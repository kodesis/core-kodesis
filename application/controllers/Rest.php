<?php

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class Rest extends REST_Controller
{

    function __construct($config = 'rest')
    {
        parent::__construct($config);
        $this->load->database();
        $this->load->model(['M_login', 'm_invoice']);
        $this->load->helper(['url', 'form', 'json_output', 'date', 'number']);
        $this->cb = $this->load->database('corebank', TRUE);
    }

    //Menampilkan data kontak
    // function index_get() {
    // $id = $this->get('id');
    // if ($id == '') {
    // $kontak = $this->db->get('telepon')->result();
    // } else {
    // $this->db->where('id', $id);
    // $kontak = $this->db->get('telepon')->result();
    // }
    // $this->response($kontak, 200);
    // }

    public function index_get($id = 0)
    {
        if (!empty($id)) {
            $data = $this->db->get_where("telepon", ['id' => $id])->row_array();
        } else {
            $data = $this->db->get("telepon")->result();
        }

        $this->response($data, REST_Controller::HTTP_OK);
    }

    public function index_post()
    {
        $input = $this->input->post();
        $this->db->insert('items', $input);

        $this->response(['Item created successfully.'], REST_Controller::HTTP_OK);
    }

    public function index_put($id)
    {
        $input = $this->put();
        $this->db->update('items', $input, array('id' => $id));

        $this->response(['Item updated successfully.'], REST_Controller::HTTP_OK);
    }

    public function index_delete($id)
    {
        $this->db->delete('items', array('id' => $id));

        $this->response(['Item deleted successfully.'], REST_Controller::HTTP_OK);
    }

    public function testing_post()
    {
        if ($this->input->method(true) !== 'POST') {
            return json_output(400, ['status' => 400, 'message' => 'Bad request']);
        }

        $params = json_decode(file_get_contents('php://input'), true);

        if (empty($params)) {
            return $this->response([
                'status' => 400,
                'message' => 'No data received'
            ], 400);
        }

        return $this->response([
            'status' => 200,
            'message' => 'Data received successfully',
            'data' => $params
        ], 200);
    }
    //Masukan function selanjutnya disini

    public function invoice_post()
    {
        if ($this->input->method(true) !== 'POST') {
            return json_output(400, ['status' => 400, 'message' => 'Bad request']);
        }

        $params = json_decode(file_get_contents('php://input'), TRUE);
        // return json_output(200, ['status' => 400, 'data' => $params]);

        if (!$this->M_login->check_auth_client()) return;

        $response = $this->M_login->auth_api();
        // $response['status'] = 200;
        if ($response['status'] != 200) return;

        $params = json_decode(file_get_contents('php://input'), TRUE);
        if (empty($params['invoice_num'])) {
            return json_output(400, ['status' => 400, 'message' => 'Invoice num can\'t be empty']);
        }

        $jenis = $params['jenis_invoice'];
        $resp = $this->store_invoice($jenis, $params);
        return json_output($resp['status'], $resp);
    }

    public function store_invoice($jenis, $params)
    {
        $id_user = $params['nip'];
        $kode_cabang = $params['kode_cabang'];
        $akronim = $params['nama_akronim'];

        $diskon = $params['diskon'] ?? '0';
        $ppn = $params['ppn'] ?? '0';
        $nominal = $this->convertToNumberWithComma($params['nominal'] ?? '0');
        $besaran_diskon = $this->convertToNumberWithComma($params['besaran_diskon'] ?? '0');
        $besaran_ppn = $this->convertToNumberWithComma($params['besaran_ppn'] ?? '0');
        $besaran_pph = $this->convertToNumberWithComma($params['besaran_pph'] ?? '0');
        $nominal_bayar = $this->convertToNumberWithComma($params['nominal_bayar'] ?? '0');
        $total_nonpph = $this->convertToNumberWithComma($params['total_nonpph'] ?? '0');
        $total_denganpph = $this->convertToNumberWithComma($params['total_denganpph'] ?? '0');
        $nominal_pendapatan = $this->convertToNumberWithComma($params['nominal_pendapatan'] ?? '0');

        $tgl_invoice = $params['tgl_invoice'] ?? date('Y-m-d');
        $tahun = substr($tgl_invoice, 0, 4);
        $month = substr($tgl_invoice, 5, 2);
        $year = substr($tgl_invoice, 2, 2);

        $opsi_termin = $params['opsi_termin'] ?? '0';
        $opsi_pph = $params['opsi_pph'] ?? '0';
        $opsi_ppn = $params['opsi_ppn'] ?? '0';
        $coa_debit = $params['coa_debit'] ?? '';
        $coa_kredit = $params['coa_kredit'] ?? '';
        $pph = $opsi_pph ? '0.02' : 0;

        $max_num = $this->m_invoice->select_max($tahun);
        $bilangan = $max_num['max'] ? $max_num['max'] + 1 : 1;
        $no_inv = sprintf("%04d", $bilangan);
        $kode_cabang_fmt = sprintf("%02d", $kode_cabang);
        $kop_invoice = strtoupper($akronim) . "-" . $kode_cabang_fmt;
        $slug = $no_inv . '/' . $kop_invoice . '/' . intToRoman($month) . '/' . $year;
        $keterangan = trim($params['keterangan'] ?? '');

        $jenis_invoice = ($jenis == 'reguler') ? 'reguler' : 'khusus';

        $invoice_data = [
            'no_invoice' => $no_inv,
            'tanggal_invoice' => $tgl_invoice,
            'created_by' => $id_user,
            'keterangan' => $keterangan,
            'id_customer' => $params['customer'] ?? null,
            'subtotal' => $nominal,
            'diskon' => $diskon,
            'besaran_diskon' => $besaran_diskon,
            'ppn' => $ppn,
            'besaran_ppn' => $besaran_ppn,
            'opsi_pph23' => $opsi_pph,
            'opsi_ppn' => $opsi_ppn,
            'pph' => $pph,
            'besaran_pph' => $besaran_pph,
            'total_nonpph' => $total_nonpph,
            'total_denganpph' => $total_denganpph,
            'coa_debit' => $coa_debit,
            'coa_kredit' => $coa_kredit,
            'nominal_bayar' => $nominal_bayar,
            'nominal_pendapatan' => $nominal_pendapatan,
            'jenis_invoice' => $jenis_invoice,
            'opsi_termin' => $opsi_termin,
            'status_pendapatan' => '1',
            'slug' => $slug,
            'id_cabang' => $kode_cabang,
        ];

        $this->cb->trans_begin();
        $id_invoice = $this->m_invoice->insert($invoice_data);

        if (!$id_invoice) {
            $this->cb->trans_rollback();
            return ['status' => 500, 'message' => 'Gagal menyimpan invoice utama.'];
        }

        $items = $params['item'] ?? [];
        $jumlahs = $params['jumlah'] ?? [];
        $totals = $params['total'] ?? [];
        $total_amounts = $params['total_amount'] ?? [];

        if (!is_array($items) || count($items) === 0) {
            $this->cb->trans_rollback();
            return ['status' => 400, 'message' => 'Item invoice tidak boleh kosong.'];
        }

        $detail_data = [];

        foreach ($params['item'] as $key => $value) {
            $detail_data[] = [
                'id_invoice' => $id_invoice,
                'item' => strtoupper($key),
                'total' => $this->convertToNumberWithComma($value),
                'qty' => 1,
                'total_amount' => $this->convertToNumberWithComma($value),
                'created_by' => $id_user,
                'id_cabang' => $kode_cabang,
            ];
        }

        $insert = $this->m_invoice->insert_batch($detail_data);
        if (!$insert) {
            $this->cb->trans_rollback();
            return ['status' => 500, 'message' => 'Gagal menyimpan detail invoice.'];
        }

        // Proses posting jurnal
        $posting_result =  $this->posting($coa_debit, $coa_kredit, $keterangan, $total_denganpph, $tgl_invoice, $id_invoice);

        if ($posting_result['status'] !== 200) {
            $this->cb->trans_rollback();
            return $posting_result;
        }

        $this->cb->trans_commit();

        return [
            'status' => 200,
            'message' => 'Invoice berhasil dibuat',
            'invoice_id' => $id_invoice,
            'no_invoice' => $no_inv,
            'slug' => $slug
        ];
    }

    private function posting($coa_debit, $coa_kredit, $keterangan, $nominal, $tanggal, $id_invoice = null)
    {
        $nip = $this->session->userdata('nip');
        $kode_cabang = $this->session->userdata('kode_cabang');

        // Update saldo COA debit
        $update_debit = $this->update_saldo_coa($coa_debit, $nominal, 'debit');
        if (!$update_debit) {
            return ['status' => 500, 'message' => 'Gagal update saldo COA debit.'];
        }

        // Update saldo COA kredit
        $update_kredit = $this->update_saldo_coa($coa_kredit, $nominal, 'kredit');
        if (!$update_kredit) {
            return ['status' => 500, 'message' => 'Gagal update saldo COA kredit.'];
        }

        // Ambil saldo terbaru
        $saldo_debit = $this->get_saldo_coa($coa_debit);
        $saldo_kredit = $this->get_saldo_coa($coa_kredit);

        // Buat data jurnal
        $dt_jurnal = [
            'tanggal' => $tanggal,
            'akun_debit' => $coa_debit,
            'jumlah_debit' => $nominal,
            'akun_kredit' => $coa_kredit,
            'jumlah_kredit' => $nominal,
            'saldo_debit' => $saldo_debit,
            'saldo_kredit' => $saldo_kredit,
            'keterangan' => $keterangan,
            'created_by' => $nip,
            'id_invoice' => $id_invoice ?? '',
            'id_cabang' => $kode_cabang
        ];

        // Insert jurnal
        $insert_jurnal = $this->m_coa->addJurnal($dt_jurnal);
        if (!$insert_jurnal) {
            return ['status' => 500, 'message' => 'Gagal insert jurnal.'];
        }

        // Insert transaksi
        $data_transaksi = [
            'user_id' => $nip,
            'tgl_trs' => date('Y-m-d H:i:s'),
            'nominal' => $nominal,
            'debet' => $coa_debit,
            'kredit' => $coa_kredit,
            'keterangan' => trim($keterangan),
            'id_cabang' => $kode_cabang
        ];

        $insert_transaksi = $this->m_coa->add_transaksi($data_transaksi);
        if (!$insert_transaksi) {
            return ['status' => 500, 'message' => 'Gagal insert transaksi.'];
        }

        return ['status' => 200, 'message' => 'Posting jurnal berhasil.'];
    }

    function convertToNumberWithComma($formattedNumber)
    {
        // Mengganti titik sebagai pemisah ribuan dengan string kosong
        $numberWithoutThousandsSeparator = str_replace(',', '', $formattedNumber);

        // Mengganti koma sebagai pemisah desimal dengan titik
        // $standardNumber = str_replace(',', '.', $numberWithoutThousandsSeparator);
        $standardNumber = $numberWithoutThousandsSeparator;

        // Mengonversi string ke float
        return (float) $standardNumber;
    }

    private function update_saldo_coa($akun_no, $jumlah, $tipe)
    {
        $substr_coa = substr($akun_no, 0, 1);
        if (in_array($substr_coa, ['1', '2', '3'])) {
            $table = "t_coa_sbb";
            $kolom = "no_sbb";
        } else {
            $table = "t_coalr_sbb";
            $kolom = "no_lr_sbb";
        }

        $query = $this->cb->query(
            "SELECT posisi, nominal FROM $table WHERE $kolom = ? AND id_cabang = ? FOR UPDATE",
            [$akun_no, $this->session->userdata('kode_cabang')]
        );

        $row = $query->row();
        if (!$row) return false;

        $posisi = $row->posisi;
        $nominal = $row->nominal;

        if ($posisi == 'AKTIVA') {
            $nominal += ($tipe == 'debit') ? $jumlah : -$jumlah;
        } elseif ($posisi == 'PASIVA') {
            $nominal += ($tipe == 'kredit') ? $jumlah : -$jumlah;
        }

        $this->cb->where($kolom, $akun_no)
            ->where('id_cabang', $this->session->userdata('kode_cabang'));
        return $this->cb->update($table, ['nominal' => $nominal]);
    }

    private function get_saldo_coa($akun_no)
    {
        $substr_coa = substr($akun_no, 0, 1);
        if ($substr_coa == "1" || $substr_coa == "2" || $substr_coa == "3") {
            $table = "t_coa_sbb";
            $kolom = "no_sbb";
        } else if ($substr_coa == "4" || $substr_coa == "5" || $substr_coa == "6" || $substr_coa == "7" || $substr_coa == "8" || $substr_coa == "9") {
            $table = "t_coalr_sbb";
            $kolom = "no_lr_sbb";
        }

        $row = $this->cb->select('nominal')
            ->where($kolom, $akun_no)
            ->where('id_cabang', $this->session->userdata('kode_cabang'))
            ->get($table)
            ->row();

        return $row->nominal;
    }

    function json_output($status, $response)
    {
        $CI = &get_instance();
        $CI->output
            ->set_content_type('application/json')
            ->set_status_header($status)
            ->set_output(json_encode($response))
            ->_display();
        exit; // <== INI WAJIB
    }
}
