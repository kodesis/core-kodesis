<?php
// Master: in_pesawat (level 919). Akun pendapatan hanya untuk level 915.
$kolom = [
    ['label' => 'Nama maskapai', 'field' => 'nama', 'type' => 'bold'],
    ['label' => 'Awalan SMU',    'field' => 'prefix'],
    ['label' => 'Warna',         'field' => 'warna', 'type' => 'color'],
];
$fields = [
    ['name' => 'nama',   'label' => 'Nama maskapai', 'key' => true, 'required' => true, 'placeholder' => 'contoh: CITILINK',
        'help' => 'Tidak bisa diganti setelah disimpan, karena nama dipakai di data SMU.'],
    ['name' => 'prefix', 'label' => 'Awalan nomor SMU', 'placeholder' => 'contoh: 888'],
    ['name' => 'warna',  'label' => 'Warna penanda', 'type' => 'color'],
];
if (!empty($boleh_coa)) {
    $kolom[]  = ['label' => 'Akun pendapatan', 'field' => 'coa_pendapatan', 'type' => 'coa', 'kosong' => 'pakai akun standar'];
    $fields[] = ['name' => 'coa_pendapatan', 'label' => 'Akun pendapatan', 'type' => 'coa', 'kosong' => '- pakai akun standar -',
        'help' => 'Akun pendapatan saat invoice incoming maskapai ini dicetak.'];
}

$cfg = [
    'judul'        => 'Daftar Maskapai (Incoming)',
    'judul_form'   => 'Maskapai',
    'store_url'    => 'incominghlp/store_pesawat',
    'label_tambah' => 'Tambah Maskapai',
    'info'         => !empty($boleh_coa) ? '' : 'Akun pendapatan hanya dapat diatur oleh bagian keuangan.',
    'kolom'        => $kolom,
    'fields'       => $fields,
];
include __DIR__ . '/master_warehouse_template.php';
