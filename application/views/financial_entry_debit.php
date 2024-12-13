<!DOCTYPE html>

<html lang="en">



<head>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <!-- Meta, title, CSS, favicons, etc. -->

    <meta charset="utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" href="images/favicon.ico" type="image/ico" />

    <title>Kodesis | Business Development</title>

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

</head>



<header class="header_area sticky-header">

    <?php

    if ($this->session->flashdata('message_name')) {

    ?>

        <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message_name') ?>"></div>

    <?php

    } ?>

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

                        <a href="<?= base_url(); ?>" class="site_title"><img src="<?= base_url(); ?>img/logo-kodesis.png" alt="..." height="42" width="60"><span> Kodesis</span></a>

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
                <div class="clearfix"></div>

                <!-- Start content-->
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="x_panel card">
                            <div class="x_title">
                                <h2>Financial entry
                                    <small>Please fill below</small>
                                </h2>
                                <ul class="nav navbar-right panel_toolbox">
                                    <li>
                                        <button class="btn btn-primary btn-sm" onclick="document.location='<?= base_url('financial/financial_entry') ?>'">Single</button>
                                        <!-- <a href="<?= base_url('financial/financial_entry') ?>" class="btn btn-primary dropdown-toggle">Single</a> -->
                                    </li>
                                    <li class="dropdown">
                                        <button class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" style="color: white;">
                                            Input Multiple
                                        </button>
                                        <ul class="dropdown-menu" role="menu">
                                            <li>
                                                <a href="<?= base_url('financial/financial_entry/debit') ?>">Multi Kredit
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?= base_url('financial/financial_entry/kredit') ?>">Multi Debit
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                            <div class="x_content">
                                <!-- <br> -->
                                <form class="form-label-left input_mask" method="POST" action="<?= base_url('financial/store_financial_entry/multi_kredit') ?>" enctype="multipart/form-data">


                                    <div class="col-md-6 col-xs-12 form-group has-feedback">
                                        <label for="" class="form-label">Coa Debit</label>
                                        <select name="neraca_debit" id="neraca_debit" class="form-control select2" style="width: 100%" required>
                                            <option value="">:: Pilih pos neraca debit</option>
                                            <?php foreach ($coa as $c) : ?>
                                                <option value="<?= $c->no_sbb ?>" data-nama="<?= $c->nama_perkiraan ?>" data-posisi="<?= $c->posisi ?>">
                                                    <?= $c->no_sbb . ' - ' . $c->nama_perkiraan ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Coa Kredit</th>
                                                <th>Nominal</th>
                                            </tr>
                                        </thead>
                                        <tbody id="journal-entries">
                                            <tr>
                                                <td>
                                                    <select name="accounts[]" class="form-control select2" style="width: 100%" required>
                                                        <option value="">:: Pilih akun</option>
                                                        <?php foreach ($coa as $c) : ?>
                                                            <option value="<?= $c->no_sbb ?>" data-nama="<?= $c->nama_perkiraan ?>"><?= $c->no_sbb . ' - ' . $c->nama_perkiraan ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control uang nominal-input" name="nominals[]" placeholder="Nominal" required>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tbody>
                                            <tr>
                                                <td colspan="2" class="text-right">
                                                    <button type="button" class="btn btn-secondary" id="add-row">Tambah Baris</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <!-- <div class="col-md-6 col-xs-12 form-group has-feedback">
                            <label for="" class="form-label">Kredit</label>
                            <select name="neraca_kredit" id="neraca_kredit" class="form-control select2" required>
                                <option value="">:: Pilih pos neraca kredit</option>
                                <?php
                                foreach ($coa as $c) :
                                ?>
                                    <option value="<?= $c->no_sbb ?>" data-nama="<?= $c->nama_perkiraan ?>" data-posisi="<?= $c->posisi ?>"><?= $c->no_sbb . ' - ' . $c->nama_perkiraan ?> </option>
                                <?php
                                endforeach; ?>
                            </select>
                        </div> -->
                                    <!-- <div class="col-md-6 col-xs-12 form-group has-feedback">
                            <label for="" class="form-label">Nominal</label>
                            <input type="text" class="form-control uang" name="input_nominal" id="input_nominal" placeholder="Nominal" autofocus required>
                        </div> -->
                                    <div class="col-md-6 col-xs-12 form-group has-feedback">
                                        <label for="" class="form-label">Tanggal</label>
                                        <input type="date" name="tanggal" id="tanggal" value="<?= date('Y-m-d') ?>" class="form-control" required>
                                    </div>
                                    <div class="col-md-6 col-xs-12 form-group has-feedback">
                                        <label for="" class="form-label">Keterangan</label>
                                        <textarea name="input_keterangan" id="input_keterangan" class="form-control" placeholder="Keterangan" oninput="this.value = this.value.toUpperCase()" rows="3" required></textarea>
                                    </div>
                                    <div class="col-md-6 col-xs-12 form-group has-feedback">
                                        <label for="file_upload" class="form-label">Upload file (opsional)</label>
                                        <input type="file" name="file_upload" id="file_upload" class="form-control">
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-9 col-sm-9  offset-md-3">
                                            <button class="btn btn-primary" type="reset">Reset</button>
                                            <button type="submit" class="btn btn-success">Submit</button>
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

    <script src="<?= base_url(); ?>src/js/jquery.mask.js"></script>

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



    <script src="<?php echo base_url(); ?>assets/vendors/jquery/dist/jquery.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="<?= base_url(); ?>assets/select2/css/select2.min.css">
    <script type="text/javascript" src="<?= base_url(); ?>assets/select2/js/select2.min.js"></script>

    <script src="<?= base_url(); ?>assets/js/jquery.mask.js"></script>
    <script>
        $(document).ready(function() {
            $('.uang').mask('000.000.000.000.000', {
                reverse: true
            });
            $('.select2').select2();

            $("form").on("submit", function() {
                Swal.fire({
                    title: "Loading...",
                    timerProgressBar: true,
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading()
                    },
                });
            });

            // Fungsi untuk menambahkan baris baru
            $('#add-row').click(function() {
                let newRow = `
            <tr>
                <td>
                    <select name="accounts[]" class="form-control select2" style="width: 100%" required>
                        <option value="">:: Pilih akun</option>
                        <?php foreach ($coa as $c) : ?>
                            <option value="<?= $c->no_sbb ?>" data-nama="<?= $c->nama_perkiraan ?>"><?= $c->no_sbb . ' - ' . $c->nama_perkiraan ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
                <td>
                    <input type="text" class="form-control uang nominal-input" name="nominals[]" placeholder="Nominal" required>
                </td>
            </tr>`;
                $('#journal-entries').append(newRow);
                $('.select2').select2();
                $('.uang').mask('000.000.000.000.000', {
                    reverse: true
                });
            });

            function formatState(state, colorAktiva, colorPasiva, signAktiva, signPasiva) {
                // console.log(state)
                if (!state.id) {
                    return state.text;
                }

                var color = state.element.dataset.posisi == "AKTIVA" ? colorAktiva : colorPasiva;
                var sign = state.element.dataset.posisi == "AKTIVA" ? signAktiva : signPasiva;

                var $state = $('<span style="background-color: ' + color + ';"><strong>' + state.text + ' ' + sign + '</strong></span>');

                return $state;
            };

            function formatStateDebit(state) {
                // console.log(state)
                return formatState(state, '#2ecc71', '#ff7675', '(+)', '(-)');
            }

            function formatStateKredit(state) {
                return formatState(state, '#ff7675', '#2ecc71', '(-)', '(+)');
            }
            $('#neraca_debit').select2({
                // templateResult: formatStateDebit,
                templateSelection: formatStateDebit
            });

            $('#neraca_kredit').select2({
                // templateResult: formatStateKredit,
                templateSelection: formatStateKredit
            });
        });

        // const flashdata = $(".flash-data").data("flashdata");
        // if (flashdata) {
        //     Swal.fire({
        //         title: "Success!! ",
        //         text: '<?= $this->session->flashdata('message_name') ?>',
        //         type: "success",
        //         icon: "success",
        //     });
        // }

        // const flashdata_error = $(".flash-data-error").data("flashdata");
        // // const flashdata_error = $('.flash-data').data('flashdata');
        // if (flashdata_error) {
        //     Swal.fire({
        //         title: "Error!! ",
        //         text: flashdata_error,
        //         type: "error",
        //         icon: "error",
        //     });
        // }
    </script>



</body>



</html>