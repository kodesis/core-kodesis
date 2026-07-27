<?php

function terbilang($angka)
{
    $angka  = abs($angka);
    $angka  = round($angka);
    $huruf  = ['', 'satu', 'dua', 'tiga', 'empat', 'lima', 'enam', 'tujuh', 'delapan', 'sembilan', 'sepuluh', 'sebelas'];

    if ($angka < 12) {
        $hasil = ' ' . $huruf[$angka];
    } elseif ($angka < 20) {
        $hasil = terbilang($angka - 10) . ' belas';
    } elseif ($angka < 100) {
        $hasil = terbilang((int)($angka / 10)) . ' puluh' . terbilang($angka % 10);
    } elseif ($angka < 200) {
        $hasil = ' seratus' . terbilang($angka - 100);
    } elseif ($angka < 1000) {
        $hasil = terbilang((int)($angka / 100)) . ' ratus' . terbilang($angka % 100);
    } elseif ($angka < 2000) {
        $hasil = ' seribu' . terbilang($angka - 1000);
    } elseif ($angka < 1000000) {
        $hasil = terbilang((int)($angka / 1000)) . ' ribu' . terbilang($angka % 1000);
    } elseif ($angka < 1000000000) {
        $hasil = terbilang((int)($angka / 1000000)) . ' juta' . terbilang($angka % 1000000);
    } elseif ($angka < 1000000000000) {
        $hasil = terbilang((int)($angka / 1000000000)) . ' miliar' . terbilang($angka % 1000000000);
    } else {
        $hasil = terbilang((int)($angka / 1000000000000)) . ' triliun' . terbilang($angka % 1000000000000);
    }

    return $hasil;
}
