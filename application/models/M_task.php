<?php if (!defined('BASEPATH')) exit('Hacking Attempt : Keluar dari sistem..!!');

class M_task extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }
    function sendto($level_jabatan, $bagian)
    {
        if ($level_jabatan == 2) {
            $sql = "SELECT * FROM users WHERE ((level_jabatan <= '$level_jabatan' AND bagian = '$bagian') OR (level_jabatan >= 1) and status = 1) ORDER BY level_jabatan DESC";
        } elseif ($level_jabatan == 3) {
            $sql = "SELECT * FROM users WHERE ((level_jabatan <= '$level_jabatan' AND bagian = '$bagian') OR (level_jabatan >= 1) and status = 1) AND level like '%601%' ORDER BY level_jabatan DESC";
        } elseif ($level_jabatan == 4) {
            $sql = "SELECT * FROM users WHERE ((level_jabatan <= '$level_jabatan' AND bagian = '$bagian') OR (level_jabatan >= 1) and status = 1) ORDER BY level_jabatan DESC";
        } elseif ($level_jabatan == 5 and $bagian <> 11) {
            $sql = "SELECT * FROM users WHERE level_jabatan >= 1 and status = 1 ORDER BY level_jabatan DESC";
        } elseif ($level_jabatan == 5 and $bagian == 11) {
            $sql = "SELECT * FROM users WHERE (level_jabatan >= 1 OR bagian = 4) and status = 1 ORDER BY level_jabatan DESC";
        } elseif ($level_jabatan == 6) {
            $sql = "SELECT * FROM users WHERE level_jabatan >= 1 and status = 1 ORDER BY level_jabatan DESC";
        } elseif ($level_jabatan == 1) {
            $sql = "SELECT * FROM users WHERE bagian = '$bagian' and status = 1 ORDER BY level_jabatan DESC";
        }
        $query = $this->db->query($sql);
        return $query->result();
    }

    // function task_get($limit, $start, $nip)
    // {
    //     // $xx = explode(';',$nip);
    //     //  $this->db->where('memnber',$x);
    //     // // }
    //     // // $this->db->limit($limit);
    //     // // $this->db->order_by($start);
    //     // $sql = $this->db->get('task');
    //     // $sql = "SELECT * FROM task limit ".$start. ", ".$limit." ";
    //     $pic = $this->session->userdata('nip');
    //     $sql = "SELECT * from task where member like '%$nip%' or pic like '%$pic%' ORDER BY activity asc , date_created desc limit " . $start . ", " . $limit;
    //     $query = $this->db->query($sql);
    //     return $query->result();
    // }
    // function task_count($nip)
    // {
    //     $sql = "SELECT id FROM task where member like '%$nip%' or pic like '%$nip%'";
    //     $query = $this->db->query($sql);
    //     return $query->num_rows();
    // }

    public function task_count($filter)
    {
        // 1. Hitung batas tanggal di PHP (Hari ini minus 7 hari)
        $batas_tanggal = date('Y-m-d', strtotime('-7 days'));
        $nip = $this->session->userdata('nip');
        $today = date('Y-m-d');

        $this->db->select('task.*');
        $this->db->from('task');

        // =========================================================================
        // PERBAIKAN FILTER TANGGAL: Lebih clean dan performant dibanding DATE_ADD
        // =========================================================================
        $this->db->group_start();
        $this->db->where('task.closed_date', NULL);
        $this->db->or_where('task.closed_date >=', $batas_tanggal);
        $this->db->group_end();

        // Filter Hak Akses (Member atau PIC)
        $this->db->group_start();
        $this->db->like('task.member', $nip);
        $this->db->or_like('task.pic', $nip);
        $this->db->group_end();

        // =========================================================================
        // PERBAIKAN SEARCH: Dibungkus group_start agar TIDAK merusak filter tanggal
        // =========================================================================
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('task.name', $search);
            $this->db->group_end();
        }

        // Logika Filter sub_sql (WHERE EXISTS)
        if (!empty($filter)) {
            $filter = strtolower($filter);
            $sub_sql = "SELECT 1 FROM task_detail td WHERE td.id_task = task.id";

            if ($filter == 'progress') {
                $sub_sql .= " AND td.activity = '1' AND td.due_date >= '{$today}'";
            } elseif ($filter == 'overdue') {
                $sub_sql .= " AND td.activity = '1' AND td.due_date < '{$today}'";
            } elseif ($filter == 'hold') {
                $sub_sql .= " AND td.activity = '2'";
            } elseif ($filter == 'closed') {
                $sub_sql .= " AND td.activity != '1' AND td.activity != '2'";
            }

            $this->db->where("EXISTS ({$sub_sql})", NULL, FALSE);
        }

        $this->db->order_by('task.activity', 'ASC');
        $this->db->order_by('task.date_created', 'DESC');

        return $this->db->count_all_results();
    }


    public function task_get($limit, $start, $filter)
    {
        // 1. Hitung batas tanggal di PHP (Hari ini minus 7 hari)
        $batas_tanggal = date('Y-m-d', strtotime('-7 days'));
        $nip = $this->session->userdata('nip');
        $today = date('Y-m-d');

        $this->db->select('task.*');
        $this->db->from('task');

        // =========================================================================
        // PERBAIKAN FILTER TANGGAL: Lebih clean dan performant dibanding DATE_ADD
        // =========================================================================
        $this->db->group_start();
        $this->db->where('task.closed_date', NULL);
        $this->db->or_where('task.closed_date >=', $batas_tanggal);
        $this->db->group_end();

        // Filter Hak Akses (Member atau PIC)
        $this->db->group_start();
        $this->db->like('task.member', $nip);
        $this->db->or_like('task.pic', $nip);
        $this->db->group_end();

        // =========================================================================
        // PERBAIKAN SEARCH: Dibungkus group_start agar TIDAK merusak filter tanggal
        // =========================================================================
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('task.name', $search);
            $this->db->group_end();
        }

        // Logika Filter sub_sql (WHERE EXISTS)
        if (!empty($filter)) {
            $filter = strtolower($filter);
            $sub_sql = "SELECT 1 FROM task_detail td WHERE td.id_task = task.id";

            if ($filter == 'progress') {
                $sub_sql .= " AND td.activity = '1' AND td.due_date >= '{$today}'";
            } elseif ($filter == 'overdue') {
                $sub_sql .= " AND td.activity = '1' AND td.due_date < '{$today}'";
            } elseif ($filter == 'hold') {
                $sub_sql .= " AND td.activity = '2'";
            } elseif ($filter == 'closed') {
                $sub_sql .= " AND td.activity != '1' AND td.activity != '2'";
            }

            $this->db->where("EXISTS ({$sub_sql})", NULL, FALSE);
        }

        $this->db->order_by('task.activity', 'ASC');
        $this->db->order_by('task.date_created', 'DESC');
        $this->db->limit($limit, $start);

        return $this->db->get()->result();
    }

    public function task_closed_count($filter)
    {
        // 1. Hitung batas tanggal di PHP (Hari ini minus 7 hari)
        $batas_tanggal = date('Y-m-d', strtotime('-7 days'));
        $nip = $this->session->userdata('nip');
        $today = date('Y-m-d');

        $this->db->select('task.*');
        $this->db->from('task');

        // =========================================================================
        // PERBAIKAN FILTER TANGGAL: Lebih clean dan performant dibanding DATE_ADD
        // =========================================================================
        $this->db->group_start();
        $this->db->where('task.activity', '3');
        $this->db->where('task.closed_date <', $batas_tanggal);
        $this->db->group_end();

        // Filter Hak Akses (Member atau PIC)
        $this->db->group_start();
        $this->db->like('task.member', $nip);
        $this->db->or_like('task.pic', $nip);
        $this->db->group_end();

        // =========================================================================
        // PERBAIKAN SEARCH: Dibungkus group_start agar TIDAK merusak filter tanggal
        // =========================================================================
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('task.name', $search);
            $this->db->group_end();
        }

        // Logika Filter sub_sql (WHERE EXISTS)
        if (!empty($filter)) {
            $filter = strtolower($filter);
            $sub_sql = "SELECT 1 FROM task_detail td WHERE td.id_task = task.id";

            if ($filter == 'progress') {
                $sub_sql .= " AND td.activity = '1' AND td.due_date >= '{$today}'";
            } elseif ($filter == 'overdue') {
                $sub_sql .= " AND td.activity = '1' AND td.due_date < '{$today}'";
            } elseif ($filter == 'hold') {
                $sub_sql .= " AND td.activity = '2'";
            } elseif ($filter == 'closed') {
                $sub_sql .= " AND td.activity != '1' AND td.activity != '2'";
            }

            $this->db->where("EXISTS ({$sub_sql})", NULL, FALSE);
        }

        $this->db->order_by('task.activity', 'ASC');
        $this->db->order_by('task.date_created', 'DESC');

        return $this->db->count_all_results();
    }


    public function task_closed_get($limit, $start, $filter)
    {
        // 1. Hitung batas tanggal di PHP (Hari ini minus 7 hari)
        $batas_tanggal = date('Y-m-d', strtotime('-7 days'));
        $nip = $this->session->userdata('nip');
        $today = date('Y-m-d');

        $this->db->select('task.*');
        $this->db->from('task');

        // =========================================================================
        // PERBAIKAN FILTER TANGGAL: Lebih clean dan performant dibanding DATE_ADD
        // =========================================================================
        $this->db->group_start();
        $this->db->where('task.activity', '3');
        $this->db->where('task.closed_date <', $batas_tanggal);
        $this->db->group_end();

        // Filter Hak Akses (Member atau PIC)
        $this->db->group_start();
        $this->db->like('task.member', $nip);
        $this->db->or_like('task.pic', $nip);
        $this->db->group_end();

        // =========================================================================
        // PERBAIKAN SEARCH: Dibungkus group_start agar TIDAK merusak filter tanggal
        // =========================================================================
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('task.name', $search);
            $this->db->group_end();
        }

        // Logika Filter sub_sql (WHERE EXISTS)
        if (!empty($filter)) {
            // $filter = strtolower($filter);
            // $sub_sql = "SELECT 1 FROM task_detail td WHERE td.id_task = task.id";

            // if ($filter == 'progress') {
            //   $sub_sql .= " AND td.activity = '1' AND td.due_date >= '{$today}'";
            // } elseif ($filter == 'overdue') {
            //   $sub_sql .= " AND td.activity = '1' AND td.due_date < '{$today}'";
            // } elseif ($filter == 'hold') {
            //   $sub_sql .= " AND td.activity = '2'";
            // } elseif ($filter == 'closed') {
            //   $sub_sql .= " AND td.activity != '1' AND td.activity != '2'";
            // }

            // $this->db->where("EXISTS ({$sub_sql})", NULL, FALSE);

            if ($filter == 'progress') {
                $this->db->where('task_detail.closed_on', 'On Progress');
            } elseif ($filter == 'overdue') {
                $this->db->like('task_detail.closed_on', 'Overdue');
            } elseif ($filter == 'hold') {
                $this->db->where('task_detail.activity', '2');
            } elseif ($filter == 'closed') {
                $this->db->where('task_detail.activity', '3');
            }
        }


        $this->db->join('task_detail', 'task_detail.id_task = task.id');
        $this->db->order_by('task.activity', 'ASC');
        $this->db->order_by('task.date_created', 'DESC');
        $this->db->limit($limit, $start);

        return $this->db->get()->result();
    }

    function task_cari_count($st, $nip)
    {
        if ($st == "NIL") $st = "";
        $sql = "SELECT id FROM task WHERE (name LIKE '%$st%' AND pic LIKE '%$nip%')";
        $query = $this->db->query($sql);
        return $query->num_rows();
    }
    function task_cari_pagination($limit, $start, $st = NULL, $nip = NULL)
    {
        if ($st == "NIL") $st = "";
        // $sql = "select a.id,a.nomor_memo,a.nip_kpd,a.judul,a.tanggal,a.read,a.nip_dari,b.nama
        // FROM memo a LEFT JOIN users b ON a.nip_dari = b.nip
        // WHERE (a.judul LIKE '%$st%' AND a.nip_kpd LIKE '%$nip%') ORDER BY a.tanggal DESC limit " . $start . ", " . $limit;
        // $query = $this->db->query($sql);
        // return $query->result();

        $sql = "SELECT * from task where name like '%$st%' and (member like '%$nip%' OR pic like '%$nip%') ORDER BY activity asc limit " . $start . ", " . $limit;
        $query = $this->db->query($sql);
        return $query->result();
    }
    function task_get_detail($id)
    {
        $nip = $this->session->userdata('nip');
        $sql = "SELECT task.read FROM task WHERE task.read NOT LIKE '%$nip%' OR task.id='$id'";
        $query = $this->db->query($sql);
        $result = $query->row();
        $kalimat = $result->read;

        if ($result) {
            $kalimat1 = $kalimat . ' ' . $nip;
            $data_update1    = array(
                'read'    => $kalimat1
            );
            $this->db->where('id', $id);
            $this->db->update('task', $data_update1);
        }

        $sql2 = "
            SELECT * FROM task where id='$id'";
        //$query = $this->db->query($sql);
        //return $query->result();
        $query = $this->db->query($sql2);
        return $query->row();
    }
}
