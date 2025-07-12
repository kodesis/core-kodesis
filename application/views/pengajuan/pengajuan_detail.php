<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php $setting = $this->db->get('setting')->result(); ?>

  <link rel="icon" href="<?= $this->session->userdata('icon') ?>" type="image/ico" />
  <title><?= $this->session->userdata('nama_singkat') ?> | Bussines Development</title>
  <!-- Bootstrap -->
  <link href="<?= base_url(); ?>src/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="<?= base_url(); ?>src/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <!-- NProgress -->
  <link href="<?= base_url(); ?>src/vendors/nprogress/nprogress.css" rel="stylesheet">
  <!-- iCheck -->
  <link href="<?= base_url(); ?>src/vendors/iCheck/skins/flat/green.css" rel="stylesheet">

  <!-- bootstrap-progressbar -->
  <link href="<?= base_url(); ?>src/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
  <!-- JQVMap -->
  <link href="<?= base_url(); ?>src/vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet" />
  <!-- bootstrap-daterangepicker -->
  <link href="<?= base_url(); ?>src/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
  <!-- Custom Theme Style -->
  <link href="<?= base_url(); ?>src/build/css/custom.min.css" rel="stylesheet">
  <!-- footer menu -->
  <link rel="stylesheet" href="<?= base_url(); ?>src/css/mobile_menu/header.css">
  <link rel="stylesheet" href="<?= base_url(); ?>src/css/mobile_menu/icons.css">

  <link href="<?= base_url(); ?>src/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
  <link href="<?= base_url(); ?>src/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
  <link href="<?= base_url(); ?>src/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
  <link href="<?= base_url(); ?>src/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
  <link href="<?= base_url(); ?>src/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">

  <!-- CKEditor -->
  <script type="text/javascript" src="<?= base_url(); ?>src/ckeditor/ckeditor.js"></script>

  <!-- jQuery -->
  <script src="<?= base_url(); ?>src/vendors/jquery/dist/jquery.min.js"></script>

  <!-- Select2 -->
  <link rel="stylesheet" href="<?= base_url(); ?>src/select2/css/select2.min.css">

  <style>
    .col-xs-3 {
      width: 25%;
      background-color: #004e81;
    }

    .row {
      margin-left: 0px;
    }

    .container-fluid {
      padding-right: 0px;
      padding-left: 0px
    }

    .btn_footer_panel .tag_ {
      padding-top: 37px;
    }
  </style>
</head>

<header class="header_area sticky-header">
  <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message_name') ?>"></div>
  <div class="flash-data-error" data-flashdata="<?= $this->session->flashdata('message_error') ?>"></div>
  <!-- footer menu -->
  <div class="footer_panel">
    <div class="container-fluid text-center">
      <div class="row">

        <div class="col-xs-3 btn_footer_panel">
          <a href="<?= base_url(); ?>app/create_memo">
            <i class="la-i la-i-m la-i-home"></i>
            <div class="tag_">
              <font color="white">Create</font>
            </div>
          </a>
        </div>
        <div class="col-xs-3 btn_footer_panel">
          <a href="<?= base_url(); ?>app/inbox">
            <i class="la-i la-i-m la-i-order"></i>
            <div class="tag_">
              <font color="white">Inbox</font>
            </div>
          </a>
        </div>
        <div class="col-xs-3 btn_footer_panel">
          <a href="<?= base_url(); ?>app/send_memo">
            <i class="la-i la-i-m la-i-notif"></i>
            <div class="tag_">
              <font color="white">Outbox</font>
            </div>
          </a>
        </div>
        <div class="col-xs-3 btn_footer_panel">
          <a href="<?= base_url(); ?>login/logout">
            <i class="la-i la-i-m la-i-akun"></i>
            <div class="tag_">
              <font color="white">Logout</font>
            </div>
          </a>
        </div>

      </div>
    </div>
  </div>
  <!-- footer menu -->
</header>

