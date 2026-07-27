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

    <!-- jQuery AutoComplete Styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-autocomplete/1.0.7/jquery.auto-complete.css">

    <!-- Select2 Styles -->
    <link rel="stylesheet" href="<?= base_url(); ?>src/select2/css/select2.min.css">

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

        .select2-container .select2-dropdown .select2-results__option {
            text-align: left;
        }

        .uppercase {
            text-transform: uppercase;
        }

        .select2-container .select2-selection--single {
            height: 34px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 34px;
            color: #555;
            padding-left: 10px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 34px;
        }

        .select2-container {
            width: 100% !important;
            z-index: 99999;
        }

        .modal .select2-dropdown {
            z-index: 99999 !important;
        }

        .modal .select2-container--open {
            z-index: 99999 !important;
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
                                <h2>Daftar Kemasan SMU Incoming</h2>
                                <ul class="nav navbar-right panel_toolbox">
                                    <li>
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalTambahSMU">
                                            Tambah SMU
                                        </button>

                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalRekap">
                                            Rekap Kemasan
                                        </button>
                                    </li>
                                </ul>
                            </div>
                            <div class="x_content">
                                <div class="table-responsive">
                                    <table id="kemasan_table" class="table table-striped table-bordered" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>uid</th>
                                                <th>SMU</th>
                                                <th>Nama Penerima</th>
                                                <th>Asal</th>
                                                <th>Pieces</th>
                                                <th>Berat</th>
                                                <th>User</th>
                                                <th>Post Date</th>
                                                <th>#</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                <h6>* klik baris tabel untuk melihat detail dan mengubah data</h6>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Tambah SMU (Dinamis dan Sesuai Data in_list.php) -->
                <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modalTambahSMU">
                    <div class="modal-dialog modal-lg" style="width: 90%;">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                                <h4 class="modal-title" id="myModalLabel">Tambah SMU Incoming</h4>
                            </div>
                            <form class="form-horizontal form-label-left" method="POST" action="<?= base_url('incominghlp/store_smu') ?>">
                                <div class="modal-body">
                                    <div class="row">
                                        <!-- Header Informasi Pesawat & Asal -->
                                        <div class="col-md-6 col-xs-12">
                                            <div class="form-group">
                                                <label class="form-label">Asal (Contoh: BKS)</label>
                                                <input type="hidden" name="asal_uid" id="t_asal_uid">
                                                <input type="text" class="form-control" name="asal" id="t_asal" placeholder="Ketik bandara asal..." required>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-xs-12">
                                            <div class="form-group">
                                                <label class="form-label">No. Pesawat</label>
                                                <input type="hidden" name="pesawat_uid" id="t_pesawat_uid">
                                                <input type="text" class="form-control" name="no_pesawat" id="t_no_pesawat" placeholder="Ketik kode pesawat..." required>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-xs-12">
                                            <div class="form-group">
                                                <label class="form-label">Pesawat</label>
                                                <!-- <select name="pesawat" id="t_pesawat" class="form-control select2-pesawat-tambah" required>
                                                    <option value="">:: Pilih Pesawat</option>
                                                </select> -->

                                                <select name="pesawat" id="t_pesawat" class="form-control" required>
                                                    <option value="">:: Pilih Pesawat</option>
                                                    <option value="BATIK">BATIK</option>
                                                    <option value="CITILINK">CITILINK</option>
                                                    <option value="FLYJAYA">FLYJAYA</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-4 col-xs-12">
                                            <div class="form-group">
                                                <label class="form-label">Tanggal Terbang</label>
                                                <input type="date" class="form-control" name="tanggal_terbang" id="t_tanggal_terbang" required>
                                            </div>
                                        </div>

                                        <div class="col-md-2 col-xs-12">
                                            <div class="form-group">
                                                <label class="form-label">Waktu Tiba</label>
                                                <input type="text" class="form-control" name="time_datang" id="t_time_datang" placeholder="Contoh: 13:59">
                                            </div>
                                        </div>

                                        <div class="col-md-12 col-xs-12">
                                            <hr>
                                            <div class="d-flex justify-content-between align-items-center" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                                                <h5><b>Daftar Item SMU</b></h5>
                                                <button type="button" class="btn btn-success btn-sm" id="btn_tambah_baris_smu">
                                                    <i class="fa fa-plus"></i> Tambah Baris
                                                </button>
                                            </div>

                                            <!-- Tabel Input Dinamis -->
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-condensed" id="tabel_input_smu">
                                                    <thead>
                                                        <tr style="background-color: #f5f5f5;">
                                                            <th width="5%" class="text-center">No</th>
                                                            <th width="12%">Jns Barang</th>
                                                            <th width="20%">SMU</th>
                                                            <th width="13%">Nama Agent</th>
                                                            <th width="13%">Penerima</th>
                                                            <th width="8%">Koli/Pieces</th>
                                                            <th width="8%">Berat Gross</th>
                                                            <th width="8%">Chargeable</th>
                                                            <th width="10%">Description</th>
                                                            <th width="3%" class="text-center">Aksi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="body_input_smu">
                                                        <!-- Baris Default ke-1 -->
                                                        <tr class="baris-smu" id="row_1">
                                                            <td class="text-center nomor-urut" style="vertical-align: middle;">1</td>
                                                            <td>
                                                                <select class="form-control select-jns-barang" name="jns_barang[]" required>
                                                                    <option value="1">Langsung</option>
                                                                    <option value="2">Partial</option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <!-- <div class="input-group">
                                                                    <input type="text" class="form-control input-smu-prefix" placeholder="Prefix" style="max-width: 65px; padding: 6px 4px;" readonly>
                                                                    <span class="input-group-addon" style="padding: 6px 6px;">-</span>
                                                                    <input type="text" class="form-control smu-number-input" maxlength="8" required placeholder="Number" style="min-width: 80px;">
                                                                </div> -->
                                                                <input type="text" class="form-control input-smu-val" name="smu[]" required>
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control input-agent-val" name="nama_agent[]" placeholder="Agent...">
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control input-penerima-val" name="nama_penerima[]" placeholder="Penerima...">
                                                            </td>
                                                            <td>
                                                                <input type="number" step="any" class="form-control input-jumlah" name="jumlah[]" required placeholder="0">
                                                            </td>
                                                            <td>
                                                                <input type="number" step="any" class="form-control input-gross" name="gross[]" required placeholder="0">
                                                            </td>
                                                            <td>
                                                                <input type="number" step="any" class="form-control input-chargeable" name="chargeable[]" readonly placeholder="0">
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control" name="deskripsi[]" placeholder="Komoditi...">
                                                            </td>
                                                            <td class="text-center" style="vertical-align: middle;">
                                                                <button type="button" class="btn btn-danger btn-xs btn-hapus-baris" disabled>
                                                                    <i class="fa fa-trash"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <div class="col-md-12 col-xs-12">
                                            <hr>
                                            <div class="form-group">
                                                <label class="form-label">Tanggal SMU</label>
                                                <input type="date" class="form-control" required name="tanggal_smu" id="t_tanggal_smu">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Modal Edit/Detail SMU -->
                <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modalDetail">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                                <h4 class="modal-title">Edit SMU <span id="detail_smu"></span></h4>
                            </div>
                            <form method="POST" action="<?= base_url('incominghlp/update_kemasan_smu') ?>">
                                <input type="hidden" name="uid" id="detail_uid">
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-6 col-xs-12">
                                            <div class="form-group">
                                                <label class="form-label">Jns Barang</label>
                                                <select class="form-control" name="jns_barang" id="d_jns_barang" required>
                                                    <option value="1">Langsung (Direct)</option>
                                                    <option value="2">Sebagian (Partial)</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-xs-12">
                                            <div class="form-group">
                                                <label class="form-label">Penerima</label>
                                                <input type="text" class="form-control" name="penerima" id="d_penerima">
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-xs-12">
                                            <div class="form-group">
                                                <label class="form-label">SMU</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="d_smu_prefix_input" placeholder="938" maxlength="3" style="max-width:70px;" readonly>
                                                    <span class="input-group-addon">-</span>
                                                    <input type="text" class="form-control d-smu-number-input" placeholder="00449002" maxlength="8">
                                                </div>
                                                <input type="hidden" name="smu" id="d_smu_hidden">
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-xs-12">
                                            <div class="form-group">
                                                <label class="form-label">Tanggal SMU</label>
                                                <input type="date" class="form-control" name="tanggal_smu" id="d_tanggal_smu" required>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-xs-12">
                                            <div class="form-group">
                                                <label class="form-label">Asal</label>
                                                <input type="hidden" name="asal_uid" id="d_asal_uid">
                                                <input type="text" class="form-control" name="asal" id="d_asal" required>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-xs-12">
                                            <div class="form-group">
                                                <label class="form-label">No. Pesawat</label>
                                                <input type="hidden" name="pesawat_uid" id="d_pesawat_uid">
                                                <input type="text" class="form-control" name="no_pesawat" id="d_no_pesawat" required>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-xs-12">
                                            <div class="form-group">
                                                <label class="form-label">Pesawat</label>
                                                <select class="form-control select2-pesawat-edit" name="pesawat" id="d_pesawat" required>
                                                    <option value="">:: Pilih Pesawat</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-xs-12">
                                            <div class="form-group">
                                                <label class="form-label">Tanggal Terbang</label>
                                                <input type="date" class="form-control" name="tanggal_terbang" id="d_tanggal_terbang" required>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-xs-12">
                                            <div class="form-group">
                                                <label class="form-label">Nama Agent</label>
                                                <input type="text" class="form-control" name="nama_agent" id="d_nama_agent">
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-xs-12">
                                            <div class="form-group">
                                                <label class="form-label">Waktu Tiba</label>
                                                <input type="text" class="form-control" name="time_datang" id="d_time_datang">
                                            </div>
                                        </div>

                                        <div class="col-md-4 col-xs-12">
                                            <div class="form-group">
                                                <label class="form-label">Jumlah (Pieces)</label>
                                                <input type="number" step="any" class="form-control" name="jumlah" id="d_jumlah" required>
                                            </div>
                                        </div>

                                        <div class="col-md-4 col-xs-12">
                                            <div class="form-group">
                                                <label class="form-label">Berat Gross</label>
                                                <input type="number" step="any" class="form-control" name="gross" id="d_gross" required>
                                            </div>
                                        </div>

                                        <div class="col-md-4 col-xs-12">
                                            <div class="form-group">
                                                <label class="form-label">Chargeable</label>
                                                <input type="number" step="any" class="form-control" name="chargeable" id="d_chargeable" readonly>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-xs-12">
                                            <div class="form-group">
                                                <label class="form-label">Komoditi</label>
                                                <input type="text" class="form-control" name="komoditi" id="d_komoditi">
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-xs-12">
                                            <div class="form-group">
                                                <label class="form-label">Tanggal Masuk</label>
                                                <input type="date" class="form-control" name="tanggal_masuk" id="d_tanggal_masuk">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                                    <input type="hidden" name="new_status" id="inv_new_status" value="0">
                                    <button type="button" class="btn btn-default btn-status-inv" data-val="0">
                                        <i class="fa fa-pencil"></i> Ubah
                                    </button>
                                    <button type="button" class="btn btn-danger btn-status-inv" data-val="1">
                                        <i class="fa fa-print"></i> Hapus
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Modal Rekap -->
                <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modalRekap">
                    <div class="modal-dialog modal-md">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                                <h4 class="modal-title">Rekap Kemasan SMU Incoming</h4>
                            </div>
                            <form class="form-horizontal form-label-left" method="POST" action="<?= base_url('incominghlp/rekap_kemasan_smu') ?>">
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-6 col-xs-12">
                                            <div class="form-group">
                                                <label class="form-label">Dari Tanggal</label>
                                                <input type="date" class="form-control" name="dari" id="dari_r" required>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-xs-12">
                                            <div class="form-group">
                                                <label class="form-label">Sampai Tanggal</label>
                                                <input type="date" class="form-control" name="sampai" id="sampai_r" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary">Unduh Excel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
            <!-- /page content -->
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
    <!-- iCheck -->
    <script src="<?= base_url(); ?>src/vendors/iCheck/icheck.min.js"></script>
    <!-- Sweetalert -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- jQuery AutoComplete -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-autocomplete/1.0.7/jquery.auto-complete.min.js"></script>
    <!-- Select2 JS -->
    <script type="text/javascript" src="<?= base_url(); ?>src/select2/js/select2.min.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="<?= base_url(); ?>src/build/js/custom.min.js"></script>

    <!-- DataTables JS -->
    <script src="<?= base_url(); ?>src/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="<?= base_url(); ?>src/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script>
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
    </script>
    <script>
        $(document).ready(function() {

            // Global variable untuk mencatat prefix pesawat terpilih saat ini
            var selectedPesawatPrefix = "";

            // =============================================
            // INITIALIZE DATATABLE INCOMING
            // =============================================
            $('#kemasan_table').DataTable({
                processing: true,
                serverSide: true,
                scrollX: true,
                order: [],
                ajax: {
                    url: '<?= base_url("incominghlp/getData_kemasan_smu") ?>',
                    type: 'POST'
                },
                columnDefs: [{
                        orderable: false,
                        targets: [-1]
                    },
                    {
                        visible: true,
                        targets: 0
                    }
                ],
                rowCallback: function(row, data) {
                    $(row).attr('data-uid', data[0]);
                    $(row).css('cursor', 'pointer');
                },
                language: {
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                    infoEmpty: "Tidak ada data",
                    zeroRecords: "Data tidak ditemukan",
                    processing: "Memuat data..."
                }
            });

            // =============================================
            // INITIALIZE SELECT2 TAMBAH (Modal Tambah SMU)
            // =============================================
            $('#modalTambahSMU').on('shown.bs.modal', function() {
                if ($('.select2-pesawat-tambah').data('select2')) {
                    $('.select2-pesawat-tambah').select2('destroy');
                }

                $('.select2-pesawat-tambah').select2({
                    placeholder: ':: Pilih Pesawat',
                    allowClear: true,
                    dropdownParent: $('#modalTambahSMU .modal-content'),
                    ajax: {
                        url: '<?= base_url('incominghlp/get_pesawat') ?>',
                        type: 'POST',
                        dataType: 'json',
                        delay: 250,
                        data: function(params) {
                            return {
                                search: params.term
                            };
                        },
                        processResults: function(data) {
                            return {
                                results: $.map(data, function(item) {
                                    return {
                                        id: item.nama,
                                        text: item.nama + ' - ' + item.prefix,
                                        prefix: item.prefix
                                    };
                                })
                            };
                        }
                    }
                });
            });

            // Deteksi perubahan pesawat di form tambah
            // $(document).on('select2:select', '#t_pesawat', function(e) {
            //     var prefix = e.params.data.prefix ?? '';
            //     selectedPesawatPrefix = prefix;
            //     updateAllRowPrefixes(prefix);
            // });

            // $(document).on('select2:unselect', '#t_pesawat', function() {
            //     selectedPesawatPrefix = '';
            //     updateAllRowPrefixes('');
            // });

            // // Fungsi mendistribusikan prefix pesawat ke seluruh input-prefix di baris tabel
            // function updateAllRowPrefixes(prefix) {
            //     $('#body_input_smu tr.baris-smu').each(function() {
            //         var $row = $(this);
            //         $row.find('.input-smu-prefix').val(prefix);
            //         updateRowSmuValue($row);
            //     });
            // }

            // // Fungsi menggabungkan prefix & nomor SMU ke input-hidden asli "smu[]"
            // function updateRowSmuValue($row) {
            //     var prefix = $row.find('.input-smu-prefix').val() || '';
            //     var number = $row.find('.smu-number-input').val() || '';

            //     if (prefix && number) {
            //         $row.find('.input-smu-val').val(prefix + '-' + number);
            //     } else if (number) {
            //         $row.find('.input-smu-val').val(number);
            //     } else {
            //         $row.find('.input-smu-val').val('');
            //     }
            // }

            // Format input numerik SMU (maksimal 8 digit)
            $(document).on('input', '.smu-number-input', function() {
                var val = $(this).val().replace(/\D/g, '').substring(0, 8);
                $(this).val(val);
                var $row = $(this).closest('tr');
                updateRowSmuValue($row);
            });

            // Format input di form edit (Modal Detail)
            $(document).on('input', '.d-smu-number-input', function() {
                var val = $(this).val().replace(/\D/g, '').substring(0, 8);
                $(this).val(val);
                updateSmuHiddenEdit();
            });

            function updateSmuHiddenEdit() {
                var prefix = $('#d_smu_prefix_input').val();
                var number = $('.d-smu-number-input').val();
                $('#d_smu_hidden').val(prefix && number ? prefix + '-' + number : (number || ''));
            }

            // Click Row - Buka Modal Detail & Edit
            $('#kemasan_table tbody').on('click', 'tr', function(e) {
                if ($(e.target).closest('button, a').length) return;

                var uid = $(this).data('uid');
                if (!uid) return;

                $.ajax({
                    url: '<?= base_url('incominghlp/get_detail_smu') ?>/' + uid,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        var r = data.row;

                        // Ekstrak prefix dan number dari string SMU database
                        var smu_parts = (r.smu ?? '').split('-');
                        var smu_prefix = smu_parts[0] ?? '';
                        var smu_number = smu_parts.slice(1).join('-') ?? '';

                        $('#detail_smu').text(r.smu);
                        $('#detail_uid').val(r.uid);
                        $('#d_jns_barang').val(r.jns_barang);
                        $('#d_penerima').val(r.nama_penerima);

                        // Isi split input SMU
                        $('#d_smu_prefix_input').val(smu_prefix);
                        $('.d-smu-number-input').val(smu_number);
                        $('#d_smu_hidden').val(r.smu);

                        $('#d_tanggal_smu').val(r.tanggal_smu);

                        $('#d_asal').val(r.asal);
                        $('#d_asal_uid').val(r.asal_uid);

                        $('#d_no_pesawat').val(r.no_pesawat);
                        $('#d_pesawat_uid').val(r.pesawat_uid);

                        $('#d_tanggal_terbang').val(r.tanggal_terbang);
                        $('#d_nama_agent').val(r.nama_agent);
                        $('#d_time_datang').val(r.time_datang);

                        $('#d_jumlah').val(r.jumlah);
                        $('#d_gross').val(r.gross);
                        $('#d_chargeable').val(r.chargeable);
                        $('#d_komoditi').val(r.komoditi);
                        $('#d_tanggal_masuk').val(r.in_date_formatted);

                        // Munculkan modal
                        $('#modalDetail').modal('show');

                        // Inisialisasi Select2 Pesawat Edit setelah modal dibuka
                        $('#modalDetail').one('shown.bs.modal', function() {
                            if ($('.select2-pesawat-edit').data('select2')) {
                                $('.select2-pesawat-edit').select2('destroy');
                            }

                            $('.select2-pesawat-edit').select2({
                                placeholder: ':: Pilih Pesawat',
                                allowClear: true,
                                dropdownParent: $('#modalDetail .modal-content'),
                                ajax: {
                                    url: '<?= base_url('incominghlp/get_pesawat') ?>',
                                    type: 'POST',
                                    dataType: 'json',
                                    delay: 250,
                                    data: function(params) {
                                        return {
                                            search: params.term
                                        };
                                    },
                                    processResults: function(data) {
                                        return {
                                            results: $.map(data, function(item) {
                                                return {
                                                    id: item.nama,
                                                    text: item.nama + ' - ' + item.prefix,
                                                    prefix: item.prefix
                                                };
                                            })
                                        };
                                    }
                                }
                            });

                            // Set nilai awal Select2 edit pesawat
                            if (r.pesawat) {
                                var optionText = r.pesawat + (r.prefix ? ' - ' + r.prefix : '');
                                var newOption = new Option(optionText, r.pesawat, true, true);
                                $('#d_pesawat').append(newOption).trigger('change');
                            }
                        });
                    }
                });
            });

            // Deteksi perubahan pesawat di form edit
            $(document).on('select2:select', '#d_pesawat', function(e) {
                var prefix = e.params.data.prefix ?? '';
                $('#d_smu_prefix_input').val(prefix);
                updateSmuHiddenEdit();
            });

            $(document).on('select2:unselect', '#d_pesawat', function() {
                $('#d_smu_prefix_input').val('');
                updateSmuHiddenEdit();
            });

            // =============================================
            // PROGRAM TAMBAH / HAPUS BARIS SMU DINAMIS
            // =============================================
            var barisCounter = 1;

            $('#btn_tambah_baris_smu').on('click', function() {
                barisCounter++;
                var html = `
                    <tr class="baris-smu" id="row_${barisCounter}">
                        <td class="text-center nomor-urut" style="vertical-align: middle;">${barisCounter}</td>
                        <td>
                            <select class="form-control select-jns-barang" name="jns_barang[]" required>
                                <option value="1">Langsung</option>
                                <option value="2">Partial</option>
                            </select>
                        </td>
                        <td>
                            <input type="text" class="form-control input-smu-val" name="smu[]" required>
                        </td>
                        <td>
                            <input type="text" class="form-control input-agent-val" name="nama_agent[]" placeholder="Agent...">
                        </td>
                        <td>
                            <input type="text" class="form-control input-penerima-val" name="nama_penerima[]" placeholder="Penerima...">
                        </td>
                        <td>
                            <input type="number" step="any" class="form-control input-jumlah" name="jumlah[]" required placeholder="0">
                        </td>
                        <td>
                            <input type="number" step="any" class="form-control input-gross" name="gross[]" required placeholder="0">
                        </td>
                        <td>
                            <input type="number" step="any" class="form-control input-chargeable" name="chargeable[]" readonly placeholder="0">
                        </td>
                        <td>
                            <input type="text" class="form-control" name="deskripsi[]" placeholder="Komoditi...">
                        </td>
                        <td class="text-center" style="vertical-align: middle;">
                            <button type="button" class="btn btn-danger btn-xs btn-hapus-baris">
                                <i class="fa fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                `;
                $('#body_input_smu').append(html);
                updateNomorUrut();
            });

            // Aksi Hapus Baris
            $(document).on('click', '.btn-hapus-baris', function() {
                $(this).closest('tr').remove();
                updateNomorUrut();
            });

            // Fungsi Memperbarui Nomor Baris Setelah Hapus/Tambah
            function updateNomorUrut() {
                var totalBaris = 0;
                $('#body_input_smu tr.baris-smu').each(function(index) {
                    totalBaris++;
                    $(this).find('.nomor-urut').text(index + 1);
                });

                // Jika baris tinggal 1, matikan tombol hapus baris pertama
                if (totalBaris === 1) {
                    $('#body_input_smu tr.baris-smu').find('.btn-hapus-baris').prop('disabled', true);
                } else {
                    $('.btn-hapus-baris').prop('disabled', false);
                }
            }

            // =============================================
            // AUTO CALCULATION CHARGEABLE (GROSS VS 10KG DEFAULT)
            // Sesuai Aturan: Di bawah 10Kg dipaksa jadi 10, di atas 10Kg pakai nilai asli
            // =============================================
            function hitungChargeable(grossInput) {
                var grossValue = parseFloat(grossInput.val()) || 0;
                var chargeableInput = grossInput.closest('tr').find('.input-chargeable');

                if (grossValue > 10) {
                    chargeableInput.val(Math.ceil(grossValue));
                } else if (grossValue > 0 && grossValue <= 10) {
                    chargeableInput.val(10);
                } else {
                    chargeableInput.val('');
                }
            }

            // Berlaku untuk Modal Tambah (Dinamis)
            $(document).on('keyup change', '.input-gross', function() {
                hitungChargeable($(this));
            });

            // Berlaku untuk Modal Edit/Detail
            $(document).on('keyup change', '#d_gross', function() {
                var grossValue = parseFloat($(this).val()) || 0;
                if (grossValue > 10) {
                    $('#d_chargeable').val(Math.ceil(grossValue));
                } else if (grossValue > 0 && grossValue <= 10) {
                    $('#d_chargeable').val(10);
                } else {
                    $('#d_chargeable').val('');
                }
            });

            // =============================================
            // AUTOCOMPLETE AUTO-FILL (PORT ASAL)
            // =============================================

            // 1. Autocomplete untuk Asal Airport di Modal Tambah
            $('#t_asal').autoComplete({
                minChars: 1,
                source: function(term, suggest) {
                    term = term.toLowerCase();
                    $.getJSON('<?= base_url("incominghlp/get_autocomplete_asal") ?>?key=' + term, function(data) {
                        var suggestions = [];
                        for (var i = 0; i < data.length; i++) {
                            if (~(data[i].kode + ' ' + data[i].nama).toLowerCase().indexOf(term)) {
                                suggestions.push(data[i]);
                            }
                        }
                        suggest(suggestions);
                    });
                },
                renderItem: function(item, search) {
                    search = search.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
                    var re = new RegExp("(" + search.split(' ').join('|') + ")", "gi");
                    return '<div class="autocomplete-suggestion" data-uid="' + item.uid + '" data-kode="' + item.kode_kota + '" data-nama="' + item.nama + '" data-val="' + item.kode_kota + '">[' + item.kode_kota.replace(re, "<b>$1</b>") + '] ' + item.nama.replace(re, "<b>$1</b>") + '</div>';
                },
                onSelect: function(e, term, item) {
                    $('#t_asal').val(item.data('kode'));
                    $('#t_asal_uid').val(item.data('uid'));
                }
            });

            $('#d_asal').autoComplete({
                minChars: 1,
                source: function(term, suggest) {
                    term = term.toLowerCase();
                    $.getJSON('<?= base_url("incominghlp/get_autocomplete_asal") ?>?key=' + term, function(data) {
                        var suggestions = [];
                        for (var i = 0; i < data.length; i++) {
                            if (~(data[i].kode + ' ' + data[i].nama).toLowerCase().indexOf(term)) {
                                suggestions.push(data[i]);
                            }
                        }
                        suggest(suggestions);
                    });
                },
                renderItem: function(item, search) {
                    search = search.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
                    var re = new RegExp("(" + search.split(' ').join('|') + ")", "gi");
                    return '<div class="autocomplete-suggestion" data-uid="' + item.uid + '" data-kode="' + item.kode_kota + '" data-nama="' + item.nama + '" data-val="' + item.kode_kota + '">[' + item.kode_kota.replace(re, "<b>$1</b>") + '] ' + item.nama.replace(re, "<b>$1</b>") + '</div>';
                },
                onSelect: function(e, term, item) {
                    $('#d_asal').val(item.data('kode'));
                    $('#d_asal_uid').val(item.data('uid'));
                }
            });

            // Autocomplete untuk No. Pesawat
            $('#t_no_pesawat').autoComplete({
                minChars: 1,
                source: function(term, suggest) {
                    term = term.toLowerCase();
                    $.getJSON('<?= base_url("incominghlp/get_autocomplete_pesawat") ?>?key=' + term, function(data) {
                        var suggestions = [];
                        for (var i = 0; i < data.length; i++) {
                            if (~(data[i].kode + ' ' + data[i].nama + ' ' + data[i].time_datang).toLowerCase().indexOf(term)) {
                                suggestions.push(data[i]);
                            }
                        }
                        suggest(suggestions);
                    });
                },
                renderItem: function(item, search) {
                    search = search.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
                    var re = new RegExp("(" + search.split(' ').join('|') + ")", "gi");
                    return '<div class="autocomplete-suggestion" data-uid="' + item.uid + '" data-nama="' + item.nama + '" data-kode="' + item.kode + '" data-time="' + item.time_datang + '" data-val="' + item.kode + '">' + item.kode.replace(re, "<b>$1</b>") + ' (' + item.nama.replace(re, "<b>$1</b>") + ')</div>';
                },
                onSelect: function(e, term, item) {
                    $('#t_pesawat_uid').val(item.data('uid'));
                }
            });

            $('#d_no_pesawat').autoComplete({
                minChars: 1,
                source: function(term, suggest) {
                    term = term.toLowerCase();
                    $.getJSON('<?= base_url("incominghlp/get_autocomplete_pesawat") ?>?key=' + term, function(data) {
                        var suggestions = [];
                        for (var i = 0; i < data.length; i++) {
                            if (~(data[i].kode + ' ' + data[i].nama + ' ' + data[i].time_datang).toLowerCase().indexOf(term)) {
                                suggestions.push(data[i]);
                            }
                        }
                        suggest(suggestions);
                    });
                },
                renderItem: function(item, search) {
                    search = search.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
                    var re = new RegExp("(" + search.split(' ').join('|') + ")", "gi");
                    return '<div class="autocomplete-suggestion" data-uid="' + item.uid + '" data-nama="' + item.nama + '" data-kode="' + item.kode + '" data-time="' + item.time_datang + '" data-val="' + item.kode + '">' + item.kode.replace(re, "<b>$1</b>") + ' (' + item.nama.replace(re, "<b>$1</b>") + ')</div>';
                },
                onSelect: function(e, term, item) {
                    $('#d_pesawat_uid').val(item.data('uid'));
                }
            });

            // =============================================
            // LIMIT TANGGAL HARI INI
            // =============================================
            var today = new Date().toISOString().split('T')[0];
            $('#t_tanggal_smu').attr('max', today);
            $('#t_tanggal_terbang').attr('max', today);
            $('#d_tanggal_smu').attr('max', today);
            $('#d_tanggal_terbang').attr('max', today);
            $('#d_tanggal_masuk').attr('max', today);

            // Ganti Status Proses Simpan / Update
            $(document).on('click', '.btn-status-inv', function() {
                var val = $(this).data('val');
                var $form = $(this).closest('form');

                if (val == '1') {
                    if (!confirm('Yakin ingin Menghapus SMU ini?')) return;
                }

                $('.btn-status-inv').removeClass('active');
                $(this).addClass('active');
                $('#inv_new_status').val(val);
                $form.submit();
            });

            // Reset Form Modal Tambah Saat Ditutup
            $('#modalTambahSMU').on('hidden.bs.modal', function() {
                $(this).find('form')[0].reset();
                selectedPesawatPrefix = "";
                $('.select2-pesawat-tambah').val(null).trigger('change');
                // Hapus baris tambahan dan sisakan baris ke-1
                $('#body_input_smu tr.baris-smu:not(#row_1)').remove();
                $('#row_1').find('.input-smu-prefix').val('');
                $('#row_1').find('.smu-number-input').val('');
                $('#row_1').find('.input-smu-val').val('');
                updateNomorUrut();
            });
        });
    </script>
</body>

</html>