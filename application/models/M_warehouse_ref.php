<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Referensi & setting modul Outgoing.
 *
 * Semua nilai yang sebelumnya ditulis langsung (hardcode) di controller
 * Outgoinghlp (tarif, PPN/PPh, COA, prefix nomor, label kode, dll.)
 * diambil dari tabel di database corebank:
 *   - all_setting      : key-value (tarif, COA tetap, prefix, batas nominal)
 *   - all_ref          : kode -> label per grup (catg_smu, metode_periksa, ...)
 *   - all_pay_methode  : metode pembayaran + COA debit
 *   - all_bank         : COA bank -> nama bank
 *   - out_pesawat.coa_pendapatan : COA pendapatan per maskapai
 *
 * Lihat: application/sql/warehouse_ref_setting.sql
 */
class M_warehouse_ref extends CI_Model
{
	private $cb;
	private $setting     = null;
	private $ref         = [];
	private $pay_methode = null;
	private $bank        = null;
	private $coa_pesawat = [];

	public function __construct()
	{
		parent::__construct();
		$this->cb = $this->load->database('corebank', TRUE);
	}

	/**
	 * Ambil semua baris tabel (SELECT *) tanpa menghentikan halaman bila
	 * tabel / kolom belum ada (misal SQL migrasi belum dijalankan).
	 * Error dicatat ke log CodeIgniter, hasilnya array kosong.
	 */
	private function ambil($table)
	{
		$debug = $this->cb->db_debug;
		$this->cb->db_debug = FALSE;
		$query = $this->cb->get($table);
		$this->cb->db_debug = $debug;

		if (!$query) {
			$err = $this->cb->error();
			log_message('error', 'M_warehouse_ref: gagal membaca ' . $table . ' - ' . ($err['message'] ?? ''));
			return [];
		}
		return $query->result_array();
	}

	/** Urutkan baris berdasarkan kolom (kolom yang tidak ada dianggap 0). */
	private function urutkan(array $rows, $kolom, $kolom2 = null)
	{
		usort($rows, function ($a, $b) use ($kolom, $kolom2) {
			$c = ((float) ($a[$kolom] ?? 0)) <=> ((float) ($b[$kolom] ?? 0));
			if ($c === 0 && $kolom2) {
				$c = strcmp((string) ($a[$kolom2] ?? ''), (string) ($b[$kolom2] ?? ''));
			}
			return $c;
		});
		return $rows;
	}

	// ------------------------------------------------------------------
	//  all_setting
	// ------------------------------------------------------------------

	/** Nilai mentah dari all_setting. $default dipakai bila kunci belum ada. */
	public function setting($kunci, $default = null)
	{
		if ($this->setting === null) {
			$this->setting = array_column($this->ambil('all_setting'), 'nilai', 'kunci');
		}
		return array_key_exists($kunci, $this->setting) ? $this->setting[$kunci] : $default;
	}

	/** Baris tabel utility (database utama), hanya sebagai cadangan origin/prefix. */
	private $utility = null;
	private function utility_row()
	{
		if ($this->utility === null) {
			$debug = $this->db->db_debug;
			$this->db->db_debug = FALSE;
			$q = $this->db->where('Id', '1')->get('utility');
			$this->db->db_debug = $debug;
			$this->utility = $q ? ($q->row_array() ?: []) : [];
		}
		return $this->utility;
	}

	/**
	 * Kode origin warehouse (contoh HLP): dipakai di nomor invoice, cetakan
	 * CSD/BTB/invoice dan tracking. Dari all_setting 'origin'; bila kosong
	 * memakai kolom origin di tabel utility.
	 */
	public function origin()
	{
		$v = trim((string) $this->setting('origin', ''));
		return $v !== '' ? $v : (string) ($this->utility_row()['origin'] ?? '');
	}

