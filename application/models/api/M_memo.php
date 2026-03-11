<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_memo extends CI_Model
{

    public function get_by_nip($nip, $limit, $start, $search)
    {
        $this->db->select('a.*,b.nama');
        $this->db->from('memo a');
        $this->db->join('users b', 'b.nip = a.nip_dari');

        if ($search) {
            $this->db->like('judul', $search);
        }

        $this->db->group_start();
        $this->db->like('nip_kpd', $nip);
        $this->db->or_like('nip_cc', $nip);
        $this->db->group_end();

        $this->db->order_by('tanggal', 'DESC');
        $this->db->limit($limit, $start);
        return $this->db->get()->result();
    }

    public function memo_count($nip, $search)
    {
        $this->db->select('a.*,b.nama');
        $this->db->from('memo a');
        $this->db->join('users b', 'b.nip = a.nip_dari');

        if ($search) {
            $this->db->like('judul', $search);
        }

        $this->db->group_start();
        $this->db->like('nip_kpd', $nip);
        $this->db->or_like('nip_cc', $nip);
        $this->db->group_end();

        return $this->db->get()->num_rows();
    }

    public function notif_memo_count($nip)
    {
        $sql = "SELECT Id FROM memo WHERE (nip_kpd LIKE '%$nip%' OR nip_cc LIKE '%$nip%') AND (`read` NOT LIKE '%$nip%');";
        $query = $this->db->query($sql);
        return $query->num_rows();
    }

    public function get_memo_detail($id, $nip)
    {
        $data = $this->db->select('a.*, b.nama_jabatan, b.nama, b.supervisi, c.kode_nama, b.level_jabatan')->from('memo a')->join('users b', 'a.nip_dari = b.nip')->join('bagian c', 'b.bagian = c.kode')->where('a.id', $id)->group_start()->like('a.nip_dari', $nip, 'both')->or_like('a.nip_kpd', $nip, 'both')->or_like('a.nip_cc', $nip, 'both')->group_end()->get();

        return $data->row();
    }

    public function sendto($level_jabatan, $bagian)
    {
        if ($level_jabatan == 2) {
            $sql = "SELECT * FROM users WHERE (status=1) AND ((level_jabatan <= '$level_jabatan' AND bagian = '$bagian') OR (level_jabatan >= '$level_jabatan')) ORDER BY level_jabatan DESC";
        } elseif ($level_jabatan == 3) {
            $sql = "SELECT * FROM users WHERE (status=1) AND ((level_jabatan <= '$level_jabatan' AND bagian = '$bagian') OR (level_jabatan >= 2)) ORDER BY level_jabatan DESC";
        } elseif ($level_jabatan == 4) {
            $sql = "SELECT * FROM users WHERE (status=1) AND ((level_jabatan <= '$level_jabatan' AND bagian = '$bagian') OR (level_jabatan >= 2)) ORDER BY level_jabatan DESC";
        } elseif ($level_jabatan == 5 and $bagian <> 11) {
            $sql = "SELECT * FROM users WHERE (status=1) AND level_jabatan >= 2 ORDER BY level_jabatan DESC";
        } elseif ($level_jabatan == 5 and $bagian == 11) {
            $sql = "SELECT * FROM users WHERE (status=1) AND (level_jabatan >= 2 OR bagian = 4) ORDER BY level_jabatan DESC";
        } elseif ($level_jabatan == 6) {
            $sql = "SELECT * FROM users WHERE (status=1) AND level_jabatan >= 2 ORDER BY level_jabatan DESC";
        } elseif ($level_jabatan == 1) {
            $sql = "SELECT * FROM users WHERE (status=1) AND bagian = '$bagian' ORDER BY level_jabatan DESC";
        }
        $query = $this->db->query($sql);
        return $query->result();
    }
}
