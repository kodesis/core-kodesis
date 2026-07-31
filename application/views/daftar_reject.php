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
                                <h2>Daftar Reject</h2>
                                <ul class="nav navbar-right panel_toolbox">
                                    <li>
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambahCustomer">
                                            Tambah
                                        </button>
                                    </li>
                                    <li>
                                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalRekapReject">
                                            <i class="fa fa-file-excel-o"></i> Cetak Rekap Excel
                                        </button>
                                    </li>

                                </ul>
                            </div>
                            <div class="x_content">
                                <div class="table-responsive">
                                    <table id="kemasan_table" class="table table-striped table-bordered" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Jam</th>
                                                <th>Tanggal</th>
                                                <th>No Flight</th>
                                                <th>Nama Pengirim</th>
                                                <th>Nama Agen</th>
                                                <th>Nama Avsec</th>
                                                <th>Tujuan</th>
                                                <th>SMU</th>
                                                <th>Isi PTI</th>
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

        <!-- /page content -->

        <!-- footer content -->

        <!-- /footer content -->

        <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="tambahCustomer">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">Tambah Daftar Reject</h4>
                    </div>
                    <form class="form-horizontal form-label-left" method="POST" action="<?= base_url('outgoinghlp/store_reject') ?>">
                        <input type="hidden" name="uid_kemasan" id="uid_kemasan">
                        <div class="modal-body">
                            <div class="row">

                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Tanggal</label>
                                        <input type="date" class="form-control" name="tanggal" required>
                                    </div>
                                </div>

                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Jam</label>
                                        <input type="time" class="form-control" name="jam" required>
                                    </div>
                                </div>

                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">SMU</label>
                                        <input type="text" class="form-control uppercase" name="smu" id="t_smu" required>
                                    </div>
                                </div>

                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">No. Flight</label>
                                        <input type="text" class="form-control" name="no_flight" required>
                                    </div>
                                </div>

                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Tujuan</label>
                                        <input type="hidden" name="tujuan_uid" id="tujuan_uid">
                                        <select name="tujuan" id="tujuan" class="form-control select2-tujuan">
                                            <option value="">:: Pilih Tujuan</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Isi PTI</label>
                                        <input type="text" class="form-control" name="isi_pti" required>
                                    </div>
                                </div>

                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Nama Pengirim</label>
                                        <input type="hidden" name="pengirim_uid" id="pengirim_uid">
                                        <select name="nama_pengirim" id="nama_pengirim" class="form-control select2-pengirim">
                                            <option value="">:: Pilih Pengirim</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Telepon Pengirim</label>
                                        <input type="text" class="form-control" name="telepon_pengirim" id="telepon_pengirim">
                                    </div>
                                </div>

                                <div class="col-md-12 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Alamat Pengirim</label>
                                        <textarea class="form-control" name="alamat_pengirim" id="alamat_pengirim" rows="2"></textarea>
                                    </div>
                                </div> -->

                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Nama Agent</label>
                                        <select name="id_agent" id="agent" class="form-control select2-agent">
                                            <option value="">:: Pilih Agent</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Avsec</label>
                                        <input type="hidden" name="avsec_uid" id="avsec_uid">
                                        <select name="avsec_nama" id="avsec" class="form-control select2-avsec">
                                            <option value="">:: Pilih Avsec</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12 col-xs-12">
                                    <hr>
                                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">
                                        <h5><b>Detail Item Reject</b></h5>
                                        <button type="button" class="btn btn-sm btn-success" id="btnTambahDetail">
                                            <i class="fa fa-plus"></i> Tambah Baris
                                        </button>
                                    </div>
                                    <table class="table table-bordered table-condensed" id="tabelDetail">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Jumlah</th>
                                                <th>Satuan</th>
                                                <th>Keterangan</th>
                                                <th>Hapus</th>
                                            </tr>
                                        </thead>
                                        <tbody id="bodyDetail">
                                            <tr class="detail-row">
                                                <td>1</td>
                                                <td><input type="number" class="form-control" name="detail_jumlah[]" placeholder="0"></td>
                                                <td>
                                                    <select class="form-control" name="detail_satuan[]">
                                                        <option value="Pieces">Pieces</option>
                                                        <option value="Koli">Koli</option>
                                                    </select>
                                                </td>
                                                <td><input type="text" class="form-control" name="detail_keterangan[]" placeholder="Keterangan..."></td>
                                                <td><button type="button" class="btn btn-xs btn-danger btn-hapus-detail"><i class="fa fa-trash"></i></button></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Process</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalRekapReject" isset="-1" role="dialog" aria-labelledby="modalRekapRejectLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="modalRekapRejectLabel"><i class="fa fa-file-excel-o"></i> Filter Rekap Daftar Reject</h4>
                    </div>

                    <form action="<?= base_url('outgoinghlp/rekap_reject_excel') ?>" method="POST" target="_blank">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Dari Tanggal</label>
                                        <div class="input-group date">
                                            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                            <input type="date" class="form-control datepicker_rekap" name="dari" value="<?= date('Y-m-d') ?>" required autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Sampai Tanggal</label>
                                        <div class="input-group date">
                                            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                            <input type="date" class="form-control datepicker_rekap" name="sampai" value="<?= date('Y-m-d') ?>" required autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-success"><i class="fa fa-download"></i> Download Excel</button>
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

            // =============================================
            // DATATABLE
            // =============================================
            $('#kemasan_table').DataTable({
                processing: true,
                serverSide: true,
                scrollX: true,
                order: [
                    [0, 'desc']
                ],
                ajax: {
                    url: '<?= base_url("outgoinghlp/getData_reject") ?>',
                    type: 'POST'
                },
                columnDefs: [{
                    orderable: false,
                    targets: [-1, -2]
                }, ],
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

            // =============================================
            // TOMBOL EDIT REJECT (Berdiri Sendiri / Global Scope)
            // =============================================
            $(document).on('click', '.btn-edit', function(e) {
                e.preventDefault();

                var uid = $(this).data('uid');

                // Ubah text judul modal & action form ke route update
                $('#myModalLabel').text('Edit Daftar Reject');
                $('#tambahCustomer').find('form').attr('action', '<?= base_url("outgoinghlp/update_reject") ?>');

                $.ajax({
                    url: '<?= base_url("outgoinghlp/edit_reject") ?>/' + uid,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        if (data.status === 'error') {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                text: data.message
                            });
                            return;
                        }

                        // Isi field modal dengan data dari server
                        $('#uid_kemasan').val(data.reject.uid);
                        $('input[name="tanggal"]').val(data.reject.tanggal);
                        $('input[name="jam"]').val(data.reject.jam);
                        $('#t_smu').val(data.reject.smu);
                        $('input[name="no_flight"]').val(data.reject.no_flight);
                        $('input[name="isi_pti"]').val(data.reject.isi_pti);
                        $('input[name="telepon_pengirim"]').val(data.reject.telepon_pengirim);
                        $('#alamat_pengirim').val(data.reject.alamat_pengirim);

                        // Set Select2 Option Secara Dinamis
                        if (data.reject.tujuan) {
                            $('#tujuan').append(new Option(data.reject.kode_kota + ' - ' + data.reject.tujuan_nama, data.reject.tujuan, true, true)).trigger('change');
                        }
                        if (data.reject.uid_pengirim) {
                            $('#nama_pengirim').append(new Option(data.reject.pengirim_nama, data.reject.uid_pengirim, true, true)).trigger('change');
                        }
                        if (data.reject.uid_agen) {
                            $('#agent').append(new Option(data.reject.agent_kode + ' - ' + data.reject.agent_nama, data.reject.uid_agen, true, true)).trigger('change');
                        }
                        if (data.reject.avsec_uid) {
                            $('#avsec').append(new Option(data.reject.avsec_kode + ' - ' + data.reject.avsec_nama, data.reject.avsec_uid, true, true)).trigger('change');
                        }

                        // Load Detail Items
                        $('#bodyDetail').empty();
                        if (data.detail && data.detail.length > 0) {
                            $.each(data.detail, function(i, item) {
                                var no = i + 1;
                                var html = '<tr class="detail-row">';
                                html += '<td>' + no + '</td>';
                                html += '<td><input type="number" class="form-control" name="detail_jumlah[]" value="' + item.jumlah + '"></td>';
                                html += '<td><select class="form-control" name="detail_satuan[]"><option value="Pieces" ' + (item.satuan == "Pieces" ? "selected" : "") + '>Pieces</option><option value="Koli" ' + (item.satuan == "Koli" ? "selected" : "") + '>Koli</option></select></td>';
                                html += '<td><input type="text" class="form-control" name="detail_keterangan[]" value="' + item.keterangan + '"></td>';
                                html += '<td><button type="button" class="btn btn-xs btn-danger btn-hapus-detail"><i class="fa fa-trash"></i></button></td>';
                                html += '</tr>';
                                $('#bodyDetail').append(html);
                            });
                        } else {
                            $('#btnTambahDetail').click();
                        }

                        // Tampilkan modal setelah data siap
                        $('#tambahCustomer').modal('show');
                    },
                    error: function() {
                        Swal.fire("Error", "Gagal terhubung ke server.", "error");
                    }
                });
            });

            // =============================================
            // RESET MODAL JIKA DITUTUP
            // =============================================
            $('#tambahCustomer').on('hidden.bs.modal', function() {
                $('#uid_kemasan').val('');
                $(this).find('form')[0].reset();
                $(this).find('form').attr('action', '<?= base_url("outgoinghlp/store_reject") ?>'); // Kembalikan ke insert
                $('.select2-pengirim, .select2-tujuan, .select2-avsec, .select2-agent').val(null).trigger('change');
                $('#myModalLabel').text('Tambah Daftar Reject');

                // Reset baris tabel detail ke default semula (1 baris kosong)
                $('#bodyDetail').html('<tr class="detail-row">' +
                    '<td>1</td>' +
                    '<td><input type="number" class="form-control" name="detail_jumlah[]" placeholder="0"></td>' +
                    '<td><select class="form-control" name="detail_satuan[]"><option value="Pieces">Pieces</option><option value="Koli">Koli</option></select></td>' +
                    '<td><input type="text" class="form-control" name="detail_keterangan[]" placeholder="Keterangan..."></td>' +
                    '<td><button type="button" class="btn btn-xs btn-danger btn-hapus-detail"><i class="fa fa-trash"></i></button></td>' +
                    '</tr>');
            });

        });

        // =============================================
        // HANDLING DETAIL ROWS (Dinamis diluar document ready)
        // =============================================
        $('#btnTambahDetail').on('click', function() {
            var no = $('#bodyDetail .detail-row').length + 1;
            var html = '<tr class="detail-row">';
            html += '<td>' + no + '</td>';
            html += '<td><input type="number" class="form-control" name="detail_jumlah[]" placeholder="0"></td>';
            html += '<td><select class="form-control" name="detail_satuan[]"><option value="Pieces">Pieces</option><option value="Koli">Koli</option></select></td>';
            html += '<td><input type="text" class="form-control" name="detail_keterangan[]" placeholder="Keterangan..."></td>';
            html += '<td><button type="button" class="btn btn-xs btn-danger btn-hapus-detail"><i class="fa fa-trash"></i></button></td>';
            html += '</tr>';
            $('#bodyDetail').append(html);
            renumberDetail();
        });

        $(document).on('click', '.btn-hapus-detail', function() {
            if ($('#bodyDetail .detail-row').length > 1) {
                $(this).closest('tr').remove();
                renumberDetail();
            }
        });

        function renumberDetail() {
            $('#bodyDetail .detail-row').each(function(i) {
                $(this).find('td:first').text(i + 1);
            });
        }

        $(document).ready(function() {
            // Inisialisasi datepicker khusus untuk modal rekap saat modal dibuka
            $('#modalRekapReject').on('shown.bs.modal', function() {
                $('.datepicker_rekap').datepicker({
                    autoclose: true,
                    format: 'yyyy-mm-dd',
                    todayHighlight: true
                });
            });
        });
    </script>

    <script>
        // =============================================
        // INITIALIZATION SELECT2 SAAT MODAL OPEN
        // =============================================
        $('#tambahCustomer').on('shown.bs.modal', function() {
            $('.select2-pengirim').select2({
                placeholder: ':: Pilih Pengirim',
                allowClear: true,
                dropdownParent: $('#tambahCustomer .modal-content'),
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
                                    id: item.uid,
                                    text: item.nama,
                                    telepon: item.telepon,
                                    alamat: item.alamat
                                };
                            })
                        };
                    }
                }
            });
        });

        // Auto-fill saat pengirim dipilih
        $(document).on('select2:select', '#nama_pengirim', function(e) {
            $('#pengirim_uid').val(e.params.data.id);
            $('#telepon_pengirim').val(e.params.data.telepon ?? '');
            $('#alamat_pengirim').val(e.params.data.alamat ?? '');
        });
    </script>
    <script>
        $(document).ready(function() {

            // No Pesawat
            $('.select2-pesawat').select2({
                placeholder: ':: Pilih No. Pesawat',
                allowClear: true,
                dropdownParent: $('#tambahCustomer'),
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
                                    id: item.kode,
                                    text: item.kode + ' - ' + item.nama
                                };
                            })
                        };
                    }
                }
            });

            // Tujuan
            $('.select2-tujuan').select2({
                placeholder: ':: Pilih Tujuan',
                allowClear: true,
                dropdownParent: $('#tambahCustomer'),
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
                                    id: item.kode_kota,
                                    text: item.kode_kota + ' - ' + item.nama
                                };
                            })
                        };
                    }
                }
            });

            // Avsec
            $('.select2-avsec').select2({
                placeholder: ':: Pilih Avsec',
                allowClear: true,
                dropdownParent: $('#tambahCustomer'),
                ajax: {
                    url: '<?= base_url('outgoinghlp/get_avsec') ?>',
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
                                    text: item.kode + ' - ' + item.nama
                                };
                            })
                        };
                    }
                }
            });

            // Agent
            $('.select2-agent').select2({
                placeholder: ':: Pilih Agent',
                allowClear: true,
                dropdownParent: $('#tambahCustomer'),
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
                                    text: item.kode + ' - ' + item.nama
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