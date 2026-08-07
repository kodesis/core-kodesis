<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <style>
        @page {
            size: letter;
            margin: 12mm 14mm;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: "Verdana", "Arial", sans-serif;
            font-size: 9.5pt;
            color: #000;
            margin: 0;
            padding: 0;
        }

        .doc {
            width: 100%;
            max-width: 720px;
            margin: 0 auto;
        }

        .title {
            text-align: center;
            margin-bottom: 8px;
        }

        .title h1 {
            font-size: 12.5pt;
            margin: 0 0 2px 0;
        }

        .title h2 {
            font-size: 10.5pt;
            margin: 0 0 2px 0;
            font-weight: normal;
        }

        .title .csd-no {
            font-size: 10.5pt;
            font-weight: bold;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        table.outer {
            border: 1px solid #000;
            margin-bottom: 6px;
        }

        table.outer td {
            border: 1px solid #000;
            padding: 5px 7px;
            vertical-align: top;
        }

        /* section label row (bold header / italic subtitle) */
        .label {
            font-weight: bold;
            font-size: 9pt;
        }

        .sublabel {
            font-style: italic;
            font-size: 8.5pt;
        }

        .data-value {
            font-style: italic;
            font-weight: bold;
        }

        .center {
            text-align: center;
        }

        .right {
            text-align: right;
        }

        /* header block: logo + AWB info */
        .header-flex {
            display: flex;
            width: 100%;
        }

        .header-left {
            width: 42%;
            border-right: 1px solid #000;
            padding: 5px 7px;
        }

        .header-left img {
            width: 130px;
            display: block;
            margin-bottom: 4px;
        }

        .header-right {
            width: 58%;
            padding: 0;
        }

        .header-right table td {
            /* border: 1px solid #000; */
            padding: 4px 6px;
            font-size: 9pt;
        }

        .header-right table td.label-col {
            width: 55%;
        }

        .header-right table td.colon-col {
            width: 5%;
        }

        /* contents of consignment */
        .contents-table th, .contents-table td {
            border: 1px solid #000;
            padding: 4px 6px;
            font-size: 9pt;
        }

        .contents-table th {
            background: #f2f2f2;
        }

        /* origin/destination row */
        .od-table td {
            border: 1px solid #000;
            padding: 5px 7px;
            vertical-align: top;
            font-size: 9pt;
        }

        /* security status + reason */
        .status-grid {
            display: flex;
            width: 100%;
        }

        .status-left {
            width: 34%;
            border-right: 1px solid #000;
        }

        .status-right {
            width: 66%;
        }

        .status-box {
            /* border-top: 1px solid #000; */
        }

        .status-box table td {
            
            /* border-top:none; */
            border-left:none;
            border-right:none;
            /* border-bottom:none; */

            /* border: 1px solid #000; */
            padding: 4px 6px;
            font-size: 9pt;
        }

        .checkbox-cell {
            width: 26px;
            text-align: center;
            font-weight: bold;
        }

        .reason-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 4px 7px;
            border-bottom: 1px solid #000;
        }

        .three-col {
            display: flex;
            width: 100%;
        }

        .three-col > div {
            width: 33.33%;
            border-right: 1px solid #000;
            padding: 4px 6px;
            min-height: 55px;
            font-size: 9pt;
        }

        .three-col > div:last-child {
            border-right: none;
        }

        .three-col .val {
            text-align: center;
            font-size: 12pt;
            margin-top: 8px;
        }

        /* other screening method */
        .other-screen {
            font-size: 9pt;
        }

        .other-screen .val {
            text-align: center;
            margin-top: 4px;
        }

        /* signature block */
        .sig-flex {
            display: flex;
            width: 100%;
        }

        .sig-col {
            width: 50%;
            border-right: 1px solid #000;
            padding: 5px 7px;
            min-height: 90px;
            position: relative;
        }

        .sig-col:last-child {
            border-right: none;
        }

        .sig-name {
            text-align: center;
            font-weight: bold;
            font-style: italic;
            position: absolute;
            bottom: 6px;
            left: 0;
            right: 0;
        }

        .sig-date {
            position: absolute;
            bottom: 6px;
            right: 7px;
        }

        .other-info-flex {
            display: flex;
            width: 100%;
            padding: 5px 7px;
        }

        .other-info-flex .left {
            width: 70%;
        }

        .other-info-flex .right {
            width: 30%;
            text-align: right;
            font-weight: bold;
            font-style: italic;
            display: flex;
            align-items: flex-end;
            justify-content: flex-end;
        }
        
    </style>