	/**
	 * Prefix nomor BTB (contoh HLPO -> HLPO-000123). Dari all_setting 'prefix';
	 * bila kosong memakai kolom prefix di tabel utility.
	 */
	public function prefix()
	{
		$v = trim((string) $this->setting('prefix', ''));
		return $v !== '' ? $v : (string) ($this->utility_row()['prefix'] ?? '');
	}

	/** Nilai angka dari all_setting (tarif, persen, batas nominal). */
	public function rate($kunci, $default = 0)
	{
		return (float) $this->setting($kunci, $default);
	}

	/** Daftar kode dipisah koma di all_setting -> array. */
	public function setting_list($kunci, $default = '')
	{
		$raw = (string) $this->setting($kunci, $default);
		return array_values(array_filter(array_map('trim', explode(',', $raw)), 'strlen'));
	}

	// ------------------------------------------------------------------
	//  all_ref
	// ------------------------------------------------------------------

	/**
	 * Semua kode => label pada satu grup (urut sesuai kolom urutan).
	 * $form_only = true : hanya yang tampil_form = 1 (untuk <option> di form input).
	 */
	public function list_ref($grup, $form_only = false)
	{
		if (!isset($this->ref[$grup])) {
			$rows = array_filter($this->ambil_ref(), function ($r) use ($grup) {
				return $r['grup'] === $grup && ($r['hold'] ?? '0') != '1';
			});
			$this->ref[$grup] = $this->urutkan($rows, 'urutan');
		}
		$rows = $this->ref[$grup];
		if ($form_only) {
			// Kolom tampil_form belum ada (migrasi lama) => anggap tampil
			$rows = array_filter($rows, function ($r) {
				return ($r['tampil_form'] ?? '1') == '1';
			});
		}
		return array_column($rows, 'label', 'kode');
	}

	/** Seluruh isi all_ref, dibaca sekali per request. */
	private $ref_all = null;
	private function ambil_ref()
	{
		if ($this->ref_all === null) {
			$this->ref_all = $this->ambil('all_ref');
		}
		return $this->ref_all;
	}

	/** Label untuk satu kode; $default bila kode kosong / tidak terdaftar. */
	public function label($grup, $kode, $default = '-')
	{
		$kode = (string) $kode;
		if ($kode === '') {
			return $default;
		}
		$list = $this->list_ref($grup);
		return $list[$kode] ?? $default;
	}

	// ------------------------------------------------------------------
	//  all_pay_methode
	// ------------------------------------------------------------------

	/** Semua metode bayar (termasuk yang di-hold): kode => row. */
	public function list_pay_methode()
	{
		if ($this->pay_methode === null) {
			$this->pay_methode = [];
			foreach ($this->urutkan($this->ambil('all_pay_methode'), 'kode') as $r) {
				// Tabel versi lama belum punya kolom label / tampil_*: isi nilai bawaan
				$nama = (string) ($r['nama'] ?? '');
				if (!isset($r['label']) || $r['label'] === '') {
					$r['label'] = strlen($nama) <= 4 ? $nama : ucfirst(strtolower($nama));
				}
				$r['tampil_ubah']  = $r['tampil_ubah']  ?? '1';
				$r['tampil_bayar'] = $r['tampil_bayar'] ?? '1';
				$r['hold']         = $r['hold']         ?? '0';
				$this->pay_methode[(string) $r['kode']] = (object) $r;
			}
		}
		return $this->pay_methode;
	}

	/**
	 * Pilihan metode bayar untuk <option>: kode => label.
	 * $kolom : null (semua aktif), 'tampil_ubah' atau 'tampil_bayar'.
	 */
	public function pay_options($kolom = null)
	{
		$out = [];
		foreach ($this->list_pay_methode() as $kode => $r) {
			if (($r->hold ?? '0') == '1') continue;
			if ($kolom && isset($r->$kolom) && $r->$kolom != '1') continue;
			$out[$kode] = $r->label;
		}
		return $out;
	}

