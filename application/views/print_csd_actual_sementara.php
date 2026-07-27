<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>CSD - <?= $row->no_csd ?></title>
</head>
<style type="text/css">
    @font-face {
        font-family: code39;
        src: url('fonts/Code39.ttf');
    }
</style>

<body style="width:240mm;height:270mm;max-width: 240mm; max-height: 270mm">
    <!-- <br><br> -->
    <table border="0" border=1 style="width:100%; max-width:240mm">
        <tr>
            <td align=left height=18>
                <font face="code39" size="4em">*<?= $row->no_csd ?>*</font>
            </td>
        </tr>
        <tr>
            <td align=right><?= $row->no_csd ?></td>
        </tr>

        <!-- <tr><td align=left >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?= $no_csd ?></td></tr>
 -->
        <tr>
            <td>
                <table border=0 width=100% cellspacing=0 cellpadding=0>

                    <tr>
                        <td width=55%>
                            <!-- <tr>
				<td>tesnomor</td>
			</tr> -->
                            <table border=0 width=100% cellspacing=3 cellpadding=3>
                                <tr>
                                    <td height=100>&nbsp;</td>


                                </tr>
                                <tr><!--tesnomor-->
                                    <!--  -->
                                    <!-- <td align=center height=40 colspan=2>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;047/Izin.RA.DJPU/X/2020&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td> -->
                                    <td align=center height=40 colspan=2>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;055/Izin.RA.DJPU/VI/2022&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                </tr>
                                <tr>
                                    <td align=right></td>
                                    <td align=right><b>&nbsp;<?= $row->komoditi ?></b></td>
                                </tr>
                                <tr>
                                    <td><b>&nbsp;</b></td>
                                </tr>
                            </table>
                        </td>
                        <td width=45%>
                            <table border=0 width=100% cellspacing=4 cellpadding=4>
                                <tr>
                                    <td width=50% height=40></td>
                                    <td></td>
                                    <td><b>&nbsp;<?= $row->smu ?></b></td>
                                </tr>
                                <tr>
                                    <td colspan=3>&nbsp;<br></td>
                                </tr>

                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td height=18>&nbsp;<?= $row->no_pesawat ?></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td height=18>&nbsp;<?= $row->tanggal_terbang ?></td>
                                </tr>
                                <tr>
                                    <td colspan=3>&nbsp;<br></td>
                                </tr>
                                <tr>
                                    <td colspan=3>&nbsp;<b>Koli: <?= $row->koli_smu ?></b>&nbsp;&nbsp;&nbsp;&nbsp;<b>Berat: <?= $row->berat_smu ?></b><br></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <!-- <tr><td ><table width=100% cellspacing=0 cellpadding=0 border=0 >
		<tr><td >
			<table width=100% cellspacing=0 cellpadding=0 >
			<tr><td width=25%><table border=0 width=100% cellspacing=0 cellpadding=0  >
					<tr><td>&nbsp;</td></tr>
					<tr><td><i>&nbsp;</i></td></tr></table></td>
				<td width=75%><table  width=100% cellspacing=5 cellpadding=5  >
					<tr><td><b><?= $upd_komoditi ?></b></td></tr>
					<tr><td >
						<table border=0 width=100% cellspacing=1 cellpadding=1 >
							<tr><td width=50%> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Koli: <?= $upd_koli_k ?></b></td><td><b>Berat: <?= $upd_berat_k ?></b></td></tr>
						</table></td></tr>
					</table>
				</td>
			</tr>
			</table></td>
		</tr>
	</table></td>
