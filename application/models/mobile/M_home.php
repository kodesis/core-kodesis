<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_home extends CI_Model
{
    public function getData($table, $where)
    {
        if ($where != null) {
            $this->db->where($where);
        }
        return $this->db->get($table);
    }

    public function get_task_statistics()
    {
        $nip           = $this->session->userdata('nip');
        $today         = date('Y-m-d');
        $batas_tanggal = date('Y-m-d', strtotime('-7 days'));

        // 1. Inisialisasi struktur hasil untuk data diagram batang vertikal
        $stats = [
            'open'   => ['progress' => 0, 'overdue_1wk' => 0, 'overdue_1mo' => 0, 'overdue_gt_1mo' => 0, 'total' => 0],
            'closed' => ['progress' => 0, 'overdue_1wk' => 0, 'overdue_1mo' => 0, 'overdue_gt_1mo' => 0, 'total' => 0]
        ];

        // 2. Query data detail beserta status arsip dari tabel utama task
        $this->db->select("
        td.task_name,
        task.closed_date,
        td.activity,
        td.due_date,
        td.closed_on,
        DATEDIFF('{$today}', td.due_date) as selisih_hari
    ");
        $this->db->from('task_detail td');
        $this->db->join('task', 'task.id = td.id_task', 'inner');

        // 3. Filter Hak Akses NIP (Mencari di dalam semicolon-separated list)
        $this->db->group_start();
        $this->db->like('td.responsible', $nip);
        $this->db->or_like('td.member_detail', $nip);
        $this->db->group_end();

        $query = $this->db->get()->result();
        // return $query = $this->db->get()->result();


        // 4. Proses Pengelompokan Data
        foreach ($query as $row) {
            // Ambil nilai status text dan bersihkan formatnya ke lowercase
            $closed_status = !empty($row->closed_on) ? strtolower(trim($row->closed_on)) : '';

            // Penentuan Kategori Tab: Masuk CLOSED jika task utama ditutup ATAU detail ditandai selesai (activity = 3)
            $is_closed = ($row->closed_date !== NULL || $row->activity == '3' || $closed_status != '');

            if (!$is_closed) {
                // =========================================================================
                // TAB 1: LOGIKA OPEN TASKS (Mengacu pada hari ini)
                // =========================================================================
                $kategori = 'open';

                if ($row->activity == '1' && $row->due_date >= $today) {
                    $stats[$kategori]['progress']++;
                } elseif ($row->activity == '1' && $row->selisih_hari > 0 && $row->selisih_hari <= 7) {
                    $stats[$kategori]['overdue_1wk']++;
                } elseif ($row->activity == '1' && $row->selisih_hari > 7 && $row->selisih_hari <= 30) {
                    $stats[$kategori]['overdue_1mo']++;
                } elseif ($row->activity == '1' && $row->selisih_hari > 30) {
                    $stats[$kategori]['overdue_gt_1mo']++;
                } else {
                    $stats[$kategori]['progress']++;
                }
            } else {
                // =========================================================================
                // TAB 2: LOGIKA CLOSED TASKS (Mengacu pada history teks closed_on)
                // =========================================================================
                $kategori = 'closed';

                if (strpos($closed_status, 'progress') !== false || $closed_status == '') {
                    // Tepat waktu / Selesai saat progress
                    $stats[$kategori]['progress']++;
                } elseif (strpos($closed_status, 'overdue < 1') !== false || strpos($closed_status, 'ming') !== false) {
                    // Menangkap teks "Overdue < 1 Ming" yang terpotong di database
                    $stats[$kategori]['overdue_1wk']++;
                } elseif (strpos($closed_status, 'bulan') !== false || strpos($closed_status, '1 mo') !== false) {
                    // Terlambat kisaran 1 minggu - 1 bulan
                    $stats[$kategori]['overdue_1mo']++;
                } else {
                    // Terlambat lebih dari 1 bulan
                    $stats[$kategori]['overdue_gt_1mo']++;
                }
            }

            // Akumulasikan total baris yang masuk ke masing-masing kategori tab
            $stats[$kategori]['total']++;
        }

        return $stats;
    }
}
