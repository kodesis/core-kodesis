<!DOCTYPE html>
<html>

<head>
  <title>Document</title>
  <style type="text/css">
    div.polaroid {
      width: 10%;
      background-color: white;
      box-shadow: 4px rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
    }

    p {
      margin: 0 !important;
      padding: 0 !important;
    }

    td {
      padding: 0 3px;
    }

    body {
      font: 12pt "Times New Roman", Times, serif;
      line-height: 1.3;
    }

    .header,
    .header-space {
      display: none;
    }

    .footer,
    .footer-space {
      display: none;
    }

    @page {
      size: A4;
    }

    @media print {
      .surat {
        margin: 0 10mm;
      }

      .header,
      .header-space {
        width: 100%;
        padding: 30px 0 120px;
        display: block;
      }

      .footer,
      .footer-space {
        width: 100%;
        padding: 100px 0 0;
        display: block;
      }
    }

    .header {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
    }

    .footer {
      position: fixed;
      bottom: 0;
      left: 0;
      right: 0;
    }

    tfoot {
      display: table-footer-group;
      left: 0;
      right: 0;
      bottom: 0;
    }

    thead {
      display: table-header-group;
    }
  </style>
</head>

<body>
  <div class="container">
    <table class="surat" width="90%">
      <thead>
        <tr>
          <!-- <td>
          <img src="<?= base_url('src/images/surat/becampus.png') ?>" alt="header" id="header" class="header">
        </td> -->
          <td>
            <div class="header-space">&nbsp;</div>
          </td>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>
            <div style="margin: 0 0 20px 0;">
              <?php
              if ($surat['date_keluar']) {
                $tgl = tgl_indo(date('Y-m-d', strtotime($surat['date_keluar'])));
              } else {
                $tgl = "";
              }
              ?>
              <?= $surat['alamat_surat'] ?>, <?= $tgl ?>
            </div>
          </td>
        </tr>
        <tr>
          <td style="padding: 0 !important; margin: 0 !important">
            <table>
              <tr>
                <td>Nomor Surat</td>
                <td class="titik2">:</td>
                <td><?= $surat['nomor_surat'] ? $surat['nomor_surat'] : '0000' . '/' . $surat['format'] . '/bulan/tahun' ?></td>
              </tr>
              <tr>
                <td>Lampiran</td>
                <td>:</td>
                <td> <?= $surat['lampiran'] ? $surat['lampiran'] . " (Lembar)" : '-' ?></td>
              </tr>
              <tr>
                <td>Hal</td>
                <td>:</td>
                <td><?= $surat['perihal'] ?></td>
              </tr>
            </table>
          </td>
        </tr>
        <tr>
          <td>
            <div class="tujuan" style="margin-top: 20px">
              Kepada Yth:
              <?= preg_replace("/<br\W*?\/?>/", "\n", $surat['kepada']) ?>
              <?= preg_replace("/<br\W*?\/?>/", "\n", $surat['alamat']) ?>
            </div>
          </td>
        </tr>
        <tr>
          <td>
            <div class="isi" style="margin-top: 5px; text-align: justify; white-space: pre-line;">
              <?= $surat['isi'] ?>
            </div>
          </td>
        </tr>
        <tr>
          <td>
            <div class="ttd" id="ttd" style="margin-top: 10px;">
              Hormat Kami,<br>
              <?= $surat['perusahaan'] ?>
              <br><br><br><br><br>
              <b><u><?= $surat['nama'] ?></u></b>
              <br>
              <?= $surat['nama_jabatan'] ?>
            </div>
          </td>
        </tr>
      </tbody>
      <tfoot>
        <tr>
          <!-- <td>
          <img src="<?= base_url('src/images/surat/becampus.png') ?>" alt="footer" id="footer" class="footer">
        </td> -->
          <td>
            <div class="footer-space">&nbsp;</div>
          </td>
        </tr>
      </tfoot>
    </table>

    <div class="header">
      <img src="<?= base_url('src/images/surat/header/') . $surat['header'] ?>" alt="header" width="100%">
    </div>
    <div class="footer">
      <?php if ($surat['footer']) { ?>
        <img src="<?= base_url('src/images/surat/footer/') . $surat['footer'] ?>" alt="footer" width="100%">
      <?php } ?>
    </div>

    <div class="row">
      <div class="polaroid">
        <img src="<?php echo base_url(); ?>app/qrcode_letter/<?php echo $surat['id']; ?>" alt="5 Terre" style="width:100%">
      </div>
    </div>
  </div>

  <!-- jQuery -->
  <script src="<?php echo base_url(); ?>src/vendors/jquery/dist/jquery.min.js"></script>
</body>

</html>