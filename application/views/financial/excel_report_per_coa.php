<?php
header("Content-Type: application/vnd.ms-excel; charset=utf-8");
?>
<table border="1">
    <thead>
        <tr>
            <th colspan="5" style="font-size: 14pt; font-weight: bold; text-align: center;">
                LAPORAN COA: <?= isset($detail_coa->nama_perkiraan) ? $detail_coa->nama_perkiraan : $this->input->post('no_coa') ?>
            </th>
        </tr>
        <tr>
            <th colspan="5" style="text-align: center;">
                Periode: <?= $this->input->post('tgl_dari') ?> s/d <?= $this->input->post('tgl_sampai') ?>
            </th>
        </tr>
        <tr style="background-color: #f2f2f2; font-weight: bold;">
            <th>No</th>
            <th>Tanggal</th>
            <th>Debit</th>
            <th>Kredit</th>
            <th>Keterangan</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        if (!empty($coa)):
            foreach ($coa as $row):
        ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= date('d-m-Y', strtotime($row->tanggal)); ?></td>
                    <td><?= $row->akun_debit == $this->input->post('no_coa') ? $row->jumlah_debit : 0; ?></td>
                    <td><?= $row->akun_kredit == $this->input->post('no_coa') ? $row->jumlah_kredit : 0; ?></td>
                    <td><?= $row->keterangan; ?></td>
                </tr>
        <?php
            endforeach;
        endif;
        ?>
    </tbody>
    <tfoot>
        <tr style="font-weight: bold; background-color: #e6e6e6;">
            <td colspan="2" style="text-align: right;">Total:</td>
            <td><?= $sum_debit; ?></td>
            <td><?= $sum_kredit; ?></td>
        </tr>
    </tfoot>
</table>