</tr> -->
        <tr>
            <td height=60>
                <table width=100% cellspacing=0 cellpadding=0 border=0>
                    <tr>
                        <td>
                            <table width=100% cellspacing=0 cellpadding=0 border=0>
                                <tr>
                                    <td width=25%>
                                        <table width=100% cellspacing=0 cellpadding=0>
                                            <tr>
                                                <td width=75%>
                                                    <table border=0 width=100% cellspacing=5 cellpadding=5>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                        </tr>
                                                        <tr>
                                                            <td><i>&nbsp;</i></td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td><b>HLP</b></td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td width=25%>
                                        <table width=100% cellspacing=0 cellpadding=0>
                                            <tr>
                                                <td width=75%>
                                                    <table border=0 width=100% cellspacing=5 cellpadding=5>
                                                        <tr>
                                                            <td> &nbsp;</td>
                                                        </tr>
                                                        <tr>
                                                            <td><i>&nbsp;</i></td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td><b><?= $row->tujuan ?></b></td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td width=50%>
                                        <table width=100% cellspacing=5 cellpadding=5>
                                            <tr>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td><i></i></td>
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
                <table width=100% cellspacing=0 cellpadding=0 border=0>
                    <tr>
                        <td width=30%>
                            <table width=100% cellspacing=0 cellpadding=0 border=0>
                                <tr>
                                    <td>
                                        <table border=0 width=100% cellspacing=3 cellpadding=3>
                                            <!-- <tr><td> &nbsp;</td></tr> -->
                                            <tr>
                                                <td>&nbsp;</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td><br><br>
                                        <table border=0 width=100% cellspacing=2 cellpadding=2>
                                            <tr>
                                                <td align=left><br><?= $check_spx ?></td>
                                                <td><i></i></td>
                                            </tr>
                                            <tr>
                                                <td height=80 align=left><br>
                                                    <?= $check_sco ?></td>
                                                <td><i></i></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr rowspan=2>
                                    <td>&nbsp;</font>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td width=60%>
                            <table width=100% cellspacing=0 cellpadding=0 border=0>
                                <tr>
                                    <td width=75%>
                                        <table border=0 width=100% cellspacing=5 cellpadding=5>
                                            <tr>
                                                <td width=65%>
                                                    <table border=0 width=100% cellspacing=0 cellpadding=0>
                                                        <tr>
                                                            <td> &nbsp;</td>
                                                        </tr>
                                                        <!-- <tr><td><i>&nbsp;<br></i></td></tr> -->
                                                    </table>
                                                </td>
                                                <td align=left>
                                                    <font=16><b><?= $row->alasan ?><b></font>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <table border=0 width=100% cellspacing=0 cellpadding=0>
                                            <tr>
                                                <td width=20%>
                                                    <table border=0 width=100% cellspacing=3 cellpadding=3>
                                                        <tr>
                                                            <td style='padding-top: 10px'>&nbsp;</td>
                                                        </tr>
                                                        <tr>
                                                            <td><i>&nbsp;</i></td>
                                                        </tr>
                                                        <tr rowspan=4>
                                                            <td><br><br>&nbsp;</td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td width=20%>
                                                    <table border=0 width=100% cellspacing=3 cellpadding=3>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                        </tr>
                                                        <!-- <tr><td><i>&nbsp;</i></td></tr> -->
                                                        <tr rowspan=2>
                                                            <td>
                                                                <font=16><b><br><?= $xray ?></b></font>
                                                            </td>
                                                        </tr>
                                                        <tr rowspan=2>
                                                            <td>&nbsp;</font>
                                                            </td>
                                                        </tr>
                                                    </table>

                                                </td>
                                                <td width=20%>
                                                    <table border=0 width=100% cellspacing=3 cellpadding=3>
                                                        <tr>
                                                            <td style='padding-top: 1px'></td>
                                                        </tr>
                                                        <tr>
                                                            <td><i><br></i></td>
                                                        </tr>
                                                        <tr rowspan=4>
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
            <td height=50>
                <table border=0 width=100% cellspacing=0 cellpadding=0>
                    <tr>
                        <td>
                            <table border=0 width=100% cellspacing=5 cellpadding=5>
                                <tr>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td><i><?= $metode ?></i></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td height=80>
                <table border=0 width=100% cellspacing=0 cellpadding=0>
                    <tr>
                        <td width=50%>
                            <table border=0 width=100% cellspacing=5 cellpadding=5>
                                <tr>
                                    <td> &nbsp;</td>
                                </tr>
                                <tr>
                                    <td><i>&nbsp;</i></td>
                                </tr>
                                <tr rowspan=40>
                                    <td height=80><br></td>
                                </tr>
                                <tr align=center>
                                    <td><?= $row->avsec_nama ?></td>
                                </tr>
                                <tr align=center>
                                    <td></td>
                                </tr>
                                <tr align=center>
                                    <td><?= $row->avsec_nik ?></td>
                                </tr>
                            </table>
                        </td>
                        <td width=50%>
                            <table border=0 width=100% cellspacing=5 cellpadding=5>
                                <!-- <tr><td >&nbsp;</td></tr> -->
                                <!-- <tr><td><i>&nbsp;</i></td></tr> -->
                                <tr rowspan=30>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>

                                        <table border=0 width=100% cellspacing=5 cellpadding=5>
                                            <!-- <tr><td width=50%>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?= $tgl_cetak ?></td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?= $time2 ?></td></tr> -->
                                            <tr>
                                                <td width=50%>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?= $wday1ctk ?>&nbsp;&nbsp;&nbsp;&nbsp;<?= $wday2ctk ?>&nbsp;&nbsp;&nbsp;&nbsp;<?= $wday3ctk ?></td>
                                                <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?= $hour ?>&nbsp;&nbsp;&nbsp;<?= $minute ?>&nbsp;&nbsp;&nbsp;<?= $second ?></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr rowspan=12>
                                    <td><br><br></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td height=40>
                <table border=0 width=100% cellspacing=0 cellpadding=0>
                    <tr>
                        <td>
                            <table border=0 width=100% cellspacing=5 cellpadding=5>
                                <tr>
                                    <td><br></td>
                                </tr>
                                <tr>
                                    <td><i></i></td>
                                </tr>
                                <tr>
                                    <td><br><b>RA LJA</b></td>
                                </tr>
                                <!-- <tr><td><br><b>RA APKARGO</b></td></tr> -->
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr>
            <td>
                <table border=0 width=100% cellspacing=0 cellpadding=0>
                    <tr>
                        <td><br>
                            <table border=0 width=100% cellspacing=0 cellpadding=0>
                                <tr>
                                    <td width=70%>
                                        <table width=100% border=0 cellspacing=6 cellpadding=6>
                                            <tr>
                                                <td width=40%></td>
                                                <td>&nbsp;</td>
                                                <td><b><?= $row->truck_no_polisi ?></b></td>
                                            </tr>
                                            <tr>
                                                <td width=40%></td>
                                                <td>&nbsp;</td>
                                                <td><b><?= $row->no_segel ?></b></td>
                                            </tr>
                                            <tr>
                                                <td width=40%></td>
                                                <td>&nbsp;</td>
                                                <td><b><?= $row->no_sticker ?></b></td>
                                            </tr>
                                            <tr>
                                                <td width=40%></td>
                                                <td>&nbsp;</td>
                                                <td><b><?= $row->driver_nama ?></b></td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td width=20% align=center><b><?= $row->nama_agent ?></b></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <style type="text/css">
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
        </style>
    </table>






    <script type="text/javascript">
        window.print();
    </script>

</body>

</html>