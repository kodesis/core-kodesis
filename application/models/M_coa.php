<?php if (!defined('BASEPATH')) exit('Hacking Attempt : Keluar dari sistem..!!');

class M_coa extends CI_Model
{
    // $this->cb untuk koneksi ke database corebank

    private function apply_cabang_filter()
    {
        $kode_cabang = $this->session->userdata('kode_cabang');
        return $this->cb->where('id_cabang', $kode_cabang);
    }

    public function list_coa()
    {
        return $this->apply_cabang_filter()->order_by('no_sbb', 'ASC')->get('v_coa_all')->result();
    }

    public function cek_coa($no_coa)
    {
        return $this->apply_cabang_filter()->select('posisi, nominal')->where('no_sbb', $no_coa)->get('v_coa_all')->row_array();
    }

    public function update_nominal_coa($no_coa, $data, $kolom, $tabel)
    {
        return $this->apply_cabang_filter()->where($kolom, $no_coa)->update($tabel, $data);
    }

    function update_nominal_coa_new($id, $nominal, $tabel, $operator)
    {
        $this->db->set('nominal', "nominal {$operator} {$nominal}", false);
        $this->db->where('Id', $id);
        $this->db->update($tabel);
    }


    public function add_transaksi($data)
    {
        return $this->cb->insert('t_log_transaksi', $data);
    }

    public function addJurnal($data)
    {
        return $this->cb->insert('jurnal_neraca', $data);
    }

    public function getNeraca($table, $posisi)
    {
        return $this->apply_cabang_filter()->where('nominal !=', '0')->where('posisi', $posisi)->get($table)->result();
    }

    public function getSumNeraca($table, $posisi)
    {
        return $this->cb->select_sum('nominal')->where('posisi', $posisi)->get($table)->row_array();
    }

    public function getPasivaWithLaba($table)
    {
        // $pasiva = $this->cb->where('posisi', 'PASIVA')->group_start()->where('nominal !=', '0')->or_where('no_sbb', '32020')->group_end()->get($table)->result();
        $pasiva = $this->cb->where('posisi', 'PASIVA')->where('nominal !=', '0')->or_where('no_sbb', '32020')->get($table)->result();
        // $total_activa = $this->getSumNeraca($table, 'AKTIVA')['nominal'];

        // foreach ($pasiva as &$row) {
        //     if ($row->no_sbb == '32020') { // Special handling for 'LABA'
        //         $row->nominal = $total_activa;
        //     }
        // }

        // echo '<pre>';
        // print_r($pasiva);
        // echo '</pre>';
        // exit;
        return $pasiva;
    }

    public function getCoaReport($no_coa, $from, $to)
    {
        $this->cb->select('*');
        $this->cb->from('jurnal_neraca');
        $this->cb->where('tanggal >=', $from);
        $this->cb->where('tanggal <=', $to);
        $this->cb->group_start();
        $this->cb->where('id_cabang', $this->session->userdata('kode_cabang'));
        $this->cb->where('akun_debit', $no_coa);
        $this->cb->or_where('akun_kredit', $no_coa);
        $this->cb->group_end();
        // $this->cb->order_by('tanggal', 'ASC');
        $this->cb->order_by('Id', 'DESC');
        $query = $this->cb->get();

        $result = $query->result();

        return $result;
    }

    public function getCoa($no_coa)
    {
        return $this->cb->where('no_sbb', $no_coa)->get('v_coa_all')->row_array();
    }

    public function getCoaBB($no_coa)
    {
        if ($no_coa == "ALL") {
            $this->cb->select('nama_perkiraan, no_bb');
            return $this->cb->get('v_coabb_all')->result();
        } else {
            return $this->cb->where('no_bb', $no_coa)->get('v_coabb_all')->row_array();
        }
    }

    public function getCoaByCode($code = NULL)
    {
        $this->apply_cabang_filter();

        if ($code) {
            $this->cb->like('no_sbb', $code, 'after');
        }

        return $this->cb->get('v_coa_all')->result();
    }

