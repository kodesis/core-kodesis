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

        .text-right {
            text-align: right !important;
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
                                <h2>Daftar Deposit</h2>
                                <ul class="nav navbar-right panel_toolbox">
                                    <li>
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambahCustomer">
                                            Tambah Saldo
                                        </button>
                                    </li>
                                    <li>
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalRekap">
                                            Rekap Deposit
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
                                                <th>Kode</th>
                                                <th>Nama</th>
                                                <th>Telepon</th>
                                                <th>Saldo</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                <h6>* klik nama customer untuk edit</h6>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row" id="card_riwayat_transaksi" style="display: none; margin-top: 20px;">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>Riwayat Transaksi Agent: <span id="txt_nama_agent_terpilih" class="text-success"></span></h2>
                                <div class="nav navbar-right panel_toolbox">
                                    <div class="form-check form-switch" style="padding-top: 5px;">
                                        <input class="form-check-input toggle-usage" type="checkbox" id="switch_termasuk_usage" data-uid="">
                                        <label class="form-check-label font-weight-bold" for="switch_termasuk_usage" style="cursor: pointer;"> &nbsp;Termasuk Usage</label>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered dt-responsive nowrap" id="sub_table_riwayat" style="width:100%">
                                        <thead>
                                            <tr class="headings">
                                                <th>Tanggal</th>
                                                <th>Kode / Keterangan Transaksi</th>
                                                <th id="no_invoice_detail">No Invoice</th>
                                                <th class="text-right">Topup Saldo</th>
                                                <th class="text-right">Usage Saldo</th>
                                                <th class="text-right">Sisa Saldo</th>
                                                <th class="text-right">Nama Kasir</th>
                                            </tr>
                                        </thead>
                                        <tbody>
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

        <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="tambahCustomer">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">
                            Tambah Agents
                        </h4>
                    </div>
                    <form class="form-horizontal form-label-left" method="POST" action="<?= base_url('depositwh/store_deposit') ?>">
                        <div class="modal-body">
                            <div class="row">

                                <input type="hidden" name="uid" id="uid_kemasan">

                                <!-- <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Kode</label>
                                        <input type="text" class="form-control" name="kode_agent" value="<?= $kode ?>" readonly>
                                    </div>
                                </div> -->
                                <input type="hidden" name="uid" id="uid_i">

                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Nama Agent</label>
                                        <select name="nama_agent" id="inv_nama_agent" class="form-control select2-agent-inv" required>
                                            <option value="">:: Pilih Agent</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Tanggal Deposit</label>
                                        <input type="date" class="form-control" name="tanggal_deposit" id="tanggal_deposit_i" placeholder="Tanggal Deposit" required>
                                    </div>
                                </div>
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
                                    <!-- <input type="text" name="coa_debit" id="coa_debit_input" class="form-control" readonly> -->
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
                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Nominal Top Up</label>
                                        <input type="number" class="form-control" name="nominal_topup" id="nominal_topup_i" placeholder="Nominal" required>
                                    </div>
                                </div>
                                <!-- <div class="col-md-6 col-xs-12">
                                    <label for="keterangan" class="form-label">Notes</label>
                                    <input name="keterangan" id="keterangan" class="form-control uppercase" value="Top Up Agent Deposit" required>
                                </div> -->
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">
                                Close
                            </button>
                            <button type="submit" class="btn btn-primary">
                                Process
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modalRekap">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Rekap Deposit</h4>
                    </div>
                    <form class="form-horizontal form-label-left" method="POST" action="<?= base_url('depositwh/rekap_deposit') ?>">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Dari</label>
                                        <input type="date" class="form-control" name="dari" id="dari_r">
                                    </div>
                                </div>

                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Sampai</label>
                                        <input type="date" class="form-control" name="sampai" id="sampai_r">
                                    </div>
                                </div>
                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Agent Deposit</label>
                                        <select name="agent_deposit" id="rekap_agent_deposit" class="form-control select2-nama-rekap" required>
                                            <option value="">:: Pilih Nama</option>
                                        </select>
                                    </div>
                                </div>
                                <!-- <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Asal Table</label>
                                        <select name="asal_table" id="rekap_asal_table" class="form-control">
                                            <option value="all">Semua</option>
                                            <option value="out_billing">Out Billing</option>
                                            <option value="in_billing">In Billing</option>
                                        </select>
                                    </div>
                                </div> -->
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
    <!-- <script src="<?= base_url(); ?>src/build/js/sweetalert.js"></script>
	<link rel="stylesheet" href="<?= base_url(); ?>src/build/css/sweetalert.css" /> -->
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
            // DATATABLE
            // =============================================
            var tableUtama = $('#kemasan_table').DataTable({
                processing: true,
                serverSide: true,
                scrollX: true,
                order: [
                    [0, 'desc']
                ], // tambahkan ini
                ajax: {
                    url: '<?= base_url("depositwh/getData_deposit") ?>',
                    type: 'POST'
                },
                columnDefs: [{
                        visible: false,
                        targets: 0
                    }, {
                        // Kolom Saldo (Indeks ke-3, karena hitungan dimulai dari 0: Kode[0], Nama[1], Telepon[2], Saldo[3])
                        targets: [3],
                        className: 'text-right' // Memberikan class rata kanan pada kolom saldo
                    },
                    {
                        orderable: false,
                        targets: [-1]
                    },
                ],
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

            var tableDetail = null;

            // 2. Event Klik Baris Tabel Utama
            $('#kemasan_table tbody').on('click', 'tr', function(e) {
                if ($(e.target).closest('a, button').length) return;

                $('#kemasan_table tbody tr').removeClass('table-active bg-gray');
                $(this).addClass('table-active bg-gray');

                var rowData = tableUtama.row(this).data();
                if (!rowData) return;

                var agent_uid = rowData[0]; // Ambil UID Agent
                var agent_name = rowData[2]; // Ambil Nama Agent

                $('#switch_termasuk_usage').data('uid', agent_uid);
                $('#txt_nama_agent_terpilih').text(agent_name);
                $('#switch_termasuk_usage').prop('checked', false);

                // Munculkan Card Bawah
                $('#card_riwayat_transaksi').slideDown();

                // Panggil fungsi untuk load atau me-refresh server-side DataTables Kedua
                initOrReloadTableDetail(agent_uid, 0);
            });

            // 3. Fungsi Pembuat / Pengendali Server-Side DataTables Detail
            function initOrReloadTableDetail(agent_uid, termasuk_usage) {
                // Jika DataTables detail sudah pernah dibuat sebelumnya, hancurkan (destroy) dulu agar bisa re-init dengan UID baru
                if (tableDetail !== null) {
                    tableDetail.destroy();
                }

                // Buat DataTables baru untuk tabel riwayat detail
                tableDetail = $('#sub_table_riwayat').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "searching": true, // Mengaktifkan fitur pencarian riwayat
                    "scrollX": true,
                    "order": [
                        [0, 'desc']
                    ], // Urutkan berdasarkan tanggal terbaru
                    "ajax": {
                        "url": "<?= base_url('depositwh/get_detail_topup_dt') ?>",
                        "type": "POST",
                        "data": function(d) {
                            d.agent_uid = agent_uid;
                            d.termasuk_usage = termasuk_usage;
                        }
                    },
                    "columnDefs": [{
                            "targets": [2, 3, 4],
                            "className": 'text-right'
                        }, // Rata kanan untuk uang
                        {
                            "orderable": false,
                            "targets": [1, 2, 3, 4, 5]
                        } // Hanya kolom tanggal yang bisa di-sort jika mau
                    ],
                    "language": {
                        "search": "Cari Riwayat:",
                        "lengthMenu": "Tampilkan _MENU_ baris",
                        "zeroRecords": "Tidak ada riwayat transaksi ditemukan"
                    }
                });

                if (termasuk_usage == 1) {
                    // Jika dicentang (Termasuk Usage), tampilkan kolom No Invoice
                    tableDetail.column(2).visible(true);
                } else {
                    // Jika TIDAK dicentang, sembunyikan kolom No Invoice
                    tableDetail.column(2).visible(false);
                }
            }

            // 4. Trigger ketika Switch Toggle diubah
            $('#switch_termasuk_usage').on('change', function() {
                var agent_uid = $(this).data('uid');
                var termasuk_usage = $(this).is(':checked') ? 1 : 0;

                if (agent_uid) {
                    initOrReloadTableDetail(agent_uid, termasuk_usage);
                }
            });

            $('.select2-agent-inv').select2({
                placeholder: ':: Pilih Agent',
                allowClear: true,
                dropdownParent: $('#tambahCustomer .modal-content'),
                ajax: {
                    // url: '<?= base_url('depositwh/get_agent') ?>',
                    url: '<?= base_url('depositwh/get_agent_deposit') ?>',
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

            $('.select2-agent-inv').on('select2:select', function(e) {
                var data = e.params.data; // Mengambil data agent yang dipilih
                var agentUid = data.id;

                // Lakukan AJAX untuk mengambil coa_sbb
                $.ajax({
                    url: '<?= base_url('depositwh/get_coa_by_agent') ?>',
                    type: 'POST',
                    data: {
                        uid: agentUid
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.coa_sbb) {
                            // Asumsikan ID input COA Debit adalah #coa_debit_input
                            $('#coa_kredit').val(response.coa_sbb).trigger('change');
                        }
                    }
                });
            });

            // =============================================
            // RESET FORM DAN SELECT2 KETIKA MODAL DI-CLOSE
            // =============================================
            $('#tambahCustomer').on('hidden.bs.modal', function() {
                // 1. Reset text input, hidden input, dan input tipe date/number di dalam form
                $(this).find('form')[0].reset();

                // 2. Kosongkan nilai input hidden manual jika ada yang tidak ter-reset
                $('#uid_i').val('');
                $('#uid_kemasan').val('');

                // 3. Reset Select2 ke opsi default (kosong)
                $('.select2-agent-inv').val(null).trigger('change');

                // 4. Kembalikan judul modal ke semula jika sebelumnya berubah akibat tombol edit
                $('#myModalLabel').text('Tambah Agents');
            });


            $('.select2-nama-rekap').select2({
                placeholder: ':: Pilih Nama',
                allowClear: true,
                dropdownParent: $('#modalRekap .modal-content'),
                ajax: {
                    url: '<?= base_url('depositwh/get_agent_deposit') ?>',
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
    </script>
</body>

</html>