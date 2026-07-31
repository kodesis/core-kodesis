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
            <table width=95%>
                <tr>
                    <td align=center>
                        <!-- <b>DEKLARASI KEAMANAN KIRIMAN <br> CONSIGMENT SECURITY DECLARATION ( CSD ) <br>Nomor :</b>  -->&nbsp; <br> &nbsp;<br><br>
                        <?= $row->no_csd ?></br>
                    </td>
                </tr>
                <tr>
                    <table cellspacing=0 cellpadding=0 width=100%>
                        <tr>
                            <td>
                                <table cellspacing=3 cellpadding=3 width=100%>
                                    <tr>
                                        <!-- <td><? echo ("$logo_txt") ?></td> -->
                                        <td>&nbsp;<br></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <!-- <b>PT. BANGUN DESA TEKNOLOGI</b> -->&nbsp;<br>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><b>Sertifikat Standar : 15052400247180002</b></td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <table cellspacing=4 cellpadding=4 width=100%>
                                    <tr>
                                        <td>
                                            <!-- Nomor SMU / AWB -->&nbsp;
                                        </td>
                                        <td>
                                            <!-- : -->&nbsp;
                                        </td>
                                        <td align="right"><b><?= $row->smu ?></b></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <!-- Nomor Penerbangan -->&nbsp;
                                        </td>
                                        <td>
                                            <!-- : -->&nbsp;
                                        </td>
                                        <td align="right"><b><?= $row->no_pesawat ?></b></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <!-- Tanggal Penerbangan  -->&nbsp;
                                        </td>
                                        <td>
                                            <!-- : -->&nbsp;
                                        </td>
                                        <td align="right"><?= $row->tanggal_terbang ?></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </tr>
                <tr>
                    <table cellspacing=0 cellpadding=0 width=100%>
                        <tr>
                            <td>
                                <b>
                                    <!-- <i>Contents Of Consignment</i> -->&nbsp;<br>
                                </b>
                                <table cellspacing=5 cellpadding=5 width=100%>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <!-- 1 -->&nbsp;
                                        </td>
                                        <td align="center" width="65%"><b><?= $row->komoditi ?></b></td>
                                        <td align="center">Koli :<b><?= $row->koli_smu ?></b></td>
                                        <td align="right"><b><?= $row->berat_smu ?></b></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <!-- 2 -->&nbsp;
                                        </td>
                                        <td align="center"><b>&nbsp;</b></td>
                                        <td><b>&nbsp;</b></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <!-- 3 -->&nbsp;
                                        </td>
                                        <td align="center"><b>&nbsp;</b></td>
                                        <td><b>&nbsp;</b></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </tr>
                <tr>
                    <td>
                        <table cellspacing=0 cellpadding=0 width=100%>
                            <tr>
                                <td width="30%" align="center">
                                    <!-- <b>Asal</b><br> -->&nbsp;
                                    <!-- <i>Origin</i> <br> -->&nbsp;
                                    <b>HLP</b>
                                </td>
                                <td width="30%" align="center">
                                    <!-- <b>Tujuan</b><br> -->&nbsp;
                                    <!-- <i>Destination</i><br> -->&nbsp;
                                    <b><?= $row->tujuan ?></b>
                                </td>
                                <td>
                                    <!-- <b>Transfer/Transit (Jika Ada)</b><br> -->&nbsp; <br>
                                    <!-- <i>Transfer/Transit Points (If known)</i><br> -->&nbsp; <br>
                                    &nbsp;
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table cellspacing=0 cellpadding=0 width=100%>
                            <!-- <tr>
								<td> &nbsp; <br> -->
                            <!-- <table cellspacing=0 cellpadding=0 width=100%>
										<tr>
											<td> -->
                            <!-- <table cellspacing=3 cellpadding=3 width=100%>
										<tr>
											<td>
												<b>Status Keamanan</b>
												&nbsp;<br>
												<i>Security Status</i>
												&nbsp;
											</td>
										</tr>
									</table> -->
                            <!-- </td>
							</tr> -->
                            <tr>
                                <td>
                                    <table cellspacing=3 cellpadding=3 width=100%>
                                        <tr>
                                            <td>
                                                <p style="margin-bottom: -20px;"><?= $check_spx ?></p>
                                            </td>
                                            <td>
                                                <!-- <i>Passenger Aircraft (SPX) </i> -->&nbsp;
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <p style="margin-bottom: -20px;">
                                                    <?= $check_sco ?></p>
                                            </td>
                                            <td>
                                                <!-- <i>Cargo Aircraft Only (SCO)</i> -->&nbsp;
                                            </td>

                                        </tr>
                                    </table>
                                    <!-- </td>
										</tr>
									</table> -->
                                </td>
                                <td>
                                    <table cellspacing=0 cellpadding=0 width=100%>
                                        <!-- <tr> -->
                                        <!-- <td align='right'> -->
                                        <!-- <table cellspacing=0 cellpadding=0> -->
                                        <!-- <tr> -->
                                        <!-- <td width=65%> -->
                                        <!-- <table cellspacing=0 cellpadding=0 width=100%>
													<tr>
														<td> -->
                                        <!-- <b>Alasan diterbitkan status keamanan</b><br> -->&nbsp; <br>
                                        <!-- <i>Reason For issuing the security Status</i> -->&nbsp;
                                        <!-- </td>
													</tr>
												</table> -->
                                        <!-- </td> -->
                                        <!-- <td align=right> -->
                                        <!-- <b font=16><?= $alasan ?><b> -->&nbsp;
                                        <!-- </td> -->
                                        <!-- </tr> -->
                                        <!-- </table> -->
                                        <!-- <b font='16'><?= $alasan ?><b> -->
                                        <!-- </td> -->
                                        <!-- </tr> -->
                                        <tr>
                                            <td>

                                                <table cellspacing=0 cellpadding=0 width=100%>
                                                    <tr>
                                                        <td>
                                                            <table cellspacing=0 cellpadding=0 width=100%>
                                                                <tr>
                                                                    <td style='padding-top: 10px'>
                                                                        <!-- <b>Diterima dari(kode)</b> -->
                                                                        &nbsp;
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <!-- <i>Received from (codes)</i> -->
                                                                        &nbsp;
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td><br>&nbsp;</td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                        <td>
                                                            <table cellspacing=0 cellpadding=0 width=80%>
                                                                <tr>
                                                                    <td>
                                                                        <!-- <b>Metode Pemeriksaan</b> -->
                                                                        &nbsp;
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <!-- <i>Screen Methods</i> -->
                                                                        &nbsp;
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td align="center">

                                                                        <b font=16 style="margin-bottom: -20px;"><?= $xray ?></b>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                        <td>
                                                            <table cellspacing=0 cellpadding=0 width=100%>
                                                                <tr>
                                                                    <td style='padding-top: 10px'>
                                                                        <!-- <b>Pengecualian Pemeriksaan</b> -->
                                                                        &nbsp;
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <!-- <i>Grounds for Exemption</i> -->
                                                                        &nbsp;
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td><br>&nbsp;</td>
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
                        <table cellspacing=0 cellpadding=0 width=100%>
                            <tr>
                                <td>
                                    <table cellspacing=0 cellpadding=0 width=100%>
                                        <tr>
                                            <td>
                                                <!-- <b>Metode Pemeriksaan yang lain (jika diterapkan)</b> -->&nbsp;<br>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <!-- <i>Other Screening Method(s) (if applicable)</i> -->&nbsp;<br>
                                                <b>&nbsp;</b>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="center">
                                                <b><?= $metode ?></b>
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
                        <table cellspacing=0 cellpadding=0 width=100%>
                            <tr>
                                <td>
                                    <table cellspacing=0 cellpadding=0 width=100%>
                                        <tr>
                                            <td>
                                                <!-- <b>Status Keamanan diterbitkan oleh :</b><br> -->&nbsp; <br>
                                                <!-- <i>Security Status Issued By:</i> -->&nbsp;
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <!-- <b>Nama Petugas Pengawas Keamanan Penerbangan</b> -->&nbsp; <br>
                                                <!-- <br><i>Name of Supervisor Aviation Security</i> -->&nbsp;
                                            </td>
                                        </tr>
                                        <tr rowspan=40>
                                            <td><br><br><br></td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;<br></td>
                                        </tr>
                                        <tr align=center>
                                            <td><b style="margin-bottom: -30px;">
                                                    <br><br><?= $row->avsec_nama ?></b></td>
                                        </tr>
                                    </table>
                                </td>
                                <td>
                                    <table cellspacing=0 cellpadding=0 width=100%>
                                        <tr>
                                            <td>
                                                <!-- <b>Status Keamanan Diterbitkan pada</b><br> -->&nbsp;<br>
                                                <!-- <i>Scurity Status issued on</i> -->&nbsp;
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
                                                <!-- Date :  -->
                                                <b><?= $tgl_cetak ?> &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;<?= $time2 ?></b>
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
                        <table cellspacing=0 cellpadding=0 width=100%>
                            <tr>
                                <td>
                                    <table cellspacing=0 cellpadding=0 width=100%>
                                        <tr>
                                            <td>
                                                <!-- <b>Nama dan Stempel Jasa Terkait Bandara Udara</b> -->&nbsp;
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <!-- <i>(Of any regulated entity who has accepted the security status given to a consignment by another regulated party)</i> -->&nbsp;
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="center"><br><b>BDT</b></td>
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
                        <table cellspacing=0 cellpadding=0 width=100%>

                            <tr>
                                <td>
                                    <table cellspacing=0 cellpadding=0 width=100%>
                                        <tr>
                                            <td>
                                                <table cellspacing=0 cellpadding=0 width=100%>
                                                    <tr>
                                                        <td>&nbsp;<br></td>
                                                        <td>&nbsp;<br></td>
                                                        <td>&nbsp;<br></td>
                                                    </tr>
                                                    <tr>
                                                        <td width=30%>
                                                            <!-- Informasi keamanan lainnya -->&nbsp;
                                                        </td>
                                                        <td>
                                                            <!-- : -->&nbsp;
                                                        </td>
                                                        <td align="right">
                                                            <!-- <b><?= $row->no_sticker ?></b> -->&nbsp;
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td width=30%>
                                                            <!-- Security Checked Label Truck no -->&nbsp;
                                                        </td>
                                                        <td>
                                                            <!-- : -->&nbsp;
                                                        </td>
                                                        <td align="right">
                                                            <!-- <b><?= $row->no_segel ?></b> -->&nbsp;
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td width=30%>
                                                            <!-- Solid Plastic Seal No -->&nbsp;
                                                        </td>
                                                        <td>
                                                            <!-- : -->&nbsp;
                                                        </td>
                                                        <td align="right">
                                                            <!-- <b><?= $row->no_sticker ?></b> -->&nbsp;
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td width=30%>
                                                            <!-- Name of Driver -->&nbsp;
                                                        </td>
                                                        <td>
                                                            <!-- : -->&nbsp;
                                                        </td>
                                                        <td align="right">
                                                            <!-- <b><?= $row->nm_driver ?></b> -->&nbsp;
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                            <td align="right"><b><?= $row->nama_agent ?></b></td>
                                        </tr>
                                    </table>
                                </td>
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
    <!-- js placed at the end of the document so the pages load faster -->
    <!-- <script class="include" type="text/javascript" src="js/jquery.dcjqaccordion.2.7.js"></script>
	<script src="js/jquery.scrollTo.min.js"></script>
	<script src="js/respond.min.js"></script>
	<script src="js/jquery.nicescroll.js" type="text/javascript"></script> -->

    <!--right slidebar-->
    <!-- <script src="js/slidebars.min.js"></script> -->

    <!--common script for all pages-->
    <!-- <script src="js/common-scripts.js"></script>
	<script src="js/bootstrap.min.js"></script> -->

</body>

</html>