<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_pengajuan extends CI_Model
{

  public function __construct()
  {
    parent::__construct();
    $this->load->database();
  }

  public function simpan_pengajuan($insert)
  {
    $this->cb->insert('t_pengajuan', $insert);
    return $this->cb->insert_id();
  }

  public function simpan_detail_batch($items)
  {
    return $this->cb->insert_batch('t_pengajuan_detail', $items);
  }

  public function get_pengajuan($limit, $start, $search, $nip)
  {
    $this->cb->limit($limit, $start);
    $this->cb->like('kode', $search, 'both');
    $this->cb->where('user', $nip);
    $this->cb->order_by('no_pengajuan', 'DESC');
    return $this->cb->get('t_pengajuan')->result_array();
  }

  public function countPengajuanSpv($search)
  {
    $nip = $this->session->userdata('nip');
    $this->cb->select('a.Id, a.status, a.no_pengajuan, a.created_at, a.no_rekening, b.nama, a.total, a.status_spv, a.posisi, a.total_realisasi, a.catatan, a.bukti_pengajuan, a.bukti_bayar');
    $this->cb->from('t_pengajuan as a');
    $this->cb->join($this->db->database . '.users as b', 'a.user = b.nip');

    if ($search) {
      $this->cb->group_start();
      $this->cb->like('a.kode', $search, 'both');
      $this->cb->or_like('b.nama', $search, 'both');
      $this->cb->or_like('a.no_rekening', $search, 'both');
      $this->cb->or_like('a.catatan', $search, 'both');
      $this->cb->group_end();
    }

    $this->cb->where(['spv' => $nip, 'cabang' => $this->session->userdata('kode_cabang')]);
    return $this->cb->order_by('a.no_pengajuan', 'DESC')->get()->num_rows();
  }

  public function countPengajuanKeuangan($search, $filter)
  {
    $this->cb->select('a.Id, a.status, a.no_pengajuan, a.created_at, a.no_rekening, b.nama, a.total, a.status_keuangan, a.posisi');
    $this->cb->from('t_pengajuan as a');
    $this->cb->join($this->db->database . '.users as b', 'a.user = b.nip');
    if ($search) {
      $this->cb->like('a.kode', $search, 'both');
      $this->cb->or_like('b.nama', $search, 'both');
      $this->cb->or_like('a.no_rekening', $search, 'both');
    }

    if ($filter == 1) {
      $this->cb->where('posisi', "Diarahkan ke pembayaran");
    }

    if ($filter == 2) {
      $this->cb->where('posisi', "Sudah Dibayar");
    }

    if ($filter == 3) {
      $this->cb->order_by('created_at', 'DESC');
    }

    if ($filter == 4) {
      $this->cb->where('status_keuangan', 0);
    }

    $this->cb->where(['status_spv' => 1]);
    return $this->cb->get()->num_rows();
  }

  public function countListPengajuan($search)
  {
    $nip = $this->session->userdata('nip');
    $cabang = $this->session->userdata('kode_cabang');

    if (!$search) {
      $sql = "SELECT * FROM t_pengajuan WHERE user = '$nip' AND cabang = '$cabang'";
      return $this->cb->query($sql)->num_rows();
    } else {
      $sql = "SELECT * FROM t_pengajuan WHERE user = '$nip' AND cabang = '$cabang' AND t_pengajuan.kode LIKE '%$search%'";
      return $this->cb->query($sql)->num_rows();
    }
  }

  public function get_detail($id)
  {
    $this->cb->where('Id', $id);
    return $this->cb->get('t_pengajuan')->row_array();
  }

  public function count_spv($nip)
  {
    $this->cb->where(['spv' => $nip, 'status_spv' => 0, 'cabang' => $this->session->userdata('kode_cabang')]);
    return $this->cb->get('t_pengajuan');
  }

  public function count_keuangan()
  {
    $this->cb->where(['status_spv' => 1, 'status_keuangan' => 0, 'cabang' => $this->session->userdata('kode_cabang')]);
    return $this->cb->get('t_pengajuan');
  }

  public function approval_spv($limit, $start, $search, $nip)
  {
    $this->cb->select('a.Id, a.status, a.kode, a.no_pengajuan, a.tanggal, a.no_rekening, b.nama, a.total, a.status_spv, a.posisi, a.total_realisasi, a.catatan, a.bukti_pengajuan, a.bukti_bayar');
    $this->cb->from('t_pengajuan as a');
    $this->cb->join($this->db->database . '.users as b', 'a.user = b.nip');

    if ($search) {
      $this->cb->group_start();
      $this->cb->like('a.kode', $search, 'both');
      $this->cb->or_like('b.nama', $search, 'both');
      $this->cb->or_like('a.no_rekening', $search, 'both');
      $this->cb->or_like('a.catatan', $search, 'both');
      $this->cb->group_end();
    }

    $this->cb->where(['spv' => $nip, 'cabang' => $this->session->userdata('kode_cabang')]);
    return $this->cb->order_by('a.no_pengajuan', 'DESC')->limit($limit, $start)->get();
  }

  public function approval_keuangan($limit, $start, $search, $filter)
  {
    $this->cb->select('a.Id, a.status, a.status_spv,a.status_direksi, a.kode, a.tanggal, a.no_rekening, a.catatan, b.nama, a.total, a.status_keuangan, a.posisi');
    $this->cb->from('t_pengajuan as a');
    $this->cb->join($this->db->database . '.users as b', 'a.user = b.nip');

    if ($search) {
      $this->cb->like('a.kode', $search, 'both');
      $this->cb->or_like('b.nama', $search, 'both');
      $this->cb->or_like('a.no_rekening', $search, 'both');
    }

    if ($filter == 1) {
      $this->cb->where('posisi', "Diarahkan ke pembayaran");
    }

    if ($filter == 2) {
      $this->cb->where('posisi', "Sudah Dibayar");
    }

    if ($filter == 3) {
      $this->cb->order_by('created_at', 'DESC');
    }

    if ($filter == 4) {
      $this->cb->where('status_keuangan', 0);
    }

    $this->cb->where(['status_spv' => 1]);
    return $this->cb->order_by('a.no_pengajuan', 'DESC')->limit($limit, $start)->get();
  }

  public function approval_direksi($limit, $start, $search)
  {
    $this->cb->select('a.Id, a.status, a.kode, a.no_pengajuan, a.created_at, a.no_rekening, b.nama, a.total, a.status_keuangan, a.status_direksi, a.posisi, a.catatan, a.bukti_pengajuan');
    $this->cb->from('t_pengajuan as a');
    $this->cb->join($this->db->database . '.users as b', 'a.user = b.nip');
    if ($search) {
      $this->cb->group_start();
      $this->cb->like('a.kode', $search, 'both');
      $this->cb->or_like('b.nama', $search, 'both');
      $this->cb->or_like('a.no_rekening', $search, 'both');
      $this->cb->group_end();
    }

    $this->cb->where(['status_keuangan' => 1, 'jenis_pengajuan' => 1, 'direksi' => $this->session->userdata('nip')]);
    return $this->cb->order_by('a.no_pengajuan', 'DESC')->limit($limit, $start)->get();
  }

  public function countPengajuanDireksi($search)
  {

    $this->cb->select('a.Id, a.status, a.no_pengajuan, a.created_at, a.no_rekening, b.nama, a.total, a.status_keuangan, a.status_direksi, a.posisi');
    $this->cb->from('t_pengajuan as a');
    $this->cb->join($this->db->database . '.users as b', 'a.user = b.nip');
    if ($search) {
      $this->cb->group_start();
      $this->cb->like('a.kode', $search, 'both');
      $this->cb->or_like('b.nama', $search, 'both');
      $this->cb->or_like('a.no_rekening', $search, 'both');
      $this->cb->group_end();
    }

    $this->cb->where(['status_keuangan' => 1, 'jenis_pengajuan' => 1, 'direksi' => $this->session->userdata('nip')]);
    return $this->cb->get()->num_rows();
  }

  public function count_direksi($nip)
  {
    $this->cb->where(['status_keuangan' => 1, 'jenis_pengajuan' => 1, 'direksi' => $nip]);
    return $this->cb->get('t_pengajuan');
  }
}
