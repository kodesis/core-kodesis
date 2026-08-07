<?php

/**
 * application/views/track_view.php
 * Lacak status SMU — halaman publik, tidak perlu login.
 * Mengikuti struktur & style login_view.php (login_lib).
 *
 * Data dari controller (semua opsional):
 *  $q, $smu, $riwayat, $notfound
 */

$q        = isset($q) ? $q : '';
$smu      = isset($smu) ? $smu : null;
$riwayat  = isset($riwayat) ? $riwayat : array();
$notfound = isset($notfound) ? $notfound : false;

$steps = array(
   array('kode' => 'diterima', 'nama' => 'SMU Diterima',       'ket' => 'Barang masuk gudang, dokumen SMU diterbitkan'),
   array('kode' => 'btb',  'nama' => 'Timbang &amp; Ukur',     'ket' => 'Verifikasi berat aktual dan dimensi koli'),
   array('kode' => 'btb',     'nama' => 'Screening X-Ray',    'ket' => 'Pemeriksaan sekuriti oleh regulated agent'),
   array('kode' => 'invoice',   'nama' => 'Build-Up Gudang',    'ket' => 'Barang ditata dan siap dimuat'),
   array('kode' => 'terbang', 'nama' => 'Manifest Maskapai',  'ket' => 'Dokumen diserahkan dan dimanifestkan'),
   array('kode' => 'terbang',  'nama' => 'Loading ke Pesawat', 'ket' => 'Koli dimuat ke kompartemen kargo'),
   array('kode' => 'terbang',  'nama' => 'Terbang',            'ket' => 'Pesawat berangkat dari bandara asal'),
);

$log = array();
foreach ($riwayat as $r) {
   if (isset($r['kode'])) $log[$r['kode']] = $r;
}

$idx = -1;
foreach ($steps as $i => $s) {
   if (isset($log[$s['kode']])) $idx = $i;
}
$total   = count($steps);
$selesai = $idx + 1;
$persen  = ($idx > 0) ? round(($idx / ($total - 1)) * 100) : 0;
$terbang = isset($log['terbang']);

