<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_ocr extends CI_Model
{
	private $table = 'ocr_history';

	public function insert($data)
	{
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}

	public function get_history($nip, $limit = 20)
	{
		return $this->db
			->select('id, original_name, file_name, lang, engine, duration, created_at, LEFT(result_text, 150) AS preview', false)
			->where('nip', $nip)
			->order_by('id', 'DESC')
			->limit($limit)
			->get($this->table)
			->result();
	}

	public function get_by_id($id, $nip)
	{
		return $this->db
			->where('id', $id)
			->where('nip', $nip)
			->get($this->table)
			->row();
	}

	public function file_exists($file_name)
	{
		return $this->db->where('file_name', $file_name)->count_all_results($this->table) > 0;
	}

	public function delete($id)
	{
		return $this->db->where('id', $id)->delete($this->table);
	}
}
