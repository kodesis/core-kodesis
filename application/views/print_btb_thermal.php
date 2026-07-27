<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <style>
        /* @page {
            size: 75mm auto;
            margin: 2mm;
        }

        body {
            width: 75mm;
            margin: 0;
            padding: 0;
        } */

        td,
        th {
            font-family: "Verdana", "Arial";
            font-size: 8pt;
            color: #000000;
            text-decoration: none;
            vertical-align: top;
        }

        @font-face {
            font-family: code39;
            src: url('<?= base_url('src/fonts/Code39.ttf') ?>');
        }
    </style>
</head>

<body style="width:75mm; height:60mm; max-width:75mm; max-height:60mm;">

    <table border="0" style="width:100%; max-width:240mm;" cellpadding="2">
        <tr>
            <td colspan="4" align="center"><b>PT. BANGUN DESA TEKNOLOGI</b></td>
        </tr>
        <tr>
            <td colspan="4" align="center">CARGO WAREHOUSE</td>
        </tr>
        <tr>
            <td colspan="4" align="center"><br></td>
        </tr>
        <tr>
            <td colspan="4" align="center">BUKTI TIMBANG BARANG</td>
        </tr>
        <tr>
            <td colspan="4" align="center">No.BTB</td>
        </tr>
        <tr>
            <td colspan="4" align="center" style="font-size: 10px;">
                <b>HLPO-<?= $row->no ?></b>
            </td>
        </tr>
        <tr>
            <td colspan="2" align="left">Airline</td>
            <td>:</td>
            <td width="150px"><b><?= $row->pesawat ?> (<?= $row->no_pesawat ?>)</b></td>
        </tr>
        <tr>
            <td colspan="2" align="left">Shipper</td>
            <td>:</td>
            <td><b><?= $row->nama ?></b></td>
        </tr>
        <tr>
            <td colspan="2" align="left">No.SMU</td>
            <td>:</td>
            <td><b><?= $row->smu ?></b></td>
        </tr>
        <tr>
            <td colspan="2" align="left">Tujuan</td>
            <td>:</td>
            <td><b><?= $row->tujuan ?></b></td>
        </tr>
        <tr>
            <td colspan="2" align="left">Jenis Barang</td>
            <td>:</td>
            <td><b><?= $row->komoditi ?></b></td>
        </tr>
        <tr>
            <td colspan="2" align="left">Tanggal Terbang</td>
            <td>:</td>
            <td><b><?= $row->tanggal_terbang ?></b></td>
        </tr>
        <tr>
            <td colspan="2" align="left">Tanggal Cetak</td>
            <td>:</td>
            <td><strong><?= $tgl_print ?>&nbsp;<?= $jam_print ?></strong></td>
        </tr>
        <tr>
            <td colspan="2" align="center"><br></td>
        </tr>
    </table>

    <table width="100%" cellspacing="0" border="1" cellpadding="3" style="border-top: 1px solid #000;">
        <tr>
            <td height="20" align="center">Koli</td>
            <td align="center">Berat</td>
            <td align="center">Volume</td>
            <td align="center">Dimensi</td>
        </tr>
        <tr>
            <td align="center"><b><?= $total_pieces_k ?></b></td>
            <td align="center"><b><?= $total_gross_k ?></b></td>
            <td align="center"><b><?= $total_volume_k ?></b></td>
            <td align="center">
                <?php foreach ($dimensi as $d): ?>
                    <?= $d->dimensi ?>/<?= $d->pieces ?><br>
                <?php endforeach; ?>
            </td>
        </tr>
    </table>

    <div align="center"><br></div>
    <div align="center">
        <font face="code39" size="5em">
            *<?= $row->smu ?>*
        </font>
    </div>

    <table border="0" style="width:100%;" cellpadding="2">
        <tr>
            <td colspan="4" align="center">HLP, <?= $pm_btb_date_txt ?></td>
        </tr>
        <tr>
            <td colspan="2" align="center">Acceptance</td>
            <td colspan="2" align="center">Shipper/Agent</td>
        </tr>
        <tr>
            <td colspan="2"><br><br></td>
        </tr>
        <tr>
            <td colspan="2" align="center"><?= $nama_accep ?></td>
            <td colspan="2" align="center"><?= $row->nama ?></td>
        </tr>
    </table>

    <br><br><br>

    <script>
        window.print();
    </script>

</body>

</html>