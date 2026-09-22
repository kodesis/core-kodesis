<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" href="<?= $this->session->userdata('icon') ?>" type="image/ico" />
    <title><?= $this->session->userdata('nama_singkat') ?> | <?= html_escape($title) ?></title>

    <link href="<?= base_url(); ?>src/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url(); ?>src/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?= base_url(); ?>src/vendors/nprogress/nprogress.css" rel="stylesheet">
    <link href="<?= base_url(); ?>src/build/css/custom.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url(); ?>src/css/mobile_menu/header.css">
    <link rel="stylesheet" href="<?= base_url(); ?>src/css/mobile_menu/icons.css">

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

        .text-right {
            text-align: right !important;
        }

        /* Kartu akun deposit */
        .akun-card {
            display: block;
            width: 100%;
            text-align: left;
            background: #fff;
            border: 1px solid #e3e6ea;
            border-left: 4px solid #004e81;
            border-radius: 4px;
            padding: 14px 16px;
            margin-bottom: 15px;
            cursor: pointer;
        }

        .akun-card:hover {
            border-color: #004e81;
        }

        .akun-card:focus {
            outline: 2px solid #26b99a;
            outline-offset: 2px;
        }

        .akun-card.active {
            background: #f2f8fc;
            border-color: #004e81;
        }

        .akun-card .akun-nama {
            font-size: 15px;
            font-weight: 600;
            color: #333;
            margin: 0;
        }

        .akun-card .akun-kode {
            font-size: 12px;
            color: #888;
        }

        .akun-card .akun-saldo {
            font-size: 22px;
            font-weight: 700;
            color: #004e81;
            margin: 8px 0 4px;
        }

        .akun-card .akun-saldo.minus {
            color: #d9534f;
        }

        .status-safe {
            color: #1e8e3e;
            border: 1px solid #1e8e3e;
        }

        .status-limit {
            color: #c77700;
            border: 1px solid #c77700;
        }

        .status-hold {
            color: #d9534f;
            border: 1px solid #d9534f;
        }

        .status-badge {
            font-size: 11px;
            padding: 1px 8px;
            border-radius: 10px;
            display: inline-block;
        }

        .row-topup td.nominal-topup {
            color: #1e8e3e;
            font-weight: 600;
        }

        .row-usage td.nominal-usage {
            color: #d9534f;
            font-weight: 600;
        }

        .empty-state {
            padding: 30px 10px;
            text-align: center;
            color: #888;
        }
    </style>
</head>

<header class="header_area sticky-header">
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
</header>