	/** Satu metode bayar, null bila tidak terdaftar. */
	public function pay_methode($kode)
	{
		$list = $this->list_pay_methode();
		return $list[(string) $kode] ?? null;
	}

	/** Label tampilan metode bayar (Deposit, Cash, ...). */
	public function pay_label($kode, $default = '')
	{
		$pm = $this->pay_methode($kode);
		return $pm ? $pm->label : $default;
	}

	// ------------------------------------------------------------------
	//  all_bank
	// ------------------------------------------------------------------

	/** Semua bank (termasuk yang di-hold): coa => row, urut kolom urutan. */
	public function list_bank()
	{
		if ($this->bank === null) {
			$this->bank = [];
			foreach ($this->urutkan($this->ambil('all_bank'), 'urutan', 'coa') as $r) {
				$this->bank[(string) $r['coa']] = (object) $r;
			}
		}
		return $this->bank;
	}

	/** Satu bank berdasarkan COA, null bila tidak terdaftar. */
	public function bank($coa)
	{
		$list = $this->list_bank();
		return $list[(string) $coa] ?? null;
	}

	/** Pilihan bank aktif untuk <option>: coa => nama. */
	public function bank_options()
	{
		$out = [];
		foreach ($this->list_bank() as $coa => $r) {
			if (($r->hold ?? '0') == '1') continue;
			$out[$coa] = $r->nama;
		}
		return $out;
	}

	// ------------------------------------------------------------------
	//  out_pesawat.coa_pendapatan
	// ------------------------------------------------------------------

	/**
	 * COA pendapatan untuk maskapai.
	 * $tabel   : out_pesawat (outgoing) atau in_pesawat (incoming)
	 * $default : kunci all_setting untuk COA bila maskapai belum punya COA
	 */
	public function coa_pendapatan($pesawat, $tabel = 'out_pesawat', $default = 'coa_pendapatan_default')
	{
		if (!isset($this->coa_pesawat[$tabel])) {
			$this->coa_pesawat[$tabel] = [];
			$rows = $this->ambil($tabel);
			if ($rows && !array_key_exists('coa_pendapatan', $rows[0])) {
				log_message('error', 'M_warehouse_ref: kolom ' . $tabel . '.coa_pendapatan belum ada, semua maskapai memakai ' . $default . '. Jalankan SQL upgrade.');
			}
			foreach ($rows as $r) {
				$this->coa_pesawat[$tabel][strtoupper(trim((string) ($r['nama'] ?? '')))] = $r['coa_pendapatan'] ?? null;
			}
		}
		$coa = $this->coa_pesawat[$tabel][strtoupper(trim((string) $pesawat))] ?? null;
		$fallback = $tabel === 'in_pesawat' ? '41003' : '41002';
		return !empty($coa) ? $coa : $this->setting($default, $fallback);
	}

	/**
	 * Pembagi volume (volumetric divisor) per maskapai: NAMA (huruf besar) => pembagi.
	 * Maskapai tanpa pembagi tidak dimasukkan; pemakai memakai pembagi_default().
	 */
	public function pembagi_list($tabel = 'out_pesawat')
	{
		$out = [];
		foreach ($this->ambil($tabel) as $r) {
			$p = (float) ($r['pembagi'] ?? 0);
			if ($p > 0) {
				$out[strtoupper(trim((string) ($r['nama'] ?? '')))] = $p;
			}
		}
		return $out;
	}

	/** Pembagi volume bawaan bila maskapai belum diatur (setting pembagi_default). */
	public function pembagi_default()
	{
		$p = $this->rate('pembagi_default', 6000);
		return $p > 0 ? $p : 6000;
	}

	// ------------------------------------------------------------------
	//  Tampilan ramah pengguna untuk halaman Setting
	// ------------------------------------------------------------------

