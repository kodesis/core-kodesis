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
                                <h2>Daftar DO</h2>
                                <ul class="nav navbar-right panel_toolbox">
                                    <li>
                                        <button type="button" class="btn btn-primary btn-do">
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
                                                <th>No STC</th>
                                                <th>WH To</th>
                                                <th>Qty</th>
                                                <th>Weight</th>
                                                <th>No Segel</th>
                                                <th>No Sticker</th>
                                                <th>No Polisi</th>
                                                <th>Driver</th>
                                                <th>Tanggal</th>
                                                <th>User</th>
                                                <th>Cetak</th>
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

        </div>

        <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modalDO">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Tambah DO</h4>
                    </div>
                    <form class="form-horizontal form-label-left" method="POST" action="<?= base_url('outgoinghlp/store_do') ?>">
                        <div class="modal-body">
                            <div class="row">

                                <div class="col-md-4 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Remark</label>
                                        <input type="text" class="form-control" name="remark" id="remark" value="CLEAR" required>
                                    </div>
                                </div>

                                <div class="col-md-4 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Warehouse</label>
                                        <select class="form-control" name="wh_name" id="wh_name" required>
                                            <option value="">:: Pilih Warehouse</option>
                                            <option value="bdl">BDL</option>
                                            <option value="ardhya">Ardhya</option>
                                            <option value="jas">JAS</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">No. Segel</label>
                                        <input type="text" class="form-control" name="no_segel" id="no_segel" placeholder="No. segel..." required>
                                    </div>
                                </div>

                                <div class="col-md-4 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">No. Sticker</label>
                                        <input type="text" class="form-control" name="no_sticker" id="no_sticker" placeholder="No. sticker..." required>
                                    </div>
                                </div>

                                <div class="col-md-4 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Driver</label>
                                        <select name="driver_uid" id="driver_uid" class="form-control select2-driver-do" required>
                                            <option value="">:: Pilih Driver</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Truck</label>
                                        <select name="truck_uid" id="truck_uid" class="form-control select2-truck-do" required>
                                            <option value="">:: Pilih Truck</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12 col-xs-12">
                                    <hr>
                                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                                        <label class="form-label" style="margin: 0;">Pilih SMU</label>
                                    </div>
                                    <table class="table table-bordered table-hover table-condensed" id="tabelSMU" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th width="30"><input type="checkbox" id="checkAll"></th>
                                                <th>No. CSD</th>
                                                <th>SMU</th>
                                                <th>Tujuan</th>
                                                <th>Komoditi</th>
                                                <th>Koli</th>
                                                <th>Berat</th>
                                            </tr>
                                        </thead>
                                        <tbody id="bodyTabelSMU">
                                            <tr>
                                                <td colspan="7" class="text-center">Memuat data...</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div id="summaryDO" style="font-size: 13px; color: #555; margin-top: 5px;">
                                        Total: <b id="totalSMU">0</b> SMU | Koli: <b id="totalKoli">0</b> | Berat: <b id="totalBerat">0</b> kg
                                    </div>
                                    <input type="hidden" name="uid_list" id="uid_list" required>
                                </div>

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Proses ke DO</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modalEditDO">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit DO <span id="edit_no_ch"></span></h4>
                    </div>
                    <form class="form-horizontal form-label-left" method="POST" action="<?= base_url('outgoinghlp/update_do') ?>">
                        <input type="hidden" name="uid_ch" id="edit_uid_ch">
                        <div class="modal-body">
                            <div class="row">

                                <div class="col-md-4 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Remark</label>
                                        <input type="text" class="form-control" name="remark" id="edit_remark" required>
                                    </div>
                                </div>

                                <div class="col-md-4 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Warehouse</label>
                                        <select class="form-control" name="wh_name" id="edit_wh_name" required>
                                            <option value="">:: Pilih Warehouse</option>
                                            <option value="bdl">BDL</option>
                                            <option value="ardhya">Ardhya</option>
                                            <option value="jas">JAS</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">No. Segel</label>
                                        <input type="text" class="form-control" name="no_segel" id="edit_no_segel" required>
                                    </div>
                                </div>

                                <div class="col-md-4 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">No. Sticker</label>
                                        <input type="text" class="form-control" name="no_sticker" id="edit_no_sticker" required>
                                    </div>
                                </div>

                                <div class="col-md-4 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Driver</label>
                                        <select name="driver_uid" id="edit_driver_uid" class="form-control select2-driver-edit" required>
                                            <option value="">:: Pilih Driver</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Truck</label>
                                        <select name="truck_uid" id="edit_truck_uid" class="form-control select2-truck-edit" required>
                                            <option value="">:: Pilih Truck</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12 col-xs-12">
                                    <hr>
                                    <label class="form-label">Pilih SMU</label>
                                    <table class="table table-bordered table-hover table-condensed" id="tabelSMUEdit" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th width="30"><input type="checkbox" id="checkAllEdit"></th>
                                                <th>No. CSD</th>
                                                <th>SMU</th>
                                                <th>Tujuan</th>
                                                <th>Komoditi</th>
                                                <th>Koli</th>
                                                <th>Berat</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                    <div style="font-size: 13px; color: #555; margin-top: 5px;">
                                        Total: <b id="editTotalSMU">0</b> SMU | Koli: <b id="editTotalKoli">0</b> | Berat: <b id="editTotalBerat">0</b> kg
                                    </div>
                                    <input type="hidden" name="uid_list" id="edit_uid_list" required>
                                </div>

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-warning">Update DO</button>
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
    <!-- iCheck -->
    <script src="<?= base_url(); ?>src/vendors/iCheck/icheck.min.js"></script>
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
            // Mencegah dan memproses tombol Enter di dalam form DO secara aman
            $(document).on('keydown', '#modalDO form input, #modalEditDO form input', function(e) {
                if (e.which === 13) { // Deteksi tombol Enter
                    // Pastikan input bukan pencarian Select2 dan bukan kolom pencarian filter DataTables
                    if (!$(this).hasClass('select2-search__field') && !$(this).closest('.dataTables_filter').length) {
                        e.preventDefault(); // Hentikan aksi bawaan Enter agar tidak langsung reload halaman

                        var form = $(this).closest('form');
                        var submitButton = form.find('button[type="submit"]');

                        // Memicu klik pada tombol submit asli (agar validasi HTML5 required tetap berjalan)
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
        <?php if ($this->session->flashdata('message_name')) { ?>
            Swal.fire({
                title: "Success!! ",
                text: '<?= $this->session->flashdata('message_name') ?>',
                type: "success",
                icon: "success",
            });
            <?php unset($_SESSION['message_name']); ?>
        <?php } ?>

        <?php if ($this->session->flashdata('message_error')) { ?>
            Swal.fire({
                title: "Error!! ",
                text: '<?= $this->session->flashdata('message_error') ?>',
                type: "error",
                icon: "error",
            });
            <?php unset($_SESSION['message_error']); ?>
        <?php } ?>
    </script>

    <script>
        $(document).ready(function() {

            // =============================================
            // DATATABLE UTAMA DO LIST
            // =============================================
            $('#kemasan_table').DataTable({
                processing: true,
                serverSide: true,
                scrollX: true,
                order: [
                    [0, 'desc']
                ],
                ajax: {
                    url: '<?= base_url("outgoinghlp/getData_do") ?>',
                    type: 'POST'
                },
                columnDefs: [{
                    orderable: false,
                    targets: [-1, -2]
                }],
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
            // DEKLARASI GLOBAL STATE (Gunakan Map agar persisten lintas Page/Search)
            // =============================================
            var dtSMU;
            var selectedSMUMap = new Map(); // Untuk Tambah (UID => {koli, berat})

            var dtSMUEdit;
            var selectedSMUMapEdit = new Map(); // Untuk Edit (UID => {koli, berat})
            var initialSelectedUidsEdit = []; // Array awal dari Database untuk Edit

            // =============================================
            // AUTO FILL NO STICKER
            // =============================================
            $("#no_segel").on('keyup', function() {
                $('#no_sticker').val($(this).val() + ' ');
            });

            // =============================================
            // MODAL TAMBAH DO
            // =============================================
            $(document).on('click', '.btn-do', function() {
                $('#no_segel').val('');
                $('#no_sticker').val('');
                $('#uid_list').val('');
                selectedSMUMap.clear(); // Bersihkan pilihan sebelumnya
                $('#modalDO').modal('show');
            });

            $('#modalDO').on('shown.bs.modal', function() {
                initDtSMU();

                $('.select2-driver-do').select2({
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

                $('.select2-truck-do').select2({
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
            });

            $('#modalDO').on('hidden.bs.modal', function() {
                $(this).find('form')[0].reset();
                selectedSMUMap.clear();
                if (dtSMU) {
                    dtSMU.destroy();
                    dtSMU = null;
                }
                updateSummary();
                $('.select2-driver-do, .select2-truck-do').val(null).trigger('change');
            });

            function initDtSMU() {
                if (dtSMU) dtSMU.destroy();

                dtSMU = $('#tabelSMU').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: '<?= base_url('outgoinghlp/get_list_smu_dt') ?>',
                        type: 'POST',
                        data: function(d) {
                            // Mengirimkan array key map ke server side
                            d.selected_uids = Array.from(selectedSMUMap.keys());
                        }
                    },
                    order: [], // Biarkan server mengaturnya ke uid DESC atau urut data terbaru
                    columns: [{
                            data: null,
                            orderable: false,
                            render: function(data) {
                                var uidStr = String(data.uid);
                                var checked = selectedSMUMap.has(uidStr) ? 'checked' : '';
                                return '<input type="checkbox" class="chk-smu" ' + checked + ' data-uid="' + data.uid + '" data-koli="' + data.koli_smu + '" data-berat="' + data.berat_smu + '">';
                            }
                        },
                        {
                            data: 'no_csd'
                        },
                        {
                            data: 'smu',
                            render: function(data) {
                                return '<b>' + (data ?? '-') + '</b>';
                            }
                        },
                        {
                            data: 'tujuan'
                        },
                        {
                            data: 'komoditi'
                        },
                        {
                            data: 'koli_smu',
                            className: 'text-center'
                        },
                        {
                            data: 'berat_smu',
                            className: 'text-center'
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
                    },
                    drawCallback: function() {
                        // Highlight baris yang dicentang
                        $('.chk-smu:checked').closest('tr').css('background', '#dbeafe');
                        updateSummary();
                    }
                });
            }

            // Aksi Check All - Hanya berdampak pada yang ada di halaman saat ini
            $('#checkAll').on('change', function() {
                var checked = $(this).is(':checked');
                $('.chk-smu').each(function() {
                    var uid = String($(this).data('uid'));
                    var koli = parseInt($(this).data('koli')) || 0;
                    var berat = parseFloat($(this).data('berat')) || 0;

                    $(this).prop('checked', checked);
                    if (checked) {
                        selectedSMUMap.set(uid, {
                            koli: koli,
                            berat: berat
                        });
                        $(this).closest('tr').css('background', '#dbeafe');
                    } else {
                        selectedSMUMap.delete(uid);
                        $(this).closest('tr').css('background', '');
                    }
                });
                updateSummary();
            });

            // Individual Checkbox Click
            $(document).on('change', '.chk-smu', function() {
                var uid = String($(this).data('uid'));
                var koli = parseInt($(this).data('koli')) || 0;
                var berat = parseFloat($(this).data('berat')) || 0;

                if ($(this).is(':checked')) {
                    selectedSMUMap.set(uid, {
                        koli: koli,
                        berat: berat
                    });
                    $(this).closest('tr').css('background', '#dbeafe');
                } else {
                    selectedSMUMap.delete(uid);
                    $(this).closest('tr').css('background', '');
                }
                updateSummary();
            });

            function updateSummary() {
                var uids = Array.from(selectedSMUMap.keys());
                $('#totalSMU').text(uids.length);
                $('#uid_list').val(uids.join(','));

                var totalKoli = 0;
                var totalBerat = 0;

                selectedSMUMap.forEach(function(val) {
                    totalKoli += val.koli;
                    totalBerat += val.berat;
                });

                $('#totalKoli').text(totalKoli);
                $('#totalBerat').text(totalBerat.toFixed(0));
            }


            // =============================================
            // MODAL EDIT DO
            // =============================================
            $(document).on('click', '.btn-edit-do', function() {
                var uid_ch = $(this).data('uid');
                selectedSMUMapEdit.clear();
                initialSelectedUidsEdit = [];

                $.ajax({
                    url: '<?= base_url('outgoinghlp/get_do') ?>/' + uid_ch,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#edit_uid_ch').val(data.header.uid);
                        $('#edit_no_ch').text(data.header.no_ch);
                        $('#edit_remark').val(data.header.remark);
                        $('#edit_wh_name').val(data.header.wh_name);
                        $('#edit_no_segel').val(data.header.no_segel);
                        $('#edit_no_sticker').val(data.header.no_sticker);

                        $('#edit_driver_uid').append(
                            new Option(data.header.nama_driver, data.header.driver_uid, true, true)
                        ).trigger('change');
                        $('#edit_truck_uid').append(
                            new Option(data.header.no_polisi, data.header.truck_uid, true, true)
                        ).trigger('change');

                        // Catat UIDs terpilih awal dari server
                        if (data.selected_uids) {
                            initialSelectedUidsEdit = data.selected_uids.map(String);
                            // Pre-register ke Map edit dengan nilai awal default
                            initialSelectedUidsEdit.forEach(function(uid) {
                                selectedSMUMapEdit.set(uid, {
                                    koli: 0,
                                    berat: 0
                                });
                            });
                        }

                        $('#modalEditDO').modal('show');
                    }
                });
            });

            $('#modalEditDO').on('shown.bs.modal', function() {
                initDtSMUEdit();

                $('.select2-driver-edit').select2({
                    placeholder: ':: Pilih Driver',
                    allowClear: true,
                    dropdownParent: $('#modalEditDO'),
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

                $('.select2-truck-edit').select2({
                    placeholder: ':: Pilih Truck',
                    allowClear: true,
                    dropdownParent: $('#modalEditDO'),
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
            });

            $('#modalEditDO').on('hidden.bs.modal', function() {
                $(this).find('form')[0].reset();
                selectedSMUMapEdit.clear();
                initialSelectedUidsEdit = [];
                if (dtSMUEdit) {
                    dtSMUEdit.destroy();
                    dtSMUEdit = null;
                }
                updateSummaryEdit();
                $('.select2-driver-edit, .select2-truck-edit').val(null).trigger('change');
            });

            function initDtSMUEdit() {
                if (dtSMUEdit) dtSMUEdit.destroy();

                dtSMUEdit = $('#tabelSMUEdit').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: '<?= base_url('outgoinghlp/get_list_smu_edit_dt') ?>',
                        type: 'POST',
                        data: function(d) {
                            d.uid_ch = $('#edit_uid_ch').val();
                            // Kirimkan state terkini Map atau UIDs awal ke server side
                            var currentKeys = Array.from(selectedSMUMapEdit.keys());
                            d.selected_uids = currentKeys.length > 0 ? currentKeys : initialSelectedUidsEdit;
                        }
                    },
                    order: [], // Biarkan server mengurutkan data terbaru di paling atas
                    columns: [{
                            data: null,
                            orderable: false,
                            render: function(data) {
                                var uidStr = String(data.uid);

                                // Update nilai real koli dan berat yang valid saat data berhasil dirender di UI
                                if (selectedSMUMapEdit.has(uidStr)) {
                                    selectedSMUMapEdit.set(uidStr, {
                                        koli: parseInt(data.koli_smu) || 0,
                                        berat: parseFloat(data.berat_smu) || 0
                                    });
                                }

                                var checked = selectedSMUMapEdit.has(uidStr) ? 'checked' : '';
                                return '<input type="checkbox" class="chk-smu-edit" ' + checked + ' data-uid="' + data.uid + '" data-koli="' + data.koli_smu + '" data-berat="' + data.berat_smu + '">';
                            }
                        },
                        {
                            data: 'no_csd'
                        },
                        {
                            data: 'smu',
                            render: function(data) {
                                return '<b>' + (data ?? '-') + '</b>';
                            }
                        },
                        {
                            data: 'tujuan'
                        },
                        {
                            data: 'komoditi'
                        },
                        {
                            data: 'koli_smu',
                            className: 'text-center'
                        },
                        {
                            data: 'berat_smu',
                            className: 'text-center'
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
                    },
                    drawCallback: function() {
                        $('.chk-smu-edit:checked').closest('tr').css('background', '#dbeafe');
                        updateSummaryEdit();
                    }
                });
            }

            $('#checkAllEdit').on('change', function() {
                var checked = $(this).is(':checked');
                $('.chk-smu-edit').each(function() {
                    var uid = String($(this).data('uid'));
                    var koli = parseInt($(this).data('koli')) || 0;
                    var berat = parseFloat($(this).data('berat')) || 0;

                    $(this).prop('checked', checked);
                    if (checked) {
                        selectedSMUMapEdit.set(uid, {
                            koli: koli,
                            berat: berat
                        });
                        $(this).closest('tr').css('background', '#dbeafe');
                    } else {
                        selectedSMUMapEdit.delete(uid);
                        // Hapus juga dari tracking UID awal database agar tidak dicentang otomatis lagi
                        initialSelectedUidsEdit = initialSelectedUidsEdit.filter(function(u) {
                            return u !== uid;
                        });
                        $(this).closest('tr').css('background', '');
                    }
                });
                updateSummaryEdit();
            });

            $(document).on('change', '.chk-smu-edit', function() {
                var uid = String($(this).data('uid'));
                var koli = parseInt($(this).data('koli')) || 0;
                var berat = parseFloat($(this).data('berat')) || 0;

                if ($(this).is(':checked')) {
                    selectedSMUMapEdit.set(uid, {
                        koli: koli,
                        berat: berat
                    });
                    $(this).closest('tr').css('background', '#dbeafe');
                } else {
                    selectedSMUMapEdit.delete(uid);
                    initialSelectedUidsEdit = initialSelectedUidsEdit.filter(function(u) {
                        return u !== uid;
                    });
                    $(this).closest('tr').css('background', '');
                }
                updateSummaryEdit();
            });

            function updateSummaryEdit() {
                var uids = Array.from(selectedSMUMapEdit.keys());
                $('#editTotalSMU').text(uids.length);
                $('#edit_uid_list').val(uids.join(','));

                var totalKoli = 0;
                var totalBerat = 0;

                selectedSMUMapEdit.forEach(function(val) {
                    totalKoli += val.koli;
                    totalBerat += val.berat;
                });

                $('#editTotalKoli').text(totalKoli);
                $('#editTotalBerat').text(totalBerat.toFixed(0));
            }

            // =============================================
            // VALIDASI MINIMAL 1 SMU SEBELUM SUBMIT FORM
            // =============================================
            $('#modalDO form').on('submit', function(e) {
                if (selectedSMUMap.size < 1) {
                    e.preventDefault();
                    Swal.fire({
                        title: "Peringatan!",
                        text: "Harap pilih minimal 1 SMU sebelum memproses DO.",
                        icon: "warning"
                    });
                    return false;
                }
            });

            $('#modalEditDO form').on('submit', function(e) {
                if (selectedSMUMapEdit.size < 1) {
                    e.preventDefault();
                    Swal.fire({
                        title: "Peringatan!",
                        text: "Harap pilih minimal 1 SMU sebelum memperbarui DO.",
                        icon: "warning"
                    });
                    return false;
                }
            });

            // =============================================
            // DELETE DO
            // =============================================
            $(document).on('click', '.btn-delete-do', function() {
                var uid = $(this).data('uid');
                if (confirm('Yakin ingin menghapus DO ini? Semua SMU akan dikembalikan.')) {
                    window.location.href = '<?= base_url('outgoinghlp/delete_do') ?>/' + uid;
                }
            });

        });
    </script>

</body>

</html>