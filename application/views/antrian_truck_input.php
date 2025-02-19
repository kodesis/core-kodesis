<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php $setting = $this->db->get('setting')->result(); ?>

  <link rel="icon" href="<?= base_url($setting[2]->object) ?>" type="image/ico" />
  <title><?= $setting['3']->object ?> | Bussines Development</title>
  <title>Andara Office | Business Development</title>
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

  <link href="<?php echo base_url(); ?>src/build/css/select2.min.css" rel="stylesheet" />

</head>
<style>
  .select2-dropdown {
    top: 0px !important;
    left: 0px !important;
  }

  .badge {
    background-color: red;
  }

  .button {
    border: none;
    outline: none;
    padding: 10px 16px;
    background-color: #f1f1f1;
    cursor: pointer;
    font-size: 18px;
  }

  /* Style the active class, and buttons on mouse-over */
  .button:hover {
    background-color: #666;
    color: white;
  }

  .act {
    background-color: #666;
    color: white;
  }

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
          <a href="<?php echo base_url(); ?>app/antrian_input">
            <i class="la-i la-i-m la-i-home"></i>
            <div class="tag_">
              <font color="white">Create</font>
            </div>
          </a>
        </div>
        <div class="col-xs-3 btn_footer_panel">
          <a href="<?php echo base_url(); ?>app/antrian_panggil">
            <i class="la-i la-i-m la-i-order"></i>
            <div class="tag_">
              <font color="white">Manage</font>
            </div>
          </a>
        </div>
        <div class="col-xs-3 btn_footer_panel">
          <a href="<?php echo base_url(); ?>app/antrian_monitor">
            <i class="la-i la-i-m la-i-notif">
            </i>
            <div class="tag_">
              <font color="white">Monitor</font>
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
            <a href="<?php echo base_url(); ?>" class="site_title"><img src="<?php echo base_url(); ?>src/images/logosaja_bdl.png" alt="..." height="42" width="60"><span> Andara Office</span></a>
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
                <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                  <i class="fa fa-envelope-o"></i>
                  <span class="badge bg-green">0</span>
                </a>
                <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
                  <li>
                    <a>
                      <span class="image"><img src="<?php echo base_url(); ?>src/images/img.jpg" alt="Profile Image" /></span>
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
                      <span class="image"><img src="<?php echo base_url(); ?>src/images/img.jpg" alt="Profile Image" /></span>
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
                      <span class="image"><img src="<?php echo base_url(); ?>src/images/img.jpg" alt="Profile Image" /></span>
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
                      <span class="image"><img src="<?php echo base_url(); ?>src/images/img.jpg" alt="Profile Image" /></span>
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
                </ul>
              </li>
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
            <!--div class="title_left">
                     <h3>Input Antrian Truck
                     </h3>
                  </div-->
          </div>
          <div class="clearfix">
          </div>
          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2>Input Antrian
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
                <!--<div class="x_content">
                           <br/>
							<?php //echo form_open_multipart('upload_ktp/do_upload', 'class="form-horizontal form-label-left"');
              ?>
							 <div class="form-group">
                                 <label class="control-label col-md-3 col-sm-3 col-xs-12" for="identity">Identity Numbers 
                                 <span class="required">*
                                 </span>
                                 </label>
                                 <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="identity" name="identity" required="required" class="form-control col-md-7 col-xs-12">
                                 </div>
                              </div>
							 <div class="form-group">
                                 <label class="control-label col-md-3 col-sm-3 col-xs-12" for="identity_file">Upload File Identity 
                                 <span class="required">*
                                 </span>
                                 </label>
                                 <div class="col-md-6 col-sm-6 col-xs-12">
                                   <input type="file" name="userfile" class="form-control col-md-7 col-xs-12"/>
									<input type="submit" value="Upload" class="btn btn-primary"/>
                                 </div>
                              </div>
							</form> 
						</div> -->

                <div class="x_content">
                  <br />
                  <?php echo form_open_multipart('app/simpan_antrian', 'class="form-horizontal form-label-left" name="form_input" id="form_input"'); ?>
                  <div class="item form-group">
                    <label style="text-align: left;" class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Nama RA</label>
                    <div class="col-md-6 col-sm-6 col-xs-12 text-left">
                      <label style="text-align: left;" class="control-label col-md-12 col-sm-12 col-xs-12" for="name"><?php echo $agent->nama; ?></label>
                    </div>
                  </div>
                  <div class="item form-group">
                    <label style="text-align: left;" class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Nama User</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <label style="text-align: left;" class="control-label col-md-12 col-sm-12 col-xs-12" for="name"><?php echo $this->session->userdata('nama'); ?></label>
                    </div>
                  </div>
                  <div class="item form-group">
                    <label style="text-align: left;" class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Nomor Mobil<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input id="nomor_mobil" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="1" name="nomor_mobil" placeholder="" required="required" type="text">
                    </div>
                  </div>
                  <div class="item form-group">
                    <label style="text-align: left;" class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Nomor Segel<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input id="nomor_segel" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="1" name="nomor_segel" placeholder="" required="required" type="text">
                    </div>
                  </div>
                  <!--div class="item form-group">
								<label style="text-align: left;" class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Nomor CSD<span class="required">*</span>
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
								  <input id="nomor_csd" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="1" name="nomor_csd" placeholder="" required="required" type="text">
								</div>
							  </div-->
                  <div class="item form-group">
                    <label style="text-align: left;" class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Nama Driver<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input id="nama_driver" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="1" name="nama_driver" placeholder="" required="required" type="text">
                    </div>
                  </div>
                  <div class="item form-group">
                    <label style="text-align: left;" class="control-label col-md-3 col-sm-3 col-xs-12" for="telephone">Nomor HP <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="text" id="phone" name="phone" required="required" data-validate-length-range="8,20" class="form-control col-md-7 col-xs-12">
                    </div>
                  </div>
                  <!--div class="item form-group">
								<label style="text-align: left;" class="control-label col-md-3 col-sm-3 col-xs-12" for="telephone">Tujuan <span class="required">*</span>
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<select id="tujuan" name="tujuan" style="width:100%">
									<option value="">Destination</option>
									<?php
                  $no = 1;
                  if (empty($tujuan)) {
                  ?>
									<?php
                  } else {
                    foreach ($tujuan as $data) :
                  ?>
									<option value="<?php echo $data->kode; ?>"><?php echo $data->nama_kota; ?></option>
									<?php endforeach;
                  } ?>
								</select>
								</div>
							  </div-->
                  <div class="item form-group">
                    <label style="text-align: left;" class="control-label col-md-3 col-sm-3 col-xs-12">Jadwal Flight <span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <div class='input-group date' id='myDatepicker'>
                        <input type='text' id='date_flight' name='date_flight' class="form-control" placeholder="yyyy-mm-dd" data-validate-words="1" required="required" />
                        <span class="input-group-addon">
                          <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="item form-group">
                    <label style="text-align: left;" class="control-label col-md-3 col-sm-3 col-xs-12">Tanggal Mengantri <span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <div class='input-group date' id='myDatepicker2'>
                        <input type='text' id='date_pic' name='date_pic' class="form-control" placeholder="yyyy-mm-dd" data-validate-words="1" required="required" />
                        <span class="input-group-addon">
                          <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="item form-group">
                    <label style="text-align: left;" class="control-label col-md-3 col-sm-3 col-xs-12" for="telephone">Jadwal Antrian<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <button type="button" class="btn btn-primary" onclick="tampil_data_barang()" data-toggle="modal" data-target="#myModal1">Pilih Jam Antrian &raquo;</button>
                      <label id="label_jam_terpilih" style="font-weight: bold; font-size: 16px; text-align: center; color: white;" class="badge badge-light">--:--</label><br><br>
                      <input id="jam_terpilih" name="jam_terpilih" type="hidden" required="required" value="">
                      <!--button name="button" class="btn btn-primary" onclick="tampil_data_barang()">Load &raquo;</button-->
                      <!--select name="show_data1" id="show_data1" class="form-control" style="width: 100px;">
									
								  </select-->
                    </div>
                  </div>
                  <!--div class="form-group">
                                 <label style="text-align: left;" class="control-label col-md-3 col-sm-3 col-xs-12">Dependents <span class="required">*</span>
                                 </label>
                                 <div class="col-md-6 col-sm-6 col-xs-12">
                                    <select class="select2_group form-control" name="Dependents">
                                       <optgroup label="Amount">
                                          <option value="0">0</option>
                                          <option value="1">1</option>
                                          <option value="2">2</option>
                                          <option value="3">3</option>
                                          <option value="4">4</option>
                                          <option value="5">5 <</option>
                                       </optgroup>
                                    </select>
                                 </div>
                              </div-->
                  <div class="form-group">
                    <label style="text-align: left;" for="informasi" class="control-label col-md-3 col-sm-3 col-xs-12">Information Tambahan
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <textarea name="informasi" class="form-control" rows="3" placeholder="Please write your information"></textarea>
                    </div>
                  </div>
                  <div class="ln_solid">
                  </div>
                  <div class="form-group">
                    <label style="text-align: left; font-size:12px;" for="informasi" class="control-label col-md-3 col-sm-3 col-xs-12">
                      <font color="red">* setelah mendapatkan nomor antrian silahkan isi DO di bawah ini</font>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <button class="btn btn-primary" type="button" onclick="window.location.href='<?php echo base_url(); ?>home';">Cancel
                      </button>
                      <button class="btn btn-primary" type="reset" onclick="reset_form()">Reset
                      </button>
                      <!--<button type="submit" id="save_project" name="save_project" class="btn btn-success" onclick="return clicked();">Submit</button>-->
                      <button name="save_customer" id="btn-submit" type="submit" class="btn btn-success">Create</button><br>
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

          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <p>
                    <font size="4" color="green"><strong>Nomor Antrian Anda &raquo;&nbsp;&nbsp;&nbsp;
                        <?php
                        if (empty($last_id)) {
                        } else {
                          echo $last_id;
                        } ?></font>
                    <font size="1"> <br>silahkan lengkapi DO (Devlivery Order)</font></strong>
                  </p>

                  <!-- start upload smu -->
                  <?php echo form_open_multipart('app/upload_smu/' . $id_antrian, 'class="form-horizontal form-label-left" name="form_input" id="form_input"'); ?>
                  <div class="item form-group">
                    <label style="text-align: left;" class="control-label col-md-3 col-sm-3 col-xs-12" for="number">Nomor DO <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="text" id="nomor_smu" name="nomor_smu" required="required" data-validate-words="1" class="form-control col-md-7 col-xs-12">
                    </div>
                  </div>
                  <div class="form-group">
                    <label style="text-align: left;" class="control-label col-md-3 col-sm-3 col-xs-12" for="identity_file">File Upload
                      <span class="required">*
                      </span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <div class="input-group">
                        <span class="input-group-btn">
                          <span class="btn btn-default btn-file">
                            Browse… <input type="file" accept=".jpg,.jpeg" id="imgInp" name="userfile" class="form-control col-md-7 col-xs-12" required="required">
                          </span>
                        </span>
                        <input type="text" class="form-control" readonly>
                      </div>
                      <img id='img-upload' />
                      <!--<input type="file" name="userfile" class="form-control col-md-7 col-xs-12" required="required"/>-->
                    </div>
                  </div>
                  <div class="form-group">
                    <label style="text-align: left;" for="info" class="control-label col-md-3 col-sm-3 col-xs-12">Information
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <textarea name="info" class="form-control" rows="3" placeholder="Write sort info"></textarea>
                    </div>
                  </div>
                  <div class="ln_solid">
                  </div>
                  <div class="form-group">
                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                      <!--button class="btn btn-primary" type="button" onclick="window.location.href='<?php echo base_url(); ?>home';">Cancel
                                    </button>
                                    <button class="btn btn-primary" type="reset" onclick="reset_form()">Reset
                                    </button>
                                    <button type="submit" id="save_project" name="save_project" class="btn btn-success" onclick="return clicked();">Submit</button>-->
                      <button name="upload" id="btn-submit" type="submit" class="btn btn-primary">Upload</button>
                      </form>

                      <!--<input type="submit" value="Save Customer" class="btn btn-success"/><br><br><br>-->
                      <?php //echo form_submit('save_customer', 'Save Customer', 'onclick="return clicked();", class="btn btn-success"'); 
                      ?>
                    </div>
                  </div>

                  <!-- finish upload smu -->

                  <div class="table-responsive">
                    <table class="table table-striped jambo_table bulk_action">
                      <thead>
                        <tr class="headings">
                          <th class="column-title">No.</th>
                          <th class="column-title">No. DO</th>
                          <th class="column-title">View</th>
                          <th class="column-title">Delete</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $no = 1;
                        if (empty($antrian_smu)) { ?>
                          <div class="alert alert-info">Tidak ditemukan data DO</div>
                          <?php } else {
                          foreach ($antrian_smu as $data) :
                          ?>
                            <tr class="even pointer">
                              <td class=" "><?php echo $no; ?></td>
                              <td class=" "><?php echo $data->nomor_smu; ?></td>
                              <td class=" "><a href="<?php echo base_url() . '/upload/smu/' . $data->nomor_smu . '.jpg'; ?>" target="_blank" class="alert-success tile-stats" style="text-align: center;">review</a></td>
                              <td class=" "><a href="<?php echo base_url() . '/app/delete_smu/' . $data->Id; ?>" class="alert-danger tile-stats" style="text-align: center;">Delete</a></td>
                            </tr>
                        <?php
                            $no++;
                          endforeach;
                        }
                        ?>
                      </tbody>
                    </table>
                  </div>
                  <a id="btn-submit_antrian" href="" class="btn btn-success" style="text-align: center;">Submit Antrian</a>
                </div>
              </div>
              <br><br><br><br><br>
            </div>
          </div>

        </div>
      </div>

      <div class="modal fade" id="myModal1" role="dialog">
        <div class="modal-dialog">
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h2 class="modal-title">Tentukan jam antrian</h2>
            </div>
            <div class="modal-body text-center">
              <h4>
                <font color="Green"><Strong>
              </h4><br>
              <div class="form-group">
                <?php
                $no = 1;
                ?>
                <!-- ajax test -->
                <div class="container">
                  <!-- Page Heading -->
                  <div class="row" id="ajax_message"></div>
                  <div class="row" id="show_data"></div>
                </div>
                <!--button id="button" name="button" class="btn btn-success" onclick="tampil_data_barang()">Load</button--><br>
                <script>
                  //fungsi tampil barang
                  function tampil_data_barang() {
                    var tanggal = $("#date_pic").val();
                    var tgl = $("#date_flight").val();
                    var ts = new Date($("#date_flight").val());
                    var time_flight = ts.getHours() + ":" + ts.getMinutes();
                    $.ajax({
                      type: 'post',
                      url: '<?php echo base_url() ?>/app/jadwal_ngantri',
                      async: false,
                      dataType: 'json',
                      data: {
                        tanggal: tanggal,
                        time_flight: time_flight,
                        tgl_flight: tgl
                      },
                      success: function(data) {
                        //var json = $.parseJSON(data);
                        var html = '';
                        var i;
                        for (i = 0; i < data.length; i++) {
                          html += "<button style='width:20%' data-dismiss='modal' onClick='jam_selected(`" + data[i].name + "`)' class='button" + data[i].Id + "'>" + data[i].name + "</button>";
                          //html += '<option value="'+data[i].name+'">'+data[i].name+'</option>';
                        }
                        $('#show_data').html(html);
                      }
                    });
                  }
                </script>

              </div>
            </div>
            <div class="modal-footer">
              <div style="text-align: center;">Anda diharuskan mengambil antrian kembali jika terlambat lebih dari 5 menit<br>
                <input id="id_slot" name="id_slot" type="hidden" required="required" value="">
                <!--button name="btn-submit" id="btn-submit" type="submit" class="btn btn-success">Finish</button-->
                <?php //echo form_submit('submit', 'Finish', 'class="btn btn-primary"'); 
                ?>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>
        <br><br><br>
      </div>

      <!-- footer content -->

      <!-- /footer content -->


      <!-- jQuery -->
      <script src="<?php echo base_url(); ?>src/vendors/jquery/dist/jquery.min.js"></script>
      <script src="<?php echo base_url(); ?>src/vendors/jquery/dist/jquery.mask.js"></script>
      <script src="<?php echo base_url(); ?>src/build/js/select2.min.js"></script>
      <!-- Bootstrap -->
      <script src="<?php echo base_url(); ?>src/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
      <!-- FastClick -->
      <script src="<?php echo base_url(); ?>src/vendors/fastclick/lib/fastclick.js"></script>
      <!-- NProgress 
      <script src="<?php echo base_url(); ?>src/vendors/nprogress/nprogress.js"></script>-->
      <!-- Chart.js 
      <script src="<?php echo base_url(); ?>src/vendors/Chart.js/dist/Chart.min.js"></script>-->
      <!-- gauge.js 
      <script src="<?php echo base_url(); ?>src/vendors/gauge.js/dist/gauge.min.js"></script>-->
      <!-- bootstrap-progressbar 
      <script src="<?php echo base_url(); ?>src/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>-->
      <!-- iCheck 
      <script src="<?php echo base_url(); ?>src/vendors/iCheck/icheck.min.js"></script>-->
      <!-- Skycons 
      <script src="<?php echo base_url(); ?>src/vendors/skycons/skycons.js"></script>-->
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
      <!-- JQVMap 
      <script src="<?php echo base_url(); ?>src/vendors/jqvmap/dist/jquery.vmap.js"></script>
      <script src="<?php echo base_url(); ?>src/vendors/jqvmap/dist/maps/jquery.vmap.world.js"></script>
      <script src="<?php echo base_url(); ?>src/vendors/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>-->
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
      <script type="text/javascript">
        $(document).ready(function() {
          // Format mata uang.
          $('.uang').mask('000.000.000', {
            reverse: true
          });
        });

        $('button').on('click', function() {
          $('button').removeClass('selected');
          $(this).addClass('selected');
        });


        $("#tujuan").select2({
          placeholder: "Destination",
          allowClear: true
        });
      </script>
      <script>
        $('#myDatepicker').datetimepicker({
          format: 'YYYY-MM-DD HH:mm'
        });
        $('#myDatepicker2').datetimepicker({
          format: 'YYYY-MM-DD',
          maxDate: Date.now() + 90000000
        });
        $('#myDatepicker3').datetimepicker({
          format: 'hh:mm A'
        });
        $('#myDatepicker4').datetimepicker({
          ignoreReadonly: true,
          allowInputToggle: true
        });
        $('#datetimepicker6').datetimepicker();
        $('#datetimepicker7').datetimepicker({
          useCurrent: false
        });
        $("#datetimepicker6").on("dp.change", function(e) {
          $('#datetimepicker7').data("DateTimePicker").minDate(e.date);
        });
        $("#datetimepicker7").on("dp.change", function(e) {
          $('#datetimepicker6').data("DateTimePicker").maxDate(e.date);
        });
        //currency
        $("input[data-type='currency']").on({
          keyup: function() {
            formatCurrency($(this));
          },
          blur: function() {
            formatCurrency($(this), "blur");
          }
        });

        function jam_selected(val) {
          //alert(val+' Selected');
          $('#label_jam_terpilih').text(val);
          document.getElementById('jam_terpilih').value = val;
        }

        function clicked() {
          return confirm('Are you sure to save new Customer?');
        }

        function reset_form() {
          document.getElementById("form_input").reset();
        }

        function formatNumber(n) {
          // format number 1000000 to 1,234,567
          return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        }

        function formatCurrency(input, blur) {
          // appends $ to value, validates decimal side
          // and puts cursor back in right position.
          // get input value
          var input_val = input.val();
          // don't validate empty input
          if (input_val === "") {
            return;
          }
          // original length
          var original_len = input_val.length;
          // initial caret position 
          var caret_pos = input.prop("selectionStart");
          // check for decimal
          if (input_val.indexOf(".") >= 0) {
            // get position of first decimal
            // this prevents multiple decimals from
            // being entered
            var decimal_pos = input_val.indexOf(".");
            // split number by decimal point
            var left_side = input_val.substring(0, decimal_pos);
            var right_side = input_val.substring(decimal_pos);
            // add commas to left side of number
            left_side = formatNumber(left_side);
            // validate right side
            right_side = formatNumber(right_side);
            // On blur make sure 2 numbers after decimal
            if (blur === "blur") {
              right_side += "00";
            }
            // Limit decimal to only 2 digits
            right_side = right_side.substring(0, 2);
            // join number by .
            input_val = "Rp " + left_side + "." + right_side;
          } else {
            // no decimal entered
            // add commas to number
            // remove all non-digits
            input_val = formatNumber(input_val);
            input_val = "Rp " + input_val;
            // final formatting
            if (blur === "blur") {
              input_val += ".00";
            }
          }
          // send updated string to input
          input.val(input_val);
          // put caret back in the right position
          var updated_len = input_val.length;
          caret_pos = updated_len - original_len + caret_pos;
          input[0].setSelectionRange(caret_pos, caret_pos);
        }
      </script>
      <script>
        $(document).ready(function() {
          $(document).on('change', '.btn-file :file', function() {
            var input = $(this),
              label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
            input.trigger('fileselect', [label]);
          });

          $('.btn-file :file').on('fileselect', function(event, label) {

            var input = $(this).parents('.input-group').find(':text'),
              log = label;

            if (input.length) {
              input.val(log);
            } else {
              if (log) alert(log);
            }

          });

          function readURL(input) {
            if (input.files && input.files[0]) {
              var reader = new FileReader();

              reader.onload = function(e) {
                $('#img-upload').attr('src', e.target.result);
              }

              reader.readAsDataURL(input.files[0]);
            }
          }

          $("#imgInp").change(function() {
            readURL(this);
          });
        });

        //sweet alert
        $('#btn-submit').on('click', function(e) {
          e.preventDefault();
          var form = $(this).parents('form');
          swal({
            title: "Are you sure?",
            text: "Queue wil be save!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, save it!",
            closeOnConfirm: false
          }, function(isConfirm) {
            if (isConfirm) form.submit();
          });
        });

        $('#btn-submit_antrian').on('click', function(e) {
          e.preventDefault();
          var form = $(this).parents('form');
          swal({
            title: "Are you sure?",
            text: "Queue wil be sent to Approve!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, Send it!",
            closeOnConfirm: false
          }, function(isConfirm) {
            if (isConfirm) {
              window.location.href = "<?php echo base_url() . 'app/submit_antrian/' . $id_antrian; ?>", "_blank";
              //window.location.href = "https://api.whatsapp.com/send?phone=<?php echo $utility->avsec_cgk_no; ?>&text=Antrian Submite";
            }
          });
        });
      </script>
</body>

</html>