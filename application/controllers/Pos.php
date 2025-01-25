<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pos extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        //$this->load->model('M_cuti');
        $this->load->model(['m_asset', 'm_coa', 'm_invoice', 'M_Customer']);
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
    }

    public function list_product()
    {
        $koperasi_id = $this->input->post('koperasi_id');
        $keyword = trim($this->input->post('keyword', true) ?? '');

        $config = [
            'base_url' => site_url('pos/list_product'),
            'total_rows' => $this->m_post->product_count($keyword, $koperasi_id),
            'per_page' => 20,
            'uri_segment' => 3,
            'num_links' => 10,
            'full_tag_open' => '<ul class="pagination" style="margin: 0 0">',
            'full_tag_close' => '</ul>',
            'first_link' => false,
            'last_link' => false,
            'first_tag_open' => '<li>',
            'first_tag_close' => '</li>',
            'prev_link' => '«',
            'prev_tag_open' => '<li class="prev">',
            'prev_tag_close' => '</li>',
            'next_link' => '»',
            'next_tag_open' => '<li>',
            'next_tag_close' => '</li>',
            'last_tag_open' => '<li>',
            'last_tag_close' => '</li>',
            'cur_tag_open' => '<li class="active"><a href="#">',
            'cur_tag_close' => '</a></li>',
            'num_tag_open' => '<li>',
            'num_tag_close' => '</li>'
        ];

        $this->pagination->initialize($config);

        $page = $this->uri->segment(3) ? $this->uri->segment(3) : 0;
        $products = $this->m_pos->list_product($config["per_page"], $page, $keyword, $koperasi_id);

        $nip = $this->session->userdata('nip');
        $sql = "SELECT COUNT(Id) FROM memo WHERE (nip_kpd LIKE '%$nip%' OR nip_cc LIKE '%$nip%') AND (`read` NOT LIKE '%$nip%');";
        $query = $this->db->query($sql);
        $result = $query->row_array()['COUNT(Id)'];

        $sql2 = "SELECT COUNT(id) FROM task WHERE (`member` LIKE '%$nip%' or `pic` like '%$nip%') and activity='1'";
        $query2 = $this->db->query($sql2);
        $result2 = $query2->row_array()['COUNT(id)'];

        $data = [
            'page' => $page,
            'products' => $products,
            'count_inbox' => $result,
            'count_inbox2' => $result2,
            'keyword' => $keyword,
            'title' => "List Product",
            'customers' => $this->M_Koperasi->list_koperasi(''),
        ];
        // echo '<pre>';
        // print_r($data['invoices']);
        // echo '</pre>';
        // exit;

        $this->load->view('invoice', $data);
    }

    public function list_koperasi()
    {
    }
}
