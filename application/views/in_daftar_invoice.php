<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
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

        .select2-container--open {
            z-index: 9999999 !important;
        }
    </style>
</head>

<header class="header_area sticky-header">
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message_name') ?>"></div>
    <div class="flash-data-error" data-flashdata="<?= $this->session->flashdata('message_error') ?>"></div>
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

                    <div class="profile clearfix">
                        <div class="profile_pic">
                            <img src="<?= base_url(); ?>src/images/img.jpg" alt="..." class="img-circle profile_img">
                        </div>
                        <div class="profile_info">
                            <span>Welcome,</span>
                            <h2><?= $this->session->userdata('nama'); ?></h2>
                        </div>
                    </div>

                    <br />

                    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                        <?php $this->load->view('side_menu.php'); ?>
                    </div>
                </div>
            </div>

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

            <!-- page content -->
            <div class="right_col" role="main">
                <div class="clearfix"></div>

                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="x_panel card">
                            <div class="x_title">
                                <h2>Daftar Invoice Incoming</h2>
                                <ul class="nav navbar-right panel_toolbox">
                                    <li>
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalRekap">
                                            Rekap Invoice
                                        </button>
                                    </li>
                                </ul>
                            </div>
                            <div class="x_content">
                                <div class="table-responsive">
                                    <table id="kemasan_table" class="table table-striped table-bordered" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>UID</th>
                                                <th>No</th>
                                                <th>No Invoice</th>
                                                <th>SMU</th>
                                                <th>Tanggal SMU</th>
                                                <th>Penerima</th>
                                                <th>Koli</th>
                                                <th>Berat Aktual</th>
                                                <th>Chargeable</th>
                                                <th>Total</th>
                                                <th>Tanggal Masuk</th>
                                                <th>Tanggal Keluar</th>
                                                <th>Days</th>
                                                <th>Acceptance</th>
                                                <th>Kasir</th>
                                                <th>Print</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                <h6>* klik baris tabel untuk edit / mengelola invoice</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modalDetailInvoice">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                        <h4 class="modal-title">Detail Invoice <span id="inv_no"></span></h4>
                    </div>
                    <form class="form-horizontal form-label-left" method="POST" action="<?= base_url('incominghlp/update_invoice') ?>">
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
                                                <th>Asal</th>
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
                                                <td id="inv_total_pieces"></td>
                                                <td id="inv_total_berat"></td>
                                                <td id="inv_total_sewa"></td>
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
                                        </tfoot>
                                    </table>
                                </div>
                            </div>

                            <div class="row">

                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Nama Penerima</label>
                                        <input type="text" class="form-control" name="nama_penerima" id="inv_nama_penerima">
                                        <!-- <input type="hidden" name="agent_uid" id="inv_agent_uid">
                                        <select name="nama_agent" id="inv_nama_agent" class="form-control select2-agent-inv">
                                            <option value="">:: Pilih Agent</option>
                                        </select> -->
                                    </div>
                                </div>
                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Telepon Penerima</label>
                                        <input type="text" class="form-control" name="telepon_penerima" id="inv_telepon_penerima">
                                        <!-- <input type="hidden" name="agent_uid" id="inv_agent_uid">
                                        <select name="nama_agent" id="inv_nama_agent" class="form-control select2-agent-inv">
                                            <option value="">:: Pilih Agent</option>
                                        </select> -->
                                    </div>
                                </div>
                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Alamat Penerima</label>
                                        <input type="text" class="form-control" name="alamat_penerima" id="inv_alamat_penerima">
                                        <!-- <input type="hidden" name="agent_uid" id="inv_agent_uid">
                                        <select name="nama_agent" id="inv_nama_agent" class="form-control select2-agent-inv">
                                            <option value="">:: Pilih Agent</option>
                                        </select> -->
                                    </div>
                                </div>
                                <!-- <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Metode Pembayaran</label>
                                        <select class="form-control" name="pay_methode" id="inv_pay_methode">
                                            <option value="">Pilih Cara Pembayaran</option>
                                            <option value="1">Deposit</option>
                                            <option value="2">Cash</option>
                                            <option selected value="3">Transfer</option>
                                            <option value="4">Tagihan</option>
                                            <option value="5">FOC</option>
                                            <option value="6">QRIS</option>
                                        </select>
                                    </div>
                                </div> -->

                                <div class="col-md-6 col-xs-12" id="inv_row_agent" style="display:none;">
                                    <div class="form-group">
                                        <label class="form-label">Nama Agent (Deposit)</label>
                                        <input type="hidden" name="agent_uid" id="inv_agent_uid">
                                        <select name="nama_agent" id="inv_nama_agent" class="form-control select2-agent-inv">
                                            <option value="">:: Pilih Agent</option>
                                        </select>
                                    </div>
                                </div>

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
                                        <label class="form-label">Biaya Administrasi</label>
                                        <select class="form-control" name="adm" id="inv_adm">
                                            <option value="1">Rp. 20.000</option>
                                            <option value="2">Rp. 3.000</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Kategori Billing</label>
                                        <select name="bill_catg" id="inv_bill_catg" class="form-control select2-catg-inv">
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
                                        <label class="form-label">Jaster</label>
                                        <select class="form-control" name="jaster" id="inv_jaster">
                                            <option value="0">Non Jaster</option>
                                            <option value="1">Jaster</option>
                                        </select>
                                    </div>
                                </div> -->

                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Opsi DG (Dangerous Goods)</label>
                                        <select class="form-control" name="opsi_dg" id="inv_opsi_dg">
                                            <option value="0">Tidak</option>
                                            <option value="1">Ya</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6 col-xs-12" id="inv_row_remarks" style="display:none;">
                                    <div class="form-group">
                                        <label class="form-label">Remarks Void (Alasan Pembatalan)</label>
                                        <textarea class="form-control" name="remarks" id="inv_remarks" style="resize:none;" rows="3"></textarea>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <!-- <div class="row" id="inv_row_coa" style="display:none;">
                                <div class="col-md-6 col-xs-12">
                                    <label for="coa_debit" class="form-label">CoA Debit</label>
                                    <select name="coa_debit" id="coa_debit" class="form-control select2" style="width: 100%" required>
                                        <option value="">:: Pilih CoA Debit</option>
                                        <?php
                                        foreach ($coa_1 as $pd) :
                                        ?>
                                            <option value="<?= $pd->no_sbb ?>"><?= $pd->no_sbb . ' - ' . $pd->nama_perkiraan ?></option>
                                        <?php
                                        endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-6 col-xs-12">
                                    <label for="coa_kredit" class="form-label">CoA Kredit</label>
                                    <select name="coa_kredit" id="coa_kredit" class="form-control select2" style="width: 100%" required>
                                        <option value="">:: Pilih CoA Kredit</option>
                                        <?php
                                        foreach ($coa_2 as $ps) :
                                        ?>
                                            <option value="<?= $ps->no_sbb ?>"><?= $ps->no_sbb . ' - ' . $ps->nama_perkiraan ?></option>
                                        <?php
                                        endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-12 col-xs-12">
                                    <label for="keterangan" class="form-label">Notes</label>
                                    <input name="keterangan" id="keterangan" class="form-control uppercase" value="Jurnal Invoice Incoming" required>
                                </div>
                            </div> -->
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
                                <i class="fa fa-times"></i> Batal / Void
                            </button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
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
                        <h4 class="modal-title">Rekap Invoice Incoming</h4>
                    </div>
                    <form class="form-horizontal form-label-left" method="POST" action="<?= base_url('incominghlp/rekap_invoice') ?>">
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
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Unduh Rekap</button>
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
                        action="<?= base_url('incominghlp/bayar_invoice') ?>">
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

    <script src="<?= base_url(); ?>src/vendors/jquery/dist/jquery.min.js"></script>
    <script src="<?= base_url(); ?>src/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="<?= base_url(); ?>src/vendors/fastclick/lib/fastclick.js"></script>
    <script src="<?= base_url(); ?>src/vendors/nprogress/nprogress.js"></script>
    <script src="<?= base_url(); ?>src/vendors/moment/min/moment.min.js"></script>
    <script src="<?= base_url(); ?>src/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link rel="stylesheet" href="<?= base_url(); ?>src/select2/css/select2.min.css">
    <script type="text/javascript" src="<?= base_url(); ?>src/select2/js/select2.min.js"></script>
    <script src="<?= base_url(); ?>src/build/js/custom.min.js"></script>

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

            $('#kemasan_table').DataTable({
                processing: true,
                serverSide: true,
                scrollX: true,
                order: [
                    // [0, 'desc']
                ],
                ajax: {
                    url: '<?= base_url("incominghlp/getData_invoice") ?>',
                    type: 'POST'
                },
                columnDefs: [{
                        orderable: false,
                        targets: [-1]
                    },
                    {
                        visible: false,
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
                    processing: "Memuat data...",
                    paginate: {
                        previous: "Sebelumnya",
                        next: "Selanjutnya"
                    }
                }
            });

            // Handle Klik Baris Tabel - Menampilkan Detail Invoice Incoming
            $('#kemasan_table tbody').on('click', 'tr', function(e) {
                if ($(e.target).closest('button, a').length) return;

                var uid = $(this).data('uid');
                if (!uid) return;

                $.ajax({
                    url: '<?= base_url('incominghlp/get_detail_invoice') ?>/' + uid,
                    type: 'GET',
                    dataType: 'json',
                    success: function(res) {
                        var r = res.billing;

                        $('#inv_no').text(r.invoice_num ?? r.no);
                        $('#inv_bil_uid').val(r.uid);

                        if (r.no_invoice) {
                            $('#inv_no_invoice').val(r.no_invoice);
                        } else {

                            let no_invoice = "HLP.IN-000" + r.no;
                            $('#inv_no_invoice').val(no_invoice);

                        }
                        $('#inv_nama_penerima').val(r.nama);
                        $('#inv_alamat_penerima').val(r.alamat);
                        $('#inv_telepon_penerima').val(r.telepon);
                        var payMethode = r.pay_methode ? String(r.pay_methode) : '3';
                        $('#inv_pay_methode').val(payMethode);
                        $('#inv_adm').val(r.adm);
                        // $('#inv_cdc').val(r.cdc);
                        $('#inv_jaster').val(r.is_jaster);
                        $('#inv_opsi_dg').val(r.opsi_dg);
                        $('#inv_new_status').val(r.status);

                        if (r.tanggal_invoice) {
                            var y = r.tanggal_invoice.substring(0, 4);
                            var m = r.tanggal_invoice.substring(4, 6);
                            var d = r.tanggal_invoice.substring(6, 8);
                            $('#inv_tanggal_invoice').val(y + '-' + m + '-' + d);
                        }

                        // Menampilkan form deposit agent jika memilih pembayaran Deposit
                        if (payMethode == '1') {
                            $('#inv_row_agent').show();
                        } else {
                            $('#inv_row_agent').hide();
                        }

                        if (payMethode == '1' || payMethode == '3') {
                            $('#inv_row_coa').show();
                        } else {
                            $('#inv_row_coa').hide();
                        }

                        var coa1 = <?= json_encode($coa_1); ?>;
                        var coa2 = <?= json_encode($coa_2); ?>;
                        var coa3 = <?= json_encode($coa_3); ?>;
                        var coa4 = <?= json_encode($coa_4); ?>;

                        if (payMethode == '1') {
                            renderDropdown('#coa_kredit', coa2);
                            renderDropdown('#coa_debit', coa1);
                        } else {
                            renderDropdown('#coa_kredit', coa4);
                            renderDropdown('#coa_debit', coa3);

                            if (payMethode == '3') {
                                setCoaDefault('#coa_debit', '12001');
                            }
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

                        // Menampilkan baris Jaster jika jaster aktif
                        // if (r.is_jaster > 0) {
                        //     $('#inv_row_jaster').show();
                        // } else {
                        //     $('#inv_row_jaster').hide();
                        // }

                        // Memetakan rincian biaya gudang
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

                        // Memetakan Item SMU List
                        var html = '';
                        if (res.list.length === 0) {
                            html = '<tr><td colspan="7" class="text-center">Tidak ada data SMU terhubung</td></tr>';
                        } else {
                            $.each(res.list, function(i, s) {
                                html += '<tr>';
                                html += '<td>' + (i + 1) + '</td>';
                                html += '<td>' + s.smu + '</td>';
                                html += '<td>' + s.asal + '</td>';
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

                        $('#modalDetailInvoice').modal('show');

                        $('#modalDetailInvoice').one('shown.bs.modal', function() {

                            if (res.billing.bill_catg_uid) {
                                // Sudah ada kategori — pakai yang tersimpan
                                $('#inv_bill_catg').append(
                                    new Option('[' + res.billing.jenis_billing + '] ' + res.billing.nama_catg,
                                        res.billing.bill_catg_uid, true, true)
                                ).trigger('change');
                            } else {
                                // Belum ada — auto pilih yang paling atas
                                $.ajax({
                                    url: '<?= base_url('incominghlp/get_bill_catg') ?>',
                                    type: 'POST',
                                    dataType: 'json',
                                    data: {
                                        search: ''
                                    },
                                    success: function(list) {
                                        if (list && list.length) {
                                            var first = list[0];
                                            $('#inv_bill_catg').append(
                                                new Option('[' + first.jenis + '] ' + first.nama_billing,
                                                    first.uid, true, true)
                                            ).trigger('change');
                                        }
                                    }
                                });
                            }

                            if (res.billing.pay_methode == '1') {
                                $('#inv_nama_agent').append(
                                    new Option(res.billing.nama_agent_deposit, res.billing.agent_deposit_uid, true, true)
                                ).trigger('change');
                                $('#inv_agent_uid').val(res.billing.agent_deposit_uid);
                            }
                        });
                    }
                });
            });


            // Show/hide agent saat pay_methode berubah
            $(document).on('change', '#inv_pay_methode', function() {
                if ($(this).val() == '1') {
                    $('#inv_row_agent').show();
                    $('#inv_nama_agent').attr('required', true);

                    $('#inv_row_coa').show();
                    $('#coa_debit').attr('required', true);
                    $('#coa_kredit').attr('required', true);

                } else if ($(this).val() == '3' || $(this).val() == '6') {
                    $('#inv_row_agent').hide();
                    $('#inv_nama_agent').attr('required', false);

                    $('#inv_row_coa').show();
                    $('#coa_debit').attr('required', true);
                    $('#coa_kredit').attr('required', true);
                } else {
                    $('#inv_row_agent').hide();
                    $('#inv_nama_agent').attr('required', false);

                    $('#inv_row_coa').hide();
                    $('#coa_debit').attr('required', false);
                    $('#coa_kredit').attr('required', false);

                }
            });

            $('#inv_pay_methode').on('change', function() {
                var metode = $(this).val();

                var coa1 = <?= json_encode($coa_1); ?>;
                var coa2 = <?= json_encode($coa_2); ?>;
                var coa3 = <?= json_encode($coa_3); ?>;
                var coa4 = <?= json_encode($coa_4); ?>;

                if (metode == '1') {
                    renderDropdown('#coa_kredit', coa2);
                    renderDropdown('#coa_debit', coa1);
                } else {
                    renderDropdown('#coa_kredit', coa4);
                    renderDropdown('#coa_debit', coa3);

                    if (metode == '3' || metode == '6') {
                        setCoaDefault('#coa_debit', '12001');
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

            // Action Batal/Void SMU dari Invoice
            $(document).on('click', '.btn-batal-smu', function() {
                var uid_smu = $(this).data('uid');
                var bil_uid = $(this).data('bil');

                Swal.fire({
                    title: 'Batal SMU?',
                    text: "Apakah Anda yakin ingin membatalkan SMU ini dari invoice?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, batalkan!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '<?= base_url('incominghlp/batal_smu_invoice') ?>',
                            type: 'POST',
                            dataType: 'json',
                            data: {
                                uid_smu: uid_smu,
                                bil_uid: bil_uid
                            },
                            success: function(res) {
                                if (res.status === 'success') {
                                    Swal.fire('Berhasil!', 'SMU telah dibatalkan dari invoice.', 'success');
                                    $('#modalDetailInvoice').modal('hide');
                                    $('#kemasan_table').DataTable().ajax.reload();
                                }
                            }
                        });
                    }
                });
            });

            // Event handler klik proses status (Void, Edit, Cetak)
            $(document).on('click', '.btn-status-inv', function() {
                var val = $(this).data('val');
                var $form = $(this).closest('form');

                if (val == '3') {
                    $('#inv_row_remarks').show();
                    $('#inv_remarks').attr('required', true);

                    Swal.fire({
                        title: 'Void Invoice?',
                        text: "Apakah Anda yakin ingin membatalkan / Void Invoice ini?",
                        icon: 'error',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, Void!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $('#inv_new_status').val(val);
                            $form.submit();
                        }
                    });
                } else {
                    $('#inv_row_remarks').hide();
                    $('#inv_remarks').attr('required', false);
                    $('#inv_new_status').val(val);
                    $form.submit();
                }
            });

            // Init Select2 dinamis di dalam Modal
            $('#modalDetailInvoice').on('shown.bs.modal', function() {
                ['select2-agent-inv', 'select2-catg-inv'].forEach(function(cls) {
                    var el = $('.' + cls);
                    if (el.data('select2')) el.select2('destroy');
                });

                $('.select2-agent-inv').select2({
                    placeholder: ':: Pilih Agent',
                    allowClear: true,
                    dropdownParent: $('#modalDetailInvoice .modal-content'),
                    ajax: {
                        url: '<?= base_url('incominghlp/get_agent_deposit') ?>',
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
                        url: '<?= base_url('incominghlp/get_bill_catg') ?>',
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