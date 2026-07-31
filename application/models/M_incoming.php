<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_incoming extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
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


	// =============================================
	// KEMASAN SMU INCOMING (TABEL `in_list`)
	// =============================================
	private $table_kemasan_smu = 'in_list';

	// Mapping orderable columns sesuai dengan urutan DataTables Incoming Anda

	private $orderable_kemasan_smu = [
		0  => 'o.uid',
		1  => 'o.smu',
		2  => 'o.nama_penerima',
		3  => 'o.asal',
		4  => 'o.jumlah',
		5  => 'o.gross',
		6  => 'o.user_in',
		7  => 'o.post_date',
	];

	private function _base_query_kemasan_smu()
	{
		// Query mengambil data dari in_list, join tabel users DB utama untuk mendapatkan pencatat (user_in)
		$this->cb->select("
        o.*,
        u.nama as user_name
    ", FALSE)
			->from('in_list o')
			->join($this->db->database . '.users u', 'u.nip = o.user_in', 'left');

		// Search
		if (!empty($_POST['search']['value'])) {
			$search = $_POST['search']['value'];
			$this->cb->group_start()

				->like('o.smu', $search)
				->or_like('o.nama_penerima', $search)
				->or_like('o.asal', $search)
				->or_like('o.jumlah', $search)
				->or_like('o.gross', $search)
				->or_like('o.user_name', $search)
				->or_like('o.post_date', $search)
				->group_end();
		}


		// Order
		$orderCol = $_POST['order'][0]['column'] ?? null;
		if ($orderCol !== null && !empty($this->orderable_kemasan_smu[$orderCol])) {
			$col = $this->orderable_kemasan_smu[$orderCol];
			$dir = ($_POST['order'][0]['dir'] ?? 'desc') === 'asc' ? 'ASC' : 'DESC';
			$this->cb->order_by($col, $dir);
		} else {
			$this->cb->order_by('out_p', 'ASC');
			$this->cb->order_by('o.uid', 'DESC');
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

	// =============================================
	// SINKRONISASI DAFTAR INVOICE INCOMING (TABEL `in_billing` & `in_list`)
	// =============================================
	private $table_invoice = 'in_billing';

	private $orderable_invoice = [
		0  => 'b.uid',
		1  => 'b.no',
		2  => 'b.no_invoice',
		3  => 'b.smu',
		4  => 'l.tanggal_smu',
		5  => 'l.nama',
		6  => 'b.total_pieces',
		7  => 'b.total_gross',
		8  => 'b.total_chargeable',
		9  => 'total',
		10 => 'b.in_date',
		11 => 'b.tanggal_invoice',
		12 => 'b.hari',
		13 => 'nama_acc',
		14 => 'nama_kasir',
	];

	private function _base_query_invoice()
	{
		// GROUP_CONCAT bisa digunakan di select jika ingin menggabungkan string SMU agar tidak duplikat, 
		// namun jika menggunakan GROUP BY b.uid, pastikan l.smu menghimpun datanya dengan benar jika 1 invoice multi SMU.
		$this->cb->select("
        b.uid,
        b.no,
        b.no_invoice,
        b.total_pieces,
        b.total_chargeable,
        IF(b.pay_status='1', b.total, '') as total,
        l.nama_pengirim,
        b.nama as nama_penerima,
        u1.nama as nama_kasir,
        b.tanggal_invoice,
        b.post_date,
        b.status,
        b.pay_status,
        b.jurnal_status,
        b.total_gross,
        l.smu,
        l.tanggal_smu,
        l.in_date,
        l.out_date,
        u2.nama as nama_acc,
        b.hari,
        b.agent_uid_depo
    ", FALSE);

		$this->cb->from('in_billing b')
			->join('in_list l', 'l.bill_uid = b.uid', 'left')
			// Memperbaiki target tabel join users dari u.nip menjadi u1.nip dan u2.nip
			->join($this->db->database . '.users u1', 'u1.nip = b.user_kasir', 'left')
			->join($this->db->database . '.users u2', 'u2.nip = l.user_in', 'left')
			->group_by('b.uid');

		if (!empty($_POST['search']['value'])) {
			$search = $_POST['search']['value'];
			$this->cb->group_start()
				->like('b.no_invoice', $search)
				->or_like('l.nama', $search) // Diubah dari b.nama ke l.nama sesuai select
				->or_like('l.smu', $search)
				->or_like('u1.nama', $search) // Menggunakan u1 (kasir) atau u2 (acc) untuk pencarian user
				->or_like('u2.nama', $search)
				->group_end();
		}

		$orderCol = $_POST['order'][0]['column'] ?? null;
		if ($orderCol !== null && !empty($this->orderable_invoice[$orderCol])) {
			$col = $this->orderable_invoice[$orderCol];
			$dir = ($_POST['order'][0]['dir'] ?? 'desc') === 'asc' ? 'ASC' : 'DESC';
			$this->cb->order_by($col, $dir);
		} else {
			$this->cb->order_by('b.pay_status', 'ASC');
			$this->cb->order_by('b.jurnal_status', 'ASC');
			$this->cb->order_by('b.uid', 'DESC');
		}
	}

	public function get_datatables_invoice()
	{
		$this->_base_query_invoice();

		if ($_POST['length'] != -1) {
			$this->cb->limit($_POST['length'], $_POST['start']);
		}

		return $this->cb->get()->result();
	}

	public function count_filtered_invoice()
	{
		$this->_base_query_invoice();
		return $this->cb->get()->num_rows();
	}

	public function count_all_invoice()
	{
		return $this->cb->count_all_results($this->table_invoice);
	}

	// ====================================
	// DAFTAR DEPOSIT
	// ====================================

	private $table_deposit = 'in_agent_deposit';

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
		$subquery_saldo = "(SELECT COALESCE(SUM(t.topup_saldo), 0) - COALESCE(SUM(t.usage_saldo), 0) FROM in_topup t WHERE t.agent_uid = a.uid)";

		$this->cb->select("
        a.uid, 
        a.kode, 
        a.nama, 
        a.telepon,
        $subquery_saldo AS saldo, -- Langsung gunakan hasil pengurangan agar bisa bernilai minus (-)
        IF($subquery_saldo > 5000000, 'Safe', 'Limit') AS status_limit
    ", FALSE);

		$this->cb->from('in_agent_deposit a');
		$this->cb->where('a.hold !=', '1');

		// Search (Perbaikan alias pencarian: gunakan alias 'a' karena from Anda adalah 'in_agent_deposit a')
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
		$this->cb->from('in_topup');
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
		$this->cb->from('in_topup');
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
		$this->cb->from('in_topup');
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

	private $table_agents = 'in_agent';

	private $orderable_agents = [
		0  => 'a.kode',
		1  => 'a.nama',
		2  => 'a.alamat',
		3  => 'a.telepon',
		4  => 'a.npwp',
		5  => 'u.user_name',
		6  => 'a.post_date',
		7  => 'a.hold',
	];

	private function _base_query_agents()
	{
		$this->cb->select("
        a.*, u.nama as user_name
    ", FALSE)
			->from('in_agent a')
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
		return $this->cb->insert('in_agent', $data);
	}

	public function update_agent($data, $uid)
	{
		return $this->cb->where('uid', $uid)->update('in_agent', $data);
	}

	// ====================================
	// DAFTAR AGENTS DEPOSIT
	// ====================================

	private $table_agents_deposit = 'in_agent_deposit';

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
			->from('in_agent_deposit a')
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
		return $this->cb->insert('in_agent_deposit', $data);
	}

	public function update_agent_deposit($data, $uid)
	{
		return $this->cb->where('uid', $uid)->update('in_agent_deposit', $data);
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
		5  => 'u.user_name',
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
				->or_like('u.user_name', $search)
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

	private $table_asal = 'in_asal';

	private $orderable_asal = [
		0  => 'a.kode',
		1  => 'a.kode_kota',
		2  => 'a.nama',
		3  => 'u.user_name',
		4  => 'a.post_date',
		// 5  => 'a.status',
	];

	private function _base_query_asal()
	{
		$this->cb->select("
        a.*, u.nama as user_name
    ", FALSE)
			->from('in_asal a')
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
		if ($orderCol !== null && !empty($this->orderable_asal[$orderCol])) {
			$col = $this->orderable_asal[$orderCol];
			$dir = ($_POST['order'][0]['dir'] ?? 'desc') === 'asc' ? 'ASC' : 'DESC';
			$this->cb->order_by($col, $dir);
		} else {
			// $this->cb->order_by('o.tgl_masuk', 'DESC');
			$this->cb->order_by('a.kode', 'DESC');
		}
	}

	public function get_datatables_asal()
	{
		$this->_base_query_asal();

		if ($_POST['length'] != -1) {
			$this->cb->limit($_POST['length'], $_POST['start']);
		}

		return $this->cb->get()->result();
	}

	public function count_filtered_asal()
	{
		$this->_base_query_asal();
		return $this->cb->get()->num_rows();
	}

	public function count_all_asal()
	{
		// return $this->cb->count_all($this->table);
		return $this->cb->count_all_results($this->table_asal);
	}

	public function insert_asal($data)
	{
		return $this->cb->insert('in_asal', $data);
	}

	public function update_asal($data, $uid)
	{
		return $this->cb->where('uid', $uid)->update('in_asal', $data);
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
	// DAFTAR KATEGORI HARGA
	// ====================================

	private $table_kategori_harga = 'in_bill_catg';

	private $orderable_kategori_harga = [
		0  => 'a.kode',
		1  => 'a.jenis_billing',
		2  => 'a.nama_billing',
		3  => 'a.csc',
		4  => 'a.kade',
		5  => 'a.sewa_gudang',
		6  => 'u.user_name',
		7  => 'a.post_date',
		8  => 'a.hold',
	];

	private function _base_query_kategori_harga()
	{
		$this->cb->select("
        a.*, u.nama as user_name
    ", FALSE)
			->from('in_bill_catg a')
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
		return $this->cb->insert('in_bill_catg', $data);
	}

	public function update_kategori_harga($data, $uid)
	{
		return $this->cb->where('uid', $uid)->update('in_bill_catg', $data);
	}
}