<body class="nav-md">
    <div class="container body">
        <div class="main_container">
            <div class="col-md-3 left_col">
                <div class="left_col scroll-view">
                    <div class="navbar nav_title" style="border: 0;">
                        <a href="<?= base_url(); ?>" class="site_title">
                            <img src="<?= $this->session->userdata('icon') ?>" alt="..." width="60">
                            <span><?= $this->session->userdata('nama_singkat') ?></span>
                        </a>
                    </div>
                    <div class="clearfix"></div>

                    <div class="profile clearfix">
                        <div class="profile_pic">
                            <img src="<?= base_url(); ?>src/images/img.jpg" alt="..." class="img-circle profile_img">
                        </div>
                        <div class="profile_info">
                            <span>Welcome,</span>
                            <h2><?= html_escape($this->session->userdata('nama')); ?></h2>
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
                                    <img src="<?= base_url(); ?>src/images/img.jpg" alt=""><?= html_escape($this->session->userdata('nama')); ?>
                                    <span class=" fa fa-angle-down"></span>
                                </a>
                                <ul class="dropdown-menu dropdown-usermenu pull-right">
                                    <li><a href="<?= base_url(); ?>login/logout"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                                </ul>
                            </li>
                            <li role="presentation" class="dropdown">
                                <a href="<?= base_url() . "app/inbox"; ?>" class="dropdown-toggle info-number">
                                    <i class="fa fa-envelope-o"></i>
                                    <span class="badge <?= $count_inbox == 0 ? 'bg-green' : 'bg-red' ?>"><?= $count_inbox; ?></span>
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

                <!-- Akun deposit -->
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>Deposit Saya</h2>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <?php if (empty($akun)) : ?>
                                    <div class="empty-state">
                                        <p><i class="fa fa-folder-open-o fa-2x"></i></p>
                                        <p>Belum ada akun deposit yang terhubung dengan akun Anda.<br>
                                            Hubungi admin untuk menautkan akun deposit ke NIP Anda.</p>
                                    </div>
                                <?php else : ?>
                                    <div class="row">
                                        <?php foreach ($akun as $a) :
                                            $saldo = (float) $a->saldo;
                                            if ($a->hold == '1') {
                                                $status = ['Hold', 'status-hold'];
                                            } elseif ($saldo > 5000000) {
                                                $status = ['Safe', 'status-safe'];
                                            } else {
                                                $status = ['Limit', 'status-limit'];
                                            }
                                        ?>
                                            <div class="col-md-4 col-sm-6 col-xs-12">
                                                <button type="button" class="akun-card"
                                                    data-uid="<?= html_escape($a->uid) ?>"
                                                    data-nama="<?= html_escape($a->nama) ?>">
                                                    <p class="akun-nama"><?= html_escape($a->nama) ?></p>
                                                    <span class="akun-kode">Kode <?= html_escape($a->kode) ?>
                                                        <?= $a->telepon ? ' / ' . html_escape($a->telepon) : '' ?></span>
                                                    <div class="akun-saldo <?= $saldo < 0 ? 'minus' : '' ?>">
                                                        Rp <?= number_format($saldo, 0, ',', '.') ?>
                                                    </div>
                                                    <span class="status-badge <?= $status[1] ?>"><?= $status[0] ?></span>
                                                </button>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                    <h6>* Pilih akun untuk melihat <?= (int) $limit_riwayat ?> transaksi terakhir</h6>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Riwayat -->
                <div class="row" id="panel_riwayat" style="display:none;">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2><?= (int) $limit_riwayat ?> transaksi terakhir: <span id="txt_nama_akun" class="text-success"></span></h2>
                                <ul class="nav navbar-right panel_toolbox">
                                    <li>
                                        <button type="button" class="btn btn-default btn-sm" id="btn_refresh">
                                            <i class="fa fa-refresh"></i> Muat ulang
                                        </button>
                                    </li>
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered" id="tabel_riwayat" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Tanggal</th>
                                                <th>Keterangan</th>
                                                <th>No Invoice</th>
                                                <th class="text-right">Topup</th>
                                                <th class="text-right">Penggunaan</th>
                                                <th class="text-right">Sisa Saldo</th>
                                                <th>Kasir</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /page content -->
        </div>
    </div>

    <script src="<?= base_url(); ?>src/vendors/jquery/dist/jquery.min.js"></script>
    <script src="<?= base_url(); ?>src/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="<?= base_url(); ?>src/vendors/fastclick/lib/fastclick.js"></script>
    <script src="<?= base_url(); ?>src/vendors/nprogress/nprogress.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="<?= base_url(); ?>src/build/js/custom.min.js"></script>

    <script>
        $(function() {
            var URL_RIWAYAT = '<?= base_url("depositagent/get_riwayat") ?>';
            var currentUid = null;
            var $tbody = $('#tabel_riwayat tbody');

            function rupiah(n) {
                return 'Rp ' + Number(n || 0).toLocaleString('id-ID', {
                    maximumFractionDigits: 0
                });
            }

            function setPesan(teks) {
                $tbody.html('<tr><td colspan="7" class="empty-state"></td></tr>');
                $tbody.find('td').text(teks);
            }

            function loadRiwayat(uid, nama) {
                currentUid = uid;
                $('#txt_nama_akun').text(nama);
                $('#panel_riwayat').slideDown();
                setPesan('Memuat riwayat...');

                $.ajax({
                    url: URL_RIWAYAT,
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        agent_uid: uid
                    },
                    success: function(res) {
                        if (!res.data || res.data.length === 0) {
                            setPesan('Belum ada transaksi di akun ini.');
                            return;
                        }

                        $tbody.empty();
                        $.each(res.data, function(i, r) {
                            var $tr = $('<tr>').addClass(r.jenis === 'topup' ? 'row-topup' : 'row-usage');

                            var $ket = $('<td>');
                            if (r.jenis === 'topup') {
                                $ket.append($('<b>').text(r.keterangan));
                            } else {
                                $ket.append('<i class="fa fa-arrow-circle-down text-danger"></i> ')
                                    .append($('<span class="text-danger">').text(r.keterangan));
                            }

                            $tr.append($('<td>').text(r.tanggal))
                                .append($ket)
                                .append($('<td>').text(r.no_invoice))
                                .append($('<td class="text-right nominal-topup">').text(r.topup > 0 ? rupiah(r.topup) : '-'))
                                .append($('<td class="text-right nominal-usage">').text(r.usage > 0 ? rupiah(r.usage) : '-'))
                                .append($('<td class="text-right">').append($('<b>').text(rupiah(r.sisa))))
                                .append($('<td>').text(r.kasir));

                            $tbody.append($tr);
                        });
                    },
                    error: function(xhr) {
                        var msg = (xhr.responseJSON && xhr.responseJSON.message) ||
                            'Riwayat gagal dimuat. Coba muat ulang halaman.';
                        setPesan(msg);
                        Swal.fire({
                            title: 'Gagal',
                            text: msg,
                            icon: 'error'
                        });
                    }
                });
            }

            $(document).on('click', '.akun-card', function() {
                $('.akun-card').removeClass('active');
                $(this).addClass('active');
                loadRiwayat($(this).data('uid'), $(this).data('nama'));
            });

            $('#btn_refresh').on('click', function() {
                var $aktif = $('.akun-card.active');
                if ($aktif.length) loadRiwayat($aktif.data('uid'), $aktif.data('nama'));
            });

            // Jika agent hanya punya 1 akun, langsung tampilkan riwayatnya
            if ($('.akun-card').length === 1) {
                $('.akun-card').first().trigger('click');
            }
        });
    </script>
</body>

</html>