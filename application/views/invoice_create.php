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

        tr.baris>td>input.form-control {
            font-size: 11px;
        }

        tr.baris>td {
            padding: 1px !important;
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
                            <?php include 'notif_tello.php' ?>
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
                                <h2>Create Invoice</h2>
                            </div>
                            <div class="x_content">
                                <form class="form-horizontal form-label-left" method="POST" action="<?= base_url('financial/store_invoice/reguler') ?>">
                                    <div class="form-group row">
                                        <div class="col-md-2 col-xs-12">
                                            <label for="no_invoice" class="form-label">Number</label>
                                            <input type="text" class="form-control" name="no_invoice" value="<?= $no_invoice ?>" readonly>
                                        </div>
                                        <div class="col-md-3 col-xs-12">
                                            <label for="tgl_invoice" class="form-label">Date</label>
                                            <input type="date" class="form-control" name="tgl_invoice" value="<?= date('Y-m-d') ?>">
                                        </div>
                                        <div class="col-md-3 col-xs-12">
                                            <label for="customer" class="form-label">Bill to</label>
                                            <select name="customer" id="customer" class="form-control select2" style="width: 100%" required>
                                                <option value="">:: Pilih customer</option>
                                                <?php
                                                foreach ($customers as $c) : ?>
                                                    <option value="<?= $c->id ?>"><?= $c->nama_customer ?></option>
                                                <?php
                                                endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="keterangan" class="form-label">Notes</label>
                                            <input name="keterangan" id="keterangan" class="form-control" oninput="this.value = this.value.toUpperCase()" placeholder="Enter notes here...">
                                        </div>
                                        <!-- <div class="col-md-2 col-xs-12">
                                            <label for="diskon" class="form-label">Discount</label>
                                            <select name="diskon" id="diskon" class="form-control">
                                                <option value="0">0%</option>
                                                <option value="0.05">5%</option>
                                                <option value="0.1">10%</option>
                                            </select>
                                        </div> -->
                                        <!-- <div class="col-md-2 col-xs-12" style="display: block">
                                            <label for="ppn" class="form-label">PPN</label>
                                            <select name="ppn" id="ppn" class="form-control">
                                                <option value="0">0%</option>
                                                <option value="0.01">1%</option>
                                                <option value="0.02">2%</option>
                                                <option value="0.10">10%</option>
                                                <option value="0.11">11%</option>
                                                <option value="0">0%</option>
                                                <option value="0.011">1.1%</option>
                                            </select>
                                        </div> -->
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-2 col-xs-12">
                                            <label for="nominal" class="form-label">Subtotal</label>
                                            <input type="text" class="form-control" name="nominal" id="nominal" value="0" readonly>
                                        </div>
                                        <!-- <div class="col-md-2 col-xs-12">
                                            <label for="besaran_diskon" class="form-label">Discount</label>
                                            <input type="text" class="form-control" name="besaran_diskon" id="besaran_diskon" value="0" readonly>
                                        </div> -->
                                        <div class="col-md-2 col-xs-12">
                                            <label for="besaran_ppn" class="form-label">PPN</label>
                                            <input type="text" class="form-control" name="besaran_ppn" id="besaran_ppn" value="0" readonly>
                                        </div>
                                        <div class="col-md-2 col-xs-12">
                                            <label for="besaran_pph" class="form-label">PPh 23</label>
                                            <input type="text" class="form-control" name="besaran_pph" id="besaran_pph" value="0" readonly>
                                        </div>
                                        <div class="col-md-2 col-xs-12">
                                            <label for="total_nonpph" class="form-label">Total (non PPh)</label>
                                            <input type="text" class="form-control" name="total_nonpph" id="total_nonpph" value="0" readonly>
                                        </div>
                                        <div class="col-md-2 col-xs-12">
                                            <label for="total_denganpph" class="form-label">Total (w/ PPh)</label>
                                            <input type="text" class="form-control" name="total_denganpph" id="total_denganpph" value="0" readonly>
                                        </div>
                                        <div class="col-md-2 col-xs-12">
                                            <label for="total_denganpph" class="form-label">Pendapatan</label>
                                            <input type="text" class="form-control" name="nominal_pendapatan" id="nominal_pendapatan" value="0" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">

                                        <div class="col-md-2 col-xs-12" style="display: none;">
                                            <label for="total_chargeable" class="form-label">Chargeable</label>
                                            <input type="text" class="form-control" name="total_chargeable" id="total_chargeable" value="0" readonly>
                                        </div>
                                        <!-- <div class="col-md-2 col-xs-12">
                                            <label for="total_basic_rate" class="form-label">Basic rate</label>
                                            <input type="text" class="form-control" name="total_basic_rate" id="total_basic_rate" value="0" readonly>
                                        </div> -->
                                        <div class="col-md-2 col-xs-12">
                                            <label for="total_biaya" class="form-label">Total biaya</label>
                                            <input type="text" class="form-control" name="total_biaya" id="total_biaya" value="0" readonly>
                                        </div>
                                        <div class="col-md-2 col-xs-12">
                                            <label for="nominal_bayar" class="form-label">Nominal bayar</label>
                                            <input type="text" class="form-control" name="nominal_bayar" id="nominal_bayar" value="0" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">

                                        <div class="col-md-3">
                                            <label for="coa_pendapatan" class="form-label">CoA Pendapatan</label>
                                            <select name="coa_pendapatan" id="coa_pendapatan" class="form-control select2" style="width: 100%" required>
                                                <option value="">:: Pilih CoA Pendapatan</option>
                                                <?php
                                                foreach ($pendapatan as $pd) :
                                                ?>
                                                    <option value="<?= $pd->no_sbb ?>"><?= $pd->nama_perkiraan ?></option>
                                                <?php
                                                endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="coa_persediaan" class="form-label">CoA Persediaan</label>
                                            <select name="coa_persediaan" id="coa_persediaan" class="form-control select2" style="width: 100%" required>
                                                <option value="">:: Pilih CoA Persediaan</option>
                                                <?php
                                                foreach ($persediaan as $ps) :
                                                ?>
                                                    <option value="<?= $ps->no_sbb ?>"><?= $ps->nama_perkiraan ?></option>
                                                <?php
                                                endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="col-md-1 col-xs-12">
                                            <label for="termin" class="form-label">Termin</label>
                                            <div class="checkbox text-end">
                                                <input type="checkbox" class="icheckbox_flat-green" style="margin-left: 0px;" name="opsi_termin" value="1">
                                            </div>
                                        </div>
                                        <div class="col-md-1 col-xs-12">
                                            <label for="opsi_ppn" class="form-label">PPn</label>
                                            <div class="checkbox text-end">
                                                <input type="checkbox" class="icheckbox_flat-green" style="margin-left: 0px;" name="opsi_ppn" id="opsi_ppn" value="1">
                                                <!-- <input id="toggleSwitch" type="checkbox" data-toggle="toggle" class="flat"> -->
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-xs-12">
                                            <label for="opsi_pph" class="form-label">Potong PPh 23</label>
                                            <div class="checkbox text-end">
                                                <input type="checkbox" class="icheckbox_flat-green" style="margin-left: 0px;" name="opsi_pph" id="opsi_pph" value="1">
                                                <!-- <input id="toggleSwitch" type="checkbox" data-toggle="toggle" class="flat"> -->
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-xs-12 text-right">
                                            <label for="keterangan" class="form-label">&nbsp;</label>
                                            <div class="mt-2">
                                                <a href="<?= base_url('financial/invoice') ?>" class="btn btn-sm btn-warning"><i class="bi bi-arrow-return-left"></i> Back</a>
                                                <button type="submit" class="btn btn-primary btn-sm">Save <i class="bi bi-save"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <table class="table mt-5 table-responsive">
                                        <thead>
                                            <tr>
                                                <th style="width: 110px;">Tgl.</th>
                                                <th style="width: 200px;">Ket.</th>
                                                <th style="width: 80px;">FN.</th>
                                                <th style="width: 70px;">Dest.</th>
                                                <th style="width: 60px;">Coly</th>
                                                <th style="width: 60px;">Act.</th>
                                                <th style="width: 60px;">CW</th>
                                                <th style="width: 70px;">Rate Ngen + WH</th>
                                                <th style="width: 80px;">Adm. Ngen</th>
                                                <th style="width: 70px;">Rate</th>
                                                <th style="width: 110px;">Total</th>
                                                <th style="width: 80px;">AWB Fee</th>
                                                <th>Amount</th>
                                                <th>Del.</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="baris">
                                                <td>
                                                    <input type="date" name="item_date[]" id="item_date[]" class="form-control">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" name="item[]" oninput="this.value = this.value.toUpperCase()">
                                                </td>
                                                <td>
                                                    <input type="text" name="flight_number[]" id="flight_number[]" class="form-control" oninput="this.value = this.value.toUpperCase()">
                                                </td>
                                                <td>
                                                    <input type="text" name="destination[]" id="destination[]" class="form-control" oninput="this.value = this.value.toUpperCase()">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" name="qty[]" value="0">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" name="actual_weight[]" value="0">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" name="chargeable_weight[]" value="0">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" name="basic_rate[]" value="0">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" name="adm_ngen[]" value="0">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" name="harga[]" value="0">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control total" name="total[]" readonly>
                                                    <input type="hidden" class="form-control" name="biaya[]" value="0" readonly>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" name="awb_fee[]" value="0">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" name="total_amount[]" value="0">
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-danger btn-sm hapusRow">Hapus</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="row">
                                        <div class="col-lg-12 text-end">
                                            <button type="button" class="btn btn-secondary btn-sm" id="addRow">Add new row</button>
                                        </div>
                                    </div>
                                </form>
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

            // $("form").on("submit", function() {
            //     Swal.fire({
            //         title: "Loading...",
            //         timerProgressBar: true,
            //         allowOutsideClick: false,
            //         didOpen: () => {
            //             Swal.showLoading()
            //         },
            //     });
            // });
        });



        function formatNumber(number) {
            // Pisahkan bagian integer dan desimal
            let parts = number.toString().split(".");

            // Format bagian integer dengan pemisah ribuan
            parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".");

            // Gabungkan bagian integer dan desimal dengan koma sebagai pemisah desimal
            return parts.join(",");
        }

        // Contoh penggunaan
        // let formattedNumber = formatNumber(10000.952);
        // console.log(formattedNumber); // Out


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


        $(document).ready(function() {
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
                newRow.find('input[name="chargeable_weight[]"]').val('0');
                newRow.find('input[name="harga[]"]').val('0');
                newRow.find('input[name="basic_rate[]"]').val('0');
                newRow.find('input[name="adm_ngen[]"]').val('0');
                newRow.find('input[name="biaya[]"]').val('0');
                newRow.find('input[name="qty[]"]').val('0');
                newRow.find('input[name="actual_weight[]"]').val('0');
                newRow.find('input[name="awb_fee[]"]').val('0');
                newRow.find('input[name="total[]"]').val('0');
                newRow.find('input[name="total_amount[]"]').val('0');

                // Perbarui tag <h4> pada baris baru dengan nomor urut yang baru
                rowCount++;

                // Tambahkan baris baru setelah baris terakhir
                previousRow.after(newRow);
            });

            // Saat input qty atau harga diubah
            // $(document).on('input', 'input[name="chargeable_weight[]"], input[name="harga[]"], input[name="awb_fee[]"], input[name="biaya[]"]', function() {
            $(document).on('input', 'input[name="chargeable_weight[]"], input[name="harga[]"], input[name="awb_fee[]"], input[name="basic_rate[]"], input[name="adm_ngen[]"], input[name="biaya[]"]', function() {
                var value = $(this).val();
                var formattedValue = parseFloat(value.split('.').join(''));
                $(this).val(formattedValue);

                var row = $(this).closest('.baris');
                hitungTotal(row);
                updateTotalBelanja();
                updateTotal();
            });

            // Tambahkan event listener untuk event keyup
            $(document).on('keyup', 'input[name="chargeable_weight[]"], input[name="harga[]"], input[name="awb_fee[]"], input[name="basic_rate[]"], input[name="adm_ngen[]"], input[name="biaya[]"]', function() {
                var value = $(this).val().trim(); // Hapus spasi di awal dan akhir nilai
                var formattedValue = formatNumber(parseFloat(value.split('.').join('')));
                $(this).val(formattedValue);
                if (isNaN(value)) { // Jika nilai input kosong
                    $(this).val(''); // Atur nilai input menjadi 0
                }
                var row = $(this).closest('.baris');
                hitungTotal(row);
                updateTotalBelanja();
                updateTotal();
            });

            function hitungTotal(row) {
                var chwt = row.find('input[name="chargeable_weight[]"]').val().replace(/\./g, '');
                var harga = row.find('input[name="harga[]"]').val().replace(/\./g, '');
                var awb_fee = row.find('input[name="awb_fee[]"]').val().replace(/\./g, '');
                var basic_rate = row.find('input[name="basic_rate[]"]').val().replace(/\./g, '');
                var adm_ngen = row.find('input[name="adm_ngen[]"]').val().replace(/\./g, '');

                chwt = parseInt(chwt); // Ubah string ke angka float
                harga = parseInt(harga); // Ubah string ke angka float
                awb_fee = parseInt(awb_fee); // Ubah string ke angka float
                basic_rate = parseInt(basic_rate); // Ubah string ke angka float
                adm_ngen = parseInt(adm_ngen); // Ubah string ke angka float

                chwt = isNaN(chwt) ? 0 : chwt;
                harga = isNaN(harga) ? 0 : harga;
                awb_fee = isNaN(awb_fee) ? 0 : awb_fee;

                var total = chwt * harga;
                var total_amount = total + awb_fee;
                var total_biaya = (chwt * basic_rate) + adm_ngen + 20000;

                row.find('input[name="total[]"]').val(formatNumber(total));
                row.find('input[name="total_amount[]"]').val(formatNumber(total_amount));
                row.find('input[name="biaya[]"]').val(formatNumber(total_biaya));
                updateTotalBelanja();
            }

            function updateTotalBelanja() {
                var total_pos_fix = 0;
                var total_chwt = 0;
                var total_basic_rate = 0;
                var total_biaya = 0;
                $(".baris").each(function() {
                    var total = $(this).find('input[name="total_amount[]"]').val().replace(/\./g, ''); // Ambil nilai total dari setiap baris
                    var chwt = $(this).find('input[name="chargeable_weight[]"]').val().replace(/\./g, ''); // Ambil nilai chargeable dari setiap baris
                    var biaya = $(this).find('input[name="biaya[]"]').val().replace(/\./g, ''); // Ambil nilai total dari setiap baris
                    total = parseFloat(total); // Ubah string ke angka float
                    chwt = parseFloat(chwt); // Ubah string ke angka float
                    biaya = parseFloat(biaya); // Ubah string ke angka float
                    if (!isNaN(total)) { // Pastikan total adalah angka
                        total_pos_fix += total; // Tambahkan nilai total ke total_pos_fix
                    }
                    if (!isNaN(chwt)) { // Pastikan total adalah angka
                        total_chwt += chwt; // Tambahkan nilai total ke total_pos_fix
                    }
                    if (!isNaN(biaya)) { // Pastikan total adalah angka
                        total_biaya += biaya; // Tambahkan nilai total ke total_pos_fix
                    }


                });
                $('#nominal').val(formatNumber(total_pos_fix)); // Atur nilai input #nominal dengan total_pos_fix
                $('#total_chargeable').val(formatNumber(total_chwt)); // Atur nilai input #total_chargeable dengan total_chwt
                // $('#total_basic_rate').val(formatNumber(total_basic_rate)); // Atur nilai input #total_basic_rate dengan total_basic_rate
                $('#total_biaya').val(formatNumber(total_biaya)); // Atur nilai input #total_biaya dengan total_biaya
            }

            // Tambahkan event listener untuk tombol hapus row
            $(document).on('click', '.hapusRow', function() {
                $(this).closest('.baris').remove();
                updateTotalBelanja(); // Perbarui total belanja setelah menghapus baris
                updateTotal();
            });

            // Saat opsi diskon berubah
            $('#diskon').on('change', function() {
                // Panggil fungsi untuk mengupdate besaran diskon dan total
                updateTotal();
            });
            $('#ppn').on('change', function() {
                // Panggil fungsi untuk mengupdate besaran diskon dan total
                updateTotal();
            });
            $('#opsi_ppn').on('change', function() {
                // Panggil fungsi untuk mengupdate besaran diskon dan total
                updateTotal();
            });
            $('#opsi_pph').on('change', function() {
                // console.log("tes")
                // updatePPH();
                updateTotal();
            });

            // Fungsi untuk mengupdate besaran diskon dan total
            function updateTotal() {
                var diskon = parseFloat($('#diskon').val());
                var ppn = 0.011;
                var pph = 0.02;
                // var opsi_pph = document.getElementById("opsi_pph").value;
                var besaranppn = parseFloat($('#besaran_ppn').val());
                var besaranpph = parseFloat($('#besaran_pph').val());
                var biaya = parseFloat($('#total_biaya').val().replace(/\./g, ''));

                console.log(biaya)
                var subtotal = 0;
                // Hitung subtotal dari total setiap baris
                $('.baris').each(function() {
                    var totalBaris = parseInt($(this).find('input[name="total_amount[]"]').val().replace(/\./g, '') || 0);
                    subtotal += totalBaris;
                });
                // Hitung besaran diskon
                var besaranDiskon = subtotal * diskon;
                var besaranDiskon = subtotal;
                // Hitung total setelah diskon
                var total = subtotal;

                // Jika opsi_pph dicentang
                if ($('#opsi_pph').is(':checked')) {
                    besaranpph = total * pph;
                } else {
                    besaranpph = 0;
                }

                if ($('#opsi_ppn').is(':checked')) {
                    besaranppn = total * ppn;
                } else {
                    besaranppn = 0;
                }

                // console.log(besaranpph)
                // var besaranppn = total * ppn;
                var total_nonpph = total + besaranppn;
                var total_denganpph = total + besaranppn - besaranpph;
                var pendapatan = total - besaranpph - biaya;
                var nominal_bayar = total + besaranppn - besaranpph;

                // console.log(subtotal);
                // console.log((ppn));
                // console.log(formatNumber(besaranppn));
                // Atur nilai input besaran_diskon dan total dengan format angka yang sesuai
                $('#besaran_ppn').val(formatNumber(besaranppn.toFixed(0)));
                $('#besaran_pph').val(formatNumber(besaranpph.toFixed(0)));
                $('#besaran_diskon').val(formatNumber(besaranDiskon));
                $('#total_nonpph').val(formatNumber(total_nonpph.toFixed(0)));
                $('#total_denganpph').val(formatNumber(total_denganpph.toFixed(0)));
                $('#nominal_pendapatan').val(formatNumber(pendapatan.toFixed(0)));
                $('#nominal_bayar').val(formatNumber(nominal_bayar.toFixed(0)));
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
                $('#total_nonpph').val(formatNumber(total));
            }

            $('#diskonEdit').on('change', function() {
                // Panggil fungsi untuk mengupdate besaran diskon dan total
                updateTotalEdit();
            });


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

            // function updatePPH() {
            //     var nominal = parseFloat($('#nominal').val().replace(/\./g, '')) || 0;
            //     var pph = 0;

            //     if ($('#opsi_pph').is(':checked')) {
            //         pph = nominal * 0.02;
            //     }

            //     $('#besaran_pph').val(formatNumber(pph.toFixed(0)));
            //     updateTotal();
            // }

            // let checkbox = document.querySelector("input[id=toggleSwitch]");

            // checkbox.addEventListener('change', function() {
            //     if (this.checked) {
            //         console.log("Checkbox is checked..");
            //     } else {
            //         console.log("Checkbox is not checked..");
            //     }
            // });
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

            initializeAutocomplete();

            $("#addRow").click(function() {
                var newRow = '<div class="autocomplete-row"><input type="text" class="form-control autocomplete" name="item[]" oninput="this.value = this.value.toUpperCase()"></div>';
                $("#invoiceForm").append(newRow);
                initializeAutocomplete();
            });
        });
    </script>


</body>

</html>