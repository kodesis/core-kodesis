<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengajuan extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model(['M_pengajuan', 'm_coa']);
    $this->load->library(array('form_validation', 'session', 'user_agent', 'Api_Whatsapp'));
    $this->load->library('pagination');
    $this->cb = $this->load->database('corebank', TRUE);
    $this->load->helper('url', 'form', 'download');
    date_default_timezone_set('Asia/Jakarta');

    if ($this->session->userdata('isLogin') == FALSE) {
      redirect('home');
    }
  }

  public function create()
  {
    $a = $this->session->userdata('level');
    if (strpos($a, '801') !== false) {
      //inbox notif
      $nip = $this->session->userdata('nip');
      $sql = "SELECT COUNT(Id) FROM memo WHERE (nip_kpd LIKE '%$nip%' OR nip_cc LIKE '%$nip%') AND (`read` NOT LIKE '%$nip%');";
      $sql2 = "SELECT * FROM asset_ruang";
      $sql3 = "SELECT * FROM asset_lokasi";
      $query = $this->db->query($sql);
      $query2 = $this->db->query($sql2);
      $query3 = $this->db->query($sql3);
      $res2 = $query->result_array();
      $asset_ruang = $query2->result();
      $asset_lokasi = $query3->result();
      $result = $res2[0]['COUNT(Id)'];
      $data['count_inbox'] = $result;
      $data['asset_ruang'] = $asset_ruang;
      $data['asset_lokasi'] = $asset_lokasi;

      // Tello
      $sql4 = "SELECT COUNT(Id) FROM task WHERE (`member` LIKE '%$nip%' or `pic` like '%$nip%') and activity='1'";
      $query4 = $this->db->query($sql4);
      $res4 = $query4->result_array();
      $result4 = $res4[0]['COUNT(Id)'];
      $data['count_inbox2'] = $result4;

      $this->load->view('pengajuan/pengajuan_form', $data);
    } else {
      redirect('home');
    }
  }

  public function insert()
  {
    $a = $this->session->userdata('level');
    if (strpos($a, '801') !== false) {
      $tgl = $this->input->post('tanggal');
      $now = date('Y-m-d');
      if (strtotime($tgl) != strtotime($now)) {
        $created_at = $tgl;
      } else {
        $created_at = date('Y-m-d H:i:s');
      }
      $rekening = $this->input->post('rekening');
      $metode = $this->input->post('metode');
      $catatan = $this->input->post('catatan');

      $rows = $this->input->post('row[]');
      $item = $this->input->post('item[]');
      $qtys = $this->input->post('qty[]');
      $price = $this->input->post('harga[]');
      $subtotal = $this->input->post('total[]');
      $total = $this->input->post('nominal');

      // echo '<pre>';
      // print_r($_POST);
      // echo '</pre>';
      // exit;

      $this->form_validation->set_rules('rekening', 'No. Rekening', 'required|trim');
      $this->form_validation->set_rules('metode', 'Metode Pembayaran', 'required');
      $this->form_validation->set_rules('catatan', 'Catatan', 'trim|required');
      $this->form_validation->set_rules('item[]', 'Nama item', 'required');
      $this->form_validation->set_rules('qty[]', 'Qty', 'required');
      $this->form_validation->set_rules('harga[]', 'Harga', 'required');

      if ($this->form_validation->run()) {
        $config['upload_path']          = './upload/pengajuan';
        $config['allowed_types']        = 'jpg|jpeg|png|pdf';
        $config['encrypt_name']         = TRUE;

        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('bukti')) {
          $response = [
            'success' => false,
            'msg' => $this->upload->display_errors()
          ];
        } else {
          $upload = $this->upload->data();
          $user = $this->db->get_where('users', ['nip' => $this->session->userdata('nip')])->row_array();
          $count = $this->cb->get('t_pengajuan')->num_rows();
          $count = $count + 1;
          $no_pengajuan = sprintf("%06d", $count);
          $pengajuan = [
            'no_pengajuan' => $no_pengajuan,
            'user' => $user['nip'],
            'no_rekening' => $rekening,
            'metode_pembayaran' => $metode,
            'spv' => $user['supervisi'],
            'posisi' => 'Diajukan kepada spv',
            'bukti_pengajuan' => $upload['file_name'],
            'catatan' => $catatan,
            'created_at' => $created_at,
            'total' => preg_replace('/[^a-zA-Z0-9\']/', '', $total)
          ];

          $this->cb->insert('t_pengajuan', $pengajuan);

          for ($i = 0; $i < count($rows); $i++) {
            $detail = [
              'no_pengajuan' => $no_pengajuan,
              'item' => $item[$i],
              'qty' => preg_replace('/[^a-zA-Z0-9\']/', '', $qtys[$i]),
              'price' => preg_replace('/[^a-zA-Z0-9\']/', '', $price[$i]),
              'total' => preg_replace('/[^a-zA-Z0-9\']/', '', $subtotal[$i]),
              'created_at' => $created_at
            ];

            $this->cb->insert('t_pengajuan_detail', $detail);
          }

          $response = [
            'success' => true,
            'msg' => 'Pengajuan berhasil ditambahkan!'
          ];
        }
      } else {
        $response = [
          'success' => false,
          'msg' => array_values($this->form_validation->error_array())[0]
        ];
      }
      echo json_encode($response);
    } else {
      redirect('home');
    }
  }

  public function list()
  {
    $a = $this->session->userdata('level');
    if (strpos($a, '801') !== false) {
      // Pagination
      $search = htmlspecialchars($this->input->get('search') ?? '', ENT_QUOTES, 'UTF-8');
      // Pagination
      $config['base_url'] = base_url('pengajuan/list');
      $config['total_rows'] = $this->M_pengajuan->countListPengajuan($search);
      $config['per_page'] = 10;
      $config['uri_segment'] = 3;
      $config['num_links'] = 3;
      $config['enable_query_strings'] = TRUE;
      $config['page_query_string'] = TRUE;
      $config['use_page_numbers'] = TRUE;
      $config['reuse_query_string'] = TRUE;
      $config['query_string_segment'] = 'page';

      // Bootstrap style pagination
      $config['full_tag_open'] = '<ul class="pagination">';
      $config['full_tag_close'] = '</ul>';
      $config['first_link'] = false;
      $config['last_link'] = false;
      $config['first_tag_open'] = '<li>';
      $config['first_tag_close'] = '</li>';
      $config['prev_link'] = '«';
      $config['prev_tag_open'] = '<li class="prev">';
      $config['prev_tag_close'] = '</li>';
      $config['next_link'] = '»';
      $config['next_tag_open'] = '<li>';
      $config['next_tag_close'] = '</li>';
      $config['last_tag_open'] = '<li>';
      $config['last_tag_close'] = '</li>';
      $config['cur_tag_open'] = '<li class="active"><a href="#">';
      $config['cur_tag_close'] = '</a></li>';
      $config['num_tag_open'] = '<li>';
      $config['num_tag_close'] = '</li>';

      // Initialize paginaton
      $this->pagination->initialize($config);
      $page = ($this->input->get('page')) ? (($this->input->get('page') - 1) * $config['per_page']) : 0;
      $data['pagination'] = $this->pagination->create_links();
      //inbox notif
      $nip = $this->session->userdata('nip');
      $sql = "SELECT COUNT(Id) FROM memo WHERE (nip_kpd LIKE '%$nip%' OR nip_cc LIKE '%$nip%') AND (`read` NOT LIKE '%$nip%');";
      $sql2 = "SELECT * FROM asset_ruang";
      $sql3 = "SELECT * FROM asset_lokasi";
      $query = $this->db->query($sql);
      $query2 = $this->db->query($sql2);
      $query3 = $this->db->query($sql3);
      $res2 = $query->result_array();
      $asset_ruang = $query2->result();
      $asset_lokasi = $query3->result();
      $result = $res2[0]['COUNT(Id)'];
      $data['count_inbox'] = $result;
      $data['asset_ruang'] = $asset_ruang;
      $data['asset_lokasi'] = $asset_lokasi;

      // Tello
      $sql4 = "SELECT COUNT(Id) FROM task WHERE (`member` LIKE '%$nip%' or `pic` like '%$nip%') and activity='1'";
      $query4 = $this->db->query($sql4);
      $res4 = $query4->result_array();
      $result4 = $res4[0]['COUNT(Id)'];
      $data['count_inbox2'] = $result4;

      $data['pengajuan'] = $this->M_pengajuan->get_pengajuan($config['per_page'], $page, $search, $this->session->userdata('nip'));
      $data['count_spv'] = $this->M_pengajuan->count_spv($this->session->userdata('nip'));
      $data['count_keuangan'] = $this->M_pengajuan->count_keuangan();
      $data['count_direksi'] = $this->M_pengajuan->count_direksi();
      $this->load->view('pengajuan/pengajuan_list', $data);
    } else {
      redirect('home');
    }
  }

  public function detail($id)
  {
    $nip = $this->session->userdata('nip');
    $sql = "SELECT COUNT(Id) FROM memo WHERE (nip_kpd LIKE '%$nip%' OR nip_cc LIKE '%$nip%') AND (`read` NOT LIKE '%$nip%');";
    $sql2 = "SELECT * FROM asset_ruang";
    $sql3 = "SELECT * FROM asset_lokasi";
    $query = $this->db->query($sql);
    $query2 = $this->db->query($sql2);
    $query3 = $this->db->query($sql3);
    $res2 = $query->result_array();
    $asset_ruang = $query2->result();
    $asset_lokasi = $query3->result();
    $result = $res2[0]['COUNT(Id)'];
    $data['count_inbox'] = $result;
    $data['asset_ruang'] = $asset_ruang;
    $data['asset_lokasi'] = $asset_lokasi;

    // Tello
    $sql4 = "SELECT COUNT(Id) FROM task WHERE (`member` LIKE '%$nip%' or `pic` like '%$nip%') and activity='1'";
    $query4 = $this->db->query($sql4);
    $res4 = $query4->result_array();
    $result4 = $res4[0]['COUNT(Id)'];
    $data['count_inbox2'] = $result4;

    $data['detail'] = $this->M_pengajuan->get_detail($id);
    $data['coa'] = $this->cb->get('v_coa_all')->result_array();
    $this->load->view('pengajuan/pengajuan_detail', $data);
  }

  public function approval_spv()
  {
    $a = $this->session->userdata('level');
    if (strpos($a, '802') !== false) {
      // Pagination
      $search = htmlspecialchars($this->input->get('search') ?? '', ENT_QUOTES, 'UTF-8');
      // Pagination
      $config['base_url'] = base_url('pengajuan/approval_spv');
      $config['total_rows'] = $this->M_pengajuan->countPengajuanSpv($search);
      $config['per_page'] = 10;
      $config['uri_segment'] = 3;
      $config['num_links'] = 3;
      $config['enable_query_strings'] = TRUE;
      $config['page_query_string'] = TRUE;
      $config['use_page_numbers'] = TRUE;
      $config['reuse_query_string'] = TRUE;
      $config['query_string_segment'] = 'page';

      // Bootstrap style pagination
      $config['full_tag_open'] = '<ul class="pagination">';
      $config['full_tag_close'] = '</ul>';
      $config['first_link'] = false;
      $config['last_link'] = false;
      $config['first_tag_open'] = '<li>';
      $config['first_tag_close'] = '</li>';
      $config['prev_link'] = '«';
      $config['prev_tag_open'] = '<li class="prev">';
      $config['prev_tag_close'] = '</li>';
      $config['next_link'] = '»';
      $config['next_tag_open'] = '<li>';
      $config['next_tag_close'] = '</li>';
      $config['last_tag_open'] = '<li>';
      $config['last_tag_close'] = '</li>';
      $config['cur_tag_open'] = '<li class="active"><a href="#">';
      $config['cur_tag_close'] = '</a></li>';
      $config['num_tag_open'] = '<li>';
      $config['num_tag_close'] = '</li>';

      // Initialize paginaton
      $this->pagination->initialize($config);
      $page = ($this->input->get('page')) ? (($this->input->get('page') - 1) * $config['per_page']) : 0;
      $data['pagination'] = $this->pagination->create_links();
      //inbox notif
      $nip = $this->session->userdata('nip');
      $sql = "SELECT COUNT(Id) FROM memo WHERE (nip_kpd LIKE '%$nip%' OR nip_cc LIKE '%$nip%') AND (`read` NOT LIKE '%$nip%');";
      $sql2 = "SELECT * FROM asset_ruang";
      $sql3 = "SELECT * FROM asset_lokasi";
      $query = $this->db->query($sql);
      $query2 = $this->db->query($sql2);
      $query3 = $this->db->query($sql3);
      $res2 = $query->result_array();
      $asset_ruang = $query2->result();
      $asset_lokasi = $query3->result();
      $result = $res2[0]['COUNT(Id)'];
      $data['count_inbox'] = $result;
      $data['asset_ruang'] = $asset_ruang;
      $data['asset_lokasi'] = $asset_lokasi;

      // Tello
      $sql4 = "SELECT COUNT(Id) FROM task WHERE (`member` LIKE '%$nip%' or `pic` like '%$nip%') and activity='1'";
      $query4 = $this->db->query($sql4);
      $res4 = $query4->result_array();
      $result4 = $res4[0]['COUNT(Id)'];
      $data['count_inbox2'] = $result4;

      $data['approval_spv'] = $this->M_pengajuan->approval_spv($config['per_page'], $page, $search, $this->session->userdata('nip'));
      $this->load->view('pengajuan/approval_spv', $data);
    } else {
      redirect('home');
    }
  }

  public function update_spv()
  {
    $id = $this->input->post('id_pengajuan');
    $status = $this->input->post('status');
    $catatan = $this->input->post('catatan');
    $tgl = $this->input->post('tanggal');
    $now = date('Y-m-d');

    if (strtotime($tgl) != strtotime($now)) {
      $date_spv = $tgl;
    } else {
      $date_spv = date('Y-m-d H:i:s');
    }

    $this->form_validation->set_rules('status', 'status pengajuan', 'required');
    $this->form_validation->set_rules('tanggal', 'date', 'required');

    if ($this->form_validation->run() == FALSE) {
      $response = [
        'success' => false,
        'msg' => array_values($this->form_validation->error_array())[0]
      ];
    } else {

      if ($status == 1) {
        $posisi = 'Diajukan kepada keuangan';
      } else {
        $posisi = 'Ditolak oleh supervisi';
      }

      $update = [
        'status_spv' => $status,
        'catatan_spv' => $catatan,
        'date_spv' => $date_spv,
        'posisi' => $posisi
      ];

      $this->cb->where(['Id' => $id]);
      $this->cb->update('t_pengajuan', $update);

      $response = [
        'success' => true,
        'msg' => 'Status pegajuan berhasil diubah!'
      ];
    }

    echo json_encode($response);
  }

  public function approval_keuangan()
  {
    $a = $this->session->userdata('level');
    if (strpos($a, '803') !== false) {
      // filter
      $filter = $this->input->get('filter');
      // Search
      $search = htmlspecialchars($this->input->get('search') ?? '', ENT_QUOTES, 'UTF-8');
      // Pagination
      $config['base_url'] = base_url('pengajuan/approval_keuangan');
      $config['total_rows'] = $this->M_pengajuan->countPengajuanKeuangan($search, $filter);
      $config['per_page'] = 10;
      $config['uri_segment'] = 3;
      $config['num_links'] = 3;
      $config['enable_query_strings'] = TRUE;
      $config['page_query_string'] = TRUE;
      $config['use_page_numbers'] = TRUE;
      $config['reuse_query_string'] = TRUE;
      $config['query_string_segment'] = 'page';

      // Bootstrap style pagination
      $config['full_tag_open'] = '<ul class="pagination">';
      $config['full_tag_close'] = '</ul>';
      $config['first_link'] = false;
      $config['last_link'] = false;
      $config['first_tag_open'] = '<li>';
      $config['first_tag_close'] = '</li>';
      $config['prev_link'] = '«';
      $config['prev_tag_open'] = '<li class="prev">';
      $config['prev_tag_close'] = '</li>';
      $config['next_link'] = '»';
      $config['next_tag_open'] = '<li>';
      $config['next_tag_close'] = '</li>';
      $config['last_tag_open'] = '<li>';
      $config['last_tag_close'] = '</li>';
      $config['cur_tag_open'] = '<li class="active"><a href="#">';
      $config['cur_tag_close'] = '</a></li>';
      $config['num_tag_open'] = '<li>';
      $config['num_tag_close'] = '</li>';

      // Initialize paginaton
      $this->pagination->initialize($config);
      $page = ($this->input->get('page')) ? (($this->input->get('page') - 1) * $config['per_page']) : 0;
      $data['pagination'] = $this->pagination->create_links();
      //inbox notif
      $nip = $this->session->userdata('nip');
      $sql = "SELECT COUNT(Id) FROM memo WHERE (nip_kpd LIKE '%$nip%' OR nip_cc LIKE '%$nip%') AND (`read` NOT LIKE '%$nip%');";
      $sql2 = "SELECT * FROM asset_ruang";
      $sql3 = "SELECT * FROM asset_lokasi";
      $query = $this->db->query($sql);
      $query2 = $this->db->query($sql2);
      $query3 = $this->db->query($sql3);
      $res2 = $query->result_array();
      $asset_ruang = $query2->result();
      $asset_lokasi = $query3->result();
      $result = $res2[0]['COUNT(Id)'];
      $data['count_inbox'] = $result;
      $data['asset_ruang'] = $asset_ruang;
      $data['asset_lokasi'] = $asset_lokasi;

      // Tello
      $sql4 = "SELECT COUNT(Id) FROM task WHERE (`member` LIKE '%$nip%' or `pic` like '%$nip%') and activity='1'";
      $query4 = $this->db->query($sql4);
      $res4 = $query4->result_array();
      $result4 = $res4[0]['COUNT(Id)'];
      $data['count_inbox2'] = $result4;

      $data['approval_keuangan'] = $this->M_pengajuan->approval_keuangan($config['per_page'], $page, $search, $filter);
      $data['coa'] = $this->cb->get('v_coa_all')->result_array();
      $this->cb->like('no_sbb', '1201', 'after');
      $data['coa_close'] = $this->cb->get('v_coa_all')->result_array();
      $this->load->view('pengajuan/approval_keuangan', $data);
    } else {
      redirect('home');
    }
  }

  public function ubah($id)
  {
    $a = $this->session->userdata('level');
    if (strpos($a, '801') !== false) {
      //inbox notif
      $nip = $this->session->userdata('nip');
      $sql = "SELECT COUNT(Id) FROM memo WHERE (nip_kpd LIKE '%$nip%' OR nip_cc LIKE '%$nip%') AND (`read` NOT LIKE '%$nip%');";
      $sql2 = "SELECT * FROM asset_ruang";
      $sql3 = "SELECT * FROM asset_lokasi";
      $query = $this->db->query($sql);
      $query2 = $this->db->query($sql2);
      $query3 = $this->db->query($sql3);
      $res2 = $query->result_array();
      $asset_ruang = $query2->result();
      $asset_lokasi = $query3->result();
      $result = $res2[0]['COUNT(Id)'];
      $data['count_inbox'] = $result;
      $data['asset_ruang'] = $asset_ruang;
      $data['asset_lokasi'] = $asset_lokasi;

      // Tello
      $sql4 = "SELECT COUNT(Id) FROM task WHERE (`member` LIKE '%$nip%' or `pic` like '%$nip%') and activity='1'";
      $query4 = $this->db->query($sql4);
      $res4 = $query4->result_array();
      $result4 = $res4[0]['COUNT(Id)'];
      $data['count_inbox2'] = $result4;

      $data['pengajuan'] = $this->cb->get_where('t_pengajuan', ['Id' => $id])->row_array();
      $this->load->view('pengajuan/pengajuan_form', $data);
    } else {
      redirect('home');
    }
  }

  public function update($id)
  {
    $data = $this->cb->get_where('t_pengajuan', ['Id' => $id])->row_array();
    $rekening = $this->input->post('rekening');
    $metode = $this->input->post('metode');
    $catatan = $this->input->post('catatan');

    $rows = $this->input->post('row[]');
    $item = $this->input->post('item[]');
    $qtys = $this->input->post('qty[]');
    $price = $this->input->post('harga[]');
    $subtotal = $this->input->post('total[]');
    $id_item = $this->input->post('id_item[]');
    $total = $this->input->post('nominal');

    $this->form_validation->set_rules('rekening', 'No. Rekening', 'required|trim');
    $this->form_validation->set_rules('metode', 'Metode Pembayaran', 'required');
    $this->form_validation->set_rules('catatan', 'Catatan', 'trim|required');
    $this->form_validation->set_rules('item[]', 'Nama item', 'required');
    $this->form_validation->set_rules('qty[]', 'Qty', 'required');
    $this->form_validation->set_rules('harga[]', 'Harga', 'required');

    if ($this->form_validation->run()) {
      $config['upload_path']          = './upload/pengajuan';
      $config['allowed_types']        = 'jpg|jpeg|png|pdf';
      $config['encrypt_name']         = TRUE;

      $this->load->library('upload', $config);

      if ($_FILES['bukti']['name']) {
        if ($this->upload->do_upload('bukti')) {
          $upload = $this->upload->data();
          $user = $this->db->get_where('users', ['nip' => $this->session->userdata('nip')])->row_array();
          $count = $this->cb->get('t_pengajuan')->num_rows();
          $count = $count + 1;
          $pengajuan = [
            'user' => $user['nip'],
            'no_rekening' => $rekening,
            'metode_pembayaran' => $metode,
            'spv' => '220940146',
            'status' => 0,
            'status_spv' => 0,
            'status_keuangan' => 0,
            'status_direksi' => 0,
            'posisi' => 'Diajukan kepada spv',
            'bukti_pengajuan' => $upload['file_name'],
            'catatan' => $catatan,
            'total' => preg_replace('/[^a-zA-Z0-9\']/', '', $total)
          ];
          $this->cb->where(['Id' => $id]);
          $this->cb->update('t_pengajuan', $pengajuan);

          $this->cb->where('no_pengajuan',  $data['no_pengajuan']);
          $this->cb->delete('t_pengajuan_detail');

          for ($i = 0; $i < count($rows); $i++) {
            $detail = [
              'no_pengajuan' => $data['no_pengajuan'],
              'item' => $item[$i],
              'qty' => preg_replace('/[^a-zA-Z0-9\']/', '', $qtys[$i]),
              'price' => preg_replace('/[^a-zA-Z0-9\']/', '', $price[$i]),
              'total' => preg_replace('/[^a-zA-Z0-9\']/', '', $subtotal[$i])
            ];
            $this->cb->insert('t_pengajuan_detail', $detail);
          }
          $response = [
            'success' => true,
            'msg' => 'Pengajuan berhasil diubah!'
          ];
        } else {
          $response = [
            'success' => false,
            'msg' => $this->upload->display_errors()
          ];
        }
      } else {
        $user = $this->db->get_where('users', ['nip' => $this->session->userdata('nip')])->row_array();
        $count = $this->cb->get('t_pengajuan')->num_rows();
        $count = $count + 1;
        $pengajuan = [
          'user' => $user['nip'],
          'no_rekening' => $rekening,
          'metode_pembayaran' => $metode,
          'spv' => 220940146,
          'status' => 0,
          'status_spv' => 0,
          'status_keuangan' => 0,
          'status_direksi' => 0,
          'posisi' => 'Diajukan kepada spv',
          'catatan' => $catatan,
          'total' => preg_replace('/[^a-zA-Z0-9\']/', '', $total)
        ];
        $this->cb->where(['Id' => $id]);
        $this->cb->update('t_pengajuan', $pengajuan);

        $this->cb->where('no_pengajuan',  $data['no_pengajuan']);
        $this->cb->delete('t_pengajuan_detail');

        for ($i = 0; $i < count($rows); $i++) {
          $detail = [
            'no_pengajuan' => $data['no_pengajuan'],
            'item' => $item[$i],
            'qty' => preg_replace('/[^a-zA-Z0-9\']/', '', $qtys[$i]),
            'price' => preg_replace('/[^a-zA-Z0-9\']/', '', $price[$i]),
            'total' => preg_replace('/[^a-zA-Z0-9\']/', '', $subtotal[$i])
          ];
          $this->cb->insert('t_pengajuan_detail', $detail);
        }

        $response = [
          'success' => true,
          'msg' => 'Pengajuan berhasil diubah!'
        ];
      }
    } else {
      $response = [
        'success' => false,
        'msg' => array_values($this->form_validation->error_array())[0]
      ];
    }
    echo json_encode($response);
  }

  public function getDataCoa($id)
  {
    $data_coa = $this->cb->get_where('v_coa_all', ['no_sbb' => $id])->row_array();
    echo json_encode($data_coa);
  }

  public function update_keuangan()
  {
    $nip = $this->session->userdata('nip');
    $id = $this->input->post('id_pengajuan');
    $coa_debit = $this->input->post('coa_debit[]');
    $id_item = $this->input->post('id_item[]');
    // $total_item = preg_replace('/[^a-zA-Z0-9\']/', '', $this->input->post('total_item[]'));
    $rows = $this->input->post('row_item[]');
    $status = $this->input->post('status');
    $direksi = $this->input->post('direksi');
    $nama_direksi = $this->input->post('nama_direksi');
    $catatan = $this->input->post('catatan');
    $tgl = $this->input->post('tanggal');
    $now = date('Y-m-d');

    if (strtotime($tgl) != strtotime($now)) {
      $date_keuangan = $tgl;
    } else {
      $date_keuangan = date('Y-m-d H:i:s');
    }

    $this->form_validation->set_rules('status', 'status pengajuan', 'required');
    $this->form_validation->set_rules('tanggal', 'date', 'required');
    if ($status == 1) {
      $this->form_validation->set_rules('coa_debit[]', 'coa', 'required');
      $this->form_validation->set_rules('direksi', 'approval direksi', 'required');
    }

    if ($direksi == 1) {
      $this->form_validation->set_rules('nama_direksi', 'direksi', 'required');
    }

    if ($this->form_validation->run() == FALSE) {
      $response = [
        'success' => false,
        'msg' => array_values($this->form_validation->error_array())[0]
      ];
    } else {
      if ($status == 1) {
        if ($direksi == 1) {
          $posisi = 'Diajukan kepada direksi';
          $nama_direksi = $nama_direksi;
        } else {
          $posisi = 'Diarahkan ke pembayaran';
          $nama_direksi = null;
        }

        for ($i = 0; $i < count($rows); $i++) {
          $this->cb->where('Id', $id_item[$i]);
          $this->cb->update('t_pengajuan_detail', [
            'debit' => $coa_debit[$i]
          ]);
        }
      } else {
        $posisi = 'Ditolak oleh keuangan';
        $nama_direksi = null;
      }

      $update = [
        'keuangan' => $nip,
        'status_keuangan' => $status,
        'date_keuangan' => $date_keuangan,
        'catatan_keuangan' => $catatan,
        'posisi' => $posisi,
        'jenis_pengajuan' => $direksi,
        'direksi' => $nama_direksi
      ];

      $this->cb->where('Id', $id);
      $this->cb->update('t_pengajuan', $update);

      $response = [
        'success' => true,
        'msg' => 'Status pegajuan berhasil diubah!'
      ];
    }

    echo json_encode($response);
  }

  public function approval_direksi()
  {
    $a = $this->session->userdata('level');
    if (strpos($a, '804') !== false) {
      //inbox notif
      $nip = $this->session->userdata('nip');
      $sql = "SELECT COUNT(Id) FROM memo WHERE (nip_kpd LIKE '%$nip%' OR nip_cc LIKE '%$nip%') AND (`read` NOT LIKE '%$nip%');";
      $sql2 = "SELECT * FROM asset_ruang";
      $sql3 = "SELECT * FROM asset_lokasi";
      $query = $this->db->query($sql);
      $query2 = $this->db->query($sql2);
      $query3 = $this->db->query($sql3);
      $res2 = $query->result_array();
      $asset_ruang = $query2->result();
      $asset_lokasi = $query3->result();
      $result = $res2[0]['COUNT(Id)'];
      $data['count_inbox'] = $result;
      $data['asset_ruang'] = $asset_ruang;
      $data['asset_lokasi'] = $asset_lokasi;

      // Tello
      $sql4 = "SELECT COUNT(Id) FROM task WHERE (`member` LIKE '%$nip%' or `pic` like '%$nip%') and activity='1'";
      $query4 = $this->db->query($sql4);
      $res4 = $query4->result_array();
      $result4 = $res4[0]['COUNT(Id)'];
      $data['count_inbox2'] = $result4;

      $data['pengajuan'] = $this->M_pengajuan->get_pengajuan($this->session->userdata('nip'));
      $data['approval_direksi'] = $this->M_pengajuan->approval_direksi();
      $this->load->view('pengajuan/approval_direksi', $data);
    } else {
      redirect('home');
    }
  }

  public function update_direksi()
  {
    $id = $this->input->post('id_pengajuan');
    $status = $this->input->post('status');
    $catatan = $this->input->post('catatan');

    $this->form_validation->set_rules('status', 'status', 'required');

    if ($this->form_validation->run() == FALSE) {
      $response = [
        'success' => false,
        'msg' => array_values($this->form_validation->error_array())[0]
      ];
    } else {
      if ($status == 1) {
        $posisi = 'Diarahkan ke pembayaran';
      } else {
        $posisi = 'Ditolak oleh direksi';
      }

      $update = [
        'status_direksi' => $status,
        'direksi' => $this->session->userdata('nip'),
        'date_direksi' => date('Y-m-d H:i:s'),
        'catatan_direksi' => $catatan,
        'posisi' => $posisi
      ];

      $this->cb->where('Id', $id);
      $this->cb->update('t_pengajuan', $update);

      $response = [
        'success' => true,
        'msg' => 'Status pegajuan berhasil diubah!'
      ];
    }

    echo json_encode($response);
  }

  public function close($id)
  {
    $a = $this->session->userdata('level');
    if (strpos($a, '803') !== false) {
      //inbox notif
      $nip = $this->session->userdata('nip');
      $sql = "SELECT COUNT(Id) FROM memo WHERE (nip_kpd LIKE '%$nip%' OR nip_cc LIKE '%$nip%') AND (`read` NOT LIKE '%$nip%');";
      $sql2 = "SELECT * FROM asset_ruang";
      $sql3 = "SELECT * FROM asset_lokasi";
      $query = $this->db->query($sql);
      $query2 = $this->db->query($sql2);
      $query3 = $this->db->query($sql3);
      $res2 = $query->result_array();
      $asset_ruang = $query2->result();
      $asset_lokasi = $query3->result();
      $result = $res2[0]['COUNT(Id)'];
      $data['count_inbox'] = $result;
      $data['asset_ruang'] = $asset_ruang;
      $data['asset_lokasi'] = $asset_lokasi;

      // Tello
      $sql4 = "SELECT COUNT(Id) FROM task WHERE (`member` LIKE '%$nip%' or `pic` like '%$nip%') and activity='1'";
      $query4 = $this->db->query($sql4);
      $res4 = $query4->result_array();
      $result4 = $res4[0]['COUNT(Id)'];
      $data['count_inbox2'] = $result4;

      $data['detail'] = $this->M_pengajuan->get_detail($id);
      // $this->cb->like('nama_perkiraan', 'BEBAN', 'after');
      $data['coa_beban'] = $this->cb->get('v_coa_all')->result_array();
      $this->cb->like('no_sbb', '1201', 'after');
      $this->cb->or_like('nama_perkiraan', 'KAS', 'after');
      $data['coa_credit'] = $this->cb->get('v_coa_all')->result_array();
      $this->load->view('pengajuan/pengajuan_detail', $data);
    } else {
      redirect('home');
    }
  }

  public function update_close()
  {
    $nip = $this->session->userdata('nip');
    $id = $this->input->post('id_pengajuan');
    $coa_beban = $this->input->post('coa_beban[]');
    $id_item = $this->input->post('id_item[]');
    $rows = $this->input->post('row_item[]');
    $realisasi = preg_replace('/[^a-zA-Z0-9\']/', '', $this->input->post('realisasi[]'));
    $tgl = $this->input->post('tanggal');
    $now = date('Y-m-d');

    if (strtotime($tgl) != strtotime($now)) {
      $date_close = $tgl;
    } else {
      $date_close = date('Y-m-d H:i:s');
    }

    $this->form_validation->set_rules('coa_beban[]', 'COA Beban', 'required');
    $this->form_validation->set_rules('realisasi[]', 'Realisasi', 'required');
    $this->form_validation->set_rules('tanggal', 'date', 'required');

    if ($this->form_validation->run() == FALSE) {
      $response = [
        'success' => false,
        'msg' => array_values($this->form_validation->error_array())[0]
      ];
    } else {
      $pengajuan = $this->cb->get_where('t_pengajuan', ['Id' => $id])->row_array();
      for ($i = 0; $i < count($rows); $i++) {
        $item[] = $this->cb->get_where('t_pengajuan_detail', ['Id' => $id_item[$i]])->row_array();
        $kas[] = $this->cb->get_where('v_coa_all', ['no_sbb' => $item[$i]['kredit']])->row_array();
        $um[] = $this->cb->get_where('v_coa_all', ['no_sbb' => $item[$i]['debit']])->row_array();
        $beban[] = $this->cb->get_where('v_coa_all', ['no_sbb' => $coa_beban[$i]])->row_array();
        $substr_coa_kas[] = substr($kas[$i]['no_sbb'], 0, 1);
        $substr_coa_um[] = substr($um[$i]['no_sbb'], 0, 1);
        $substr_coa_beban[] = substr($beban[$i]['no_sbb'], 0, 1);
        $nominal_kas_baru[] = 0;
        $nominal_um_baru[] = 0;
        $nominal_beban_baru[] = $beban[$i]['nominal'];
        $anggaran_beban_baru[] = 0;
        $selisih[] = $item[$i]['total'] - $realisasi[$i];
        // $total_realisasi = 0;
        // $total_realisasi += $realisasi[$i];

        if ($substr_coa_kas[$i] == "1" || $substr_coa_kas[$i] == "2" || $substr_coa_kas[$i] == "3") {
          $tabel_kas[] = "t_coa_sbb";
          $kolom_kas[] = "no_sbb";
        }

        if ($substr_coa_kas[$i] == "4" || $substr_coa_kas[$i] == "5" || $substr_coa_kas[$i] == "6" || $substr_coa_kas[$i] == "7" || $substr_coa_kas[$i] == "8" || $substr_coa_kas[$i] == "9") {
          $tabel_kas[] = "t_coalr_sbb";
          $kolom_kas[] = "no_lr_sbb";
        }

        if ($substr_coa_um[$i] == "1" || $substr_coa_um[$i] == "2" || $substr_coa_um[$i] == "3") {
          $tabel_um[] = "t_coa_sbb";
          $kolom_um[] = "no_sbb";
        }
        if ($substr_coa_um[$i] == "4" || $substr_coa_um[$i] == "5" || $substr_coa_um[$i] == "6" || $substr_coa_um[$i] == "7" || $substr_coa_um[$i] == "8" || $substr_coa_um[$i] == "9") {
          $tabel_um[] = "t_coalr_sbb";
          $kolom_um[] = "no_lr_sbb";
        }

        if ($substr_coa_beban[$i] == "1" || $substr_coa_beban[$i] == "2" || $substr_coa_beban[$i] == "3") {
          $tabel_beban[] = "t_coa_sbb";
          $kolom_beban[] = "no_sbb";
        }

        if ($substr_coa_beban[$i] == "4" || $substr_coa_beban[$i] == "5" || $substr_coa_beban[$i] == "6" || $substr_coa_beban[$i] == "7" || $substr_coa_beban[$i] == "8" || $substr_coa_beban[$i] == "9") {
          $tabel_beban[] = "t_coalr_sbb";
          $kolom_beban[] = "no_lr_sbb";
        }

        if ($selisih[$i] > 0) {
          // Kredit
          if ($um[$i]['posisi'] == "AKTIVA") {
            $nominal_um_baru[$i] = $um[$i]['nominal'] - $realisasi[$i];
          }
          if ($um[$i]['posisi'] == "PASIVA") {
            $nominal_um_baru[$i] = $um[$i]['nominal'] + $realisasi[$i];
          }

          // Debit 
          if ($beban[$i]['posisi'] == "AKTIVA") {
            $nominal_beban_baru[$i] = $beban[$i]['nominal'] + $realisasi[$i];
          }
          if ($beban[$i]['posisi'] == "PASIVA") {
            $nominal_beban_baru[$i] = $beban[$i]['nominal'] - $realisasi[$i];
          }
          // $nominal_um_baru[$i] = $um[$i]['nominal'] - $realisasi[$i];
          // $nominal_beban_baru[$i] = $beban[$i]['nominal'] + $realisasi[$i];
          // $anggaran_beban_baru[$i] = $beban[$i]['anggaran'] - $realisasi[$i];

          $this->cb->where([$kolom_um[$i] => $um[$i]['no_sbb']]);
          $this->cb->update($tabel_um[$i], ['nominal' => $nominal_um_baru[$i]]);

          $this->cb->where([$kolom_beban[$i] => $coa_beban[$i]]);
          $this->cb->update($tabel_beban[$i], ['nominal' => $nominal_beban_baru[$i]]);

          // create jurnal
          $jurnal = [
            'tanggal' => $date_close,
            'akun_debit' => $coa_beban[$i],
            'jumlah_debit' => $realisasi[$i],
            'akun_kredit' => $um[$i]['no_sbb'],
            'jumlah_kredit' => $realisasi[$i],
            'saldo_debit' => $nominal_beban_baru[$i],
            'saldo_kredit' => $nominal_um_baru[$i],
            'keterangan' => $item[$i]['item'],
            'created_by' => $this->session->userdata('nip'),
          ];

          $this->cb->insert('jurnal_neraca', $jurnal);

          // Debit 
          if ($kas[$i]['posisi'] == "AKTIVA") {
            $nominal_kas_baru[$i] = $kas[$i]['nominal'] + $selisih[$i];
          }
          if ($kas[$i]['posisi'] == "PASIVA") {
            $nominal_kas_baru[$i] = $kas[$i]['nominal'] - $selisih[$i];
          }

          // Kredit
          if ($um[$i]['posisi'] == "AKTIVA") {
            $nominal_um_baru[$i] = $nominal_um_baru[$i] - $selisih[$i];
          }
          if ($um[$i]['posisi'] == "PASIVA") {
            $nominal_um_baru[$i] = $nominal_um_baru[$i] + $selisih[$i];
          }
          // $nominal_um_baru[$i] = $nominal_um_baru[$i] - $selisih[$i];
          // $nominal_kas_baru[$i] = $kas[$i]['nominal'] + $selisih[$i];

          $this->cb->where([$kolom_um[$i] => $um[$i]['no_sbb']]);
          $this->cb->update($tabel_um[$i], ['nominal' => $nominal_um_baru[$i]]);

          $this->cb->where([$kolom_kas[$i] => $kas[$i]['no_sbb']]);
          $this->cb->update($tabel_kas[$i], ['nominal' => $nominal_kas_baru[$i]]);

          // create jurnal
          $jurnal = [
            'tanggal' => $date_close,
            'akun_debit' => $kas[$i]['no_sbb'],
            'jumlah_debit' => $selisih[$i],
            'akun_kredit' => $um[$i]['no_sbb'],
            'jumlah_kredit' => $selisih[$i],
            'saldo_kredit' => $nominal_um_baru[$i],
            'saldo_debit' => $nominal_kas_baru[$i],
            'keterangan' => $item[$i]['item'],
            'created_by' => $this->session->userdata('nip'),
          ];
          $this->cb->insert('jurnal_neraca', $jurnal);
        }

        if ($selisih[$i] < 0) {
          // Kredit
          if ($um[$i]['posisi'] == "AKTIVA") {
            $nominal_um_baru[$i] = $um[$i]['nominal'] - $item[$i]['total'];
          }
          if ($um[$i]['posisi'] == "PASIVA") {
            $nominal_um_baru[$i] = $um[$i]['nominal'] + $item[$i]['total'];
          }

          // Debit
          if ($beban[$i]['posisi'] == "AKTIVA") {
            $nominal_beban_baru[$i] = $beban[$i]['nominal'] + $item[$i]['total'];
          }
          if ($beban[$i]['posisi'] == "PASIVA") {
            $nominal_beban_baru[$i] = $beban[$i]['nominal'] - $item[$i]['total'];
          }

          // $nominal_um_baru[$i] = $um[$i]['nominal'] - $item[$i]['total'];
          // $nominal_beban_baru[$i] = $beban[$i]['nominal'] + $item[$i]['total'];
          // $anggaran_beban_baru[$i] = $beban[$i]['anggaran'] - $item[$i]['total'];

          $this->cb->where([$kolom_um[$i] => $um[$i]['no_sbb']]);
          $this->cb->update($tabel_um[$i], ['nominal' => $nominal_um_baru[$i]]);

          $this->cb->where([$kolom_beban[$i] => $coa_beban[$i]]);
          $this->cb->update($tabel_beban[$i], ['nominal' => $nominal_beban_baru[$i]]);

          // create jurnal
          $jurnal = [
            'tanggal' => $date_close,
            'akun_debit' => $coa_beban[$i],
            'jumlah_debit' => $item[$i]['total'],
            'akun_kredit' => $um[$i]['no_sbb'],
            'jumlah_kredit' => $item[$i]['total'],
            'saldo_debit' => $nominal_beban_baru[$i],
            'saldo_kredit' => $nominal_um_baru[$i],
            'keterangan' => $item[$i]['item'],
            'created_by' => $this->session->userdata('nip'),
          ];

          $this->cb->insert('jurnal_neraca', $jurnal);

          // Kredit
          if ($kas[$i]['posisi'] == "AKTIVA") {
            $nominal_kas_baru[$i] = $kas[$i]['nominal'] - abs($selisih[$i]);
          }
          if ($kas[$i]['posisi'] == "PASIVA") {
            $nominal_kas_baru[$i] = $kas[$i]['nominal'] + abs($selisih[$i]);
          }

          // Debit
          if ($beban[$i]['posisi'] == "AKTIVA") {
            $nominal_beban_baru[$i] = $nominal_beban_baru[$i] + abs($selisih[$i]);
          }
          if ($beban[$i]['posisi'] == "PASIVA") {
            $nominal_beban_baru[$i] = $nominal_beban_baru[$i] - abs($selisih[$i]);
          }

          // $nominal_kas_baru[$i] = $kas[$i]['nominal'] - abs($selisih[$i]);
          // $nominal_beban_baru[$i] = $nominal_beban_baru[$i] + abs($selisih[$i]);
          // $anggaran_beban_baru[$i] = $anggaran_beban_baru[$i] - abs($selisih[$i]);

          $this->cb->where([$kolom_kas[$i] => $kas[$i]['no_sbb']]);
          $this->cb->update($tabel_kas[$i], ['nominal' => $nominal_kas_baru[$i]]);

          $this->cb->where([$kolom_beban[$i] => $coa_beban[$i]]);
          $this->cb->update($tabel_beban[$i], ['nominal' => $nominal_beban_baru[$i]]);

          // create jurnal
          $jurnal = [
            'tanggal' => $date_close,
            'akun_debit' => $coa_beban[$i],
            'jumlah_debit' => abs($selisih[$i]),
            'akun_kredit' => $kas[$i]['no_sbb'],
            'jumlah_kredit' => abs($selisih[$i]),
            'saldo_debit' => $nominal_beban_baru[$i],
            'saldo_kredit' => $nominal_kas_baru[$i],
            'keterangan' => $item[$i]['item'],
            'created_by' => $this->session->userdata('nip'),
          ];

          $this->cb->insert('jurnal_neraca', $jurnal);
        }

        if ($selisih[$i] == 0) {
          // kredit
          if ($um[$i]['posisi'] == "AKTIVA") {
            $nominal_um_baru[$i] = $um[$i]['nominal'] - $realisasi[$i];
          }
          if ($um[$i]['posisi'] == "PASIVA") {
            $nominal_um_baru[$i] = $um[$i]['nominal'] + $realisasi[$i];
          }

          // Debit
          if ($beban[$i]['posisi'] == "AKTIVA") {
            $nominal_beban_baru[$i] = $beban[$i]['nominal'] + $realisasi[$i];
          }
          if ($beban[$i]['posisi'] == "PASIVA") {
            $nominal_beban_baru[$i] = $beban[$i]['nominal'] - $realisasi[$i];
          }

          // $nominal_um_baru[$i] = $um[$i]['nominal'] - $realisasi[$i];
          // $nominal_beban_baru[$i] = $beban[$i]['nominal'] + $realisasi[$i];
          // $anggaran_beban_baru[$i] = $beban[$i]['anggaran'] - $realisasi[$i];

          $this->cb->where([$kolom_um[$i] => $um[$i]['no_sbb']]);
          $this->cb->update($tabel_um[$i], ['nominal' => $nominal_um_baru[$i]]);

          $this->cb->where([$kolom_beban[$i] => $coa_beban[$i]]);
          $this->cb->update($tabel_beban[$i], ['nominal' => $nominal_beban_baru[$i]]);

          // create jurnal
          $jurnal = [
            'tanggal' => $date_close,
            'akun_debit' => $coa_beban[$i],
            'jumlah_debit' => $realisasi[$i],
            'akun_kredit' => $um[$i]['no_sbb'],
            'jumlah_kredit' => $realisasi[$i],
            'saldo_debit' => $nominal_beban_baru[$i],
            'saldo_kredit' => $nominal_um_baru[$i],
            'keterangan' => $item[$i]['item'],
            'created_by' => $this->session->userdata('nip'),
          ];

          $this->cb->insert('jurnal_neraca', $jurnal);
        }

        $this->cb->where('Id', $item[$i]['Id']);
        $this->cb->update('t_pengajuan_detail', [
          'beban' => $coa_beban[$i],
          'realisasi' => $realisasi[$i]
        ]);
      }

      $update = [
        'keuangan' => $nip,
        'status' => 2,
        'date_close' => $date_close,
        'posisi' => 'Closed',
        // 'total_realisasi' => $total_realisasi,
        'user_close' => $nip,
      ];

      $this->cb->where('Id', $id);
      $this->cb->update('t_pengajuan', $update);

      $response = [
        'success' => true,
        'msg' => 'Status pegajuan berhasil diubah!'
      ];
    }
    echo json_encode($response);
  }

  // public function update_close()
  // {
  //   $id = $this->input->post('id_pengajuan');
  //   $realisasi = $this->input->post('realisasi[]')
  //   $pengajuan = $this->cb->get_where('t_pengajuan', ['Id' => $id])->row_array();
  //   $detail = $this->cb->get_where('t_pengajuan_detail', ['no_pengajuan' => $pengajuan['no_pengajuan']])->result_array();

  //   foreach ($detail as $row) {
  //     $debit = $this->cb->get_where('v_coa_all', ['no_sbb' => $row['debit']])->row_array();
  //     $credit = $this->cb->get_where('v_coa_all', ['no_sbb' => $row['kredit']])->row_array();
  //     $nominal_debit_baru = 0;
  //     $nominal_credit_baru = 0;
  //     $substr_coa_debit = substr($row['debit'], 0, 1);
  //     $substr_coa_credit = substr($row['kredit'], 0, 1);

  //     // update nominal debit
  //     // $selisih = $row['total'] - $row['realisasi'];
  //     if ($debit['posisi'] == "AKTIVA") {
  //       $nominal_debit_baru = $debit['nominal'] + $row['realisasi'];
  //     }

  //     if ($debit['posisi'] == "PASIVA") {
  //       $nominal_debit_baru = $debit['nominal'] - $row['realisasi'];
  //     }

  //     if ($substr_coa_debit == "1" || $substr_coa_debit == "2" || $substr_coa_debit == "3") {
  //       $table_debit = "t_coa_sbb";
  //       $kolom_debit = "no_sbb";
  //     } else if ($substr_coa_debit == "4" || $substr_coa_debit == "5" || $substr_coa_debit == "6" || $substr_coa_debit == "7" || $substr_coa_debit == "8" || $substr_coa_debit == "9") {
  //       $table_debit = "t_coalr_sbb";
  //       $kolom_debit = "no_lr_sbb";
  //     }

  //     $this->cb->where([$kolom_debit => $row['debit']]);
  //     $this->cb->update($table_debit, ['nominal' => $nominal_debit_baru]);

  //     // Update nominal kredit
  //     if ($credit['posisi'] == "AKTIVA") {
  //       $nominal_credit_baru = $credit['nominal'] - $row['realisasi'];
  //     }

  //     if ($credit['posisi'] == "PASIVA") {
  //       $nominal_credit_baru = $credit['nominal'] + $row['realisasi'];
  //     }

  //     if ($substr_coa_credit == "1" || $substr_coa_credit == "2" || $substr_coa_credit == "3") {
  //       $table_credit = "t_coa_sbb";
  //       $kolom_credit = "no_sbb";
  //     } else if ($substr_coa_credit == "4" || $substr_coa_credit == "5" || $substr_coa_credit == "6" || $substr_coa_credit == "7" || $substr_coa_credit == "8" || $substr_coa_credit == "9") {
  //       $table_credit = "t_coalr_sbb";
  //       $kolom_credit = "no_lr_sbb";
  //     }

  //     $this->cb->where([$kolom_credit => $credit['no_sbb']]);
  //     $this->cb->update($table_credit, ['nominal' => $nominal_credit_baru]);

  //     // create jurnal
  //     $jurnal = [
  //       'tanggal' => date('Y-m-d'),
  //       'akun_debit' => $row['debit'],
  //       'jumlah_debit' => $row['realisasi'],
  //       'akun_kredit' => $row['kredit'],
  //       'jumlah_kredit' => $row['realisasi'],
  //       'saldo_debit' => $debit['anggaran'],
  //       'saldo_kredit' => $nominal_credit_baru,
  //       'keterangan' => $pengajuan['catatan'],
  //       'created_by' => $this->session->userdata('nip'),
  //     ];
  //     $this->cb->insert('jurnal_neraca', $jurnal);
  //   }

  //   // Update table pengajuan
  //   $update = [
  //     'user_close' => $this->session->userdata('nip'),
  //     'status' => 2,
  //     'posisi' => 'Closed',
  //     'date_close' => date('Y-m-d H:i:s'),
  //   ];

  //   $this->cb->where(['Id' => $id]);
  //   $this->cb->update('t_pengajuan', $update);

  //   redirect('pengajuan/approval_keuangan');
  // }

  public function bayar($id)
  {
    $a = $this->session->userdata('level');
    if (strpos($a, '803') !== false) {
      //inbox notif
      $nip = $this->session->userdata('nip');
      $sql = "SELECT COUNT(Id) FROM memo WHERE (nip_kpd LIKE '%$nip%' OR nip_cc LIKE '%$nip%') AND (`read` NOT LIKE '%$nip%');";
      $sql2 = "SELECT * FROM asset_ruang";
      $sql3 = "SELECT * FROM asset_lokasi";
      $query = $this->db->query($sql);
      $query2 = $this->db->query($sql2);
      $query3 = $this->db->query($sql3);
      $res2 = $query->result_array();
      $asset_ruang = $query2->result();
      $asset_lokasi = $query3->result();
      $result = $res2[0]['COUNT(Id)'];
      $data['count_inbox'] = $result;
      $data['asset_ruang'] = $asset_ruang;
      $data['asset_lokasi'] = $asset_lokasi;

      // Tello
      $sql4 = "SELECT COUNT(Id) FROM task WHERE (`member` LIKE '%$nip%' or `pic` like '%$nip%') and activity='1'";
      $query4 = $this->db->query($sql4);
      $res4 = $query4->result_array();
      $result4 = $res4[0]['COUNT(Id)'];
      $data['count_inbox2'] = $result4;

      $data['detail'] = $this->M_pengajuan->get_detail($id);
      $data['coa'] = $this->cb->get('v_coa_all')->result_array();
      // $this->cb->like('no_sbb', '1201', 'after');
      // $this->cb->or_like('nama_perkiraan', 'KAS', 'after');
      $data['coa_credit'] = $this->cb->get('v_coa_all')->result_array();
      $this->load->view('pengajuan/pengajuan_detail', $data);
    } else {
      redirect('home');
    }
  }

  public function update_bayar()
  {
    $id = $this->input->post('id_pengajuan');
    // $realisasi = preg_replace('/[^a-zA-Z0-9\']/', '', $this->input->post('realisasi[]'));
    $coa_kredit = $this->input->post('coa_credit[]');
    $id_item = $this->input->post('id_item[]');
    $rows = $this->input->post('row_item[]');
    $tgl = $this->input->post('tanggal');
    $now = date('Y-m-d');

    $pengajuan = $this->cb->get_where('t_pengajuan', ['Id' => $id])->row_array();

    if (strtotime($tgl) != strtotime($now)) {
      $date_bayar = $tgl;
    } else {
      $date_bayar = date('Y-m-d H:i:s');
    }

    $this->form_validation->set_rules('coa_credit[]', 'coa', 'required');

    if ($this->form_validation->run() == FALSE) {
      $response = [
        'success' => false,
        'msg' => array_values($this->form_validation->error_array())[0]
      ];
    } else {
      $config['upload_path']          = './upload/pengajuan';
      $config['allowed_types']        = 'jpg|jpeg|png|pdf';
      $config['encrypt_name']         = TRUE;

      $this->load->library('upload', $config);
      if (!$this->upload->do_upload('bukti-bayar')) {
        $response = [
          'success' => false,
          'msg' => $this->upload->display_errors()
        ];
      } else {
        $upload = $this->upload->data();
        for ($i = 0; $i < count($rows); $i++) {
          $item[] = $this->cb->get_where('t_pengajuan_detail', ['Id' => $id_item[$i]])->row_array();
          // Update coa debit
          $coa_debit[] = $this->cb->get_where('v_coa_all', ['no_sbb' => $item[$i]['debit']])->row_array();
          // $anggaran_debit[] = $coa_debit[$i]['anggaran'];
          $posisi_debit[] = $coa_debit[$i]['posisi'];
          $nominal_debit[] = $coa_debit[$i]['nominal'];
          $substr_coa_debit[] = substr($item[$i]['debit'], 0, 1);
          $nominal_debit_baru[] = 0;

          if ($posisi_debit[$i] == "AKTIVA") {
            $nominal_debit_baru[$i] = $nominal_debit[$i] + $item[$i]['total'];
          }

          if ($posisi_debit[$i] == "PASIVA") {
            $nominal_debit_baru[$i] = $nominal_debit[$i] - $item[$i]['total'];
          }

          if ($substr_coa_debit[$i] == "1" || $substr_coa_debit[$i] == "2" || $substr_coa_debit[$i] == "3") {
            $table_debit[] = "t_coa_sbb";
            $kolom_debit[] = "no_sbb";
          } else if ($substr_coa_debit[$i] == "4" || $substr_coa_debit[$i] == "5" || $substr_coa_debit[$i] == "6" || $substr_coa_debit[$i] == "7" || $substr_coa_debit[$i] == "8" || $substr_coa_debit[$i] == "9") {
            $table_debit[] = "t_coalr_sbb";
            $kolom_debit[] = "no_lr_sbb";
          }

          $this->cb->where([$kolom_debit[$i] => $coa_debit[$i]['no_sbb']]);
          $this->cb->update($table_debit[$i], ['nominal' => $nominal_debit_baru[$i]]);

          // update coa credit
          $detail_coa_credit[] = $this->cb->get_where('v_coa_all', ['no_sbb' => $coa_kredit[$i]])->row_array();
          $posisi_credit[] = $detail_coa_credit[$i]['posisi'];
          // $anggaran_credit[] = $detail_coa_credit[$i]['anggaran'];
          $nominal_credit[] = $detail_coa_credit[$i]['nominal'];
          $substr_coa_credit[] = substr($coa_kredit[$i], 0, 1);
          $saldo_credit_baru[] = 0;
          $nominal_credit_baru[] = 0;

          if ($posisi_credit[$i] == "AKTIVA") {
            $nominal_credit_baru[$i] = $nominal_credit[$i] - $item[$i]['total'];
          }
          if ($posisi_credit == "PASIVA") {
            $nominal_credit_baru[$i] = $nominal_credit[$i] + $item[$i]['total'];
          }

          if ($substr_coa_credit[$i] == "1" || $substr_coa_credit[$i] == "2" || $substr_coa_credit[$i] == "3") {
            $table_credit[] = "t_coa_sbb";
            $kolom_credit[] = "no_sbb";
          } else if ($substr_coa_credit[$i] == "4" || $substr_coa_credit[$i] == "5" || $substr_coa_credit[$i] == "6" || $substr_coa_credit[$i] == "7" || $substr_coa_credit[$i] = "8" || $substr_coa_credit[$i] = "9") {
            $table_credit[] = "t_coalr_sbb";
            $kolom_credit[] = "no_lr_sbb";
          }

          $this->cb->where([$kolom_credit[$i] => $coa_kredit[$i]]);
          $this->cb->update($table_credit[$i], ['nominal' => $nominal_credit_baru[$i]]);


          // update table pengajuan detail
          $this->cb->where('Id', $id_item[$i]);
          $this->cb->update('t_pengajuan_detail', [
            'kredit' => $coa_kredit[$i],
          ]);

          // create jurnal
          $jurnal = [
            'tanggal' => $date_bayar,
            'akun_debit' => $item[$i]['debit'],
            'jumlah_debit' => $item[$i]['total'],
            'akun_kredit' => $coa_kredit[$i],
            'jumlah_kredit' => $item[$i]['total'],
            'saldo_debit' => $nominal_debit_baru[$i],
            'saldo_kredit' => $nominal_credit_baru[$i],
            'keterangan' => $item[$i]['item'],
            'created_by' => $this->session->userdata('nip'),
          ];
          $this->cb->insert('jurnal_neraca', $jurnal);
        }

        // Update table pengajuan
        $update = [
          'user_bayar' => $this->session->userdata('nip'),
          'status' => 1,
          'posisi' => 'Sudah Dibayar',
          'date_bayar' => $date_bayar,
          'bukti_bayar' => $upload['file_name'],
        ];

        $this->cb->where(['Id' => $id]);
        $this->cb->update('t_pengajuan', $update);

        $response = [
          'success' => true,
          'msg' => 'Pengajuan berhasil dibayar!'
        ];
      }
    }
    echo json_encode($response);
  }

  public function export_pengajuan()
  {

    $mulai = $this->input->post('tgl_mulai');
    $sampai = $this->input->post('tgl_sampai');
    echo '<table><tbody>';
    $no = 1;

    // include APPPATH . 'third_party/PHPExcel-8/PHPExcel.php';

    $excel = new PHPExcel();

    // Buat sebuah variabel untuk menampung pengaturan style dari header tabel
    $style_col = array(
      'font' => array('bold' => true), // Set font nya jadi bold
      'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
      ),
      'borders' => array(
        'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
        'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
        'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
        'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
      )
    );

    // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
    $style_row = array(
      'alignment' => array(
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
      ),
      'borders' => array(
        'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
        'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
        'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
        'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
      )
    );

    // Buat header tabel nya pada baris ke 3
    $excel->setActiveSheetIndex(0)->setCellValue('A3', "No.");
    $excel->setActiveSheetIndex(0)->setCellValue('B3', "No. Pengajuan");
    $excel->setActiveSheetIndex(0)->setCellValue('C3', "Tanggal Pengajuan");
    $excel->setActiveSheetIndex(0)->setCellValue('D3', "User");
    $excel->setActiveSheetIndex(0)->setCellValue('E3', "COA");
    $excel->setActiveSheetIndex(0)->setCellValue('F3', "Nama COA");
    $excel->setActiveSheetIndex(0)->setCellValue('G3', "Uraian");
    $excel->setActiveSheetIndex(0)->setCellValue('H3', "Pieces");
    $excel->setActiveSheetIndex(0)->setCellValue('I3', "Harga Satuan");
    $excel->setActiveSheetIndex(0)->setCellValue('J3', "Jumlah");
    $excel->setActiveSheetIndex(0)->setCellValue('K3', "Total Pengajuan");
    $excel->setActiveSheetIndex(0)->setCellValue('L3', "Tanggal Bayar");
    $excel->setActiveSheetIndex(0)->setCellValue('M3', "User Payment");
    $excel->setActiveSheetIndex(0)->setCellValue('N3', "Realisasi Bayar");
    $excel->setActiveSheetIndex(0)->setCellValue('O3', "Selisih");
    $excel->setActiveSheetIndex(0)->setCellValue('P3', "Kepala Divisi");
    $excel->setActiveSheetIndex(0)->setCellValue('Q3', "Tanggal Approve");
    $excel->setActiveSheetIndex(0)->setCellValue('R3', "Keuangan");
    $excel->setActiveSheetIndex(0)->setCellValue('S3', "Tanggal Approve");
    $excel->setActiveSheetIndex(0)->setCellValue('T3', "Posisi");

    // Apply style header yang telah kita buat tadi ke masing-masing kolom header
    $excel->getActiveSheet()->getStyle('A3')->applyFromArray($style_col);
    $excel->getActiveSheet()->getStyle('B3')->applyFromArray($style_col);
    $excel->getActiveSheet()->getStyle('C3')->applyFromArray($style_col);
    $excel->getActiveSheet()->getStyle('D3')->applyFromArray($style_col);
    $excel->getActiveSheet()->getStyle('E3')->applyFromArray($style_col);
    $excel->getActiveSheet()->getStyle('F3')->applyFromArray($style_col);
    $excel->getActiveSheet()->getStyle('G3')->applyFromArray($style_col);
    $excel->getActiveSheet()->getStyle('H3')->applyFromArray($style_col);
    $excel->getActiveSheet()->getStyle('I3')->applyFromArray($style_col);
    $excel->getActiveSheet()->getStyle('J3')->applyFromArray($style_col);
    $excel->getActiveSheet()->getStyle('K3')->applyFromArray($style_col);
    $excel->getActiveSheet()->getStyle('L3')->applyFromArray($style_col);
    $excel->getActiveSheet()->getStyle('M3')->applyFromArray($style_col);
    $excel->getActiveSheet()->getStyle('N3')->applyFromArray($style_col);
    $excel->getActiveSheet()->getStyle('O3')->applyFromArray($style_col);
    $excel->getActiveSheet()->getStyle('P3')->applyFromArray($style_col);
    $excel->getActiveSheet()->getStyle('Q3')->applyFromArray($style_col);
    $excel->getActiveSheet()->getStyle('R3')->applyFromArray($style_col);
    $excel->getActiveSheet()->getStyle('S3')->applyFromArray($style_col);
    $excel->getActiveSheet()->getStyle('T3')->applyFromArray($style_col);


    $this->cb->where("created_at >= '$mulai' AND created_at <= '$sampai'");
    $item = $this->cb->get('t_pengajuan_detail')->result_array();

    $no = 1; // Untuk penomoran tabel, di awal set dengan 1
    $i = 0;
    $numrow = 4; // Set baris pertama untuk isi tabel adalah baris ke 4
    foreach ($item as $data) { // Lakukan looping pada variabel siswa
      $pengajuan = $this->cb->get_where('t_pengajuan', ['no_pengajuan' => $data['no_pengajuan']])->row_array();
      $user = $this->db->get_where('users', ['nip' => $pengajuan['user']])->row_array();
      $coa = $this->cb->get_where('v_coa_all', ['no_sbb' => $data['beban']])->row_array();
      $payment = $this->db->get_where('users', ['nip' => $pengajuan['user_bayar']])->row_array();
      $kadiv = $this->db->get_where('users', ['nip' => $pengajuan['spv']])->row_array();
      $keuangan = $this->db->get_where('users', ['nip' => $pengajuan['keuangan']])->row_array();

      $excel->setActiveSheetIndex(0)->setCellValue('A' . $numrow, $no);
      $excel->setActiveSheetIndex(0)->setCellValue('B' . $numrow, $data['no_pengajuan']);
      $excel->setActiveSheetIndex(0)->setCellValue('C' . $numrow, $data['created_at'] ? date('d-m-Y', strtotime($data['created_at'])) : "");
      $excel->setActiveSheetIndex(0)->setCellValue('D' . $numrow, $user['nama']);
      $excel->setActiveSheetIndex(0)->setCellValue('E' . $numrow, $data['beban']);
      $excel->setActiveSheetIndex(0)->setCellValue('F' . $numrow, $data['beban'] ? $coa['nama_perkiraan'] : "");
      $excel->setActiveSheetIndex(0)->setCellValue('G' . $numrow, $data['item']);
      $excel->setActiveSheetIndex(0)->setCellValue('H' . $numrow, $data['qty']);
      $excel->setActiveSheetIndex(0)->setCellValue('I' . $numrow, $data['price']);
      $excel->setActiveSheetIndex(0)->setCellValue('J' . $numrow, $data['total']);
      $excel->setActiveSheetIndex(0)->setCellValue('K' . $numrow, $pengajuan['total']);
      $excel->setActiveSheetIndex(0)->setCellValue('L' . $numrow, $pengajuan['date_bayar'] ? date('d-m-Y', strtotime($pengajuan['date_bayar'])) : "");
      $excel->setActiveSheetIndex(0)->setCellValue('M' . $numrow, $pengajuan['user_bayar'] ? $payment['nama'] : '');
      $excel->setActiveSheetIndex(0)->setCellValue('N' . $numrow, $data['realisasi']);
      $excel->setActiveSheetIndex(0)->setCellValue('O' . $numrow, $data['total'] - $data['realisasi']);
      $excel->setActiveSheetIndex(0)->setCellValue('P' . $numrow, $kadiv['nama']);
      $excel->setActiveSheetIndex(0)->setCellValue('Q' . $numrow, $pengajuan['date_spv'] ? date('d-m-Y', strtotime($pengajuan['date_spv'])) : "");
      $excel->setActiveSheetIndex(0)->setCellValue('R' . $numrow, $pengajuan['keuangan'] ? $keuangan['nama'] : '');
      $excel->setActiveSheetIndex(0)->setCellValue('S' . $numrow, $pengajuan['date_keuangan'] ? date('d-m-Y', strtotime($pengajuan['date_keuangan'])) : '');
      $excel->setActiveSheetIndex(0)->setCellValue('T' . $numrow, $pengajuan['posisi']);

      // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
      $excel->getActiveSheet()->getStyle('A' . $numrow)->applyFromArray($style_row);
      $excel->getActiveSheet()->getStyle('B' . $numrow)->applyFromArray($style_row);
      $excel->getActiveSheet()->getStyle('C' . $numrow)->applyFromArray($style_row);
      $excel->getActiveSheet()->getStyle('D' . $numrow)->applyFromArray($style_row);
      $excel->getActiveSheet()->getStyle('E' . $numrow)->applyFromArray($style_row);
      $excel->getActiveSheet()->getStyle('F' . $numrow)->applyFromArray($style_row);
      $excel->getActiveSheet()->getStyle('G' . $numrow)->applyFromArray($style_row);
      $excel->getActiveSheet()->getStyle('H' . $numrow)->applyFromArray($style_row);
      $excel->getActiveSheet()->getStyle('I' . $numrow)->applyFromArray($style_row);
      $excel->getActiveSheet()->getStyle('J' . $numrow)->applyFromArray($style_row);
      $excel->getActiveSheet()->getStyle('K' . $numrow)->applyFromArray($style_row);
      $excel->getActiveSheet()->getStyle('L' . $numrow)->applyFromArray($style_row);
      $excel->getActiveSheet()->getStyle('M' . $numrow)->applyFromArray($style_row);
      $excel->getActiveSheet()->getStyle('N' . $numrow)->applyFromArray($style_row);
      $excel->getActiveSheet()->getStyle('O' . $numrow)->applyFromArray($style_row);
      $excel->getActiveSheet()->getStyle('P' . $numrow)->applyFromArray($style_row);
      $excel->getActiveSheet()->getStyle('Q' . $numrow)->applyFromArray($style_row);
      $excel->getActiveSheet()->getStyle('R' . $numrow)->applyFromArray($style_row);
      $excel->getActiveSheet()->getStyle('S' . $numrow)->applyFromArray($style_row);
      $excel->getActiveSheet()->getStyle('T' . $numrow)->applyFromArray($style_row);

      $no++; // Tambah 1 setiap kali looping
      $i++;
      $numrow++; // Tambah 1 setiap kali looping
    }
    // Set width kolom
    $excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true); // Set width kolom A
    $excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true); // Set width kolom B
    $excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true); // Set width kolom C
    $excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true); // Set width kolom D
    $excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true); // Set width kolom E
    $excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true); // Set width kolom E
    $excel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true); // Set width kolom E
    $excel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true); // Set width kolom E
    $excel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true); // Set width kolom E
    $excel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true); // Set width kolom E
    $excel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true); // Set width kolom E
    $excel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true); // Set width kolom E
    $excel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true); // Set width kolom E
    $excel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true); // Set width kolom E
    $excel->getActiveSheet()->getColumnDimension('O')->setAutoSize(true); // Set width kolom E
    $excel->getActiveSheet()->getColumnDimension('P')->setAutoSize(true); // Set width kolom E
    $excel->getActiveSheet()->getColumnDimension('Q')->setAutoSize(true); // Set width kolom E
    $excel->getActiveSheet()->getColumnDimension('R')->setAutoSize(true); // Set width kolom E
    $excel->getActiveSheet()->getColumnDimension('S')->setAutoSize(true); // Set width kolom E
    $excel->getActiveSheet()->getColumnDimension('T')->setAutoSize(true); // Set width kolom E

    // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
    $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
    // Set orientasi kertas jadi LANDSCAPE
    $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
    // Set judul file excel nya
    $excel->getActiveSheet(0)->setTitle("Data Pengajuan");
    $excel->setActiveSheetIndex(0);
    // Proses file excel
    // ob_end_clean();

    $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
    header("Content-type: application/vnd.ms-excel");
    header('Content-Disposition: attachment; filename="Data-pengajuan-' . date('ymd', strtotime($mulai)) . '-' . date('ymd', strtotime($sampai)) . '.xlsx"');
    header("Pragma: no-cache");
    header("Expires: 0");
    ob_end_clean();
    // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    // header('Content-Disposition: attachment; filename="Daftar Belanja.xlsx"'); // Set nama file excel nya
    // header('Cache-Control: max-age=0');
    $write->save('php://output');
  }
}
