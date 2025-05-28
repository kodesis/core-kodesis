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

        tr.baris>td>input.form-control {
            font-size: 11px;
        }

        input.uppercase {
            text-transform: uppercase;
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
                            <img src="<?= $this->session->userdata('icon') ?>" alt="..." height="42" width="60">
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
                                <!--ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
                    <li>
                      <a>
                        <span class="image"><img src="<?= base_url(); ?>src/images/img.jpg" alt="Profile Image" /></span>
                        <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                        <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                      </a>
                    </li>
                    <li>
                      <a>
                        <span class="image"><img src="<?= base_url(); ?>src/images/img.jpg" alt="Profile Image" /></span>
                        <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                        <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                      </a>
                    </li>
                    <li>
                      <a>
                        <span class="image"><img src="<?= base_url(); ?>src/images/img.jpg" alt="Profile Image" /></span>
                        <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                        <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                      </a>
                    </li>
                    <li>
                      <a>
                        <span class="image"><img src="<?= base_url(); ?>src/images/img.jpg" alt="Profile Image" /></span>
                        <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                        <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                      </a>
                    </li>
                    <li>
                      <div class="text-center">
                        <a>
                          <strong>See All Alerts</strong>
                          <i class="fa fa-angle-right"></i>
                        </a>
                      </div>
                    </li>
                  </ul-->
                            </li>
                            <?php include 'notif_tello.php' ?>
                        </ul>
                    </nav>
                </div>
            </div>
            <!-- /top navigation -->

            <!-- page content -->
            <div class="right_col" role="main">
                <!--div class="pull-left">
				<font color='Grey'>Create New E-Memo </font>
			</div-->
                <div class="clearfix"></div>

                <!-- Start content-->
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="x_panel card">
                            <div class="x_title">
                                <h2>Create Nota</h2>
                            </div>
                            <div class="x_content">
                                <form class="form-horizontal form-label-left" method="POST" action="<?= base_url('financial/store_nota') ?>">
                                    <div class="form-group row">
                                        <div class="col-md-2 col-xs-12">
                                            <label for="tgl_nota" class="form-label">Date</label>
                                            <input type="date" class="form-control" name="tgl_nota" value="<?= date('Y-m-d') ?>">
                                        </div>
                                        <div class="col-md-4 col-xs-12">
                                            <label for="customer" class="form-label">Bill to</label>
                                            <input type="text" name="customer" id="customer" class="form-control" placeholder="Customer" required>
                                            <!-- <select name="customer" id="customer" class="form-control select2" style="width: 100%" required>
                                                <option value="">:: Pilih customer</option>
                                                <?php
                                                foreach ($customers as $c) : ?>
                                                    <option value="<?= $c->id ?>"><?= $c->nama_customer ?></option>
                                                <?php
                                                endforeach; ?>
                                            </select> -->
                                        </div>
                                        <!-- <div class="col-md-2 col-xs-12">
                                            <label for="diskon" class="form-label">Discount</label>
                                            <select name="diskon" id="diskon" class="form-control">
                                                <option value="0">0%</option>
                                                <option value="0.05">5%</option>
                                                <option value="0.1">10%</option>
                                            </select>
                                        </div> -->
                                        <div class="col-md-2 col-xs-12">
                                            <label for="ppn" class="form-label">PPN</label>
                                            <select name="ppn" id="ppn" class="form-control">
                                                <option value="0">0%</option>
                                                <option value="<?= $this->session->userdata('ppn') ?>"><?= $this->session->userdata('nama_ppn') ?></option>
                                            </select>
                                        </div>
                                        <div class="col-md-4 col-xs-12">
                                            <label for="keterangan" class="form-label">Jenis nota</label>
                                            <select name="jenis" id="jenis" class="form-control" required>
                                                <option value="">:: Pilih jenis nota</option>
                                                <?php
                                                if ($jenis) {
                                                    foreach ($jenis as $j) : ?>
                                                        <option value="<?= $j->Id ?>"><?= $j->nama_jenis_nota ?></option>
                                                <?php
                                                    endforeach;
                                                } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-2 col-xs-12">
                                            <label for="nominal" class="form-label">Subtotal</label>
                                            <input type="text" class="form-control" name="nominal" id="nominal" value="0" readonly>
                                        </div>
                                        <!-- <div class="col-md-2 col-xs-12">
                                            <label for="besaran_diskon" class="form-label">Discount</label>
                                            <input type="text" class="form-control" name="besaran_diskon" id="besaran_diskon" value="0" readonly>
                                        </div> -->
                                        <div class="col-md-2 col-xs-12">
                                            <label for="besaran_ppn" class="form-label">PPN</label>
                                            <input type="text" class="form-control" name="besaran_ppn" id="besaran_ppn" value="0" readonly>
                                        </div>
                                        <!-- <div class="col-md-2 col-xs-12">
                                            <label for="total_nonpph" class="form-label">Total (non PPh)</label>
                                            <input type="text" class="form-control" name="total_nonpph" id="total_nonpph" value="0" readonly>
                                        </div>
                                        <div class="col-md-2 col-xs-12">
                                            <label for="total_denganpph" class="form-label">Total (w/ PPh)</label>
                                            <input type="text" class="form-control" name="total_denganpph" id="total_denganpph" value="0" readonly>
                                        </div> -->
                                        <div class="col-md-2 col-xs-12">
                                            <label for="total_denganpph" class="form-label">Pendapatan</label>
                                            <input type="text" class="form-control" name="nominal_pendapatan" id="nominal_pendapatan" value="0" readonly>
                                        </div>
                                        <div class="col-md-2 col-xs-12">
                                            <label for="nominal_bayar" class="form-label">Nominal bayar</label>
                                            <input type="text" class="form-control" name="nominal_bayar" id="nominal_bayar" value="0" readonly>
                                        </div>
                                    </div>
                                    <table class="table mt-5 table-responsive">
                                        <thead>
                                            <tr>
                                                <th>Keterangan</th>
                                                <th>Stok</th>
                                                <th>Jumlah</th>
                                                <th>Nominal</th>
                                                <th>Amount</th>
                                                <th>Del.</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="baris">
                                                <td>
                                                    <input type="hidden" name="id_item[]" id="id_item[]" class="form-control" readonly>
                                                    <input type="text" class="form-control uppercase autocomplete" name="item[]">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" name="stok_gudang[]" value="0" readonly>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" name="jumlah[]" value="0">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control total" name="total[]" value="0">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" name="total_amount[]" value="0" readonly>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-danger btn-sm hapusRow">Hapus</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="row">
                                        <div class="col-lg-6 col-xs-12">
                                            <button type="button" class="btn btn-secondary btn-sm" id="addRow">Add new row</button>
                                        </div>
                                        <div class="col-md-6 col-xs-12 text-right">
                                            <div class="">
                                                <a href="<?= base_url('financial/nota') ?>" class="btn btn-sm btn-warning"><i class="bi bi-arrow-return-left"></i> Back</a>
                                                <button type="submit" class="btn btn-primary btn-sm">Save <i class="bi bi-save"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
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

    </div>

    <!-- jQuery -->



    <script src="<?= base_url(); ?>src/vendors/jquery/dist/jquery.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <!-- Bootstrap -->
    <script src="<?= base_url(); ?>src/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="<?= base_url(); ?>src/vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <!-- <script src="<?= base_url(); ?>src/vendors/nprogress/nprogress.js"></script> -->
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

    <script>
        $(document).ready(function() {
            $('.js-example-basic-multiple').select2();
            $('.select2').select2();

            // $("form").on("submit", function() {
            //     Swal.fire({
            //         title: "Loading...",
            //         timerProgressBar: true,
            //         allowOutsideClick: false,
            //         didOpen: () => {
            //             Swal.showLoading()
            //         },
            //     });
            // });
        });



        function formatNumber(number) {
            // Pisahkan bagian integer dan desimal
            let parts = number.toString().split(",");

            // Format bagian integer dengan pemisah ribuan
            parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");

            // Gabungkan bagian integer dan desimal dengan koma sebagai pemisah desimal
            return parts.join(",");
        }

        <?php
        if ($this->session->flashdata('message_name')) {
        ?>
            Swal.fire({
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


        $(document).ready(function() {
            var rowCount = 1; // Inisialisasi row

            $('#addRow').on('click', function() {
                // Periksa apakah ada input yang kosong di baris sebelumnya
                var previousRow = $('.baris').last();
                var inputs = previousRow.find('input[type="text"], input[type="datetime-local"]');
                var isEmpty = false;

                inputs.each(function() {
                    if ($(this).val().trim() === '') {
                        isEmpty = true;
                        return false; // Berhenti iterasi jika ditemukan input kosong
                    }
                });

                // Jika ada input yang kosong, tampilkan pesan peringatan
                if (isEmpty) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Mohon isi semua input pada baris sebelumnya terlebih dahulu!',
                    });
                    return; // Hentikan penambahan baris baru
                }

                // Salin baris terakhir
                var newRow = previousRow.clone();

                // Kosongkan nilai input di baris baru
                newRow.find('input').val('');
                newRow.find('input[name="total[]"]').val('0');
                newRow.find('input[name="jumlah[]"]').val('0');
                newRow.find('input[name="total_amount[]"]').val('0');

                // Perbarui tag <h4> pada baris baru dengan nomor urut yang baru
                rowCount++;

                // Tambahkan baris baru setelah baris terakhir
                previousRow.after(newRow);
            });

            $(document).on('change click keyup input paste', 'input[name="jumlah[]"], input[name="total[]"], input[name="stok_gudang[]"]', function(event) {
                $(this).val(function(index, value) {
                    return value.replace(/(?!\.)\D/g, "")
                        .replace(/(?<=\..*)\./g, "")
                        .replace(/(?<=\.\d\d).*/g, "")
                        .replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                });

                var row = $(this).closest('.baris');

                hitungTotal(row);
                updateTotalBelanja();
                updateTotal();
            });


            function hitungTotal(row) {
                var total = row.find('input[name="total[]"]').val().replace(/\,/g, '');
                var jumlah = row.find('input[name="jumlah[]"]').val().replace(/\,/g, '');
                var stok = row.find('input[name="stok_gudang[]"]').val().replace(/\,/g, '');

                total = (total) || 0;
                jumlah = (jumlah) || 0;
                stok = (stok) || 0;

                // Batasi jumlah agar tidak lebih dari stok
                jumlah = Math.min(jumlah, stok);

                var total_amount = Number(total) * Number(jumlah);

                row.find('input[name="total_amount[]"]').val(formatNumber(total_amount.toFixed(0)));
                row.find('input[name="jumlah[]"]').val(jumlah)
                updateTotalBelanja();
            }

            function updateTotalBelanja() {
                var total_pos_fix = 0;

                $(".baris").each(function() {
                    var total = $(this).find('input[name="total_amount[]"]').val().replace(/\,/g, ''); // Ambil nilai total dari setiap baris
                    total = parseFloat(total); // Ubah string ke angka float

                    if (!isNaN(total)) { // Pastikan total adalah angka
                        total_pos_fix += total; // Tambahkan nilai total ke total_pos_fix
                    }
                });
                $('#nominal').val(formatNumber(total_pos_fix)); // Atur nilai input #total_basic_rate dengan total_basic_rate
            }

            // Tambahkan event listener untuk tombol hapus row
            $(document).on('click', '.hapusRow', function() {
                $(this).closest('.baris').remove();
                updateTotalBelanja(); // Perbarui total belanja setelah menghapus baris
                updateTotal();
            });

            // Saat opsi diskon berubah
            $('#diskon').on('change', function() {
                // Panggil fungsi untuk mengupdate besaran diskon dan total
                updateTotal();
            });
            $('#ppn').on('change', function() {
                // Panggil fungsi untuk mengupdate besaran diskon dan total
                updateTotal();
            });
            $('#opsi_pph').on('change', function() {
                // console.log("tes")
                // updatePPH();
                updateTotal();
            });

            // Fungsi untuk mengupdate besaran diskon dan total
            function updateTotal() {
                var diskon = parseFloat($('#diskon').val());
                var ppn = parseFloat($('#ppn').val());

                var subtotal = 0;
                // Hitung subtotal dari total setiap baris
                $('.baris').each(function() {
                    var totalBaris = parseInt($(this).find('input[name="total_amount[]"]').val().replace(/\,/g, '') || 0);
                    subtotal += totalBaris;
                });
                // Hitung besaran diskon
                var besaranDiskon = subtotal * diskon;
                var besaranDiskon = subtotal;
                // Hitung total setelah diskon
                var total = subtotal;

                // console.log(besaranpph)
                var besaranppn = total * ppn;
                var nominal_bayar = total + besaranppn;

                // console.log(subtotal);
                // console.log((ppn));
                // console.log(formatNumber(besaranppn));
                // Atur nilai input besaran_diskon dan total dengan format angka yang sesuai
                $('#besaran_ppn').val(formatNumber(besaranppn.toFixed(0)));
                // $('#besaran_pph').val(formatNumber(besaranpph.toFixed(0)));
                $('#besaran_diskon').val(formatNumber(besaranDiskon));
                $('#nominal_pendapatan').val(formatNumber(total.toFixed(0)));
                $('#nominal_bayar').val(formatNumber(nominal_bayar.toFixed(0)));
            }

            $('#diskonEdit').on('change', function() {
                // Panggil fungsi untuk mengupdate besaran diskon dan total
                updateTotalEdit();
            });

            function updateTotalEdit() {
                var diskon = parseFloat($('#diskonEdit').val());

                var subtotal = parseInt($('#nominal').val().replace(/\,/g, '') || 0);

                // Hitung besaran diskon
                var besaranDiskon = subtotal * diskon;
                // Hitung total setelah diskon
                var total = subtotal - besaranDiskon;
                // Atur nilai input besaran_diskon dan total dengan format angka yang sesuai
                $('#besaran_diskon').val(formatNumber(besaranDiskon));
                $('#total_nonpph').val(formatNumber(total));
            }

            $('#diskonEdit').on('change', function() {
                // Panggil fungsi untuk mengupdate besaran diskon dan total
                updateTotalEdit();
            });

            $('#addNewRow').on('click', function() {
                // Periksa apakah ada input yang kosong di baris sebelumnya
                var previousRow = $('.barisEdit').last();
                var inputs = previousRow.find('input[type="text"], input[type="datetime-local"]');
                var isEmpty = false;

                inputs.each(function() {
                    if ($(this).val().trim() === '') {
                        isEmpty = true;
                        return false; // Berhenti iterasi jika ditemukan input kosong
                    }
                });

                // Jika ada input yang kosong, tampilkan pesan peringatan
                if (isEmpty) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Mohon isi semua input pada baris sebelumnya terlebih dahulu!',
                    });
                    return; // Hentikan penambahan baris baru
                }

                // Salin baris terakhir
                var newRow = previousRow.clone();

                // Kosongkan nilai input di baris baru
                newRow.find('input').val('');
                newRow.find('input[name="newHarga[]"]').val('0');

                // Perbarui tag <h4> pada baris baru dengan nomor urut yang baru
                rowCount++;

                // Tambahkan baris baru setelah baris terakhir
                previousRow.after(newRow);
            });


            $(document).on('click', '.hapusRowAddItem', function() {
                $(this).closest('.barisEdit').remove();
            });

            $(document).on('input', 'input[name="newHarga[]"]', function() {
                var value = $(this).val();
                var formattedValue = parseFloat(value.split('.').join(''));
                $(this).val(formattedValue);

                var row = $(this).closest('.barisEdit');
                hitungTotalNewItem(row);
            });

            // Tambahkan event listener untuk event keyup
            $(document).on('keyup', 'input[name="newHarga[]"]', function() {
                var value = $(this).val().trim(); // Hapus spasi di awal dan akhir nilai
                var formattedValue = formatNumber(parseFloat(value.split('.').join('')));
                $(this).val(formattedValue);
                if (isNaN(value)) { // Jika nilai input kosong
                    $(this).val(''); // Atur nilai input menjadi 0
                }
                var row = $(this).closest('.barisEdit');
                hitungTotalNewItem(row);
            });

            function hitungTotalNewItem(row) {
                var harga = row.find('input[name="newHarga[]"]').val().replace(/\,/g, ''); //
                harga = parseInt(harga);

                harga = isNaN(harga) ? 0 : harga;

                // var total = qty * harga;
                // row.find('input[name="newTotal[]"]').val(formatNumber(total));
            }
        });
    </script>
    <script>
        $(function() {
            function initializeAutocomplete() {
                $(".autocomplete").autocomplete({
                    source: function(request, response) {
                        $.ajax({
                            url: "<?php echo site_url('financial/autocomplete'); ?>",
                            dataType: "json",
                            data: {
                                term: request.term
                            },
                            success: function(data) {
                                response(data);
                            }
                        });
                    },
                    minLength: 2,

                    select: function(event, ui) {
                        var $row = $(this).closest('tr.baris');
                        var harga = ui.item.harga;
                        var stok = ui.item.stok;
                        var formattedValue = (parseInt(ui.item.harga.split('.').join('')));

                        $row.find('input[name="id_item[]"]').val(ui.item.id_item);
                        $row.find('input[name="total[]"]').val(formatNumber(Math.round(harga)));
                        $row.find('input[name="stok_gudang[]"]').val(formatNumber((stok)));
                    }
                });
            }

            initializeAutocomplete();

            $("#addRow").click(function() {
                var newRow = '<div class="autocomplete-row"><input type="text" class="form-control autocomplete" name="item[]" oninput="this.value = this.value.toUpperCase()"></div>';
                $("#invoiceForm").append(newRow);
                initializeAutocomplete();
            });
        });
    </script>


</body>

</html>