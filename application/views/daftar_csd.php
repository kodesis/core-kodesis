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
                                <h2>Daftar CSD</h2>
                                <ul class="nav navbar-right panel_toolbox">
                                    <li>
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambahCustomer">
                                            Tambah
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
                                                <th>No CSD</th>
                                                <th>No SMU</th>
                                                <th>No Flight</th>
                                                <th>Tanggal Flight</th>
                                                <th>Nama Barang</th>
                                                <th>Koli</th>
                                                <th>Gross</th>
                                                <th>Post Dates</th>
                                                <th>Jaster</th>
                                                <th>Print</th>
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

        <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="tambahCustomer">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">
                            Tambah Daftar CSD
                        </h4>
                    </div>
                    <form class="form-horizontal form-label-left" method="POST" action="<?= base_url('outgoinghlp/store_csd') ?>">
                        <div class="modal-body">
                            <div class="row">

                                <!-- Input Hidden UID (Tidak perlu required karena otomatis terisi via JS) -->
                                <input type="hidden" name="uid" id="uid_kemasan">

                                <!-- Input SMU -->
                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">SMU</label>
                                        <input type="text" class="form-control smu-input" name="smu" id="t_smu" placeholder="Masukkan nomor SMU..." maxlength="12" required>
                                    </div>
                                </div>

                                <!-- Input No. Pesawat -->
                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">No. Pesawat</label>
                                        <input type="text" class="form-control" name="no_pesawat" id="t_no_pesawat" placeholder="0001" required>
                                    </div>
                                </div>

                                <!-- Input Tanggal Terbang -->
                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Tanggal Terbang</label>
                                        <input type="date" class="form-control" name="tanggal_terbang" required>
                                    </div>
                                </div>

                                <!-- Input Komoditi -->
                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Komoditi</label>
                                        <input type="text" class="form-control uppercase" name="komoditi" placeholder="Masukkan komoditi..." required>
                                    </div>
                                </div>

                                <!-- Input Jumlah (Koli) -->
                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Jumlah (Koli)</label>
                                        <input type="number" class="form-control" name="jumlah" placeholder="0" required>
                                    </div>
                                </div>

                                <!-- Input Gross (kg) -->
                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Gross (kg)</label>
                                        <input type="number" step="1" class="form-control" name="gross" placeholder="0"
                                            onblur="this.value = this.value % 1 > 0.5 ? Math.ceil(this.value) : Math.floor(this.value)" required>
                                    </div>
                                </div>

                                <!-- Select Tujuan -->
                                <!-- <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Tujuan</label>
                                        <select name="tujuan" id="tujuan" class="form-control select2-tujuan" required>
                                            <option value="">:: Pilih Tujuan</option>
                                        </select>
                                    </div>
                                </div> -->

                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Tujuan</label>
                                        <input type="text" class="form-control" name="tujuan" id="t_tujuan">
                                    </div>
                                </div>

                                <!-- Select Status Keamanan -->
                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Status Keamanan</label>
                                        <select name="status_keamanan" class="form-control" required>
                                            <option value="">Pilih Status</option>
                                            <option value='1'>Passenger Aircraft (SPX)</option>
                                            <option value='2'>Cargo Aircraft Only (SCO)</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Select Metode Pemeriksaan -->
                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Metode Pemeriksaan</label>
                                        <select name="methode_pemeriksaan" class="form-control" required>
                                            <option value="">Pilih Metode</option>
                                            <option value='1'>XRAY LINE 1</option>
                                            <option value='2'>XRAY LINE 2</option>
                                            <option value='3'>ETD</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Select Metode Pemeriksaan Opsional -->
                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Metode Pemeriksaan Opsional</label>
                                        <select name="methode_pemeriksaan_opsional" class="form-control" required>
                                            <option value="">Pilih Metode</option>
                                            <option value='1'>PERIKSA FISIK</option>
                                            <option value='2'>ETD</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Select Avsec -->
                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Avsec</label>
                                        <select name="avsec" id="avsec" class="form-control select2-avsec" required>
                                            <option value="">:: Pilih Avsec</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Select Agent -->
                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Agent</label>
                                        <select name="agent" id="agent" class="form-control select2-agent" required>
                                            <option value="">:: Pilih Agent</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Checkbox Jaster (TIDAK ditambahkan required agar bisa di-uncheck) -->
                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Jaster</label>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="jaster" value="1" checked> Jaster
                                            </label>
                                        </div>
                                    </div>
                                </div>

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

        <div class="modal fade" id="modalMigrate" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Konfirmasi Migrate ke Kemasan SMU</h4>
                    </div>
                    <div class="modal-body">
                        <p>Apakah anda yakin ingin memindahkan SMU <b id="migrate_smu"></b> ke Kemasan SMU (out_list)?</p>
                        <p class="text-warning"><i class="fa fa-warning"></i> Data akan disalin ke out_list dan tidak bisa dibatalkan.</p>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" id="migrate_uid">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-primary" id="btnConfirmMigrate">Ya, Migrate</button>
                    </div>
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
                    url: '<?= base_url("outgoinghlp/getData_csd") ?>',
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
                                    id: item.uid,
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

            // 1. Tab masuk ke select2 → dropdown langsung terbuka
            $(document).on('focus', '.select2-selection', function() {
                var $sel = $(this).closest('.select2-container').siblings('select:enabled');
                if ($sel.data('s2-just-closed')) {
                    $sel.data('s2-just-closed', false);
                    return;
                }
                $sel.select2('open');
            });

            // 2. Fokuskan kolom pencarian begitu dropdown terbuka
            $(document).on('select2:open', function() {
                var el = document.querySelector('.select2-container--open .select2-search__field');
                if (el) el.focus();
            });

            // 3. Kembalikan fokus ke field-nya setelah tertutup, supaya Tab lanjut ke field berikutnya
            $(document).on('select2:close', function(e) {
                var $sel = $(e.target);
                $sel.data('s2-just-closed', true);
                setTimeout(function() {
                    var s2 = $sel.data('select2');
                    if (s2) s2.$selection.focus();
                }, 0);
            });

        });
    </script>
    <script>
        // Reset form saat modal ditutup
        $('#tambahCustomer').on('hidden.bs.modal', function() {
            $('#uid_kemasan').val('');
            $(this).find('form')[0].reset();
            $('.select2-pesawat, .select2-tujuan, .select2-avsec, .select2-agent').val(null).trigger('change');
            $('#myModalLabel').text('Tambah Daftar CSD');
        });

        // Tombol edit
        $(document).on('click', '.btn-edit', function() {
            var uid = $(this).data('uid');

            console.log('masuk edit');
            $.get('<?= base_url('outgoinghlp/edit_csd') ?>/' + uid, function(data) {
                console.log('masuk url edit');

                console.log(data);
                $('#uid_kemasan').val(data.uid);
                $('#t_smu').val(data.smu);

                $('input[name="tanggal_terbang"]').val(data.tanggal_terbang);
                $('input[name="komoditi"]').val(data.komoditi);
                $('input[name="jumlah"]').val(data.koli_smu);
                $('input[name="gross"]').val(data.berat_smu);
                $('select[name="status_keamanan"]').val(data.status_keamanan);
                $('select[name="methode_pemeriksaan"]').val(data.methode_pemeriksaan);
                $('select[name="methode_pemeriksaan_opsional"]').val(data.methode_pemeriksaan_opsional);
                $('input[name="jaster"]').prop('checked', data.jaster == '1');

                $('#t_no_pesawat').val(data.no_pesawat);

                $('#t_tujuan').val(data.tujuan);
                // $('#tujuan').append(new Option(data.kode_kota + ' - ' + data.tujuan_nama, data.tujuan_uid, true, true)).trigger('change');
                $('#avsec').append(new Option(data.avsec_nama, data.avsec_uid, true, true)).trigger('change');
                $('#agent').append(new Option(data.agent_nama, data.agent_uid, true, true)).trigger('change');

                $('#myModalLabel').text('Edit Daftar CSD');
                $('#tambahCustomer').modal('show');
            });
        });
    </script>

    <script>
        // Tombol DO
        $(document).on('click', '.btn-do', function() {
            var uid = $(this).data('uid');
            $('#uid_csd').val(uid);
            $('#no_segel').val('');
            $('#no_sticker').val('');
            $('.select2-driver, .select2-truck').val(null).trigger('change');
            $('#modalDO').modal('show');
        });

        // Select2 Driver
        $('.select2-driver').select2({
            placeholder: ':: Pilih Driver',
            allowClear: true,
            dropdownParent: $('#modalDO'),
            ajax: {
                url: '<?= base_url('outgoinghlp/get_driver') ?>',
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

        // Select2 Truck
        $('.select2-truck').select2({
            placeholder: ':: Pilih Truck',
            allowClear: true,
            dropdownParent: $('#modalDO'),
            ajax: {
                url: '<?= base_url('outgoinghlp/get_truck') ?>',
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
                                text: item.no_polisi
                            };
                        })
                    };
                }
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            // Mencegah dan memproses tombol Enter di dalam form Tambah/Edit CSD secara aman
            $(document).on('keydown', '#tambahCustomer form input', function(e) {
                if (e.which === 13) { // Deteksi kode kunci untuk tombol Enter (13)
                    // Pastikan input bukan bagian dari kolom pencarian internal Select2
                    if (!$(this).hasClass('select2-search__field')) {
                        e.preventDefault(); // Hentikan aksi default Enter agar tidak mengacaukan halaman

                        var form = $(this).closest('form');
                        var submitButton = form.find('button[type="submit"]');

                        // Memicu klik tombol submit bawaan agar browser menampilkan balon peringatan jika ada kolom kosong
                        if (submitButton.length > 0) {
                            submitButton.trigger('click');
                        } else {
                            form.submit();
                        }
                    }
                }
            });
        });

        $(document).on('click', '.btn-migrate', function() {
            $('#migrate_uid').val($(this).data('uid'));
            $('#migrate_smu').text($(this).data('smu'));
            $('#modalMigrate').modal('show');
        });

        $('#btnConfirmMigrate').on('click', function() {
            var uid = $('#migrate_uid').val();
            $.ajax({
                url: '<?= base_url('outgoinghlp/migrate_to_kemasan') ?>',
                type: 'POST',
                dataType: 'json',
                data: {
                    uid: uid
                },
                success: function(res) {
                    $('#modalMigrate').modal('hide');
                    if (res.status === 'success') {
                        alert(res.message);
                        $('#kemasan_table').DataTable().ajax.reload();
                    } else {
                        alert(res.message);
                    }
                }
            });
        });
    </script>
</body>

</html>