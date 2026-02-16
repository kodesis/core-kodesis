<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
	private $json_input;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Auth_api_model');
		$this->load->library('jwt_lib');

		// CORS
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
		header('Access-Control-Allow-Headers: Content-Type, Authorization');

		if ($this->input->method() === 'options') {
			exit;
		}

		// ===== TAMBAHKAN INI =====
		// Parse JSON input
		$this->json_input = json_decode(file_get_contents('php://input'), true);
	}

	/**
	 * Get input (support both form-data & JSON)
	 */
	private function get_input($key, $default = null)
	{
		// Cek JSON input dulu
		if (!empty($this->json_input) && isset($this->json_input[$key])) {
			return $this->json_input[$key];
		}

		// Fallback ke POST biasa (form-data)
		return $this->input->post($key) ?? $default;
	}

	/**
	 * Login Endpoint
	 */
	public function login()
	{
		// Validasi input - GANTI CARA AMBIL DATA
		$username = $this->get_input('username');
		$password = $this->get_input('password');

		// echo '<pre>';
		// print_r($password);
		// echo '</pre>';
		// exit;

		// Manual validation (karena form_validation ga support JSON)
		if (empty($username)) {
			return $this->json_response([
				'status' => false,
				'message' => 'Validation error',
				'errors' => ['username' => 'The Username field is required.']
			], 400);
		}

		if (empty($password)) {
			return $this->json_response([
				'status' => false,
				'message' => 'Validation error',
				'errors' => ['password' => 'The Password field is required.']
			], 400);
		}

		// Validate credentials
		$user = $this->Auth_api_model->validate_user($username, $password);

		if (!$user) {
			return $this->json_response([
				'status' => false,
				'message' => 'Invalid username or password'
			], 401);
		}

		// Generate tokens
		$access_token = $this->jwt_lib->generate_access_token($user);
		$refresh_token_data = $this->jwt_lib->generate_refresh_token($user['id']);

		// Save refresh token to database
		$this->Auth_api_model->save_refresh_token($user['id'], $refresh_token_data);

		// Response
		return $this->json_response([
			'status' => true,
			'message' => 'Login successful',
			'data' => [
				'access_token' => $access_token,
				'refresh_token' => $refresh_token_data['token'],
				'token_type' => 'Bearer',
				'expires_in' => $this->config->item('jwt_access_token_expire'),
				'user' => [
					'id' => $user['id'],
					'nip' => $user['nip'],
					'nama' => $user['nama'],
					'level' => $user['level'],
					'level_jabatan' => $user['level_jabatan'] ?? null,
					'bagian' => $user['bagian'] ?? null
				]
			]
		], 200);
	}

	/**
	 * Refresh Token Endpoint
	 */
	public function refresh()
	{
		$refresh_token = $this->get_input('refresh_token');

		if (!$refresh_token) {
			return $this->json_response([
				'status' => false,
				'message' => 'Refresh token is required'
			], 400);
		}

		// ... rest of the code sama

		// Validate refresh token JWT
		$payload = $this->jwt_lib->validate_refresh_token($refresh_token);

		if (!$payload) {
			return $this->json_response([
				'status' => false,
				'message' => 'Invalid or expired refresh token'
			], 401);
		}

		// Validate refresh token in database
		$token_record = $this->Auth_api_model->validate_refresh_token_db($payload['token_id']);

		if (!$token_record) {
			return $this->json_response([
				'status' => false,
				'message' => 'Refresh token has been revoked or expired'
			], 401);
		}

		// Get user data
		$user = $this->Auth_api_model->get_user_by_id($payload['user_id']);

		if (!$user) {
			return $this->json_response([
				'status' => false,
				'message' => 'User not found'
			], 404);
		}

		// Generate new access token
		$new_access_token = $this->jwt_lib->generate_access_token($user);

		return $this->json_response([
			'status' => true,
			'message' => 'Token refreshed successfully',
			'data' => [
				'access_token' => $new_access_token,
				'token_type' => 'Bearer',
				'expires_in' => $this->config->item('jwt_access_token_expire')
			]
		], 200);
	}

	/**
	 * Logout Endpoint
	 */
	public function logout()
	{
		$this->load->library('authorization');

		// Validate access token
		$user = $this->authorization->validate_token();

		$refresh_token = $this->get_input('refresh_token');

		if ($refresh_token) {
			$payload = $this->jwt_lib->validate_refresh_token($refresh_token);

			if ($payload) {
				$this->Auth_api_model->revoke_refresh_token($payload['token_id']);
			}
		} else {
			$this->Auth_api_model->revoke_all_user_tokens($user['user_id']);
		}

		return $this->json_response([
			'status' => true,
			'message' => 'Logged out successfully'
		], 200);
	}

	/**
	 * Get Current User Info
	 */
	public function me()
	{
		$this->load->library('authorization');

		$user = $this->authorization->validate_token();

		$user_data = $this->Auth_api_model->get_user_by_id($user['user_id']);

		if (!$user_data) {
			return $this->json_response([
				'status' => false,
				'message' => 'User not found'
			], 404);
		}

		unset($user_data['password']);

		return $this->json_response([
			'status' => true,
			'data' => $user_data
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
