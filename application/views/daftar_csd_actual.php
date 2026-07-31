<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
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
                    <br />

                    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                        <?php $this->load->view('side_menu.php'); ?>
                    </div>
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
                                    <li><a href="<?= base_url(); ?>login/logout"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                                </ul>
                            </li>
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
                                <h2>Daftar CSD Actual (Verifikasi Keamanan Gudang)</h2>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <div class="table-responsive">
                                    <table id="csd_actual_table" class="table table-striped table-bordered" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>No CSD</th>
                                                <th>SMU/AWB</th>
                                                <th>Komoditi</th>
                                                <th>Status Keamanan</th>
                                                <th>Metode Pemeriksaan</th>
                                                <th>Status</th>
                                                <th>Tanggal</th>
                                                <th>Avsec</th>
                                                <th>Cetak</th>
                                                <th>#</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- MODAL PROSES CSD (BUAT BARU / EDIT) -->
        <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="tambahCustomer">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                        <h4 class="modal-title" id="myModalLabel">Proses CSD Actual</h4>
                    </div>
                    <form id="formCsdActual" class="form-horizontal form-label-left" method="POST"
                        action="<?= base_url('outgoinghlp/update_csd_actual') ?>">
                        <div class="modal-body">
                            <div class="row">
                                <!-- Input Hidden UIDs -->
                                <input type="hidden" name="csd_uid" id="uid_csd">
                                <input type="hidden" name="smu_uid" id="smu_uid">

                                <!-- Input No CSD (Hanya Muncul saat Edit) -->
                                <div class="col-md-6 col-xs-12" id="group_no_csd" style="display: none;">
                                    <div class="form-group">
                                        <label class="form-label">No. CSD</label>
                                        <input type="text" class="form-control" name="no_csd" id="no_csd" readonly>
                                    </div>
                                </div>

                                <!-- Input SMU -->
                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">SMU</label>
                                        <input type="text" class="form-control" name="smu" id="t_smu" readonly>
                                    </div>
                                </div>

                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Alasan</label>
                                        <select class="form-control" name="alasan" id="t_alasan" required>
                                            <option value="0">Pilih Alasan</option>
                                            <option value="1" selected>CLEAR</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Select Status Keamanan -->
                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Status Keamanan</label>
                                        <select name="status_keamanan" id="t_status_keamanan" class="form-control" required>
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
                                        <select name="methode_pemeriksaan" id="t_methode_pemeriksaan" class="form-control" required>
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
                                        <select name="methode_pemeriksaan_opsional" id="t_methode_pemeriksaan_opsional" class="form-control" required>
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
                                        <select name="upd_avsec_uid" id="avsec" class="form-control select2-avsec" required>
                                            <option value="">:: Pilih Avsec</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Input No. Segel -->
                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">No. Segel (Seal)</label>
                                        <input type="text" class="form-control" name="no_segel" id="no_segel" placeholder="Ketik nomor segel...">
                                    </div>
                                </div>

                                <!-- Input No. Sticker -->
                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">No. Sticker</label>
                                        <input type="text" class="form-control" name="no_sticker" id="no_sticker" placeholder="Ketik nomor sticker...">
                                    </div>
                                </div>

                                <!-- Select Driver -->
                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Driver</label>
                                        <select name="driver_uid" id="driver_uid" class="form-control select2-driver">
                                            <option value="">:: Pilih Driver</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Select Truck -->
                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">No Polisi Truck</label>
                                        <select name="truck_uid" id="truck_uid" class="form-control select2-truck">
                                            <option value="">:: Pilih Truck</option>
                                        </select>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan CSD</button>
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
    <script src="<?= base_url(); ?>src/vendors/fastclick/lib/fastclick.js"></script>
    <script src="<?= base_url(); ?>src/vendors/nprogress/nprogress.js"></script>
    <!-- Datatables -->
    <script src="<?= base_url(); ?>src/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="<?= base_url(); ?>src/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <!-- Sweetalert -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Select2 -->
    <link rel="stylesheet" href="<?= base_url(); ?>src/select2/css/select2.min.css">
    <script type="text/javascript" src="<?= base_url(); ?>src/select2/js/select2.min.js"></script>
    <!-- Custom Theme Scripts (sidebar toggle, dll) -->
    <script src="<?= base_url(); ?>src/build/js/custom.min.js"></script>

    <script>
        $(document).ready(function() {
            // =============================================
            // INITIALIZE DATATABLE SERVER SIDE (ra_csd LEFT JOIN out_list)
            // =============================================
            var table = $('#csd_actual_table').DataTable({
                processing: true,
                serverSide: true,
                scrollX: true,
                order: [], // Kosong agar sort default CASE WHEN MySQL ditaruh paling atas
                ajax: {
                    url: '<?= base_url("outgoinghlp/getData_csd_actual") ?>',
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

            // Auto-fill No Sticker dari No Segel saat penulisan
            $("#no_segel").on('keyup', function() {
                $('#no_sticker').val($(this).val() + ' ');
            });

            // =============================================
            // ACTION: BUAT CSD BARU (INSERT)
            // =============================================
            $(document).on('click', '.btn-buat', function() {
                var smu_uid = $(this).data('smu-uid');

                Swal.fire({
                    title: 'Memuat data...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                $.get('<?= base_url('outgoinghlp/get_smu_detail_for_csd') ?>/' + smu_uid, function(data) {
                    Swal.close();

                    // Bersihkan & Set hidden values
                    $('#uid_csd').val('');
                    $('#smu_uid').val(data.smu_uid_val);

                    // Isi data SMU
                    $('#t_smu').val(data.smu);

                    // Sembunyikan Input No CSD (Karena di-generate oleh sistem saat simpan)
                    $('#group_no_csd').hide();
                    $('#no_csd').val('');

                    // Reset CSD & Logistik
                    $('#t_status_keamanan').val('');
                    $('#t_methode_pemeriksaan').val('');
                    $('#t_methode_pemeriksaan_opsional').val('');
                    $('#t_alasan').val('1'); // Default select CLEAR (1)
                    $('#no_segel').val('');
                    $('#no_sticker').val('');

                    // Reset Select2
                    $('.select2-avsec, .select2-driver, .select2-truck').val(null).trigger('change');

                    $('#myModalLabel').text('Buat CSD Baru');
                    $('#tambahCustomer').modal('show');
                });
            });

            // =============================================
            // ACTION: EDIT CSD (UPDATE)
            // =============================================
            $(document).on('click', '.btn-edit', function() {
                var uid = $(this).data('uid'); // CSD UID

                console.log('Edit CSD UID:', uid); // Debugging: Log UID to console
                Swal.fire({
                    title: 'Memuat data...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                $.get('<?= base_url('outgoinghlp/edit_csd_actual') ?>/' + uid, function(data) {
                    Swal.close();

                    // Set hidden values
                    $('#uid_csd').val(data.csd_uid);
                    $('#smu_uid').val(data.smu_uid_val);

                    // Tampilkan No CSD (Readonly)
                    $('#group_no_csd').show();
                    $('#no_csd').val(data.no_csd);

                    // Isi data SMU
                    $('#t_smu').val(data.smu);

                    // Isi data CSD & Logistik
                    $('#t_status_keamanan').val(data.status_keamanan);
                    $('#t_methode_pemeriksaan').val(data.methode_pemeriksaan);
                    $('#t_methode_pemeriksaan_opsional').val(data.methode_pemeriksaan_opsional);
                    $('#t_alasan').val(data.alasan || '1'); // Set value Alasan dari data database atau default 1
                    $('#no_segel').val(data.no_segel);
                    $('#no_sticker').val(data.no_sticker);

                    // Reset & Set Select2
                    $('.select2-avsec, .select2-driver, .select2-truck').val(null).trigger('change');

                    if (data.avsec_uid) {
                        $('.select2-avsec').append(new Option(data.avsec_nama, data.avsec_uid, true, true)).trigger('change');
                    }
                    if (data.driver_uid) {
                        $('.select2-driver').append(new Option(data.driver_nama, data.driver_uid, true, true)).trigger('change');
                    }
                    if (data.truck_uid) {
                        $('.select2-truck').append(new Option(data.truck_no_polisi, data.truck_uid, true, true)).trigger('change');
                    }

                    $('#myModalLabel').text('Edit CSD Actual');
                    $('#tambahCustomer').modal('show');
                });
            });

            // =============================================
            // INITIALIZE SELECT2 ON MODAL
            // =============================================
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

            $('.select2-driver').select2({
                placeholder: ':: Pilih Driver',
                allowClear: true,
                dropdownParent: $('#tambahCustomer'),
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

            $('.select2-truck').select2({
                placeholder: ':: Pilih No Polisi Truck',
                allowClear: true,
                dropdownParent: $('#tambahCustomer'),
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

            $('#formCsdActual').on('submit', function(e) {
                e.preventDefault();

                var $form = $(this);
                var $btn = $form.find('button[type="submit"]');

                $.ajax({
                    url: $form.attr('action'),
                    type: 'POST',
                    data: $form.serialize(),
                    dataType: 'json',
                    beforeSend: function() {
                        $btn.prop('disabled', true);
                        Swal.fire({
                            title: 'Menyimpan...',
                            allowOutsideClick: false,
                            didOpen: () => Swal.showLoading()
                        });
                    },
                    success: function(res) {
                        if (res.success) {
                            $('#tambahCustomer').modal('hide');
                            Swal.fire({
                                icon: 'success',
                                title: res.msg || 'CSD berhasil disimpan.',
                                timer: 1500,
                                showConfirmButton: false
                            });
                            table.ajax.reload(null, false);
                        } else {
                            Swal.fire('Gagal', res.msg || 'CSD gagal disimpan.', 'error');
                        }
                    },
                    error: function(xhr) {
                        console.error(xhr.status, xhr.responseText);
                        Swal.fire('Error', 'Terjadi kesalahan pada server.', 'error');
                    },
                    complete: function() {
                        $btn.prop('disabled', false);
                    }
                });
            });
        });
    </script>
</body>

</html>