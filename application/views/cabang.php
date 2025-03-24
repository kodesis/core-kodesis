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

        .mb-3 {
            margin-bottom: .5rem;
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

        .select2-container .select2-dropdown .select2-results__option {
            text-align: left;
            /* Pastikan opsi dropdown rata kiri */
        }

        .uppercase {
            text-transform: uppercase;
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
                            <img src="<?= $this->session->userdata('icon') ?>" alt="..." height="42" width="60">
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
                                <h2>Pengaturan sistem</h2>
                            </div>
                            <div class="x_content">
                                <div class="table-responsive">
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <button class="btn btn-primary btn-xs edit_data">Edit data</button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-8">
                                            <table id="datatable" class="table table-striped table-bordered" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>No.</th>
                                                        <th>Kategori</th>
                                                        <th>Object</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $no = 1; ?>
                                                    <tr>
                                                        <td><?= $no++; ?>.</td>
                                                        <td>Nama perusahaan</td>
                                                        <td><?= $setting->nama_perusahaan ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><?= $no++; ?>.</td>
                                                        <td>Nama singkat</td>
                                                        <td><?= $setting->nama_singkat ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><?= $no++; ?>.</td>
                                                        <td>Alamat perusahaan</td>
                                                        <td><?= $setting->alamat_perusahaan ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><?= $no++; ?>.</td>
                                                        <td>No. Rekening</td>
                                                        <td><?= $setting->nomor_rekening ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><?= $no++; ?>.</td>
                                                        <td>Nama PPN</td>
                                                        <td><?= $setting->nama_ppn ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><?= $no++; ?>.</td>
                                                        <td>Besaran PPN</td>
                                                        <td><?= $setting->besaran_ppn ?></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="col-md-4">
                                            <h4>Logo perusahaan</h4>
                                            <img src="<?= $setting->logo ?>" alt="..." width="100%">
                                            <br>

                                            <button class="btn btn-primary btn-xs tukar_logo">Tukar logo</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 text-right">
                                        <?= $this->pagination->create_links() ?>
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
                        <form class="form-horizontal form-label-left" method="POST" action="<?= base_url('setting/update') ?>">
                            <div class="modal-body">
                                <div class="row mb-3">
                                    <div class="col-xs-12">
                                        <label for="nama_perusahaan" class="form-label">Nama perusahaan</label>
                                        <input type="text" class="form-control" name="nama_perusahaan" value="<?= $setting->nama_perusahaan ?>" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-xs-12">
                                        <label for="nama_singkat" class="form-label">Nama singkat</label>
                                        <input type="text" class="form-control" name="nama_singkat" value="<?= $setting->nama_singkat ?>" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-xs-12">
                                        <label for="alamat_perusahaan" class="form-label">Alamat perusahaan</label>
                                        <textarea class="form-control" name="alamat_perusahaan" id="alamat_perusahaan" rows="3" required><?= $setting->alamat_perusahaan ?></textarea>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-xs-12">
                                        <label for="nama_ppn" class="form-label">Nama PPN</label>
                                        <input type="text" class="form-control" name="nama_ppn" value="<?= $setting->nama_ppn ?>" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-xs-12">
                                        <label for="besaran_ppn" class="form-label">Besaran PPN</label>
                                        <input type="text" class="form-control" name="besaran_ppn" value="<?= $setting->besaran_ppn ?>" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-xs-12">
                                        <label for="no_rekening" class="form-label">No. Rekening perusahaan (untuk invoice)</label>
                                        <textarea class="form-control" name="no_rekening" id="no_rekening" rows="3" required><?= $setting->nomor_rekening ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Perbarui</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="detailModal3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                            <h4 class="modal-title" id="myModalLabel2">Lacak arus kas</h4>
                        </div>
                        <form class="form-horizontal form-label-left" method="POST" action="<?= base_url('setting/update_logo') ?>" enctype="multipart/form-data">
                            <div class="modal-body">
                                <div class="row mb-3">
                                    <div class="col-xs-12">
                                        <label for="logo" class="form-label">Logo perusahaan</label>
                                        <input type="file" class="form-control" name="logo" value="<?= $setting->logo ?>" required>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Perbarui</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Finish content-->

        </div>

        <!-- /page content -->

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
                });
            });
        });



        function formatNumber(number) {
            return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        <?php
        if ($this->session->flashdata('message_name')) {
        ?> Swal.fire({
                title: "Success!! ",
                text: '<?= $this->session->flashdata('message_name') ?>',
                type: "success",
                icon: "success",
            });
        <?php
            // $this->session->sess_destroy('message_name');
            unset($_SESSION['message_name']);
        } ?>

        // const flashdata_error = $('<?= $this->session->flashdata("message_error") ?>').data("flashdata");
        const flashdata_error = $(".flash-data-error").data("flashdata");
        // const flashdata_error = $('.flash-data').data('flashdata');
        if (flashdata_error) {
            Swal.fire({
                title: "Error!! ",
                text: flashdata_error,
                type: "error",
                icon: "error",
            });
        }

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
            $(document).on('click', '.edit_data', function() {
                $('#detailModal2 .modal-title').text('Edit data');
                $('#detailModal2').modal('show');
            });
            $(document).on('click', '.tukar_logo', function() {
                $('#detailModal3 .modal-title').text('Edit data');
                $('#detailModal3').modal('show');
            });
            document.getElementById("alamat_perusahaan").placeholder =
                `Jalan bukit cinere D/186 RT 04 RW 02 \nKec. Cinere Kab. Depok \n0896-2555-1238`;
            document.getElementById("no_rekening").placeholder =
                `Pembayaran Transfer ke rekening berikut: \nBank BCA 3753002304 \nPT. Kode Sistem Indonesia`;
        });
    </script>
</body>

</html>