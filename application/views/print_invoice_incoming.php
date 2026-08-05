<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <style>
        td {
            font-family: "Verdana", "Arial";
            font-size: 11pt;
            color: #000000;
            text-decoration: none;
        }

        th {
            font-family: "Verdana", "Arial";
            font-size: 12pt;
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

<body style="width:235mm; max-width:235mm;">

    <!-- HEADER INVOICE -->
    <table border="0" style="width:100%; max-width:235mm;" cellpadding="0">
        <tr>
            <td colspan="3" align="center"><b>INVOICE</b></td>
        </tr>
        <tr>
            <td width="30%">
                <?= $corp_logo ?><br>
                PT. BANGUN DESA TEKNOLOGI<br>
                BANDARA LANUD HALIM PERDANA KUSUMA<br>
                Tel: (021) 2280 2395
            </td>
            <td width="30%">
                <br><br><br>
                <b>KEPADA YTH. :</b><br>
                <?= $billing->nama ?><br>
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
    <table width="100%" cellspacing="0" border="1" cellpadding="0" class="tbl-smu">
        <tr>
            <td height="40" align="center"><b>No</b></td>
            <td align="center"><b>SMU</b></td>
            <td align="center"><b>Asal/Tujuan</b></td>
            <td align="center"><b>Komoditi</b></td>
            <td align="center"><b>Koli</b></td>
            <td align="center"><b>Berat (Kg)</b></td>
            <?php if ($billing->hari > 0): ?>
                <td align="center"><b>Days</b></td>
            <?php endif; ?>
            <td align="center"><b>Biaya Gudang</b></td>
        </tr>
        <?php foreach ($list_billing as $i => $s): ?>
            <tr>
                <td height="30" align="center"><?= $i + 1 ?></td>
                <td><?= $s->smu ?></td>
                <td align="center"><?= $s->asal ?>-HLP</td>
                <td align="center"><?= $s->komoditi ?></td>
                <td align="center"><?= $s->jumlah ?></td>
                <td align="right"><?= $s->chargeable ?></td>
                <?php if ($billing->hari > 0): ?>
                    <td align="center"><b><?= number_format($s->hari) ?></b></td>
                <?php endif; ?>
                <td align="right"><?= number_format((float)$s->sewa_gudang) ?></td>
            </tr>
        <?php endforeach; ?>
        <tr>
            <td colspan="4" height="30" align="center">Total</td>
            <td align="center"><?= $total_pieces_k ?></td>
            <td align="right"><?= (float)$total_chargeable_k ?></td>
            <?php if ($billing->hari > 0): ?>
                <td align="center"><b><?= $days_k ?></b></td>
            <?php endif; ?>
            <td align="right"><b><?= $total_sewa_gudang_k ?></b></td>
        </tr>
    </table>

    <!-- BIAYA GUDANG -->
    <table width="100%" border="1" cellspacing="0" cellpadding="0" class="tbl-smu">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Grand Total</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($billing->opsi_dg == '1'): ?>
                <tr>
                    <td>SURCHARGE DG 100%</td>
                    <td align="right"><b><?= number_format($billing->nominal_surcharge_dg) ?></b></td>
                </tr>
            <?php endif; ?>
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
        </tbody>
        <tfoot>
            <tr>
                <td><b>SUB TOTAL</b></td>
                <td align="right"><b><?= $bg_total_k ?></b></td>
            </tr>
        </tfoot>
    </table>
    <br>

    <!-- BIAYA KC -->
    <table width="100%" border="1" cellspacing="0" cellpadding="0" class="tbl-smu">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Harga</th>
                <th>Charge Weight</th>
                <th>Total Harga</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Jasa Terminal Handling</td>
                <td align="right"><?= $kade_k ?></td>
                <td align="right"><?= (float)$total_chargeable_k ?></td>
                <td align="right"><?= $total_kade_k ?></td>
            </tr>
            <tr>
                <td>BIAYA CSC</td>
                <td align="right"><?= $csc_k ?></td>
                <td align="right"><?= (float)$total_chargeable_k ?></td>
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
        </tbody>
        <tfoot>
            <tr>
                <th>GRAND TOTAL</th>
                <td colspan="3" align="right"><b><?= $grand_total_k ?></b></td>
            </tr>
            <tr>
                <td colspan="4">
                    Terbilang<br><?= $terbilang ?>
                </td>
            </tr>
        </tfoot>
    </table>

    <!-- TTD INVOICE -->
    <table width="100%" cellspacing="0" cellpadding="3">
        <tr>
            <td colspan="2" height="8"></td>
        </tr>
        <tr>
            <td colspan="2" align="right">
                HLP, <?= $pm_billing_date_txt ?><br><br><br><br><br><br>
                ( <?= $kasir_name ?> )
            </td>
        </tr>
    </table>

    <p>* Minimum Charges For Storage IDR 25.000 / Airwaybill</p>
    <p>Pembayaran dapat ditransfer melalui No. Rekening Bank Central Asia (BCA) 375-8420-835<br>
        atas nama PT. Elite Kargo Signature</p>

    <!-- ================================== -->
    <!-- SURAT JALAN -->
    <!-- ================================== -->
    <style>
        /* td {
            font-family: "Verdana", "Arial";
            font-size: 9pt;
            color: #000000;
        }

        th {
            font-family: "Verdana", "Arial";
            font-size: 10pt;
            color: #000000;
        } */
    </style>

    <table border="0" style="width:100%; max-width:235mm;">
        <tr>
            <td colspan="2" align="center">
                <b><u>SURAT JALAN</u></b><br><?= $sj_no ?>
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
                        <td><?= $billing->nama ?></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="2" height="15"></td>
        </tr>
    </table>

    <!-- LIST SMU SURAT JALAN -->
    <table width="100%" cellspacing="0" border="1" cellpadding="5" class="tbl-smu">
        <tr>
            <td height="40" align="center"><b>No</b></td>
            <td align="center"><b>SMU</b></td>
            <td align="center"><b>Asal/Tujuan</b></td>
            <td align="center"><b>Koli</b></td>
            <td align="center"><b>Berat Aktual (Kg)</b></td>
            <td align="center"><b>Chargeable (Kg)</b></td>
        </tr>
        <?php foreach ($list_billing as $i => $s): ?>
            <tr>
                <td height="30" align="center"><?= $i + 1 ?></td>
                <td><?= $s->smu ?></td>
                <td align="center"><?= $s->asal ?>-HLP</td>
                <td align="center"><?= number_format((float)$s->jumlah) ?></td>
                <td align="right"><?= number_format((float)$s->gross) ?></td>
                <td align="right"><?= number_format((float)$s->chargeable) ?></td>
            </tr>
        <?php endforeach; ?>
        <tr>
            <td colspan="3" height="30" align="center">Total</td>
            <td align="center"><?= $total_pieces_k ?></td>
            <td align="right"><?= number_format(array_sum(array_column((array)$list_billing, 'gross'))) ?></td>
            <td align="right"><?= $total_chargeable_k ?></td>
        </tr>
    </table>
    <br><br>

    <!-- TTD SURAT JALAN -->
    <table style="width:100%; max-width:235mm;">
        <tr>
            <td align="left">KASIR</td>
            <td align="center">AVSEC RUKO</td>
            <td align="right">PENERIMA</td>
        </tr>
        <tr>
            <td colspan="3">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="3">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="3">&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;&nbsp;<?= $cdo_name ?></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td align="left">----------------------------</td>
            <td align="center">-------------------</td>
            <td align="right">---------------------</td>
        </tr>
    </table>

    <script>
        window.print();
    </script>

</body>

</html>