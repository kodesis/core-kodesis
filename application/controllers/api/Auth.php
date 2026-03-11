<?php
defined('BASEPATH') or exit('No direct script access allowed');

// Gunakan MY_Controller jika sudah ada, atau CI_Controller jika ingin publik
class Auth extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		// Load library JWT manual yang kita buat sebelumnya
		$this->load->library('jwt_lib');
	}

	public function generate_token()
	{
		// 1. Ambil Secret/Key yang dikirim oleh Aplikasi Client
		$client_id     = $this->input->post('client_id');
		$client_secret = $this->input->post('client_secret');
		$nip = $this->input->post('nip');

		// 2. Validasi kredensial aplikasi (Bisa simpan di config atau database)
		$valid_id     = "KODESIS_APP_01";
		$valid_secret = "SECRET_KODESIS_2026";

		if ($client_id === $valid_id && $client_secret === $valid_secret) {

			$user = $this->db->select('a.*, b.kode_nama')->from('users a')->join('bagian b', 'b.kode = a.bagian')->where('a.nip', $nip)->get()->row();

			if (!$user) {
				return $this->response(['status' => false, 'message' => 'User tidak ditemukan'], 404);
			}

			// 3. Siapkan Payload (data identitas aplikasi)
			$payload = [
				'app_id'   => $client_id,
				'role'     => 'internal_app',
				'nip'      => $user->nip,
				'nama'          => $user->nama,
				'level_jabatan' => $user->level_jabatan,
				'kode_nama'     => $user->kode_nama, // Bagian/Dept
				'iat'      => time(),
				'exp'      => time() + (60 * 60 * 24) // Token berlaku 24 jam
			];

			// 4. Generate Token menggunakan Jwt_lib
			$token = $this->jwt_lib->encode($payload);

			$this->response([
				'status'  => true,
				'message' => 'Token generated successfully',
				'token'   => $token,
			], 200);
		} else {
			// Jika kredensial salah
			$this->response([
				'status'  => false,
				'message' => 'Invalid Client ID or Secret'
			], 401);
		}
	}
}
