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
                                <h2>Daftar Kemasan SMU</h2>
                                <ul class="nav navbar-right panel_toolbox">
                                    <li>
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalTambahSMU">
                                            Tambah
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
                                                <th>Kategori SMU</th>
                                                <th>SMU</th>
                                                <th>Tujuan</th>
                                                <th>Pieces</th>
                                                <th>Berat</th>
                                                <th>Volume</th>
                                                <th>Pengirim</th>
                                                <th>Post Date</th>
                                                <th>Jaster</th>
                                                <th>#</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                <h6>* klik nama customer untuk edit</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Finish content-->

        </div>

        <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modalTambahSMU">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Tambah SMU</h4>
                    </div>
                    <form class="form-horizontal form-label-left" method="POST" action="<?= base_url('outgoinghlp/store_smu') ?>">
                        <div class="modal-body">
                            <div class="row">

                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Jenis Barang</label>
                                        <select class="form-control" name="jns_barang" required>
                                            <option value="1">Langsung (Direct)</option>
                                            <option value="2">Sebagian (Partial)</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Kategori SMU</label>
                                        <select class="form-control" name="catg_smu" required>
                                            <option value="1">Langsung (Direct)</option>
                                            <option value="2">Angkut Lanjut (Transhipment)</option>
                                            <option value="3">Terminal Change (w/o Invoice)</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Reposisi: Input Pesawat dipindahkan ke sebelum SMU -->
                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Pesawat</label>
                                        <select name="pesawat" id="t_pesawat" class="form-control select2-pesawat-tambah" required>
                                            <option value="">:: Pilih Pesawat</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Nomor SMU</label>

                                        <!-- Input Group untuk mode Manual (Default Tampil) -->
                                        <div class="input-group" id="smu_group_manual">
                                            <input type="text" class="form-control" id="smu_prefix_input" placeholder="938" maxlength="3" style="max-width:70px;" readonly>
                                            <span class="input-group-addon">-</span>
                                            <input type="text" class="form-control smu-number-input" id="smu_number_input" placeholder="00449002" maxlength="8" required>
                                        </div>

                                        <!-- Input untuk Mode Full/Scan (Default Sembunyi) -->
                                        <input type="text" name="smu" id="smu_hidden" class="form-control" placeholder="Scan SMU di sini..." style="display: none;" required>
                                    </div>

                                    <!-- Checkbox / Switcher Mode -->
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" id="check_mode_scan"> Mode Direct Scan SMU
                                        </label>
                                    </div>
                                </div>

                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Tanggal SMU</label>
                                        <input type="date" class="form-control" name="tanggal_smu" required>
                                    </div>
                                </div>

                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Tujuan</label>
                                        <select name="tujuan" id="t_tujuan" class="form-control select2-tujuan-tambah" required>
                                            <option value="">:: Pilih Tujuan</option>
                                        </select>
                                        <input type="hidden" name="tujuan_uid" id="t_tujuan_uid" required>
                                    </div>
                                </div>

                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">No. Pesawat</label>
                                        <input type="text" class="form-control" name="no_pesawat" id="t_no_pesawat" placeholder="0001" required>
                                    </div>
                                </div>

                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Tanggal Terbang</label>
                                        <input type="date" class="form-control" name="tanggal_terbang" required>
                                    </div>
                                </div>

                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <!-- Waktu Terbang tidak required (opsional) -->
                                        <label class="form-label">Waktu Terbang</label>
                                        <input type="time" class="form-control" name="time_terbang" placeholder="Contoh: 13:59">
                                    </div>
                                </div>

                                <div class="col-md-12 col-xs-12">
                                    <hr>
                                    <h5><b>Pengirim</b></h5>
                                </div>

                                <!-- <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Nama Pengirim</label>
                                        <input type="hidden" name="pengirim_uid" id="t_pengirim_uid" required>
                                        <select name="nama_pengirim" id="t_nama_pengirim" class="form-control select2-pengirim-tambah" required>
                                            <option value="">:: Pilih Pengirim</option>
                                        </select>
                                    </div>
                                </div> -->

                                <!-- <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Nama Pengirim</label>
                                        <input type="text" class="form-control" name="nama_pengirim" id="t_nama_pengirim" required>
                                    </div>
                                </div> -->

                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Nama Pengirim</label>
                                        <select name="nama_pengirim" id="t_nama_pengirim"
                                            class="form-control select2-pengirim-tambah" required></select>
                                        <small class="text-muted" id="t_pengirim_hint"></small>
                                    </div>
                                </div>

                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Telepon Pengirim</label>
                                        <input type="text" class="form-control" name="telepon_pengirim" id="t_telepon_pengirim">
                                    </div>
                                </div>

                                <div class="col-md-12 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Alamat Pengirim</label>
                                        <textarea class="form-control" name="alamat_pengirim" id="t_alamat_pengirim" rows="2"></textarea>
                                    </div>
                                </div>

                                <div class="col-md-12 col-xs-12">
                                    <hr>
                                    <h5><b>Penerima</b></h5>
                                </div>

                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Nama Penerima</label>
                                        <input type="hidden" name="penerima_uid" id="t_penerima_uid">
                                        <input type="text" class="form-control" name="nama_penerima" id="t_nama_penerima" required>
                                    </div>
                                </div>

                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <!-- Telepon Penerima tidak required (opsional) -->
                                        <label class="form-label">Telepon Penerima</label>
                                        <input type="text" class="form-control" name="telepon_penerima" id="t_telepon_penerima">
                                    </div>
                                </div>

                                <div class="col-md-12 col-xs-12">
                                    <div class="form-group">
                                        <!-- Alamat Penerima tidak required (opsional) -->
                                        <label class="form-label">Alamat Penerima</label>
                                        <textarea class="form-control" name="alamat_penerima" id="t_alamat_penerima" rows="2"></textarea>
                                    </div>
                                </div>

                                <div class="col-md-12 col-xs-12">
                                    <hr>
                                    <h5><b>Informasi Lain</b></h5>
                                </div>

                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Nama Agent</label>
                                        <input type="hidden" name="agent_uid" id="t_agent_uid" required>
                                        <select name="nama_agent" id="t_nama_agent" class="form-control select2-agent-tambah" required>
                                            <option value="">:: Pilih Agent</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <!-- Jaster tidak required (opsional) -->
                                        <label class="form-label">Jaster</label>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="jaster" id="t_jaster" value="1"> Jaster
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 col-xs-12">
                                    <hr>
                                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">
                                        <h5><b>Dimensi <span id="t_pembagi_label" class="text-primary" style="font-size: 13px; font-weight: normal;"></span></b></h5>
                                        <button type="button" class="btn btn-sm btn-success" id="btnTambahDimensiTambah">
                                            <i class="fa fa-plus"></i> Tambah
                                        </button>
                                    </div>
                                    <table class="table table-bordered table-condensed" id="tabelDimensiTambah">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Panjang</th>
                                                <th>Lebar</th>
                                                <th>Tinggi</th>
                                                <th>Pieces</th>
                                                <th>Dimensi</th>
                                                <th>Volume</th>
                                                <th>Total Volume</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody id="bodyDimensiTambah">
                                            <tr class="no-data-row">
                                                <td colspan="9" class="text-center">Tidak ada data</td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="6" class="text-right"><b>Total Volume</b></td>
                                                <td id="t_total_volume_sum">0.00</td>
                                                <td id="t_total_volume_all">0.00</td>
                                                <td></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>

                                <div class="col-md-4 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Jumlah (Koli)</label>
                                        <input type="number" class="form-control" name="jumlah" id="t_jumlah" required>
                                    </div>
                                </div>

                                <div class="col-md-4 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Berat Gross</label>
                                        <input type="number" step="0.01" class="form-control" name="gross" id="t_gross" required>
                                    </div>
                                </div>

                                <div class="col-md-4 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Komoditi</label>
                                        <input type="text" class="form-control" name="komoditi" id="t_komoditi" required>
                                    </div>
                                </div>

                                <div class="col-md-4 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Berat Volume</label>
                                        <input type="number" class="form-control" name="volume" id="t_volume" required>
                                    </div>
                                </div>

                                <div class="col-md-4 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Chargeable</label>
                                        <input type="number" step="0.01" class="form-control" name="chargeable" id="t_chargeable" required>
                                    </div>
                                </div>

                                <div class="col-md-4 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Tanggal Masuk</label>
                                        <input type="date" class="form-control" name="tanggal_masuk" id="t_tanggal_masuk" required>
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

        <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modalDetail">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit SMU <span id="detail_smu"></span></h4>
                    </div>
                    <form method="POST" action="<?= base_url('outgoinghlp/update_kemasan_smu') ?>" id="formEditSMU">
                        <input type="hidden" name="uid" id="detail_uid">
                        <div class="modal-body">
                            <div class="row">

                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Jenis Barang</label>
                                        <select class="form-control" name="jns_barang" id="d_jns_barang" required>
                                            <option value="1">Langsung (Direct)</option>
                                            <option value="2">Sebagian (Partial)</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Kategori SMU</label>
                                        <select class="form-control" name="catg_smu" id="d_catg_smu" required>
                                            <option value="1">Langsung (Direct)</option>
                                            <option value="2">Angkut Lanjut (Transhipment)</option>
                                            <option value="3">Terminal Change (w/o Invoice)</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Reposisi: Input Pesawat dipindahkan ke sebelum SMU di Modal Edit -->
                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Pesawat</label>
                                        <select name="pesawat" id="d_pesawat" class="form-control select2-pesawat-edit" required>
                                            <option value="">:: Pilih Pesawat</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">SMU</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="d_smu_prefix_input" placeholder="938" maxlength="3" style="max-width:70px;" readonly>
                                            <span class="input-group-addon">-</span>
                                            <input type="text" class="form-control d-smu-number-input" placeholder="00449002" maxlength="8" required>
                                        </div>
                                        <input type="hidden" name="smu" id="d_smu_hidden" required>
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
                                        <label class="form-label">Tujuan</label>
                                        <input type="hidden" name="tujuan_uid" id="d_tujuan_uid" required>
                                        <select name="tujuan" id="d_tujuan" class="form-control select2-tujuan-edit" required>
                                            <option value="">:: Pilih Tujuan</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">No. Pesawat</label>
                                        <input type="text" class="form-control" name="no_pesawat" id="d_no_pesawat" required>
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
                                        <!-- Waktu Terbang tidak required (opsional) -->
                                        <label class="form-label">Waktu Terbang</label>
                                        <input type="time" class="form-control" name="time_terbang" id="d_time_terbang" placeholder="Contoh: 13:59">
                                    </div>
                                </div>

                                <div class="col-md-12 col-xs-12">
                                    <hr>
                                    <h5><b>Pengirim</b></h5>
                                </div>

                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Nama Pengirim</label>
                                        <select name="nama_pengirim" id="d_nama_pengirim"
                                            class="form-control select2-pengirim-edit" required></select>
                                        <small class="text-muted" id="d_pengirim_hint"></small>
                                    </div>
                                </div>

                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Telepon Pengirim</label>
                                        <input type="text" class="form-control" name="telepon_pengirim" id="d_telepon_pengirim">
                                    </div>
                                </div>

                                <div class="col-md-12 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Alamat Pengirim</label>
                                        <textarea class="form-control" name="alamat_pengirim" id="d_alamat_pengirim" rows="2"></textarea>
                                    </div>
                                </div>

                                <div class="col-md-12 col-xs-12">
                                    <hr>
                                    <h5><b>Penerima</b></h5>
                                </div>

                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Nama Penerima</label>
                                        <input type="text" class="form-control" name="nama_penerima" id="d_nama_penerima" required>
                                    </div>
                                </div>

                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <!-- Telepon Penerima tidak required (opsional) -->
                                        <label class="form-label">Telepon Penerima</label>
                                        <input type="text" class="form-control" name="telepon_penerima" id="d_telepon_penerima">
                                    </div>
                                </div>

                                <div class="col-md-12 col-xs-12">
                                    <div class="form-group">
                                        <!-- Alamat Penerima tidak required (opsional) -->
                                        <label class="form-label">Alamat Penerima</label>
                                        <textarea class="form-control" name="alamat_penerima" id="d_alamat_penerima" rows="2"></textarea>
                                    </div>
                                </div>

                                <div class="col-md-12 col-xs-12">
                                    <hr>
                                    <h5><b>Informasi Lain</b></h5>
                                </div>

                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Nama Agent</label>
                                        <input type="hidden" name="agent_uid" id="d_agent_uid" required>
                                        <select name="nama_agent" id="d_nama_agent" class="form-control select2-agent-edit" required>
                                            <option value="">:: Pilih Agent</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <!-- Jaster tidak required (opsional) -->
                                        <label class="form-label">Jaster</label>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="jaster" id="d_jaster" value="1"> Jaster
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 col-xs-12">
                                    <hr>
                                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">
                                        <h5><b>Dimensi <span id="d_pembagi_label" class="text-primary" style="font-size: 13px; font-weight: normal;"></span></b></h5>
                                        <button type="button" class="btn btn-sm btn-success" id="btnTambahDimensi">
                                            <i class="fa fa-plus"></i> Tambah
                                        </button>
                                    </div>
                                    <table class="table table-bordered table-condensed" id="tabelDimensi">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Panjang</th>
                                                <th>Lebar</th>
                                                <th>Tinggi</th>
                                                <th>Pieces</th>
                                                <th>Dimensi</th>
                                                <th>Volume</th>
                                                <th>Total Volume</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody id="bodyDimensi">
                                            <tr>
                                                <td colspan="9" class="text-center">Tidak ada data</td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="6" class="text-right"><b>Total Volume</b></td>
                                                <td id="d_total_volume_sum"></td>
                                                <td id="d_total_volume_all"></td>
                                                <td></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <div class="col-md-4 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Jumlah (Koli)</label>
                                        <input type="number" class="form-control" name="jumlah" id="d_jumlah" required>
                                    </div>
                                </div>

                                <div class="col-md-4 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Berat Gross</label>
                                        <input type="number" step="0.01" class="form-control" name="gross" id="d_gross" required>
                                    </div>
                                </div>

                                <div class="col-md-4 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Komoditi</label>
                                        <input type="text" class="form-control" name="komoditi" id="d_komoditi" required>
                                    </div>
                                </div>

                                <div class="col-md-4 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Berat Volume</label>
                                        <input type="number" step="0.01" class="form-control" name="volume" id="d_volume" required>
                                    </div>
                                </div>

                                <div class="col-md-4 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Chargeable</label>
                                        <input type="number" step="0.01" class="form-control" name="chargeable" id="d_chargeable" required>
                                    </div>
                                </div>

                                <div class="col-md-4 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Tanggal Masuk</label>
                                        <input type="date" class="form-control" name="tanggal_masuk" id="d_tanggal_masuk" required>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                            <button type="button" class="btn btn-primary" id="btn-selesai-smu">Selesai SMU Lama</button>
                            <button type="submit" class="btn btn-warning">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Konfirmasi BTB -->
        <div class="modal fade" id="confirmBtbModal" tabindex="-1" role="dialog" aria-labelledby="confirmBtbModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmBtbModalLabel">Konfirmasi Kirim ke BTB</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Apakah Anda yakin ingin memproses data dengan SMU <strong id="modal-smu-text"></strong> ke BTB?</p>

                        <!-- Tampilan Nomor BTB Otomatis -->
                        <div class="alert alert-info">
                            <strong>Estimasi Nomor BTB Baru:</strong>
                            <span id="modal-btb-no-preview" class="badge badge-primary" style="font-size: 14px;">Memuat...</span>
                        </div>
                        <!-- Input Tanggal BTB -->
                        <div class="form-group">
                            <label for="modal-btb-date"><strong>Tanggal BTB:</strong></label>
                            <input type="date" id="modal-btb-date" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
                            <small class="text-danger" id="date-error" style="display:none;">Tanggal BTB wajib diisi!</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="button" id="btn-proses-btb-confirm" class="btn btn-primary">Ya, Proses</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modalRekap">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Rekap Kemasan SMU</h4>
                    </div>
                    <form class="form-horizontal form-label-left" method="POST" action="<?= base_url('outgoinghlp/rekap_kemasan_smu') ?>">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Dari</label>
                                        <input type="date" class="form-control" name="dari" id="dari_r" required>
                                    </div>
                                </div>

                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Sampai</label>
                                        <input type="date" class="form-control" name="sampai" id="sampai_r" required>
                                    </div>
                                </div>

                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Catg Via</label>
                                        <select class="form-control" required="" name="catg">
                                            <option value="all">ALL</option>
                                            <option value="gudang_langsung">Langsung Gudang</option>
                                            <option value="ra_apk">RA APK</option>
                                        </select>
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
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Select2 -->
    <link rel="stylesheet" href="<?= base_url(); ?>src/select2/css/select2.min.css">
    <script type="text/javascript" src="<?= base_url(); ?>src/select2/js/select2.min.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="<?= base_url(); ?>src/build/js/custom.min.js"></script>

    <!-- DataTables JS -->
    <script src="<?= base_url(); ?>src/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="<?= base_url(); ?>src/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

    <script>
        $(document).ready(function() {
            // Mencegah dan memproses tombol Enter di dalam form Tambah, Edit, dan Rekap secara aman
            $(document).on('keydown', '#modalTambahSMU form input, #modalDetail form input, #modalRekap form input', function(e) {
                if (e.which === 13) { // Deteksi kode kunci untuk tombol Enter (13)
                    // Pastikan input bukan bagian dari kolom pencarian internal Select2
                    if (!$(this).hasClass('select2-search__field')) {
                        e.preventDefault(); // Hentikan aksi default Enter agar tidak mengacaukan halaman

                        var form = $(this).closest('form');
                        var submitButton = form.find('button[type="submit"]');

                        // Memicu klik tombol submit bawaan agar browser menampilkan balon peringatan jika ada kolom wajib yang kosong
                        if (submitButton.length > 0) {
                            submitButton.trigger('click');
                        } else {
                            form.submit();
                        }
                    }
                }
            });
        });
    </script>

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
            unset($_SESSION['message_error']);
        } ?>
    </script>
    <script>
        $(document).ready(function() {

            $('#inputBarcode').on('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault(); // Tahan form agar tidak submit

                    let barcodeValue = $(this).val(); // Mengambil nilai (contoh: 888-12742133)

                    if (barcodeValue !== '') {
                        // Jalankan fungsi pencarian / pemrosesan data Anda
                        prosesData(barcodeValue);

                        // Clear input setelah di-scan
                        $(this).val('');
                    }
                }
            });

            function prosesData(code) {
                console.log("Data berhasil ditangkap:", code);
                // Panggil AJAX atau pindah fokus ke elemen berikutnya
            }

            var today = new Date().toISOString().split('T')[0];
            $('#t_tanggal_masuk').val(today);

            // =============================================
            // DATATABLE
            // =============================================
            $('#kemasan_table').DataTable({
                processing: true,
                serverSide: true,
                scrollX: true,
                order: [
                    // [10, 'asc']
                ],
                ajax: {
                    url: '<?= base_url("outgoinghlp/getData_kemasan_smu") ?>',
                    type: 'POST'
                },
                columnDefs: [{
                    visible: false,
                    targets: 0
                }],
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
                    processing: "Memuat data...",
                    paginate: {
                        previous: "Sebelumnya",
                        next: "Selanjutnya"
                    }
                }
            });

            $(document).on('input', '.smu-input', function() {
                var val = $(this).val();
                val = val.replace(/[^\d-]/g, '');
                var raw = val.replace(/-/g, '');
                if (raw.length > 11) {
                    raw = raw.substring(0, 11);
                }
                if (raw.length > 3) {
                    val = raw.substring(0, 3) + '-' + raw.substring(3);
                } else {
                    val = raw;
                }
                $(this).val(val);
            });

            var currentListUid = null;
            var justSavedUids = [];

            // Click row - buka modal detail
            $('#kemasan_table tbody').on('click', 'tr', function(e) {
                if ($(e.target).closest('button, a').length) return;

                var uid = $(this).data('uid');
                if (!uid) return;

                $.ajax({
                    url: '<?= base_url('outgoinghlp/get_detail_smu') ?>/' + uid,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        var r = data.row;
                        currentListUid = r.uid;

                        var smu_parts = (r.smu ?? '').split('-');
                        var smu_prefix = smu_parts[0] ?? '';
                        var smu_number = smu_parts.slice(1).join('-') ?? '';

                        $('#d_smu_prefix_input').val(smu_prefix);
                        $('.d-smu-number-input').val(smu_number);
                        $('#d_smu_hidden').val(r.smu);

                        $('#detail_uid').val(r.uid);
                        $('#d_jns_barang').val(r.jns_barang);
                        $('#d_catg_smu').val(r.catg_smu);
                        $('#d_smu_val').val(r.smu);
                        $('#d_tanggal_smu').val(r.tanggal_smu);
                        $('#d_no_pesawat').val(r.no_pesawat);
                        $('#d_tanggal_terbang').val(r.tanggal_terbang);
                        $('#d_time_terbang').val(r.time_terbang);
                        // $('#d_nama_pengirim').val(r.nama_pengirim);
                        $('#d_telepon_pengirim').val(r.telepon_pengirim);
                        $('#d_alamat_pengirim').val(r.alamat_pengirim);
                        $('#d_nama_penerima').val(r.nama_penerima);
                        $('#d_telepon_penerima').val(r.telepon_penerima);
                        $('#d_alamat_penerima').val(r.alamat_penerima);
                        $('#d_jaster').prop('checked', r.jaster == '1');
                        $('#d_jumlah').val(r.jumlah);
                        $('#d_gross').val(r.gross);
                        $('#d_komoditi').val(r.komoditi);
                        $('#d_volume').val(r.volume);
                        $('#d_chargeable').val(r.chargeable);
                        $('#d_tanggal_masuk').val(r.in_date_formatted);

                        if (r.out_p == '1' && r.btb_p == '1') {
                            $('#btn-selesai-smu').show();
                        } else {
                            $('#btn-selesai-smu').hide();
                        }

                        // Show modal dulu
                        $('#modalDetail').modal('show');

                        // Fill Select2 setelah modal terbuka
                        $('#modalDetail').one('shown.bs.modal', function() {
                            $('#d_pesawat').append(
                                new Option(r.pesawat + ' - ' + r.prefix, r.pesawat, true, true)
                            ).trigger('change');

                            $('#d_tujuan').append(
                                new Option(r.tujuan, r.tujuan_uid, true, true)
                            ).trigger('change');

                            $('#d_nama_pengirim').empty();
                            if (r.nama_pengirim) {
                                $('#d_nama_pengirim').append(
                                    new Option(r.nama_pengirim, r.nama_pengirim, true, true)
                                ).trigger('change');
                            }

                            $('#d_nama_agent').append(
                                new Option(r.nama_agent, r.agent_uid, true, true)
                            ).trigger('change');
                            $('#d_agent_uid').val(r.agent_uid);

                            renderDimensi(data.dimensi);
                        });
                    }
                });
            });

            $('#modalDetail').on('shown.bs.modal', function() {
                ['select2-pesawat-edit', 'select2-tujuan-edit', 'select2-pengirim-edit',
                    'select2-penerima-edit', 'select2-agent-edit'
                ].forEach(function(cls) {
                    var el = $('.' + cls);
                    if (el.data('select2')) el.select2('destroy');
                });

                $('.select2-pesawat-edit').select2({
                    placeholder: ':: Kode',
                    allowClear: true,
                    dropdownParent: $('#modalDetail .modal-content'),
                    ajax: {
                        url: '<?= base_url('outgoinghlp/get_pesawat') ?>',
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
                                        prefix: item.prefix,
                                        jaster: item.jaster // Map properti jaster
                                    };
                                })
                            };
                        }
                    }
                });

                // Saat pesawat dipilih di edit, update prefix & sesuaikan Jaster & Pembagi label
                $('#d_pesawat').on('select2:select', function(e) {
                    var prefix = e.params.data.prefix ?? '';
                    $('#d_smu_prefix_input').val(prefix);
                    updateSmuHiddenEdit();

                    // Sinkronisasi otomatis Jaster di modal edit
                    var jasterVal = e.params.data.jaster;
                    if (jasterVal !== undefined) {
                        $('#d_jaster').prop('checked', parseInt(jasterVal) == 1);
                    }

                    // Tambahkan detail pembagi pesawat
                    var pesawatVal = $(this).val();
                    var pembagi = pesawatVal == 'BATIK' ? 5000 : 6000;
                    $('#d_pembagi_label').text('(Pembagi ' + pembagi + ')');

                    // Hitung ulang semua baris dimensi yang ada di edit modal
                    $('#bodyDimensi tr').each(function() {
                        var uid = $(this).find('input').first().data('uid');
                        if (uid) hitungDimensi(uid);
                    });
                });

                $('#d_pesawat').on('select2:unselect', function() {
                    $('#d_smu_prefix_input').val('');
                    updateSmuHiddenEdit();
                    $('#d_jaster').prop('checked', false);
                    $('#d_pembagi_label').text('');
                });

                $(document).on('input', '.d-smu-number-input', function() {
                    var val = $(this).val().replace(/\D/g, '').substring(0, 8);
                    $(this).val(val);
                    updateSmuHiddenEdit();
                });

                $(document).on('input', '#d_smu_prefix_input', function() {
                    var val = $(this).val().replace(/\D/g, '').substring(0, 3);
                    $(this).val(val);
                    updateSmuHiddenEdit();
                });

                function updateSmuHiddenEdit() {
                    var prefix = $('#d_smu_prefix_input').val();
                    var number = $('.d-smu-number-input').val();
                    $('#d_smu_hidden').val(prefix && number ? prefix + '-' + number : '');
                }

                $('.select2-tujuan-edit').select2({
                    placeholder: ':: Pilih Tujuan',
                    allowClear: true,
                    dropdownParent: $('#modalDetail .modal-content'),
                    ajax: {
                        url: '<?= base_url('outgoinghlp/get_tujuan') ?>',
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
                                        id: item.uid,
                                        text: item.kode_kota + ' - ' + item.nama,
                                        nama: item.nama // <-- tambahkan ini
                                    };
                                })
                            };
                        }
                    }
                });

                $(document).on('select2:select', '#d_tujuan', function(e) {
                    if (!$('#d_alamat_penerima').val().trim()) {
                        $('#d_alamat_penerima').val(e.params.data.nama || '');
                    }
                });

                $('.select2-pengirim-edit').select2({
                    placeholder: ':: Pilih pengirim atau ketik nama baru',
                    allowClear: true,
                    tags: true,
                    dropdownParent: $('#modalDetail .modal-content'),
                    createTag: function(params) {
                        var term = $.trim(params.term);
                        if (term === '') return null;
                        return {
                            id: term,
                            text: term,
                            isNew: true
                        };
                    },
                    templateResult: function(data) {
                        if (data.isNew) {
                            return $('<span><i class="fa fa-plus"></i> Pengirim baru: </span>')
                                .append($('<b></b>').text(data.text));
                        }
                        return data.text;
                    },
                    ajax: {
                        url: '<?= base_url('outgoinghlp/get_pengirim') ?>',
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
                                        text: item.nama,
                                        telepon: item.telepon,
                                        alamat: item.alamat
                                    };
                                })
                            };
                        }
                    }
                });

                $('.select2-agent-edit').select2({
                    placeholder: ':: Pilih Agent',
                    allowClear: true,
                    dropdownParent: $('#modalDetail .modal-content'),
                    ajax: {
                        url: '<?= base_url('outgoinghlp/get_agent') ?>',
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
                                        id: item.uid,
                                        text: item.nama
                                    };
                                })
                            };
                        }
                    }
                });
            });

            $(document).on('select2:select', '#d_nama_pengirim', function(e) {
                var data = e.params.data;
                if (data.isNew) {
                    $('#d_telepon_pengirim, #d_alamat_pengirim').val('');
                    $('#d_pengirim_hint').text('Pengirim baru — isi telepon & alamat, akan disimpan otomatis.');
                } else {
                    $('#d_telepon_pengirim').val(data.telepon || '');
                    $('#d_alamat_pengirim').val(data.alamat || '');
                    $('#d_pengirim_hint').text('');
                }
            });

            $(document).on('select2:clear', '#d_nama_pengirim', function() {
                $('#d_telepon_pengirim, #d_alamat_pengirim').val('');
                $('#d_pengirim_hint').text('');
            });

            // Render dimensi
            function renderDimensi(dimensi) {
                var html = '';
                var total_vol = 0;
                var total_vol_all = 0;

                // Detail pembagi label
                var pesawatVal = $('#d_pesawat').val();
                var pembagi = pesawatVal == 'BATIK' ? 5000 : 6000;
                if (pesawatVal) {
                    $('#d_pembagi_label').text('(Pembagi ' + pembagi + ')');
                }

                if (dimensi.length === 0) {
                    html = '<tr><td colspan="9" class="text-center">Tidak ada data dimensi</td></tr>';
                } else {
                    $.each(dimensi, function(i, d) {
                        total_vol += parseFloat(d.volume) || 0;
                        total_vol_all += parseFloat(d.total_volume) || 0;

                        var isSaved = justSavedUids.includes(String(d.uid));
                        var btnClass = isSaved ? 'btn-success' : 'btn-primary';
                        var iconClass = isSaved ? 'fa-check' : 'fa-save';

                        html += '<tr id="dim_row_' + d.uid + '">';
                        html += '<td>' + (i + 1) + '</td>';
                        html += '<td><input type="number" class="form-control input-xs dim-panjang" value="' + d.panjang + '" data-uid="' + d.uid + '"></td>';
                        html += '<td><input type="number" class="form-control input-xs dim-lebar"  value="' + d.lebar + '" data-uid="' + d.uid + '"></td>';
                        html += '<td><input type="number" class="form-control input-xs dim-tinggi" value="' + d.tinggi + '" data-uid="' + d.uid + '"></td>';
                        html += '<td><input type="number" class="form-control input-xs dim-pieces" value="' + d.pieces + '" data-uid="' + d.uid + '"></td>';
                        html += '<td><input type="text"   class="form-control input-xs dim-dimensi" value="' + d.dimensi + '" readonly data-uid="' + d.uid + '"></td>';
                        html += '<td><input type="text"   class="form-control input-xs dim-volume"  value="' + parseFloat(d.volume).toFixed(2) + '" readonly data-uid="' + d.uid + '"></td>';
                        html += '<td><input type="text"   class="form-control input-xs dim-total"   value="' + parseFloat(d.total_volume).toFixed(2) + '" readonly data-uid="' + d.uid + '"></td>';
                        html += '<td>';
                        html += '<button type="button" class="btn btn-xs ' + btnClass + ' btn-upd-dim" data-uid="' + d.uid + '"><i class="fa ' + iconClass + '"></i></button> ';
                        html += '<button type="button" class="btn btn-xs btn-danger btn-del-dim"  data-uid="' + d.uid + '"><i class="fa fa-trash"></i></button>';
                        html += '</td>';
                        html += '</tr>';
                    });
                }

                $('#bodyDimensi').html(html);

                $('#d_total_volume_sum').text(total_vol.toFixed(2));
                $('#d_total_volume_all').text(total_vol_all.toFixed(2));
                // Total volume jangan dibulatkan di input
                // $('#d_volume').val(total_vol_all.toFixed(2));
                $('#d_volume').val(Math.round(total_vol_all));

                // Hitung chargeable (Gross vs Volume terbesar dibulatkan)
                var gross = parseFloat($('#d_gross').val()) || 0;
                var max_val = total_vol_all > gross ? total_vol_all : gross;
                if (max_val < 10) {
                    max_val = 10;
                }
                // $('#d_chargeable').val(Math.ceil(max_val));
                $('#d_chargeable').val(Math.round(max_val));

            }

            // Hitung dimensi otomatis saat input berubah
            function hitungDimensi(uid) {
                var pesawat = $('#d_pesawat').val();
                var panjang = parseFloat($('.dim-panjang[data-uid="' + uid + '"]').val()) || 0;
                var lebar = parseFloat($('.dim-lebar[data-uid="' + uid + '"]').val()) || 0;
                var tinggi = parseFloat($('.dim-tinggi[data-uid="' + uid + '"]').val()) || 0;
                var pieces = parseFloat($('.dim-pieces[data-uid="' + uid + '"]').val()) || 1;
                var pembagi = pesawat == 'BATIK' ? 5000 : 6000;

                if (panjang > 0 && lebar > 0 && tinggi > 0) {
                    var dimensi = panjang + 'x' + lebar + 'x' + tinggi;
                    var volume = (panjang * lebar * tinggi) / pembagi;
                    var total_volume = volume * pieces;
                    var total_all = 0;
                    var total_koli = 0;

                    $('.dim-dimensi[data-uid="' + uid + '"]').val(dimensi);
                    $('.dim-volume[data-uid="' + uid + '"]').val(volume.toFixed(2));
                    $('.dim-total[data-uid="' + uid + '"]').val(total_volume.toFixed(2));

                    $('.dim-total').each(function() {
                        total_all += parseFloat($(this).val()) || 0;
                    });
                    $('.dim-pieces').each(function() {
                        total_koli += parseFloat($(this).val()) || 0;
                    });
                    $('#d_total_volume_all').text(total_all.toFixed(2));

                    console.log('Total Koli: ' + total_koli);
                    $('#d_jumlah').val(total_koli);

                    // Volume di input jangan dibulatkan
                    // $('#d_volume').val(total_all.toFixed(2));
                    total_all = Math.round(total_all)
                    $('#d_volume').val(total_all);

                    // Hitung chargeable ( Gross vs Volume terbesar dibulatkan )
                    var gross = parseFloat($('#d_gross').val()) || 0;
                    var max_val = total_all > gross ? total_all : gross;
                    if (max_val < 10) {
                        max_val = 10;
                    }
                    // $('#d_chargeable').val(Math.ceil(max_val));
                    $('#d_chargeable').val(Math.round(max_val));
                }
            }

            $(document).on('change keyup input', '.dim-panjang, .dim-lebar, .dim-tinggi, .dim-pieces', function() {
                var uid = String($(this).data('uid'));
                if (uid && uid !== 'undefined') {
                    justSavedUids = justSavedUids.filter(function(id) {
                        return id !== uid;
                    });
                    var $row = $('#dim_row_' + uid);
                    $row.find('.btn-upd-dim').removeClass('btn-success').addClass('btn-primary')
                        .find('i').removeClass('fa-check').addClass('fa-save');
                }
                hitungDimensi(uid);
            });

            $(document).on('keyup change', '#d_gross', function() {
                var gross = parseFloat($(this).val()) || 0;
                var total_vol = parseFloat($('#d_total_volume_all').text()) || 0;
                var max_val = total_vol > gross ? total_vol : gross;
                if (max_val < 10) {
                    max_val = 10;
                }
                // $('#d_chargeable').val(Math.ceil(max_val));
                $('#d_chargeable').val(Math.round(max_val));
            });

            // Tambah dimensi baru
            $('#btnTambahDimensi').on('click', function() {
                if (!currentListUid) return;
                $.ajax({
                    url: '<?= base_url('outgoinghlp/tambah_dimensi') ?>',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        uid_list: currentListUid
                    },
                    success: function(res) {
                        if (res.status === 'success') {
                            reloadDimensi(currentListUid);
                        }
                    }
                });
            });

            // Update dimensi
            $(document).on('click', '.btn-upd-dim', function() {
                var uid = $(this).data('uid');

                // JIKA NEW ROW (TANPA UID / DI MODAL TAMBAH)
                if (!uid) {
                    var row = $(this).closest('tr');
                    // Jika itu adalah row modal tambah, hitung ulang row tsb secara lokal
                    if (row.find('.t-dim-panjang').length > 0) {
                        hitungRowDimensiTambah(row);
                    }
                    $(this).removeClass('btn-primary').addClass('btn-success')
                        .find('i').removeClass('fa-save').addClass('fa-check');
                    Swal.fire({
                        icon: 'success',
                        title: 'Kalkulasi Berhasil',
                        text: 'Data dimensi baru ini akan tersimpan permanen saat Anda menekan tombol "Simpan" di bawah.',
                        timer: 2500,
                        showConfirmButton: false
                    });
                    return;
                }

                var pesawat = $('#d_pesawat').val();
                var panjang = $('.dim-panjang[data-uid="' + uid + '"]').val();
                var lebar = $('.dim-lebar[data-uid="' + uid + '"]').val();
                var tinggi = $('.dim-tinggi[data-uid="' + uid + '"]').val();
                var pieces = $('.dim-pieces[data-uid="' + uid + '"]').val();
                var pembagi = pesawat == 'BATIK' ? 5000 : 6000;
                var volume = (panjang * lebar * tinggi) / pembagi;
                var total_volume = volume * pieces;
                var dimensi = panjang + 'x' + lebar + 'x' + tinggi;

                $.ajax({
                    url: '<?= base_url('outgoinghlp/update_dimensi') ?>',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        uid: uid,
                        panjang: panjang,
                        lebar: lebar,
                        tinggi: tinggi,
                        pieces: pieces,
                        dimensi: dimensi,
                        volume: volume,
                        total_volume: total_volume
                    },
                    success: function(res) {
                        if (res.status === 'success') {
                            if (uid && !justSavedUids.includes(String(uid))) {
                                justSavedUids.push(String(uid));
                            }
                            reloadDimensi(currentListUid);
                            Swal.fire({
                                icon: 'success',
                                title: 'Dimensi Berhasil Diperbarui',
                                timer: 2500,
                                showConfirmButton: true
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal Memperbarui Dimensi',
                                timer: 2500,
                                showConfirmButton: true
                            });
                        }
                    }
                });
            });

            // Hapus dimensi
            $(document).on('click', '.btn-del-dim', function() {
                var uid = $(this).data('uid');
                if (!confirm('Yakin hapus dimensi ini?')) return;
                $.ajax({
                    url: '<?= base_url('outgoinghlp/hapus_dimensi') ?>/' + uid,
                    type: 'GET',
                    dataType: 'json',
                    success: function(res) {
                        if (res.status === 'success') {
                            justSavedUids = justSavedUids.filter(function(id) {
                                return id !== String(uid);
                            });
                            reloadDimensi(currentListUid);
                        }
                    }
                });
            });

            // Reload dimensi
            function reloadDimensi(uid_list) {
                $.get('<?= base_url('outgoinghlp/get_dimensi') ?>/' + uid_list, function(data) {
                    renderDimensi(data);
                }, 'json');
            }

            // Menutup select2 saat modal edit di-scroll
            $('#modalDetail').on('scroll', function() {
                $('.select2-pesawat-edit, .select2-tujuan-edit, .select2-pengirim-edit, .select2-penerima-edit, .select2-agent-edit').select2('close');
            });

            // Reset saat modal edit tutup
            $('#modalDetail').on('hidden.bs.modal', function() {
                justSavedUids = [];
                $('#d_pembagi_label').text('');
                $('.select2-pesawat-edit, .select2-tujuan-edit, .select2-pengirim-edit, .select2-penerima-edit, .select2-agent-edit')
                    .val(null).trigger('change');
                $('#d_nama_pengirim').empty().trigger('change');
                $('#d_pengirim_hint').text('');
            });

            // =============================================
            // INITIALIZATION SELECT2 TAMBAH (modalTambahSMU)
            // =============================================
            $('#modalTambahSMU').on('shown.bs.modal', function() {
                ['select2-pesawat-tambah', 'select2-tujuan-tambah', 'select2-pengirim-tambah',
                    'select2-penerima-tambah', 'select2-agent-tambah'
                ].forEach(function(cls) {
                    var el = $('.' + cls);
                    if (el.data('select2')) el.select2('destroy');
                });

                $('.select2-pesawat-tambah').select2({
                    placeholder: ':: Kode',
                    allowClear: true,
                    dropdownParent: $('#modalTambahSMU .modal-content'),
                    ajax: {
                        url: '<?= base_url('outgoinghlp/get_pesawat') ?>',
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
                                        prefix: item.prefix,
                                        jaster: item.jaster // Ambil nilai jaster dari database
                                    };
                                })
                            };
                        }
                    }
                });

                // Saat pesawat dipilih di form tambah, isi prefix, tangani status Jaster otomatis & pembagi
                $('#t_pesawat').on('select2:select', function(e) {
                    var prefix = e.params.data.prefix ?? '';
                    $('#smu_prefix_input').val(prefix);
                    updateSmuHidden();

                    // Sinkronisasi otomatis Jaster berdasarkan pesawat terpilih
                    var jasterVal = e.params.data.jaster;
                    if (jasterVal !== undefined) {
                        $('#t_jaster').prop('checked', parseInt(jasterVal) == 1);
                    }

                    // Tampilkan pembagi dinamis
                    var pesawatVal = $(this).val();
                    var pembagi = pesawatVal == 'BATIK' ? 5000 : 6000;
                    $('#t_pembagi_label').text('(Pembagi ' + pembagi + ')');

                    // Recalculate local rows
                    $('#bodyDimensiTambah tr:not(.no-data-row)').each(function() {
                        hitungRowDimensiTambah($(this));
                    });
                });

                $('#t_pesawat').on('select2:unselect', function() {
                    $('#smu_prefix_input').val('');
                    updateSmuHidden();
                    $('#t_jaster').prop('checked', false);
                    $('#t_pembagi_label').text('');
                });

                $(document).on('input', '.smu-number-input', function() {
                    var val = $(this).val().replace(/\D/g, '').substring(0, 8);
                    $(this).val(val);
                    updateSmuHidden();
                });

                function updateSmuHidden() {
                    var prefix = $('#smu_prefix_input').val();
                    var number = $('.smu-number-input').val();
                    if (prefix && number) {
                        $('#smu_hidden').val(prefix + '-' + number);
                    } else {
                        $('#smu_hidden').val('');
                    }
                }

                $('.select2-tujuan-tambah').select2({
                    placeholder: ':: Pilih Tujuan',
                    allowClear: true,
                    dropdownParent: $('#modalTambahSMU .modal-content'),
                    ajax: {
                        url: '<?= base_url('outgoinghlp/get_tujuan') ?>',
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
                                        id: item.uid,
                                        text: item.kode_kota + ' - ' + item.nama,
                                        nama: item.nama // <-- tambahkan ini
                                    };
                                })
                            };
                        }
                    }
                });

                $(document).on('select2:select', '#t_tujuan', function(e) {
                    $('#t_alamat_penerima').val(e.params.data.nama || '');
                });

                $(document).on('select2:clear', '#t_tujuan', function() {
                    $('#t_alamat_penerima').val('');
                });

                $('.select2-pengirim-tambah').select2({
                    placeholder: ':: Pilih pengirim atau ketik nama baru',
                    allowClear: true,
                    tags: true,
                    dropdownParent: $('#modalTambahSMU .modal-content'),
                    createTag: function(params) {
                        var term = $.trim(params.term);
                        if (term === '') return null;
                        return {
                            id: term,
                            text: term,
                            isNew: true
                        };
                    },
                    templateResult: function(data) {
                        if (data.isNew) {
                            return $('<span><i class="fa fa-plus"></i> Pengirim baru: </span>')
                                .append($('<b></b>').text(data.text));
                        }
                        return data.text;
                    },
                    ajax: {
                        url: '<?= base_url('outgoinghlp/get_pengirim') ?>',
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
                                        text: item.nama,
                                        telepon: item.telepon,
                                        alamat: item.alamat
                                    };
                                })
                            };
                        }
                    }
                });

                $('#t_nama_pengirim').on('select2:select', function(e) {
                    var data = e.params.data;
                    if (data.isNew) {
                        $('#t_telepon_pengirim, #t_alamat_pengirim').val('');
                        $('#t_pengirim_hint').text('Pengirim baru — isi telepon & alamat, akan disimpan otomatis.');
                    } else {
                        $('#t_telepon_pengirim').val(data.telepon || '');
                        $('#t_alamat_pengirim').val(data.alamat || '');
                        $('#t_pengirim_hint').text('');
                    }
                });

                $('#t_nama_pengirim').on('select2:clear', function() {
                    $('#t_telepon_pengirim, #t_alamat_pengirim').val('');
                    $('#t_pengirim_hint').text('');
                });

                $('.select2-agent-tambah').select2({
                    placeholder: ':: Pilih Agent',
                    allowClear: true,
                    dropdownParent: $('#modalTambahSMU .modal-content'),
                    ajax: {
                        url: '<?= base_url('outgoinghlp/get_agent') ?>',
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
                                        id: item.uid,
                                        text: item.nama
                                    };
                                })
                            };
                        }
                    }
                });

                // Saat agent dipilih, simpan uid
                $('#t_nama_agent').on('select2:select', function(e) {
                    $('#t_agent_uid').val(e.params.data.id);
                });

            });

            // =============================================
            // DIMENSI TAMBAH (CLIENT-SIDE)
            // =============================================
            var tambahDimensiCounter = 0;

            function renderDimensiTambahNo() {
                var rows = $('#bodyDimensiTambah tr:not(.no-data-row)');
                if (rows.length === 0) {
                    $('#bodyDimensiTambah').html('<tr class="no-data-row"><td colspan="9" class="text-center">Tidak ada data</td></tr>');
                    $('#t_total_volume_sum').text('0.00');
                    $('#t_total_volume_all').text('0.00');
                    $('#t_volume').val(0);

                    var gross = parseFloat($('#t_gross').val()) || 0;
                    // $('#t_chargeable').val(Math.ceil(gross));
                    $('#t_chargeable').val(Math.round(gross));
                } else {
                    rows.each(function(index) {
                        $(this).find('td:first').text(index + 1);
                    });
                    hitungTotalDimensiTambah();
                }
            }

            function hitungTotalDimensiTambah() {
                var total_vol = 0;
                var total_vol_all = 0;
                var total_koli = 0;

                $('#bodyDimensiTambah tr:not(.no-data-row)').each(function() {
                    var vol = parseFloat($(this).find('.t-dim-volume').val()) || 0;
                    var tot = parseFloat($(this).find('.t-dim-total').val()) || 0;
                    var pieces = parseInt($(this).find('.t-dim-pieces').val()) || 0;
                    total_vol += vol;
                    total_vol_all += tot;
                    total_koli += pieces;
                });

                $('#t_total_volume_sum').text(total_vol.toFixed(2));
                $('#t_total_volume_all').text(total_vol_all.toFixed(2));
                // Volume jangan dibulatkan di input
                // $('#t_volume').val(total_vol_all.toFixed(2));
                total_vol_all = Math.round(total_vol_all)
                $('#t_volume').val(total_vol_all);

                // Auto-sum pieces dimensi ke input Jumlah (Koli)
                $('#t_jumlah').val(total_koli);

                // Hitung chargeable (Gross vs Volume terbesar dibulatkan)
                var gross = parseFloat($('#t_gross').val()) || 0;
                var chargeableVal = total_vol_all > gross ? total_vol_all : gross;
                if (chargeableVal < 10) {
                    chargeableVal = 10;
                }
                // $('#t_chargeable').val(Math.ceil(chargeableVal));
                $('#t_chargeable').val(Math.round(chargeableVal));

            }

            function hitungRowDimensiTambah(row) {
                var pesawat = $('#t_pesawat').val();
                var panjang = parseFloat(row.find('.t-dim-panjang').val()) || 0;
                var lebar = parseFloat(row.find('.t-dim-lebar').val()) || 0;
                var tinggi = parseFloat(row.find('.t-dim-tinggi').val()) || 0;
                var pieces = parseFloat(row.find('.t-dim-pieces').val()) || 1;
                var pembagi = pesawat == 'BATIK' ? 5000 : 6000;

                console.log('Calculating Row Dimension...');

                if (panjang > 0 && lebar > 0 && tinggi > 0) {
                    var dimensi = panjang + 'x' + lebar + 'x' + tinggi;
                    var volume = (panjang * lebar * tinggi) / pembagi;
                    var total_volume = volume * pieces;

                    row.find('.t-dim-dimensi').val(dimensi);
                    row.find('.t-dim-volume').val(volume.toFixed(2));
                    row.find('.t-dim-total').val(total_volume.toFixed(2));
                } else {
                    row.find('.t-dim-dimensi').val('');
                    row.find('.t-dim-volume').val('0.00');
                    row.find('.t-dim-total').val('0.00');
                }
                hitungTotalDimensiTambah();
            }

            $('#btnTambahDimensiTambah').on('click', function() {
                $('#bodyDimensiTambah tr.no-data-row').remove();
                tambahDimensiCounter++;

                var html = '<tr id="t_dim_row_' + tambahDimensiCounter + '">';
                html += '<td></td>';
                html += '<td><input type="number" class="form-control input-xs t-dim-panjang" name="dim_panjang[]" value="0"></td>';
                html += '<td><input type="number" class="form-control input-xs t-dim-lebar" name="dim_lebar[]" value="0"></td>';
                html += '<td><input type="number" class="form-control input-xs t-dim-tinggi" name="dim_tinggi[]" value="0"></td>';
                html += '<td><input type="number" class="form-control input-xs t-dim-pieces" name="dim_pieces[]" value="1"></td>';
                html += '<td><input type="text" class="form-control input-xs t-dim-dimensi" name="dim_dimensi[]" readonly value=""></td>';
                html += '<td><input type="text" class="form-control input-xs t-dim-volume" name="dim_volume[]" readonly value="0.00"></td>';
                html += '<td><input type="text" class="form-control input-xs t-dim-total" name="dim_total_volume[]" readonly value="0.00"></td>';
                html += '<td>';
                html += '<button type="button" class="btn btn-xs btn-primary btn-upd-dim"><i class="fa fa-save"></i></button> ';
                html += '<button type="button" class="btn btn-xs btn-danger btn-del-dim-tambah"><i class="fa fa-trash"></i></button>';
                html += '</td>';
                html += '</tr>';

                $('#bodyDimensiTambah').append(html);
                renderDimensiTambahNo();
            });

            $(document).on('change keyup', '.t-dim-panjang, .t-dim-lebar, .t-dim-tinggi, .t-dim-pieces', function() {
                var row = $(this).closest('tr');
                row.find('.btn-upd-dim').removeClass('btn-success').addClass('btn-primary')
                    .find('i').removeClass('fa-check').addClass('fa-save');
                hitungRowDimensiTambah(row);
            });

            $(document).on('click', '.btn-del-dim-tambah', function() {
                $(this).closest('tr').remove();
                renderDimensiTambahNo();
            });

            // Re-kalkulasi seluruh baris jika maskapai diubah (dikarenakan perubahan pembagi)
            $('#t_pesawat').on('change', function() {
                $('#bodyDimensiTambah tr:not(.no-data-row)').each(function() {
                    hitungRowDimensiTambah($(this));
                });
            });

            // Auto hitung chargeable pada form tambah berdasarkan perubahan berat gross manual (dibulatkan)
            $(document).on('keyup change', '#t_gross', function() {
                var gross = parseFloat($(this).val()) || 0;
                var total_vol = parseFloat($('#t_total_volume_all').text()) || 0;
                var max_val = total_vol > gross ? total_vol : gross;
                if (max_val < 10) {
                    max_val = 10;
                }
                // $('#t_chargeable').val(Math.ceil(max_val));
                $('#t_chargeable').val(Math.round(max_val));
            });

            // Auto hitung chargeable pada form tambah (apabila volume diubah manual - dibulatkan)
            $(document).on('keyup change', '#t_volume', function() {
                var gross = parseFloat($('#t_gross').val()) || 0;
                var volume = parseFloat($(this).val()) || 0;
                var max_val = volume > gross ? volume : gross;
                if (max_val < 10) {
                    max_val = 10;
                }
                // $('#t_chargeable').val(Math.ceil(max_val));
                $('#t_chargeable').val(Math.round(max_val));
            });

            // Menutup select2 saat modal tambah di-scroll
            $('#modalTambahSMU').on('scroll', function() {
                $('.select2-pesawat-tambah, .select2-tujuan-tambah, .select2-pengirim-tambah, .select2-penerima-tambah, .select2-agent-tambah').select2('close');
            });

            // $('#modalTambahSMU form').on('submit', function(e) {
            //     if (!$.trim($('#t_nama_pengirim_val').val())) {
            //         e.preventDefault();
            //         Swal.fire('Perhatian', 'Nama pengirim wajib diisi.', 'warning');
            //         $('#t_nama_pengirim').select2('open');
            //     }
            // });

            // Reset saat modal tambah tutup
            $('#modalTambahSMU').on('hidden.bs.modal', function() {
                // $('#t_nama_pengirim').empty().trigger('change');
                // $(this).find('form')[0].reset();
                // $('#t_pembagi_label').text('');
                // $('#bodyDimensiTambah').html('<tr class="no-data-row"><td colspan="9" class="text-center">Tidak ada data</td></tr>');
                // $('#t_total_volume_sum').text('0.00');
                // $('#t_total_volume_all').text('0.00');
                // $('.select2-pesawat-tambah, .select2-tujuan-tambah, .select2-pengirim-tambah, .select2-penerima-tambah, .select2-agent-tambah').val(null).trigger('change');

                // // Reset kembali ke default tanggal masuk hari ini setelah form dibersihkan
                // var today = new Date().toISOString().split('T')[0];
                // $('#t_tanggal_masuk').val(today);
            });

            $('#btn-selesai-smu').on('click', function(e) {
                e.preventDefault();

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data SMU akan diperbarui dan diselesaikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Selesaikan!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {

                        var formData = $('#formEditSMU').serialize();

                        $.ajax({
                            url: "<?php echo base_url('outgoinghlp/update_selesai_smu_lama'); ?>",
                            type: "POST",
                            data: formData,
                            dataType: "JSON",
                            beforeSend: function() {
                                Swal.fire({
                                    title: 'Mohon Tunggu...',
                                    text: 'Sedang memproses data',
                                    allowOutsideClick: false,
                                    didOpen: () => {
                                        Swal.showLoading();
                                    }
                                });
                            },
                            success: function(response) {
                                if (response.status == 'success') {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Berhasil!',
                                        text: response.message,
                                        showConfirmButton: true
                                    }).then(() => {
                                        window.location.reload();
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Gagal!',
                                        text: response.message
                                    });
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error(xhr.responseText);
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Terjadi Kesalahan',
                                    text: 'Gagal terhubung ke server.'
                                });
                            }
                        });

                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            let selectedUid = null;

            // 1. Ketika tombol "ke BTB" diklik
            $(document).on('click', '.btn-btb', function(e) {
                e.preventDefault();

                selectedUid = $(this).data('uid');
                selectedSMU = $(this).data('smu');

                $('#modal-smu-text').text(selectedSMU);
                $('#modal-btb-no-preview').text('Mengambil nomor...');

                const today = new Date().toISOString().split('T')[0];
                $('#modal-btb-date').val(today);

                $('#confirmBtbModal').modal('show');

                $.ajax({
                    url: '<?php echo site_url("outgoinghlp/get_next_no"); ?>',
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            $('#modal-btb-no-preview').text(response.next_no);
                        } else {
                            $('#modal-btb-no-preview').text('Gagal memuat nomor');
                        }
                    },
                    error: function() {
                        $('#modal-btb-no-preview').text('Error sistem');
                    }
                });
            });

            // 2. Ketika tombol "Ya, Proses" di dalam modal diklik
            $('#btn-proses-btb-confirm').on('click', function() {
                if (!selectedUid) return;
                const btbDate = $('#modal-btb-date').val();

                if (!btbDate) {
                    $('#date-error').show();
                    return;
                } else {
                    $('#date-error').hide();
                }

                const btnConfirm = $(this);
                btnConfirm.prop('disabled', true).text('Memproses...');

                $.ajax({
                    url: '<?php echo site_url("outgoinghlp/proses_single_btb"); ?>',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        uid: selectedUid,
                        btb_date: btbDate
                    },
                    success: function(response) {
                        $('#confirmBtbModal').modal('hide');

                        if (response.status === 'success') {
                            alert(response.message);
                            location.reload();
                        } else {
                            alert('Gagal memproses data: ' + response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        $('#confirmBtbModal').modal('hide');
                        alert('Terjadi kesalahan koneksi atau sistem.');
                        console.error(error);
                    },
                    complete: function() {
                        btnConfirm.prop('disabled', false).text('Ya, Proses');
                        selectedUid = null;
                    }
                });
            });

            $('#check_mode_scan').on('change', function() {
                if ($(this).is(':checked')) {
                    $('#smu_group_manual').hide();
                    $('#smu_prefix_input, .smu-number-input').prop('disabled', true); // Nonaktifkan agar tidak ikut ter-submit

                    $('#smu_hidden').show().prop('disabled', false).focus();
                } else {
                    $('#smu_group_manual').show();
                    $('#smu_prefix_input, .smu-number-input').prop('disabled', false);

                    $('#smu_hidden').hide().val('').prop('disabled', true);
                }
            });

            // 2. Handling Scan / Enter pada input #smu_hidden
            $('#smu_hidden').on('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault(); // Cegah auto-submit form

                    let rawValue = $(this).val().trim();
                    if (rawValue === '') return;

                    // 1. Bersihkan karakter selain angka (menghilangkan strip '-', spasi, dll)
                    // Contoh "888-1274905200001" menjadi "8881274905200001"
                    let cleanDigits = rawValue.replace(/\D/g, '');

                    // 2. Potong hanya mengambil 11 digit pertama (3 digit Prefix + 8 digit Nomor SMU)
                    // Contoh "8881274905200001" menjadi "88812749052"
                    let smu11Digits = cleanDigits.substring(0, 11);

                    if (smu11Digits.length === 11) {
                        let prefix = smu11Digits.substring(0, 3); // "888"
                        let number = smu11Digits.substring(3, 11); // "12749052"

                        // Format kembali menjadi standard SMU (888-12749052)
                        let formattedSMU = prefix + '-' + number;

                        // Set nilai yang sudah bersih kembali ke input #smu_hidden
                        $(this).val(formattedSMU);

                        // Opsional: Ambil nomor koli jika nanti Anda butuh info kolinya
                        let koliNumber = cleanDigits.substring(11); // "00001"

                        // Auto-select Select2 Pesawat berdasarkan 3 digit prefix awal
                        autoSelectPesawatByPrefix(prefix);

                    } else {
                        alert('Format barcode SMU tidak valid!');
                    }
                }
            });

            // 3. Fungsi Auto-Select Pesawat berdasarkan Prefix lewat AJAX Select2
            function autoSelectPesawatByPrefix(prefix) {
                $.ajax({
                    url: '<?= base_url('outgoinghlp/get_pesawat') ?>',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        search: prefix
                    },
                    success: function(data) {
                        if (data && data.length > 0) {
                            // Cari item yang prefix-nya persis cocok
                            let matchedItem = data.find(item => item.prefix == prefix) || data[0];

                            // Buat option baru di Select2 jika belum ter-render
                            let newOption = new Option(
                                matchedItem.nama + ' - ' + matchedItem.prefix,
                                matchedItem.nama,
                                true,
                                true
                            );

                            // Attach data kustom (prefix, jaster) ke element option
                            $(newOption).data('data', {
                                id: matchedItem.nama,
                                text: matchedItem.nama + ' - ' + matchedItem.prefix,
                                prefix: matchedItem.prefix,
                                jaster: matchedItem.jaster
                            });

                            // Trigger perubahan ke Select2
                            $('#t_pesawat').append(newOption).trigger('change');

                            var jasterVal = matchedItem.jaster;
                            if (jasterVal !== undefined) {
                                $('#t_jaster').prop('checked', parseInt(jasterVal) == 1);
                            }
                            // Isi juga prefix input manual jika sewaktu-waktu switched back
                            $('#smu_prefix_input').val(matchedItem.prefix);
                        }
                    }
                });
            }
        });
    </script>

</body>

</html>