if (!function_exists('tr_val')) {
   function tr_val($a, $k, $d = '-')
   {
      return (isset($a[$k]) && $a[$k] !== '') ? $a[$k] : $d;
   }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>

   <title>Lacak SMU</title>

   <meta charset="UTF-8">

   <meta name="viewport" content="width=device-width, initial-scale=1">

   <!--===============================================================================================-->
   <?php
   $logo = $this->db->get('utility')->row_array()['logo']; ?>

   <link rel="icon" type="image/png" href="<?= $logo ?>" />

   <!--===============================================================================================-->

   <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>login_lib/vendor/bootstrap/css/bootstrap.min.css">

   <!--===============================================================================================-->

   <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>login_lib/fonts/font-awesome-4.7.0/css/font-awesome.min.css">

   <!--===============================================================================================-->

   <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>login_lib/fonts/Linearicons-Free-v1.0.0/icon-font.min.css">

   <!--===============================================================================================-->

   <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>login_lib/vendor/animate/animate.css">

   <!--===============================================================================================-->

   <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>login_lib/css/util.css">

   <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>login_lib/css/main.css">

   <!--===============================================================================================-->

   <style>
      /* ---- Halaman lacak SMU ---- */
      .wrap-track {
         width: 100%;
         max-width: 720px;
      }

      .track-card {
         width: 100%;
         background-color: #fff;
         border-radius: 10px;
         overflow: hidden;
      }

      /* ikon FontAwesome untuk kolom input */
      .focus-fa::after {
         font-family: FontAwesome !important;
      }

      /* ---- Papan rute ---- */
      .tr-pass {
         background-color: #04263f;
         padding: 25px 25px 20px;
      }

      .tr-label {
         font-size: 11px;
         letter-spacing: 2px;
         text-transform: uppercase;
         color: #8fb4d1;
         line-height: 1.4;
      }

      .tr-iata {
         font-family: Ubuntu-Bold, sans-serif;
         font-size: 38px;
         color: #fff;
         line-height: 1;
      }

      .tr-flight {
         font-family: Ubuntu-Bold, sans-serif;
         font-size: 20px;
         color: #fff;
         letter-spacing: 1px;
      }

      .tr-rail {
         position: relative;
         height: 2px;
         background-color: rgba(143, 180, 209, .35);
         margin: 28px 10px 0;
      }

      .tr-rail-fill {
         position: absolute;
         top: 0;
         left: 0;
         height: 2px;
         width: 0;
         background-color: #f5a524;
         transition: width 1s ease-out;
      }

      .tr-plane {
         position: absolute;
         top: -12px;
         left: 0;
         margin-left: -9px;
         font-size: 18px;
         color: #f5a524;
         transition: left 1s ease-out;
      }

      .tr-plane.done {
         color: #6ee7b7;
      }

      /* ---- Detail SMU ---- */
      .tr-detail {
         padding: 20px 25px;
         border-bottom: 1px solid #e6e6e6;
      }

      .tr-field {
         font-size: 11px;
         letter-spacing: 1.5px;
         text-transform: uppercase;
         color: #999;
         margin-bottom: 2px;
      }

      .tr-value {
         font-size: 15px;
         color: #333;
         font-family: Ubuntu-Bold, sans-serif;
         word-break: break-word;
      }

      .tr-badge {
         display: inline-block;
         font-size: 12px;
         letter-spacing: 1px;
         text-transform: uppercase;
         padding: 4px 14px;
         border-radius: 20px;
      }

      .tr-badge.proses {
         background-color: #fdf0d8;
         color: #8a5a00;
      }

      .tr-badge.selesai {
         background-color: #e2f3ea;
         color: #14664a;
      }

      /* ---- Timeline ---- */
      .tr-body {
         padding: 25px;
      }

      .tr-head {
         font-family: Ubuntu-Bold, sans-serif;
         font-size: 20px;
         color: #333;
         text-transform: uppercase;
      }

      .tr-step {
         position: relative;
         padding: 0 0 24px 62px;
         min-height: 62px;
      }

      .tr-step:last-child {
         padding-bottom: 0;
      }

      .tr-step:before {
         content: "";
         position: absolute;
         left: 21px;
         top: 46px;
         bottom: 0;
         width: 2px;
         background-color: #e6e6e6;
      }

      .tr-step.ok:before {
         background-color: #004e81;
      }

      .tr-step:last-child:before {
         display: none;
      }

      .tr-dot {
         position: absolute;
         left: 0;
         top: 0;
         width: 44px;
         height: 44px;
         border-radius: 10px;
         border: 2px solid #e6e6e6;
         background-color: #fff;
         color: #b3b3b3;
         font-family: Ubuntu-Bold, sans-serif;
         font-size: 17px;
         line-height: 40px;
         text-align: center;
      }

      .tr-step.ok .tr-dot {
         background-color: #004e81;
         border-color: #004e81;
         color: #fff;
      }

      .tr-step.now .tr-dot {
         background-color: #f5a524;
         border-color: #f5a524;
         color: #3a2600;
      }

      .tr-step.last .tr-dot {
         background-color: #1b8a5a;
         border-color: #1b8a5a;
         color: #fff;
      }

      .tr-step h3 {
         font-family: Ubuntu-Bold, sans-serif;
         font-size: 16px;
         color: #333;
         line-height: 44px;
         text-transform: uppercase;
      }

      .tr-step.pending h3 {
         color: #b3b3b3;
      }

      .tr-step .tr-ket {
         font-size: 13px;
         color: #888;
         line-height: 1.5;
      }

      .tr-step.pending .tr-ket {
         color: #b3b3b3;
      }

      .tr-meta {
         font-size: 13px;
         color: #555;
         margin-top: 6px;
      }

      .tr-waktu {
         font-family: Ubuntu-Bold, sans-serif;
         color: #004e81;
         margin-right: 14px;
      }

      .tr-empty {
         padding: 45px 25px;
         text-align: center;
      }

      .tr-empty i {
         font-size: 46px;
         color: #d9d9d9;
      }

      .tr-foot a {
         color: #fff;
         text-decoration: underline;
      }

      @media (max-width: 575px) {
         .tr-iata {
            font-size: 30px;
         }

         .tr-pass,
         .tr-detail,
         .tr-body {
            padding-left: 18px;
            padding-right: 18px;
         }

         .input100 {
            font-size: 17px;
         }
      }

      @media print {

         .no-print,
         .login100-form-btn {
            display: none !important;
         }

         .container-login100:before {
            display: none;
         }
      }
   </style>

</head>

<body>

   <div class="limiter">

      <div class="container-login100">

         <div class="wrap-track p-t-10 p-b-10">

            <span class="login100-form-title p-b-30">
               <a href="<?= base_url() ?>"><img src="<?= $logo; ?>" alt="..." width="150"></a>
            </span>

            <!-- ================= FORM PENCARIAN ================= -->
            <form class="track-card validate-form m-b-20 no-print" action="<?= base_url('track') ?>" method="get" name="track">

               <div class="wrap-input100 validate-input" data-validate="Masukkan Nomor SMU">
                  <input class="input100" type="text" name="q" value="<?= htmlspecialchars($q, ENT_QUOTES) ?>"
                     placeholder="Nomor SMU / AWB" autocomplete="off" autofocus>
                  <span class="focus-input100 focus-fa" data-placeholder="&#xf02a;"></span>
               </div>

               <div class="container-login100-form-btn p-t-25 p-b-25">
                  <button class="login100-form-btn">
                     Lacak
                  </button>
               </div>

            </form>

            <?php if ($notfound) : ?>

               <!-- ================= TIDAK DITEMUKAN ================= -->
               <div class="track-card tr-empty">
                  <i class="fa fa-search"></i>
                  <div class="tr-head m-t-15">Nomor SMU Tidak Ditemukan</div>
                  <p class="m-t-8">Periksa kembali penulisan nomor, atau hubungi petugas gudang kargo bila SMU baru saja dibuat.</p>
               </div>

            <?php elseif ($smu) : ?>

               <!-- ================= HASIL ================= -->
               <div class="track-card">

                  <div class="tr-pass">
                     <div class="row align-items-start">
                        <div class="col-4">
                           <div class="tr-label">Asal</div>
                           <div class="tr-iata"><?= tr_val($smu, 'origin') ?></div>
                           <div class="tr-label" style="letter-spacing:0"><?= tr_val($smu, 'origin_kota', '') ?></div>
                        </div>
                        <div class="col-4 text-center">
                           <div class="tr-label">Penerbangan</div>
                           <div class="tr-flight"><?= tr_val($smu, 'flight') ?></div>
                           <div class="tr-label" style="letter-spacing:0">ETD <?= tr_val($smu, 'etd') ?></div>
                        </div>
                        <div class="col-4 text-right">
                           <div class="tr-label">Tujuan</div>
                           <div class="tr-iata"><?= tr_val($smu, 'destination') ?></div>
                           <div class="tr-label" style="letter-spacing:0"><?= tr_val($smu, 'dest_kota', '') ?></div>
                        </div>
                     </div>

                     <div class="tr-rail">
                        <div class="tr-rail-fill" id="railFill"></div>
                        <i class="fa fa-plane tr-plane <?= $terbang ? 'done' : '' ?>" id="railPlane"></i>
                     </div>

                     <div class="d-flex justify-content-between m-t-10">
                        <span class="tr-label" style="letter-spacing:0"><?= $selesai ?> dari <?= $total ?> tahap selesai</span>
                        <span class="tr-label" style="letter-spacing:0"><?= $persen ?>%</span>
                     </div>
                  </div>

                  <div class="tr-detail">
                     <div class="row">
                        <div class="col-6 col-md-3 m-b-15">
                           <div class="tr-field">Nomor SMU</div>
                           <div class="tr-value"><?= tr_val($smu, 'no_smu') ?></div>
                        </div>
                        <div class="col-6 col-md-3 m-b-15">
                           <div class="tr-field">Koli / Berat</div>
                           <div class="tr-value"><?= tr_val($smu, 'koli') ?> koli &middot; <?= tr_val($smu, 'berat') ?> kg</div>
                        </div>
                        <div class="col-6 col-md-3 m-b-15">
                           <div class="tr-field">Komoditi</div>
                           <div class="tr-value"><?= tr_val($smu, 'komoditi') ?></div>
                        </div>
                        <div class="col-6 col-md-3 m-b-15">
                           <div class="tr-field">Status</div>
                           <span class="tr-badge <?= $terbang ? 'selesai' : 'proses' ?>">
                              <?= $terbang ? 'Sudah Terbang' : 'Dalam Proses' ?>
                           </span>
                        </div>
                        <div class="col-12 col-md-6">
                           <div class="tr-field">Pengirim</div>
                           <div class="tr-value"><?= tr_val($smu, 'shipper') ?></div>
                        </div>
                        <div class="col-12 col-md-6">
                           <div class="tr-field">Penerima</div>
                           <div class="tr-value"><?= tr_val($smu, 'consignee') ?></div>
                        </div>
                     </div>
                  </div>

                  <div class="tr-body">
                     <div class="d-flex justify-content-between align-items-center m-b-25">
                        <span class="tr-head">Tahapan Proses</span>
                        <a href="javascript:window.print()" class="no-print" style="color:#004e81;">
                           <i class="fa fa-print"></i> Cetak
                        </a>
                     </div>

                     <?php foreach ($steps as $i => $s) :
                        $ada = isset($log[$s['kode']]);
                        $cls = 'pending';
                        if ($ada) {
                           $cls = ($i === $idx) ? ($s['kode'] === 'terbang' ? 'ok last' : 'ok now') : 'ok';
                        }
                        $d = $ada ? $log[$s['kode']] : array();
                     ?>
                        <div class="tr-step <?= $cls ?>">
                           <div class="tr-dot">
                              <?php if ($ada && $i < $idx) : ?>
                                 <i class="fa fa-check"></i>
                              <?php else : ?>
                                 <?= str_pad($i + 1, 2, '0', STR_PAD_LEFT) ?>
                              <?php endif; ?>
                           </div>
                           <h3><?= $s['nama'] ?></h3>
                           <p class="tr-ket"><?= $s['ket'] ?></p>
                           <?php if ($ada) : ?>
                              <div class="tr-meta">
                                 <span class="tr-waktu"><?= tr_val($d, 'waktu') ?></span>
                                 <?php if (!empty($d['lokasi'])) : ?>
                                    <i class="fa fa-map-marker"></i> <?= $d['lokasi'] ?>&nbsp;&nbsp;
                                 <?php endif; ?>
                                 <?php if (!empty($d['petugas'])) : ?>
                                    <i class="fa fa-user-o"></i> <?= $d['petugas'] ?>
                                 <?php endif; ?>
                              </div>
                              <?php if (!empty($d['catatan'])) : ?>
                                 <p class="tr-ket m-t-5"><em><?= $d['catatan'] ?></em></p>
                              <?php endif; ?>
                           <?php else : ?>
                              <div class="tr-meta" style="color:#b3b3b3;">Menunggu</div>
                           <?php endif; ?>
                        </div>
                     <?php endforeach; ?>
                  </div>

               </div>

            <?php else : ?>

               <!-- ================= BELUM ADA PENCARIAN ================= -->
               <div class="track-card tr-empty">
                  <i class="fa fa-cube"></i>
                  <div class="tr-head m-t-15">Belum Ada SMU Yang Dilacak</div>
                  <p class="m-t-8">Masukkan nomor SMU di kolom di atas untuk melihat posisi barang,<br>dari diterima di gudang sampai pesawat berangkat.</p>
               </div>

            <?php endif; ?>

            <br>
            <div class="text-center tr-foot">
               <font color="white">
                  <a href="<?= base_url('login') ?>">Masuk sebagai petugas</a><br><br>
                  IT KODESIS &copy;2024 <br> KODESIS 1.0
               </font>
            </div>

         </div>

      </div>

   </div>

   <!--===============================================================================================-->

   <script src="<?php echo base_url(); ?>login_lib/vendor/jquery/jquery-3.2.1.min.js"></script>

   <script src="<?php echo base_url(); ?>login_lib/vendor/bootstrap/js/popper.js"></script>

   <script src="<?php echo base_url(); ?>login_lib/vendor/bootstrap/js/bootstrap.min.js"></script>

   <script src="<?php echo base_url(); ?>login_lib/js/main.js"></script>

   <script>
      $(document).ready(function() {
         var persen = <?= (int) $persen ?>;
         setTimeout(function() {
            $('#railFill').css('width', persen + '%');
            $('#railPlane').css('left', persen + '%');
         }, 150);
      });
   </script>

</body>

</html>