    public function simpanLaporan($data)
    {
        return $this->cb->insert('t_log_neraca', $data);
    }

    public function count_laporan($jenis)
    {
        return $this->cb->from('t_log_neraca')->where('jenis', $jenis)->count_all_results();
    }

    public function list_laporan($jenis, $limit, $from)
    {
        $laporan = $this->cb->where('jenis', $jenis)->order_by('tanggal_simpan', 'DESC')->limit($limit, $from)->get('t_log_neraca')->result_array();

        // Ambil semua user dari database bdl_core
        $users = $this->db->select('id, nip, nama')->get('users')->result_array();
        $user_map = array_column($users, 'nama', 'nip');  // Menggunakan nama pengguna sebagai nama kolom

        // Gabungkan hasil query
        foreach ($laporan as &$lp) {
            $lp['created_by_name'] = isset($user_map[$lp['created_by']]) ? $user_map[$lp['created_by']] : null;
        }

        return $laporan;
    }

    public function showNeraca($slug)
    {
        return $this->cb->where('slug', $slug)->get('t_log_neraca')->row_array();
    }

    public function select_max($jenis)
    {
        return $this->cb->select('max(no_urut) as max')->where('jenis', $jenis)->get('t_log_neraca')->row_array();
    }

    public function count($keyword, $tabel)
    {
        $this->apply_cabang_filter();
        if ($keyword) {
            $this->cb->like('no_sbb', $keyword);
            $this->cb->or_like('no_bb', $keyword);
            $this->cb->or_like('nama_perkiraan', $keyword);
        }
        return $this->cb->from($tabel)->count_all_results();
    }

    public function list_coa_paginate($limit, $from, $keyword)
    {
        $this->apply_cabang_filter();
        if ($keyword) {
            $this->cb->like('no_sbb', $keyword);
            $this->cb->or_like('no_bb', $keyword);
            $this->cb->or_like('nama_perkiraan', $keyword);
        }
        $laporan = $this->cb->order_by(
            'no_sbb',
            'ASC'
        )->limit($limit, $from)->get('v_coa_all')->result_array();

        return $laporan;
    }

    public function isAvailable($kolom, $key)
    {
        $this->apply_cabang_filter();
        return $this->cb->from('v_coa_all')->where($kolom, $key)->count_all_results();
    }

    public function list_saldo()
    {
        $this->apply_cabang_filter();
        return $this->cb->order_by('periode', 'DESC')->get('saldo_awal')->result();
    }

    public function showSaldo($slug)
    {
        return $this->cb->where('slug', $slug)->get('saldo_awal')->row_array();
    }

    public function showDetailSaldo($id)
    {
        return $this->cb->from('saldo_awal_detail s')->join('v_coa_all v', 's.no_sbb = v.no_sbb')->where('id_saldo_awal', $id)->get()->result();
    }

    // Fungsi untuk menyimpan saldo awal ke tabel saldo_awal_neraca
    public function insert_saldo_awal($data)
    {
        return $this->cb->insert('saldo_awal', $data);
    }

    public function update_saldo_awal($periode, $data)
    {
        return $this->cb->where('periode', $periode)->update('saldo_awal', $data);
    }

    // Fungsi untuk mendapatkan saldo awal berdasarkan bulan tertentu
    public function get_saldo_awal($bulan)
    {
        $this->cb->select('*');
        $this->cb->from('saldo_awal');
        $this->cb->where('periode', $bulan);
        $query = $this->cb->get();
        return $query->row_array();
    }

