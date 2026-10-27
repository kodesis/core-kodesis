<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Sistem Tesseract OCR
 *
 * Alur:
 *  1. User upload gambar  -> tesseract/process (AJAX)
 *  2. Server menjalankan binary tesseract (library thiagoalessio/tesseract_ocr)
 *  3. Hasil disimpan ke tabel `ocr_history` dan dikembalikan sebagai JSON
 *  4. Jika binary tesseract tidak terpasang di server, halaman otomatis
 *     memakai Tesseract.js di browser lalu menyimpan hasilnya via
 *     tesseract/save_client_result
 */
class Tesseract extends CI_Controller
{
	const UPLOAD_DIR = './uploads/ocr/';
	const MAX_SIZE_KB = 5120;

	// bahasa yang diizinkan => label
	private $languages = array(
		'ind'     => 'Indonesia',
		'eng'     => 'English',
		'ind+eng' => 'Indonesia + English',
	);

	// page segmentation mode yang diizinkan => label
	private $psm_modes = array(
		'3'  => 'Otomatis (default)',
		'4'  => 'Satu kolom teks',
		'6'  => 'Satu blok teks',
		'7'  => 'Satu baris teks',
		'11' => 'Teks tersebar (sparse)',
	);

	public function __construct()
	{
		parent::__construct();

		$this->load->model('m_app');
		$this->load->model('M_ocr', 'ocr');
		$this->load->library(array('form_validation', 'session', 'user_agent'));
		$this->load->library('pagination');
		$this->load->database();
		$this->load->helper(array('url', 'form', 'download'));
	}

	public function index()
	{
		if ($this->session->userdata('isLogin') == FALSE) {
			redirect('home');
		}

		$nip = $this->session->userdata('nip');
		$like = '%' . $nip . '%';

		// inbox notif
		$res = $this->db->query(
			"SELECT COUNT(Id) AS total FROM memo WHERE (nip_kpd LIKE ? OR nip_cc LIKE ?) AND (`read` NOT LIKE ?)",
			array($like, $like, $like)
		)->row_array();
		$data['count_inbox'] = $res['total'];

		// Tello
		$res2 = $this->db->query(
			"SELECT COUNT(Id) AS total FROM task WHERE (`member` LIKE ? OR `pic` LIKE ?) AND activity='1'",
			array($like, $like)
		)->row_array();
		$data['count_inbox2'] = $res2['total'];

		$data['languages'] = $this->languages;
		$data['psm_modes'] = $this->psm_modes;
		$data['server_ready'] = $this->server_engine_available();
		$data['history'] = $this->ocr->get_history($nip, 20);

		$this->load->view('tesseract_view', $data);
	}

	/**
	 * Upload gambar + OCR di server. Response JSON.
	 */
	public function process()
	{
		if (!$this->_ajax_login_check()) {
			return;
		}

		$lang = $this->_valid_lang($this->input->post('lang'));
		$psm  = $this->_valid_psm($this->input->post('psm'));

		$upload = $this->_upload_image();
		if (isset($upload['error'])) {
			return $this->_json(array('status' => false, 'message' => $upload['error']));
		}

		$file_path = $upload['full_path'];
		$this->_load_library();

		$start = microtime(true);
		try {
			$ocr = new \thiagoalessio\TesseractOCR\TesseractOCR($file_path);
			$ocr->lang(...explode('+', $lang))->psm($psm);
			$text = $ocr->run(60);
		} catch (\thiagoalessio\TesseractOCR\TesseractNotFoundException $e) {
			// biarkan file tetap ada, browser akan memproses lalu memanggil save_client_result
			return $this->_json(array(
				'status'    => false,
				'code'      => 'engine_not_found',
				'message'   => 'Tesseract belum terpasang di server, memproses di browser...',
				'file_name' => $upload['file_name'],
			));
		} catch (\thiagoalessio\TesseractOCR\UnsuccessfulCommandException $e) {
			// tesseract mengembalikan error, biasanya karena gambar kosong/tidak terbaca
			$text = '';
		} catch (Exception $e) {
			@unlink($file_path);
			return $this->_json(array('status' => false, 'message' => 'Gagal memproses gambar: ' . $e->getMessage()));
		}
		$duration = round(microtime(true) - $start, 2);

		$id = $this->ocr->insert(array(
			'nip'           => $this->session->userdata('nip'),
			'file_name'     => $upload['file_name'],
			'original_name' => $upload['client_name'],
			'lang'          => $lang,
			'psm'           => $psm,
			'engine'        => 'server',
			'result_text'   => $text,
			'duration'      => $duration,
			'created_at'    => date('Y-m-d H:i:s'),
		));

		return $this->_json(array(
			'status'   => true,
			'id'       => $id,
			'text'     => $text,
			'engine'   => 'server',
			'duration' => $duration,
			'message'  => trim($text) === '' ? 'Tidak ada teks yang terdeteksi.' : 'Berhasil mengekstrak teks.',
		));
	}

