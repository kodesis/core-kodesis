<?php

use HTMLtoOpenXML\Parser;
use PhpOffice\PhpWord\Element\TextRun;

defined('BASEPATH') or exit('No direct script access allowed');

class Letter extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('M_letter');
    $this->load->library(array('form_validation', 'session', 'user_agent', 'Api_Whatsapp'));
    $this->load->library('pagination');
    $this->load->database();
    $this->load->helper('url', 'form', 'download');
    date_default_timezone_set('Asia/Jakarta');

    if ($this->session->userdata('isLogin') == FALSE) {
      redirect('home');
    }
  }

  public function create()
  {
    $a = $this->session->userdata('level');
    if (strpos($a, '701') !== false) {
      //inbox notif
      $nip = $this->session->userdata('nip');
      $sql = "SELECT COUNT(Id) FROM memo WHERE (nip_kpd LIKE '%$nip%' OR nip_cc LIKE '%$nip%') AND (`read` NOT LIKE '%$nip%');";
      $sql2 = "SELECT * FROM asset_ruang";
      $sql3 = "SELECT * FROM asset_lokasi";
      $query = $this->db->query($sql);
      $query2 = $this->db->query($sql2);
      $query3 = $this->db->query($sql3);
      $res2 = $query->result_array();
      $asset_ruang = $query2->result();
      $asset_lokasi = $query3->result();
      $result = $res2[0]['COUNT(Id)'];
      $data['count_inbox'] = $result;
      $data['asset_ruang'] = $asset_ruang;
      $data['asset_lokasi'] = $asset_lokasi;

      // Tello
      $sql4 = "SELECT COUNT(Id) FROM task WHERE (`member` LIKE '%$nip%' or `pic` like '%$nip%') and activity='1'";
      $query4 = $this->db->query($sql4);
      $res4 = $query4->result_array();
      $result4 = $res4[0]['COUNT(Id)'];
      $data['count_inbox2'] = $result4;
      $this->db->where('company !=', 'BDL');
      $data['surat'] = $this->db->get('jenis_surat');
      $data['manager'] = $this->db->get_where('users', 'level_jabatan > 2');
      $this->load->view('letter_create', $data);
    } else {
      redirect('home');
    }
  }

  public function insert()
  {
    $nip = $this->session->userdata('nip');
    $surat = $this->input->post('surat');
    $manager = $this->input->post('manager');
    $lampiran = $this->input->post('lampiran');
    $perihal = $this->input->post('perihal');
    $kepada = $this->input->post('kepada');
    $isi = $this->input->post('isi');
    $alamat = $this->input->post('alamat');
    $alamat_surat = $this->input->post('alamat-surat');
    $catatan = $this->input->post('catatan');

    $this->form_validation->set_rules('surat', 'jenis surat', 'required', array(
      'required' => 'wajib diisi!'
    ));

    $this->form_validation->set_rules('alamat-surat', 'alamat surat', 'required|trim', array(
      'required' => 'wajib diisi!'
    ));

    $this->form_validation->set_rules('manager', 'yang akan ttd', 'required', array(
      'required' => 'wajib diisi!'
    ));

    $this->form_validation->set_rules('perihal', 'perihal', 'required|trim', array(
      'required' => 'wajib diisi!'
    ));

    $this->form_validation->set_rules('kepada', 'tujuan', 'required|trim', array(
      'required' => 'wajib diisi!'
    ));

    $this->form_validation->set_rules('isi', 'isi', 'required|trim', array(
      'required' => 'wajib diisi!'
    ));

    $this->form_validation->set_rules('alamat', 'alamat', 'required|trim', array(
      'required' => 'wajib diisi!'
    ));

    $this->form_validation->set_error_delimiters("<span class='text-danger'>", "</span>");

    if ($this->form_validation->run() == FALSE) {
      $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <strong>Warning!</strong> Mohon periksa kembali data anda!</div>
        ');
      $this->create();
    } else {
      $sql = "SELECT max(no_pengajuan) as maximal FROM letter";
      $data_letter = $this->db->query($sql)->row_array();
      // $count = $this->db->get('letter')->num_rows();
      $insert = [
        'no_pengajuan' => sprintf("%04d", $data_letter['maximal'] + 1),
        'jenis_surat' => $surat,
        'user' => $nip,
        'perihal' => $perihal,
        'kepada' => $kepada,
        'alamat' => $alamat,
        'isi' => $isi,
        'ttd' => $manager,
        'lampiran' => $lampiran,
        'alamat_surat' => $alamat_surat,
        'catatan' => $catatan
      ];

      $this->db->insert('letter', $insert);

      // Notif whatsapp
      $nama_session = $this->session->userdata('nama');
      $letter = $this->db->get_where('jenis_surat', ['id' => $surat])->row();
      $corsec = $this->db->get_where('users', ['bagian' => 17, 'level_jabatan <' => 3, 'status' => 1])->result();
      $msg = "*Pengajuan Surat*\n\nFrom: *$nama_session*\nJenis Surat: *$letter->nama*\nCompany: *$letter->company*\n\nMohon untuk segera diproses.";
      foreach ($corsec as $row) {
        $phone_corsec[] = $row->phone;
      }
      $send_notif = implode(',', $phone_corsec);
      $this->api_whatsapp->wa_notif($msg, $send_notif);

      $this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong>Success!</strong> Data berhasil diajukan kepada admin corsec!.
        </div>');
      redirect('letter/create');
    }
  }

  public function list()
  {

    if ($this->session->userdata('isLogin') == FALSE) {
      redirect('home');
    } else {
      $a = $this->session->userdata('level');
      if (strpos($a, '701') !== false) {
        //inbox notif
        $nip = $this->session->userdata('nip');
        $sql = "SELECT COUNT(Id) FROM memo WHERE (nip_kpd LIKE '%$nip%' OR nip_cc LIKE '%$nip%') AND (`read` NOT LIKE '%$nip%');";
        $sql2 = "SELECT * FROM asset_ruang";
        $sql3 = "SELECT * FROM asset_lokasi";
        $query = $this->db->query($sql);
        $query2 = $this->db->query($sql2);
        $query3 = $this->db->query($sql3);
        $res2 = $query->result_array();
        $asset_ruang = $query2->result();
        $asset_lokasi = $query3->result();
        $result = $res2[0]['COUNT(Id)'];
        $data['count_inbox'] = $result;
        $data['asset_ruang'] = $asset_ruang;
        $data['asset_lokasi'] = $asset_lokasi;

        // Tello
        $sql4 = "SELECT COUNT(Id) FROM task WHERE (`member` LIKE '%$nip%' or `pic` like '%$nip%') and activity='1'";
        $query4 = $this->db->query($sql4);
        $res4 = $query4->result_array();
        $result4 = $res4[0]['COUNT(Id)'];
        $data['count_inbox2'] = $result4;

        $data['surat'] = $this->M_letter->get_surat();
        $data['count_admin'] = $this->M_letter->count_admin();
        $data['count_smcorsec'] = $this->M_letter->count_smcorsec();
        $data['count_direksi'] = $this->M_letter->count_direksi();
        $this->load->view('letter_list', $data);
      } else {
        redirect('home');
      }
    }
  }

  public function admin()
  {
    $a = $this->session->userdata('level');
    if (strpos($a, '702') !== false) {
      //inbox notif
      $nip = $this->session->userdata('nip');
      $sql = "SELECT COUNT(Id) FROM memo WHERE (nip_kpd LIKE '%$nip%' OR nip_cc LIKE '%$nip%') AND (`read` NOT LIKE '%$nip%');";
      $sql2 = "SELECT * FROM asset_ruang";
      $sql3 = "SELECT * FROM asset_lokasi";
      $query = $this->db->query($sql);
      $query2 = $this->db->query($sql2);
      $query3 = $this->db->query($sql3);
      $res2 = $query->result_array();
      $asset_ruang = $query2->result();
      $asset_lokasi = $query3->result();
      $result = $res2[0]['COUNT(Id)'];
      $data['count_inbox'] = $result;
      $data['asset_ruang'] = $asset_ruang;
      $data['asset_lokasi'] = $asset_lokasi;

      // Tello
      $sql4 = "SELECT COUNT(Id) FROM task WHERE (`member` LIKE '%$nip%' or `pic` like '%$nip%') and activity='1'";
      $query4 = $this->db->query($sql4);
      $res4 = $query4->result_array();
      $result4 = $res4[0]['COUNT(Id)'];
      $data['count_inbox2'] = $result4;

      $data['surat'] = $this->M_letter->get_surat_admin();
      $this->load->view('letter_admin', $data);
    } else {
      redirect('home');
    }
  }

  public function update_admin()
  {
    $a = $this->session->userdata('level');
    if (strpos($a, '702') !== false) {
      $id = $this->input->post('id_surat');
      $status = $this->input->post('status_surat');
      $catatan = $this->input->post('catatan');

      $letter = $this->db->get_where('letter', ['id' => $id])->row();
      $user = $this->db->get_where('users', ['nip' => $letter->user])->row();
      $jenis = $this->db->get_where('jenis_surat', ['id' => $letter->jenis_surat])->row();

      $this->form_validation->set_rules('status_surat', 'Status surat', 'required');

      if ($this->form_validation->run()) {
        $where =
          [
            'id' => $id,
          ];

        $update = [
          'admin' => $this->session->userdata('nip'),
          'status_admin' => $status,
          'date_admin' => date('Y-m-d H:i:s'),
          'catatan_admin' => $catatan
        ];

        $this->db->where($where);
        $this->db->update('letter', $update);


        // Notif Whatsapp
        if ($status == 1) {
          $s = 'Disetujui';
          $msgsm = "*Pengajuan Surat*\n\nFrom: *$user->nama*\nJenis Surat: *$jenis->nama*\nCompany: *$jenis->company*\n\nMohon untuk segera diproses.";
          // phone sm corsec
          $this->db->select('phone');
          $this->db->where(['bagian' => 17, 'status' => 1, 'level_jabatan' => 3]);
          $data = $this->db->get('users')->row();

          $this->api_whatsapp->wa_notif($msgsm, $data->phone);
        } else {
          $s = 'Ditolak';
        }

        $msguser = "*Notifikasi Surat*\n\nPengajuan surat anda sudah diproses oleh admin corsec dengan status *$s*.\n\nCatatan: $catatan";
        $this->api_whatsapp->wa_notif($msguser, $user->phone);
        $response = [
          'error' => false,
          'msg' => 'Status surat berhasil diubah!'
        ];
      } else {
        $response = [
          'error' => true,
          'msg' => "Status surat gagal diupdate!",
          'err_status' => form_error('status_surat'),
        ];
      }
      echo json_encode($response);
    } else {
      redirect('home');
    }
  }

  public function smcorsec()
  {
    $a = $this->session->userdata('level');
    if (strpos($a, '703') !== false) {
      //inbox notif
      $nip = $this->session->userdata('nip');
      $sql = "SELECT COUNT(Id) FROM memo WHERE (nip_kpd LIKE '%$nip%' OR nip_cc LIKE '%$nip%') AND (`read` NOT LIKE '%$nip%');";
      $sql2 = "SELECT * FROM asset_ruang";
      $sql3 = "SELECT * FROM asset_lokasi";
      $query = $this->db->query($sql);
      $query2 = $this->db->query($sql2);
      $query3 = $this->db->query($sql3);
      $res2 = $query->result_array();
      $asset_ruang = $query2->result();
      $asset_lokasi = $query3->result();
      $result = $res2[0]['COUNT(Id)'];
      $data['count_inbox'] = $result;
      $data['asset_ruang'] = $asset_ruang;
      $data['asset_lokasi'] = $asset_lokasi;

      // Tello
      $sql4 = "SELECT COUNT(Id) FROM task WHERE (`member` LIKE '%$nip%' or `pic` like '%$nip%') and activity='1'";
      $query4 = $this->db->query($sql4);
      $res4 = $query4->result_array();
      $result4 = $res4[0]['COUNT(Id)'];
      $data['count_inbox2'] = $result4;

      $data['surat'] = $this->M_letter->get_surat_smcorsec();
      $data['direksi'] = $this->db->get_where('users', 'level_jabatan >= 5');
      $this->load->view('letter_smcorsec', $data);
    } else {
      redirect('home');
    }
  }

  public function update_smcorsec()
  {
    $a = $this->session->userdata('level');
    if (strpos($a, '703') !== false) {
      $id = $this->input->post('id_surat');
      $status = $this->input->post('status_surat');
      $catatan = $this->input->post('catatan');
      $date = $this->input->post('date');

      $letter = $this->db->get_where('letter', ['id' => $id])->row_array();
      $user = $this->db->get_where('users', ['nip' => $letter['user']])->row_array();
      $array_bln = array(1 => "I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII");

      $this->form_validation->set_rules('status_surat', 'Status surat', 'required');

      if ($this->form_validation->run()) {
        if ($status == 1) {
          $surat = $this->db->get_where('letter', ['id' => $id])->row_array();
          $jenis_surat = $this->db->get_where('jenis_surat', ['id' => $surat['jenis_surat']])->row();

          $bln = $array_bln[date('n')];

          if (date('Y-m-d', strtotime($date)) == date('Y-m-d')) {
            $sql = "SELECT MAX(nomor) as maximal FROM letter LEFT JOIN jenis_surat ON letter.jenis_surat = jenis_surat.id WHERE jenis_surat.company = '$jenis_surat->company' AND YEAR(date_created) = YEAR(curdate()) AND letter.back_date = 0;";
            $result = $this->db->query($sql);
            if ($result->num_rows() > 0) {
              $res = $result->row_array();
              $nomor = $res['maximal'] + 1;
            } else {
              $nomor = 1;
            }

            $back_date = 0;
            $date_keluar = date('Y-m-d H:i:s');
            $nomor_surat = sprintf("%04d", $nomor + 100) . '/' . $jenis_surat->format . '/' . $bln . '/' . date('Y');
          } else {
            $sql = "SELECT MAX(nomor) as maximal FROM letter LEFT JOIN jenis_surat ON letter.jenis_surat = jenis_surat.id WHERE jenis_surat.company = '$jenis_surat->company' AND YEAR(date_created) = YEAR(curdate()) AND letter.back_date = 1;";
            $result = $this->db->query($sql);

            if ($result->num_rows() > 0) {
              $res = $result->row_array();
              $nomor = $res['maximal'] + 1;
            } else {
              $nomor = 1;
            }
            $back_date = 1;
            $date_keluar = $date;
            $nomor_surat = sprintf("%04d", $nomor) . '/' . $jenis_surat->format . '/' . $bln . '/' . date('Y');
          }

          $update = [
            'nomor' => $nomor,
            'nomor_surat' => $nomor_surat,
            'status_sm_corsec' => $status,
            'date_sm_corsec' => date('Y-m-d H:i:s'),
            'catatan_sm_corsec' => $catatan,
            'sm_corsec' => $this->session->userdata('nip'),
            'date_keluar' => $date_keluar,
            'back_date' => $back_date
          ];

          $msguser = "*Notifikasi Surat*\n\nPengajuan surat anda sudah diproses oleh Senior Manager Corsec dengan status *Disetujui*.\nNo. Surat: *$nomor_surat*\n\nCatatan: *$catatan*";
          $this->api_whatsapp->wa_notif($msguser, $user['phone']);
        } else {
          $nomor = 0;
          $nomor_surat = '';
          $update = [
            'nomor' => $nomor,
            'nomor_surat' => $nomor_surat,
            'status_sm_corsec' => $status,
            'date_sm_corsec' => date('Y-m-d H:i:s'),
            'catatan_sm_corsec' => $catatan,
            'sm_corsec' => $this->session->userdata('nip'),
          ];

          $msguser = "*Notifikasi Surat*\n\nPengajuan surat anda sudah diproses oleh Senior Manager Corsec dengan status *Ditolak*.\n\nCatatan: *$catatan*";
          $this->api_whatsapp->wa_notif($msguser, $user['phone']);
        }

        $where =
          [
            'id' => $id,
          ];

        $this->db->where($where);
        $this->db->update('letter', $update);

        $response = [
          'error' => false,
          'msg' => 'Status surat berhasil diubah!'
        ];
      } else {
        $response = [
          'error' => true,
          'msg' => "Status surat gagal diupdate!",
          'err_status' => form_error('status_surat'),
          'err_direksi' => form_error('direksi'),
        ];
      }
      echo json_encode($response);
    } else {
      redirect('home');
    }
  }

  // public function direksi()
  // {
  //   $nip = $this->session->userdata('nip');
  //   $user = $this->db->get_where('users', ['nip' => $nip])->row_array();

  //   if ($user['level_jabatan'] >= 5) {
  //     //inbox notif
  //     $nip = $this->session->userdata('nip');
  //     $sql = "SELECT COUNT(Id) FROM memo WHERE (nip_kpd LIKE '%$nip%' OR nip_cc LIKE '%$nip%') AND (`read` NOT LIKE '%$nip%');";
  //     $sql2 = "SELECT * FROM asset_ruang";
  //     $sql3 = "SELECT * FROM asset_lokasi";
  //     $query = $this->db->query($sql);
  //     $query2 = $this->db->query($sql2);
  //     $query3 = $this->db->query($sql3);
  //     $res2 = $query->result_array();
  //     $asset_ruang = $query2->result();
  //     $asset_lokasi = $query3->result();
  //     $result = $res2[0]['COUNT(Id)'];
  //     $data['count_inbox'] = $result;
  //     $data['asset_ruang'] = $asset_ruang;
  //     $data['asset_lokasi'] = $asset_lokasi;

  //     // Tello
  //     $sql4 = "SELECT COUNT(Id) FROM task WHERE (`member` LIKE '%$nip%' or `pic` like '%$nip%') and activity='1'";
  //     $query4 = $this->db->query($sql4);
  //     $res4 = $query4->result_array();
  //     $result4 = $res4[0]['COUNT(Id)'];
  //     $data['count_inbox2'] = $result4;

  //     $data['surat'] = $this->M_letter->get_surat_direksi();
  //     $this->load->view('letter_direksi', $data);
  //   } else {
  //     redirect('home');
  //   }
  // }

  // public function update_direksi()
  // {
  //   $id = $this->input->post('id_surat');
  //   $status = $this->input->post('status_surat');
  //   $catatan = $this->input->post('catatan');

  //   $letter = $this->db->get_where('letter', ['id' => $id])->row_array();
  //   $user = $this->db->get_where('users', ['nip' => $letter['user']])->row_array();

  //   $this->form_validation->set_rules('status_surat', 'Status surat', 'required');
  //   $array_bln = array(1 => "I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII");

  //   if ($this->form_validation->run()) {
  //     // Membuat nomor surat
  //     if ($status == 1) {
  //       $surat = $this->db->get_where('letter', ['id' => $id])->row_array();
  //       $jenis_surat = $this->db->get_where('jenis_surat', ['id' => $surat['jenis_surat']])->row();

  //       if ($surat['back_date'] == 0) {
  //         $sql = "SELECT MAX(nomor) as maximal FROM letter LEFT JOIN jenis_surat ON letter.jenis_surat = jenis_surat.id WHERE jenis_surat.company = '$jenis_surat->company' AND YEAR(date_created) = YEAR(curdate()) AND letter.back_date = 0;";
  //         $result = $this->db->query($sql);

  //         if ($result->num_rows() > 0) {
  //           $res = $result->row_array();
  //           $nomor = $res['maximal'] + 1;
  //         } else {
  //           $nomor = 1;
  //         }
  //         $bln = $array_bln[date('n')];
  //         $nomor_surat = sprintf("%04d", $nomor + 100) . '/' . $jenis_surat->format . '/' . $bln . '/' . date('Y');

  //         $update = [
  //           'nomor' => $nomor,
  //           'nomor_surat' => $nomor_surat,
  //           'status_direksi' => $status,
  //           'date_direksi' => date('Y-m-d H:i:s'),
  //           'catatan_direksi' => $catatan,
  //           'date_keluar' => date('Y-m-d H:i:s')
  //         ];
  //       } else {
  //         $sql = "SELECT MAX(nomor) as maximal FROM letter LEFT JOIN jenis_surat ON letter.jenis_surat = jenis_surat.id WHERE jenis_surat.company = '$jenis_surat->company' AND YEAR(date_created) = YEAR(curdate()) AND letter.back_date = 1;";
  //         $result = $this->db->query($sql);

  //         if ($result->num_rows() > 0) {
  //           $res = $result->row_array();
  //           $nomor = $res['maximal'] + 1;
  //         } else {
  //           $nomor = 1;
  //         }
  //         $bln = $array_bln[date('n')];
  //         $nomor_surat = sprintf("%04d", $nomor) . '/' . $jenis_surat->format . '/' . $bln . '/' . date('Y');
  //         $update = [
  //           'nomor' => $nomor,
  //           'nomor_surat' => $nomor_surat,
  //           'status_direksi' => $status,
  //           'date_direksi' => date('Y-m-d H:i:s'),
  //           'catatan_direksi' => $catatan,
  //         ];
  //       }

  //       $msguser = "*Notifikasi Surat*\n\nPengajuan surat anda sudah diproses oleh Direksi dengan status *Disetujui*.\nNo. Surat: *$nomor_surat*\n\nCatatan: *$catatan*";
  //       $this->api_whatsapp->wa_notif($msguser, $user['phone']);
  //     } else {
  //       $nomor = 0;
  //       $nomor_surat = '';
  //       $update = [
  //         'nomor' => $nomor,
  //         'nomor_surat' => $nomor_surat,
  //         'status_direksi' => $status,
  //         'date_direksi' => date('Y-m-d H:i:s'),
  //         'catatan_direksi' => $catatan,
  //       ];

  //       $msguser = "*Notifikasi Surat*\n\nPengajuan surat anda sudah diproses oleh Direksi dengan status *Ditolak*.\n\nCatatan: *$catatan*";
  //       $this->api_whatsapp->wa_notif($msguser, $user['phone']);
  //     }

  //     $where = [
  //       'id' => $id,
  //     ];

  //     $this->db->where($where);
  //     $this->db->update('letter', $update);

  //     $response = [
  //       'error' => false,
  //       'msg' => 'Status surat berhasil diubah!'
  //     ];
  //   } else {
  //     $response = [
  //       'error' => true,
  //       'msg' => "Status surat gagal diupdate!",
  //       'err_status' => form_error('status_surat'),
  //     ];
  //   }
  //   echo json_encode($response);
  // }

  public function review($id)
  {
    $data['surat'] = $this->M_letter->view_surat($id);
    $nip = $this->session->userdata('nip');
    $user = $this->db->get_where('users', ['nip' => $nip])->row_array();

    if (!$data['surat']) {
      echo "Data tidak ditemukan";
      return false;
    }

    if ($data['surat']['user'] != $nip) {
      if ($user['bagian'] == 17 or $user['level_jabatan'] >= 5) {
        $this->load->view('letter_review', $data);
      } else {
        redirect('letter/list');
      }
    } else {
      $this->load->view('letter_review', $data);
    }
  }

  public function view_qr($id)
  {
    $data['surat'] = $this->M_letter->view_surat($id);
    $nip = $this->session->userdata('nip');
    $user = $this->db->get_where('users', ['nip' => $nip])->row_array();

    if (!$data['surat']) {
      echo "Data tidak ditemukan";
      return false;
    }

    if ($user['bagian'] == 17) {
      $this->load->view('letter_review', $data);
    } else {
      echo "Access denied";
      return false;
    }
  }

  public function word($id)
  {
    $data['surat'] = $this->M_letter->view_surat($id);
    $nip = $this->session->userdata('nip');
    $user = $this->db->get_where('users', ['nip' => $nip])->row_array();

    if ($data['surat']['user'] != $nip) {
      if ($user['bagian'] == 17 or $user['level_jabatan'] >= 5) {
        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor(FCPATH . '/template/bandes.docx');
        $_ = $this->M_letter->view_surat($id);
        if ($_['date_keluar']) {
          $tgl = tgl_indo(date('Y-m-d', strtotime($_['date_keluar'])));
        } else {
          $tgl = "";
        }
        $parser = new Parser();
        \PhpOffice\PhpWord\Settings::setOutputEscapingEnabled(false);
        $perihal = $parser->fromHTML($_['perihal']);
        $kepada = $parser->fromHTML($_['kepada']);
        $lokasi = $parser->fromHTML($_['alamat']);
        $isi = $parser->fromHTML($_['isi']);
        $underline = new TextRun(array('underline' => 'single', 'bold' => true));

        $templateProcessor->setValues([
          'tempat'     => $_['alamat_surat'],
          'tanggal'   => $tgl,
          'no_surat'  => $_['nomor_surat'],
          'lampiran'  => $_['lampiran'],
          'perihal'  => $perihal,
          'kepada'  => $kepada,
          'lokasi'  => $lokasi,
          'isi'  => $isi,
          'ttd' => $_['nama'],
          'perusahaan' => $_['perusahaan'],
          'jabatan' => $_['nama_jabatan']
        ]);

        $templateProcessor->setImageValue('qrcode', base_url('app/qrcode_letter/' . $id));
        $templateProcessor->setComplexValue('ttd', $underline);

        \PhpOffice\PhpWord\Settings::setOutputEscapingEnabled(true);
        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document'); //mime type
        header('Content-Disposition: attachment;filename="' . $_['nomor_surat'] . '.docx"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache

        $templateProcessor->saveAs('php://output');
      } else {
        redirect('letter/list');
      }
    } else {
      $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor(FCPATH . '/template/bandes.docx');
      $_ = $this->M_letter->view_surat($id);
      if ($_['date_keluar']) {
        $tgl = tgl_indo(date('Y-m-d', strtotime($_['date_keluar'])));
      } else {
        $tgl = "";
      }
      $parser = new Parser();
      \PhpOffice\PhpWord\Settings::setOutputEscapingEnabled(false);
      $perihal = $parser->fromHTML($_['perihal']);
      $kepada = $parser->fromHTML($_['kepada']);
      $lokasi = $parser->fromHTML($_['alamat']);
      $isi = $parser->fromHTML($_['isi']);
      $underline = new TextRun(array('underline' => 'single', 'bold' => true));

      $templateProcessor->setValues([
        'tempat'     => $_['alamat_surat'],
        'tanggal'   => $tgl,
        'no_surat'  => $_['nomor_surat'],
        'lampiran'  => $_['lampiran'],
        'perihal'  => $perihal,
        'kepada'  => $kepada,
        'lokasi'  => $lokasi,
        'isi'  => $isi,
        'ttd' => $_['nama'],
        'perusahaan' => $_['perusahaan'],
        'jabatan' => $_['nama_jabatan']
      ]);

      $templateProcessor->setImageValue('qrcode', base_url('app/qrcode_letter/' . $id));

      $templateProcessor->setComplexValue('ttd', $underline);
      \PhpOffice\PhpWord\Settings::setOutputEscapingEnabled(true);
      header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document'); //mime type
      header('Content-Disposition: attachment;filename="' . $_['nomor_surat'] . '.docx"'); //tell browser what's the file name
      header('Cache-Control: max-age=0'); //no cache

      $templateProcessor->saveAs('php://output');
    }
  }

  public function update_user($id)
  {
    //inbox notif
    $nip = $this->session->userdata('nip');
    $sql = "SELECT COUNT(Id) FROM memo WHERE (nip_kpd LIKE '%$nip%' OR nip_cc LIKE '%$nip%') AND (`read` NOT LIKE '%$nip%');";
    $sql2 = "SELECT * FROM asset_ruang";
    $sql3 = "SELECT * FROM asset_lokasi";
    $query = $this->db->query($sql);
    $query2 = $this->db->query($sql2);
    $query3 = $this->db->query($sql3);
    $res2 = $query->result_array();
    $asset_ruang = $query2->result();
    $asset_lokasi = $query3->result();
    $result = $res2[0]['COUNT(Id)'];
    $data['count_inbox'] = $result;
    $data['asset_ruang'] = $asset_ruang;
    $data['asset_lokasi'] = $asset_lokasi;

    // Tello
    $sql4 = "SELECT COUNT(Id) FROM task WHERE (`member` LIKE '%$nip%' or `pic` like '%$nip%') and activity='1'";
    $query4 = $this->db->query($sql4);
    $res4 = $query4->result_array();
    $result4 = $res4[0]['COUNT(Id)'];
    $data['count_inbox2'] = $result4;

    $data['jenis_surat'] = $this->db->get('jenis_surat');
    $data['manager'] = $this->db->get_where('users', 'level_jabatan > 2');
    $data['letter'] = $this->db->get_where('letter', ['id' => $id])->row_array();
    $data['perusahaan'] = $this->db->get('perusahaan');

    $this->load->view('letter_create', $data);
  }

  public function update($id)
  {
    $surat = $this->input->post('surat');
    $alamat_surat = $this->input->post('alamat-surat');
    $manager = $this->input->post('manager');
    $lampiran = $this->input->post('lampiran');
    $perihal = $this->input->post('perihal');
    $kepada = $this->input->post('kepada');
    $isi = $this->input->post('isi');
    $alamat = $this->input->post('alamat');
    $catatan = $this->input->post('catatan');

    $this->form_validation->set_rules('surat', 'jenis surat', 'required', array(
      'required' => 'wajib diisi!'
    ));

    $this->form_validation->set_rules('manager', 'yang akan ttd', 'required', array(
      'required' => 'wajib diisi!'
    ));

    $this->form_validation->set_rules('perihal', 'perihal', 'required', array(
      'required' => 'wajib diisi!'
    ));

    $this->form_validation->set_rules('kepada', 'tujuan', 'required', array(
      'required' => 'wajib diisi!'
    ));

    $this->form_validation->set_rules('isi', 'isi', 'required', array(
      'required' => 'wajib diisi!'
    ));

    $this->form_validation->set_rules('alamat', 'alamat', 'required', array(
      'required' => 'wajib diisi!'
    ));

    $this->form_validation->set_rules('alamat-surat', 'alamat surat', 'required', array(
      'required' => 'wajib diisi!'
    ));

    $this->form_validation->set_error_delimiters("<span class='text-danger'>", "</span>");

    if ($this->form_validation->run() == FALSE) {
      $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <strong>Warning!</strong> Mohon periksa kembali data anda!</div>
        ');
      $this->create();
    } else {

      $where = ['id' => $id];

      $update = [
        'jenis_surat' => $surat,
        'perihal' => $perihal,
        'kepada' => $kepada,
        'alamat' => $alamat,
        'isi' => $isi,
        'ttd' => $manager,
        'lampiran' => $lampiran,
        'alamat_surat' => $alamat_surat,
        'status_admin' => 0,
        'status_sm_corsec' => 0,
        'status_direksi' => 0,
        'catatan' => $catatan
      ];

      $this->db->where($where);
      $this->db->update('letter', $update);
      $this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong>Success!</strong> Data berhasil diajukan ulang!.
        </div>');
      redirect('letter/create');
    }
  }

  public function upload_file()
  {

    $file = $_FILES['file']['name'];
    $id = $this->input->post('id_letter');

    $config['upload_path'] = './upload/letter/';
    $config['allowed_types'] = 'pdf';
    $config['max_size'] = '5120';
    $config['encrypt_name'] = TRUE;

    $this->load->library('upload', $config);
    if ($this->upload->do_upload('file')) {
      $where = [
        'id' => $id
      ];

      $upload = $this->upload->data();

      $update = [
        'file' => $file,
        'file_name' => $upload['file_name']
      ];

      $this->db->where($where);
      $this->db->update('letter', $update);

      $response = [
        'success' => true,
        'msg' => 'File berhasil diupload!'
      ];
    } else {
      $response = [
        'success' => false,
        'msg' => $this->upload->display_errors()
      ];
    }

    echo json_encode($response);
  }

  public function get_catatan()
  {
    $id = $this->input->post('id');
    $this->db->select('catatan, catatan_admin, catatan_sm_corsec, catatan_direksi');
    $letter = $this->db->get_where('letter', ['id' => $id])->row_array();

    echo json_encode($letter);
  }

  public function get_surat($id)
  {
    $letter = $this->db->get_where('letter', ['id' => $id])->row_array();
    $jenis = $this->db->get_where('jenis_surat', ['id' => $letter['jenis_surat']])->row_array();

    echo json_encode($jenis);
  }

  public function qrcode($id)
  {
    $this->load->view('letter-qrcode', ['id' => $id]);
  }

  public function report()
  {
    $a = $this->session->userdata('level');
    if (strpos($a, '702') !== false) {
      $bulan = $this->input->post('bulan');
      $perusahaan = $this->input->post('perusahaan');

      $sql = "SELECT letter.nomor_surat, jenis_surat.nama, jenis_surat.company,letter.user, letter.admin, letter.sm_corsec, letter.date_keluar, letter.file_name, letter.perihal FROM letter RIGHT JOIN jenis_surat ON letter.jenis_surat = jenis_surat.id RIGHT JOIN perusahaan ON perusahaan.kode = jenis_surat.company WHERE letter.date_keluar LIKE '%$bulan%' AND jenis_surat.company = '$perusahaan' AND letter.nomor_surat != ''";
      $letter = $this->db->query($sql)->result_array();

      echo '<table><tbody>';
      $no = 1;

      // include APPPATH . 'third_party/PHPExcel/PHPExcel.php';

      $excel = new PHPExcel();

      // Settingan awal fil excel

      $excel->getProperties()->setCreator('My Notes Code')
        ->setLastModifiedBy('Bangun Desa LogistIndo')
        ->setTitle("Report Letter")
        ->setSubject("Letter")
        ->setDescription("Report Pengajuan Surat")
        ->setKeywords("Report Letter");

      // Buat sebuah variabel untuk menampung pengaturan style dari header tabel
      $style_col = array(
        'font' => array('bold' => true), // Set font nya jadi bold
        'alignment' => array(
          'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
          'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
        ),
        'borders' => array(
          'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
          'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
          'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
          'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
        )
      );

      // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
      $style_row = array(
        'alignment' => array(
          'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
        ),
        'borders' => array(
          'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
          'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
          'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
          'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
        )
      );

      $excel->setActiveSheetIndex(0)->setCellValue('A1', "Report Pengajuan Surat");
      $excel->getActiveSheet()->mergeCells('A1:J1'); // Set Merge Cell pada kolom A1 sampai E1
      $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
      $excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
      $excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
      $excel->getActiveSheet()->getStyle('F1')->getAlignment()->setWrapText(true); // Set text wrapper
      $excel->getActiveSheet()->getStyle('H1')->getAlignment()->setWrapText(true); // Set text wrapper

      // Buat header tabel nya pada baris ke 3
      $excel->setActiveSheetIndex(0)->setCellValue('A3', "No.");
      $excel->setActiveSheetIndex(0)->setCellValue('B3', "No. Surat");
      $excel->setActiveSheetIndex(0)->setCellValue('C3', "Jenis Surat");
      $excel->setActiveSheetIndex(0)->setCellValue('D3', "Perusahaan");
      $excel->setActiveSheetIndex(0)->setCellValue('E3', "User");
      $excel->setActiveSheetIndex(0)->setCellValue('F3', "Admin");
      $excel->setActiveSheetIndex(0)->setCellValue('G3', "SM Corsec");
      $excel->setActiveSheetIndex(0)->setCellValue('H3', "Tanggal Keluar");
      $excel->setActiveSheetIndex(0)->setCellValue('I3', "File Surat");
      $excel->setActiveSheetIndex(0)->setCellValue('J3', "Perihal");

      // Apply style header yang telah kita buat tadi ke masing-masing kolom header
      $excel->getActiveSheet()->getStyle('A3')->applyFromArray($style_col);
      $excel->getActiveSheet()->getStyle('B3')->applyFromArray($style_col);
      $excel->getActiveSheet()->getStyle('C3')->applyFromArray($style_col);
      $excel->getActiveSheet()->getStyle('D3')->applyFromArray($style_col);
      $excel->getActiveSheet()->getStyle('E3')->applyFromArray($style_col);
      $excel->getActiveSheet()->getStyle('F3')->applyFromArray($style_col);
      $excel->getActiveSheet()->getStyle('G3')->applyFromArray($style_col);
      $excel->getActiveSheet()->getStyle('H3')->applyFromArray($style_col);
      $excel->getActiveSheet()->getStyle('I3')->applyFromArray($style_col);
      $excel->getActiveSheet()->getStyle('J3')->applyFromArray($style_col);

      $no = 1; // Untuk penomoran tabel, di awal set dengan 1
      $i = 0;
      $numrow = 4; // Set baris pertama untuk isi tabel adalah baris ke 4
      foreach ($letter as $data) { // Lakukan looping pada variabel siswa

        // User 
        $query = "SELECT users.nama, users.nama_jabatan FROM users RIGHT JOIN cuti ON users.nip = '$data[user]'";
        $user = $this->db->query($query)->row_array();

        // Admin
        $query = "SELECT users.nama FROM users RIGHT JOIN cuti ON users.nip = '$data[admin]'";
        $admin = $this->db->query($query)->row_array();

        // SM Corsec
        $query = "SELECT users.nama FROM users RIGHT JOIN cuti ON users.nip = '$data[sm_corsec]'";
        $sm_corsec = $this->db->query($query)->row_array();

        $excel->setActiveSheetIndex(0)->setCellValue('A' . $numrow, $no);
        $excel->setActiveSheetIndex(0)->setCellValue('B' . $numrow, $data['nomor_surat']);
        $excel->setActiveSheetIndex(0)->setCellValue('C' . $numrow, $data['nama']);
        $excel->setActiveSheetIndex(0)->setCellValue('D' . $numrow, $data['company']);
        $excel->setActiveSheetIndex(0)->setCellValue('E' . $numrow, $user['nama']);
        $excel->setActiveSheetIndex(0)->setCellValue('F' . $numrow, $admin['nama']);
        $excel->setActiveSheetIndex(0)->setCellValue('G' . $numrow, $sm_corsec['nama']);
        $excel->setActiveSheetIndex(0)->setCellValue('H' . $numrow, $data['date_keluar']);
        $excel->setActiveSheetIndex(0)->setCellValue('I' . $numrow, $data['file_name'] ? 'File Surat' : '-');
        $excel->setActiveSheetIndex(0)->setCellValue('J' . $numrow, $data['perihal']);


        // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
        $excel->getActiveSheet()->getStyle('A' . $numrow)->applyFromArray($style_row);
        $excel->getActiveSheet()->getStyle('B' . $numrow)->applyFromArray($style_row);
        $excel->getActiveSheet()->getStyle('C' . $numrow)->applyFromArray($style_row);
        $excel->getActiveSheet()->getStyle('D' . $numrow)->applyFromArray($style_row);
        $excel->getActiveSheet()->getStyle('E' . $numrow)->applyFromArray($style_row);
        $excel->getActiveSheet()->getStyle('F' . $numrow)->applyFromArray($style_row);
        $excel->getActiveSheet()->getStyle('G' . $numrow)->applyFromArray($style_row);
        $excel->getActiveSheet()->getStyle('H' . $numrow)->applyFromArray($style_row);
        $excel->getActiveSheet()->getStyle('I' . $numrow)->applyFromArray($style_row);
        $excel->getActiveSheet()->getStyle('J' . $numrow)->applyFromArray($style_row);
        if ($data['file_name']) {
          $excel->getActiveSheet()->getCell('I' . $numrow)->getHyperlink()->setUrl(strip_tags(base_url('upload/letter/' . $data['file_name'])));
        }

        $no++; // Tambah 1 setiap kali looping
        $i++;
        $numrow++; // Tambah 1 setiap kali looping
      }
      // Set width kolom
      $excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true); // Set width kolom A
      $excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true); // Set width kolom B
      $excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true); // Set width kolom C
      $excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true); // Set width kolom D
      $excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true); // Set width kolom E
      $excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true); // Set width kolom E
      $excel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true); // Set width kolom E
      $excel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true); // Set width kolom E
      $excel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true); // Set width kolom E
      $excel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true); // Set width kolom E


      // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
      $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
      // Set orientasi kertas jadi LANDSCAPE
      $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
      // Set judul file excel nya
      $excel->getActiveSheet(0)->setTitle("Report Letter");
      $excel->setActiveSheetIndex(0);
      // Proses file excel
      // ob_end_clean();

      $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
      header("Content-type: application/vnd.ms-excel");
      header('Content-Disposition: attachment; filename="report-letter.xlsx"');
      header("Pragma: no-cache");
      header("Expires: 0");
      ob_end_clean();
      // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      // header('Content-Disposition: attachment; filename="Daftar Belanja.xlsx"'); // Set nama file excel nya
      // header('Cache-Control: max-age=0');
      $write->save('php://output');
    } else {
      redirect('home');
    }
  }
}
