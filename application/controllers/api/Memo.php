<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Memo extends MY_Controller
{
	private $user; // Current authenticated user

	public function __construct()
	{
		parent::__construct();
		$this->load->library('authorization');
		$this->load->model('api/M_memo');
		$this->load->model('m_app'); // Model existing lu

		date_default_timezone_set('Asia/Jakarta');


		// CORS
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
		header('Access-Control-Allow-Headers: Content-Type, Authorization');

		if ($this->input->method() === 'options') {
			exit;
		}
	}


	public function sendmemo()
	{
		$this->auth_check();

		$this->db->select('a.*, b.kode_nama')->from('users a')->join('bagian b', 'b.kode = a.bagian', 'left')->where('nip', $this->input->post('nip'));
		$user_data = $this->db->get()->row_array();

		$tujuan = $this->input->post('tujuan_memo');
		$cc = $this->input->post('cc_memo');
		$judul = $this->input->post('subject_memo');
		$isi = $this->input->post('isi');

		$this->form_validation->set_rules('tujuan_memo', 'Tujuan', 'required|trim', [
			'required' => '%s harus diisi!'
		]);
		$this->form_validation->set_rules('subject_memo', 'Judul atau subject', 'required|trim', [
			'required' => '%s harus diisi!'
		]);
		$this->form_validation->set_rules('isi', 'Isi memo', 'required|trim', [
			'required' => '%s harus diisi!'
		]);

		if ($this->form_validation->run() == FALSE) {
			return $this->response([
				'status' => false,
				'message' => array_values($this->form_validation->error_array())[0]
			], 422);
		}

		// $nip_kpd = is_array($tujuan) ? implode(';', $tujuan) . ';' : $tujuan;
		// $nip_cc = !empty($cc) ? (is_array($cc) ? implode(';', $cc) . ';' : $cc) : '';
		$nip_kpd = rtrim($tujuan, ';') . ';';
		$nip_cc  = rtrim($cc, ';') . ';';

		// 1. Pastikan input jadi array (pecah string jika perlu)
		$array_tujuan = is_array($tujuan) ? $tujuan : explode(';', rtrim($tujuan, ';'));
		$array_cc = is_array($cc) ? $cc : explode(';', rtrim($cc, ';'));

		// 2. Gabungkan dan bersihkan dari elemen kosong atau duplikat
		$all_user = array_unique(array_filter(array_merge($array_tujuan, $array_cc)));

		// 3. Ambil nomor HP dari database
		$phone_user = [];
		if (!empty($all_user)) {
			$this->db->select('phone');
			$this->db->from('users');
			$this->db->where_in('nip', $all_user);
			$users = $this->db->get()->result_array();

			// Ambil kolom phone dan buang yang kosong
			$phone_user = array_filter(array_column($users, 'phone'));
		}

		$no_memo = '';
		if ($user_data['level_jabatan'] >= 2) {
			$bagian = $user_data['kode_nama'];
			$this->db->select_max('nomor_memo');
			$this->db->where(['bagian' => $bagian, 'YEAR(tanggal)' => date('Y')]);
			$memo = $this->db->get('memo')->row();
			$no_memo = ($memo->nomor_memo ?? 0) + 1;
		}

		$attach = "";
		$attach_name = "";

		if (!empty($_FILES['lampiran']['name'][0])) {
			$filesCount = count($_FILES['lampiran']['name']);

			$config = [
				'upload_path' => './upload/att_memo',
				'allowed_types' => 'jpg|jpeg|png|pdf|doc|docx|xls|xlsx|ppt|pptx',
				'max_size' => 10240,
				'encrypt_name' => TRUE
			];

			$this->load->library('upload', $config);
			$uploadedNames = [];
			$originalNames = [];

			for ($i = 0; $i < $filesCount; $i++) {
				$_FILES['file']['name']     = $_FILES['lampiran']['name'][$i];
				$_FILES['file']['type']     = $_FILES['lampiran']['type'][$i];
				$_FILES['file']['tmp_name'] = $_FILES['lampiran']['tmp_name'][$i];
				$_FILES['file']['error']    = $_FILES['lampiran']['error'][$i];
				$_FILES['file']['size']     = $_FILES['lampiran']['size'][$i];

				if ($this->upload->do_upload('file')) {
					$uploadData = $this->upload->data();
					$uploadedNames[] = $uploadData['file_name'];
					$originalNames[] = $_FILES['file']['name'];
				} else {
					// Jika satu gagal, hapus yang sudah terupload (Rollback file)
					foreach ($uploadedNames as $fileName) {
						@unlink('./upload/att_memo/' . $fileName);
					}
					return $this->response([
						'status' => false,
						'message' => 'Upload Error: ' . strip_tags($this->upload->display_errors())
					], 400);
				}
			}
			$attach = implode(';', $uploadedNames);
			$attach_name = implode(';', $originalNames);
		}

		if (!empty($this->input->post('attach_exist'))) {
			$attach_name = $this->input->post('attach_exist') . ($attach_name ? $attach_name . ';' : '');
			$attach = $this->input->post('attach_exist_encrypt') . ($attach ? $attach . ';' : '');
		}

		// 6. Simpan ke Database
		$insert = [
			'nomor_memo'  => $no_memo,
			'nip_kpd'     => $nip_kpd,
			'nip_cc'      => $nip_cc,
			'judul'       => $judul,
			'isi_memo'    => $isi,
			'nip_dari'    => $user_data['nip'],
			'tanggal'     => date('Y-m-d H:i:s'),
			'read'        => 0,
			'persetujuan' => 0,
			'bagian'      => $user_data['kode_nama'],
			'attach'      => $attach,
			'attach_name' => $attach_name,
		];

		if ($this->db->insert('memo', $insert)) {
			$is_notif = $this->db->get('utility')->row();
			$this->load->library('Api_Whatsapp');
			if ($is_notif->notif_wa == 1 && !empty($phone_user)) {
				$nama_sender = $user_data['nama'];
				$msg = "There's a new Memo\nFrom : *$nama_sender*\nSubject : *$judul*\n\n" . base_url();
				foreach ($phone_user as $pu) {
					$this->api_whatsapp->wa_notif($msg, $pu);
				}
			}

			return $this->response(['status' => true, 'message' => 'Sukses kirim memo'], 201);
		}

		return $this->response(['status' => false, 'message' => 'Gagal simpan ke database'], 500);
	}

	public function inbox()
	{
		$this->auth_check();

		$nip = $this->input->get('nip');
		$limit = $this->input->get('limit');
		$start = $this->input->get('start');
		$search = $this->input->get('search');
		if (empty($nip)) {
			$this->response(['status' => false, 'message' => 'Data dengan nip tersebut tidak ditemukan!'], 400);
		}

		$data = $this->M_memo->get_by_nip($nip, $limit, $start, $search);

		if ($data) {
			$this->response([
				'status' => true,
				'message' => 'Data memo ditemukan',
				'data' => $data
			], 200);
		} else {
			$this->response([
				'status' => false,
				'message' => 'Data memo tidak ditemukan untuk NIP tersebut'
			], 404);
		}
	}

	public function memo_count($nip)
	{
		$this->auth_check();
		$search = $this->input->get('search');
		if (empty($nip)) {
			$this->response(['status' => false, 'message' => 'Data dengan nip tersebut tidak ditemukan!'], 400);
		}

		$data = $this->M_memo->memo_count($nip, $search);

		if ($data) {
			$this->response([
				'status' => true,
				'message' => 'Data memo ditemukan',
				'data' => $data
			], 200);
		} else {
			$this->response([
				'status' => false,
				'message' => 'Data memo tidak ditemukan untuk NIP tersebut'
			], 404);
		}
	}

	public function notif_memo_count($nip)
	{
		$this->auth_check();

		if (empty($nip)) {
			$this->response(['status' => false, 'message' => 'Data dengan nip tersebut tidak ditemukan!'], 400);
		}

		$data = $this->M_memo->notif_memo_count($nip);

		if ($data) {
			$this->response([
				'status' => true,
				'message' => 'Data memo ditemukan',
				'data' => $data
			], 200);
		} else {
			$this->response([
				'status' => false,
				'message' => 'Data memo tidak ditemukan untuk NIP tersebut'
			], 404);
		}
	}

	public function memo_view($id)
	{
		$this->auth_check();

		$nip = $this->input->get('nip');

		if (empty($id)) {
			$this->response(['status' => false, 'message' => 'Unauthorize Privilage!'], 400);
		}

		$data = $this->M_memo->get_memo_detail($id, $nip);

		if ($data) {
			$this->response([
				'status' => true,
				'message' => 'Data memo ditemukan',
				'data' => $data
			], 200);
		} else {
			$this->response([
				'status' => false,
				'message' => 'Unauthorize Privilage!'
			], 404);
		}
	}

	public function sendto()
	{
		$this->auth_check();

		$level_jabatan = $this->input->get('level_jabatan');
		$bagian = $this->input->get('bagian');

		$data = $this->M_memo->sendto($level_jabatan, $bagian);

		if ($data) {
			$this->response([
				'status' => true,
				'message' => 'Data user ditemukan',
				'data' => $data
			], 200);
		} else {
			$this->response([
				'status' => false,
				'message' => 'Data user tidak ditemukan!'
			], 404);
		}
	}
}
