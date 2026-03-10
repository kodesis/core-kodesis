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
                            <!-- <div class="x_title">
                    <h2>Tabel</h2>

                </div> -->
                            <div class="x_content">
                                <?php
                                if ($this->input->post('no_coa')) { ?>
                                    <div class="row">
                                        <form class="form-horizontal form-label-left" method="POST" action="<?= base_url('financial/coa_report') ?>">
                                            <div class="col-md-5 col-xs-12">
                                                <label for="" class="form-label">No. CoA</label>
                                                <select name="no_coa" id="no_coa" class="form-control select2">
                                                    <option value="">:: Pilih nomor coa</option>
                                                    <?php
                                                    foreach ($coas as $c) {
                                                    ?>
                                                        <option <?= ($this->input->post('no_coa') == $c->no_sbb) ? "selected" : "" ?> value="<?= $c->no_sbb ?>"><?= $c->no_sbb ?> - <?= $c->nama_perkiraan ?></option>
                                                    <?php
                                                    } ?>
                                                </select>
                                            </div>
                                            <div class="col-md-3 col-xs-12">
                                                <label for="tgl_dari" class="form-label">Dari</label>
                                                <input type="date" class="form-control" name="tgl_dari" value="<?= $this->input->post('tgl_dari') ?>">
                                            </div>
                                            <div class="col-md-3 col-xs-12">
                                                <label for="tgl_sampai" class="form-label">Sampai</label>
                                                <input type="date" class="form-control" name="tgl_sampai" value="<?= $this->input->post('tgl_sampai') ?>">
                                            </div>
                                            <div class="col-md-1 col-xs-12">
                                                <button type="submit" class="btn btn-primary" style="margin-top: 24px;">Lihat</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="row" style="margin-top: 10px;">
                                        <div class="col-md-12 col-xs-12 table-responsive">
                                            <table id="datatable" class="table table-bordered" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th class="text-right" colspan="2">Total:</th>
                                                        <th class="text-right"><?= number_format($sum_debit, 2) ?></th>
                                                        <th class="text-right"><?= number_format($sum_kredit, 2) ?></th>
                                                        <!-- <th class="text-right" colspan="2">Saldo Awal: <?= number_format($saldo_awal, 2) ?></th> -->
                                                    </tr>
                                                    <tr>
                                                        <th class="text-center">#</th>
                                                        <th class="text-center">Tanggal</th>
                                                        <th class="text-center">Debit</th>
                                                        <th class="text-center">Kredit</th>
                                                        <!-- <th class="text-center">Saldo Akhir</th> -->
                                                        <th class="text-center">Keterangan</th>
                                                        <th class="text-center">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $no = 1;
                                                    if ($coa) {

                                                        foreach ($coa as $a) :
                                                    ?>
                                                            <tr>
                                                                <td><?= $no++ ?></td>
                                                                <td><?= format_indo($a->tanggal) ?></td>
                                                                <!-- <td><?= ($a->akun_debit == $detail_coa['no_sbb']) ? $a->akun_debit : $a->akun_kredit ?></td> -->
                                                                <td class="text-right"><?= ($a->akun_debit == $detail_coa['no_sbb']) ? (($a->jumlah_debit) ? number_format($a->jumlah_debit) : '0') : '0' ?></td>
                                                                <!-- <td class="text-right"><?= ($a->akun_debit == $detail_coa['no_sbb']) ? (($a->saldo_debit) ? number_format($a->saldo_debit) : '0') : '0' ?></td> -->
                                                                <td class="text-right"><?= ($a->akun_kredit == $detail_coa['no_sbb']) ? (($a->jumlah_kredit) ? number_format($a->jumlah_kredit) : '0') : '0' ?></td>
                                                                <!-- <td class="text-right"><?= ($a->akun_kredit == $detail_coa['no_sbb']) ? (($a->saldo_kredit) ? number_format($a->saldo_kredit) : '0') : '0' ?></td> -->
                                                                <!-- <td class="text-right"><?= ($a->akun_kredit == $detail_coa['no_sbb']) ? (($a->saldo_kredit) ? number_format($a->saldo_kredit) :  '0') : (($a->saldo_debit) ? number_format($a->saldo_debit) : '0') ?></td> -->
                                                                <td><?= $a->keterangan ?></td>
                                                                <td> <button class="btn btn-sm btn-warning text-white" onclick="onEdit_report_per_coa(<?= $a->id ?>)" type="button">Update</button>
                                                                </td>
                                                            </tr>
                                                        <?php
                                                        endforeach;
                                                    } else {
                                                        ?>
                                                        <tr>
                                                            <td colspan="6">Tidak ada transaksi pada periode yang dipilih</td>
                                                        </tr>
                                                    <?php
                                                    } ?>
                                                </tbody>
                                                <!-- <tbody>
                                                    <?php
                                                    $no = 1;
                                                    $saldo = $saldo_awal;
                                                    if ($coa) {
                                                        foreach ($coa as $a) {
                                                            $posisi = $detail_coa["posisi"];
                                                            $no_sbb = $detail_coa["no_sbb"];

                                                            if ($posisi == "AKTIVA") {
                                                                if ($a->akun_debit == $no_sbb) {
                                                                    $saldo += $a->jumlah_debit;
                                                                } else {
                                                                    $saldo -= $a->jumlah_kredit;
                                                                }
                                                            } else { // PASIVA
                                                                if ($a->akun_kredit == $no_sbb) {
                                                                    $saldo += $a->jumlah_kredit;
                                                                } else {
                                                                    $saldo -= $a->jumlah_debit;
                                                                }
                                                            } ?>
                                                            <tr>
                                                                <td><?= $no++ ?></td>
                                                                <td><?= format_indo($a->tanggal) ?></td>
                                                                <td class="text-right">
                                                                    <?= ($a->akun_debit == $detail_coa['no_sbb']) ? number_format(($a->jumlah_debit ?: 0), 2) : '0.00' ?>
                                                                </td>
                                                                <td class="text-right">
                                                                    <?= ($a->akun_kredit == $detail_coa['no_sbb']) ? number_format(($a->jumlah_kredit ?: 0), 2) : '0.00' ?>
                                                                </td>
                                                                <td class="text-right"><?= number_format($saldo) ?></td>
                                                                <td><?= $a->keterangan ?></td>
                                                            </tr>
                                                        <?php
                                                        }
                                                    } else {
                                                        ?>
                                                        <tr>
                                                            <td colspan="6">Tidak ada transaksi pada periode yang dipilih</td>
                                                        </tr>
                                                    <?php
                                                    }
                                                    ?>

                                                </tbody> -->
                                            </table>
                                        </div>
                                    </div>
                                <?php
                                } else {
                                ?>
                                    <div class="row">

                                        <form class="form-horizontal form-label-left" method="POST" action="<?= base_url('financial/coa_report') ?>">
                                            <div class="col-md-5 col-xs-12">
                                                <label for="" class="form-label">No. CoA </label>
                                                <select name="no_coa" id="no_coa" class="form-control select2">
                                                    <option value="">:: Pilih nomor coa</option>
                                                    <?php
                                                    foreach ($coas as $c) {
                                                    ?>
                                                        <option value="<?= $c->no_sbb ?>"><?= $c->no_sbb ?> - <?= $c->nama_perkiraan ?></option>
                                                    <?php
                                                    } ?>
                                                </select>
                                            </div>
                                            <div class="col-md-3 col-xs-12">
                                                <label for="tgl_invoice" class="form-label">Dari</label>
                                                <input type="date" class="form-control" name="tgl_dari" value="">
                                            </div>
                                            <div class="col-md-3 col-xs-12">
                                                <label for="tgl_invoice" class="form-label">Sampai</label>
                                                <input type="date" class="form-control" name="tgl_sampai" value="<?= date('Y-m-d') ?>">
                                            </div>
                                            <div class="col-md-1 col-xs-12">
                                                <button type="submit" class="btn btn-primary" style="margin-top: 24px;">Lihat</button>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- <div class="row">
                            <div class="col-md-12 col-xs-12">
                                <h4>Tidak ada nomor coa yang dipilih</h4>
                            </div>
                        </div> -->
                                <?php
                                } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Update COA Modal -->
            <div class="modal fade" id="updateCoaModal" tabindex="-1" aria-labelledby="updateCoaModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="updateCoaModalLabel">Update COA Entry</h5>
                            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">X</button>
                        </div>
                        <form id="updateCoaForm" action="<?= site_url('financial/update_report_per_coa') ?>" method="POST" enctype="multipart/form-data">
                            <div class="modal-body">
                                <div class="row">
                                    <input type="hidden" name="id" id="update_id">
                                    <div class="col-md-6 col-xs-12 form-group has-feedback">
                                        <label class="form-label">Debit</label>
                                        <select name="neraca_debit" id="update_neraca_debit" class="form-control" style="width: 100%;" required>
                                            <option value="">-- Pilih pos neraca debit</option>
                                            <?php foreach ($coas as $c) : ?>
                                                <option value="<?= $c->no_sbb ?>" data-nama="<?= $c->nama_perkiraan ?>" data-posisi="<?= $c->posisi ?>">
                                                    <?= $c->no_sbb . ' - ' . $c->nama_perkiraan ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6 col-xs-12 form-group has-feedback">
                                        <label class="form-label">Kredit</label>
                                        <select name="neraca_kredit" id="update_neraca_kredit" class="form-control" style="width: 100%;" required>
                                            <option value="">-- Pilih pos neraca kredit</option>
                                            <?php foreach ($coas as $c) : ?>
                                                <option value="<?= $c->no_sbb ?>" data-nama="<?= $c->nama_perkiraan ?>" data-posisi="<?= $c->posisi ?>">
                                                    <?= $c->no_sbb . ' - ' . $c->nama_perkiraan ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-md-12 col-xs-12 form-group has-feedback">
                                        <div id="warningMessage" class="validation-error-alert"></div>
                                    </div>
                                    <div class="col-md-6 col-xs-12 form-group has-feedback">
                                        <label class="form-label">Nominal</label>
                                        <input type="text" class="form-control format_angka" name="input_nominal" id="update_input_nominal" placeholder="Nominal" required>
                                    </div>
                                    <div class="col-md-6 col-xs-12 form-group has-feedback">
                                        <label class="form-label">Keterangan</label>
                                        <input type="text" class="form-control" name="input_keterangan" id="update_input_keterangan" placeholder="Keterangan" oninput="this.value = this.value.toUpperCase()" required>
                                    </div>
                                    <div class="col-md-12 col-xs-12 form-group has-feedback">
                                        <label class="form-label">Tanggal</label>
                                        <input type="date" name="tanggal" id="update_tanggal" value="<?= date('Y-m-d') ?>" class="form-control" required>
                                    </div>
                                    <!-- <div class="col-md-6 col-xs-12 form-group has-feedback">
                                        <label class="form-label">Attachment (Image/Excel/Word)</label>
                                        <input type="file" class="form-control-file" name="file" id="file">
                                    </div> -->
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-danger" onclick="onDeleteArusKas()">Delete</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <link rel="stylesheet" href="<?= base_url(); ?>assets/select2/css/select2.min.css">
            <script type="text/javascript" src="<?= base_url(); ?>assets/select2/js/select2.min.js"></script>
            <script>
                $(document).ready(function() {
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
            </script>

            <!-- Finish content-->

        </div>

        <!-- /page content -->

        <!-- footer content -->

        <!-- /footer content -->

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

            $(document).ready(function() {


                function formatState(state, colorAktiva, colorPasiva, signAktiva, signPasiva) {
                    if (!state.id) {
                        return state.text;
                    }

                    var color = state.element.dataset.posisi == "AKTIVA" ? colorAktiva : colorPasiva;
                    var sign = state.element.dataset.posisi == "AKTIVA" ? signAktiva : signPasiva;

                    var $state = $('<span style="background-color: ' + color + ';"><strong>' + state.text + ' ' + sign + '</strong></span>');

                    return $state;
                };

                function formatStateDebit(state) {
                    return formatState(state, '#2ecc71', '#ff7675', '(+)', '(-)');
                }

                function formatStateKredit(state) {
                    return formatState(state, '#ff7675', '#2ecc71', '(-)', '(+)');
                }

                $('#update_neraca_debit').select2({
                    // templateResult: formatStateDebit,
                    templateSelection: formatStateDebit
                });

                $('#update_neraca_kredit').select2({
                    // templateResult: formatStateKredit,
                    templateSelection: formatStateKredit
                });

                $('#update_neraca_debit, #update_neraca_kredit').change(function() {
                    var debit = $('#update_neraca_debit').find(":selected").val();
                    var kredit = $('#update_neraca_kredit').find(":selected").val();
                    disabledSubmit(debit, kredit);
                });

                function disabledSubmit(debit, kredit) {
                    if (debit && kredit) {
                        if (debit == kredit) {
                            console.log('sama');
                            $('.btn-success').prop('disabled', true);
                        } else {
                            console.log('tidak sama');
                            $('.btn-success').prop('disabled', false);
                        }
                    }
                }
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
        function onEdit_report_per_coa(id) {
            $('#updateCoaForm')[0].reset(); // reset form on modals
            // $('.form-group').removeClass('has-error'); // clear error class
            // $('.help-block').empty(); // clear error string
            // $('.modal-title').text('Edit Poster');

            $.ajax({
                url: "<?php echo site_url('financial/ajax_edit_report_coa') ?>/" + id,
                type: "POST",
                dataType: "JSON",
                success: function(response) {
                    var data = response.data;

                    console.log(response);

                    JSON.stringify(data.id);
                    // alert(JSON.stringify(data));

                    $('#update_id').val(data.id);
                    $('#update_neraca_debit').val(data.akun_debit).trigger('change');
                    $('#update_neraca_kredit').val(data.akun_kredit).trigger('change');
                    // var formattedNominal = new Intl.NumberFormat('id-ID', {
                    // 	style: 'currency',
                    // 	currency: 'IDR',
                    // 	minimumFractionDigits: 0
                    // }).format(data.jumlah_debit);

                    // // Ganti simbol Rp yang ada spasinya (bawaan Intl) jika perlu
                    // formattedNominal = formattedNominal.replace(/(\D+)/, 'Rp ');

                    // BARU - pakai formatAngka supaya konsisten, support desimal
                    var rawNominal = parseFloat(data.jumlah_debit) || 0;
                    var formattedNominal = rawNominal.toLocaleString('id-ID', {
                        minimumFractionDigits: 0,
                        maximumFractionDigits: 2
                    });

                    $('#update_input_nominal').val(formattedNominal);
                    $('#update_input_keterangan').val(data.keterangan);
                    $('#update_tanggal').val(data.tanggal);
                    // if (coaEntry.table_source == "t_coa_sbb") {
                    //   $('#update_no_bb').val(data.no_bb);
                    //   $('#update_no_sbb').val(data.no_sbb);
                    // } else {

                    //   $('#update_no_bb').val(data.no_lr_bb);
                    //   $('#update_no_sbb').val(data.no_lr_sbb);
                    // }
                    // $('#update_nama_perkiraan').val(data.nama_perkiraan);
                    // $('#update_nominal').val(data.nominal);


                    $('#updateCoaModal').modal('show'); // show bootstrap modal when complete loaded

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error get data from ajax');
                }
            });
        }

        $(document).ready(function() {
            // Event listener untuk input dengan class format_angka
            $('.format_angka').on('input', function() {
                // 1. Ambil nilai asli, hapus semua karakter selain angka
                let value = $(this).val().replace(/[^0-9]/g, '');

                // 2. Format menjadi ribuan dengan titik
                if (value !== "") {
                    let formattedValue = new Intl.NumberFormat('id-ID').format(value);
                    $(this).val(formattedValue);
                } else {
                    $(this).val("");
                }
            });

            // 3. Pastikan saat form di-submit, titik dihapus agar masuk ke DB sebagai angka
            $('form').on('submit', function() {
                $('.format_angka').each(function() {
                    let plainValue = $(this).val().replace(/\./g, '');
                    $(this).val(plainValue);
                });
            });
        });

        function onDeleteArusKas() {
            let id = $('#update_id').val();
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "<?= base_url('financial/hapus_arus_kas/') ?>", // Use POST for ID, don't append to URL unless it's a RESTful DELETE
                        type: 'POST', // Keep as POST
                        data: {
                            id: id
                        },
                        dataType: 'json', // Expect JSON response
                        success: function(response) {
                            let iconType = 'error'; // Default to error
                            if (response.status == 'success') {
                                iconType = 'success';
                            } else if (response.status == 'info') {
                                iconType = 'info'; // Use info icon for "not found" cases
                            }

                            Swal.fire(
                                response.status === 'success' ? 'Berhasil!' : 'Perhatian!', // Dynamic title
                                response.message, // Display the message from the backend
                                iconType
                            ).then(() => {
                                // Only reload the table if it was a success or a clear 'info' (already deleted) case
                                if (response.status === 'success' || response.status === 'info') {
                                    location.reload();
                                }
                            });
                        },
                        error: function(xhr, status, error) {
                            console.error('AJAX Error:', status, error, xhr.responseText); // Log full error for debugging
                            Swal.fire(
                                'Kesalahan Jaringan!', // More specific error message
                                'Terjadi kesalahan komunikasi dengan server. Silakan coba lagi.',
                                'error'
                            );
                        }
                    });
                }
            });
        }
    </script>

</body>

</html>