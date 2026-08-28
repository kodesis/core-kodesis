<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Task extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->library('Api_Whatsapp');
    $this->load->model('mobile/M_task', 'M_task');
    if ($this->session->userdata('isLogin') == FALSE) {
      $this->session->set_flashdata(
        'msg',
        '<div class="alert rounded-s bg-red-dark" role="alert">
            Your session has been expired! Please login!
            <button type="button" class="close color-white opacity-60 font-16" data-bs-dismiss="alert" aria-label="Close">&times;</button>
         </div>'
      );
      redirect('mobile/auth');
    }
  }

  // public function task()
  // {
  //   $a = $this->session->userdata('level');
  //   if (strpos($a, '601') !== false) {
  //     $search = htmlspecialchars($this->input->get('search') ?? '', ENT_QUOTES, 'UTF-8');
  //     // Pagination
  //     $config['base_url'] = base_url('task/task');
  //     $config['total_rows'] = $this->M_task->task_count($search);
  //     $config['per_page'] = 10;
  //     $config['uri_segment'] = 3;
  //     $config['num_links'] = 1;
  //     $config['enable_query_strings'] = TRUE;
  //     $config['page_query_string'] = TRUE;
  //     $config['use_page_numbers'] = TRUE;
  //     $config['reuse_query_string'] = TRUE;
  //     $config['query_string_segment'] = 'page';

  //     // Bootstrap style pagination
  //     $config['full_tag_open'] = '<ul class="pagination justify-content-center">';
  //     $config['full_tag_close'] = '</ul>';
  //     $config['first_link'] = '<i class="fa-solid fa-angles-left"></i>';
  //     $config['first_tag_open'] = '<li class="page-item">';
  //     $config['first_tag_close'] = '</li>';
  //     $config['last_link'] = '<i class="fa-solid fa-angles-right"></i>';
  //     $config['last_tag_open'] = '<li class="page-item">';
  //     $config['last_tag_close'] = '</li>';
  //     $config['prev_link'] = '<i class="fa-solid fa-angle-left"></i>';
  //     $config['prev_tag_open'] = '<li class="page-item">';
  //     $config['prev_tag_close'] = '</li>';
  //     $config['next_link'] = '<i class="fa-solid fa-angle-right"></i>';
  //     $config['next_tag_open'] = '<li class="page-item">';
  //     $config['next_tag_close'] = '</li>';
  //     $config['cur_tag_open'] = '<li class="page-item active"><a href="#" class="page-link">';
  //     $config['cur_tag_close'] = '</a></li>';
  //     $config['num_tag_open'] = '<li class="page-item">';
  //     $config['num_tag_close'] = '</li>';
  //     $config['attributes'] = array('class' => 'page-link rounded-xs bg-dark-dark color-white shadow-l border-0');

  //     // Initialize paginaton
  //     $this->pagination->initialize($config);
  //     $page = ($this->input->get('page')) ? (($this->input->get('page') - 1) * $config['per_page']) : 0;
  //     $data['task'] = $this->M_task->task_get($config['per_page'], $page, $search);
  //     $data['pagination'] = $this->pagination->create_links();

  //     $this->load->view('mobile/Layouts/v_header', $data);
  //     $this->load->view('mobile/task/v_task', $data);
  //     $this->load->view('mobile/Layouts/v_footer');
  //   } else {
  //     $this->session->set_flashdata('forbidden', 'Not Allowed!');
  //     redirect('mobile/home');
  //   }
  // }

  public function task($filter = null)
  {
    $a = $this->session->userdata('level');
    if (strpos($a, '601') !== false) {
      $search = htmlspecialchars($this->input->get('search') ?? '', ENT_QUOTES, 'UTF-8');

      // =========================================================================
      // PERBAIKAN BASE URL: Masukkan filter ke base_url jika sedang aktif
      // =========================================================================
      if ($filter) {
        $config['base_url'] = base_url('task/task/' . $filter);
        $config['uri_segment'] = 4; // Bergeser ke segment 4 karena ada /task/task/status
      } else {
        $config['base_url'] = base_url('task/task');
        $config['uri_segment'] = 3;
      }

      // Kirim data filter ke view untuk keperluan tanda active di tombol jika perlu
      $data['current_filter'] = $filter;

      // Pagination Config
      $config['total_rows'] = $this->M_task->task_count($search, $filter);
      $config['per_page'] = 10;
      $config['num_links'] = 1;
      $config['enable_query_strings'] = TRUE;
      $config['page_query_string'] = TRUE;
      $config['use_page_numbers'] = TRUE;
      $config['reuse_query_string'] = TRUE;
      $config['query_string_segment'] = 'page';

      // Bootstrap style pagination
      $config['full_tag_open'] = '<ul class="pagination justify-content-center">';
      $config['full_tag_close'] = '</ul>';
      $config['first_link'] = '<i class="fa-solid fa-angles-left"></i>';
      $config['first_tag_open'] = '<li class="page-item">';
      $config['first_tag_close'] = '</li>';
      $config['last_link'] = '<i class="fa-solid fa-angles-right"></i>';
      $config['last_tag_open'] = '<li class="page-item">';
      $config['last_tag_close'] = '</li>';
      $config['prev_link'] = '<i class="fa-solid fa-angle-left"></i>';
      $config['prev_tag_open'] = '<li class="page-item">';
      $config['prev_tag_close'] = '</li>';
      $config['next_link'] = '<i class="fa-solid fa-angle-right"></i>';
      $config['next_tag_open'] = '<li class="page-item">';
      $config['next_tag_close'] = '</li>';
      $config['cur_tag_open'] = '<li class="page-item active"><a href="#" class="page-link">';
      $config['cur_tag_close'] = '</a></li>';
      $config['num_tag_open'] = '<li class="page-item">';
      $config['num_tag_close'] = '</li>';
      $config['attributes'] = array('class' => 'page-link rounded-xs bg-dark-dark color-white shadow-l border-0');

      // Initialize pagination
      $this->pagination->initialize($config);
      $page = ($this->input->get('page')) ? (($this->input->get('page') - 1) * $config['per_page']) : 0;

      // Panggil data dari model dengan filter segment
      $data['task'] = $this->M_task->task_get($config['per_page'], $page, $search, $filter);
      $data['pagination'] = $this->pagination->create_links();

      $today = date('Y-m-d');
      $batas_tanggal = date('Y-m-d', strtotime('-7 days'));

      // Query satu kali untuk menghitung semua status sekaligus (Lebih cepat & ringan)
      $counts = $this->db->select("
    COUNT(id_detail) as total_all,
    SUM(CASE WHEN b.activity = 1 AND due_date > '$today' THEN 1 ELSE 0 END) as total_progress,
    SUM(CASE WHEN b.activity = 2 THEN 1 ELSE 0 END) as total_hold,
    SUM(CASE WHEN b.activity = 1 AND due_date <= '$today' THEN 1 ELSE 0 END) as total_overdue,
    SUM(CASE WHEN b.activity = 3 THEN 1 ELSE 0 END) as total_closed
")


        ->group_start()
        ->where('a.closed_date', NULL)
        ->or_where('a.closed_date >=', $batas_tanggal)
        ->group_end()
        ->group_start()
        ->like('a.member', $this->session->userdata('nip'))
        ->or_like('a.pic', $this->session->userdata('nip'))
        ->group_end()
        ->join('task as a', 'b.id_task = a.id')
        ->get('task_detail b')
        ->row_array();

      // Ambil nilai masing-masing, set default ke 0 jika bernilai NULL
      $data['count_all']      = $counts['total_all'] ?? 0;
      $data['count_progress'] = $counts['total_progress'] ?? 0;
      $data['count_hold']     = $counts['total_hold'] ?? 0;
      $data['count_overdue']  = $counts['total_overdue'] ?? 0;
      $data['count_closed']   = $counts['total_closed'] ?? 0;

      $this->load->view('mobile/Layouts/v_header', $data);
      $this->load->view('mobile/task/v_task', $data);
      $this->load->view('mobile/Layouts/v_footer');
    } else {
      $this->session->set_flashdata('forbidden', 'Not Allowed!');
      redirect('mobile/home');
    }
  }

  public function task_closed($filter = null)
  {
    $a = $this->session->userdata('level');
    if (strpos($a, '601') !== false) {
      $search = htmlspecialchars($this->input->get('search') ?? '', ENT_QUOTES, 'UTF-8');

      // =========================================================================
      // PERBAIKAN BASE URL: Masukkan filter ke base_url jika sedang aktif
      // =========================================================================
      if ($filter) {
        $config['base_url'] = base_url('task/task/' . $filter);
        $config['uri_segment'] = 4; // Bergeser ke segment 4 karena ada /task/task/status
      } else {
        $config['base_url'] = base_url('task/task');
        $config['uri_segment'] = 3;
      }

      // Kirim data filter ke view untuk keperluan tanda active di tombol jika perlu
      $data['current_filter'] = $filter;

      // Pagination Config
      $config['total_rows'] = $this->M_task->task_closed_count($search, $filter);
      $config['per_page'] = 10;
      $config['num_links'] = 1;
      $config['enable_query_strings'] = TRUE;
      $config['page_query_string'] = TRUE;
      $config['use_page_numbers'] = TRUE;
      $config['reuse_query_string'] = TRUE;
      $config['query_string_segment'] = 'page';

      // Bootstrap style pagination
      $config['full_tag_open'] = '<ul class="pagination justify-content-center">';
      $config['full_tag_close'] = '</ul>';
      $config['first_link'] = '<i class="fa-solid fa-angles-left"></i>';
      $config['first_tag_open'] = '<li class="page-item">';
      $config['first_tag_close'] = '</li>';
      $config['last_link'] = '<i class="fa-solid fa-angles-right"></i>';
      $config['last_tag_open'] = '<li class="page-item">';
      $config['last_tag_close'] = '</li>';
      $config['prev_link'] = '<i class="fa-solid fa-angle-left"></i>';
      $config['prev_tag_open'] = '<li class="page-item">';
      $config['prev_tag_close'] = '</li>';
      $config['next_link'] = '<i class="fa-solid fa-angle-right"></i>';
      $config['next_tag_open'] = '<li class="page-item">';
      $config['next_tag_close'] = '</li>';
      $config['cur_tag_open'] = '<li class="page-item active"><a href="#" class="page-link">';
      $config['cur_tag_close'] = '</a></li>';
      $config['num_tag_open'] = '<li class="page-item">';
      $config['num_tag_close'] = '</li>';
      $config['attributes'] = array('class' => 'page-link rounded-xs bg-dark-dark color-white shadow-l border-0');

      // Initialize pagination
      $this->pagination->initialize($config);
      $page = ($this->input->get('page')) ? (($this->input->get('page') - 1) * $config['per_page']) : 0;

      // Panggil data dari model dengan filter segment
      $data['task'] = $this->M_task->task_closed_get($config['per_page'], $page, $search, $filter);
      $data['pagination'] = $this->pagination->create_links();

      $today = date('Y-m-d');
      $batas_tanggal = date('Y-m-d', strtotime('-7 days'));

      // Query satu kali untuk menghitung semua status sekaligus (Lebih cepat & ringan)
      $counts = $this->db->select("
    COUNT(id_detail) as total_all,
    SUM(CASE WHEN b.activity = 1 AND due_date > '$today' THEN 1 ELSE 0 END) as total_progress,
    SUM(CASE WHEN b.activity = 2 THEN 1 ELSE 0 END) as total_hold,
    SUM(CASE WHEN b.activity = 1 AND due_date <= '$today' THEN 1 ELSE 0 END) as total_overdue,
    SUM(CASE WHEN b.activity = 3 THEN 1 ELSE 0 END) as total_closed
")

        ->group_start()
        ->where('b.closed_date', NULL)
        ->or_where('b.closed_date >=', $batas_tanggal)
        ->group_end()
        ->group_start()
        ->like('b.member', $this->session->userdata('nip'))
        ->or_like('b.pic', $this->session->userdata('nip'))
        ->group_end()->join('task as b', 'task_detail.id_task = b.id')
        ->get('task_detail')
        ->row_array();

      // Ambil nilai masing-masing, set default ke 0 jika bernilai NULL
      $data['count_all']      = $counts['total_all'] ?? 0;
      $data['count_progress'] = $counts['total_progress'] ?? 0;
      $data['count_hold']     = $counts['total_hold'] ?? 0;
      $data['count_overdue']  = $counts['total_overdue'] ?? 0;
      $data['count_closed']   = $counts['total_closed'] ?? 0;

      $this->load->view('mobile/Layouts/v_header', $data);
      $this->load->view('mobile/task/v_task', $data);
      $this->load->view('mobile/Layouts/v_footer');
    } else {
      $this->session->set_flashdata('forbidden', 'Not Allowed!');
      redirect('mobile/home');
    }
  }

  public function task_view($id)
  {
    $a = $this->session->userdata('level');
    $task = $this->db->get_where('task', ['id' => $id])->row();
    $data['task'] = $task;
    if (strpos($a, '601') !== false) {
      if ($data['task']) {
        $cek_detail = $this->db->get_where('task_detail', ['id_task' => $id])->num_rows();
        if ($cek_detail) {

          // =========================================================================
          // LOGIKA BARU: CEK SEGMENT 4 (APAKAH ID DETAIL ATAU STATUS FILTER)
          // =========================================================================
          $segment_4 = $this->uri->segment(5);
          $status_filter = null;
          $id_detail_comment = null;

          // Daftar teks status yang mungkin dikirim lewat URL
          $allowed_status = ['progress', 'hold', 'overdue', 'closed'];

          if ($segment_4) {

            if (in_array(strtolower($segment_4), $allowed_status)) {
              // Jika segment 4 adalah string status (misal: /36/progress)
              $status_filter = strtolower($segment_4);
            } else {
              // Jika segment 4 adalah ID angka (misal: /36/42)
              $id_detail_comment = $segment_4;
              $detail_task_row = $this->db->get_where('task_detail', ['id_detail' => $id_detail_comment])->row();
              if ($detail_task_row->member_detail) {
                $data_nip_member = explode(';', $detail_task_row->member_detail);
              } else {
                $data_nip_member = [];
              }
              $soeryo = '2146501';
              if ($soeryo != $this->session->userdata('nip') && $this->session->userdata('level_jabatan') <= '4' && $task->pic != $this->session->userdata('nip') && $detail_task_row->responsible != $this->session->userdata('nip') && !in_array($this->session->userdata('nip'), $data_nip_member)) {
                $this->session->set_flashdata('forbidden', "You are not responsible for this Task!");
                redirect('mobile/task/task_view/' . $id);
              }
            }
          }

          // =========================================================================
          // 1. QUERY UNTUK LIST TASK DETAIL (DENGAN FILTER STATUS JIKA ADA)
          // =========================================================================
          // $this->db->where('b.id_task', $id);
          // $this->db->from('users as a');
          // $this->db->join('task_detail as b', 'a.nip = b.responsible');

          $this->db->where('b.id_task', $id);
          $this->db->from('task_detail as b');


          // Tambahkan filter where dinamis berdasarkan kiriman segment 4
          if ($status_filter) {
            $today = date('Y-m-d');
            if ($status_filter == 'progress') {
              $this->db->where('b.activity', 1);
              $this->db->where('b.due_date >', $today);
            } elseif ($status_filter == 'overdue') {
              $this->db->where('b.activity', 1);
              $this->db->where('b.due_date <=', $today);
            } elseif ($status_filter == 'hold') {
              // Sesuaikan kondisi database Anda untuk status HOLD (misal activity = 2)
              $this->db->where('b.activity', 2);
            } elseif ($status_filter == 'closed') {
              $this->db->where('b.activity !=', 1);
              $this->db->where('b.activity !=', 2); // Abaikan hold juga jika terpisah
            }
          }

          $this->db->order_by('b.activity', 'ASC');
          $this->db->order_by('b.date_created', 'DESC');

          $data['task_detail'] = $this->db->get()->result();

          $id_task = $this->uri->segment(3);
          $today = date('Y-m-d');

          // Query satu kali untuk menghitung semua status sekaligus (Lebih cepat & ringan)
          $counts = $this->db->select("
    COUNT(id_detail) as total_all,
    SUM(CASE WHEN activity = 1 AND due_date > '$today' THEN 1 ELSE 0 END) as total_progress,
    SUM(CASE WHEN activity = 2 THEN 1 ELSE 0 END) as total_hold,
    SUM(CASE WHEN activity = 1 AND due_date <= '$today' THEN 1 ELSE 0 END) as total_overdue,
    SUM(CASE WHEN activity = 3 THEN 1 ELSE 0 END) as total_closed
")
            ->where('id_task', $id_task)
            ->get('task_detail')
            ->row_array();

          // Ambil nilai masing-masing, set default ke 0 jika bernilai NULL
          $data['count_all']      = $counts['total_all'] ?? 0;
          $data['count_progress'] = $counts['total_progress'] ?? 0;
          $data['count_hold']     = $counts['total_hold'] ?? 0;
          $data['count_overdue']  = $counts['total_overdue'] ?? 0;
          $data['count_closed']   = $counts['total_closed'] ?? 0;

          // =========================================================================
          // 2. QUERY UNTUK COMMENT (HANYA BERJALAN JIKA SEGMENT 4 ADALAH ID ANGKA)
          // =========================================================================
          $data['task_comment'] = null;
          $data['task_comment_member'] = array();

          if ($id_detail_comment) {
            $this->db->select('*,c.activity as status_task,b.activity,b.comment as comment,b.date_created');
            $this->db->where('b.id_detail', $id_detail_comment);
            $this->db->from('users as a');
            $this->db->join('task_detail as b', 'a.nip=b.responsible');
            $this->db->join('task as c', 'b.id_task=c.id');
            $data['task_comment'] = $this->db->get()->row_array();

            $this->db->where('b.id_task_detail', $id_detail_comment);
            $this->db->from('users as a');
            $this->db->join('task_detail_comment as b', 'a.nip=b.member');
            $this->db->order_by('date_created', 'DESC');
            $data['task_comment_member'] = $this->db->get()->result();

            // Update read card
            $nip = $this->session->userdata('nip');
            $sqlx = "SELECT task_detail.read FROM task_detail WHERE id_detail ='$id_detail_comment'";
            $queryxx = $this->db->query($sqlx);
            $resultx = $queryxx->row();
            if ($resultx) {
              $kalimat = $resultx->read;
              if (!preg_match("/$nip/i", $kalimat ?? '')) {
                $kalimat1 = $kalimat . ' ' . $nip;
                $data_update11 = array('read' => $kalimat1);
                $this->db->where('id_detail', $id_detail_comment);
                $this->db->update('task_detail', $data_update11);
              }
            }
          }

          // =========================================================================
          // 3. UPDATE READ TASK (TETAP BERJALAN KARENA MENGGUNAKAN SEGMENT 3 / ID TASK)
          // =========================================================================
          if ($id) {
            $nip = $this->session->userdata('nip');
            $sql = "SELECT task.read FROM task WHERE id ='$id'";
            $result = $this->db->query($sql)->row();
            if ($result) {
              $kalimat = $result->read;
              if (!preg_match("/$nip/i", $kalimat ?? '')) {
                $kalimat1 = $kalimat . ' ' . $nip;
                $update = array('read' => $kalimat1);
                $this->db->where('id', $id);
                $this->db->update('task', $update);
              }
            }
          }

          $this->load->view('mobile/Layouts/v_header', $data);
          $this->load->view('mobile/task/v_detail', $data);
          $this->load->view('mobile/Layouts/v_footer');
        } else {
          if ($data['task']->pic !== $this->session->userdata('nip')) {
            $this->session->set_flashdata('forbidden', "PIC has'nt created a task card yet!");
            redirect('mobile/task/task');
          } else {
            redirect('mobile/task/task_view/' . $id);
          }
        }
      } else {
        $this->session->set_flashdata('forbidden', 'Unauthorize Privilage!');
        redirect('mobile/task/task/');
      }
    } else {
      $this->session->set_flashdata('forbidden', 'Not Allowed!');
      redirect('mobile/home');
    }
  }

  public function create_task()
  {
    $a = $this->session->userdata('level');
    $data['task_edit'] = $this->db->get_where('task', ['id' => $this->uri->segment(3)])->row_array();

    if (strpos($a, '601') !== false || $data['task_edit']['pic'] == $this->session->userdata('nip')) {
      $data['sendto'] = $this->M_task->sendto($this->session->userdata('level_jabatan'), $this->session->userdata('bagian'));

      $this->load->view('mobile/Layouts/v_header');
      $this->load->view('mobile/task/v_create', $data);
      $this->load->view('mobile/Layouts/v_footer');
    } else {
      $this->session->set_flashdata('forbidden', 'Unauthorize Privilage!');
      redirect('mobile/task/task');
    }
  }

  public function save_task()
  {
    $a = $this->session->userdata('level');
    if (strpos($a, '601') !== false) {
      $project_name = htmlspecialchars($this->input->post('project_name'), ENT_QUOTES, 'UTF-8');
      $activity = $this->input->post('activity');
      $member_name = $this->input->post('member_task[]');
      $comment = htmlspecialchars($this->input->post('comment'), ENT_QUOTES, 'UTF-8');

      $this->form_validation->set_rules('project_name', 'Project or task name', 'required|trim');
      $this->form_validation->set_rules('member_task[]', 'Member name', 'required');
      $this->form_validation->set_rules('activity', 'Activity', 'required|in_list[1,2,3]');
      $this->form_validation->set_error_delimiters('<span class="error text-danger">', '</span>');

      if ($this->form_validation->run() == FALSE) {
        $this->create_task();
      } else {
        date_default_timezone_set('Asia/Jakarta');

        // Simpan Task / Project
        $member_task = '';
        $i = 0;
        if (!empty($member_name)) {
          foreach ($member_name as $value) {
            $member_task .= $value . ';';
            $get_member[] = $this->db->get_where('users', ['nip' => $value])->row_array();
            $phone_member[] = $get_member[$i]['phone'];
            $i++;
          }
        }
        $insert = [
          'name' => $project_name,
          'member' => $member_task,
          'activity' => $activity,
          'comment' => $comment,
          'pic' => $this->session->userdata('nip'),
          'date_created' => date('Y-m-d')
        ];
        $this->db->insert('task', $insert);
        $last_id = $this->db->insert_id();

        // Notif Whatsapp
        $nama_session = $this->session->userdata('nama');
        $msg = "There's a new project\nProjectName : *$project_name*\n\nCreated By : *$nama_session*";
        $send_wa = implode(',', $phone_member);
        foreach ($phone_member as $p) {
          $utility = $this->db->get_where('utility', ['Id' => 1])->row_array();

          if ($utility['notif_wa'] == 1) {
            $this->api_whatsapp->wa_notif($msg, $p);
          }
        }

        // Alert berhasil insert
        $this->session->set_flashdata('success', 'Projectsuccessfully created!');
        redirect('mobile/task/detail_task/' . $last_id);
      }
    } else {
      $this->session->set_flashdata('forbidden', 'Unauthorize Privilage!');
      redirect('mobile/task/task');
    }
  }

  public function detail_task($id)
  {
    $a = $this->session->userdata('level');
    if (strpos($a, '601') !== false) {
      $get_task = $this->db->get_where('task', ['id' => $id])->row_array();
      if ($get_task['pic'] !== $this->session->userdata('nip')) {
        $cek_card = $this->db->get_where('task_detail', ['id_task' => $id])->num_rows();

        if ($cek_card > 0) {
          $this->session->set_flashdata('forbidden', 'Unauthorize Privilage!');
        } else {
          $this->session->set_flashdata('forbidden', 'Task Belum Ada!');
        }
        redirect('mobile/task/task');
      }

      $data['task'] = $get_task['member'];
      $nip_task = explode(';', $get_task['member']);
      $this->db->where_in('nip', $nip_task);
      $data['ss'] = $this->db->get('users')->result();

      $this->load->view('mobile/Layouts/v_header');
      $this->load->view('mobile/task/v_create_card', $data);
      $this->load->view('mobile/Layouts/v_footer');
    } else {
      $this->session->set_flashdata('forbidden', 'Unauthorize Privilage!');
      redirect('mobile/task/task');
    }
  }

  public function save_detail_task($id)
  {
    $nip = $this->session->userdata('nip');
    $user = $this->db->get_where('users', ['nip' => $nip])->row();

    $id_task = $this->input->post('id_task');
    $id_card = $this->input->post('id_card');
    $card_name = htmlspecialchars($this->input->post('card_name'), ENT_QUOTES, 'UTF-8');
    $responsible = $this->input->post('responsible');
    $description = htmlspecialchars($this->input->post('description'), ENT_QUOTES, 'UTF-8');
    $start = $this->input->post('start_date');
    $end = $this->input->post('end_date');
    $activity = $this->input->post('activity');

    $this->form_validation->set_rules('card_name', 'card name', 'required|trim');
    $this->form_validation->set_rules('responsible', 'responsible', 'required');
    $this->form_validation->set_rules('start_date', 'start date', 'required');
    $this->form_validation->set_rules('end_date', 'due date', 'required');
    $this->form_validation->set_rules('activity', 'activity', 'required|in_list[1,2,3]');
    $this->form_validation->set_error_delimiters('<span class="error text-danger">', '</span>');

    $target_file = '../moc.mlejitoffice.id/upload/task_comment/';

    if ($this->form_validation->run() == FALSE) {
      $this->detail_task($this->uri->segment(3));
    } else {
      if (!empty($_FILES['attachment']['name'][0])) {
        $nama_file = array();
        for ($xx = 0; $xx < count($_FILES['attachment']['name']); $xx++) {
          // Simpan nama file ke variabel terlebih dahulu agar nilai time() konsisten
          $clean_name = str_replace(' ', '', $_FILES['attachment']['name'][$xx]);
          $newfilename = time() . '_' . $clean_name;

          // Pindahkan file asli menggunakan nama yang sudah fix
          move_uploaded_file($_FILES['attachment']['tmp_name'][$xx], $target_file . $newfilename);

          // Masukkan variabel yang sama ke dalam array nama file
          $nama_file[] = $newfilename;
        }

        // Gabungkan array menjadi string jika array tidak kosong
        $file_i = implode(';', $nama_file);
      } else {
        // Jika tidak ada file, set langsung sebagai string kosong atau null sesuai kebutuhan database
        $file_i = '';
      }

      // Susun data insert ke database
      $insert = [
        'id_task'     => $id,
        'task_name'   => $card_name,
        'responsible' => $responsible,
        'description' => $description,
        'start_date'  => $start,
        'due_date'    => $end,
        'activity'    => $activity,
        'attachment'  => $file_i, // Sekarang aman dari error implode karena tipenya pasti string
      ];

      $member_name = $this->input->post('member_task[]');
      $member_task = '';
      $i = 0;
      if (!empty($member_name)) {
        foreach ($member_name as $value) {
          $member_task .= $value . ';';
          $get_member[] = $this->db->get_where('users', ['nip' => $value])->row_array();
          $phone_member[] = $get_member[$i]['phone'];
          $i++;
        }
      }
      $insert['member_detail'] = $member_task;

      $this->db->insert('task_detail', $insert);

      $task = $this->db->get_where('task', ['id' => $id])->row();
      $nip_member = rtrim($task->member, ';');
      $arr_member = explode(';', $nip_member);

      foreach ($arr_member as $value) {
        $user = $this->db->get_where('users', ['nip' => $value])->row();
        $msg = "There's a new task\nProjectName:*$task->name*\nTask Name : *$card_name*\n\nCreated By :  *$user->nama*";
        $utility = $this->db->get_where('utility', ['Id' => 1])->row_array();

        if ($utility['notif_wa'] == 1) {
          $this->api_whatsapp->wa_notif($msg, $user->phone);
        }
      }

      $this->session->set_flashdata('success', 'Task successfully created!');
      redirect('mobile/task/task_view/' . $id);
    }
  }

  public function update_detail_task()
  {
    $nip = $this->session->userdata('nip');
    $user = $this->db->get_where('users', ['nip' => $nip])->row();

    $id_task = $this->input->post('id_task');
    $id_card = $this->input->post('id_card');
    $card_name = htmlspecialchars($this->input->post('card_name'), ENT_QUOTES, 'UTF-8');
    $responsible = $this->input->post('responsible');
    $description = htmlspecialchars($this->input->post('description'), ENT_QUOTES, 'UTF-8');
    $start = $this->input->post('start_date');
    $end = $this->input->post('end_date');
    $activity = $this->input->post('activity');

    $this->form_validation->set_rules('card_name', 'card name', 'required|trim');
    $this->form_validation->set_rules('responsible', 'responsible', 'required');
    $this->form_validation->set_rules('start_date', 'start date', 'required');
    $this->form_validation->set_rules('end_date', 'due date', 'required');
    $this->form_validation->set_rules('activity', 'activity', 'required|in_list[1,2,3]');
    $this->form_validation->set_error_delimiters('<span class="error text-danger">', '</span>');

    $target_file = '../moc.mlejitoffice.id/upload/task_comment/';

    if ($this->form_validation->run() == FALSE) {
      $this->session->set_flashdata('forbidden', array_values($this->form_validation->error_array())[0]);
      redirect('mobile/task/card_edit/' . $id_task . '/' . $id_card);
    } else {
      // if ($_FILES['attachment']['name'][0] != "") {
      //   $nama_file = array();
      //   for ($xx = 0; $xx < count($_FILES['attachment']['name']); $xx++) {
      //     $newfilename = str_replace(' ', '', time() . '_' . $_FILES['attachment']['name'][$xx]);
      //     move_uploaded_file($_FILES['attachment']['tmp_name'][$xx], $target_file . $newfilename);
      //     $nama_file[] = str_replace(' ', '', time() . '_' . $_FILES['attachment']['name'][$xx]);
      //   }
      // } else {
      //   $nama_file = null;
      // }

      // $file_i = implode(';', $nama_file);
      if (!empty($_FILES['attachment']['name'][0])) {
        $nama_file = array();
        for ($xx = 0; $xx < count($_FILES['attachment']['name']); $xx++) {
          // Simpan nama file ke variabel terlebih dahulu agar nilai time() konsisten
          $clean_name = str_replace(' ', '', $_FILES['attachment']['name'][$xx]);
          $newfilename = time() . '_' . $clean_name;

          // Pindahkan file asli menggunakan nama yang sudah fix
          move_uploaded_file($_FILES['attachment']['tmp_name'][$xx], $target_file . $newfilename);

          // Masukkan variabel yang sama ke dalam array nama file
          $nama_file[] = $newfilename;
        }

        // Gabungkan array menjadi string jika array tidak kosong
        $file_i = implode(';', $nama_file);
      } else {
        // Jika tidak ada file, set langsung sebagai string kosong atau null sesuai kebutuhan database
        $file_i = '';
      }

      $member_name = $this->input->post('member_task[]');
      $member_task = '';
      $i = 0;
      if (!empty($member_name)) {
        foreach ($member_name as $value) {
          $member_task .= $value . ';';
          $get_member[] = $this->db->get_where('users', ['nip' => $value])->row_array();
          $phone_member[] = $get_member[$i]['phone'];
          $i++;
        }
      }

      $update = [
        'id_task' => $id_task,
        'task_name' => $card_name,
        'responsible' => $responsible,
        'member_detail' => $member_task,
        'description' => $description,
        'start_date' => $start,
        'due_date' => $end,
        'activity' => $activity,
        'attachment' => $file_i,
      ];

      if ($activity == '3') {
        if ($end) {
          // Buat objek tanggal untuk hari ini dan tanggal jatuh tempo
          $today = new DateTime(date('Y-m-d'));
          $due = new DateTime($end);

          // Hitung selisih hari
          $diff = $today->diff($due);
          $days_left = (int)$diff->format('%r%a');

          if ($days_left >= 0) {
            // Belum lewat (Hari H atau sisa waktu masih ada) -> Progress Biru
            $closed_on = 'On Progress';
          } else {
            // Sudah LEWAT (Nilai $days_left negatif, kita ubah jadi positif agar mudah dibaca)
            $days_overdue = abs($days_left);

            if ($days_overdue <= 7) {
              // Lewat 1 minggu kebawah (1 - 7 hari) -> Kuning
              $closed_on = 'Overdue < 1 Ming';
            } elseif ($days_overdue > 7 && $days_overdue <= 30) {
              $closed_on = 'Overdue < 1 Bln';
            } else {
              $closed_on = 'Overdue > 1 Bln';
            }
          }
        } else {
          $closed_on = 'On Progress';
        }
        $update['closed_on'] = $closed_on;
        $update['closed_date'] = date('Y-m-d');
      }
      $this->db->where('id_detail', $id_card);
      $this->db->update('task_detail', $update);

      // update task 
      $this->db->where('id', $id_task);
      $this->db->update('task', ['read' => 0]);


      $this->session->set_flashdata('success', 'Task successfully updated!');
      redirect('mobile/task/task_view/' . $id_task);
    }
  }

  public function activity_comment()
  {
    $data = [
      "id_task_detail" => $this->input->post('id_detail'),
      "comment_member" => $this->input->post('comment'),
      // "attachment" => implode(';', $arr_att),
      // "attachment_name" => implode(';', str_replace(' ', '_', $arr_name)),
      "member" => $this->session->userdata('nip')
    ];

    // var_dump($_FILES['file']);
    // die;

    if (isset($_FILES['file']) && !empty($_FILES['file']['name'][0]) && $_FILES['file']['error'][0] != 4) {

      $files = $_FILES;
      $cpt = count($_FILES['file']['name']);

      // Buat array kosong dulu untuk menghindari error undefined jika ada file yang gagal
      $arr_att = [];
      $arr_name = [];

      for ($i = 0; $i < $cpt; $i++) {
        // Lewati jika index file ini bermasalah atau kosong
        if ($files['file']['error'][$i] == 4) continue;

        $name = time() . '_' . str_replace(' ', '_', $files['file']['name'][$i]);
        $name_xx = $files['file']['name'][$i];

        $_FILES['file']['name']     = $name;
        $_FILES['file']['type']     = $files['file']['type'][$i];
        $_FILES['file']['tmp_name'] = $files['file']['tmp_name'][$i];
        $_FILES['file']['error']    = $files['file']['error'][$i];
        $_FILES['file']['size']     = $files['file']['size'][$i];

        $this->load->library('upload');
        $this->upload->initialize($this->set_upload_options('../moc.mlejitoffice.id/upload/task_comment'));

        if ($this->upload->do_upload('file') && $_FILES['file']['error'] == 0) {
          // Masukkan nama file yang berhasil di-upload (menggunakan variabel $name yang sama)
          $arr_att[] = $name;
          $arr_name[] = $name_xx;
        }
      }

      // Isi data attachment jika ada file yang berhasil tersimpan
      if (!empty($arr_att)) {
        if ($this->upload->data()['file_size'] < 10000) {
          $data['attachment'] = implode(';', $arr_att);
          $data['attachment_name'] = implode(';', $arr_name);
        } else {
          echo "<script>alert('File Tidak boleh lebih dari 10Mb !');window.history.back();</script>";
          die;
        }
      }
    }

    $id_detail = $this->input->post('id_detail');
    // $get_task_detail = $this->db->query("SELECT * FROM task as a left join task_detail as b on(a.id=b.id_task) where b.id_detail='$id_detail'")->row_array();
    // $phone_x = explode(';', $get_task_detail['member']);


    $get_task_detail = $this->db->query("SELECT * FROM task_detail where id_detail='$id_detail'")->row_array();
    $phone_x = explode(';', $get_task_detail['responsible']);

    // var_dump($phone_x);
    // die();
    foreach ($phone_x as $k) { //member card kirim ke wa

      $get_user = $this->db->get_where('users', ['nip' => $k])->row_array();
      $task_name = $get_task_detail['task_name'];
      $nama_member = $get_user["nama"];
      $comment = $this->input->post("comment");
      $nama_session = $this->session->userdata('nama');
      $msg = "There's a new comment\nTask Name : *$task_name*\nComment : *$comment*\n\nComment from :  *$nama_session*";
      $utility = $this->db->get_where('utility', ['Id' => 1])->row_array();

      if ($utility['notif_wa'] == 1) {
        // $this->api_whatsapp->wa_notif($msg, $get_user['phone']);
      }
    }



    $this->db->insert('task_detail_comment', $data);

    // update task detail
    $this->db->set('read', '0');
    $this->db->where('id_detail', $id_detail);
    $this->db->update('task_detail');

    //Update Task
    $task_detail = $this->db->get_where('task_detail', ['id_detail' => $id_detail])->row();
    $task = $this->db->get_where('task', ['id' => $task_detail->id_task])->row();

    $this->db->set('read', '0');
    $this->db->where('id', $task->id);
    $this->db->update('task');


    redirect('mobile/task/task_view/' . $this->input->post('id_task') . '/' . $this->input->post('id_detail'));
  }

  public function set_upload_options($file_path)
  {
    // upload an image options
    $config = array();
    $config['upload_path'] = $file_path;
    $config['allowed_types'] = '*';
    $config['max_size'] = 10000;
    // $config ['encrypt_name'] = true;
    return $config;
  }

  public function update_task($id)
  {
    $a = $this->session->userdata('level');
    if (strpos($a, '601') !== false) {
      $project_name = htmlspecialchars($this->input->post('project_name'), ENT_QUOTES, 'UTF-8');
      $activity = $this->input->post('activity');
      $member_name = $this->input->post('member_task[]');
      $comment = htmlspecialchars($this->input->post('comment'), ENT_QUOTES, 'UTF-8');

      $this->form_validation->set_rules('project_name', 'Project or task name', 'required|trim');
      $this->form_validation->set_rules('member_task[]', 'Member name', 'required');
      $this->form_validation->set_rules('activity', 'Activity', 'required|in_list[1,2,3]');
      $this->form_validation->set_error_delimiters('<span class="error text-danger">', '</span>');

      if ($this->form_validation->run() == FALSE) {
        $this->create_task($id);
      } else {
        date_default_timezone_set('Asia/Jakarta');

        // Simpan Project/ Project
        $member_task = '';
        $i = 0;
        if (!empty($member_name)) {
          foreach ($member_name as $value) {
            $member_task .= $value . ';';
            $get_member[] = $this->db->get_where('users', ['nip' => $value])->row_array();
            $phone_member[] = $get_member[$i]['phone'];
            $i++;
          }
        }
        $update = [
          'name' => $project_name,
          'member' => $member_task,
          'activity' => $activity,
          'comment' => $comment,
          'pic' => $this->session->userdata('nip')
        ];

        if ($activity == '3') {

          $this->db->where('id_task', $id);
          $this->db->where('activity', '1');
          $this->db->or_where('activity', '2');
          $cek_detail = $this->db->get('task_detail')->num_rows();

          if ($cek_detail) {
            $this->session->set_flashdata('forbidden', 'Project Still Have Active Task!');
            redirect('mobile/task/task');
            return;
          }

          $update['closed_date'] = date('Y-m-d');
        } else {
          $update['closed_date'] = null;
        }
        $this->db->where('id', $id);
        $this->db->update('task', $update);
        $last_id = $this->db->insert_id();

        // Alert berhasil insert
        $this->session->set_flashdata('success', 'Projectsuccessfully updated!');
        redirect('mobile/task/task');
      }
    } else {
      $this->session->set_flashdata('forbidden', 'Unauthorize Privilage!');
      redirect('mobile/task/task');
    }
  }

  public function card_edit()
  {
    $task_id = $this->uri->segment(4);
    $card_id = $this->uri->segment(5);
    $get_task = $this->db->get_where('task', ['id' => $task_id])->row_array();
    $data['task'] = $get_task['member'];
    $nip_task = explode(';', $get_task['member']);
    $this->db->where_in('nip', $nip_task);
    $data['ss'] = $this->db->get('users')->result();
    $data['row_edit'] = $this->db->get_where('task_detail', ['id_detail' => $card_id])->row_array();

    $this->load->view('mobile/Layouts/v_header');
    $this->load->view('mobile/task/v_create_card', $data);
    $this->load->view('mobile/Layouts/v_footer');
  }

  public function close_task()
  {
    $id = $this->uri->segment(3);
    // update task detail
    $this->db->where('id_task', $id);
    $this->db->set('activity', '3');
    $this->db->update('task_detail');

    // update task master
    $this->db->where('id', $id);
    $this->db->set('activity', '3');
    $this->db->update('task');
    $this->session->set_flashdata('success', 'Projectsuccessfully closed!');
    redirect('mobile/task/task_view/' . $id);
  }
}