	/** Urutan bagian di halaman Setting. Bagian terakhir disembunyikan secara bawaan. */
	public function setting_bagian()
	{
		return ['Tarif & Pajak', 'Deposit Agen', 'Akun Jurnal (COA)', 'Nomor Dokumen', 'Lanjutan (teknis)'];
	}

	/**
	 * Keterangan setiap kunci: [bagian, nama, tipe, penjelasan].
	 * tipe: persen | rupiah | angka | coa | coa_list | teks | tanggal
	 */
	public function setting_meta($kunci)
	{
		$m = [
			// Tarif & Pajak
			'ppn_rate'             => ['Tarif & Pajak', 'PPN', 'persen', 'Persentase PPN pada invoice. Contoh: isi 11 untuk 11%.'],
			'pph23_rate'           => ['Tarif & Pajak', 'Potongan PPh 23', 'persen', 'Persentase PPh 23 yang dipotong bila invoice memakai PPh 23. Contoh: 2.'],
			'min_sewa_gudang'      => ['Tarif & Pajak', 'Minimal sewa gudang', 'rupiah', 'Jika hasil hitung sewa gudang lebih kecil, yang ditagih adalah angka ini.'],
			'biaya_adm_1'          => ['Tarif & Pajak', 'Biaya administrasi (pilihan 1)', 'rupiah', 'Biaya administrasi pilihan pertama di form invoice.'],
			'biaya_adm_0'          => ['Tarif & Pajak', 'Biaya administrasi (pilihan 2)', 'rupiah', 'Biaya administrasi pilihan kedua di form invoice.'],
			'cdc_rate'             => ['Tarif & Pajak', 'Cargo Development Charge (CDC)', 'persen', 'Persentase dari sewa gudang bila CDC dipilih. Isi 0 bila tidak dikenakan.'],
			'in_surcharge_dg_rate' => ['Tarif & Pajak', 'Surcharge barang berbahaya (DG) per kg', 'rupiah', 'Incoming: tambahan biaya per kg bila barang Dangerous Goods.'],
			'pembagi_default'      => ['Tarif & Pajak', 'Pembagi volume standar', 'angka', 'Volume = panjang x lebar x tinggi (cm) / pembagi. Dipakai untuk maskapai yang belum punya pembagi sendiri. Contoh: 6000.'],
			// Deposit
			'limit_saldo_deposit'  => ['Deposit Agen', 'Batas peringatan saldo deposit', 'rupiah', 'Bila sisa saldo deposit agen di bawah angka ini, kasir mendapat peringatan.'],
			// COA
			'coa_piutang'               => ['Akun Jurnal (COA)', 'Akun piutang invoice', 'coa', 'Dicatat saat invoice dicetak (debit) dan saat dibayar (kredit).'],
			'coa_pph23'                 => ['Akun Jurnal (COA)', 'Akun PPh 23', 'coa', 'Akun untuk mencatat potongan PPh 23.'],
			'coa_pendapatan_default'    => ['Akun Jurnal (COA)', 'Akun pendapatan Outgoing (maskapai lain)', 'coa', 'Dipakai bila maskapai belum punya akun pendapatan sendiri di menu Pesawat.'],
			'in_coa_pendapatan_default' => ['Akun Jurnal (COA)', 'Akun pendapatan Incoming (maskapai lain)', 'coa', 'Dipakai bila maskapai belum punya akun pendapatan sendiri di menu Pesawat Incoming.'],
			'coa_pendapatan_khusus'     => ['Akun Jurnal (COA)', 'Akun pendapatan invoice khusus', 'coa', 'Akun pendapatan untuk invoice khusus.'],
			'coa_deposit_khusus'        => ['Akun Jurnal (COA)', 'Akun deposit invoice khusus', 'coa', 'Akun yang dipotong saat invoice khusus dibayar.'],
			// Nomor dokumen
			'origin'          => ['Nomor Dokumen', 'Kode bandara / warehouse', 'teks', 'Contoh: HLP. Tampil di cetakan dan nomor invoice. Kosongkan untuk memakai pengaturan lama sistem.'],
			'prefix'          => ['Nomor Dokumen', 'Awalan nomor BTB', 'teks', 'Contoh: HLPO, sehingga nomor BTB menjadi HLPO-000123. Kosongkan untuk memakai pengaturan lama sistem.'],
			'out_prefix_sj'   => ['Nomor Dokumen', 'Awalan nomor invoice Outgoing', 'teks', 'Contoh: HLP.OUT-JASTER-, sehingga nomor invoice menjadi HLP.OUT-JASTER-000123. Kosong = kode bandara + .OUT-JASTER-'],
			'in_kode_invoice' => ['Nomor Dokumen', 'Sisipan nomor invoice Incoming', 'teks', 'Nomor invoice incoming = kode bandara + sisipan ini + bulan tahun + nomor urut. Contoh: .IN.'],
			'in_prefix_sj'    => ['Nomor Dokumen', 'Awalan nomor surat jalan Incoming', 'teks', 'Contoh: HPLI-, sehingga nomor surat jalan menjadi HPLI-000123.'],
			'prefix_do'       => ['Nomor Dokumen', 'Awalan nomor DO', 'teks', 'Contoh: BDT., sehingga nomor DO menjadi BDT.000123/11/2026.'],
			'prefix_csd'      => ['Nomor Dokumen', 'Awalan nomor CSD', 'teks', 'Contoh: BDT.CSD.'],
			'kop_gdg_khusus'  => ['Nomor Dokumen', 'Kode gudang di nomor invoice khusus', 'teks', 'Contoh: LJAWH, sehingga nomor menjadi 000123/LJAWH/XI/26.'],
			// Lanjutan
			'prefix_csd_lama'      => ['Lanjutan (teknis)', 'Awalan nomor CSD (menu lama)', 'teks', 'Dipakai menu Daftar CSD (Kasir).'],
			'branch_code_csd'      => ['Lanjutan (teknis)', 'Kode cabang CSD', 'teks', 'Kode cabang yang disimpan pada data CSD.'],
			'agent_deposit_khusus' => ['Lanjutan (teknis)', 'Nomor agen deposit invoice khusus', 'angka', 'Nomor (uid) agen deposit yang dipotong saat invoice khusus dibayar.'],
			'tgl_template_khusus'  => ['Lanjutan (teknis)', 'Mulai tanggal cetakan invoice khusus baru', 'tanggal', 'Invoice khusus sejak tanggal ini memakai bentuk cetakan baru.'],
		];
		$lists = [
			'coa_list_debit_depo' => 'Outgoing: pilihan akun debit (deposit)', 'coa_list_kredit_depo' => 'Outgoing: pilihan akun kredit (deposit)',
			'coa_list_debit_transfer' => 'Outgoing: pilihan akun debit (transfer)', 'coa_list_kredit_transfer' => 'Outgoing: pilihan akun kredit (transfer)',
			'coa_list_debit_depo_khusus' => 'Invoice khusus: pilihan akun debit (deposit)', 'coa_list_kredit_depo_khusus' => 'Invoice khusus: pilihan akun kredit (deposit)',
			'coa_list_debit_transfer_khusus' => 'Invoice khusus: pilihan akun debit (transfer)', 'coa_list_kredit_transfer_khusus' => 'Invoice khusus: pilihan akun kredit (transfer)',
			'in_coa_list_debit_depo' => 'Incoming: pilihan akun debit (deposit)', 'in_coa_list_kredit_depo' => 'Incoming: pilihan akun kredit (deposit)',
			'in_coa_list_debit_transfer' => 'Incoming: pilihan akun debit (transfer)', 'in_coa_list_kredit_transfer' => 'Incoming: pilihan akun kredit (transfer)',
		];
		foreach ($lists as $k => $nama) {
			$m[$k] = ['Lanjutan (teknis)', $nama, 'coa_list', 'Daftar akun yang muncul di form jurnal invoice. Boleh lebih dari satu; nomor awalan (misalnya 210) mencakup semua akun yang diawali nomor itu.'];
		}

		if (isset($m[$kunci])) {
			list($bagian, $nama, $tipe, $help) = $m[$kunci];
		} else {
			list($bagian, $nama, $tipe, $help) = ['Lanjutan (teknis)', $kunci, 'teks', ''];
		}
		return ['bagian' => $bagian, 'nama' => $nama, 'tipe' => $tipe, 'help' => $help];
	}

