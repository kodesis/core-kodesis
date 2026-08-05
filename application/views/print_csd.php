<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: "Verdana", "Arial";
            font-size: 11pt;
            color: #000000;
            text-decoration: none;
        }

        td {
            font-family: "Verdana", "Arial";
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
            <table width=95% border="0">
                <tr>
                    <td align=center>
                        <b>DEKLARASI KEAMANAN KIRIMAN <br> CONSIGNMENT SECURITY DECLARATION (CSD) <br>Nomor : <span class="data-value"><?= $row->no_csd ?></span> </b> &nbsp; <br> &nbsp;<br><br>
                    </td>
                </tr>
                <tr>
                    <table border="1" cellspacing=0 cellpadding=0 width=100%>
                        <tr>
                            <td>
                                <table border="1" cellspacing=3 cellpadding=3 width=100%>
                                    <tr>
                                        <td><img src="<?= base_url('src/images/logo_bdt.jpg') ?>" width=150></td>
                                        <td>&nbsp;<br></td>
                                    </tr>
                                    <tr>
                                        <td>Sertifikat Standar : 15052400247180002&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;<br></td>
                                    </tr>
                                </table>
                            </td>
                            <td style="width: 50%;">
                                <table border="1" cellspacing=4 cellpadding=4 width=60%>
                                    <tr>
                                        <td>Nomor SMU / AWB <br>(Number of Airway Bill)&nbsp;</td>
                                        <td>:&nbsp;</td>
                                        <td align="right"><b class="data-value"><?= $row->smu ?></b></td>
                                    </tr>
                                    <tr>
                                        <td>Nomor Penerbangan&nbsp;</td>
                                        <td>:&nbsp;</td>
                                        <td align="right"><b class="data-value"><?= $row->no_pesawat ?></b></td>
                                    </tr>
                                    <tr>
                                        <td>Tanggal Penerbangan&nbsp;</td>
                                        <td>:&nbsp;</td>
                                        <td align="right" class="data-value"><?= $row->tanggal_terbang ?></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </tr>
                <tr>
                    <table border="1" cellspacing=0 cellpadding=0 width=100%>
                        <tr>
                            <td>
                                <b><i>Contents Of Consignment</i>&nbsp;<br></b>
                                <table border="1" cellspacing=5 cellpadding=5 width=100%>
                                    <tr>
                                        <td align="center">No.&nbsp;</td>
                                        <td align="center">Jenis/Nama Barang&nbsp;</td>
                                        <td align="center">Koli&nbsp;</td>
                                        <td align="center">Berat (Weight)&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td align="center">1&nbsp;</td>
                                        <td align="center" width="70%"><b class="data-value"><?= $row->komoditi ?></b></td>
                                        <td align="center"><b class="data-value"><?= $row->koli_smu ?></b></td>
                                        <td align="center"><b class="data-value"><?= $row->berat_smu ?></b></td>
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
                </tr>
                <tr>
                    <td>
                        <table border="1" cellspacing=0 cellpadding=0 width=100%>
                            <tr>
                                <td width="10%" align="left">
                                    <b>Asal</b><br>&nbsp;
                                    <i>Origin</i>
                                </td>
                                <td width="20%" align="left">
                                    <br><b>HLP</b>
                                </td>
                                <td width="15%" align="left">
                                    <b>Tujuan</b><br>&nbsp;
                                    <i>Destination</i>
                                </td>
                                <td width="15%" align="left">
                                    <br><b class="data-value"><?= $row->tujuan ?></b>
                                </td>
                                <td>
                                    <b>Transfer/Transit (Jika Ada)</b><br>&nbsp;
                                    <i>Transfer/Transit Points (If known)</i><br>&nbsp;<br>&nbsp;
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table border="1" cellspacing=0 cellpadding=0 width=100%>
                            <tr>
                                <td> &nbsp; <br>
                                    <table cellspacing=0 cellpadding=0 width=100% style="margin-top: -30px;">
                                        <tr>
                                            <td>
                                                <table cellspacing=3 cellpadding=3 width=100% style="margin-bottom: 50px;">
                                                    <tr>
                                                        <td>
                                                            <b>Status Keamanan</b>&nbsp;<br>
                                                            <i>Security Status</i>&nbsp;
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <table border="1" cellspacing=3 cellpadding=3 width=100%>
                                                    <tr>
                                                        <td><?= $check_spx ?></td>
                                                        <td><i>Passenger Aircraft (SPX) </i>&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td><?= $check_sco ?></td>
                                                        <td><i>Cargo Aircraft Only (SCO)</i>&nbsp;</td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                <td>
                                    <table border="1" cellspacing=0 cellpadding=0 width=100%>
                                        <tr>
                                            <td align='right'>
                                                <table cellspacing=0 cellpadding=0>
                                                    <tr>
                                                        <td width=65%>
                                                            <table cellspacing=0 cellpadding=0 width=100%>
                                                                <tr>
                                                                    <td>
                                                                        <b>Alasan diterbitkan status keamanan</b>&nbsp;<br>
                                                                        <i>Reason For issuing the security Status</i>&nbsp;
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                        <td align=right>
                                                            <b font=16 class="data-value"><?= $alasan ?></b>&nbsp;
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
                                                            <table border="1" cellspacing="0" cellpadding="5" width="100%">
                                                                <tr>
                                                                    <td style="padding-top: 10px;"><b>Diterima dari(kode)</b></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><i>Received from (codes)</i></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><br></td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                        <td width="33%">
                                                            <table border="1" cellspacing="0" cellpadding="5" width="100%">
                                                                <tr>
                                                                    <td style="padding-top: 10px;"><b>Metode Pemeriksaan</b></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><i>Screen Methods 100%</i></td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="text-align: center;"><b style="font-size: 16px;" class="data-value"><?= $xray ?></b></td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                        <td width="34%">
                                                            <table border="1" cellspacing="0" cellpadding="5" width="100%">
                                                                <tr>
                                                                    <td style="padding-top: 10px;"><b>Pengecualian Pemeriksaan</b></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><i>Grounds for Exemption (Code)</i></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><br></td>
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
                    <td>
                        <table border="1" cellspacing=0 cellpadding=0 width=100%>
                            <tr>
                                <td>
                                    <table border="1" cellspacing=0 cellpadding=0 width=100%>
                                        <tr>
                                            <td>
                                                Metode Pemeriksaan yang lain (jika diterapkan)&nbsp;<br>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <i>Other Screening Method(s) (if applicable)</i>&nbsp;<br>
                                                <b>&nbsp;</b>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="center">
                                                <b class="data-value"><?= $metode ?></b>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table border="1" cellspacing=0 cellpadding=0 width=100%>
                            <tr>
                                <td>
                                    <table border="1" cellspacing=0 cellpadding=0 width=100%>
                                        <tr>
                                            <td>
                                                Status Keamanan diterbitkan oleh&nbsp;<br>
                                                <i>Security Status Issued By</i><br>&nbsp;
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Nama Petugas Pengawas Keamanan Penerbangan&nbsp;<br>
                                                <i>Name of Supervisor Aviation Security</i>&nbsp;
                                            </td>
                                        </tr>
                                        <tr rowspan=40>
                                            <td><br><br><br></td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;<br></td>
                                        </tr>
                                        <tr align=center>
                                            <td><b class="data-value"><?= $row->avsec_nama ?></b></td>
                                        </tr>
                                    </table>
                                </td>
                                <td>
                                    <table border="1" cellspacing=0 cellpadding=0 width=100%>
                                        <tr>
                                            <td>
                                                Status Keamanan Diterbitkan pada&nbsp;<br>
                                                <i>Security Status issued on</i>&nbsp;
                                            </td>
                                        </tr>
                                        <tr rowspan=30>
                                            <td><br><br><br><br></td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;<br></td>
                                        </tr>
                                        <tr>
                                            <td align=right>
                                                Tanggal :
                                                <? if ($tgl_cetak != "") { ?> <b><?= $tgl_cetak ?></b> Pukul : <b><?= $time2 ?></b><? } ?>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table border="0" cellspacing=0 cellpadding=0 width=100%>
                            <tr>
                                <td>
                                    <table border="1" cellspacing=0 cellpadding=0 width=100%>
                                        <tr>
                                            <td>
                                                Nama dan Stempel Jasa Terkait Bandara Udara&nbsp;<br>
                                                <i>(Of any regulated party who has accepted the security status given to a consignment by another regulated party)</i>&nbsp;
                                            </td>
                                        </tr>
                                    </table>
                                    <br>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table border="1" cellspacing=0 cellpadding=0 width=100%>
                            <tr>
                                <td>
                                    <table border="0" cellspacing=0 cellpadding=0 width=100%>
                                        <tr>
                                            <td>&nbsp;<br></td>
                                            <!-- <td>&nbsp;<br></td> -->
                                            <!-- <td>&nbsp;<br></td> -->
                                        </tr>
                                        <tr>
                                            <td width=70%>Informasi keamanan lainnya :&nbsp;</td>
                                            <!-- <td align="right">&nbsp;</td> -->
                                        </tr>
                                        <tr>
                                            <td width=30%>&nbsp;</td>
                                            <td></td>
                                            <td align="right">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td width=30%>&nbsp;</td>
                                            <td></td>
                                            <td align="right">&nbsp;</td>
                                        </tr>
                                        <!-- <tr>
                                            <td width=30%>&nbsp;</td>
                                            <td></td>
                                            <td align="right">&nbsp;</td>
                                        </tr> -->
                                    </table>
                                </td>
                                <td align="right"><b class="data-value"><?= $row->nama_agent ?></b></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <script type="text/javascript">
        window.print();
    </script>

</body>

</html>