<body class="nav-md">
  <div class="container body">
    <div class="main_container">
      <div class="col-md-3 left_col">
        <div class="left_col scroll-view">
          <div class="navbar nav_title" style="border: 0;">
            <a href="<?php echo base_url(); ?>" class="site_title">
              <img src="<?= $this->session->userdata('icon') ?>" alt="..." width="60">
              <span><?= $this->session->userdata('nama_singkat') ?></span>
            </a>
          </div>

          <div class="clearfix"></div>

          <!-- menu profile quick info -->
          <div class="profile clearfix">
            <div class="profile_pic">
              <img src="<?= base_url(); ?>src/images/img.jpg" alt="..." class="img-circle profile_img">
            </div>
            <div class="profile_info">
              <span>Welcome,</span>
              <h2><?= $this->session->userdata('nama'); ?></h2>
            </div>
          </div>
          <!-- /menu profile quick info -->

          <br />

          <!-- sidebar menu -->
          <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <?php $this->load->view('side_menu.php'); ?>
          </div>
          <!-- /sidebar menu -->

          <!-- /menu footer buttons -->

          <!-- /menu footer buttons -->
        </div>
      </div>

      <!-- top navigation -->
      <div class="top_nav">
        <div class="nav_menu">
          <nav>
            <div class="nav toggle">
              <a id="menu_toggle"><i class="fa fa-bars"></i></a>
            </div>

            <ul class="nav navbar-nav navbar-right">
              <li class="">
                <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                  <img src="<?= base_url(); ?>src/images/img.jpg" alt=""><?= $this->session->userdata('nama'); ?>
                  <span class=" fa fa-angle-down"></span>
                </a>
                <ul class="dropdown-menu dropdown-usermenu pull-right">
                  <li><a href="javascript:;"> Profile</a></li>
                  <li>
                    <a href="javascript:;">
                      <span class="badge bg-red pull-right">50%</span>
                      <span>Settings</span>
                    </a>
                  </li>
                  <li><a href="javascript:;">Help</a></li>
                  <li><a href="<?= base_url(); ?>login/logout"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                </ul>
              </li>

              <li role="presentation" class="dropdown">
                <a href="<?= base_url() . "app/inbox"; ?>" class="dropdown-toggle info-number">
                  <i class="fa fa-envelope-o"></i>
                  <?php if ($count_inbox == 0) { ?>
                    <span class="badge bg-green"><?= $count_inbox; ?></span>
                  <?php } else { ?>
                    <span class="badge bg-red"><?= $count_inbox; ?></span>
                  <?php } ?>
                </a>
                <?php include APPPATH . 'views/notif_tello.php' ?>
            </ul>
          </nav>
        </div>
      </div>
      <!-- /top navigation -->

      <!-- page content -->
      <div class="right_col" role="main">
        <!--div class="pull-left">
				<font color='Grey'>Create New E-Memo </font>
			</div-->
        <div class="clearfix"></div>
        <!-- Start content-->
        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel card">
              <div class="x_title">
                <h2>Detail Pengajuan <?= $detail['kode'] ?></h2>
              </div>
              <div class="x_content">
                <a href="<?= base_url('pengajuan/approval_keuangan') ?>" class="btn btn-warning">Back</a>
                <?php if ($detail['posisi'] == "Diarahkan ke pembayaran" && $this->uri->segment(2) == 'bayar') { ?>
                  <form action="<?= base_url('pengajuan/update_bayar') ?>" method="post" enctype="multipart/form-data" id="update-bayar" style="width: 100%;">
                    <input type="hidden" name="id_pengajuan" id="id_pengajuan" value="<?= $detail['Id'] ?>">
                    <div class="table-responsive">
                      <table class="table table-bordered">
                        <thead>
                          <tr>
                            <th>Item</th>
                            <th>Total</th>
                            <th>COA Credit</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          $item = $this->cb->get_where('t_pengajuan_detail', ['no_pengajuan' => $detail['Id'], 'cabang' => $this->session->userdata('kode_cabang')])->result_array();
                          foreach ($item as $i) {
                          ?>
                            <input type="hidden" class="form-control" name="row_item[]" id="row<?= $i['Id'] ?>">
                            <input type="hidden" class="form-control" name="id_item[]" id="id_item<?= $i['Id'] ?>" value="<?= $i['Id'] ?>">
                            <tr>
                              <td><?= $i['item'] ?></td>
                              <td>
                                <input type="text" class="form-control" name="total_item[]" id="total_item<?= $i['Id'] ?>" value="<?= number_format($i['total']) ?>" readonly>
                              </td>
                              <td>
                                <select name="coa_credit[]" id="coa_credit<?= $i['Id'] ?>" class="form-control coa_credit<?= $i['Id'] ?>" style="width: 100%;">
                                  <option value=""> -- Pilih COA Credit -- </option>
                                  <?php foreach ($coa_credit as $c) { ?>
                                    <option value="<?= $c['no_sbb'] ?>"><?= $c['no_sbb'] . ' - ' . $c['nama_perkiraan'] ?></option>
                                  <?php } ?>
                                </select>
                                <!-- <div style="margin: 5px 0;"></div>
                                <input type="text" class="form-control" name="anggaran_credit[]" id="anggaran_credit<?= $i['Id'] ?>" readonly> -->
                              </td>
                            </tr>
                            <script>
                              $(document).ready(function() {
                                $('.coa_debit<?= $i['Id'] ?>').select2();
                                $('.coa_credit<?= $i['Id'] ?>').select2();
                              })
                            </script>
                          <?php } ?>
                          <tr>
                            <td><b>Total</b></td>
                            <td>
                              <input type="text" class="form-control" name="total_pengajuan[]" id="total_pengajuan" value="<?= number_format($detail['total']) ?>" readonly>
                            </td>
                            <td colspan="2"><?= terbilang($detail['total']) ?></td>
                          </tr>
                          <tr>
                            <td><b>Lampiran</b></td>
                            <td colspan="3"><a href="<?= base_url('upload/pengajuan/' . $detail['bukti_pengajuan']) ?>" class="btn btn-success btn-sm" target="_blank">Lampiran Pengajuan</a></td>
                          </tr>
                          <tr>
                            <td><b>Catatan User</b></td>
                            <td colspan="4"><?= $detail['catatan'] ?></td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                    <div class="row">
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                          <label for="rekening" class="form-label">No. Rekening</label>
                          <input type="text" class="form-control" name="rekening" id="rekening" value="<?= $detail['no_rekening'] ?>" readonly>
                        </div>
                        <div class="form-group">
                          <label for="pembayaran" class="form-label">Jenis Pembayaran</label>
                          <input type="text" class="form-control" name="rekening" id="rekening" value="<?= $detail['metode_pembayaran'] ?>" readonly>
                        </div>
                        <div class="form-group">
                          <?php if ($detail['status_keuangan'] == 0) { ?>
                            <label for="catatan" class="form-label">Catatan</label>
                            <textarea name="catatan" id="catatan" class="form-control"></textarea>
                          <?php } else if ($detail['status_keuangan'] == 1) { ?>
                            <label for="catatan" class="form-label">Catatan</label>
                            <textarea name="catatan" id="catatan" class="form-control" disabled><?= $detail['catatan_keuangan'] ?></textarea>
                          <?php } else { ?>
                            <label for="catatan" class="form-label">Catatan</label>
                            <textarea name="catatan" id="catatan" class="form-control" disabled><?= $detail['catatan_keuangan'] ?></textarea>
                          <?php } ?>
                        </div>
                      </div>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                          <label for="tanggal" class="form-label">Tanggal Bayar</label>
                          <?php if ($detail['date_bayar'] == null) { ?>
                            <input type="date" class="form-control" name="tanggal" id="tanggal" value="<?= date('Y-m-d') ?>">
                          <?php } else { ?>
                            <input type="date" class="form-control" name="tanggal" id="tanggal" value="<?= $detail['date_bayar'] ?>">
                          <?php } ?>
                        </div>
                        <div class="form-group">
                          <label for="status" class="form-label">Status Pengajuan</label>
                          <?php if ($detail['status_keuangan'] == 0) { ?>
                            <select name="status" id="status" class="form-control">
                              <option value="">:: Pilih Status ::</option>
                              <option value="1">Disetujui </option>
                              <option value="2">Ditolak </option>
                            </select>
                          <?php } else if ($detail['status_keuangan'] == 1) { ?>
                            <select name="status" id="status" class="form-control" disabled>
                              <option value="">:: Pilih Status ::</option>
                              <option value="1" selected>Disetujui </option>
                              <option value="2">Ditolak </option>
                            </select>
                          <?php } else { ?>
                            <select name="status" id="status" class="form-control" disabled>
                              <option value="">:: Pilih Status ::</option>
                              <option value="1">Disetujui </option>
                              <option value="2" selected>Ditolak </option>
                            </select>
                          <?php } ?>
                        </div>
                        <div class="form-group">
                          <label for="direksi" class="form-label">Approval Direksi</label>
                          <?php if ($detail['status_keuangan'] == 0) { ?>
                            <select name="direksi" id="direksi" class="form-control">
                              <option value="">:: Pilih Status ::</option>
                              <option value="1">Ya </option>
                              <option value="2" selected>Tidak </option>
                            </select>
                          <?php } else if ($detail['status_keuangan'] == 1) { ?>
                            <select name="direksi" id="direksi" class="form-control" disabled>
                              <option value="">:: Pilih Status ::</option>
                              <option value="1" <?= $detail['jenis_pengajuan'] == 1 ? 'selected' : '' ?>>Ya </option>
                              <option value="2" <?= $detail['jenis_pengajuan'] == 2 ? 'selected' : '' ?>>Tidak </option>
                            </select>
                          <?php } else { ?>
                            <select name="direksi" id="direksi" class="form-control" disabled>
                              <option value="">:: Pilih Status ::</option>
                              <option value="1" <?= $detail['jenis_pengajuan'] == 1 ? 'selected' : '' ?>>Ya </option>
                              <option value="2" <?= $detail['jenis_pengajuan'] == 2 ? 'selected' : '' ?>>Tidak </option>
                            </select>
                          <?php } ?>
                        </div>
                        <div class="form-group">
                          <label for="nama_direksi">Direksi</label>
                          <select name="nama_direksi" id="nama_direksi" class="form-control select2" style="width: 100%;" disabled>
                            <option value=""> -- Pilih Direksi -- </option>
                            <?php
                            $direksi = $this->db->get_where('users', ['level_jabatan > ' => 4])->result_array();
                            foreach ($direksi as $d) {
                            ?>
                              <option value="<?= $d['nip'] ?>" <?= $d['nip'] == $detail['direksi'] ? 'selected' : '' ?>><?= $d['nama'] ?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                          <label for="file" class="form-label">Bukti Bayar</label>
                          <input type="file" class="form-control" name="bukti-bayar" id="bukti-bayar">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <button class="btn btn-danger" type="reset">Reset</button>
                      <button class="btn btn-primary" type="submit" id="btn-update-bayar">Bayar</button>
                    </div>
                  </form>
                <?php } ?>
                <?php if ($detail['posisi'] == 'Sudah Dibayar' && $this->uri->segment(2) == 'detail') {
                ?>
                  <input type="hidden" name="id_pengajuan" id="id_pengajuan" value="<?= $detail['Id'] ?>">
                  <div class="table-responsive">
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th>Item</th>
                          <th>Qty</th>
                          <th>Price</th>
                          <th>Total</th>
                          <th>COA</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $item = $this->cb->get_where('t_pengajuan_detail', ['no_pengajuan' => $detail['Id'], 'cabang' => $this->session->userdata('kode_cabang')])->result_array();
                        foreach ($item as $i) {
                        ?>
                          <input type="hidden" class="form-control" name="row_item[]" id="row<?= $i['Id'] ?>">
                          <input type="hidden" class="form-control" name="id_item[]" id="id_item<?= $i['Id'] ?>" value="<?= $i['Id'] ?>">
                          <tr>
                            <td><?= $i['item'] ?></td>
                            <td><?= $i['qty'] ?></td>
                            <td><?= number_format($i['price']) ?></td>
                            <td><?= number_format($i['total']) ?></td>
                            <td>
                              <select name="coa_debit[]" id="coa_debit<?= $i['Id'] ?>" class="form-control coa_debit<?= $i['Id'] ?>" style="width: 100%;" disabled>
                                <?php foreach ($coa as $c) { ?>
                                  <option value="<?= $c['no_sbb'] ?>" <?= $c['no_sbb'] == $i['debit'] ? 'selected' : '' ?>><?= $c['no_sbb'] . ' - ' . $c['nama_perkiraan'] ?></option>
                                <?php } ?>
                              </select>
                              <select name="coa_debit[]" id="coa_debit<?= $i['Id'] ?>" class="form-control coa_debit<?= $i['Id'] ?>" style="width: 100%;" disabled>
                                <?php foreach ($coa as $c) { ?>
                                  <option value="<?= $c['no_sbb'] ?>" <?= $c['no_sbb'] == $i['kredit'] ? 'selected' : '' ?>><?= $c['no_sbb'] . ' - ' . $c['nama_perkiraan'] ?></option>
                                <?php } ?>
                              </select>
                            </td>
                          </tr>
                        <?php } ?>
                        <tr>
                          <td colspan="3" align="end"><b>Total</b></td>
                          <td><input type="text" class="form-control" name="total_pengajuan[]" id="total_pengajuan" value="<?= number_format($detail['total']) ?>" readonly></td>
                        </tr>
                        <tr>
                          <td><b>Lampiran</b></td>
                          <td colspan="4"><a href="<?= base_url('upload/pengajuan/' . $detail['bukti_pengajuan']) ?>" class="btn btn-success btn-sm" target="_blank">Lampiran Pengajuan</a></td>
                        </tr>
                        <tr>
                          <td><b>Catatan User</b></td>
                          <td colspan="4"><?= $detail['catatan'] ?></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <div class="row">
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <div class="form-group">
                        <label for="rekening" class="form-label">No. Rekening</label>
                        <input type="text" class="form-control" name="rekening" id="rekening" value="<?= $detail['no_rekening'] ?>" readonly>
                      </div>
                      <div class="form-group">
                        <label for="pembayaran" class="form-label">Jenis Pembayaran</label>
                        <input type="text" class="form-control" name="rekening" id="rekening" value="<?= $detail['metode_pembayaran'] ?>" readonly>
                      </div>
                      <div class="form-group">
                        <?php if ($detail['status_keuangan'] == 0) { ?>
                          <label for="catatan" class="form-label">Catatan</label>
                          <textarea name="catatan" id="catatan" class="form-control"></textarea>
                        <?php } else if ($detail['status_keuangan'] == 1) { ?>
                          <label for="catatan" class="form-label">Catatan</label>
                          <textarea name="catatan" id="catatan" class="form-control" disabled><?= $detail['catatan_keuangan'] ?></textarea>
                        <?php } else { ?>
                          <label for="catatan" class="form-label">Catatan</label>
                          <textarea name="catatan" id="catatan" class="form-control" disabled><?= $detail['catatan_keuangan'] ?></textarea>
                        <?php } ?>
                      </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <div class="form-group">
                        <label for="status" class="form-label">Status Pengajuan</label>
                        <?php if ($detail['status_keuangan'] == 0) { ?>
                          <select name="status" id="status" class="form-control">
                            <option value="">:: Pilih Status ::</option>
                            <option value="1">Disetujui </option>
                            <option value="2">Ditolak </option>
                          </select>
                        <?php } else if ($detail['status_keuangan'] == 1) { ?>
                          <select name="status" id="status" class="form-control" disabled>
                            <option value="">:: Pilih Status ::</option>
                            <option value="1" selected>Disetujui </option>
                            <option value="2">Ditolak </option>
                          </select>
                        <?php } else { ?>
                          <select name="status" id="status" class="form-control" disabled>
                            <option value="">:: Pilih Status ::</option>
                            <option value="1">Disetujui </option>
                            <option value="2" selected>Ditolak </option>
                          </select>
                        <?php } ?>
                      </div>
                      <div class="form-group">
                        <label for="direksi" class="form-label">Approval Direksi</label>
                        <?php if ($detail['status_keuangan'] == 0) { ?>
                          <select name="direksi" id="direksi" class="form-control">
                            <option value="">:: Pilih Status ::</option>
                            <option value="1">Ya </option>
                            <option value="2" selected>Tidak </option>
                          </select>
                        <?php } else if ($detail['status_keuangan'] == 1) { ?>
                          <select name="direksi" id="direksi" class="form-control" disabled>
                            <option value="">:: Pilih Status ::</option>
                            <option value="1" <?= $detail['jenis_pengajuan'] == 1 ? 'selected' : '' ?>>Ya </option>
                            <option value="2" <?= $detail['jenis_pengajuan'] == 2 ? 'selected' : '' ?>>Tidak </option>
                          </select>
                        <?php } else { ?>
                          <select name="direksi" id="direksi" class="form-control" disabled>
                            <option value="">:: Pilih Status ::</option>
                            <option value="1" <?= $detail['jenis_pengajuan'] == 1 ? 'selected' : '' ?>>Ya </option>
                            <option value="2" <?= $detail['jenis_pengajuan'] == 2 ? 'selected' : '' ?>>Tidak </option>
                          </select>
                        <?php } ?>
                      </div>
                      <div class="form-group">
                        <label for="nama_direksi">Direksi</label>
                        <select name="nama_direksi" id="nama_direksi" class="form-control select2" style="width: 100%;" disabled>
                          <option value=""> -- Pilih Direksi -- </option>
                          <?php
                          $direksi = $this->db->get_where('users', ['level_jabatan > ' => 4])->result_array();
                          foreach ($direksi as $d) {
                          ?>
                            <option value="<?= $d['nip'] ?>" <?= $d['nip'] == $detail['direksi'] ? 'selected' : '' ?>><?= $d['nama'] ?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <?php if ($detail['status_keuangan'] == 0) { ?>
                      <button class="btn btn-danger" type="reset">Reset</button>
                      <button class="btn btn-primary" type="submit" id="btn-keuangan">Save</button>
                    <?php } ?>
                  </div>
                <?php } ?>

                <?php if ($detail['posisi'] == 'Diajukan kepada keuangan' && $this->uri->segment(2) == 'detail') {
                ?>
                  <form action="<?= base_url('pengajuan/update_keuangan') ?>" method="post" enctype="multipart/form-data" id="update-keuangan">
                    <input type="hidden" name="id_pengajuan" id="id_pengajuan" value="<?= $detail['Id'] ?>">
                    <div class="table-responsive">
                      <table class="table table-bordered">
                        <thead>
                          <tr>
                            <th>Item</th>
                            <th>Qty</th>
                            <th>Price</th>
                            <th>Total</th>
                            <th>COA</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          $item = $this->cb->get_where('t_pengajuan_detail', ['no_pengajuan' => $detail['Id'], 'cabang' => $this->session->userdata('kode_cabang')])->result_array();
                          foreach ($item as $i) {
                          ?>
                            <input type="hidden" class="form-control" name="row_item[]" id="row<?= $i['Id'] ?>">
                            <input type="hidden" class="form-control" name="id_item[]" id="id_item<?= $i['Id'] ?>" value="<?= $i['Id'] ?>">
                            <tr>
                              <td><?= $i['item'] ?></td>
                              <td><?= $i['qty'] ?></td>
                              <td><?= number_format($i['price']) ?></td>
                              <td><?= number_format($i['total']) ?></td>
                              <td>
                                <select name="coa_debit[]" id="coa_debit<?= $i['Id'] ?>" class="form-control coa_debit<?= $i['Id'] ?>" style="width: 100%;">
                                  <?php foreach ($coa as $c) { ?>
                                    <option value="<?= $c['no_sbb'] ?>" <?= $c['no_sbb'] == '15110' ? 'selected' : '' ?>><?= $c['no_sbb'] . ' - ' . $c['nama_perkiraan'] ?></option>
                                  <?php } ?>
                                </select>
                              </td>
                            </tr>
                            <script>
                              $(document).ready(function() {
                                $('.coa_debit<?= $i['Id'] ?>').select2()
                              })
                            </script>
                          <?php } ?>
                          <tr>
                            <td colspan="3" align="end"><b>Total</b></td>
                            <td><input type="text" class="form-control" name="total_pengajuan[]" id="total_pengajuan" value="<?= number_format($detail['total']) ?>" readonly></td>
                          </tr>
                          <tr>
                            <td><b>Lampiran</b></td>
                            <td colspan="4"><a href="<?= base_url('upload/pengajuan/' . $detail['bukti_pengajuan']) ?>" class="btn btn-success btn-sm" target="_blank">Lampiran Pengajuan</a></td>
                          </tr>
                          <tr>
                            <td><b>Catatan User</b></td>
                            <td colspan="4"><?= $detail['catatan'] ?></td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                    <div class="row">
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                          <label for="rekening" class="form-label">No. Rekening</label>
                          <input type="text" class="form-control" name="rekening" id="rekening" value="<?= $detail['no_rekening'] ?>" readonly>
                        </div>
                        <div class="form-group">
                          <label for="pembayaran" class="form-label">Jenis Pembayaran</label>
                          <input type="text" class="form-control" name="rekening" id="rekening" value="<?= $detail['metode_pembayaran'] ?>" readonly>
                        </div>
                        <div class="form-group">
                          <?php if ($detail['status_keuangan'] == 0) { ?>
                            <label for="catatan" class="form-label">Catatan</label>
                            <textarea name="catatan" id="catatan" class="form-control"></textarea>
                          <?php } else if ($detail['status_keuangan'] == 1) { ?>
                            <label for="catatan" class="form-label">Catatan</label>
                            <textarea name="catatan" id="catatan" class="form-control" disabled><?= $detail['catatan_keuangan'] ?></textarea>
                          <?php } else { ?>
                            <label for="catatan" class="form-label">Catatan</label>
                            <textarea name="catatan" id="catatan" class="form-control" disabled><?= $detail['catatan_keuangan'] ?></textarea>
                          <?php } ?>
                        </div>
                      </div>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                          <label for="tanggal" class="form-label">Tanggal</label>
                          <?php if ($detail['date_keuangan'] == null) { ?>
                            <input type="date" class="form-control" name="tanggal" id="tanggal" value="<?= date('Y-m-d') ?>">
                          <?php } else { ?>
                            <input type="date" class="form-control" name="tanggal" id="tanggal" value="<?= $detail['date_keuangan'] ?>">
                          <?php } ?>
                        </div>
                        <div class="form-group">
                          <label for="status" class="form-label">Status Pengajuan</label>
                          <?php if ($detail['status_keuangan'] == 0) { ?>
                            <select name="status" id="status" class="form-control">
                              <option value="">:: Pilih Status ::</option>
                              <option value="1">Disetujui </option>
                              <option value="2">Ditolak </option>
                            </select>
                          <?php } else if ($detail['status_keuangan'] == 1) { ?>
                            <select name="status" id="status" class="form-control" disabled>
                              <option value="">:: Pilih Status ::</option>
                              <option value="1" selected>Disetujui </option>
                              <option value="2">Ditolak </option>
                            </select>
                          <?php } else { ?>
                            <select name="status" id="status" class="form-control" disabled>
                              <option value="">:: Pilih Status ::</option>
                              <option value="1">Disetujui </option>
                              <option value="2" selected>Ditolak </option>
                            </select>
                          <?php } ?>
                        </div>
                        <div class="form-group">
                          <label for="direksi" class="form-label">Approval Direksi</label>
                          <?php if ($detail['status_keuangan'] == 0) { ?>
                            <select name="direksi" id="direksi" class="form-control">
                              <option value="">:: Pilih Status ::</option>
                              <option value="1">Ya </option>
                              <option value="2" selected>Tidak </option>
                            </select>
                          <?php } else if ($detail['status_keuangan'] == 1) { ?>
                            <select name="direksi" id="direksi" class="form-control" disabled>
                              <option value="">:: Pilih Status ::</option>
                              <option value="1" <?= $detail['jenis_pengajuan'] == 1 ? 'selected' : '' ?>>Ya </option>
                              <option value="2" <?= $detail['jenis_pengajuan'] == 2 ? 'selected' : '' ?>>Tidak </option>
                            </select>
                          <?php } else { ?>
                            <select name="direksi" id="direksi" class="form-control" disabled>
                              <option value="">:: Pilih Status ::</option>
                              <option value="1" <?= $detail['jenis_pengajuan'] == 1 ? 'selected' : '' ?>>Ya </option>
                              <option value="2" <?= $detail['jenis_pengajuan'] == 2 ? 'selected' : '' ?>>Tidak </option>
                            </select>
                          <?php } ?>
                        </div>
                        <div class="form-group">
                          <label for="nama_direksi">Direksi</label>
                          <select name="nama_direksi" id="nama_direksi" class="form-control select2" style="width: 100%;" disabled>
                            <option value=""> -- Pilih Direksi -- </option>
                            <?php
                            $direksi = $this->db->get_where('users', ['level_jabatan > ' => 4])->result_array();
                            foreach ($direksi as $d) {
                            ?>
                              <option value="<?= $d['nip'] ?>"><?= $d['nama'] ?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <?php if ($detail['status_keuangan'] == 0) { ?>
                        <button class="btn btn-danger" type="reset">Reset</button>
                        <button class="btn btn-primary" type="submit" id="btn-keuangan">Save</button>
                      <?php } ?>
                    </div>
                  </form>
                <?php } ?>

                <?php if ($detail['posisi'] == 'Diajukan kepada direksi' && $this->uri->segment(2) == 'detail') {
                ?>
                  <div class="table-responsive">
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th width="400px">Item</th>
                          <th>Qty</th>
                          <th>Price</th>
                          <th>Total</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $item = $this->cb->get_where('t_pengajuan_detail', ['no_pengajuan' => $detail['Id']])->result_array();
                        foreach ($item as $i) {
                        ?>
                          <tr>
                            <td><?= $i['item'] ?></td>
                            <td><?= $i['qty'] ?></td>
                            <td><?= number_format($i['price'], 2, '.', ',') ?></td>
                            <td><?= number_format($i['total'], 2, '.', ',') ?></td>
                          </tr>
                        <?php } ?>
                        <tr>
                          <td colspan="3" align="end"><b>Total</b></td>
                          <td><input type="text" class="form-control" name="total_pengajuan[]" id="total_pengajuan" value="<?= number_format($detail['total'], 2, '.', ',') ?>" readonly></td>
                        </tr>
                        <tr>
                          <td><b>Lampiran</b></td>
                          <td colspan="4"><a href="<?= base_url('upload/pengajuan/' . $detail['bukti_pengajuan']) ?>" class="btn btn-success btn-sm" target="_blank">Lampiran Pengajuan</a></td>
                        </tr>
                        <tr>
                          <td><b>Catatan User</b></td>
                          <td colspan="4"><?= $detail['catatan'] ?></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                <?php } ?>

                <?php if ($detail['posisi'] == 'Diarahkan ke pembayaran' && $this->uri->segment(2) == 'detail') {
                ?>
                  <form action="<?= base_url('pengajuan/update_keuangan') ?>" method="post" enctype="multipart/form-data" id="update-keuangan">
                    <input type="hidden" name="id_pengajuan" id="id_pengajuan" value="<?= $detail['Id'] ?>">
                    <div class="table-responsive">
                      <table class="table table-bordered">
                        <thead>
                          <tr>
                            <th>Item</th>
                            <th>Qty</th>
                            <th>Price</th>
                            <th>Total</th>
                            <th>COA</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          $item = $this->cb->get_where('t_pengajuan_detail', ['no_pengajuan' => $detail['Id'], 'cabang' => $this->session->userdata('kode_cabang')])->result_array();
                          foreach ($item as $i) {
                          ?>
                            <input type="hidden" class="form-control" name="row_item[]" id="row<?= $i['Id'] ?>">
                            <input type="hidden" class="form-control" name="id_item[]" id="id_item<?= $i['Id'] ?>" value="<?= $i['Id'] ?>">
                            <tr>
                              <td><?= $i['item'] ?></td>
                              <td><?= $i['qty'] ?></td>
                              <td><?= number_format($i['price']) ?></td>
                              <td><?= number_format($i['total']) ?></td>
                              <td>
                                <select name="coa_debit[]" id="coa_debit<?= $i['Id'] ?>" class="form-control coa_debit<?= $i['Id'] ?>" style="width: 100%;" disabled>
                                  <?php foreach ($coa as $c) { ?>
                                    <option value="<?= $c['no_sbb'] ?>" <?= $c['no_sbb'] == $i['debit'] ? 'selected' : '' ?>><?= $c['no_sbb'] . ' - ' . $c['nama_perkiraan'] ?></option>
                                  <?php } ?>
                                </select>
                              </td>
                            </tr>
                            <script>
                              $(document).ready(function() {
                                $('.coa_debit<?= $i['Id'] ?>').select2()
                              })
                            </script>
                          <?php } ?>
                          <tr>
                            <td colspan="3" align="end"><b>Total</b></td>
                            <td><input type="text" class="form-control" name="total_pengajuan[]" id="total_pengajuan" value="<?= number_format($detail['total']) ?>" readonly></td>
                          </tr>
                          <tr>
                            <td><b>Lampiran</b></td>
                            <td colspan="4"><a href="<?= base_url('upload/pengajuan/' . $detail['bukti_pengajuan']) ?>" class="btn btn-success btn-sm" target="_blank">Lampiran Pengajuan</a></td>
                          </tr>
                          <tr>
                            <td><b>Catatan User</b></td>
                            <td colspan="4"><?= $detail['catatan'] ?></td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                    <div class="row">
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                          <label for="rekening" class="form-label">No. Rekening</label>
                          <input type="text" class="form-control" name="rekening" id="rekening" value="<?= $detail['no_rekening'] ?>" readonly>
                        </div>
                        <div class="form-group">
                          <label for="pembayaran" class="form-label">Jenis Pembayaran</label>
                          <input type="text" class="form-control" name="rekening" id="rekening" value="<?= $detail['metode_pembayaran'] ?>" readonly>
                        </div>
                        <div class="form-group">
                          <?php if ($detail['status_keuangan'] == 0) { ?>
                            <label for="catatan" class="form-label">Catatan</label>
                            <textarea name="catatan" id="catatan" class="form-control"></textarea>
                          <?php } else if ($detail['status_keuangan'] == 1) { ?>
                            <label for="catatan" class="form-label">Catatan</label>
                            <textarea name="catatan" id="catatan" class="form-control" disabled><?= $detail['catatan_keuangan'] ?></textarea>
                          <?php } else { ?>
                            <label for="catatan" class="form-label">Catatan</label>
                            <textarea name="catatan" id="catatan" class="form-control" disabled><?= $detail['catatan_keuangan'] ?></textarea>
                          <?php } ?>
                        </div>
                      </div>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                          <label for="status" class="form-label">Status Pengajuan</label>
                          <?php if ($detail['status_keuangan'] == 0) { ?>
                            <select name="status" id="status" class="form-control">
                              <option value="">:: Pilih Status ::</option>
                              <option value="1">Disetujui </option>
                              <option value="2">Ditolak </option>
                            </select>
                          <?php } else if ($detail['status_keuangan'] == 1) { ?>
                            <select name="status" id="status" class="form-control" disabled>
                              <option value="">:: Pilih Status ::</option>
                              <option value="1" selected>Disetujui </option>
                              <option value="2">Ditolak </option>
                            </select>
                          <?php } else { ?>
                            <select name="status" id="status" class="form-control" disabled>
                              <option value="">:: Pilih Status ::</option>
                              <option value="1">Disetujui </option>
                              <option value="2" selected>Ditolak </option>
                            </select>
                          <?php } ?>
                        </div>
                        <div class="form-group">
                          <label for="direksi" class="form-label">Approval Direksi</label>
                          <?php if ($detail['status_keuangan'] == 0) { ?>
                            <select name="direksi" id="direksi" class="form-control">
                              <option value="">:: Pilih Status ::</option>
                              <option value="1">Ya </option>
                              <option value="2" selected>Tidak </option>
                            </select>
                          <?php } else if ($detail['status_keuangan'] == 1) { ?>
                            <select name="direksi" id="direksi" class="form-control" disabled>
                              <option value="">:: Pilih Status ::</option>
                              <option value="1" <?= $detail['jenis_pengajuan'] == 1 ? 'selected' : '' ?>>Ya </option>
                              <option value="2" <?= $detail['jenis_pengajuan'] == 2 ? 'selected' : '' ?>>Tidak </option>
                            </select>
                          <?php } else { ?>
                            <select name="direksi" id="direksi" class="form-control" disabled>
                              <option value="">:: Pilih Status ::</option>
                              <option value="1" <?= $detail['jenis_pengajuan'] == 1 ? 'selected' : '' ?>>Ya </option>
                              <option value="2" <?= $detail['jenis_pengajuan'] == 2 ? 'selected' : '' ?>>Tidak </option>
                            </select>
                          <?php } ?>
                        </div>
                        <div class="form-group">
                          <label for="nama_direksi">Direksi</label>
                          <select name="nama_direksi" id="nama_direksi" class="form-control select2" style="width: 100%;" disabled>
                            <option value=""> -- Pilih Direksi -- </option>
                            <?php
                            $direksi = $this->db->get_where('users', ['level_jabatan > ' => 4])->result_array();
                            foreach ($direksi as $d) {
                            ?>
                              <option value="<?= $d['nip'] ?>"><?= $d['nama'] ?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <?php if ($detail['status_keuangan'] == 0) { ?>
                        <button class="btn btn-danger" type="reset">Reset</button>
                        <button class="btn btn-primary" type="submit" id="btn-keuangan">Save</button>
                      <?php } ?>
                    </div>
                  </form>
                <?php } ?>

                <?php if ($this->uri->segment(2) == "detail" && $detail['posisi'] == 'Closed') { ?>
                  <form action="<?= base_url('pengajuan/update_keuangan') ?>" method="post" enctype="multipart/form-data" id="update-keuangan">
                    <input type="hidden" name="id_pengajuan" id="id_pengajuan" value="<?= $detail['Id'] ?>">
                    <div class="table-responsive">
                      <table class="table table-bordered">
                        <thead>
                          <tr>
                            <th>Item</th>
                            <th style="width: 2%;">Qty</th>
                            <th style="width: 15%;">Harga Satuan</th>
                            <th style="width: 15%;">Total</th>
                            <th style="width: 15%;">Realisasi</th>
                            <th style="width: 30%;">COA</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          $item = $this->cb->get_where('t_pengajuan_detail', ['no_pengajuan' => $detail['Id'], 'cabang' => $this->session->userdata('kode_cabang')])->result_array();
                          $total_realisasi = 0;
                          foreach ($item as $i) {
                            $total_realisasi += $i['realisasi'];
                          ?>
                            <input type="hidden" class="form-control" name="row_item[]" id="row<?= $i['Id'] ?>">
                            <input type="hidden" class="form-control" name="id_item[]" id="id_item<?= $i['Id'] ?>" value="<?= $i['Id'] ?>">
                            <tr>
                              <td><?= $i['item'] ?></td>
                              <td><?= $i['qty'] ?></td>
                              <td><input type="text" class="form-control" name="price[]" id="price<?= $i['Id'] ?>" value="<?= number_format($i['price']) ?>" readonly></td>
                              <td>
                                <input type="text" class="form-control" name="total_item[]" id="total_item<?= $i['Id'] ?>" value="<?= number_format($i['total']) ?>" readonly>
                              </td>
                              <td>
                                <input type="text" class="form-control" disabled value="<?= number_format($i['realisasi']) ?>">
                              </td>
                              <td>
                                <select class="form-control coa_debit<?= $i['Id'] ?>" style="width: 100%;" disabled>
                                  <?php foreach ($coa as $cd) { ?>
                                    <option value="<?= $cd['no_sbb'] ?>" <?= $cd['no_sbb'] == $i['debit'] ? 'selected' : '' ?>><?= $cd['no_sbb'] . ' - ' . $cd['nama_perkiraan'] ?></option>
                                  <?php } ?>
                                </select>

                                <select class="form-control coa_debit<?= $i['Id'] ?>" style="width: 100%;" disabled>
                                  <?php foreach ($coa as $ck) { ?>
                                    <option value="<?= $ck['no_sbb'] ?>" <?= $ck['no_sbb'] == $i['kredit'] ? 'selected' : '' ?>><?= $ck['no_sbb'] . ' - ' . $ck['nama_perkiraan'] ?></option>
                                  <?php } ?>
                                </select>

                                <select class="form-control coa_debit<?= $i['Id'] ?>" style="width: 100%;" disabled>
                                  <?php foreach ($coa as $cb) { ?>
                                    <option value="<?= $cb['no_sbb'] ?>" <?= $cb['no_sbb'] == $i['beban'] ? 'selected' : '' ?>><?= $cb['no_sbb'] . ' - ' . $cb['nama_perkiraan'] ?></option>
                                  <?php } ?>
                                </select>
                              </td>
                            </tr>
                            <script>
                              $(document).ready(function() {
                                $('.coa_debit<?= $i['Id'] ?>').select2();

                                $('#coa_debit<?= $i['Id'] ?>').change(function() {
                                  var id = $(this).val();
                                  $.ajax({
                                    url: '<?= base_url('pengajuan/getDataCoa/') ?>' + id,
                                    method: 'GET',
                                    dataType: 'JSON',
                                    success: function(res) {
                                      if (res.anggaran) {
                                        $('#anggaran<?= $i['Id'] ?>').val(formatNumber(res.anggaran));
                                      } else {
                                        $('#anggaran<?= $i['Id'] ?>').val(0);
                                      }
                                    }
                                  })
                                })

                              })
                            </script>
                          <?php } ?>
                          <tr>
                            <td colspan="3" align="end"><b>Total</b></td>
                            <td><input type="text" class="form-control" value="<?= number_format($detail['total']) ?>" readonly></td>
                            <td><input type="text" class="form-control" value="<?= number_format($total_realisasi) ?>" readonly></td>
                          </tr>
                          <tr>
                            <td><b>Lampiran</b></td>
                            <td colspan="5">
                              <a href="<?= base_url('upload/pengajuan/' . $detail['bukti_pengajuan']) ?>" class="btn btn-success btn-sm" target="_blank">Lampiran Pengajuan</a>
                              <a href="<?= base_url('upload/pengajuan/' . $detail['bukti_bayar']) ?>" class="btn btn-success btn-sm" target="_blank">Bukti Bayar</a>
                            </td>
                          </tr>
                          <tr>
                            <td><b>Catatan User</b></td>
                            <td colspan="5"><?= $detail['catatan'] ?></td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                    <div class="row">
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                          <label for="rekening" class="form-label">No. Rekening</label>
                          <input type="text" class="form-control" name="rekening" id="rekening" value="<?= $detail['no_rekening'] ?>" readonly>
                        </div>
                        <div class="form-group">
                          <label for="pembayaran" class="form-label">Jenis Pembayaran</label>
                          <input type="text" class="form-control" name="rekening" id="rekening" value="<?= $detail['metode_pembayaran'] ?>" readonly>
                        </div>
                        <div class="form-group">
                          <?php if ($detail['status_keuangan'] == 0) { ?>
                            <label for="catatan" class="form-label">Catatan</label>
                            <textarea name="catatan" id="catatan" class="form-control"></textarea>
                          <?php } else if ($detail['status_keuangan'] == 1) { ?>
                            <label for="catatan" class="form-label">Catatan</label>
                            <textarea name="catatan" id="catatan" class="form-control" disabled><?= $detail['catatan_keuangan'] ?></textarea>
                          <?php } else { ?>
                            <label for="catatan" class="form-label">Catatan</label>
                            <textarea name="catatan" id="catatan" class="form-control" disabled><?= $detail['catatan_keuangan'] ?></textarea>
                          <?php } ?>
                        </div>
                      </div>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                          <label for="status" class="form-label">Status Pengajuan</label>
                          <?php if ($detail['status_keuangan'] == 0) { ?>
                            <select name="status" id="status" class="form-control">
                              <option value="">:: Pilih Status ::</option>
                              <option value="1">Disetujui </option>
                              <option value="2">Ditolak </option>
                            </select>
                          <?php } else if ($detail['status_keuangan'] == 1) { ?>
                            <select name="status" id="status" class="form-control" disabled>
                              <option value="">:: Pilih Status ::</option>
                              <option value="1" selected>Disetujui </option>
                              <option value="2">Ditolak </option>
                            </select>
                          <?php } else { ?>
                            <select name="status" id="status" class="form-control" disabled>
                              <option value="">:: Pilih Status ::</option>
                              <option value="1">Disetujui </option>
                              <option value="2" selected>Ditolak </option>
                            </select>
                          <?php } ?>
                        </div>
                        <div class="form-group">
                          <label for="direksi" class="form-label">Approval Direksi</label>
                          <?php if ($detail['status_keuangan'] == 0) { ?>
                            <select name="direksi" id="direksi" class="form-control">
                              <option value="">:: Pilih Status ::</option>
                              <option value="1">Ya </option>
                              <option value="2" selected>Tidak </option>
                            </select>
                          <?php } else if ($detail['status_keuangan'] == 1) { ?>
                            <select name="direksi" id="direksi" class="form-control" disabled>
                              <option value="">:: Pilih Status ::</option>
                              <option value="1" <?= $detail['jenis_pengajuan'] == 1 ? 'selected' : '' ?>>Ya </option>
                              <option value="2" <?= $detail['jenis_pengajuan'] == 2 ? 'selected' : '' ?>>Tidak </option>
                            </select>
                          <?php } else { ?>
                            <select name="direksi" id="direksi" class="form-control" disabled>
                              <option value="">:: Pilih Status ::</option>
                              <option value="1" <?= $detail['jenis_pengajuan'] == 1 ? 'selected' : '' ?>>Ya </option>
                              <option value="2" <?= $detail['jenis_pengajuan'] == 2 ? 'selected' : '' ?>>Tidak </option>
                            </select>
                          <?php } ?>
                        </div>
                        <div class="form-group">
                          <label for="nama_direksi">Direksi</label>
                          <select name="nama_direksi" id="nama_direksi" class="form-control select2" style="width: 100%;" disabled>
                            <option value=""> -- Pilih Direksi -- </option>
                            <?php
                            $direksi = $this->db->get_where('users', ['level_jabatan > ' => 4])->result_array();
                            foreach ($direksi as $d) {
                            ?>
                              <option value="<?= $d['nip'] ?>" <?= $d['nip'] == $detail['direksi'] ? 'selected' : '' ?>><?= $d['nama'] ?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <?php if ($detail['status_keuangan'] == 0) { ?>
                        <button class="btn btn-danger" type="reset">Reset</button>
                        <button class="btn btn-primary" type="submit" id="btn-keuangan">Save</button>
                      <?php } ?>
                    </div>
                  </form>
                <?php } ?>

                <?php if ($this->uri->segment(2) == 'close') { ?>
                  <form action="<?= base_url('pengajuan/update_close') ?>" method="post" enctype="multipart/form-data" id="close-pengajuan">
                    <input type="hidden" name="id_pengajuan" id="id_pengajuan" value="<?= $detail['Id'] ?>">
                    <div class="table-responsive">
                      <table class="table table-bordered">
                        <thead>
                          <tr>
                            <th>Item</th>
                            <th>Total</th>
                            <th>COA</th>
                            <th>Realisasi</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          $item = $this->cb->get_where('t_pengajuan_detail', ['no_pengajuan' => $detail['Id'], 'cabang' => $this->session->userdata('kode_cabang')])->result_array();
                          foreach ($item as $i) {
                          ?>
                            <input type="hidden" class="form-control" name="row_item[]" id="row<?= $i['Id'] ?>">
                            <input type="hidden" class="form-control" name="id_item[]" id="id_item<?= $i['Id'] ?>" value="<?= $i['Id'] ?>">
                            <tr>
                              <td><?= $i['item'] ?></td>
                              <td>
                                <input type="text" class="form-control" name="total_item[]" id="total_item<?= $i['Id'] ?>" value="<?= number_format($i['total']) ?>" readonly>
                              </td>
                              <td>
                                <?php if ($detail['posisi'] != 'Closed') { ?>
                                  <select name="coa_beban[]" id="coa_beban<?= $i['Id'] ?>" class="form-control coa_beban<?= $i['Id'] ?>" style="width: 100%;">
                                    <option value=""> -- Pilih COA Beban -- </option>
                                    <?php foreach ($coa_beban as $c) { ?>
                                      <option value="<?= $c['no_sbb'] ?>"><?= $c['no_sbb'] . ' - ' . $c['nama_perkiraan'] ?></option>
                                    <?php } ?>
                                  </select>
                                <?php } else { ?>
                                  <select name="coa_beban[]" id="coa_beban<?= $i['Id'] ?>" class="form-control coa_beban<?= $i['Id'] ?>" style="width: 100%;" disabled>
                                    <?php foreach ($coa_beban as $c) { ?>
                                      <option value="<?= $c['no_sbb'] ?>" <?= $c['no_sbb'] == $i['beban'] ? 'selected' : '' ?>><?= $c['no_sbb'] . ' - ' . $c['nama_perkiraan'] ?></option>
                                    <?php } ?>
                                  </select>
                                <?php } ?>
                              </td>
                              <td>
                                <?php if ($detail['posisi'] != "Closed") { ?>
                                  <input type="text" class="form-control" name="realisasi[]" id="realisasi<?= $i['Id'] ?>">
                                <?php } else { ?>
                                  <input type="text" class="form-control" name="realisasi[]" id="realisasi<?= $i['Id'] ?>" value="<?= number_format($i['realisasi']) ?>" disabled>
                                <?php } ?>
                              </td>
                            </tr>
                            <script>
                              $(document).ready(function() {
                                $('.coa_beban<?= $i['Id'] ?>').select2();
                              })
                            </script>
                          <?php } ?>
                          <tr>
                            <td><b>Total</b></td>
                            <td><input type="text" class="form-control" name="total_pengajuan[]" id="total_pengajuan" value="<?= number_format($detail['total']) ?>" readonly></td>
                          </tr>
                          <tr>
                            <td><b>Lampiran</b></td>
                            <td colspan="4"><a href="<?= base_url('upload/pengajuan/' . $detail['bukti_pengajuan']) ?>" class="btn btn-success btn-sm" target="_blank">Lampiran Pengajuan</a></td>
                          </tr>
                          <tr>
                            <td><b>Catatan User</b></td>
                            <td colspan="4"><?= $detail['catatan'] ?></td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                    <div class="row">
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                          <label for="rekening" class="form-label">No. Rekening</label>
                          <input type="text" class="form-control" name="rekening" id="rekening" value="<?= $detail['no_rekening'] ?>" readonly>
                        </div>
                        <div class="form-group">
                          <label for="pembayaran" class="form-label">Jenis Pembayaran</label>
                          <input type="text" class="form-control" name="rekening" id="rekening" value="<?= $detail['metode_pembayaran'] ?>" readonly>
                        </div>
                        <div class="form-group">
                          <?php if ($detail['status_keuangan'] == 0) { ?>
                            <label for="catatan" class="form-label">Catatan</label>
                            <textarea name="catatan" id="catatan" class="form-control"></textarea>
                          <?php } else if ($detail['status_keuangan'] == 1) { ?>
                            <label for="catatan" class="form-label">Catatan</label>
                            <textarea name="catatan" id="catatan" class="form-control" disabled><?= $detail['catatan_keuangan'] ?></textarea>
                          <?php } else { ?>
                            <label for="catatan" class="form-label">Catatan</label>
                            <textarea name="catatan" id="catatan" class="form-control" disabled><?= $detail['catatan_keuangan'] ?></textarea>
                          <?php } ?>
                        </div>
                      </div>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                          <label for="tanggal" class="form-label">Tanggal Close</label>
                          <?php if ($detail['date_close'] == null) { ?>
                            <input type="date" class="form-control" name="tanggal" id="tanggal" value="<?= date('Y-m-d') ?>">
                          <?php } else { ?>
                            <input type="date" class="form-control" name="tanggal" id="tanggal" value="<?= $detail('date_close') ?>">
                          <?php } ?>
                        </div>
                        <div class="form-group">
                          <label for="status" class="form-label">Status Pengajuan</label>
                          <?php if ($detail['status_keuangan'] == 0) { ?>
                            <select name="status" id="status" class="form-control">
                              <option value="">:: Pilih Status ::</option>
                              <option value="1">Disetujui </option>
                              <option value="2">Ditolak </option>
                            </select>
                          <?php } else if ($detail['status_keuangan'] == 1) { ?>
                            <select name="status" id="status" class="form-control" disabled>
                              <option value="">:: Pilih Status ::</option>
                              <option value="1" selected>Disetujui </option>
                              <option value="2">Ditolak </option>
                            </select>
                          <?php } else { ?>
                            <select name="status" id="status" class="form-control" disabled>
                              <option value="">:: Pilih Status ::</option>
                              <option value="1">Disetujui </option>
                              <option value="2" selected>Ditolak </option>
                            </select>
                          <?php } ?>
                        </div>
                        <div class="form-group">
                          <label for="direksi" class="form-label">Approval Direksi</label>
                          <?php if ($detail['status_keuangan'] == 0) { ?>
                            <select name="direksi" id="direksi" class="form-control">
                              <option value="">:: Pilih Status ::</option>
                              <option value="1">Ya </option>
                              <option value="2" selected>Tidak </option>
                            </select>
                          <?php } else if ($detail['status_keuangan'] == 1) { ?>
                            <select name="direksi" id="direksi" class="form-control" disabled>
                              <option value="">:: Pilih Status ::</option>
                              <option value="1" <?= $detail['jenis_pengajuan'] == 1 ? 'selected' : '' ?>>Ya </option>
                              <option value="2" <?= $detail['jenis_pengajuan'] == 2 ? 'selected' : '' ?>>Tidak </option>
                            </select>
                          <?php } else { ?>
                            <select name="direksi" id="direksi" class="form-control" disabled>
                              <option value="">:: Pilih Status ::</option>
                              <option value="1" <?= $detail['jenis_pengajuan'] == 1 ? 'selected' : '' ?>>Ya </option>
                              <option value="2" <?= $detail['jenis_pengajuan'] == 2 ? 'selected' : '' ?>>Tidak </option>
                            </select>
                          <?php } ?>
                        </div>
                        <div class="form-group">
                          <label for="nama_direksi">Direksi</label>
                          <select name="nama_direksi" id="nama_direksi" class="form-control select2" style="width: 100%;" disabled>
                            <option value=""> -- Pilih Direksi -- </option>
                            <?php
                            $direksi = $this->db->get_where('users', ['level_jabatan > ' => 4])->result_array();
                            foreach ($direksi as $d) {
                            ?>
                              <option value="<?= $d['nip'] ?>" <?= $d['nip']  == $detail['direksi'] ? 'selected' : '' ?>><?= $d['nama'] ?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <?php if ($detail['posisi'] != 'Closed') { ?>
                        <button class="btn btn-danger" type="reset">Reset</button>
                        <button class="btn btn-primary" type="submit" id="btn-close">Close</button>
                      <?php } ?>
                    </div>
                  </form>
                <?php } ?>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Finish content-->
    </div>

    <!-- /page content -->

    <!-- footer content -->

    <!-- /footer content -->

  </div>

  <!-- jQuery -->


  <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
  <!-- Bootstrap -->
  <script src="<?= base_url(); ?>src/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
  <!-- FastClick -->
  <script src="<?= base_url(); ?>src/vendors/fastclick/lib/fastclick.js"></script>
  <!-- NProgress -->
  <!-- <script src="<?= base_url(); ?>src/vendors/nprogress/nprogress.js"></script> -->
  <!-- Chart.js -->
  <script src="<?= base_url(); ?>src/vendors/Chart.js/dist/Chart.min.js"></script>
  <!-- gauge.js -->
  <script src="<?= base_url(); ?>src/vendors/gauge.js/dist/gauge.min.js"></script>
  <!-- bootstrap-progressbar -->
  <script src="<?= base_url(); ?>src/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
  <!-- iCheck -->
  <script src="<?= base_url(); ?>src/vendors/iCheck/icheck.min.js"></script>
  <!-- Skycons -->
  <script src="<?= base_url(); ?>src/vendors/skycons/skycons.js"></script>
  <!-- Flot -->
  <script src="<?= base_url(); ?>src/vendors/Flot/jquery.flot.js"></script>
  <script src="<?= base_url(); ?>src/vendors/Flot/jquery.flot.pie.js"></script>
  <script src="<?= base_url(); ?>src/vendors/Flot/jquery.flot.time.js"></script>
  <script src="<?= base_url(); ?>src/vendors/Flot/jquery.flot.stack.js"></script>
  <script src="<?= base_url(); ?>src/vendors/Flot/jquery.flot.resize.js"></script>
  <!-- Flot plugins -->
  <script src="<?= base_url(); ?>src/vendors/flot.orderbars/js/jquery.flot.orderBars.js"></script>
  <script src="<?= base_url(); ?>src/vendors/flot-spline/js/jquery.flot.spline.min.js"></script>
  <script src="<?= base_url(); ?>src/vendors/flot.curvedlines/curvedLines.js"></script>
  <!-- DateJS -->
  <script src="<?= base_url(); ?>src/vendors/DateJS/build/date.js"></script>
  <!-- JQVMap -->
  <script src="<?= base_url(); ?>src/vendors/jqvmap/dist/jquery.vmap.js"></script>
  <script src="<?= base_url(); ?>src/vendors/jqvmap/dist/maps/jquery.vmap.world.js"></script>
  <script src="<?= base_url(); ?>src/vendors/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>
  <!-- bootstrap-daterangepicker -->
  <script src="<?= base_url(); ?>src/vendors/moment/min/moment.min.js"></script>
  <script src="<?= base_url(); ?>src/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
  <!-- Sweetalert -->
  <!-- <script src="<?= base_url(); ?>src/build/js/sweetalert.js"></script>
	<link rel="stylesheet" href="<?= base_url(); ?>src/build/css/sweetalert.css" /> -->
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script type="text/javascript" src="<?= base_url(); ?>src/select2/js/select2.min.js"></script>
  <!-- Custom Theme Scripts -->
  <script src="<?= base_url(); ?>src/build/js/custom.min.js"></script>

  <script>
    $(document).ready(function() {
      // $('.select2').select2();
      $("select[name='direksi']").change(function() {
        var val = $(this).val();
        if (val == 1) {
          $('#nama_direksi').attr('disabled', false);
        } else {
          $('#nama_direksi').attr('disabled', true);
        }
      })

      $("button[id='btn-keuangan']").click(function(e) {
        var url = $('form[id="update-keuangan"]').attr("action");
        var formData = new FormData($("form#update-keuangan")[0]);
        e.preventDefault();
        Swal.fire({
          title: "Are you sure?",
          text: "You want to submit the form?",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Yes",
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              url: url,
              method: "POST",
              data: formData,
              processData: false,
              contentType: false,
              dataType: "JSON",
              beforeSend: () => {
                Swal.fire({
                  title: "Loading....",
                  timerProgressBar: true,
                  allowOutsideClick: false,
                  didOpen: () => {
                    Swal.showLoading();
                  },
                });
              },
              success: function(res) {
                if (res.success) {
                  Swal.fire({
                    icon: "success",
                    title: `${res.msg}`,
                    showConfirmButton: false,
                    timer: 1500,
                  }).then(function() {
                    Swal.close();
                    location.href = '<?= base_url('pengajuan/approval_keuangan') ?>';
                  });
                } else {
                  Swal.fire({
                    icon: "error",
                    title: `${res.msg}`,
                    showConfirmButton: false,
                    timer: 1500,
                  }).then(function() {
                    Swal.close();
                  });
                }
              },
              error: function(xhr, status, error) {
                Swal.fire({
                  icon: "error",
                  title: `${error}`,
                  showConfirmButton: false,
                  timer: 1500,
                });
              },
            });
          }
        });
      })
      $("button[id='btn-update-bayar']").click(function(e) {
        var url = $('form[id="update-bayar"]').attr("action");
        var formData = new FormData($("form#update-bayar")[0]);
        e.preventDefault();
        Swal.fire({
          title: "Are you sure?",
          text: "You want to submit the form?",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Yes",
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              url: url,
              method: "POST",
              data: formData,
              processData: false,
              contentType: false,
              dataType: "JSON",
              beforeSend: () => {
                Swal.fire({
                  title: "Loading....",
                  timerProgressBar: true,
                  allowOutsideClick: false,
                  didOpen: () => {
                    Swal.showLoading();
                  },
                });
              },
              success: function(res) {
                if (res.success) {
                  Swal.fire({
                    icon: "success",
                    title: `${res.msg}`,
                    showConfirmButton: false,
                    timer: 1500,
                  }).then(function() {
                    Swal.close();
                    location.href = '<?= base_url('pengajuan/approval_keuangan') ?>';
                  });
                } else {
                  Swal.fire({
                    icon: "error",
                    title: `${res.msg}`,
                    showConfirmButton: false,
                    timer: 1500,
                  }).then(function() {
                    Swal.close();
                  });
                }
              },
              error: function(xhr, status, error) {
                Swal.fire({
                  icon: "error",
                  title: `${error}`,
                  showConfirmButton: false,
                  timer: 1500,
                });
              },
            });
          }
        });
      })

      $("button[id='btn-close']").click(function(e) {
        var url = $('form[id="close-pengajuan"]').attr("action");
        var formData = new FormData($("form#close-pengajuan")[0]);
        e.preventDefault();
        Swal.fire({
          title: "Are you sure?",
          text: "You want to submit the form?",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Yes",
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              url: url,
              method: "POST",
              data: formData,
              processData: false,
              contentType: false,
              dataType: "JSON",
              beforeSend: () => {
                Swal.fire({
                  title: "Loading....",
                  timerProgressBar: true,
                  allowOutsideClick: false,
                  didOpen: () => {
                    Swal.showLoading();
                  },
                });
              },
              success: function(res) {
                if (res.success) {
                  Swal.fire({
                    icon: "success",
                    title: `${res.msg}`,
                    showConfirmButton: false,
                    timer: 1500,
                  }).then(function() {
                    Swal.close();
                    location.href = '<?= base_url('pengajuan/approval_keuangan') ?>';
                  });
                } else {
                  Swal.fire({
                    icon: "error",
                    title: `${res.msg}`,
                    showConfirmButton: false,
                    timer: 1500,
                  }).then(function() {
                    Swal.close();
                  });
                }
              },
              error: function(xhr, status, error) {
                Swal.fire({
                  icon: "error",
                  title: `${error}`,
                  showConfirmButton: false,
                  timer: 1500,
                });
              },
            });
          }
        });
      })

      $(document).on('input', 'input[name="realisasi[]"]', function() {
        var value = $(this).val();
        var formattedValue = parseFloat(value.split('.').join(''));
        $(this).val(formattedValue);
      });

      // Tambahkan event listener untuk event keyup
      $(document).on('keyup', 'input[name="realisasi[]"]', function() {
        var value = $(this).val().trim(); // Hapus spasi di awal dan akhir nilai
        var formattedValue = formatNumber(parseFloat(value.split('.').join('')));
        $(this).val(formattedValue);
        if (isNaN(value)) { // Jika nilai input kosong
          $(this).val(''); // Atur nilai input menjadi 0
        }
        var row = $(this).closest('.baris');
      });

      $("select[name='filter']").change(function() {
        // var val = $(this).val();
        $("form[id='form-filter']").submit();
      })
    })
  </script>
  <script>
    function formatNumber(number) {
      return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }
  </script>
</body>

</html>