	/** Nilai untuk ditampilkan di tabel: 0.11 -> 11%, 25000 -> Rp 25.000, dst. */
	public function setting_tampil($kunci, $nilai, array $coa_nama = [])
	{
		$nilai = (string) $nilai;
		if ($nilai === '') {
			return '(kosong)';
		}
		switch ($this->setting_meta($kunci)['tipe']) {
			case 'persen':
				return rtrim(rtrim(number_format((float) $nilai * 100, 4, ',', '.'), '0'), ',') . '%';
			case 'rupiah':
				return 'Rp ' . number_format((float) $nilai, 0, ',', '.');
			case 'angka':
				return number_format((float) $nilai, 0, ',', '.');
			case 'coa':
				return isset($coa_nama[$nilai]) ? $coa_nama[$nilai] : $nilai;
			case 'coa_list':
				$out = [];
				foreach (array_filter(array_map('trim', explode(',', $nilai)), 'strlen') as $c) {
					$out[] = isset($coa_nama[$c]) ? $coa_nama[$c] : $c . ' (semua akun berawalan ' . $c . ')';
				}
				return implode('; ', $out);
			case 'tanggal':
				return strlen($nilai) >= 8 ? substr($nilai, 6, 2) . '-' . substr($nilai, 4, 2) . '-' . substr($nilai, 0, 4) : $nilai;
		}
		return $nilai;
	}

