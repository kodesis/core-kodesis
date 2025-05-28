<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="images/favicon.ico" type="image/ico" />
  <title>Mlejit Office | Business Development</title>
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

  <!-- Datatables -->
  <link href="cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
  <link href="<?= base_url() ?>src/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
  <link href="<?= base_url() ?>src/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
  <link href="<?= base_url() ?>src/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
  <link href="<?= base_url() ?>src/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
  <link href="<?= base_url() ?>src/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">

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

    .badge-success {
      background-color: green;
    }

    .badge-danger {
      background-color: red;
    }

    .badge-warning {
      background-color: orange;
    }

    td {
      padding: 0 3px;
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
                <h2>List Pengajuan</h2>
                <div class="clearfix"></div>
              </div>
              <div class="x_content">
                <div style="margin-bottom:30px">
                  <?php
                  $nip = $this->session->userdata('nip');
                  $user = $this->db->get_where('users', ['nip' => $nip])->row_array();
                  ?>

                  <!-- Create Pengajuan -->
                  <a href="<?= base_url('letter/create') ?>" class="btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i> Create</a>

                  <?php
                  $a = $this->session->userdata('level');
                  ?>
                  <!-- Menu admin corsec -->
                  <?php if (strpos($a, '702') !== false) { ?>
                    <a href="<?= base_url('letter/admin') ?>" class="btn btn-success"><i class="fa fa-list-ol" aria-hidden="true"></i> Approval Admin <span class="badge bg-red"><?= $count_admin > 0 ? $count_admin : "0" ?></span></a>
                  <?php } ?>

                  <!-- Menu Manager Corsec -->
                  <?php if (strpos($a, '703') !== false) { ?>
                    <a href="<?= base_url('letter/smcorsec') ?>" class="btn btn-success"><i class="fa fa-list-ol" aria-hidden="true"></i> Approval SM <span class="badge bg-red"><?= $count_smcorsec > 0 ? $count_smcorsec : "0" ?></span></a>
                  <?php } ?>

                  <!-- Menu Direksi -->
                  <?php if ($user['level_jabatan'] > 4) { ?>
                    <a href="<?= base_url('letter/direksi') ?>" class="btn btn-success"><i class="fa fa-list-ol" aria-hidden="true"></i> Approval Direksi <span class="badge bg-red"><?= $count_direksi > 0 ? $count_direksi : "0" ?></span></a>
                  <?php } ?>
                </div>
                <div class="table-responsive">
                  <table class="table table-striped jambo_table bulk_action" id="myTable">
                    <thead>
                      <tr>
                        <th>No.</th>
                        <th>No. Pengajuan</th>
                        <th>No. Surat</th>
                        <th>Jenis Surat</th>
                        <th>Nama Perusahaan</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                        <th>Catatan</th>
                        <th>#</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $no = 1;
                      foreach ($surat->result_array() as $value) {
                      ?>
                        <tr>
                          <td><?= $no++ ?></td>
                          <td><?= $value['no_pengajuan'] ?></td>
                          <td><?= $value['nomor_surat'] ?? '-' ?></td>
                          <td><?= $value['nama'] ?></td>
                          <td><?= $value['perusahaan'] ?></td>
                          <td><?= $value['date_created'] ?></td>
                          <td>
                            <a href="<?= base_url('letter/review/') . $value['id_letter'] ?>" class="aksi badge badge-warning" target="_blank">
                              <i class="fa fa-eye" aria-hidden="true"></i> Review
                            </a>

                            <!-- Re-submission -->
                            <?php if ($value['status_admin'] == 2 or $value['status_sm_corsec'] == 2 or $value['status_direksi'] == 2) { ?>
                              <a href="<?= base_url('letter/update_user/') . $value['id_letter'] ?>" class="aksi badge badge-success" style="margin-top: 3px;">
                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Re-submission
                              </a>
                            <?php } ?>

                            <!-- Export word -->
                            <?php
                            if ($value['status_admin'] == 1 and $value['status_sm_corsec'] == 1) {
                            ?>
                              <a href="<?= base_url('letter/word/' . $value['id_letter']) ?>" class="badge badge-primary" style="cursor: pointer; margin-top:5px;"><i class="fa fa-file-word-o" aria-hidden="true"></i> Download Docs</a>
                            <?php } ?>

                            <!-- Upload file surat -->
                            <?php
                            if ($value['status_admin'] == 1 and $value['status_sm_corsec'] == 1 and $value['file'] == null) {
                            ?>
                              <span class="badge badge-success" style="cursor: pointer; margin-top:5px;" onclick="upload_file(<?= $value['id_letter'] ?>)"><i class="fa fa-plus" aria-hidden="true"></i> Upload File</span>
                            <?php } ?>

                            <!-- View file surat -->
                            <?php if ($value['file'] != null) { ?>
                              <a href="<?= base_url('upload/letter/') . $value['file_name'] ?>" class="badge badge-success" style="cursor: pointer; margin-top:5px;" target="_blank"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> File Surat</a>
                            <?php } ?>
                          </td>
                          <td>
                            <span class="badge badge-warning" style="cursor: pointer;" onclick="get_catatan(<?= $value['id_letter'] ?>)"><i class="fa fa-eye" aria-hidden="true"></i> View</span>
                          </td>
                          <td>
                            <?php

                            // status admin
                            if ($value['status_admin'] == 1) {
                              $status_admin =  '<span class="badge badge-success">Disetujui Admin Corsec</span>';
                            } else if ($value['status_admin'] == 2) {
                              $status_admin = '<span class="badge badge-danger">Ditolak Admin Corsec</span>';
                            } else {
                              $status_admin = '<span class="badge badge-secondary">Diajukan kepada Admin Corsec</span>';
                            }

                            // status sm corse
                            if ($value['status_sm_corsec'] == 1) {
                              $status_sm_corsec =  '<span class="badge badge-success">Disetujui SM Corsec</span>';
                            } else if ($value['status_sm_corsec'] == 2) {
                              $status_sm_corsec = '<span class="badge badge-danger">Ditolak SM Corsec</span>';
                            } else {
                              $status_sm_corsec = '<span class="badge badge-secondary">Diajukan kepada SM Corsec</span>';
                            }

                            // status direksi
                            if ($value['status_direksi'] == 1) {
                              $status_direksi =  '<span class="badge badge-success">Disetujui Direksi</span>';
                            } else if ($value['status_direksi'] == 2) {
                              $status_direksi = '<span class="badge badge-danger">Ditolak Direksi</span>';
                            } else {
                              $status_direksi = '<span class="badge badge-secondary">Diajukan kepada Direksi</span>';
                            }

                            if ($value['status_admin'] != 1) {
                              echo $status_admin;
                            }

                            if ($value['status_admin'] == 1) {
                              echo $status_admin . $status_sm_corsec;
                            }

                            // if ($value['kode'] == "SKDIR") {
                            //   if ($value['status_sm_corsec'] == 1) {
                            //     echo $status_direksi;
                            //   }
                            // }
                            ?>
                          </td>
                        </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="modal fade" id="myModal1" role="dialog">
          <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h2 class="modal-title">File Surat</h2>
              </div>
              <div class="modal-body">
                <form action="<?= base_url('letter/upload_file') ?>" method="post" enctype="multipart/form-data" id="form-upload-file">
                  <input type="text" name="id_letter" id="id_letter" class="form-control">
                  <div class="form-group">
                    <label for="file">File Surat</label>
                    <input type="file" class="form-control" name="file" id="file">
                  </div>
                  <div>
                    <button type="submit" class="btn btn-primary" id="btn-upload">Upload</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>

        <div class="modal fade" id="myModal2" role="dialog">
          <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h2 class="modal-title">Catatan</h2>
              </div>
              <div class="modal-body">
                <table class="table table-striped">
                  <tr>
                    <th>Catatan User</th>
                    <td>:</td>
                    <td id="catatan_user"></td>
                  </tr>
                  <tr>
                    <th>Catatan Admin</th>
                    <td>:</td>
                    <td id="catatan_admin"></td>
                  </tr>
                  <tr>
                    <th>Catatan SM Corsec</th>
                    <td>:</td>
                    <td id="catatan_sm_corsec"></td>
                  </tr>
                  <tr>
                    <th>Catatan Direksi</th>
                    <td>:</td>
                    <td id="catatan_direksi"></td>
                  </tr>
                </table>
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
    <!-- Datatables -->
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
        $('.js-example-basic-single').select2();
        $('#myTable').DataTable()

        $("button[id='btn-upload']").click(function(e) {
          e.preventDefault();
          var url = $('form[id="form-upload-file"]').attr("action");
          var formData = new FormData($("form#form-upload-file")[0]);
          Swal.fire({
            title: "Are you sure?",
            text: "You want upload this file?",
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
                      location.reload();
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
      });
    </script>

    <script>
      function upload_file(id) {
        $('#myModal1').modal('show');
        $("#id_letter").val(id);
      }

      function get_catatan(id) {

        $.ajax({
          url: '<?= base_url('letter/get_catatan') ?>',
          method: "post",
          dataType: "JSON",
          data: {
            id: id
          },
          success: function(res) {
            $('#myModal2').modal('show');
            res.catatan ? $('td#catatan_user').html(res.catatan) : $('td#catatan_user').html('-');
            res.catatan_admin ? $('td#catatan_admin').html(res.catatan_admin) : $('td#catatan_admin').html('-');
            res.catatan_sm_corsec ? $('td#catatan_sm_corsec').html(res.catatan_sm_corsec) : $('td#catatan_sm_corsec').html('-');
            res.catatan_direksi ? $('td#catatan_direksi').html(res.catatan_direksi) : $('td#catatan_direksi').html('-');
            console.log(res);
          }
        })
      }
    </script>

    <!-- <script>
      function get_catatan(id) {
        $.ajax({
          url: <?= base_url('letter/get_catatan/') ?> + id,
          method: "GET",
          dataType: "JSON",
          success: function(res) {
            $('#myModal2').modal('show');
            console.log(res);
          }
        })
      }
    </script> -->
</body>

</html>