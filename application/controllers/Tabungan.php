<?php if (!defined('BASEPATH')) exit('Hacking Attempt. Keluar dari sistem.');

class Tabungan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->cb = $this->load->database('corebank', TRUE);
        $this->load->library(array('session'));
        $this->load->helper('url');
        $this->load->model('m_login');
        $this->load->model('tabungan_m', 'tabungan');
        $this->load->model('member_m', 'member');
        $this->load->database();
    }

    public function index()
    {
        if ($this->session->userdata('isLogin') == FALSE) {
            redirect('login/login_form');
        } else {
            $this->load->model('m_login');
            $user = $this->session->userdata('username');
            //$data['level'] = $this->session->userdata('level');        
            $data['pengguna'] = $this->m_login->dataPengguna($user);
            //$data['utility'] = $this->m_login->utility();
            //redirect('app/grab_project');
            $nip = $this->session->userdata('nip');
            $sql = "SELECT COUNT(Id) FROM memo WHERE (nip_kpd LIKE '%$nip%' OR nip_cc LIKE '%$nip%') AND (`read` NOT LIKE '%$nip%');";
            $query = $this->db->query($sql);
            $res2 = $query->result_array();
            $result = $res2[0]['COUNT(Id)'];

            $sql2 = "SELECT COUNT(Id) FROM memo WHERE (nip_kpd LIKE '%$nip%' OR nip_cc LIKE '%$nip%') AND (`read` LIKE '%$nip%');";
            $sql3 = "SELECT COUNT(Id) FROM memo WHERE (nip_kpd LIKE '%$nip%' OR nip_cc LIKE '%$nip%');";

            $query2 = $this->db->query($sql2);
            $res3 = $query2->result_array();
            $result2 = $res3[0]['COUNT(Id)'];

            $query3 = $this->db->query($sql3)->result_array();
            $result3 = $query3[0]['COUNT(Id)'];

            $data['total'] = $result3;
            $data['count_inbox'] = $result;
            $data['read_inbox'] = $result2;

            $sql4 = "SELECT COUNT(id) FROM task WHERE (`member` LIKE '%$nip%' or `pic` like '%$nip%') and activity='1'";
            $query4 = $this->db->query($sql4);
            $res4 = $query4->result_array();
            $result4 = $res4[0]['COUNT(id)'];
            $data['count_inbox2'] = $result4;

            // $sql4 = "SELECT COUNT(id) FROM task WHERE (`member` LIKE '%$nip%' or `pic` like '%$nip%') and activity='1'";
            // $query4 = $this->db->query($sql4);
            // $res4 = $query4->result_array();
            // $result4 = $res4[0]['COUNT(id)'];
            // $data['count_inbox2'] = $result4;
            $this->load->view('tabungan_view', $data);
        }
    }
    public function ajax_list()
    {
        $this->load->model('tabungan_m', 'tabungan');

        $list = $this->tabungan->get_datatables();
        $data = array();
        $crs = "";
        $no = $_POST['start'];
        $months = [
            'Jan',
            'Feb',
            'Mar',
            'Apr',
            'Mei',
            'Jun',
            'Jul',
            'Agu',
            'Sep',
            'Okt',
            'Nov',
            'Des'
        ];

        foreach ($list as $cat) {

            $no++;
            $row = array();
            // $row[] = $no;
            $row[] = $cat->no_tabungan;
            // $row[] = $cat->no_cib;
            $row[] = $cat->nama;
            // $row[] = $cat->jenis_tabungan;
            $row[] = $cat->nama_tabungan;
            $row[] = $cat->status_tabungan;
            $row[] = $cat->no_urut;
            $row[] = $cat->nominal;
            $row[] = $cat->spread_rate;
            $row[] = $cat->nominal_blokir;
            $row[] = $cat->pos_rate;
            $row[] = $cat->nolsp;

            $row[] = '<center> <div class="list-icons d-inline-flex">
                <a title="Update User" href="' . base_url('tabungan/update/' . $cat->no_cib) . '" class="btn btn-warning"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit">
                                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                                    </svg></a>
                                                <a title="Delete User" onclick="onDelete(' . $cat->no_cib . ')" class="btn btn-danger"><svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                                                        <polyline points="3 6 5 6 21 6"></polyline>
                                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                        <line x1="10" y1="11" x2="10" y2="17"></line>
                                                        <line x1="14" y1="11" x2="14" y2="17"></line>
                                                    </svg></a>
            </div>
    </center>';
            // $row[] = $date->format('d') . ' ' . $months[$monthIndex] . ' ' . $date->format('Y');


            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->tabungan->count_all(),
            "recordsFiltered" => $this->tabungan->count_filtered(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function create()
    {
        if ($this->session->userdata('isLogin') == FALSE) {
            redirect('login/login_form');
        } else {
            $this->load->model('m_login');
            $user = $this->session->userdata('username');
            //$data['level'] = $this->session->userdata('level');        
            $data['pengguna'] = $this->m_login->dataPengguna($user);
            //$data['utility'] = $this->m_login->utility();
            //redirect('app/grab_project');
            $nip = $this->session->userdata('nip');
            $sql = "SELECT COUNT(Id) FROM memo WHERE (nip_kpd LIKE '%$nip%' OR nip_cc LIKE '%$nip%') AND (`read` NOT LIKE '%$nip%');";
            $query = $this->db->query($sql);
            $res2 = $query->result_array();
            $result = $res2[0]['COUNT(Id)'];

            $sql2 = "SELECT COUNT(Id) FROM memo WHERE (nip_kpd LIKE '%$nip%' OR nip_cc LIKE '%$nip%') AND (`read` LIKE '%$nip%');";
            $sql3 = "SELECT COUNT(Id) FROM memo WHERE (nip_kpd LIKE '%$nip%' OR nip_cc LIKE '%$nip%');";

            $query2 = $this->db->query($sql2);
            $res3 = $query2->result_array();
            $result2 = $res3[0]['COUNT(Id)'];

            $query3 = $this->db->query($sql3)->result_array();
            $result3 = $query3[0]['COUNT(Id)'];

            $data['total'] = $result3;
            $data['count_inbox'] = $result;
            $data['read_inbox'] = $result2;

            $sql4 = "SELECT COUNT(id) FROM task WHERE (`member` LIKE '%$nip%' or `pic` like '%$nip%') and activity='1'";
            $query4 = $this->db->query($sql4);
            $res4 = $query4->result_array();
            $result4 = $res4[0]['COUNT(id)'];
            $data['count_inbox2'] = $result4;

            // $sql4 = "SELECT COUNT(id) FROM task WHERE (`member` LIKE '%$nip%' or `pic` like '%$nip%') and activity='1'";
            // $query4 = $this->db->query($sql4);
            // $res4 = $query4->result_array();
            // $result4 = $res4[0]['COUNT(id)'];
            // $data['count_inbox2'] = $result4;
            $data['nasabah'] = $this->tabungan->get_nasabah();
            $data['tabungan'] = $this->tabungan->get_jenis_tabungan();
            $data['cabang'] = $this->member->get_cabang();

            $this->load->view('tabungan_form', $data);
        }
    }
    public function update($id)
    {

        if ($this->session->userdata('isLogin') == FALSE) {
            redirect('login/login_form');
        } else {
            $this->load->model('m_login');
            $user = $this->session->userdata('username');
            //$data['level'] = $this->session->userdata('level');        
            $data['pengguna'] = $this->m_login->dataPengguna($user);
            //$data['utility'] = $this->m_login->utility();
            //redirect('app/grab_project');
            $nip = $this->session->userdata('nip');
            $sql = "SELECT COUNT(Id) FROM memo WHERE (nip_kpd LIKE '%$nip%' OR nip_cc LIKE '%$nip%') AND (`read` NOT LIKE '%$nip%');";
            $query = $this->db->query($sql);
            $res2 = $query->result_array();
            $result = $res2[0]['COUNT(Id)'];

            $sql2 = "SELECT COUNT(Id) FROM memo WHERE (nip_kpd LIKE '%$nip%' OR nip_cc LIKE '%$nip%') AND (`read` LIKE '%$nip%');";
            $sql3 = "SELECT COUNT(Id) FROM memo WHERE (nip_kpd LIKE '%$nip%' OR nip_cc LIKE '%$nip%');";

            $query2 = $this->db->query($sql2);
            $res3 = $query2->result_array();
            $result2 = $res3[0]['COUNT(Id)'];

            $query3 = $this->db->query($sql3)->result_array();
            $result3 = $query3[0]['COUNT(Id)'];

            $data['total'] = $result3;
            $data['count_inbox'] = $result;
            $data['read_inbox'] = $result2;

            $sql4 = "SELECT COUNT(id) FROM task WHERE (`member` LIKE '%$nip%' or `pic` like '%$nip%') and activity='1'";
            $query4 = $this->db->query($sql4);
            $res4 = $query4->result_array();
            $result4 = $res4[0]['COUNT(id)'];
            $data['count_inbox2'] = $result4;

            // $sql4 = "SELECT COUNT(id) FROM task WHERE (`member` LIKE '%$nip%' or `pic` like '%$nip%') and activity='1'";
            // $query4 = $this->db->query($sql4);
            // $res4 = $query4->result_array();
            // $result4 = $res4[0]['COUNT(id)'];
            // $data['count_inbox2'] = $result4;

            $data['nasabah'] = $this->tabungan->get_nasabah();
            $data['tabungan'] = $this->tabungan->get_jenis_tabungan();
            $data['cabang'] = $this->member->get_cabang();

            $data['detail'] = $this->tabungan->get_detail_id($id);

            $this->load->view('tabungan_form', $data);
        }
    }
    public function proses_tambah_tabungan()
    {
        $data_insert = array(
            'no_tabungan' => $this->input->post('no_tabungan'),
            'no_cib' => $this->input->post('no_cib'),
            'jenis_tabungan' => $this->input->post('jenis_tabungan'),
            'status_tabungan' => $this->input->post('status_tabungan'),
            'no_urut' => $this->input->post('no_urut'),
            'nominal' => $this->input->post('nominal'),
            'spread_rate' => $this->input->post('spread_rate'),
            'nominal_blokir' => $this->input->post('nominal_blokir'),
            'pos_rate' => $this->input->post('pos_rate'),
            'nolsp' => $this->input->post('nolsp'),
            'cabang' => $this->input->post('cabang'),
        );
        $this->cb->insert('t_tabungan', $data_insert);
        redirect('tabungan');
    }

    public function proses_update_tabungan()
    {

        $data_insert = array(
            'no_tabungan' => $this->input->post('no_tabungan'),
            'no_cib' => $this->input->post('no_cib'),
            'jenis_tabungan' => $this->input->post('jenis_tabungan'),
            'status_tabungan' => $this->input->post('status_tabungan'),
            'no_urut' => $this->input->post('no_urut'),
            'nominal' => $this->input->post('nominal'),
            'spread_rate' => $this->input->post('spread_rate'),
            'nominal_blokir' => $this->input->post('nominal_blokir'),
            'pos_rate' => $this->input->post('pos_rate'),
            'nolsp' => $this->input->post('nolsp'),
            'cabang' => $this->input->post('cabang'),
        );
        $this->cb->where('no_tabungan', $this->input->post('id_tabungan')); // Ensure to specify the record to update
        $this->cb->update('t_tabungan', $data_insert);
        redirect('tabungan');
    }

    public function delete()
    {
        $id = $this->input->post('id_delete');
        $this->tabungan->delete(array('no_cib' => $id));
        echo json_encode(array("status" => TRUE));
    }

    public function getNextTabunganNumber()
    {
        $this->load->model('Tabungan_m'); // Load your model
        $jenis_tabungan = $this->input->post('jenis_tabungan');

        if ($jenis_tabungan) {
            // Get the highest `no_urut` across all records
            $lastNoUrut = $this->Tabungan_m->getLastNoUrut();
            $lastNumber = $this->Tabungan_m->getLastNumber($jenis_tabungan);


            if ($lastNoUrut !== null && $lastNumber !== null) {
                // Remove the prefix and increment
                $numericPart = (int)substr($lastNumber, strlen($jenis_tabungan));
                $nextNumber = $numericPart + 1;

                // Format as: jenis_tabungan + zero-padded number
                $formattedNumber = $jenis_tabungan . str_pad(
                    $nextNumber,
                    4,
                    '0',
                    STR_PAD_LEFT
                );

                $nextNoUrut = $lastNoUrut + 1;

                // Combine `jenis_tabungan` with the incremented `no_urut`, formatted with leading zeros
                echo json_encode(['status' => true, 'no_tabungan' => $formattedNumber, 'no_urut' => $nextNoUrut]);
            } else if ($lastNoUrut !== null) {
                $formattedNumber = $jenis_tabungan . '0001';
                $nextNoUrut = $lastNoUrut + 1;
                echo json_encode(['status' => true, 'no_tabungan' => $formattedNumber, 'no_urut' => $nextNoUrut]);
            } else {
                // Start with `no_urut = 1` if no record exists
                $formattedNumber = $jenis_tabungan . '0001';
                echo json_encode(['status' => true, 'no_tabungan' => $formattedNumber, 'no_urut' => 1]);
            }
        } else {
            echo json_encode(['status' => false, 'message' => 'Jenis tabungan is required.']);
        }
    }
}