	/** Seperti setting_tampil(), tetapi nilai kosong ditambah nilai yang sedang dipakai sistem. */
	public function setting_tampil_efektif($kunci, $nilai, array $coa_nama = [])
	{
		if (trim((string) $nilai) !== '') {
			return $this->setting_tampil($kunci, $nilai, $coa_nama);
		}
		$pakai = null;
		if ($kunci === 'origin') {
			$pakai = $this->origin();
		} elseif ($kunci === 'prefix') {
			$pakai = $this->prefix();
		} elseif ($kunci === 'out_prefix_sj') {
			$pakai = $this->origin() . '.OUT-JASTER-';
		}
		return $pakai !== null && $pakai !== '' ? '(kosong, sekarang memakai: ' . $pakai . ')' : '(kosong)';
	}

	/** Nilai untuk diisi ke kolom isian: 0.11 -> 11, 20261001000000 -> 2026-10-01. */
	public function setting_form($kunci, $nilai)
	{
		$nilai = (string) $nilai;
		switch ($this->setting_meta($kunci)['tipe']) {
			case 'persen':
				return $nilai === '' ? '' : rtrim(rtrim(number_format((float) $nilai * 100, 4, '.', ''), '0'), '.');
			case 'rupiah':
			case 'angka':
				return $nilai === '' ? '' : (string) (0 + $nilai);
			case 'tanggal':
				return strlen($nilai) >= 8 ? substr($nilai, 0, 4) . '-' . substr($nilai, 4, 2) . '-' . substr($nilai, 6, 2) : '';
		}
		return $nilai;
	}

