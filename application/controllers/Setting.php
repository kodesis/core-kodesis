<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Setting extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model(['m_app']);
        $this->load->library(['form_validation', 'session', 'user_agent', 'Api_Whatsapp', 'pagination', 'pdfgenerator']);
        $this->load->database();
        $this->load->helper(['url', 'form', 'download', 'date', 'number']);

        $this->cb = $this->load->database('corebank', TRUE);

        if (!$this->session->userdata('nip')) {
            redirect('login');
        }
    }

    public function index()
    {
        $nip = $this->session->userdata('nip');
        $sql = "SELECT COUNT(Id) FROM memo WHERE (nip_kpd LIKE '%$nip%' OR nip_cc LIKE '%$nip%') AND (`read` NOT LIKE '%$nip%');";
        $query = $this->db->query($sql);
        $res2 = $query->result_array();
        $result = $res2[0]['COUNT(Id)'];

        $sql2 = "SELECT COUNT(id) FROM task WHERE (`member` LIKE '%$nip%' or `pic` like '%$nip%') and activity='1'";
        $query2 = $this->db->query($sql2);
        $res2 = $query2->result_array();
        $result2 = $res2[0]['COUNT(id)'];

        $data = [
            'count_inbox' => $result,
            'count_inbox2' => $result2,
            'setting' => $this->db->where('Id', '1')->get('utility')->row()
        ];

        $this->load->view('setting', $data);
    }

    public function update()
    {
        $data = [
            'nama_perusahaan' => trim($this->input->post('nama_perusahaan')),
            'nama_singkat' => trim($this->input->post('nama_singkat')),
            'alamat_perusahaan' => trim($this->input->post('alamat_perusahaan')),
            'nama_ppn' => trim($this->input->post('nama_ppn')),
            'besaran_ppn' => trim($this->input->post('besaran_ppn')),
            'nomor_rekening' => trim($this->input->post('no_rekening')),
        ];

        $update = $this->db->where('Id', '1')->update('utility', $data);

        if ($update) {
            $this->session->set_flashdata('message_name', 'Data sudah berhasil diperbarui. Silahkan logout dari sistem dan login kembali untuk implementasi data terbaru!');
        } else {
            $this->session->set_flashdata('message_error', 'Gagal perbarui data! Silahkan dicoba lagi!');
        }

        redirect('setting');
    }

    public function update_logo()
    {
        if (!empty($_FILES['logo']['tmp_name'])) {
            $file_data = file_get_contents($_FILES['logo']['tmp_name']);

            $base64 = base64_encode($file_data);

            $mime_type = mime_content_type($_FILES['logo']['tmp_name']);

            $base64_image = 'data:' . $mime_type . ';base64,' . $base64;

            $data = [
                'logo' => $base64_image
            ];

            $update = $this->db->where('Id', '1')->update('utility', $data);

            if ($update) {
                $this->session->set_flashdata('message_name', 'Data sudah berhasil diperbarui. Silahkan logout dari sistem dan login kembali untuk implementasi data terbaru!');
            } else {
                $this->session->set_flashdata('message_error', 'Gagal perbarui data! Silahkan dicoba lagi!');
            }
            redirect('setting');
        } else {
            echo "File tidak ditemukan!";
        }
    }

    public function cabang()
    {
        $nip = $this->session->userdata('nip');
        $sql = "SELECT COUNT(Id) FROM memo WHERE (nip_kpd LIKE '%$nip%' OR nip_cc LIKE '%$nip%') AND (`read` NOT LIKE '%$nip%');";
        $query = $this->db->query($sql);
        $res2 = $query->result_array();
        $result = $res2[0]['COUNT(Id)'];

        $sql2 = "SELECT COUNT(id) FROM task WHERE (`member` LIKE '%$nip%' or `pic` like '%$nip%') and activity='1'";
        $query2 = $this->db->query($sql2);
        $res2 = $query2->result_array();
        $result2 = $res2[0]['COUNT(id)'];

        $data = [
            'count_inbox' => $result,
            'count_inbox2' => $result2,
            'branchs' => $this->cb->get('t_cabang')->result()
        ];

        $this->load->view('cabang', $data);
    }
}
