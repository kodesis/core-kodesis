<?php
// Master: all_pay_methode (level 905) - cara pembayaran & akun penerimaan uang
$cfg = [
    'judul'        => 'Cara Pembayaran',
    'judul_form'   => 'Cara Pembayaran',
    'store_url'    => 'outgoinghlp/store_pay_methode',
    'label_tambah' => 'Tambah Cara Bayar',
    'info'         => 'Daftar cara bayar yang bisa dipilih kasir, dan <b>akun tempat uang masuk</b> saat invoice dibayar.<br>'
        . '<b>Deposit</b> dan <b>Transfer</b> tidak perlu akun di sini: Deposit memakai akun agen, Transfer memakai akun bank yang dipilih kasir (menu Bank Transfer).<br>'
        . 'Untuk menyembunyikan cara bayar, ubah <b>Status</b> menjadi Nonaktif; jangan mengganti arti kode yang sudah ada.',
    'kolom'        => [
        ['label' => 'Kode',                     'field' => 'kode'],
        ['label' => 'Nama cara bayar',          'field' => 'label', 'type' => 'bold'],
        ['label' => 'Tulisan di jurnal',        'field' => 'nama'],
        ['label' => 'Akun uang masuk',          'field' => 'coa_debit', 'type' => 'coa', 'kosong' => 'otomatis (agen / bank)'],
        ['label' => 'Muncul saat ubah invoice', 'field' => 'tampil_ubah', 'type' => 'flag'],
        ['label' => 'Muncul saat bayar',        'field' => 'tampil_bayar', 'type' => 'flag'],
        ['label' => 'Status', 'field' => 'hold', 'type' => 'flag', 'ya' => 'Nonaktif', 'tidak' => 'Aktif', 'warna_ya' => 'danger', 'warna_tidak' => 'success'],
    ],
    'fields'       => [
        ['name' => 'kode',  'label' => 'Kode', 'key' => true, 'required' => true, 'placeholder' => 'contoh: 7',
            'help' => 'Angka. Tidak bisa diganti setelah disimpan.'],
        ['name' => 'label', 'label' => 'Nama cara bayar', 'required' => true, 'placeholder' => 'contoh: Debit BCA', 'help' => 'Nama yang dilihat kasir.'],
        ['name' => 'nama',  'label' => 'Tulisan di jurnal', 'required' => true, 'placeholder' => 'contoh: DEBIT BCA',
            'help' => 'Ditulis di keterangan jurnal: "PEMBAYARAN INVOICE ... METODE : <i>tulisan ini</i>".'],
        ['name' => 'coa_debit', 'label' => 'Akun uang masuk', 'type' => 'coa', 'kosong' => '- otomatis (deposit / transfer) -',
            'help' => 'Akun yang bertambah saat invoice dibayar dengan cara ini.'],
        ['name' => 'tampil_ubah',  'label' => 'Muncul saat ubah invoice?', 'type' => 'select', 'options' => ['1' => 'Ya', '0' => 'Tidak'], 'default' => '1'],
        ['name' => 'tampil_bayar', 'label' => 'Muncul saat bayar invoice?', 'type' => 'select', 'options' => ['1' => 'Ya', '0' => 'Tidak'], 'default' => '1'],
        ['name' => 'hold', 'label' => 'Status', 'type' => 'select', 'options' => ['0' => 'Aktif', '1' => 'Nonaktif'], 'default' => '0'],
    ],
];
include __DIR__ . '/master_warehouse_template.php';
