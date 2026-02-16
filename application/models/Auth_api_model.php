<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth_api_model extends CI_Model
{
	/**
	 * Validate User Credentials
	 */
	public function validate_user($username, $password)
	{
		// Sesuaikan dengan struktur table users lu
		$this->db->where('username', $username);
		// Atau kalo pakai nip sebagai username:
		// $this->db->where('nip', $username);

		$user = $this->db->get('users')->row_array();

		if (!$user) {
			return false;
		}

		// Verify password (sesuaikan dengan enkripsi lu)
		// Kalo pake password_hash:
		if (password_verify($password, $user['password'])) {
			return $user;
		}

		// Kalo pake MD5 atau enkripsi lain:
		// if (md5($password) === $user['password']) {
		//     return $user;
		// }

		return false;
	}

	/**
	 * Get User by ID
	 */
	public function get_user_by_id($user_id)
	{
		return $this->db->get_where('users', ['id' => $user_id])->row_array();
	}

	/**
	 * Save Refresh Token
	 */
	public function save_refresh_token($user_id, $token_data)
	{
		$data = [
			'user_id' => $user_id,
			'token_id' => $token_data['token_id'],
			'token' => $token_data['token'],
			'expires_at' => $token_data['expires_at'],
			'user_agent' => $this->input->user_agent(),
			'ip_address' => $this->input->ip_address()
		];

		return $this->db->insert('refresh_tokens', $data);
	}

	/**
	 * Validate Refresh Token dari Database
	 */
	public function validate_refresh_token_db($token_id)
	{
		$this->db->where('token_id', $token_id);
		$this->db->where('revoked', 0);
		$this->db->where('expires_at >', date('Y-m-d H:i:s'));

		return $this->db->get('refresh_tokens')->row_array();
	}

	/**
	 * Revoke Refresh Token
	 */
	public function revoke_refresh_token($token_id)
	{
		$this->db->where('token_id', $token_id);
		return $this->db->update('refresh_tokens', [
			'revoked' => 1,
			'revoked_at' => date('Y-m-d H:i:s')
		]);
	}

	/**
	 * Revoke All User Tokens (untuk logout semua device)
	 */
	public function revoke_all_user_tokens($user_id)
	{
		$this->db->where('user_id', $user_id);
		$this->db->where('revoked', 0);
		return $this->db->update('refresh_tokens', [
			'revoked' => 1,
			'revoked_at' => date('Y-m-d H:i:s')
		]);
	}

	/**
	 * Clean Expired Tokens (jalankan via cron)
	 */
	public function clean_expired_tokens()
	{
		$this->db->where('expires_at <', date('Y-m-d H:i:s'));
		return $this->db->delete('refresh_tokens');
	}
}
