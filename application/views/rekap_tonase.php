<?php
$tahun_now  = date('Y');
$bulan_nama = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" href="<?= $this->session->userdata('icon') ?>" type="image/ico" />
    <title><?= $this->session->userdata('nama_singkat') ?> | Rekap Tonase</title>
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
    <!-- DataTables -->
    <link href="<?= base_url(); ?>src/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <!-- Select2 -->
    <link rel="stylesheet" href="<?= base_url(); ?>src/select2/css/select2.min.css">

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
        }

        .select2-container .select2-selection--single {
            height: 30px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 30px;
            color: #555;
            padding-left: 10px;
            font-size: 12px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 30px;
        }

        .select2-container {
            width: 100% !important;
        }

        /* ===== Rekap Tonase ===== */
        .rt-filter .form-group {
            margin-bottom: 10px;
        }

        .rt-filter label {
            font-size: 12px;
            margin-bottom: 3px;
        }

        .tile_count .tile_stats_count .count {
            font-size: 28px;
        }

        #tbl-rekap tbody tr.rt-row {
            cursor: pointer;
        }

        #tbl-rekap tbody tr.rt-row:hover td {
            background: #eef5f9;
        }

        .rt-num {
            text-align: right;
            white-space: nowrap;
        }

        .rt-empty {
            color: #aab2bd;
            font-style: italic;
        }

        #tbl-rekap tfoot th,
        #tbl-detail tfoot th {
            background: #f5f7fa;
        }

        #modal-detail .modal-dialog {
            width: 95%;
            max-width: 1400px;
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
                                <h2>Rekap Tonase</h2>
                                <ul class="nav navbar-right panel_toolbox">
                                    <li>
                                        <a href="<?= base_url('outgoinghlp/daftar_kemasan_smu') ?>" class="btn btn-default btn-sm" style="color:#5A738E;">
                                            <i class="fa fa-arrow-left"></i> Daftar Kemasan SMU
                                        </a>
                                    </li>
                                </ul>
                                <div class="clearfix"></div>
                            </div>

                            <div class="x_content">

                                <!-- ===== Filter ===== -->
                                <form id="form-filter" class="rt-filter" onsubmit="return false;">
                                    <div class="row">
                                        <div class="col-md-2 col-sm-4 col-xs-6 form-group">
                                            <label>Tahun</label>
                                            <select name="tahun" class="form-control input-sm">
                                                <option value="">Semua tahun</option>
                                                <?php foreach ($tahun_list as $t) : ?>
                                                    <option value="<?= $t->tahun ?>" <?= $t->tahun == $tahun_now ? 'selected' : '' ?>><?= $t->tahun ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="col-md-2 col-sm-4 col-xs-6 form-group">
                                            <label>Bulan</label>
                                            <select name="bulan" class="form-control input-sm">
                                                <option value="">Semua bulan</option>
                                                <?php foreach ($bulan_nama as $i => $b) : ?>
                                                    <option value="<?= $i + 1 ?>"><?= $b ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="col-md-2 col-sm-4 col-xs-6 form-group">
                                            <label>Dari tanggal</label>
                                            <input type="date" name="dari" class="form-control input-sm">
                                        </div>
                                        <div class="col-md-2 col-sm-4 col-xs-6 form-group">
                                            <label>Sampai tanggal</label>
                                            <input type="date" name="sampai" class="form-control input-sm">
                                        </div>
                                        <div class="col-md-2 col-sm-4 col-xs-6 form-group">
                                            <label>Pesawat</label>
                                            <select name="pesawat" id="f_pesawat" class="form-control input-sm">
                                                <option value="">Semua pesawat</option>
                                                <?php foreach ($pesawat_list as $p) : ?>
                                                    <option value="<?= html_escape($p->nama) ?>"><?= html_escape($p->nama) ?><?= !empty($p->prefix) ? ' - ' . html_escape($p->prefix) : '' ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="col-md-2 col-sm-4 col-xs-6 form-group">
                                            <label>Agent</label>
                                            <select name="agent" id="f_agent" class="form-control input-sm">
                                                <option value="">Semua agent</option>
                                                <?php foreach ($agent_list as $a) : ?>
                                                    <option value="<?= $a->uid ?>"><?= html_escape($a->nama) ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-2 col-sm-4 col-xs-6 form-group">
                                            <label>Rekap per</label>
                                            <select name="per" class="form-control input-sm">
                                                <option value="bulan">Bulan</option>
                                                <option value="hari">Hari</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3 col-sm-4 col-xs-6 form-group">
                                            <label>Pisahkan berdasarkan</label>
                                            <select name="group" class="form-control input-sm">
                                                <option value="none">Tidak dipisah</option>
                                                <option value="pesawat">Pesawat</option>
                                                <option value="agent">Agent</option>
                                                <option value="both">Pesawat dan agent</option>
                                            </select>
                                        </div>
                                        <div class="col-md-5 col-sm-4 col-xs-12 form-group">
                                            <label class="hidden-xs">&nbsp;</label>
                                            <div>
                                                <button type="button" id="btn-tampil" class="btn btn-primary btn-sm"><i class="fa fa-search"></i> Tampilkan</button>
                                                <button type="button" id="btn-reset" class="btn btn-default btn-sm"><i class="fa fa-refresh"></i> Reset</button>
                                                <button type="button" id="btn-export" class="btn btn-success btn-sm"><i class="fa fa-file-excel-o"></i> Export Excel</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                                <!-- ===== Ringkasan ===== -->
                                <div class="row tile_count" style="margin-top:5px;">
                                    <div class="col-md-3 col-sm-4 col-xs-6 tile_stats_count">
                                        <span class="count_top"><i class="fa fa-balance-scale"></i> Total tonase</span>
                                        <div class="count green" id="sum-ton">0</div>
                                        <span class="count_bottom">ton (dari berat gross)</span>
                                    </div>
                                    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                                        <span class="count_top"><i class="fa fa-cube"></i> Gross</span>
                                        <div class="count" id="sum-gross">0</div>
                                        <span class="count_bottom">kg</span>
                                    </div>
                                    <div class="col-md-3 col-sm-4 col-xs-6 tile_stats_count">
                                        <span class="count_top"><i class="fa fa-money"></i> Chargeable</span>
                                        <div class="count" id="sum-charge">0</div>
                                        <span class="count_bottom">kg</span>
                                    </div>
                                    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                                        <span class="count_top"><i class="fa fa-cubes"></i> Koli</span>
                                        <div class="count" id="sum-koli">0</div>
                                        <span class="count_bottom">pieces</span>
                                    </div>
                                    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                                        <span class="count_top"><i class="fa fa-file-text-o"></i> SMU</span>
                                        <div class="count" id="sum-smu">0</div>
                                        <span class="count_bottom">dokumen</span>
                                    </div>
                                </div>

                                <!-- ===== Tabel rekap ===== -->
                                <div class="table-responsive">
                                    <table id="tbl-rekap" class="table table-striped table-bordered" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th id="th-periode">Bulan</th>
                                                <th class="col-pesawat">Pesawat</th>
                                                <th class="col-agent">Agent</th>
                                                <th class="rt-num">SMU</th>
                                                <th class="rt-num">Pieces</th>
                                                <th class="rt-num">Gross (kg)</th>
                                                <th class="rt-num">Volume</th>
                                                <th class="rt-num">Chargeable (kg)</th>
                                                <th class="rt-num">Tonase (ton)</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                        <tfoot></tfoot>
                                    </table>
                                </div>
                                <h6>* klik baris untuk melihat daftar SMU di periode tersebut</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Finish content-->
        </div>

        <!-- ===== Modal detail ===== -->
        <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modal-detail">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="detail-title">Detail tonase</h4>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table id="tbl-detail" class="table table-striped table-bordered table-condensed" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kategori SMU</th>
                                        <th>SMU</th>
                                        <th>Tgl Masuk</th>
                                        <th>Tgl Terbang</th>
                                        <th>Tujuan</th>
                                        <th>Pesawat</th>
                                        <th>No. Pesawat</th>
                                        <th>Agent</th>
                                        <th>Pengirim</th>
                                        <th>Komoditi</th>
                                        <th>Jaster</th>
                                        <th class="rt-num">Pieces</th>
                                        <th class="rt-num">Gross (kg)</th>
                                        <th class="rt-num">Volume</th>
                                        <th class="rt-num">Chargeable (kg)</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                                <tfoot></tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                        <button type="button" id="btn-export-detail" class="btn btn-success"><i class="fa fa-file-excel-o"></i> Export Excel</button>
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
    <script type="text/javascript" src="<?= base_url(); ?>src/select2/js/select2.min.js"></script>
    <!-- Custom Theme Scripts -->
    <script src="<?= base_url(); ?>src/build/js/custom.min.js"></script>
    <!-- DataTables JS -->
    <script src="<?= base_url(); ?>src/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="<?= base_url(); ?>src/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

    <script>
        $(document).ready(function() {
            var URL_REKAP = "<?= base_url('outgoinghlp/getRekap_tonase') ?>";
            var URL_DETAIL = "<?= base_url('outgoinghlp/getDetail_tonase') ?>";
            var TAHUN_NOW = "<?= $tahun_now ?>";
            var BULAN = <?= json_encode($bulan_nama) ?>;
            // Warna pesawat dari out_pesawat, sama seperti badge SMU di Daftar Kemasan SMU
            var PESAWAT_WARNA = <?php
                                $warna_map = [];
                                foreach ($pesawat_list as $p) {
                                    if (!empty($p->warna)) $warna_map[$p->nama] = $p->warna;
                                }
                                echo json_encode((object) $warna_map);
                                ?>;

            var DT_LANG = {
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
            };

            // ================= HELPER =================
            function num(v) {
                var n = parseFloat(String(v === null || v === undefined ? '' : v).replace(',', '.'));
                return isNaN(n) ? 0 : n;
            }

            function fmt(v, d) {
                d = (d === undefined) ? 2 : d;
                return num(v).toLocaleString('id-ID', {
                    minimumFractionDigits: d,
                    maximumFractionDigits: d
                });
            }

            function esc(s) {
                return $('<div>').text(s === null || s === undefined ? '' : s).html();
            }

            function labelPeriode(p) {
                var b = BULAN[parseInt(p.substr(4, 2), 10) - 1] || p.substr(4, 2);
                return p.length === 8 ? p.substr(6, 2) + ' ' + b + ' ' + p.substr(0, 4) : b + ' ' + p.substr(0, 4);
            }

            function labelTanggal(s) { // YmdHis -> dd-mm-yyyy HH:ii (sama seperti Post Date di daftar SMU)
                s = String(s || '');
                if (s.length < 8) return s;
                var t = s.substr(6, 2) + '-' + s.substr(4, 2) + '-' + s.substr(0, 4);
                if (s.length >= 12) t += ' ' + s.substr(8, 2) + ':' + s.substr(10, 2);
                return t;
            }

            function labelTglTerbang(s) { // Y-m-d -> dd-mm-yyyy
                s = String(s || '');
                var m = s.match(/^(\d{4})-(\d{2})-(\d{2})/);
                return m ? m[3] + '-' + m[2] + '-' + m[1] : esc(s);
            }

            // Badge berwarna sesuai pesawat, format sama dengan kolom SMU di Daftar Kemasan SMU
            function colorBadge(text, pesawat) {
                var w = PESAWAT_WARNA[pesawat];
                if (w) {
                    return '<span class="btn btn-sm" style="color:#fff; border:1px solid #fff; background-color:#' + esc(w) + '; cursor:inherit;">' + esc(text) + '</span>';
                }
                return '<span class="btn btn-sm" style="color:#73879C; cursor:inherit;">' + esc(text) + '</span>';
            }

            function pesawatLabel(v) {
                return v ? colorBadge(v, v) : '<span class="rt-empty">Tanpa pesawat</span>';
            }

            function kategoriLabel(c) {
                if (c == '1') return 'Langsung';
                if (c == '2') return 'Transhipment';
                if (c == '3') return 'Terminal change(w/o inv)';
                if (c == '4') return 'Via RA LJA';
                if (c == '5') return 'Langsung(AAP)';
                return 'Belum Dipilih';
            }

            function jasterBadge(j) {
                return j == '1' ?
                    '<span class="btn btn-sm" style="color:#5cb85c; border:1px solid #5cb85c; background:transparent; cursor:default;">Jaster</span>' :
                    '<span class="btn btn-sm" style="color:#d9534f; border:1px solid #d9534f; background:transparent; cursor:default;">No Jaster</span>';
            }

            function agentLabel(uid, nama) {
                return (parseInt(uid, 10) && nama) ? esc(nama) : '<span class="rt-empty">Tanpa agent</span>';
            }

            // ================= SELECT2 FILTER =================
            $('#f_pesawat').select2({
                placeholder: 'Semua pesawat',
                allowClear: true
            });
            $('#f_agent').select2({
                placeholder: 'Semua agent',
                allowClear: true
            });

            var lastFilter = {};
            var silent = false;

            function getFilter() {
                var d = {};
                $.each($('#form-filter').serializeArray(), function(_, x) {
                    d[x.name] = x.value;
                });
                return d;
            }

            // ================= REKAP =================
            function loadRekap() {
                lastFilter = getFilter();
                var g = lastFilter.group;
                var showP = (g === 'pesawat' || g === 'both');
                var showA = (g === 'agent' || g === 'both');
                var nCol = 7 + (showP ? 1 : 0) + (showA ? 1 : 0);

                $('#tbl-rekap .col-pesawat').toggle(showP);
                $('#tbl-rekap .col-agent').toggle(showA);
                $('#th-periode').text(lastFilter.per === 'hari' ? 'Tanggal' : 'Bulan');

                var $tb = $('#tbl-rekap tbody').html('<tr><td colspan="' + nCol + '" class="text-center"><i class="fa fa-spinner fa-spin"></i> Memuat data...</td></tr>');
                $('#tbl-rekap tfoot').empty();
                NProgress.start();

                $.post(URL_REKAP, lastFilter, function(res) {
                    $tb.empty();
                    var rows = res.rows || [];
                    var tot = {
                        smu: 0,
                        koli: 0,
                        gross: 0,
                        vol: 0,
                        charge: 0
                    };

                    if (!rows.length) {
                        $tb.html('<tr><td colspan="' + nCol + '" class="text-center rt-empty">Tidak ada data untuk filter ini. Coba ubah tahun atau rentang tanggal.</td></tr>');
                    }

                    $.each(rows, function(_, r) {
                        tot.smu += num(r.jml_smu);
                        tot.koli += num(r.total_koli);
                        tot.gross += num(r.total_gross);
                        tot.vol += num(r.total_volume);
                        tot.charge += num(r.total_chargeable);

                        var key = {
                            periode: r.periode
                        };
                        if (showP) key.pesawat = r.pesawat || '';
                        if (showA) key.agent = r.agent_uid || 0;

                        var label = {
                            periode: labelPeriode(r.periode),
                            pesawat: showP ? (r.pesawat || 'Tanpa pesawat') : null,
                            agent: showA ? ((parseInt(r.agent_uid, 10) && r.nama_agent) ? r.nama_agent : 'Tanpa agent') : null
                        };

                        var $tr = $('<tr class="rt-row">').data('key', key).data('label', label);
                        $tr.append('<td><b>' + labelPeriode(r.periode) + '</b></td>');
                        if (showP) $tr.append('<td>' + pesawatLabel(r.pesawat) + '</td>');
                        if (showA) $tr.append('<td>' + agentLabel(r.agent_uid, r.nama_agent) + '</td>');
                        $tr.append(
                            '<td class="rt-num">' + fmt(r.jml_smu, 0) + '</td>' +
                            '<td class="rt-num">' + fmt(r.total_koli, 0) + '</td>' +
                            '<td class="rt-num">' + fmt(r.total_gross) + '</td>' +
                            '<td class="rt-num">' + fmt(r.total_volume) + '</td>' +
                            '<td class="rt-num">' + fmt(r.total_chargeable) + '</td>' +
                            '<td class="rt-num"><span class="label label-success" style="font-size:12px;">' + fmt(num(r.total_gross) / 1000, 3) + '</span></td>'
                        );
                        $tb.append($tr);
                    });

                    var span = 1 + (showP ? 1 : 0) + (showA ? 1 : 0);
                    if (rows.length) {
                        $('#tbl-rekap tfoot').html(
                            '<tr>' +
                            '<th colspan="' + span + '">Total</th>' +
                            '<th class="rt-num">' + fmt(tot.smu, 0) + '</th>' +
                            '<th class="rt-num">' + fmt(tot.koli, 0) + '</th>' +
                            '<th class="rt-num">' + fmt(tot.gross) + '</th>' +
                            '<th class="rt-num">' + fmt(tot.vol) + '</th>' +
                            '<th class="rt-num">' + fmt(tot.charge) + '</th>' +
                            '<th class="rt-num">' + fmt(tot.gross / 1000, 3) + '</th>' +
                            '</tr>'
                        );
                    }

                    $('#sum-ton').text(fmt(tot.gross / 1000, 3));
                    $('#sum-gross').text(fmt(tot.gross, 0));
                    $('#sum-charge').text(fmt(tot.charge, 0));
                    $('#sum-koli').text(fmt(tot.koli, 0));
                    $('#sum-smu').text(fmt(tot.smu, 0));
                }, 'json').fail(function() {
                    $tb.html('<tr><td colspan="' + nCol + '" class="text-center text-danger">Gagal memuat rekap. Periksa koneksi atau log server, lalu klik Tampilkan lagi.</td></tr>');
                }).always(function() {
                    NProgress.done();
                });
            }

            // ================= DETAIL =================
            $('#tbl-rekap tbody').on('click', 'tr.rt-row', function() {
                var key = $(this).data('key');
                var lbl = $(this).data('label');

                var post = $.extend({}, lastFilter, {
                    periode: key.periode
                });
                if (key.hasOwnProperty('pesawat')) post.pesawat_key = key.pesawat;
                if (key.hasOwnProperty('agent')) post.agent_key = key.agent;
                lastDetailPost = post;

                var judul = ['Detail Tonase', lbl.periode, lbl.pesawat, lbl.agent].filter(Boolean).join(' - ');
                $('#detail-title').text(judul);

                if ($.fn.DataTable.isDataTable('#tbl-detail')) {
                    $('#tbl-detail').DataTable().destroy();
                }
                $('#tbl-detail tbody').html('<tr><td colspan="16" class="text-center"><i class="fa fa-spinner fa-spin"></i> Memuat data...</td></tr>');
                $('#tbl-detail tfoot').empty();
                $('#modal-detail').modal('show');

                $.post(URL_DETAIL, post, function(res) {
                    if (res.status !== 'ok') {
                        $('#tbl-detail tbody').html('<tr><td colspan="16" class="text-center text-danger">' + esc(res.message || 'Gagal memuat detail.') + '</td></tr>');
                        return;
                    }

                    var rows = res.rows || [];
                    var tot = {
                        koli: 0,
                        gross: 0,
                        vol: 0,
                        charge: 0
                    };
                    var html = '';

                    $.each(rows, function(i, r) {
                        tot.koli += num(r.jumlah);
                        tot.gross += num(r.gross);
                        tot.vol += num(r.volume);
                        tot.charge += num(r.chargeable);

                        html += '<tr>' +
                            '<td>' + (i + 1) + '</td>' +
                            '<td>' + kategoriLabel(r.catg_smu) + '</td>' +
                            '<td>' + colorBadge(r.smu, r.pesawat) + '</td>' +
                            '<td>' + labelTanggal(r.in_date) + '</td>' +
                            '<td>' + labelTglTerbang(r.tanggal_terbang) + '</td>' +
                            '<td>' + esc(r.tujuan) + '</td>' +
                            '<td>' + esc(r.pesawat) + '</td>' +
                            '<td>' + esc(r.no_pesawat) + '</td>' +
                            '<td>' + esc(r.nama_agent) + '</td>' +
                            '<td>' + esc(r.nama_pengirim) + '</td>' +
                            '<td>' + esc(r.komoditi) + '</td>' +
                            '<td>' + jasterBadge(r.jaster) + '</td>' +
                            '<td class="rt-num">' + fmt(r.jumlah, 0) + '</td>' +
                            '<td class="rt-num">' + fmt(r.gross) + '</td>' +
                            '<td class="rt-num">' + fmt(r.volume) + '</td>' +
                            '<td class="rt-num">' + fmt(r.chargeable) + '</td>' +
                            '</tr>';
                    });

                    $('#tbl-detail tbody').html(html);
                    $('#tbl-detail tfoot').html(
                        '<tr>' +
                        '<th colspan="12">Total ' + rows.length + ' SMU &nbsp;|&nbsp; ' + fmt(tot.gross / 1000, 3) + ' ton</th>' +
                        '<th class="rt-num">' + fmt(tot.koli, 0) + '</th>' +
                        '<th class="rt-num">' + fmt(tot.gross) + '</th>' +
                        '<th class="rt-num">' + fmt(tot.vol) + '</th>' +
                        '<th class="rt-num">' + fmt(tot.charge) + '</th>' +
                        '</tr>'
                    );

                    $('#tbl-detail').DataTable({
                        pageLength: 25,
                        order: [
                            [0, 'asc']
                        ],
                        language: DT_LANG
                    });
                }, 'json').fail(function() {
                    $('#tbl-detail tbody').html('<tr><td colspan="16" class="text-center text-danger">Gagal memuat detail. Coba klik baris lagi.</td></tr>');
                });
            });

            // ================= EXPORT =================
            var URL_EXPORT = "<?= base_url('outgoinghlp/export_rekap_tonase') ?>";
            var lastDetailPost = null;

            // Kirim filter via form POST tersembunyi supaya browser langsung mengunduh file
            function submitExport(data) {
                var $f = $('<form method="POST" style="display:none;">').attr('action', URL_EXPORT);
                $.each(data, function(k, v) {
                    $('<input type="hidden">').attr('name', k).val(v).appendTo($f);
                });
                $f.appendTo('body').submit();
                setTimeout(function() {
                    $f.remove();
                }, 1000);
            }

            // Export semua sesuai filter yang sedang tampil
            $('#btn-export').on('click', function() {
                submitExport(getFilter());
            });

            // Export hanya baris yang sedang dibuka di modal
            $('#btn-export-detail').on('click', function() {
                if (lastDetailPost) submitExport(lastDetailPost);
            });

            // ================= EVENT =================
            $('#btn-tampil').on('click', loadRekap);

            $('#form-filter').on('change', 'select, input', function() {
                if (!silent) loadRekap();
            });

            $('#btn-reset').on('click', function() {
                silent = true;
                $('#form-filter')[0].reset();
                $('#form-filter [name=tahun]').val(TAHUN_NOW);
                $('#f_pesawat, #f_agent').val('').trigger('change');
                silent = false;
                loadRekap();
            });

            loadRekap();
        });
    </script>

</body>

</html>