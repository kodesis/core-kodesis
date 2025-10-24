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
    <?php
    if ($this->session->flashdata('message_name')) {
    ?>
        <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message_name') ?>"></div>
    <?php } ?>
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
                                <h2><?= ($description) ?> </h2>
                            </div>
                            <div class="x_content">
                                <div class="row" style="margin-bottom: 10px">
                                    <form class="form-inline" method="POST" action="<?= base_url('financial/reportBBMonthly') ?>">
                                        <div class="col-xs-12 text-right">

                                            <div class="form-group row" style="margin-right: 15px">
                                                <select id="per_bulan" name="per_bulan" class="form-control">
                                                    <option value="">Select Month</option>
                                                    <?php
                                                    $months = [
                                                        'January', 'February', 'March', 'April', 'May', 'June',
                                                        'July', 'August', 'September', 'October', 'November', 'December'
                                                    ];

                                                    foreach ($months as $key => $monthName) {
                                                        $month = $key + 1;
                                                        $selected = $month == $per_bulan ? 'selected' : '';
                                                        // $key + 1 gives the numeric month value (1-12)
                                                        echo '<option value="' . ($month) . '" ' . $selected . '>' . $monthName . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                                <select name="per_tahun" id="per_tahun" class="form-control">
                                                    <?php
                                                    $current_year = date('Y');
                                                    for ($year = $current_year; $year >= 2020; $year--) :
                                                    ?>
                                                        <option value="<?= $year ?>" <?= $year == $per_tahun ? 'selected' : '' ?>>
                                                            <?= $year ?>
                                                        </option>
                                                    <?php endfor; ?>
                                                </select>
                                            </div>
                                            <div class="form-group row">
                                                <button type="submit" name="button_sbm" class="btn btn-primary" value="lihat">Lihat</button>
                                                <!-- <button type="submit" name="button_sbm" class="btn btn-success" value="excel"><i class='fa fa-file'></i> Excel</button> -->
                                                <button type="submit" name="button_sbm" class="btn btn-danger" value="pdf"><i class='fa fa-file'></i> PDF</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="table-responsive">
                                            <table id="" class="table jambo_table" style="width:100%">
                                                <?php
                                                if ($list_coa) {
                                                    foreach ($list_coa as $lc) :
                                                        $saldo_awal_value = isset($saldo_awal[$lc->no_sbb]) ? $saldo_awal[$lc->no_sbb] : 0;

                                                        $transaction = $this->m_coa->getCoaReportMonthly($lc->no_sbb, $per_periode);

                                                        if ($transaction) { ?>
                                                            <thead>
                                                                <tr class="headings">
                                                                    <th style="width: 15%"><?= $lc->no_sbb ?></th>
                                                                    <th style="width: 40%"><?= strtoupper($lc->nama_perkiraan) ?></th>
                                                                    <th class="text-right" colspan="3">IDR</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <th class="text-center">Tanggal</th>
                                                                    <th class="text-center" colspan="2">Keterangan</th>
                                                                    <th class="text-center">Debit</th>
                                                                    <th class="text-center">Kredit</th>
                                                                </tr>
                                                                <?php

                                                                $total_debit = 0;
                                                                $total_kredit = 0;
                                                                $selisih = 0;

                                                                foreach ($transaction as $tr) :
                                                                    if ($lc->no_sbb == $tr->akun_debit) { ?>
                                                                        <tr>
                                                                            <td><?= format_indo($tr->tanggal) ?></td>
                                                                            <td colspan="2"><?= $tr->keterangan ?></td>
                                                                            <td class="text-right"><?= number_format($tr->jumlah_debit) ?></td>
                                                                            <td class="text-right">-</td>
                                                                        </tr>
                                                                    <?php
                                                                        $total_debit += $tr->jumlah_debit;
                                                                        $total_kredit += 0;
                                                                    } else {
                                                                    ?>
                                                                        <tr>
                                                                            <td><?= format_indo($tr->tanggal) ?></td>
                                                                            <td colspan="2"><?= $tr->keterangan ?></td>
                                                                            <td class="text-right">-</td>
                                                                            <td class="text-right"><?= number_format($tr->jumlah_kredit) ?></td>
                                                                        </tr>
                                                                    <?php
                                                                        $total_kredit += $tr->jumlah_kredit;
                                                                        $total_debit += 0;
                                                                    } ?>
                                                                <?php
                                                                endforeach;

                                                                if ($lc->posisi === "AKTIVA") {
                                                                    $selisih = $total_debit - $total_kredit;
                                                                } else {
                                                                    $selisih = $total_kredit - $total_debit;
                                                                }
                                                                ?>

                                                                <tr>
                                                                    <th class="text-right">Saldo awal:</th>
                                                                    <th class="text-right"><?= number_format($saldo_awal_value) ?></th>
                                                                    <th class="text-right">Total</th>
                                                                    <th class="text-right"><?= number_format($total_debit) ?></th>
                                                                    <th class="text-right"><?= number_format($total_kredit) ?></th>
                                                                </tr>
                                                                <tr>
                                                                    <th class="text-right">Saldo akhir:</th>
                                                                    <th class="text-right"><?= number_format($saldo_awal_value + $selisih) ?></th>
                                                                    <th class="text-right">Mutasi</th>
                                                                    <th class="text-right"><?= number_format($selisih) ?></th>
                                                                    <th class="text-right"></th>
                                                                </tr>
                                                            </tbody>
                                                    <?php
                                                        }
                                                    endforeach;
                                                    ?>
                                                <?php
                                                } ?>
                                            </table>
                                        </div>
                                    </div>
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

        <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="simpanNeraca">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">
                            Simpan neraca
                        </h4>
                    </div>
                    <form class="form-horizontal form-label-left" method="POST" action="<?= base_url('financial/simpanNeraca') ?>">
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

        $(document).ready(function() {
            // $('#simpan_neraca').click(function() {
            //     $.ajax({
            //         url: '<?php echo base_url('financial/simpanNeraca'); ?>',
            //         type: 'GET',
            //         dataType: 'json',
            //         contentType: "application/json; charset=utf-8",
            //         headers: {
            //             'Access-Control-Allow-Origin': '*',
            //         },

            //         success: function(response) {
            //             console.log(response);
            //             if (response.status == 'success') {
            //                 Swal.fire({
            //                     title: "Success!! ",
            //                     text: 'Laporan neraca berhasil disimpan!',
            //                     icon: "success",
            //                 });
            //             } else {
            //                 Swal.fire({
            //                     title: "Error!! ",
            //                     text: 'Gagal menyimpan laporan neraca.',
            //                     icon: "error",
            //                 });
            //             }
            //         },
            //         error: function(xhr, status, error) {
            //             console.log(xhr);
            //             Swal.fire({
            //                 title: "Error!! ",
            //                 text: 'Terjadi kesalahan: ' + error,
            //                 icon: "error",
            //             });
            //         }
            //     });
            // });
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
                icon: "error",
            });
        <?php
            // $this->session->sess_destroy('message_error');
            unset($_SESSION['message_error']);
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
</body>

</html>