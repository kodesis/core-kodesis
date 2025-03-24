<?php if (!defined('BASEPATH')) exit('Hacking Attempt. Keluar dari sistem.');

class Member extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->cb = $this->load->database('corebank', TRUE);
        $this->load->library(array('session'));
        $this->load->helper('url');
        $this->load->model('m_login');
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
            $this->load->view('member_view', $data);
        }
    }
    public function ajax_list()
    {
        $this->load->model('member_m', 'member');

        $list = $this->member->get_datatables();
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
            $date1 = new DateTime($cat->tgl_lahir);
            $date2 = new DateTime($cat->tgl_pendaftaran);

            $no++;
            $row = array();
            // $row[] = $no;
            $row[] = $cat->nama;
            $row[] = $cat->alamat;
            $row[] = $cat->no_ktp;
            $row[] = $cat->no_telp;
            $row[] = $cat->ahli_waris;
            $row[] = $cat->kode_pos;
            $row[] = $cat->nama_ibu_kandung;
            $row[] = $cat->pekerjaan;
            // $row[] = $cat->kode_ao;
            $row[] = $cat->nama_ao;

            $monthIndex = (int) $date1->format('n') - 1; // Get the month index (0-based)
            $row[] = $date1->format('d') . ' ' . $months[$monthIndex] . ' ' . $date1->format('Y');
            $row[] = $cat->tempat_lahir;
            $row[] = $cat->nama_cabang;
            $row[] = $cat->kota;

            $monthIndex = (int) $date2->format('n') - 1; // Get the month index (0-based)
            $row[] = $date2->format('d') . ' ' . $months[$monthIndex] . ' ' . $date2->format('Y');
            // $row[] = $cat->tipe_nasabah;
            $row[] = $cat->nama_tipe;
            // $row[] = $cat->segmen_nasabah;
            $row[] = $cat->nama_segmen;
            $row[] = $cat->warga_negara;
            $row[] = $cat->no_cib;
            $row[] = '<center> <div class="list-icons d-inline-flex">
                <a title="Update User" href="' . base_url('member/update/' . $cat->no_cib) . '" class="btn btn-warning"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit">
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
            "recordsTotal" => $this->member->count_all(),
            "recordsFiltered" => $this->member->count_filtered(),
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
            $data['tipe'] = $this->member->get_tipe_nasabah();
            $data['segmen'] = $this->member->get_seg_nasabah();
            $data['karyawan'] = $this->member->get_karyawan();
            $data['cabang'] = $this->member->get_cabang();

            $this->load->view('member_form', $data);
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

            $data['tipe'] = $this->member->get_tipe_nasabah();
            $data['segmen'] = $this->member->get_seg_nasabah();
            $data['karyawan'] = $this->member->get_karyawan();
            $data['cabang'] = $this->member->get_cabang();

            $data['detail'] = $this->member->get_detail_id($id);

            $this->load->view('member_form', $data);
        }
    }
    public function proses_tambah_member()
    {
        $time =  Date('Y-m-d h:i:s');
        $data_insert = array(
            'nama' => $this->input->post('nama'),
            'alamat' => $this->input->post('alamat'),
            'no_ktp' => $this->input->post('no_ktp'),
            'no_telp' => $this->input->post('no_telp'),
            'ahli_waris' => $this->input->post('ahli_waris'),
            'kode_pos' => $this->input->post('kode_pos'),
            'nama_ibu_kandung' => $this->input->post('nama_ibu_kandung'),
            'pekerjaan' => $this->input->post('pekerjaan'),
            'kode_ao' => $this->input->post('kode_ao'),
            'nama_panggilan' => $this->input->post('nama_panggilan'),
            'tgl_lahir' => $this->input->post('tgl_lahir'),
            'tempat_lahir' => $this->input->post('tempat_lahir'),
            'kota' => $this->input->post('kota'),
            'cabang' => $this->input->post('cabang'),
            'tgl_pendaftaran' => $time,
            'tipe_nasabah' => $this->input->post('tipe_nasabah'),
            'segmen_nasabah' => $this->input->post('segmen_nasabah'),
            'warga_negara' => $this->input->post('warga_negara'),
            'no_cib' => $this->input->post('no_cib'),
        );
        $this->cb->insert('t_nasabah', $data_insert);
        redirect('member');
    }

    public function proses_update_member()
    {

        $data_insert = array(
            'nama' => $this->input->post('nama'),
            'alamat' => $this->input->post('alamat'),
            'no_ktp' => $this->input->post('no_ktp'),
            'no_telp' => $this->input->post('no_telp'),
            'ahli_waris' => $this->input->post('ahli_waris'),
            'kode_pos' => $this->input->post('kode_pos'),
            'nama_ibu_kandung' => $this->input->post('nama_ibu_kandung'),
            'pekerjaan' => $this->input->post('pekerjaan'),
            'kode_ao' => $this->input->post('kode_ao'),
            'nama_panggilan' => $this->input->post('nama_panggilan'),
            'tgl_lahir' => $this->input->post('tgl_lahir'),
            'tempat_lahir' => $this->input->post('tempat_lahir'),
            'kota' => $this->input->post('kota'),
            'cabang' => $this->input->post('cabang'),
            // 'tgl_pendaftaran' => $this->input->post('tgl_pendaftaran'),
            'tipe_nasabah' => $this->input->post('tipe_nasabah'),
            'segmen_nasabah' => $this->input->post('segmen_nasabah'),
            'warga_negara' => $this->input->post('warga_negara'),
            // 'no_cib' => $this->input->post('no_cib'),
        );
        $this->cb->where('no_cib', $this->input->post('id_member')); // Ensure to specify the record to update
        $this->cb->update('t_nasabah', $data_insert);
        redirect('member');
    }

    public function delete()
    {
        $id = $this->input->post('id_delete');
        $this->member->delete(array('no_cib' => $id));
        echo json_encode(array("status" => TRUE));
    }
}
