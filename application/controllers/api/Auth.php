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
		date_default_timezone_set('Asia/Jakarta');
	}

	public function generate_token()
	{
		// 1. Ambil Secret/Key yang dikirim oleh Aplikasi Client
		$client_id     = $this->input->post('client_id');
		$client_secret = $this->input->post('client_secret');


		$client = $this->db->get_where('api_clients', [
			'client_id' => $client_id,
			'is_active' => 1
		])->row();

		if (!$client || !password_verify($client_secret, $client->client_secret)) {
			return $this->response([
				'status' => false,
				'message' => 'Invalid Client Credentials'
			], 401);
		}

		$existing = $this->db->get_where('api_tokens', [
			'client_id' => $client_id
		])->row();

		$now = date('Y-m-d H:i:s');

		if ($existing && $existing->expired_at > $now) {
			return $this->response(['status' => true, 'token' => $existing->token], 200);
		}

		$expired_at = date('Y-m-d H:i:s', strtotime('+24 hours'));
		$payload = [
			'client_id' => $client_id,
			'iat'      => time(),
			'exp'      => strtotime($expired_at) // Token berlaku 24 jam
		];

		$token = $this->jwt_lib->encode($payload);

		$data_save = [
			'token'      => $token,
			'expired_at' => $expired_at,
			'created_at' => $now
		];

		if ($existing) {
			$this->db->where('Id', $existing->Id)->update('api_tokens', $data_save);
		} else {
			$data_save['client_id'] = $client_id;
			$this->db->insert('api_tokens', $data_save);
		}

		$this->response(['status' => true, 'message' => 'Token generated successfully', 'token' => $token], 200);
	}
}
