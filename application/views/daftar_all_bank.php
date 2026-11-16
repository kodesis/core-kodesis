<?php
// Master: all_bank (level 905) - rekening bank untuk pembayaran transfer
$cfg = [
    'judul'        => 'Rekening Bank untuk Transfer',
    'judul_form'   => 'Rekening Bank',
    'store_url'    => 'outgoinghlp/store_bank',
    'label_tambah' => 'Tambah Rekening',
    'info'         => 'Daftar rekening yang bisa dipilih kasir saat invoice dibayar dengan <b>Transfer</b>. '
        . 'Uang dicatat masuk ke <b>akun</b> rekening yang dipilih.<br>'
        . 'Rekening dengan <b>urutan</b> terkecil otomatis terpilih lebih dulu di form bayar.',
    'kolom'        => [
        ['label' => 'Nama rekening', 'field' => 'nama', 'type' => 'bold'],
        ['label' => 'Akun',          'field' => 'coa', 'type' => 'coa'],
        ['label' => 'Urutan',        'field' => 'urutan'],
        ['label' => 'Status', 'field' => 'hold', 'type' => 'flag', 'ya' => 'Nonaktif', 'tidak' => 'Aktif', 'warna_ya' => 'danger', 'warna_tidak' => 'success'],
    ],
    'fields'       => [
        ['name' => 'nama', 'label' => 'Nama rekening', 'required' => true, 'placeholder' => 'contoh: BNI MBZ',
            'help' => 'Nama yang dilihat kasir dan tercetak di data invoice.'],
        ['name' => 'coa',  'label' => 'Akun rekening', 'type' => 'coa', 'required' => true, 'help' => 'Pilih akun bank dari daftar akun.'],
        ['name' => 'urutan', 'label' => 'Urutan di daftar', 'type' => 'number', 'step' => '1', 'default' => '0', 'help' => '1 = paling atas dan terpilih otomatis.'],
        ['name' => 'hold', 'label' => 'Status', 'type' => 'select', 'options' => ['0' => 'Aktif', '1' => 'Nonaktif'], 'default' => '0'],
    ],
];
include __DIR__ . '/master_warehouse_template.php';
