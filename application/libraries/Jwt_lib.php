<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Jwt_lib
{
	private $key = "kodesistemindonesia2026"; // Pastikan key ini aman

	// PASTIKAN NAMA FUNGSI INI ADALAH 'encode'
	public function encode($data)
	{
		// Pastikan data yang dikirim adalah array
		$payload = json_encode($data);

		$header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);

		$base64UrlHeader = $this->base64UrlEncode($header);
		$base64UrlPayload = $this->base64UrlEncode($payload);

		$signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, $this->key, true);
		$base64UrlSignature = $this->base64UrlEncode($signature);

		return $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;
	}

	// Fungsi Decode untuk validasi
	public function decode($token)
	{
		$parts = explode('.', $token);
		if (count($parts) !== 3) return false;

		list($header, $payload, $signature) = $parts;
		$validSignature = $this->base64UrlEncode(hash_hmac('sha256', $header . "." . $payload, $this->key, true));

		if ($signature !== $validSignature) return false;

		$payload_decoded = json_decode($this->base64UrlDecode($payload), true);
		if (isset($payload_decoded['exp']) && $payload_decoded['exp'] < time()) return false;

		return $payload_decoded;
	}

	private function base64UrlEncode($data)
	{
		return str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($data));
	}

	private function base64UrlDecode($data)
	{
		return base64_decode(str_replace(['-', '_'], ['+', '/'], $data));
	}
}
