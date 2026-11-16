<?php
// Master: all_ref (level 909) - teks pilihan yang muncul di form & cetakan
$grup_nama = $this->M_warehouse_ref->ref_grup_nama();
$cfg = [
    'judul'        => 'Daftar Pilihan (Referensi)',
    'judul_form'   => 'Pilihan',
    'store_url'    => 'outgoinghlp/store_ref',
    'label_tambah' => 'Tambah Pilihan',
    'info'         => 'Halaman ini mengatur <b>teks pilihan</b> yang muncul di form dan cetakan, misalnya pilihan Kategori SMU atau Gudang tujuan DO. '
        . 'Yang biasanya diubah hanya <b>Teks yang tampil</b>.<br>'
        . '<b>Bisa dipilih di form = Tidak</b>: teks tetap muncul untuk data lama, tetapi tidak bisa dipilih untuk data baru. '
        . '<b>Nonaktif</b>: disembunyikan sepenuhnya.',
    'filter'       => ['label' => 'Tampilkan', 'kolom' => 0, 'options' => array_values($grup_nama), 'semua' => 'Semua jenis pilihan'],
    'kolom'        => [
        ['label' => 'Jenis pilihan',      'field' => 'grup', 'type' => 'map', 'map' => $grup_nama],
        ['label' => 'Kode',               'field' => 'kode'],
        ['label' => 'Teks yang tampil',   'field' => 'label', 'type' => 'bold'],
        ['label' => 'Urutan',             'field' => 'urutan'],
        ['label' => 'Bisa dipilih di form', 'field' => 'tampil_form', 'type' => 'flag'],
        ['label' => 'Status', 'field' => 'hold', 'type' => 'flag', 'ya' => 'Nonaktif', 'tidak' => 'Aktif', 'warna_ya' => 'danger', 'warna_tidak' => 'success'],
    ],
    'fields'       => [
        ['name' => 'grup',  'label' => 'Jenis pilihan', 'type' => 'select', 'options' => $grup_nama, 'key' => true, 'required' => true,
            'help' => 'Tidak bisa diganti setelah disimpan.'],
        ['name' => 'kode',  'label' => 'Kode', 'key' => true, 'required' => true, 'placeholder' => 'contoh: 6',
            'help' => 'Kode yang disimpan di data. Tidak bisa diganti setelah disimpan, karena sudah dipakai data lama.'],
        ['name' => 'label', 'label' => 'Teks yang tampil', 'required' => true, 'placeholder' => 'contoh: Langsung (Direct)'],
        ['name' => 'urutan', 'label' => 'Urutan di daftar', 'type' => 'number', 'step' => '1', 'default' => '0', 'help' => 'Angka kecil tampil lebih atas.'],
        ['name' => 'tampil_form', 'label' => 'Bisa dipilih di form?', 'type' => 'select', 'options' => ['1' => 'Ya', '0' => 'Tidak'], 'default' => '1'],
        ['name' => 'hold', 'label' => 'Status', 'type' => 'select', 'options' => ['0' => 'Aktif', '1' => 'Nonaktif'], 'default' => '0'],
    ],
];
include __DIR__ . '/master_warehouse_template.php';