	/**
	 * Menyimpan hasil OCR yang diproses di browser (Tesseract.js),
	 * untuk file yang sudah ter-upload lewat process().
	 */
	public function save_client_result()
	{
		if (!$this->_ajax_login_check()) {
			return;
		}

		$file_name = basename((string) $this->input->post('file_name'));
		if ($file_name === '' || !is_file(self::UPLOAD_DIR . $file_name)) {
			return $this->_json(array('status' => false, 'message' => 'File tidak ditemukan.'));
		}
		if ($this->ocr->file_exists($file_name)) {
			return $this->_json(array('status' => false, 'message' => 'Hasil untuk file ini sudah tersimpan.'));
		}

		$id = $this->ocr->insert(array(
			'nip'           => $this->session->userdata('nip'),
			'file_name'     => $file_name,
			'original_name' => substr(strip_tags((string) $this->input->post('original_name')), 0, 255),
			'lang'          => $this->_valid_lang($this->input->post('lang')),
			'psm'           => $this->_valid_psm($this->input->post('psm')),
			'engine'        => 'browser',
			'result_text'   => (string) $this->input->post('text'),
			'confidence'    => is_numeric($this->input->post('confidence')) ? $this->input->post('confidence') : null,
			'duration'      => is_numeric($this->input->post('duration')) ? $this->input->post('duration') : null,
			'created_at'    => date('Y-m-d H:i:s'),
		));

		return $this->_json(array('status' => true, 'id' => $id));
	}

	/**
	 * Detail satu riwayat (JSON).
	 */
	public function detail($id = null)
	{
		if (!$this->_ajax_login_check()) {
			return;
		}

		$row = $this->ocr->get_by_id((int) $id, $this->session->userdata('nip'));
		if (!$row) {
			return $this->_json(array('status' => false, 'message' => 'Data tidak ditemukan.'));
		}

		$row->image_url = base_url('uploads/ocr/' . $row->file_name);
		return $this->_json(array('status' => true, 'data' => $row));
	}

	/**
	 * Daftar riwayat terbaru (JSON) untuk refresh tabel.
	 */
	public function history()
	{
		if (!$this->_ajax_login_check()) {
			return;
		}

		$rows = $this->ocr->get_history($this->session->userdata('nip'), 20);
		return $this->_json(array('status' => true, 'data' => $rows));
	}

	/**
	 * Download hasil OCR sebagai file .txt
	 */
	public function download($id = null)
	{
		if ($this->session->userdata('isLogin') == FALSE) {
			redirect('home');
		}

		$row = $this->ocr->get_by_id((int) $id, $this->session->userdata('nip'));
		if (!$row) {
			show_404();
		}

		$name = pathinfo($row->original_name ?: $row->file_name, PATHINFO_FILENAME);
		force_download('ocr_' . $name . '.txt', $row->result_text);
	}

	public function delete($id = null)
	{
		if (!$this->_ajax_login_check()) {
			return;
		}

		$row = $this->ocr->get_by_id((int) $id, $this->session->userdata('nip'));
		if (!$row) {
			return $this->_json(array('status' => false, 'message' => 'Data tidak ditemukan.'));
		}

		$this->ocr->delete($row->id);
		@unlink(self::UPLOAD_DIR . $row->file_name);

		return $this->_json(array('status' => true, 'message' => 'Riwayat dihapus.'));
	}

	// kompatibilitas dengan URL lama
	public function process_image()
	{
		return $this->process();
	}

	// ------------------------------------------------------------------

	private function _load_library()
	{
		require_once APPPATH . 'third_party/vendor/vendor/autoload.php';
	}

	private function server_engine_available()
	{
		$this->_load_library();
		try {
			// version() mengembalikan string kosong jika binary tidak ditemukan
			return trim((string) (new \thiagoalessio\TesseractOCR\TesseractOCR())->version()) !== '';
		} catch (Exception $e) {
			return false;
		}
	}

	private function _upload_image()
	{
		if (!is_dir(self::UPLOAD_DIR)) {
			@mkdir(self::UPLOAD_DIR, 0755, true);
		}

		$config = array(
			'upload_path'   => self::UPLOAD_DIR,
			'allowed_types' => 'jpg|jpeg|png|bmp|gif|tif|tiff|webp',
			'max_size'      => self::MAX_SIZE_KB,
			'encrypt_name'  => true,
		);
		$this->load->library('upload', $config);
		$this->upload->initialize($config);

		if (!$this->upload->do_upload('image')) {
			return array('error' => strip_tags($this->upload->display_errors()));
		}

		return $this->upload->data();
	}

	private function _valid_lang($lang)
	{
		return isset($this->languages[$lang]) ? $lang : 'ind+eng';
	}

	private function _valid_psm($psm)
	{
		return isset($this->psm_modes[$psm]) ? (int) $psm : 3;
	}

	private function _ajax_login_check()
	{
		if ($this->session->userdata('isLogin') == FALSE) {
			$this->_json(array('status' => false, 'message' => 'Sesi berakhir, silakan login kembali.'), 401);
			return false;
		}
		return true;
	}

	private function _json($data, $status = 200)
	{
		$this->output
			->set_status_header($status)
			->set_content_type('application/json')
			->set_output(json_encode($data));
	}
}
