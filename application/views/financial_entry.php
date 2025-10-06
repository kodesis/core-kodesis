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

                                <h2>Financial entry

                                    <small>Please fill below

                                    </small>

                                </h2>

                                <ul class="nav navbar-right panel_toolbox">
                                    <li class="dropdown">
                                        <a class="btn btn-warning btn-sm" href="<?= base_url('src/format/format_data.xlsx') ?>" download style="font-size: 12px;padding: 5px 10px;color: white;">
                                            Download Format Data
                                        </a>
                                    </li>
                                    <li class="dropdown">
                                        <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#upload_modal" type="button" style="color: white;">
                                            Upload Data
                                        </button>
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
                                    <li>

                                        <a class="collapse-link">

                                            <i class="fa fa-chevron-up">

                                            </i>

                                        </a>

                                    </li>

                                    <li class="dropdown">

                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">

                                            <i class="fa fa-wrench">

                                            </i>

                                        </a>

                                        <ul class="dropdown-menu" role="menu">

                                            <li>

                                                <a href="#">Settings 1

                                                </a>

                                            </li>

                                            <li>

                                                <a href="#">Settings 2

                                                </a>

                                            </li>

                                        </ul>

                                    </li>

                                    <li>

                                        <a class="close-link">

                                            <i class="fa fa-close">

                                            </i>

                                        </a>

                                    </li>

                                </ul>

                                <!-- <div class="clearfix">

                                </div> -->

                            </div>

                            <div class="x_content">

                                <!-- <br> -->

                                <form class="form-label-left input_mask" method="POST" action="<?= base_url('financial/process_financial_entry') ?>">


                                    <div class="col-md-6 col-xs-12 form-group has-feedback">

                                        <label for="" class="form-label">Debit</label>

                                        <select name="neraca_debit" id="neraca_debit" class="form-control select2" style="width: 100%;" required>

                                            <option value="">-- Pilih pos neraca debit</option>

                                            <?php

                                            foreach ($coa as $c) :

                                            ?>

                                                <option value="<?= $c->no_sbb ?>" data-nama="<?= $c->nama_perkiraan ?>" data-posisi="<?= $c->posisi ?>"><?= $c->no_sbb . ' - ' . $c->nama_perkiraan ?></option>

                                            <?php

                                            endforeach; ?>

                                        </select>

                                    </div>

                                    <div class="col-md-6 col-xs-12 form-group has-feedback">

                                        <label for="" class="form-label">Kredit</label>

                                        <select name="neraca_kredit" id="neraca_kredit" class="form-control select2" style="width: 100%;" required>

                                            <option value="">-- Pilih pos neraca kredit</option>

                                            <?php

                                            foreach ($coa as $c) :

                                            ?>

                                                <option value="<?= $c->no_sbb ?>" data-nama="<?= $c->nama_perkiraan ?>" data-posisi="<?= $c->posisi ?>"><?= $c->no_sbb . ' - ' . $c->nama_perkiraan ?> </option>

                                            <?php

                                            endforeach; ?>

                                        </select>

                                    </div>
                                    <div class="col-md-6 col-xs-12 form-group has-feedback">

                                        <label for="" class="form-label">Nominal</label>

                                        <!-- <input type="text" class="form-control" name="input_nominal" id="input_nominal" placeholder="Nominal" oninput="format_angka()" onkeypress="return onlyNumberKey(event)" autofocus required> -->

                                        <input type="text" class="form-control uang" name="input_nominal" id="input_nominal" placeholder="Nominal" autofocus required>

                                    </div>

                                    <div class="col-md-6 col-xs-12 form-group has-feedback">

                                        <label for="" class="form-label">Keterangan</label>

                                        <input type="text" class="form-control" name="input_keterangan" id="input_keterangan" placeholder="Keterangan" oninput="this.value = this.value.toUpperCase()" required>

                                    </div>

                                    <div class="col-md-6 col-xs-12 form-group has-feedback">

                                        <label for="" class="form-label">Tanggal</label>

                                        <input type="date" name="tanggal" id="tanggal" value="<?= date('Y-m-d') ?>" class="form-control" required>

                                    </div>

                                    <div class="form-group row">

                                        <div class="col-md-9 col-sm-9  offset-md-3">

                                            <button type="button" class="btn btn-primary">Cancel</button>

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

    <div class="modal fade" id="upload_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Upload Financial Entry</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <form id="upload_file_fe">
                            <div class="col-md-12 col-sm-12  offset-md-3 mt-3">
                                <label for="" class="form-label">File Format Data</label>
                                <input class="form-control" type="file" name="format_data" id="format_data">
                            </div>
                        </form>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="upload_fe()">Save</button>

                </div>
            </div>
        </div>
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



    <script>
        function reset_form() {

            document.getElementById("form_input").reset();

            document.getElementById("ckeditor").value = '';

        }

        function upload_fe() {
            const ttlnamaValue = $('#format_data').val();


            if (!ttlnamaValue) {
                swal.fire({
                    customClass: 'slow-animation',
                    icon: 'error',
                    showConfirmButton: false,
                    title: 'Kolom File Tidak Boleh Kosong',
                    timer: 1500
                });
            } else {
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        InputEvent: 'form-control',
                        confirmButton: 'btn btn-primary',
                        cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                    title: 'Ingin Menambahkan Data?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Tambahkan',
                    cancelButtonText: 'Tidak',
                    reverseButtons: true
                }).then((result) => {

                    if (result.isConfirmed) {

                        var url;
                        var formData;
                        url = "<?php echo site_url('financial/upload_financial_entry') ?>";

                        // window.location = url_base;
                        var formData = new FormData($("#upload_file_fe")[0]);
                        let accumulatedResponse = ""; // Variable to accumulate the response

                        $.ajax({
                            url: url,
                            type: "POST",
                            dataType: "text", // Change to 'text' to handle server-sent events
                            data: formData,
                            contentType: false,
                            processData: false,
                            beforeSend: function() {
                                // Show the progress dialog before sending the request
                                Swal.fire({
                                    title: 'Uploading...',
                                    html: `
                <progress id="progressBar" value="0" max="100" style="width: 100%;"></progress>
                <div id="progressText" style="margin-top: 10px; font-weight: bold;">0/0 Data</div>
            `,
                                    allowOutsideClick: false,
                                    showConfirmButton: false
                                });
                            },
                            xhrFields: {
                                onprogress: function(e) {
                                    // Read the response text for progress updates
                                    accumulatedResponse += e.currentTarget.responseText; // Accumulate responses

                                    var response = e.currentTarget.responseText.trim().split('\n');

                                    // Loop through each line to find progress data
                                    response.forEach(function(line) {
                                        try {
                                            var progressData = JSON.parse(line.replace("data: ", ""));
                                            if (progressData.progress) {
                                                $("#progressBar").val(progressData.progress);
                                                $("#progressText").text(`${progressData.currentRow}/${progressData.totalRows} Data`);
                                            }
                                        } catch (error) {
                                            console.error("Error parsing progress data:", error);
                                        }
                                    });
                                },
                            },
                            success: function(data) {
                                try {
                                    // Attempt to parse the final response
                                    var finalResponse = JSON.parse(accumulatedResponse.trim().split('\n').pop()); // Get the last line which should be the status
                                    console.log("Response data:", finalResponse); // Log final response to see its structure
                                    if (finalResponse.status) {
                                        const noDebitRows = finalResponse.no_debit_rows ? finalResponse.no_debit_rows.join(', ') : 'Tidak ada';
                                        const noKreditRows = finalResponse.no_kredit_rows ? finalResponse.no_kredit_rows.join(', ') : 'Tidak ada';

                                        // document.getElementById('rumahadat').reset();
                                        // $('#add_modal').modal('hide');
                                        (JSON.stringify(data));
                                        // alert(data)
                                        // swal.fire({
                                        //   customClass: 'slow-animation',
                                        //   icon: 'success',
                                        //   showConfirmButton: false,
                                        //   title: 'Berhasil Menambahkan Data',
                                        //   timer: 3000
                                        // });
                                        // document.getElementById('upload_file_fe').reset(); // Reset the form
                                        // $('#upload_modal').modal('hide'); // Hide the modal
                                        // location.reload();
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Proses Selesai',
                                            html: `
                                        <b>Berhasil:</b> ${finalResponse.success_count || 0} Data<br>
                                        <b>COA Debit Tidak Ditemukan:</b> ${finalResponse.no_debit_rows.length || 0} Data<br>
                                        (Baris: ${noDebitRows})<br><br>
                                        <b>COA Kredit Tidak Ditemukan:</b> ${finalResponse.no_kredit_rows.length || 0} Data<br>
                                        (Baris: ${noKreditRows})
                                    `,
                                            showConfirmButton: true,
                                            allowOutsideClick: true
                                        }).then(() => {
                                            document.getElementById('upload_file_fe').reset();
                                            $('#upload_modal').modal('hide');
                                            // location.reload();
                                        });

                                    } else {

                                        swal.fire('Gagal menyimpan data', 'error');
                                    }
                                } catch (error) {
                                    // If parsing fails, log the error
                                    console.error("Error parsing final response:", error);
                                    // swal.fire('Gagal menyimpan data', 'error');
                                    swal.fire('Gagal menyimpan data', 'Terjadi kesalahan pada respons server.', 'error');
                                }
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                swal.fire('Operation Failed!', errorThrown, 'error');
                            },
                            complete: function() {
                                console.log('Editing job done');
                            }
                        });


                    }

                })
            }
        }

        $(document).ready(function() {

            $('.uang').mask('000.000.000.000.000', {

                reverse: true

            });



            <?php if ($this->session->userdata('msg') == 'error2') { ?>

                Swal.fire({

                    icon: 'error',

                    title: 'Oops...',

                    text: 'Error Input!',

                })

            <?php

                $this->session->unset_userdata('msg');
            } else if ($this->session->userdata('msg_memo')) { ?>

                Swal.fire({

                    icon: 'success',

                    title: 'Success input',

                    text: 'Create & Send Success to ID <?= $this->session->userdata('msg_memo') ?>',

                })

            <?php

                $this->session->unset_userdata('msg_memo');
            } else ?>



            $("#submit-memo").on('click', function(e) {

                Swal.fire({

                    title: 'Are you sure?',

                    text: "You want to submit the form?",

                    icon: 'warning',

                    showCancelButton: true,

                    confirmButtonColor: '#3085d6',

                    cancelButtonColor: '#d33',

                    confirmButtonText: 'Yes'

                }).then((result) => {

                    if (result.isConfirmed) {

                        $("#form_input").submit();

                    } else {

                        e.preventDefault();

                    }

                })

            });



            $("#form_input").on('submit', () => {

                $("#submit-memo").attr('disabled', true);

                $("#submit-memo").html('Sending...');

                Swal.fire({

                    title: 'Sending...',

                    timerProgressBar: true,

                    allowOutsideClick: false,

                    didOpen: () => {

                        Swal.showLoading()

                    },

                })

            });



        });



        function simpan() {

            if (!confirm("Yes, send it!")) {

                alert('Canceled!');

                return false;

            } else {

                form.submit();

            }

        }



        $('#save_memo1').on('click', function(e) {

            e.preventDefault();

            var form = $(this).parents('form');

            swal({

                title: "Are you sure?",

                text: "Send Memo!",

                type: "warning",

                showCancelButton: true,

                confirmButtonColor: "#DD6B55",

                confirmButtonText: "Yes, send it!",

                closeOnConfirm: false

            }, function(isConfirm) {

                if (isConfirm) form.submit();

            });

        });



        $(document).ready(function() {

            $('.js-example-basic-multiple').select2();

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

            $(document).ready(function() {


                function formatState(state, colorAktiva, colorPasiva, signAktiva, signPasiva) {
                    if (!state.id) {
                        return state.text;
                    }

                    var color = state.element.dataset.posisi == "AKTIVA" ? colorAktiva : colorPasiva;
                    var sign = state.element.dataset.posisi == "AKTIVA" ? signAktiva : signPasiva;

                    var $state = $('<span style="background-color: ' + color + ';"><strong>' + state.text + ' ' + sign + '</strong></span>');

                    return $state;
                };

                function formatStateDebit(state) {
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

                $('#neraca_debit, #neraca_kredit').change(function() {
                    var debit = $('#neraca_debit').find(":selected").val();
                    var kredit = $('#neraca_kredit').find(":selected").val();
                    disabledSubmit(debit, kredit);
                });

                function disabledSubmit(debit, kredit) {
                    if (debit && kredit) {
                        if (debit == kredit) {
                            console.log('sama');
                            $('.btn-success').prop('disabled', true);
                        } else {
                            console.log('tidak sama');
                            $('.btn-success').prop('disabled', false);
                        }
                    }
                }
            });

        });







        function formatNumber(number) {

            return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");

        }



        function format_angka() {

            var nominal = document.getElementById('input_nominal').value;



            var formattedValue = formatNumber(parseFloat(nominal.split('.').join('')));



            document.getElementById('input_nominal').value = formattedValue;

        }



        function onlyNumberKey(evt) {



            // Only ASCII character in that range allowed

            let ASCIICode = (evt.which) ? evt.which : evt.keyCode

            if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))

                return false;

            return true;

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
    </script>



</body>



</html>