    public function calculate_saldo_awal($bulan, $tahun)
    {
        $bulan = (int) $bulan;
        $tahun = (int) $tahun;
        $kode_cabang = $this->session->userdata('kode_cabang');

        $query = $this->cb->query("
            SELECT 
                coa.no_sbb, coa.nama_perkiraan, coa.posisi, coa.table_source,
                SUM(
                    CASE 
                        WHEN jn.akun_debit = jn.akun_kredit THEN 0
                        WHEN coa.posisi = 'AKTIVA' AND jn.akun_debit = coa.no_sbb THEN jn.jumlah_debit
                        WHEN coa.posisi = 'AKTIVA' AND jn.akun_kredit = coa.no_sbb THEN -jn.jumlah_kredit
                        WHEN coa.posisi = 'PASIVA' AND jn.akun_kredit = coa.no_sbb THEN jn.jumlah_kredit
                        WHEN coa.posisi = 'PASIVA' AND jn.akun_debit = coa.no_sbb THEN -jn.jumlah_debit
                        ELSE 0
                    END
                ) AS saldo_awal
            FROM 
                v_coa_all coa
            LEFT JOIN 
                jurnal_neraca jn ON coa.no_sbb = jn.akun_debit OR coa.no_sbb = jn.akun_kredit
            WHERE 
                jn.id_cabang = '$kode_cabang' AND 
                coa.id_cabang = '$kode_cabang' AND 
                MONTH(jn.tanggal) = '$bulan' AND YEAR(jn.tanggal) = '$tahun'
            GROUP BY 
                coa.no_sbb
            ORDER BY 
                coa.no_sbb ASC
        ");
        // echo '<pre>';
        // print_r($query->result_array());
        // echo '</pre>';
        // exit;
        return $query->result();
    }

    public function cek_saldo_awal($bulan)
    {
        $this->apply_cabang_filter();
        return $this->cb->where('periode', $bulan)->get('saldo_awal')->row_array();
    }

    public function getNeracaByDate($table, $posisi, $tanggal_akhir)
    {
        $date = new DateTime($tanggal_akhir);
        $tanggal_awal = $date->format('Y-m') . '-01';
        $kode_cabang = $this->session->userdata('kode_cabang');

        if ($posisi == "AKTIVA") {

            $query = $this->cb->query("
            SELECT 
                coa.no_sbb, coa.nama_perkiraan, coa.posisi,
                SUM(
                    CASE 
                        WHEN jn.akun_debit = jn.akun_kredit THEN 0
                        WHEN coa.posisi = 'AKTIVA' AND jn.akun_debit = coa.no_sbb THEN jn.jumlah_debit
                        WHEN coa.posisi = 'AKTIVA' AND jn.akun_kredit = coa.no_sbb THEN -jn.jumlah_kredit
                        ELSE 0
                    END
                ) AS saldo_awal
            FROM 
                v_coa_all coa
            LEFT JOIN 
                jurnal_neraca jn ON coa.no_sbb = jn.akun_debit OR coa.no_sbb = jn.akun_kredit
            WHERE 
                jn.id_cabang = '$kode_cabang' AND 
                coa.id_cabang = '$kode_cabang' AND
                jn.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
                AND coa.table_source = '$table' AND coa.posisi = '$posisi'
            GROUP BY 
                coa.no_sbb
            ORDER BY 
                coa.no_sbb ASC
        ");
        } else if ($posisi == "PASIVA") {

            $query = $this->cb->query("
            SELECT 
                coa.no_sbb, coa.nama_perkiraan, coa.posisi,
                SUM(
                    CASE 
                        WHEN jn.akun_debit = jn.akun_kredit THEN 0
                        WHEN coa.posisi = 'PASIVA' AND jn.akun_kredit = coa.no_sbb THEN jn.jumlah_kredit
                        WHEN coa.posisi = 'PASIVA' AND jn.akun_debit = coa.no_sbb THEN -jn.jumlah_debit
                        ELSE 0
                    END
                ) AS saldo_awal
            FROM 
                v_coa_all coa
            LEFT JOIN 
                jurnal_neraca jn ON coa.no_sbb = jn.akun_debit OR coa.no_sbb = jn.akun_kredit
            WHERE 
                jn.id_cabang = '$kode_cabang' AND 
                coa.id_cabang = '$kode_cabang' AND
                jn.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
                AND coa.table_source = '$table' AND coa.posisi = '$posisi'
            GROUP BY 
                coa.no_sbb
            ORDER BY 
                coa.no_sbb ASC
        ");
        }

        // echo '<pre>';
        // print_r($query->result());
        // echo '</pre>';
        // exit;

        return $query->result();
    }
}
