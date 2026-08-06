<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>CSD - <?= $row->no_csd ?></title>
    <style>
        body {
            font-family: "Verdana", "Arial", sans-serif;
            font-size: 11pt;
            color: #000000;
            text-decoration: none;
            margin: 20px;
        }

        td {
            font-family: "Verdana", "Arial", sans-serif;
            font-size: 11pt;
            color: #000000;
            text-decoration: none;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            font-family: Arial, sans-serif;
            color: #333;
        }

        .data-value {
            font-style: italic;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="row">
        <div class="col-sm-12">
            <table width="95%" border="0">
                <tr>
                    <td align="center">
                        <b>DEKLARASI KEAMANAN KIRIMAN <br> CONSIGNMENT SECURITY DECLARATION (CSD) <br>Nomor : <span class="data-value"><?= $row->no_csd ?></span> </b> &nbsp; <br> &nbsp;<br><br>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table border="1" cellspacing="0" cellpadding="0" width="100%">
                            <tr>
                                <td style="width: 50%;">
                                    <table border="0" cellspacing="3" cellpadding="3" width="100%">
                                        <tr>
                                            <td><img src="<?= base_url('src/images/logo_bdt.jpg') ?>" width="150" onerror="this.onerror=null; this.src='https://placehold.co/150x50/e0e0e0/333333?text=Logo+BDT';"></td>
                                            <td>&nbsp;<br></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" style="font-size: 10pt;">Sertifikat Standar : 15052400247180002&nbsp;</td>
                                        </tr>
                                    </table>
                                </td>
                                <td style="width: 50%;">
                                    <table border="0" cellspacing="4" cellpadding="4" width="100%">
                                        <tr>
                                            <td width="55%">Nomor SMU / AWB <br>(Number of Airway Bill)&nbsp;</td>
                                            <td width="5%">:&nbsp;</td>
                                            <td align="right" width="40%"><b class="data-value"><?= $row->smu ?></b></td>
                                        </tr>
                                        <tr>
                                            <td>Nomor Penerbangan&nbsp;</td>
                                            <td>:&nbsp;</td>
                                            <!-- <td align="right"><b class="data-value"><?= $row->no_pesawat ?></b></td> -->
                                            <td align="right"><b class="data-value"><?= $pesawat ?></b></td>
                                        </tr>
                                        <tr>
                                            <td>Tanggal Penerbangan&nbsp;</td>
                                            <td>:&nbsp;</td>
                                            <td align="right" class="data-value"><?= date('d-m-Y', strtotime($row->tanggal_terbang)) ?></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td><br>
                        <table border="1" cellspacing="0" cellpadding="0" width="100%">
                            <tr>
                                <td>
                                    <b>&nbsp;<i>Contents Of Consignment</i>&nbsp;<br></b>
                                    <table border="1" cellspacing="5" cellpadding="5" width="100%">
                                        <tr style="background-color: #f2f2f2;">
                                            <td align="center" width="10%"><b>No.</b>&nbsp;</td>
                                            <td align="center" width="50%"><b>Jenis/Nama Barang</b>&nbsp;</td>
                                            <td align="center" width="20%"><b>Koli</b>&nbsp;</td>
                                            <td align="center" width="20%"><b>Berat (Weight)</b>&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td align="center">1&nbsp;</td>
                                            <td align="center"><b class="data-value"><?= $row->komoditi ?></b></td>
                                            <td align="center"><b class="data-value"><?= $row->koli_smu ?? 0 ?></b></td>
                                            <td align="center"><b class="data-value"><?= $row->berat_smu ?? 0 ?> kg</b></td>
                                        </tr>
                                        <tr>
                                            <td align="center">2&nbsp;</td>
                                            <td align="center"><b>&nbsp;</b></td>
                                            <td><b>&nbsp;</b></td>
                                            <td><b>&nbsp;</b></td>
                                        </tr>
                                        <tr>
                                            <td align="center">3&nbsp;</td>
                                            <td align="center"><b>&nbsp;</b></td>
                                            <td><b>&nbsp;</b></td>
                                            <td><b>&nbsp;</b></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td><br>
                        <table border="1" cellspacing="0" cellpadding="5" width="100%">
                            <tr>
                                <td width="15%" align="left">
                                    <b>Asal</b><br>
                                    <i>Origin</i>
                                </td>
                                <td width="20%" align="left" style="vertical-align: middle;">
                                    <b>HLP</b>
                                </td>
                                <td width="15%" align="left">
                                    <b>Tujuan</b><br>
                                    <i>Destination</i>
                                </td>
                                <td width="20%" align="left" style="vertical-align: middle;">
                                    <b class="data-value"><?= $row->tujuan ?? '-' ?></b>
                                </td>
                                <td width="30%">
                                    <b>Transfer/Transit</b><br>
                                    <i>Transfer/Transit Points</i>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td><br>
                        <table border="1" cellspacing="0" cellpadding="0" width="100%">
                            <tr>
                                <td style="width: 50%; vertical-align: top; padding: 10px;">
                                    <b>Status Keamanan</b><br>
                                    <i>Security Status</i><br><br>
                                    <table border="1" cellspacing="0" cellpadding="5" width="100%">
                                        <tr>
                                            <td width="15%" align="center" style="height: 30px;"><?= $check_spx ?></td>
                                            <td><i>Passenger Aircraft (SPX) </i>&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td align="center" style="height: 30px;"><?= $check_sco ?></td>
                                            <td><i>Cargo Aircraft Only (SCO)</i>&nbsp;</td>
                                        </tr>
                                    </table>
                                </td>
                                <td style="width: 50%; vertical-align: top;">
                                    <table border="1" cellspacing="0" cellpadding="5" width="100%">
                                        <tr>
                                            <td>
                                                <table cellspacing="0" cellpadding="0" width="100%">
                                                    <tr>
                                                        <td width="70%">
                                                            <b>Alasan diterbitkan status keamanan</b>&nbsp;<br>
                                                            <i>Reason For issuing the security Status</i>&nbsp;
                                                        </td>
                                                        <td align="right" style="vertical-align: middle;">
                                                            <b style="font-size: 14pt;" class="data-value"><?= $alasan ?></b>&nbsp;
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <table border="1" cellspacing="0" cellpadding="0" width="100%">
                                                    <tr>
                                                        <td width="33%">
                                                            <table border="0" cellspacing="0" cellpadding="5" width="100%">
                                                                <tr>
                                                                    <td><b>Diterima dari</b></td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="font-size: 9pt;"><i>Received from (codes)</i></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>-</td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                        <td width="34%">
                                                            <table border="0" cellspacing="0" cellpadding="5" width="100%">
                                                                <tr>
                                                                    <td><b>Metode Pemeriksaan</b></td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="font-size: 9pt;"><i>Screen Methods 100%</i></td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="text-align: center;"><b style="font-size: 11pt;" class="data-value"><?= $xray ?></b></td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                        <td width="33%">
                                                            <table border="0" cellspacing="0" cellpadding="5" width="100%">
                                                                <tr>
                                                                    <td><b>Pengecualian</b></td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="font-size: 9pt;"><i>Grounds for Exemption</i></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>-</td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td><br>
                        <table border="1" cellspacing="0" cellpadding="5" width="100%">
                            <tr>
                                <td>
                                    <b>Metode Pemeriksaan yang lain (jika diterapkan) / <i>Other Screening Method(s) (if applicable)</i></b>
                                    <div align="center" style="padding: 10px 0;"><b class="data-value"><?= $metode ?></b></div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td><br>
                        <table border="1" cellspacing="0" cellpadding="0" width="100%">
                            <tr>
                                <td style="width: 50%; vertical-align: top; padding: 10px;">
                                    <b>Status Keamanan diterbitkan oleh</b><br>
                                    <i>Security Status Issued By</i><br><br>
                                    Nama Petugas Pengawas Keamanan Penerbangan:<br>
                                    <i>Name of Supervisor Aviation Security</i><br><br>
                                    <br><br><br>
                                    <div align="center">
                                        <b class="data-value"><?= $row->avsec_nama ?? '-' ?></b><br>
                                        <span style="font-size: 9pt;">NIK: <?= $row->avsec_nik ?? '-' ?></span>
                                    </div>
                                </td>
                                <td style="width: 50%; vertical-align: top; padding: 10px;">
                                    <b>Status Keamanan Diterbitkan pada</b><br>
                                    <i>Security Status issued on</i><br><br>
                                    <br><br><br><br>
                                    <div align="right" style="padding-top: 25px;">
                                        Tanggal : <b><?= $tgl_cetak ?></b>&nbsp;&nbsp;Pukul : <b><?= $time2 ?></b>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td><br>
                        <table border="1" cellspacing="0" cellpadding="8" width="100%">
                            <tr>
                                <td>
                                    <b>Nama dan Stempel Jasa Terkait Bandar Udara</b><br>
                                    <span style="font-size: 9pt;"><i>(Of any regulated party who has accepted the security status given to a consignment by another regulated party)</i></span>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td><br>
                        <table border="1" cellspacing="0" cellpadding="10" width="100%">
                            <tr>
                                <td style="width: 60%; vertical-align: top;">
                                    Informasi keamanan lainnya / <i>Other security information</i> : <br>
                                    - Segel No: <b><?= $row->no_segel ?: '-' ?></b><br>
                                    - Sticker No: <b><?= $row->no_sticker ?: '-' ?></b>
                                </td>
                                <td style="width: 40%; text-align: right; vertical-align: middle;">
                                    Nama Agen: <br><b style="font-size: 13pt;" class="data-value"><?= $row->nama_agent ?? '-' ?></b>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <!-- Trigger cetak otomatis pada saat halaman selesai dimuat -->
    <script type="text/javascript">
        window.onload = function() {
            window.print();
        }
    </script>
</body>

</html>
```
eof

```php:Cetak CSD Actual View:print_csd_actual.php
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>CSD Actual - <?= $row->no_csd ?></title>
    <style>
        body {
            font-family: "Verdana", "Arial", sans-serif;
            font-size: 10pt;
            color: #000000;
            text-decoration: none;
            margin: 15px;
        }

        td {
            font-family: "Verdana", "Arial", sans-serif;
            font-size: 10pt;
            color: #000000;
            text-decoration: none;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            font-family: Arial, sans-serif;
            color: #333;
        }

        .data-value {
            font-style: italic;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="row">
        <div class="col-sm-12">
            <table width="98%" border="0" align="center">
                <tr>
                    <td align="center">
                        <b>DEKLARASI KEAMANAN KIRIMAN <br> CONSIGNMENT SECURITY DECLARATION (CSD) <br>Nomor : <span class="data-value"><?= $row->no_csd ?></span> </b> &nbsp; <br> &nbsp;<br><br>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table border="1" cellspacing="0" cellpadding="0" width="100%">
                            <tr>
                                <td style="width: 50%; padding: 5px;">
                                    <table border="0" cellspacing="3" cellpadding="3" width="100%">
                                        <tr>
                                            <td><img src="<?= base_url('src/images/logo_bdt.jpg') ?>" width="150" onerror="this.onerror=null; this.src='https://placehold.co/150x50/e0e0e0/333333?text=Logo+BDT';"></td>
                                            <td>&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" style="font-size: 9pt;">Sertifikat Standar : 15052400247180002&nbsp;</td>
                                        </tr>
                                    </table>
                                </td>
                                <td style="width: 50%; padding: 5px;" valign="top">
                                    <table border="0" cellspacing="4" cellpadding="4" width="100%">
                                        <tr>
                                            <td width="55%">Nomor SMU / AWB <br>(Number of Airway Bill)&nbsp;</td>
                                            <td width="5%">:&nbsp;</td>
                                            <td align="right" width="40%"><b class="data-value"><?= $row->smu ?></b></td>
                                        </tr>
                                        <tr>
                                            <td>Nomor Penerbangan&nbsp;</td>
                                            <td>:&nbsp;</td>
                                            <!-- <td align="right"><b class="data-value"><?= $row->no_pesawat ?></b></td> -->
                                            <td align="right"><b class="data-value"><?= $pesawat ?></b></td>
                                        </tr>
                                        <tr>
                                            <td>Tanggal Penerbangan&nbsp;</td>
                                            <td>:&nbsp;</td>
                                            <td align="right" class="data-value"><?= date('d-m-Y', strtotime($row->tanggal_terbang)) ?></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td><br>
                        <table border="1" cellspacing="0" cellpadding="0" width="100%">
                            <tr>
                                <td style="padding: 5px;">
                                    <b>&nbsp;<i>Contents Of Consignment</i>&nbsp;<br></b>
                                    <table border="1" cellspacing="5" cellpadding="5" width="100%">
                                        <tr style="background-color: #f2f2f2;">
                                            <td align="center" width="10%"><b>No.</b>&nbsp;</td>
                                            <td align="center" width="50%"><b>Jenis/Nama Barang</b>&nbsp;</td>
                                            <td align="center" width="20%"><b>Koli</b>&nbsp;</td>
                                            <td align="center" width="20%"><b>Berat (Weight)</b>&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td align="center">1&nbsp;</td>
                                            <td align="center"><b class="data-value"><?= $row->komoditi ?></b></td>
                                            <td align="center"><b class="data-value"><?= $row->koli_smu ?? 0 ?></b></td>
                                            <td align="center"><b class="data-value"><?= $row->berat_smu ?? 0 ?> kg</b></td>
                                        </tr>
                                        <tr>
                                            <td align="center">2&nbsp;</td>
                                            <td align="center"><b>&nbsp;</b></td>
                                            <td><b>&nbsp;</b></td>
                                            <td><b>&nbsp;</b></td>
                                        </tr>
                                        <tr>
                                            <td align="center">3&nbsp;</td>
                                            <td align="center"><b>&nbsp;</b></td>
                                            <td><b>&nbsp;</b></td>
                                            <td><b>&nbsp;</b></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td><br>
                        <table border="1" cellspacing="0" cellpadding="5" width="100%">
                            <tr>
                                <td width="15%" align="left">
                                    <b>Asal</b><br>
                                    <i>Origin</i>
                                </td>
                                <td width="20%" align="left" style="vertical-align: middle;">
                                    <b>HLP</b>
                                </td>
                                <td width="15%" align="left">
                                    <b>Tujuan</b><br>
                                    <i>Destination</i>
                                </td>
                                <td width="20%" align="left" style="vertical-align: middle;">
                                    <b class="data-value"><?= $row->tujuan ?? '-' ?></b>
                                </td>
                                <td width="30%">
                                    <b>Transfer/Transit</b><br>
                                    <i>Transfer/Transit Points</i>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td><br>
                        <table border="1" cellspacing="0" cellpadding="0" width="100%">
                            <tr>
                                <td style="width: 50%; vertical-align: top; padding: 10px;">
                                    <b>Status Keamanan</b><br>
                                    <i>Security Status</i><br><br>
                                    <table border="1" cellspacing="0" cellpadding="5" width="100%">
                                        <tr>
                                            <td width="15%" align="center" style="height: 30px;"><?= $check_spx ?></td>
                                            <td><i>Passenger Aircraft (SPX) </i>&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td align="center" style="height: 30px;"><?= $check_sco ?></td>
                                            <td><i>Cargo Aircraft Only (SCO)</i>&nbsp;</td>
                                        </tr>
                                    </table>
                                </td>
                                <td style="width: 50%; vertical-align: top;">
                                    <table border="1" cellspacing="0" cellpadding="5" width="100%">
                                        <tr>
                                            <td>
                                                <table cellspacing="0" cellpadding="0" width="100%">
                                                    <tr>
                                                        <td width="70%">
                                                            <b>Alasan diterbitkan status keamanan</b>&nbsp;<br>
                                                            <i>Reason For issuing the security Status</i>&nbsp;
                                                        </td>
                                                        <td align="right" style="vertical-align: middle;">
                                                            <b style="font-size: 14pt;" class="data-value"><?= $alasan ?></b>&nbsp;
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <table border="1" cellspacing="0" cellpadding="0" width="100%">
                                                    <tr>
                                                        <td width="33%">
                                                            <table border="0" cellspacing="0" cellpadding="5" width="100%">
                                                                <tr>
                                                                    <td><b>Diterima dari</b></td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="font-size: 8pt;"><i>Received from (codes)</i></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>-</td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                        <td width="34%">
                                                            <table border="0" cellspacing="0" cellpadding="5" width="100%">
                                                                <tr>
                                                                    <td><b>Metode Pemeriksaan</b></td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="font-size: 8pt;"><i>Screen Methods 100%</i></td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="text-align: center;"><b style="font-size: 11pt;" class="data-value"><?= $xray ?></b></td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                        <td width="33%">
                                                            <table border="0" cellspacing="0" cellpadding="5" width="100%">
                                                                <tr>
                                                                    <td><b>Pengecualian</b></td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="font-size: 8pt;"><i>Grounds for Exemption</i></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>-</td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td><br>
                        <table border="1" cellspacing="0" cellpadding="5" width="100%">
                            <tr>
                                <td>
                                    <b>Metode Pemeriksaan yang lain (jika diterapkan) / <i>Other Screening Method(s) (if applicable)</i></b>
                                    <div align="center" style="padding: 10px 0;"><b class="data-value"><?= $metode ?></b></div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td><br>
                        <table border="1" cellspacing="0" cellpadding="0" width="100%">
                            <tr>
                                <td style="width: 50%; vertical-align: top; padding: 10px;">
                                    <b>Status Keamanan diterbitkan oleh</b><br>
                                    <i>Security Status Issued By</i><br><br>
                                    Nama Petugas Pengawas Keamanan Penerbangan:<br>
                                    <i>Name of Supervisor Aviation Security</i><br><br>
                                    <br><br>
                                    <div align="center">
                                        <b class="data-value"><?= $row->avsec_nama ?? '-' ?></b><br>
                                        <span style="font-size: 8pt;">NIK: <?= $row->avsec_nik ?? '-' ?></span>
                                    </div>
                                </td>
                                <td style="width: 50%; vertical-align: top; padding: 10px;">
                                    <b>Status Keamanan Diterbitkan pada</b><br>
                                    <i>Security Status issued on</i><br><br>
                                    <br><br><br>
                                    <div align="right" style="padding-top: 15px;">
                                        Tanggal : <b><?= $tgl_cetak ?></b>&nbsp;&nbsp;Pukul : <b><?= $time2 ?></b>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td><br>
                        <table border="1" cellspacing="0" cellpadding="8" width="100%">
                            <tr>
                                <td>
                                    <b>Nama dan Stempel Jasa Terkait Bandar Udara</b><br>
                                    <span style="font-size: 8pt;"><i>(Of any regulated party who has accepted the security status given to a consignment by another regulated party)</i></span>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td><br>
                        <table border="1" cellspacing="0" cellpadding="10" width="100%">
                            <tr>
                                <td style="width: 60%; vertical-align: top;">
                                    Informasi keamanan lainnya / <i>Other security information</i> : <br>
                                    - Segel No: <b><?= $row->no_segel ?: '-' ?></b><br>
                                    - Sticker No: <b><?= $row->no_sticker ?: '-' ?></b>
                                </td>
                                <td style="width: 40%; text-align: right; vertical-align: middle;">
                                    Nama Agen: <br><b style="font-size: 13pt;" class="data-value"><?= $row->nama_agent ?? '-' ?></b>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <script type="text/javascript">
        window.onload = function() {
            window.print();
        }
    </script>
</body>

</html>