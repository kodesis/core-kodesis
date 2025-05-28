<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="images/favicon.ico" type="image/ico" />
  <title>BDL CORE | Business Development</title>
  <!-- Bootstrap -->
  <link href="<?php echo base_url(); ?>src/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="<?php echo base_url(); ?>src/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <!-- NProgress -->
  <link href="<?php echo base_url(); ?>src/vendors/nprogress/nprogress.css" rel="stylesheet">
  <!-- iCheck -->
  <link href="<?php echo base_url(); ?>src/vendors/iCheck/skins/flat/green.css" rel="stylesheet">

  <!-- bootstrap-progressbar -->
  <link href="<?php echo base_url(); ?>src/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
  <!-- JQVMap -->
  <link href="<?php echo base_url(); ?>src/vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet" />
  <!-- bootstrap-daterangepicker -->
  <link href="<?php echo base_url(); ?>src/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
  <!-- Custom Theme Style -->
  <link href="<?php echo base_url(); ?>src/build/css/custom.min.css" rel="stylesheet">
  <!-- footer menu -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>src/css/mobile_menu/header.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>src/css/mobile_menu/icons.css">

  <!-- CKEditor -->
  <script type="text/javascript" src="<?php echo base_url(); ?>src/ckeditor/ckeditor.js"></script>

  <style>
    .col-xs-3 {
      width: 25%;
      background-color: #008080;
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
  <!-- footer menu -->
  <div class="footer_panel">
    <div class="container-fluid text-center">
      <div class="row">

        <div class="col-xs-3 btn_footer_panel">
          <a href="<?php echo base_url(); ?>app/create_memo">
            <i class="la-i la-i-m la-i-home"></i>
            <div class="tag_">
              <font color="white">Create</font>
            </div>
          </a>
        </div>
        <div class="col-xs-3 btn_footer_panel">
          <a href="<?php echo base_url(); ?>app/inbox">
            <i class="la-i la-i-m la-i-order"></i>
            <div class="tag_">
              <font color="white">Inbox</font>
            </div>
          </a>
        </div>
        <div class="col-xs-3 btn_footer_panel">
          <a href="<?php echo base_url(); ?>app/send_memo">
            <i class="la-i la-i-m la-i-notif"></i>
            <div class="tag_">
              <font color="white">Outbox</font>
            </div>
          </a>
        </div>
        <div class="col-xs-3 btn_footer_panel">
          <a href="<?php echo base_url(); ?>login/logout">
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
            <a href="<?php echo base_url(); ?>" class="site_title"><img src="<?php echo base_url(); ?>img/boc_logo.png" alt="..." height="42" width="60"><span> Bangun Desa</span></a>
          </div>

          <div class="clearfix"></div>

          <!-- menu profile quick info -->
          <div class="profile clearfix">
            <div class="profile_pic">
              <img src="<?php echo base_url(); ?>src/images/img.jpg" alt="..." class="img-circle profile_img">
            </div>
            <div class="profile_info">
              <span>Welcome,</span>
              <h2><?php echo $this->session->userdata('nama'); ?></h2>
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
                  <img src="<?php echo base_url(); ?>src/images/img.jpg" alt=""><?php echo $this->session->userdata('nama'); ?>
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
                  <li><a href="<?php echo base_url(); ?>login/logout"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                </ul>
              </li>

              <li role="presentation" class="dropdown">
                <a href="<?php echo base_url() . "app/inbox"; ?>" class="dropdown-toggle info-number">
                  <i class="fa fa-envelope-o"></i>
                  <?php if ($count_inbox == 0) { ?>
                    <span class="badge bg-green"><?php echo $count_inbox; ?></span>
                  <?php } else { ?>
                    <span class="badge bg-red"><?php echo $count_inbox; ?></span>
                  <?php } ?>
                </a>
              </li>
              <?php include 'notif_tello.php' ?>
            </ul>
          </nav>
        </div>
      </div>
      <!-- /top navigation -->

      <!-- page content -->
      <div class="right_col" role="main">
        <div class="clearfix"></div>
        <!-- Start content-->
        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel card">
              <div class="x_title">
                <?php if (!$this->uri->segment(3)) { ?>
                  <h2>Create Letter</h2>
                <?php } else { ?>
                  <h2>Update Letter</h2>
                <?php } ?>
                <ul class="nav navbar-right panel_toolbox">
                  <li>
                    <a class="collapse-link">
                      <i class="fa fa-chevron-up">
                      </i>
                    </a>
                  </li>
                  <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                      <i class="fa fa-wrench">
                      </i>
                    </a>
                    <ul class="dropdown-menu" role="menu">
                      <li>
                        <a href="#">Settings 1
                        </a>
                      </li>
                      <li>
                        <a href="#">Settings 2
                        </a>
                      </li>
                    </ul>
                  </li>
                  <li>
                    <a class="close-link">
                      <i class="fa fa-close">
                      </i>
                    </a>
                  </li>
                </ul>
                <div class="clearfix">
                </div>
              </div>
              <div class="x_content">

                <div class="">
                  <?php if ($this->session->flashdata('msg')) {
                    echo $this->session->flashdata('msg');
                    unset($_SESSION['msg']);
                  }
                  ?>
                </div>

                <?php if (!$this->uri->segment(3)) { ?>
                  <form action="<?= base_url('letter/insert') ?>" enctype="multipart/form-data" method="post">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="surat" class="form-label">Jenis Surat</label>
                          <select name="surat" id="surat" class="form-control js-example-basic-single" style="width: 100%;">
                            <option value=""> -- Pilih Jenis Surat -- </option>
                            <?php foreach ($surat->result_array() as $val) { ?>
                              <option value="<?= $val['id'] ?>" <?= set_select('surat', $val['kode']) ?>><?= $val['key'] ?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="manager" class="form-label">Tanda Tangan</label>
                          <select name="manager" id="manager" class="form-control js-example-basic-single" style="width: 100%;">
                            <option value=""> -- Pilih Tanda Tangan -- </option>
                            <?php foreach ($manager->result_array() as $val) { ?>
                              <option value="<?= $val['nip'] ?>" <?= set_select('manager', $val['nip']) ?>><?= $val['nama'] ?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="alamat-surat">Alamat Surat</label>
                          <input type="text" class="form-control" name="alamat-surat" id="alamat-surat" placeholder="Contoh : Jakarta">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="lampiran" class="form-label">Lampiran Surat</label>
                          <input type="number" class="form-control" id="lampiran" name="lampiran" value="<?= set_value('lampiran') ?>">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="perihal" class="form-label">Perihal Surat</label>
                          <textarea name="perihal" id="perihal" class="ckeditor"><?= set_value('perihal') ?></textarea>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="kepada" class="form-label">Tujuan Surat</label>
                          <textarea name="kepada" id="kepada" class="ckeditor" rows="2"><?= set_value('kepada') ?></textarea>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="alamat" class="form-label">Alamat Tujuan</label>
                          <textarea name="alamat" id="alamat" class="ckeditor" rows="2"><?= set_value('alamat') ?></textarea>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="isi" class="form-label">Isi Surat</label>
                          <textarea name="isi" id="isi" class="ckeditor" rows="10"><?= set_value('isi') ?></textarea>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="catatan" class="form-label">Catatan</label>
                          <textarea name="catatan" id="catatan" class="form-control" rows="3"><?= set_value('isi') ?></textarea>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <button type="reset" class="btn btn-danger">Reset</button>
                        <button class="btn btn-primary" type="submit">Simpan</button>
                      </div>
                    </div>
                  </form>
                <?php } else { ?>
                  <form action="<?= base_url('letter/update/') . $this->uri->segment(3) ?>" enctype="multipart/form-data" method="post">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="surat" class="form-label">Jenis Surat</label>
                          <select name="surat" id="surat" class="form-control js-example-basic-single" style="width: 100%;">
                            <option value=""> -- Pilih Jenis Surat -- </option>
                            <?php foreach ($jenis_surat->result_array() as $val) { ?>
                              <option value="<?= $val['id'] ?>" <?= $letter['jenis_surat'] == $val['id'] ? 'selected' : "" ?>><?= $val['key'] ?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="manager" class="form-label">Manager</label>
                          <select name="manager" id="manager" class="form-control js-example-basic-single" style="width: 100%;">
                            <option value=""> -- Pilih Manager -- </option>
                            <?php foreach ($manager->result_array() as $val) { ?>
                              <option value="<?= $val['nip'] ?>" <?= $letter['ttd'] == $val['nip'] ? 'selected' : '' ?>><?= $val['nama'] ?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="alamat-surat" class="form-label">Alamat Surat</label>
                          <input type="text" class="form-control" id="alamat-surat" name="alamat-surat" value="<?= $letter['alamat_surat'] ?>">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="lampiran" class="form-label">Lampiran</label>
                          <input type="number" class="form-control" id="lampiran" name="lampiran" value="<?= $letter['lampiran'] ?>">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="perihal" class="form-label">Perihal</label>
                          <textarea name="perihal" id="perihal" class="ckeditor"><?= $letter['perihal'] ?></textarea>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="kepada" class="form-label">Kepada</label>
                          <textarea name="kepada" id="kepada" class="ckeditor"><?= $letter['kepada'] ?></textarea>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="alamat" class="form-label">Alamat</label>
                          <textarea name="alamat" id="alamat" class="ckeditor"><?= $letter['alamat'] ?></textarea>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="isi" class="form-label">Isi Surat</label>
                          <textarea name="isi" id="isi" class="ckeditor" rows="10"><?= $letter['isi'] ?></textarea>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="catatan" class="form-label">Catatan</label>
                          <textarea name="catatan" id="catatan" class="form-control" rows="3"><?= $letter['catatan'] ?></textarea>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <a href="<?= base_url('letter/list') ?>" class="btn btn-warning">Back</a>
                        <button class="btn btn-primary" type="submit">Simpan</button>
                      </div>
                    </div>
                  </form>
                <?php } ?>
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
    <script src="<?php echo base_url(); ?>src/vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="<?php echo base_url(); ?>src/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="<?php echo base_url(); ?>src/vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="<?php echo base_url(); ?>src/vendors/nprogress/nprogress.js"></script>
    <!-- Chart.js -->
    <script src="<?php echo base_url(); ?>src/vendors/Chart.js/dist/Chart.min.js"></script>
    <!-- gauge.js -->
    <script src="<?php echo base_url(); ?>src/vendors/gauge.js/dist/gauge.min.js"></script>
    <!-- bootstrap-progressbar -->
    <script src="<?php echo base_url(); ?>src/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    <!-- iCheck -->
    <script src="<?php echo base_url(); ?>src/vendors/iCheck/icheck.min.js"></script>
    <!-- Skycons -->
    <script src="<?php echo base_url(); ?>src/vendors/skycons/skycons.js"></script>
    <!-- Flot -->
    <script src="<?php echo base_url(); ?>src/vendors/Flot/jquery.flot.js"></script>
    <script src="<?php echo base_url(); ?>src/vendors/Flot/jquery.flot.pie.js"></script>
    <script src="<?php echo base_url(); ?>src/vendors/Flot/jquery.flot.time.js"></script>
    <script src="<?php echo base_url(); ?>src/vendors/Flot/jquery.flot.stack.js"></script>
    <script src="<?php echo base_url(); ?>src/vendors/Flot/jquery.flot.resize.js"></script>
    <!-- Flot plugins -->
    <script src="<?php echo base_url(); ?>src/vendors/flot.orderbars/js/jquery.flot.orderBars.js"></script>
    <script src="<?php echo base_url(); ?>src/vendors/flot-spline/js/jquery.flot.spline.min.js"></script>
    <script src="<?php echo base_url(); ?>src/vendors/flot.curvedlines/curvedLines.js"></script>
    <!-- DateJS -->
    <script src="<?php echo base_url(); ?>src/vendors/DateJS/build/date.js"></script>
    <!-- JQVMap -->
    <script src="<?php echo base_url(); ?>src/vendors/jqvmap/dist/jquery.vmap.js"></script>
    <script src="<?php echo base_url(); ?>src/vendors/jqvmap/dist/maps/jquery.vmap.world.js"></script>
    <script src="<?php echo base_url(); ?>src/vendors/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="<?php echo base_url(); ?>src/vendors/moment/min/moment.min.js"></script>
    <script src="<?php echo base_url(); ?>src/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
    <!-- Sweetalert -->
    <!-- <script src="<?php echo base_url(); ?>src/build/js/sweetalert.js"></script>
	<link rel="stylesheet" href="<?php echo base_url(); ?>src/build/css/sweetalert.css" /> -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Select2 -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>src/select2/css/select2.min.css">
    <script type="text/javascript" src="<?php echo base_url(); ?>src/select2/js/select2.min.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="<?php echo base_url(); ?>src/build/js/custom.min.js"></script>


    <script>
      $(document).ready(function() {
        $('.js-example-basic-single').select2();

        $("select[id='surat']").change(function() {
          var kode = $(this).val();
          $.ajax({
            url: '<?= base_url('letter/get_perusahaan/') ?>' + kode,
            dataType: "JSON",
            method: "GET",
            success: function(res) {
              $("#perusahaan").html(res.option);
            }
          })
        })

        $("select[id='perusahaan']").change(function() {
          var perusahaan = $(this).val();
          var surat = $("select[id='surat']").val();
          $.ajax({
            url: '<?= base_url('letter/get_format/') ?>',
            dataType: "JSON",
            method: "GET",
            data: {
              perusahaan: perusahaan,
              surat: surat
            },
            success: function(res) {
              $("#format").html(res.option);
            }
          })
        })
      });
    </script>
</body>

</html>