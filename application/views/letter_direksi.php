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
                <h2>List Approval Direksi</h2>
                <div class="clearfix"></div>
              </div>
              <div class="x_content">
                <div style="margin-bottom:30px">
                  <a href="<?= base_url('letter/list') ?>" class="btn btn-warning"><i class="fa fa-chevron-left" aria-hidden="true"></i> Back</a>
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
                        <th>Format Surat</th>
                        <th>Tanggal</th>
                        <th>Catatan</th>
                        <th>Aksi</th>
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
                          <td><?= $value['nomor_surat'] ?? "-" ?></td>
                          <td><?= $value['nama'] ?></td>
                          <td><?= $value['perusahaan'] ?></td>
                          <td><?= $value['format'] ?></td>
                          <td><?= $value['date_created'] ?></td>
                          <td><?= $value['catatan'] ?? "-" ?></td>
                          <td>
                            <a href="<?= base_url('letter/review/') . $value['id_letter'] ?>" class="aksi badge badge-warning" target="_blank">
                              <i class="fa fa-eye" aria-hidden="true"></i> review
                            </a>
                            <?php if ($value['file'] != null) { ?>
                              <a href="<?= base_url('upload/letter/') . $value['file_name'] ?>" class="badge badge-success" style="cursor: pointer; margin-top:5px;" target="_blank">File Surat</a>
                            <?php } ?>
                          </td>
                          <td>
                            <?php if ($value['status_direksi'] == 0) { ?>
                              <a class="aksi badge badge-success" onclick="update_direksi(<?= $value['id_letter'] ?>)">
                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Update
                              </a>
                            <?php } else { ?>
                              <?php
                              if ($value['status_direksi'] == 1) {
                                echo '<span class="badge badge-success">Disetujui</span>';
                              }
                              if ($value['status_direksi'] == 2) {
                                echo '<span class="badge badge-danger">Ditolak</span>';
                              }
                              ?>
                            <?php } ?>
                            </span>
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
        <!-- Finish content-->
      </div>
      <!-- /page content -->
      <!-- footer content -->
      <!-- /footer content -->
    </div>

    <div class="modal fade" id="modal-update-direksi">
      <div class="modal-dialog modal-centered">
        <div class="modal-content">
          <!-- header-->
          <div class="modal-header">
            <button class="close" data-dismiss="modal"><span>&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Update Direksi</h4>
          </div>
          <!--body-->
          <div class="modal-body">
            <form action="<?= base_url('letter/update_direksi') ?>" id="form-update-direksi" method="post">
              <div class="form-group">
                <input type="text" readonly class="form-control" id="id_surat" name="id_surat">
              </div>
              <div class="form-group" id="error_jenis">
                <label for="status_surat">Status</label>
                <select class="form-control select2" id="status_surat" name="status_surat" style="width:100%;">
                  <option value=""> -- Pilih Status --</option>
                  <option value="1">Disetujui</option>
                  <option value="2">Ditolak</option>
                </select>
                <span id="err_status_direksi" class="text-danger"></span>
              </div>
              <div class="form-group">
                <label for="catatan">Catatan (Opsional)</label>
                <textarea class="form-control" name="catatan" id="catatan" rows="3"></textarea>
              </div>
              <!--footer-->
              <div class="modal-footer">
                <button class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Tutup</button>
                <button type="submit" class="btn btn-primary" id="btn-update-direksi"><i class="fa fa-paper-plane" aria-hidden="true"></i> Update</button>
              </div>
            </form>
          </div>
        </div>
      </div>
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

        $("#btn-update-direksi").click(function(e) {
          e.preventDefault();
          Swal.fire({
            icon: 'warning',
            title: "Apakah anda yakin data surat sudah sesuai dan dapat dipertanggung jawabkan?",
            showCancelButton: true,
            cancelButtonText: "Batal",
            confirmButtonText: "Ya",
          }).then((result) => {
            if (result.isConfirmed) {
              var url = $("#form-update-direksi").attr('action');
              var formData = new FormData($("form#form-update-direksi")[0]);

              $.ajax({
                url: url,
                type: "POST",
                dataType: "JSON",
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: () => {
                  Swal.fire({
                    title: 'Loading...',
                    timerProgressBar: true,
                    allowOutsideClick: false,
                    didOpen: () => {
                      Swal.showLoading()
                    },
                  })
                },
                success: function(res) {
                  if (!res.error) {
                    Swal.fire({
                        type: "success",
                        icon: "success",
                        title: `${res.msg}`,
                        showConfirmButton: false,
                        allowOutsideClick: false,
                      },
                      setTimeout(function() {
                        window.location.reload();
                      }, 1500)
                    );
                  } else {
                    Swal.fire({
                        icon: "error",
                        title: `${res.msg}`,
                        showConfirmButton: false,
                        allowOutsideClick: false,
                      },
                      setTimeout(function() {
                        Swal.close();
                        res.err_status ?
                          $("span#err_status_direksi").html(
                            res.err_status
                          ) :
                          $("span#err_status_direksi").html("");
                      }, 1500)
                    );
                  }
                }
              })
            }
          })
        })
      });
    </script>

    <script>
      function update_direksi(id) {
        $('#modal-update-direksi').modal('show');
        $('#id_surat').val(id);
      }
    </script>
</body>

</html>