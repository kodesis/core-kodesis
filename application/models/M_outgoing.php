<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_outgoing extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private $table = 'out_csd';

	private $orderable = [
		0  => 'o.csd_num',
		1  => 'o.no_csd',
		2  => 'o.smu',
		3  => 'o.no_pesawat',
		4  => 'o.tanggal_terbang',
		5  => 'o.komoditi',
		6  => 'o.koli_smu',
		7  => 'o.berat_smu',
		8  => 'o.tgl_csd',
		9  => 'o.jaster',
		// 8  => 'o.metode_pemeriksaan',
		// 9 => 'o.debit',
		// 10 => 'o.kredit',
		// 11 => 'o.is_delivery',  // tambah
		// 12 => 'o.status',       // geser
	];

	private function _base_query()
	{
		$this->cb->select("
        o.*
    ", FALSE)
			->from('out_csd o');
		// ->where('(is_do != 1 OR is_do IS NULL)');

		// Search
		if (!empty($_POST['search']['value'])) {
			$search = $_POST['search']['value'];
			$this->cb->group_start()
				->like('o.csd_num', $search)
				->or_like('o.no_csd', $search)
				->or_like('o.smu', $search)
				->or_like('o.no_pesawat', $search)
				->or_like('o.tanggal_terbang', $search)
				->or_like('o.komoditi', $search)
				->or_like('o.tgl_csd', $search)
				// ->or_like('o.koli_smu', $search)
				// ->or_like('o.gross_smu', $search)
				->group_end();
		}

		// Order
		$orderCol = $_POST['order'][0]['column'] ?? null;
		// $orderCol = null;
		if ($orderCol !== null && !empty($this->orderable[$orderCol])) {
			$col = $this->orderable[$orderCol];
			$dir = ($_POST['order'][0]['dir'] ?? 'desc') === 'asc' ? 'ASC' : 'DESC';
			$this->cb->order_by($col, $dir);
		} else {
			// $this->cb->order_by('o.tgl_masuk', 'DESC');
			$this->cb->order_by('o.csd_num', 'DESC');
		}
	}

	public function get_datatables()
	{
		$this->_base_query();

		if ($_POST['length'] != -1) {
			$this->cb->limit($_POST['length'], $_POST['start']);
		}

		return $this->cb->get()->result();
	}

	public function count_filtered()
	{
		$this->_base_query();
		return $this->cb->get()->num_rows();
	}

	public function count_all()
	{
		// return $this->cb->count_all($this->table);
		return $this->cb->count_all_results($this->table);
	}

	public function insert_kemasan_smu($data)
	{
		return $this->cb->insert('out_list', $data);
	}

	public function update_kemasan_smu($data, $uid)
	{
		return $this->cb->where('uid', $uid)->update('out_list', $data);
	}

	public function get_kemasan_smu_by_uid($uid)
	{
		return $this->cb->where('uid', $uid)->get('out_list')->row();
	}

	public function insert_csd($data)
	{
		return $this->cb->insert('out_csd', $data);
	}

	public function update_csd($data, $uid)
	{
		return $this->cb->where('uid', $uid)->update('out_csd', $data);
	}

	private $table_csd_actual = 'ra_csd';

	private $orderable_csd_actual = [
		0  => 'c.csd_num',
		1  => 'c.no_csd',
		2  => 'o.smu',
		3  => 'o.komoditi',
		4  => 'c.status_keamanan',
		5  => 'c.methode_pemeriksaan',
		6  => 'c.status',
		7  => 'c.tgl_csd',
		8  => 'nama_avsec',
		9  => 'o.jaster',
	];

	// =========================================================================
	// BASE QUERY BUILDER (Menggabungkan ra_csd dan out_list)
	// =========================================================================
	private function _base_query_csd_actual()
	{
		$this->cb->select("
		c.uid as csd_uid,
            c.*, 
			o.uid as smu_uid_val,
            o.smu, 
            o.komoditi,
            o.jaster,
			a.nama as nama_avsec
        ", FALSE)
			->from('out_list o')
			->join('ra_csd c', 'c.smu_uid = o.uid', 'left')
			->join('out_avsec a', 'a.uid = c.avsec_uid', 'left')
			// ->join($this->db->database . '.users u',      'u.nip = c.user',    'left')
			->where('o.btb_p', '1');

		// Logic Filter Pencarian Dinamis lintas kedua tabel
		if (!empty($_POST['search']['value'])) {
			$search = $_POST['search']['value'];
			$this->cb->group_start()
				->like('c.csd_num', $search)
				->or_like('c.no_csd', $search)
				->or_like('o.smu', $search)
				->or_like('o.no_pesawat', $search)
				->or_like('o.tanggal_terbang', $search)
				->or_like('o.komoditi', $search)
				->or_like('c.tgl_csd', $search)
				->group_end();
		}

		// Logic Sorting Kolom Datatable
		$orderCol = $_POST['order'][0]['column'] ?? null;
		if ($orderCol !== null && !empty($this->orderable_csd_actual[$orderCol])) {
			$col = $this->orderable_csd_actual[$orderCol];
			$dir = ($_POST['order'][0]['dir'] ?? 'desc') === 'asc' ? 'ASC' : 'DESC';
			$this->cb->order_by($col, $dir);
		} else {
			// Urutan default sesuai request:
			// 1. Yang belum punya CSD (c.uid IS NULL) diletakkan paling atas
			$this->cb->order_by("CASE WHEN c.uid IS NULL THEN 0 ELSE 1 END", "ASC", FALSE);
			// 2. Yang belum ada CSD disortir berdasarkan ID out_list terbaru (o.uid DESC)
			$this->cb->order_by("CASE WHEN c.uid IS NULL THEN o.uid ELSE 0 END", "DESC", FALSE);
			// 3. Yang sudah ada CSD disortir berdasarkan nomor CSD (c.no_csd DESC)
			$this->cb->order_by("c.no_csd", "DESC");
		}
	}

	// =========================================================================
	// DATATABLE GET DATA METHOD
	// =========================================================================
	public function get_datatables_csd_actual()
	{
		$this->_base_query_csd_actual();

		if (isset($_POST['length']) && $_POST['length'] != -1) {
			$this->cb->limit(intval($_POST['length']), intval($_POST['start']));
		}

		return $this->cb->get()->result();
	}

	// =========================================================================
	// DATATABLE COUNT METHODS
	// =========================================================================
	public function count_filtered_csd_actual()
	{
		$this->_base_query_csd_actual();
		return $this->cb->get()->num_rows();
	}

	public function count_all_csd_actual()
	{
		$this->cb->from('ra_csd c')
			->join('out_list o', 'c.smu_uid = o.uid', 'inner');
		return $this->cb->count_all_results();
	}

	// ===============================
	// DAFTAR DO
	// ===============================

	private $table_reject = 'out_reject_item_list';

	private $orderable_reject = [
		0  => 'o.uid',
		1  => 'o.jam',
		2  => 'o.tanggal',
		3  => 'o.no_flight',
		4  => 'nama_pengirim',
		5  => 'nama_agen',
		6  => 'nama_avsec',
		7  => 'nama_tujuan',
		8  => 'o.smu',
		9  => 'o.isi_pti',
		// 8  => 'o.metode_pemeriksaan',
		// 9 => 'o.debit',
		// 10 => 'o.kredit',
		// 11 => 'o.is_delivery',  // tambah
		// 12 => 'o.status',       // geser
	];

	private function _base_query_reject()
	{
		$this->cb->select("
        o.*, p.nama as nama_pengirim, a.nama as nama_agen, t.nama as nama_tujuan, av.nama as nama_avsec
    ", FALSE)
			->from('out_reject_item_list o')
			->join('out_pengirim p',  'p.uid = o.uid_pengirim',  'left')
			->join('out_agent a',  'a.uid = o.uid_agen',  'left')
			->join('out_tujuan t',  't.kode_kota = o.tujuan',  'left')
			->join('out_avsec av',  'av.uid = o.avsec_uid',  'left');

		// ->where('(is_do != 1 OR is_do IS NULL)');

		// Search
		if (!empty($_POST['search']['value'])) {
			$search = $_POST['search']['value'];
			$this->cb->group_start()
				->like('o.jam', $search)
				->or_like('o.tanggal', $search)

				->or_like('o.no_flight', $search)
				->or_like('nama_pengirim', $search)
				->or_like('nama_agen', $search)
				->or_like('o.avsec_nama', $search)
				->or_like('nama_tujuan', $search)
				->or_like('o.smu', $search)
				->or_like('o.isi_pti', $search)
				// ->or_like('o.koli_smu', $search)
				// ->or_like('o.gross_smu', $search)
				->group_end();
		}

		// Order
		$orderCol = $_POST['order'][0]['column'] ?? null;
		// $orderCol = null;
		if ($orderCol !== null && !empty($this->orderable_reject[$orderCol])) {
			$col = $this->orderable_reject[$orderCol];
			$dir = ($_POST['order'][0]['dir'] ?? 'desc') === 'asc' ? 'ASC' : 'DESC';
			$this->cb->order_by($col, $dir);
		} else {
			// $this->cb->order_by('o.tgl_masuk', 'DESC');
			$this->cb->order_by('o.csd_num', 'DESC');
		}
	}

	public function get_datatables_reject()
	{
		$this->_base_query_reject();

		if ($_POST['length'] != -1) {
			$this->cb->limit($_POST['length'], $_POST['start']);
		}

		return $this->cb->get()->result();
	}

	public function count_filtered_reject()
	{
		$this->_base_query_reject();
		return $this->cb->get()->num_rows();
	}

	public function count_all_reject()
	{
		// return $this->cb->count_all($this->table);
		return $this->cb->count_all_results($this->table_reject);
	}

	public function insert_reject($data)
	{
		return $this->cb->insert('out_reject_item_list', $data);
	}

	public function update_reject($data, $uid)
	{
		return $this->cb->where('uid', $uid)->update('out_reject_item_list', $data);
	}

	// ===============================
	// DAFTAR DO
	// ===============================
	private $table_do = 'out_ch';

	private $orderable_do = [
		0  => 'o.no_do ',
		1  => 'o.no_ch',
		2  => 'o.wh_name',
		3  => 'o.total_koli',
		4  => 'o.total_berat',       // driver
		5  => 't.no_segel',  // truck
		6  => 'o.no_sticker',
		7  => 'o.truck_uid',
		8  => 'o.driver_uid',
		9  => 'o.tgl_ch',
		10 => 'u.nama',       // user_do
	];

	private function _base_query_do()
	{
		$this->cb->select("
        o.*,
        d.nama as nama_driver,
        t.no_polisi,
        u.nama as nama_user_do
    ", FALSE)
			->from('out_ch o')
			->join('out_driver d', 'd.uid = o.driver_uid', 'left')
			->join('out_truck t',  't.uid = o.truck_uid',  'left')
			->join($this->db->database . '.users u',      'u.nip = o.user',    'left');
		// ->where('o.is_do', '1');

		// Search
		if (!empty($_POST['search']['value'])) {
			$search = $_POST['search']['value'];
			$this->cb->group_start()
				->like('o.no_do', $search)
				->or_like('o.no_ch', $search)
				->or_like('o.wh_name', $search)
				->or_like('o.total_koli', $search)
				->or_like('o.total_berat', $search)
				->or_like('t.no_segel', $search)
				->or_like('o.no_sticker', $search)
				->or_like('o.tgl_ch', $search)
				->or_like('u.nama', $search)
				->group_end();
		}

		// Order
		$orderCol = $_POST['order'][0]['column'] ?? null;
		// $orderCol = null;
		if ($orderCol !== null && !empty($this->orderable_do[$orderCol])) {
			$col = $this->orderable_do[$orderCol];
			$dir = ($_POST['order'][0]['dir'] ?? 'desc') === 'asc' ? 'ASC' : 'DESC';
			$this->cb->order_by($col, $dir);
		} else {
			// $this->cb->order_by('o.tgl_masuk', 'DESC');
			$this->cb->order_by('o.csd_num', 'DESC');
		}
	}

	public function get_datatables_do()
	{
		$this->_base_query_do();

		if ($_POST['length'] != -1) {
			$this->cb->limit($_POST['length'], $_POST['start']);
		}

		return $this->cb->get()->result();
	}

	public function count_filtered_do()
	{
		$this->_base_query_do();
		return $this->cb->get()->num_rows();
	}

	public function count_all_do()
	{
		return $this->cb->count_all_results($this->table_do);
	}

	private $table_kemasan_smu = 'out_list';

	private $orderable_kemasan_smu = [
		0  => 'o.uid',
		1  => 'o.catg_smu',
		2  => 'o.smu',
		3  => 'o.tujuan',
		4  => 'o.jumlah',
		5  => 'o.gross',
		6  => 'o.volume',
		7  => 'o.nama_pengirim',
		8  => 'o.post_date',
		9  => 'o.jaster',
		10 => 'o.btb_p',
	];

	private function _base_query_kemasan_smu()
	{
		$this->cb->select("
            o.*
        ", FALSE)
			->from('out_list o')
			->join($this->db->database . '.users u', 'u.nip = o.user_in', 'left');

		// Logic Search
		if (!empty($_POST['search']['value'])) {
			$search = $_POST['search']['value'];
			$this->cb->group_start()
				->like('o.smu', $search)
				->or_like('o.tujuan', $search)
				->or_like('o.jumlah', $search)
				->or_like('o.gross', $search)
				->or_like('o.volume', $search)
				->or_like('o.nama_pengirim', $search)
				->or_like('o.post_date', $search)
				->group_end();
		}

		// =========================================================================
		// LOGIKA SORTING PRIORITAS KUSTOM (Sesuai Permintaan)
		// =========================================================================
		$custom_priority_order = "CASE 
            -- Prioritas 5 (Paling bawah): Jika data merupakan SMU lama
            WHEN (o.smu_lama IS NOT NULL AND o.smu_lama != '0' AND o.smu_lama != '') THEN 5

            -- Prioritas 1 (Paling atas): Volume ada isinya (>0) dan belum di-BTB (btb_p != '1')
            WHEN (o.volume > 0 AND o.volume IS NOT NULL AND o.volume != '') AND (o.btb_p != '1' OR o.btb_p IS NULL) THEN 1

            -- Prioritas 2 (Kedua): Volume kosong, bernilai 0, atau NULL
            WHEN (o.volume = '0' OR o.volume = '' OR o.volume IS NULL) THEN 2
			
            -- Prioritas 3 (Ketiga): Volume ada isinya (>0) dan sudah di-BTB (btb_p = '1')
            WHEN (o.volume > 0 AND o.volume IS NOT NULL AND o.volume != '') AND o.btb_p = '1' THEN 3

            -- Prioritas 4 (Ketiga): Volume ada isinya (>0) dan sudah di-Invoice (out_p = '1')
            WHEN (o.volume > 0 AND o.volume IS NOT NULL AND o.volume != '') AND o.out_p = '1' THEN 4

            -- Cadangan fallback default
            ELSE 5
        END";

		// Terapkan sorting kustom terlebih dahulu (escape di-set ke FALSE agar query raw SQL CASE WHEN tidak rusak)


		// =========================================================================
		// URUTAN KEDUA (Sub-sorting berdasarkan pilihan kolom DataTables ATAU default post_date/uid)
		// =========================================================================
		$orderCol = $_POST['order'][0]['column'] ?? null;
		if ($orderCol !== null && !empty($this->orderable_kemasan_smu[$orderCol])) {
			$col = $this->orderable_kemasan_smu[$orderCol];
			$dir = ($_POST['order'][0]['dir'] ?? 'desc') === 'asc' ? 'ASC' : 'DESC';
			$this->cb->order_by($col, $dir);
		} else {
			// Default sub-sorting menggunakan post_date terbaru dan uid terbaru
			// $this->cb->order_by('o.post_date', 'DESC');
			$this->cb->order_by($custom_priority_order, 'ASC', FALSE);
			$this->cb->order_by('o.uid', 'DESC');
			// $this->cb->order_by('o.uid', 'ASC');
		}
	}

	public function get_datatables_kemasan_smu()
	{
		$this->_base_query_kemasan_smu();

		if ($_POST['length'] != -1) {
			$this->cb->limit($_POST['length'], $_POST['start']);
		}

		return $this->cb->get()->result();
	}

	public function count_filtered_kemasan_smu()
	{
		$this->_base_query_kemasan_smu();
		return $this->cb->get()->num_rows();
	}

	public function count_all_kemasan_smu()
	{
		return $this->cb->count_all_results($this->table_kemasan_smu);
	}

	// ====================================
	// OUT LIST BTB
	// ====================================

	private $table_btb = 'out_list_btb';

	private $orderable_btb = [
		0  => 'b.no',
		1  => 'o.smu',
		2  => 'o.nama_agent',
		3  => 'b.total_pieces',
		4  => 'b.total_gross',
		5  => 'b.total_volume',
		6  => 'o.jaster',
		7 => 'b.tanggal',
		8 => 'o.out_date',
		9  => 'u.nama',
		10  => 'o.out_p',
	];

	private function _base_query_btb()
	{
		$this->cb->select("
        o.smu, o.nama_agent, o.out_p, o.out_date, o.pesawat, b.*, u.nama, o.jaster as is_jaster
    ", FALSE)
			->from('out_list_btb b')
			->join('out_list o',  'o.btb_uid = b.uid',  'left')
			->join($this->db->database . '.users u',      'u.nip = b.user',    'left');
		// ->where('btb_p !=', '1');
		// ->where('(is_do != 1 OR is_do IS NULL)');

		// Search
		if (!empty($_POST['search']['value'])) {
			$search = $_POST['search']['value'];
			$this->cb->group_start()
				->like('b.no', $search)
				->or_like('o.smu', $search)
				->or_like('o.nama_agent', $search)
				->or_like('b.total_pieces', $search)
				->or_like('b.total_gross', $search)
				->or_like('b.total_volume', $search)
				->or_like('b.tanggal', $search)
				// ->or_like('o.koli_smu', $search)
				// ->or_like('o.gross_smu', $search)
				->group_end();
		}

		// Order
		$orderCol = $_POST['order'][0]['column'] ?? null;
		// $orderCol = null;
		if ($orderCol !== null && !empty($this->orderable_btb[$orderCol])) {
			$col = $this->orderable_btb[$orderCol];
			$dir = ($_POST['order'][0]['dir'] ?? 'desc') === 'asc' ? 'ASC' : 'DESC';
			$this->cb->order_by($col, $dir);
		} else {
			// $this->cb->order_by('o.tgl_masuk', 'DESC');
			$this->cb->order_by('o.out_p', 'ASC');
			$this->cb->order_by('b.uid', 'DESC');
		}
	}

	public function get_datatables_btb()
	{
		$this->_base_query_btb();

		if ($_POST['length'] != -1) {
			$this->cb->limit($_POST['length'], $_POST['start']);
		}

		return $this->cb->get()->result();
	}

	public function count_filtered_btb()
	{
		$this->_base_query_btb();
		return $this->cb->get()->num_rows();
	}

	public function count_all_btb()
	{
		// return $this->cb->count_all($this->table);
		return $this->cb->count_all_results($this->table_btb);
	}

	// ====================================
	// DAFTAR INVOICE
	// ====================================

	private $table_invoice = 'out_billing';

	private $orderable_invoice = [
		0  => 'b.invoice_num',
		1  => 'b.no_invoice',
		2  => 'o.catg_smu',
		3  => 'o.smu',
		4  => 'o.nama_agent',
		4  => 'o.nama_pengirim',
		5  => 'b.total_pieces',
		6  => 'b.total_chargeable',
		7  => 'b.total',
		8  => 'b.tanggal_invoice',
		9  => 'b.jaster',
		10 => 'u.nama',
	];

	private function _base_query_invoice($agent = null, $pay = null, $jurnal = null)
	{

		$this->cb->select("
        o.smu, o.pesawat, o.catg_smu, o.jaster as is_jaster, o.nama_agent as list_agent, o.nama_pengirim as list_pengirim, b.*, u.nama as nama_kasir,
        IF(EXISTS(
            SELECT 1 FROM all_topup t
            WHERE t.billing_uid = b.uid
            AND t.asal_table = 'out_billing'
        ), 1, 0) AS has_topup,
        IF(
            b.pay_methode = 1
            AND NOT EXISTS(
                SELECT 1 FROM all_topup t
                WHERE t.billing_uid = b.uid
                AND t.asal_table = 'out_billing'
            ),
            1, 0
        ) AS is_warning
    ", FALSE)
			->from('out_billing b')
			->join('out_list o',  'o.bill_uid = b.uid',  'left')
			->join($this->db->database . '.users u',      'u.nip = b.user_kasir',    'left');
		if ($agent !== null && $agent !== '') {
			$this->cb->where('o.agent_uid', $agent);
		}
		if ($pay !== null && $pay !== '') {
			$this->cb->where('b.pay_status', $pay);
		}
		if ($jurnal !== null && $jurnal !== '') {
			$this->cb->where('b.jurnal_status', $jurnal);
		}
		// ->where('out_khusus !=', '1');
		// ->where('btb_p !=', '1');
		// ->where('(is_do != 1 OR is_do IS NULL)');

		// Search
		if (!empty($_POST['search']['value'])) {
			$search = $_POST['search']['value'];
			$this->cb->group_start()
				->like('b.invoice_num', $search)
				->or_like('b.no_invoice', $search)
				// ->or_like('b.catg_smu', $search)
				->or_like('o.smu', $search)
				->or_like('o.nama_agent', $search)
				->or_like('o.nama_pengirim', $search)
				->or_like('b.total_pieces', $search)
				->or_like('b.total_chargeable', $search)
				->or_like('b.total', $search)
				->or_like('b.tanggal_invoice', $search)
				->or_like('b.jaster', $search)
				->or_like('u.nama', $search)
				// ->or_like('o.koli_smu', $search)
				// ->or_like('o.gross_smu', $search)
				->group_end();
		}

		// Prioritas paling atas: warning (pay_method=1 tapi belum ada topup)

		// Order
		$orderCol = $_POST['order'][0]['column'] ?? null;
		// $orderCol = null;
		if ($orderCol !== null && !empty($this->orderable_invoice[$orderCol])) {
			$col = $this->orderable_invoice[$orderCol];
			$dir = ($_POST['order'][0]['dir'] ?? 'desc') === 'asc' ? 'ASC' : 'DESC';
			$this->cb->order_by($col, $dir);
		} else {
			// $this->cb->order_by('b.post_date', 'DESC');
			$this->cb->order_by('is_warning', 'DESC');
			$this->cb->order_by('b.pay_status', 'ASC');
			$this->cb->order_by('b.jurnal_status', 'ASC');
			// $this->cb->order_by('has_topup', 'DESC');
			$this->cb->order_by('b.uid', 'DESC');
		}
	}

	public function get_datatables_invoice($agent, $pay, $jurnal)
	{
		$this->_base_query_invoice($agent, $pay, $jurnal);

		if ($_POST['length'] != -1) {
			$this->cb->limit($_POST['length'], $_POST['start']);
		}

		return $this->cb->get()->result();
	}

	public function count_filtered_invoice($agent, $pay, $jurnal)
	{
		$this->_base_query_invoice($agent, $pay, $jurnal);
		return $this->cb->get()->num_rows();
	}

	public function count_all_invoice($agent, $pay, $jurnal)
	{
		// return $this->cb->count_all($this->table);
		return $this->cb->count_all_results($this->table_invoice);
	}

	// ====================================
	// DAFTAR INVOICE KHUSUS
	// ====================================

	private $table_invoice_khusus = 'out_billing_inv_khusus';

	private $orderable_invoice_khusus = [
		0  => 'b.invoice_num',
		1  => 'b.no_invoice',
		2  => 'o.catg_smu',
		3  => 'o.smu',
		4  => 'b.nama_agent',
		5  => 'b.total_pieces',
		6  => 'b.total_chargeable',
		7  => 'b.total',
		8  => 'b.tanggal_invoice',
		9  => 'b.jaster',
		10 => 'b.nama_kasir',
	];

	private function _base_query_invoice_khusus()
	{
		$this->cb->select("
        o.smu,o.pesawat,o.catg_smu,o.jaster as is_jaster, b.*, u.nama as nama_kasir,
        IF(EXISTS(
            SELECT 1 FROM all_topup t
            WHERE t.billing_uid = b.uid
            AND t.asal_table = 'out_billing_inv_khusus'
        ), 1, 0) AS has_topup,
        IF(
            b.pay_methode = 1
            AND NOT EXISTS(
                SELECT 1 FROM all_topup t
                WHERE t.billing_uid = b.uid
                AND t.asal_table = 'out_billing_inv_khusus'
            ),
            1, 0
        ) AS is_warning
    ", FALSE)
			->from('out_billing_inv_khusus b')
			->join('out_list o',  'o.bill_khusus_uid = b.uid',  'left')
			->join($this->db->database . '.users u',      'u.nip = b.user_kasir',    'left');
		// ->where('out_khusus', '1');
		// ->where('(is_do != 1 OR is_do IS NULL)');

		// Search
		if (!empty($_POST['search']['value'])) {
			$search = $_POST['search']['value'];
			$this->cb->group_start()
				->like('b.invoice_num', $search)
				->or_like('o.no_invoice', $search)
				->or_like('o.catg_smu', $search)
				->or_like('o.smu', $search)
				->or_like('o.nama_agent', $search)
				->or_like('b.total_pieces', $search)
				->or_like('b.total_chargeable', $search)
				->or_like('b.total', $search)
				->or_like('b.tanggal_invoice', $search)
				->or_like('b.jaster', $search)
				->or_like('b.nama_kasir', $search)
				// ->or_like('o.koli_smu', $search)
				// ->or_like('o.gross_smu', $search)
				->group_end();
		}

		// Prioritas paling atas: warning (pay_methode=1 tapi belum ada topup)
		$this->cb->order_by('is_warning', 'DESC');
		// $this->cb->order_by('has_topup', 'DESC');

		// Order
		$orderCol = $_POST['order'][0]['column'] ?? null;
		// $orderCol = null;
		if ($orderCol !== null && !empty($this->orderable_invoice_khusus[$orderCol])) {
			$col = $this->orderable_invoice_khusus[$orderCol];
			$dir = ($_POST['order'][0]['dir'] ?? 'desc') === 'asc' ? 'ASC' : 'DESC';
			$this->cb->order_by($col, $dir);
		} else {
			// $this->cb->order_by('o.tgl_masuk', 'DESC');
			$this->cb->order_by('is_warning', 'DESC');
			$this->cb->order_by('b.pay_status', 'ASC');
			$this->cb->order_by('b.jurnal_status', 'ASC');
			$this->cb->order_by('b.uid', 'DESC');
		}
	}

	public function get_datatables_invoice_khusus()
	{
		$this->_base_query_invoice_khusus();

		if ($_POST['length'] != -1) {
			$this->cb->limit($_POST['length'], $_POST['start']);
		}

		return $this->cb->get()->result();
	}

	public function count_filtered_invoice_khusus()
	{
		$this->_base_query_invoice_khusus();
		return $this->cb->get()->num_rows();
	}

	public function count_all_invoice_khusus()
	{
		// return $this->cb->count_all($this->table);
		return $this->cb->count_all_results($this->table_invoice_khusus);
	}

	// ====================================
	// DAFTAR DEPOSIT
	// ====================================

	private $table_deposit = 'out_agent_deposit';

	private $orderable_deposit = [
		0  => 'a.uid',
		1  => 'a.kode',
		2  => 'a.nama',
		3  => 'a.telepon',
		4  => 't.saldo',
		5  => 't.status_limit',
	];

	private function _base_query_deposit()
	{
		// Definisikan perhitungan saldo murni (bisa menghasilkan nilai positif, nol, maupun negatif)
		$subquery_saldo = "(SELECT COALESCE(SUM(t.topup_saldo), 0) - COALESCE(SUM(t.usage_saldo), 0) FROM out_topup t WHERE t.agent_uid = a.uid)";

		$this->cb->select("
        a.uid, 
        a.kode, 
        a.nama, 
        a.telepon,
        $subquery_saldo AS saldo, -- Langsung gunakan hasil pengurangan agar bisa bernilai minus (-)
        IF($subquery_saldo > 5000000, 'Safe', 'Limit') AS status_limit
    ", FALSE);

		$this->cb->from('out_agent_deposit a');
		$this->cb->where('a.hold !=', '1');

		// Search (Perbaikan alias pencarian: gunakan alias 'a' karena from Anda adalah 'out_agent_deposit a')
		if (!empty($_POST['search']['value'])) {
			$search = $_POST['search']['value'];
			$this->cb->group_start()
				->like('a.kode', $search)
				->like('a.nama', $search)
				->or_like('a.telepon', $search)
				->group_end();
		}

		// Order
		$orderCol = $_POST['order'][0]['column'] ?? null;
		if ($orderCol !== null && !empty($this->orderable_deposit[$orderCol])) {
			$col = $this->orderable_deposit[$orderCol];
			$dir = ($_POST['order'][0]['dir'] ?? 'desc') === 'asc' ? 'ASC' : 'DESC';
			$this->cb->order_by($col, $dir);
		} else {
			$this->cb->order_by('a.kode', 'DESC');
		}
	}

	public function get_datatables_deposit()
	{
		$this->_base_query_deposit();

		if ($_POST['length'] != -1) {
			$this->cb->limit($_POST['length'], $_POST['start']);
		}

		return $this->cb->get()->result();
	}

	public function count_filtered_deposit()
	{
		$this->_base_query_deposit();
		return $this->cb->get()->num_rows();
	}

	public function count_all_deposit()
	{
		// return $this->cb->count_all($this->table);
		$this->cb->from($this->table_deposit . ' a');
		$this->cb->where('a.hold !=', '1');

		return $this->cb->count_all_results();
	}

	// 1. Ambil Data Riwayat Berdasarkan Datatables Limit & Search
	// 1. Ambil data mentah secara ASC untuk dihitung Running Total di Controller
	public function get_riwayat_topup_raw($agent_uid, $termasuk_usage, $search = '')
	{
		$this->cb->select('billing_uid, kode, topup_saldo, usage_saldo, saldo as saldo_db, post_date');
		$this->cb->from('out_topup');
		$this->cb->where('agent_uid', $agent_uid);

		if ($termasuk_usage == 0) {
			$this->cb->where('kode !=', '');
			$this->cb->where('kode IS NOT NULL');
			$this->cb->where('topup_saldo >', 0);
		}

		if (!empty($search)) {
			$this->cb->group_start();
			$this->cb->like('kode', $search);
			$this->cb->group_end();
		}

		// WAJIB ASC agar perhitungan running total dari transaksi pertama benar
		$this->cb->order_by('post_date', 'ASC');
		return $this->cb->get()->result();
	}

	// 2. Hitung total data untuk keperluan pagination DataTables
	public function count_all_riwayat($agent_uid, $termasuk_usage)
	{
		$this->cb->from('out_topup');
		$this->cb->where('agent_uid', $agent_uid);
		if ($termasuk_usage == 0) {
			$this->cb->where('kode !=', '');
			$this->cb->where('topup_saldo >', 0);
		}
		return $this->cb->count_all_results();
	}

	// 3. Hitung Total Transaksi Setelah Ter-Filter Pencarian
	public function count_filtered_riwayat($agent_uid, $termasuk_usage, $search = '')
	{
		$this->cb->from('out_topup');
		$this->cb->where('agent_uid', $agent_uid);
		if ($termasuk_usage == 0) {
			$this->cb->where('kode !=', '');
			$this->cb->where('topup_saldo >', 0);
		}
		if (!empty($search)) {
			$this->cb->group_start();
			$this->cb->like('kode', $search);
			$this->cb->group_end();
		}
		return $this->cb->count_all_results();
	}

	// ====================================
	// DAFTAR AGENTS
	// ====================================

	private $table_agents = 'out_agent';

	private $orderable_agents = [
		0  => 'a.kode',
		1  => 'a.nama',
		2  => 'a.alamat',
		3  => 'a.telepon',
		4  => 'a.npwp',
		5  => 'user_name',
		6  => 'a.post_date',
		7  => 'a.hold',
	];

	private function _base_query_agents()
	{
		$this->cb->select("
        a.*, u.nama as user_name
    ", FALSE)
			->from('out_agent a')
			->join($this->db->database . '.users u',      'u.nip = a.user',    'left');
		// ->where('btb_p !=', '1');
		// ->where('(is_do != 1 OR is_do IS NULL)');

		// Search
		if (!empty($_POST['search']['value'])) {
			$search = $_POST['search']['value'];
			$this->cb->group_start()
				->like('a.kode', $search)
				->or_like('a.nama', $search)
				->or_like('a.alamat', $search)
				->or_like('a.telepon', $search)
				// ->or_like('o.npwp', $search)
				->or_like('u.nama', $search)
				->or_like('a.post_date', $search)
				->or_like('a.hold', $search)
				// ->or_like('o.koli_smu', $search)
				// ->or_like('o.gross_smu', $search)
				->group_end();
		}

		// Order
		$orderCol = $_POST['order'][0]['column'] ?? null;
		// $orderCol = null;
		if ($orderCol !== null && !empty($this->orderable_agents[$orderCol])) {
			$col = $this->orderable_agents[$orderCol];
			$dir = ($_POST['order'][0]['dir'] ?? 'desc') === 'asc' ? 'ASC' : 'DESC';
			$this->cb->order_by($col, $dir);
		} else {
			// $this->cb->order_by('o.tgl_masuk', 'DESC');
			$this->cb->order_by('a.kode', 'DESC');
		}
	}

	public function get_datatables_agents()
	{
		$this->_base_query_agents();

		if ($_POST['length'] != -1) {
			$this->cb->limit($_POST['length'], $_POST['start']);
		}

		return $this->cb->get()->result();
	}

	public function count_filtered_agents()
	{
		$this->_base_query_agents();
		return $this->cb->get()->num_rows();
	}

	public function count_all_agents()
	{
		// return $this->cb->count_all($this->table);
		return $this->cb->count_all_results($this->table_agents);
	}

	public function insert_agent($data)
	{
		return $this->cb->insert('out_agent', $data);
	}

	public function update_agent($data, $uid)
	{
		return $this->cb->where('uid', $uid)->update('out_agent', $data);
	}

	// ====================================
	// DAFTAR AGENTS DEPOSIT
	// ====================================

	private $table_agents_deposit = 'out_agent_deposit';

	private $orderable_agents_deposit = [
		0  => 'a.kode',
		1  => 'a.nama',
		2  => 'a.alamat',
		3  => 'a.telepon',
		4  => 'a.npwp',
		5  => 'u.user_name',
		6  => 'a.post_date',
		7  => 'a.hold',
	];

	private function _base_query_agents_deposit()
	{
		$this->cb->select("
        a.*, u.nama as user_name
    ", FALSE)
			->from('out_agent_deposit a')
			->join($this->db->database . '.users u',      'u.nip = a.user',    'left');
		// ->where('btb_p !=', '1');
		// ->where('(is_do != 1 OR is_do IS NULL)');

		// Search
		if (!empty($_POST['search']['value'])) {
			$search = $_POST['search']['value'];
			$this->cb->group_start()
				->like('a.kode', $search)
				->or_like('a.nama', $search)
				->or_like('a.alamat', $search)
				->or_like('a.telepon', $search)
				// ->or_like('o.npwp', $search)
				->or_like('u.user_name', $search)
				->or_like('a.post_date', $search)
				->or_like('a.hold', $search)
				// ->or_like('o.koli_smu', $search)
				// ->or_like('o.gross_smu', $search)
				->group_end();
		}

		// Order
		$orderCol = $_POST['order'][0]['column'] ?? null;
		// $orderCol = null;
		if ($orderCol !== null && !empty($this->orderable_agents_deposit[$orderCol])) {
			$col = $this->orderable_agents_deposit[$orderCol];
			$dir = ($_POST['order'][0]['dir'] ?? 'desc') === 'asc' ? 'ASC' : 'DESC';
			$this->cb->order_by($col, $dir);
		} else {
			// $this->cb->order_by('o.tgl_masuk', 'DESC');
			$this->cb->order_by('a.kode', 'DESC');
		}
	}

	public function get_datatables_agents_deposit()
	{
		$this->_base_query_agents_deposit();

		if ($_POST['length'] != -1) {
			$this->cb->limit($_POST['length'], $_POST['start']);
		}

		return $this->cb->get()->result();
	}

	public function count_filtered_agents_deposit()
	{
		$this->_base_query_agents_deposit();
		return $this->cb->get()->num_rows();
	}

	public function count_all_agents_deposit()
	{
		// return $this->cb->count_all($this->table);
		return $this->cb->count_all_results($this->table_agents_deposit);
	}

	public function insert_agent_deposit($data)
	{
		return $this->cb->insert('out_agent_deposit', $data);
	}

	public function update_agent_deposit($data, $uid)
	{
		return $this->cb->where('uid', $uid)->update('out_agent_deposit', $data);
	}

	// ====================================
	// DAFTAR PENGIRIM
	// ====================================

	private $table_pengirim = 'out_pengirim';

	private $orderable_pengirim = [
		0  => 'a.kode',
		1  => 'a.nama',
		2  => 'a.alamat',
		3  => 'a.telepon',
		5  => 'u.nama',
		6  => 'a.post_date',
		7  => 'a.status',
	];

	private function _base_query_pengirim()
	{
		$this->cb->select("
        a.*, u.nama as user_name
    ", FALSE)
			->from('out_pengirim a')
			->join($this->db->database . '.users u',      'u.nip = a.user_code',    'left');
		// ->where('btb_p !=', '1');
		// ->where('(is_do != 1 OR is_do IS NULL)');

		// Search
		if (!empty($_POST['search']['value'])) {
			$search = $_POST['search']['value'];
			$this->cb->group_start()
				->like('a.kode', $search)
				->or_like('a.nama', $search)
				->or_like('a.alamat', $search)
				->or_like('a.telepon', $search)
				->or_like('u.nama', $search)
				->or_like('a.post_date', $search)
				->or_like('a.status', $search)
				// ->or_like('o.koli_smu', $search)
				// ->or_like('o.gross_smu', $search)
				->group_end();
		}

		// Order
		$orderCol = $_POST['order'][0]['column'] ?? null;
		// $orderCol = null;
		if ($orderCol !== null && !empty($this->orderable_pengirim[$orderCol])) {
			$col = $this->orderable_pengirim[$orderCol];
			$dir = ($_POST['order'][0]['dir'] ?? 'desc') === 'asc' ? 'ASC' : 'DESC';
			$this->cb->order_by($col, $dir);
		} else {
			// $this->cb->order_by('o.tgl_masuk', 'DESC');
			$this->cb->order_by('a.kode', 'DESC');
		}
	}

	public function get_datatables_pengirim()
	{
		$this->_base_query_pengirim();

		if ($_POST['length'] != -1) {
			$this->cb->limit($_POST['length'], $_POST['start']);
		}

		return $this->cb->get()->result();
	}

	public function count_filtered_pengirim()
	{
		$this->_base_query_pengirim();
		return $this->cb->get()->num_rows();
	}

	public function count_all_pengirim()
	{
		// return $this->cb->count_all($this->table);
		return $this->cb->count_all_results($this->table_pengirim);
	}

	public function insert_pengirim($data)
	{
		return $this->cb->insert('out_pengirim', $data);
	}

	public function update_pengirim($data, $uid)
	{
		return $this->cb->where('uid', $uid)->update('out_pengirim', $data);
	}

	// ====================================
	// DAFTAR TUJUAN
	// ====================================

	private $table_tujuan = 'out_tujuan';

	private $orderable_tujuan = [
		0  => 'a.kode',
		1  => 'a.kode_kota',
		2  => 'a.nama',
		3  => 'u.user_name',
		4  => 'a.post_date',
		// 5  => 'a.status',
	];

	private function _base_query_tujuan()
	{
		$this->cb->select("
        a.*, u.nama as user_name
    ", FALSE)
			->from('out_tujuan a')
			->join($this->db->database . '.users u',      'u.nip = a.user_code',    'left');
		// ->where('btb_p !=', '1');
		// ->where('(is_do != 1 OR is_do IS NULL)');

		// Search
		if (!empty($_POST['search']['value'])) {
			$search = $_POST['search']['value'];
			$this->cb->group_start()
				->like('b.kode', $search)
				->or_like('a.kode_kota', $search)
				->or_like('a.nama', $search)
				->or_like('u.user_name', $search)
				->or_like('a.post_date', $search)
				// ->or_like('o.koli_smu', $search)
				// ->or_like('o.gross_smu', $search)
				->group_end();
		}

		// Order
		$orderCol = $_POST['order'][0]['column'] ?? null;
		// $orderCol = null;
		if ($orderCol !== null && !empty($this->orderable_tujuan[$orderCol])) {
			$col = $this->orderable_tujuan[$orderCol];
			$dir = ($_POST['order'][0]['dir'] ?? 'desc') === 'asc' ? 'ASC' : 'DESC';
			$this->cb->order_by($col, $dir);
		} else {
			// $this->cb->order_by('o.tgl_masuk', 'DESC');
			$this->cb->order_by('a.kode', 'DESC');
		}
	}

	public function get_datatables_tujuan()
	{
		$this->_base_query_tujuan();

		if ($_POST['length'] != -1) {
			$this->cb->limit($_POST['length'], $_POST['start']);
		}

		return $this->cb->get()->result();
	}

	public function count_filtered_tujuan()
	{
		$this->_base_query_tujuan();
		return $this->cb->get()->num_rows();
	}

	public function count_all_tujuan()
	{
		// return $this->cb->count_all($this->table);
		return $this->cb->count_all_results($this->table_tujuan);
	}

	public function insert_tujuan($data)
	{
		return $this->cb->insert('out_tujuan', $data);
	}

	public function update_tujuan($data, $uid)
	{
		return $this->cb->where('uid', $uid)->update('out_tujuan', $data);
	}
	// ====================================
	// DAFTAR AVSEC
	// ====================================

	private $table_avsec = 'out_avsec';

	private $orderable_avsec = [
		0  => 'a.kode',
		1  => 'a.nama',
		2  => 'a.alamat',
		3  => 'a.telepon',
		4  => 'u.user_name',
		5  => 'a.post_date',
		6  => 'a.hold',
	];

	private function _base_query_avsec()
	{
		$this->cb->select("
        a.*, u.nama as user_name
    ", FALSE)
			->from('out_avsec a')
			->join($this->db->database . '.users u',      'u.nip = a.user',    'left');
		// ->where('btb_p !=', '1');
		// ->where('(is_do != 1 OR is_do IS NULL)');

		// Search
		if (!empty($_POST['search']['value'])) {
			$search = $_POST['search']['value'];
			$this->cb->group_start()
				->like('a.kode', $search)
				->or_like('a.nama', $search)
				->or_like('a.alamat', $search)
				->or_like('a.telepon', $search)
				->or_like('u.user_name', $search)
				->or_like('a.post_date', $search)
				->or_like('a.hold', $search)
				// ->or_like('o.koli_smu', $search)
				// ->or_like('o.gross_smu', $search)
				->group_end();
		}

		// Order
		$orderCol = $_POST['order'][0]['column'] ?? null;
		// $orderCol = null;
		if ($orderCol !== null && !empty($this->orderable_avsec[$orderCol])) {
			$col = $this->orderable_avsec[$orderCol];
			$dir = ($_POST['order'][0]['dir'] ?? 'desc') === 'asc' ? 'ASC' : 'DESC';
			$this->cb->order_by($col, $dir);
		} else {
			// $this->cb->order_by('o.tgl_masuk', 'DESC');
			$this->cb->order_by('a.kode', 'DESC');
		}
	}

	public function get_datatables_avsec()
	{
		$this->_base_query_avsec();

		if ($_POST['length'] != -1) {
			$this->cb->limit($_POST['length'], $_POST['start']);
		}

		return $this->cb->get()->result();
	}

	public function count_filtered_avsec()
	{
		$this->_base_query_avsec();
		return $this->cb->get()->num_rows();
	}

	public function count_all_avsec()
	{
		// return $this->cb->count_all($this->table);
		return $this->cb->count_all_results($this->table_avsec);
	}

	public function insert_avsec($data)
	{
		return $this->cb->insert('out_avsec', $data);
	}

	public function update_avsec($data, $uid)
	{
		return $this->cb->where('uid', $uid)->update('out_avsec', $data);
	}

	// ====================================
	// DAFTAR DRIVER
	// ====================================

	private $table_driver = 'out_driver';

	private $orderable_driver = [
		0  => 'a.kode',
		1  => 'a.nama',
		2  => 'a.alamat',
		3  => 'a.telepon',
		4  => 'u.user_name',
		5  => 'a.post_date',
		6  => 'a.hold',
	];

	private function _base_query_driver()
	{
		$this->cb->select("
        a.*, u.nama as user_name
    ", FALSE)
			->from('out_driver a')
			->join($this->db->database . '.users u',      'u.nip = a.user',    'left');
		// ->where('btb_p !=', '1');
		// ->where('(is_do != 1 OR is_do IS NULL)');

		// Search
		if (!empty($_POST['search']['value'])) {
			$search = $_POST['search']['value'];
			$this->cb->group_start()
				->like('a.kode', $search)
				->or_like('a.nama', $search)
				->or_like('a.alamat', $search)
				->or_like('a.telepon', $search)
				->or_like('u.user_name', $search)
				->or_like('a.post_date', $search)
				->or_like('a.hold', $search)
				// ->or_like('o.koli_smu', $search)
				// ->or_like('o.gross_smu', $search)
				->group_end();
		}

		// Order
		$orderCol = $_POST['order'][0]['column'] ?? null;
		// $orderCol = null;
		if ($orderCol !== null && !empty($this->orderable_driver[$orderCol])) {
			$col = $this->orderable_driver[$orderCol];
			$dir = ($_POST['order'][0]['dir'] ?? 'desc') === 'asc' ? 'ASC' : 'DESC';
			$this->cb->order_by($col, $dir);
		} else {
			// $this->cb->order_by('o.tgl_masuk', 'DESC');
			$this->cb->order_by('a.kode', 'DESC');
		}
	}

	public function get_datatables_driver()
	{
		$this->_base_query_driver();

		if ($_POST['length'] != -1) {
			$this->cb->limit($_POST['length'], $_POST['start']);
		}

		return $this->cb->get()->result();
	}

	public function count_filtered_driver()
	{
		$this->_base_query_driver();
		return $this->cb->get()->num_rows();
	}

	public function count_all_driver()
	{
		// return $this->cb->count_all($this->table);
		return $this->cb->count_all_results($this->table_driver);
	}

	public function insert_driver($data)
	{
		return $this->cb->insert('out_driver', $data);
	}

	public function update_driver($data, $uid)
	{
		return $this->cb->where('uid', $uid)->update('out_driver', $data);
	}

	// ====================================
	// DAFTAR TRUCK
	// ====================================

	private $table_truck = 'out_truck';

	private $orderable_truck = [
		0  => 'a.kode',
		1  => 'a.merk',
		2  => 'a.no_polisi',
		3  => 'u.user_name',
		4  => 'a.post_date',
		5  => 'a.hold',
	];

	private function _base_query_truck()
	{
		$this->cb->select("
        a.*, u.nama as user_name
    ", FALSE)
			->from('out_truck a')
			->join($this->db->database . '.users u',      'u.nip = a.user',    'left');
		// ->where('btb_p !=', '1');
		// ->where('(is_do != 1 OR is_do IS NULL)');

		// Search
		if (!empty($_POST['search']['value'])) {
			$search = $_POST['search']['value'];
			$this->cb->group_start()
				->like('a.kode', $search)
				->or_like('a.merk', $search)
				->or_like('a.no_polisi', $search)
				->or_like('u.user_name', $search)
				->or_like('a.post_date', $search)
				->or_like('a.hold', $search)
				// ->or_like('o.koli_smu', $search)
				// ->or_like('o.gross_smu', $search)
				->group_end();
		}

		// Order
		$orderCol = $_POST['order'][0]['column'] ?? null;
		// $orderCol = null;
		if ($orderCol !== null && !empty($this->orderable_truck[$orderCol])) {
			$col = $this->orderable_truck[$orderCol];
			$dir = ($_POST['order'][0]['dir'] ?? 'desc') === 'asc' ? 'ASC' : 'DESC';
			$this->cb->order_by($col, $dir);
		} else {
			// $this->cb->order_by('o.tgl_masuk', 'DESC');
			$this->cb->order_by('a.kode', 'DESC');
		}
	}

	public function get_datatables_truck()
	{
		$this->_base_query_truck();

		if ($_POST['length'] != -1) {
			$this->cb->limit($_POST['length'], $_POST['start']);
		}

		return $this->cb->get()->result();
	}

	public function count_filtered_truck()
	{
		$this->_base_query_truck();
		return $this->cb->get()->num_rows();
	}

	public function count_all_truck()
	{
		// return $this->cb->count_all($this->table);
		return $this->cb->count_all_results($this->table_truck);
	}

	public function insert_truck($data)
	{
		return $this->cb->insert('out_truck', $data);
	}

	public function update_truck($data, $uid)
	{
		return $this->cb->where('uid', $uid)->update('out_truck', $data);
	}

	// ====================================
	// DAFTAR KATEGORI
	// ====================================

	private $table_kategori_harga = 'out_bill_catg';

	private $orderable_kategori_harga = [
		0  => 'a.kode',
		1  => 'a.jenis_billing',
		2  => 'a.nama_billing',
		3  => 'a.csc',
		4  => 'a.kade',
		5  => 'a.sewa_gudang',
		6  => 'a.jasa_ra',
		7  => 'u.user_name',
		8  => 'a.post_date',
		9  => 'a.hold',
	];

	private function _base_query_kategori_harga()
	{
		$this->cb->select("
        a.*, u.nama as user_name
    ", FALSE)
			->from('out_bill_catg a')
			->join($this->db->database . '.users u',      'u.nip = a.user',    'left');
		// ->where('btb_p !=', '1');
		// ->where('(is_do != 1 OR is_do IS NULL)');

		// Search
		if (!empty($_POST['search']['value'])) {
			$search = $_POST['search']['value'];
			$this->cb->group_start()

				->like('a.kode', $search)
				->or_like('a.nama_billing', $search)
				->or_like('a.csc', $search)
				->or_like('a.kade', $search)
				->or_like('a.jasa_ra', $search)
				->or_like('u.user_name', $search)
				->or_like('a.post_date', $search)
				->or_like('a.hold', $search)
				// ->or_like('o.koli_smu', $search)
				// ->or_like('o.gross_smu', $search)
				->group_end();
		}

		// Order
		$orderCol = $_POST['order'][0]['column'] ?? null;
		// $orderCol = null;
		if ($orderCol !== null && !empty($this->orderable_kategori_harga[$orderCol])) {
			$col = $this->orderable_kategori_harga[$orderCol];
			$dir = ($_POST['order'][0]['dir'] ?? 'desc') === 'asc' ? 'ASC' : 'DESC';
			$this->cb->order_by($col, $dir);
		} else {
			// $this->cb->order_by('o.tgl_masuk', 'DESC');
			$this->cb->order_by('a.kode', 'DESC');
		}
	}

	public function get_datatables_kategori_harga()
	{
		$this->_base_query_kategori_harga();

		if ($_POST['length'] != -1) {
			$this->cb->limit($_POST['length'], $_POST['start']);
		}

		return $this->cb->get()->result();
	}

	public function count_filtered_kategori_harga()
	{
		$this->_base_query_kategori_harga();
		return $this->cb->get()->num_rows();
	}

	public function count_all_kategori_harga()
	{
		// return $this->cb->count_all($this->table);
		return $this->cb->count_all_results($this->table_kategori_harga);
	}

	public function insert_kategori_harga($data)
	{
		return $this->cb->insert('out_bill_catg', $data);
	}

	public function update_kategori_harga($data, $uid)
	{
		return $this->cb->where('uid', $uid)->update('out_bill_catg', $data);
	}

	// ====================================
	// DAFTAR KATEGORI KHUSUS
	// ====================================

	private $table_kategori_harga_khusus = 'out_bill_catg';

	private $orderable_kategori_harga_khusus = [
		0  => 'a.kode',
		1  => 'a.jenis_billing',
		2  => 'a.nama_billing',
		3  => 'a.csc',
		4  => 'a.cdc',
		5  => 'a.kade',
		6  => 'a.sewa_gudang',
		7  => 'a.jasa_ra',
		8  => 'a.ppn_gdg',
		9  => 'a.ppn_ra',
		10  => 'u.user_name',
		11 => 'a.post_date',
		12 => 'a.hold',
	];

	private function _base_query_kategori_harga_khusus()
	{
		$this->cb->select("
        a.*, u.nama as user_name
    ", FALSE)
			->from('out_bill_catg_inv_khusus a')
			->join($this->db->database . '.users u',      'u.nip = a.user',    'left');
		// ->where('btb_p !=', '1');
		// ->where('(is_do != 1 OR is_do IS NULL)');

		// Search
		if (!empty($_POST['search']['value'])) {
			$search = $_POST['search']['value'];
			$this->cb->group_start()

				->like('a.kode', $search)
				->or_like('a.nama_billing', $search)
				->or_like('a.csc', $search)
				->or_like('a.cdc', $search)
				->or_like('a.kade', $search)
				->or_like('a.jasa_ra', $search)
				->or_like('a.ppn_gdg', $search)
				->or_like('a.ppn_ra', $search)
				->or_like('u.user_name', $search)
				->or_like('a.post_date', $search)
				->or_like('a.hold', $search)
				// ->or_like('o.koli_smu', $search)
				// ->or_like('o.gross_smu', $search)
				->group_end();
		}

		// Order
		$orderCol = $_POST['order'][0]['column'] ?? null;
		// $orderCol = null;
		if ($orderCol !== null && !empty($this->orderable_kategori_harga_khusus[$orderCol])) {
			$col = $this->orderable_kategori_harga_khusus[$orderCol];
			$dir = ($_POST['order'][0]['dir'] ?? 'desc') === 'asc' ? 'ASC' : 'DESC';
			$this->cb->order_by($col, $dir);
		} else {
			// $this->cb->order_by('o.tgl_masuk', 'DESC');
			$this->cb->order_by('a.kode', 'DESC');
		}
	}

	public function get_datatables_kategori_harga_khusus()
	{
		$this->_base_query_kategori_harga_khusus();

		if ($_POST['length'] != -1) {
			$this->cb->limit($_POST['length'], $_POST['start']);
		}

		return $this->cb->get()->result();
	}

	public function count_filtered_kategori_harga_khusus()
	{
		$this->_base_query_kategori_harga_khusus();
		return $this->cb->get()->num_rows();
	}

	public function count_all_kategori_harga_khusus()
	{
		// return $this->cb->count_all($this->table);
		return $this->cb->count_all_results($this->table_kategori_harga_khusus);
	}

	public function insert_kategori_harga_khusus($data)
	{
		return $this->cb->insert('out_bill_catg_inv_khusus', $data);
	}

	public function update_kategori_harga_khusus($data, $uid)
	{
		return $this->cb->where('uid', $uid)->update('out_bill_catg_inv_khusus', $data);
	}

	private $table_outbound_manifest = 'ra_csd';

	private $orderable_outbound_manifest = [
		0  => 'o.uid',
		1  => 'o.catg_smu',
		2  => 'o.smu',
		3  => 'o.tujuan',
		4  => 'o.post_date',
		5  => 'o.manifest_date',
		6  => 'o.loading_date',
		7  => 'o.fly_date',
		// 6 => 'o.fly_p',
	];

	// =========================================================================
	// BASE QUERY BUILDER (Menggabungkan ra_csd dan out_list)
	// =========================================================================
	private function _base_query_outbound_manifest()
	{

		$this->cb->select("
            o.*, b.pay_status, b.jurnal_status
        ", FALSE)
			->from('out_list o')
			->where('o.btb_p', '1')
			->join($this->db->database . '.users u', 'u.nip = o.user_in', 'left')
			->join('out_billing b', 'b.uid = o.bill_uid', 'left');

		// Logic Search
		if (!empty($_POST['search']['value'])) {
			$search = $_POST['search']['value'];
			$this->cb->group_start()
				->like('o.smu', $search)
				->or_like('o.tujuan', $search)
				->or_like('o.jumlah', $search)
				->or_like('o.gross', $search)
				->or_like('o.volume', $search)
				->or_like('o.nama_pengirim', $search)
				->or_like('o.post_date', $search)
				->group_end();
		}

		// Logic Sorting Kolom Datatable
		$orderCol = $_POST['order'][0]['column'] ?? null;
		if ($orderCol !== null && !empty($this->orderable_outbound_manifest[$orderCol])) {
			$col = $this->orderable_outbound_manifest[$orderCol];
			$dir = ($_POST['order'][0]['dir'] ?? 'desc') === 'asc' ? 'ASC' : 'DESC';
			$this->cb->order_by($col, $dir);
		} else {
			$this->cb->order_by("o.fly_p", "ASC");
			$this->cb->order_by("o.uid", "DESC");
		}
	}

	// =========================================================================
	// DATATABLE GET DATA METHOD
	// =========================================================================
	public function get_datatables_outbound_manifest()
	{
		$this->_base_query_outbound_manifest();

		if (isset($_POST['length']) && $_POST['length'] != -1) {
			$this->cb->limit(intval($_POST['length']), intval($_POST['start']));
		}

		return $this->cb->get()->result();
	}

	// =========================================================================
	// DATATABLE COUNT METHODS
	// =========================================================================
	public function count_filtered_outbound_manifest()
	{
		$this->_base_query_outbound_manifest();
		return $this->cb->get()->num_rows();
	}

	public function count_all_outbound_manifest()
	{
		$this->cb->from('ra_csd c')
			->join('out_list o', 'c.smu_uid = o.uid', 'inner');
		return $this->cb->count_all_results();
	}
}
