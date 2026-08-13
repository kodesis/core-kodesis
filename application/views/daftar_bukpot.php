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
                                <h2>Daftar Bukti Potong</h2>
                                <!-- <ul class="nav navbar-right panel_toolbox">
                                    <li>
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalRekap">
                                            Rekap Bukti Potong
                                        </button>
                                    </li>
                                </ul> -->
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-4">
                                    <select id="f_agent" class="form-control select2-agent">
                                        <option value="">:: Semua Agent</option>
                                    </select>
                                </div>
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
                                                <th>Agent</th>
                                                <th>Pengirim</th>
                                                <th>Total PPH</th>
                                                <th>Total Setelah PPH</th>
                                                <th>Bukti Potong</th>
                                                <th>Tanggal</th>
                                                <th>Jaster</th>
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

        <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modalDetailInvoice">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Detail Bukti Potong <span id="inv_no"></span></h4>
                    </div>
                    <form class="form-horizontal form-label-left" method="POST" action="<?= base_url('outgoinghlp/update_bukti_potong') ?>">
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
                                                <th>Sewa Gudang</th>
                                                <th>Total PPH</th>
                                                <th>Total Setelah PPH</th>
                                                <th>Agent</th>
                                                <th>Pengirim</th>
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
                                                <td class="text-right" id="inv_total_pph"></td>
                                                <td class="text-right" id="inv_total_setelah_pph"></td>
                                                <td class="text-right" id="inv_agent"></td>
                                                <td class="text-right" id="inv_pengirim"></td>
                                                <td></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>

                            <div class="row">


                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Bukti Potong</label>
                                        <input type="text" class="form-control" name="bukti_potong" id="inv_bukti_potong">
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
                            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                            <!-- <button type="submit" class="btn btn-success">Simpan</button> -->
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
            // DATATABLE
            // =============================================
            $('#kemasan_table').DataTable({
                processing: true,
                serverSide: true,
                scrollX: true,
                order: [
                    // [0, 'desc']
                ],
                ajax: {
                    url: '<?= base_url("outgoinghlp/getData_bukti_potong") ?>',
                    type: 'POST',
                    data: function(d) {
                        d.f_agent = $('#f_agent').val();
                        d.f_pay = $('#f_pay').val();
                        d.f_jurnal = $('#f_jurnal').val();
                    }
                },
                columnDefs: [{
                        orderable: false,
                        targets: [-1]
                    },
                    {
                        visible: false,
                        targets: 0
                    } // sembunyikan kolom uid
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

            $('#f_agent').on('change', function() {
                $('#kemasan_table').DataTable().ajax.reload();
            });

            // Buka modal saat click row datatable
            $('#kemasan_table tbody').on('click', 'tr', function(e) {
                if ($(e.target).closest('button, a').length) return;

                var uid = $(this).data('uid');
                if (!uid) return;

                $.ajax({
                    url: '<?= base_url('outgoinghlp/get_detail_bukti_potong') ?>/' + uid,
                    type: 'GET',
                    dataType: 'json',
                    success: function(res) {
                        var r = res.billing;

                        $('#inv_bil_uid').val(r.uid);

                        // Billing totals
                        $('#inv_bukti_potong').text(r.bukti_potong);

                        // List SMU
                        var html = '';
                        if (res.list.length === 0) {
                            html = '<tr><td colspan="7" class="text-center">Tidak ada data</td></tr>';
                        } else {
                            $.each(res.list, function(i, s) {
                                html += '<tr>';
                                html += '<td>' + (i + 1) + '</td>';
                                html += '<td>' + s.smu + '</td>';
                                html += '<td class="text-right">' + r.grand_total_k + '</td>';
                                html += '<td class="text-right">' + r.total_pph + '</td>';
                                html += '<td class="text-right">' + r.total_setelah_pph + '</td>';
                                html += '<td class="text-right">' + s.nama_agent + '</td>';
                                html += '<td class="text-right">' + s.nama_pengirim + '</td>';
                                html += '</tr>';
                            });
                        }
                        $('#bodyListSMU').html(html);

                        $('#modalDetailInvoice').modal('show');
                    }
                });
            });


            $(document).on('click', '.btn-status-inv', function() {
                var val = $(this).data('val');
                var $form = $(this).closest('form');


                var kosong = [];

                if (!$('#inv_bukti_potong').val()) kosong.push('Bukti Potong');

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


            $(document).on('input', '#inv_bukti_potong', function() {
                $(this).closest('.form-group').toggleClass('has-error', !$(this).val().trim());
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
        });
    </script>
</body>

</html>