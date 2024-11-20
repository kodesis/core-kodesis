<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title_pdf; ?></title>
    <style>
        body {
            font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
            font-size: 8pt;
        }

        #table {
            /* font-family: "Trebuchet MS", Arial, Helvetica, sans-serif; */
            border-collapse: collapse;
            width: 100%;


        }

        #table td,
        #table th {
            border: 1px solid #000;
            padding: 2px;
        }

        /* #table tr:nth-child(even) {
            background-color: #f2f2f2;
        } */

        /* #table tr:hover {
            background-color: #ddd;
        } */

        #table th {
            padding-top: 1px;
            padding-bottom: 1px;
            text-align: center;
            background-color: #ddd;
            color: black;
        }

        td {
            vertical-align: middle;
            padding-top: 1px;
            padding-bottom: 1px;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }
    </style>
</head>

<body>
    <?php
    $month = substr($invoice['tanggal_invoice'], 5, 2);
    $year = substr($invoice['tanggal_invoice'], 2, 2);
    ?>
    <table style="margin-bottom: 30px; width: 100%">
        <tbody>
            <tr>
                <td style="width: 110px;">
                    <img src="<?= base_url(); ?>img/logo-kodesis.png" style="width: 100px;" alt="">
                </td>
                <td>PT. Kode Sistem Indonesia<br>Jalan bukit cinere D/186 RT 04 RW 02 Kec. Cinere Kab. Depok<br>0896-2555-1238</td>
                <td style="text-align: right; vertical-align:middle">Invoice No. : <?= $invoice['no_invoice'] ?>/KSI/<?= intToRoman($month) ?>/<?= $year ?></td>
            </tr>
        </tbody>
    </table>
    <table style="width: 100%;">

        <tbody>
            <tr>
                <td width="10%" style="vertical-align: top;">
                    <strong>Kepada </strong><br>
                </td>
                <td width="50%" style="vertical-align: top;">: <?= $invoice['nama_customer'] ?></td>
                <td width="10%" style="vertical-align: top;">
                    <strong>Tanggal </strong><br>
                </td>
                <td width="30%" style="vertical-align: top;">: <?= format_indo($invoice['tanggal_invoice']) ?></td>
            </tr>
            <tr>
                <td style="vertical-align: top;">
                    <strong>Alamat </strong><br>
                </td>
                <td style="vertical-align: top;">: <?= $invoice['alamat_customer'] ?></td>
                <!-- <td style="vertical-align: top;">
                    <strong>Service </strong><br>
                </td>
                <td style="vertical-align: top;">: Port to Port</td> -->
            </tr>
        </tbody>
    </table>
    <p style="width: 450px;">
    </p>
    <h3 style="text-align: center;">INVOICE</h3>
    <?php
    if ($invoice['jenis_invoice'] == "reguler") {
    ?>
        <table id="table" style="width: 100%; font-size: 7pt">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Date</th>
                    <th>AWB</th>
                    <th>Flight Number</th>
                    <th>Dest.</th>
                    <th>Coly</th>
                    <th>Act.</th>
                    <th>CW</th>
                    <th>Rate</th>
                    <th>Total</th>
                    <th>AWB Fee</th>
                    <th>Total Amount</th>
                    <!-- <th>Keterangan</th> -->
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                $total_qty = 0;
                $total_actual_weight = 0;
                $total_chargeable_weight = 0;
                foreach ($details as $d) :
                ?>
                    <tr>
                        <td class="text-center"><?= $no++ ?>.</td>
                        <td class="text-center"><?= format_indo($d->item_date) ?></td>
                        <td class="text-center"><?= $d->item ?></td>
                        <td class="text-center"><?= $d->flight_number ?></td>
                        <td class="text-center"><?= $d->destination ?></td>
                        <td class="text-right"><?= number_format($d->qty) ?></td>
                        <td class="text-right"><?= number_format($d->actual_weight) ?></td>
                        <td class="text-right"><?= number_format($d->chargeable_weight) ?></td>
                        <td class="text-right"><?= number_format($d->harga) ?></td>
                        <td class="text-right"><?= number_format($d->total) ?></td>
                        <td class="text-right"><?= number_format($d->awb_fee) ?></td>
                        <td class="text-right"><?= number_format($d->total_amount) ?></td>
                        <!-- <td></td> -->
                    </tr>
                <?php
                    $total_qty += $d->qty;
                    $total_actual_weight += $d->actual_weight;
                    $total_chargeable_weight += $d->chargeable_weight;
                endforeach;
                ?>
                <tr>
                    <td class="" colspan="5"><strong>SUBTOTAL</strong></td>
                    <td class="text-right"><strong><?= number_format($total_qty) ?></strong></td>
                    <td class="text-right"><strong><?= number_format($total_actual_weight) ?></strong></td>
                    <td class="text-right"><strong><?= number_format($total_chargeable_weight) ?></strong></td>
                    <td colspan="3"></td>
                    <td class="text-right"><strong><?= number_format($invoice['subtotal']) ?></strong></td>
                </tr>
                <!-- <tr>
                    <td class="" colspan="11">DISKON <?= $invoice['diskon'] * 100 ?>%</td>
                    <td class="text-right"><?= number_format($invoice['besaran_diskon']) ?></td>
                </tr> -->
                <tr>
                    <td class="" colspan="11">VAT <?= $invoice['ppn'] * 100 ?>%</td>
                    <td class="text-right"><?= number_format($invoice['besaran_ppn']) ?></td>
                </tr>
                <tr>
                    <td class="" colspan="11"><strong>GRAND TOTAL</strong></td>
                    <td class="text-right"><strong><?= number_format($invoice['total_nonpph']) ?></strong></td>
                </tr>
                <tr>
                    <td colspan="12"><strong><?= terbilang($invoice['total_nonpph']) ?> Rupiah</strong></td>
                </tr>
            </tbody>
        </table>
    <?php
    } else { ?>
        <table id="table">
            <thead>
                <tr>
                    <th style="width: 10%">No.</th>
                    <th style="width: 50%">Keterangan</th>
                    <th style="width: 20%">Item</th>
                    <th>Total Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                foreach ($details as $d) :
                ?>
                    <tr>
                        <td><?= $no++ ?>.</td>
                        <td><?= $d->item ?></td>
                        <td><?= ($d->qty) ?></td>
                        <td class="text-right"><?= number_format($d->total_amount) ?></td>
                    </tr>
                <?php
                endforeach;
                ?>
                <tr>
                    <td class="" colspan="3"><strong>SUBTOTAL</strong></td>
                    <td class="text-right"><?= number_format($invoice['subtotal']) ?></td>
                </tr>
                <tr>
                    <!-- <td class="" colspan="3"><strong>VAT <?= $invoice['ppn'] * 100 ?>%</strong></td> -->
                    <td class="" colspan="3"><strong>PPN 11%</strong></td>
                    <td class="text-right"><?= number_format($invoice['besaran_ppn']) ?></td>
                </tr>
                <tr>
                    <td class="" colspan="3"><strong>GRAND TOTAL</strong></td>
                    <td class="text-right"><?= number_format($invoice['total_nonpph']) ?></td>
                </tr>
                <tr>
                    <td colspan="4"><strong><?= terbilang($invoice['total_nonpph']) ?> Rupiah</strong></td>
                </tr>
            </tbody>
        </table>
    <?php
    } ?>

    <table style="width: 100%;">
        <tbody>
            <tr>
                <td colspan="3" style="border: 0px; vertical-align: bottom">
                    <p>
                        Pembayaran Transfer ke: <br>
                        Bank BCA 3753002304<br>
                        Kode Sistem Indonesia
                    </p>
                </td>
                <td colspan="2" style="border: 0px; text-align: center;">
                    <p style="margin-top: 20px;">Finance</p>
                    <p style="margin-top: 100px;"><?= $user['nama'] ?></p>
                </td>
            </tr>
        </tbody>
    </table>
</body>

</html>