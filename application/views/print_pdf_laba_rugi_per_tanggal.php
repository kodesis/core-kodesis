<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10pt;
        }

        h2 {
            text-align: center;
            font-size: 12pt;
            margin-bottom: 20px;
        }

        .coa-header {
            background-color: #E8E8E8;
            font-weight: bold;
            padding: 5px;
            margin-top: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 3px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .bold {
            font-weight: bold;
        }

        .summary-row {
            background-color: #f9f9f9;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <h2><?= $title ?></h2>

    <table>
        <thead>
            <tr class="coa-header">
                <th colspan="3">PENDAPATAN</th>
            </tr>
            <tr class="coa-header">
                <th style="width: 25%">No. Coa</th>
                <th style="width: 50%">Nama Coa</th>
                <th>Nominal</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($pendapatan as $a) :
                $coa = $this->m_coa->getCoa($a->no_sbb);

                if ($coa['table_source'] == "t_coalr_sbb" && $coa['posisi'] == 'PASIVA') { ?>
                    <tr>
                        <td><?= $a->no_sbb ?></td>
                        <td><?= $coa['nama_perkiraan'] ?></td>
                        <td class="text-right"><?= number_format($a->saldo_awal, 0) ?></td>
                    </tr>
            <?php
                }
            endforeach; ?>
            <tr class="coa-header">
                <th class="text-center" colspan="2">TOTAL</th>
                <th class="text-right"><?= number_format($sum_pendapatan) ?></th>
            </tr>
        </tbody>
    </table>

    <table>
        <thead>
            <tr class="coa-header">
                <th colspan="3">BIAYA</th>
            </tr>
            <tr class="coa-header">
                <th style="width: 25%">No. Coa</th>
                <th style="width: 50%">Nama Coa</th>
                <th>Nominal</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($biaya as $a) :
                $coa = $this->m_coa->getCoa($a->no_sbb);

                if ($coa['table_source'] == "t_coalr_sbb" && $coa['posisi'] == 'AKTIVA') { ?>
                    <tr>
                        <td><?= $a->no_sbb ?></td>
                        <td><?= $coa['nama_perkiraan'] ?></td>
                        <td class="text-right"><?= number_format($a->saldo_awal, 0) ?></td>
                    </tr>
            <?php

                }
            endforeach; ?>
            <tr class="coa-header">
                <th class="text-center" colspan="2">TOTAL</th>
                <th class="text-right"><?= number_format($sum_biaya) ?></th>
            </tr>
        </tbody>
    </table>
    <table>
        <thead>
            <tr>
                <th colspan="2">
                    <h3>LABA BERJALAN</h3>
                </th>
                <th class="text-right">
                    <h3><?= number_format($total_pendapatan) ?></h3>
                </th>
            </tr>
        </thead>
    </table>
</body>

</html>