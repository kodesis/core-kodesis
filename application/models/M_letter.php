<?php if (!defined('BASEPATH')) exit('Hacking Attempt : Keluar dari sistem..!!');

class M_letter extends CI_Model
{
  public function __construct()
  {
    parent::__construct();
  }

  public function get_surat()
  {
    $nip = $this->session->userdata('nip');
    $sql = "SELECT letter.id as id_letter, letter.no_pengajuan, letter.nomor_surat, letter.jenis_surat, letter.date_created, letter.status_admin, letter.status_sm_corsec, letter.status_direksi, letter.file, letter.file_name, jenis_surat.*, perusahaan.perusahaan FROM letter LEFT JOIN jenis_surat ON jenis_surat.id = letter.jenis_surat LEFT JOIN perusahaan ON jenis_surat.company = perusahaan.kode WHERE letter.user = '$nip' ORDER BY letter.id DESC";
    return $this->db->query($sql);
  }

  public function get_surat_admin()
  {
    $nip = $this->session->userdata('nip');
    $sql = "SELECT letter.id as id_letter, letter.catatan, letter.no_pengajuan, letter.nomor_surat, letter.jenis_surat, letter.date_created, letter.status_admin, letter.status_sm_corsec, letter.status_direksi, letter.file, letter.file_name, jenis_surat.*, perusahaan.perusahaan FROM letter LEFT JOIN jenis_surat ON jenis_surat.id = letter.jenis_surat LEFT JOIN perusahaan ON jenis_surat.company = perusahaan.kode WHERE letter.user != '$nip' ORDER BY letter.id DESC";
    return $this->db->query($sql);
  }

  public function get_surat_smcorsec()
  {
    $nip = $this->session->userdata('nip');
    $sql = "SELECT letter.id as id_letter, letter.catatan, letter.no_pengajuan, letter.nomor_surat, letter.jenis_surat, letter.date_created, letter.status_admin, letter.status_sm_corsec, letter.status_direksi, letter.file, letter.file_name, jenis_surat.*, perusahaan.perusahaan FROM letter LEFT JOIN jenis_surat ON jenis_surat.id = letter.jenis_surat LEFT JOIN perusahaan ON jenis_surat.company = perusahaan.kode WHERE letter.user != '$nip' AND letter.status_admin = 1 ORDER BY letter.id DESC";
    return $this->db->query($sql);
  }

  public function get_surat_direksi()
  {
    $nip = $this->session->userdata('nip');
    $sql = "SELECT letter.id as id_letter, letter.catatan, letter.no_pengajuan, letter.nomor_surat, letter.jenis_surat, letter.date_created, letter.status_admin, letter.status_sm_corsec, letter.status_direksi, letter.file, letter.file_name, jenis_surat.*, perusahaan.perusahaan FROM letter LEFT JOIN jenis_surat ON jenis_surat.id = letter.jenis_surat LEFT JOIN perusahaan ON jenis_surat.company = perusahaan.kode WHERE letter.user != '$nip' AND letter.status_admin = 1 AND letter.direksi = $nip ORDER BY letter.id DESC";
    return $this->db->query($sql);
  }

  public function view_surat($id)
  {
    $sql = "SELECT letter.*, perusahaan.perusahaan, perusahaan.header, perusahaan.footer, jenis_surat.kode, jenis_surat.format, users.nama, users.nama_jabatan FROM letter LEFT JOIN jenis_surat ON jenis_surat.id = letter.jenis_surat RIGHT JOIN perusahaan ON jenis_surat.company = perusahaan.kode LEFT JOIN users ON letter.ttd = users.nip WHERE letter.id = '$id'";

    return $this->db->query($sql)->row_array();
  }

  public function count_admin()
  {
    $nip = $this->session->userdata('nip');
    $sql = "SELECT * FROM letter WHERE letter.status_admin = 0 AND letter.user != '$nip'";
    return $this->db->query($sql)->num_rows();
  }

  public function count_smcorsec()
  {
    $nip = $this->session->userdata('nip');
    $sql = "SELECT * FROM letter WHERE letter.status_admin = 1 AND letter.user != '$nip' AND letter.status_sm_corsec = 0";
    return $this->db->query($sql)->num_rows();
  }

  public function count_direksi()
  {
    $nip = $this->session->userdata('nip');
    $sql = "SELECT * FROM letter WHERE letter.status_admin = 1 AND letter.user != '$nip' AND letter.status_sm_corsec = 1 AND letter.direksi = '$nip' AND letter.status_direksi = 0";
    return $this->db->query($sql)->num_rows();
  }
}
