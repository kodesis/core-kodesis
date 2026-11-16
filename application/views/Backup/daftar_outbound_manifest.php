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
                                <h2>Daftar Outbound Manifest</h2>
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
                                                <th>Post Date</th>
                                                <th>Manifest Date</th>
                                                <th>Loading Date</th>
                                                <th>Fly Date</th>
                                                <th>Status</th>
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
                    url: '<?= base_url("outgoinghlp/getData_outbound_manifest") ?>',
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
        });
    </script>
    <script>
        $(document).on('click', '.btn-update', function(e) {
            e.preventDefault();

            var uid = $(this).data('uid');
            var status = $(this).data('status');
            var fotoTerpilih = null;
            var stream = null;

            Swal.fire({
                title: 'Konfirmasi Update Status',
                html: `
            <p>Apakah Anda yakin ingin memproses SMU menjadi status "${status}" ?</p>

            <div class="btn-group btn-group-sm" style="margin-bottom:10px;">
                <button type="button" class="btn btn-outline-primary active" id="tab-kamera">
                    <i class="fa fa-camera"></i> Ambil Foto
                </button>
                <button type="button" class="btn btn-outline-primary" id="tab-file">
                    <i class="fa fa-upload"></i> Pilih File
                </button>
            </div>

            <div id="area-kamera">
                <video id="cam-video" autoplay playsinline
                       style="width:60%; border-radius:6px; background:#000;"></video>
                <button type="button" class="btn btn-sm btn-dark btn-block" id="btn-jepret"
                        style="margin-top:8px;">
                    <i class="fa fa-circle"></i> Jepret
                </button>
                <p id="cam-error" style="color:#d33; font-size:13px; display:none; margin-top:8px;"></p>
            </div>

            <div id="area-file" style="display:none;">
                <input type="file" id="swal-foto" accept="image/*" class="form-control">
            </div>

            <div id="area-preview" style="display:none; margin-top:10px;">
                <img id="swal-preview" style="max-width:60%; border-radius:6px;">
                <br>
                <button type="button" class="btn btn-sm btn-link" id="btn-ulang">Ambil ulang</button>
            </div>
        `,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Update Status!',
                cancelButtonText: 'Batal',
                width: 480,

                didOpen: function() {
                    var video = document.getElementById('cam-video');

                    function bukaKamera() {
                        if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
                            return gagalKamera('Browser tidak mendukung kamera. Gunakan Pilih File.');
                        }
                        navigator.mediaDevices.getUserMedia({
                            video: {
                                facingMode: 'environment'
                            }
                        }).then(function(s) {
                            stream = s;
                            video.srcObject = s;
                        }).catch(function() {
                            gagalKamera('Kamera tidak dapat diakses. Gunakan Pilih File.');
                        });
                    }

                    function gagalKamera(pesan) {
                        $('#cam-error').text(pesan).show();
                        $('#cam-video, #btn-jepret').hide();
                    }

                    function tutupKamera() {
                        if (stream) {
                            stream.getTracks().forEach(function(t) {
                                t.stop();
                            });
                            stream = null;
                        }
                    }

                    function tampilPreview(file) {
                        fotoTerpilih = file;
                        $('#swal-preview').attr('src', URL.createObjectURL(file));
                        $('#area-preview').show();
                        $('#area-kamera, #area-file').hide();
                        tutupKamera();
                    }

                    bukaKamera();

                    $('#tab-kamera').on('click', function() {
                        $(this).addClass('active');
                        $('#tab-file').removeClass('active');
                        $('#area-file, #area-preview').hide();
                        $('#area-kamera').show();
                        $('#cam-error').hide();
                        $('#cam-video, #btn-jepret').show();
                        fotoTerpilih = null;
                        bukaKamera();
                    });

                    $('#tab-file').on('click', function() {
                        $(this).addClass('active');
                        $('#tab-kamera').removeClass('active');
                        $('#area-kamera, #area-preview').hide();
                        $('#area-file').show();
                        fotoTerpilih = null;
                        tutupKamera();
                    });

                    $('#btn-jepret').on('click', function() {
                        if (!stream) return;
                        var canvas = document.createElement('canvas');
                        canvas.width = video.videoWidth;
                        canvas.height = video.videoHeight;
                        canvas.getContext('2d').drawImage(video, 0, 0);
                        canvas.toBlob(function(blob) {
                            tampilPreview(new File([blob], 'kamera.jpg', {
                                type: 'image/jpeg'
                            }));
                        }, 'image/jpeg', 0.85);
                    });

                    $('#swal-foto').on('change', function() {
                        if (this.files[0]) tampilPreview(this.files[0]);
                    });

                    $('#btn-ulang').on('click', function() {
                        fotoTerpilih = null;
                        $('#area-preview').hide();
                        $('#swal-foto').val('');
                        $('#tab-kamera').trigger('click');
                    });
                },

                willClose: function() {
                    if (stream) stream.getTracks().forEach(function(t) {
                        t.stop();
                    });
                },

                preConfirm: function() {
                    if (!fotoTerpilih) {
                        Swal.showValidationMessage('Foto bukti wajib diambil atau diunggah');
                        return false;
                    }
                    if (fotoTerpilih.size > 5 * 1024 * 1024) {
                        Swal.showValidationMessage('Ukuran foto maksimal 5 MB');
                        return false;
                    }
                    return fotoTerpilih;
                }

            }).then(function(result) {
                if (!result.isConfirmed) return;

                var fd = new FormData();
                fd.append('uid', uid);
                fd.append('status', status);
                fd.append('foto', result.value, result.value.name);

                Swal.fire({
                    title: 'Mengunggah...',
                    allowOutsideClick: false,
                    didOpen: function() {
                        Swal.showLoading();
                    }
                });

                $.ajax({
                    url: '<?= base_url() ?>outgoinghlp/store_outbound_manifest',
                    type: 'POST',
                    data: fd,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    success: function(res) {
                        if (res.status) {
                            Swal.fire('Berhasil', res.message, 'success').then(function() {
                                location.reload();
                            });
                        } else {
                            Swal.fire('Gagal', res.message, 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Gagal', 'Terjadi kesalahan pada server.', 'error');
                    }
                });
            });
        });
    </script>

</body>

</html>