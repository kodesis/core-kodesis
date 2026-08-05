<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: "Verdana", "Arial";
            font-size: 10pt;
            color: #000000;
            width: 240mm;
            height: 270mm;
            max-width: 240mm;
            max-height: 270mm;
        }

        td {
            font-family: "Verdana", "Arial";
            font-size: 10pt;
            color: #000000;
        }
    </style>
</head>

<body>

    <table border="0" width="100%" style="max-width:240mm;">

        <!-- HEADER KOSONG (untuk kop surat) -->
        <tr>
            <td>
                <table border="0" width="100%" cellspacing="2" cellpadding="2">
                    <tr>
                        <td width="20%" height="150px">&nbsp;</td>
                        <td style="font-size:15pt;" align="center"><b>&nbsp;<br>&nbsp;</b></td>
                    </tr>
                </table>
            </td>
        </tr>

        <!-- INFO NO CH, SEGEL, STICKER -->
        <tr>
            <td>
                <table border="0" width="100%" cellspacing="0" cellpadding="0">
                    <tr>
                        <td style="width:50%;"></td>
                        <td style="width:50%;">
                            <table border="0" width="100%" cellspacing="1" cellpadding="1">
                                <tr>
                                    <td align="right">STC No (Cargo Handover No)</td>
                                    <td>:</td>
                                    <td><?= $header->no_ch ?></td>
                                </tr>
                                <tr>
                                    <td align="right">Dikirim Jam (Sent at)</td>
                                    <td>:</td>
                                    <td><?= $tgl_ch ?> <?= $time ?></td>
                                </tr>
                                <tr>
                                    <td align="right">No Segel (Seal No.)</td>
                                    <td>:</td>
                                    <td><?= $header->no_segel ?></td>
                                </tr>
                                <tr>
                                    <td align="right">No. Sticker (Sticker No.)</td>
                                    <td>:</td>
                                    <td><?= $header->no_sticker ?></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <!-- TANGGAL, NO POLISI, WAREHOUSE -->
        <tr>
            <td>
                <table border="0" width="100%" cellspacing="0" cellpadding="0">
                    <tr>
                        <td style="width:50%;">
                            <table border="0" width="100%" cellspacing="2" cellpadding="2">
                                <tr>
                                    <td>Tanggal (Date)</td>
                                    <td>:</td>
                                    <td><?= $tgl_ch ?> <?= $time ?></td>
                                </tr>
                                <tr>
                                    <td>No. Polisi (Vehicle No)</td>
                                    <td>:</td>
                                    <td><?= $header->no_polisi ?></td>
                                </tr>
                            </table>
                        </td>
                        <td style="width:50%;">
                            <table border="0" width="100%" cellspacing="2" cellpadding="2">
                                <tr>
                                    <td align="center"><b>WAREHOUSE :</b></td>
                                </tr>
                                <tr>
                                    <td align="center"><b><?= $wh ?></b></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <!-- TABLE LIST SMU -->
        <tr>
            <td>
                <table border="1" width="100%" cellspacing="0" cellpadding="2">
                    <tr>
                        <td align="center">No</td>
                        <td align="center">SMU</td>
                        <td align="center">Qty</td>
                        <td align="center">Weight</td>
                        <td align="center">Commodity</td>
                        <td align="center">Airline</td>
                        <td align="center">Agent/Shipper</td>
                        <td align="center">Dest</td>
                    </tr>
                    <?php foreach ($list as $i => $r): ?>
                        <tr>
                            <td align="center"><?= $i + 1 ?></td>
                            <td align="left"><?= $r->smu ?></td>
                            <td align="right"><?= $r->qty ?></td>
                            <td align="right"><?= $r->weight ?></td>
                            <td><?= $r->commodity ?></td>
                            <td><?= $r->airline ?></td>
                            <td><?= $r->agent ?></td>
                            <td><?= $r->destin ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="2" align="center">TOTAL</td>
                        <td align="right"><?= $total_koli_k ?></td>
                        <td align="right"><?= $total_berat_k ?></td>
                        <td colspan="4"></td>
                    </tr>
                </table>
            </td>
        </tr>

        <!-- PETUGAS, DRIVER, REMARK -->
        <tr>
            <td>
                <table border="0" width="100%" cellspacing="2" cellpadding="2">
                    <tr>
                        <td width="25%">PETUGAS DO : <?= $header->user_name ?></td>
                        <td>DRIVER : <?= $header->user_driver ?></td>
                    </tr>
                    <tr>
                        <td colspan="2">REMARK : <?= $header->remark ?></td>
                    </tr>
                    <tr>
                        <td>Print Date: <?= $tgl_ch ?></td>
                        <td>Time : <?= $p_time ?></td>
                    </tr>
                </table>
            </td>
        </tr>

        <!-- PADDING ROWS JIKA DATA < 26 -->
        <?php if (count($list) < 15):
            $row = 15 - count($list); ?>
            <tr>
                <td>
                    <table width="100%" cellspacing="0" cellpadding="0">
                        <?php for ($i = 0; $i < $row; $i++): ?>
                            <tr>
                                <td height="20" colspan="9"></td>
                            </tr>
                        <?php endfor; ?>
                    </table>
                </td>
            </tr>
        <?php endif; ?>

        <!-- TTD -->
        <tr>
            <td><br><br><br>
                <table border="0" width="100%" cellspacing="2" cellpadding="2">
                    <tr>
                        <td></td>
                        <td align="center"><b>AIRLINES/GROUND HANDLING</b></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td><br>
                <table border="0" width="100%" cellspacing="2" cellpadding="2">
                    <tr>
                        <td colspan="2"></td>
                        <td colspan="2">Diserahkan Jam (Submit at) :</td>
                    </tr>
                    <tr>
                        <td>Shipper</td>
                        <td align="center">Pengemudi</td>
                        <td align="center">Petugas DO</td>
                        <td align="right">Petugas Gudang</td>
                    </tr>
                    <tr>
                        <td colspan="4">&nbsp;<br><br><br><br></td>
                    </tr>
                    <tr>
                        <td>
                            <div style="border-bottom:1px solid #000; width:125px;"></div>
                        </td>
                        <td align="center">
                            <div style="border-bottom:1px solid #000; width:200px;"><?= $header->user_driver ?></div>
                        </td>
                        <td align="center">
                            <div style="border-bottom:1px solid #000; width:200px;"><?= $header->user_name ?></div>
                        </td>
                        <td align="right">
                            <div style="border-bottom:1px solid #000; width:125px;"></div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <!-- LEMBAR -->
        <tr>
            <td>
                <table border="0" width="40%" cellspacing="0" cellpadding="0">
                    <tr>
                        <td style="font-size:8pt;">Lembar I</td>
                        <td>:</td>
                        <td style="font-size:8pt;">PT. Bangun Desa Teknologi</td>
                    </tr>
                    <tr>
                        <td style="font-size:8pt;">Lembar II</td>
                        <td>:</td>
                        <td style="font-size:8pt;">Airline/Ground Handling</td>
                    </tr>
                    <tr>
                        <td style="font-size:8pt;">Lembar III</td>
                        <td>:</td>
                        <td style="font-size:8pt;">Extra Copy</td>
                    </tr>
                    <tr>
                        <td style="font-size:8pt;">Lembar IV</td>
                        <td>:</td>
                        <td style="font-size:8pt;"></td>
                    </tr>
                </table>
            </td>
        </tr>

    </table>

    <script type="text/javascript">
        window.print();
    </script>

</body>

</html>