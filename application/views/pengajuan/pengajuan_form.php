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
  <title>Kodesis | Business Development</title>
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
                <!--ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
                    <li>
                      <a>
                        <span class="image"><img src="<?= base_url(); ?>src/images/img.jpg" alt="Profile Image" /></span>
                        <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                        <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                      </a>
                    </li>
                    <li>
                      <a>
                        <span class="image"><img src="<?= base_url(); ?>src/images/img.jpg" alt="Profile Image" /></span>
                        <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                        <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                      </a>
                    </li>
                    <li>
                      <a>
                        <span class="image"><img src="<?= base_url(); ?>src/images/img.jpg" alt="Profile Image" /></span>
                        <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                        <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                      </a>
                    </li>
                    <li>
                      <a>
                        <span class="image"><img src="<?= base_url(); ?>src/images/img.jpg" alt="Profile Image" /></span>
                        <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                        <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                      </a>
                    </li>
                    <li>
                      <div class="text-center">
                        <a>
                          <strong>See All Alerts</strong>
                          <i class="fa fa-angle-right"></i>
                        </a>
                      </div>
                    </li>
                  </ul-->
              </li>
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
                <h2>Create Pengajuan</h2>
              </div>
              <div class="x_content">
                <?php if (!$this->uri->segment(3)) { ?>
                  <form class="form-horizontal form-label-left" method="POST" action="<?= base_url('pengajuan/insert') ?>" enctype="multipart/form-data" id="form-pengajuan">
                    <div class="row" style="margin-bottom: 30px">
                      <div class="col-md-2">
                        <label for="tanggal" class="form-label">Tangal</label>
                        <input type="date" class="form-control" name="tanggal" id="tanggal" value="<?php echo date('Y-m-d'); ?>">
                      </div>
                      <div class="col-md-3">
                        <label for="no_rekening" class="form-label">No. Rekening</label>
                        <input type="text" class="form-control" name="rekening" id="rekening">
                      </div>
                      <div class="col-md-3">
                        <label for="metode" class="form-label">Metode Pembayaran</label>
                        <select name="metode" id="metode" class="form-control">
                          <option value=""> -- Pilih Metode Pembayaran -- </option>
                          <option value="Reimburse">Reimburse</option>
                          <option value="Transfer">Transfer</option>
                        </select>
                      </div>
                      <div class="col-md-4">
                        <label for="bukti" class="form-label">File Bukti</label>
                        <input type="file" class="form-control" name="bukti" id="bukti">
                      </div>
                      <div class="col-md-12">
                        <label for="catatan" class="form-label">Catatan</label>
                        <textarea name="catatan" id="catatan" class="form-control"></textarea>
                      </div>
                    </div>
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th>Item</th>
                          <th>Qty</th>
                          <th>Price</th>
                          <th>Total</th>
                          <th>#</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr class="baris">
                          <td>
                            <input type="hidden" name="row[]" id="row">
                            <input type="text" class="form-control" name="item[]" id="item">
                          </td>
                          <td>
                            <input type="text" class="form-control" name="qty[]" id="qty" value="0">
                          </td>
                          <td>
                            <input type="text" class="form-control" name="harga[]" id="price" value="0">
                          </td>
                          <td>
                            <input type="text" class="form-control" name="total[]" id="total" readonly>
                          </td>
                          <td>
                            <button type="button" class="btn btn-danger hapusRow">Hapus</button>
                          </td>
                        </tr>
                        <tr align="right">
                          <td colspan="3">TOTAL</td>
                          <td>
                            <input type="text" class="form-control" readonly name="nominal" id="nominal">
                          </td>
                          <td></td>
                        </tr>
                        <tr>
                          <td colspan="5">
                            <button type="button" class="btn btn-success btn-sm" id="addRow">Add new row</button>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                    <div class="row">
                      <div class="col-lg-12 text-end">
                        <a href="<?= base_url('pengajuan/list') ?>" class="btn btn-warning">Back</a>
                        <button type="submit" class="btn btn-primary" id="btn-save">Save</button>
                      </div>
                    </div>
                  </form>
                <?php } else { ?>
                  <form class="form-horizontal form-label-left" method="POST" action="<?= base_url('pengajuan/update/' . $this->uri->segment(3)) ?>" enctype="multipart/form-data" id="form-pengajuan">
                    <div class="row" style="margin-bottom: 30px">
                      <div class="col-md-2">
                        <label for="tanggal" class="form-label">Tangal</label>
                        <input type="date" class="form-control" name="tanggal" id="tanggal" value="<?= date('Y-m-d', strtotime($pengajuan['created_at'])); ?>">
                      </div>
                      <div class="col-md-3">
                        <label for="no_rekening" class="form-label">No. Rekening</label>
                        <input type="text" class="form-control" name="rekening" id="rekening" value="<?= $pengajuan['no_rekening'] ?>">
                      </div>
                      <div class="col-md-3">
                        <label for="metode" class="form-label">Metode Pembayaran</label>
                        <select name="metode" id="metode" class="form-control">
                          <option value=""> -- Pilih Metode Pembayaran -- </option>
                          <option value="Reimburse" <?= $pengajuan['metode_pembayaran'] == 'Reimburse' ? 'selected' : '' ?>>Reimburse</option>
                          <option value="Transfer" <?= $pengajuan['metode_pembayaran'] == 'Transfer' ? 'selected' : '' ?>>Transfer</option>
                        </select>
                      </div>
                      <div class="col-md-4">
                        <label for="bukti" class="form-label">File Bukti</label>
                        <input type="file" class="form-control" name="bukti" id="bukti">
                        <span>Attacment : <?= $pengajuan['bukti_pengajuan'] ?></span>
                      </div>
                      <div class="col-md-12">
                        <label for="catatan" class="form-label">Catatan</label>
                        <textarea name="catatan" id="catatan" class="form-control"><?= $pengajuan['catatan'] ?></textarea>
                      </div>
                    </div>
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th>Item</th>
                          <th>Qty</th>
                          <th>Price</th>
                          <th>Total</th>
                          <th>#</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $detail = $this->cb->get_where('t_pengajuan_detail', ['no_pengajuan' => $pengajuan['no_pengajuan']])->result_array();
                        foreach ($detail as $data) {
                        ?>
                          <tr class="baris">
                            <td>
                              <input type="hidden" name="row[]" id="row">
                              <input type="hidden" class="form-control" name="id_item[]" id="id_item" value="<?= $data['Id'] ?>" readonly>
                              <input type="text" class="form-control" name="item[]" id="item" value="<?= $data['item'] ?>">
                            </td>
                            <td>
                              <input type="text" class="form-control" name="qty[]" id="qty" value="<?= $data['qty'] ?>">
                            </td>
                            <td>
                              <input type="text" class="form-control" name="harga[]" id="price" value="<?= number_format($data['price'], 0, ',', '.') ?>">
                            </td>
                            <td>
                              <input type="text" class="form-control" name="total[]" id="total" readonly value="<?= number_format($data['total'], 0, ',', '.') ?>">
                            </td>
                            <td>
                              <!-- <button type="button" class="btn btn-danger" onclick="deleteRow(<?= $data['Id'] ?>)">Hapus</button> -->
                              <button type="button" class="btn btn-danger hapusRow">Hapus</button>
                            </td>
                          </tr>
                        <?php } ?>
                        <tr align="right">
                          <td colspan="3">TOTAL</td>
                          <td>
                            <input type="text" class="form-control" readonly name="nominal" id="nominal">
                          </td>
                          <td></td>
                        </tr>
                        <tr>
                          <td colspan="5">
                            <button type="button" class="btn btn-success btn-sm" id="addRow">Add new row</button>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                    <div class="row">
                      <div class="col-lg-12 text-end">
                        <a href="<?= base_url('pengajuan/list') ?>" class="btn btn-warning">Back</a>
                        <button type="submit" class="btn btn-primary" id="btn-save">Update</button>
                      </div>
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



  <script src="<?= base_url(); ?>src/vendors/jquery/dist/jquery.min.js"></script>
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
  <!-- Select2 -->
  <link rel="stylesheet" href="<?= base_url(); ?>src/select2/css/select2.min.css">
  <script type="text/javascript" src="<?= base_url(); ?>src/select2/js/select2.min.js"></script>

  <!-- Custom Theme Scripts -->
  <script src="<?= base_url(); ?>src/build/js/custom.min.js"></script>

  <script>
    $(document).ready(function() {
      $('.js-example-basic-multiple').select2();
      $('.select2').select2();

      $("form").on("submit", function() {
        Swal.fire({
          title: "Loading...",
          timerProgressBar: true,
          allowOutsideClick: false,
          didOpen: () => {
            Swal.showLoading()
          },
        });
      });

      $("button[id='btn-save']").click(function(e) {
        var url = $('form[id="form-pengajuan"]').attr("action");
        var formData = new FormData($("form#form-pengajuan")[0]);
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

    // function deleteRow(id) {
    //   Swal.fire({
    //     title: "Are you sure?",
    //     text: "You want delete this item?",
    //     icon: "warning",
    //     showCancelButton: true,
    //     confirmButtonColor: "#3085d6",
    //     cancelButtonColor: "#d33",
    //     confirmButtonText: "Yes",
    //   }).then((result) => {
    //     $.ajax({
    //       url: '<?= base_url('pengajuan/deleteItem/') ?>' + id,
    //       dataType: "JSON",
    //       method: "POST",
    //     })
    //   })
    // }

    function formatNumber(number) {
      return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    function format_angka() {
      var nominal = document.getElementById('input_nominal').value;

      var formattedValue = formatNumber(parseFloat(nominal.split('.').join('')));

      document.getElementById('input_nominal').value = formattedValue;
    }

    const flashdata_error = $(".flash-data-error").data("flashdata");

    if (flashdata_error) {
      Swal.fire({
        title: "Error!! ",
        text: flashdata_error,
        type: "error",
        icon: "error",
      });
    }
  </script>
  <script>
    $(document).ready(function() {
      updateTotalItem()
      var rowCount = 1; // Inisialisasi row
      $('#addRow').on('click', function() {
        // Periksa apakah ada input yang kosong di baris sebelumnya
        var previousRow = $('.baris').last();
        var inputs = previousRow.find('input[type="text"], input[type="datetime-local"]');
        var isEmpty = false;

        inputs.each(function() {
          if ($(this).val().trim() === '') {
            isEmpty = true;
            return false; // Berhenti iterasi jika ditemukan input kosong
          }
        });

        // Jika ada input yang kosong, tampilkan pesan peringatan
        if (isEmpty) {
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Mohon isi semua input pada baris sebelumnya terlebih dahulu!',
          });
          return; // Hentikan penambahan baris baru
        }

        // Salin baris terakhir
        var newRow = previousRow.clone();

        // Kosongkan nilai input di baris baru
        newRow.find('input').val('');
        newRow.find('input[name="qty[]"]').val('0');
        newRow.find('input[name="harga[]"]').val('0');

        // Perbarui tag <h4> pada baris baru dengan nomor urut yang baru
        rowCount++;

        // Tambahkan baris baru setelah baris terakhir
        previousRow.after(newRow);
      });

      // Saat input qty atau harga diubah
      $(document).on('input', 'input[name="qty[]"], input[name="harga[]"]', function() {
        var value = $(this).val();
        var formattedValue = parseFloat(value.split('.').join(''));
        $(this).val(formattedValue);

        var row = $(this).closest('.baris');
        hitungTotal(row);
        updateTotalItem();
        updateTotal();
      });

      // Tambahkan event listener untuk event keyup
      $(document).on('keyup', 'input[name="qty[]"], input[name="harga[]"]', function() {
        var value = $(this).val().trim(); // Hapus spasi di awal dan akhir nilai
        var formattedValue = formatNumber(parseFloat(value.split('.').join('')));
        $(this).val(formattedValue);
        if (isNaN(value)) { // Jika nilai input kosong
          $(this).val(''); // Atur nilai input menjadi 0
        }
        var row = $(this).closest('.baris');
        hitungTotal(row);
        updateTotalItem();
        updateTotal();
      });

      function hitungTotal(row) {
        var qty = row.find('input[name="qty[]"]').val().replace(/\./g, ''); // Hapus tanda titik
        var harga = row.find('input[name="harga[]"]').val().replace(/\./g, ''); // Hapus tanda titik
        qty = parseInt(qty); // Ubah string ke angka float
        harga = parseInt(harga); // Ubah string ke angka float

        qty = isNaN(qty) ? 0 : qty;
        harga = isNaN(harga) ? 0 : harga;

        var total = qty * harga;
        row.find('input[name="total[]"]').val(formatNumber(total));
        updateTotalItem();
      }

      function updateTotalItem() {
        var total_pos_fix = 0;
        $(".baris").each(function() {
          var total = $(this).find('input[name="total[]"]').val().replace(/\./g, ''); // Ambil nilai total dari setiap baris
          total = parseFloat(total); // Ubah string ke angka float
          if (!isNaN(total)) { // Pastikan total adalah angka
            total_pos_fix += total; // Tambahkan nilai total ke total_pos_fix
          }
        });
        $('#nominal').val(formatNumber(total_pos_fix)); // Atur nilai input #nominal dengan total_pos_fix
      }

      function formatNumber(number) {
        return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
      }

      // Tambahkan event listener untuk tombol hapus row
      $(document).on('click', '.hapusRow', function() {
        $(this).closest('.baris').remove();
        updateTotalItem(); // Perbarui total belanja setelah menghapus baris
        updateTotal();
      });

      // Saat opsi diskon berubah
      $('#diskon').on('change', function() {
        // Panggil fungsi untuk mengupdate besaran diskon dan total
        updateTotal();
      });
      $('#pajak').on('change', function() {
        // Panggil fungsi untuk mengupdate besaran diskon dan total
        updateTotal();
      });

      // Fungsi untuk mengupdate besaran diskon dan total
      function updateTotal() {
        var diskon = parseFloat($('#diskon').val());
        var pajak = parseFloat($('#pajak').val());
        var subtotal = 0;
        // Hitung subtotal dari total setiap baris
        $('.baris').each(function() {
          var totalBaris = parseInt($(this).find('input[name="total[]"]').val().replace(/\./g, '') || 0);
          subtotal += totalBaris;
        });
        // Hitung besaran diskon
        var besaranDiskon = subtotal * diskon;
        // Hitung total setelah diskon
        var total = subtotal - besaranDiskon;
        var besaranPajak = total * pajak;
        var grandtotal = total + besaranPajak;
        // Atur nilai input besaran_diskon dan total dengan format angka yang sesuai
        $('#besaran_pajak').val(formatNumber(besaranPajak));
        $('#besaran_diskon').val(formatNumber(besaranDiskon));
        $('#grandtotal').val(formatNumber(grandtotal));
      }

      $('#diskonEdit').on('change', function() {
        // Panggil fungsi untuk mengupdate besaran diskon dan total
        updateTotalEdit();
      });

      function updateTotalEdit() {
        var diskon = parseFloat($('#diskonEdit').val());

        var subtotal = parseInt($('#nominal').val().replace(/\./g, '') || 0);

        // Hitung besaran diskon
        var besaranDiskon = subtotal * diskon;
        // Hitung total setelah diskon
        var total = subtotal - besaranDiskon;
        // Atur nilai input besaran_diskon dan total dengan format angka yang sesuai
        $('#besaran_diskon').val(formatNumber(besaranDiskon));
        $('#grandtotal').val(formatNumber(total));
      }

      $('#diskonEdit').on('change', function() {
        // Panggil fungsi untuk mengupdate besaran diskon dan total
        updateTotalEdit();
      });

      function updateTotalEdit() {
        var diskon = parseFloat($('#diskonEdit').val());

        var subtotal = parseInt($('#nominal').val().replace(/\./g, '') || 0);

        // Hitung besaran diskon
        var besaranDiskon = subtotal * diskon;
        // Hitung total setelah diskon
        var total = subtotal - besaranDiskon;
        // Atur nilai input besaran_diskon dan total dengan format angka yang sesuai
        $('#besaran_diskon').val(formatNumber(besaranDiskon));
        $('#grandtotal').val(formatNumber(total));
      }


      $(document).on('input', 'input[name="qty"], input[name="harga"]', function() {
        var value = $(this).val();
        var formattedValue = parseFloat(value.split('.').join(''));
        $(this).val(formattedValue);

        var row = $(this).closest('.baris');
        hitungTotalItem(row);
      });

      function hitungTotalItem(row) {
        var qty = row.find('input[name="qty"]').val().replace(/\./g, ''); // Hapus tanda titik
        var harga = row.find('input[name="harga"]').val().replace(/\./g, ''); // Hapus tanda titik
        qty = parseInt(qty); // Ubah string ke angka float
        harga = parseInt(harga); // Ubah string ke angka float

        qty = isNaN(qty) ? 0 : qty;
        harga = isNaN(harga) ? 0 : harga;

        var total = qty * harga;
        row.find('input[name="harga"]').val(formatNumber(harga));
        row.find('input[name="total"]').val(formatNumber(total));
      }

      $('#addNewRow').on('click', function() {
        // Periksa apakah ada input yang kosong di baris sebelumnya
        var previousRow = $('.barisEdit').last();
        var inputs = previousRow.find('input[type="text"], input[type="datetime-local"]');
        var isEmpty = false;

        inputs.each(function() {
          if ($(this).val().trim() === '') {
            isEmpty = true;
            return false; // Berhenti iterasi jika ditemukan input kosong
          }
        });

        // Jika ada input yang kosong, tampilkan pesan peringatan
        if (isEmpty) {
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Mohon isi semua input pada baris sebelumnya terlebih dahulu!',
          });
          return; // Hentikan penambahan baris baru
        }

        // Salin baris terakhir
        var newRow = previousRow.clone();

        // Kosongkan nilai input di baris baru
        newRow.find('input').val('');
        newRow.find('input[name="newQty[]"]').val('0');
        newRow.find('input[name="newHarga[]"]').val('0');

        // Perbarui tag <h4> pada baris baru dengan nomor urut yang baru
        rowCount++;

        // Tambahkan baris baru setelah baris terakhir
        previousRow.after(newRow);
      });


      $(document).on('click', '.hapusRowAddItem', function() {
        $(this).closest('.barisEdit').remove();
      });

      $(document).on('input', 'input[name="newQty[]"], input[name="newHarga[]"]', function() {
        var value = $(this).val();
        var formattedValue = parseFloat(value.split('.').join(''));
        $(this).val(formattedValue);

        var row = $(this).closest('.barisEdit');
        hitungTotalNewItem(row);
      });

      // Tambahkan event listener untuk event keyup
      $(document).on('keyup', 'input[name="newQty[]"], input[name="newHarga[]"]', function() {
        var value = $(this).val().trim(); // Hapus spasi di awal dan akhir nilai
        var formattedValue = formatNumber(parseFloat(value.split('.').join('')));
        $(this).val(formattedValue);
        if (isNaN(value)) { // Jika nilai input kosong
          $(this).val(''); // Atur nilai input menjadi 0
        }
        var row = $(this).closest('.barisEdit');
        hitungTotalNewItem(row);
      });

      function hitungTotalNewItem(row) {
        var qty = row.find('input[name="newQty[]"]').val().replace(/\./g, ''); // Hapus tanda titik
        var harga = row.find('input[name="newHarga[]"]').val().replace(/\./g, ''); // Hapus tanda titik
        qty = parseInt(qty); // Ubah string ke angka float
        harga = parseInt(harga); // Ubah string ke angka float

        qty = isNaN(qty) ? 1 : qty;
        harga = isNaN(harga) ? 0 : harga;

        var total = qty * harga;
        row.find('input[name="newTotal[]"]').val(formatNumber(total));
      }
    });
  </script>
  <script>
    $(function() {
      function initializeAutocomplete() {
        $(".autocomplete").autocomplete({
          source: function(request, response) {
            $.ajax({
              url: "<?php echo site_url('financial/autocomplete'); ?>",
              dataType: "json",
              data: {
                term: request.term
              },
              success: function(data) {
                response(data);
              }
            });
          },
          minLength: 2,

          select: function(event, ui) {
            var $row = $(this).closest('tr.baris');
            var harga = ui.item.harga;
            var formattedValue = (parseInt(ui.item.harga.split('.').join('')));

            $row.find('input[name="id_item[]"]').val(ui.item.id_item);
            $row.find('input[name="harga[]"]').val(formatNumber(Math.round(harga)));
          }
        });
      }
    });
  </script>


</body>

</html>