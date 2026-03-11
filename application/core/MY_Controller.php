<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
    public function __construct()
    {
        return parent::__construct();
        //memastikan output selalu json

        $this->output->set_content_type('application/json');
    }

    // Helper untuk mengirim json
    public function response($data, $status = 200)
    {
        $this->output->set_status_header($status)->set_output(json_encode($data, JSON_PRETTY_PRINT))->_display();
        exit;
    }

    protected function auth_check()
    {
        $this->load->library('jwt_lib');
        $headers = $this->input->get_request_header('Authorization');

        if (!empty($headers)) {
            $token = str_replace('Bearer ', '', $headers);
            $decoded = $this->jwt_lib->decode($token);

            if ($decoded) {
                return $decoded; // Mengembalikan data user dari token
            }
        }

        // Jika gagal, langsung stop request
        $this->response([
            'status' => false,
            'message' => 'Akses ditolak: Token tidak valid atau kedaluwarsa'
        ], 401);
    }
}
