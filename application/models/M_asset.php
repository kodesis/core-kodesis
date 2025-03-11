<?php if (!defined('BASEPATH')) exit('Hacking Attempt : Keluar dari sistem..!!');

class M_asset extends CI_Model
{

	var $column_order = array(null, 'periode', null);
	var $column_search = array('periode');
	var $order = array('Id' => 'desc');

	public function __construct()
	{
		parent::__construct();
	}

	public function __destruct()
	{
		$this->db->close();
	}

	private function _get_datatables_query_penyusutan()
	{
		$this->cb->select('a.*')->from('t_penyusutan a');
		$i = 0;
		foreach ($this->column_search as $item) {
			if ($this->input->post('search')['value']) {
				if ($i === 0) {
					$this->cb->group_start();
					$this->cb->like($item, $this->input->post('search')['value']);
				} else {
					$this->cb->or_like($item, $this->input->post('search')['value']);
				}
				if (count($this->column_search) - 1 == $i) //looping terakhir
					$this->cb->group_end();
			}
			$i++;
		}
		// jika datatable mengirim POST untuk order
		if ($this->input->post('order')) {
			$this->cb->order_by($this->column_order[$this->input->post('order')['0']['column']], $this->input->post('order')['0']['dir']);
		} else if (isset($this->order)) {
			$order = $this->order;
			$this->cb->order_by(key($order), $order[key($order)]);
		}
	}

	public function get_datatables_penyusutan()
	{
		$this->_get_datatables_query_penyusutan();
		if ($this->input->post('length') != -1)
			$this->cb->limit($this->input->post('length'), $this->input->post('start'));
		$query = $this->cb->get();
		return $query->result();
	}

	public function count_filtered()
	{
		$this->_get_datatables_query_penyusutan();
		$query = $this->cb->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$this->_get_datatables_query_penyusutan();
		return $this->cb->count_all_results();
	}

	function asset_get($limit, $start)
	{
		$jenis = $this->session->userdata('filterJenis');
		if ($jenis == true) {
			$sql = "SELECT * FROM item_list where jenis_item='$jenis' ORDER BY Id DESC limit " . $start . ", " . $limit;
		} else {
			$sql = "select * FROM item_list ORDER BY Id DESC limit " . $start . ", " . $limit;
		}
		$query = $this->db->query($sql);
		return $query->result();
	}
	function asset_count()
	{
		$jenis = $this->session->userdata('filterJenis');
		if ($jenis == true) {
			$sql = "SELECT * FROM item_list where jenis_item='$jenis' ORDER BY Id";
		} else {
			$sql = "select * FROM item_list";
		}
		// $sql = "select Id FROM asset_list";
		$query = $this->db->query($sql);
		return $query->num_rows();
	}

	function item_cari_pagination($limit, $start, $st = NULL)
	{
		if ($st == "NIL") $st = "";
		// $sql = "SELECT * FROM asset_list WHERE (kode LIKE '%$st%' OR spesifikasi LIKE '%$st%' OR nama_asset LIKE '%$st%') ORDER BY kode ASC limit " . $start . ", " . $limit;
		$sql = "SELECT a.* FROM item_list as a left join item_in as b on(a.Id=b.item_list_id) WHERE (a.nomor LIKE '%$st%' OR a.nama LIKE '%$st%') ORDER BY a.Id ASC limit " . $start . ", " . $limit;
		$query = $this->db->query($sql);
		return $query->result();
	}

	function item_cari_count($st = NULL)
	{
		if ($st == "NIL") $st = "";
		// $sql = "select Id FROM asset_list WHERE (kode LIKE '%$st%' OR spesifikasi LIKE '%$st%' OR nama_asset LIKE '%$st%')";
		$sql = "SELECT a.* FROM item_list as a left join item_in as b on(a.Id=b.item_list_id) WHERE (a.nomor LIKE '%$st%' OR a.nama LIKE '%$st%')";
		$query = $this->db->query($sql);
		return $query->num_rows();
	}
}
