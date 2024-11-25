<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title_pdf; ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

    <style>
        h2 {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif !important;
        }

        table {
            border-collapse: collapse;
        }

        /* table,
        th,
        td {
            border: 1px solid black;
        } */
    </style>

</head>

<body>

    <div class="container p-0">
        <?php
        $month = substr($invoice['tanggal_invoice'], 5, 2);
        $year = substr($invoice['tanggal_invoice'], 2, 2);
        ?>

        <div class="row">
            <div class="col-md-12">
                <table class="table" style="margin-bottom: 30px; width: 100%">
                    <tbody>
                        <tr>
                            <td>
                                <img src="<?= base_url(); ?>img/logo-kodesis.png" style="width: 100px;" alt="">
                            </td>
                            <td colspan="2" class="text-end">
                                <p style="font-weight: bold; font-size: 20pt">Invoice</p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="text-end">
                                Referensi <br>
                                Tanggal
                            </td>
                            <td class="text-end" style="width: 25%;">
                                <?= $invoice['no_invoice'] ?>/KSI/<?= intToRoman($month) ?>/<?= $year ?> <br>
                                <?= format_indo($invoice['tanggal_invoice']) ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">

                <table style="width: 100%; margin-bottom: 10px;">
                    <tbody>
                        <tr>
                            <td style="vertical-align:bottom; width: 49%;">
                                <p style="font-weight: bold;">Informasi Perusahaan</p>
                                <hr>
                            </td>
                            <td style="vertical-align:bottom; width: 2%;">
                            </td>
                            <td style="vertical-align:bottom; width: 49%;">
                                <p style="font-weight: bold;">Tagihan Kepada</p>
                                <hr>
                            </td>
                        </tr>
                        <tr>
                            <td style="vertical-align:top">
                                <p style="font-weight: bold;">PT. Kode Sistem Indonesia</p>
                                Jalan bukit cinere D/186 RT 04 RW 02 Kec. Cinere Kab. Depok<br>0896-2555-1238
                            </td>
                            <td style="vertical-align:bottom; width: 2%;">
                            </td>
                            <td style="vertical-align:top">
                                <p style="font-weight: bold;"><?= $invoice['nama_customer'] ?></p>
                                <?= $invoice['alamat_customer'] ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered mt-3">
                    <thead>
                        <tr>
                            <!-- <th style="width: 10%">No.</th> -->
                            <th>Keterangan</th>
                            <th>Item</th>
                            <th>Total Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($details as $d) :
                        ?>
                            <tr>
                                <td><?= $d->item ?></td>
                                <td><?= ($d->qty) ?></td>
                                <td class="text-end"><?= number_format($d->total_amount) ?></td>
                            </tr>
                        <?php
                        endforeach;
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row mt-3">
            <!-- <div class="col-6">
            </div> -->
            <div class="col-md-12">
                <table class="table">
                    <tbody>

                        <tr>
                            <td class="text-end" style="width: 75%"><strong>SUBTOTAL</strong></td>
                            <td class="text-end"><?= number_format($invoice['subtotal']) ?></td>
                        </tr>
                        <tr>
                            <!-- <td class="text-end" style="width: 75%"><strong>VAT <?= $invoice['ppn'] * 100 ?>%</strong></td> -->
                            <td class="text-end" style="width: 75%"><strong>PPN 11%</strong></td>
                            <td class="text-end"><?= number_format($invoice['besaran_ppn']) ?></td>
                        </tr>
                        <tr>
                            <td class="text-end" style="width: 75%"><strong>GRAND TOTAL</strong></td>
                            <td class="text-end"><?= number_format($invoice['total_nonpph']) ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table class="table" style="width: 100%;">
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
                                <p style="margin-top: 70px;"><?= $user['nama'] ?></p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>

</html>