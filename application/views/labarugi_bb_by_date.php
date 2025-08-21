<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" href="<?= $this->session->userdata('icon') ?>" type="image/ico" />
    <title><?= $this->session->userdata('nama_singkat') ?> | Bussines Development</title>
    <title>Kodesis <?= (isset($title)) ? "| " . $title : '' ?></title>
    <link rel="icon" type="image/png" href="<?php echo base_url(); ?>img/logo-kodesis.png" /><!-- Bootstrap -->
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
    <style>
        .modal {
            text-align: center;
            padding: 0 !important;
        }

        .modal:before {
            content: '';
            display: inline-block;
            height: 100%;
            vertical-align: middle;
            margin-right: -4px;
        }

        .modal-dialog {
            display: inline-block;
            text-align: left;
            vertical-align: middle;
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
                                <h2>Neraca per tanggal <?= format_indo($per_tanggal) ?> </h2>
                            </div>
                            <div class="x_content">
                                <div class="row">
                                    <div class="col-md-4 col-xs-12">
                                        <h5>
                                            Laba berjalan: <strong>Rp <?= number_format($total_pendapatan) ?></strong>
                                        </h5>
                                    </div>
                                    <form class="form-horizontal form-label-left" method="POST" action="<?= base_url('financial/reportByDate') ?>">
                                        <div class="col-md-2 col-xs-12">

                                            <div class="form-group row">
                                                <input type="date" name="per_tanggal" id="per_tanggal" class="form-control" value="<?= $per_tanggal ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-xs-12">

                                            <div class="form-group row">
                                                <select name="jenis_laporan" id="jenis_laporan" class="form-control">
                                                    <option <?= ($this->input->post('jenis_laporan') == "neraca") ? "selected" : "" ?> value="neraca">Neraca SBB</option>
                                                    <option <?= ($this->input->post('jenis_laporan') == "laba_rugi") ? "selected" : "" ?> value="laba_rugi">Laba Rugi SBB</option>
                                                    <option <?= ($this->input->post('jenis_laporan') == "neraca_bb") ? "selected" : "" ?> value="neraca_bb">Neraca BB</option>
                                                    <option <?= ($this->input->post('jenis_laporan') == "lr_bb") ? "selected" : "" ?> value="lr_bb">Laba Rugi BB</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-xs-12 text-right">
                                            <div class="form-group row">
                                                <button type="submit" name="button_sbm" class="btn btn-primary btn-sm" value="lihat">Lihat</button>
                                                <button type="submit" name="button_sbm" class="btn btn-success btn-sm" value="excel"><i class='fa fa-file'></i> Excel</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-xs-12">
                                        <h2 class="text-center">Biaya</h2>
                                        <p class="text-right">Total: <strong><?= number_format($sum_biaya) ?></strong></p>
                                        <div class="table-responsive">
                                            <table id="" class="table" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>No. Coa</th>
                                                        <th>Nama Coa</th>
                                                        <th>Nominal</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    foreach ($biaya as $a) :
                                                        $coa = $this->m_coa->getCoaBB($a->no_bb); ?>
                                                        <tr>
                                                            <td><?= $a->no_bb ?></td>
                                                            <td><?= $coa['nama_perkiraan'] ?></td>
                                                            <td class="text-right"><?= number_format($a->saldo_aktiva) ?></td>
                                                        </tr>
                                                    <?php
                                                    endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-xs-12">
                                        <div class="row justify-content-between">
                                            <h2 class="text-center">Pendapatan</h2>
                                            <p class="text-right">Total: <strong><?= number_format($sum_pendapatan) ?></strong></p>
                                        </div>
                                        <div class="table-responsive">
                                            <table id="" class="table" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>No. Coa</th>
                                                        <th>Nama Coa</th>
                                                        <th>Nominal</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    foreach ($pendapatan as $a) :
                                                        $coa = $this->m_coa->getCoaBB($a->no_bb); ?>
                                                        <tr>
                                                            <td><?= $a->no_bb ?></td>
                                                            <td><?= $coa['nama_perkiraan'] ?></td>
                                                            <td class="text-right"><?= number_format($a->saldo_pasiva) ?></td>
                                                        </tr>
                                                    <?php
                                                    endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="detailModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                            <h4 class="modal-title" id="myModalLabel2">Lacak arus kas</h4>
                        </div>
                        <form class="form-horizontal form-label-left" method="POST" action="<?= base_url('financial/coa_report') ?>" target="_blank">
                            <div class="modal-body">
                                <div class="row">
                                    <input type="hidden" class="form-control" name="no_coa">
                                    <div class="col-md-6 col-xs-12">
                                        <label for="tgl_dari" class="form-label">Dari</label>
                                        <input type="date" class="form-control" name="tgl_dari" required>
                                    </div>
                                    <div class="col-md-6 col-xs-12">
                                        <label for="tgl_sampai" class="form-label">Sampai</label>
                                        <input type="date" class="form-control" name="tgl_sampai" required>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Lihat</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Finish content-->

        </div>

        <!-- /page content -->

        <!-- footer content -->

        <!-- /footer content -->

        <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="simpanLR">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">
                            Simpan Laba Rugi
                        </h4>
                    </div>
                    <form class="form-horizontal form-label-left" method="POST" action="<?= base_url('financial/simpanLR') ?>">
                        <div class="modal-body">
                            <div class="form-group row">
                                <div class="col-xs-12">
                                    <label for="keterangan" class="form-label">Keterangan</label>
                                    <textarea name="keterangan" id="keterangan" class="form-control" oninput="this.value = this.value.toUpperCase()"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">
                                Simpan neraca
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <!-- jQuery -->
    <script src="<?= base_url(); ?>src/vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="<?= base_url(); ?>src/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="<?= base_url(); ?>src/vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="<?= base_url(); ?>src/vendors/nprogress/nprogress.js"></script>
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
                    timer: 1500
                });
            });
        });



        function formatNumber(number) {
            return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        function format_angka() {
            var nominal = document.getElementById('input_nominal').value;

            var formattedValue = formatNumber(parseFloat(nominal.split('.').join('')));

            document.getElementById('input_nominal').value = formattedValue;
        }

        <?php
        if ($this->session->flashdata('message_name')) {
        ?>
            Swal.fire({
                title: "Success!! ",
                text: '<?= $this->session->flashdata('message_name') ?>',
                type: "success",
                icon: "success",
            });
        <?php
            // $this->session->sess_destroy('message_name');
            unset($_SESSION['message_name']);
        } ?>

        <?php
        if ($this->session->flashdata('message_error')) {
        ?>
            Swal.fire({
                title: "Error!! ",
                text: '<?= $this->session->flashdata('message_error') ?>',
                type: "error",
                icon: "error",
            });
        <?php
            // $this->session->sess_destroy('message_error');
            unset($_SESSION['message_error']);
        } ?>

        $(".btn-process").on("click", function(e) {
            e.preventDefault();
            const href = $(this).attr("href");

            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, process it!",
            }).then((result) => {
                if (result.isConfirmed) {
                    document.location.href = href;
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $(document).on('click', '.arus_kas', function() {
                var id = $(this).data('id');

                $('#detailModal2 .modal-title').text('Arus kas ' + id);
                // $('#detailModal2 .modal-body').html(id);
                $('#detailModal2 input[name="no_coa"]').val(id);
                $('#detailModal2').modal('show');
            });
        });
    </script>


</body>

</html>