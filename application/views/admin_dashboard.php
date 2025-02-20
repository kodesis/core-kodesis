<!DOCTYPE html>
<html lang="en">

<head>
   <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
   <!-- Meta, title, CSS, favicons, etc. -->
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <?php $setting = $this->db->get('setting')->result(); ?>

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
   <link rel="stylesheet" href="<?php echo base_url(); ?>app_umrah/css/header.css">
   <link rel="stylesheet" href="<?php echo base_url(); ?>app_umrah/css/icons.css">
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

      body {}
   </style>
</head>

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
                  <a href="<?php echo base_url(); ?>" class="site_title">
                     <img src="<?php echo base_url(); ?>src/images/istefa_logo.png" alt="..." height="42" width="42">
                     <span> Kodesis
                     </span>
                  </a>
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
               <!--<div class="page-title">
                     <div class="title_left">
                        <h2>Monitoring
                        </h3>
                     </div>
                  </div>-->
               <div class="clearfix">
               </div>
               <div class="x_content">
                  <p>
                     <font size="3"><strong>Financials Monitoring</font></strong>
                  </p>
                  <div class="table-responsive">
                     <table class="table table-striped jambo_table bulk_action">
                        <thead>

                        </thead>
                        <tbody>
                           <!-- <div class="alert alert-danger"><strong>Make sure you always check bank cash!</strong0></div>
								price element -->
                           <div class="col-md-4 col-sm-6 col-xs-12">
                              <h2 class="mb-30">Activa</h2>
                              <div class="pricing">
                                 <div class="title">
                                    <h2>Bank Cash Amount</h2>
                                    <h1>Rp. <?php $number = $bank_cash->kas;
                                             $nominal = number_format($number);
                                             echo $nominal; ?>.-</h1>
                                 </div>
                                 <div class="title">
                                    <h2>Total Omset</h2>
                                    <h1>Rp. <?php
                                             //$query = $this->db->query('SELECT (sum(p.project_modal)+sum(p1.project_modal)) AS omset From project p FULL OUTER JOIN project_arsip p1 ON p.Id = p1.Id');
                                             $query = $this->db->query('SELECT sum(project_modal) AS omset From project');
                                             $query1 = $this->db->query('SELECT sum(project_modal) AS omset From project_arsip');
                                             $hasil1 = $query->row();
                                             $hasil2 = $query1->row();
                                             //echo $hasil->omset;
                                             $number = $hasil1->omset + $hasil2->omset;
                                             $nominal = number_format($number);
                                             echo $nominal;
                                             ?>.-</h1>
                                 </div>
                                 <div class="title">
                                    <h2>Total Outstanding</h2>
                                    <h1>Rp. <?php $number = $bank_cash->piutang_penjualan;
                                             $nominal = number_format($number);
                                             echo $nominal; ?>.-</h1>
                                 </div>
                                 <div class="x_content">
                                    <div class="">
                                       <!--<div class="pricing_features">
										  <ul class="list-unstyled text-left">
											<li><i class="fa fa-times text-danger"></i> <strong>Unlimited</strong> storage</li>
											<li><i class="fa fa-check text-success"></i> Check <strong> Your Bank Cash</strong></li>
										  </ul>
										</div>
									  </div>-->
                                       <!--div class="pricing_footer">
										<a href="javascript:void(0);" class="btn btn-success btn-block" role="button">Check Bank Now!</a>
										<p>
										  <!--<a href="javascript:void(0);">Sign up</a>-->
                                       </p>
                                       </div-->
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <!-- price element -->
                           <div class="col-md-4 col-sm-6 col-xs-12">
                              <h2 class="mb-30">Profit</h2>
                              <div class="pricing">
                                 <div class="title">
                                    <h2>Total Profit In</h2>
                                    <h1>Rp. <?php $number = $bank_cash->pendapatan;
                                             $nominal = number_format($number);
                                             echo $nominal; ?>.-</h1>
                                 </div>
                                 <div class="title">
                                    <h2>Total Estimate Profit</h2>
                                    <h1>Rp. <?php
                                             $query = $this->db->query('SELECT sum(project_potensi_laba) AS omset From project');
                                             $query1 = $this->db->query('SELECT sum(project_potensi_laba) AS omset From project_arsip');
                                             $hasil1 = $query->row();
                                             $hasil2 = $query1->row();
                                             $number = $hasil1->omset + $hasil2->omset;
                                             $nominal = number_format($number);
                                             echo $nominal; ?>.-</h1>
                                 </div>
                                 <div class="title">
                                    <h2>Total Write Off</h2>
                                    <h1>Rp. <?php $number = $bank_cash->write_off;
                                             $nominal = number_format($number);
                                             echo $nominal; ?>.-</h1>
                                 </div>
                                 <div class="x_content">
                                    <div class="">
                                       <!--<div class="pricing_features">
										  <ul class="list-unstyled text-left">
											<li><i class="fa fa-times text-danger"></i> <strong>Unlimited</strong> storage</li>
											<li><i class="fa fa-check text-success"></i> Check <strong> Your Bank Cash</strong></li>
										  </ul>
										</div>
									  </div>-->
                                       <!--div class="pricing_footer">
										<a href="javascript:void(0);" class="btn btn-success btn-block" role="button">Check Bank Now!</a>
										<p>
										  <!--<a href="javascript:void(0);">Sign up</a>-->
                                       </p>
                                       </div-->
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </tbody>
                     </table>
                     <br>
                  </div>
               </div>

               <!-- Modal -->
               <form data-parsley-validate action="<?php echo base_url(); ?>app/simpan" method="post" name="form_input" id="form_input" class="form-horizontal form-label-left">
                  <div class="modal fade" id="myModal" role="dialog">
                     <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                           <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                              <h2 class="modal-title">Confirmation </h2>
                           </div>
                           <div class="modal-body text-center">
                              <p>
                                 <font color="green">Nominal : </font>
                              <h2><strong>Rp. <label id="nominal2">Nominal</label>
                                    <?php //$number = $data->nominal; $nominal = number_format($number); echo $nominal;
                                    ?>.-</strong></h2>
                              </p>
                              <p>
                                 <font color="green">Detail : </font>
                              <h2><strong><label id="detail">Detail</label>
                                    <?php //echo $data->keterangan; 
                                    ?></strong></h2>
                              </p>
                              <p>
                                 <font color="green">Post From User : </font>
                              <h2><strong><label id="username">Username</label>
                                    <?php //echo $data->username; 
                                    ?>
                                 </strong></h2>
                              </p>
                              <h4>
                                 <font color="Red"><Strong>Confirmation to Post...!!! </strong></font>
                              </h4>
                           </div>
                           <div class="modal-footer">
                              <input id="id_post" name="id_post" type="hidden" required="required" value="">
                              <?php echo form_submit('post_transaksi', 'Submit', 'class="btn btn-primary"'); ?>
                              <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                           </div>
                        </div>
                     </div>
                  </div>
               </form>
            </div>
         </div>
      </div>

      <!-- jQuery -->
      <script src="<?php echo base_url(); ?>src/vendors/jquery/dist/jquery.min.js"></script>
      <script src="<?php echo base_url(); ?>src/vendors/jquery/dist/jquery.mask.js"></script>
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
      <script src="<?php echo base_url(); ?>src/build/js/numeral.js"></script>
      <!-- Initialize datetimepicker -->
      <script type="text/javascript">
         $(document).ready(function() {
            // Format mata uang.
            $('.uang').mask('000.000.000', {
               reverse: true
            });
         })
      </script>
      <script>
         $('#myDatepicker').datetimepicker();
         $('#myDatepicker2').datetimepicker({
            format: 'YYYY-MM-DD'
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

         function clicked() {
            return confirm('Are you sure to post this transaction? ');
         }

         //start get value for modal
         function get_val(val) {
            document.getElementById('id_post').value = val;
            var myMoney = document.getElementById('id' + val).value;
            document.getElementById('nominal2').innerHTML = numeral(myMoney).format('0,0');;
            document.getElementById('detail').innerHTML = document.getElementById('detail' + val).value;
            document.getElementById('username').innerHTML = document.getElementById('username' + val).value;
         }

         //finish get value

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
</body>

</html>