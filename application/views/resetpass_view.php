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
    <title>Kodesis | Business Development
    </title>
    <!-- Bootstrap -->
    <link href="<?php echo base_url(); ?>src/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?php echo base_url(); ?>src/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress 
      <link href="<?php echo base_url(); ?>src/vendors/nprogress/nprogress.css" rel="stylesheet">-->
    <!-- iCheck 
      <link href="<?php echo base_url(); ?>src/vendors/iCheck/skins/flat/green.css" rel="stylesheet">-->
    <!-- bootstrap-progressbar 
      <link href="<?php echo base_url(); ?>src/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">-->
    <!-- JQVMap 
      <link href="<?php echo base_url(); ?>src/vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet"/>-->
    <!-- bootstrap-daterangepicker -->
    <link href="<?php echo base_url(); ?>src/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
    <!-- bootstrap-datetimepicker -->
    <link href="<?php echo base_url(); ?>src/vendors/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="<?php echo base_url(); ?>src/build/css/custom.min.css" rel="stylesheet">
    <!-- footer menu -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>src/css/mobile_menu/header.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>src/css/mobile_menu/icons.css">
    <!-- Sweetalert -->
    <script src="<?php echo base_url(); ?>src/build/js/sweetalert.js"></script>
    <link rel="stylesheet" href="<?php echo base_url(); ?>src/build/css/sweetalert.css" />
</head>
<style>
    .btn-file {
        position: relative;
        overflow: hidden;
    }

    .btn-file input[type=file] {
        position: absolute;
        top: 0;
        right: 0;
        min-width: 100%;
        min-height: 100%;
        font-size: 100px;
        text-align: right;
        filter: alpha(opacity=0);
        opacity: 0;
        outline: none;
        background: white;
        cursor: inherit;
        display: block;
    }

    #img-upload {
        width: 100%;
    }

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

    body {}
</style>