	/**
	 * Ubah isian form menjadi nilai yang disimpan.
	 * Hasil: ['ok' => bool, 'nilai' => string, 'pesan' => string]
	 */
	public function setting_simpan($kunci, $input)
	{
		$tipe  = $this->setting_meta($kunci)['tipe'];
		$gagal = function ($pesan) {
			return ['ok' => false, 'nilai' => '', 'pesan' => $pesan];
		};

		if ($tipe === 'coa_list') {
			$list = is_array($input) ? $input : explode(',', (string) $input);
			$list = array_values(array_unique(array_filter(array_map('trim', $list), 'strlen')));
			if (!$list) return $gagal('Pilih minimal satu akun.');
			foreach ($list as $c) {
				if (!ctype_digit($c)) return $gagal('Nomor akun hanya boleh angka: ' . $c);
			}
			return ['ok' => true, 'nilai' => implode(',', $list), 'pesan' => ''];
		}

		$v = trim((string) $input);
		switch ($tipe) {
			case 'persen':
				$v = str_replace(['%', ' '], '', str_replace(',', '.', $v));
				if ($v === '' || !is_numeric($v) || $v < 0 || $v > 100) return $gagal('Isi persen antara 0 sampai 100, contoh 11.');
				return ['ok' => true, 'nilai' => rtrim(rtrim(number_format($v / 100, 6, '.', ''), '0'), '.') ?: '0', 'pesan' => ''];
			case 'rupiah':
			case 'angka':
				$v = preg_replace('/[^0-9]/', '', $v);
				if ($v === '') return $gagal('Isi dengan angka.');
				if ($kunci === 'pembagi_default' && (int) $v <= 0) return $gagal('Pembagi harus lebih dari 0.');
				return ['ok' => true, 'nilai' => (string) (int) $v, 'pesan' => ''];
			case 'coa':
				if ($v === '' || !ctype_digit($v)) return $gagal('Pilih akun dari daftar.');
				return ['ok' => true, 'nilai' => $v, 'pesan' => ''];
			case 'tanggal':
				$d = DateTime::createFromFormat('Y-m-d', $v);
				if (!$d || $d->format('Y-m-d') !== $v) return $gagal('Tanggal tidak valid.');
				return ['ok' => true, 'nilai' => $d->format('Ymd') . '000000', 'pesan' => ''];
		}
		return ['ok' => true, 'nilai' => $v, 'pesan' => ''];
	}

	/** Daftar akun untuk pilihan: no_sbb => "no_sbb - nama perkiraan" (cabang yang sedang login). */
	public function coa_options()
	{
		$debug = $this->cb->db_debug;
		$this->cb->db_debug = FALSE;
		$cabang = $this->session->userdata('kode_cabang');
		if ($cabang !== null && $cabang !== '') {
			$this->cb->where('id_cabang', $cabang);
		}
		$q = $this->cb->select('no_sbb, nama_perkiraan')->order_by('no_sbb', 'ASC')->get('v_coa_all');
		$this->cb->db_debug = $debug;

		$out = [];
		foreach ($q ? $q->result_array() : [] as $r) {
			$out[(string) $r['no_sbb']] = $r['no_sbb'] . ' - ' . trim((string) $r['nama_perkiraan']);
		}
		return $out;
	}

	/**
	 * Baris halaman Setting, sudah berisi nama, bagian, nilai tampil & nilai form.
	 * $hanya_awalan : misalnya 'in_' untuk halaman Setting Incoming.
	 */
	public function setting_rows($hanya_awalan = null, array $coa_nama = [])
	{
		$urut = array_flip($this->setting_bagian());
		$rows = [];
		foreach ($this->ambil('all_setting') as $r) {
			$kunci = (string) $r['kunci'];
			if ($hanya_awalan !== null && strpos($kunci, $hanya_awalan) !== 0) continue;
			$m = $this->setting_meta($kunci);
			$rows[] = [
				'uid'        => $r['uid'] ?? '',
				'kunci'      => $kunci,
				'bagian'     => $m['bagian'],
				'nama'       => $m['nama'],
				'tipe'       => $m['tipe'],
				'help'       => $m['help'] !== '' ? $m['help'] : (string) ($r['keterangan'] ?? ''),
				'tampil'     => $this->setting_tampil_efektif($kunci, $r['nilai'], $coa_nama),
				'nilai_form' => $this->setting_form($kunci, $r['nilai']),
			];
		}
		usort($rows, function ($a, $b) use ($urut) {
			$c = ($urut[$a['bagian']] ?? 99) <=> ($urut[$b['bagian']] ?? 99);
			return $c !== 0 ? $c : strcmp($a['nama'], $b['nama']);
		});
		return $rows;
	}

