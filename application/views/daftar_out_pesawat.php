<?php
// Master: out_pesawat (level 909). Akun pendapatan hanya untuk level 905.
$kolom = [
    ['label' => 'Nama maskapai', 'field' => 'nama', 'type' => 'bold'],
    ['label' => 'Awalan SMU',    'field' => 'prefix'],
    ['label' => 'Warna',         'field' => 'warna', 'type' => 'color'],
    ['label' => 'Jaster',        'field' => 'jaster', 'type' => 'flag'],
    ['label' => 'Pembagi volume', 'field' => 'pembagi'],
];
$fields = [
    ['name' => 'nama',   'label' => 'Nama maskapai', 'key' => true, 'required' => true, 'placeholder' => 'contoh: CITILINK',
        'help' => 'Tidak bisa diganti setelah disimpan, karena nama dipakai di data SMU.'],
    ['name' => 'prefix', 'label' => 'Awalan nomor SMU', 'placeholder' => 'contoh: 888'],
    ['name' => 'warna',  'label' => 'Warna penanda', 'type' => 'color'],
    ['name' => 'jaster', 'label' => 'Jaster?', 'type' => 'select', 'options' => ['0' => 'Tidak', '1' => 'Ya'], 'default' => '0'],
    ['name' => 'pembagi', 'label' => 'Pembagi volume', 'type' => 'number', 'step' => '1',
        'placeholder' => 'kosong = ' . ($pembagi_default ?? 6000),
        'help' => 'Volume = panjang x lebar x tinggi (cm) / pembagi. Kosongkan untuk memakai pembagi standar (' . ($pembagi_default ?? 6000) . ').'],
];
if (!empty($boleh_coa)) {
    $kolom[]  = ['label' => 'Akun pendapatan', 'field' => 'coa_pendapatan', 'type' => 'coa', 'kosong' => 'pakai akun standar'];
    $fields[] = ['name' => 'coa_pendapatan', 'label' => 'Akun pendapatan', 'type' => 'coa', 'kosong' => '- pakai akun standar -',
        'help' => 'Akun pendapatan saat invoice maskapai ini dicetak.'];
}
$kolom[]  = ['label' => 'Status', 'field' => 'hold', 'type' => 'flag', 'ya' => 'Nonaktif', 'tidak' => 'Aktif', 'warna_ya' => 'danger', 'warna_tidak' => 'success'];
$fields[] = ['name' => 'hold', 'label' => 'Status', 'type' => 'select', 'options' => ['0' => 'Aktif', '1' => 'Nonaktif'], 'default' => '0'];

$cfg = [
    'judul'        => 'Daftar Maskapai (Outgoing)',
    'judul_form'   => 'Maskapai',
    'store_url'    => 'outgoinghlp/store_pesawat',
    'label_tambah' => 'Tambah Maskapai',
    'info'         => 'Maskapai <b>Nonaktif</b> tidak muncul di pilihan pesawat saat input SMU. '
        . '<b>Pembagi volume</b> dipakai saat menghitung volume dimensi di Kemasan SMU; kosong berarti memakai pembagi standar (' . ($pembagi_default ?? 6000) . ').'
        . (!empty($boleh_coa) ? '' : ' Akun pendapatan hanya dapat diatur oleh bagian keuangan.'),
    'kolom'        => $kolom,
    'fields'       => $fields,
];
include __DIR__ . '/master_warehouse_template.php';
