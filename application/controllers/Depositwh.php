<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Depositwh extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->library(['session', 'pagination']);
		$this->load->helper(['string', 'url', 'date', 'number']);
		$this->load->model(['M_depositwh', 'm_coa', 'm_invoice',]);

		$this->cb = $this->load->database('corebank', TRUE);
		// $this->load->helper('terbilang');

		if (!$this->session->userdata('nip')) {
			redirect('login');
		}
	}
	function convertToNumber($formattedNumber)
	{
		// Mengganti titik sebagai pemisah ribuan dengan string kosong
		$numberWithoutThousandsSeparator = str_replace('.', '', $formattedNumber);

		// Mengganti koma sebagai pemisah desimal dengan titik
		$standardNumber = str_replace(',', '.', $numberWithoutThousandsSeparator);

		// Mengonversi string ke float
		return (float) $standardNumber;
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

	private function posting($coa_debit, $coa_kredit, $keterangan, $nominal, $tanggal, $id_invoice = NULL)
	{
		// Update coa debit 
		$this->update_saldo_coa($coa_debit, $nominal, 'debit');
		// Update coa kredit
		$this->update_saldo_coa($coa_kredit, $nominal, 'kredit');

		// Ambil saldo debit
		$saldo_debit = $this->get_saldo_coa($coa_debit);
		// Ambil saldo kredit
		$saldo_kredit = $this->get_saldo_coa($coa_kredit);

		$dt_jurnal = [
			'tanggal' => $tanggal,
			'akun_debit' => $coa_debit,
			'jumlah_debit' => $nominal,
			'akun_kredit' => $coa_kredit,
			'jumlah_kredit' => $nominal,
			'saldo_debit' => $saldo_debit,
			'saldo_kredit' => $saldo_kredit,
			'keterangan' => $keterangan,
			'created_by' => $this->session->userdata('nip'),
			'id_invoice' => ($id_invoice) ? $id_invoice : '',
			'id_cabang' => $this->session->userdata('kode_cabang')
		];

		$this->m_coa->addJurnal($dt_jurnal);

		$data_transaksi = [
			'user_id' => $this->session->userdata('nip'),
			'tgl_trs' => date('Y-m-d H:i:s'),
			'nominal' => $nominal,
			'debet' => $coa_debit,
			'kredit' => $coa_kredit,
			'keterangan' => trim($keterangan),
			'id_cabang' => $this->session->userdata('kode_cabang')
		];

		$this->m_coa->add_transaksi($data_transaksi);
	}

	private function update_saldo_coa($akun_no, $jumlah, $tipe)
	{
		$substr_coa = substr($akun_no, 0, 1);
		if ($substr_coa == "1" || $substr_coa == "2" || $substr_coa == "3") {
			$table = "t_coa_sbb";
			$kolom = "no_sbb";
		} else if ($substr_coa == "4" || $substr_coa == "5" || $substr_coa == "6" || $substr_coa == "7" || $substr_coa == "8" || $substr_coa == "9") {
			$table = "t_coalr_sbb";
			$kolom = "no_lr_sbb";
		}

		$query = $this->cb->query(
			"SELECT posisi, nominal FROM $table WHERE " . $kolom . " = ? AND id_cabang = " . $this->session->userdata('kode_cabang') . " FOR UPDATE",
			[$akun_no]
		);

		$row = $query->row();
		if (!$row) return;

		$posisi = $row->posisi;
		$nominal = $row->nominal;

		if ($posisi == 'AKTIVA') {
			if ($tipe == 'debit') {
				$nominal += $jumlah;
			} else { // kredit
				$nominal -= $jumlah;
			}
		} elseif ($posisi == 'PASIVA') {
			if ($tipe == 'debit') {
				$nominal -= $jumlah;
			} else { // kredit
				$nominal += $jumlah;
			}
		}

		// Update saldo
		$this->cb->where(($table == 't_coa_sbb') ? 'no_sbb' : 'no_lr_sbb', $akun_no);
		$this->cb->where('id_cabang', $this->session->userdata('kode_cabang'));
		$this->cb->update($table, ['nominal' => $nominal]);
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

	public function get_agent_deposit()
	{
		$search = $this->input->post('search');

		$this->cb->select('*');
		$this->cb->from('all_agent_deposit');

		if ($search) {
			$this->cb->like('nama', $search);
			$this->cb->or_like('kode', $search);
		}

		$query = $this->cb->get();
		$data  = $query->result();

		echo json_encode($data);
	}

	// DAFTAR DEPOSIT
	public function daftar_deposit()
	{
		$nip = $this->session->userdata('nip');
		$sql = "SELECT COUNT(Id) FROM memo WHERE (nip_kpd LIKE '%$nip%' OR nip_cc LIKE '%$nip%') AND (`read` NOT LIKE '%$nip%');";
		$query = $this->db->query($sql);
		$res2 = $query->result_array();
		$result = $res2[0]['COUNT(Id)'];

		$sql2 = "SELECT COUNT(id) FROM task WHERE (`member` LIKE '%$nip%' or `pic` like '%$nip%') and activity='1'";
		$query2 = $this->db->query($sql2);
		$res2 = $query2->result_array();
		$result2 = $res2[0]['COUNT(id)'];

		$data['count_inbox'] = $result;
		$data['count_inbox2'] = $result2;

		// Ambil data COA pertama
		$coa_kas_1_arr = $this->m_coa->getCoaByCode('210');

		// Ambil data COA kedua
		$coa_12002 = $this->m_coa->getCoaByCode('12002');
		$coa_12001 = $this->m_coa->getCoaByCode('12001');

		$merged_coa_arr = array_merge($coa_12002, $coa_12001);


		$data['coa_2'] = $coa_kas_1_arr;
		$data['coa_1'] = $merged_coa_arr;

		$data['title'] = "Daftar Deposit";

		$this->load->view('all_daftar_deposit', $data);
	}

	public function getData_deposit()
	{
		$results = $this->M_depositwh->get_datatables_deposit();
		$data    = [];

		$no = 0;
		foreach ($results as $r) {


			$data[] = [
				$r->uid,
				$r->kode,
				$r->nama,
				$r->telepon,
				'Rp. ' . number_format((float)($r->saldo ?? 0), 2, ',', '.'),
				$r->status_limit ?? '-',
			];
		}

		$output = [
			'draw'            => intval($_POST['draw'] ?? 0),
			'recordsTotal'    => $this->M_depositwh->count_all_deposit(),
			'recordsFiltered' => $this->M_depositwh->count_filtered_deposit(),
			'data'            => $data,
		];

		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($output));
	}

	public function get_detail_topup_dt()
	{
		$agent_uid = $this->input->post('agent_uid');
		$termasuk_usage = $this->input->post('termasuk_usage');

		// Tangkap parameter DataTables
		$search = $_POST['search']['value'] ?? '';
		$limit  = intval($_POST['length'] ?? 10);
		$start  = intval($_POST['start'] ?? 0);

		// 1. Ambil data mentah urut dari transaksi terlama (ASC)
		$raw_list = $this->M_depositwh->get_riwayat_topup_raw($agent_uid, $termasuk_usage, $search);

		$calculated_data = array();
		$running_saldo = 0; // Wadah sisa saldo berjalan

		// 2. Hitung matematika Running Total Saldo
		foreach ($raw_list as $r) {
			// Rumus: Saldo Sebelumnya + Topup Sekarang - Usage Sekarang
			$running_saldo = $running_saldo + (float)$r->topup_saldo - (float)$r->usage_saldo;

			if (!empty($r->kode)) {
				$display_kode = '<b>' . $r->kode . '</b>';
				$no_invoice = '';
				$users = $this->db->where('nip', $r->user_topup)->get('users')->row();
				$nama_kasir = $users ? $users->nama : '';
			} else {
				$display_kode = '<span class="text-danger"><i class="fa fa-arrow-circle-down"></i> Penggunaan Saldo</span>';
				$invoice_detail = $this->cb->where('uid', $r->billing_uid)->get($r->asal_table)->row();
				$no_invoice = $invoice_detail->no_invoice;
				$users = $this->db->where('nip', $r->user_kasir)->get('users')->row();
				$nama_kasir = $users ? $users->nama : '';
			}


			// Simpan data beserta hasil perhitungan saldo buatan kita sendiri
			$calculated_data[] = array(
				date('d/m/Y H:i', strtotime($r->post_date)),
				$display_kode,
				$no_invoice,
				$r->topup_saldo > 0 ? 'Rp ' . number_format($r->topup_saldo, 0, ',', '.') : '-',
				$r->usage_saldo > 0 ? 'Rp ' . number_format($r->usage_saldo, 0, ',', '.') : '-',
				'<b>Rp ' . number_format($running_saldo, 0, ',', '.') . '</b>', // Menggunakan running_saldo dinamis
				$nama_kasir
			);
		}

		// 3. Balik urutan data agar data TERBARU berada di paling atas (DESC)
		$reversed_data = array_reverse($calculated_data);

		// 4. Lakukan pemotongan data (Slice array) sesuai limit & offset pagination DataTables
		$total_filtered = count($reversed_data);
		$paged_data = array_slice($reversed_data, $start, $limit);

		// Hitung total murni tanpa filter search
		$total_records = $this->M_depositwh->count_all_riwayat($agent_uid, $termasuk_usage);

		// Output JSON standar DataTables
		$output = array(
			"draw"            => intval($_POST['draw'] ?? 1),
			"recordsTotal"    => intval($total_records),
			"recordsFiltered" => intval($total_filtered),
			"data"            => $paged_data,
		);

		echo json_encode($output);
	}

	public function get_coa_by_agent()
	{
		$uid = $this->input->post('uid');
		// Sesuaikan query dengan struktur database Anda
		$data = $this->cb->get_where('all_agent_deposit', ['uid' => $uid])->row();

		echo json_encode(['coa_sbb' => $data->coa_sbb]);
	}

	public function store_deposit()
	{
		// 1. Ambil data dari POST input form
		$agent_uid       = $this->input->post('nama_agent'); // Di form select name="nama_agent" nilainya adalah UID
		$tanggal_deposit = $this->input->post('tanggal_deposit');
		$nominal_topup   = $this->input->post('nominal_topup');

		// Ambil data session yang dibutuhkan
		$login_branch    = $this->session->userdata('branch_code'); // Sesuaikan nama session Anda
		$now_uid         = $this->session->userdata('nip');         // Sesuaikan nama session Anda

		// 2. Format waktu untuk post_date (YmdHis)
		$post_dates      = date("YmdHis");

		// Validasi jika agent dipilih
		if (!empty($agent_uid)) {

			// 3. GENERATE KODE OTOMATIS (Menggantikan SELECT MAX)
			$this->cb->select_max('kode');
			$query_no = $this->cb->get('all_topup')->row_array();
			$no_mydisburse = isset($query_no['kode']) ? (int)$query_no['kode'] : 0;

			if ($no_mydisburse > 0) {
				$disburse = $no_mydisburse + 1;
				$kode = sprintf("%06d", $disburse);
			} else {
				$kode = "000001";
			}

			// Clean nominal (menghilangkan koma jika input bertipe string berformat uang)
			$topup_amount1 = (float)str_replace(",", "", $nominal_topup);

			// 4. CEK SALDO AGENT SAAT INI (Subquery Sum)
			$this->cb->select('SUM(topup_saldo) as total_saldo, SUM(usage_saldo) as total_pemakaian');
			$this->cb->where('agent_uid', $agent_uid);
			$row = $this->cb->get('all_topup')->row_array();

			$total_saldo     = isset($row['total_saldo']) ? (float)$row['total_saldo'] : 0;
			$total_pemakaian = isset($row['total_pemakaian']) ? (float)$row['total_pemakaian'] : 0;

			// Hitung akumulasi saldo baru setelah ditambah topup sekarang
			$cek = $total_saldo - $total_pemakaian + $topup_amount1;

			// 5. TENTUKAN STATUS SALDO (Jika > 5.000.000 status menjadi 1, jika tidak 0)
			$status_saldo = ($cek > 5000000) ? '1' : '0';

			// 6. PREPARE DATA UNTUK INSERT
			$data_insert = [
				'kode'         => $kode,
				'agent_uid'    => $agent_uid,
				'topup_date'   => $tanggal_deposit,
				'topup_saldo'  => $topup_amount1,
				'saldo'        => $cek,
				'status_saldo' => $status_saldo,
				'branch_code'  => $login_branch,
				'user_topup'   => $now_uid,
				'post_date'    => $post_dates
			];

			// Jalankan Query Insert
			$insert = $this->cb->insert('all_topup', $data_insert);
			if ($insert) {
				$id_user = $this->session->userdata('nip');
				// $keterangan = $this->input->post('keterangan');
				$ag = $this->cb->select('nama')->where('uid', $agent_uid)->get('all_agent_deposit')->row();
				$nama_agent = $ag->nama ?? '';
				$keterangan = "Topup Deposit Agent UID: $nama_agent, Nominal: Rp. " . number_format($topup_amount1, 0, ',', '.');
				$nominal = $this->convertToNumberWithComma($this->input->post('nominal_topup'));
				$coa_debit = $this->input->post('coa_debit');
				$coa_kredit = $this->input->post('coa_kredit');

				// Pastikan fungsi posting tidak mengganggu transaksi
				$this->posting($coa_debit, $coa_kredit, $keterangan, $nominal, $tanggal_deposit, '');

				$this->cb->trans_commit();
				$this->session->set_flashdata('message_name', 'Deposit Berhasil, Jurnal Berhasil di buat.');
				redirect("depositwh/daftar_deposit");
			}
			// if ($insert) {
			// 	// Set notifikasi sukses menggunakan Flashdata (Sesuai dengan library sweetalert di view Anda)
			// 	$this->session->set_flashdata('message_name', 'Data Deposit Berhasil Disimpan.');
			// } else {
			// 	$this->session->set_flashdata('message_error', 'Gagal menyimpan data deposit.');
			// }

			// Redirect kembali ke halaman daftar deposit
			// redirect('depositwh/daftar_deposit');
		} else {
			$this->session->set_flashdata('message_error', 'Silahkan pilih Agent terlebih dahulu.');
			redirect('depositwh/daftar_deposit');
		}
	}

	public function rekap_deposit()
	{
		$dari         = $this->input->post('dari');
		$sampai       = $this->input->post('sampai');
		$agent_uid    = $this->input->post('agent_deposit');
		$asal_table   = $this->input->post('asal_table');

		$start_date = str_replace('-', '', $dari)   . '000000';
		$end_date   = str_replace('-', '', $sampai) . '235959';

		// echo ($start_date . ' - ' . $end_date);
		// exit();
		// Query topup dengan subquery untuk sisa saldo
		$sql = "SELECT 
    t.uid, t.kode, t.topup_date, t.topup_saldo,
    IFNULL(
        (SELECT SUM(t1.topup_saldo) - SUM(t1.usage_saldo) 
         FROM all_topup t1 
         WHERE t1.uid <= t.uid AND t1.agent_uid = t.agent_uid), 
        0
    ) as sisa_saldo,
    t.billing_uid, t.agent_uid, t.asal_table,
    IFNULL(
        CASE t.asal_table
            WHEN 'out_billing' THEN (SELECT b.no_invoice       FROM out_billing b WHERE b.uid = t.billing_uid)
            WHEN 'in_billing'  THEN (SELECT b.no_invoice       FROM in_billing  b WHERE b.uid = t.billing_uid)
            WHEN 'out_billing_inv_khusus'  THEN (SELECT b.no_invoice       FROM out_billing_inv_khusus  b WHERE b.uid = t.billing_uid)
        END,
    '') as no_invoice,
    IFNULL(
        CASE t.asal_table
            WHEN 'out_billing' THEN (SELECT b.tanggal_invoice  FROM out_billing b WHERE b.uid = t.billing_uid)
            WHEN 'in_billing'  THEN (SELECT b.tanggal_invoice  FROM in_billing  b WHERE b.uid = t.billing_uid)
            WHEN 'out_billing_inv_khusus'  THEN (SELECT b.tanggal_invoice  FROM out_billing_inv_khusus  b WHERE b.uid = t.billing_uid)
        END,
    '') as tanggal_invoice,
    IFNULL(
        CASE t.asal_table
            WHEN 'out_billing' THEN (SELECT b.nama             FROM out_billing b WHERE b.uid = t.billing_uid)
            WHEN 'in_billing'  THEN (SELECT b.nama             FROM in_billing  b WHERE b.uid = t.billing_uid)
            WHEN 'out_billing_inv_khusus'  THEN (SELECT b.nama             FROM out_billing_inv_khusus  b WHERE b.uid = t.billing_uid)
        END,
    '') as nama_pengirim,
    IFNULL(
        CASE t.asal_table
            WHEN 'out_billing' THEN (SELECT b.total_chargeable FROM out_billing b WHERE b.uid = t.billing_uid)
            WHEN 'in_billing'  THEN (SELECT b.total_chargeable FROM in_billing  b WHERE b.uid = t.billing_uid)
            WHEN 'out_billing_inv_khusus'  THEN (SELECT b.total_chargeable FROM out_billing_inv_khusus  b WHERE b.uid = t.billing_uid)
        END,
    '') as total_chargeable,
    IFNULL(
        CASE t.asal_table
            WHEN 'out_billing' THEN (SELECT b.total            FROM out_billing b WHERE b.uid = t.billing_uid)
            WHEN 'in_billing'  THEN (SELECT b.total            FROM in_billing  b WHERE b.uid = t.billing_uid)
            WHEN 'out_billing_inv_khusus'  THEN (SELECT b.total            FROM out_billing_inv_khusus  b WHERE b.uid = t.billing_uid)
        END,
    '') as grand_total,
    IFNULL(
        CASE t.asal_table
            WHEN 'out_billing' THEN (SELECT b.pay_methode      FROM out_billing b WHERE b.uid = t.billing_uid)
            WHEN 'in_billing'  THEN (SELECT b.pay_methode      FROM in_billing  b WHERE b.uid = t.billing_uid)
            WHEN 'out_billing_inv_khusus'  THEN (SELECT b.pay_methode      FROM out_billing_inv_khusus  b WHERE b.uid = t.billing_uid)
        END,
    '') as pay_methode,
    IFNULL(
        CASE t.asal_table
            WHEN 'out_billing' THEN (SELECT b.user_kasir       FROM out_billing b WHERE b.uid = t.billing_uid)
            WHEN 'in_billing'  THEN (SELECT b.user_kasir       FROM in_billing  b WHERE b.uid = t.billing_uid)
            WHEN 'out_billing_inv_khusus'  THEN (SELECT b.user_kasir       FROM out_billing_inv_khusus  b WHERE b.uid = t.billing_uid)
        END,
    '') as user_kasir
    FROM all_topup t
    WHERE t.post_date BETWEEN '$start_date' AND '$end_date'
";

		if ($agent_uid) {
			$sql .= " AND t.agent_uid = '$agent_uid'";
		}
		$sql .= " ORDER BY t.uid, no_invoice, tanggal_invoice ASC";

		$results = $this->cb->query($sql)->result_array();

		// Nama agent
		$nama_agent = '';
		if ($agent_uid) {
			$ag = $this->cb->select('nama')->where('uid', $agent_uid)->get('all_agent_deposit')->row();
			$nama_agent = $ag->nama ?? '';
		}

		// Load PhpSpreadsheet
		require APPPATH . 'third_party/autoload.php';

		// Include PhpSpreadsheet from third_party
		require APPPATH . 'third_party/psr/simple-cache/src/CacheInterface.php';

		$spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
		$sheet       = $spreadsheet->getActiveSheet();
		$sheet->setTitle('Rekap Deposit Outgoing');

		$center = \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER;
		$right  = \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT;
		$left   = \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT;

		// Header baris 1 - nama agent
		$sheet->mergeCells('A1:O1');
		$sheet->getStyle('A1')->getFont()->setBold(true)->setSize(12);
		$sheet->getStyle('A1')->getAlignment()->setHorizontal($center);
		$sheet->setCellValue('A1', $nama_agent ?: 'REKAP DEPOSIT OUTGOING');

		// Header baris 2-3
		$merges2 = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'N', 'O'];
		foreach ($merges2 as $col) {
			$sheet->mergeCells($col . '2:' . $col . '3');
		}
		$sheet->mergeCells('K2:M2');

		$headers2 = [
			'A' => 'No',
			'B' => 'No Invoice',
			'C' => 'Tanggal',
			'D' => 'AGENT',
			'E' => 'No',
			'F' => 'SMU',
			'G' => 'Asal',
			'H' => 'Koli',
			'I' => 'Berat',
			'J' => 'Total Ch.W',
			'K' => 'Nominal',
			'N' => 'Pembayaran',
			'O' => 'Kasir On Duty',
		];
		foreach ($headers2 as $col => $label) {
			$sheet->getStyle($col . '2')->getAlignment()->setHorizontal($center);
			$sheet->setCellValue($col . '2', $label);
		}

		$headers3 = ['K' => 'Total Invoice', 'L' => 'Topup', 'M' => 'Sisa Topup'];
		foreach ($headers3 as $col => $label) {
			$sheet->getStyle($col . '3')->getAlignment()->setHorizontal($center);
			$sheet->setCellValue($col . '3', $label);
		}

		$sheet->getStyle('A2:O3')->getFont()->setBold(true);

		$rowNum = 4;
		$nomor  = 1;

		foreach ($results as $r) {
			$t_billing_uid    = $r['billing_uid'];
			$topup_saldo      = $r['topup_saldo'];
			$sisa_saldo       = $r['sisa_saldo'];
			$t_agent_uid      = $r['agent_uid'];
			$asal_table       = $r['asal_table'];

			// Cek apakah ini row topup (tanpa billing)
			if (empty($t_billing_uid)) {
				// Row topup saldo murni
				$sheet->mergeCells('A' . $rowNum . ':K' . $rowNum);
				$sheet->getStyle('A' . $rowNum)->getAlignment()->setHorizontal($center);
				$sheet->setCellValue('A' . $rowNum, 'Topup Deposit');
				$sheet->getStyle('L' . $rowNum)->getAlignment()->setHorizontal($right);
				$sheet->setCellValue('L' . $rowNum, $topup_saldo);
				$sheet->getStyle('M' . $rowNum)->getAlignment()->setHorizontal($right);
				$sheet->setCellValue('M' . $rowNum, $sisa_saldo);
				$rowNum++;
				continue;
			}

			// Ambil data billing
			$billing = $this->cb->select('uid, no_invoice, tanggal_invoice, nama, grand_total, pay_methode, user_kasir')
				// ->where('status', '1')
				->where('uid', $t_billing_uid)
				// ->get('out_billing')->row();
				->get($asal_table)->row();

			if (!$billing) {
				$rowNum++;
				continue;
			}

			// Nama kasir
			$kasir = $this->db->select('nama')->where('nip', $billing->user_kasir)->get('users')->row();
			$kasir_name = $kasir->nama ?? '';

			// Jaster & nama agent dari out_list
			if ($asal_table === 'out_billing') {
				$jaster_row = $this->cb->select('a.uid, a.jaster, b.nama as nama_agen', FALSE)
					->from('out_list a')
					->join('out_agent b', 'b.uid = a.agent_uid', 'left')
					->where('a.bill_uid', $billing->uid)
					->get()->row();
				$nama_agen_list = $jaster_row->nama_agen ?? $billing->nama_agent;
			} else {
				// Jika bukan dari out_billing, gunakan nama agent dari billing
				$ag = $this->cb->select('nama')->where('uid', $t_agent_uid)->get('all_agent_deposit')->row();
				$nama_agen_list = $ag->nama ?? '';
			}
			// $jaster_row = $this->cb->select('a.uid, a.jaster, b.nama as nama_agen', FALSE)
			// 	->from('out_list a')
			// 	->join('all_agent b', 'b.uid = a.agent_uid', 'left')
			// 	->where('a.bill_uid', $billing->uid)
			// 	->get()->row();
			// $nama_agen_list = $jaster_row->nama_agen ?? $billing->nama_agent;

			// Format tanggal
			$tgl = $billing->tanggal_invoice;
			$tgl_txt = $tgl ? date('j F Y', strtotime(
				substr($tgl, 0, 4) . '-' . substr($tgl, 4, 2) . '-' . substr($tgl, 6, 2)
			)) : '';

			if ($asal_table === 'out_billing') {
				$list_smu = $this->cb->select('uid, smu, tujuan, jumlah, gross, chargeable')
					->where('bill_uid', $billing->uid)
					->where('out_p', '1')
					->order_by('uid', 'ASC')
					->get('out_list')->result_array();
			} else if ($asal_table === 'out_billing_inv_khusus') {
				$list_smu = $this->cb->select('uid, smu, tujuan, jumlah, gross, chargeable')
					->where('bill_khusus_uid', $billing->uid)
					->where('out_p', '1')
					->order_by('uid', 'ASC')
					->get('out_list')->result_array();
			} else {
				$list_smu = $this->cb->select('uid, smu, asal as tujuan, jumlah, gross, chargeable')
					->where('bill_uid', $billing->uid)
					->where('out_p', '1')
					->order_by('uid', 'ASC')
					->get('in_list')->result_array();
			}
			// List SMU


			$startRow = $rowNum;
			$no_smu   = 1;

			foreach ($list_smu as $s) {
				$sheet->getStyle('E' . $rowNum)->getAlignment()->setHorizontal($center);
				$sheet->setCellValue('E' . $rowNum, $no_smu);
				$sheet->setCellValue('F' . $rowNum, $s['smu']);
				$sheet->setCellValue('G' . $rowNum, $s['tujuan']);
				$sheet->setCellValue('H' . $rowNum, $s['jumlah']);
				$sheet->setCellValue('I' . $rowNum, $s['gross']);
				$sheet->setCellValue('J' . $rowNum, $s['chargeable']);
				$rowNum++;
				$no_smu++;
			}

			$endRow = $rowNum - 1;

			// Merge jika lebih dari 1 SMU
			if ($endRow > $startRow) {
				foreach (['A', 'B', 'C', 'D'] as $col) {
					$sheet->mergeCells($col . $startRow . ':' . $col . $endRow);
				}
			}

			// Set nilai billing
			$sheet->getStyle('A' . $startRow)->getAlignment()->setHorizontal($center);
			$sheet->setCellValue('A' . $startRow, $nomor);
			$sheet->getStyle('B' . $startRow)->getAlignment()->setHorizontal($left);
			$sheet->setCellValue('B' . $startRow, $billing->no_invoice);
			$sheet->getStyle('C' . $startRow)->getAlignment()->setHorizontal($left);
			$sheet->setCellValue('C' . $startRow, $tgl_txt);
			$sheet->getStyle('D' . $startRow)->getAlignment()->setHorizontal($left);
			$sheet->setCellValue('D' . $startRow, $nama_agen_list);
			$sheet->getStyle('K' . $startRow)->getAlignment()->setHorizontal($right);
			$sheet->setCellValue('K' . $startRow, $billing->grand_total);
			$sheet->getStyle('M' . $startRow)->getAlignment()->setHorizontal($right);
			$sheet->setCellValue('M' . $startRow, $sisa_saldo);
			$sheet->getStyle('N' . $startRow)->getAlignment()->setHorizontal($left);
			$sheet->setCellValue('N' . $startRow, 'Deposit');
			$sheet->getStyle('O' . $startRow)->getAlignment()->setHorizontal($left);
			$sheet->setCellValue('O' . $startRow, $kasir_name);

			$nomor++;
		}

		// Autosize
		foreach (range('A', 'O') as $col) {
			$sheet->getColumnDimension($col)->setAutoSize(true);
		}

		// Download
		require APPPATH . 'third_party/autoload_zip.php';
		$filename = 'rekap_deposit_outgoing_' . date('d-m-Y') . '.xlsx';

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="' . $filename . '"');
		header('Cache-Control: max-age=0');

		$writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
		$writer->save('php://output');
		exit();
	}

	// DAFTAR AGENTS DEPOSIT
	public function daftar_agents_deposit()
	{
		$nip = $this->session->userdata('nip');
		$sql = "SELECT COUNT(Id) FROM memo WHERE (nip_kpd LIKE '%$nip%' OR nip_cc LIKE '%$nip%') AND (`read` NOT LIKE '%$nip%');";
		$query = $this->db->query($sql);
		$res2 = $query->result_array();
		$result = $res2[0]['COUNT(Id)'];

		$sql2 = "SELECT COUNT(id) FROM task WHERE (`member` LIKE '%$nip%' or `pic` like '%$nip%') and activity='1'";
		$query2 = $this->db->query($sql2);
		$res2 = $query2->result_array();
		$result2 = $res2[0]['COUNT(id)'];

		$data['count_inbox'] = $result;
		$data['count_inbox2'] = $result2;

		$data['title'] = "Daftar Agents Deposit";

		$this->load->view('all_daftar_agents_deposit', $data);
	}

	public function get_coa()
	{
		$search = $this->input->post('search');

		$this->cb->select('*');
		$this->cb->from('t_coa_sbb');
		$this->cb->like('no_sbb', '210');
		if ($search) {
			$this->cb->like('nama_perkiraan', $search);
			// $this->cb->or_like('nip', $search);
		}

		$query = $this->cb->get();
		$data  = $query->result();

		echo json_encode($data);
	}

	public function getData_agents_deposit()
	{
		$results = $this->M_depositwh->get_datatables_agents_deposit();
		$data    = [];

		$no = 0;
		foreach ($results as $r) {


			// Dates
			$wday1 = substr($r->post_date, 0, 4);
			$wday2 = substr($r->post_date, 4, 2);
			$wday3 = substr($r->post_date, 6, 2);
			$wday4 = substr($r->post_date, 8, 2);
			$wday5 = substr($r->post_date, 10, 2);
			$wday6 = substr($r->post_date, 12, 2);
			$time2 = "$wday4" . ":" . "$wday5";
			if ($r->post_date != "") {
				$tanggal_txt = "$wday3" . "-" . "$wday2" . "-" . "$wday1" . " " . "$time2";
			} else {
				$tanggal_txt = "";
			}


			if ($r->hold == '1') {
				$hold = "<span class='btn btn-sm' style='color:#d9534f; border:1px solid #d9534f; background:transparent;'>Hold</span> ";

				$button_hold = "<a class='btn btn-sm btn-success' href='" . base_url() . "depositwh/agent_deposit_hold/{$r->uid}/0'>
        <i class='fa fa-check'></i> Ready</a>";
			} else {
				$hold = "<span class='btn btn-sm' style='color:#5cb85c; border:1px solid #5cb85c; background:transparent;'>Ready</span> ";
				$button_hold = "<a class='btn btn-sm btn-danger' href='" . base_url() . "depositwh/agent_deposit_hold/{$r->uid}/1'>
        <i class='fa fa-remove'></i> Hold</a>";
			}

			$button_edit = "<a class='btn btn-sm btn-warning btn-edit' data-uid='{$r->uid}'>
        <i class='fa fa-pencil'></i> Edit</a>";

			$button = $button_hold . ' ' . $button_edit;



			$data[] = [
				// $r->uid,
				$r->kode,
				$r->nama,
				$r->alamat,
				$r->telepon,
				$r->coa_sbb . ' - ' . $r->nama_perkiraan,
				// $r->npwp ?? '-',
				$r->user_name ?? '-',
				$tanggal_txt ?? '-',
				$hold ?? '-',
				$button,
			];
		}

		$output = [
			'draw'            => intval($_POST['draw'] ?? 0),
			'recordsTotal'    => $this->M_depositwh->count_all_agents_deposit(),
			'recordsFiltered' => $this->M_depositwh->count_filtered_agents_deposit(),
			'data'            => $data,
		];

		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($output));
	}

	public function edit_agent_deposit($uid)
	{
		$this->cb->select('a.*, u.nama as nama_pic, coa.nama_perkiraan');
		$this->cb->from('all_agent_deposit a');
		$this->cb->join($this->db->database . '.users u',      'u.nip = a.user_pic',    'left');
		$this->cb->join('t_coa_sbb coa', 'coa.no_sbb = a.coa_sbb', 'left');
		$this->cb->where('uid', $uid);

		$row = $this->cb->get()->row();

		if (!$row) {
			echo json_encode(['status' => 'error', 'message' => 'Data tidak ditemukan.']);
			return;
		}

		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($row));
	}

	public function store_agent_deposit()
	{
		// $kode = $this->input->post('kode_agent');
		$nama = $this->input->post('nama_agent');
		$alamat = $this->input->post('alamat_agent');
		$telepon = $this->input->post('telepon_agent');
		$coa_agent = $this->input->post('coa_agent');

		$data = [
			// 'kode'                          => $kode,
			'nama'                          => $nama,
			'alamat'                        => $alamat,
			'telepon'                       => $telepon,
			'coa_sbb' 							=> $coa_agent,
			// 'npwp'                          => $npwp,
			// 'post_date'                     => $post_dates,
			// 'user'                          => $this->session->userdata('nip'),
		];

		$uid = $this->input->post('uid'); // untuk edit

		if ($uid) {
			$this->M_depositwh->update_agent_deposit($data, $uid);
			$this->session->set_flashdata('message_name', 'Agent berhasil diupdate.');
		} else {
			$signdate = time();
			$post_date1 = date("Ymd", $signdate);
			$post_date2 = date("His", $signdate);
			$post_dates = "$post_date1" . "$post_date2";

			$all_agent = $this->cb->select('MAX(CAST(kode AS UNSIGNED)) as kode')->from('all_agent_deposit')->get()->row();

			$no_mydisburse1 = $all_agent->kode;

			if ($no_mydisburse1 > 0) {
				$disburse1 = $no_mydisburse1 + 1;
				$nodis1 = sprintf("%06d", $disburse1);
				$no = $nodis1;
			} else {
				$no = "000001";
			}

			$data['user']  = $this->session->userdata('nip');
			$data['post_date'] = $post_dates;
			$data['kode'] = $no;

			$this->M_depositwh->insert_agent_deposit($data);
			$this->session->set_flashdata('message_name', 'Agent berhasil ditambahkan.');
		}

		redirect('depositwh/daftar_agents_deposit');
	}

	public function agent_deposit_hold($uid, $hold)
	{

		$data = [
			// 'kode'                          => $kode,
			'hold'                          => $hold,
			// 'npwp'                          => $npwp,
			// 'post_date'                     => $post_dates,
			// 'user'                          => $this->session->userdata('nip'),
		];


		$this->M_depositwh->update_agent_deposit($data, $uid);

		if ($hold == '1') {
			$this->session->set_flashdata('message_name', 'Agent berhasil di Hold.');
		} else {
			$this->session->set_flashdata('message_name', 'Agent Ready.');
		}
		redirect('depositwh/daftar_agents_deposit');
	}
}