	/**
	 * Simpan satu setting dari form halaman Setting (hanya mengubah, tidak menambah).
	 * Hasil: ['ok' => bool, 'pesan' => string]
	 */
	public function simpan_setting($uid, $kunci, $input, $hanya_awalan = null)
	{
		// Cari baris: utamakan uid, cadangan kunci
		$row = null;
		foreach ($this->ambil('all_setting') as $r) {
			if (((int) $uid > 0 && (int) ($r['uid'] ?? 0) === (int) $uid) || ((int) $uid <= 0 && $r['kunci'] === $kunci)) {
				$row = $r;
				break;
			}
		}
		if (!$row) {
			return ['ok' => false, 'pesan' => 'Pengaturan tidak ditemukan.'];
		}
		$kunci = (string) $row['kunci'];
		if ($hanya_awalan !== null && strpos($kunci, $hanya_awalan) !== 0) {
			return ['ok' => false, 'pesan' => 'Pengaturan ini tidak bisa diubah dari halaman ini.'];
		}

		$m   = $this->setting_meta($kunci);
		$has = $this->setting_simpan($kunci, $input);
		if (!$has['ok']) {
			return ['ok' => false, 'pesan' => $m['nama'] . ': ' . $has['pesan']];
		}
		if ($m['tipe'] === 'coa' && !isset($this->coa_options()[$has['nilai']])) {
			return ['ok' => false, 'pesan' => 'Akun ' . $has['nilai'] . ' tidak ditemukan di daftar akun.'];
		}

		$where = isset($row['uid']) ? ['uid' => $row['uid']] : ['kunci' => $kunci];
		$this->cb->where($where)->update('all_setting', ['nilai' => $has['nilai']]);
		$this->setting = null; // muat ulang cache

		return ['ok' => true, 'pesan' => $m['nama'] . ' berhasil disimpan: ' . $this->setting_tampil($kunci, $has['nilai'], $this->coa_options())];
	}

	/** Nama yang mudah dibaca untuk grup di menu Referensi Kode. */
	public function ref_grup_nama()
	{
		return [
			'catg_smu'        => 'Kategori SMU',
			'jns_barang'      => 'Jenis barang',
			'jenis_billing'   => 'Jenis tagihan (kategori harga)',
			'status_keamanan' => 'Status keamanan (CSD)',
			'metode_periksa'  => 'Metode pemeriksaan (CSD)',
			'metode_opsional' => 'Pemeriksaan tambahan (CSD)',
			'alasan'          => 'Hasil pemeriksaan (CSD)',
			'warehouse'       => 'Gudang tujuan DO',
		];
	}

	// ------------------------------------------------------------------
	//  Helper non-database
	// ------------------------------------------------------------------

	/**
	 * Render <option> dari array kode => label.
	 * $selected : kode yang terpilih (opsional).
	 */
	public function options(array $list, $selected = null)
	{
		$html = '';
		foreach ($list as $kode => $label) {
			$sel   = ($selected !== null && (string) $selected === (string) $kode) ? ' selected' : '';
			$html .= '<option value="' . html_escape($kode) . '"' . $sel . '>' . html_escape($label) . "</option>\n";
		}
		return $html;
	}

	/** 1..12 -> I..XII (aturan baku, tidak perlu disimpan di database). */
	public function romawi($bulan)
	{
		$r = ['', 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];
		return $r[(int) $bulan] ?? '';
	}
}
