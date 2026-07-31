<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <style>
        td {
            font-family: "Verdana", "Arial";
            font-size: 12pt;
            color: #000000;
            text-decoration: none;
        }

        th {
            font-family: "Verdana", "Arial";
            font-size: 13pt;
            color: #000000;
            text-decoration: none;
        }

        @page {
            size: A4;
            margin: 10mm;
        }

        table.tbl-smu {
            border-collapse: collapse;
        }

        table.tbl-smu td {
            border: 1px solid #000;
        }
    </style>
</head>

<body style="width:240mm; max-width:240mm;">

    <!-- HEADER -->
    <table border="0" style="width:100%; max-width:240mm;" cellpadding="3">
        <tr>
            <td colspan="3" align="center"><b>INVOICE</b></td>
        </tr>
        <tr>
            <td width="30%">
                <?= $corp_logo ?><br>
                PT. BANGUN DESA TEKNOLOGI<br>
                BANDARA LANUD HALIM PERDANA KUSUMA<br>
                Tel: (021) 22080 2395
            </td>
            <td width="30%">
                <br><br><br>
                <b>KEPADA :</b><br>
                <?= $nama_agent ?><br>
                <?= $billing->alamat ?><br>
                <?= $billing->telepon ?>
            </td>
            <td width="40%">
                <br><br><br>
                No. Invoice : <?= $billing->no_invoice ?><br>
                Tanggal Invoice : <?= $pm_billing_date_txt ?><br>
                No. NPWP : 03.313.653.2-015.000
            </td>
        </tr>
    </table>

    <!-- LIST SMU -->
    <table width="100%" cellspacing="0" border="2" cellpadding="3" class="tbl-smu">
        <tr>
            <td height="40" align="center"><b>No</b></td>
            <td align="center"><b>SMU</b></td>
            <td align="center"><b>Tujuan</b></td>
            <td align="center"><b>Komoditi</b></td>
            <td align="center"><b>Koli</b></td>
            <td align="center"><b>Berat (Kg)</b></td>
            <td align="center"><b>Biaya Gudang</b></td>
        </tr>
        <?php foreach ($list_billing as $i => $s): ?>
            <tr>
                <td height="30" align="center"><?= $i + 1 ?></td>
                <td><?= $s->smu ?></td>
                <td align="center"><?= $s->tujuan ?></td>
                <td align="center"><?= $s->komoditi ?></td>
                <td align="center"><?= $s->jumlah ?></td>
                <td align="right"><?= (float)$s->chargeable ?></td>
                <td align="right"><?= number_format($s->sewa_gudang) ?></td>
            </tr>
        <?php endforeach; ?>
        <tr>
            <td colspan="4" height="30" align="center">Total</td>
            <td align="center"><?= $total_pieces_k ?></td>
            <td align="right"><?= $total_chargeable_k ?></td>
            <td align="right"><b><?= $total_sewa_gudang_k ?></b></td>
        </tr>
    </table>

    <!-- BIAYA GUDANG -->
    <table width="100%" border="1" cellspacing="0" cellpadding="1" class="tbl-smu">
        <tr>
            <td>SUBTOTAL</td>
            <td align="right"><?= $total_sewa_gudang_k ?></td>
        </tr>
        <tr>
            <td>CARGO DEVELOPMENT CHARGE</td>
            <td align="right"><?= $upd_total_cdc ?></td>
        </tr>
        <tr>
            <td>PPN 11%</td>
            <td align="right"><?= $bg_ppn_k ?></td>
        </tr>
        <tr>
            <td>ADMINISTRASI</td>
            <td align="right"><?= $administrasi_k ?></td>
        </tr>
        <tr>
            <td>MATERAI</td>
            <td align="right"><?= $materai_k ?></td>
        </tr>
        <tr>
            <td><b>SUB TOTAL</b></td>
            <td align="right"><b><?= $bg_total_k ?></b></td>
        </tr>
    </table>
    <br>

    <!-- BIAYA KC -->
    <table width="100%" border="1" cellspacing="0" cellpadding="3" class="tbl-smu">
        <?php if ($jaster_opt != '0'): ?>
            <tr>
                <td>JASTER <?= $jaster_opt ?></td>
                <td align="right"><?= $jaster_rate_k ?></td>
                <td align="right"><?= $total_chargeable_k ?></td>
                <td align="right"><?= $total_jaster_k ?></td>
            </tr>
        <?php endif; ?>
        <tr>
            <td>Jasa Terminal Handling</td>
            <td align="right"><?= $kade_k ?></td>
            <td align="right"><?= $total_chargeable_k ?></td>
            <td align="right"><?= $total_kade_k ?></td>
        </tr>
        <tr>
            <td>BIAYA CSC</td>
            <td align="right"><?= $csc_k ?></td>
            <td align="right"><?= $total_chargeable_k ?></td>
            <td align="right"><?= $total_csc_k ?></td>
        </tr>
        <tr>
            <td>TOTAL</td>
            <td colspan="3" align="right"><b><?= $kc_sub_total_k ?></b></td>
        </tr>
        <tr>
            <td>PPN 11%</td>
            <td colspan="3" align="right"><?= $kc_ppn_k ?></td>
        </tr>
        <tr>
            <td><b>SUBTOTAL</b></td>
            <td colspan="3" align="right"><b><?= $kc_total_k ?></b></td>
        </tr>
        <tr>
            <th>GRAND TOTAL</th>
            <td colspan="3" align="right"><b><?= $grand_total_k ?></b></td>
        </tr>
        <tr>
            <td colspan="4">
                Terbilang<br>
                <?= $billing->terbilang ?>
            </td>
        </tr>
    </table>

    <!-- TTD -->
    <table width="100%" cellspacing="0" cellpadding="3">
        <tr>
            <td colspan="2" height="10"></td>
        </tr>
        <tr>
            <td colspan="2" align="right">
                HLP, <?= $pm_billing_date_txt ?><br><br><br>
                ( <?= $kasir_name ?> )
            </td>
        </tr>
    </table>

    <!-- <p>Pembayaran dapat ditransfer melalui No. Rekening Bank Central Asia (BCA) 375-8420-835<br>
        atas nama PT. Elite Kargo Signature</p> -->

    <?php if ($btb): ?>

        <!-- <div style="page-break-before: always;"></div> -->

        <!-- HEADER BTB -->
        <table border="0" style="width:100%; max-width:240mm;">
            <tr>
                <td colspan="2" align="center">
                    <b><u>BUKTI TIMBANG BARANG</u></b><br><?= $btb_no ?>
                </td>
            </tr>
            <tr>
                <td colspan="3" height="35">&nbsp;</td>
            </tr>
            <tr>
                <td height="40">
                    <table>
                        <tr>
                            <td>Kepada Yth.</td>
                            <td>:</td>
                            <td><?= $btb->nama ?></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <!-- LIST SMU BTB -->
        <table width="100%" cellspacing="0" border="1" cellpadding="3" class="tbl-smu">
            <tr>
                <td height="40" align="center"><b>No</b></td>
                <td align="center"><b>SMU</b></td>
                <td align="center"><b>Tujuan</b></td>
                <td align="center"><b>Flight</b></td>
                <td align="center"><b>Koli</b></td>
                <td align="center"><b>Berat (Kg)</b></td>
                <td align="center"><b>Volume (Kg)</b></td>
                <td align="center"><b>Dimensi</b></td>
            </tr>
            <?php foreach ($list_btb as $i => $s): ?>
                <tr>
                    <td height="30" align="center"><?= $i + 1 ?></td>
                    <td><?= $s->smu ?></td>
                    <td align="center"><?= $s->tujuan ?></td>
                    <td><?= $s->no_pesawat ?>/<?= date('d-m-Y', strtotime($s->tanggal_terbang)) ?></td>
                    <td align="center"><?= $s->jumlah ?></td>
                    <td align="right"><?= number_format($s->gross) ?></td>
                    <td align="right"><?= number_format($s->volume) ?></td>
                    <td>
                        <?php foreach ($s->dimensi as $d): ?>
                            <?= $d->dimensi ?>/<?= $d->pieces ?>&nbsp;
                        <?php endforeach; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="4" height="30" align="center">Total</td>
                <td align="center"><?= number_format($btb->total_pieces) ?></td>
                <td align="right"><?= number_format($btb->total_gross) ?></td>
                <td align="right"><?= number_format($btb->total_volume) ?></td>
                <td>&nbsp;</td>
            </tr>
        </table>
        <br><br>

        <!-- TTD BTB -->
        <table style="width:100%; max-width:240mm;">
            <tr>
                <td align="left">ACCEPTANCE</td>
                <td align="right">PENGIRIM</td>
            </tr>
            <tr>
                <td colspan="2">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="2">&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;&nbsp;<?= $btb_name ?></td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td align="left">----------------------------</td>
                <td align="right">---------------------</td>
            </tr>
        </table>

        <p>Pembayaran dapat ditransfer melalui No. Rekening Bank Central Asia (BCA) 375-8420-835<br>
            atas nama PT. Elite Kargo Signature</p>

    <?php endif; ?>

    <script>
        window.print();
    </script>

</body>

</html>