<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Task extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();

		//$this->load->model('m_login');
		$this->load->model('m_task');
		$this->load->library(array('form_validation', 'session', 'user_agent', 'Api_Whatsapp'));
		$this->load->library('pagination');
		$this->load->database();
		$this->load->helper('url', 'form', 'download');
	}

	public function task($filter = null)
	{
		if ($this->session->userdata('isLogin') == FALSE) {
			redirect('home');
		} else {
			$a = $this->session->userdata('level');
			if (strpos($a, '601') !== false) {
				if ($filter) {
					$config['base_url'] = base_url('task/task/' . $filter);
					$config['uri_segment'] = 4; // Bergeser ke segment 4 karena ada /task/task/status
				} else {
					$config['base_url'] = base_url('task/task');
					$config['uri_segment'] = 3;
				}

				// Kirim data filter ke view untuk keperluan tanda active di tombol jika perlu

				//pagination settings
				$config['base_url'] = site_url('task/task');
				// $config['total_rows'] = $this->m_task->task_count($this->session->userdata('nip'));
				$config['total_rows'] = $this->m_task->task_count($filter);
				$config['per_page'] = "10";
				$config["uri_segment"] = 3;
				$choice = $config["total_rows"] / $config["per_page"];
				//$config["num_links"] = floor($choice);
				$config["num_links"] = 10;
				// integrate bootstrap pagination
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
				$this->pagination->initialize($config);
				$data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
				// $data['users_data'] = $this->m_task->task_get($config["per_page"], $data['page'], $this->session->userdata('nip'));
				$data['users_data'] = $this->m_task->task_get($config['per_page'], $data['page'], $filter);
				$data['current_filter'] = $filter;

				$data['pagination'] = $this->pagination->create_links();

				//inbox notif
				$nip = $this->session->userdata('nip');
				$sql = "SELECT COUNT(Id) FROM memo WHERE (nip_kpd LIKE '%$nip%' OR nip_cc LIKE '%$nip%') AND (`read` NOT LIKE '%$nip%');";
				$query = $this->db->query($sql);
				$res2 = $query->result_array();
				$result = $res2[0]['COUNT(Id)'];
				$data['count_inbox'] = $result;

				$sql3 = "SELECT COUNT(id) FROM task WHERE (`member` LIKE '%$nip%' or `pic` like '%$nip%') and activity='1'";
				$query3 = $this->db->query($sql3);
				$res3 = $query3->result_array();
				$result3 = $res3[0]['COUNT(id)'];
				$data['count_inbox2'] = $result3;

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

				$this->load->view('task_list', $data);
			}
		}
	}
	public function task_closed($filter = null)
	{
		if ($this->session->userdata('isLogin') == FALSE) {
			redirect('home');
		} else {
			$a = $this->session->userdata('level');
			if (strpos($a, '601') !== false) {
				if ($filter) {
					$config['base_url'] = base_url('task/task/' . $filter);
					$config['uri_segment'] = 4; // Bergeser ke segment 4 karena ada /task/task/status
				} else {
					$config['base_url'] = base_url('task/task');
					$config['uri_segment'] = 3;
				}

				// Kirim data filter ke view untuk keperluan tanda active di tombol jika perlu

				//pagination settings
				$config['base_url'] = site_url('task/task');
				// $config['total_rows'] = $this->m_task->task_count($this->session->userdata('nip'));
				$config['total_rows'] = $this->m_task->task_closed_count($filter);
				$config['per_page'] = "10";
				$config["uri_segment"] = 3;
				$choice = $config["total_rows"] / $config["per_page"];
				//$config["num_links"] = floor($choice);
				$config["num_links"] = 10;
				// integrate bootstrap pagination
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
				$this->pagination->initialize($config);
				$data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
				// $data['users_data'] = $this->m_task->task_get($config["per_page"], $data['page'], $this->session->userdata('nip'));
				$data['users_data'] = $this->m_task->task_closed_get($config['per_page'], $data['page'], $filter);
				$data['current_filter'] = $filter;

				$data['pagination'] = $this->pagination->create_links();

				//inbox notif
				$nip = $this->session->userdata('nip');
				$sql = "SELECT COUNT(Id) FROM memo WHERE (nip_kpd LIKE '%$nip%' OR nip_cc LIKE '%$nip%') AND (`read` NOT LIKE '%$nip%');";
				$query = $this->db->query($sql);
				$res2 = $query->result_array();
				$result = $res2[0]['COUNT(Id)'];
				$data['count_inbox'] = $result;

				$sql3 = "SELECT COUNT(id) FROM task WHERE (`member` LIKE '%$nip%' or `pic` like '%$nip%') and activity='1'";
				$query3 = $this->db->query($sql3);
				$res3 = $query3->result_array();
				$result3 = $res3[0]['COUNT(id)'];
				$data['count_inbox2'] = $result3;

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

				$this->load->view('task_list', $data);
			}
		}
	}
	function card_edit()
	{
		$card_id = $this->uri->segment(3);
		$get_task = $this->db->query("SELECT * FROM task where id='$card_id'")->row_array();
		$data['task'] = $get_task['member'];
		$nip_task = explode(';', $get_task['member']);
		$this->db->where_in('nip', $nip_task);
		$data['ss'] = $this->db->get('users')->result();

		$data['row_edit'] = $this->db->get_where('task_detail', ['id_detail' => $this->uri->segment(4)])->result();
		//inbox notif
		$nip = $this->session->userdata('nip');
		$sql = "SELECT COUNT(Id) FROM memo WHERE (nip_kpd LIKE '%$nip%' OR nip_cc LIKE '%$nip%') AND (`read` NOT LIKE '%$nip%');";
		$query = $this->db->query($sql);
		$res2 = $query->result_array();
		$result = $res2[0]['COUNT(Id)'];
		$data['count_inbox'] = $result;

		$sql3 = "SELECT COUNT(id) FROM task WHERE (`member` LIKE '%$nip%' or `pic` like '%$nip%') and activity='1'";
		$query3 = $this->db->query($sql3);
		$res3 = $query3->result_array();
		$result3 = $res3[0]['COUNT(id)'];
		$data['count_inbox2'] = $result3;

		$this->load->view('create_detail_task', $data);
	}
	public function task_cari()
	{
		if ($this->session->userdata('isLogin') == FALSE) {
			redirect('home');
		} else {
			$a = $this->session->userdata('level');
			if (strpos($a, '401') !== false) {
				// get search string
				$search = ($this->input->post("search")) ? $this->input->post("search") : "NIL";
				if ($search <> 'NIL') {
					$this->session->set_userdata('keyword', $search);
				}
				$search = ($this->uri->segment(3)) ? $this->uri->segment(3) : $search;
				$stringLink = str_replace(' ', '_', $search);
				// pagination settings
				$config = array();
				$config['base_url'] = site_url("task/task_cari/$stringLink");
				$config['total_rows'] = $this->m_task->task_cari_count($search, $this->session->userdata('nip'));
				$config['per_page'] = "10";
				$config["uri_segment"] = 4;
				$choice = $config["total_rows"] / $config["per_page"];
				//$config["num_links"] = floor($choice);
				$config["num_links"] = 10;

				// integrate bootstrap pagination
				$config['full_tag_open'] = '<ul class="pagination">';
				$config['full_tag_close'] = '</ul>';
				$config['first_link'] = false;
				$config['last_link'] = false;
				$config['first_tag_open'] = '<li>';
				$config['first_tag_close'] = '</li>';
				$config['prev_link'] = 'Prev';
				$config['prev_tag_open'] = '<li class="prev">';
				$config['prev_tag_close'] = '</li>';
				$config['next_link'] = 'Next';
				$config['next_tag_open'] = '<li>';
				$config['next_tag_close'] = '</li>';
				$config['last_tag_open'] = '<li>';
				$config['last_tag_close'] = '</li>';
				$config['cur_tag_open'] = '<li class="active"><a href="#">';
				$config['cur_tag_close'] = '</a></li>';
				$config['num_tag_open'] = '<li>';
				$config['num_tag_close'] = '</li>';
				$this->pagination->initialize($config);

				$data['page'] = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;

				// get books list
				$data['users_data'] = $this->m_task->task_cari_pagination($config["per_page"], $data['page'], $search, $this->session->userdata('nip'));
				$data['pagination'] = $this->pagination->create_links();

				//inbox notif
				$nip = $this->session->userdata('nip');
				$sql = "SELECT COUNT(Id) FROM memo WHERE (nip_kpd LIKE '%$nip%' OR nip_cc LIKE '%$nip%') AND (`read` NOT LIKE '%$nip%');";
				$query = $this->db->query($sql);
				$res2 = $query->result_array();
				$result = $res2[0]['COUNT(Id)'];
				$data['count_inbox'] = $result;

				$sql3 = "SELECT COUNT(id) FROM task WHERE (`member` LIKE '%$nip%' or `pic` like '%$nip%') and activity='1'";
				$query3 = $this->db->query($sql3);
				$res3 = $query3->result_array();
				$result3 = $res3[0]['COUNT(id)'];
				$data['count_inbox2'] = $result3;

				$this->load->view('task_list', $data);
			}
		}
	}
	public function task_view($id)
	{
		if ($this->session->userdata('isLogin') == FALSE) {
			redirect('home');
		} else {
			$a = $this->session->userdata('level');
			if (strpos($a, '601') !== false) {
				if ($this->uri->segment(3)) {
					$data['task'] = $this->m_task->task_get_detail($this->uri->segment(3));
					if (empty($data['task'])) {
						echo "<script>alert('Unauthorize Privilage!');window.history.back();</script>";
					} else {
						$uri = $this->uri->segment(3);
						$cek_detail = $this->db->get_where('task_detail', ['id_task' => $uri])->num_rows();
						if ($cek_detail == true) {
							//inbox notif
							$nip = $this->session->userdata('nip');
							$sql = "SELECT COUNT(Id) FROM memo WHERE (nip_kpd LIKE '%$nip%' OR nip_cc LIKE '%$nip%') AND (`read` NOT LIKE '%$nip%');";
							$query = $this->db->query($sql);
							$res2 = $query->result_array();
							$result = $res2[0]['COUNT(Id)'];
							$data['count_inbox'] = $result;

							$sql3 = "SELECT COUNT(id) FROM task WHERE (`member` LIKE '%$nip%' or `pic` like '%$nip%') and activity='1'";
							$query3 = $this->db->query($sql3);
							$res3 = $query3->result_array();
							$result3 = $res3[0]['COUNT(id)'];
							$data['count_inbox2'] = $result3;
							//update read warna merah

							// =========================================================================
							// LOGIKA BARU: CEK SEGMENT 4 (APAKAH ID DETAIL ATAU STATUS FILTER)
							// =========================================================================
							$segment_4 = $this->uri->segment(4);
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
									$task = $this->db->get_where('task', ['id' => $id])->row();
									$soeryo = '2146501';
									if ($soeryo != $this->session->userdata('nip') && $this->session->userdata('level_jabatan') <= '4' && $task->pic != $this->session->userdata('nip') && $detail_task_row->responsible != $this->session->userdata('nip') && !in_array($this->session->userdata('nip'), $data_nip_member)) {
										$this->session->set_flashdata('forbidden', "You are not responsible for this Task!");
										redirect('task/task_view/' . $id);
									}
								}
							}

							$this->db->where('b.id_task', $id);
							$this->db->from('task_detail as b');
							$this->db->join('users as a', 'a.nip=b.responsible');


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

							// $this->db->where('b.id_task', $this->uri->segment(3));
							// $this->db->from('users as a');
							// $this->db->join('task_detail as b', 'a.nip=b.responsible');
							// $this->db->order_by('activity', 'ASC');
							// $this->db->order_by('date_created', 'DESC');
							// $data['task_detail'] = $this->db->get()->result();

							$id_task = $this->uri->segment(3);
							$today = date('Y-m-d');

							// Query satu kali untuk menghitung semua status sekaligus (Lebih cepat & ringan)
							$counts = $this->db->select("
    COUNT(id_detail) as total_all,
    SUM(CASE WHEN activity = 1 AND due_date > '$today' THEN 1 ELSE 0 END) as total_progress,
    SUM(CASE WHEN activity = 2 THEN 1 ELSE 0 END) as total_hold,
    SUM(CASE WHEN activity = 1 AND due_date <= '$today' THEN 1 ELSE 0 END) as total_overdue,
    SUM(CASE WHEN activity = 3 THEN 1 ELSE 0 END) as total_closed,
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


							// if ($this->uri->segment(4)) {
							// 	$nip = $this->session->userdata('nip');
							// 	$id_detail = $this->uri->segment(4);
							// 	$sqlx = "SELECT task_detail.read FROM task_detail WHERE id_detail ='$id_detail'";
							// 	$queryxx = $this->db->query($sqlx);
							// 	$resultx = $queryxx->row();
							// 	$kalimat = $resultx->read;
							// 	if (preg_match("/$nip/i", $kalimat)) {
							// 	} else {
							// 		$kalimat1 = $kalimat . ' ' . $nip;
							// 		$data_update11	= array(
							// 			'read'	=> $kalimat1
							// 		);
							// 		$this->db->where('id_detail', $id_detail);
							// 		$this->db->update('task_detail', $data_update11);
							// 	}
							// }
							// if ($this->uri->segment(3)) {
							// 	$nip = $this->session->userdata('nip');
							// 	$id_detail = $this->uri->segment(3);
							// 	$sqlx = "SELECT task.read FROM task WHERE id ='$id_detail'";
							// 	$queryxx = $this->db->query($sqlx);
							// 	$resultx = $queryxx->row();
							// 	$kalimat = $resultx->read;
							// 	if (preg_match("/$nip/i", $kalimat)) {
							// 	} else {
							// 		$kalimat1 = $kalimat . ' ' . $nip;
							// 		$data_update11	= array(
							// 			'read'	=> $kalimat1
							// 		);
							// 		$this->db->where('id', $id_detail);
							// 		$this->db->update('task', $data_update11);
							// 	}
							// }

							$this->load->view('task_view', $data);
						} else {
							redirect('task/detail_task/' . $uri);
						}
					}
				} else {
					redirect('task/task');
				}
			}
		}
	}

	function close_task()
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
		redirect('task/task_view/' . $id);
	}

	function status_activity()
	{
		$id_task = $this->input->post('id_task');
		$data = [
			"activity" => $this->input->post('activity')
		];
		$this->db->where('id_detail', $this->input->post('id_detail'));
		$this->db->update('task_detail', $data);
		$status = $this->input->post('activity');
		//
		$id_detail = $this->input->post('id_detail');
		$get_task_detail = $this->db->query("SELECT * FROM task as a left join task_detail as b on(a.id=b.id_task) where b.id_detail='$id_detail'")->row_array();
		$phone_x = explode(';', $get_task_detail['member']);
		if ($status == '1') {
			$statusx = 'Open';
		} elseif ($status == '2') {
			$statusx = 'Pending';
		} else if ($status == '3') {
			$statusx = 'Close';
		}
		foreach ($phone_x as $k) { //member card kirim ke wa
			$get_user = $this->db->get_where('users', ['nip' => $k])->row_array();
			$task_name = $get_task_detail['task_name'];
			$nama_member = $get_user["nama"];
			$comment = $this->input->post("commentt");
			$nama_session = $this->session->userdata('nama');
			$msg = "There's a new comment\nCard Name : *$task_name*\nStatus : *$statusx*\n\nChange from :  *$nama_session*\n\n" . base_url();
			$utility = $this->db->get_where('utility', ['Id' => 1])->row_array();

			if ($utility['notif_wa'] == 1) {
				$this->api_whatsapp->wa_notif($msg, $get_user['phone']);
			}
		}


		$cek_activity_detail = $this->db->query("SELECT count(id_detail) as closed FROM task_detail where id_task='$id_task' and activity='3'")->row_array();
		$cek_activity_detail_total = $this->db->query("SELECT count(id_detail) as total FROM task_detail where id_task='$id_task'")->row_array();

		if ($cek_activity_detail['closed'] == $cek_activity_detail_total['total']) {
			$this->db->where('id', $id_task);
			$this->db->set('activity', '3');
			$this->db->update('task');
		}
		redirect('task/task_view/' . $id_task . '/' . $this->input->post('id_detail'));
	}

	function activity_comment()
	{
		$id = $this->input->post('id_detail');
		$comment = $this->input->post('commentt');

		if (!empty($_FILES['attach']['name'])) {
			$files = $_FILES['attach']['name'];
		} else {
			$files = [];
		}

		$this->form_validation->set_rules('commentt',  'Comment', 'required');

		if ($this->form_validation->run() == FALSE) {
			// $response = [
			// 	'success' => false,
			// 	'msg' => array_values($this->form_validation->error_array())[0]
			// ];
			echo "<script>alert('" . array_values($this->form_validation->error_array())[0] . "');window.history.back();</script>";
		} else {
			$filesCount = count($files);
			$uploadedFiles = [];
			$errors = [];
			$uploadedFileName = [];

			$hasFile = false;
			for ($i = 0; $i < $filesCount; $i++) {
				if ($files[$i] != '') {
					$hasFile = true;
					break;
				}
			}

			if ($hasFile) {
				$totalSize = 0;
				for ($i = 0; $i < $filesCount; $i++) {
					$totalSize += $_FILES['attach']['size'][$i];
				}

				if ($totalSize > 5 * 1024 * 1024) {
					// $response = [
					// 	'success' => FALSE,
					// 	'msg' => 'toal ukuran file tidak boleh lebih dari 15MB.'
					// ];
					echo "<script>alert('Total ukuran file tidak boleh lebih dari 5 MB');window.history.back();</script>";
					return;
				}

				for ($i = 0; $i < $filesCount; $i++) {
					$_FILES['file_temp']['name']     = $_FILES['attach']['name'][$i];
					$_FILES['file_temp']['type']     = $_FILES['attach']['type'][$i];
					$_FILES['file_temp']['tmp_name'] = $_FILES['attach']['tmp_name'][$i];
					$_FILES['file_temp']['error']    = $_FILES['attach']['error'][$i];
					$_FILES['file_temp']['size']     = $_FILES['attach']['size'][$i];

					$config['upload_path']   = './upload/task_comment';
					$config['allowed_types'] = '*';
					$config['max_size']      = 5120;
					// $config['encrypt_name']  = TRUE;

					$file_extension = pathinfo($_FILES['attach']['name'][$i], PATHINFO_EXTENSION);
					$custom_file_name[] = time() . '_' . $id . '-' . $i . '.' . $file_extension;
					$config['file_name'] = $custom_file_name[$i];
					$config['encrypt_name']  = FALSE; // Set to FALSE to use your custom file_name

					$this->load->library('upload', $config);

					if ($this->upload->do_upload('file_temp')) {
						$uploadData = $this->upload->data();
						$uploadedFiles[] = $uploadData['full_path'];
						$uploadedFileName[] = $uploadData['file_name'];
					} else {
						$errors[] = $this->upload->display_errors();
						break; // Stop dan batal jika ada gagal
					}
				}

				// Hapus file jika gagal
				if (!empty($errors)) {
					foreach ($uploadedFiles as $filePath) {
						if (file_exists($filePath)) {
							unlink($filePath);
						}
					}
					// $response = [
					// 	'success' => FALSE,
					// 	'msg' => 'Error : ' . $errors[0]
					// ];
					// echo json_encode($response);
					echo "<script>alert('Error : " . $errors[0] . "');window.history.back();</script>";
					// return;
				} else {
					$attach = implode(';', $uploadedFileName);
					$attach_name = implode(';', $files);
					$insert = [
						"id_task_detail" => $id,
						"comment_member" => $comment,
						"attachment" => $attach,
						"attachment_name" => $attach_name,
						"member" => $this->session->userdata('nip')
					];

					$this->db->insert('task_detail_comment', $insert);

					// update task detail
					$this->db->set('read', '0');
					$this->db->where('id_detail', $id);
					$this->db->update('task_detail');

					//Update Task
					$task_detail = $this->db->get_where('task_detail', ['id_detail' => $id])->row();
					$task = $this->db->get_where('task', ['id' => $task_detail->id_task])->row();

					$this->db->set('read', '0');
					$this->db->where('id', $task->id);
					$this->db->update('task');

					// $response = [
					// 	'success' => true,
					// 	'msg' => 'Success add activity!'
					// ];

					$id_detail = $this->input->post('id_detail');
					$get_task_detail = $this->db->query("SELECT * FROM task as a left join task_detail as b on(a.id=b.id_task) where b.id_detail='$id_detail'")->row_array();
					$phone_x = explode(';', $get_task_detail['member']);
					foreach ($phone_x as $k) { //member card kirim ke wa
						$get_user = $this->db->get_where('users', ['nip' => $k])->row_array();
						if ($get_user) {
							$task_name = $get_task_detail['task_name'];
							$comment = $this->input->post("commentt");
							$nama_session = $this->session->userdata('nama');
							$msg = "There's a new comment\nCard Name : *$task_name*\nComment : *$comment*\n\nComment from :  *$nama_session*\n\n" . base_url();
							$utility = $this->db->get_where('utility', ['Id' => 1])->row_array();

							if ($utility['notif_wa'] == 1) {
								$this->api_whatsapp->wa_notif($msg, $get_user['phone']);
							}
						}
					}

					echo "<script>alert('Tambah activity sukses!');window.location.href='" . base_url('task/task_view/') . $task_detail->id_task . "/" . $id . "';</script>";
				}
			} else {
				$insert = [
					"id_task_detail" => $id,
					"comment_member" => $comment,
					"member" => $this->session->userdata('nip')
				];

				$this->db->insert('task_detail_comment', $insert);

				// update task detail
				$this->db->set('read', '0');
				$this->db->where('id_detail', $id);
				$this->db->update('task_detail');

				//Update Task
				$task_detail = $this->db->get_where('task_detail', ['id_detail' => $id])->row();
				$task = $this->db->get_where('task', ['id' => $task_detail->id_task])->row();

				$this->db->set('read', '0');
				$this->db->where('id', $task->id);
				$this->db->update('task');

				$id_detail = $this->input->post('id_detail');
				$get_task_detail = $this->db->query("SELECT * FROM task as a left join task_detail as b on(a.id=b.id_task) where b.id_detail='$id_detail'")->row_array();
				$phone_x = explode(';', $get_task_detail['member']);
				foreach ($phone_x as $k) { //member card kirim ke wa
					$get_user = $this->db->get_where('users', ['nip' => $k])->row_array();
					if ($get_user) {
						$task_name = $get_task_detail['task_name'];
						$comment = $this->input->post("commentt");
						$nama_session = $this->session->userdata('nama');
						$msg = "There's a new comment\nCard Name : *$task_name*\nComment : *$comment*\n\nComment from :  *$nama_session*\n\n" . base_url();
						$utility = $this->db->get_where('utility', ['Id' => 1])->row_array();

						if ($utility['notif_wa'] == 1) {
							$this->api_whatsapp->wa_notif($msg, $get_user['phone']);
						}
					}
				}

				echo "<script>alert('Tambah activity sukses!');window.location.href='" . base_url('task/task_view/') . $task_detail->id_task . "/" . $id . "';</script>";
			}
		}
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
	function create_task()
	{
		if ($this->session->userdata('isLogin') == FALSE) {
			redirect('home');
		} else {
			$a = $this->session->userdata('level');
			$data['task_edit'] = $this->db->get_where('task', ['id' => $this->uri->segment(3)])->row_array();

			if (strpos($a, '601') !== false || $data['task_edit']['pic'] == $this->session->userdata('nip')) {
				$data['sendto'] = $this->m_task->sendto($this->session->userdata('level_jabatan'), $this->session->userdata('bagian'));


				//inbox notif
				$nip = $this->session->userdata('nip');
				$sql = "SELECT COUNT(Id) FROM memo WHERE (nip_kpd LIKE '%$nip%' OR nip_cc LIKE '%$nip%') AND (`read` NOT LIKE '%$nip%');";
				$query = $this->db->query($sql);
				$res2 = $query->result_array();
				$result = $res2[0]['COUNT(Id)'];
				$data['count_inbox'] = $result;

				$sql3 = "SELECT COUNT(id) FROM task WHERE (`member` LIKE '%$nip%' or `pic` like '%$nip%') and activity='1'";
				$query3 = $this->db->query($sql3);
				$res3 = $query3->result_array();
				$result3 = $res3[0]['COUNT(id)'];
				$data['count_inbox2'] = $result3;
				$this->load->view('create_task', $data);
			}
		}
	}
	public function save_task()
	{
		if ($this->session->userdata('isLogin') == FALSE) {
			redirect('home');
		} else {
			$a = $this->session->userdata('level');
			if (strpos($a, '601') !== false) {
				$this->form_validation->set_rules('project_name', 'project_name', 'required');
				$this->form_validation->set_rules('member_task[]', 'member_task', 'required');
				$this->form_validation->set_error_delimiters('<span class="error">', '</span>');
				if ($this->form_validation->run() == FALSE) {
					$this->session->set_userdata('msg', 'error2');
					redirect('task/create_task');
					// echo "<script>alert('error input!');window.location.href = '" . base_url() . "task/create_memo';</script>";
				} else {
					date_default_timezone_set('Asia/Jakarta');
					//simpan memo
					$member_task = '';
					$i = 0;
					if (!empty($this->input->post('member_task[]'))) {
						foreach ($this->input->post('member_task[]') as $value1) {
							$member_task .= $value1 . ';';
							$get_member[] = $this->db->get_where('users', ['nip' => $value1])->result_array();
							$phone_member[] = $get_member[$i][0]['phone'];
							$i++;
						}
					}

					$data_update1 	= array(
						'name'		=> $this->input->post('project_name'),
						'member'		=> $member_task,
						'activity'		=> '1',
						'comment' => $this->input->post('comment'),
						'pic' => $this->session->userdata('nip'),
						'date_created' => date('Y-m-d'),
						'read' => $this->session->userdata('nip'),
					);
					$this->session->set_userdata('member_task', $member_task);
					$this->db->insert('task', $data_update1);
					$last_id = $this->db->insert_id();
					$xx = $last_id;

					$nama_session = $this->session->userdata('nama');
					$project = $this->input->post('project_name');
					$msg = "There's a new task\nTask Name : *$project*\n\nCreated By :  *$nama_session*";

					foreach ($phone_member as $p) {
						$utility = $this->db->get_where('utility', ['Id' => 1])->row_array();

						if ($utility['notif_wa'] == 1) {
							$this->api_whatsapp->wa_notif($msg, $p);
						}
					}

					$this->session->set_userdata('msg_memo', $xx);
					if ($_FILES) {
						$countfiles = count(array_filter($_FILES['file']['name']));
					}



					$this->session->set_userdata('id_task', $xx);
					redirect('task/detail_task/' . $xx);
				}

				//reload Send Memo
				$data['sendto'] = $this->m_task->sendto($this->session->userdata('level_jabatan'), $this->session->userdata('bagian'));

				//inbox notif
				$nip = $this->session->userdata('nip');
				$sql = "SELECT COUNT(Id) FROM memo WHERE (nip_kpd LIKE '%$nip%' OR nip_cc LIKE '%$nip%') AND (`read` NOT LIKE '%$nip%');";
				$query = $this->db->query($sql);
				$res2 = $query->result_array();
				$result = $res2[0]['COUNT(Id)'];
				$data['count_inbox'] = $result;

				$this->load->view('create_task', $data);
			}
		}
	}
	function update_task()
	{
		if ($this->session->userdata('isLogin') == FALSE) {
			redirect('home');
		} else {
			$a = $this->session->userdata('level');
			if (strpos($a, '601') !== false) {
				$this->form_validation->set_rules('project_name', 'project_name', 'required');
				$this->form_validation->set_rules('member_task[]', 'member_task', 'required');
				$this->form_validation->set_error_delimiters('<span class="error">', '</span>');
				if ($this->form_validation->run() == FALSE) {
					$this->session->set_userdata('msg', 'error2');
					redirect('task/create_task');
					// echo "<script>alert('error input!');window.location.href = '" . base_url() . "task/create_memo';</script>";
				} else {
					date_default_timezone_set('Asia/Jakarta');
					//simpan memo
					$member_task = '';
					$nip_cc = '';
					// foreach ($this->input->post('project_name[]') as $value) 
					// {
					// $nip_kpd .= $value.';';
					// }
					if (!empty($this->input->post('member_task[]'))) {
						foreach ($this->input->post('member_task[]') as $value1) {
							$member_task .= $value1 . ';';
						}
					}

					$data_update1 	= array(
						'name'		=> $this->input->post('project_name'),
						'member'		=> $member_task,
						'activity'		=> $this->input->post('activity'),
						'pic' => $this->session->userdata('nip')
					);
					$id_edit = $this->input->post('id_edit');
					$this->session->set_userdata('member_task', $member_task);
					$this->db->where('id', $id_edit);
					$this->db->update('task', $data_update1);
					$last_id = $this->db->insert_id();
					$xx = $last_id;
					$this->session->set_userdata('msg_memo', $xx);
					if ($_FILES) {
						$countfiles = count(array_filter($_FILES['file']['name']));
					}

					$this->session->set_userdata('id_task', $xx);
					redirect('task/task');
				}

				//reload Send Memo
				$data['sendto'] = $this->m_task->sendto($this->session->userdata('level_jabatan'), $this->session->userdata('bagian'));

				//inbox notif
				$nip = $this->session->userdata('nip');
				$sql = "SELECT COUNT(Id) FROM memo WHERE (nip_kpd LIKE '%$nip%' OR nip_cc LIKE '%$nip%') AND (`read` NOT LIKE '%$nip%');";
				$query = $this->db->query($sql);
				$res2 = $query->result_array();
				$result = $res2[0]['COUNT(Id)'];
				$data['count_inbox'] = $result;

				$this->load->view('create_task', $data);
			}
		}
	}
	function get_detail_task()
	{
		$this->db->where('username !=', null, false);
		$this->db->where_in('nip', explode(';', $this->session->userdata('member_task')));
		$data = $this->db->get_where('users')->result();
		echo json_encode($data);
	}

	public function detail_task()
	{
		$id_task = $this->uri->segment(3);
		if ($id_task != null) {
			if ($this->session->userdata('isLogin') == FALSE) {
				redirect('home');
			} else {
				$a = $this->session->userdata('level');
				if (strpos($a, '601') !== false) {
					$get_task = $this->db->query("SELECT * FROM task where id='$id_task'")->row_array();
					$data['task'] = $get_task['member'];
					$nip_task = explode(';', $get_task['member']);
					$this->db->where_in('nip', $nip_task);
					$data['ss'] = $this->db->get('users')->result();
					// $data['detail_task'] = $this->db->query("SELECT * FROM users where nip in $nip_task ")->result();
					$this->session->set_userdata('member_task', $get_task['member']);
					//inbox notif
					$nip = $this->session->userdata('nip');
					$sql = "SELECT COUNT(Id) FROM memo WHERE (nip_kpd LIKE '%$nip%' OR nip_cc LIKE '%$nip%') AND (`read` NOT LIKE '%$nip%');";
					$query = $this->db->query($sql);
					$res2 = $query->result_array();
					$result = $res2[0]['COUNT(Id)'];
					$data['count_inbox'] = $result;

					$sql3 = "SELECT COUNT(id) FROM task WHERE (`member` LIKE '%$nip%' or `pic` like '%$nip%') and activity='1'";
					$query3 = $this->db->query($sql3);
					$res3 = $query3->result_array();
					$result3 = $res3[0]['COUNT(id)'];
					$data['count_inbox2'] = $result3;


					$this->load->view('create_detail_task', $data);
				}
			}
		} else {
			redirect('task/create_task');
		}
	}
	// public function save_detail_task()
	// {
	// 	$nip_session = $this->session->userdata('nip');
	// 	$user_session = $this->db->get_where('users', ['nip' => $nip_session])->row();
	// 	$id_task = $this->input->post('id_task');
	// 	$id_card = $this->input->post('id_card');
	// 	$total_row = count($this->input->post('row'));
	// 	if ($this->input->post('status') == 'edit') {
	// 		for ($i = 1; $i <= $total_row; $i++) {
	// 			$target_file = './upload/card_task/';
	// 			$target_file2 = './upload/task_comment/';

	// 			if ($_FILES['att' . $i]['name'][0] != "") {
	// 				$nama_filee = array();
	// 				for ($xx = 0; $xx < count($_FILES['att' . $i]['name']); $xx++) {
	// 					$newfilename = str_replace(' ', '', time() . '_' . $_FILES['att' . $i]['name'][$xx]);
	// 					move_uploaded_file($_FILES['att' . $i]["tmp_name"][$xx], $target_file2 . $newfilename);
	// 					$nama_filee[] = str_replace(' ', '', time() . '_' . $_FILES['att' . $i]['name'][$xx]);
	// 				}
	// 			} else {
	// 				$nama_filee = null;
	// 			}
	// 			if ($this->input->post('project_name' . $i) != '') {
	// 				// if (count($_FILES['att'.$i]['name']) >= 0) {
	// 				$file_i = implode(';', $nama_filee);
	// 				// }else{
	// 				// $file_i = null;
	// 				// }
	// 				$data = [
	// 					"id_task" => $this->input->post('id_task' . $i),
	// 					"task_name" => $this->input->post('project_name' . $i),
	// 					"responsible" => $this->input->post('member_task' . $i),
	// 					"description" => $this->input->post('description' . $i),
	// 					"start_date" => $this->input->post('start' . $i),
	// 					"due_date" => $this->input->post('end' . $i),
	// 					"activity" => $this->input->post('activity' . $i),
	// 					"attachment" => $file_i,
	// 					"read" => 0
	// 					// "comment" => $this->input->post('comment'.$i),
	// 				];
	// 				$this->db->where('id_detail', $id_card);
	// 				$this->db->update('task_detail', $data);

	// 				// update task 
	// 				$this->db->where('id', $id_task);
	// 				$this->db->update('task', ['read' => 0]);

	// 				//detail comment
	// 				$this->db->select_max('id_detail');
	// 				$id_task_detail = $this->db->get('task_detail')->row();
	// 				$comment_detail = [
	// 					"id_task_detail" => $id_task_detail->id_detail,
	// 					"comment_member" => $this->input->post('comment' . $i),
	// 					"attachment" => $file_i,
	// 					"attachment_name" => $file_i,
	// 					"member" => $this->session->userdata('nip')
	// 				];
	// 				$this->db->where('id_task_detail', $id_card);
	// 				$this->db->update('task_detail_comment', $comment_detail);
	// 			}
	// 		}
	// 		$this->session->set_flashdata('msg', 'success_edit');
	// 		// redirect('task/card_edit/' . $id_task . '/' . $id_card);
	// 		redirect('task/task_view/' . $id_task);
	// 	} else {
	// 		for ($i = 1; $i <= $total_row; $i++) {
	// 			$target_file = './upload/card_task/';
	// 			$target_file2 = './upload/task_comment/';


	// 			if ($_FILES['att' . $i]['name'][0] != "") {
	// 				$nama_filee = array();
	// 				for ($xx = 0; $xx < count($_FILES['att' . $i]['name']); $xx++) {
	// 					$newfilename = str_replace(' ', '', time() . '_' . $_FILES['att' . $i]['name'][$xx]);
	// 					move_uploaded_file($_FILES['att' . $i]["tmp_name"][$xx], $target_file2 . $newfilename);
	// 					$nama_filee[] = str_replace(' ', '', time() . '_' . $_FILES['att' . $i]['name'][$xx]);
	// 				}
	// 			} else {
	// 				$nama_filee = null;
	// 			}

	// 			if ($this->input->post('project_name' . $i) != '') {
	// 				$file_i = implode(';', $nama_filee);

	// 				$data = [
	// 					"id_task" => $this->input->post('id_task' . $i),
	// 					"task_name" => $this->input->post('project_name' . $i),
	// 					"responsible" => $this->input->post('member_task' . $i),
	// 					"description" => $this->input->post('description' . $i),
	// 					"start_date" => $this->input->post('start' . $i),
	// 					"due_date" => $this->input->post('end' . $i),
	// 					"activity" => $this->input->post('activity' . $i),
	// 					"attachment" => $file_i,
	// 					// "comment" => $this->input->post('comment'.$i),
	// 				];
	// 				$this->db->insert('task_detail', $data);
	// 				$this->db->select_max('id_detail');
	// 				$id_task_detail = $this->db->get('task_detail')->row();
	// 				$comment_detail = [
	// 					"id_task_detail" => $id_task_detail->id_detail,
	// 					"comment_member" => $this->input->post('comment' . $i),
	// 					"attachment" => $file_i,
	// 					"attachment_name" => $file_i,
	// 					"member" => $this->session->userdata('nip')
	// 				];
	// 				$this->db->insert('task_detail_comment', $comment_detail);
	// 			}

	// 			$task = $this->db->get_where('task', ['id' => $id_task])->row();
	// 			$nip_member = rtrim($task->member, ";");
	// 			$arr_member = explode(";", $nip_member);
	// 			$card_name = $this->input->post('project_name' . $i);
	// 			$task = $this->db->get_where('task', ['id' => $id_task])->row();

	// 			foreach ($arr_member as $value) {
	// 				$user = $this->db->get_where('users', ['nip' => $value])->row();
	// 				$msg = "There's a new card\nTask Name:*$task->name*\nCard Name : *$card_name*\n\nCreated By :  *$user_session->nama*";
	// 				$this->api_whatsapp->wa_notif($msg, $user->phone);
	// 			}
	// 		}
	// 		redirect('task/task_view/' . $id_card);
	// 	}
	// }

	public function save_detail_task()
	{
		$nip_session = $this->session->userdata('nip');
		$user_session = $this->db->get_where('users', ['nip' => $nip_session])->row();
		$id_task = $this->input->post('id_task');
		$id_card = $this->input->post('id_card');
		$total_row = count($this->input->post('row'));
		$card = $this->db->select('attachment')->from('task_detail')->where('id_detail', $id_card)->get()->row();
		if ($this->input->post('status') == 'edit') {
			$target_file = './upload/card_task/';
			$target_file2 = './upload/task_comment/';

			if ($_FILES['att']['name'][0] != "") {
				$nama_filee = array();
				for ($xx = 0; $xx < count($_FILES['att']['name']); $xx++) {
					$newfilename = str_replace(' ', '', time() . '_' . $_FILES['att']['name'][$xx]);
					move_uploaded_file($_FILES['att']["tmp_name"][$xx], $target_file2 . $newfilename);
					$nama_filee[] = str_replace(' ', '', time() . '_' . $_FILES['att']['name'][$xx]);
				}
				$file_i = implode(';', $nama_filee);
			} else {
				$file_i = $card->attachment;
			}
			if ($this->input->post('project_name') != '') {
				// if (count($_FILES['att'.$i]['name']) >= 0) {

				// }else{
				// $file_i = null;

				// }
				// Ambil & proses member_task lebih dulu, sebelum dipakai di $data
				$member_name = $this->input->post('member_task[]'); // array nip
				$member_task = ''; // string nip dipisah ";"
				$get_member = [];
				$phone_member = [];
				$i = 0;
				if (!empty($member_name)) {
					foreach ($member_name as $value) {
						$member_task .= $value . ';';
						$get_member[] = $this->db->get_where('users', ['nip' => $value])->row_array();
						$phone_member[] = $get_member[$i]['phone'];
						$i++;
					}
				}

				$data = [
					"id_task"      => $this->input->post('id_task'),
					"task_name"    => $this->input->post('project_name'),
					"responsible"  => $this->input->post('responsible_task'),
					"member_detail"       => rtrim($member_task, ';'), // <-- string, bukan array
					"description"  => $this->input->post('description'),
					"start_date"   => $this->input->post('start'),
					"due_date"     => $this->input->post('end'),
					"activity"     => $this->input->post('activity'),
					"attachment"   => $file_i,
					"read"         => $nip_session,
					"comment"      => $this->input->post('comment'),
				];
				// $data['member_detail'] = rtrim($member_task, ';');

				$this->db->where('id_detail', $id_card);
				$this->db->update('task_detail', $data);

				// update task 
				$this->db->where('id', $id_task);
				$this->db->update('task', ['read' => 0]);

				//detail comment
				// $this->db->select_max('id_detail');
				// $id_task_detail = $this->db->get('task_detail')->row();
				// $comment_detail = [
				// 	"id_task_detail" => $id_task_detail->id_detail,
				// 	// "comment_member" => $this->input->post('comment'),
				// 	"attachment" => $file_i,
				// 	"attachment_name" => $file_i,
				// 	"member" => $this->session->userdata('nip')
				// ];

				// $this->db->insert('task_detail_comment', $comment_detail);
			}

			$this->session->set_flashdata('msg', 'success_edit');
			// redirect('task/card_edit/' . $id_task . '/' . $id_card);
			redirect('task/task_view/' . $id_task);
		} else {

			$target_file = './upload/card_task/';
			$target_file2 = './upload/task_comment/';


			if ($_FILES['att']['name'][0] != "") {
				$nama_filee = array();
				for ($xx = 0; $xx < count($_FILES['att']['name']); $xx++) {
					$newfilename = str_replace(' ', '', time() . '_' . $_FILES['att']['name'][$xx]);
					move_uploaded_file($_FILES['att']["tmp_name"][$xx], $target_file2 . $newfilename);
					$nama_filee[] = str_replace(' ', '', time() . '_' . $_FILES['att']['name'][$xx]);
				}
			} else {
				$nama_filee[] = null;
			}

			if ($this->input->post('project_name') != '') {
				$file_i = implode(';', $nama_filee);

				// Ambil & proses member_task lebih dulu, sebelum dipakai di $data
				$member_name = $this->input->post('member_task[]'); // array nip
				$member_task = ''; // string nip dipisah ";"
				$get_member = [];
				$phone_member = [];
				$i = 0;
				if (!empty($member_name)) {
					foreach ($member_name as $value) {
						$member_task .= $value . ';';
						$get_member[] = $this->db->get_where('users', ['nip' => $value])->row_array();
						$phone_member[] = $get_member[$i]['phone'];
						$i++;
					}
				}

				$data = [
					"id_task"      => $this->input->post('id_task'),
					"task_name"    => $this->input->post('project_name'),
					"responsible"  => $this->input->post('responsible_task'),
					"member_detail"       => rtrim($member_task, ';'), // <-- string, bukan array
					"description"  => $this->input->post('description'),
					"start_date"   => $this->input->post('start'),
					"due_date"     => $this->input->post('end'),
					"activity"     => $this->input->post('activity'),
					"attachment"   => $file_i,
					"read"         => $nip_session,
					"comment"      => $this->input->post('comment'),
				];
				// $data['member_detail'] = rtrim($member_task, ';');

				$this->db->insert('task_detail', $data);
				// $this->db->select_max('id_detail');
				// $id_task_detail = $this->db->get('task_detail')->row();
				// $comment_detail = [
				// 	"id_task_detail" => $id_task_detail->id_detail,
				// 	"comment_member" => $this->input->post('comment'),
				// 	"attachment" => $file_i,
				// 	"attachment_name" => $file_i,
				// 	"member" => $this->session->userdata('nip')
				// ];
				// $this->db->insert('task_detail_comment', $comment_detail);
			}

			$task = $this->db->get_where('task', ['id' => $id_task])->row();
			// $nip_member = rtrim($task->member, ";");
			// $arr_member = explode(";", $nip_member);
			// $card_name = $this->input->post('project_name');
			// $task = $this->db->get_where('task', ['id' => $id_task])->row();

			$msg = "There's a new task\nProject Name:*$task->name*\nTask Name : *" . $this->input->post('project_name') . "*\n\nCreated By :  *$user_session->nama*";

			// foreach ($member_name as $value) {
			// 	$user = $this->db->get_where('users', ['nip' => $value])->row();
			// 	// $msg = "There's a new task\nProject Name:*$task->name*\nTask Name : *$card_name*\n\nCreated By :  *$user->nama*";
			// 	$utility = $this->db->get_where('utility', ['Id' => 1])->row_array();

			// 	if ($utility['notif_wa'] == 1) {
			// 		$this->api_whatsapp->wa_notif($msg, $user->phone);
			// 	}
			// }

			$user = $this->db->get_where('users', ['nip' => $this->input->post('responsible_task')])->row();
			$this->api_whatsapp->wa_notif($msg, $user->phone);

			foreach ($phone_member as $p) {
				$utility = $this->db->get_where('utility', ['Id' => 1])->row_array();

				if ($utility['notif_wa'] == 1) {
					$this->api_whatsapp->wa_notif($msg, $p);
				}
			}

			redirect('task/task_view/' . $id_card);
		}
	}
}
