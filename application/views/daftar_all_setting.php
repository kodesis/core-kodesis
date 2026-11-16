<?php
// Halaman Setting Tarif & COA (level 905). Baris disiapkan controller dengan nama & nilai yang mudah dibaca.
$cfg = [
    'judul'       => 'Pengaturan Tarif, Akun & Nomor Dokumen',
    'judul_form'  => 'Pengaturan',
    'store_url'   => $store_url ?? 'outgoinghlp/store_setting',
    'bisa_tambah' => false,
    'info'        => 'Halaman ini berisi angka dan akun yang dipakai otomatis saat membuat invoice dan jurnal. '
        . 'Klik <b>Ubah</b> pada baris yang ingin diganti. Perubahan hanya berlaku untuk invoice <b>baru</b>; invoice lama tidak berubah.<br>'
        . 'Bagian <b>Lanjutan (teknis)</b> disembunyikan; pilih di kotak "Tampilkan bagian" bila perlu, dan ubah hanya setelah berkoordinasi dengan bagian IT/keuangan.',
    'filter'      => ['label' => 'Tampilkan bagian', 'kolom' => 0, 'options' => $bagian ?? [], 'semua' => 'Semua (kecuali Lanjutan)', 'sembunyi' => 'Lanjutan (teknis)'],
    'kolom'       => [
        ['label' => 'Bagian',          'field' => 'bagian'],
        ['label' => 'Pengaturan',      'field' => 'nama', 'type' => 'bold'],
        ['label' => 'Nilai sekarang',  'field' => 'tampil'],
        ['label' => 'Penjelasan',      'field' => 'help', 'type' => 'muted'],
    ],
    'fields'      => [
        ['name' => 'kunci', 'type' => 'hidden'],
        ['name' => 'nama',  'label' => 'Pengaturan', 'type' => 'tampil'],
        ['name' => 'help',  'label' => 'Penjelasan', 'type' => 'tampil'],
        ['name' => 'nilai', 'label' => 'Nilai baru', 'type' => 'nilai_setting', 'dari' => 'nilai_form', 'required' => true],
    ],
];
include __DIR__ . '/master_warehouse_template.php';
