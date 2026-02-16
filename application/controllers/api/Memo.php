<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Memo extends CI_Controller
{
	private $user; // Current authenticated user

	public function __construct()
	{
		parent::__construct();
		$this->load->library('authorization');
		$this->load->model('api/memo_model');
		$this->load->model('m_app'); // Model existing lu

		// CORS
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
		header('Access-Control-Allow-Headers: Content-Type, Authorization');

		if ($this->input->method() === 'options') {
			exit;
		}
	}

	/**
	 * Create Memo
	 * POST /api/v1/memo/create
	 */
	public function create()
	{
		// Validate JWT Token
		$this->user = $this->authorization->validate_token();

		// Check permission (level 402)
		$this->authorization->check_permission($this->user, '402');

		// Validasi input
		$this->form_validation->set_rules('tujuan_memo', 'Tujuan Memo', 'required');
		$this->form_validation->set_rules('subject_memo', 'Subject', 'required|trim');
		$this->form_validation->set_rules('isi_memo', 'Isi Memo', 'required');

		if ($this->form_validation->run() == FALSE) {
			return $this->json_response([
				'status' => false,
				'message' => 'Validation error',
				'errors' => $this->form_validation->error_array()
			], 400);
		}

		// Get input data
		$tujuan_memo = $this->input->post('tujuan_memo'); // Array or comma-separated
		$cc_memo = $this->input->post('cc_memo'); // Array or comma-separated
		$subject = $this->input->post('subject_memo');
		$isi_memo = $this->input->post('isi_memo');

		// Convert to array if string
		if (!is_array($tujuan_memo)) {
			$tujuan_memo = explode(',', $tujuan_memo);
		}
		if ($cc_memo && !is_array($cc_memo)) {
			$cc_memo = explode(',', $cc_memo);
		}

		// Start transaction
		$this->db->trans_start();

		try {
			// Process tujuan (recipients)
			$nip_kpd = '';
			foreach ($tujuan_memo as $nip) {
				$nip = trim($nip);
				$nip_kpd .= $nip . ';';

				// Send WhatsApp notification
				$this->send_wa_notification($nip, $subject);
			}

			// Process CC
			$nip_cc = '';
			if (!empty($cc_memo)) {
				foreach ($cc_memo as $nip) {
					$nip = trim($nip);
					$nip_cc .= $nip . ';';

					// Send WhatsApp notification
					$this->send_wa_notification($nip, $subject);
				}
			}

			// Generate nomor memo (jika level_jabatan >= 2)
			$no_memo = '';
			if ($this->user['level_jabatan'] >= 2) {
				$no_memo = $this->generate_nomor_memo($this->user['kode_nama']);
			}

			// Handle file attachments (existing files)
			$attach_name = $this->input->post('attch_exist') ?? '';
			$attach = $this->input->post('attch_exist_nm') ?? '';

			// Prepare memo data
			$memo_data = [
				'nomor_memo' => $no_memo,
				'nip_kpd' => $nip_kpd,
				'nip_cc' => $nip_cc,
				'judul' => $subject,
				'isi_memo' => $isi_memo,
				'nip_dari' => $this->user['nip'],
				'tanggal' => date('Y-m-d H:i:s'),
				'read' => 0,
				'persetujuan' => 0,
				'bagian' => $this->user['kode_nama'],
				'attach' => $attach,
				'attach_name' => $attach_name
			];

			// Insert memo
			$this->db->insert('memo', $memo_data);
			$memo_id = $this->db->insert_id();

			// Handle new file uploads
			$uploaded_files = $this->handle_file_uploads($memo_id);

			// Complete transaction
			$this->db->trans_complete();

			if ($this->db->trans_status() === FALSE) {
				throw new Exception('Failed to save memo');
			}

			return $this->json_response([
				'status' => true,
				'message' => 'Memo created successfully',
				'data' => [
					'memo_id' => $memo_id,
					'nomor_memo' => $no_memo,
					'recipients' => $nip_kpd,
					'cc' => $nip_cc,
					'uploaded_files' => $uploaded_files
				]
			], 201);
		} catch (Exception $e) {
			$this->db->trans_rollback();

			return $this->json_response([
				'status' => false,
				'message' => 'Failed to create memo',
				'error' => $e->getMessage()
			], 500);
		}
	}

	/**
	 * Generate Nomor Memo
	 */
	private function generate_nomor_memo($bagian)
	{
		// Fix SQL Injection dengan query builder
		$this->db->select_max('nomor_memo');
		$this->db->where('bagian', $bagian);
		$this->db->where('YEAR(tanggal) = YEAR(CURDATE())', NULL, FALSE);
		$result = $this->db->get('memo')->row_array();

		if ($result && $result['nomor_memo']) {
			return $result['nomor_memo'] + 1;
		}

		return 1;
	}

	/**
	 * Send WhatsApp Notification
	 */
	private function send_wa_notification($nip, $subject)
	{
		$get_user = $this->db->get_where('users', ['nip' => $nip])->row_array();

		if ($get_user && !empty($get_user['phone'])) {
			$msg = "BOC Notif\nThere's a new Memo\nBOC From: *{$this->user['nama']}*\nSubject: *{$subject}*";

			// Load WhatsApp library
			$this->load->library('api_whatsapp');
			$this->api_whatsapp->wa_notif($msg, $get_user['phone']);
		}
	}

	/**
	 * Handle File Uploads
	 */
	private function handle_file_uploads($memo_id)
	{
		$uploaded_files = [];

		if (empty($_FILES['files']['name'][0])) {
			return $uploaded_files;
		}

		$countfiles = count($_FILES['files']['name']);

		// Create upload directory if not exists
		$upload_path = 'upload/att_memo/';
		if (!is_dir($upload_path)) {
			mkdir($upload_path, 0755, true);
		}

		for ($i = 0; $i < $countfiles; $i++) {
			if ($_FILES['files']['error'][$i] === 0) {
				$filename_original = $_FILES['files']['name'][$i];
				$file_tmp = $_FILES['files']['tmp_name'][$i];
				$file_size = $_FILES['files']['size'][$i];

				// Validate file size (max 5MB)
				if ($file_size > 5242880) {
					continue; // Skip large files
				}

				// Get extension
				$array = explode('.', $filename_original);
				$extension = strtolower(end($array));

				// Validate extension
				$allowed_ext = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'jpg', 'jpeg', 'png', 'zip'];
				if (!in_array($extension, $allowed_ext)) {
					continue; // Skip invalid files
				}

				// Generate unique filename
				$filename = bin2hex(random_bytes(16)) . '.' . $extension;

				// Move file
				if (move_uploaded_file($file_tmp, $upload_path . $filename)) {
					// Update database menggunakan query builder (fix SQL injection)
					$this->db->set('attach', "CONCAT_WS(';', attach, '$filename')", FALSE);
					$this->db->set('attach_name', "CONCAT_WS(';', attach_name, '$filename_original')", FALSE);
					$this->db->where('Id', $memo_id);
					$this->db->update('memo');

					$uploaded_files[] = [
						'original_name' => $filename_original,
						'saved_name' => $filename,
						'size' => $file_size
					];
				}
			}
		}

		return $uploaded_files;
	}

	/**
	 * Get Memo List (Inbox)
	 * GET /api/v1/memo/inbox
	 */
	public function inbox()
	{
		$this->user = $this->authorization->validate_token();

		$nip = $this->user['nip'];

		// Query dengan query builder (fix SQL injection)
		$this->db->select('*');
		$this->db->where("(nip_kpd LIKE '%$nip%' OR nip_cc LIKE '%$nip%')");
		$this->db->order_by('tanggal', 'DESC');
		$memos = $this->db->get('memo')->result_array();

		return $this->json_response([
			'status' => true,
			'data' => $memos
		], 200);
	}

	/**
	 * JSON Response Helper
	 */
	private function json_response($data, $code = 200)
	{
		$this->output
			->set_status_header($code)
			->set_content_type('application/json')
			->set_output(json_encode($data));
	}
}
