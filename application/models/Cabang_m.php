<?php defined('BASEPATH') or exit('No direct script access allowed');

class Cabang_m extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->cb = $this->load->database('corebank', TRUE);
        date_default_timezone_set('Asia/Jakarta');
    }

    var $table = 't_cabang';
    var $column_order = array('uid', 'nama_cabang', 'alamat_cabang'); //set column field database for datatable orderable
    var $column_search = array('uid', 'nama_cabang', 'alamat_cabang'); //set column field database for datatable searchable

    var $order = array('uid' => 'desc'); // default order 

    function _get_datatables_query()
    {

        $this->cb->select('a.*');
        $this->cb->from('t_cabang as a');
        // $this->cb->join('t_segnasabah as d', 'd.kode_segmen = a.segmen_nasabah', 'LEFT');
        $i = 0;

        foreach ($this->column_search as $item) // loop column 
        {
            if ($_POST['search']['value']) // if datatable send POST for search
            {

                if ($i === 0) // first loop
                {
                    $this->cb->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->cb->like($item, $_POST['search']['value']);
                } else {
                    $this->cb->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_search) - 1 == $i) //last loop
                    $this->cb->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->cb->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            // $this->cb->order_by(key($order), $order[key($order)]);
            foreach ($order as $key => $value) {
                $this->cb->order_by($key, $value);
            }
        }
    }

    function get_datatables()
    {
        $this->_get_datatables_query();
        if ($_POST['length'] != -1)
            $this->cb->limit($_POST['length'], $_POST['start']);
        $query = $this->cb->get();
        return $query->result();
    }

    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->cb->get();
        return $query->num_rows();
    }

    function count_all()
    {

        $this->_get_datatables_query();
        $query = $this->cb->get();

        return $this->cb->count_all_results();
    }
    public function get_detail_id($id)
    {
        $this->cb->select('*'); // Fetch only these columns
        $this->cb->from('t_cabang'); // Table name
        $this->cb->where('uid', $id);
        $query = $this->cb->get();

        // return $query->result_array(); // Return the result as an array
        return $query->row(); // Return the result as an array
    }
    public function delete($where)
    {
        $this->cb->delete($this->table, $where);
    }
    public function get_nasabah()
    {
        $this->cb->select('*'); // Fetch only these columns
        $this->cb->from('t_nasabah'); // Table name
        $query = $this->cb->get();
        return $query->result(); // Return the result as an array
    }
    public function get_karyawan()
    {
        $this->cb->select('*'); // Fetch only these columns
        $this->cb->from('t_karyawan'); // Table name
        $query = $this->cb->get();
        return $query->result(); // Return the result as an array
    }
    public function get_jenis_tabungan()
    {
        $this->cb->select('*'); // Fetch only these columns
        $this->cb->from('t_jenistabungan'); // Table name
        $query = $this->cb->get();
        return $query->result(); // Return the result as an array
    }
    public function getLastNumber($jenis_tabungan)
    {
        $this->cb->select('no_tabungan');
        $this->cb->where('jenis_tabungan', $jenis_tabungan);
        $this->cb->order_by('no_tabungan', 'DESC');
        $this->cb->limit(1);
        $result = $this->cb->get('t_cabang')->row();

        return $result ? $result->no_tabungan : null;
    }
    public function getLastNoUrut()
    {
        $this->cb->select_max('no_urut');
        $result = $this->cb->get('t_cabang')->row();

        return $result ? (int)$result->no_urut : null;
    }
}
