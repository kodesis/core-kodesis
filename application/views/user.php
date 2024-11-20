<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="images/favicon.ico" type="image/ico" />
  <title>Kodesis | Business Development</title>
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

  <!-- DataTables -->
  <link href="cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
  <link href="<?= base_url() ?>src/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
  <link href="<?= base_url() ?>src/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
  <link href="<?= base_url() ?>src/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
  <link href="<?= base_url() ?>src/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
  <link href="<?= base_url() ?>src/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">

  <!-- footer menu -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>src/css/mobile_menu/header.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>src/css/mobile_menu/icons.css">

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

    tr>th {
      background-color: #004e81;
      color: white;
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
            <a href="<?php echo base_url(); ?>" class="site_title"><img src="<?php echo base_url(); ?>img/logo-kodesis.png" alt="..." height="42" width="60"><span> Kodesis</span></a>
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

      <!-- Start content-->
      <div class="right_col" role="main">

        <div class="x_panel card">
          <?php if ($this->session->flashdata('success_reset')) { ?>
            <div class="alert alert-success">
              <a href="#" class="close" data-dismiss="alert">&times;</a>
              <strong>Success!</strong> <?php echo $this->session->flashdata('success_reset'); ?>
            </div>
          <?php } ?>
          <?php if ($this->session->flashdata('msg')) { ?>
            <div class="alert alert-success">
              <a href="#" class="close" data-dismiss="alert">&times;</a>
              <strong>Success!</strong> <?php echo $this->session->flashdata('msg'); ?>
            </div>
          <?php } ?>


          <!--div class="alert alert-info">Daftar Surat Kuasa </div-->
          <div align="center">
            <?php
            if (($this->uri->segment(2) == 'send_memo') or ($this->uri->segment(2) == 'send_cari')) {
            ?><font color="brown">Send Memo</font><br><br>
          </div>
          <!-- search -->
          <form data-parsley-validate action="<?php echo base_url(); ?>app/send_cari" method="post" name="form_input" id="form_input">
            <label class="control-label col-md-1 col-sm-1 col-xs-4" for="cari_nama">Filter
              <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-8">
              <input type="text" id="search" name="search" class="form-control col-md-7 col-xs-12" placeholder="isi dengan judul yang akan dicari">
            </div>
            <?php echo form_submit('cari_user', 'Cari', 'class="btn btn-primary"'); ?>
            <input type="button" class="btn btn-primary" value="Tampilkan Semua" onclick="window.location.href='<?php echo base_url(); ?>app/user'" />
          </form>
        <?php } else { ?>
          <font color="brown">List User</font><br><br>
        </div>

        <p>
          <font size="4"><strong data-toggle="collapse" href="#memoCollapse" role="button" aria-expanded="false" aria-controls="memoCollapse">Migrasi Memo <i class="fa fa-arrow-right"></i></font></strong>
        </p>
        <div class="collapse" id="memoCollapse">
          <form action="<?= base_url('app/migration') ?>" method="post" style="margin:3px 0">
            <label for="" class="form-label">Migrasi Memo</label>
            <div class="row">
              <div class="col-md-3" style="margin-bottom:10px">
                <input type="text" class="form-control" name="nip_asal" id="nip_asal" placeholder="Input NIP Asal" value="<?= set_value('nip_asal') ?>">
                <span style="color: red;"><?= form_error('nip_asal') ?? "" ?></span>
              </div>
              <div class="col-md-3">
                <input type="text" class="form-control" name="nip_tujuan" id="nip_tujuan" placeholder="Input NIP Tujuan" value="<?= set_value('nip_tujuan') ?>">
                <span style="color: red;"><?= form_error('nip_tujuan') ?? "" ?></span>
              </div>
              <div class="col-md-3">
                <button type="submit" class="btn btn-success">Kirim</button>
              </div>
            </div>
          </form>

          <form action="<?= base_url('app/read_memo') ?>" method="post" style="margin:3px 0">
            <label for="" class="form-label">Read Memo</label>
            <div class="row">
              <div class="col-md-3" style="margin-bottom:10px">
                <input type="text" class="form-control" name="nip_user" id="nip_user" placeholder="Input NIP User" value="<?= set_value('nip_user') ?>">
                <span style="color: red;"><?= form_error('nip_user') ?? "" ?></span>
              </div>
              <div class="col-md-3">
                <button type="submit" class="btn btn-success">Kirim</button>
              </div>
            </div>
          </form>
        </div>

        <p>
          <font size="4"><strong data-toggle="collapse" href="#tglLibur" role="button" aria-expanded="false" aria-controls="tglLibur">Tanggal Libur <i class="fa fa-arrow-right"></i></font></strong>
        </p>

        <div class="collapse" id="tglLibur">
          <?php
              $this->db->order_by('tgl_libur', "ASC");
              $libur = $this->db->get('libur')->result_array();
          ?>

          <div>
            <form action="<?= base_url('app/addlibur') ?>" method="post">
              <div class="row">
                <div class="col-md-3">
                  <input type="date" class="form-control" placeholder="input tanggal" name="tgl-libur" id="tgl-libur">
                  <span style="color: red;"><?= form_error('tgl-libur') ?? "" ?></span>
                </div>
                <div class="col-md-3">
                  <input type="text" class="form-control" placeholder="Keterangan" name="ket-libur" id="ket-libur">
                  <span style="color: red;"><?= form_error('ket-libur') ?? "" ?></span>
                </div>
                <div class="col-md-3">
                  <button type="submit" class="btn btn-success mt-3">Tambah</button>
                </div>
              </div>
            </form>
          </div>
          <div class="table-responsive" style="margin:10px 0;">
            <table class="table table-striped" width="100%" id="myTable">
              <thead>
                <tr>
                  <th>No.</th>
                  <th>Tanggal</th>
                  <th>Keterangan</th>
                  <th>#</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $i = 1;
                foreach ($libur as $value) {  ?>
                  <tr>
                    <td><?= $i++ ?></td>
                    <td><?= date('D, d F Y', strtotime($value['tgl_libur'])) ?></td>
                    <td><?= $value['keterangan'] ?></td>
                    <td>
                      <form action="<?= base_url('app/del_tgl') ?>" method="post">
                        <input type="hidden" value="<?= $value['Id'] ?>" name="id_tgl" id="id_tgl">
                        <button type="submit" class="btn btn-danger btn-sm" id="btn-hapus-tgl-libur">Hapus</button>
                      </form>
                    </td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>

        <!-- search -->
        <form data-parsley-validate action="<?php echo base_url(); ?>app/user_cari" method="post" name="form_input" id="form_input">
          <label class="control-label col-md-1 col-sm-1 col-xs-4" for="cari_nama">Filter
            <span class="required">*</span>
          </label>
          <div class="col-md-6 col-sm-6 col-xs-8">
            <input type="text" id="search" name="search" class="form-control col-md-7 col-xs-12" placeholder="isi nama atau nip">
          </div>
          <?php echo form_submit('cari_user', 'Cari', 'class="btn btn-primary"'); ?>
          <input type="button" class="btn btn-primary" value="Tampilkan Semua" onclick="window.location.href='<?php echo base_url(); ?>app/user'" />
          <a href="<?= base_url('app/add_user') ?>" class="btn btn-success">Add User</a>
          <a href="<?= base_url('cuti/reset_cuti') ?>" class="btn btn-warning" id="button-reset-cuti">Reset Cuti</a>
        </form>


      <?php } ?>


      <div class="table-responsive">
        <table class="table table-striped">
          <thead>
            <tr>
              <th bgcolor="#34495e">
                <font color="white">No.</font>
              </th>
              <th bgcolor="#34495e">
                <font color="white">Nama</font>
              </th>
              <th bgcolor="#34495e">
                <font color="white">Username</font>
              </th>
              <th bgcolor="#34495e">
                <font color="white">Level</font>
              </th>
              <th bgcolor="#34495e">
                <font color="white">Nip</font>
              </th>
              <th bgcolor="#34495e">
                <font color="white">Status</font>
              </th>

              <!--th bgcolor="#008080"><font color="white">Status</font></th-->
              <th bgcolor="#34495e">
                <font color="white">Detail</font>
              </th>
            </tr>
          </thead>
          <?php
          if ($this->uri->segment(3) == '') {
            $no = 1;
          } else {
            $no = $this->uri->segment(3) + 1;
          }
          if (empty($users_data)) {
          ?>

            <?php
          } else {
            foreach ($users_data as $data) :
            ?>
              <!--content here-->
              <tbody>
                <tr>
                  <?php
                  // $nip = $this->session->userdata('nip');
                  // $kalimat = $data->read;
                  //if (preg_match("/$nip/i", $kalimat)) { 
                  ?>
                  <p style="font-weight: normal;">
                    <td><?php echo $no; ?></td>
                    <td><?php echo $data->nama; ?></td>
                    <td><?php echo $data->username; ?></td>
                    <td><?php echo $data->level; ?></td>
                    <td><?php echo $data->nip; ?></td>
                    <td><?php echo $data->status; ?></td>

                    <td>
                      <!-- <form action="<?php echo base_url() . "app/user_view/" . $data->id; ?>" target="">
								<button type="submit" class="btn btn-dark btn-xs">Open</button>
							</form> -->
                      <a class="btn btn-dark btn-xs" href="<?= base_url('app/user_view/' . $data->id) ?>">Open</a>
                      <a class="btn btn-warning btn-xs" href="<?= base_url('app/user_edit/' . $data->id . '/e') ?>">Edit</a>
                      <a class="btn btn-success btn-xs" href="<?= base_url('app/user_resetpass/' . $data->id) ?>" id="btn-reset-pass">Reset Password</a>
                    </td>

                    <!--td>
						<form action="<?php echo base_url() . "app/surat_keluar_edit/" . $data->id; ?>">
							<button type="submit" class="btn btn-warning btn-xs">Edit</button>
						</form>
					</td-->
                </tr>
              </tbody>

          <?php
              $no++;
            endforeach;
          }
          ?>
        </table>
      </div>

      <!--pagination-->
      <div class="row col-xs-12 text-center">
        <?php echo $pagination; ?>
      </div>

      </div>

      <!-- Finish content-->


      <!-- /page content -->

      <!-- footer content -->

      <!-- /footer content --></br></br>

      <!-- jQuery -->
      <script src="<?php echo base_url(); ?>src/vendors/jquery/dist/jquery.min.js"></script>
      <!-- Bootstrap -->
      <script src="<?php echo base_url(); ?>src/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
      <!-- FastClick -->
      <script src="<?php echo base_url(); ?>src/vendors/fastclick/lib/fastclick.js"></script>
      <!-- NProgress -->
      <script src="<?php echo base_url(); ?>src/vendors/nprogress/nprogress.js"></script>

      <!-- gauge.js -->
      <script src="<?php echo base_url(); ?>src/vendors/gauge.js/dist/gauge.min.js"></script>
      <!-- bootstrap-progressbar -->
      <script src="<?php echo base_url(); ?>src/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
      <!-- iCheck -->
      <script src="<?php echo base_url(); ?>src/vendors/iCheck/icheck.min.js"></script>
      <!-- Skycons -->
      <script src="<?php echo base_url(); ?>src/vendors/skycons/skycons.js"></script>

      <!-- DateJS -->
      <script src="<?php echo base_url(); ?>src/vendors/DateJS/build/date.js"></script>
      <!-- JQVMap -->
      <script src="<?php echo base_url(); ?>src/vendors/jqvmap/dist/jquery.vmap.js"></script>
      <script src="<?php echo base_url(); ?>src/vendors/jqvmap/dist/maps/jquery.vmap.world.js"></script>
      <script src="<?php echo base_url(); ?>src/vendors/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>
      <!-- bootstrap-daterangepicker -->
      <script src="<?php echo base_url(); ?>src/vendors/moment/min/moment.min.js"></script>
      <script src="<?php echo base_url(); ?>src/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>

      <!-- Custom Theme Scripts -->
      <script src="<?php echo base_url(); ?>src/build/js/custom.min.js"></script>

      <!-- Sweetalert -->
      <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

      <!-- DataTables -->
      <script src="<?= base_url() ?>src/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
      <script src="<?= base_url() ?>src/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
      <script src="<?= base_url() ?>src/vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
      <script src="<?= base_url() ?>src/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
      <script src="<?= base_url() ?>src/vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
      <script src="<?= base_url() ?>src/vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
      <script src="<?= base_url() ?>src/vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
      <script src="<?= base_url() ?>src/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
      <script src="<?= base_url() ?>src/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
      <script src="<?= base_url() ?>src/vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
      <script src="<?= base_url() ?>src/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
      <script src="<?= base_url() ?>src/vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>

      <script>
        $(document).ready(function() {
          $("a[id='button-reset-cuti']").click(function(e) {
            if (!confirm('Apakah anda yakin ingin mereset cuti?')) {
              e.preventDefault();
            }

          });

          <?php if ($this->session->flashdata('error')) { ?>
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: '<?= $this->session->flashdata('error') ?>',
            })
          <?php } ?>

          $("button[id='btn-hapus-tgl-libur']").click(function(e) {
            if (!confirm('Apakah anda yakin ingin menghapus tanggal libur tersebut?')) {
              e.preventDefault();
            }
          });


          $('#myTable').dataTable();
        })
      </script>

</body>

</html>