<header class="header_area sticky-header">
    <!-- footer menu -->
    <div class="footer_panel">
        <div class="container-fluid text-center">
            <div class="row">

                <div class="col-xs-3 btn_footer_panel">
                    <a href="<?php echo base_url(); ?>app/grab_project">
                        <i class="la-i la-i-m la-i-home"></i>
                        <div class="tag_">
                            <font color="white">Home</font>
                        </div>
                    </a>
                </div>
                <div class="col-xs-3 btn_footer_panel">
                    <a href="<?php echo base_url(); ?>app/list_project">
                        <i class="la-i la-i-m la-i-order"></i>
                        <div class="tag_">
                            <font color="white">Investment</font>
                        </div>
                    </a>
                </div>
                <div class="col-xs-3 btn_footer_panel">
                    <a href="<?php echo base_url(); ?>app/finance_report">
                        <i class="la-i la-i-m la-i-notif">
                        </i>
                        <div class="tag_">
                            <font color="white">Ledger</font>
                        </div>
                    </a>
                </div>
                <div class="col-xs-3 btn_footer_panel">
                    <i class="la-i la-i-m la-i-akun">
                        <?php if ($this->session->userdata('isLogin_umrah') == TRUE) {
                            $umrah_cart = $this->m_app_umrah->get_countcart_user($this->session->userdata('username'), 1); ?>
                            <notif><?php echo $umrah_cart; ?></notif>
                        <?php } ?>
                    </i>
                    <div class="tag_">
                        <font color="white">Notif</font>
                    </div>
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
                    <div class="clearfix">
                    </div>
                    <!-- menu profile quick info -->
                    <div class="profile clearfix">
                        <div class="profile_pic">
                            <img src="<?php echo base_url(); ?>src/images/img.jpg" alt="..." class="img-circle profile_img">
                        </div>
                        <div class="profile_info">
                            <span>Welcome,
                            </span>
                            <h2>
                                <?php echo $this->session->userdata('nama'); ?>
                            </h2>
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
            <!-- /page content -->
            <div class="right_col" role="main">
                <div class="">
                    <div class="page-title">
                        <div class="title_left">
                            <h3>
                                Reset Password
                            </h3>
                        </div>
                    </div>
                    <div class="clearfix">
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>Input Password
                                        <small>Please fill below
                                        </small>
                                    </h2>
                                    <ul class="nav navbar-right panel_toolbox">
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
                                    <div class="clearfix">
                                    </div>
                                </div>
                                <div class="x_content">
                                    <br />
                                    <?php echo form_open_multipart('app/resetpass/' . $this->uri->segment(3), 'class="form-horizontal form-label-left" name="form_input" id="form_input"'); ?>
                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="customer_name">New Password
                                            <span class="">*
                                            </span>
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="password" name="password_new" id="password_new" class="form-control col-md-7 col-xs-12" value="<?= set_value('password_new') ?>">
                                            <?= form_error('password_new') ?>
                                        </div>
                                    </div>
                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="customer_name">Verified Password
                                            <span class="required">*
                                            </span>
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="password" name="password_v" id="password_v" class="form-control col-md-7 col-xs-12">
                                            <?= form_error('password_v') ?>
                                        </div>
                                    </div>

                                    <div class="ln_solid">
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                            <button class="btn btn-primary" type="button" onclick="window.location.href='<?php echo base_url(); ?>app/user';">Cancel</button>

                                            <button name="save_password" id="btn-submit" type="submit" class="btn btn-success">Save</button><br><br><br>
                                            <!--<input type="submit" value="Save Customer" class="btn btn-success"/><br><br><br>-->
                                            <?php //echo form_submit('save_customer', 'Save Customer', 'onclick="return clicked();", class="btn btn-success"'); 
                                            ?>
                                        </div>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- footer content -->

            <!-- /footer content -->


            <!-- jQuery -->
            <script src="<?php echo base_url(); ?>src/vendors/jquery/dist/jquery.min.js"></script>
            <script src="<?php echo base_url(); ?>src/vendors/jquery/dist/jquery.mask.js"></script>
            <!-- Bootstrap -->
            <script src="<?php echo base_url(); ?>src/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
            <!-- FastClick -->
            <script src="<?php echo base_url(); ?>src/vendors/fastclick/lib/fastclick.js"></script>
            <!-- Flot -->
            <script src="<?php echo base_url(); ?>src/vendors/Flot/jquery.flot.js"></script>
            <script src="<?php echo base_url(); ?>src/vendors/Flot/jquery.flot.pie.js"></script>
            <script src="<?php echo base_url(); ?>src/vendors/Flot/jquery.flot.time.js"></script>
            <script src="<?php echo base_url(); ?>src/vendors/Flot/jquery.flot.stack.js"></script>
            <script src="<?php echo base_url(); ?>src/vendors/Flot/jquery.flot.resize.js"></script>
            <!-- Flot plugins -->
            <script src="<?php echo base_url(); ?>src/vendors/flot.orderbars/js/jquery.flot.orderBars.js"></script>
            <script src="<?php echo base_url(); ?>src/vendors/flot-spline/js/jquery.flot.spline.min.js"></script>
            <script src="<?php echo base_url(); ?>src/vendors/flot.curvedlines/curvedLines.js"></script>
            <!-- DateJS -->
            <script src="<?php echo base_url(); ?>src/vendors/DateJS/build/date.js"></script>
            <!-- bootstrap-daterangepicker -->
            <script src="<?php echo base_url(); ?>src/vendors/moment/min/moment.min.js"></script>
            <script src="<?php echo base_url(); ?>src/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
            <!-- bootstrap-datetimepicker -->
            <script src="<?php echo base_url(); ?>src/vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
            <!-- Custom Theme Scripts -->
            <script src="<?php echo base_url(); ?>src/build/js/custom.min.js"></script>
            <!-- validator -->
            <script src="<?php echo base_url(); ?>src/vendors/validator/validator.js"></script>
            <!-- Initialize datetimepicker -->
</body>

</html>