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

        .footer {
            margin-top: 30px;
        }

        .footer p {
            font-size: 10px;
            color: #777;
        }
    </style>
    <title><?= $title ?></title>
</head>

<body>
    <h2><?= $title ?></h2>

    <table>
        <thead>
            <tr class="coa-header">
                <th colspan="3">AKTIVA</th>
            </tr>
            <tr class="coa-header">
                <th style="width: 25%">No. Coa</th>
                <th style="width: 50%">Nama Coa</th>
                <th>Nominal</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($activa as $a) :
                $coa = $this->m_coa->getCoa($a->no_sbb);

                if ($coa['table_source'] == "t_coa_sbb" && $coa['posisi'] == 'AKTIVA' && $a->saldo_awal > 0) { ?>
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
                <th class="text-right"><?= number_format($sum_activa) ?></th>
            </tr>
        </tbody>
    </table>
    <table>
        <thead>
            <tr class="coa-header">
                <th colspan="3">PASIVA</th>
            </tr>
            <tr class="coa-header">
                <th style="width: 25%">No. Coa</th>
                <th style="width: 50%">Nama Coa</th>
                <th>Nominal</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($pasiva as $a) :
                $coa = $this->m_coa->getCoa($a->no_sbb);

                if ($coa['table_source'] == "t_coa_sbb" && $coa['posisi'] == 'PASIVA' && $a->saldo_awal > 0) { ?>
                    <tr>
                        <td><?= $a->no_sbb ?></td>
                        <td><?= $coa['nama_perkiraan'] ?></td>
                        <td class="text-right"><?= number_format($a->saldo_awal, 0) ?></td>
                    </tr>
            <?php
                }
            endforeach; ?>
            <tr>
                <td>31030</td>
                <td>Laba Tahun Berjalan</td>
                <td class="text-right"><?= number_format($laba, 0) ?></td>
            </tr>
            <tr class="coa-header">
                <th class="text-center" colspan="2">TOTAL</th>
                <th class="text-right"><?= number_format($sum_pasiva) ?></th>
            </tr>
        </tbody>
    </table>
    <!-- <table>
        <thead>
            <tr>
                <th colspan="2">
                    <h3>NERACA</h3>
                </th>
                <th class="text-right">
                    <h3><?= number_format($neraca) ?></h3>
                </th>
            </tr>
        </thead>
    </table> -->


    <div class="footer" style="text-align: right">
        <p>
            <!-- Dicetak otomatis pada <?= format_indo(date('Y-m-d H:i:s')) ?> WIB <br> -->
            <!-- Supported by: kodesis.id -->
        </p>
    </div>
</body>

</html>