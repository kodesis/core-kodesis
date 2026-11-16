<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" href="<?= $this->session->userdata('icon') ?>" type="image/ico" />
    <title><?= $this->session->userdata('nama_singkat') ?> | <?= html_escape($title) ?></title>
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
                                <?php
                                // Nama akun COA untuk tampilan: no => "no - nama perkiraan"
                                $coa_options = isset($coa_options) && is_array($coa_options) ? $coa_options : [];
                                $bisa_tambah = $cfg['bisa_tambah'] ?? true;
                                ?>
                                <h2><?= html_escape($cfg['judul']) ?></h2>
                                <?php if ($bisa_tambah) { ?>
                                    <ul class="nav navbar-right panel_toolbox">
                                        <li>
                                            <button type="button" class="btn btn-primary btn-tambah">
                                                <i class="fa fa-plus"></i> <?= html_escape($cfg['label_tambah'] ?? 'Tambah') ?>
                                            </button>
                                        </li>
                                    </ul>
                                <?php } ?>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <?php if (!empty($cfg['info'])) { ?>
                                    <div class="alert alert-info" style="color:#31708f; background:#d9edf7; border-color:#bce8f1;">
                                        <?= $cfg['info'] ?>
                                    </div>
                                <?php } ?>
                                <?php if (!empty($cfg['filter'])) { ?>
                                    <div class="form-inline" style="margin-bottom:10px;">
                                        <label style="margin-right:8px;"><?= html_escape($cfg['filter']['label']) ?></label>
                                        <select id="master_filter" class="form-control">
                                            <option value=""><?= html_escape($cfg['filter']['semua'] ?? 'Semua') ?></option>
                                            <?php foreach ($cfg['filter']['options'] as $fo) { ?>
                                                <option value="<?= html_escape($fo) ?>" <?= (($cfg['filter']['default'] ?? '') === $fo) ? 'selected' : '' ?>><?= html_escape($fo) ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                <?php } ?>
                                <div class="table-responsive">
                                    <table id="master_table" class="table table-striped table-bordered" style="width:100%">
                                        <thead>
                                            <tr>
                                                <?php foreach ($cfg['kolom'] as $k) { ?>
                                                    <th><?= html_escape($k['label']) ?></th>
                                                <?php } ?>
                                                <th>#</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($rows as $r) {
                                                $r = (array) $r; ?>
                                                <tr>
                                                    <?php foreach ($cfg['kolom'] as $k) {
                                                        $v    = $r[$k['field']] ?? '';
                                                        $tipe = $k['type'] ?? 'text'; ?>
                                                        <td>
                                                            <?php if ($tipe === 'flag') { ?>
                                                                <?php if ($v == '1') { ?>
                                                                    <span class="label label-<?= $k['warna_ya'] ?? 'success' ?>"><?= html_escape($k['ya'] ?? 'Ya') ?></span>
                                                                <?php } else { ?>
                                                                    <span class="label label-<?= $k['warna_tidak'] ?? 'default' ?>"><?= html_escape($k['tidak'] ?? 'Tidak') ?></span>
                                                                <?php } ?>
                                                            <?php } elseif ($tipe === 'color') { ?>
                                                                <?php if ($v !== '') { ?>
                                                                    <span class="btn btn-sm" style="color:#fff; background-color:#<?= html_escape(ltrim($v, '#')) ?>;">#<?= html_escape(ltrim($v, '#')) ?></span>
                                                                <?php } else { ?>-<?php } ?>
                                                            <?php } elseif ($tipe === 'map') { ?>
                                                                <?= html_escape($k['map'][(string) $v] ?? (($v === '' || $v === null) ? '-' : $v)) ?>
                                                            <?php } elseif ($tipe === 'coa') { ?>
                                                                <?= ($v === '' || $v === null) ? '<span class="text-muted">' . html_escape($k['kosong'] ?? '-') . '</span>' : html_escape($coa_options[(string) $v] ?? $v) ?>
                                                            <?php } elseif ($tipe === 'bold') { ?>
                                                                <b><?= html_escape($v) ?></b>
                                                            <?php } elseif ($tipe === 'muted') { ?>
                                                                <small class="text-muted"><?= html_escape($v) ?></small>
                                                            <?php } else { ?>
                                                                <?= ($v === '' || $v === null) ? '-' : html_escape($v) ?>
                                                            <?php } ?>
                                                        </td>
                                                    <?php } ?>
                                                    <td>
                                                        <button type="button" class="btn btn-sm btn-warning btn-edit" data-row="<?= html_escape(json_encode($r)) ?>">
                                                            <i class="fa fa-pencil"></i> Ubah
                                                        </button>
                                                    </td>
                                                </tr>
                                            <?php } ?>
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

        <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modalMaster">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modalMasterLabel">Tambah</h4>
                    </div>
                    <form class="form-horizontal form-label-left" method="POST" action="<?= base_url($cfg['store_url']) ?>">
                        <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
                        <input type="hidden" name="mode" id="f_mode" value="add">
                        <input type="hidden" name="uid" id="f_uid" value="">
                        <div class="modal-body">
                            <div class="row">
                                <?php foreach ($cfg['fields'] as $f) {
                                    $tipe = $f['type'] ?? 'text';
                                    $id   = 'f_' . $f['name'];
                                    if ($tipe === 'hidden') {
                                        echo '<input type="hidden" name="' . $f['name'] . '" id="' . $id . '">';
                                        continue;
                                    } ?>
                                    <div class="<?= $tipe === 'textarea' ? 'col-md-12' : 'col-md-6' ?> col-xs-12">
                                        <div class="form-group">
                                            <label class="form-label"><?= html_escape($f['label']) ?><?= !empty($f['required']) ? ' <span style="color:red">*</span>' : '' ?></label>
                                            <?php if ($tipe === 'select') { ?>
                                                <select class="form-control" name="<?= $f['name'] ?>" id="<?= $id ?>" data-key="<?= !empty($f['key']) ? '1' : '0' ?>" <?= !empty($f['required']) ? 'required' : '' ?>>
                                                    <?= $this->M_warehouse_ref->options($f['options']) ?>
                                                </select>
                                                <?php if (!empty($f['key'])) { ?>
                                                    <input type="hidden" name="<?= $f['name'] ?>" id="h_<?= $f['name'] ?>" disabled>
                                                <?php } ?>
                                            <?php } elseif ($tipe === 'coa') { ?>
                                                <select class="form-control pilih-coa" name="<?= $f['name'] ?>" id="<?= $id ?>" style="width:100%" <?= !empty($f['required']) ? 'required' : '' ?>>
                                                    <option value=""><?= html_escape($f['kosong'] ?? '- pilih akun -') ?></option>
                                                    <?= $this->M_warehouse_ref->options($coa_options) ?>
                                                </select>
                                            <?php } elseif ($tipe === 'tampil') { ?>
                                                <p class="form-control-static" id="<?= $id ?>" style="font-weight:bold;"></p>
                                            <?php } elseif ($tipe === 'nilai_setting') { ?>
                                                <!-- Satu isian aktif sesuai jenis pengaturan (diatur JavaScript) -->
                                                <div class="input-group ns ns-persen" style="display:none;">
                                                    <input type="number" step="any" min="0" max="100" class="form-control" name="<?= $f['name'] ?>" disabled>
                                                    <span class="input-group-addon">%</span>
                                                </div>
                                                <div class="input-group ns ns-rupiah" style="display:none;">
                                                    <span class="input-group-addon">Rp</span>
                                                    <input type="number" step="1" min="0" class="form-control" name="<?= $f['name'] ?>" disabled>
                                                </div>
                                                <input type="number" step="1" min="0" class="form-control ns ns-angka" name="<?= $f['name'] ?>" style="display:none;" disabled>
                                                <input type="text" class="form-control ns ns-teks" name="<?= $f['name'] ?>" style="display:none;" disabled>
                                                <input type="date" class="form-control ns ns-tanggal" name="<?= $f['name'] ?>" style="display:none;" disabled>
                                                <div class="ns ns-coa" style="display:none;">
                                                    <select class="form-control pilih-coa" name="<?= $f['name'] ?>" style="width:100%" disabled>
                                                        <option value="">- pilih akun -</option>
                                                        <?= $this->M_warehouse_ref->options($coa_options) ?>
                                                    </select>
                                                </div>
                                                <div class="ns ns-coa_list" style="display:none;">
                                                    <select class="form-control pilih-coa-banyak" name="<?= $f['name'] ?>[]" multiple style="width:100%" disabled>
                                                        <?= $this->M_warehouse_ref->options($coa_options) ?>
                                                    </select>
                                                </div>
                                            <?php } elseif ($tipe === 'textarea') { ?>
                                                <textarea class="form-control" rows="2" name="<?= $f['name'] ?>" id="<?= $id ?>"></textarea>
                                            <?php } else { ?>
                                                <input type="<?= $tipe ?>" class="form-control" name="<?= $f['name'] ?>" id="<?= $id ?>"
                                                    <?= isset($f['step']) ? 'step="' . $f['step'] . '"' : '' ?>
                                                    placeholder="<?= html_escape($f['placeholder'] ?? '') ?>"
                                                    data-key="<?= !empty($f['key']) ? '1' : '0' ?>"
                                                    <?= !empty($f['required']) ? 'required' : '' ?>>
                                            <?php } ?>
                                            <?php if (!empty($f['help'])) { ?>
                                                <small class="text-muted"><?= $f['help'] ?></small>
                                            <?php } ?>
                                        </div>
                                    </div>
                                <?php } ?>
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
            var FIELDS = <?= json_encode(array_map(function ($f) {
                                return ['name' => $f['name'], 'type' => $f['type'] ?? 'text', 'default' => $f['default'] ?? '', 'dari' => $f['dari'] ?? null];
                            }, $cfg['fields'])) ?>;
            var FILTER = <?= json_encode($cfg['filter'] ?? null) ?>;

            // Daftar akun yang bisa dicari (select2)
            $('.pilih-coa').select2({
                dropdownParent: $('#modalMaster'),
                width: '100%',
                placeholder: '- pilih akun -',
                allowClear: true
            });
            $('.pilih-coa-banyak').select2({
                dropdownParent: $('#modalMaster'),
                width: '100%',
                tags: true, // nomor awalan (mis. 210) boleh diketik walau bukan akun lengkap
                placeholder: 'pilih satu atau lebih akun'
            });

            // Filter per bagian / grup. Bagian "sembunyi" tidak tampil saat memilih "Semua".
            if (FILTER) {
                $.fn.dataTable.ext.search.push(function(settings, data) {
                    if (settings.nTable.id !== 'master_table') return true;
                    var pilih = $('#master_filter').val();
                    var nilai = data[FILTER.kolom];
                    if (pilih) return nilai === pilih;
                    return !FILTER.sembunyi || nilai !== FILTER.sembunyi;
                });
            }

            var tabel = $('#master_table').DataTable({
                scrollX: true,
                pageLength: 25,
                order: [],
                columnDefs: [{
                    orderable: false,
                    targets: [-1]
                }],
                language: {
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                    infoEmpty: "Tidak ada data",
                    infoFiltered: "(disaring dari _MAX_ data)",
                    zeroRecords: "Data tidak ditemukan",
                    paginate: {
                        previous: "Sebelumnya",
                        next: "Selanjutnya"
                    }
                }
            });

            $('#master_filter').on('change', function() {
                tabel.draw();
            });
            if (FILTER) tabel.draw();

            function nilaiRow(row, f) {
                var kunci = f.dari || f.name;
                return row && row[kunci] !== undefined && row[kunci] !== null ? row[kunci] : f.default;
            }

            function isiForm(row, mode) {
                $('#f_mode').val(mode);
                $('#f_uid').val(mode === 'edit' && row && row.uid ? row.uid : '');
                $.each(FIELDS, function(i, f) {
                    var el = $('#f_' + f.name);
                    var v = nilaiRow(row, f);

                    if (f.type === 'tampil') {
                        el.text(v === null || v === undefined ? '' : String(v));
                        return;
                    }
                    if (f.type === 'nilai_setting') {
                        // Tampilkan hanya isian yang sesuai jenis pengaturan
                        var jenis = (row && row.tipe) || 'teks';
                        $('.ns').hide().find(':input').addBack(':input').prop('disabled', true);
                        var box = $('.ns-' + jenis).show();
                        var input = box.is(':input') ? box : box.find(':input');
                        input.prop('disabled', false);
                        if (jenis === 'coa_list') {
                            var daftar = String(v || '').split(',').filter(function(x) { return x.trim() !== ''; });
                            daftar.forEach(function(c) {
                                if (!input.find('option[value="' + c + '"]').length) input.append(new Option(c, c));
                            });
                            input.val(daftar).trigger('change');
                        } else if (jenis === 'coa') {
                            input.val(String(v || '')).trigger('change');
                        } else {
                            input.val(String(v === null || v === undefined ? '' : v));
                        }
                        return;
                    }

                    v = String(v === null || v === undefined ? '' : v);
                    if (f.type === 'color') {
                        v = v ? '#' + v.replace(/^#/, '') : '#73879c';
                    }
                    el.val(v);
                    if (f.type === 'coa') el.trigger('change');

                    // Kolom kunci tidak boleh diubah saat ubah data
                    var kunci = mode === 'edit' && el.data('key') == 1;
                    if (el.is('select')) {
                        el.prop('disabled', kunci);
                        $('#h_' + f.name).val(v).prop('disabled', !kunci);
                    } else {
                        el.prop('readonly', kunci);
                    }
                });
                $('#modalMasterLabel').text((mode === 'edit' ? 'Ubah ' : 'Tambah ') + <?= json_encode($cfg['judul_form'] ?? $cfg['judul']) ?>);
                $('#modalMaster').modal('show');
            }

            $(document).on('click', '.btn-tambah', function() {
                isiForm(null, 'add');
            });

            $(document).on('click', '.btn-edit', function() {
                isiForm($(this).data('row'), 'edit');
            });
        });
    </script>
</body>

</html>
