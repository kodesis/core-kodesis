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

    .swal2-container {
      z-index: 9999999 !important;
      /* atau angka lain yang lebih tinggi dari elemen lain */
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

                <h2>List Approval Direksi</h2>

              </div>

              <div class="x_content">

                <a href="<?= base_url('pengajuan/list') ?>" class="btn btn-warning">Back</a>

                <div class="table-responsive">

                  <table class="table table-bordered">

                    <thead>

                      <tr>

                        <th scope="col">No.</th>

                        <th scope="col">User</th>

                        <th scope="col">Tanggal</th>

                        <th scope="col">Total</th>

                        <th scope="col">Status</th>

                        <th scope="col">Posisi</th>

                        <th scope="col">#</th>

                      </tr>

                    </thead>

                    <tbody>

                      <?php if ($approval_direksi->num_rows() < 1) {  ?>

                        <tr align="center">

                          <td colspan="7">Belum ada data</td>

                        </tr>

                        <?php } else {

                        foreach ($approval_direksi->result_array() as $value) {

                        ?>

                          <tr>

                            <td><?= $value['no_pengajuan'] ?></td>

                            <td><?= $value['nama'] ?></td>

                            <td><?= $value['created_at'] ?></td>

                            <td><?= number_format($value['total']) ?></td>

                            <td>

                              <?php if ($value['status_direksi'] == 1) {

                                echo "Disetujui";
                              } elseif ($value['status_direksi'] == 2) {

                                echo "Ditolak";
                              } else {

                                echo "Belum diproses";
                              } ?>

                            </td>

                            <td><?= $value['posisi'] ?></td>

                            <td>

                              <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#myModal<?= $value['Id'] ?>">View</button>



                              <!-- Modal Detail -->

                              <div class="modal fade" id="myModal<?= $value['Id'] ?>" role="dialog" style="z-index: 99999 !important;">

                                <div class="modal-dialog modal-lg">

                                  <!-- Modal content-->

                                  <div class="modal-content">

                                    <div class="modal-header">

                                      <button type="button" class="close" data-dismiss="modal">&times;</button>

                                      <h2 class="modal-title">Pengajuan <?= $value['kode'] ?></h2>

                                    </div>

                                    <div class="modal-body">

                                      <table class="table table-bordered">

                                        <thead>

                                          <tr>

                                            <th>No.</th>

                                            <th>Item</th>

                                            <th>Qty</th>

                                            <th>Price</th>

                                            <th>Total</th>

                                          </tr>

                                        </thead>

                                        <tbody>

                                          <?php $detail = $this->cb->get_where('t_pengajuan_detail', ['no_pengajuan' => $value['Id']])->result_array();

                                          $no = 1;

                                          foreach ($detail as $row) {

                                          ?>

                                            <tr>

                                              <td><?= $no++ ?></td>

                                              <td><?= $row['item'] ?></td>

                                              <td><?= $row['qty'] ?></td>

                                              <td><?= number_format($row['price'], 0) ?></td>

                                              <td><?= number_format($row['total'], 0) ?></td>

                                            </tr>

                                          <?php } ?>

                                          <tr>

                                            <td colspan="4" align="right"><strong>TOTAL</strong></td>

                                            <td><?= number_format($value['total']) ?></td>

                                          </tr>

                                        </tbody>

                                      </table>

                                      <div class="panel panel-default">

                                        <div class="panel-heading">Catatan</div>

                                        <div class="panel-body">

                                          <?= $value['catatan'] ?>

                                        </div>

                                      </div>

                                      <div class="panel panel-default">

                                        <div class="panel-heading">Attacment</div>

                                        <div class="panel-body">

                                          <a href="<?= base_url('upload/pengajuan/' . $value['bukti_pengajuan']) ?>" class="btn btn-success btn-xs" target="_blank">Lampiran Pengajuan</a></th>

                                        </div>

                                      </div>

                                      <?php if ($value['status_direksi'] == 0) { ?>

                                        <form action="<?= base_url('pengajuan/update_direksi') ?>" method="post" enctype="multipart/form-data" id="update-direksi">

                                          <input type="hidden" name="id_pengajuan" id="id_pengajuan" value="<?= $value['Id'] ?>">

                                          <div class="form-group">

                                            <div class="row" style="margin-bottom: 20px;">

                                              <div class="col-md-8 col-sm-8 col-xs-12">

                                                <label for="status" class="form-label">Total Pengajuan</label>

                                                <input type="text" class="form-control" name="total" id="total" value="<?= number_format($value['total']) ?>" readonly>

                                              </div>

                                            </div>

                                            <div class="row" style="margin-bottom: 20px;">

                                              <div class="col-md-8 col-sm-8 col-xs-12">

                                                <label for="status" class="form-label">Status</label>

                                                <select name="status" id="status" class="form-control">

                                                  <option value=""> -- Pilih Status -- </option>

                                                  <option value="1">Disetujui</option>

                                                  <option value="2">Ditolak</option>

                                                </select>

                                              </div>

                                            </div>

                                            <div class="row" style="margin-bottom: 20px;">

                                              <div class="col-md-8 col-sm-8 col-xs-12">

                                                <label for="catatan" class="form-label">Catatan</label>

                                                <textarea name="catatan" id="catatan" class="form-control"></textarea>

                                              </div>

                                            </div>

                                          </div>

                                          <div class="row">

                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>

                                            <button class="btn btn-primary" id="btn-direksi">Save</button>

                                          </div>

                                        </form>

                                      <?php } ?>

                                    </div>

                                  </div>

                                </div>

                              </div>

                            </td>

                          </tr>

                      <?php }
                      } ?>

                    </tbody>

                  </table>

                </div>

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

      $('.select2').select2();



      $("button[id='btn-direksi']").click(function(e) {

        var url = $('form[id="update-direksi"]').attr("action");

        var formData = new FormData($("form#update-direksi")[0]);

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

    })
  </script>

  <script>
    function formatNumber(number) {

      return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");

    }
  </script>

</body>



</html>