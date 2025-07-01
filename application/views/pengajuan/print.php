<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pengajuan <?= $pengajuan->kode ?></title>

  <style>
    @page {
      margin: 1.5mm 5mm;
    }

    * {
      font-size: 10pt;
    }

    table {
      width: 100%;
    }

    td,
    th {
      /* border: 1px solid #ddd; */
      padding: 8px;
    }
  </style>
</head>

<body>
  <div>
    <h2 style="text-align: center;">Pengajuan Biaya</h2>
    <table border="1" style="border-collapse: collapse;">
      <?php
      $user = $this->db->select('a.nama, b.nama as nama_bagian')->from('users a')->join('bagian b', 'b.kode = a.bagian')->where('nip', $pengajuan->user)->get()->row();
      $supervisi = $this->db->select('a.nama, b.nama as nama_bagian')->from('users a')->join('bagian b', 'b.kode = a.bagian')->where('nip', $pengajuan->spv)->get()->row();
      $finance = $this->db->select('a.nama, b.nama as nama_bagian')->from('users a')->join('bagian b', 'b.kode = a.bagian')->where('nip', $pengajuan->keuangan)->get()->row();
      $direksi = $this->db->select('a.nama, b.nama as nama_bagian')->from('users a')->join('bagian b', 'b.kode = a.bagian')->where('nip', $pengajuan->direksi)->get()->row();

      ?>
      <thead>
        <tr>
          <td colspan="5" style="text-align: center;">
            <img src="<?= $this->session->userdata('icon') ?>" style="width: 200px;" alt="">
          </td>
        </tr>
        <tr>
          <td colspan="2">Tanggal : <?= tgl_indo(date('Y-m-d', strtotime($pengajuan->created_at))) ?></td>
          <td colspan="3">No. Pengajuan : <?= $pengajuan->kode ?></td>
        </tr>
        <tr>
          <td colspan="2">User : <?= $user->nama ?></td>
          <td colspan="3">Divisi : <?= $user->nama_bagian ?></td>
        </tr>
        <tr>
          <th width="20px">No</th>
          <th>Keterangan</th>
          <th width="20px">Qty</th>
          <th>Harga Satuan</th>
          <th>Total</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $i = 1;
        foreach ($pengajuan_detail as $value) : ?>
          <tr>
            <td><?= $i++ ?></td>
            <td><?= $value->item ?></td>
            <td><?= $value->qty ?></td>
            <td><?= number_format($value->price) ?></td>
            <td><?= number_format($value->total) ?></td>
          </tr>
        <?php endforeach; ?>
        <tr>
          <td colspan="4" style="text-align: end;">Jumlah</td>
          <td><?= number_format($pengajuan->total) ?></td>
        </tr>
        <tr>
          <td colspan="5" style="text-align: left;">Terbilang : <br> <strong><?= terbilang($pengajuan->total) ?> Rupiah</strong> </td>
        </tr>
        <tr>
          <td colspan="5">Catatan : <br> <?= $pengajuan->catatan ?></td>
        </tr>
      </tbody>
    </table>
    <table border="0">
      <tr>
        <td>User,</td>
        <td>Supervisi,</td>
        <td>Finance,</td>
        <td>Direksi,</td>
      </tr>
      <tr>
        <td>
          <img src="<?= base_url() . "img/approved.png" ?>" alt="approved" width="35%">
        </td>
        <td>
          <?php if ($pengajuan->status_spv == 1) { ?>
            <img src="<?= base_url() . "img/approved.png" ?>" alt="approved" width="35%">
          <?php } ?>
        </td>
        <td>
          <?php if ($pengajuan->status_keuangan == 1) { ?>
            <img src="<?= base_url() . "img/approved.png" ?>" alt="approved" width="35%"><br>
          <?php } ?>
        </td>
        <td></td>
      </tr>
      <tr>
        <td><?= $user->nama ?></td>
        <td><?= $supervisi->nama ?></td>
        <td><?= $finance ? $finance->nama : '' ?></td>
        <td></td>
      </tr>
      <tr>
        <td></td>
        <td><?= tgl_indo(date('Y-m-d', strtotime($pengajuan->date_spv))) ?></td>
        <td><?= $pengajuan->date_keuangan ? tgl_indo(date('Y-m-d', strtotime($pengajuan->date_keuangan))) : "" ?></td>
      </tr>
    </table>
  </div>
</body>

</html>