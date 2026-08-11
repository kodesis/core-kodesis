<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Incominghlp extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->library(['session', 'pagination']);
		$this->load->helper(['string', 'url', 'date', 'number']);
		$this->load->model(['M_incoming', 'm_coa', 'm_invoice',]);

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

	public function get_pesawat()
	{
		$search = $this->input->post('search');

		$this->cb->select('uid, nama, prefix, warna');
		$this->cb->from('in_pesawat');

		if ($search) {
			$this->cb->like('nama', $search);
			$this->cb->or_like('prefix', $search);
		}

		$query = $this->cb->get();
		$data  = $query->result();

		echo json_encode($data);
	}

	public function get_asal()
	{
		$search = $this->input->post('search');

		$this->cb->select('uid, kode, kode_kota, nama');
		$this->cb->from('in_asal');

		if ($search) {
			$this->cb->like('kode', $search);
			$this->cb->or_like('kode_kota', $search);
			$this->cb->or_like('nama', $search);
		}

		$query = $this->cb->get();
		$data  = $query->result();

		echo json_encode($data);
	}

	public function get_avsec()
	{
		$search = $this->input->post('search');

		$this->cb->select('uid, nama, kode');
		$this->cb->from('out_avsec');

		if ($search) {
			$this->cb->like('nama', $search);
			$this->cb->or_like('kode', $search);
		}

		$query = $this->cb->get();
		$data  = $query->result();

		echo json_encode($data);
	}
	public function get_users()
	{
		$search = $this->input->post('search');

		$this->db->select('nip, nama');
		$this->db->from('users');

		if ($search) {
			$this->db->like('nama', $search);
			$this->db->or_like('nip', $search);
		}

		$query = $this->db->get();
		$data  = $query->result();

		echo json_encode($data);
	}

	public function get_agent()
	{
		$search = $this->input->post('search');

		$this->cb->select('uid, nama, kode');
		$this->cb->from('out_agent');

		if ($search) {
			$this->cb->like('nama', $search);
			$this->cb->or_like('kode', $search);
		}

		$query = $this->cb->get();
		$data  = $query->result();

		echo json_encode($data);
	}

	public function get_agent_deposit()
	{
		$search = $this->input->post('search');

		$this->cb->select('uid, nama, kode');
		$this->cb->from('all_agent_deposit');

		if ($search) {
			$this->cb->like('nama', $search);
			$this->cb->or_like('kode', $search);
		}

		$query = $this->cb->get();
		$data  = $query->result();

		echo json_encode($data);
	}

	public function get_pengirim()
	{
		$search = $this->input->post('search');

		$this->cb->select('uid, nama, kode');
		$this->cb->from('out_pengirim');

		if ($search) {
			$this->cb->like('nama', $search);
			$this->cb->or_like('kode', $search);
		}

		$query = $this->cb->get();
		$data  = $query->result();

		echo json_encode($data);
	}

	public function get_penerima()
	{
		$search = $this->input->post('search');

		$this->cb->select('uid, nama, kode, telepon');
		$this->cb->from('in_penerima');

		if ($search) {
			$this->cb->like('nama', $search);
			$this->cb->or_like('kode', $search);
		}

		$query = $this->cb->get();
		$data  = $query->result();

		echo json_encode($data);
	}

	// =============================================
	// KEMASAN SMU INCOMING
	// =============================================

	public function daftar_kemasan_smu()
	{
		$nip = $this->session->userdata('nip');

		// Inbox and Task counting logic
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
		$data['title'] = "Daftar Kemasan SMU Incoming";

		$this->load->view('in_daftar_kemasan_smu', $data);
	}

	public function getData_kemasan_smu()
	{
		// Ambil list data incoming (in_list) via ServerSide
		$results = $this->M_incoming->get_datatables_kemasan_smu();
		$data    = [];

		foreach ($results as $r) {
			// Mapping Kategori via database

			// // Jika volume kosong, munculkan alert
			// if (empty($r->volume) || $r->volume == 0) {
			// 	$aksi = "<button class='btn btn-xs btn-danger'><i class='fa fa-times'></i> Volume Kosong</button>";
			// } else {
			// 	$aksi = "<button class='btn btn-xs btn-primary btn-btb' data-uid='{$r->uid}' data-smu='{$r->smu}'><i class='fa fa-send'></i> Ke BTB</button>";
			// }

			// Format post_date (YmdHis) ke d-m-Y H:i
			$post_date_txt = "";
			if (!empty($r->post_date) && strlen($r->post_date) >= 12) {
				$wday1 = substr($r->post_date, 0, 4);
				$wday2 = substr($r->post_date, 4, 2);
				$wday3 = substr($r->post_date, 6, 2);
				$wday4 = substr($r->post_date, 8, 2);
				$wday5 = substr($r->post_date, 10, 2);
				$post_date_txt = "$wday3-$wday2-$wday1 $wday4:$wday5";
			}

			// if ($r->out_p == '1') {
			// 	$aksi = "";
			// } else {
			// 	$aksi = "<a class='btn btn-sm btn-primary' href='" . base_url() . "incominghlp/buat_invoice/{$r->uid}'><i class='fa fa-send'></i> Ke Invoice</a>";
			// }

			if ($r->fly_p == '1') {
				$aksi = "
    <button class='btn btn-sm btn-success' >	
        <i class='fa fa-check'> Sudah Berangkat</i>
    </button>";
			} else if ($r->out_p == '1') {
				$aksi = "
    <button class='btn btn-sm btn-success' >
        <i class='fa fa-check'> Sudah Ter Invoice</i>
    </button>";
			} else {
				$aksi = "<a class='btn btn-sm btn-primary' href='" . base_url() . "incominghlp/buat_invoice/{$r->uid}'><i class='fa fa-send'></i> Ke Invoice</a>";
			}

			$data[] = [
				$r->uid,
				$r->smu,
				// $r->nama_pengirim,
				$r->nama_penerima,
				$r->asal ?? '-',
				$r->jumlah ?? '0',
				$r->gross ?? '0.00',
				$r->user_name ?? '-',
				$post_date_txt,
				$aksi,
			];
		}

		$output = [
			'draw'            => intval($_POST['draw'] ?? 0),
			'recordsTotal'    => $this->M_incoming->count_all_kemasan_smu(),
			'recordsFiltered' => $this->M_incoming->count_filtered_kemasan_smu(),
			'data'            => $data,
		];

		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($output));
	}

	// =============================================
	// GET AUTOCOMPLETE DATA (JSON RESPONSES)
	// =============================================

	public function get_autocomplete_pesawat()
	{
		$key = $this->input->get('key');
		$this->cb->select('uid, kode as kode, nama');
		$this->cb->from('pesawat'); // Sesuaikan dengan nama tabel pesawat incoming di DB Anda
		if ($key) {
			$this->cb->group_start()
				->like('kode', $key)
				->or_like('nama', $key)
				->group_end();
		}
		$this->cb->limit(10);
		$data = $this->cb->get()->result();

		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	public function get_autocomplete_asal()
	{
		$key = $this->input->get('key');
		$this->cb->select('uid, kode_kota, nama');
		$this->cb->from('in_asal'); // Sesuaikan dengan nama tabel bandara asal di DB Anda
		if ($key) {
			$this->cb->group_start()
				->like('kode_kota', $key)
				->or_like('nama', $key)
				->group_end();
		}
		$this->cb->limit(10);
		$data = $this->cb->get()->result();

		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	// =============================================
	// SIMPAN DATA SMU BARU (DINAMIS ARRAY LOOP)
	// Sesuai Logika "add_list" di in_list.php
	// =============================================
	public function store_smu()
	{
		$signdate  = time();
		$post_date = date('YmdHis', $signdate);
		$in_date   = $post_date;

		// Ambil data header form
		$asal_uid       = $this->input->post('asal_uid');
		$asal           = strtoupper($this->input->post('asal'));
		$pesawat_uid    = $this->input->post('pesawat_uid');
		$no_pesawat     = $this->input->post('no_pesawat');
		$pesawat        = $this->input->post('pesawat');
		$tanggal_terbang = $this->input->post('tanggal_terbang');
		$time_datang    = $this->input->post('time_datang');
		$tanggal_smu    = $this->input->post('tanggal_smu');

		// Ambil data item array dinamis
		$arr_jns_barang  = $this->input->post('jns_barang');
		$arr_smu         = $this->input->post('smu');
		$arr_nama_agent  = $this->input->post('nama_agent');
		$arr_nama_penerima = $this->input->post('nama_penerima');
		$arr_jumlah      = $this->input->post('jumlah');
		$arr_gross       = $this->input->post('gross');
		$arr_chargeable  = $this->input->post('chargeable');
		$arr_deskripsi   = $this->input->post('deskripsi'); // atau deskripsi barang

		$all_smu_exist_count = 0;

		if (!empty($arr_smu)) {
			// Perulangan untuk menyimpan baris dinamis satu per satu
			for ($i = 0; $i < count($arr_smu); $i++) {
				$smu_val = trim($arr_smu[$i]);

				// Abaikan jika input SMU di baris ini kosong
				if ($smu_val == "") continue;

				// Validasi duplikasi nomor SMU jika jenis barangnya bukan Partial (Partial boleh duplikat)
				if ($arr_jns_barang[$i] != "2") {
					$cek_smu = $this->cb->where('smu', $smu_val)->count_all_results('in_list');
					if ($cek_smu > 0) {
						$all_smu_exist_count++;
						continue; // Lewati baris ini karena SMU sudah ada
					}
				}

				// Siapkan data untuk baris saat ini
				$insert_data = [
					'branch_code'     => $this->session->userdata('kode_cabang'),
					'user_in'         => $this->session->userdata('nip'),
					'post_date'       => $post_date,
					// 'smu'             => $smu1,
					'tanggal_smu'     => $tanggal_smu,
					'asal'            => $asal,
					'asal_uid'        => $asal_uid,
					'no_pesawat'      => $no_pesawat,
					'pesawat'         => $pesawat,
					'tanggal_terbang' => $tanggal_terbang,
					'time_datang'     => $time_datang,
					'nama_penerima'   => $this->input->post('nama_penerima1'),
					'nama_agent'      => $this->input->post('nama_agent1'),
					'jumlah'          => $this->input->post('jumlah1'),
					'gross'           => $this->input->post('gross1'),
					'chargeable'      => $this->input->post('chargeable1'),
					'komoditi'        => strtoupper($this->input->post('deskripsi1')),
					'jns_barang'      => $this->input->post('jns_barang1'),
					'in_date'         => $in_date,
					'in_p'            => '1',
					'status'          => '1',
					'pesawat_uid'     => $pesawat_uid,
				];

				// Ganti isian sesuai index perulangan dinamis
				$insert_data['smu']           = $smu_val;
				$insert_data['jns_barang']    = $arr_jns_barang[$i];
				$insert_data['nama_agent']    = $arr_nama_agent[$i] ?? '';
				$insert_data['nama_penerima'] = $arr_nama_penerima[$i] ?? '';
				$insert_data['jumlah']        = $arr_jumlah[$i] ?? 0;
				$insert_data['gross']         = $arr_gross[$i] ?? 0;
				$insert_data['chargeable']    = $arr_chargeable[$i] ?? 0;
				$insert_data['komoditi']      = strtoupper($arr_deskripsi[$i] ?? '');

				// Insert ke tabel in_list database corebank
				$this->cb->insert('in_list', $insert_data);
			}
		}

		if ($all_smu_exist_count > 0) {
			$this->session->set_flashdata('message_error', 'Beberapa SMU tidak ditambahkan karena nomor SMU sudah ada.');
		} else {
			$this->session->set_flashdata('message_name', 'Daftar SMU Incoming berhasil disimpan.');
		}

		redirect('incominghlp/daftar_kemasan_smu');
	}

	// =============================================
	// GET DETAIL SMU UNTUK EDIT / DETAIL MODAL
	// =============================================
	public function get_detail_smu($uid)
	{
		$row = $this->cb->where('uid', $uid)->get('in_list')->row();

		if (!$row) {
			echo json_encode(['status' => 'error']);
			return;
		}

		// Memformat format in_date YmdHis menjadi Y-m-d agar ramah tag input date HTML5
		$row->in_date_formatted = date('Y-m-d', strtotime(
			substr($row->in_date, 0, 4) . '-' .
				substr($row->in_date, 4, 2) . '-' .
				substr($row->in_date, 6, 2)
		));

		$this->output->set_content_type('application/json')
			->set_output(json_encode([
				'row' => $row
			]));
	}

	// =============================================
	// UPDATE KEMASAN SMU / HAPUS (UBAH & HAPUS LOGIC)
	// Sesuai Logika "upd_list" di in_list.php
	// =============================================
	public function update_kemasan_smu()
	{

		$signdate  = time();
		$post_date = date('YmdHis', $signdate);

		$uid        = $this->input->post('uid');
		$new_status = $this->input->post('new_status');

		// 1. Logika Hapus Data
		if ($new_status == "1") {
			$this->cb->where('uid', $uid)->delete('in_list');
			$this->session->set_flashdata('message_name', 'Data SMU Incoming berhasil dihapus.');
			redirect('incominghlp/daftar_kemasan_smu');
			return;
		}

		// 2. Logika Update/Ubah Data biasa
		$signdate      = time();
		$post_date2    = date('His');
		$tanggal_masuk = $this->input->post('tanggal_masuk');
		$re_in_date_ex = explode('-', $tanggal_masuk);
		$re_in_date    = $re_in_date_ex[0] . $re_in_date_ex[1] . $re_in_date_ex[2];
		$in_date       = $re_in_date . $post_date2;

		$data_update = [
			'jns_barang'      => $this->input->post('jns_barang'),
			'nama_penerima'   => $this->input->post('penerima'),
			'smu'             => $this->input->post('smu'),
			'tanggal_smu'     => $this->input->post('tanggal_smu'),
			'asal'            => strtoupper($this->input->post('asal')),
			'asal_uid'        => $this->input->post('asal_uid'),
			'no_pesawat'      => $this->input->post('no_pesawat'),
			'pesawat_uid'     => $this->input->post('pesawat_uid'),
			'pesawat'         => $this->input->post('pesawat'),
			'tanggal_terbang' => $this->input->post('tanggal_terbang'),
			'nama_agent'      => $this->input->post('nama_agent'),
			'time_datang'     => $this->input->post('time_datang'),
			'jumlah'          => $this->input->post('jumlah'),
			'gross'           => $this->input->post('gross'),
			'chargeable'      => $this->input->post('chargeable'),
			'komoditi'        => strtoupper($this->input->post('komoditi')),
			'in_date'         => $in_date,
			'upd_date'        => $post_date,
			'user_upd'        => $this->session->userdata('nip'),
		];
		$this->cb->where('uid', $uid)->update('in_list', $data_update);

		$il = $this->cb->where('uid', $uid)->get('in_list')->row();

		$warning = '0';


		if ($il->bill_uid) {
			$bil = $this->cb->where('uid', $il->bill_uid)->get('in_billing')->row();

			if ($bil->pay_status != '1' && $bil->status != '1') {
				echo ('MASUK');
				$data_billing = [
					'total_pieces'        => $this->input->post('jumlah'),
					'total_gross'       => $this->input->post('gross'),
					'total_volume'       => $this->input->post('volume'),
					'total_chargeable'       => $this->input->post('chargeable'),
				];
				$this->cb->where('uid', $il->bill_uid)->update('in_billing', $data_billing);
			} else {
				$warning = '1';
			}
		}


		if ($warning == '1') {
			$this->session->set_flashdata('message_error', 'Data SMU Incoming berhasil diperbarui, Tapi Data Billing Tidak di perbarui karena sudah Bayar Invoice.');
		} else {
			$this->session->set_flashdata('message_name', 'Data SMU Incoming berhasil diperbarui.');
		}



		redirect('incominghlp/daftar_kemasan_smu');
	}

	public function get_dimensi($uid_list)
	{
		$data = $this->cb->where('uid_list', $uid_list)->order_by('uid', 'ASC')->get('out_dimensi')->result();
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	public function tambah_dimensi()
	{
		$this->cb->insert('out_dimensi', [
			'uid_list'     => $this->input->post('uid_list'),
			'panjang'      => 0,
			'lebar'        => 0,
			'tinggi'       => 0,
			'pieces'       => 1,
			'dimensi'      => '',
			'volume'       => 0,
			'total_volume' => 0,
		]);
		echo json_encode(['status' => 'success']);
	}

	public function update_dimensi()
	{
		$uid = $this->input->post('uid');
		$this->cb->where('uid', $uid)->update('out_dimensi', [
			'panjang'      => $this->input->post('panjang'),
			'lebar'        => $this->input->post('lebar'),
			'tinggi'       => $this->input->post('tinggi'),
			'pieces'       => $this->input->post('pieces'),
			'dimensi'      => $this->input->post('dimensi'),
			'volume'       => $this->input->post('volume'),
			'total_volume' => $this->input->post('total_volume'),
		]);
		echo json_encode(['status' => 'success']);
	}

	public function hapus_dimensi($uid)
	{
		$this->cb->where('uid', $uid)->delete('out_dimensi');
		echo json_encode(['status' => 'success']);
	}

	/**
	 * Memproses satu data ke BTB menggunakan AJAX POST
	 */

	public function rekap_kemasan_smu()
	{
		$dari   = $this->input->post('dari');
		$sampai = $this->input->post('sampai');

		$start_date = str_replace('-', '', $dari)   . '000000';
		$end_date   = str_replace('-', '', $sampai) . '235959';

		// Query data
		$this->cb->select('*', FALSE);
		$this->cb->from('in_list');
		$this->cb->where('out_date !=', '');
		$this->cb->where("in_date BETWEEN '$start_date' AND '$end_date'", NULL, FALSE);
		$this->cb->order_by('in_date', 'ASC');
		$results = $this->cb->get()->result_array();

		// Load PhpSpreadsheet
		require APPPATH . 'third_party/autoload.php';

		// Include PhpSpreadsheet from third_party
		require APPPATH . 'third_party/psr/simple-cache/src/CacheInterface.php';

		$spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
		$sheet       = $spreadsheet->getActiveSheet();
		$sheet->setTitle('Rekap Tonase SMU Incoming HLP');

		// Header
		$headers = [
			'A' => 'No',
			'B' => 'SMU',
			'C' => 'Asal',
			'D' => 'Tanggal Masuk',
			'E' => 'Tanggal Keluar',
			'F' => 'No Penerbangan',
			'G' => 'Nama Pesawat',
			'H' => 'Tanggal Terbang',
			'I' => 'Koli',
			'J' => 'Berat',
			'K' => 'Komoditi',
			'L' => 'User Input SMU',
		];

		foreach ($headers as $col => $label) {
			$sheet->setCellValue($col . '1', $label);
		}

		$sheet->getStyle('A1:L1')->getFont()->setBold(true)->setSize(12);
		$sheet->getStyle('A1:L1')->getAlignment()
			->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

		// Data rows
		$nomor  = 1;
		$rowNum = 2;

		foreach ($results as $r) {
			// User input SMU
			$user_name = '';
			if (!empty($r['user_in'])) {
				$u = $this->db->select('nama')->where('nip', $r['user_in'])->get('users')->row();
				$user_name = $u->nama ?? '';
			}

			// Format tanggal masuk
			$tgl_masuk = $r['in_date'] ? date('j F Y', strtotime($r['in_date'])) : '';

			// Format tanggal keluar
			$tgl_keluar = $r['out_date'] ? date('j F Y', strtotime($r['out_date'])) : '';

			// Format tanggal terbang
			$tgl_terbang = $r['tanggal_terbang'] ? date('j F Y', strtotime($r['tanggal_terbang'])) : '';

			$sheet->setCellValue('A' . $rowNum, $nomor);
			$sheet->setCellValue('B' . $rowNum, $r['smu']);
			$sheet->setCellValue('C' . $rowNum, $r['asal']);
			$sheet->setCellValue('D' . $rowNum, $tgl_masuk);
			$sheet->setCellValue('E' . $rowNum, $tgl_keluar);
			$sheet->setCellValue('F' . $rowNum, $r['no_pesawat']);
			$sheet->setCellValue('G' . $rowNum, $r['pesawat']);
			$sheet->setCellValue('H' . $rowNum, $tgl_terbang);
			$sheet->setCellValue('I' . $rowNum, $r['jumlah']);
			$sheet->setCellValue('J' . $rowNum, $r['gross']);
			$sheet->setCellValue('K' . $rowNum, $r['komoditi']);
			$sheet->setCellValue('L' . $rowNum, $user_name);

			$rowNum++;
			$nomor++;
		}

		// Baris total
		$totalRow = $rowNum;
		$firstRow = 2;
		$lastRow  = $rowNum - 1;

		$sheet->mergeCells('A' . $totalRow . ':H' . $totalRow);
		$sheet->getStyle('A' . $totalRow)->getAlignment()
			->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
		$sheet->setCellValue('A' . $totalRow, 'TOTAL');
		$sheet->setCellValue('I' . $totalRow, '=SUM(I' . $firstRow . ':I' . $lastRow . ')');
		$sheet->setCellValue('J' . $totalRow, '=SUM(J' . $firstRow . ':J' . $lastRow . ')');

		// Autosize semua kolom
		foreach (range('A', 'L') as $col) {
			$sheet->getColumnDimension($col)->setAutoSize(true);
		}

		// Download
		require APPPATH . 'third_party/autoload_zip.php';
		$filename = 'rekap_kemasan_incoming_HLP_' . date('d-m-Y') . '.xlsx';

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="' . $filename . '"');
		header('Cache-Control: max-age=0');

		$writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
		$writer->save('php://output');
		exit();
	}

	public function buat_invoice($uid_list)
	{
		$signdate   = time();
		$post_date1 = date('Ymd', $signdate);
		$post_date2 = date('His', $signdate);
		$post_dates = $post_date1 . $post_date2;

		// Ambil data list
		$list = $this->cb->where('uid', $uid_list)->get('in_list')->row();

		if (!$list) {
			$this->session->set_flashdata('message_error', 'Data tidak ditemukan.');
			redirect('incominghlp/daftar_list');
			return;
		}

		if ($list->out_p == '1') {
			$this->session->set_flashdata('message_error', 'Data sudah pernah di-invoice.');
			redirect('incominghlp/daftar_list');
			return;
		}

		// Generate nomor invoice
		$no_query = $this->cb->select('MAX(no) as max_no')->from('in_billing')->get()->row();
		$no_inv   = $no_query->max_no ?? 0;

		if ($no_inv > 0) {
			$noinv   = sprintf("%06d", $no_inv + 1);
		} else {
			$noinv   = "000001";
		}

		$my      = date('my', $signdate);
		$invoice = "HLP.IN." . $my . $noinv;

		// Cek nomor sudah dipakai
		$cek = $this->cb->where('no', $invoice)->count_all_results('in_billing');
		if ($cek > 0) {
			$this->session->set_flashdata('message_error', 'Nomor invoice sudah digunakan.');
			redirect('incominghlp/daftar_list');
			return;
		}

		// Insert ke in_billing
		$this->cb->insert('in_billing', [
			'user_kasir' => $this->session->userdata('nip'),
			'post_date'  => $post_dates,
			'no'         => $noinv,
			'no_invoice'         => $invoice,
		]);
		$invoice_uid = $this->cb->insert_id();

		// Update in_list - tandai sudah di-invoice
		$this->cb->where('uid', $uid_list)->update('in_list', [
			'out_date' => $post_dates,
			'out_p'    => '1',
			'bill_uid' => $invoice_uid,
			'user_out' => $this->session->userdata('nip'),
		]);

		// Hitung total dari in_list
		$totals = $this->cb->select('SUM(jumlah) as total_qty, SUM(gross) as total_gross, SUM(chargeable) as total_chargeable')
			->where('bill_uid', $invoice_uid)
			->get('in_list')->row();

		// Update total di in_billing
		$this->cb->where('uid', $invoice_uid)->update('in_billing', [
			'total_pieces'     => $totals->total_qty        ?? 0,
			'total_gross'      => $totals->total_gross      ?? 0,
			'total_chargeable' => $totals->total_chargeable ?? 0,
			// 'nama' => $list->nama_penerima ?? 0,
			// 'alamat' => $list->alamat_penerima ?? 0,
			// 'telepon' => $list->telepon_penerima ?? 0,
			// 'penerima' => $list->nama_penerima ?? 0,
		]);

		$this->session->set_flashdata('message_name', 'Invoice ' . $invoice . ' berhasil dibuat.');
		redirect('incominghlp/daftar_kemasan_smu');
	}

	// DAFTAR INVOICE
	public function daftar_invoice()
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
		$data['title'] = "Daftar Invoice Incoming";

		$coa_12002 = $this->m_coa->getCoaByCode('12002');
		$coa_12001 = $this->m_coa->getCoaByCode('12001');

		$merged_coa_debit_depo = array_merge($coa_12002, $coa_12001);

		$coa_debit_depo = $this->m_coa->getCoaByCode('210');


		$coa_debit_transfer = $merged_coa_debit_depo;

		// $coa_41001 = $this->m_coa->getCoaByCode('41001');
		$coa_41003 = $this->m_coa->getCoaByCode('41003');
		// $coa_41003 = $this->m_coa->getCoaByCode('41003');
		$coa_13010 = $this->m_coa->getCoaByCode('13010');


		// $merged_coa_kredit_transfer = array_merge($coa_41001, $coa_41002, $coa_41003, $coa_13010);
		$merged_coa_kredit_transfer = array_merge($coa_41003,  $coa_13010);


		$data['coa_1'] = $coa_debit_depo;
		// $data['coa_2'] = $coa_kredit_depo;
		$data['coa_2'] = $coa_41003;

		$data['coa_3'] = $coa_debit_transfer;
		$data['coa_4'] = $coa_41003;

		$this->load->view('in_daftar_invoice', $data);
	}

	public function getData_invoice()
	{
		$results = $this->M_incoming->get_datatables_invoice();
		$data    = [];

		foreach ($results as $r) {

			if ($r->tanggal_smu != "") {
				$Stanggal_txt = date("d-M-y", strtotime($r->tanggal_smu));
			} else {
				$Stanggal_txt = "";
			}

			$print = '';
			if ($r->pay_status == '1') {
				$print = "<a target='_blank' class='btn btn-xs btn-primary' href='" . base_url() . "incominghlp/print_invoice_incoming/{$r->uid}'><i class='fa fa-print'></i> Print</a>";
			}

			if ($r->tanggal_invoice != "") {

				$wday1 = substr($r->tanggal_invoice, 0, 4);
				$wday2 = substr($r->tanggal_invoice, 4, 2);
				$wday3 = substr($r->tanggal_invoice, 6, 2);
				$wday4 = substr($r->tanggal_invoice, 8, 2);
				$wday5 = substr($r->tanggal_invoice, 10, 2);
				$wday6 = substr($r->tanggal_invoice, 12, 2);
				$time2 = "$wday4" . ":" . "$wday5";

				$tanggal_txt = "$wday3" . "-" . "$wday2" . "-" . "$wday1" . " " . "$time2";
			} else {
				$tanggal_txt = "";
			}
			if ($r->in_date != "") {
				$Iwday1 = substr($r->in_date, 0, 4);
				$Iwday2 = substr($r->in_date, 4, 2);
				$Iwday3 = substr($r->in_date, 6, 2);
				$Iwday4 = substr($r->in_date, 8, 2);
				$Iwday5 = substr($r->in_date, 10, 2);
				$Iwday6 = substr($r->in_date, 12, 2);
				$Itime2 = "$Iwday4" . ":" . "$Iwday5";


				$Itanggal_txt = "$Iwday3" . "-" . "$Iwday2" . "-" . "$Iwday1" . " " . "$Itime2";
			} else {
				$Itanggal_txt = "";
			}

			$nominal = 'Rp. ' . number_format((float)$r->total);
			if ($r->pay_status == 0) {
				$nominal = "<span>$nominal</span>";
			} else if ($r->pay_status == 1 && $r->jurnal_status == 0) {
				$nominal = "<span class='btn btn-sm' style='color:white; background-color:red;'>$nominal</span><span style='color:red;'>Belum Terbayar &#128544;<span>";
			} else if ($r->pay_status == 1 && $r->jurnal_status == 1) {
				$nominal = "<span class='btn btn-sm' style='color:white; background-color:green;'>$nominal</span><span style='color:green;'>Terbayar &#128513;<span>";
			}


			$data[] = [
				$r->uid,
				$r->no,
				$r->no_invoice,
				$r->smu ?? '-',
				$Stanggal_txt ?? '-',
				$r->nama_penerima ?? '-',
				number_format($r->total_pieces),
				number_format($r->total_gross, 2),
				number_format($r->total_chargeable, 2),
				// 'Rp. ' . number_format((float)$r->total),
				$nominal,
				$Itanggal_txt,
				$tanggal_txt,
				$r->hari,
				$r->nama_acc ?? '-',
				$r->nama_kasir ?? '-',
				$print,
			];
		}

		$output = [
			'draw'            => intval($_POST['draw'] ?? 0),
			'recordsTotal'    => $this->M_incoming->count_all_invoice(),
			'recordsFiltered' => $this->M_incoming->count_filtered_invoice(),
			'data'            => $data,
		];

		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($output));
	}

	public function get_detail_invoice($uid)
	{
		// Ambil data header invoice in_billing
		$billing = $this->cb->where('b.uid', $uid)
			->select('b.*, l.pesawat, c.nama_billing as nama_catg, c.jenis_billing, c.sewa_gudang as rate_sewa, c.kade as rate_kade, c.csc as rate_csc')
			->from('in_billing b')
			->join('in_list l', 'l.bill_uid = b.uid', 'left')
			->join('in_bill_catg c', 'c.uid = b.bill_catg_uid', 'left')
			->get()->row();

		if (!$billing) {
			echo json_encode(['status' => 'error']);
			return;
		}

		// Hitung kalkulasi sewa gudang, kade, csc dll. sesuai database in_list
		$list_smu = $this->cb->where('bill_uid', $uid)->get('in_list')->result();

		$total_pieces     = 0;
		$total_chargeable = 0;
		$total_sewa       = 0;
		$rate_sewa        = (float)($billing->rate_sewa ?? 0);
		$rate_kade        = (float)($billing->rate_kade ?? 0);
		$rate_csc         = (float)($billing->rate_csc ?? 0);

		foreach ($list_smu as $smu) {
			$total_pieces     += (float)$smu->jumlah;
			$total_chargeable += (float)$smu->chargeable;

			// Perhitungan denda / hari masuk & keluar (Sewa Gudang)
			$t_checkout_date = substr($smu->out_date, 0, 8);
			$t_checkin_date  = substr($smu->in_date, 0, 8);
			$date_from       = strtotime($t_checkin_date);
			$date_to         = strtotime($t_checkout_date);
			$days            = (float)0;

			$days = 1;
			if ($date_from && $date_to) {
				$from = (new DateTime())->setTimestamp($date_from)->setTime(0, 0);
				$to   = (new DateTime())->setTimestamp($date_to)->setTime(0, 0);
				$days = $from->diff($to)->days + 1;
			}

			if ($days < 1) $days = 1;

			$smu->hari_hitung = $days;
			$smu_sewa = (float)$smu->chargeable * $rate_sewa * $days;
			if ($smu_sewa < 25000) $smu_sewa = 25000;

			$smu->sewa_gudang = $smu_sewa;
			$total_sewa += $smu_sewa;
		}

		// Surcharge Dangerous Goods (DG)
		$nominal_surcharge_dg = ($billing->opsi_dg == '1') ? ($total_chargeable * 600) : 0;

		// Cargo Development Charge (CDC)
		$total_cdc = 0; // standard CDC formula

		// Biaya Gudang PPN (11%)
		$bg_ppn = ($total_sewa + $total_cdc + $nominal_surcharge_dg) * 0.11;
		$administrasi = ($billing->adm == '2') ? 3000 : 20000;
		$materai = (float)$billing->materai;
		$bg_total = $total_sewa + $total_cdc + $bg_ppn + $administrasi + $materai + $nominal_surcharge_dg;

		// Biaya KC Terminal / Kade & CSC
		$total_kade = $total_chargeable * $rate_kade;
		$total_csc  = $total_chargeable * $rate_csc;

		$kc_sub_total = $total_kade + $total_csc;
		$kc_ppn = $kc_sub_total * 0.11;
		$kc_total = $kc_sub_total + $kc_ppn;

		$grand_total = round($bg_total + $kc_total);

		// Format data response untuk Javascript view
		$billing->total_pieces_k     = number_format($total_pieces);
		$billing->total_chargeable_k = number_format($total_chargeable);
		$billing->total_cargo_k      = number_format($total_sewa);
		$billing->total_cdc_k        = number_format($total_cdc);
		$billing->bg_ppn_k           = number_format($bg_ppn);
		$billing->administrasi_k     = number_format($administrasi);
		$billing->materai_k          = number_format($materai);
		$billing->bg_total_k         = number_format($bg_total);
		$billing->total_kade_k       = number_format($total_kade);
		$billing->total_csc_k        = number_format($total_csc);
		$billing->kc_sub_total_k     = number_format($kc_sub_total);
		$billing->kc_ppn_k           = number_format($kc_ppn);
		$billing->kc_total_k         = number_format($kc_total);
		$billing->grand_total_k      = number_format($grand_total);

		// Pembayaran via Deposit Agen
		if ($billing->pay_methode == '1') {
			$topup = $this->cb->select('agent_uid')
				->where('billing_uid', $uid)
				->where('asal_table', 'in_billing')
				->get('all_topup')
				->row();
			if ($topup) {
				$agent = $this->cb->select('uid, kode, nama')
					->where('uid', $topup->agent_uid)->get('out_agent_deposit')->row();

				$billing->agent_deposit_uid = $agent->uid ?? '';
				$billing->nama_agent_deposit = $agent->nama ?? '';
			}
		}

		$billing->jenis_billing = ($billing->jenis_billing == '1') ? 'TRANSIT' : 'UMUM';

		$this->output->set_content_type('application/json')->set_output(json_encode([
			'billing' => $billing,
			'list'    => $list_smu,
		]));
	}

	public function batal_smu_invoice()
	{
		$uid_smu = $this->input->post('uid_smu');
		$bil_uid = $this->input->post('bil_uid');

		$this->cb->where('uid', $uid_smu)->update('in_list', [
			'out_p'    => '0',
			'bill_uid' => '',
			'out_date' => '',
			'user_out' => '',
			'sewa_gudang' => 0,
		]);

		$count = $this->cb->where('bill_uid', $bil_uid)->count_all_results('in_list');
		if ($count == 0) {
			$this->cb->where('uid', $bil_uid)->delete('in_billing');
		}

		echo json_encode(['status' => 'success']);
	}

	public function get_bill_catg()
	{
		$search = $this->input->post('search');
		$this->cb->select('uid, nama_billing, jenis_billing,
		IF(jenis_billing = "0", "UMUM", IF(jenis_billing = "1", "TRANSIT", "")) as jenis', FALSE);
		$this->cb->from('in_bill_catg');
		$this->cb->where('hold !=', '1');
		if ($search) $this->cb->like('nama_billing', $search);
		echo json_encode($this->cb->get()->result());
	}
	public function update_kasir_invoice()
	{
		$bil_uid = $this->input->post('bil_uid', TRUE);

		if (empty($bil_uid)) {
			return $this->output->set_content_type('application/json')
				->set_output(json_encode([
					'success' => false,
					'msg'     => 'UID invoice tidak dikirim.'
				]));
		}

		$billing = $this->cb->where('uid', $bil_uid)->limit(1)->get('in_billing')->row();

		if (!$billing) {
			return $this->output->set_content_type('application/json')
				->set_output(json_encode([
					'success' => false,
					'msg'     => 'Invoice tidak ditemukan.'
				]));
		}

		$this->cb->where('uid', $bil_uid)->update('in_billing', [
			'user_kasir' => $this->session->userdata('nip'),
		]);

		return $this->output->set_content_type('application/json')
			->set_output(json_encode([
				'success' => true,
				'msg'     => 'Kasir invoice berhasil diubah.'
			]));
	}
	public function update_invoice()
	{
		$bil_uid    = $this->input->post('bil_uid');
		$new_status = $this->input->post('new_status');
		$bill_catg  = $this->input->post('bill_catg');
		// $nama_penerima = $this->input->post('nama_penerima');
		// $alamat_penerima = $this->input->post('alamat_penerima');
		// $telepon_penerima = $this->input->post('telepon_penerima');
		$pay_methode = $this->input->post('pay_methode');

		$nama_penerima    = preg_replace('/\s+/', ' ', trim($this->input->post('nama_penerima', TRUE)));
		$telepon_penerima = trim($this->input->post('telepon_penerima', TRUE));
		$alamat_penerima  = trim($this->input->post('alamat_penerima', TRUE));

		$penerima_uid = '';

		if ($nama_penerima !== '') {
			$penerima = $this->cb->where('nama', $nama_penerima)
				->limit(1)
				->get('in_penerima')
				->row();

			if ($penerima) {
				$penerima_uid     = $penerima->uid;
				$telepon_penerima = $penerima->telepon;
				$alamat_penerima  = $penerima->alamat;
			}
			// else {
			// 	$this->cb->insert('in_penerima', [
			// 		'nama'    => $nama_penerima,
			// 		'telepon' => $telepon_penerima,
			// 		'alamat'  => $alamat_penerima,
			// 	]);
			// 	$penerima_uid = $this->cb->insert_id();
			// }
		}

		if ($pay_methode == '1') {
			$agent_deposit = $this->cb->where('uid', $this->input->post('nama_agent'))->get('all_agent_deposit')->row();

			$agent_deposit_uid = $agent_deposit->uid;
			$nama_agent_deposit = $agent_deposit->nama;
			$agent_deposit_alamat = $agent_deposit->alamat;
			$agent_deposit_telepon = $agent_deposit->telepon;
		} else {

			$agent_deposit_uid = '';
			$nama_agent_deposit = '';
			$agent_deposit_alamat = '';
			$agent_deposit_telepon = '';
		}
		$no_invoice = $this->input->post('no_invoice');
		$adm        = $this->input->post('adm');
		$cdc        = $this->input->post('cdc');
		$opsi_dg    = $this->input->post('opsi_dg') ?? '0';
		$remarks    = $this->input->post('remarks');

		$signdate   = time();
		$post_date1 = date('Ymd', $signdate);
		$post_date2 = date('His', $signdate);
		$post_dates = $post_date1 . $post_date2;

		$tanggal_invoice = $this->input->post('tanggal_invoice');
		$re_in_date_ex   = explode('-', $tanggal_invoice);
		$re_in_date      = $re_in_date_ex[0] . $re_in_date_ex[1] . $re_in_date_ex[2];
		$tanggal_billing = $re_in_date . $post_date2;

		// =============================================
		// LOGIKA STATUS 3 - VOID / BATAL
		// =============================================
		if ($new_status == '3') {
			$this->cb->where('uid', $bil_uid)->update('in_billing', [
				'total_pieces'     => '0',
				'total_gross'      => '0',
				'total_volume'     => '0',
				'total_chargeable' => '0',
				'total_cargo'      => '0',
				'bg_ppn'           => '0',
				'administrasi'     => '0',
				'materai'          => '0',
				'bg_total'         => '0',
				'cdc'              => '0',
				'total_cdc'        => '0',
				'kade'             => '0',
				'csc'              => '0',
				'total_kade'       => '0',
				'total_csc'        => '0',
				'kc_sub_total'     => '0',
				'kc_ppn'           => '0',
				'kc_total'         => '0',
				'grand_total'      => '0',
				'grand_total_paid' => '0',
				'terbilang'        => 'Nol Rupiah',
				'status'           => '0',
				'pay_status'       => '0',
				'total'            => '0',
				'remarks_void'     => $remarks
			]);

			$this->cb->where(['billing_uid' => $bil_uid, 'asal_table' => 'in_billing'])->update('all_topup', ['usage_saldo' => 0]);
			$this->cb->where('bill_uid', $bil_uid)->update('in_list', ['sewa_gudang' => 0]);

			$this->session->set_flashdata('message_name', 'Invoice Incoming Berhasil Di-Void.');
			echo ('Invoice Incoming Berhasil Di-Void.');
			// redirect('incominghlp/daftar_invoice');
			return;
		}

		// =============================================
		// KALKULASI PROSES SIMPAN / UPDATE INVOICE
		// =============================================
		$catg = $this->cb->where('uid', $bill_catg)->get('in_bill_catg')->row();
		if (!$catg) {
			echo ('Kategori Billing tidak valid.');
			$this->session->set_flashdata('message_error', 'Kategori Billing tidak valid.');
			// redirect('incominghlp/daftar_invoice');
			return;
		}

		$rate_sewa   = (float)$catg->sewa_gudang;
		$rate_kade   = (float)$catg->kade;
		$rate_csc    = (float)$catg->csc;

		// Hitung denda / hari simpan per SMU
		$list_smu = $this->cb->where('bill_uid', $bil_uid)->get('in_list')->result();
		$total_sewa = 0;
		foreach ($list_smu as $smu) {
			$t_checkout_date = substr($smu->out_date, 0, 8);
			$t_checkin_date  = substr($smu->in_date, 0, 8);
			$date_from       = strtotime($t_checkin_date);
			$date_to         = strtotime($t_checkout_date);
			$days            = 0;


			if ($date_from && $date_to) {
				$days = ceil(($date_to - $date_from) / 86400) + 1;
			}
			if ($days < 1) $days = 1;
			// echo ('/nOut Date :' . $t_checkout_date);
			// echo ('/nIn Date :' . $t_checkin_date);
			// echo $days;
			// exit();
			$smu_sewa = (float)$smu->chargeable * $rate_sewa * $days;
			if ($smu_sewa < 25000) $smu_sewa = 25000;

			$this->cb->where('uid', $smu->uid)->update('in_list', [
				'sewa_gudang' => $smu_sewa,
				'hari'        => $days
			]);
			$total_sewa += $smu_sewa;
		}

		// Sum totals dari in_list
		$totals = $this->cb->select('SUM(jumlah) as total_pieces, SUM(gross) as total_gross, SUM(chargeable) as total_chargeable, SUM(volume) as total_volume')
			->where('bill_uid', $bil_uid)->get('in_list')->row();

		$total_pieces     = (float)($totals->total_pieces ?? 0);
		$total_gross      = (float)($totals->total_gross ?? 0);
		$total_chargeable = (float)($totals->total_chargeable ?? 0);
		$total_volume     = (float)($totals->total_volume ?? 0);

		// Surcharge Dangerous Goods (DG)
		$nominal_surcharge_dg = ($opsi_dg == '1') ? ($total_chargeable * 600) : 0;

		$total_cdc = 0;
		$administrasi = ($adm == '2') ? 3000 : 20000;
		$materai = 0; // standard materai

		$bg_ppn = ($total_sewa + $total_cdc + $nominal_surcharge_dg) * 0.11;
		$bg_total = $total_sewa + $total_cdc + $bg_ppn + $administrasi + $materai + $nominal_surcharge_dg;

		$total_kade = $total_chargeable * $rate_kade;
		$total_csc  = $total_chargeable * $rate_csc;

		$kc_sub_total = $total_kade + $total_csc;
		$kc_ppn = $kc_sub_total * 0.11;
		$kc_total = $kc_sub_total + $kc_ppn;

		$grand_total = round($bg_total + $kc_total);

		// =============================================
		// STATUS 1 - CETAK
		// =============================================
		if ($new_status == '1') {
			$update_data = [
				'penerima_uid'     => $penerima_uid,
				'nama'     => $nama_penerima,
				'alamat'   => $alamat_penerima,
				'telepon'  => $telepon_penerima,
				'total_pieces'     => $total_pieces,
				'total_gross'      => $total_gross,
				'total_volume'     => $total_volume,
				'total_chargeable' => $total_chargeable,
				'total_cargo'      => $total_sewa,
				'bg_ppn'           => $bg_ppn,
				'administrasi'     => $administrasi,
				'materai'          => $materai,
				'bg_total'         => $bg_total,
				'cdc'              => $cdc,
				'total_cdc'        => $total_cdc,
				'kade'             => $rate_kade,
				'csc'              => $rate_csc,
				'total_kade'       => $total_kade,
				'total_csc'        => $total_csc,
				'kc_sub_total'     => $kc_sub_total,
				'kc_ppn'           => $kc_ppn,
				'kc_total'         => $kc_total,
				'grand_total'      => $grand_total,
				'grand_total_paid' => $grand_total,
				'status'           => '1',
				'pay_status'       => '1',
				'tanggal_invoice'  => $tanggal_billing,
				'no_invoice'       => $no_invoice,
				// 'pay_methode'      => $pay_methode,
				'user_kasir'       => $this->session->userdata('nip'),
				'total'            => $grand_total,
				'bill_catg_uid'    => $bill_catg,
				'opsi_dg'          => $opsi_dg,
				'nominal_surcharge_dg' => $nominal_surcharge_dg,
				'terbilang'        => ucwords(trim($this->terbilang($grand_total))) . ' Rupiah',
				'hari'        => $days
			];

			$this->cb->where('uid', $bil_uid)->update('in_billing', $update_data);

			$nominal = $this->convertToNumberWithComma($grand_total);

			$keterangan = "PENDAPATAN YANG AKAN DI TERIMA. WAREHOUSE INCOMING NO INVOICE :" . $no_invoice;

			// Pastikan fungsi posting tidak mengganggu transaksi
			// $this->posting($coa_debit, $coa_kredit, $keterangan, $nominal, '', '');
			$this->posting('11505', '41003', $keterangan, $nominal, $tanggal_invoice, '');

			$this->cb->trans_commit();
			$this->session->set_flashdata('message_name', 'Invoice dan Jurnal Berhasil Di Cetak.');
			redirect('incominghlp/daftar_invoice');
			return;
		}

		// =============================================
		// STATUS 0 - UBAH
		// =============================================
		if ($new_status == '0') {
			$update_data = [
				'penerima_uid'     => $penerima_uid,
				'nama'     => $nama_penerima,
				'alamat'   => $alamat_penerima,
				'telepon'  => $telepon_penerima,
				'total_pieces'     => $total_pieces,
				'total_gross'      => $total_gross,
				'total_volume'     => $total_volume,
				'total_chargeable' => $total_chargeable,
				'total_cargo'      => $total_sewa,
				'bg_ppn'           => $bg_ppn,
				'administrasi'     => $administrasi,
				'materai'          => $materai,
				'bg_total'         => $bg_total,
				'cdc'              => $cdc,
				'total_cdc'        => $total_cdc,
				'kade'             => $rate_kade,
				'csc'              => $rate_csc,
				'total_kade'       => $total_kade,
				'total_csc'        => $total_csc,
				'kc_sub_total'     => $kc_sub_total,
				'kc_ppn'           => $kc_ppn,
				'kc_total'         => $kc_total,
				'grand_total'      => $grand_total,
				'grand_total_paid' => $grand_total,
				'status'           => '1',
				'pay_status'       => '0',
				'tanggal_invoice'  => $tanggal_billing,
				'no_invoice'       => $no_invoice,
				// 'pay_methode'      => $pay_methode,
				'user_kasir'       => $this->session->userdata('nip'),
				'total'            => $grand_total,
				'bill_catg_uid'    => $bill_catg,
				'opsi_dg'          => $opsi_dg,
				'nominal_surcharge_dg' => $nominal_surcharge_dg,
				'terbilang'        => ucwords(trim($this->terbilang($grand_total))) . ' Rupiah',
				'hari'        => $days
			];
			$this->cb->where('uid', $bil_uid)->update('in_billing', $update_data);

			$update_data_list = [
				'pesawat'     => $this->input->post('pesawat'),
			];
			$this->cb->where(['bill_uid' => $bil_uid])->update('in_list', $update_data_list);

			$this->session->set_flashdata('message_name', 'Invoice berhasil diupdate.');
			redirect('incominghlp/daftar_invoice');
			return;
		}
	}

	public function bayar_invoice()
	{
		$no_invoice = trim($this->input->post('no_invoice', TRUE));
		$pay_methode   = trim($this->input->post('pay_methode', TRUE));
		$coa_bank   = trim($this->input->post('coa_bank', TRUE));
		$agent_deposit_uid   = trim($this->input->post('nama_agent', TRUE));

		$signdate   = time();
		$post_date1 = date('Ymd', $signdate);
		$post_date2 = date('His', $signdate);
		$post_dates = $post_date1 . $post_date2;

		// 1. Validasi input
		if ($no_invoice === '' || $pay_methode === '') {
			echo $no_invoice;
			echo $pay_methode;
			exit();
			$this->session->set_flashdata('message_error', 'Nomor invoice dan Metode Pembayaran diisi.');
			// redirect('incominghlp/daftar_invoice');
			// return;
		}

		// 2. Cari invoice
		$billing = $this->cb->where('no_invoice', $no_invoice)
			->limit(1)
			->get('in_billing')
			->row();

		if (!$billing) {
			$this->session->set_flashdata('message_error', 'Billing ' . $no_invoice . ' tidak ditemukan.');
			redirect('incominghlp/daftar_invoice');
			return;
		}
		$msg = '';

		// 3. Cegah pembayaran ganda & invoice yang sudah dibatalkan
		if ($billing->pay_status == '1' && $billing->jurnal_status == '0') {


			if ($pay_methode == '1') {
				$agent_deposit = $this->cb->where('uid', $agent_deposit_uid)
					->limit(1)
					->get('all_agent_deposit')
					->row();

				$coa_debit = $agent_deposit->coa_sbb;

				$saldo_row = $this->cb
					->select('COALESCE(SUM(topup_saldo), 0) - COALESCE(SUM(usage_saldo), 0) AS saldo', FALSE)
					->where('agent_uid', $agent_deposit_uid)
					->where('asal_table', 'in_billing')
					->get('all_topup')
					->row();
				$cek_saldo = (float)($saldo_row->saldo ?? 0);

				$status_saldo = ($cek_saldo > 5000000) ? '1' : '0';

				// Sinkronisasi tabel all_topup
				$cek_topup = $this->cb->where(['billing_uid' => $billing->uid, 'asal_table' => 'in_billing'])->count_all_results('all_topup');
				$data_topup = [
					'agent_uid'    => $agent_deposit_uid,
					'billing_uid'  => $billing->uid,
					'asal_table'   => 'in_billing',
					'usage_saldo'  => $billing->grand_total,
					'user_kasir'   => $this->session->userdata('nip'),
					'status_saldo' => $status_saldo,
					'post_date'    => $post_dates
				];

				if ($cek_topup > 0) {
					$this->cb->where(['billing_uid' => $billing->uid, 'asal_table' => 'in_billing'])->update('all_topup', $data_topup);
				} else {
					$this->cb->insert('all_topup', $data_topup);
				}

				$saldo_row = $this->cb
					->select('COALESCE(SUM(topup_saldo), 0) - COALESCE(SUM(usage_saldo), 0) AS saldo', FALSE)
					->where('agent_uid', $agent_deposit_uid)
					->get('all_topup')
					->row();
				$cek_saldo = (float)($saldo_row->saldo ?? 0);

				$msg = $cek_saldo > 5000000
					? 'Invoice berhasil dicetak. Sisa saldo ' . $agent_deposit->nama . ' adalah Rp' . number_format($cek_saldo)
					: 'Peringatan: Sisa saldo ' . $agent_deposit->nama . ' adalah Rp' . number_format($cek_saldo) . '. Harap hubungi agen yang bersangkutan.';
			} else if ($pay_methode == '3' || $pay_methode == '4') {
				$coa_debit = $coa_bank;
			} else if ($pay_methode == '6') {
				$coa_debit = '12001';
			}
			$coa_kredit = '11505';

			$nominal = $this->convertToNumberWithComma($billing->grand_total);

			if ($pay_methode == '1') {
				$metode_agent = "DEPOSIT";
			} else if ($pay_methode == '3') {
				$metode_agent = "TRANSFER";
			} else if ($pay_methode == '4') {
				$metode_agent = "TAGIHAN";
			} else if ($pay_methode == '6') {
				$metode_agent = "QRIS";
			}

			$list = $this->cb->where('bill_uid', $billing->uid)
				->limit(1)
				->get('in_list')
				->row();

			$keterangan = "PEMBAYARAN INVOICE " . $no_invoice . ". METODE : " . $metode_agent;

			// $sub_total = $billing->total_cargo;
			// $total_ppn = $billing->bg_ppn + $billing->kc_ppn;
			// $total_nonpph = $sub_total + $total_ppn;
			// $total = $total_nonpph;

			// $total = $total_nonpph;
			$total = $billing->grand_total;
			$nominal = $this->convertToNumberWithComma($total);

			$this->posting($coa_debit, $coa_kredit, $keterangan, $nominal, $billing->tanggal_invoice, '');

			$update_data = [
				'jurnal_status'       => '1',
				'pay_methode'       => $pay_methode,
			];
			$this->cb->where('uid', $billing->uid)->update('in_billing', $update_data);
			$this->session->set_flashdata('message_name', 'Invoice ' . $no_invoice . ' Berhasil Di Bayar.' . $msg);
			redirect('incominghlp/daftar_invoice');
			return;
		} else {
			$this->cb->trans_rollback();
			$this->session->set_flashdata('message_name', 'Invoice detail data is empty.');
			redirect("outgoinghlp/daftar_invoice");
		}


		redirect('incominghlp/daftar_invoice');
	}

	private function terbilang($nilai)
	{
		$nilai = abs((float)$nilai);
		$huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
		$temp = "";
		if ($nilai < 12) {
			$temp = " " . $huruf[$nilai];
		} else if ($nilai < 20) {
			$temp = $this->terbilang($nilai - 10) . " belas";
		} else if ($nilai < 100) {
			$temp = $this->terbilang((int)($nilai / 10)) . " puluh" . $this->terbilang($nilai % 10);
		} else if ($nilai < 200) {
			$temp = " seratus" . $this->terbilang($nilai - 100);
		} else if ($nilai < 1000) {
			$temp = $this->terbilang((int)($nilai / 100)) . " ratus" . $this->terbilang($nilai % 100);
		} else if ($nilai < 2000) {
			$temp = " seribu" . $this->terbilang($nilai - 1000);
		} else if ($nilai < 1000000) {
			$temp = $this->terbilang((int)($nilai / 1000)) . " ribu" . $this->terbilang($nilai % 1000);
		} else if ($nilai < 1000000000) {
			$temp = $this->terbilang((int)($nilai / 1000000)) . " juta" . $this->terbilang($nilai % 1000000);
		} else if ($nilai < 1000000000000) {
			$temp = $this->terbilang((int)($nilai / 1000000000)) . " milyar" . $this->terbilang(fmod($nilai, 1000000000));
		} else if ($nilai < 1000000000000000) {
			$temp = $this->terbilang((int)($nilai / 1000000000000)) . " trilyun" . $this->terbilang(fmod($nilai, 1000000000000));
		}
		return $temp;
	}

	public function print_invoice_incoming($uid)
	{
		// =============================================
		// Data Billing + List + Catg
		// =============================================
		$this->cb->select('b.uid, b.total_pieces, b.total_gross, b.total_volume, b.total_chargeable,
        b.total_cargo, b.bg_ppn, b.administrasi, b.materai, b.bg_total,
        b.kade, b.csc, b.total_kade, b.total_csc, b.kc_sub_total,
        b.kc_ppn, b.kc_total, b.grand_total, b.grand_total_paid, b.terbilang,
        b.nama, b.alamat, b.telepon, b.status, b.pay_status,
        b.tanggal_invoice, b.no_invoice, b.memo, b.virtual, b.pay_methode,
        b.no, b.user_bill, b.user_kasir, b.total_cdc, b.hari,
        b.opsi_dg, b.nominal_surcharge_dg,
        l.in_date, l.out_date, l.komoditi,
        c.sewa_gudang as catg_sewa_gudang', FALSE);
		$this->cb->from('in_billing b');
		$this->cb->join('in_list l',      'l.bill_uid = b.uid', 'left');
		$this->cb->join('in_bill_catg c', 'c.uid = b.bill_catg_uid', 'left');
		$this->cb->where('b.uid', $uid);
		$billing = $this->cb->get()->row();

		if (!$billing) show_error('Data tidak ditemukan.', 404);

		// Kasir
		$kasir = $this->db->select('nama')->where('nip', $billing->user_kasir)->get('users')->row();
		$kasir_name = $kasir->nama ?? '';

		// Kasir SJ (untuk surat jalan)
		$kasir_sj = $this->db->select('nama')->where('nip', $billing->user_kasir)->get('users')->row();
		$cdo_name = $kasir_sj->nama ?? '';

		$corp_logo = "<img src='" . base_url('src/images/logo_bdt.jpg') . "' border='0' width='150'>";

		// Format tanggal invoice
		$tgl_inv = $billing->tanggal_invoice;
		$date4Y  = substr($tgl_inv, 0, 4);
		$date4m  = substr($tgl_inv, 4, 2);
		$date4d  = substr($tgl_inv, 6, 2);
		$pm_billing_date_txt = $tgl_inv > 1 ? "$date4d-$date4m-$date4Y" : '-';

		// Format tanggal masuk/keluar
		$in_date  = $billing->in_date;
		$out_date = $billing->out_date;

		$t_checkin_date  = $in_date > 1
			? substr($in_date, 0, 4) . '-' . substr($in_date, 4, 2) . '-' . substr($in_date, 6, 2)
			: '';
		$t_checkout_date = $out_date > 1
			? substr($out_date, 0, 4) . '-' . substr($out_date, 4, 2) . '-' . substr($out_date, 6, 2)
			: '';

		// Angka format
		$total_sewa_gudang_k  = number_format((float)$billing->total_cargo);
		$upd_total_cdc        = $billing->total_cdc > 0 ? number_format((float)$billing->total_cdc) : '';
		$bg_ppn_k             = number_format((float)$billing->bg_ppn);
		$administrasi_k       = number_format((float)$billing->administrasi);
		$materai_k            = $billing->materai > 0 ? number_format((float)$billing->materai) : '';
		$bg_total_k           = number_format((float)$billing->bg_total);
		$total_kade_k         = number_format((float)$billing->total_kade);
		$total_csc_k          = number_format((float)$billing->total_csc);
		$kc_sub_total_k       = number_format((float)$billing->kc_sub_total);
		$kc_ppn_k             = number_format((float)$billing->kc_ppn);
		$kc_total_k           = number_format((float)$billing->kc_total);
		$grand_total_k        = number_format((float)$billing->grand_total);
		$total_pieces_k       = number_format((float)$billing->total_pieces);
		$total_chargeable_k   = number_format((float)$billing->total_chargeable);
		$kade_k               = number_format((float)$billing->kade);
		$csc_k                = number_format((float)$billing->csc);
		$days_k               = number_format((float)$billing->hari);

		// Terbilang
		// $this->load->helper('terbilang');
		$terbilang = $billing->terbilang
			? $billing->terbilang
			: 'Terbilang : ' . ucwords(trim(terbilang($billing->grand_total))) . ' Rupiah';

		// List SMU Invoice
		$list_billing = $this->cb->where('bill_uid', $uid)
			->order_by('uid', 'ASC')
			->get('in_list')->result();

		// Surat Jalan
		$sj_no = 'HPLI-' . $billing->no;

		$data = [
			'billing'              => $billing,
			'kasir_name'           => $kasir_name,
			'cdo_name'             => $cdo_name,
			'corp_logo'            => $corp_logo,
			'pm_billing_date_txt'  => $pm_billing_date_txt,
			't_checkin_date'       => $t_checkin_date,
			't_checkout_date'      => $t_checkout_date,
			'total_sewa_gudang_k'  => $total_sewa_gudang_k,
			'upd_total_cdc'        => $upd_total_cdc,
			'bg_ppn_k'             => $bg_ppn_k,
			'administrasi_k'       => $administrasi_k,
			'materai_k'            => $materai_k,
			'bg_total_k'           => $bg_total_k,
			'total_kade_k'         => $total_kade_k,
			'total_csc_k'          => $total_csc_k,
			'kc_sub_total_k'       => $kc_sub_total_k,
			'kc_ppn_k'             => $kc_ppn_k,
			'kc_total_k'           => $kc_total_k,
			'grand_total_k'        => $grand_total_k,
			'total_pieces_k'       => $total_pieces_k,
			'total_chargeable_k'   => $total_chargeable_k,
			'kade_k'               => $kade_k,
			'csc_k'                => $csc_k,
			'days_k'               => $days_k,
			'terbilang'            => $terbilang,
			'list_billing'         => $list_billing,
			'sj_no'                => $sj_no,
		];

		$this->load->view('print_invoice_incoming', $data);
	}

	public function rekap_invoice()
	{
		$dari      = $this->input->post('dari');
		$sampai    = $this->input->post('sampai');
		$pesawat  = $this->input->post('pesawat');
		$pesawat = is_array($pesawat) ? array_filter($pesawat) : array();
		$kasir     = $this->input->post('kasir');

		$start_date = str_replace('-', '', $dari)   . '000000';
		$end_date   = str_replace('-', '', $sampai) . '235959';

		$this->cb->select('b.uid, b.no_invoice, b.tanggal_invoice, b.nama, b.total_chargeable, b.total_cargo, b.total_cdc,
        b.bg_ppn, b.administrasi, b.materai, b.bg_total, b.total_kade, b.total_csc, b.kc_sub_total, b.kc_ppn, b.kc_total,
        b.grand_total, b.user_kasir, b.pay_methode, b.hari, b.status, b.remarks_void, b.opsi_dg, b.nominal_surcharge_dg, l.pesawat', FALSE);
		$this->cb->from('in_billing b');
		$this->cb->join('in_list l', 'l.bill_uid = b.uid', 'left');
		$this->cb->where("b.tanggal_invoice BETWEEN '$start_date' AND '$end_date'", NULL, FALSE);

		if (!empty($pesawat)) {
			$this->cb->where_in('l.pesawat', $pesawat);
		}
		if ($kasir) {
			$this->cb->where('b.user_kasir', $kasir);
		}

		$this->cb->order_by('b.tanggal_invoice', 'ASC');
		$results = $this->cb->get()->result_array();

		require APPPATH . 'third_party/autoload.php';

		// Include PhpSpreadsheet from third_party
		require APPPATH . 'third_party/psr/simple-cache/src/CacheInterface.php';

		$spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
		$sheet       = $spreadsheet->getActiveSheet();
		$sheet->setTitle('Rekap Incoming');

		$headers = [
			'A'  => 'No',
			'B'  => 'No Invoice',
			'C'  => 'Tanggal',
			'D'  => 'Pengirim',
			'E'  => 'Penerima',
			'F'  => 'No',
			'G'  => 'SMU',
			'H'  => 'Asal',
			'I'  => 'Koli',
			'J'  => 'Berat',
			'K'  => 'Biaya Gudang',
			'L' => 'Hari',
			'M' => 'Total Ch.W',
			'N'  => 'SubTotal Sewa Gudang',
			'O' => 'Surcharge DG 100%',
			'P'  => 'Cargo Development Charge',
			'Q' => 'PPN BG',
			'R'  => 'Administrasi',
			'S' => 'Materai',
			'T' => 'Total Sewa Gudang',
			'U'  => 'Jasa Terminal Handling',
			'V' => 'Biaya CSC',
			'W'  => 'SubTotal KC',
			'X' => 'PPN KC',
			'Y' => 'Total KC',
			'Z'  => 'Total',
			'AA' => 'Pembayaran',
			'AB' => 'Kasir',
		];

		foreach ($headers as $col => $label) {
			$sheet->setCellValue($col . '1', $label);
		}

		$sheet->getStyle('A1:AB1')->getFont()->setBold(true)->setSize(12);
		$sheet->getStyle('A1:AB1')->getAlignment()
			->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

		$rowNum = 2;
		$nomor  = 1;

		foreach ($results as $r) {
			$serial       = $r['uid'];
			$pay_methode  = $r['pay_methode'];
			$status       = $r['status'];
			$remarks_void = $r['remarks_void'];

			$pay_map = ['1' => 'Deposit', '2' => 'Cash', '3' => 'Transfer', '4' => 'Tagihan', '5' => 'FOC', '6' => 'QRIS'];
			$pay = $pay_map[$pay_methode] ?? '';

			if ($status == '1') {
				$status_txt = 'Invoice';
			} elseif ($status == '0') {
				$status_txt = 'Void (' . $remarks_void . ')';
			} else {
				$status_txt = '-';
			}

			$kasir_row = $this->db->select('nama')->where('nip', $r['user_kasir'])->get('users')->row();
			$user_name = $kasir_row->nama ?? '';

			$tgl_txt = $r['tanggal_invoice'] ? date('j F Y', strtotime($r['tanggal_invoice'])) : '';

			$list_smu = $this->cb->select('uid, smu, asal, jumlah, gross, sewa_gudang, nama_penerima, nama_agent')
				->where('bill_uid', $serial)
				->where('out_p', '1')
				->order_by('uid', 'ASC')
				->get('in_list')->result_array();

			$startRow = $rowNum;
			$no_smu   = 1;

			$nama_penerima_kasir = $r['nama'];
			$nama_penerima = '';

			foreach ($list_smu as $s) {
				$sheet->getStyle('F' . $rowNum)->getAlignment()
					->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
				$sheet->setCellValue('F' . $rowNum, $no_smu);
				$sheet->setCellValue('G' . $rowNum, $s['smu']);
				$sheet->setCellValue('H' . $rowNum, $s['asal']);
				$sheet->setCellValue('I' . $rowNum, $s['jumlah']);
				$sheet->setCellValue('J' . $rowNum, $s['gross']);
				$sheet->setCellValue('K' . $rowNum, $s['sewa_gudang']);

				$nama_penerima = $s['nama_penerima'];
				$nama_agent = $s['nama_agent'];

				$rowNum++;
				$no_smu++;
			}

			$endRow = $rowNum - 1;

			if ($endRow > $startRow) {
				foreach (['A', 'B', 'C', 'D', 'E', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB'] as $col) {
					$sheet->mergeCells($col . $startRow . ':' . $col . $endRow);
				}
			}

			$sheet->getStyle('A' . $startRow)->getAlignment()
				->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			$sheet->setCellValue('A' . $startRow, $nomor);
			$sheet->setCellValue('B' . $startRow, $r['no_invoice']);
			$sheet->setCellValue('C' . $startRow, $tgl_txt);
			$sheet->setCellValue('D' . $startRow, $nama_agent);
			$sheet->setCellValue('E' . $startRow, $nama_penerima_kasir);
			$sheet->setCellValue('L' . $startRow, $r['hari']);
			$sheet->setCellValue('M' . $startRow, $r['total_chargeable']);
			$sheet->setCellValue('N' . $startRow, $r['total_cargo']);
			$sheet->setCellValue('O' . $startRow, $r['nominal_surcharge_dg']);
			$sheet->setCellValue('P' . $startRow, $r['total_cdc']);
			$sheet->setCellValue('Q' . $startRow, $r['bg_ppn']);
			$sheet->setCellValue('R' . $startRow, $r['administrasi']);
			$sheet->setCellValue('S' . $startRow, $r['materai']);
			$sheet->setCellValue('T' . $startRow, $r['bg_total']);
			$sheet->setCellValue('U' . $startRow, $r['total_kade']);
			$sheet->setCellValue('V' . $startRow, $r['total_csc']);
			$sheet->setCellValue('W' . $startRow, $r['kc_sub_total']);
			$sheet->setCellValue('X' . $startRow, $r['kc_ppn']);
			$sheet->setCellValue('Y' . $startRow, $r['kc_total']);
			$sheet->setCellValue('Z' . $startRow, $r['grand_total']);
			$sheet->setCellValue('AA' . $startRow, $pay);
			$sheet->setCellValue('AB' . $startRow, $user_name);

			$nomor++;
		}

		$totalRow = $rowNum;
		$firstRow = 2;
		$lastRow  = $rowNum - 1;

		$sheet->mergeCells('A' . $totalRow . ':K' . $totalRow);
		$sheet->getStyle('A' . $totalRow)->getAlignment()
			->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
		$sheet->setCellValue('A' . $totalRow, 'TOTAL');

		foreach (['L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y'] as $col) {
			$sheet->setCellValue($col . $totalRow, '=SUM(' . $col . $firstRow . ':' . $col . $lastRow . ')');
		}

		$cols = array_merge(range('A', 'Z'), ['AA', 'AB']);
		foreach ($cols as $col) {
			$sheet->getColumnDimension($col)->setAutoSize(true);
		}

		require APPPATH . 'third_party/autoload_zip.php';
		$filename = 'rekap_incoming_HLP_' . date('d-m-Y') . '.xlsx';

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="' . $filename . '"');
		header('Cache-Control: max-age=0');

		$writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
		$writer->save('php://output');
		exit();
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

		$data['title'] = "Daftar Deposit";

		$this->load->view('in_daftar_deposit', $data);
	}

	public function getData_deposit()
	{
		$results = $this->M_incoming->get_datatables_deposit();
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
			'recordsTotal'    => $this->M_incoming->count_all_deposit(),
			'recordsFiltered' => $this->M_incoming->count_filtered_deposit(),
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
		$raw_list = $this->M_incoming->get_riwayat_topup_raw($agent_uid, $termasuk_usage, $search);

		$calculated_data = array();
		$running_saldo = 0; // Wadah sisa saldo berjalan

		// 2. Hitung matematika Running Total Saldo
		foreach ($raw_list as $r) {
			// Rumus: Saldo Sebelumnya + Topup Sekarang - Usage Sekarang
			$running_saldo = $running_saldo + (float)$r->topup_saldo - (float)$r->usage_saldo;

			if (!empty($r->kode)) {
				$display_kode = '<b>' . $r->kode . '</b>';
				$no_invoice = '';
			} else {
				$display_kode = '<span class="text-danger"><i class="fa fa-arrow-circle-down"></i> Penggunaan Saldo</span>';
				$invoice_detail = $this->cb->where('uid', $r->billing_uid)->get('in_billing')->row();
				$no_invoice = $invoice_detail->no_invoice;
			}


			// Simpan data beserta hasil perhitungan saldo buatan kita sendiri
			$calculated_data[] = array(
				date('d/m/Y H:i', strtotime($r->post_date)),
				$display_kode,
				$no_invoice,
				$r->topup_saldo > 0 ? 'Rp ' . number_format($r->topup_saldo, 0, ',', '.') : '-',
				$r->usage_saldo > 0 ? 'Rp ' . number_format($r->usage_saldo, 0, ',', '.') : '-',
				'<b>Rp ' . number_format($running_saldo, 0, ',', '.') . '</b>' // Menggunakan running_saldo dinamis
			);
		}

		// 3. Balik urutan data agar data TERBARU berada di paling atas (DESC)
		$reversed_data = array_reverse($calculated_data);

		// 4. Lakukan pemotongan data (Slice array) sesuai limit & offset pagination DataTables
		$total_filtered = count($reversed_data);
		$paged_data = array_slice($reversed_data, $start, $limit);

		// Hitung total murni tanpa filter search
		$total_records = $this->M_incoming->count_all_riwayat($agent_uid, $termasuk_usage);

		// Output JSON standar DataTables
		$output = array(
			"draw"            => intval($_POST['draw'] ?? 1),
			"recordsTotal"    => intval($total_records),
			"recordsFiltered" => intval($total_filtered),
			"data"            => $paged_data,
		);

		echo json_encode($output);
	}

	public function store_deposit()
	{
		// 1. Ambil data dari POST input form
		$agent_uid       = $this->input->post('nama_agent'); // Di form select name="nama_agent" nilainya adalah UID
		$tanggal_deposit = $this->input->post('tanggal_deposit');
		$nominal_topup   = $this->input->post('nominal_topup');

		// Ambil data session yang dibutuhkan
		$login_branch    = $this->session->userdata('branch_code'); // Sesuaikan nama session Anda
		$now_uid         = $this->session->userdata('uid');         // Sesuaikan nama session Anda

		// 2. Format waktu untuk post_date (YmdHis)
		$post_dates      = date("YmdHis");

		// Validasi jika agent dipilih
		if (!empty($agent_uid)) {

			// 3. GENERATE KODE OTOMATIS (Menggantikan SELECT MAX)
			$this->cb->select_max('kode');
			$query_no = $this->cb->get('in_topup')->row_array();
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
			$row = $this->cb->get('in_topup')->row_array();

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
			$insert = $this->cb->insert('in_topup', $data_insert);

			if ($insert) {
				// Set notifikasi sukses menggunakan Flashdata (Sesuai dengan library sweetalert di view Anda)
				$this->session->set_flashdata('message_name', 'Data Deposit Berhasil Disimpan.');
			} else {
				$this->session->set_flashdata('message_error', 'Gagal menyimpan data deposit.');
			}

			// Redirect kembali ke halaman daftar deposit
			redirect('incominghlp/daftar_deposit');
		} else {
			$this->session->set_flashdata('message_error', 'Silahkan pilih Agent terlebih dahulu.');
			redirect('incominghlp/daftar_deposit');
		}
	}

	public function rekap_deposit()
	{
		$dari      = $this->input->post('dari');
		$sampai    = $this->input->post('sampai');
		$agent_uid = $this->input->post('agent_deposit');

		$start_date = str_replace('-', '', $dari)   . '000000';
		$end_date   = str_replace('-', '', $sampai) . '235959';

		// Query topup dengan subquery untuk sisa saldo
		$sql = "SELECT 
        t.uid, t.kode, t.topup_date, t.topup_saldo,
        -- IF(
        --     (SELECT SUM(t1.topup_saldo) - SUM(t1.usage_saldo) FROM in_topup t1 WHERE t1.uid < t.uid AND t1.agent_uid = t.agent_uid) != '',
        --     IF(
        --         (SELECT SUM(t1.topup_saldo) - SUM(t1.usage_saldo) FROM in_topup t1 WHERE t1.uid < t.uid AND t.usage_saldo != '' AND t1.agent_uid = t.agent_uid)
        --         = (SELECT SUM(t1.topup_saldo) - SUM(t1.usage_saldo) FROM in_topup t1 WHERE t1.uid < t.uid AND t1.agent_uid = t.agent_uid),
        --         (SELECT SUM(t1.topup_saldo) - SUM(t1.usage_saldo) FROM in_topup t1 WHERE t1.uid < t.uid AND t1.agent_uid = t.agent_uid) - t.usage_saldo,
        --         ''
        --     ),
        --     t.topup_saldo - t.usage_saldo
        -- ) as sisa_saldo,
		IFNULL(
    (SELECT SUM(t1.topup_saldo) - SUM(t1.usage_saldo) 
     FROM in_topup t1 
     WHERE t1.uid <= t.uid AND t1.agent_uid = t.agent_uid), 
    0
) as sisa_saldo,
        t.billing_uid, t.agent_uid,
		IFNULL((SELECT b.no_invoice FROM in_billing b WHERE b.uid = t.billing_uid), '') as no_invoice,
        IFNULL((SELECT b.tanggal_invoice  FROM in_billing b WHERE b.uid = t.billing_uid), '') as tanggal_invoice,
		-- IFNULL((SELECT l.nama_penerima FROM in_list l WHERE l.bill_uid = t.billing_uid LIMIT 1), '') as nama_penerima,        IFNULL((SELECT b.total_chargeable FROM in_billing b WHERE b.uid = t.billing_uid), '') as total_chargeable,
        IFNULL((SELECT b.grand_total      FROM in_billing b WHERE b.uid = t.billing_uid), '') as grand_total,
        IFNULL((SELECT b.pay_methode      FROM in_billing b WHERE b.uid = t.billing_uid), '') as pay_methode,
        IFNULL((SELECT b.user_kasir       FROM in_billing b WHERE b.uid = t.billing_uid), '') as user_kasir,
        IFNULL((SELECT b.status           FROM in_billing b WHERE b.uid = t.billing_uid), '') as status
        FROM in_topup t
        WHERE t.post_date BETWEEN '$start_date' AND '$end_date'
    ";

		if ($agent_uid) {
			$sql .= " AND t.agent_uid = '$agent_uid'";
		}
		$sql .= " ORDER BY t.uid ASC";

		$results = $this->cb->query($sql)->result_array();

		$ag = $this->cb->select('nama')->where('uid', $agent_uid)->get('all_agent_deposit')->row();
		$nama_agent = $ag->nama ?? '';


		// Load PhpSpreadsheet
		require APPPATH . 'third_party/autoload.php';

		// Include PhpSpreadsheet from third_party
		require APPPATH . 'third_party/psr/simple-cache/src/CacheInterface.php';

		$spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
		$sheet       = $spreadsheet->getActiveSheet();
		$sheet->setTitle('Rekap Deposit Incoming HLP');

		$center = \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER;
		$right  = \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT;
		$left   = \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT;

		// Header baris 1 - nama agent
		$sheet->mergeCells('A1:P1');
		$sheet->getStyle('A1')->getFont()->setBold(true)->setSize(12);
		$sheet->getStyle('A1')->getAlignment()->setHorizontal($center);
		$sheet->setCellValue('A1', $nama_agent ?: 'REKAP DEPOSIT INCOMING HLP');

		// Header baris 2-3
		$merges2 = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'N', 'O', 'P'];
		foreach ($merges2 as $col) {
			$sheet->mergeCells($col . '2:' . $col . '3');
		}
		$sheet->mergeCells('K2:M2');

		$headers2 = [
			'A' => 'No',
			'B' => 'No Invoice',
			'C' => 'Tanggal',
			'D' => 'Agent',
			'E' => 'No',
			'F' => 'SMU',
			'G' => 'Asal',
			'H' => 'Koli',
			'I' => 'Berat',
			'J' => 'Total Ch.W',
			'K' => 'Nominal',
			'N' => 'Pembayaran',
			'O' => 'Kasir On Duty',
			'P' => 'Remarks',
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

		$sheet->getStyle('A2:P3')->getFont()->setBold(true);

		$rowNum = 4;
		$nomor  = 1;

		foreach ($results as $r) {
			$t_billing_uid = $r['billing_uid'];
			$topup_saldo   = $r['topup_saldo'];
			$sisa_saldo    = $r['sisa_saldo'];
			$agent_uid    = $r['agent_uid'];

			// Row topup saja (tanpa billing)
			if (empty($t_billing_uid)) {
				$tgl_topup = $r['topup_date'] ? date('j F Y', strtotime($r['topup_date'])) : '';

				$sheet->mergeCells('A' . $rowNum . ':C' . $rowNum);
				$sheet->getStyle('A' . $rowNum)->getAlignment()->setHorizontal($center);
				$sheet->setCellValue('A' . $rowNum, $tgl_topup);

				$sheet->mergeCells('D' . $rowNum . ':K' . $rowNum);
				$sheet->getStyle('D' . $rowNum)->getAlignment()->setHorizontal($center);
				$sheet->setCellValue('D' . $rowNum, 'Topup Deposit');

				$sheet->getStyle('L' . $rowNum)->getAlignment()->setHorizontal($right);
				$sheet->setCellValue('L' . $rowNum, $topup_saldo);

				$sheet->getStyle('M' . $rowNum)->getAlignment()->setHorizontal($right);
				$sheet->setCellValue('M' . $rowNum, $sisa_saldo);

				$rowNum++;
				$nomor++;
				continue;
			}

			// Ambil data billing
			$billing = $this->cb->select('uid, no_invoice, tanggal_invoice, nama, grand_total, pay_methode, user_kasir, status')
				// ->where("status = '1' OR status = '0'", NULL, FALSE)
				->where('uid', $t_billing_uid)
				->get('in_billing')->row();

			if (!$billing) {
				$rowNum++;
				continue;
			}

			// Status
			$status_txt = $billing->status == '1' ? 'Invoice' : ($billing->status == '0' ? 'Void' : '');

			// Pembayaran
			$pay = $billing->pay_methode == '1' ? 'Deposit' : '';

			// Kasir
			$kasir = $this->db->select('nama')->where('nip', $billing->user_kasir)->get('users')->row();
			$kasir_name = $kasir->nama ?? '';

			// Format tanggal
			$tgl = $billing->tanggal_invoice;
			$tgl_txt = $tgl ? date('j F Y', strtotime($tgl)) : '';

			// List SMU
			$list_smu = $this->cb->select('uid, smu, asal, jumlah, gross, chargeable')
				->where('bill_uid', $billing->uid)
				->where('out_p', '1')
				->order_by('uid', 'ASC')
				->get('in_list')->result_array();

			$startRow = $rowNum;
			$no_smu   = 1;

			foreach ($list_smu as $s) {
				$sheet->getStyle('E' . $rowNum)->getAlignment()->setHorizontal($center);
				$sheet->setCellValue('E' . $rowNum, $no_smu);
				$sheet->setCellValue('F' . $rowNum, $s['smu']);
				$sheet->setCellValue('G' . $rowNum, $s['asal']);
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

			$ag = $this->cb->select('nama')->where('uid', $agent_uid)->get('all_agent_deposit')->row();
			$nama_agent = $ag->nama ?? '';
			$sheet->getStyle('D' . $startRow)->getAlignment()->setHorizontal($left);
			$sheet->setCellValue('D' . $startRow, $nama_agent);
			$sheet->getStyle('K' . $startRow)->getAlignment()->setHorizontal($right);
			$sheet->setCellValue('K' . $startRow, $billing->grand_total);
			$sheet->getStyle('M' . $startRow)->getAlignment()->setHorizontal($right);
			$sheet->setCellValue('M' . $startRow, $sisa_saldo);
			$sheet->getStyle('N' . $startRow)->getAlignment()->setHorizontal($left);
			$sheet->setCellValue('N' . $startRow, $pay);
			$sheet->getStyle('O' . $startRow)->getAlignment()->setHorizontal($left);
			$sheet->setCellValue('O' . $startRow, $kasir_name);
			$sheet->getStyle('P' . $startRow)->getAlignment()->setHorizontal($left);
			$sheet->setCellValue('P' . $startRow, $status_txt);

			$nomor++;
		}

		// Autosize
		foreach (range('A', 'P') as $col) {
			$sheet->getColumnDimension($col)->setAutoSize(true);
		}

		// Download
		require APPPATH . 'third_party/autoload_zip.php';
		$filename = 'rekap_deposit_incoming_' . date('d-m-Y') . '.xlsx';

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="' . $filename . '"');
		header('Cache-Control: max-age=0');

		$writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
		$writer->save('php://output');
		exit();
	}

	// DAFTAR AGENTS
	public function daftar_agents()
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

		$data['title'] = "Daftar Agents";

		$out_agent = $this->cb->select('MAX(CAST(kode AS UNSIGNED)) as kode')->from('out_agent')->get()->row();

		$this->load->view('in_daftar_agents', $data);
	}

	public function getData_agents()
	{
		$results = $this->M_incoming->get_datatables_agents();
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

				$button_hold = "<a class='btn btn-sm btn-success' href='" . base_url() . "incominghlp/agnet_hold/{$r->uid}/0'>
        <i class='fa fa-check'></i> Ready</a>";
			} else {
				$hold = "<span class='btn btn-sm' style='color:#5cb85c; border:1px solid #5cb85c; background:transparent;'>Ready</span> ";
				$button_hold = "<a class='btn btn-sm btn-danger' href='" . base_url() . "incominghlp/agnet_hold/{$r->uid}/1'>
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
				$r->npwp ?? '-',
				$r->user_name ?? '-',
				$tanggal_txt ?? '-',
				$hold ?? '-',
				$button,
			];
		}

		$output = [
			'draw'            => intval($_POST['draw'] ?? 0),
			'recordsTotal'    => $this->M_incoming->count_all_agents(),
			'recordsFiltered' => $this->M_incoming->count_filtered_agents(),
			'data'            => $data,
		];

		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($output));
	}

	public function edit_agent($uid)
	{
		$this->cb->select('a.*, u.nama as nama_pic');
		$this->cb->from('out_agent a');
		$this->cb->join($this->db->database . '.users u',      'u.nip = a.user_pic',    'left');
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

	public function store_agent()
	{
		// $kode = $this->input->post('kode_agent');
		$nama = $this->input->post('nama_agent');
		$alamat = $this->input->post('alamat_agent');
		$telepon = $this->input->post('telepon_agent');
		$pic_agent = $this->input->post('pic_agent');

		$data = [
			// 'kode'                          => $kode,
			'nama'                          => $nama,
			'alamat'                        => $alamat,
			'telepon'                       => $telepon,
			'user_pic' 							=> $pic_agent,
			// 'npwp'                          => $npwp,
			// 'post_date'                     => $post_dates,
			// 'user'                          => $this->session->userdata('nip'),
		];

		$uid = $this->input->post('uid'); // untuk edit

		if ($uid) {
			$this->M_incoming->update_agent($data, $uid);
			$this->session->set_flashdata('message_name', 'Agent berhasil diupdate.');
		} else {
			$signdate = time();
			$post_date1 = date("Ymd", $signdate);
			$post_date2 = date("His", $signdate);
			$post_dates = "$post_date1" . "$post_date2";

			$out_agent = $this->cb->select('MAX(CAST(kode AS UNSIGNED)) as kode')->from('out_agent')->get()->row();

			$no_mydisburse1 = $out_agent->kode;

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

			$this->M_incoming->insert_agent($data);
			$this->session->set_flashdata('message_name', 'Agent berhasil ditambahkan.');
		}

		redirect('incominghlp/daftar_agents');
	}

	public function agnet_hold($uid, $hold)
	{

		$data = [
			// 'kode'                          => $kode,
			'hold'                          => $hold,
			// 'npwp'                          => $npwp,
			// 'post_date'                     => $post_dates,
			// 'user'                          => $this->session->userdata('nip'),
		];


		$this->M_incoming->update_agent($data, $uid);

		if ($hold == '1') {
			$this->session->set_flashdata('message_name', 'Agent berhasil di Hold.');
		} else {
			$this->session->set_flashdata('message_name', 'Agent Ready.');
		}
		redirect('incominghlp/daftar_agents');
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

		$data['title'] = "Daftar Agents";

		$out_agent = $this->cb->select('MAX(CAST(kode AS UNSIGNED)) as kode')->from('in_agent')->get()->row();

		$this->load->view('in_daftar_agents_deposit', $data);
	}

	public function getData_agents_deposit()
	{
		$results = $this->M_incoming->get_datatables_agents_deposit();
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

				$button_hold = "<a class='btn btn-sm btn-success' href='" . base_url() . "incominghlp/agent_deposit_hold/{$r->uid}/0'>
        <i class='fa fa-check'></i> Ready</a>";
			} else {
				$hold = "<span class='btn btn-sm' style='color:#5cb85c; border:1px solid #5cb85c; background:transparent;'>Ready</span> ";
				$button_hold = "<a class='btn btn-sm btn-danger' href='" . base_url() . "incominghlp/agent_deposit_hold/{$r->uid}/1'>
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
				$r->npwp ?? '-',
				$r->user_name ?? '-',
				$tanggal_txt ?? '-',
				$hold ?? '-',
				$button,
			];
		}

		$output = [
			'draw'            => intval($_POST['draw'] ?? 0),
			'recordsTotal'    => $this->M_incoming->count_all_agents_deposit(),
			'recordsFiltered' => $this->M_incoming->count_filtered_agents_deposit(),
			'data'            => $data,
		];

		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($output));
	}

	public function edit_agent_deposit($uid)
	{
		$this->cb->select('a.*, u.nama as nama_pic');
		$this->cb->from('in_agent_deposit a');
		$this->cb->join($this->db->database . '.users u',      'u.nip = a.user_pic',    'left');
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
		$pic_agent = $this->input->post('pic_agent');

		$data = [
			// 'kode'                          => $kode,
			'nama'                          => $nama,
			'alamat'                        => $alamat,
			'telepon'                       => $telepon,
			'user_pic' 							=> $pic_agent,
			// 'npwp'                          => $npwp,
			// 'post_date'                     => $post_dates,
			// 'user'                          => $this->session->userdata('nip'),
		];

		$uid = $this->input->post('uid'); // untuk edit

		if ($uid) {
			$this->M_incoming->update_agent_deposit($data, $uid);
			$this->session->set_flashdata('message_name', 'Agent berhasil diupdate.');
		} else {
			$signdate = time();
			$post_date1 = date("Ymd", $signdate);
			$post_date2 = date("His", $signdate);
			$post_dates = "$post_date1" . "$post_date2";

			$in_agent = $this->cb->select('MAX(CAST(kode AS UNSIGNED)) as kode')->from('in_agent_deposit')->get()->row();

			$no_mydisburse1 = $in_agent->kode;

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

			$this->M_incoming->insert_agent_deposit($data);
			$this->session->set_flashdata('message_name', 'Agent berhasil ditambahkan.');
		}

		redirect('incominghlp/daftar_agents_deposit');
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


		$this->M_incoming->update_agent_deposit($data, $uid);

		if ($hold == '1') {
			$this->session->set_flashdata('message_name', 'Agent berhasil di Hold.');
		} else {
			$this->session->set_flashdata('message_name', 'Agent Ready.');
		}
		redirect('incominghlp/daftar_agents_deposit');
	}


	// DAFTAR ASAL
	public function daftar_asal()
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

		$data['title'] = "Daftar Asal";


		$this->load->view('in_daftar_asal', $data);
	}

	public function getData_asal()
	{
		$results = $this->M_incoming->get_datatables_asal();
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


			// 	if ($r->status == '1') {
			// 		$hold = "<span class='btn btn-sm' style='color:#5cb85c; border:1px solid #5cb85c; background:transparent;'>Ready</span> ";
			// 		$button_hold = "<a class='btn btn-sm btn-danger' href='" . base_url() . "incominghlp/pengirim_hold/{$r->uid}/0'>
			// <i class='fa fa-remove'></i> Hold</a>";
			// 	} else {
			// 		$hold = "<span class='btn btn-sm' style='color:#d9534f; border:1px solid #d9534f; background:transparent;'>Hold</span> ";
			// 		$button_hold = "<a class='btn btn-sm btn-success' href='" . base_url() . "incominghlp/pengirim_hold/{$r->uid}/1'>
			// <i class='fa fa-check'></i> Ready</a>";
			// 	}

			$button_edit = "<a class='btn btn-sm btn-warning btn-edit' data-uid='{$r->uid}'>
        <i class='fa fa-pencil'></i> Edit</a>";

			// $button = $button_hold . ' ' . $button_edit;



			$data[] = [
				// $r->uid,
				$r->kode,
				$r->kode_kota,
				$r->nama,
				$r->user_name ?? '-',
				$tanggal_txt ?? '-',
				$button_edit,
			];
		}

		$output = [
			'draw'            => intval($_POST['draw'] ?? 0),
			'recordsTotal'    => $this->M_incoming->count_all_asal(),
			'recordsFiltered' => $this->M_incoming->count_filtered_asal(),
			'data'            => $data,
		];

		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($output));
	}

	public function edit_asal($uid)
	{
		$this->cb->from('in_asal');
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

	public function store_asal()
	{
		// $kode = $this->input->post('kode_asal');
		$kode_kota = $this->input->post('kode_kota_asal');
		$nama = $this->input->post('nama_asal');

		$data = [
			// 'kode'                          => $kode,
			'kode_kota'                          => $kode_kota,
			'nama'                        => $nama,
			// 'npwp'                          => $npwp,
			// 'post_date'                     => $post_dates,
			// 'user'                          => $this->session->userdata('nip'),
		];

		$uid = $this->input->post('uid'); // untuk edit

		if ($uid) {
			$this->M_incoming->update_asal($data, $uid);
			$this->session->set_flashdata('message_name', 'Tujuan berhasil diupdate.');
		} else {
			$signdate = time();
			$post_date1 = date("Ymd", $signdate);
			$post_date2 = date("His", $signdate);
			$post_dates = "$post_date1" . "$post_date2";

			$in_asal = $this->cb->select('MAX(CAST(kode AS UNSIGNED)) as kode')->from('in_asal')->get()->row();

			$no_mydisburse1 = $in_asal->kode;

			if ($no_mydisburse1 > 0) {
				$disburse1 = $no_mydisburse1 + 1;
				$nodis1 = sprintf("%05d", $disburse1); // Diubah jadi %05d agar menghasilkan 5 digit
				$no = $nodis1;
			} else {
				$no = "00001"; // Tetap 5 digit
			}

			$data['user_code']  = $this->session->userdata('nip');
			$data['post_date'] = $post_dates;
			$data['kode'] = $no;

			$this->M_incoming->insert_asal($data);
			$this->session->set_flashdata('message_name', 'Tujuan berhasil ditambahkan.');
		}

		redirect('incominghlp/daftar_asal');
	}

	// DAFTAR PENERIMA
	public function daftar_penerima()
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

		$data['title'] = "Daftar Asal";


		$this->load->view('in_daftar_penerima', $data);
	}

	public function getData_penerima()
	{
		$results = $this->M_incoming->get_datatables_penerima();
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


			// 	if ($r->status == '1') {
			// 		$hold = "<span class='btn btn-sm' style='color:#5cb85c; border:1px solid #5cb85c; background:transparent;'>Ready</span> ";
			// 		$button_hold = "<a class='btn btn-sm btn-danger' href='" . base_url() . "incominghlp/pengirim_hold/{$r->uid}/0'>
			// <i class='fa fa-remove'></i> Hold</a>";
			// 	} else {
			// 		$hold = "<span class='btn btn-sm' style='color:#d9534f; border:1px solid #d9534f; background:transparent;'>Hold</span> ";
			// 		$button_hold = "<a class='btn btn-sm btn-success' href='" . base_url() . "incominghlp/pengirim_hold/{$r->uid}/1'>
			// <i class='fa fa-check'></i> Ready</a>";
			// 	}

			$button_edit = "<a class='btn btn-sm btn-warning btn-edit' data-uid='{$r->uid}'>
        <i class='fa fa-pencil'></i> Edit</a><a class='btn btn-sm btn-danger btn-delete' data-uid='{$r->uid}'>
        <i class='fa fa-trash'></i> Delete</a>";

			// $button = $button_hold . ' ' . $button_edit;



			$data[] = [
				// $r->uid,
				$r->kode,
				$r->nama,
				$r->telepon,
				$r->alamat,
				$r->user_name ?? '-',
				$tanggal_txt ?? '-',
				$button_edit,
			];
		}

		$output = [
			'draw'            => intval($_POST['draw'] ?? 0),
			'recordsTotal'    => $this->M_incoming->count_all_penerima(),
			'recordsFiltered' => $this->M_incoming->count_filtered_penerima(),
			'data'            => $data,
		];

		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($output));
	}

	public function edit_penerima($uid)
	{
		$this->cb->from('in_penerima');
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

	public function delete_penerima()
	{
		$uid = $this->input->post('uid');
		$delete = $this->cb->where('uid', $uid)->delete('in_penerima');

		if (!$delete) {
			echo json_encode(['status' => 'error', 'message' => 'Data Gagal dihapus.']);
			return;
		}

		$this->output
			->set_content_type('application/json')
			->set_output(json_encode(['status' => 'success', 'message' => 'Data berhasil dihapus.']));
	}

	public function store_penerima()
	{
		$nama = $this->input->post('nama_penerima');
		$telepon = $this->input->post('nomor_telepon');
		$alamat = $this->input->post('alamat');

		$data = [
			// 'kode'                          => $kode,
			'nama'                        => $nama,
			'telepon'                       => $telepon,
			'alamat'                        => $alamat,
			// 'npwp'                          => $npwp,
			// 'post_date'                     => $post_dates,
			// 'user'                          => $this->session->userdata('nip'),
		];

		$uid = $this->input->post('uid'); // untuk edit

		if ($uid) {
			$this->M_incoming->update_penerima($data, $uid);
			$this->session->set_flashdata('message_name', 'Penerima berhasil diupdate.');
		} else {
			$signdate = time();
			$post_date1 = date("Ymd", $signdate);
			$post_date2 = date("His", $signdate);
			$post_dates = "$post_date1" . "$post_date2";

			$in_penerima = $this->cb->select('MAX(CAST(kode AS UNSIGNED)) as kode')->from('in_penerima')->get()->row();

			$no_mydisburse1 = $in_penerima->kode;

			if ($no_mydisburse1 > 0) {
				$disburse1 = $no_mydisburse1 + 1;
				$nodis1 = sprintf("%05d", $disburse1); // Diubah jadi %05d agar menghasilkan 5 digit
				$no = $nodis1;
			} else {
				$no = "00001"; // Tetap 5 digit
			}

			$data['user_code']  = $this->session->userdata('nip');
			$data['post_date'] = $post_dates;
			$data['kode'] = $no;

			$this->M_incoming->insert_penerima($data);
			$this->session->set_flashdata('message_name', 'Penerima berhasil ditambahkan.');
		}

		redirect('incominghlp/daftar_penerima');
	}


	// DAFTAR AVSEC
	public function daftar_avsec()
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

		$data['title'] = "Daftar Avsec";


		$this->load->view('in_daftar_avsec', $data);
	}

	public function getData_avsec()
	{
		$results = $this->M_incoming->get_datatables_avsec();
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

				$button_hold = "<a class='btn btn-sm btn-success' href='" . base_url() . "incominghlp/avsec_hold/{$r->uid}/0'>
        <i class='fa fa-check'></i> Ready</a>";
			} else {
				$hold = "<span class='btn btn-sm' style='color:#5cb85c; border:1px solid #5cb85c; background:transparent;'>Ready</span> ";
				$button_hold = "<a class='btn btn-sm btn-danger' href='" . base_url() . "incominghlp/avsec_hold/{$r->uid}/1'>
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
				$r->user_name ?? '-',
				$tanggal_txt ?? '-',
				$hold ?? '-',
				$button,
			];
		}

		$output = [
			'draw'            => intval($_POST['draw'] ?? 0),
			'recordsTotal'    => $this->M_incoming->count_all_avsec(),
			'recordsFiltered' => $this->M_incoming->count_filtered_avsec(),
			'data'            => $data,
		];

		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($output));
	}

	public function edit_avsec($uid)
	{
		$this->cb->from('out_avsec');
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

	public function store_avsec()
	{
		$nik = $this->input->post('nik_avsec');
		$nama = $this->input->post('nama_avsec');
		$alamat = $this->input->post('alamat_avsec');
		$telepon = $this->input->post('telepon_avsec');

		$data = [
			// 'kode'                          => $kode,
			'nik'                          => $nik,
			'nama'                          => $nama,
			'alamat'                        => $alamat,
			'telepon'                       => $telepon,
			// 'npwp'                          => $npwp,
			// 'post_date'                     => $post_dates,
			// 'user'                          => $this->session->userdata('nip'),
		];

		$uid = $this->input->post('uid'); // untuk edit

		if ($uid) {
			$this->M_incoming->update_avsec($data, $uid);
			$this->session->set_flashdata('message_name', 'Avsec berhasil diupdate.');
		} else {
			$signdate = time();
			$post_date1 = date("Ymd", $signdate);
			$post_date2 = date("His", $signdate);
			$post_dates = "$post_date1" . "$post_date2";

			$out_avsec = $this->cb->select('MAX(CAST(kode AS UNSIGNED)) as kode')->from('out_avsec')->get()->row();

			$no_mydisburse1 = $out_avsec->kode;

			if ($no_mydisburse1 > 0) {
				$disburse1 = $no_mydisburse1 + 1;
				$nodis1 = sprintf("%05d", $disburse1); // Diubah jadi %05d agar menghasilkan 5 digit
				$no = $nodis1;
			} else {
				$no = "00001"; // Tetap 5 digit
			}

			$data['user_code']  = $this->session->userdata('nip');
			$data['post_date'] = $post_dates;
			$data['kode'] = $no;

			$this->M_incoming->insert_avsec($data);
			$this->session->set_flashdata('message_name', 'Avsec berhasil ditambahkan.');
		}

		redirect('incominghlp/daftar_avsec');
	}

	public function avsec_hold($uid, $hold)
	{

		$data = [
			// 'kode'                          => $kode,
			'hold'                          => $hold,
			// 'npwp'                          => $npwp,
			// 'post_date'                     => $post_dates,
			// 'user'                          => $this->session->userdata('nip'),
		];


		$this->M_incoming->update_avsec($data, $uid);

		if ($hold == '1') {
			$this->session->set_flashdata('message_name', 'Avsec berhasil di Hold.');
		} else {
			$this->session->set_flashdata('message_name', 'Avsec Ready.');
		}
		redirect('incominghlp/daftar_avsec');
	}

	// DAFTAR DRIVER
	public function daftar_driver()
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

		$data['title'] = "Daftar Driver";


		$this->load->view('in_daftar_driver', $data);
	}

	public function getData_driver()
	{
		$results = $this->M_incoming->get_datatables_driver();
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

				$button_hold = "<a class='btn btn-sm btn-success' href='" . base_url() . "incominghlp/driver_hold/{$r->uid}/0'>
        <i class='fa fa-check'></i> Ready</a>";
			} else {
				$hold = "<span class='btn btn-sm' style='color:#5cb85c; border:1px solid #5cb85c; background:transparent;'>Ready</span> ";
				$button_hold = "<a class='btn btn-sm btn-danger' href='" . base_url() . "incominghlp/driver_hold/{$r->uid}/1'>
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
				$r->user_name ?? '-',
				$tanggal_txt ?? '-',
				$hold ?? '-',
				$button,
			];
		}

		$output = [
			'draw'            => intval($_POST['draw'] ?? 0),
			'recordsTotal'    => $this->M_incoming->count_all_driver(),
			'recordsFiltered' => $this->M_incoming->count_filtered_driver(),
			'data'            => $data,
		];

		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($output));
	}

	public function edit_driver($uid)
	{
		$this->cb->select('a.*');
		$this->cb->from('out_driver a');
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

	public function store_driver()
	{
		// $kode = $this->input->post('kode_driver');
		$nama = $this->input->post('nama_driver');
		$alamat = $this->input->post('alamat_driver');
		$telepon = $this->input->post('telepon_driver');

		$data = [
			// 'kode'                          => $kode,
			'nama'                          => $nama,
			'alamat'                        => $alamat,
			'telepon'                       => $telepon,
			// 'npwp'                          => $npwp,
			// 'post_date'                     => $post_dates,
			// 'user'                          => $this->session->userdata('nip'),
		];

		$uid = $this->input->post('uid'); // untuk edit

		if ($uid) {
			$this->M_incoming->update_driver($data, $uid);
			$this->session->set_flashdata('message_name', 'Driver berhasil diupdate.');
		} else {
			$signdate = time();
			$post_date1 = date("Ymd", $signdate);
			$post_date2 = date("His", $signdate);
			$post_dates = "$post_date1" . "$post_date2";

			$out_driver = $this->cb->select('MAX(CAST(kode AS UNSIGNED)) as kode')->from('out_driver')->get()->row();

			$no_mydisburse1 = $out_driver->kode;

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

			$this->M_incoming->insert_driver($data);
			$this->session->set_flashdata('message_name', 'Driver berhasil ditambahkan.');
		}

		redirect('incominghlp/daftar_driver');
	}

	public function driver_hold($uid, $hold)
	{

		$data = [
			// 'kode'                          => $kode,
			'hold'                          => $hold,
			// 'npwp'                          => $npwp,
			// 'post_date'                     => $post_dates,
			// 'user'                          => $this->session->userdata('nip'),
		];


		$this->M_incoming->update_driver($data, $uid);

		if ($hold == '1') {
			$this->session->set_flashdata('message_name', 'Driver berhasil di Hold.');
		} else {
			$this->session->set_flashdata('message_name', 'Driver Ready.');
		}
		redirect('incominghlp/daftar_driver');
	}

	// DAFTAR DRIVER
	public function daftar_truck()
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

		$data['title'] = "Daftar Driver";


		$this->load->view('in_daftar_truck', $data);
	}

	public function getData_truck()
	{
		$results = $this->M_incoming->get_datatables_truck();
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

				$button_hold = "<a class='btn btn-sm btn-success' href='" . base_url() . "incominghlp/truck_hold/{$r->uid}/0'>
        <i class='fa fa-check'></i> Ready</a>";
			} else {
				$hold = "<span class='btn btn-sm' style='color:#5cb85c; border:1px solid #5cb85c; background:transparent;'>Ready</span> ";
				$button_hold = "<a class='btn btn-sm btn-danger' href='" . base_url() . "incominghlp/truck_hold/{$r->uid}/1'>
        <i class='fa fa-remove'></i> Hold</a>";
			}

			$button_edit = "<a class='btn btn-sm btn-warning btn-edit' data-uid='{$r->uid}'>
        <i class='fa fa-pencil'></i> Edit</a>";

			$button = $button_hold . ' ' . $button_edit;



			$data[] = [
				// $r->uid,
				$r->kode,
				$r->merk,
				$r->no_polisi,
				$r->user_name ?? '-',
				$tanggal_txt ?? '-',
				$hold ?? '-',
				$button,
			];
		}

		$output = [
			'draw'            => intval($_POST['draw'] ?? 0),
			'recordsTotal'    => $this->M_incoming->count_all_truck(),
			'recordsFiltered' => $this->M_incoming->count_filtered_truck(),
			'data'            => $data,
		];

		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($output));
	}

	public function edit_truck($uid)
	{
		$this->cb->select('a.*');
		$this->cb->from('out_truck a');
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

	public function store_truck()
	{
		// $kode = $this->input->post('kode_truck');
		$merk = $this->input->post('nama_truck');
		$no_polisi = $this->input->post('alamat_truck');

		$data = [
			// 'kode'                          => $kode,
			'merk'                          => $merk,
			'no_polisi'                        => $no_polisi,
			// 'npwp'                          => $npwp,
			// 'post_date'                     => $post_dates,
			// 'user'                          => $this->session->userdata('nip'),
		];

		$uid = $this->input->post('uid'); // untuk edit

		if ($uid) {
			$this->M_incoming->update_truck($data, $uid);
			$this->session->set_flashdata('message_name', 'Truck berhasil diupdate.');
		} else {
			$signdate = time();
			$post_date1 = date("Ymd", $signdate);
			$post_date2 = date("His", $signdate);
			$post_dates = "$post_date1" . "$post_date2";

			$out_truck = $this->cb->select('MAX(CAST(kode AS UNSIGNED)) as kode')->from('out_truck')->get()->row();

			$no_mydisburse1 = $out_truck->kode;

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

			$this->M_incoming->insert_truck($data);
			$this->session->set_flashdata('message_name', 'Truck berhasil ditambahkan.');
		}

		redirect('incominghlp/daftar_truck');
	}

	public function truck_hold($uid, $hold)
	{

		$data = [
			// 'kode'                          => $kode,
			'hold'                          => $hold,
			// 'npwp'                          => $npwp,
			// 'post_date'                     => $post_dates,
			// 'user'                          => $this->session->userdata('nip'),
		];


		$this->M_incoming->update_truck($data, $uid);

		if ($hold == '1') {
			$this->session->set_flashdata('message_name', 'Truck berhasil di Hold.');
		} else {
			$this->session->set_flashdata('message_name', 'Truck Ready.');
		}
		redirect('incominghlp/daftar_truck');
	}

	// DAFTAR KATEGORI HARGA
	public function kategori_harga()
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

		$data['title'] = "Daftar Kategori Harga";


		$this->load->view('in_daftar_kategori_harga', $data);
	}

	public function getData_kategori_harga()
	{
		$results = $this->M_incoming->get_datatables_kategori_harga();
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

			if ($r->jenis_billing == "0") {
				$jenis_billing = 'Umum';
			} else if ($r->jenis_billing == "1") {
				$jenis_billing = 'Transit';
			} else {
				$jenis_billing = '';
			}


			if ($r->hold == '1') {
				$hold = "<span class='btn btn-sm' style='color:#d9534f; border:1px solid #d9534f; background:transparent;'>Hold</span> ";

				$button_hold = "<a class='btn btn-sm btn-success' href='" . base_url() . "incominghlp/kategori_harga_hold/{$r->uid}/0'>
        <i class='fa fa-check'></i> Ready</a>";
			} else {
				$hold = "<span class='btn btn-sm' style='color:#5cb85c; border:1px solid #5cb85c; background:transparent;'>Ready</span> ";
				$button_hold = "<a class='btn btn-sm btn-danger' href='" . base_url() . "incominghlp/kategori_harga_hold/{$r->uid}/1'>
        <i class='fa fa-remove'></i> Hold</a>";
			}

			$button_edit = "<a class='btn btn-sm btn-warning btn-edit' data-uid='{$r->uid}'>
        <i class='fa fa-pencil'></i> Edit</a>";

			$button = $button_hold . ' ' . $button_edit;

			$data[] = [
				// $r->uid,
				$r->kode,
				$jenis_billing,
				$r->nama_billing,
				$r->csc,
				$r->kade,
				$r->sewa_gudang,
				$r->user_name ?? '-',
				$tanggal_txt ?? '-',
				$hold ?? '-',
				$button,
			];
		}

		$output = [
			'draw'            => intval($_POST['draw'] ?? 0),
			'recordsTotal'    => $this->M_incoming->count_all_kategori_harga(),
			'recordsFiltered' => $this->M_incoming->count_filtered_kategori_harga(),
			'data'            => $data,
		];

		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($output));
	}

	public function edit_kategori_harga($uid)
	{
		$this->cb->from('in_bill_catg');
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

	public function store_kategori_harga()
	{

		$jenis_billing = $this->input->post('jenis_billing');
		$nama_billing = $this->input->post('nama_billing');
		$csc = $this->input->post('csc');
		$kade = $this->input->post('kade');
		$sewa_gudang = $this->input->post('sewa_gudang');
		// $jasa_ra = $this->input->post('jasa_ra');






		$data = [
			'jenis_billing'                          => $jenis_billing,
			'nama_billing'                          => $nama_billing,
			'csc'                        => $csc,
			'kade'                       => $kade,
			'sewa_gudang'                        => $sewa_gudang,
			// 'jasa_ra'                       => $jasa_ra,

		];

		$uid = $this->input->post('uid'); // untuk edit

		if ($uid) {
			$this->M_incoming->update_kategori_harga($data, $uid);
			$this->session->set_flashdata('message_name', 'Kategori Harga berhasil diupdate.');
		} else {
			$signdate = time();
			$post_date1 = date("Ymd", $signdate);
			$post_date2 = date("His", $signdate);
			$post_dates = "$post_date1" . "$post_date2";

			$out_bill_catg = $this->cb->select('MAX(CAST(kode AS UNSIGNED)) as kode')->from('out_bill_catg')->get()->row();

			$no_mydisburse1 = $out_bill_catg->kode;

			if ($no_mydisburse1 > 0) {
				$disburse1 = $no_mydisburse1 + 1;
				$nodis1 = sprintf("%05d", $disburse1); // Diubah jadi %05d agar menghasilkan 5 digit
				$no = $nodis1;
			} else {
				$no = "00001"; // Tetap 5 digit
			}

			$data['user']  = $this->session->userdata('nip');
			$data['post_date'] = $post_dates;
			$data['kode'] = $no;

			$this->M_incoming->insert_kategori_harga($data);
			$this->session->set_flashdata('message_name', 'Kategori Harga berhasil ditambahkan.');
		}

		redirect('incominghlp/kategori_harga');
	}

	public function kategori_harga_hold($uid, $hold)
	{

		$data = [
			// 'kode'                          => $kode,
			'hold'                          => $hold,
			// 'npwp'                          => $npwp,
			// 'post_date'                     => $post_dates,
			// 'user'                          => $this->session->userdata('nip'),
		];


		$this->M_incoming->update_kategori_harga($data, $uid);

		if ($hold == '1') {
			$this->session->set_flashdata('message_name', 'Kategori Harga berhasil di Hold.');
		} else {
			$this->session->set_flashdata('message_name', 'Kategori Harga Ready.');
		}
		redirect('incominghlp/kategori_harga');
	}
}
