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
    <link href="<?php echo base_url(); ?>src/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?php echo base_url(); ?>src/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="<?php echo base_url(); ?>src/vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="<?php echo base_url(); ?>src/vendors/iCheck/skins/flat/green.css" rel="stylesheet">

    <!-- bootstrap-progressbar -->
    <link href="<?php echo base_url(); ?>src/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
    <!-- JQVMap -->
    <link href="<?php echo base_url(); ?>src/vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet" />
    <!-- bootstrap-daterangepicker -->
    <link href="<?php echo base_url(); ?>src/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="<?php echo base_url(); ?>src/build/css/custom.min.css" rel="stylesheet">

    <!-- DataTables -->
    <link href="cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <link href="<?= base_url() ?>src/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url() ?>src/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url() ?>src/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url() ?>src/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url() ?>src/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">

    <!-- footer menu -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>src/css/mobile_menu/header.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>src/css/mobile_menu/icons.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">

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

        tr>th {
            background-color: #004e81;
            color: white;
        }

        .col-centered {
            float: none;
            margin: 0 auto;
        }
    </style>
</head>

<header class="header_area sticky-header">
    <!-- footer menu -->
    <div class="footer_panel">
        <div class="container-fluid text-center">
            <div class="row">

                <div class="col-xs-3 btn_footer_panel">
                    <a href="<?php echo base_url(); ?>app/create_memo">
                        <i class="la-i la-i-m la-i-home"></i>
                        <div class="tag_">
                            <font color="white">Create</font>
                        </div>
                    </a>
                </div>
                <div class="col-xs-3 btn_footer_panel">
                    <a href="<?php echo base_url(); ?>app/inbox">
                        <i class="la-i la-i-m la-i-order"></i>
                        <div class="tag_">
                            <font color="white">Inbox</font>
                        </div>
                    </a>
                </div>
                <div class="col-xs-3 btn_footer_panel">
                    <a href="<?php echo base_url(); ?>app/send_memo">
                        <i class="la-i la-i-m la-i-notif"></i>
                        <div class="tag_">
                            <font color="white">Outbox</font>
                        </div>
                    </a>
                </div>
                <div class="col-xs-3 btn_footer_panel">
                    <a href="<?php echo base_url(); ?>login/logout">
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
                        <a href="<?php echo base_url(); ?>" class="site_title"><img src="<?php echo base_url(); ?>img/logo-kodesis.png" alt="..." height="42" width="60"><span> Kodesis</span></a>
                    </div>

                    <div class="clearfix"></div>

                    <!-- menu profile quick info -->
                    <div class="profile clearfix">
                        <div class="profile_pic">
                            <img src="<?php echo base_url(); ?>src/images/img.jpg" alt="..." class="img-circle profile_img">
                        </div>
                        <div class="profile_info">
                            <span>Welcome,</span>
                            <h2><?php echo $this->session->userdata('nama'); ?></h2>
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
                                    <img src="<?php echo base_url(); ?>src/images/img.jpg" alt=""><?php echo $this->session->userdata('nama'); ?>
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
                                    <li><a href="<?php echo base_url(); ?>login/logout"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                                </ul>
                            </li>

                            <li role="presentation" class="dropdown">
                                <a href="<?php echo base_url() . "app/inbox"; ?>" class="dropdown-toggle info-number">
                                    <i class="fa fa-envelope-o"></i>
                                    <?php if ($count_inbox == 0) { ?>
                                        <span class="badge bg-green"><?php echo $count_inbox; ?></span>
                                    <?php } else { ?>
                                        <span class="badge bg-red"><?php echo $count_inbox; ?></span>
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

            <!-- Start content-->
            <div class="right_col" role="main">

                <div class="x_panel card" id="user">
                    <?php if ($this->session->flashdata('success_reset')) { ?>
                        <div class="alert alert-success">
                            <a href="#" class="close" data-dismiss="alert">&times;</a>
                            <strong>Success!</strong> <?php echo $this->session->flashdata('success_reset'); ?>
                        </div>
                    <?php } ?>
                    <?php if ($this->session->flashdata('msg')) { ?>
                        <div class="alert alert-success">
                            <a href="#" class="close" data-dismiss="alert">&times;</a>
                            <strong>Success!</strong> <?php echo $this->session->flashdata('msg'); ?>
                        </div>
                    <?php } ?>


                    <!--div class="alert alert-info">Daftar Surat Kuasa </div-->
                    <div align="center">
                        <font color="brown">Member List</font><br><br>
                    </div>

                    <div class="text-center">
                        <a href="<?= base_url('cabang/create') ?>" class="btn btn-primary">Create</a>
                    </div>


                    <div class="table-responsive">
                        <table id="table1" class="table table-striped" style="width: 100%;">
                            <thead>
                                <tr>
                                    <!-- <th bgcolor="#34495e">
                                        <font color="white">No.</font>
                                    </th> -->
                                    <th bgcolor="#34495e">
                                        <font color="white">No</font>
                                    </th>
                                    <th bgcolor="#34495e">
                                        <font color="white">Nama Cabang</font>
                                    </th>
                                    <th bgcolor="#34495e">
                                        <font color="white">Alamat</font>
                                    </th>
                                    <th bgcolor="#34495e">
                                        <font color="white">#</font>
                                    </th>
                                    <!--th bgcolor="#004e81"><font color="white">Status</font></th-->
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <!-- Finish content-->
            </div>

            <!-- /page content -->

            <!-- footer content -->

            <!-- /footer content --></br></br>

            <!-- jQuery -->
            <script src="<?php echo base_url(); ?>src/vendors/jquery/dist/jquery.min.js"></script>
            <!-- Bootstrap -->
            <script src="<?php echo base_url(); ?>src/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
            <!-- FastClick -->
            <script src="<?php echo base_url(); ?>src/vendors/fastclick/lib/fastclick.js"></script>
            <!-- NProgress -->
            <script src="<?php echo base_url(); ?>src/vendors/nprogress/nprogress.js"></script>

            <!-- gauge.js -->
            <script src="<?php echo base_url(); ?>src/vendors/gauge.js/dist/gauge.min.js"></script>
            <!-- bootstrap-progressbar -->
            <script src="<?php echo base_url(); ?>src/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
            <!-- iCheck -->
            <script src="<?php echo base_url(); ?>src/vendors/iCheck/icheck.min.js"></script>
            <!-- Skycons -->
            <script src="<?php echo base_url(); ?>src/vendors/skycons/skycons.js"></script>

            <!-- DateJS -->
            <script src="<?php echo base_url(); ?>src/vendors/DateJS/build/date.js"></script>
            <!-- JQVMap -->
            <script src="<?php echo base_url(); ?>src/vendors/jqvmap/dist/jquery.vmap.js"></script>
            <script src="<?php echo base_url(); ?>src/vendors/jqvmap/dist/maps/jquery.vmap.world.js"></script>
            <script src="<?php echo base_url(); ?>src/vendors/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>
            <!-- bootstrap-daterangepicker -->
            <script src="<?php echo base_url(); ?>src/vendors/moment/min/moment.min.js"></script>
            <script src="<?php echo base_url(); ?>src/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>

            <!-- Custom Theme Scripts -->
            <script src="<?php echo base_url(); ?>src/build/js/custom.min.js"></script>

            <!-- Sweetalert -->
            <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

            <!-- DataTables -->
            <script src="<?= base_url() ?>src/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
            <script src="<?= base_url() ?>src/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
            <script src="<?= base_url() ?>src/vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
            <script src="<?= base_url() ?>src/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
            <script src="<?= base_url() ?>src/vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
            <script src="<?= base_url() ?>src/vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
            <script src="<?= base_url() ?>src/vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
            <script src="<?= base_url() ?>src/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
            <script src="<?= base_url() ?>src/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
            <script src="<?= base_url() ?>src/vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
            <script src="<?= base_url() ?>src/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
            <script src="<?= base_url() ?>src/vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>

            <!-- DatePicker -->
            <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

            <script>
                $(document).ready(function() {
                    $('#tanggal_export_absensi').datepicker({
                        format: "mm/yyyy",
                        startView: "months",
                        minViewMode: "months",
                        autoclose: true
                    });

                    <?php if ($this->session->flashdata('error')) { ?>
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: '<?= $this->session->flashdata('error') ?>',
                        })
                    <?php } ?>

                    $('#table1').dataTable({
                        // responsive: true,
                        rowReorder: {
                            selector: 'td:nth-child(2)'
                        },
                        processing: true,
                        serverSide: true,
                        ajax: {
                            url: "<?php echo site_url('cabang/ajax_list') ?>",
                            type: "POST"
                        },
                        order: [],
                        iDisplayLength: 10,
                        columnDefs: [{
                            targets: 3,
                            orderable: false
                        }]
                    });
                })

                function onDelete(id) {

                    const swalWithBootstrapButtons = Swal.mixin({
                        customClass: {
                            confirmButton: 'btn btn-success',
                            cancelButton: 'btn btn-danger'
                        },
                        buttonsStyling: false
                    })

                    swalWithBootstrapButtons.fire({
                        title: 'Apakah anda yakin ingin menghapus Data?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Ya, hapus Data',
                        cancelButtonText: 'Tidak',
                        reverseButtons: true
                    }).then((result) => {

                        if (result.isConfirmed) {

                            $.ajax({
                                url: "<?php echo site_url('cabang/delete') ?>",
                                type: "POST",
                                data: {
                                    id_delete: id
                                },
                                dataType: "JSON",
                                beforeSend: function() {
                                    // showLoading("Saving data...", "Mohon tunggu");
                                },
                                success: function(data) {
                                    if (!data.status) showAlert('Gagal!', data.message.toString().replace(/<[^>]*>/g, ''), 'error');
                                    else {
                                        swalWithBootstrapButtons.fire(
                                            'Terhapus!',
                                            'Data berhasil dihapus.',
                                            'success'
                                        )
                                        $('#table1').DataTable().ajax.reload(); // Assuming you are using AJAX to load data
                                    }
                                },
                                error: function(jqXHR, textStatus, errorThrown) {
                                    swalWithBootstrapButtons.fire(
                                        'Gagal',
                                        'Data gagal dihapus',
                                        'error'
                                    )
                                },
                                complete: function() {
                                    console.log('published job done');
                                }
                            });


                        }

                    })



                }
            </script>

</body>

</html>