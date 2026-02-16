<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Authorization
{
	private $CI;

	public function __construct()
	{
		$this->CI = &get_instance();
		$this->CI->load->library('jwt_lib');
	}

	/**
	 * Validate JWT Token dari Header
	 */
	public function validate_token()
	{
		// Get Authorization header
		$headers = $this->CI->input->request_headers();

		if (!isset($headers['Authorization'])) {
			$this->token_error('No token provided', 401);
		}

		// Extract token
		$auth_header = $headers['Authorization'];
		$token = null;

		// Format: "Bearer <token>"
		if (preg_match('/Bearer\s+(.*)$/i', $auth_header, $matches)) {
			$token = $matches[1];
		}

		if (!$token) {
			$this->token_error('Invalid token format', 401);
		}

		// Validate token
		$payload = $this->CI->jwt_lib->validate_access_token($token);

		if (!$payload) {
			$this->token_error('Invalid or expired token', 401);
		}

		return $payload;
	}

	/**
	 * Check User Level Permission
	 */
	public function check_permission($user_data, $required_level)
	{
		$user_level = $user_data['level'];

		if (strpos($user_level, $required_level) === false) {
			$this->token_error('Unauthorized access', 403);
		}

		return true;
	}

	/**
	 * Send Error Response
	 */
	private function token_error($message, $code = 401)
	{
		$this->CI->output
			->set_status_header($code)
			->set_content_type('application/json')
			->set_output(json_encode([
				'status' => false,
				'message' => $message
			]))
			->_display();
		exit;
	}
}
