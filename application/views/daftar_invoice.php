<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link class="js-favicon" rel="icon" href="<?= $this->session->userdata('icon') ?>" type="image/ico" />
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
            /* Pastikan opsi dropdown rata kiri */
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
        }

        /* Memastikan dropdown Select2 selalu berada di atas modal Bootstrap */
        .select2-container--open {
            z-index: 9999999 !important;
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
                                <h2>Daftar Invoice</h2>
                                <ul class="nav navbar-right panel_toolbox">
                                    <li>
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalRekap">
                                            Rekap Invoice
                                        </button>
                                    </li>
                                </ul>
                            </div>
                            <form id="filterForm" method="get" action="<?= current_url() ?>">
                                <!-- reset ke halaman 1 setiap kali filter/search berubah -->
                                <input type="hidden" name="page" value="1">
                                <div class="row mb-2">
                                    <div class="col-md-3">
                                        <select name="f_agent" id="f_agent" class="form-control select2-agent">
                                            <option value="">:: Semua Agent</option>
                                            <?php if (!empty($f_agent) && !empty($f_agent_nama)): ?>
                                                <option value="<?= htmlspecialchars($f_agent) ?>" selected><?= htmlspecialchars($f_agent_nama) ?></option>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <select name="f_pay" id="f_pay" class="form-control select2-filter">
                                            <option value="">:: Semua Status Invoice</option>
                                            <option value="0" <?= ($f_pay ?? '') === '0' ? 'selected' : '' ?>>Belum Invoice</option>
                                            <option value="1" <?= ($f_pay ?? '') === '1' ? 'selected' : '' ?>>Sudah Invoice</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <select name="f_jurnal" id="f_jurnal" class="form-control select2-filter">
                                            <option value="">:: Semua Status Jurnal</option>
                                            <option value="0" <?= ($f_jurnal ?? '') === '0' ? 'selected' : '' ?>>Belum Bayar</option>
                                            <option value="1" <?= ($f_jurnal ?? '') === '1' ? 'selected' : '' ?>>Sudah Bayar</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="input-group">
                                            <input type="text" name="f_search" class="form-control" placeholder="Cari..." value="<?= htmlspecialchars($f_search ?? '') ?>">
                                            <span class="input-group-btn">
                                                <button type="submit" class="btn btn-default"><i class="fa fa-search"></i> Cari</button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div class="x_content">
                                <div class="mb-2">
                                    Menampilkan <?= count($rows) ?> dari <?= $total_rows ?> total data (Halaman <?= $current_page ?> dari <?= $total_pages ?>)
                                </div>
                                <div class="table-responsive">
                                    <table id="kemasan_table" class="table table-striped table-bordered" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>No Invoice</th>
                                                <th>Kategori SMU</th>
                                                <th>SMU</th>
                                                <th>Agent</th>
                                                <th>Pengirim</th>
                                                <th>Koli</th>
                                                <th>Chargeable</th>
                                                <th>Total</th>
                                                <th>PPH 23</th>
                                                <th>Tanggal</th>
                                                <th>Jaster</th>
                                                <th>Kasir</th>
                                                <th>Print</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($rows)): ?>
                                                <?php $no = ($current_page - 1) * $per_page + 1; ?>
                                                <?php foreach ($rows as $row): ?>
                                                    <tr data-uid="<?= $row['uid'] ?>" style="cursor:pointer;">
                                                        <td><?= $no++ ?></td>
                                                        <td><?= $row['no_invoice'] ?></td>
                                                        <td><?= $row['catg'] ?></td>
                                                        <td><?= $row['smu'] ?></td>
                                                        <td><?= $row['agent'] ?></td>
                                                        <td><?= $row['pengirim'] ?></td>
                                                        <td><?= $row['total_pieces'] ?></td>
                                                        <td><?= $row['total_chg'] ?></td>
                                                        <td><?= $row['nominal'] ?></td>
                                                        <td><?= $row['pph'] ?></td>
                                                        <td><?= $row['tanggal'] ?></td>
                                                        <td><?= $row['jaster'] ?></td>
                                                        <td><?= $row['warning_topup'] ?></td>
                                                        <td><?= $row['print'] ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="14" class="text-center">Tidak ada data</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>

                                <?php
                                function build_page_url_invoice($page_num, $f_search, $f_agent, $f_pay, $f_jurnal)
                                {
                                    $params = array_filter([
                                        'page'     => $page_num,
                                        'f_search' => $f_search,
                                        'f_agent'  => $f_agent,
                                        'f_pay'    => $f_pay,
                                        'f_jurnal' => $f_jurnal,
                                    ], function ($v) {
                                        return $v !== null && $v !== '';
                                    });
                                    return current_url() . '?' . http_build_query($params);
                                }
                                ?>
                                <?php if ($total_pages > 1): ?>
                                    <nav>
                                        <ul class="pagination">
                                            <li class="<?= $current_page <= 1 ? 'disabled' : '' ?>">
                                                <a href="<?= build_page_url_invoice(max(1, $current_page - 1), $f_search, $f_agent, $f_pay, $f_jurnal) ?>">Sebelumnya</a>
                                            </li>
                                            <?php
                                            $start = max(1, $current_page - 3);
                                            $end   = min($total_pages, $current_page + 3);
                                            for ($i = $start; $i <= $end; $i++):
                                            ?>
                                                <li class="<?= $i === $current_page ? 'active' : '' ?>">
                                                    <a href="<?= build_page_url_invoice($i, $f_search, $f_agent, $f_pay, $f_jurnal) ?>"><?= $i ?></a>
                                                </li>
                                            <?php endfor; ?>
                                            <li class="<?= $current_page >= $total_pages ? 'disabled' : '' ?>">
                                                <a href="<?= build_page_url_invoice(min($total_pages, $current_page + 1), $f_search, $f_agent, $f_pay, $f_jurnal) ?>">Selanjutnya</a>
                                            </li>
                                        </ul>
                                    </nav>
                                <?php endif; ?>

                                <h6>* klik nama customer untuk edit</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Finish content-->

        </div>

        <!-- /page content -->

        <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modalDetailInvoice">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Detail Invoice <span id="inv_no"></span></h4>
                    </div>
                    <form class="form-horizontal form-label-left" method="POST" action="<?= base_url('outgoinghlp/update_invoice') ?>">
                        <input type="hidden" name="bil_uid" id="inv_bil_uid">
                        <div class="modal-body">

                            <div class="row">
                                <div class="col-md-12 col-xs-12">
                                    <h5><b>List SMU</b></h5>
                                    <table class="table table-bordered table-condensed" id="tabelListSMU">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>SMU</th>
                                                <th>Tujuan</th>
                                                <th>Koli</th>
                                                <th>Berat</th>
                                                <th>Sewa Gudang</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody id="bodyListSMU">
                                            <tr>
                                                <td colspan="7" class="text-center">Memuat data...</td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="3" class="text-center"><b>TOTAL</b></td>
                                                <td class="text-center" id="inv_total_pieces"></td>
                                                <td class="text-right" id="inv_total_berat"></td>
                                                <td class="text-right" id="inv_total_sewa"></td>
                                                <td></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 col-xs-12">
                                    <h5><b>Biaya Gudang</b></h5>
                                    <table class="table table-bordered table-condensed">
                                        <tr>
                                            <td>SUB TOTAL</td>
                                            <td class="text-right"><b id="inv_sub_total"></b></td>
                                        </tr>
                                        <tr>
                                            <td>CARGO DEVELOPMENT CHARGE</td>
                                            <td class="text-right" id="inv_total_cdc"></td>
                                        </tr>
                                        <tr>
                                            <td>PPN 11%</td>
                                            <td class="text-right" id="inv_bg_ppn"></td>
                                        </tr>
                                        <tr>
                                            <td>ADMINISTRASI</td>
                                            <td class="text-right" id="inv_administrasi"></td>
                                        </tr>
                                        <tr>
                                            <td>MATERAI</td>
                                            <td class="text-right" id="inv_materai"></td>
                                        </tr>
                                        <tr>
                                            <td><b>SUBTOTAL</b></td>
                                            <td class="text-right"><b id="inv_bg_total"></b></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 col-xs-12">
                                    <h5><b>Biaya KC</b></h5>
                                    <table class="table table-bordered table-condensed">
                                        <thead>
                                            <tr>
                                                <th>Nama</th>
                                                <th class="text-right">Charge Weight</th>
                                                <th class="text-right">Total Harga</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr id="inv_row_jaster" style="display:none;">
                                                <td>JASTER</td>
                                                <td class="text-right" id="inv_berat_jaster"></td>
                                                <td class="text-right" id="inv_total_jaster"></td>
                                            </tr>
                                            <tr>
                                                <td>Jasa Terminal Handling</td>
                                                <td class="text-right" id="inv_berat_kade"></td>
                                                <td class="text-right" id="inv_total_kade"></td>
                                            </tr>
                                            <tr>
                                                <td>BIAYA CSC</td>
                                                <td class="text-right" id="inv_berat_csc"></td>
                                                <td class="text-right" id="inv_total_csc"></td>
                                            </tr>
                                            <tr>
                                                <td>TOTAL</td>
                                                <td colspan="2" class="text-right" id="inv_kc_sub_total"></td>
                                            </tr>
                                            <tr>
                                                <td>PPN 11%</td>
                                                <td colspan="2" class="text-right" id="inv_kc_ppn"></td>
                                            </tr>
                                            <tr>
                                                <td><b>SUBTOTAL</b></td>
                                                <td colspan="2" class="text-right"><b id="inv_kc_total"></b></td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>GRAND TOTAL</th>
                                                <td colspan="2" class="text-right"><b id="inv_grand_total"></b></td>
                                            </tr>
                                            <tr id="inv_row_pph_23" style="display:none;">
                                                <td>GRAND TOTAL SETELAH PPH</td>
                                                <td class="text-right" id="inv_total_pph"></td>
                                                <td class="text-right" id="inv_setelah_pph"></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>

                            <div class="row">

                                <!-- <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Metode Pembayaran</label>
                                        <select class="form-control" name="pay_methode" id="inv_pay_methode">
                                            <option value="">Pilih Cara Pembayaran</option>
                                            <option value="1">Deposit</option>
                                            <option value="2">Cash</option>
                                            <option value="3">Transfer</option>
                                            <option value="4">Tagihan</option>
                                            <option value="5">FOC</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6 col-xs-12" id="inv_row_agent" style="display:none;">
                                    <div class="form-group">
                                        <label class="form-label">Nama Agent (Deposit)</label>
                                        <input type="hidden" name="agent_uid" id="inv_agent_uid">
                                        <select name="nama_agent" id="inv_nama_agent" class="form-control select2-agent-inv">
                                            <option value="">:: Pilih Agent</option>
                                        </select>
                                    </div>
                                </div> -->

                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">No. Invoice</label>
                                        <input type="text" class="form-control" name="no_invoice" id="inv_no_invoice">
                                    </div>
                                </div>

                                <div class="col-md-6 col-xs-12" style="display:none;">
                                    <div class="form-group">
                                        <label class="form-label">Tanggal Invoice</label>
                                        <!-- <input type="date" class="form-control" name="tanggal_invoice" id="inv_tanggal_invoice"> -->
                                        <input type="date" class="form-control" name="tanggal_invoice" id="inv_tanggal_invoice"
                                            value="<?= date('Y-m-d') ?>">
                                    </div>
                                </div>
                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Pesawat</label>
                                        <select class="form-control select2-pesawat-inv" name="pesawat" id="inv_pesawat">
                                            <option selected>:: Pilih Pesawat</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Biaya Administrasi</label>
                                        <select class="form-control" name="adm" id="inv_adm">
                                            <option value="1">Rp. 20.000</option>
                                            <option value="2">Rp. 3.000</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Nama Agent</label>
                                        <input type="text" class="form-control" disabled id="inv_agent">
                                    </div>
                                </div>



                                <!-- <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Biaya Materai</label>
                                        <input type="text" class="form-control" name="materai" id="inv_materai_input">
                                    </div>
                                </div> -->

                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Kategori Billing</label>
                                        <select name="bill_catg" id="inv_bill_catg" class="form-control select2-catg-inv" required>
                                            <option value="">Pilih Kategori Billing</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Cargo Development Charge</label>
                                        <!-- <select class="form-control" name="cdc" id="inv_cdc" readonly>
                                            <option value="0" selected>No Cargo Development Charge</option>
                                            <option value="1">Cargo Development Charge</option>
                                        </select> -->
                                        <select class="form-control" id="inv_cdc" disabled>
                                            <option value="0" selected>No Cargo Development Charge</option>
                                            <option value="1">Cargo Development Charge</option>
                                        </select>
                                        <input type="hidden" name="cdc" id="inv_cdc_val" value="0">
                                    </div>
                                </div>

                                <!-- <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Cargo Development Charge</label>
                                        <select class="form-control" name="cdc" id="inv_cdc">
                                            <option value="0">No Cargo Development Charge</option>
                                            <option value="1">Cargo Development Charge</option>
                                        </select>
                                    </div>
                                </div> -->

                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Jaster</label>
                                        <select class="form-control" name="jaster" id="inv_jaster" require>
                                            <option value="0">Non Jaster</option>
                                            <option value="1">Jaster</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">PPH 23</label>
                                        <select class="form-control" name="pph_23" id="inv_pph_23" required>
                                            <option value="">:: Pilih PPH</option>
                                            <option value="0">Non PPH 23</option>
                                            <option value="1">PPH 23</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <hr>

                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="new_status" id="inv_new_status" value="0">
                            <button type="button" class="btn btn-default btn-status-inv" data-val="0" id="btnUbahInvoice">
                                <i class="fa fa-pencil"></i> Ubah
                            </button>
                            <button type="button" class="btn btn-primary btn-status-inv" data-val="1" id="btnCetakInvoice">
                                <i class="fa fa-print"></i> Cetak
                            </button>
                            <button type="button" class="btn btn-success" id="btnBayarInvoice">
                                <i class="fa fa-money"></i> Bayar
                            </button>
                            <button type="button" class="btn btn-danger btn-status-inv" data-val="3" id="btnBatalInvoice">
                                <i class="fa fa-times"></i> Batal
                            </button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                            <!-- <button type="submit" class="btn btn-success">Simpan</button> -->
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modalRekap">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Rekap Invoice</h4>
                    </div>
                    <form class="form-horizontal form-label-left" method="POST" action="<?= base_url('outgoinghlp/rekap_invoice') ?>">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-4 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Dari</label>
                                        <input type="date" class="form-control" name="dari" id="dari_r">
                                    </div>
                                </div>

                                <div class="col-md-4 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Sampai</label>
                                        <input type="date" class="form-control" name="sampai" id="sampai_r">
                                    </div>
                                </div>

                                <div class="col-md-4 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Metode Pembayaran</label>
                                        <select class="form-control" name="pay_methode">
                                            <option value="All">Semua</option>
                                            <option value="1">Deposit</option>
                                            <option value="2">Cash</option>
                                            <option value="3">Transfer</option>
                                            <option value="4">Tagihan</option>
                                            <option value="5">FOC</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Pesawat</label>
                                        <!-- <select name="pesawat" id="rekap_pesawat" class="form-control select2-pesawat-rekap">
                                            <option value="">:: Pilih Pesawat</option>
                                        </select> -->
                                        <select name="pesawat[]" id="rekap_pesawat" class="form-control select2-pesawat-rekap" multiple>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Agent</label>
                                        <select name="agent" id="rekap_agent" class="form-control select2-nama-rekap">
                                            <option value="">:: Pilih Agent</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Kasir Duty</label>
                                        <select name="kasir" id="rekap_kasir" class="form-control select2-kasir-rekap">
                                            <option value="">:: Pilih Nama</option>
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

        <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modalBayar">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                        <h4 class="modal-title">Bayar Invoice Incoming</h4>
                    </div>
                    <form class="form-horizontal form-label-left" method="POST"
                        action="<?= base_url('outgoinghlp/bayar_invoice') ?>">
                        <div class="modal-body">
                            <div class="row">
                                <input type="hidden" name="bill_uid" id="b_bill_uid">
                                <input type="hidden" name="nominal" id="b_nominal_val">

                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Invoice</label>
                                        <input type="text" class="form-control" name="no_invoice" id="b_invoice" readonly>
                                    </div>
                                </div>

                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Nominal</label>
                                        <input type="text" class="form-control" id="b_nominal" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Metode Pembayaran</label>
                                        <select class="form-control" name="pay_methode" id="b_pay_methode">
                                            <option value="">Pilih Cara Pembayaran</option>
                                            <option value="1">Deposit</option>
                                            <option value="2">Cash</option>
                                            <option selected value="3">Transfer</option>
                                            <option value="4">Tagihan</option>
                                            <!-- <option value="5">FOC</option> -->
                                            <option value="6">QRIS</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6 col-xs-12" id="b_row_bank" style="display:none;">
                                    <div class="form-group">
                                        <label class="form-label">Bank</label>
                                        <select name="coa_bank" id="b_bank" class="form-control" required>
                                            <option value="12001" selected>BANK EKS</option>
                                            <option value="12002">BANK BDT</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xs-12" id="b_row_agent" style="display:none;">
                                    <div class="form-group">
                                        <label class="form-label">Nama Agent (Deposit)</label>
                                        <input type="hidden" name="agent_uid" id="b_agent_uid">
                                        <select name="nama_agent" id="b_nama_agent" class="form-control select2-agent-b">
                                            <option value="">:: Pilih Agent</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Bayar</button>
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

            $('.js-example-basic-multiple').select2();
            $('.select2').select2();

            // =============================================
            // TABEL DIRENDER LANGSUNG DARI SERVER (PHP), TIDAK PAKAI AJAX/DATATABLES
            // Filter tetap berfungsi seperti sebelumnya, tapi submit via GET
            // (reload halaman) alih-alih ajax.reload().
            // =============================================
            $('#f_agent, #f_pay, #f_jurnal').on('change', function() {
                $('#filterForm').submit();
            });

            $('#f_pay, #f_jurnal').select2({
                minimumResultsForSearch: Infinity,
                width: '100%'
            });

            // Buka modal saat click row datatable
            $('#kemasan_table tbody').on('click', 'tr', function(e) {
                if ($(e.target).closest('button, a').length) return;

                var uid = $(this).data('uid');
                if (!uid) return;

                $.ajax({
                    url: '<?= base_url('outgoinghlp/get_detail_invoice') ?>/' + uid,
                    type: 'GET',
                    dataType: 'json',
                    success: function(res) {
                        var r = res.billing;

                        $('#inv_no').text(r.invoice_num ?? r.no);
                        $('#inv_bil_uid').val(r.uid);
                        $('#inv_no_invoice').val(r.no_invoice);
                        $('#inv_pay_methode').val(r.pay_methode);
                        $('#inv_adm').val(r.adm);
                        $('#inv_materai_input').val(r.materai);
                        $('#inv_telepon').val(r.telepon);
                        $('#inv_agent').val(r.nama_agent);
                        $('#inv_cdc').val(r.cdc);
                        $('#inv_jaster').val(r.is_jaster);
                        $('#inv_pph_23').val(
                            (r.is_pph_23 === null || r.is_pph_23 === undefined || r.is_pph_23 === '') ?
                            '' :
                            String(r.is_pph_23)
                        );
                        $('#inv_new_status').val(r.status);
                        $('#inv_pengirim_uid').val(r.pengirim_uid);

                        // Tanggal invoice format Y-m-d
                        if (r.tanggal_invoice) {
                            var y = r.tanggal_invoice.substring(0, 4);
                            var m = r.tanggal_invoice.substring(4, 6);
                            var d = r.tanggal_invoice.substring(6, 8);
                            $('#inv_tanggal_invoice').val(y + '-' + m + '-' + d);
                        }

                        // Show/hide deposit agent
                        if (r.pay_methode == '1') {
                            $('#inv_row_agent').show();
                        } else {
                            $('#inv_row_agent').hide();
                        }

                        if (r.pay_methode == '1' || r.pay_methode == '3' || r.pay_methode == '4') {
                            $('#inv_row_coa').show();
                        } else {
                            $('#inv_row_coa').hide();
                        }

                        // Show/hide jaster row
                        console.log('JASTER : ' + r.is_jaster);
                        if (r.is_jaster > 0) {
                            $('#inv_row_jaster').show();
                        } else {
                            $('#inv_row_jaster').hide();
                        }

                        console.log('PPH-23 : ' + r.is_pph_23);
                        if (r.is_pph_23 > 0) {
                            $('#inv_row_pph_23').show();
                        } else {
                            $('#inv_row_pph_23').hide();
                        }

                        // Billing totals
                        $('#inv_sub_total').text(r.total_cargo_k);
                        $('#inv_total_cdc').text(r.total_cdc_k);
                        $('#inv_bg_ppn').text(r.bg_ppn_k);
                        $('#inv_administrasi').text(r.administrasi_k);
                        $('#inv_materai').text(r.materai_k);
                        $('#inv_bg_total').text(r.bg_total_k);
                        $('#inv_berat_jaster').text(r.total_chargeable_k);
                        $('#inv_total_jaster').text(r.total_jaster_k);
                        $('#inv_berat_kade').text(r.total_chargeable_k);
                        $('#inv_total_kade').text(r.total_kade_k);
                        $('#inv_berat_csc').text(r.total_chargeable_k);
                        $('#inv_total_csc').text(r.total_csc_k);
                        $('#inv_kc_sub_total').text(r.kc_sub_total_k);
                        $('#inv_kc_ppn').text(r.kc_ppn_k);
                        $('#inv_kc_total').text(r.kc_total_k);
                        $('#inv_grand_total').text(r.grand_total_k);
                        $('#inv_total_pieces').text(r.total_pieces_k);
                        $('#inv_total_berat').text(r.total_chargeable_k);
                        $('#inv_total_sewa').text(r.total_cargo_k);

                        $('#inv_total_pph').text(r.total_pph);
                        $('#inv_setelah_pph').text(r.total_setelah_pph);

                        // List SMU
                        var html = '';
                        if (res.list.length === 0) {
                            html = '<tr><td colspan="7" class="text-center">Tidak ada data</td></tr>';
                        } else {
                            $.each(res.list, function(i, s) {
                                html += '<tr>';
                                html += '<td>' + (i + 1) + '</td>';
                                html += '<td>' + s.smu + '</td>';
                                html += '<td>' + s.tujuan + '</td>';
                                html += '<td class="text-center">' + s.jumlah + '</td>';
                                html += '<td class="text-right">' + s.chargeable + '</td>';
                                html += '<td class="text-right">' + s.sewa_gudang + '</td>';
                                if (r.jurnal_status != '1') {
                                    html += '<td><button type="button" class="btn btn-xs btn-danger btn-batal-smu" data-uid="' + s.uid + '" data-bil="' + r.uid + '">Batal</button></td>';
                                } else {
                                    html += '<td></td>';
                                }
                                html += '</tr>';
                            });
                        }
                        $('#bodyListSMU').html(html);

                        // Kategori billing
                        // $('#inv_bill_catg').append(
                        //     new Option(res.billing.nama_catg, res.billing.bill_catg_uid, true, true)
                        // ).trigger('change');

                        // // Nama agent/pengirim
                        // $('#inv_nama').append(
                        //     new Option(r.nama, r.pengirim_uid, true, true)
                        // ).trigger('change');

                        // Agent deposit
                        if (r.pay_methode == '1') {
                            $('#inv_nama_agent').append(
                                new Option(r.nama_agent_deposit, r.agent_deposit_uid, true, true)
                            ).trigger('change');
                            $('#inv_agent_uid').val(r.agent_deposit_uid);
                        }


                        if (r.pay_status == '1' && r.jurnal_status == '1') {
                            console.log('Pay Status 1 Masuk');
                            $('#btnUbahInvoice').prop('disabled', true);
                            $('#btnCetakInvoice').prop('disabled', true);
                            $('#btnBayarInvoice').prop('disabled', true);
                            $('#btnBatalInvoice').prop('disabled', true);
                        } else if (r.pay_status == '1' && r.jurnal_status == '0') {
                            console.log('Pay Status 0 Masuk');
                            $('#btnUbahInvoice').prop('disabled', true);
                            $('#btnCetakInvoice').prop('disabled', true);
                            $('#btnBayarInvoice').prop('disabled', false);
                            $('#btnBatalInvoice').prop('disabled', true);
                        } else {
                            console.log('Pay Status 0 Masuk');
                            $('#btnUbahInvoice').prop('disabled', false);
                            $('#btnCetakInvoice').prop('disabled', false);
                            $('#btnBayarInvoice').prop('disabled', true);
                            $('#btnBatalInvoice').prop('disabled', false);
                        }

                        $('#modalDetailInvoice').modal('show');

                        $('#modalDetailInvoice').one('shown.bs.modal', function() {
                            $('#inv_pesawat').append(
                                new Option(res.billing.pesawat, res.billing.pesawat, true, true)
                            ).trigger('change');

                            // Baru append setelah Select2 siap
                            $('#inv_bill_catg').append(
                                new Option('[' + res.billing.jenis_billing + '] ' + res.billing.nama_catg, res.billing.bill_catg_uid, true, true)
                            ).trigger('change');

                            if (res.billing.pay_methode == '1') {

                                // kode_agent_deposit
                                $('#inv_nama_agent').append(
                                    new Option(res.billing.nama_agent_deposit, res.billing.agent_deposit_uid, true, true)
                                ).trigger('change');
                                // $('#inv_nama_agent').append(
                                //     new Option(res.billing.nama_agent, res.billing.agent_uid, true, true)
                                // ).trigger('change');
                            }

                            $('#inv_nama').append(
                                new Option(res.billing.nama, res.billing.pengirim_uid, true, true)
                            ).trigger('change');
                        });
                    }
                });
            });

            $(document).on('change', '#inv_pay_methode', function() {
                if ($(this).val() == '1') {
                    $('#inv_row_agent').show();
                    $('#inv_nama_agent').attr('required', true);
                } else {
                    $('#inv_row_agent').hide();
                    $('#inv_nama_agent').attr('required', false);
                }
            });

            // Batal SMU dari invoice
            $(document).on('click', '.btn-batal-smu', function() {
                var uid_smu = $(this).data('uid');
                var bil_uid = $(this).data('bil');
                if (!confirm('Yakin ingin membatalkan SMU ini dari invoice?')) return;
                $.ajax({
                    url: '<?= base_url('outgoinghlp/batal_smu_invoice') ?>',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        uid_smu: uid_smu,
                        bil_uid: bil_uid
                    },
                    success: function(res) {
                        if (res.status === 'success') {
                            $('#modalDetailInvoice').modal('hide');
                            $('#invoice_table').DataTable().ajax.reload();
                        }
                    }
                });
            });

            // Init Select2 saat modal terbuka
            $('#modalDetailInvoice').on('shown.bs.modal', function() {
                // Destroy dulu kalau sudah pernah di-init
                ['select2-agent-inv', 'select2-nama-inv', 'select2-catg-inv'].forEach(function(cls) {
                    var el = $('.' + cls);
                    if (el.data('select2')) el.select2('destroy');
                });

                $('.select2-pesawat-inv').select2({
                    placeholder: ':: Pilih Pesawat',
                    allowClear: true,
                    dropdownParent: $('#modalDetailInvoice .modal-content'),
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
                                        text: item.nama
                                    };
                                })
                            };
                        }
                    }
                });

                // Perbaikan: mengubah dropdownParent mengarah ke .modal-content bukan div .modal utama
                $('.select2-agent-inv').select2({
                    placeholder: ':: Pilih Agent',
                    allowClear: true,
                    dropdownParent: $('#modalDetailInvoice .modal-content'),
                    ajax: {
                        // url: '<?= base_url('outgoinghlp/get_agent') ?>',
                        url: '<?= base_url('outgoinghlp/get_agent_deposit') ?>',
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

                $('.select2-nama-inv').select2({
                    placeholder: ':: Pilih Nama',
                    allowClear: true,
                    dropdownParent: $('#modalDetailInvoice .modal-content'),
                    ajax: {
                        // url: '<?= base_url('outgoinghlp/get_pengirim') ?>',
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

                $('.select2-catg-inv').select2({
                    placeholder: 'Pilih Kategori Billing',
                    allowClear: true,
                    dropdownParent: $('#modalDetailInvoice .modal-content'),
                    ajax: {
                        url: '<?= base_url('outgoinghlp/get_bill_catg') ?>',
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
                                        text: '[' + item.jenis + '] ' + item.nama_billing
                                    };
                                })
                            };
                        }
                    }
                });
            });
            $('#modalDetailInvoice').on('scroll', function() {
                $('.select2-agent-inv, .select2-nama-inv, .select2-catg-inv').select2('close');
            });

            // Reset saat modal edit tutup
            $('#modalDetailInvoice').on('hidden.bs.modal', function() {
                $('.select2-agent-inv, .select2-nama-inv, .select2-catg-inv')
                    .val(null).trigger('change');
            });
            // Reset saat modal tutup
            $('#modalDetailInvoice').on('hidden.bs.modal', function() {
                $(this).find('form')[0].reset();
                $('#bodyListSMU').html('<tr><td colspan="7" class="text-center">Memuat data...</td></tr>');
                $('.select2-agent-inv, .select2-nama-inv, .select2-catg-inv').val(null).trigger('change');
                $('#inv_row_agent').hide();
                $('#inv_row_jaster').hide();
            });

            $(document).on('click', '.btn-status-inv', function() {
                var val = $(this).data('val');
                var $form = $(this).closest('form');

                // Batal tidak perlu validasi isian
                if (val == '3') {
                    if (!confirm('Yakin ingin membatalkan invoice ini?')) return;
                    $('#inv_new_status').val(val);
                    $form.submit();
                    return;
                }

                var kosong = [];

                if (!$('#inv_bill_catg').val()) kosong.push('Kategori Billing');
                if (!$('#inv_no_invoice').val().trim()) kosong.push('No. Invoice');
                if (!$('#inv_pesawat').val()) kosong.push('Pesawat');
                if ($('#inv_pph_23').val() === '') kosong.push('PPH 23');

                if (kosong.length) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Data Belum Lengkap',
                        html: 'Mohon lengkapi:<br><b>' + kosong.join('<br>') + '</b>'
                    });

                    $('#inv_bill_catg, #inv_no_invoice, #inv_pesawat').each(function() {
                        $(this).closest('.form-group').toggleClass('has-error', !$(this).val());
                    });
                    $('#inv_pph_23').closest('.form-group')
                        .toggleClass('has-error', $('#inv_pph_23').val() === '');

                    return;
                }

                $('.form-group').removeClass('has-error');
                $('.btn-status-inv').removeClass('active');
                $(this).addClass('active');
                $('#inv_new_status').val(val);
                $form.submit();
            });

            $(document).on('change', '#inv_bill_catg, #inv_pesawat', function() {
                $(this).closest('.form-group').toggleClass('has-error', !$(this).val());
            });

            $(document).on('input', '#inv_no_invoice', function() {
                $(this).closest('.form-group').toggleClass('has-error', !$(this).val().trim());
            });

            $(document).on('change', '#inv_pph_23', function() {
                $(this).closest('.form-group').toggleClass('has-error', $(this).val() === '');
            });

            $('.select2-nama-rekap').select2({
                placeholder: ':: Pilih Nama',
                allowClear: true,
                dropdownParent: $('#modalRekap .modal-content'),
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

            $('.select2-agent').select2({
                placeholder: ':: Pilih Agent',
                allowClear: true,
                // dropdownParent: $('#modalDetailInvoice .modal-content'),
                ajax: {
                    url: '<?= base_url('outgoinghlp/get_agent') ?>',
                    // url: '<?= base_url('outgoinghlp/get_agent_deposit') ?>',
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

            // $('.select2-pesawat-rekap').select2({
            //     placeholder: ':: Pilih Pesawat',
            //     allowClear: true,
            //     dropdownParent: $('#modalRekap .modal-content'),
            //     ajax: {
            //         url: '<?= base_url('outgoinghlp/get_pesawat') ?>',
            //         type: 'POST',
            //         dataType: 'json',
            //         delay: 250,
            //         data: function(params) {
            //             return {
            //                 search: params.term
            //             };
            //         },
            //         processResults: function(data) {
            //             return {
            //                 results: $.map(data, function(item) {
            //                     return {
            //                         id: item.nama,
            //                         text: item.nama
            //                     };
            //                 })
            //             };
            //         }
            //     }
            // });

            $('.select2-pesawat-rekap').select2({
                placeholder: ':: Pilih Pesawat',
                multiple: true,
                dropdownParent: $('#modalRekap .modal-content'),
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
                                    text: item.nama
                                };
                            })
                        };
                    }
                }
            });

            $('.select2-kasir-rekap').select2({
                placeholder: ':: Pilih Nama',
                allowClear: true,
                dropdownParent: $('#modalRekap .modal-content'),
                ajax: {
                    url: '<?= base_url('outgoinghlp/get_users') ?>',
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
                                    id: item.nip,
                                    text: item.nama
                                };
                            })
                        };
                    }
                }
            });

            function renderDropdown(selector, data) {
                var $el = $(selector);
                $el.empty();
                $.each(data, function(key, value) {
                    $el.append('<option value="' + value.no_sbb + '">' + value.no_sbb + ' - ' + value.nama_perkiraan + '</option>');
                });
                $el.trigger('change');
            }

            function setCoaDefault(selector, value) {
                var $el = $(selector);
                if ($el.find('option[value="' + value + '"]').length) {
                    $el.val(value).trigger('change');
                } else {
                    console.warn('CoA ' + value + ' tidak ditemukan di ' + selector);
                }
            }

            $('#modalDetailInvoice').on('hidden.bs.modal', function() {
                $(this).find('form')[0].reset();
                $('#bodyListSMU').html('<tr><td colspan="7" class="text-center">Memuat data...</td></tr>');
                $('#inv_bill_catg, #inv_nama_agent').empty().trigger('change');
                $('.select2-agent-inv, .select2-catg-inv').val(null).trigger('change');
                $('#inv_pay_methode').val('3');
                $('#inv_row_agent').hide();
                $('#inv_row_jaster').hide();
                $('#inv_row_remarks').hide();
            });

            $('#btnBayarInvoice').on('click', function() {
                var uid = $('#inv_bil_uid').val();
                var noInvoice = $('#inv_no_invoice').val();
                var nominalTeks = $('#inv_grand_total').text();
                var nominalRaw = $('#inv_grand_total').data('raw');

                if (!uid) {
                    Swal.fire('Perhatian', 'Data invoice belum termuat.', 'warning');
                    return;
                }

                if (nominalRaw === undefined || nominalRaw === null || nominalRaw === '') {
                    nominalRaw = nominalTeks.replace(/[^\d]/g, '');
                }

                $('#b_bill_uid').val(uid);
                $('#b_invoice').val(noInvoice);
                $('#b_nominal').val(nominalTeks);
                $('#b_nominal_val').val(nominalRaw);

                // Tutup modal detail dulu, baru buka modal bayar
                $('#modalDetailInvoice').one('hidden.bs.modal', function() {
                    $('#modalBayar').modal('show');
                }).modal('hide');
            });

            function toggleBayarField() {
                var m = $('#b_pay_methode').val();

                var showAgent = (m === '1'); // Deposit
                var showBank = (m === '3' || m === '4'); // Transfer / Tagihan

                $('#b_row_agent').toggle(showAgent);
                $('#b_nama_agent').prop('required', showAgent);

                $('#b_row_bank').toggle(showBank);
                $('#b_bank').prop('required', showBank);

                // Bersihkan field yang sedang disembunyikan
                if (!showAgent) {
                    $('#b_nama_agent').val(null).trigger('change');
                    $('#b_agent_uid').val('');
                }
                if (!showBank) {
                    $('#b_bank').val('12001');
                }
            }

            $(document).on('change', '#b_pay_methode', toggleBayarField);
            $('#modalBayar').on('shown.bs.modal', toggleBayarField);

            $('#modalBayar').on('hidden.bs.modal', function() {
                $('#b_nama_agent').val(null).trigger('change');
                $('#b_agent_uid').val('');
                $('#b_bank').val('12001');
                $('#b_row_agent, #b_row_bank').hide();
                $('#b_nama_agent, #b_bank').prop('required', false);
            });

            $('.select2-agent-b').select2({
                placeholder: ':: Pilih Agent',
                allowClear: true,
                dropdownParent: $('#modalBayar .modal-content'),
                ajax: {
                    url: '<?= base_url('outgoinghlp/get_agent_deposit') ?>',
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

            $(document).on('select2:select', '#b_nama_agent', function(e) {
                $('#b_agent_uid').val(e.params.data.id);
            });

            $(document).on('select2:clear', '#b_nama_agent', function() {
                $('#b_agent_uid').val('');
            });

            $('#modalDetailInvoice').on('hidden.bs.modal', function() {
                $(this).find('form')[0].reset();
                $('#bodyListSMU').html('<tr><td colspan="7" class="text-center">Memuat data...</td></tr>');
                $('#inv_bill_catg, #inv_nama_agent').empty().trigger('change');
                $('.select2-agent-inv, .select2-catg-inv').val(null).trigger('change');
                $('#inv_pay_methode').val('3');
                $('#inv_row_agent').hide();
                $('#inv_row_jaster').hide();
                $('#inv_row_remarks').hide();
            });

            $('#btnBayarInvoice').on('click', function() {
                var uid = $('#inv_bil_uid').val();
                var noInvoice = $('#inv_no_invoice').val();
                var nominalTeks = $('#inv_grand_total').text();
                var nominalRaw = $('#inv_grand_total').data('raw');

                if (!uid) {
                    Swal.fire('Perhatian', 'Data invoice belum termuat.', 'warning');
                    return;
                }

                if (nominalRaw === undefined || nominalRaw === null || nominalRaw === '') {
                    nominalRaw = nominalTeks.replace(/[^\d]/g, '');
                }

                $('#b_bill_uid').val(uid);
                $('#b_invoice').val(noInvoice);
                $('#b_nominal').val(nominalTeks);
                $('#b_nominal_val').val(nominalRaw);

                // Tutup modal detail dulu, baru buka modal bayar
                $('#modalDetailInvoice').one('hidden.bs.modal', function() {
                    $('#modalBayar').modal('show');
                }).modal('hide');
            });

            function toggleBayarField() {
                var m = $('#b_pay_methode').val();

                var showAgent = (m === '1'); // Deposit
                var showBank = (m === '3' || m === '4'); // Transfer / Tagihan

                $('#b_row_agent').toggle(showAgent);
                $('#b_nama_agent').prop('required', showAgent);

                $('#b_row_bank').toggle(showBank);
                $('#b_bank').prop('required', showBank);

                // Bersihkan field yang sedang disembunyikan
                if (!showAgent) {
                    $('#b_nama_agent').val(null).trigger('change');
                    $('#b_agent_uid').val('');
                }
                if (!showBank) {
                    $('#b_bank').val('12001');
                }
            }

            $(document).on('change', '#b_pay_methode', toggleBayarField);
            $('#modalBayar').on('shown.bs.modal', toggleBayarField);

            $('#modalBayar').on('hidden.bs.modal', function() {
                $('#b_nama_agent').val(null).trigger('change');
                $('#b_agent_uid').val('');
                $('#b_bank').val('12001');
                $('#b_row_agent, #b_row_bank').hide();
                $('#b_nama_agent, #b_bank').prop('required', false);
            });

            $('.select2-agent-b').select2({
                placeholder: ':: Pilih Agent',
                allowClear: true,
                dropdownParent: $('#modalBayar .modal-content'),
                ajax: {
                    url: '<?= base_url('outgoinghlp/get_agent_deposit') ?>',
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

            $(document).on('select2:select', '#b_nama_agent', function(e) {
                $('#b_agent_uid').val(e.params.data.id);
            });

            $(document).on('select2:clear', '#b_nama_agent', function() {
                $('#b_agent_uid').val('');
            });
        });
    </script>
</body>

</html>