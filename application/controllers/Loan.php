<?php if (!defined('BASEPATH')) exit('Hacking Attempt. Keluar dari sistem.');

class Loans extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->library(array('session'));
        $this->load->helper('url');
        $this->load->model('m_login');
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
            $this->load->view('home_view', $data);
        }
    }
}
