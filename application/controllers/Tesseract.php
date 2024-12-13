<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tesseract extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();

		//$this->load->model('m_login');
		$this->load->model('m_app');
		$this->load->library(array('form_validation', 'session', 'user_agent', 'Api_Whatsapp'));
		$this->load->library('pagination');
		$this->load->database();
		$this->load->helper('url', 'form', 'download');
	}
	public function index()
	{
		if ($this->session->userdata('isLogin') == FALSE) {
			redirect('home');
		} else {
			//inbox notif
			$nip = $this->session->userdata('nip');
			$sql = "SELECT COUNT(Id) FROM memo WHERE (nip_kpd LIKE '%$nip%' OR nip_cc LIKE '%$nip%') AND (`read` NOT LIKE '%$nip%');";
			$sql2 = "SELECT * FROM asset_ruang";
			$sql3 = "SELECT * FROM asset_lokasi";
			$query = $this->db->query($sql);
			$query2 = $this->db->query($sql2);
			$query3 = $this->db->query($sql3);
			$res2 = $query->result_array();
			$asset_ruang = $query2->result();
			$asset_lokasi = $query3->result();
			$result = $res2[0]['COUNT(Id)'];
			$data['count_inbox'] = $result;
			$data['asset_ruang'] = $asset_ruang;
			$data['asset_lokasi'] = $asset_lokasi;

			// Tello
			$sql4 = "SELECT COUNT(Id) FROM task WHERE (`member` LIKE '%$nip%' or `pic` like '%$nip%') and activity='1'";
			$query4 = $this->db->query($sql4);
			$res4 = $query4->result_array();
			$result4 = $res4[0]['COUNT(Id)'];
			$data['count_inbox2'] = $result4;

			$this->load->model(
				'Absen_m',
				'user'
			);
			$this->load->view('tesseract_view', $data);
		}
	}
	public function process_image()
	{
		$this->load->library('upload');
		require APPPATH . 'third_party/tesseract-ocr/vendor/autoload.php';


		if (!isset($_FILES['image']) || $_FILES['image']['error'] != UPLOAD_ERR_OK) {
			echo "Error: No file uploaded or there was an issue with the upload.";
			return;
		}

		// Get the temporary file path
		$temp_file = $_FILES['image']['tmp_name'];

		// Check if TesseractOCR is installed and process the file
		try {
			$ocr = new \thiagoalessio\TesseractOCR\TesseractOCR($temp_file);
			$text = $ocr->lang('eng') // Set language to English
				->run();      // Process the image

			// Display the extracted text
			echo "Extracted Text: " . nl2br(htmlspecialchars($text));
		} catch (Exception $e) {
			// Handle errors
			echo "Error processing image: " . $e->getMessage();
		}
	}
}
