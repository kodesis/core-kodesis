<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_depositwh extends CI_Model
{

	// ====================================
	// DAFTAR DEPOSIT
	// ====================================

	private $table_deposit = 'all_agent_deposit';

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
		$subquery_saldo = "(SELECT COALESCE(SUM(t.topup_saldo), 0) - COALESCE(SUM(t.usage_saldo), 0) FROM all_topup t WHERE t.agent_uid = a.uid)";

		$this->cb->select("
        a.uid, 
        a.kode, 
        a.nama, 
        a.telepon,
        $subquery_saldo AS saldo, -- Langsung gunakan hasil pengurangan agar bisa bernilai minus (-)
        IF($subquery_saldo > 5000000, 'Safe', 'Limit') AS status_limit
    ", FALSE);

		$this->cb->from('all_agent_deposit a');
		$this->cb->where('a.hold !=', '1');

		// Search (Perbaikan alias pencarian: gunakan alias 'a' karena from Anda adalah 'all_agent_deposit a')
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
		$this->cb->select('billing_uid, kode, topup_saldo, usage_saldo, saldo as saldo_db, post_date, asal_table, user_topup, user_kasir');
		$this->cb->from('all_topup');
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
		$this->cb->from('all_topup');
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
		$this->cb->from('all_topup');
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
	// DAFTAR AGENTS DEPOSIT
	// ====================================

	private $table_agents_deposit = 'all_agent_deposit';

	private $orderable_agents_deposit = [
		0  => 'a.kode',
		1  => 'a.nama',
		2  => 'a.alamat',
		3  => 'a.telepon',
		4  => 'a.coa_sbb',
		5  => 'u.user_name',
		6  => 'a.post_date',
		7  => 'a.hold',
	];

	private function _base_query_agents_deposit()
	{
		$this->cb->select("
        a.*, u.nama as user_name, coa.nama_perkiraan
    ", FALSE)
			->from('all_agent_deposit a')
			->join($this->db->database . '.users u',      'u.nip = a.user',    'left')
			->join('t_coa_sbb coa', 'coa.no_sbb = a.coa_sbb', 'left');
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
		return $this->cb->insert('all_agent_deposit', $data);
	}

	public function update_agent_deposit($data, $uid)
	{
		return $this->cb->where('uid', $uid)->update('all_agent_deposit', $data);
	}
}
