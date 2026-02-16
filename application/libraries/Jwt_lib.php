<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Jwt_lib
{
	private $CI;

	public function __construct()
	{
		$this->CI = &get_instance();

		// CARA 1: Auto load via composer (RECOMMENDED)
		// Pastikan sudah set di config.php: $config['composer_autoload']

		// CARA 2: Manual load (jika cara 1 ga jalan)
		// if (!class_exists('Firebase\JWT\JWT')) {
		//     require_once FCPATH . 'vendor/autoload.php';
		// }
	}

	/**
	 * Generate Access Token
	 */
	public function generate_access_token($user_data)
	{
		try {
			$secret_key = $this->CI->config->item('jwt_secret_key');
			$expire = $this->CI->config->item('jwt_access_token_expire');

			$payload = [
				'iat' => time(),
				'exp' => time() + $expire,
				'user_id' => $user_data['id'],
				'nip' => $user_data['nip'],
				'nama' => $user_data['nama'],
				'level' => $user_data['level'] ?? '',
				'level_jabatan' => $user_data['level_jabatan'] ?? null,
				'bagian' => $user_data['bagian'] ?? null,
				'kode_nama' => $user_data['kode_nama'] ?? null
			];

			return JWT::encode($payload, $secret_key, 'HS256');
		} catch (Exception $e) {
			log_message('error', 'JWT Generate Error: ' . $e->getMessage());
			throw new Exception('Failed to generate token: ' . $e->getMessage());
		}
	}

	/**
	 * Generate Refresh Token
	 */
	public function generate_refresh_token($user_id)
	{
		try {
			$secret_key = $this->CI->config->item('jwt_refresh_secret_key');
			$expire = $this->CI->config->item('jwt_refresh_token_expire');

			$token_id = bin2hex(random_bytes(16));

			$payload = [
				'iat' => time(),
				'exp' => time() + $expire,
				'user_id' => $user_id,
				'token_id' => $token_id,
				'type' => 'refresh'
			];

			$token = JWT::encode($payload, $secret_key, 'HS256');

			return [
				'token' => $token,
				'token_id' => $token_id,
				'expires_at' => date('Y-m-d H:i:s', time() + $expire)
			];
		} catch (Exception $e) {
			log_message('error', 'JWT Refresh Token Error: ' . $e->getMessage());
			throw new Exception('Failed to generate refresh token: ' . $e->getMessage());
		}
	}

	/**
	 * Validate Access Token
	 */
	public function validate_access_token($token)
	{
		try {
			$secret_key = $this->CI->config->item('jwt_secret_key');
			$decoded = JWT::decode($token, new Key($secret_key, 'HS256'));
			return (array) $decoded;
		} catch (\Firebase\JWT\ExpiredException $e) {
			log_message('debug', 'Token expired: ' . $e->getMessage());
			return false;
		} catch (Exception $e) {
			log_message('error', 'JWT Validation Error: ' . $e->getMessage());
			return false;
		}
	}

	/**
	 * Validate Refresh Token
	 */
	public function validate_refresh_token($token)
	{
		try {
			$secret_key = $this->CI->config->item('jwt_refresh_secret_key');
			$decoded = JWT::decode($token, new Key($secret_key, 'HS256'));

			$payload = (array) $decoded;

			if (!isset($payload['type']) || $payload['type'] !== 'refresh') {
				return false;
			}

			return $payload;
		} catch (Exception $e) {
			log_message('error', 'JWT Refresh Validation Error: ' . $e->getMessage());
			return false;
		}
	}
}