</head>

<body>
    <div class="doc">
        <div class="title">
            <h1>DEKLARASI KEAMANAN KIRIMAN</h1>
            <h2>CONSIGNMENT SECURITY DECLARATION (CSD)</h2>
            <div class="csd-no">Nomor : <span class="data-value"><?= $row->no_csd ?></span></div>
        </div>

        <!-- Header: Logo/Certificate + AWB info -->
        <table class="outer">
            <tr>
                <td style="padding:0;">
                    <div class="header-flex">
                        <div class="header-left">
                            <img src="<?= base_url('src/images/logo_bdt.jpg') ?>" alt="logo">
                            <div>Sertifikat Standar : 15052400247180002</div>
                        </div>
                        <div class="header-right">
                            <table>
                                <tr >
                                    <td class="label-col" style="border-top:none; border-left:none;">Nomor SMU / AWB<br><span class="sublabel">(Number of Airway Bill)</span></td>
                                    <td class="colon-col" style="border-top:none;">:</td>
                                    <td class="right" style="border-top:none; border-right:none;"><b class="data-value"><?= $row->smu ?></b></td>
                                </tr>
                                <tr>
                                    <td class="label-col" style="border-top:none; border-left:none;">Nomor Penerbangan</td>
                                    <td class="colon-col" >:</td>
                                    <td class="right" style="border-top:none; border-right:none;"><b class="data-value"><?= $row->no_pesawat ?></b></td>
                                </tr>
                                <tr>
                                    <td class="label-col" style="border-bottom:none; border-left:none;">Tanggal Penerbangan</td>
                                    <td class="colon-col"style="border-bottom:none;">:</td>
                                    <td class="right data-value" style="border-bottom:none; border-right:none;"><?= $row->tanggal_terbang ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </td>
            </tr>
        </table>

        <!-- Contents of Consignment -->
        <table class="outer">
            <tr>
                <td style="padding:5px 7px;">
                    <div class="label" style="font-style:italic; margin-bottom:4px;">Contents Of Consignment</div>
                    <table class="contents-table">
                        <tr>
                            <th style="width:8%;">No.</th>
                            <th>Jenis/Nama Barang</th>
                            <th style="width:15%;">Koli</th>
                            <th style="width:20%;">Berat (Weight)</th>
                        </tr>
                        <tr>
                            <td class="center">1</td>
                            <td class="center"><b class="data-value"><?= $row->komoditi ?></b></td>
                            <td class="center"><b class="data-value"><?= $row->koli_smu ?></b></td>
                            <td class="center"><b class="data-value"><?= $row->berat_smu ?></b></td>
                        </tr>
                        <tr>
                            <td class="center">2</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="center">3</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <!-- Origin / HLP / Destination / Transfer -->
        <table class="outer od-table">
            <tr>
                <td style="width:15%;">
                    <b>Asal</b><br><span class="sublabel">Origin</span>
                </td>
                <td style="width:15%;">
                    <b>HLP</b>
                </td>
                <td style="width:15%;">
                    <b>Tujuan</b><br><span class="sublabel">Destination</span>
                </td>
                <td style="width:15%;">
                    <b class="data-value"><?= $row->tujuan ?></b>
                </td>
                <td>
                    <b>Transfer/Transit (Jika Ada)</b><br>
                    <span class="sublabel">Transfer/Transit Points (If known)</span>
                </td>
            </tr>
        </table>

        <!-- Security Status + Reason/Method -->
        <table class="outer">
            <tr>
                <td style="padding:0;">
                    <div class="status-grid">
                        <div class="status-left">
                            <div style="padding:5px 7px;">
                                <b>Status Keamanan</b><br><span class="sublabel">Security Status</span>
                            </div>
                            <div class="status-box">
                                <table>
                                    <tr>
                                        <td class="checkbox-cell"><?= $check_spx ?></td>
                                        <td style="border-left: 1px solid #000;"><i>Passenger Aircraft (SPX)</i></td>
                                    </tr>
                                    <tr>
                                        <td class="checkbox-cell"><?= $check_sco ?></td>
                                        <td style="border-left: 1px solid #000;"><i>Cargo Aircraft Only (SCO)</i></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="status-right">
                            <div class="reason-row">
                                <div>
                                    <b>Alasan diterbitkan status keamanan</b><br>
                                    <span class="sublabel">Reason For issuing the security Status</span>
                                </div>
                                <div style="font-size:12pt;"><b class="data-value"><?= $alasan ?></b></div>
                            </div>
                            <div class="three-col">
                                <div>
                                    <b>Diterima dari(kode)</b><br>
                                    <span class="sublabel">Received from (codes)</span>
                                </div>
                                <div>
                                    <b>Metode Pemeriksaan</b><br>
                                    <span class="sublabel">Screen Methods 100%</span>
                                    <div class="val data-value"><?= $xray ?></div>
                                </div>
                                <div>
                                    <b>Pengecualian Pemeriksaan</b><br>
                                    <span class="sublabel">Grounds for Exemption (Code)</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        </table>

        <!-- Other screening method -->
        <table class="outer other-screen">
            <tr>
                <td>
                    Metode Pemeriksaan yang lain (jika diterapkan)<br>
                    <i>Other Screening Method(s) (if applicable)</i>
                    <div class="val"><b class="data-value"><?= $metode ?></b></div>
                </td>
            </tr>
        </table>

        <!-- Signature block -->
        <table class="outer">
            <tr>
                <td style="padding:0;">
                    <div class="sig-flex">
                        <div class="sig-col">
                            <div>Status Keamanan diterbitkan oleh<br><i>Security Status Issued By</i></div>
                            <div style="margin-top:4px;">Nama Petugas Pengawas Keamanan Penerbangan<br><i>Name of Supervisor Aviation Security</i></div>
                            <div class="sig-name"><?= $row->avsec_nama ?></div>
                            <br>
                            <br>
                            <br>
                            <br>
                        </div>
                        <div class="sig-col">
                            <div>Status Keamanan Diterbitkan pada<br><i>Security Status issued on</i></div>
                            <div class="sig-date">
                                Tanggal :
                                <? if ($tgl_cetak != "") { ?> <b><?= $tgl_cetak ?></b> Pukul : <b><?= $time2 ?></b><? } ?>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        </table>

        <!-- Regulated party stamp -->
        <table class="outer">
            <tr>
                <td>
                    Nama dan Stempel Jasa Terkait Bandara Udara<br>
                    <i>(Of any regulated party who has accepted the security status given to a consignment by another regulated party)</i>
                    <div style="min-height:26px;"></div>
                </td>
            </tr>
        </table>

        <!-- Other security info + agent name -->
        <table class="outer">
            <tr>
                <td style="padding:0;">
                    <div class="other-info-flex">
                        <div class="left">
                            Informasi keamanan lainnya :
                            <div style="min-height:26px;"></div>
                        </div>
                        <div class="right"><?= $row->nama_agent ?></div>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <script type="text/javascript">
        window.print();
    </script>

</body>

</html>