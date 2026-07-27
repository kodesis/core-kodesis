<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Outgoinghlp extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->library(['session', 'pagination']);
		$this->load->helper(['string', 'url', 'date', 'number']);
		$this->load->model(['M_outgoing', 'm_coa', 'm_invoice',]);

		$this->cb = $this->load->database('corebank', TRUE);
		// $this->load->helper('terbilang');

		if (!$this->session->userdata('nip')) {
			redirect('login');
		}
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

	public function daftar_csd()
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

		$data['title'] = "Daftar CSD";

		// $data['customers'] = $this->M_outgoing->kemasan_smu();

		$this->load->view('daftar_csd', $data);
	}

	public function getData_csd()
	{
		$results = $this->M_outgoing->get_datatables();
		$data    = [];

		$no = 0;
		foreach ($results as $r) {

			if ($r->jaster == '1') {
				$jaster = "<span class='btn btn-sm' style='color:#5cb85c; border:1px solid #5cb85c; background:transparent;'>Jaster</span> ";
			} else {
				$jaster = "<span class='btn btn-sm' style='color:#d9534f; border:1px solid #d9534f; background:transparent;'>No Jaster</span> ";
			}

			// <button class='btn btn-sm btn-primary btn-do' data-uid='{$r->uid}'>
			//     <i class='fa fa-send'> ke DO</i>
			// </button>
			$kemasan = '';
			// 		if ($r->is_kemasan_smu != '1') {
			// 			$kemasan = "<button class='btn btn-sm btn-primary btn-migrate' data-uid='{$r->uid}' data-smu='{$r->smu}'>
			//     <i class='fa fa-send'></i> ke Kemasan SMU
			// </button>";
			// 		}
			$aksi = $kemasan . "
    <button class='btn btn-sm btn-warning btn-edit' data-uid='{$r->uid}'>
        <i class='fa fa-pencil'> Edit</i>
    </button>
";

			$print = "<a target='_blank' class='btn btn-sm btn-primary' href='" . base_url() . "outgoinghlp/print_csd/{$r->uid}'>
        <i class='fa fa-print'></i> CSD</a>";

			$data[] = [
				$r->csd_num,
				$r->no_csd,
				$r->smu,
				$r->no_pesawat ?? '-',
				$r->tanggal_terbang ?? '-',
				$r->komoditi ?? '-',
				$r->koli_smu ?? '-',
				$r->berat_smu ?? '-',
				$r->tgl_csd ?? '-',
				$jaster,
				$print,
				$aksi,
			];
		}

		$output = [
			'draw'            => intval($_POST['draw'] ?? 0),
			'recordsTotal'    => $this->M_outgoing->count_all(),
			'recordsFiltered' => $this->M_outgoing->count_filtered(),
			'data'            => $data,
		];

		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($output));
	}

	public function daftar_csd_actual()
	{
		$nip = $this->session->userdata('nip');

		// Counter Inbox Memo
		$sql = "SELECT COUNT(Id) FROM memo WHERE (nip_kpd LIKE '%$nip%' OR nip_cc LIKE '%$nip%') AND (`read` NOT LIKE '%$nip%');";
		$query = $this->db->query($sql);
		$res2 = $query->result_array();
		$result = $res2[0]['COUNT(Id)'];

		// Counter Task Active
		$sql2 = "SELECT COUNT(id) FROM task WHERE (`member` LIKE '%$nip%' OR `pic` LIKE '%$nip%') AND activity='1'";
		$query2 = $this->db->query($sql2);
		$res3 = $query2->result_array();
		$result2 = $res3[0]['COUNT(id)'];

		$data['count_inbox'] = $result;
		$data['count_inbox2'] = $result2;
		$data['title'] = "Daftar CSD Actual";

		$this->load->view('daftar_csd_actual', $data);
	}

	// =========================================================================
	// 2. DATA TABLES HANDLER: GET DATA CSD ACTUAL (SERVER SIDE DARI ra_csd)
	// =========================================================================
	public function getData_csd_actual()
	{
		$results = $this->M_outgoing->get_datatables_csd_actual();
		$data    = [];

		foreach ($results as $r) {
			// Render Jaster Badge
			if ($r->jaster == '1') {
				$jaster = "<span class='btn btn-xs' style='color:#5cb85c; border:1px solid #5cb85c; background:transparent; padding: 2px 6px;'>Jaster</span>";
			} else {
				$jaster = "<span class='btn btn-xs' style='color:#d9534f; border:1px solid #d9534f; background:transparent; padding: 2px 6px;'>No Jaster</span>";
			}

			// Memeriksa keberadaan data CSD
			if (empty($r->csd_uid)) {
				// Belum ada CSD
				$no_csd_badge = "<span class='label label-default' style='font-size:10px;'>Belum Ada CSD</span>";
				// $print = "<button class='btn btn-sm btn-default' disabled><i class='fa fa-print'></i> CSD</button>";
				$print = "<button class='btn btn-sm btn-default' disabled><i class='fa fa-print'></i> CSD JASTER</button><button class='btn btn-sm btn-default' disabled><i class='fa fa-print'></i> CSD RA</button>";
				$aksi = "
                    <button class='btn btn-sm btn-success btn-buat' data-smu-uid='{$r->smu_uid_val}' title='Buat CSD Baru'>
                        <i class='fa fa-plus'></i> Buat CSD
                    </button>
                ";
			} else {
				// Sudah ada CSD
				$no_csd_badge = $r->no_csd;
				// $print = "
				//     <a target='_blank' class='btn btn-sm btn-primary' href='" . base_url() . "outgoinghlp/print_csd_actual/{$r->csd_uid}'>
				//         <i class='fa fa-print'></i> CSD
				//     </a>
				// ";

				$print = "
				    <a target='_blank' class='btn btn-sm btn-primary' href='" . base_url() . "outgoinghlp/print_csd_actual_isi/{$r->csd_uid}'>
				        <i class='fa fa-print'></i> CSD JASTER
				    </a><a target='_blank' class='btn btn-sm btn-primary' href='" . base_url() . "outgoinghlp/print_csd_actual_sementara/{$r->csd_uid}'>
				        <i class='fa fa-print'></i> CSD RA
				    </a>
				";

				$aksi = "
                    <button class='btn btn-sm btn-warning btn-edit' data-uid='{$r->csd_uid}' title='Edit CSD'>
                        <i class='fa fa-pencil'></i> Edit
                    </button>
                ";
			}

			if ($r->status_keamanan == '1') {
				$status_keamanan = "Passenger Aircraft (SPX)";
			} else if ($r->status_keamanan == '0') {
				$status_keamanan = "Cargo Aircraft Only (SCO)";
			} else {
				$status_keamanan = "-";
			}

			if ($r->methode_pemeriksaan == '1') {
				$methode_pemeriksaan = "X-Ray";
			} else if ($r->methode_pemeriksaan == '2') {
				$methode_pemeriksaan = "Physical Check";
			} else if ($r->methode_pemeriksaan == '3') {
				$methode_pemeriksaan = "X-Ray & Physical Check";
			} else {
				$methode_pemeriksaan = "-";
			}

			if ($r->alasan == '1') {
				$alasan_text = "CLEAR";
			} else {
				$alasan_text = "HOLD";
			}

			$data[] = [
				$r->csd_num ?? '-',
				$no_csd_badge,
				"<b>" . ($r->smu ?? '-') . "</b>",
				$r->komoditi ?? '-',
				$status_keamanan ?? '-',
				$methode_pemeriksaan ?? '-',
				$alasan_text,
				$r->tgl_csd ?? '-',
				$jaster,
				$print,
				$aksi
			];
		}

		$output = [
			'draw'            => intval($_POST['draw'] ?? 0),
			'recordsTotal'    => $this->M_outgoing->count_all_csd_actual(),
			'recordsFiltered' => $this->M_outgoing->count_filtered_csd_actual(),
			'data'            => $data,
		];

		return $this->output
			->set_content_type('application/json')
			->set_output(json_encode($output));
	}

	// =========================================================================
	// 3. DETAIL ENDPOINT UNTUK PROSES BUAT CSD (DATA BARU DARI out_list)
	// =========================================================================
	public function get_smu_detail_for_csd($smu_uid)
	{
		$this->cb->select("
            o.uid AS smu_uid_val,
            o.smu,
            o.no_pesawat,
            o.tanggal_terbang,
            o.komoditi,
            b.total_pieces as koli_smu,
            b.total_gross as berat_smu,
        	o.jaster,
            o.tujuan_uid,
            o.agent_uid,
            t.kode_kota, t.nama AS tujuan_nama,
            ag.nama AS agent_nama
        ")
			->from('out_list o')
			->join('out_tujuan t', 't.uid = o.tujuan_uid', 'left')
			->join('out_agent ag', 'ag.uid = o.agent_uid', 'left')
			->join('out_list_btb b', 'b.uid = o.btb_uid', 'left')
			->where('o.uid', $smu_uid);

		$data = $this->cb->get()->row();

		// Sediakan skema kosong default ra_csd agar JS form rendering tidak error
		if ($data) {
			$data->csd_uid = "";
			$data->no_csd = "";
			$data->status_keamanan = "";
			$data->methode_pemeriksaan = "";
			$data->methode_pemeriksaan_opsional = "";
			$data->no_segel = "";
			$data->no_sticker = "";
			$data->avsec_uid = "";
			$data->avsec_nama = "";
			$data->driver_uid = "";
			$data->driver_nama = "";
			$data->truck_uid = "";
			$data->truck_no_polisi = "";
		}

		return $this->output
			->set_content_type('application/json')
			->set_output(json_encode($data));
	}

	// =========================================================================
	// 4. EDIT CSD ACTUAL METHOD: GET SINGLE RECORD DATA
	// =========================================================================
	public function edit_csd_actual($uid)
	{
		$this->cb->select("
            c.*, 
            c.uid AS csd_uid,
            o.uid AS smu_uid_val,
            o.smu,
            o.no_pesawat,
            o.tanggal_terbang,
            o.komoditi,
            b.total_pieces as koli_smu,
            b.total_gross as berat_smu,
            o.jaster,
            o.tujuan_uid,
            o.agent_uid,
            t.kode_kota, t.nama AS tujuan_nama,
            av.nama AS avsec_nama,
            ag.nama AS agent_nama,
            dr.nama AS driver_nama,
            tr.no_polisi AS truck_no_polisi
        ")
			->from('ra_csd c')
			->join('out_list o', 'o.uid = c.smu_uid', 'left')
			->join('out_list_btb b', 'b.uid = o.btb_uid', 'left')
			->join('out_tujuan t', 't.uid = o.tujuan_uid', 'left')
			->join('out_avsec av', 'av.uid = c.avsec_uid', 'left')
			->join('out_agent ag', 'ag.uid = o.agent_uid', 'left')
			->join('out_driver dr', 'dr.uid = c.driver_uid', 'left')
			->join('out_truck tr', 'tr.uid = c.truck_uid', 'left')
			->where('c.uid', $uid);

		$data = $this->cb->get()->row();

		return $this->output
			->set_content_type('application/json')
			->set_output(json_encode($data));
	}

	// =========================================================================
	// 5. ACTION PROCESSOR: UPDATE / INSERT DATA CSD ACTUAL (ra_csd & out_list)
	// =========================================================================
	public function update_csd_actual()
	{
		$csd_uid = $this->input->post('csd_uid');
		$smu_uid = $this->input->post('smu_uid');

		$data_csd = [
			'status_keamanan'              => $this->input->post('status_keamanan'),
			'methode_pemeriksaan'          => $this->input->post('methode_pemeriksaan'),
			'methode_pemeriksaan_opsional' => $this->input->post('methode_pemeriksaan_opsional'),
			'alasan'                       => $this->input->post('alasan'), // Menyimpan alasan terpilih
			'avsec_uid'                    => $this->input->post('upd_avsec_uid'),
			'no_segel'                     => $this->input->post('no_segel'),
			'no_sticker'                   => $this->input->post('no_sticker'),
			'driver_uid'                   => $this->input->post('driver_uid') ?: null,
			'truck_uid'                    => $this->input->post('truck_uid') ?: null,
			'tgl_csd'                      => date('Y-m-d'),
			'post_date'                    => date('YmdHis'),
			'user'                         => $this->session->userdata('nama')
		];

		// Membagi Aksi INSERT Baru atau UPDATE
		if (empty($csd_uid)) {
			// INSERT Baru
			$data_csd['smu_uid'] = $smu_uid;
			$data_csd['branch_code'] = 'CORP_03';

			// Menghitung penomoran CSD otomatis
			$signdate = time();
			$my = date("my", $signdate);

			$query_max = $this->cb->select_max('no')->get('ra_csd')->row();
			$max_no = $query_max->no ?? 0;
			$next_no = sprintf("%06d", intval($max_no) + 1);

			$data_csd['no'] = $next_no;
			$data_csd['no_csd'] = "BDT.CSD." . $my . $next_no;
			$data_csd['csd_num'] = $next_no;

			$process = $this->cb->insert('ra_csd', $data_csd);
		} else {
			// UPDATE
			$no_csd_input = $this->input->post('no_csd');
			if (!empty($no_csd_input)) {
				$data_csd['no_csd'] = $no_csd_input;
			}
			$this->cb->where('uid', $csd_uid);
			$process = $this->cb->update('ra_csd', $data_csd);
		}
		if ($process) {
			$this->session->set_flashdata('message_name', 'Data CSD Actual Berhasil Diproses!');
		} else {
			$this->session->set_flashdata('message_error', 'Gagal Memproses Data CSD Actual.');
		}
		// Sinkronisasi Data ke out_list (flight info & cargo)
		// $data_list = [
		// 	'no_pesawat'      => $this->input->post('no_pesawat'),
		// 	'tanggal_terbang' => $this->input->post('tanggal_terbang'),
		// 	'komoditi'        => strtoupper($this->input->post('komoditi')),
		// 	// 'koli_smu'        => $this->input->post('jumlah'),
		// 	// 'berat_smu'       => $this->input->post('gross'),
		// 	'tujuan_uid'      => $this->input->post('tujuan'),
		// 	'agent_uid'       => $this->input->post('agent'),
		// 	'jaster'          => $this->input->post('jaster') == '1' ? '1' : '0'
		// ];

		// $this->cb->where('uid', $smu_uid);
		// $update = $this->cb->update('out_list', $data_list);

		// if ($update) {
		$this->session->set_flashdata('message_name', 'Data CSD Actual Berhasil Diproses!');
		// } else {
		// 	$this->session->set_flashdata('message_error', 'Gagal Memproses Data CSD Actual.');
		// }

		redirect('outgoinghlp/daftar_csd_actual');
	}

	public function print_csd_actual($uid)
	{
		// Query data utama menggabungkan ra_csd, out_list, out_list_btb, ra_avsec, out_agent, out_tujuan
		$this->cb->select('
            c.*, 
            c.uid AS csd_uid,
            o.uid AS smu_uid_val,
            o.smu,
            o.no_pesawat,
            o.tanggal_terbang,
            o.komoditi,
            b.total_pieces as koli_smu,
            b.total_gross as berat_smu,
            t.nama AS tujuan,
            av.nama AS avsec_nama,
            av.nik AS avsec_nik,
            ag.nama AS nama_agent
        ');
		$this->cb->from('ra_csd c');
		$this->cb->join('out_list o', 'o.uid = c.smu_uid', 'left');
		$this->cb->join('out_list_btb b', 'b.uid = o.btb_uid', 'left');
		$this->cb->join('out_tujuan t', 't.uid = o.tujuan_uid', 'left');
		$this->cb->join('out_avsec av', 'av.uid = c.avsec_uid', 'left');
		$this->cb->join('out_agent ag', 'ag.uid = o.agent_uid', 'left');
		$this->cb->where('c.uid', $uid);

		$row = $this->cb->get()->row();

		if (!$row) {
			show_error('Data CSD tidak ditemukan.', 404);
		}

		// Logika metode pemeriksaan utama
		$xray = '';
		if ($row->methode_pemeriksaan == '1') {
			$xray = 'XRAY LINE 1';
		} else if ($row->methode_pemeriksaan == '2') {
			$xray = 'XRAY LINE 2';
		} else {
			$xray = 'ETD';
		}

		// Logika metode pemeriksaan opsional / tambahan
		$metode = '';
		if ($row->methode_pemeriksaan_opsional == '1') {
			$metode = 'PERIKSA FISIK';
		} else if ($row->methode_pemeriksaan_opsional == '2') {
			$metode = 'ETD';
		} else {
			$metode = '-';
		}

		// Logika status alasan diterbitkan
		$alasan = '';
		if ($row->alasan == '1') {
			$alasan = 'CLEAR';
		} else if ($row->alasan == '2') {
			$alasan = 'REJECT';
		} else {
			$alasan = 'CLEAR';
		}

		// Penanganan penanggalan
		$tgl_csd_raw = $row->tgl_csd ?: date('Y-m-d');
		$tgl_cetak = date('d/m/Y', strtotime($tgl_csd_raw));
		$time2     = date('H:i:s', strtotime($tgl_csd_raw));

		// Checklist Status Keamanan SPX atau SCO
		$checklist = '<img src="' . base_url() . 'src/images/checklisticon.png" width="20">';

		$check_spx = $row->status_keamanan == '1' ? $checklist : '';
		$check_sco = $row->status_keamanan == '2' ? $checklist : '';

		$data = [
			'row'       => $row,
			'xray'      => $xray,
			'metode'    => $metode,
			'alasan'    => $alasan,
			'tgl_cetak' => $tgl_cetak,
			'time2'     => $time2,
			'check_spx' => $check_spx,
			'check_sco' => $check_sco,
			'checklist' => $checklist,
		];

		// Memuat view cetak CSD Actual
		$this->load->view('print_csd_actual', $data);
	}

	public function print_csd_actual_isi($uid)
	{
		// Query data utama menggabungkan ra_csd, out_list, out_list_btb, ra_avsec, out_agent, out_tujuan
		$this->cb->select('
            c.*, 
            c.uid AS csd_uid,
            o.uid AS smu_uid_val,
            o.smu,
            o.no_pesawat,
            o.tanggal_terbang,
            o.komoditi,
            b.total_pieces as koli_smu,
            b.total_gross as berat_smu,
            t.nama AS tujuan,
            av.nama AS avsec_nama,
            av.nik AS avsec_nik,
            ag.nama AS nama_agent
        ');
		$this->cb->from('ra_csd c');
		$this->cb->join('out_list o', 'o.uid = c.smu_uid', 'left');
		$this->cb->join('out_list_btb b', 'b.uid = o.btb_uid', 'left');
		$this->cb->join('out_tujuan t', 't.uid = o.tujuan_uid', 'left');
		$this->cb->join('out_avsec av', 'av.uid = c.avsec_uid', 'left');
		$this->cb->join('out_agent ag', 'ag.uid = o.agent_uid', 'left');
		$this->cb->where('c.uid', $uid);

		$row = $this->cb->get()->row();

		if (!$row) {
			show_error('Data CSD tidak ditemukan.', 404);
		}

		// Logika metode pemeriksaan utama
		$xray = '';
		if ($row->methode_pemeriksaan == '1') {
			$xray = 'XRAY LINE 1';
		} else if ($row->methode_pemeriksaan == '2') {
			$xray = 'XRAY LINE 2';
		} else {
			$xray = 'ETD';
		}

		// Logika metode pemeriksaan opsional / tambahan
		$metode = '';
		if ($row->methode_pemeriksaan_opsional == '1') {
			$metode = 'PERIKSA FISIK';
		} else if ($row->methode_pemeriksaan_opsional == '2') {
			$metode = 'ETD';
		} else {
			$metode = '-';
		}

		// Logika status alasan diterbitkan
		$alasan = '';
		if ($row->alasan == '1') {
			$alasan = 'CLEAR';
		} else if ($row->alasan == '2') {
			$alasan = 'REJECT';
		} else {
			$alasan = 'CLEAR';
		}

		// Penanganan penanggalan
		$tgl_csd_raw = $row->tgl_csd ?: date('Y-m-d');
		$tgl_cetak = date('d/m/Y', strtotime($tgl_csd_raw));
		$time2     = date('H:i:s', strtotime($tgl_csd_raw));

		// Checklist Status Keamanan SPX atau SCO
		$checklist = '<img src="' . base_url() . 'src/images/checklisticon.png" width="20">';

		$check_spx = $row->status_keamanan == '1' ? $checklist : '';
		$check_sco = $row->status_keamanan == '2' ? $checklist : '';

		$data = [
			'row'       => $row,
			'xray'      => $xray,
			'metode'    => $metode,
			'alasan'    => $alasan,
			'tgl_cetak' => $tgl_cetak,
			'time2'     => $time2,
			'check_spx' => $check_spx,
			'check_sco' => $check_sco,
			'checklist' => $checklist,
		];

		// Memuat view cetak CSD Actual
		$this->load->view('print_csd_actual_isi', $data);
	}

	public function print_csd_actual_sementara($uid)
	{
		// Query data utama menggabungkan ra_csd, out_list, out_list_btb, ra_avsec, out_agent, out_tujuan
		$this->cb->select('
            c.*, 
            c.uid AS csd_uid,
            o.uid AS smu_uid_val,
            o.smu,
            o.no_pesawat,
            o.tanggal_terbang,
            o.komoditi,
            b.total_pieces as koli_smu,
            b.total_gross as berat_smu,
            t.nama AS tujuan,
            av.nama AS avsec_nama,
            av.nik AS avsec_nik,
            ag.nama AS nama_agent,
            dr.nama AS driver_nama,
            tr.no_polisi AS truck_no_polisi
        ');
		$this->cb->from('ra_csd c');
		$this->cb->join('out_list o', 'o.uid = c.smu_uid', 'left');
		$this->cb->join('out_list_btb b', 'b.uid = o.btb_uid', 'left');
		$this->cb->join('out_tujuan t', 't.uid = o.tujuan_uid', 'left');
		$this->cb->join('out_avsec av', 'av.uid = c.avsec_uid', 'left');
		$this->cb->join('out_agent ag', 'ag.uid = o.agent_uid', 'left');
		$this->cb->join('out_driver dr', 'dr.uid = c.driver_uid', 'left');
		$this->cb->join('out_truck tr', 'tr.uid = c.truck_uid', 'left');
		$this->cb->where('c.uid', $uid);

		$row = $this->cb->get()->row();

		if (!$row) {
			show_error('Data CSD tidak ditemukan.', 404);
		}

		// Logika metode pemeriksaan utama
		$xray = '';
		if ($row->methode_pemeriksaan == '1') {
			$xray = 'XRAY LINE 1';
		} else if ($row->methode_pemeriksaan == '2') {
			$xray = 'XRAY LINE 2';
		} else {
			$xray = 'ETD';
		}

		// Logika metode pemeriksaan opsional / tambahan
		$metode = '';
		if ($row->methode_pemeriksaan_opsional == '1') {
			$metode = 'PERIKSA FISIK';
		} else if ($row->methode_pemeriksaan_opsional == '2') {
			$metode = 'ETD';
		} else {
			$metode = '-';
		}

		// Logika status alasan diterbitkan
		$alasan = '';
		if ($row->alasan == '1') {
			$alasan = 'CLEAR';
		} else if ($row->alasan == '2') {
			$alasan = 'REJECT';
		} else {
			$alasan = 'CLEAR';
		}

		// Penanganan penanggalan
		$tgl_csd_raw = $row->tgl_csd ?: date('Y-m-d');
		$tgl_cetak = date('d/m/Y', strtotime($tgl_csd_raw));
		$time2     = date('H:i:s', strtotime($tgl_csd_raw));

		$wday1ctk = substr($tgl_cetak, 0, 2);
		$wday2ctk = substr($tgl_cetak, 3, 2);
		$wday3ctk = substr($tgl_cetak, 6, 4);


		$jam = date("H:i:s");

		$hour = substr($jam, 0, 2);
		$minute = substr($jam, 3, 2);
		$second = substr($jam, 6, 2);

		// Checklist Status Keamanan SPX atau SCO
		$checklist = '<img src="' . base_url() . 'src/images/checklisticon.png" width="20">';

		$check_spx = $row->status_keamanan == '1' ? $checklist : '';
		$check_sco = $row->status_keamanan == '2' ? $checklist : '';

		$data = [
			'row'       => $row,
			'xray'      => $xray,
			'metode'    => $metode,
			'alasan'    => $alasan,
			'tgl_cetak' => $tgl_cetak,
			'time2'     => $time2,
			'check_spx' => $check_spx,
			'check_sco' => $check_sco,
			'checklist' => $checklist,
			'wday1ctk'  => $wday1ctk,
			'wday2ctk'  => $wday2ctk,
			'wday3ctk'  => $wday3ctk,
			'hour'      => $hour,
			'minute'    => $minute,
			'second'    => $second,
		];

		// Memuat view cetak CSD Actual
		$this->load->view('print_csd_actual_sementara', $data);
	}

	public function get_pesawat()
	{
		$search = $this->input->post('search');

		$this->cb->select('*');
		$this->cb->from('out_pesawat');

		if ($search) {
			$this->cb->like('nama', $search);
			$this->cb->or_like('prefix', $search);
		}

		$query = $this->cb->get();
		$data  = $query->result();

		echo json_encode($data);
	}

	public function get_tujuan()
	{
		$search = $this->input->post('search');

		$this->cb->select('*');
		$this->cb->from('out_tujuan');

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

		$this->cb->select('*');
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

		$this->db->select('*');
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

		$this->cb->select('*');
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

	public function get_pengirim()
	{
		$search = $this->input->post('search');

		$this->cb->select('*');
		$this->cb->from('out_pengirim');

		if ($search) {
			$this->cb->like('nama', $search);
			$this->cb->or_like('kode', $search);
		}

		$query = $this->cb->get();
		$data  = $query->result();

		echo json_encode($data);
	}

	public function store_csd()
	{

		// $smu = $this->input->post('smu_prefix') . '-' . $this->input->post('smu_number');
		// $no_pesawat = $this->input->post('no_pesawat_kode') . '-' . $this->input->post('no_pesawat_number');
		$smu  = $this->input->post('smu');
		$no_pesawat  = $this->input->post('no_pesawat');

		// Ambil data tujuan
		$tujuan_uid  = $this->input->post('tujuan');
		$tujuan_row  = $this->cb->where('uid', $tujuan_uid)->get('out_tujuan')->row();
		$tujuan_kode = $tujuan_row ? $tujuan_row->kode_kota : '';

		// Ambil data avsec
		$avsec_uid  = $this->input->post('avsec');
		$avsec_row  = $this->cb->where('uid', $avsec_uid)->get('out_avsec')->row();
		$avsec_nama = $avsec_row ? $avsec_row->nama : '';

		// Ambil data agent
		$agent_uid  = $this->input->post('agent');
		$agent_row  = $this->cb->where('uid', $agent_uid)->get('out_agent')->row();
		$agent_nama = $agent_row ? $agent_row->nama : '';

		$data = [
			'smu'                          => $smu,
			'user'                          => $this->session->userdata('nip'),
			'no_pesawat'                   => $no_pesawat,
			'tanggal_terbang'              => $this->input->post('tanggal_terbang'),
			'komoditi'                     => strtoupper($this->input->post('komoditi')),
			'koli_smu'                       => $this->input->post('jumlah'),
			'berat_smu'                        => $this->input->post('gross'),
			'tujuan'                       => $tujuan_kode,
			// 'origin'                       => 'HLP',
			// 'tujuan_uid'                   => $tujuan_uid,
			'status_keamanan'              => $this->input->post('status_keamanan'),
			'methode_pemeriksaan'          => $this->input->post('methode_pemeriksaan'),
			'methode_pemeriksaan_opsional' => $this->input->post('methode_pemeriksaan_opsional'),
			// 'nama_avsec'                   => $avsec_nama,
			'avsec_uid'                    => $avsec_uid,
			'nama_agent'                   => $agent_nama,
			'agent_uid'                    => $agent_uid,
			'jaster'                       => $this->input->post('jaster') ? '1' : '0',
		];

		$uid = $this->input->post('uid'); // untuk edit

		if ($uid) {
			$this->M_outgoing->update_csd($data, $uid);
			$this->session->set_flashdata('message_name', 'Data kemasan SMU berhasil diupdate.');
		} else {
			$signdate = time();
			$post_date1 = date("Ymd", $signdate);
			$post_date2 = date("His", $signdate);
			$post_dates = "$post_date1" . "$post_date2";
			$tgl_csd = date("Y-m-d", $signdate);

			$out_csd = $this->cb->select('MAX(CAST(csd_num AS UNSIGNED)) as csd_num')->from('out_csd')->get()->row();

			$no_mydisburse1 = $out_csd->csd_num;

			if ($no_mydisburse1 > 0) {
				$disburse1 = $no_mydisburse1 + 1;
				$nodis1 = sprintf("%06d", $disburse1);
				$no = $nodis1;
			} else {
				$no = "000001";
			}

			$my = date("my", strtotime($post_dates));
			$new_no_csd = "BDT.CSD.01.$my$no";

			$data['no_csd']  = $new_no_csd;
			$data['tgl_csd'] = $tgl_csd;
			$data['csd_num'] = $no;

			$this->M_outgoing->insert_csd($data);
			$this->session->set_flashdata('message_name', 'Data kemasan SMU berhasil ditambahkan.');
		}

		redirect('outgoinghlp/daftar_csd');
	}

	public function edit_csd($uid)
	{
		$this->cb->select('o.*, 
        p.kode as no_pesawat_kode, p.nama as no_pesawat_nama,
        t.kode_kota, t.nama as tujuan_nama,
        a.nama as avsec_nama,
        ag.nama as agent_nama');
		$this->cb->from('out_csd o');
		$this->cb->join('pesawat p', "p.kode = SUBSTRING_INDEX(o.no_pesawat, '-', 1)", 'left');
		$this->cb->join('out_tujuan t',  't.kode_kota = o.tujuan', 'left');
		$this->cb->join('out_avsec a',   'a.uid = o.avsec_uid',  'left');
		$this->cb->join('out_agent ag',  'ag.uid = o.agent_uid', 'left');
		$this->cb->where('o.uid', $uid);

		$row = $this->cb->get()->row();

		if (!$row) {
			echo json_encode(['status' => 'error', 'message' => 'Data tidak ditemukan.']);
			return;
		}

		// if ($row->smu) {
		// 	$smu = explode('-', $row->smu, 2);
		// 	$row->smu_prefix = $smu[0] ?? '';
		// 	$row->smu_number = $smu[1] ?? '';
		// }
		// if ($row->no_pesawat) {
		// 	$pesawat = explode('-', $row->no_pesawat, 2);
		// 	$row->no_pesawat_kode   = $pesawat[0] ?? '';
		// 	$row->no_pesawat_number = $pesawat[1] ?? '';
		// }

		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($row));
	}

	public function print_csd($uid)
	{
		// Query data utama
		$this->cb->select('o.*, 
        a.nama as avsec_nama, a.nik as avsec_nik');
		$this->cb->from('out_csd o');
		$this->cb->join('out_avsec a', 'a.uid = o.avsec_uid', 'left');
		$this->cb->where('o.uid', $uid);
		$row = $this->cb->get()->row();

		if (!$row) show_error('Data tidak ditemukan.', 404);

		// Logika metode pemeriksaan
		$xray = '';
		if ($row->methode_pemeriksaan == '1')      $xray = 'XRAY LINE 1';
		else if ($row->methode_pemeriksaan == '2') $xray = 'XRAY LINE 2';
		else                                        $xray = 'ETD';

		// Logika metode opsional
		$metode = '';
		if ($row->methode_pemeriksaan_opsional == '1')      $metode = 'PERIKSA FISIK';
		else if ($row->methode_pemeriksaan_opsional == '2') $metode = 'ETD';

		// Logika alasan
		$alasan = '';
		if ($row->alasan == '1')      $alasan = 'CLEAR';
		else if ($row->alasan == '2') $alasan = 'REJECT';
		else $alasan = 'CLEAR';

		// Tanggal
		$tgl_cetak = date('d/m/Y', strtotime($row->tgl_csd));
		$time2     = date('H:i:s', strtotime($row->tgl_csd));

		// Checklist status keamanan
		$checklist = '<img src="' . base_url() . 'src/images/checklisticon.png" width="20">';

		$check_spx = $row->status_keamanan == '1' ? $checklist : '';
		$check_sco = $row->status_keamanan == '2' ? $checklist : '';

		// $checklist_path = FCPATH . 'src/images/checklisticon.png';
		$data = [
			'row'       => $row,
			'xray'      => $xray,
			'metode'    => $metode,
			'alasan'    => $alasan,
			'tgl_cetak' => $tgl_cetak,
			'time2'     => $time2,
			'check_spx' => $check_spx,
			'check_sco' => $check_sco,
			'checklist' => $checklist,
			// 'check_sco' => $check_sco,

		];
		// Load library
		// $this->load->library('pdfgenerator');
		// $html = $this->load->view('print_csd', $data, true);
		// $this->pdfgenerator->generate($html, 'CSD_' . $row->no_csd . '.pdf');
		$html = $this->load->view('print_csd', $data);
	}


	public function get_driver()
	{
		$search = $this->input->post('search');
		$this->cb->select('uid, nama');
		$this->cb->from('out_driver');
		if ($search) $this->cb->like('nama', $search);
		echo json_encode($this->cb->get()->result());
	}

	public function get_truck()
	{
		$search = $this->input->post('search');
		$this->cb->select('uid, no_polisi');
		$this->cb->from('out_truck');
		if ($search) $this->cb->like('no_polisi', $search);
		echo json_encode($this->cb->get()->result());
	}

	// =========================
	// DAFTAR REJECT ITEM
	// =========================

	public function daftar_reject()
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

		$data['title'] = "Daftar Reject Item";

		// $data['customers'] = $this->M_outgoing->kemasan_smu();

		$this->load->view('daftar_reject', $data);
	}

	public function getData_reject()
	{
		$results = $this->M_outgoing->get_datatables_reject();
		$data    = [];

		$no = 1;
		foreach ($results as $r) {


			$data[] = [
				$no++,
				$r->jam,
				$r->tanggal,
				$r->no_flight,
				$r->nama_pengirim ?? '-',
				$r->nama_agen ?? '-',
				$r->avsec_nama ?? '-',
				$r->nama_tujuan ?? '-',
				$r->smu ?? '-',
				$r->isi_pti ?? '-',
				'<button type="button" class="btn btn-warning btn-xs btn-edit" data-uid="' . $r->uid . '"><i class="fa fa-edit"></i> Edit</button>'
			];
		}

		$output = [
			'draw'            => intval($_POST['draw'] ?? 0),
			'recordsTotal'    => $this->M_outgoing->count_all_reject(),
			'recordsFiltered' => $this->M_outgoing->count_filtered_reject(),
			'data'            => $data,
		];

		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($output));
	}

	public function store_reject()
	{
		$uid       = $this->input->post('uid_kemasan');
		$signdate  = time();
		$post_date = date('YmdHis', $signdate);

		$data_head = [
			'branch_code'      => $this->session->userdata('kode_cabang'),
			'tanggal'          => $this->input->post('tanggal'),
			'jam'              => $this->input->post('jam'),
			'smu'              => strtoupper($this->input->post('smu')),
			'no_flight'        => $this->input->post('no_flight'),
			'tujuan'       => $this->input->post('tujuan_uid'),
			'uid_pengirim'     => $this->input->post('pengirim_uid'),
			// 'telepon_pengirim' => $this->input->post('telepon_pengirim'),
			// 'alamat_pengirim'  => $this->input->post('alamat_pengirim'),
			'isi_pti'          => $this->input->post('isi_pti'),
			'uid_agen'         => $this->input->post('id_agent'),
			'avsec_uid'        => $this->input->post('avsec_uid'),
			'avsec_nama'       => $this->input->post('avsec_nama'),
		];

		if ($uid) {
			// Update head
			$this->cb->where('uid', $uid)->update('out_reject_item_list', $data_head);
			$reject_uid = $uid;
		} else {
			// Insert head
			$this->cb->insert('out_reject_item_list', $data_head);
			$reject_uid = $this->cb->insert_id();
		}

		// Insert detail/child
		$detail_jumlah      = $this->input->post('detail_jumlah')      ?? [];
		$detail_satuan      = $this->input->post('detail_satuan')      ?? [];
		$detail_keterangan  = $this->input->post('detail_keterangan')  ?? [];

		// Hapus detail lama jika edit
		if ($uid) {
			$this->cb->where('reject_list_uid', $uid)->delete('out_reject_item_detail');
		}

		foreach ($detail_jumlah as $i => $jumlah) {
			if (empty($jumlah)) continue;
			$this->cb->insert('out_reject_item_detail', [
				'reject_list_uid' => $reject_uid,
				'jumlah'          => $jumlah,
				'satuan'          => $detail_satuan[$i]     ?? 'Pieces',
				'keterangan'      => $detail_keterangan[$i] ?? '',
			]);
		}

		$this->session->set_flashdata('message_name', 'Data reject berhasil disimpan.');
		redirect('outgoinghlp/daftar_reject');
	}

	// 1. Fungsi Ambil Data JSON untuk Edit
	// 1. Fungsi Ambil Data JSON untuk Edit
	public function edit_reject($uid)
	{
		// Mengambil data utama reject beserta join teks nama agen/tujuan/avsec
		$this->cb->select('out_reject_item_list.*, tujuan.nama as tujuan_nama, tujuan.kode_kota, pengirim.nama as pengirim_nama, agent.kode as agent_kode, agent.nama as agent_nama, avsec.kode as avsec_kode, avsec.nama as avsec_nama');
		$this->cb->from('out_reject_item_list');
		$this->cb->join('out_tujuan tujuan', 'tujuan.kode_kota = out_reject_item_list.tujuan', 'left');
		$this->cb->join('out_pengirim pengirim', 'pengirim.uid = out_reject_item_list.uid_pengirim', 'left');
		$this->cb->join('out_agent agent', 'agent.uid = out_reject_item_list.uid_agen', 'left');
		$this->cb->join('out_avsec avsec', 'avsec.uid = out_reject_item_list.avsec_uid', 'left');
		$this->cb->where('out_reject_item_list.uid', $uid);
		$reject = $this->cb->get()->row();

		if (!$reject) {
			// Kirim response error jika UID ngaco atau data tidak ada
			echo json_encode([
				'status' => 'error',
				'message' => 'Data tidak ditemukan.'
			]);
			return;
		}

		$data['reject'] = $reject;
		$data['detail'] = $this->cb->where('reject_list_uid', $uid)->get('out_reject_item_detail')->result();

		echo json_encode($data);
	}

	// 2. Fungsi Proses Update Data
	public function update_reject()
	{
		$uid = $this->input->post('uid_kemasan');

		$avsec  = $this->cb->where('uid', $this->input->post('avsec_nama'))->get('out_avsec')->row();
		$avsec_nama = $avsec ? $avsec->nama : '';
		$avsec_uid = $avsec ? $avsec->uid : '';
		$data_update = [
			'tanggal'          => $this->input->post('tanggal'),
			'jam'              => $this->input->post('jam'),
			'smu'              => strtoupper($this->input->post('smu')),
			'no_flight'        => $this->input->post('no_flight'),
			'tujuan'       => $this->input->post('tujuan'),
			'isi_pti'          => $this->input->post('isi_pti'),
			'uid_pengirim'     => $this->input->post('nama_pengirim'),
			// 'telepon_pengirim' => $this->input->post('telepon_pengirim'),
			// 'alamat_pengirim'  => $this->input->post('alamat_pengirim'),
			'uid_agen'         => $this->input->post('id_agent'),
			'avsec_uid'        => $avsec_uid,
			'avsec_nama'       => $avsec_nama,
		];

		$this->cb->trans_start(); // Gunakan transaksi DB agar aman

		// Update data utama
		$this->cb->where('uid', $uid)->update('out_reject_item_list', $data_update);

		// Hapus detail lama, lalu insert ulang detail yang baru dimodifikasi
		$this->cb->where('reject_list_uid', $uid)->delete('out_reject_item_detail');

		$detail_jumlah     = $this->input->post('detail_jumlah');
		$detail_satuan     = $this->input->post('detail_satuan');
		$detail_keterangan = $this->input->post('detail_keterangan');

		if (!empty($detail_jumlah)) {
			foreach ($detail_jumlah as $key => $val) {
				if ($val > 0) { // Hanya simpan jika jumlah > 0
					$data_detail = [
						'reject_list_uid' => $uid,
						'jumlah'     => $val,
						'satuan'     => $detail_satuan[$key],
						'keterangan' => $detail_keterangan[$key]
					];
					$this->cb->insert('out_reject_item_detail', $data_detail);
				}
			}
		}

		$this->cb->trans_complete();

		if ($this->cb->trans_status() === FALSE) {
			$this->session->set_flashdata('message_error', 'Gagal memperbarui data.');
		} else {
			$this->session->set_flashdata('message_name', 'Daftar Reject berhasil diperbarui.');
		}

		redirect('outgoinghlp/daftar_reject'); // Sesuaikan base_url controller Anda
	}

	public function rekap_reject_excel()
	{
		$dari   = $this->input->post('dari');
		$sampai = $this->input->post('sampai');

		// Query data reject beserta detail items-nya
		$this->cb->select('
        out_reject_item_list.uid, 
        out_reject_item_list.tanggal, 
        out_reject_item_list.jam, 
        out_reject_item_list.no_flight, 
        out_reject_item_list.smu, 
        out_reject_item_list.isi_pti,
        pengirim.telepon as telepon_pengirim,
        pengirim.alamat as alamat_pengirim,
        tujuan.nama as nama_tujuan, 
        tujuan.kode_kota, 
        pengirim.nama as nama_pengirim, 
        agent.nama as nama_agent, 
        avsec.nama as nama_avsec,
        detail.jumlah,
        detail.satuan,
        detail.keterangan as detail_keterangan
    ', FALSE);
		$this->cb->from('out_reject_item_list');
		$this->cb->join('out_tujuan tujuan', 'tujuan.kode_kota = out_reject_item_list.tujuan', 'left');
		$this->cb->join('out_pengirim pengirim', 'pengirim.uid = out_reject_item_list.uid_pengirim', 'left');
		$this->cb->join('out_agent agent', 'agent.uid = out_reject_item_list.uid_agen', 'left');
		$this->cb->join('out_avsec avsec', 'avsec.uid = out_reject_item_list.avsec_uid', 'left');

		// Gabungkan dengan tabel detail items reject
		$this->cb->join('out_reject_item_detail detail', 'detail.reject_list_uid = out_reject_item_list.uid', 'left');

		// Filter Berdasarkan Kriteria Reject (status_reject/hold/is_reject sesuaikan dengan DB Anda)
		// Berdasarkan kode Anda sebelumnya, data ditarik dari get_datatables_reject()
		$this->cb->where('out_reject_item_list.tanggal >=', $dari);
		$this->cb->where('out_reject_item_list.tanggal <=', $sampai);
		$this->cb->order_by('out_reject_item_list.tanggal', 'ASC');
		$this->cb->order_by('out_reject_item_list.jam', 'ASC');

		$results = $this->cb->get()->result_array();

		// Load PhpSpreadsheet komponen dari third_party Anda
		require APPPATH . 'third_party/autoload.php';
		require APPPATH . 'third_party/psr/simple-cache/src/CacheInterface.php';

		$spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
		$sheet       = $spreadsheet->getActiveSheet();
		$sheet->setTitle('Rekap Daftar Reject');

		// Header Struktur Excel
		$headers = [
			'A' => 'No',
			'B' => 'Tanggal Reject',
			'C' => 'Jam',
			'D' => 'No Flight',
			'E' => 'SMU',
			'F' => 'Tujuan',
			'G' => 'Pengirim',
			'H' => 'No. Telp Pengirim',
			'I' => 'Alamat Pengirim',
			'J' => 'Isi PTI',
			'K' => 'Agen',
			'L' => 'Nama Avsec',
			'M' => 'Qty Item',
			'N' => 'Satuan',
			'O' => 'Keterangan Item Reject'
		];

		foreach ($headers as $col => $label) {
			$sheet->setCellValue($col . '1', $label);
		}

		// Styling Header
		$sheet->getStyle('A1:O1')->getFont()->setBold(true)->setSize(11);
		$sheet->getStyle('A1:O1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

		// Iterasi Data ke baris excel
		$nomor  = 1;
		$rowNum = 2;

		foreach ($results as $r) {
			$tgl_reject = $r['tanggal'] ? date('d-m-Y', strtotime($r['tanggal'])) : '-';

			$sheet->setCellValue('A' . $rowNum, $nomor);
			$sheet->setCellValue('B' . $rowNum, $tgl_reject);
			$sheet->setCellValue('C' . $rowNum, $r['jam']);
			$sheet->setCellValue('D' . $rowNum, $r['no_flight']);
			$sheet->setCellValue('E' . $rowNum, $r['smu'] ?? '-');
			$sheet->setCellValue('F' . $rowNum, ($r['kode_kota'] ? $r['kode_kota'] . ' - ' : '') . $r['nama_tujuan']);
			$sheet->setCellValue('G' . $rowNum, $r['nama_pengirim'] ?? '-');
			$sheet->setCellValue('H' . $rowNum, $r['telepon_pengirim'] ?? '-');
			$sheet->setCellValue('I' . $rowNum, $r['alamat_pengirim'] ?? '-');
			$sheet->setCellValue('J' . $rowNum, $r['isi_pti'] ?? '-');
			$sheet->setCellValue('K' . $rowNum, $r['nama_agent'] ?? '-');
			$sheet->setCellValue('L' . $rowNum, $r['nama_avsec'] ?? '-');

			// Data detail item reject
			$sheet->setCellValue('M' . $rowNum, $r['jumlah'] ?? 0);
			$sheet->setCellValue('N' . $rowNum, $r['satuan'] ?? '-');
			$sheet->setCellValue('O' . $rowNum, $r['detail_keterangan'] ?? '-');

			$rowNum++;
			$nomor++;
		}

		// Baris Total Qty Item Reject
		$totalRow = $rowNum;
		$firstRow = 2;
		$lastRow  = $rowNum - 1;

		if ($lastRow >= $firstRow) {
			$sheet->mergeCells('A' . $totalRow . ':L' . $totalRow);
			$sheet->getStyle('A' . $totalRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
			$sheet->getStyle('A' . $totalRow)->getFont()->setBold(true);
			$sheet->setCellValue('A' . $totalRow, 'TOTAL QTY REJECT  ');

			// Menggunakan formula SUM excel pada kolom M (Jumlah)
			$sheet->setCellValue('M' . $totalRow, '=SUM(M' . $firstRow . ':M' . $lastRow . ')');
			$sheet->getStyle('M' . $totalRow)->getFont()->setBold(true);
		}

		// Auto-fit Column Width
		foreach (range('A', 'O') as $col) {
			$sheet->getColumnDimension($col)->setAutoSize(true);
		}

		// Proses Download File Excel
		require APPPATH . 'third_party/autoload_zip.php';
		$filename = 'rekap_daftar_reject_HLP_' . $dari . '_to_' . $sampai . '.xlsx';

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="' . $filename . '"');
		header('Cache-Control: max-age=0');

		$writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
		$writer->save('php://output');
		exit();
	}

	// =========================
	// DAFTAR DO
	// =========================

	public function daftar_do()
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

		$data['title'] = "Daftar DO";

		// $data['customers'] = $this->M_outgoing->kemasan_smu();

		$this->load->view('daftar_do', $data);
	}

	public function getData_do()
	{
		$results = $this->M_outgoing->get_datatables_do();
		$data    = [];

		$no = 0;
		foreach ($results as $r) {


			// <button class='btn btn-sm btn-danger btn-delete-do' data-uid='{$r->uid}'>
			//     <i class='fa fa-trash'></i>
			// </button>

			$aksi = "
    <button class='btn btn-sm btn-warning btn-edit-do' data-uid='{$r->uid}'>
        <i class='fa fa-pencil'></i>
    </button>
";

			$print = "<a target='_blank' class='btn btn-sm btn-primary' href='" . base_url() . "outgoinghlp/print_do/{$r->uid}'>
        <i class='fa fa-print'></i> DO</a>";

			$data[] = [
				$r->no_do,
				$r->no_ch,
				$r->wh_name        ?? '-',
				$r->total_koli      ?? '-',
				$r->total_berat     ?? '-',
				$r->no_segel       ?? '-',
				$r->no_sticker        ?? '-',
				$r->nama_driver       ?? '-',
				$r->no_polisi         ?? '-',
				$r->tgl_ch,
				$r->nama_user_do    ?? '-',
				$print,
				$aksi,
			];
		}

		$output = [
			'draw'            => intval($_POST['draw'] ?? 0),
			'recordsTotal'    => $this->M_outgoing->count_all_do(),
			'recordsFiltered' => $this->M_outgoing->count_filtered_do(),
			'data'            => $data,
		];

		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($output));
	}

	public function get_list_smu()
	{
		$search = $this->input->post('search');

		$this->cb->select('uid, no_csd, smu, tujuan, komoditi, koli_smu, berat_smu');
		$this->cb->from('out_csd');
		// $this->cb->where('IFNULL(is_do, 0) !=', 1);

		if ($search) {
			$this->cb->group_start()
				->like('smu', $search)
				->or_like('komoditi', $search)
				->or_like('no_csd', $search)
				->group_end();
		}

		echo json_encode($this->cb->get()->result());
	}

	public function get_list_smu_dt()
	{
		// Ambil UIDs terpilih, pastikan dalam bentuk array integer yang bersih
		$selected_uids = $this->input->post('selected_uids');
		if (!is_array($selected_uids)) {
			$selected_uids = !empty($selected_uids) ? explode(',', $selected_uids) : [];
		}
		$selected_uids = array_filter(array_map('intval', $selected_uids));

		$this->cb->select('uid, no_csd, smu, tujuan, komoditi, koli_smu, berat_smu');
		$this->cb->from('out_csd');
		$this->cb->where('is_do != "1"');

		// Search
		if (!empty($_POST['search']['value'])) {
			$search = $_POST['search']['value'];
			$this->cb->group_start()
				->like('smu', $search)
				->or_like('komoditi', $search)
				->or_like('no_csd', $search)
				->group_end();
		}

		$total_filtered = $this->cb->count_all_results('', false);

		// 1. Prioritas Utama: Taruh yang sedang tercentang di paling atas
		if (!empty($selected_uids)) {
			$this->cb->order_by('FIELD(uid, ' . implode(',', $selected_uids) . ') DESC');
		}

		// 2. Prioritas Kedua: Sorting kolom DataTables atau default Terbaru di Atas
		$columns = array('uid', 'no_csd', 'smu', 'tujuan', 'komoditi', 'koli_smu', 'berat_smu');
		if (isset($_POST['order'][0]['column'])) {
			$col_idx = intval($_POST['order'][0]['column']);
			$col_dir = $_POST['order'][0]['dir'] === 'asc' ? 'ASC' : 'DESC';
			if (isset($columns[$col_idx])) {
				$this->cb->order_by($columns[$col_idx], $col_dir);
			}
		} else {
			$this->cb->order_by('uid', 'DESC'); // Default: Data terbaru di paling atas
		}

		$limit  = intval($_POST['length'] ?? 10);
		$offset = intval($_POST['start']  ?? 0);
		$this->cb->limit($limit, $offset);

		$results = $this->cb->get()->result();

		$this->output->set_content_type('application/json')->set_output(json_encode([
			'draw'            => intval($_POST['draw'] ?? 0),
			'recordsTotal'    => $this->cb->count_all_results('out_csd'),
			'recordsFiltered' => $total_filtered,
			'data'            => $results,
		]));
	}

	public function get_list_smu_edit_dt()
	{
		$uid_ch        = $this->input->post('uid_ch');
		$selected_uids = $this->input->post('selected_uids');
		if (!is_array($selected_uids)) {
			$selected_uids = !empty($selected_uids) ? explode(',', $selected_uids) : [];
		}
		$selected_uids = array_filter(array_map('intval', $selected_uids));

		// Base query
		$this->cb->select('uid, no_csd, smu, tujuan, komoditi, koli_smu, berat_smu');
		$this->cb->from('out_csd');
		$this->cb->group_start()
			->where('is_do != "1"')
			->or_where_in('uid', $selected_uids)   // SMU yang memang milik DO ini
			->group_end();

		// Search
		if (!empty($_POST['search']['value'])) {
			$search = $_POST['search']['value'];
			$this->cb->group_start()
				->like('smu', $search)
				->or_like('komoditi', $search)
				->or_like('no_csd', $search)
				->group_end();
		}

		$total_filtered = $this->cb->count_all_results('', false);

		// 1. Prioritas Utama: Taruh yang sedang tercentang di paling atas
		if (!empty($selected_uids)) {
			$this->cb->order_by('FIELD(uid, ' . implode(',', $selected_uids) . ') DESC');
		}

		// 2. Prioritas Kedua: Sorting kolom DataTables atau default Terbaru di Atas
		$columns = array('uid', 'no_csd', 'smu', 'tujuan', 'komoditi', 'koli_smu', 'berat_smu');
		if (isset($_POST['order'][0]['column'])) {
			$col_idx = intval($_POST['order'][0]['column']);
			$col_dir = $_POST['order'][0]['dir'] === 'asc' ? 'ASC' : 'DESC';
			if (isset($columns[$col_idx])) {
				$this->cb->order_by($columns[$col_idx], $col_dir);
			}
		} else {
			$this->cb->order_by('uid', 'DESC'); // Default: Data terbaru di paling atas
		}

		// Limit & offset
		$limit  = intval($_POST['length'] ?? 10);
		$offset = intval($_POST['start']  ?? 0);
		$this->cb->limit($limit, $offset);

		$results = $this->cb->get()->result();

		$this->output->set_content_type('application/json')->set_output(json_encode([
			'draw'            => intval($_POST['draw'] ?? 0),
			'recordsTotal'    => $this->cb->count_all('out_csd'),
			'recordsFiltered' => $total_filtered,
			'data'            => $results,
		]));
	}

	public function store_do()
	{
		$uid_list = $this->input->post('uid_list');

		if (empty($uid_list)) {
			$this->session->set_flashdata('message_error', 'Pilih minimal 1 SMU.');
			redirect('outgoinghlp/daftar_do');
			return;
		}

		$uids = explode(',', $uid_list);

		// Hitung total koli & berat
		$this->cb->select('SUM(koli_smu) as total_koli, SUM(berat_smu) as total_berat');
		$this->cb->from('out_csd');
		$this->cb->where_in('uid', $uids);
		$total = $this->cb->get()->row();

		// Generate no_ch & no_do
		$signdate  = time();
		$postdate  = date('YmdHis', $signdate);
		$tgl_ch    = date('Y-m-d', $signdate);
		$date_no   = date('m/Y', $signdate);

		$no_query  = $this->cb->select('MAX(no_do) as max_no')->from('out_ch')->get()->row();
		$no_inv    = $no_query->max_no ?? 0;

		if ($no_inv > 0) {
			$noinv         = sprintf("%06d", $no_inv + 1);
			$no_submission = "BDT." . $noinv . "/" . $date_no;
		} else {
			$noinv         = "000001";
			$no_submission = "BDT.000001/" . $date_no;
		}

		// Ambil no_pol dari truck
		$truck  = $this->cb->where('uid', $this->input->post('truck_uid'))->get('out_truck')->row();
		$no_pol = $truck->no_polisi ?? '';

		// Insert header DO ke out_ch
		$header = [
			'branch_code' => $this->session->userdata('kode_cabang'),
			'user'        => $this->session->userdata('nip'),
			'post_date'   => $postdate,
			'no_ch'       => $no_submission,
			'no_do'       => $noinv,
			'tgl_ch'      => $tgl_ch,
			'no_segel'    => $this->input->post('no_segel'),
			'no_sticker'  => $this->input->post('no_sticker'),
			'remark'      => $this->input->post('remark'),
			'wh_name'     => $this->input->post('wh_name'),
			'status'      => '1',
			'driver_uid'  => $this->input->post('driver_uid'),
			'truck_uid'   => $this->input->post('truck_uid'),
			'no_pol'      => $no_pol,
			'total_koli'  => $total->total_koli ?? 0,
			'total_berat' => $total->total_berat ?? 0,
		];

		$this->cb->insert('out_ch', $header);
		$uid_ch = $this->cb->insert_id();

		// Insert list ke out_list_do & update is_do di out_csd
		foreach ($uids as $uid_csd) {
			$uid_csd = trim($uid_csd);

			$this->cb->insert('out_list_do', [
				'uid_ch'  => $uid_ch,
				'uid_csd' => $uid_csd,
			]);

			$this->cb->where('uid', $uid_csd)->update('out_csd', [
				'is_do' => 1,
				'no_do' => $noinv,
			]);
		}

		$this->session->set_flashdata('message_name', 'DO ' . $no_submission . ' berhasil dibuat.');
		redirect('outgoinghlp/daftar_do');
	}

	public function get_do($uid_ch)
	{
		// Header
		$this->cb->select('r.*, d.nama as nama_driver, t.no_polisi');
		$this->cb->from('out_ch r');
		$this->cb->join('out_driver d', 'd.uid = r.driver_uid', 'left');
		$this->cb->join('out_truck t',  't.uid = r.truck_uid',  'left');
		$this->cb->where('r.uid', $uid_ch);
		$header = $this->cb->get()->row();

		// List SMU yang sudah terpilih
		$list = $this->cb->select('uid_csd')->from('out_list_do')
			->where('uid_ch', $uid_ch)->get()->result();

		$selected_uids = array_column((array)$list, 'uid_csd');

		$this->output->set_content_type('application/json')
			->set_output(json_encode([
				'header'        => $header,
				'selected_uids' => $selected_uids,
			]));
	}

	public function get_list_smu_edit()
	{
		$search        = $this->input->post('search');
		$selected_uids = $this->input->post('selected_uids') ?? [];
		$uid_ch        = $this->input->post('uid_ch'); // tambahkan hidden input uid_ch di form edit

		$this->cb->select('uid, no_csd, smu, tujuan, komoditi, koli_smu, berat_smu');
		$this->cb->from('out_csd');
		// $this->cb->group_start();
		// // Yang belum di-DO sama sekali
		// // $this->cb->where('IFNULL(is_do, 0) !=', 1);
		// // ATAU yang sudah terpilih di DO ini (is_do = 1 tapi milik DO ini)
		// if (!empty($selected_uids)) {
		// 	$this->cb->or_where_in('uid', $selected_uids);
		// }
		// $this->cb->group_end();

		if ($search) {
			$this->cb->group_start()
				->like('smu', $search)
				->or_like('komoditi', $search)
				->or_like('no_csd', $search)
				->group_end();
		}

		echo json_encode($this->cb->get()->result());
	}

	public function update_do()
	{
		$signdate  = time();
		$postdate  = date('YmdHis', $signdate);

		$uid_ch   = $this->input->post('uid_ch');
		$uid_list = $this->input->post('uid_list');
		$new_uids = !empty($uid_list) ? explode(',', $uid_list) : [];

		// Ambil list SMU lama
		$old_list  = $this->cb->select('uid_csd')->from('out_list_do')
			->where('uid_ch', $uid_ch)->get()->result();
		$old_uids  = array_column((array)$old_list, 'uid_csd');

		// SMU yang dihapus -> kembalikan is_do = 0
		$removed = array_diff($old_uids, $new_uids);
		foreach ($removed as $uid_csd) {
			$this->cb->where('uid', $uid_csd)->update('out_csd', [
				'is_do' => 0,
				'no_do' => null,
				'post_date_upd' => $postdate,
			]);
			$this->cb->where('uid_ch', $uid_ch)
				->where('uid_csd', $uid_csd)
				->delete('out_list_do');
		}

		// SMU yang ditambah -> insert & update is_do = 1
		$added = array_diff($new_uids, $old_uids);

		// Ambil no_do dari header
		$header = $this->cb->select('no_do')->from('out_ch')
			->where('uid', $uid_ch)->get()->row();

		foreach ($added as $uid_csd) {
			$uid_csd = trim($uid_csd);
			$this->cb->insert('out_list_do', [
				'uid_ch'  => $uid_ch,
				'uid_csd' => $uid_csd,
			]);
			$this->cb->where('uid', $uid_csd)->update('out_csd', [
				'is_do' => 1,
				'no_do' => $header->no_do,
			]);
		}

		// Update header
		$truck  = $this->cb->where('uid', $this->input->post('truck_uid'))->get('out_truck')->row();
		$no_pol = $truck->no_polisi ?? '';

		// Hitung ulang total
		$this->cb->select('SUM(koli_smu) as total_koli, SUM(berat_smu) as total_berat');
		$this->cb->from('out_csd');
		$this->cb->where_in('uid', $new_uids);
		$total = $this->cb->get()->row();

		$this->cb->where('uid', $uid_ch)->update('out_ch', [
			'remark'      => $this->input->post('remark'),
			'wh_name'     => $this->input->post('wh_name'),
			'no_segel'    => $this->input->post('no_segel'),
			'no_sticker'  => $this->input->post('no_sticker'),
			'driver_uid'  => $this->input->post('driver_uid'),
			'truck_uid'   => $this->input->post('truck_uid'),
			'no_pol'      => $no_pol,
			'total_koli'  => $total->total_koli ?? 0,
			'total_berat' => $total->total_berat ?? 0,
		]);

		$this->session->set_flashdata('message_name', 'DO berhasil diupdate.');
		redirect('outgoinghlp/daftar_do');
	}

	public function delete_do($uid_ch)
	{
		// Ambil list SMU
		$list     = $this->cb->select('uid_csd')->from('out_list_do')
			->where('uid_ch', $uid_ch)->get()->result();
		$old_uids = array_column((array)$list, 'uid_csd');

		// Kembalikan is_do = 0 semua SMU
		foreach ($old_uids as $uid_csd) {
			$this->cb->where('uid', $uid_csd)->update('out_csd', [
				'is_do' => 0,
				'no_do' => null,
				'post_date_upd' => $postdate,
			]);
		}

		$this->cb->where('uid_ch', $uid_ch)->delete('out_list_do');
		$this->cb->where('uid', $uid_ch)->delete('out_ch');

		$this->session->set_flashdata('message_name', 'DO berhasil dihapus.');
		redirect('outgoinghlp/daftar_do');
	}

	public function print_do($uid_ch)
	{
		// Query header DO
		$this->cb->select('
        r.*,
        t.no_polisi,
        u.nama as user_name,
        d.nama as user_driver
    ');
		$this->cb->from('out_ch r');
		$this->cb->join('out_truck t',   't.uid = r.truck_uid',  'left');
		$this->cb->join($this->db->database . '.users u',       'u.nip = r.user',       'left');
		$this->cb->join('out_driver d',  'd.uid = r.driver_uid', 'left');
		$this->cb->where('r.uid', $uid_ch);
		$header = $this->cb->get()->row();

		if (!$header) show_error('Data tidak ditemukan.', 404);

		// Warehouse name
		$wh_map = [
			'bdl'    => 'BANGUN DESA TEKNOLOGI',
			'ardhya' => 'ARDHYA BUMI PERSADA',
			'jas'    => 'JASA ANGKASA SEMESTA',
		];
		$wh = $wh_map[$header->wh_name] ?? $header->wh_name;

		// Format tanggal & jam dari post_date (YmdHis)
		$post_date = $header->post_date;
		$time      = substr($post_date, 8, 2) . ':' . substr($post_date, 10, 2) . ':' . substr($post_date, 12, 2);
		$tgl_ch    = date('d/m/Y', strtotime($header->tgl_ch));

		// Print date & time sekarang
		$now        = date('YmdHis');
		$p_time     = substr($now, 8, 2) . ':' . substr($now, 10, 2) . ':' . substr($now, 12, 2);

		// Format angka
		$total_koli_k  = number_format($header->total_koli);
		$total_berat_k = number_format($header->total_berat);

		// Query list SMU dari out_list_do JOIN out_csd
		$this->cb->select('
        l.uid,
        o.smu,
        o.koli_smu   as qty,
        o.berat_smu  as weight,
        o.komoditi   as commodity,
        o.no_pesawat as airline,
        o.nama_agent as agent,
        o.tujuan     as destin
    ');
		$this->cb->from('out_list_do l');
		$this->cb->join('out_csd o', 'o.uid = l.uid_csd', 'left');
		$this->cb->where('l.uid_ch', $uid_ch);
		$this->cb->order_by('l.uid', 'ASC');
		$list = $this->cb->get()->result();

		$data = [
			'header'        => $header,
			'wh'            => $wh,
			'time'          => $time,
			'tgl_ch'        => $tgl_ch,
			'p_time'        => $p_time,
			'total_koli_k'  => $total_koli_k,
			'total_berat_k' => $total_berat_k,
			'list'          => $list,
		];

		$this->load->view('print_do', $data);
	}

	public function migrate_to_kemasan()
	{
		$uid = $this->input->post('uid');

		// Ambil data dari out_csd
		$csd = $this->cb->where('uid', $uid)->get('out_csd')->row();

		if (!$csd) {
			echo json_encode(['status' => 'error', 'message' => 'Data tidak ditemukan.']);
			return;
		}

		if ($csd->is_kemasan_smu == '1') {
			echo json_encode(['status' => 'error', 'message' => 'Data sudah pernah dimigrate.']);
			return;
		}

		$signdate = time();
		$post_date = date('YmdHis', $signdate);

		// Insert ke out_list
		$data = [
			'branch_code'                  => $csd->branch_code,
			'post_date'                    => $post_date,
			'smu'                          => $csd->smu,
			'no_pesawat'                   => $csd->no_pesawat,
			'tanggal_terbang'              => $csd->tanggal_terbang,
			'tujuan'                       => $csd->tujuan,
			'tujuan_uid'                   => $csd->tujuan_uid ?? '',
			'komoditi'                     => $csd->komoditi,
			'jumlah'                       => $csd->koli_smu,
			'gross'                        => $csd->berat_smu,
			'nama_agent'                   => $csd->nama_agent,
			'agent_uid'                    => $csd->agent_uid,
			'jaster'                       => $csd->jaster,
			'status_keamanan'              => $csd->status_keamanan,
			'methode_pemeriksaan'          => $csd->methode_pemeriksaan,
			'methode_pemeriksaan_opsional' => $csd->methode_pemeriksaan_opsional,
			'nama_avsec'                   => '',
			'avsec_uid'                    => $csd->avsec_uid,
			'csd_uid'                      => $csd->uid,
			'user_in'                      => $this->session->userdata('nip'),
			'status'                       => '1',
			'in_p'                         => '1',
			'in_date'                      => $post_date,
		];

		$this->cb->insert('out_list', $data);
		$out_list_uid = $this->cb->insert_id();

		// Update is_kemasan_smu di out_csd
		$this->cb->where('uid', $uid)->update('out_csd', [
			'is_kemasan_smu' => 1,
			'smu_uid'        => $out_list_uid,
		]);

		echo json_encode([
			'status'  => 'success',
			'message' => 'SMU ' . $csd->smu . ' berhasil dimigrate ke Kemasan SMU.',
		]);
	}

	public function daftar_kemasan_smu()
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

		$data['title'] = "Daftar Kemasan SMU";

		// $data['customers'] = $this->M_outgoing->kemasan_smu();

		$this->load->view('daftar_kemasan_smu', $data);
	}

	public function getData_kemasan_smu()
	{
		$results = $this->M_outgoing->get_datatables_kemasan_smu();
		$data    = [];

		$no = 0;
		foreach ($results as $r) {

			if ($r->catg_smu == '1') {
				$i_catg_k = "Langsung";
			} else if ($r->catg_smu == '2') {
				$i_catg_k = "Transhipment";
			} else if ($r->catg_smu == '3') {
				$i_catg_k = "Terminal change(w/o inv)";
			} else {
				$i_catg_k = "Belum Dipilih";
			}

			if ($r->jaster == '1') {
				$jaster = "<span class='btn btn-sm' style='color:#5cb85c; border:1px solid #5cb85c; background:transparent;'>Jaster</span> ";
			} else {
				$jaster = "<span class='btn btn-sm' style='color:#d9534f; border:1px solid #d9534f; background:transparent;'>No Jaster</span> ";
			}



			// <button class='btn btn-sm btn-primary btn-do' data-uid='{$r->uid}'>
			//     <i class='fa fa-send'> ke DO</i>
			// </button>
			// 			$aksi = "
			//     <button class='btn btn-sm btn-warning btn-edit' data-uid='{$r->uid}'>
			//         <i class='fa fa-pencil'> Edit</i>
			//     </button>
			// ";

			if ($r->smu_lama) {
				$aksi = "
    <button class='btn btn-sm btn-secondary'>
        <i class='fa fa-old'><b> SMU Lama </b></i>
    </button>
";
			} else if ($r->volume == '0' || $r->volume == '') {
				$aksi = "
    <button class='btn btn-sm btn-danger'>
        <i class='fa fa-times'> Volume Tidak Boleh 0</i>
    </button>
";
			} else {

				if ($r->btb_p != '1') {
					$aksi = "
    <button class='btn btn-sm btn-primary btn-btb' data-uid='{$r->uid}' data-smu='{$r->smu}'>
        <i class='fa fa-send'> ke BTB</i>
    </button>
";
				} else {
					$aksi = "
    <button class='btn btn-sm btn-success' >
        <i class='fa fa-check'> Sudah di BTB</i>
    </button>
";
				}
			}

			$pesawat = $this->cb->where('nama', $r->pesawat)->get('out_pesawat')->row();
			$warna = $pesawat->warna ?? Null;
			if ($warna) {
				$SMU = "<span class='btn btn-sm' style='color:#fff; border:1px solid #fff; background-color:#$warna;'>$r->smu</span> ";
			} else {
				$SMU = "<span class='btn btn-sm' style='color:#73879C;'>$r->smu</span> ";
			}

			// 	$print = "<a target='_blank' class='btn btn-sm btn-primary' href='" . base_url() . "outgoinghlp/print_csd/{$r->uid}'>
			// <i class='fa fa-print'></i> CSD</a>";

			// Dates
			$wday1 = substr($r->post_date, 0, 4);
			$wday2 = substr($r->post_date, 4, 2);
			$wday3 = substr($r->post_date, 6, 2);
			$wday4 = substr($r->post_date, 8, 2);
			$wday5 = substr($r->post_date, 10, 2);
			$wday6 = substr($r->post_date, 12, 2);
			$time2 = "$wday4" . ":" . "$wday5";
			if ($r->post_date != "") {
				$post_date_txt = "$wday3" . "-" . "$wday2" . "-" . "$wday1" . " " . "$time2";
			} else {
				$post_date_txt = "";
			}


			$data[] = [
				$r->uid,
				$i_catg_k,
				$SMU,
				$r->tujuan,
				$r->jumlah ?? '-',
				$r->gross ?? '-',
				$r->volume ?? '-',
				$r->nama_pengirim ?? '-',
				$post_date_txt ?? '-',
				$jaster,
				// $print,
				$aksi,
			];
		}

		$output = [
			'draw'            => intval($_POST['draw'] ?? 0),
			'recordsTotal'    => $this->M_outgoing->count_all_kemasan_smu(),
			'recordsFiltered' => $this->M_outgoing->count_filtered_kemasan_smu(),
			'data'            => $data,
		];

		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($output));
	}


	public function store_smu()
	{
		$signdate  = time();
		$post_date = date('YmdHis', $signdate);

		$tanggal_masuk = $this->input->post('tanggal_masuk');
		$re_in_date_ex = explode('-', $tanggal_masuk);
		$re_in_date    = isset($re_in_date_ex[0], $re_in_date_ex[1], $re_in_date_ex[2]) ? $re_in_date_ex[0] . $re_in_date_ex[1] . $re_in_date_ex[2] : date('Ymd');
		$in_date       = $re_in_date . date('His', $signdate);

		$tujuan_row = $this->cb->where('uid', $this->input->post('tujuan'))->get('out_tujuan')->row();
		$tujuan = $tujuan_row->kode_kota ?? '';

		$pengirim = $this->cb->where('uid', $this->input->post('nama_pengirim'))->get('out_pengirim')->row();
		$pengirim_uid = $pengirim->uid ?? null;
		$pengirim_nama = $pengirim->nama ?? '';
		$pengirim_alamat = $pengirim->alamat ?? '';
		$pengirim_telepon = $pengirim->telepon ?? '';

		$agent = $this->cb->where('uid', $this->input->post('nama_agent'))->get('out_agent')->row();
		$agent_uid = $agent->uid ?? null;
		$agent_nama = $agent->nama ?? '';
		$agent_alamat = $agent->alamat ?? '';
		$agent_telepon = $agent->telepon ?? '';
		$uid  = $this->input->post('uid');

		$data = [
			'branch_code'      => $this->session->userdata('kode_cabang'),
			'post_date'        => $post_date,
			'smu'              => $this->input->post('smu'),
			'tanggal_smu'      => $this->input->post('tanggal_smu'),
			'tujuan'           => $tujuan,
			'tujuan_uid'       => $this->input->post('tujuan'),
			'no_pesawat'       => $this->input->post('no_pesawat'),
			'pesawat'          => $this->input->post('pesawat'),
			'tanggal_terbang'  => $this->input->post('tanggal_terbang'),
			'time_terbang'     => $this->input->post('time_terbang'),
			'pengirim_uid'     => $pengirim_uid,
			'nama_pengirim'    => $pengirim_nama,
			'telepon_pengirim' => $pengirim_alamat,
			'alamat_pengirim'  => $pengirim_telepon,
			'nama_penerima'    => $this->input->post('nama_penerima'),
			'telepon_penerima' => $this->input->post('telepon_penerima'),
			'alamat_penerima'  => $this->input->post('alamat_penerima'),
			'agent_uid'        => $agent_uid,
			'nama_agent'       => $agent_nama,
			'alamat_agent'     => $agent_alamat,
			'telepon_agent'    => $agent_telepon,
			'jaster'           => $this->input->post('jaster') ? '1' : '0',

			// Mengaktifkan kembali kolom utama agar terisi ke database
			'jumlah'           => $this->input->post('jumlah'),
			'gross'            => $this->input->post('gross'),
			'volume'           => $this->input->post('volume'),
			'chargeable'       => $this->input->post('chargeable'),
			'komoditi'         => strtoupper($this->input->post('komoditi')),
			'in_date'          => $in_date,

			'user_in'          => $this->session->userdata('nip'),
			'status'           => '1',
			'in_p'             => '1',
			'jns_barang'       => $this->input->post('jns_barang'),
			'catg_smu'         => $this->input->post('catg_smu'),
		];

		$cek_smu = $this->cb->where([
			'smu'          => $this->input->post('smu'),
		])->get('out_list')->num_rows();

		if ($cek_smu > 0) {
			$this->session->set_flashdata('message_error', 'SMU sudah ada di database.');
			redirect('outgoinghlp/daftar_kemasan_smu');
			return;
		}

		$this->cb->insert('out_list', $data);
		$inserted_uid = $this->cb->insert_id(); // Dapatkan UID record utama yang baru saja tersimpan

		// Menyimpan data dimensi dinamis dari form tambah modal ke out_dimensi
		$dim_panjang = $this->input->post('dim_panjang');
		if (!empty($dim_panjang) && is_array($dim_panjang)) {
			$dim_lebar        = $this->input->post('dim_lebar');
			$dim_tinggi       = $this->input->post('dim_tinggi');
			$dim_pieces       = $this->input->post('dim_pieces');
			$dim_dimensi      = $this->input->post('dim_dimensi');
			$dim_volume       = $this->input->post('dim_volume');
			$dim_total_volume = $this->input->post('dim_total_volume');

			for ($i = 0; $i < count($dim_panjang); $i++) {
				// Simpan baris hanya jika nilai panjang valid (> 0)
				if (floatval($dim_panjang[$i]) > 0) {
					$this->cb->insert('out_dimensi', [
						'uid_list'     => $inserted_uid,
						'panjang'      => floatval($dim_panjang[$i]),
						'lebar'        => floatval($dim_lebar[$i]),
						'tinggi'       => floatval($dim_tinggi[$i]),
						'pieces'       => intval($dim_pieces[$i]),
						'dimensi'      => $dim_dimensi[$i],
						'volume'       => floatval($dim_volume[$i]),
						'total_volume' => floatval($dim_total_volume[$i]),
					]);
				}
			}
		}

		$this->session->set_flashdata('message_name', 'SMU berhasil ditambahkan.');
		redirect('outgoinghlp/daftar_kemasan_smu');
	}

	public function get_detail_smu($uid)
	{
		// Data header
		// $row = $this->cb->where('uid', $uid)->get('out_list')->row();
		$this->cb->select('o.*, p.nama as pesawat_nama, p.prefix as prefix', FALSE);
		$this->cb->from('out_list o');
		$this->cb->join('out_pesawat p', "p.nama = o.pesawat", 'left');
		$this->cb->where('o.uid', $uid);
		$row = $this->cb->get()->row();

		if (!$row) {
			echo json_encode(['status' => 'error']);
			return;
		}

		$row->in_date_formatted = date('Y-m-d', strtotime(
			substr($row->in_date, 0, 4) . '-' .
				substr($row->in_date, 4, 2) . '-' .
				substr($row->in_date, 6, 2)
		));

		$row->prefix = $row->prefix ?? '';

		// Data dimensi
		$dimensi = $this->cb->where('uid_list', $uid)
			->order_by('uid', 'ASC')
			->get('out_dimensi')->result();

		$this->output->set_content_type('application/json')
			->set_output(json_encode([
				'row'     => $row,
				'dimensi' => $dimensi,
			]));
	}

	public function update_kemasan_smu()
	{
		$tujuan = $this->cb->where('uid', $this->input->post('tujuan'))->get('out_tujuan')->row();
		$tujuan = $tujuan->kode_kota;
		$uid  = $this->input->post('uid');

		$pengirim = $this->cb->where('uid', $this->input->post('nama_pengirim'))->get('out_pengirim')->row();
		$pengirim_uid = $pengirim->uid;
		$pengirim_nama = $pengirim->nama;
		$pengirim_alamat = $pengirim->alamat;
		$pengirim_telepon = $pengirim->telepon;


		$agent = $this->cb->where('uid', $this->input->post('nama_agent'))->get('out_agent')->row();
		$agent_uid = $agent->uid;
		$agent_nama = $agent->nama;
		$agent_alamat = $agent->alamat;
		$agent_telepon = $agent->telepon;
		$uid  = $this->input->post('uid');


		$signdate = time();
		$post_date1 = date("Ymd", $signdate);
		$post_date2 = date("His", $signdate);
		$tanggal_masuk = $this->input->post('tanggal_masuk');
		$re_in_date_ex = explode('-', $tanggal_masuk);
		$re_in_date    = $re_in_date_ex[0] . $re_in_date_ex[1] . $re_in_date_ex[2];
		$post_date2    = date('His');
		$in_date       = $re_in_date . $post_date2;

		$postdate  = date('YmdHis', $signdate);

		$data = [
			'smu'              => $this->input->post('smu'),
			'tanggal_smu'      => $this->input->post('tanggal_smu'),
			'tujuan'           => $tujuan,
			'tujuan_uid'           => $this->input->post('tujuan'),
			// 'no_pesawat' => $this->input->post('no_pesawat_kode') . '-' . $this->input->post('no_pesawat_number'),
			'no_pesawat'       => $this->input->post('no_pesawat'),
			'pesawat'          => $this->input->post('pesawat'),
			'tanggal_terbang'  => $this->input->post('tanggal_terbang'),
			'time_terbang'     => $this->input->post('time_terbang'),
			'pengirim_uid'     => $pengirim_uid,
			'nama_pengirim'    => $pengirim_nama,
			'telepon_pengirim' => $pengirim_alamat,
			'alamat_pengirim'  => $pengirim_telepon,
			'nama_penerima'    => $this->input->post('nama_penerima'),
			'telepon_penerima' => $this->input->post('telepon_penerima'),
			'alamat_penerima'  => $this->input->post('alamat_penerima'),
			'agent_uid'        => $agent_uid,
			'nama_agent'       => $agent_nama,
			'alamat_agent'     => $agent_alamat,
			'telepon_agent'    => $agent_telepon,
			'jaster'           => $this->input->post('jaster'),
			'jumlah'           => $this->input->post('jumlah'),
			'gross'            => $this->input->post('gross'),
			'komoditi'         => strtoupper($this->input->post('komoditi')),
			'volume'           => $this->input->post('volume'),
			'chargeable'       => $this->input->post('chargeable'),
			'jns_barang'       => $this->input->post('jns_barang'),
			'catg_smu'         => $this->input->post('catg_smu'),
			'in_date' 		   => $in_date,
			'post_date_upd'    => $postdate,
		];

		$il = $this->cb->where('uid', $uid)->get('out_list')->row();
		echo ('UID LIST' . $uid);
		if ($il->bill_uid) {
			echo ('MASUK');
			$data_billing = [
				'agent_uid'        => $agent_uid,
				'nama_agent'       => $agent_nama,
			];
			$this->cb->where('uid', $il->bill_uid)->update('out_billing', $data_billing);
		}
		$this->cb->where('uid', $uid)->update('out_list', $data);

		$this->session->set_flashdata('message_name', 'Data berhasil diupdate.');
		redirect('outgoinghlp/daftar_kemasan_smu');
	}

	public function update_selesai_smu_lama()
	{
		// 1. Pastikan hanya menerima request melalui AJAX
		if ($this->input->is_ajax_request()) {

			// 2. Ambil UID dari input POST (pastikan di formEditSMU ada input dengan name="uid")
			// Atau jika Anda mengirimkannya lewat button value, pastikan sudah masuk ke serialize form.
			$uid = $this->input->post('uid');

			if (empty($uid)) {
				$output = [
					'status'  => 'error',
					'message' => 'UID tidak ditemukan atau tidak valid.'
				];
				echo json_encode($output);
				return;
			}

			// 3. Siapkan data yang akan di-update
			$data = [
				'smu'      => '-' . $this->input->post('smu'),
				'smu_lama' => '1',
			];

			// 4. Jalankan proses update ke database
			$update = $this->cb->where('uid', $uid)->update('out_list', $data);

			// 5. Cek apakah update berhasil
			if ($update) {
				// Kita tetap set flashdata jika setelah reload halaman Anda ingin menampilkan alert bawaan CI,
				// tapi karena kita pakai SweetAlert2 untuk reload, ini opsional.
				$this->session->set_flashdata('message_name', 'Data berhasil diupdate.');

				$output = [
					'status'  => 'success',
					'message' => 'Data SMU Lama berhasil diperbarui.'
				];
			} else {
				$output = [
					'status'  => 'error',
					'message' => 'Gagal memperbarui data ke database.'
				];
			}

			// 6. Cetak output JSON agar dibaca oleh AJAX
			echo json_encode($output);
		} else {
			// Jika diakses langsung tanpa AJAX, lempar ke 404
			show_404();
		}
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

	public function get_next_no()
	{
		// Query untuk mencari nilai MAX dari kolom 'no' di tabel out_list_btb
		$this->cb->select('MAX(CAST(no AS UNSIGNED)) as max_no');
		$query = $this->cb->get('out_list_btb');
		$row = $query->row();

		// Jika data masih kosong, nomor BTB dimulai dari 1
		$next_no_int = (!empty($row->max_no)) ? ($row->max_no + 1) : 1;

		// Pad angka dengan nol di depan hingga panjangnya 6 digit (contoh: 2 -> 000002)
		// Silakan ubah angka 6 di bawah jika panjang digit nomor BTB Anda berbeda
		$next_no = str_pad($next_no_int, 6, "0", STR_PAD_LEFT);

		return $this->output
			->set_content_type('application/json')
			->set_output(json_encode([
				'status' => 'success',
				'next_no' => $next_no
			]));
	}

	/**
	 * Memproses satu data ke BTB menggunakan AJAX POST
	 */
	public function proses_single_btb()
	{
		// Ambil data UID yang dikirimkan via AJAX POST
		$q_uid = $this->input->post('uid');

		if (empty($q_uid)) {
			return $this->output
				->set_content_type('application/json')
				->set_status_header(400)
				->set_output(json_encode([
					'status' => 'error',
					'message' => 'Parameter UID tidak ditemukan.'
				]));
		}

		// Mengambil user ID yang aktif saat ini dari session
		$now_uid = $this->session->userdata('nip');

		if (empty($now_uid)) {
			return $this->output
				->set_content_type('application/json')
				->set_output(json_encode([
					'status' => 'error',
					'message' => 'Sesi User UID telah habis. Silakan login kembali.'
				]));
		}

		// Membuat timestamp format YmdHis (contoh: 20261024143045)
		$post_dates = date("YmdHis");

		$btb_date_input = $this->input->post('btb_date');
		$tanggal = date("Ymd", strtotime($btb_date_input)) . date("His");

		// Mulai database transaction untuk menjamin keutuhan data
		$this->cb->trans_start();

		// 1. CARI & HITUNG NOMOR BTB TERBARU (Secara realtime di dalam Transaction agar aman dari race condition)
		$this->cb->select('MAX(CAST(no AS UNSIGNED)) as max_no');
		$query_max = $this->cb->get('out_list_btb');
		$row_max = $query_max->row();
		$btb_no_int = (!empty($row_max->max_no)) ? ($row_max->max_no + 1) : 1;

		// Pad angka hasil kalkulasi agar tetap tersimpan dengan format nol di depan (misal: 000002)
		$btb_no = str_pad($btb_no_int, 6, "0", STR_PAD_LEFT);

		// 2. TAMBAHKAN HEADER BTB BARU (INSERT INTO out_list_btb)
		$data_insert_btb = [
			'user'      => $now_uid,
			'post_date' => $post_dates,
			'no'        => $btb_no,
			'tanggal'   => $tanggal,
		];
		$this->cb->insert('out_list_btb', $data_insert_btb);

		// Ambil btb_uid yang baru saja digenerate oleh database
		$btb_uid = $this->cb->insert_id();

		// 3. UPDATE DATA TUNGGAL PADA out_list MENGGUNAKAN btb_uid YANG BARU SAJA DI-INSERT
		$data_update_list = [
			'btb_date' => $post_dates,
			'btb_p'    => '1',
			'btb_uid'  => $btb_uid,
			'user_btb' => $now_uid
		];
		$this->cb->where('uid', $q_uid);
		$this->cb->update('out_list', $data_update_list);

		// 4. HITUNG TOTAL BARU UNTUK BTB_UID TERKAIT (SUM)
		$this->cb->select('SUM(jumlah) as total_qty, SUM(gross) as total_gross, SUM(chargeable) as total_chargeable, SUM(volume) as total_volume');
		$this->cb->where('btb_uid', $btb_uid);
		$query_sum = $this->cb->get('out_list');
		$totals = $query_sum->row();

		// 5. UPDATE SUMMARY KE TABEL out_list_btb YANG BARU SAJA KITA BUAT DI ATAS
		$data_summary = [
			'total_pieces'     => $totals->total_qty ?? 0,
			'total_gross'      => $totals->total_gross ?? 0,
			'total_volume'     => $totals->total_volume ?? 0,
			'total_chargeable' => $totals->total_chargeable ?? 0
		];
		$this->cb->where('uid', $btb_uid);
		$this->cb->update('out_list_btb', $data_summary);

		// Selesaikan transaction
		$this->cb->trans_complete();

		// Cek apakah seluruh operasi database sukses tanpa error
		if ($this->cb->trans_status() === FALSE) {
			return $this->output
				->set_content_type('application/json')
				->set_output(json_encode([
					'status' => 'error',
					'message' => 'Terjadi kesalahan sistem saat memperbarui data BTB.'
				]));
		}

		// Berikan respon sukses ke AJAX frontend dengan info nomor BTB yang berhasil dibuat
		return $this->output
			->set_content_type('application/json')
			->set_output(json_encode([
				'status' => 'success',
				'message' => 'Data berhasil dibuat dan diproses ke BTB Baru dengan No: ' . $btb_no
			]));
	}

	public function rekap_kemasan_smu()
	{
		$dari   = $this->input->post('dari');
		$sampai = $this->input->post('sampai');
		$catg   = $this->input->post('catg');

		// Format tanggal untuk query (in_date format YmdHis)
		$start_date = str_replace('-', '', $dari) . '000000';
		$end_date   = str_replace('-', '', $sampai) . '235959';

		// Catg via filter
		$catg_via = '';
		if ($catg == 'gudang_langsung') {
			$catg_via = "AND status_apk = '0'";
		} elseif ($catg == 'ra_apk') {
			$catg_via = "AND status_apk = '1'";
		}

		// Query data
		$this->cb->select('*', FALSE);
		$this->cb->from('out_list');
		$this->cb->where('in_date !=', '');
		$this->cb->where("in_date BETWEEN '$start_date' AND '$end_date'", NULL, FALSE);
		if ($catg_via) {
			$this->cb->where($catg_via, NULL, FALSE);
		}
		$this->cb->order_by('in_date', 'ASC');
		$results = $this->cb->get()->result_array();

		// Load PhpSpreadsheet
		require APPPATH . 'third_party/autoload.php';

		// Include PhpSpreadsheet from third_party
		require APPPATH . 'third_party/psr/simple-cache/src/CacheInterface.php';

		$spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
		$sheet       = $spreadsheet->getActiveSheet();
		$sheet->setTitle('Rekap Tonase SMU Outgoing HLP');

		// Header
		$headers = [
			'A' => 'No',
			'B' => 'No BTB',
			'C' => 'Kategori SMU',
			'D' => 'SMU',
			'E' => 'Tujuan',
			'F' => 'Tanggal Masuk',
			'G' => 'Jam Masuk',
			'H' => 'Tanggal Keluar',
			'I' => 'Jam Keluar',
			'J' => 'No Penerbangan',
			'K' => 'Nama Pesawat',
			'L' => 'Tanggal Terbang',
			'M' => 'Waktu Terbang',
			'N' => 'Koli RA',
			'O' => 'Berat RA',
			'P' => 'Koli GDG',
			'Q' => 'Berat GDG',
			'R' => 'Volume',
			'S' => 'Chargeable',
			'T' => 'Komoditi',
			'U' => 'Agen',
			'V' => 'Pengirim',
			'W' => 'Penerima',
			'X' => 'User Acceptance 1',
			'Y' => 'User Acceptance 2',
			'Z' => 'Status(Void/Ready)',
		];

		foreach ($headers as $col => $label) {
			$sheet->setCellValue($col . '1', $label);
		}

		$sheet->getStyle('A1:Z1')->getFont()->setBold(true)->setSize(12);
		$sheet->getStyle('A1:Z1')->getAlignment()
			->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

		// Data rows
		$nomor   = 1;
		$rowNum  = 2;

		foreach ($results as $r) {
			// No BTB
			$no_btb = '';
			if (!empty($r['btb_uid'])) {
				$btb = $this->cb->select('no')->where('uid', $r['btb_uid'])->get('out_list_btb')->row();
				$no_btb = $btb ? 'HLPO-' . $btb->no : '';
			}

			// Nama agent
			$nama_agent = '';
			if (!empty($r['agent_uid'])) {
				$agent = $this->cb->select('nama')->where('uid', $r['agent_uid'])->get('out_agent')->row();
				$nama_agent = $agent->nama ?? '';
			}

			// User acceptance 1
			$user1 = '';
			if (!empty($r['user_in'])) {
				$u1 = $this->db->select('nama')->where('nip', $r['user_in'])->get('users')->row();
				$user1 = $u1->nama ?? '';
			}

			// User acceptance 2
			$user2 = '';
			if (!empty($r['user_gdg_via_ra'])) {
				$u2 = $this->db->select('nama')->where('nip', $r['user_gdg_via_ra'])->get('users')->row();
				$user2 = $u2->nama ?? '';
			}

			// Kategori SMU
			$catg_map = [
				'1' => 'Langsung(CGU)',
				'2' => 'Transhipment',
				'3' => 'Terminal Change w/o Inv',
				'4' => 'Via RA LJA',
				'5' => 'Langsung(AAP)',
			];
			$catg_smu_txt = $catg_map[$r['catg_smu']] ?? '';

			// Format tanggal masuk
			$tgl_masuk = $r['in_date'] ? date('j F Y', strtotime($r['in_date'])) : '';
			$jam_masuk = $r['in_date'] ? date('H:i:s', strtotime($r['in_date'])) : '';

			// Format tanggal keluar
			$tgl_keluar = $r['out_date'] ? date('j F Y', strtotime($r['out_date'])) : '';
			$jam_keluar = $r['out_date'] ? date('H:i:s', strtotime($r['out_date'])) : '';

			// Format tanggal terbang
			$tgl_terbang  = $r['tanggal_terbang'] ? date('j F Y', strtotime($r['tanggal_terbang'])) : '';
			$waktu_terbang = $r['time_terbang'] ? date('H:i:s', strtotime($r['time_terbang'])) : '';

			// Status
			$status = $r['hold'] == '1' ? 'Void' : 'Ready';

			$sheet->setCellValue('A' . $rowNum, $nomor);
			$sheet->setCellValue('B' . $rowNum, $no_btb);
			$sheet->setCellValue('C' . $rowNum, $catg_smu_txt);
			$sheet->setCellValue('D' . $rowNum, $r['smu']);
			$sheet->setCellValue('E' . $rowNum, $r['tujuan']);
			$sheet->setCellValue('F' . $rowNum, $tgl_masuk);
			$sheet->setCellValue('G' . $rowNum, $jam_masuk);
			$sheet->setCellValue('H' . $rowNum, $tgl_keluar);
			$sheet->setCellValue('I' . $rowNum, $jam_keluar);
			$sheet->setCellValue('J' . $rowNum, $r['no_pesawat']);
			$sheet->setCellValue('K' . $rowNum, $r['pesawat']);
			$sheet->setCellValue('L' . $rowNum, $tgl_terbang);
			$sheet->setCellValue('M' . $rowNum, $waktu_terbang);
			$sheet->setCellValue('N' . $rowNum, $r['jumlah_ra'] ?? '');
			$sheet->setCellValue('O' . $rowNum, $r['berat_ra']  ?? '');
			$sheet->setCellValue('P' . $rowNum, $r['jumlah']);
			$sheet->setCellValue('Q' . $rowNum, $r['gross']);
			$sheet->setCellValue('R' . $rowNum, $r['volume']);
			$sheet->setCellValue('S' . $rowNum, $r['chargeable']);
			$sheet->setCellValue('T' . $rowNum, $r['komoditi']);
			$sheet->setCellValue('U' . $rowNum, $nama_agent);
			$sheet->setCellValue('V' . $rowNum, $r['nama_pengirim']);
			$sheet->setCellValue('W' . $rowNum, $r['nama_penerima']);
			$sheet->setCellValue('X' . $rowNum, $user1);
			$sheet->setCellValue('Y' . $rowNum, $user2);
			$sheet->setCellValue('Z' . $rowNum, $status);

			$rowNum++;
			$nomor++;
		}

		// Baris total
		$totalRow  = $rowNum;
		$firstRow  = 2;
		$lastRow   = $rowNum - 1;

		$sheet->mergeCells('A' . $totalRow . ':M' . $totalRow);
		$sheet->getStyle('A' . $totalRow)->getAlignment()
			->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
		$sheet->setCellValue('A' . $totalRow, 'TOTAL');
		$sheet->setCellValue('N' . $totalRow, '=SUM(N' . $firstRow . ':N' . $lastRow . ')');
		$sheet->setCellValue('O' . $totalRow, '=SUM(O' . $firstRow . ':O' . $lastRow . ')');
		$sheet->setCellValue('P' . $totalRow, '=SUM(P' . $firstRow . ':P' . $lastRow . ')');
		$sheet->setCellValue('Q' . $totalRow, '=SUM(Q' . $firstRow . ':Q' . $lastRow . ')');
		$sheet->setCellValue('R' . $totalRow, '=SUM(R' . $firstRow . ':R' . $lastRow . ')');
		$sheet->setCellValue('S' . $totalRow, '=SUM(S' . $firstRow . ':S' . $lastRow . ')');

		// Autosize semua kolom
		foreach (range('A', 'Z') as $col) {
			$sheet->getColumnDimension($col)->setAutoSize(true);
		}

		// Download
		require APPPATH . 'third_party/autoload_zip.php';
		$filename = 'rekap_kemasan_outgoing_HLP_' . date('d-m-Y') . '.xlsx';

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="' . $filename . '"');
		header('Cache-Control: max-age=0');

		$writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
		$writer->save('php://output');
		exit();
	}

	// DAFTAR BTB
	public function daftar_btb()
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

		$data['title'] = "Daftar BTB";

		// $data['customers'] = $this->M_outgoing->kemasan_smu();

		$this->load->view('daftar_btb', $data);
	}

	public function getData_btb()
	{
		$results = $this->M_outgoing->get_datatables_btb();
		$data    = [];

		$no = 0;
		foreach ($results as $r) {

			// Dates
			$wday1 = substr($r->tanggal, 0, 4);
			$wday2 = substr($r->tanggal, 4, 2);
			$wday3 = substr($r->tanggal, 6, 2);
			$wday4 = substr($r->tanggal, 8, 2);
			$wday5 = substr($r->tanggal, 10, 2);
			$wday6 = substr($r->tanggal, 12, 2);
			$time2 = "$wday4" . ":" . "$wday5";
			if ($r->tanggal != "") {
				$tanggal_txt = "$wday3" . "-" . "$wday2" . "-" . "$wday1" . " " . "$time2";
			} else {
				$tanggal_txt = "";
			}

			// Dates
			if ($r->out_p == 1) {
				$wday1 = substr($r->out_date, 0, 4);
				$wday2 = substr($r->out_date, 4, 2);
				$wday3 = substr($r->out_date, 6, 2);
				$wday4 = substr($r->out_date, 8, 2);
				$wday5 = substr($r->out_date, 10, 2);
				$wday6 = substr($r->out_date, 12, 2);
				$time2 = "$wday4" . ":" . "$wday5";

				$tanggal_txt_inv = "$wday3" . "-" . "$wday2" . "-" . "$wday1" . " " . "$time2";
			} else {
				$tanggal_txt_inv = "";
			}

			if ($r->out_p == 1) {
				$status = "<span class='btn btn-sm btn-success'>Sudah di Invoice</span> ";
			} else {
				$status = "<button type='button' class='btn btn-sm btn-primary btn-buat-invoice' data-uid='{$r->uid}' data-no='{$r->no}' data-smu='{$r->smu}' data-agent='{$r->nama_agent}'><i class='fa fa-send'></i> Ke Invoice</button> <button type='button' class='btn btn-sm btn-primary btn-buat-invoice-khusus' data-uid='{$r->uid}' data-no='{$r->no}' data-smu='{$r->smu}' data-agent='{$r->nama_agent}'><i class='fa fa-send'></i> Ke Invoice Khusus</button>";
			}

			$print = "<a target='_blank' class='btn btn-sm btn-primary' href='" . base_url() . "outgoinghlp/print_btb_thermal/{$r->uid}'>
        <i class='fa fa-print'></i> BTB</a>";

			$data[] = [
				$r->no,
				$r->smu,
				$r->nama_agent,
				$r->total_pieces ?? '-',
				$r->total_gross ?? '-',
				$r->total_volume ?? '-',
				$tanggal_txt ?? '-',
				$tanggal_txt_inv ?? '-',
				$r->nama ?? '-',
				$status,
				$print,
			];
		}

		$output = [
			'draw'            => intval($_POST['draw'] ?? 0),
			'recordsTotal'    => $this->M_outgoing->count_all_btb(),
			'recordsFiltered' => $this->M_outgoing->count_filtered_btb(),
			'data'            => $data,
		];

		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($output));
	}

	public function print_btb_thermal($uid)
	{
		// Query header BTB + list SMU
		$this->cb->select('
        a.uid, a.total_pieces, a.total_gross, a.total_volume, a.total_chargeable,
        b.nama_agent as nama, a.status, a.tanggal, a.no, a.user,
        b.smu, b.no_pesawat, b.pesawat, b.tujuan, b.komoditi, b.tanggal_terbang,
        b.uid as uid_list
    ');
		$this->cb->from('out_list_btb a');
		$this->cb->join('out_list b', 'a.uid = b.btb_uid', 'left');
		$this->cb->where('a.uid', $uid);
		$row = $this->cb->get()->row();

		if (!$row) show_error('Data tidak ditemukan.', 404);

		// Ambil nama user
		$user = $this->db->select('nama')->from('users')
			->where('nip', $row->user)->get()->row();
		$nama_accep = strtoupper($user->nama ?? '');

		// Format tanggal BTB (YmdHis)
		$tgl_btb = $row->tanggal;
		$date4Y  = substr($tgl_btb, 0, 4);
		$date4m  = substr($tgl_btb, 4, 2);
		$date4d  = substr($tgl_btb, 6, 2);

		$months = [
			1 => 'Januari',
			2 => 'Februari',
			3 => 'Maret',
			4 => 'April',
			5 => 'Mei',
			6 => 'Juni',
			7 => 'Juli',
			8 => 'Agustus',
			9 => 'September',
			10 => 'Oktober',
			11 => 'November',
			12 => 'Desember'
		];
		$bln = $months[(int)$date4m] ?? '';

		$pm_btb_date_txt = $tgl_btb > 1 ? "$date4d $bln $date4Y" : '-';

		// Format angka
		// $total_pieces_k    = number_format($row->total_pieces);
		// $total_gross_k     = number_format($row->total_gross, 2);
		// $total_volume_k    = number_format($row->total_volume, 2);
		// $total_chargeable_k = number_format($row->total_chargeable, 2);


		$total_pieces_k    = number_format($row->total_pieces);
		$total_gross_k     = number_format($row->total_gross);
		$total_volume_k    = number_format($row->total_volume);
		$total_chargeable_k = number_format($row->total_chargeable);

		// Tanggal & jam cetak
		$tgl_print = date('d/m/Y');
		$jam_print = date('H:i:s');

		// Dimensi
		$dimensi = $this->cb->where('uid_list', $row->uid_list)
			->order_by('uid', 'ASC')
			->get('out_dimensi')->result();

		$data = [
			'row'               => $row,
			'nama_accep'        => $nama_accep,
			'pm_btb_date_txt'   => $pm_btb_date_txt,
			'total_pieces_k'    => $total_pieces_k,
			'total_gross_k'     => $total_gross_k,
			'total_volume_k'    => $total_volume_k,
			'total_chargeable_k' => $total_chargeable_k,
			'tgl_print'         => $tgl_print,
			'jam_print'         => $jam_print,
			'dimensi'           => $dimensi,
		];

		$this->load->view('print_btb_thermal', $data);
	}

	public function get_next_invoice_no()
	{
		$no_query = $this->cb->select('MAX(invoice_num) as max_no')
			->from('out_billing')
			->get()->row();

		$max_no = $no_query->max_no ?? 0;

		// Konversi dan tambahkan 1
		$next_no_int = intval($max_no) + 1;

		// Pad dengan angka nol di depan hingga 6 digit (contoh: 000001)
		$next_no = str_pad($next_no_int, 6, "0", STR_PAD_LEFT);

		return $this->output
			->set_content_type('application/json')
			->set_output(json_encode([
				'status' => 'success',
				'next_no' => $next_no
			]));
	}

	public function get_next_invoice_khusus_no()
	{
		$no_query = $this->cb->select('MAX(invoice_num) as max_no')
			->from('out_billing_inv_khusus')
			->get()->row();

		$max_no = $no_query->max_no ?? 0;

		// Konversi dan tambahkan 1
		$next_no_int = intval($max_no) + 1;

		// Pad dengan angka nol di depan hingga 6 digit (contoh: 000001)
		$next_no = str_pad($next_no_int, 6, "0", STR_PAD_LEFT);

		return $this->output
			->set_content_type('application/json')
			->set_output(json_encode([
				'status' => 'success',
				'next_no' => $next_no
			]));
	}

	public function buat_invoice($uid_list_btb)
	{
		$signdate  = time();
		$post_date1 = date('Ymd', $signdate);
		$post_date2 = date('His', $signdate);
		$post_dates = $post_date1 . $post_date2;
		$post_date_inv = date('YmdHis', $signdate);

		// Ambil data SMU
		$btb = $this->cb->where('uid', $uid_list_btb)->get('out_list_btb')->row();
		$smu = $this->cb->where('btb_uid', $uid_list_btb)->get('out_list')->row();

		if (!$smu) {
			$this->session->set_flashdata('message_error', 'Data SMU tidak ditemukan.');
			redirect('outgoinghlp/daftar_btb');
			return;
		}

		// Cek apakah sudah di-invoice
		if ($smu->out_p == '1') {
			$this->session->set_flashdata('message_error', 'SMU sudah pernah di-invoice.');
			redirect('outgoinghlp/daftar_btb');
			return;
		}

		// Generate nomor invoice
		$no_query = $this->cb->select('MAX(invoice_num) as max_no')
			->from('out_billing')
			->get()->row();
		$no_inv = $no_query->max_no ?? 0;

		if ($no_inv > 0) {
			$disburse = floatval($no_inv) + 1;
			$noinv    = sprintf("%06d", $disburse);
			$no       = $noinv;
		} else {
			$no = "000001";
		}
		$new_no_invoice = "HLP.OUT-JASTER" . "-" . "$no";

		// if ($no_inv > 0) {
		// 	$noinv   = sprintf("%06d", $no_inv + 1);
		// } else {
		// 	$noinv   = "000001";
		// }
		// $invoice = "BDT.INV.01.$my$noinv";

		// Cek nomor invoice sudah dipakai
		$cek = $this->cb->where('invoice_num', $no)->count_all_results('out_billing');
		if ($cek > 0) {
			$this->session->set_flashdata('message_error', 'Nomor invoice sudah digunakan.');
			redirect('outgoinghlp/daftar_btb');
			return;
		}

		// Ambil kategori billing
		$catg = $this->cb->select('uid, csc, kade, sewa_gudang, jasa_ra')
			->where('hold !=', '1')
			->get('out_bill_catg')->row();

		if (!$catg) {
			$this->session->set_flashdata('message_error', 'Kategori billing tidak ditemukan.');
			redirect('outgoinghlp/daftar_btb');
			return;
		}

		$sub_charge  = $smu->chargeable;
		$sewa_gudang = $sub_charge * $catg->sewa_gudang;
		$jasa_ra     = $smu->jaster == '1' ? $catg->jasa_ra : 0;

		// Insert ke out_billing
		$this->cb->insert('out_billing', [
			'user_bill'   => $this->session->userdata('nip'),
			'post_date'   => $post_dates,
			'invoice_num' => $no,
			// 'no_invoice' => $new_no_invoice,
			'nama'        => $smu->nama_pengirim,
			'alamat'        => $smu->alamat_pengirim,
			'telepon'        => $smu->telepon_pengirim,
			'pengirim_uid' => $smu->pengirim_uid,
			'nama_agent'  => $smu->nama_agent,
			'agent_uid'   => $smu->agent_uid,
			'total_pieces'   => $btb->total_pieces,
			'total_gross'   => $btb->total_gross,
			'total_volume'   => $btb->total_volume,
			'total_chargeable'   => $btb->total_chargeable,
			'jaster'   => $smu->jaster,
		]);
		$bill_uid = $this->cb->insert_id();

		// Update out_list
		$this->cb->where('uid', $smu->uid)->update('out_list', [
			'out_date'   => $post_dates,
			'out_p'      => '1',
			'bill_uid'   => $bill_uid,
			'user_out'   => $this->session->userdata('nip'),
			'sewa_gudang' => $sewa_gudang,
			'catg_bill'  => $catg->uid,
		]);

		$this->session->set_flashdata('message_name', 'Invoice Number ' . $no . ' berhasil dibuat.');
		redirect('outgoinghlp/daftar_btb');
	}

	public function buat_invoice_khusus($uid_list_btb)
	{
		$signdate  = time();
		$post_date1 = date('Ymd', $signdate);
		$post_date2 = date('His', $signdate);
		$post_dates = $post_date1 . $post_date2;
		$post_date_inv = date('YmdHis', $signdate);

		// Ambil data SMU
		$btb = $this->cb->where('uid', $uid_list_btb)->get('out_list_btb')->row();
		$smu = $this->cb->where('btb_uid', $uid_list_btb)->get('out_list')->row();

		if (!$smu) {
			$this->session->set_flashdata('message_error', 'Data SMU tidak ditemukan.');
			redirect('outgoinghlp/daftar_btb');
			return;
		}

		// Cek apakah sudah di-invoice
		if ($smu->out_p == '1') {
			$this->session->set_flashdata('message_error', 'SMU sudah pernah di-invoice.');
			redirect('outgoinghlp/daftar_btb');
			return;
		}

		// Generate nomor invoice
		$no_query = $this->cb->select('MAX(invoice_num) as max_no')
			->from('out_billing_inv_khusus')
			->get()->row();
		$no_inv = $no_query->max_no ?? 0;

		if ($no_inv > 0) {
			$disburse = floatval($no_inv) + 1;
			$noinv    = sprintf("%06d", $disburse);
			$no       = $noinv;
		} else {
			$no = "000001";
		}

		// if ($no_inv > 0) {
		// 	$noinv   = sprintf("%06d", $no_inv + 1);
		// } else {
		// 	$noinv   = "000001";
		// }
		// $invoice = "BDT.INV.01.$my$noinv";

		// Cek nomor invoice sudah dipakai
		$cek = $this->cb->where('invoice_num', $no)->count_all_results('out_billing_inv_khusus');
		if ($cek > 0) {
			$this->session->set_flashdata('message_error', 'Nomor invoice sudah digunakan.');
			redirect('outgoinghlp/daftar_btb');
			return;
		}

		// Ambil kategori billing
		$catg = $this->cb->select('uid, csc, kade, sewa_gudang, jasa_ra')
			->where('hold !=', '1')
			->get('out_bill_catg_inv_khusus')->row();

		if (!$catg) {
			$this->session->set_flashdata('message_error', 'Kategori billing tidak ditemukan.');
			redirect('outgoinghlp/daftar_btb');
			return;
		}

		$sub_charge  = $smu->chargeable;
		$sewa_gudang = $sub_charge * $catg->sewa_gudang;
		$jasa_ra     = $smu->jaster == '1' ? $catg->jasa_ra : 0;

		// Insert ke out_billing
		$this->cb->insert('out_billing_inv_khusus', [
			'user_bill'   => $this->session->userdata('nip'),
			'post_date'   => $post_dates,
			'invoice_num' => $no,
			// 'no_invoice' => $new_no_invoice,
			'nama'        => $smu->nama_pengirim,
			'alamat'        => $smu->alamat_pengirim,
			'telepon'        => $smu->telepon_pengirim,
			'pengirim_uid' => $smu->pengirim_uid,
			'nama_agent'  => $smu->nama_agent,
			'agent_uid'   => $smu->agent_uid,
			'total_pieces'   => $btb->total_pieces,
			'total_gross'   => $btb->total_gross,
			'total_volume'   => $btb->total_volume,
			'total_chargeable'   => $btb->total_chargeable,
			'jaster'   => $smu->jaster,
		]);
		$bill_uid = $this->cb->insert_id();

		// Update out_list
		$this->cb->where('uid', $smu->uid)->update('out_list', [
			'out_date'   => $post_dates,
			'out_p'      => '1',
			'out_khusus'      => '1',
			'bill_khusus_uid'   => $bill_uid,
			'user_out'   => $this->session->userdata('nip'),
			'sewa_gudang' => $sewa_gudang,
			'catg_bill'  => $catg->uid,
		]);

		$this->session->set_flashdata('message_name', 'Invoice Number ' . $no . ' berhasil dibuat.');
		redirect('outgoinghlp/daftar_btb');
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

		$data['title'] = "Daftar Invoice";


		// Ambil data COA DEPOSIT
		// $coa_2_arr = $this->m_coa->getCoaByCode('221');

		// $coa_4 = $this->m_coa->getCoaByCode('210');
		// $coa_2 = $this->m_coa->getCoaByCode('2102');

		// Ambil data COA kedua
		$coa_12002 = $this->m_coa->getCoaByCode('12002');
		$coa_12001 = $this->m_coa->getCoaByCode('12001');

		$merged_coa_debit_depo = array_merge($coa_12002, $coa_12001);

		$coa_debit_depo = $this->m_coa->getCoaByCode('210');


		$coa_debit_transfer = $merged_coa_debit_depo;

		// $coa_41001 = $this->m_coa->getCoaByCode('41001');
		$coa_41002 = $this->m_coa->getCoaByCode('41002');
		// $coa_41003 = $this->m_coa->getCoaByCode('41003');
		$coa_13010 = $this->m_coa->getCoaByCode('13010');


		// $merged_coa_kredit_transfer = array_merge($coa_41001, $coa_41002, $coa_41003, $coa_13010);
		$merged_coa_kredit_transfer = array_merge($coa_41002,  $coa_13010);


		$data['coa_1'] = $coa_debit_depo;
		// $data['coa_2'] = $coa_kredit_depo;
		$data['coa_2'] = $coa_41002;

		$data['coa_3'] = $coa_debit_transfer;
		$data['coa_4'] = $merged_coa_kredit_transfer;

		// $data['customers'] = $this->M_outgoing->kemasan_smu();

		$this->load->view('daftar_invoice', $data);
	}

	public function getData_invoice()
	{
		$results = $this->M_outgoing->get_datatables_invoice();
		$data    = [];

		$no = 0;
		foreach ($results as $r) {


			// Dates
			$wday1 = substr($r->tanggal_invoice, 0, 4);
			$wday2 = substr($r->tanggal_invoice, 4, 2);
			$wday3 = substr($r->tanggal_invoice, 6, 2);
			$wday4 = substr($r->tanggal_invoice, 8, 2);
			$wday5 = substr($r->tanggal_invoice, 10, 2);
			$wday6 = substr($r->tanggal_invoice, 12, 2);
			$time2 = "$wday4" . ":" . "$wday5";
			if ($r->tanggal_invoice != "") {
				$tanggal_txt = "$wday3" . "-" . "$wday2" . "-" . "$wday1" . " " . "$time2";
			} else {
				$tanggal_txt = "";
			}

			if ($r->catg_smu == '1') {
				$l_catg_k = "Langsung(Direct)";
			} else if ($r->catg_smu == '2') {
				$l_catg_k = "Transhipment";
			} else if ($r->catg_smu == '3') {
				$l_catg_k = "Terminal change(w/o inv)";
			} else if ($r->catg_smu == '4') {
				$l_catg_k = "Direct from RA";
			} else {
				$l_catg_k = '';
			}

			if ($r->is_jaster == '1') {
				$jaster = "<span class='btn btn-sm' style='color:#5cb85c; border:1px solid #5cb85c; background:transparent;'>Jaster</span> ";
			} else {
				$jaster = "<span class='btn btn-sm' style='color:#d9534f; border:1px solid #d9534f; background:transparent;'>No Jaster</span> ";
			}
			$print = '';
			if ($r->pay_status == '1') {
				$print = "<a target='_blank' class='btn btn-sm btn-primary' href='" . base_url() . "outgoinghlp/print_invoice/{$r->uid}'>
        <i class='fa fa-print'></i> Invoice</a>";
			}

			$pesawat = $this->cb->where('nama', $r->pesawat)->get('out_pesawat')->row();
			$warna = $pesawat->warna ?? Null;
			if ($warna) {
				$SMU = "<span class='btn btn-sm' style='color:#fff; border:1px solid #fff; background-color:#$warna;'>$r->smu</span> ";
			} else {
				$SMU = "<span class='btn btn-sm' style='color:#73879C;'>$r->smu</span> ";
			}
			if ($r->pay_methode == '1' && $r->pay_status == '1') {
				// $cek_topup = $this->cb->where('billing_uid', $r->uid)->where('asal_table', 'out_billing')->get('all_topup')->num_rows();

				if ($r->has_topup) {
					$warning_topup = "<span>$r->nama_kasir</span>";
				} else {
					$warning_topup = "<span class='btn btn-sm' style='color:white; background-color:red;'>$r->nama_kasir</span><span style='color:red;'>Invoice Belum Terpotong &#128544;<span>";
				}
			} else {
				$warning_topup = "<span>$r->nama_kasir</span>";
			}
			$data[] = [
				$r->uid,
				$r->invoice_num,
				$r->no_invoice,
				$l_catg_k,
				$SMU,
				$r->nama_agent,
				$r->total_pieces ?? '-',
				$r->total_chargeable ?? '-',
				$r->total ?? '-',
				$tanggal_txt ?? '-',
				$jaster ?? '-',
				$warning_topup,
				$print,
			];
		}

		$output = [
			'draw'            => intval($_POST['draw'] ?? 0),
			'recordsTotal'    => $this->M_outgoing->count_all_invoice(),
			'recordsFiltered' => $this->M_outgoing->count_filtered_invoice(),
			'data'            => $data,
		];

		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($output));
	}

	public function get_detail_invoice($uid)
	{
		// Ambil billing
		$billing = $this->cb->where('b.uid', $uid)
			->select('b.*, c.nama_billing as nama_catg, c.jenis_billing')
			->from('out_billing b')
			->join('out_bill_catg c', 'c.uid = b.bill_catg_uid', 'left')
			->get()->row();

		if (!$billing) {
			echo json_encode(['status' => 'error']);
			return;
		}

		// Ambil jaster dari out_list
		$jaster_row = $this->cb->select('jaster')
			->where('bill_uid', $uid)->get('out_list')->row();
		$jaster_opt = $jaster_row->jaster ?? 0;

		if ($billing->bill_catg_uid == '' || $billing->bill_catg_uid == null) {

			// Ambil jaster dari out_list
			$catg_bill_row = $this->cb->select('o.catg_bill, c.jenis_billing, c.nama_billing as nama_catg,')
				->where('bill_uid', $uid)->from('out_list o')->join('out_bill_catg c', 'c.uid = o.catg_bill', 'left')->get()->row();
			$catg_bill = $catg_bill_row->catg_bill ?? 0;
			$jenis_billing = $catg_bill_row->jenis_billing ?? '';
			$nama_catg = $catg_bill_row->nama_catg ?? '';
		} else {
			$catg_bill = $billing->bill_catg_uid;
			$jenis_billing = $billing->jenis_billing;
			$nama_catg = $billing->nama_catg;
		}
		// Ambil kategori billing
		$catg = $this->cb->where('hold !=', '1')->get('out_bill_catg')->row();

		// Hitung total
		$total_berat = $billing->total_chargeable > 0
			? $billing->total_chargeable
			: $this->cb->select_sum('chargeable')->where('bill_uid', $uid)->get('out_list')->row()->chargeable;

		$total_pieces = $billing->total_pieces > 0
			? $billing->total_pieces
			: $this->cb->select_sum('jumlah')->where('bill_uid', $uid)->get('out_list')->row()->jumlah;

		$total_berat   = (float)$total_berat;
		$catg_sewa     = (float)$catg->sewa_gudang;
		$catg_kade     = (float)$catg->kade;
		$catg_csc      = (float)$catg->csc;
		$catg_jasa_ra  = (float)$catg->jasa_ra;

		$total_sewa    = $billing->total_cargo   > 0 ? (float)$billing->total_cargo   : $total_berat * $catg_sewa;
		$bg_ppn        = $billing->bg_ppn        > 0 ? (float)$billing->bg_ppn        : $total_sewa * 0.11;
		$administrasi  = $billing->administrasi  > 0 ? (float)$billing->administrasi  : 0;
		$materai       = $billing->materai       > 0 ? (float)$billing->materai       : 0;
		$bg_total      = $billing->bg_total      > 0 ? (float)$billing->bg_total      : $total_sewa + $bg_ppn + $administrasi + $materai;
		$total_kade    = $billing->total_kade    > 0 ? (float)$billing->total_kade    : $total_berat * $catg_kade;
		$total_csc     = $billing->total_csc     > 0 ? (float)$billing->total_csc     : $total_berat * $catg_csc;
		$total_jaster  = $jaster_opt > 0 ? ($billing->total_jaster > 0 ? (float)$billing->total_jaster : $total_berat * $catg_jasa_ra) : 0;
		$kc_sub_total  = $billing->kc_sub_total  > 0 ? (float)$billing->kc_sub_total  : $total_kade + $total_csc + $total_jaster;
		$kc_ppn        = $billing->kc_ppn        > 0 ? (float)$billing->kc_ppn        : $kc_sub_total * 0.11;
		$kc_total      = $billing->kc_total      > 0 ? (float)$billing->kc_total      : $kc_sub_total + $kc_ppn;
		$grand_total   = $billing->grand_total   > 0 ? (float)$billing->grand_total   : $kc_total + $bg_total;

		// Format angka
		$billing->total_pieces_k    = number_format($total_pieces);
		$billing->total_chargeable_k = number_format($total_berat);
		$billing->total_cargo_k     = number_format($total_sewa);
		$billing->total_cdc_k       = $billing->total_cdc > 0 ? number_format($billing->total_cdc) : '';
		$billing->bg_ppn_k          = number_format($bg_ppn);
		$billing->administrasi_k    = number_format($administrasi);
		$billing->materai_k         = number_format($materai);
		$billing->bg_total_k        = number_format($bg_total);
		$billing->total_kade_k      = number_format($total_kade);
		$billing->total_csc_k       = number_format($total_csc);
		$billing->total_jaster_k    = $jaster_opt > 0 ? number_format($total_jaster) : '';
		$billing->kc_sub_total_k    = number_format($kc_sub_total);
		$billing->kc_ppn_k          = number_format($kc_ppn);
		$billing->kc_total_k        = number_format($kc_total);
		$billing->grand_total_k     = number_format($grand_total);

		$billing->is_jaster = $jaster_opt;

		$new_no_invoice = "HLP.OUT-JASTER" . "-" . "$billing->invoice_num";

		$billing->no_invoice = $new_no_invoice;
		$billing->nama_catg = $nama_catg;
		if ($jenis_billing == '0') {
			$jenis_billing = 'UMUM';
		} else if ($jenis_billing == '1') {
			$jenis_billing = 'TRANSIT';
		}
		$billing->jenis_billing = $jenis_billing;
		$billing->bill_catg_uid = $catg_bill;

		if ($billing->pay_methode == '1') {
			$topup = $this->cb->select('agent_uid')
				->where(['billing_uid' => $uid, 'asal_table' => 'out_billing'])->get('all_topup')->row();
			if ($topup) {

				$agent = $this->cb->select('uid, kode, nama')
					->where('uid', $topup->agent_uid)->get('all_agent_deposit')->row();

				$agent_deposit_uid = $agent->uid;
				$kode_agent_deposit = $agent->kode;
				$nama_agent_deposit = $agent->nama;
			} else {
				$agent_deposit_uid = '';
				$kode_agent_deposit = '';
				$nama_agent_deposit = '';
			}
		} else {
			$agent_deposit_uid = '';
			$kode_agent_deposit = '';
			$nama_agent_deposit = '';
		}

		$billing->agent_deposit_uid = $agent_deposit_uid;
		$billing->kode_agent_deposit = $kode_agent_deposit;
		$billing->nama_agent_deposit = $nama_agent_deposit;


		// List SMU
		$list = $this->cb->select('uid, smu, tujuan, jumlah, chargeable, sewa_gudang')
			->where('bill_uid', $uid)->order_by('uid', 'ASC')->get('out_list')->result();

		$this->output->set_content_type('application/json')->set_output(json_encode([
			'billing' => $billing,
			'list'    => $list,
		]));
	}

	public function batal_smu_invoice()
	{
		$uid_smu = $this->input->post('uid_smu');
		$bil_uid = $this->input->post('bil_uid');

		$this->cb->where('uid', $uid_smu)->update('out_list', [
			'out_p'    => '0',
			'bill_uid' => '',
			'out_date' => '',
			'user_out' => '',
		]);

		// Cek apakah masih ada SMU di billing ini
		$count = $this->cb->where('bill_uid', $bil_uid)->count_all_results('out_list');
		if ($count == 0) {
			$this->cb->where('uid', $bil_uid)->delete('out_billing');
		}

		echo json_encode(['status' => 'success']);
	}

	public function get_bill_catg()
	{
		$search = $this->input->post('search');
		$this->cb->select('uid, nama_billing, jenis_billing,
    IF(jenis_billing = "0", "UMUM", IF(jenis_billing = "1", "TRANSIT", "")) as jenis', FALSE);
		$this->cb->from('out_bill_catg');
		$this->cb->where('hold !=', '1');
		if ($search) $this->cb->like('nama_billing', $search);
		echo json_encode($this->cb->get()->result());
	}

	public function update_invoice()
	{
		$bil_uid    = $this->input->post('bil_uid');
		$new_status = $this->input->post('new_status');
		$bill_catg  = $this->input->post('bill_catg');
		// echo ('Catg Bill =' . $bill_catg);
		// exit();
		$jaster     = $this->input->post('jaster');
		$pay_methode = $this->input->post('pay_methode');
		$agent_uid  = $this->input->post('agent_uid');
		// $nama_agent = $this->input->post('nama_agent');
		echo ('Agent UID :' . $this->input->post('nama_agent'));

		if ($pay_methode == '1') {
			$agent = $this->cb->where('uid', $this->input->post('nama_agent'))->get('all_agent_deposit')->row();

			$agent_uid = $agent->uid;
			$nama_agent = $agent->nama;
			$agent_alamat = $agent->alamat;
			$agent_telepon = $agent->telepon;
		} else {

			$agent_uid = '';
			$nama_agent = '';
			$agent_alamat = '';
			$agent_telepon = '';
		}
		$no_invoice = $this->input->post('no_invoice');
		$adm        = $this->input->post('adm');
		$materai    = $this->input->post('materai') ?? 0;
		$cdc        = $this->input->post('cdc');
		$telepon    = $this->input->post('telepon');

		$signdate   = time();
		$post_date1 = date('Ymd', $signdate);
		$post_date2 = date('His', $signdate);
		$post_dates = $post_date1 . $post_date2;

		// Format tanggal invoice
		$tanggal_invoice = $this->input->post('tanggal_invoice');
		$re_in_date_ex   = explode('-', $tanggal_invoice);
		$re_in_date      = $re_in_date_ex[0] . $re_in_date_ex[1] . $re_in_date_ex[2];
		$tanggal_billing = $re_in_date . $post_date2;

		// =============================================
		// STATUS 3 - BATAL
		// =============================================
		if ($new_status == '3') {
			$this->cb->where('uid', $bil_uid)->update('out_billing', [
				'total_pieces' => '',
				'total_gross' => '',
				'total_volume' => '',
				'total_chargeable' => '',
				'total_cargo' => '',
				'bg_ppn' => '',
				'administrasi' => '',
				'materai' => '',
				'bg_total' => '',
				'cdc' => '',
				'total_cdc' => '',
				'kade' => '',
				'csc' => '',
				'total_kade' => '',
				'total_csc' => '',
				'kc_sub_total' => '',
				'kc_ppn' => '',
				'kc_total' => '',
				'grand_total' => '',
				'grand_total_paid' => '',
				'terbilang' => '',
				'nama' => '',
				'alamat' => '',
				'telepon' => '',
				'status' => '3',
				'pay_status' => '',
				'pengirim_uid' => '',
				'tanggal_invoice' => '',
				'no_invoice' => '',
				'memo' => '',
				'virtual' => '',
				'pay_methode' => '',
				'user_kasir' => '',
				'diskon' => '',
				'total' => '',
				'agent_uid' => '',
				'nama_agent' => '',
				'post_date' => '',
				'bill_catg_uid' => '',
			]);

			$this->session->set_flashdata('message_name', 'Invoice berhasil dibatalkan.');
			redirect('outgoinghlp/daftar_invoice');
			return;
		}

		// =============================================
		// STATUS 2 - HAPUS
		// =============================================
		if ($new_status == '2') {
			$count = $this->cb->where('bill_uid', $bil_uid)->count_all_results('out_list');
			if ($count > 0) {
				$this->session->set_flashdata('message_error', 'Tidak bisa dihapus, invoice masih memiliki SMU.');
				redirect('outgoinghlp/daftar_invoice');
				return;
			}

			$this->cb->where('uid', $bil_uid)->delete('out_billing');

			// Hapus topup jika ada
			$cek_topup = $this->cb->where(['billing_uid' => $bil_uid, 'asal_table' => 'out_billing'])->count_all_results('all_topup');
			if ($cek_topup > 0) {
				$this->cb->where(['billing_uid' => $bil_uid, 'asal_table' => 'out_billing'])->delete('all_topup');
			}

			$this->session->set_flashdata('message_name', 'Invoice berhasil dihapus.');
			redirect('outgoinghlp/daftar_invoice');
			return;
		}

		// =============================================
		// STATUS 0 & 1 - UBAH & CETAK
		// Hitung semua biaya
		// =============================================

		// Update jaster di out_list
		$this->cb->where('bill_uid', $bil_uid)->update('out_list', ['jaster' => $jaster]);

		// Ambil jaster dari out_list
		$jaster_row = $this->cb->select('jaster')->where('bill_uid', $bil_uid)->get('out_list')->row();
		$jaster_opt = $jaster_row->jaster ?? 0;

		// Ambil kategori billing
		if ($jaster_opt == '1') {
			$catg = $this->cb->select('uid, csc, kade, sewa_gudang, jasa_ra')
				->where('uid', $bill_catg)->get('out_bill_catg')->row();
			$jasa_ra = (float)($catg->jasa_ra ?? 0);
		} else {
			$catg = $this->cb->select('uid, csc, kade, sewa_gudang')
				->where('uid', $bill_catg)->get('out_bill_catg')->row();
			$jasa_ra = 0;
		}

		$catg_sewa_gudang = (float)($catg->sewa_gudang ?? 0);
		$catg_kade        = (float)($catg->kade        ?? 0);
		$catg_csc         = (float)($catg->csc         ?? 0);

		// Update sewa gudang per SMU
		$list_smu = $this->cb->where('bill_uid', $bil_uid)->get('out_list')->result();
		foreach ($list_smu as $smu) {
			$sewa_baru = (float)$smu->chargeable * $catg_sewa_gudang;
			if ($sewa_baru < 25000) $sewa_baru = 25000;
			$this->cb->where('uid', $smu->uid)->update('out_list', ['sewa_gudang' => $sewa_baru]);
		}

		// Hitung total dari out_list
		$totals = $this->cb->select('SUM(jumlah) as total_pieces, SUM(gross) as total_gross, SUM(chargeable) as total_chargeable, SUM(volume) as total_volume')
			->where('bill_uid', $bil_uid)->get('out_list')->row();

		$total_pieces     = (float)($totals->total_pieces     ?? 0);
		$total_gross      = (float)($totals->total_gross      ?? 0);
		$total_chargeable = (float)($totals->total_chargeable ?? 0);
		$total_volume     = (float)($totals->total_volume     ?? 0);

		// Hitung biaya
		$total_cargo = $total_chargeable * $catg_sewa_gudang;
		if ($total_cargo < 25000) $total_cargo = 25000;

		$administrasi = $adm == '1' ? 20000 : 3000;
		$materai      = (float)$materai;

		$total_cdc = 0;
		if ($cdc == '1') {
			$total_cdc = $total_cargo * 0;
			$bg_ppn    = ($total_cargo + $total_cdc) * 0.11;
			$bg_total  = $total_cargo + $total_cdc + $bg_ppn + $administrasi + $materai;
		} else {
			$bg_ppn   = $total_cargo * 0.11;
			$bg_total = $total_cargo + $bg_ppn + $administrasi + $materai;
		}

		$total_kade    = $total_chargeable * $catg_kade;
		$total_csc     = $total_chargeable * $catg_csc;
		$total_jaster  = $total_chargeable * $jasa_ra;
		$kc_sub_total  = $total_kade + $total_csc + $total_jaster;
		$kc_ppn        = $kc_sub_total * 0.11;
		$kc_total      = $kc_sub_total + $kc_ppn;
		$total         = round($bg_total + $kc_total);

		// =============================================
		// STATUS 1 - CETAK
		// =============================================
		if ($new_status == '1') {
			if ($total_pieces <= 0) {
				$this->session->set_flashdata('message_error', 'Tidak bisa cetak, invoice tidak memiliki SMU.');
				redirect('outgoinghlp/daftar_invoice');
				return;
			}

			$update_data = [
				'total_pieces'     => $total_pieces,
				'total_gross'      => $total_gross,
				'total_volume'     => $total_volume,
				'total_chargeable' => $total_chargeable,
				'total_cargo'      => $total_cargo,
				'bg_ppn'           => $bg_ppn,
				'administrasi'     => $administrasi,
				'materai'          => $materai,
				'bg_total'         => $bg_total,
				'cdc'              => $cdc,
				'total_cdc'        => $total_cdc,
				'kade'             => $catg_kade,
				'csc'              => $catg_csc,
				'total_kade'       => $total_kade,
				'total_csc'        => $total_csc,
				'total_jaster'     => $total_jaster,
				'jaster'           => $jasa_ra,
				'kc_sub_total'     => $kc_sub_total,
				'kc_ppn'           => $kc_ppn,
				'kc_total'         => $kc_total,
				'grand_total'      => $total,
				'grand_total_paid' => $total,
				'status'           => '1',
				'pay_status'       => '1',
				'tanggal_invoice'  => $tanggal_billing,
				'no_invoice'       => $no_invoice,
				'pay_methode'      => $pay_methode,
				'user_kasir'       => $this->session->userdata('nip'),
				'total'            => $total,
				'bill_catg_uid'    => $bill_catg,
				'adm'              => $adm,
				'post_date'        => $post_dates,
				'terbilang' => ucwords(trim(terbilang($total))) . ' Rupiah',

			];

			echo ('Agent UID :' . $agent_uid);
			if ($pay_methode == '1') {

				if (!$agent_uid) {
					$this->session->set_flashdata('message_error', 'Anda Belum Memilih Agent.');

					redirect('outgoinghlp/daftar_invoice');
					return;
				}

				// Cek saldo
				$saldo_row = $this->cb->select('SUM(topup_saldo) - SUM(usage_saldo) as saldo')
					->where('agent_uid', $agent_uid)
					->where('asal_table', 'out_billing')
					->get('all_topup')
					->row();
				$cek_saldo = (float)($saldo_row->saldo ?? 0);

				$status_saldo = $cek_saldo > 5000000 ? '1' : '0';

				$this->cb->where('uid', $bil_uid)->update('out_billing', $update_data);

				// Update atau insert all_topup
				$cek_topup = $this->cb->where(['billing_uid' => $bil_uid, 'asal_table' => 'out_billing'])->count_all_results('all_topup');
				if ($cek_topup > 0) {
					$this->cb->where(['billing_uid' => $bil_uid, 'asal_table' => 'out_billing'])->update('all_topup', [
						'agent_uid'    => $agent_uid,
						'billing_uid'  => $bil_uid,
						'asal_table'   => 'out_billing',
						'usage_saldo'  => $total,
						'user_kasir'   => $this->session->userdata('nip'),
						'status_saldo' => $status_saldo,
						'post_date'    => $post_dates,
					]);
				} else {
					$this->cb->insert('all_topup', [
						'agent_uid'    => $agent_uid,
						'billing_uid'  => $bil_uid,
						'asal_table'   => 'out_billing',
						'usage_saldo'  => $total,
						'user_kasir'   => $this->session->userdata('nip'),
						'status_saldo' => $status_saldo,
						'post_date'    => $post_dates,
					]);
				}

				$msg = $cek_saldo > 5000000
					? 'Invoice berhasil dicetak. Sisa saldo ' . $nama_agent . ' adalah Rp' . number_format($cek_saldo)
					: 'Peringatan: Sisa saldo ' . $nama_agent . ' adalah Rp' . number_format($cek_saldo) . '. Harap hubungi agen yang bersangkutan.';

				$this->session->set_flashdata('message_name', $msg);
			} else {
				$this->cb->where('uid', $bil_uid)->update('out_billing', $update_data);

				// Hapus topup jika bukan deposit
				$cek_topup = $this->cb->where(['billing_uid' => $bil_uid, 'asal_table' => 'out_billing'])->count_all_results('all_topup');
				if ($cek_topup > 0) {
					$this->cb->where(['billing_uid' => $bil_uid, 'asal_table' => 'out_billing'])->delete('all_topup');
				}

				$this->session->set_flashdata('message_name', 'Invoice berhasil dicetak.');
			}

			if ($pay_methode == '1' || $pay_methode == '3') {
				$id_user = $this->session->userdata('nip');

				$tgl_invoice = $tanggal_billing;
				$tahun = substr($tgl_invoice, 0, 4);

				// $max_num = $this->m_invoice->select_max($tahun);
				$max_num = $this->m_invoice->select_max();

				if (!$max_num['max']) {
					$bilangan = 1; // Nilai Proses
				} else {
					$bilangan = $max_num['max'] + 1;
				}

				$month = substr($tgl_invoice, 5, 2);
				$year = substr($tgl_invoice, 2, 2);

				$no_inv = sprintf("%04d", $bilangan);
				$kode_cabang = sprintf("%02d", $this->session->userdata('kode_cabang'));

				$kop_invoice = $this->session->userdata('nama_akronim') . "-" . $kode_cabang;

				$slug = $no_inv . '/' . strtoupper($kop_invoice) . '/' . intToRoman($month) . '/' . $year;

				// $keterangan = trim($this->input->post('keterangan'));
				// $keterangan = 'Invoice ' . $no_inv . ' - ' . $nama_agent;

				if ($pay_methode == '1') {
					$metode_agent = 'METODE DEPOSIT';
					$nama_agent_keterangan = $nama_agent;
				} else if ($pay_methode == '3') {
					$metode_agent = 'METODE TRANSFER';
					$smu = $this->cb->select('nama_agent')->where('bill_uid', $bil_uid)->get('out_list')->row();
					$nama_agent_keterangan = $smu->nama_agent;
				}
				$keterangan = "PEMBAYARAN INVOICE " . $no_inv . ". " . $metode_agent . ", AGENT " . strtoupper($nama_agent_keterangan);

				// if ($jenis == 'pendapatan') {
				// $jenis_invoice = 'pendapatan';
				if ($pay_methode == '1') {
					$jenis_invoice = 'deposit';
				} else if ($pay_methode == '3') {
					$jenis_invoice = 'transfer';
				} else {
					$jenis_invoice = 'reguler';
				}
				// } else if ($jenis == 'khusus') {
				// 	$jenis_invoice = 'khusus';
				// } else {
				// 	$jenis_invoice = 'reguler';
				// }

				$sub_total = $total_cargo + $total_cargo;
				$total_ppn = $bg_ppn + $kc_ppn;
				$total_nonpph = $sub_total + $total_ppn;
				$coa_debit = $this->input->post('coa_debit');
				$coa_kredit = $this->input->post('coa_kredit');

				// Insert ke tabel invoice
				$invoice_data = [
					'no_invoice' => $no_inv,
					'tanggal_invoice' => $tgl_invoice,
					'created_by' => $id_user,
					'keterangan' => $keterangan,
					// 'id_customer' => $this->input->post('customer'),
					'subtotal' => $sub_total,
					'diskon' => isset($diskon) ? $diskon : '0',
					// 'besaran_diskon' => $besaran_diskon,
					'ppn' => 0.11,
					'besaran_ppn' => $total_ppn,
					'opsi_pph23' => isset($opsi_pph) ? $opsi_pph : '0',
					'opsi_ppn' => isset($opsi_ppn) ? $opsi_ppn : '0',
					'pph' => 0,
					'besaran_pph' => 0,
					'opsi_pph_ps4' => isset($opsi_pph_ps4) ? $opsi_pph_ps4 : '0',
					'pph_ps4' => 0,
					'besaran_pph_ps4' => 0,
					'total_nonpph' => $total_nonpph,
					'total_denganpph' => $total_nonpph,
					'coa_debit' => $coa_debit,
					'coa_kredit' => $coa_kredit,
					'nominal_bayar' => $total_nonpph,
					'nominal_pendapatan' => $sub_total,
					'jenis_invoice' => $jenis_invoice,
					// 'status_pendapatan' => isset($status_pendapatan) ? $status_pendapatan : '0'
					'opsi_termin' => isset($opsi_termin) ? $opsi_termin : '0',
					'status_pendapatan' => '1',
					'slug' => $slug,
					'id_cabang' => $this->session->userdata('kode_cabang'),
				];

				$this->cb->trans_begin();
				$id_invoice = $this->m_invoice->insert($invoice_data);

				if (!$id_invoice) {
					$this->cb->trans_rollback();
					$this->session->set_flashdata('message_name', 'Failed to create invoice.');
					redirect("outgoinghlp/daftar_invoice");
				}

				$item = $keterangan;
				$jumlah = 1;
				$total = $total_nonpph;
				$total_amount = $total_nonpph;

				$detail_data[] = [
					'id_invoice' => $id_invoice,
					'item' => strtoupper($item),
					'total' => $total,
					'qty' => $jumlah,
					'total_amount' => $total_amount,
					'created_by' => $id_user,
					'id_cabang' => $this->session->userdata('kode_cabang'),
				];


				if (!empty($detail_data)) {
					$insert = $this->m_invoice->insert_batch($detail_data);

					if ($insert === FALSE) {
						$this->cb->trans_rollback();
						$this->session->set_flashdata('message_name', 'Failed to insert invoice details.');
						redirect("outgoinghlp/daftar_invoice");
					}

					// Pastikan fungsi posting tidak mengganggu transaksi
					$this->posting($coa_debit, $coa_kredit, $keterangan, $total_nonpph, $tgl_invoice, $id_invoice);

					$this->cb->trans_commit();
					$this->session->set_flashdata('message_name', 'The invoice has been successfully created. ' . $no_inv);
					redirect("outgoinghlp/daftar_invoice");
				} else {
					$this->cb->trans_rollback();
					$this->session->set_flashdata('message_name', 'Invoice detail data is empty.');
					redirect("outgoinghlp/daftar_invoice");
				}


				// $keterangan = $this->input->post('keterangan');
				$nominal = $this->convertToNumberWithComma($total);
				// $coa_debit = $this->input->post('coa_debit');
				// $coa_kredit = $this->input->post('coa_kredit');

				// Pastikan fungsi posting tidak mengganggu transaksi
				$this->posting($coa_debit, $coa_kredit, $keterangan, $nominal, '', '');
			}

			redirect('outgoinghlp/daftar_invoice');
			return;
		}

		// =============================================
		// STATUS 0 - UBAH
		// =============================================
		if ($new_status == '0') {
			if ($total_pieces <= 0) {
				$this->session->set_flashdata('message_error', 'Tidak bisa update, invoice tidak memiliki SMU.');
				redirect('outgoinghlp/daftar_invoice');
				return;
			}

			$update_data = [
				'total_pieces'     => $total_pieces,
				'total_gross'      => $total_gross,
				'total_volume'     => $total_volume,
				'total_chargeable' => $total_chargeable,
				'total_cargo'      => $total_cargo,
				'bg_ppn'           => $bg_ppn,
				'administrasi'     => $administrasi,
				'materai'          => $materai,
				'bg_total'         => $bg_total,
				'cdc'              => $cdc,
				'total_cdc'        => $total_cdc,
				'kade'             => $catg_kade,
				'csc'              => $catg_csc,
				'total_kade'       => $total_kade,
				'total_csc'        => $total_csc,
				'total_jaster'     => $total_jaster,
				'jaster'           => $jasa_ra,
				'kc_sub_total'     => $kc_sub_total,
				'kc_ppn'           => $kc_ppn,
				'kc_total'         => $kc_total,
				'grand_total'      => $total,
				'grand_total_paid' => $total,
				'status'           => '0',
				'pay_status'       => '',
				'tanggal_invoice'  => $tanggal_billing,
				'no_invoice'       => $no_invoice,
				'pay_methode'      => $pay_methode,
				'user_kasir'       => $this->session->userdata('nip'),
				'total'            => $total,
				'bill_catg_uid'    => $bill_catg,
				'terbilang' => ucwords(trim(terbilang($total))) . ' Rupiah',
			];


			$this->cb->where('uid', $bil_uid)->update('out_billing', $update_data);
			$this->session->set_flashdata('message_name', 'Invoice berhasil diupdate.');
			redirect('outgoinghlp/daftar_invoice');
			return;
		}
	}

	public function print_invoice($uid)
	{
		// =============================================
		// Data Billing
		// =============================================
		$billing = $this->cb->select('
        b.uid, b.total_pieces, b.total_gross, b.total_volume, b.total_chargeable,
        b.total_cargo, b.bg_ppn, b.administrasi, b.materai, b.bg_total,
        b.kade, b.csc, b.total_kade, b.total_csc, b.kc_sub_total,
        b.kc_ppn, b.kc_total, b.grand_total, b.grand_total_paid, b.terbilang,
        b.nama, b.alamat, b.telepon, b.status, b.pay_status,
        b.tanggal_invoice, b.no_invoice, b.memo, b.virtual, b.pay_methode,
        b.no, b.user_bill, b.user_kasir, b.total_cdc, b.jaster, b.total_jaster,
        b.nama_agent, b.kade as kade_rate, b.csc as csc_rate
    ', FALSE)
			->from('out_billing b')
			->where('b.uid', $uid)
			->get()->row();

		if (!$billing) show_error('Data tidak ditemukan.', 404);

		// Jaster dari out_list
		$jaster_row = $this->cb->select('a.uid, a.jaster, b.nama as nama_agent_list', FALSE)
			->from('out_list a')
			->join('out_agent b', 'b.uid = a.agent_uid', 'left')
			->where('a.bill_uid', $uid)
			->get()->row();

		$jaster_opt  = $jaster_row->jaster      ?? 0;
		$nama_agent  = $jaster_row->nama_agent_list ?? $billing->nama_agent;

		// Kasir
		$kasir = $this->db->select('nama')->from('users')
			->where('nip', $billing->user_kasir)->get()->row();
		$kasir_name = $kasir->nama ?? '';

		// Format tanggal invoice
		$tgl_inv = $billing->tanggal_invoice;
		$date4Y  = substr($tgl_inv, 0, 4);
		$date4m  = substr($tgl_inv, 4, 2);
		$date4d  = substr($tgl_inv, 6, 2);
		$pm_billing_date_txt = $tgl_inv > 1 ? "$date4d-$date4m-$date4Y" : '-';

		// Angka format
		$total_sewa_gudang_k = number_format($billing->total_cargo, 2);
		$upd_total_cdc       = $billing->total_cdc > 0 ? number_format($billing->total_cdc, 2) : '';
		$bg_ppn_k            = number_format($billing->bg_ppn, 2);
		$administrasi_k      = number_format($billing->administrasi, 2);
		$materai_k           = $billing->materai > 0 ? number_format($billing->materai, 2) : '';
		$bg_total_k          = number_format($billing->bg_total, 2);
		$total_kade_k        = number_format($billing->total_kade, 2);
		$total_csc_k         = number_format($billing->total_csc, 2);
		$total_jaster_k      = $jaster_opt != '0' ? number_format($billing->total_jaster, 2) : '';
		$kc_sub_total_k      = number_format($billing->kc_sub_total, 2);
		$kc_ppn_k            = number_format($billing->kc_ppn, 2);
		$kc_total_k          = number_format($billing->kc_total, 2);
		$grand_total_k       = number_format($billing->grand_total, 2);
		$total_pieces_k      = number_format($billing->total_pieces);
		$total_chargeable_k  = number_format($billing->total_chargeable, 2);
		$kade_k              = number_format($billing->kade_rate);
		$csc_k               = number_format($billing->csc_rate);
		$jaster_rate_k       = number_format($billing->jaster);

		// List SMU billing
		$list_billing = $this->cb->where('bill_uid', $uid)
			->order_by('uid', 'ASC')
			->get('out_list')->result();

		// Data perusahaan
		// $corp = $this->cb->select('branch_name, phone1, addr1, addr2, img1, tax_num')
		// 	->where('branch_code', 'CORP_03')
		// 	->get('client_branch')->row();

		$corp_logo = "<img src='" . base_url('src/images/logo_bdt.jpg') . "' border='0' width='150'>";

		$data = [
			'billing'              => $billing,
			'jaster_opt'           => $jaster_opt,
			'nama_agent'           => $nama_agent,
			'kasir_name'           => $kasir_name,
			'pm_billing_date_txt'  => $pm_billing_date_txt,
			'total_sewa_gudang_k'  => $total_sewa_gudang_k,
			'upd_total_cdc'        => $upd_total_cdc,
			'bg_ppn_k'             => $bg_ppn_k,
			'administrasi_k'       => $administrasi_k,
			'materai_k'            => $materai_k,
			'bg_total_k'           => $bg_total_k,
			'total_kade_k'         => $total_kade_k,
			'total_csc_k'          => $total_csc_k,
			'total_jaster_k'       => $total_jaster_k,
			'kc_sub_total_k'       => $kc_sub_total_k,
			'kc_ppn_k'             => $kc_ppn_k,
			'kc_total_k'           => $kc_total_k,
			'grand_total_k'        => $grand_total_k,
			'total_pieces_k'       => $total_pieces_k,
			'total_chargeable_k'   => $total_chargeable_k,
			'kade_k'               => $kade_k,
			'csc_k'                => $csc_k,
			'jaster_rate_k'        => $jaster_rate_k,
			'list_billing'         => $list_billing,
			// 'corp'                 => $corp,
			'corp_logo'            => $corp_logo,
		];

		// =============================================
		// Data BTB - ambil btb_uid dari out_list
		// =============================================
		$btb_row = $this->cb->select('btb_uid')->where('bill_uid', $uid)->get('out_list')->row();
		$btb_uid = $btb_row->btb_uid ?? 0;

		$btb = null;
		$list_btb = [];
		$btb_name = '';
		$tanggal_txt = '-';

		if ($btb_uid) {
			$btb = $this->cb->select('uid, total_pieces, total_gross, total_volume, total_chargeable, nama, status, tanggal, no, user')
				->where('uid', $btb_uid)->get('out_list_btb')->row();

			if ($btb) {
				// Kasir BTB
				$kasir_btb = $this->db->select('nama')->from('users')
					->where('nip', $btb->user)->get()->row();
				$btb_name = $kasir_btb->nama ?? '';

				// Format tanggal BTB
				$tgl_btb = $btb->tanggal;
				$date4Y  = substr($tgl_btb, 0, 4);
				$date4m  = substr($tgl_btb, 4, 2);
				$date4d  = substr($tgl_btb, 6, 2);
				$tanggal_txt = $tgl_btb > 1 ? "$date4d-$date4m-$date4Y" : '-';

				// List SMU BTB
				$list_btb = $this->cb->where('btb_uid', $btb_uid)
					->order_by('uid', 'ASC')
					->get('out_list')->result();

				// Dimensi per SMU
				foreach ($list_btb as $s) {
					$s->dimensi = $this->cb->where('uid_list', $s->uid)
						->order_by('uid', 'ASC')
						->get('out_dimensi')->result();
				}
			}
		}

		$btb_no = $btb ? 'HLPO-' . $btb->no : '';

		$data['btb']          = $btb;
		$data['btb_no']       = $btb_no;
		$data['btb_name']     = $btb_name;
		$data['tanggal_txt']  = $tanggal_txt;
		$data['list_btb']     = $list_btb;

		$this->load->view('print_invoice', $data);
	}

	public function rekap_invoice()
	{
		$dari      = $this->input->post('dari');
		$sampai    = $this->input->post('sampai');
		$pengirim  = $this->input->post('pengirim');
		$kasir     = $this->input->post('kasir');
		$pay_methode = $this->input->post('pay_methode');

		$start_date = str_replace('-', '', $dari)   . '000000';
		$end_date   = str_replace('-', '', $sampai) . '235959';

		// Base query
		$this->cb->select('*', FALSE);
		$this->cb->from('out_billing');
		$this->cb->where('status', '1');
		$this->cb->where("tanggal_invoice BETWEEN '$start_date' AND '$end_date'", NULL, FALSE);

		if ($pengirim) {
			$this->cb->where('pengirim_uid', $pengirim);
		}
		if ($kasir) {
			$this->cb->where('user_kasir', $kasir);
		}
		if ($pay_methode == '1') {
			$this->cb->where('pay_methode', '1');
		} else if ($pay_methode == '2') {
			$this->cb->where('pay_methode', '2');
		} else if ($pay_methode == '3') {
			$this->cb->where('pay_methode', '3');
		} else if ($pay_methode == '4') {
			$this->cb->where('pay_methode', '4');
		} else if ($pay_methode == '5') {
			$this->cb->where('pay_methode', '5');
		}

		$this->cb->order_by('no_invoice, tanggal_invoice', 'ASC');
		$results = $this->cb->get()->result_array();

		// Load PhpSpreadsheet
		require APPPATH . 'third_party/autoload.php';

		// Include PhpSpreadsheet from third_party
		require APPPATH . 'third_party/psr/simple-cache/src/CacheInterface.php';

		$spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
		$sheet       = $spreadsheet->getActiveSheet();
		$sheet->setTitle('Rekap Outgoing HLP');

		// Header
		$headers = [
			'A'  => 'No',
			'B'  => 'No Invoice',
			'C'  => 'Tanggal',
			'D'  => 'Agen',
			'E'  => 'Pengirim',
			'F'  => 'No',
			'G'  => 'SMU',
			'H'  => 'Asal',
			'I'  => 'Koli',
			'J'  => 'Berat',
			'K'  => 'Biaya Gudang',
			'L'  => 'Volume',
			'M'  => 'Total Ch.W',
			'N'  => 'SubTotal Sewa Gudang',
			'O'  => 'Cargo Development Charge',
			'P'  => 'PPN BG',
			'Q'  => 'Administrasi',
			'R'  => 'Materai',
			'S'  => 'Total Sewa Gudang',
			'T'  => 'Jasa Terminal Handling',
			'U'  => 'Biaya Jaster',
			'V'  => 'Biaya CSC',
			'W'  => 'SubTotal KC',
			'X'  => 'PPN KC',
			'Y'  => 'Total KC',
			'Z'  => 'Total',
			'AA' => 'Pembayaran',
			'AB' => 'Keterangan',
			'AC' => 'Jaster',
		];

		foreach ($headers as $col => $label) {
			$sheet->setCellValue($col . '1', $label);
		}

		$sheet->getStyle('A1:AC1')->getFont()->setBold(true)->setSize(12);
		$sheet->getStyle('A1:AC1')->getAlignment()
			->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

		$nomor  = 1;
		$rowNum = 2;

		foreach ($results as $r) {
			$uid         = $r['uid'];
			$no_invoice  = $r['no_invoice'];
			$tanggal     = $r['tanggal_invoice'];
			$nama        = $r['nama'];
			$nama_agent  = $r['nama_agent'];
			$pay_methode = $r['pay_methode'];
			$uid_agent   = $r['agent_uid'];
			$uid_pengirim = $r['pengirim_uid'];
			$user_kasir  = $r['user_kasir'];

			$total_chargeable = $r['total_chargeable'];
			$total_cargo      = $r['total_cargo'];
			$total_cdc        = $r['total_cdc'];
			$bg_ppn           = $r['bg_ppn'];
			$administrasi     = $r['administrasi'];
			$materai          = $r['materai'];
			$bg_total         = $r['bg_total'];
			$total_kade       = $r['total_kade'];
			$total_jaster     = $r['total_jaster'];
			$total_csc        = $r['total_csc'];
			$kc_sub_total     = $r['kc_sub_total'];
			$kc_ppn           = $r['kc_ppn'];
			$kc_total         = $r['kc_total'];
			$grand_total      = $r['grand_total'];

			// Format pembayaran
			$pay_map = ['1' => 'Deposit', '2' => 'Cash', '3' => 'Transfer', '4' => 'Tagihan', '5' => 'FOC'];
			$pay     = $pay_map[$pay_methode] ?? '';

			// Jaster
			$jaster = $total_jaster > 0 ? 'JASTER' : 'Non JASTER';

			// Nama agent
			$agent = $this->cb->select('nama')->where('uid', $uid_agent)->get('out_agent')->row();
			$nama_agent = $agent->nama ?? '';

			// Nama pengirim
			$pengirim_row = $this->cb->select('nama')->where('uid', $uid_pengirim)->get('out_pengirim')->row();
			$nama_pengirim = $pengirim_row->nama ?? $nama;

			// Kasir
			$kasir_row = $this->db->select('nama')->where('nip', $user_kasir)->get('users')->row();
			$user_name = $kasir_row->nama ?? '';

			// Format tanggal
			$tgl_txt = $tanggal ? date('j F Y', strtotime(
				substr($tanggal, 0, 4) . '-' . substr($tanggal, 4, 2) . '-' . substr($tanggal, 6, 2)
			)) : '';

			// List SMU per billing
			$list_smu = $this->cb->select('uid, smu, tujuan, jumlah, chargeable, sewa_gudang, volume')
				->where('bill_uid', $uid)
				->order_by('uid', 'ASC')
				->get('out_list')->result_array();

			$no_smu   = 1;
			$startRow = $rowNum;

			foreach ($list_smu as $s) {
				$sheet->setCellValue('F' . $rowNum, $no_smu);
				$sheet->setCellValue('G' . $rowNum, $s['smu']);
				$sheet->setCellValue('H' . $rowNum, $s['tujuan']);
				$sheet->setCellValue('I' . $rowNum, $s['jumlah']);
				$sheet->setCellValue('J' . $rowNum, $s['chargeable']);
				$sheet->setCellValue('K' . $rowNum, $s['sewa_gudang']);
				$sheet->setCellValue('L' . $rowNum, $s['volume']);

				$rowNum++;
				$no_smu++;
			}

			$endRow = $rowNum - 1;

			// Merge kolom header billing jika ada lebih dari 1 SMU
			if ($endRow > $startRow) {
				foreach (['A', 'B', 'C', 'D', 'E', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC'] as $col) {
					$sheet->mergeCells($col . $startRow . ':' . $col . $endRow);
				}
			}

			// Set nilai billing di startRow
			$sheet->setCellValue('A'  . $startRow, $nomor);
			$sheet->setCellValue('B'  . $startRow, $no_invoice);
			$sheet->setCellValue('C'  . $startRow, $tgl_txt);
			$sheet->setCellValue('D'  . $startRow, $nama_agent);
			$sheet->setCellValue('E'  . $startRow, $nama_pengirim);
			$sheet->setCellValue('M'  . $startRow, $total_chargeable);
			$sheet->setCellValue('N'  . $startRow, $total_cargo);
			$sheet->setCellValue('O'  . $startRow, $total_cdc);
			$sheet->setCellValue('P'  . $startRow, $bg_ppn);
			$sheet->setCellValue('Q'  . $startRow, $administrasi);
			$sheet->setCellValue('R'  . $startRow, $materai);
			$sheet->setCellValue('S'  . $startRow, $bg_total);
			$sheet->setCellValue('T'  . $startRow, $total_kade);
			$sheet->setCellValue('U'  . $startRow, $total_jaster);
			$sheet->setCellValue('V'  . $startRow, $total_csc);
			$sheet->setCellValue('W'  . $startRow, $kc_sub_total);
			$sheet->setCellValue('X'  . $startRow, $kc_ppn);
			$sheet->setCellValue('Y'  . $startRow, $kc_total);
			$sheet->setCellValue('Z'  . $startRow, $grand_total);
			$sheet->setCellValue('AA' . $startRow, $pay);
			$sheet->setCellValue('AB' . $startRow, $user_name);
			$sheet->setCellValue('AC' . $startRow, $jaster);

			$nomor++;
		}

		// Baris total
		$totalRow = $rowNum;
		$firstRow = 2;
		$lastRow  = $rowNum - 1;

		$sheet->mergeCells('A' . $totalRow . ':K' . $totalRow);
		$sheet->getStyle('A' . $totalRow)->getAlignment()
			->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
		$sheet->setCellValue('A' . $totalRow, 'TOTAL');

		foreach (['L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'] as $col) {
			$sheet->setCellValue($col . $totalRow, '=SUM(' . $col . $firstRow . ':' . $col . $lastRow . ')');
		}

		// Autosize
		$cols = array_merge(range('A', 'Z'), ['AA', 'AB', 'AC']);
		foreach ($cols as $col) {
			$sheet->getColumnDimension($col)->setAutoSize(true);
		}

		// Download
		require APPPATH . 'third_party/autoload_zip.php';
		$filename = 'rekap_outgoing_HLP_' . date('d-m-Y') . '.xlsx';

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="' . $filename . '"');
		header('Cache-Control: max-age=0');

		$writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
		$writer->save('php://output');
		exit();
	}

	// DAFTAR INVOICE KHUSUS
	public function daftar_invoice_khusus()
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

		$data['title'] = "Daftar Invoice Khusus";


		// Ambil data COA DEPOSIT
		// Ambil data COA kedua
		$coa_12002 = $this->m_coa->getCoaByCode('12002');
		$coa_12001 = $this->m_coa->getCoaByCode('12001');

		$merged_coa_debit_depo = array_merge($coa_12002, $coa_12001);

		$coa_debit_depo = $this->m_coa->getCoaByCode('21040');


		$coa_debit_transfer = $merged_coa_debit_depo;

		// $coa_41001 = $this->m_coa->getCoaByCode('41001');
		$coa_41001 = $this->m_coa->getCoaByCode('41001');
		// $coa_41003 = $this->m_coa->getCoaByCode('41003');
		$coa_13010 = $this->m_coa->getCoaByCode('13010');


		// $merged_coa_kredit_transfer = array_merge($coa_41001, $coa_41002, $coa_41003, $coa_13010);
		$merged_coa_kredit_transfer = array_merge($coa_41001,  $coa_13010);


		$data['coa_1'] = $coa_debit_depo;
		// $data['coa_2'] = $coa_kredit_depo;
		$data['coa_2'] = $coa_41001;

		$data['coa_3'] = $coa_debit_transfer;
		$data['coa_4'] = $merged_coa_kredit_transfer;

		// $data['customers'] = $this->M_outgoing->kemasan_smu();

		$this->load->view('daftar_invoice_khusus', $data);
	}

	public function getData_invoice_khusus()
	{
		$results = $this->M_outgoing->get_datatables_invoice_khusus();
		$data    = [];

		$no = 0;
		foreach ($results as $r) {


			// Dates
			$wday1 = substr($r->tanggal_invoice, 0, 4);
			$wday2 = substr($r->tanggal_invoice, 4, 2);
			$wday3 = substr($r->tanggal_invoice, 6, 2);
			$wday4 = substr($r->tanggal_invoice, 8, 2);
			$wday5 = substr($r->tanggal_invoice, 10, 2);
			$wday6 = substr($r->tanggal_invoice, 12, 2);
			$time2 = "$wday4" . ":" . "$wday5";
			if ($r->tanggal_invoice != "") {
				$tanggal_txt = "$wday3" . "-" . "$wday2" . "-" . "$wday1" . " " . "$time2";
			} else {
				$tanggal_txt = "";
			}

			if ($r->catg_smu == '1') {
				$l_catg_k = "Langsung(Direct)";
			} else if ($r->catg_smu == '2') {
				$l_catg_k = "Transhipment";
			} else if ($r->catg_smu == '3') {
				$l_catg_k = "Terminal change(w/o inv)";
			} else if ($r->catg_smu == '4') {
				$l_catg_k = "Direct from RA";
			} else {
				$l_catg_k = '';
			}

			if ($r->is_jaster == '1') {
				$jaster = "<span class='btn btn-sm' style='color:#5cb85c; border:1px solid #5cb85c; background:transparent;'>Jaster</span> ";
			} else {
				$jaster = "<span class='btn btn-sm' style='color:#d9534f; border:1px solid #d9534f; background:transparent;'>No Jaster</span> ";
			}
			$print = '';
			if ($r->pay_status == '1') {
				$print = "<a target='_blank' class='btn btn-sm btn-primary' href='" . base_url() . "outgoinghlp/print_invoice_khusus/{$r->uid}'>
        <i class='fa fa-print'></i> Invoice</a>";
			}

			$pesawat = $this->cb->where('nama', $r->pesawat)->get('out_pesawat')->row();
			$warna = $pesawat->warna ?? Null;
			if ($warna) {
				$SMU = "<span class='btn btn-sm' style='color:#fff; border:1px solid #fff; background-color:#$warna;'>$r->smu</span> ";
			} else {
				$SMU = "<span class='btn btn-sm' style='color:#73879C;'>$r->smu</span> ";
			}

			$data[] = [
				$r->uid,
				$r->invoice_num,
				$r->no_invoice,
				$l_catg_k,
				$SMU,
				$r->nama_agent,
				$r->total_pieces ?? '-',
				$r->total_chargeable ?? '-',
				$r->total ?? '-',
				$tanggal_txt ?? '-',
				$jaster ?? '-',
				$r->nama_kasir ?? '-',
				$print,
			];
		}

		$output = [
			'draw'            => intval($_POST['draw'] ?? 0),
			'recordsTotal'    => $this->M_outgoing->count_all_invoice_khusus(),
			'recordsFiltered' => $this->M_outgoing->count_filtered_invoice_khusus(),
			'data'            => $data,
		];

		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($output));
	}

	public function get_detail_invoice_khusus($uid)
	{
		// Ambil billing
		$billing = $this->cb->where('b.uid', $uid)
			->select('b.*, c.nama_billing as nama_catg, c.jenis_billing')
			->from('out_billing_inv_khusus b')
			->join('out_bill_catg_inv_khusus c', 'c.uid = b.bill_catg_uid', 'left')
			->get()->row();

		if (!$billing) {
			echo json_encode(['status' => 'error']);
			return;
		}

		// Ambil jaster dari out_list
		$jaster_row = $this->cb->select('jaster')
			->where('bill_khusus_uid', $uid)->get('out_list')->row();
		$jaster_opt = $jaster_row->jaster ?? 0;

		if ($billing->bill_catg_uid == '' || $billing->bill_catg_uid == null) {

			// Ambil jaster dari out_list
			$catg_bill_row = $this->cb->select('o.catg_bill, c.jenis_billing, c.nama_billing as nama_catg,')
				->where('bill_khusus_uid', $uid)->from('out_list o')->join('out_bill_catg_inv_khusus c', 'c.uid = o.catg_bill', 'left')->get()->row();
			$catg_bill = $catg_bill_row->catg_bill ?? 0;
			$jenis_billing = $catg_bill_row->jenis_billing ?? '';
			$nama_catg = $catg_bill_row->nama_catg ?? '';
		} else {
			$catg_bill = $billing->bill_catg_uid;
			$jenis_billing = $billing->jenis_billing;
			$nama_catg = $billing->nama_catg;
		}
		// Ambil kategori billing
		$catg = $this->cb->where('hold !=', '1')->get('out_bill_catg_inv_khusus')->row();

		// Hitung total
		$total_berat = $billing->total_chargeable > 0
			? $billing->total_chargeable
			: $this->cb->select_sum('chargeable')->where('bill_khusus_uid', $uid)->get('out_list')->row()->chargeable;

		$total_pieces = $billing->total_pieces > 0
			? $billing->total_pieces
			: $this->cb->select_sum('jumlah')->where('bill_khusus_uid', $uid)->get('out_list')->row()->jumlah;

		$total_berat   = (float)$total_berat;
		$catg_sewa     = (float)$catg->sewa_gudang;
		$catg_kade     = (float)$catg->kade;
		$catg_csc      = (float)$catg->csc;
		$catg_jasa_ra  = (float)$catg->jasa_ra;

		$total_sewa    = $billing->total_cargo   > 0 ? (float)$billing->total_cargo   : $total_berat * $catg_sewa;
		$grand_total   = $billing->grand_total   > 0 ? (float)$billing->grand_total   : $total_sewa;

		// Format angka
		$billing->total_pieces_k    = number_format($total_pieces);
		$billing->total_chargeable_k = number_format($total_berat);
		$billing->total_cargo_k     = number_format($total_sewa);
		$billing->grand_total_k     = number_format($grand_total);

		$billing->is_jaster = $jaster_opt;

		// $new_no_invoice = "HLP.OUT-JASTER" . "-" . "$billing->invoice_num";

		// $billing->no_invoice = $new_no_invoice;
		$billing->nama_catg = $nama_catg;
		if ($jenis_billing == '0') {
			$jenis_billing = 'UMUM';
		} else if ($jenis_billing == '1') {
			$jenis_billing = 'TRANSIT';
		}
		$billing->jenis_billing = $jenis_billing;
		$billing->bill_catg_uid = $catg_bill;

		if ($billing->pay_methode == '1') {
			$topup = $this->cb->select('agent_uid')
				->where(['billing_uid' => $uid, 'asal_table' => 'out_billing_inv_khusus'])->get('all_topup')->row();
			if ($topup) {

				$agent = $this->cb->select('uid, kode, nama')
					->where('uid', $topup->agent_uid)->get('all_agent_deposit')->row();

				$agent_deposit_uid = $agent->uid;
				$kode_agent_deposit = $agent->kode;
				$nama_agent_deposit = $agent->nama;
			} else {
				$agent_deposit_uid = '';
				$kode_agent_deposit = '';
				$nama_agent_deposit = '';
			}
		} else {
			$agent_deposit_uid = '';
			$kode_agent_deposit = '';
			$nama_agent_deposit = '';
		}

		$billing->agent_deposit_uid = $agent_deposit_uid;
		$billing->kode_agent_deposit = $kode_agent_deposit;
		$billing->nama_agent_deposit = $nama_agent_deposit;


		// List SMU
		$list = $this->cb->select('uid, smu, tujuan, jumlah, chargeable, sewa_gudang')
			->where('bill_khusus_uid', $uid)->order_by('uid', 'ASC')->get('out_list')->result();

		$this->output->set_content_type('application/json')->set_output(json_encode([
			'billing' => $billing,
			'list'    => $list,
		]));
	}

	public function batal_smu_invoice_khusus()
	{
		$uid_smu = $this->input->post('uid_smu');
		$bil_uid = $this->input->post('bil_uid');

		$this->cb->where('uid', $uid_smu)->update('out_list', [
			'out_p'    => '0',
			'bill_khusus_uid' => '',
			'out_date' => '',
			'user_out' => '',
		]);

		// Cek apakah masih ada SMU di billing ini
		$count = $this->cb->where('bill_khusus_uid', $bil_uid)->count_all_results('out_list');
		if ($count == 0) {
			$this->cb->where('uid', $bil_uid)->delete('out_billing_inv_khusus');
		}

		echo json_encode(['status' => 'success']);
	}

	public function get_bill_catg_inv_khusus()
	{
		$search = $this->input->post('search');
		$this->cb->select('uid, nama_billing, jenis_billing,
    IF(jenis_billing = "0", "UMUM", IF(jenis_billing = "1", "TRANSIT", "")) as jenis', FALSE);
		$this->cb->from('out_bill_catg_inv_khusus');
		$this->cb->where('hold !=', '1');
		if ($search) $this->cb->like('nama_billing', $search);
		echo json_encode($this->cb->get()->result());
	}

	public function update_invoice_khusus()
	{
		$bil_uid    = $this->input->post('bil_uid');
		$new_status = $this->input->post('new_status');
		$bill_catg  = $this->input->post('bill_catg');
		// echo ('Catg Bill =' . $bill_catg);
		// exit();
		$jaster     = $this->input->post('jaster');
		$pay_methode = $this->input->post('pay_methode');
		if ($pay_methode == '1') {
			$agent_uid  = $this->input->post('agent_uid');
			// $nama_agent = $this->input->post('nama_agent');
			echo ('Agent UID :' . $this->input->post('nama_agent'));

			$agent = $this->cb->where('uid', $this->input->post('nama_agent'))->get('all_agent_deposit')->row();

			$agent_uid = $agent->uid;
			$nama_agent = $agent->nama;
			$agent_alamat = $agent->alamat;
			$agent_telepon = $agent->telepon;
		} else {
			$agent_uid = '';
			$nama_agent = '';
			$agent_alamat = '';
			$agent_telepon = '';
		}

		// $no_invoice = $this->input->post('no_invoice');
		$invoice_num = $this->input->post('invoice_num');
		$adm        = $this->input->post('adm');
		$materai    = $this->input->post('materai') ?? 0;
		$cdc        = $this->input->post('cdc');
		$telepon    = $this->input->post('telepon');

		$signdate   = time();
		$post_date1 = date('Ymd', $signdate);
		$post_date2 = date('His', $signdate);
		$post_dates = $post_date1 . $post_date2;

		// Format tanggal invoice
		$tanggal_invoice = $this->input->post('tanggal_invoice');
		$re_in_date_ex   = explode('-', $tanggal_invoice);
		$re_in_date      = $re_in_date_ex[0] . $re_in_date_ex[1] . $re_in_date_ex[2];
		$tanggal_billing = $re_in_date . $post_date2;

		echo ('Tanggal Invoice :' . $tanggal_invoice);

		// $tanggal_tanggal = substr($tanggal_invoice, 6, 2);
		// $tanggal_bulan = substr($tanggal_invoice, 4, 2);
		// $tanggal_tahun = substr($tanggal_invoice, 0, 4);
		// $tanggal_tahun_2dig = substr($tanggal_invoice, 2, 2);
		$tanggal_tahun_2dig = substr($tanggal_invoice, 2, 2);
		$tanggal_bulan   = substr($tanggal_invoice, 5, 2);  // 07
		$tanggal_tanggal = substr($tanggal_invoice, 8, 2);  // 06

		if ($tanggal_bulan == '01') {
			$bulan = 'I';
		} elseif ($tanggal_bulan == '02') {
			$bulan = 'II';
		} elseif ($tanggal_bulan == '03') {
			$bulan = 'III';
		} elseif ($tanggal_bulan == '04') {
			$bulan = 'IV';
		} elseif ($tanggal_bulan == '05') {
			$bulan = 'V';
		} elseif ($tanggal_bulan == '06') {
			$bulan = 'VI';
		} elseif ($tanggal_bulan == '07') {
			$bulan = 'VII';
		} elseif ($tanggal_bulan == '08') {
			$bulan = 'VIII';
		} elseif ($tanggal_bulan == '09') {
			$bulan = 'IX';
		} elseif ($tanggal_bulan == '10') {
			$bulan = 'X';
		} elseif ($tanggal_bulan == '11') {
			$bulan = 'XI';
		} elseif ($tanggal_bulan == '12') {
			$bulan = 'XII';
		}

		$kop_gdg = 'LJAWH';
		$no_invoice = "$invoice_num/$kop_gdg/$bulan/$tanggal_tahun_2dig";

		echo ('Bulan :' . $tanggal_bulan);
		echo ('No Invoice :' . $no_invoice);
		// exit();
		// =============================================
		// STATUS 3 - BATAL
		// =============================================
		if ($new_status == '3') {
			$this->cb->where('uid', $bil_uid)->update('out_billing_inv_khusus', [
				'total_pieces' => '',
				'total_gross' => '',
				'total_volume' => '',
				'total_chargeable' => '',
				'total_cargo' => '',
				'bg_ppn' => '',
				'administrasi' => '',
				'materai' => '',
				'bg_total' => '',
				'cdc' => '',
				'total_cdc' => '',
				'kade' => '',
				'csc' => '',
				'total_kade' => '',
				'total_csc' => '',
				'kc_sub_total' => '',
				'kc_ppn' => '',
				'kc_total' => '',
				'grand_total' => '',
				'grand_total_paid' => '',
				'terbilang' => '',
				'nama' => '',
				'alamat' => '',
				'telepon' => '',
				'status' => '3',
				'pay_status' => '',
				'pengirim_uid' => '',
				'tanggal_invoice' => '',
				'no_invoice' => '',
				'memo' => '',
				'virtual' => '',
				'pay_methode' => '',
				'user_kasir' => '',
				'diskon' => '',
				'total' => '',
				'agent_uid' => '',
				'nama_agent' => '',
				'post_date' => '',
				'bill_catg_uid' => '',
			]);

			$this->session->set_flashdata('message_name', 'Invoice berhasil dibatalkan.');
			redirect('outgoinghlp/daftar_invoice_khusus');
			return;
		}

		// =============================================
		// STATUS 2 - HAPUS
		// =============================================
		if ($new_status == '2') {
			$count = $this->cb->where('bill_khusus_uid', $bil_uid)->count_all_results('out_list');
			if ($count > 0) {
				$this->session->set_flashdata('message_error', 'Tidak bisa dihapus, invoice masih memiliki SMU.');
				redirect('outgoinghlp/daftar_invoice_khusus');
				return;
			}

			$this->cb->where('uid', $bil_uid)->delete('out_billing_inv_khusus');

			// Hapus topup jika ada
			$cek_topup = $this->cb->where(['billing_uid' => $bil_uid, 'asal_table' => 'out_billing_inv_khusus'])->count_all_results('all_topup');
			if ($cek_topup > 0) {
				$this->cb->where(['billing_uid' => $bil_uid, 'asal_table' => 'out_billing_inv_khusus'])->delete('all_topup');
			}

			$this->session->set_flashdata('message_name', 'Invoice berhasil dihapus.');
			redirect('outgoinghlp/daftar_invoice_khusus');
			return;
		}

		// =============================================
		// STATUS 0 & 1 - UBAH & CETAK
		// Hitung semua biaya
		// =============================================

		// Update jaster di out_list
		$this->cb->where('bill_khusus_uid', $bil_uid)->update('out_list', ['jaster' => $jaster]);

		// Ambil jaster dari out_list
		$jaster_row = $this->cb->select('jaster')->where('bill_khusus_uid', $bil_uid)->get('out_list')->row();
		$jaster_opt = $jaster_row->jaster ?? 0;

		// Ambil kategori billing
		$catg = $this->cb->select('uid, csc, kade, sewa_gudang, ppn_gdg, ppn_ra, jasa_ra, cdc')
			->where('uid', $bill_catg)->get('out_bill_catg_inv_khusus')->row();
		// $jasa_ra = (float)($catg->jasa_ra ?? 0);


		$catg_sewa_gudang = (float)($catg->sewa_gudang ?? 0);
		$catg_kade        = (float)($catg->kade        ?? 0);
		$catg_csc         = (float)($catg->csc         ?? 0);
		$catg_ppn_gdg     = (float)($catg->ppn_gdg     ?? 0);
		$catg_ppn_ra      = (float)($catg->ppn_ra      ?? 0);
		$catg_cdc         = (float)($catg->cdc         ?? 0);
		$catg_harga_ra    = (float)($catg->jasa_ra     ?? 0);

		// Update sewa gudang per SMU
		$smu = $this->cb->where('bill_khusus_uid', $bil_uid)->get('out_list')->row();
		// foreach ($list_smu as $smu) {
		$chargeWeight = (float)$smu->chargeable;

		if ($jaster_opt == '1') {
			$total_harga_sewa = $catg_sewa_gudang + $catg_harga_ra;
		} else {
			$total_harga_sewa = $catg_sewa_gudang;
		}
		$sewa_baru = (float)$smu->chargeable * $total_harga_sewa;
		if ($sewa_baru < 25000) $sewa_baru = 25000;
		$this->cb->where('uid', $smu->uid)->update('out_list', ['sewa_gudang' => $sewa_baru]);
		// }

		// Hitung total dari out_list
		$totals = $this->cb->select('SUM(jumlah) as total_pieces, SUM(gross) as total_gross, SUM(chargeable) as total_chargeable, SUM(volume) as total_volume')
			->where('bill_khusus_uid', $bil_uid)->get('out_list')->row();

		$total_pieces     = (float)($totals->total_pieces     ?? 0);
		$total_gross      = (float)($totals->total_gross      ?? 0);
		$total_chargeable = (float)($totals->total_chargeable ?? 0);
		$total_volume     = (float)($totals->total_volume     ?? 0);

		$sub_sewa_gdg = $sewa_baru;

		// minimal charge 25000 untuk sewa gudang
		if ($sub_sewa_gdg < 25000) {
			$sub_sewa_gdg = 25000;
		} else {
			$sub_sewa_gdg = $sub_sewa_gdg;
		}

		$sub_csc_gdg = $chargeWeight * $catg_csc;
		$sub_cdc_gdg = $chargeWeight * $catg_cdc;
		$sub_kade_gdg = $chargeWeight * $catg_kade;
		$sub_total_gdg = $sub_sewa_gdg + $sub_csc_gdg + $sub_cdc_gdg + $sub_kade_gdg;

		// $sub_total_ra = $chargeWeight * $catg_harga_ra;

		// // minimal charge 25000 untuk biaya RA
		// if ($sub_total_ra < 25000) {
		// 	$sub_total_ra = 25000;
		// } else {
		// 	$sub_total_ra = $sub_total_ra;
		// }

		// $ppnInDecimal_gdg = $catg_ppn_gdg / 100;
		// $ppn_value_gdg = $ppnInDecimal_gdg * $sub_total_gdg;

		// if ($ppn_value_gdg == '0') {
		// 	$ppn_value_gdg = '';
		// } else {
		// 	$ppn_value_gdg = $ppn_value_gdg;
		// }

		// // var_dump($sub_total_ra, $sub_sewa_gdg);exit;

		// $ppnInDecimal_ra = $catg_ppn_ra / 100;
		// $ppn_value_ra = $ppnInDecimal_ra * $sub_total_ra;

		// if ($ppn_value_ra == '0') {
		// 	$ppn_value_ra = '';
		// } else {
		// 	$ppn_value_ra = $ppn_value_ra;
		// }

		// $grand_total_gdg = (float)$sub_total_gdg + (float)$ppn_value_gdg +  (float)$adm;
		$grand_total_gdg = (float)$sub_total_gdg;
		$grand_total_gdg = round($grand_total_gdg);
		// $grand_total_ra = $sub_total_ra + $ppn_value_ra;
		// $grand_total_ra = round($grand_total_ra);

		// // Hitung biaya
		$total_cargo = $total_chargeable * $catg_sewa_gudang;
		// if ($total_cargo < 25000) $total_cargo = 25000;

		// $administrasi = $adm == '1' ? 20000 : 3000;
		// $materai      = (float)$materai;

		// $total_cdc = 0;
		// if ($cdc == '1') {
		// 	$total_cdc = $total_cargo * 0;
		// 	$bg_ppn    = ($total_cargo + $total_cdc) * 0.11;
		// 	$bg_total  = $total_cargo + $total_cdc + $bg_ppn + $administrasi + $materai;
		// } else {
		// 	$bg_ppn   = $total_cargo * 0.11;
		// 	$bg_total = $total_cargo + $bg_ppn + $administrasi + $materai;
		// }

		// $total_kade    = $total_chargeable * $catg_kade;
		// $total_csc     = $total_chargeable * $catg_csc;
		// $total_jaster  = $total_chargeable * $jasa_ra;
		// $kc_sub_total  = $total_kade + $total_csc + $total_jaster;
		// $kc_ppn        = $kc_sub_total * 0.11;
		// $kc_total      = $kc_sub_total + $kc_ppn;
		// $total         = round($bg_total + $kc_total);

		// =============================================
		// STATUS 1 - CETAK
		// =============================================
		if ($new_status == '1') {
			if ($total_pieces <= 0) {
				$this->session->set_flashdata('message_error', 'Tidak bisa cetak, invoice tidak memiliki SMU.');
				redirect('outgoinghlp/daftar_invoice_khusus');
				return;
			}

			$update_data = [
				'total_pieces'     => $total_pieces,
				'total_gross'      => $total_gross,
				'total_volume'     => $total_volume,
				'total_chargeable' => $total_chargeable,
				'total_cargo'      => $total_cargo,
				// 'bg_ppn'           => $bg_ppn,
				// 'administrasi'     => $administrasi,
				// 'materai'          => $materai,
				'bg_total'         => $grand_total_gdg,
				// 'cdc'              => $cdc,
				// 'total_cdc'        => $total_cdc,
				// 'kade'             => $catg_kade,
				// 'csc'              => $catg_csc,
				// 'total_kade'       => $total_kade,
				// 'total_csc'        => $total_csc,
				// 'total_jaster'     => $total_jaster,
				// 'jaster'           => $jasa_ra,
				// 'kc_sub_total'     => $kc_sub_total,
				// 'kc_ppn'           => $kc_ppn,
				// 'kc_total'         => $kc_total,
				'grand_total'      => $grand_total_gdg,
				'grand_total_paid' => $grand_total_gdg,
				'status'           => '1',
				'pay_status'       => '1',
				'tanggal_invoice'  => $tanggal_billing,
				'no_invoice'       => $no_invoice,
				'pay_methode'      => $pay_methode,
				'user_kasir'       => $this->session->userdata('nip'),
				'total'            => $grand_total_gdg,
				'bill_catg_uid'    => $bill_catg,
				'adm'              => $adm,
				'post_date'        => $post_dates,
				'terbilang' => ucwords(trim(terbilang($grand_total_gdg))) . ' Rupiah',

			];

			echo ('Agent UID :' . $agent_uid);
			if ($pay_methode == '1') {

				if (!$agent_uid) {
					$this->session->set_flashdata('message_error', 'Anda Belum Memilih Agent.');

					redirect('outgoinghlp/daftar_invoice_khusus');
					return;
				}

				// Cek saldo
				$saldo_row = $this->cb->select('SUM(topup_saldo) - SUM(usage_saldo) as saldo')
					->where('agent_uid', $agent_uid)
					->where('asal_table', 'out_billing_inv_khusus')
					->get('all_topup')
					->row();
				$cek_saldo = (float)($saldo_row->saldo ?? 0);

				$status_saldo = $cek_saldo > 5000000 ? '1' : '0';

				$this->cb->where('uid', $bil_uid)->update('out_billing_inv_khusus', $update_data);

				// Update atau insert all_topup
				$cek_topup = $this->cb->where(['billing_uid' => $bil_uid, 'asal_table' => 'out_billing_inv_khusus'])->count_all_results('all_topup');
				if ($cek_topup > 0) {
					$this->cb->where(['billing_uid' => $bil_uid, 'asal_table' => 'out_billing_inv_khusus'])->update('all_topup', [
						'agent_uid'    => $agent_uid,
						'billing_uid'  => $bil_uid,
						'asal_table'   => 'out_billing_inv_khusus',
						'usage_saldo'  => $grand_total_gdg,
						'user_kasir'   => $this->session->userdata('nip'),
						'status_saldo' => $status_saldo,
						'post_date'    => $post_dates,
					]);
				} else {
					$this->cb->insert('all_topup', [
						'agent_uid'    => $agent_uid,
						'billing_uid'  => $bil_uid,
						'asal_table'   => 'out_billing_inv_khusus',
						'usage_saldo'  => $grand_total_gdg,
						'user_kasir'   => $this->session->userdata('nip'),
						'status_saldo' => $status_saldo,
						'post_date'    => $post_dates,
					]);
				}

				$msg = $cek_saldo > 5000000
					? 'Invoice berhasil dicetak. Sisa saldo ' . $nama_agent . ' adalah Rp' . number_format($cek_saldo)
					: 'Peringatan: Sisa saldo ' . $nama_agent . ' adalah Rp' . number_format($cek_saldo) . '. Harap hubungi agen yang bersangkutan.';

				$this->session->set_flashdata('message_name', $msg);
			} else {
				$this->cb->where('uid', $bil_uid)->update('out_billing_inv_khusus', $update_data);

				// Hapus topup jika bukan deposit
				$cek_topup = $this->cb->where(['billing_uid' => $bil_uid, 'asal_table' => 'out_billing_inv_khusus'])->count_all_results('all_topup');
				if ($cek_topup > 0) {
					$this->cb->where(['billing_uid' => $bil_uid, 'asal_table' => 'out_billing_inv_khusus'])->delete('all_topup');
				}

				$this->session->set_flashdata('message_name', 'Invoice berhasil dicetak.');
			}

			if ($pay_methode == '1' || $pay_methode == '3') {
				$id_user = $this->session->userdata('nip');

				$tgl_invoice = $tanggal_billing;
				$tahun = substr($tgl_invoice, 0, 4);

				// $max_num = $this->m_invoice->select_max($tahun);
				$max_num = $this->m_invoice->select_max();

				if (!$max_num['max']) {
					$bilangan = 1; // Nilai Proses
				} else {
					$bilangan = $max_num['max'] + 1;
				}

				$month = substr($tgl_invoice, 5, 2);
				$year = substr($tgl_invoice, 2, 2);

				$no_inv = sprintf("%04d", $bilangan);
				$kode_cabang = sprintf("%02d", $this->session->userdata('kode_cabang'));

				$kop_invoice = $this->session->userdata('nama_akronim') . "-" . $kode_cabang;

				$slug = $no_inv . '/' . strtoupper($kop_invoice) . '/' . intToRoman($month) . '/' . $year;

				// $keterangan = trim($this->input->post('keterangan'));
				// $keterangan = 'Invoice ' . $no_inv . ' - ' . $nama_agent;
				$keterangan = "PEMBAYARAN INVOICE KHUSUS " . $no_inv . ". METODE DEPOSIT, AGENT " . strtoupper($nama_agent);

				// if ($jenis == 'pendapatan') {
				// $jenis_invoice = 'pendapatan';
				if ($pay_methode == '1') {
					$jenis_invoice = 'deposit';
				} else if ($pay_methode == '3') {
					$jenis_invoice = 'transfer';
				} else {
					$jenis_invoice = 'reguler';
				}
				// } else if ($jenis == 'khusus') {
				// 	$jenis_invoice = 'khusus';
				// } else {
				// 	$jenis_invoice = 'reguler';
				// }

				// $sub_total = $total_cargo + $total_cargo;
				// $total_ppn = $bg_ppn + $kc_ppn;
				// $total_nonpph = $sub_total + $total_ppn;
				$coa_debit = $this->input->post('coa_debit');
				$coa_kredit = $this->input->post('coa_kredit');

				// Insert ke tabel invoice
				$invoice_data = [
					'no_invoice' => $no_inv,
					'tanggal_invoice' => $tgl_invoice,
					'created_by' => $id_user,
					'keterangan' => $keterangan,
					// 'id_customer' => $this->input->post('customer'),
					'subtotal' => $grand_total_gdg,
					'diskon' => isset($diskon) ? $diskon : '0',
					// 'besaran_diskon' => $besaran_diskon,
					'ppn' => 0.11,
					'besaran_ppn' => 0,
					'opsi_pph23' => isset($opsi_pph) ? $opsi_pph : '0',
					'opsi_ppn' => isset($opsi_ppn) ? $opsi_ppn : '0',
					'pph' => 0,
					'besaran_pph' => 0,
					'opsi_pph_ps4' => isset($opsi_pph_ps4) ? $opsi_pph_ps4 : '0',
					'pph_ps4' => 0,
					'besaran_pph_ps4' => 0,
					'total_nonpph' => $grand_total_gdg,
					'total_denganpph' => $grand_total_gdg,
					'coa_debit' => $coa_debit,
					'coa_kredit' => $coa_kredit,
					'nominal_bayar' => $grand_total_gdg,
					'nominal_pendapatan' => $grand_total_gdg,
					'jenis_invoice' => $jenis_invoice,
					// 'status_pendapatan' => isset($status_pendapatan) ? $status_pendapatan : '0'
					'opsi_termin' => isset($opsi_termin) ? $opsi_termin : '0',
					'status_pendapatan' => '1',
					'slug' => $slug,
					'id_cabang' => $this->session->userdata('kode_cabang'),
				];

				$this->cb->trans_begin();
				$id_invoice = $this->m_invoice->insert($invoice_data);

				if (!$id_invoice) {
					$this->cb->trans_rollback();
					$this->session->set_flashdata('message_name', 'Failed to create invoice.');
					redirect("outgoinghlp/daftar_invoice_khusus");
				}

				$item = $keterangan;
				$jumlah = 1;
				// $total = $total_nonpph;
				// $total_amount = $total_nonpph;

				$detail_data[] = [
					'id_invoice' => $id_invoice,
					'item' => strtoupper($item),
					'total' => $grand_total_gdg,
					'qty' => $jumlah,
					'total_amount' => $grand_total_gdg,
					'created_by' => $id_user,
					'id_cabang' => $this->session->userdata('kode_cabang'),
				];


				if (!empty($detail_data)) {
					$insert = $this->m_invoice->insert_batch($detail_data);

					if ($insert === FALSE) {
						$this->cb->trans_rollback();
						$this->session->set_flashdata('message_name', 'Failed to insert invoice details.');
						redirect("outgoinghlp/daftar_invoice_khusus");
					}

					// Pastikan fungsi posting tidak mengganggu transaksi
					$this->posting($coa_debit, $coa_kredit, $keterangan, $grand_total_gdg, $tgl_invoice, $id_invoice);

					$this->cb->trans_commit();
					$this->session->set_flashdata('message_name', 'The invoice has been successfully created. ' . $no_inv);
					redirect("outgoinghlp/daftar_invoice_khusus");
				} else {
					$this->cb->trans_rollback();
					$this->session->set_flashdata('message_name', 'Invoice detail data is empty.');
					redirect("outgoinghlp/daftar_invoice_khusus");
				}


				// $keterangan = $this->input->post('keterangan');
				$nominal = $this->convertToNumberWithComma($grand_total_gdg);
				// $coa_debit = $this->input->post('coa_debit');
				// $coa_kredit = $this->input->post('coa_kredit');

				// Pastikan fungsi posting tidak mengganggu transaksi
				$this->posting($coa_debit, $coa_kredit, $keterangan, $nominal, '', '');
			}

			redirect('outgoinghlp/daftar_invoice_khusus');
			return;
		}

		// =============================================
		// STATUS 0 - UBAH
		// =============================================
		if ($new_status == '0') {
			if ($total_pieces <= 0) {
				$this->session->set_flashdata('message_error', 'Tidak bisa update, invoice tidak memiliki SMU.');
				redirect('outgoinghlp/daftar_invoice_khusus');
				return;
			}

			$update_data = [
				'total_pieces'     => $total_pieces,
				'total_gross'      => $total_gross,
				'total_volume'     => $total_volume,
				'total_chargeable' => $total_chargeable,
				'total_cargo'      => $total_cargo,
				// 'bg_ppn'           => $bg_ppn,
				// 'administrasi'     => $administrasi,
				// 'materai'          => $materai,
				'bg_total'         => $grand_total_gdg,
				// 'cdc'              => $cdc,
				// 'total_cdc'        => $total_cdc,
				// 'kade'             => $catg_kade,
				// 'csc'              => $catg_csc,
				// 'total_kade'       => $total_kade,
				// 'total_csc'        => $total_csc,
				// 'total_jaster'     => $total_jaster,
				// 'jaster'           => $jasa_ra,
				// 'kc_sub_total'     => $kc_sub_total,
				// 'kc_ppn'           => $kc_ppn,
				// 'kc_total'         => $kc_total,
				'grand_total'      => $grand_total_gdg,
				'grand_total_paid' => $grand_total_gdg,
				'status'           => '0',
				'pay_status'       => '',
				'tanggal_invoice'  => $tanggal_billing,
				'no_invoice'       => $no_invoice,
				'pay_methode'      => $pay_methode,
				'user_kasir'       => $this->session->userdata('nip'),
				'total'            => $grand_total_gdg,
				'bill_catg_uid'    => $bill_catg,
				'terbilang' => ucwords(trim(terbilang($grand_total_gdg))) . ' Rupiah',
			];


			$this->cb->where('uid', $bil_uid)->update('out_billing_inv_khusus', $update_data);
			$this->session->set_flashdata('message_name', 'Invoice berhasil diupdate.');
			redirect('outgoinghlp/daftar_invoice_khusus');
			return;
		}
	}

	public function print_invoice_khusus($uid)
	{
		// =============================================
		// Data Billing
		// =============================================
		$billing = $this->cb->select('
        b.uid, b.total_pieces, b.total_gross, b.total_volume, b.total_chargeable,
        b.total_cargo, b.bg_ppn, b.administrasi, b.materai, b.bg_total,
        b.kade, b.csc, b.total_kade, b.total_csc, b.kc_sub_total,
        b.kc_ppn, b.kc_total, b.grand_total, b.grand_total_paid, b.terbilang,
        b.nama, b.alamat, b.telepon, b.status, b.pay_status,
        b.tanggal_invoice, b.no_invoice, b.memo, b.virtual, b.pay_methode,
        b.no, b.user_bill, b.user_kasir, b.total_cdc, b.jaster, b.total_jaster,
        b.nama_agent, b.kade as kade_rate, b.csc as csc_rate, b.bill_catg_uid
    ', FALSE)
			->from('out_billing_inv_khusus b')
			->where('b.uid', $uid)
			->get()->row();

		if (!$billing) show_error('Data tidak ditemukan.', 404);

		// Jaster dari out_list
		$jaster_row = $this->cb->select('a.uid, a.jaster, b.nama as nama_agent_list', FALSE)
			->from('out_list a')
			->join('out_agent b', 'b.uid = a.agent_uid', 'left')
			->where('a.bill_khusus_uid', $uid)
			->get()->row();

		$jaster_opt  = $jaster_row->jaster      ?? 0;
		$nama_agent  = $jaster_row->nama_agent_list ?? $billing->nama_agent;

		// Kasir
		$kasir = $this->db->select('nama')->from('users')
			->where('nip', $billing->user_kasir)->get()->row();
		$kasir_name = $kasir->nama ?? '';

		// Format tanggal invoice
		$tgl_inv = $billing->tanggal_invoice;
		$date4Y  = substr($tgl_inv, 0, 4);
		$date4m  = substr($tgl_inv, 4, 2);
		$date4d  = substr($tgl_inv, 6, 2);
		$pm_billing_date_txt = $tgl_inv > 1 ? "$date4d-$date4m-$date4Y" : '-';

		// Angka format
		$total_sewa_gudang_k = number_format($billing->total_cargo, 2);
		$upd_total_cdc       = $billing->total_cdc > 0 ? number_format($billing->total_cdc, 2) : '';
		$bg_ppn_k            = number_format((float)$billing->bg_ppn, 2);
		$administrasi_k      = number_format((float)$billing->administrasi, 2);
		$materai_k           = $billing->materai > 0 ? number_format($billing->materai, 2) : '';
		$bg_total_k          = number_format((float)$billing->bg_total, 2);
		$total_kade_k        = number_format((float)$billing->total_kade, 2);
		$total_csc_k         = number_format((float)$billing->total_csc, 2);
		$total_jaster_k      = $jaster_opt != '0' ? number_format($billing->total_jaster, 2) : '';
		$kc_sub_total_k      = number_format((float)$billing->kc_sub_total, 2);
		$kc_ppn_k            = number_format((float)$billing->kc_ppn, 2);
		$kc_total_k          = number_format((float)$billing->kc_total, 2);
		$grand_total_k       = number_format((float)$billing->grand_total, 2);
		$total_pieces_k      = number_format((float)$billing->total_pieces);
		$total_chargeable_k  = number_format((float)$billing->total_chargeable, 2);
		$kade_k              = number_format((float)$billing->kade_rate);
		$csc_k               = number_format((float)$billing->csc_rate);
		$jaster_rate_k       = 0;

		// List SMU billing
		$list_billing = $this->cb->where('bill_khusus_uid', $uid)
			->order_by('uid', 'ASC')
			->get('out_list')->result();

		$catg_bill = $this->cb->where('uid', $billing->bill_catg_uid)
			->get('out_bill_catg_inv_khusus')->row();

		$billing->harga_gdg = $catg_bill->sewa_gudang;
		// Data perusahaan
		// $corp = $this->cb->select('branch_name, phone1, addr1, addr2, img1, tax_num')
		// 	->where('branch_code', 'CORP_03')
		// 	->get('client_branch')->row();

		$corp_logo = "<img src='" . base_url('src/images/logo_bdt.jpg') . "' border='0' width='150'>";

		$data = [
			'billing'              => $billing,
			'jaster_opt'           => $jaster_opt,
			'nama_agent'           => $nama_agent,
			'kasir_name'           => $kasir_name,
			'pm_billing_date_txt'  => $pm_billing_date_txt,
			'total_sewa_gudang_k'  => $total_sewa_gudang_k,
			'upd_total_cdc'        => $upd_total_cdc,
			'bg_ppn_k'             => $bg_ppn_k,
			'administrasi_k'       => $administrasi_k,
			'materai_k'            => $materai_k,
			'bg_total_k'           => $bg_total_k,
			'total_kade_k'         => $total_kade_k,
			'total_csc_k'          => $total_csc_k,
			'total_jaster_k'       => $total_jaster_k,
			'kc_sub_total_k'       => $kc_sub_total_k,
			'kc_ppn_k'             => $kc_ppn_k,
			'kc_total_k'           => $kc_total_k,
			'grand_total_k'        => $grand_total_k,
			'total_pieces_k'       => $total_pieces_k,
			'total_chargeable_k'   => $total_chargeable_k,
			'kade_k'               => $kade_k,
			'csc_k'                => $csc_k,
			'jaster_rate_k'        => $jaster_rate_k,
			'list_billing'         => $list_billing,
			// 'corp'                 => $corp,
			'corp_logo'            => $corp_logo,
		];

		// =============================================
		// Data BTB - ambil btb_uid dari out_list
		// =============================================
		$btb_row = $this->cb->select('btb_uid')->where('bill_khusus_uid', $uid)->get('out_list')->row();
		$btb_uid = $btb_row->btb_uid ?? 0;

		$btb = null;
		$list_btb = [];
		$btb_name = '';
		$tanggal_txt = '-';

		if ($btb_uid) {
			$btb = $this->cb->select('uid, total_pieces, total_gross, total_volume, total_chargeable, nama, status, tanggal, no, user')
				->where('uid', $btb_uid)->get('out_list_btb')->row();

			if ($btb) {
				// Kasir BTB
				$kasir_btb = $this->db->select('nama')->from('users')
					->where('nip', $btb->user)->get()->row();
				$btb_name = $kasir_btb->nama ?? '';

				// Format tanggal BTB
				$tgl_btb = $btb->tanggal;
				$date4Y  = substr($tgl_btb, 0, 4);
				$date4m  = substr($tgl_btb, 4, 2);
				$date4d  = substr($tgl_btb, 6, 2);
				$tanggal_txt = $tgl_btb > 1 ? "$date4d-$date4m-$date4Y" : '-';

				// List SMU BTB
				$list_btb = $this->cb->where('btb_uid', $btb_uid)
					->order_by('uid', 'ASC')
					->get('out_list')->result();

				// Dimensi per SMU
				foreach ($list_btb as $s) {
					$s->dimensi = $this->cb->where('uid_list', $s->uid)
						->order_by('uid', 'ASC')
						->get('out_dimensi')->result();
				}
			}
		}

		$btb_no = $btb ? 'HLPO-' . $btb->no : '';

		$data['btb']          = $btb;
		$data['btb_no']       = $btb_no;
		$data['btb_name']     = $btb_name;
		$data['tanggal_txt']  = $tanggal_txt;
		$data['list_btb']     = $list_btb;

		$this->load->view('print_invoice_khusus', $data);
	}

	public function rekap_invoice_khusus()
	{
		$dari      = $this->input->post('dari');
		$sampai    = $this->input->post('sampai');
		$pengirim  = $this->input->post('pengirim');
		$kasir     = $this->input->post('kasir');
		$pay_methode = $this->input->post('pay_methode');

		$start_date = str_replace('-', '', $dari)   . '000000';
		$end_date   = str_replace('-', '', $sampai) . '235959';

		// Base query
		$this->cb->select('*', FALSE);
		$this->cb->from('out_billing_inv_khusus');
		$this->cb->where('status', '1');
		$this->cb->where("tanggal_invoice BETWEEN '$start_date' AND '$end_date'", NULL, FALSE);

		if ($pengirim) {
			$this->cb->where('pengirim_uid', $pengirim);
		}
		if ($kasir) {
			$this->cb->where('user_kasir', $kasir);
		}
		if ($pay_methode == '1') {
			$this->cb->where('pay_methode', '1');
		} else if ($pay_methode == '2') {
			$this->cb->where('pay_methode', '2');
		} else if ($pay_methode == '3') {
			$this->cb->where('pay_methode', '3');
		} else if ($pay_methode == '4') {
			$this->cb->where('pay_methode', '4');
		} else if ($pay_methode == '5') {
			$this->cb->where('pay_methode', '5');
		}

		$this->cb->order_by('no_invoice, tanggal_invoice', 'ASC');
		$results = $this->cb->get()->result_array();

		// Load PhpSpreadsheet
		require APPPATH . 'third_party/autoload.php';

		// Include PhpSpreadsheet from third_party
		require APPPATH . 'third_party/psr/simple-cache/src/CacheInterface.php';

		$spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
		$sheet       = $spreadsheet->getActiveSheet();
		$sheet->setTitle('Rekap Outgoing Inv Khusus HLP');

		// Header
		$headers = [
			'A'  => 'No',
			'B'  => 'No Invoice',
			'C'  => 'Tanggal',
			'D'  => 'Agen',
			'E'  => 'Pengirim',
			'F'  => 'No',
			'G'  => 'SMU',
			'H'  => 'Asal',
			'I'  => 'Koli',
			'J'  => 'Berat',
			'K'  => 'Biaya Gudang',
			'L'  => 'Volume',
			'M'  => 'Total Ch.W',
			'N'  => 'SubTotal Sewa Gudang',
			'O'  => 'Cargo Development Charge',
			'P'  => 'PPN BG',
			'Q'  => 'Administrasi',
			'R'  => 'Materai',
			'S'  => 'Total Sewa Gudang',
			'T'  => 'Jasa Terminal Handling',
			'U'  => 'Biaya Jaster',
			'V'  => 'Biaya CSC',
			'W'  => 'SubTotal KC',
			'X'  => 'PPN KC',
			'Y'  => 'Total KC',
			'Z'  => 'Total',
			'AA' => 'Pembayaran',
			'AB' => 'Keterangan',
			'AC' => 'Jaster',
		];

		foreach ($headers as $col => $label) {
			$sheet->setCellValue($col . '1', $label);
		}

		$sheet->getStyle('A1:AC1')->getFont()->setBold(true)->setSize(12);
		$sheet->getStyle('A1:AC1')->getAlignment()
			->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

		$nomor  = 1;
		$rowNum = 2;

		foreach ($results as $r) {
			$uid         = $r['uid'];
			$no_invoice  = $r['no_invoice'];
			$tanggal     = $r['tanggal_invoice'];
			$nama        = $r['nama'];
			$nama_agent  = $r['nama_agent'];
			$pay_methode = $r['pay_methode'];
			$uid_agent   = $r['agent_uid'];
			$uid_pengirim = $r['pengirim_uid'];
			$user_kasir  = $r['user_kasir'];

			$total_chargeable = $r['total_chargeable'];
			$total_cargo      = $r['total_cargo'];
			$total_cdc        = $r['total_cdc'];
			$bg_ppn           = $r['bg_ppn'];
			$administrasi     = $r['administrasi'];
			$materai          = $r['materai'];
			$bg_total         = $r['bg_total'];
			$total_kade       = $r['total_kade'];
			$total_jaster     = $r['total_jaster'];
			$total_csc        = $r['total_csc'];
			$kc_sub_total     = $r['kc_sub_total'];
			$kc_ppn           = $r['kc_ppn'];
			$kc_total         = $r['kc_total'];
			$grand_total      = $r['grand_total'];

			// Format pembayaran
			$pay_map = ['1' => 'Deposit', '2' => 'Cash', '3' => 'Transfer', '4' => 'Tagihan', '5' => 'FOC'];
			$pay     = $pay_map[$pay_methode] ?? '';

			// Jaster
			$jaster = $total_jaster > 0 ? 'JASTER' : 'Non JASTER';

			// Nama agent
			$agent = $this->cb->select('nama')->where('uid', $uid_agent)->get('out_agent')->row();
			$nama_agent = $agent->nama ?? '';

			// Nama pengirim
			$pengirim_row = $this->cb->select('nama')->where('uid', $uid_pengirim)->get('out_pengirim')->row();
			$nama_pengirim = $pengirim_row->nama ?? $nama;

			// Kasir
			$kasir_row = $this->db->select('nama')->where('nip', $user_kasir)->get('users')->row();
			$user_name = $kasir_row->nama ?? '';

			// Format tanggal
			$tgl_txt = $tanggal ? date('j F Y', strtotime(
				substr($tanggal, 0, 4) . '-' . substr($tanggal, 4, 2) . '-' . substr($tanggal, 6, 2)
			)) : '';

			// List SMU per billing
			$list_smu = $this->cb->select('uid, smu, tujuan, jumlah, chargeable, sewa_gudang, volume')
				->where('bill_khusus_uid', $uid)
				->order_by('uid', 'ASC')
				->get('out_list')->result_array();

			$no_smu   = 1;
			$startRow = $rowNum;

			foreach ($list_smu as $s) {
				$sheet->setCellValue('F' . $rowNum, $no_smu);
				$sheet->setCellValue('G' . $rowNum, $s['smu']);
				$sheet->setCellValue('H' . $rowNum, $s['tujuan']);
				$sheet->setCellValue('I' . $rowNum, $s['jumlah']);
				$sheet->setCellValue('J' . $rowNum, $s['chargeable']);
				$sheet->setCellValue('K' . $rowNum, $s['sewa_gudang']);
				$sheet->setCellValue('L' . $rowNum, $s['volume']);

				$rowNum++;
				$no_smu++;
			}

			$endRow = $rowNum - 1;

			// Merge kolom header billing jika ada lebih dari 1 SMU
			if ($endRow > $startRow) {
				foreach (['A', 'B', 'C', 'D', 'E', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC'] as $col) {
					$sheet->mergeCells($col . $startRow . ':' . $col . $endRow);
				}
			}

			// Set nilai billing di startRow
			$sheet->setCellValue('A'  . $startRow, $nomor);
			$sheet->setCellValue('B'  . $startRow, $no_invoice);
			$sheet->setCellValue('C'  . $startRow, $tgl_txt);
			$sheet->setCellValue('D'  . $startRow, $nama_agent);
			$sheet->setCellValue('E'  . $startRow, $nama_pengirim);
			$sheet->setCellValue('M'  . $startRow, $total_chargeable);
			$sheet->setCellValue('N'  . $startRow, $total_cargo);
			$sheet->setCellValue('O'  . $startRow, $total_cdc);
			$sheet->setCellValue('P'  . $startRow, $bg_ppn);
			$sheet->setCellValue('Q'  . $startRow, $administrasi);
			$sheet->setCellValue('R'  . $startRow, $materai);
			$sheet->setCellValue('S'  . $startRow, $bg_total);
			$sheet->setCellValue('T'  . $startRow, $total_kade);
			$sheet->setCellValue('U'  . $startRow, $total_jaster);
			$sheet->setCellValue('V'  . $startRow, $total_csc);
			$sheet->setCellValue('W'  . $startRow, $kc_sub_total);
			$sheet->setCellValue('X'  . $startRow, $kc_ppn);
			$sheet->setCellValue('Y'  . $startRow, $kc_total);
			$sheet->setCellValue('Z'  . $startRow, $grand_total);
			$sheet->setCellValue('AA' . $startRow, $pay);
			$sheet->setCellValue('AB' . $startRow, $user_name);
			$sheet->setCellValue('AC' . $startRow, $jaster);

			$nomor++;
		}

		// Baris total
		$totalRow = $rowNum;
		$firstRow = 2;
		$lastRow  = $rowNum - 1;

		$sheet->mergeCells('A' . $totalRow . ':K' . $totalRow);
		$sheet->getStyle('A' . $totalRow)->getAlignment()
			->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
		$sheet->setCellValue('A' . $totalRow, 'TOTAL');

		foreach (['L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'] as $col) {
			$sheet->setCellValue($col . $totalRow, '=SUM(' . $col . $firstRow . ':' . $col . $lastRow . ')');
		}

		// Autosize
		$cols = array_merge(range('A', 'Z'), ['AA', 'AB', 'AC']);
		foreach ($cols as $col) {
			$sheet->getColumnDimension($col)->setAutoSize(true);
		}

		// Download
		require APPPATH . 'third_party/autoload_zip.php';
		$filename = 'rekap_outgoing_HLP_' . date('d-m-Y') . '.xlsx';

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

		$this->load->view('daftar_deposit', $data);
	}

	public function getData_deposit()
	{
		$results = $this->M_outgoing->get_datatables_deposit();
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
			'recordsTotal'    => $this->M_outgoing->count_all_deposit(),
			'recordsFiltered' => $this->M_outgoing->count_filtered_deposit(),
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
		$raw_list = $this->M_outgoing->get_riwayat_topup_raw($agent_uid, $termasuk_usage, $search);

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
				$invoice_detail = $this->cb->where('uid', $r->billing_uid)->get('out_billing')->row();
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
		$total_records = $this->M_outgoing->count_all_riwayat($agent_uid, $termasuk_usage);

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
			$query_no = $this->cb->get('out_topup')->row_array();
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
			$row = $this->cb->get('out_topup')->row_array();

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
			$insert = $this->cb->insert('out_topup', $data_insert);

			if ($insert) {
				// Set notifikasi sukses menggunakan Flashdata (Sesuai dengan library sweetalert di view Anda)
				$this->session->set_flashdata('message_name', 'Data Deposit Berhasil Disimpan.');
			} else {
				$this->session->set_flashdata('message_error', 'Gagal menyimpan data deposit.');
			}

			// Redirect kembali ke halaman daftar deposit
			redirect('outgoinghlp/daftar_deposit');
		} else {
			$this->session->set_flashdata('message_error', 'Silahkan pilih Agent terlebih dahulu.');
			redirect('outgoinghlp/daftar_deposit');
		}
	}

	public function rekap_deposit()
	{
		$dari         = $this->input->post('dari');
		$sampai       = $this->input->post('sampai');
		$agent_uid    = $this->input->post('agent_deposit');

		$start_date = str_replace('-', '', $dari)   . '000000';
		$end_date   = str_replace('-', '', $sampai) . '235959';

		// Query topup dengan subquery untuk sisa saldo
		$sql = "SELECT 
        t.uid, t.kode, t.topup_date, t.topup_saldo,
        IF(
            (SELECT SUM(t1.topup_saldo) - SUM(t1.usage_saldo) FROM out_topup t1 WHERE t1.uid < t.uid AND t1.agent_uid = t.agent_uid) != '',
            IF(
                (SELECT SUM(t1.topup_saldo) - SUM(t1.usage_saldo) FROM out_topup t1 WHERE t1.uid < t.uid AND t.usage_saldo != '' AND t1.agent_uid = t.agent_uid)
                = (SELECT SUM(t1.topup_saldo) - SUM(t1.usage_saldo) FROM out_topup t1 WHERE t1.uid < t.uid AND t1.agent_uid = t.agent_uid),
                (SELECT SUM(t1.topup_saldo) - SUM(t1.usage_saldo) FROM out_topup t1 WHERE t1.uid < t.uid AND t1.agent_uid = t.agent_uid) - t.usage_saldo,
                ''
            ),
            t.topup_saldo - t.usage_saldo
        ) as sisa_saldo,
        t.billing_uid, t.agent_uid,
        IFNULL((SELECT b.no_invoice      FROM out_billing b WHERE b.uid = t.billing_uid), '') as no_invoice,
        IFNULL((SELECT b.tanggal_invoice FROM out_billing b WHERE b.uid = t.billing_uid), '') as tanggal_invoice,
        IFNULL((SELECT b.nama            FROM out_billing b WHERE b.uid = t.billing_uid), '') as nama_pengirim,
        IFNULL((SELECT b.total_chargeable FROM out_billing b WHERE b.uid = t.billing_uid), '') as total_chargeable,
        IFNULL((SELECT b.total           FROM out_billing b WHERE b.uid = t.billing_uid), '') as grand_total,
        IFNULL((SELECT b.pay_methode     FROM out_billing b WHERE b.uid = t.billing_uid), '') as pay_methode,
        IFNULL((SELECT b.user_kasir      FROM out_billing b WHERE b.uid = t.billing_uid), '') as user_kasir
        FROM out_topup t
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
			$ag = $this->cb->select('nama')->where('uid', $agent_uid)->get('out_agent_deposit')->row();
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
			$billing = $this->cb->select('uid, no_invoice, tanggal_invoice, nama, grand_total, pay_methode, user_kasir, nama_agent')
				->where('status', '1')
				->where('uid', $t_billing_uid)
				->get('out_billing')->row();

			if (!$billing) {
				$rowNum++;
				continue;
			}

			// Nama kasir
			$kasir = $this->db->select('nama')->where('nip', $billing->user_kasir)->get('users')->row();
			$kasir_name = $kasir->nama ?? '';

			// Jaster & nama agent dari out_list
			$jaster_row = $this->cb->select('a.uid, a.jaster, b.nama as nama_agen', FALSE)
				->from('out_list a')
				->join('out_agent b', 'b.uid = a.agent_uid', 'left')
				->where('a.bill_uid', $billing->uid)
				->get()->row();
			$nama_agen_list = $jaster_row->nama_agen ?? $billing->nama_agent;

			// Format tanggal
			$tgl = $billing->tanggal_invoice;
			$tgl_txt = $tgl ? date('j F Y', strtotime(
				substr($tgl, 0, 4) . '-' . substr($tgl, 4, 2) . '-' . substr($tgl, 6, 2)
			)) : '';

			// List SMU
			$list_smu = $this->cb->select('uid, smu, tujuan, jumlah, gross, chargeable')
				->where('bill_uid', $billing->uid)
				->where('out_p', '1')
				->order_by('uid', 'ASC')
				->get('out_list')->result_array();

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

		$this->load->view('daftar_agents', $data);
	}

	public function getData_agents()
	{
		$results = $this->M_outgoing->get_datatables_agents();
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

				$button_hold = "<a class='btn btn-sm btn-success' href='" . base_url() . "outgoinghlp/agnet_hold/{$r->uid}/0'>
        <i class='fa fa-check'></i> Ready</a>";
			} else {
				$hold = "<span class='btn btn-sm' style='color:#5cb85c; border:1px solid #5cb85c; background:transparent;'>Ready</span> ";
				$button_hold = "<a class='btn btn-sm btn-danger' href='" . base_url() . "outgoinghlp/agnet_hold/{$r->uid}/1'>
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
			'recordsTotal'    => $this->M_outgoing->count_all_agents(),
			'recordsFiltered' => $this->M_outgoing->count_filtered_agents(),
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
			$this->M_outgoing->update_agent($data, $uid);
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

			$this->M_outgoing->insert_agent($data);
			$this->session->set_flashdata('message_name', 'Agent berhasil ditambahkan.');
		}

		redirect('outgoinghlp/daftar_agents');
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


		$this->M_outgoing->update_agent($data, $uid);

		if ($hold == '1') {
			$this->session->set_flashdata('message_name', 'Agent berhasil di Hold.');
		} else {
			$this->session->set_flashdata('message_name', 'Agent Ready.');
		}
		redirect('outgoinghlp/daftar_agents');
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

		$out_agent = $this->cb->select('MAX(CAST(kode AS UNSIGNED)) as kode')->from('out_agent')->get()->row();

		$this->load->view('daftar_agents_deposit', $data);
	}

	public function getData_agents_deposit()
	{
		$results = $this->M_outgoing->get_datatables_agents_deposit();
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

				$button_hold = "<a class='btn btn-sm btn-success' href='" . base_url() . "outgoinghlp/agent_deposit_hold/{$r->uid}/0'>
        <i class='fa fa-check'></i> Ready</a>";
			} else {
				$hold = "<span class='btn btn-sm' style='color:#5cb85c; border:1px solid #5cb85c; background:transparent;'>Ready</span> ";
				$button_hold = "<a class='btn btn-sm btn-danger' href='" . base_url() . "outgoinghlp/agent_deposit_hold/{$r->uid}/1'>
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
			'recordsTotal'    => $this->M_outgoing->count_all_agents_deposit(),
			'recordsFiltered' => $this->M_outgoing->count_filtered_agents_deposit(),
			'data'            => $data,
		];

		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($output));
	}

	public function edit_agent_deposit($uid)
	{
		$this->cb->select('a.*, u.nama as nama_pic');
		$this->cb->from('out_agent_deposit a');
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
			$this->M_outgoing->update_agent_deposit($data, $uid);
			$this->session->set_flashdata('message_name', 'Agent berhasil diupdate.');
		} else {
			$signdate = time();
			$post_date1 = date("Ymd", $signdate);
			$post_date2 = date("His", $signdate);
			$post_dates = "$post_date1" . "$post_date2";

			$out_agent = $this->cb->select('MAX(CAST(kode AS UNSIGNED)) as kode')->from('out_agent_deposit')->get()->row();

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

			$this->M_outgoing->insert_agent_deposit($data);
			$this->session->set_flashdata('message_name', 'Agent berhasil ditambahkan.');
		}

		redirect('outgoinghlp/daftar_agents_deposit');
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


		$this->M_outgoing->update_agent_deposit($data, $uid);

		if ($hold == '1') {
			$this->session->set_flashdata('message_name', 'Agent berhasil di Hold.');
		} else {
			$this->session->set_flashdata('message_name', 'Agent Ready.');
		}
		redirect('outgoinghlp/daftar_agents_deposit');
	}


	// DAFTAR PENGIRIM
	public function daftar_pengirim()
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

		$data['title'] = "Daftar Pengirim";


		$this->load->view('daftar_pengirim', $data);
	}

	public function getData_pengirim()
	{
		$results = $this->M_outgoing->get_datatables_pengirim();
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


			if ($r->status == '1') {
				$hold = "<span class='btn btn-sm' style='color:#5cb85c; border:1px solid #5cb85c; background:transparent;'>Ready</span> ";
				$button_hold = "<a class='btn btn-sm btn-danger' href='" . base_url() . "outgoinghlp/pengirim_hold/{$r->uid}/0'>
        <i class='fa fa-remove'></i> Hold</a>";
			} else {
				$hold = "<span class='btn btn-sm' style='color:#d9534f; border:1px solid #d9534f; background:transparent;'>Hold</span> ";
				$button_hold = "<a class='btn btn-sm btn-success' href='" . base_url() . "outgoinghlp/pengirim_hold/{$r->uid}/1'>
        <i class='fa fa-check'></i> Ready</a>";
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
			'recordsTotal'    => $this->M_outgoing->count_all_pengirim(),
			'recordsFiltered' => $this->M_outgoing->count_filtered_pengirim(),
			'data'            => $data,
		];

		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($output));
	}

	public function edit_pengirim($uid)
	{
		$this->cb->from('out_pengirim');
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

	public function store_pengirim()
	{
		// $kode = $this->input->post('kode_pengirim');
		$nama = $this->input->post('nama_pengirim');
		$alamat = $this->input->post('alamat_pengirim');
		$telepon = $this->input->post('telepon_pengirim');
		$npwp = $this->input->post('npwp');

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
			$this->M_outgoing->update_pengirim($data, $uid);
			$this->session->set_flashdata('message_name', 'Pengirim berhasil diupdate.');
		} else {
			$signdate = time();
			$post_date1 = date("Ymd", $signdate);
			$post_date2 = date("His", $signdate);
			$post_dates = "$post_date1" . "$post_date2";

			$out_pengirim = $this->cb->select('MAX(CAST(kode AS UNSIGNED)) as kode')->from('out_pengirim')->get()->row();

			$no_mydisburse1 = $out_pengirim->kode;

			if ($no_mydisburse1 > 0) {
				$disburse1 = $no_mydisburse1 + 1;
				$nodis1 = sprintf("%06d", $disburse1);
				$no = $nodis1;
			} else {
				$no = "000001";
			}

			$data['user_code']  = $this->session->userdata('nip');
			$data['post_date'] = $post_dates;
			$data['kode'] = $no;

			$this->M_outgoing->insert_pengirim($data);
			$this->session->set_flashdata('message_name', 'Pengirim berhasil ditambahkan.');
		}

		redirect('outgoinghlp/daftar_pengirim');
	}

	public function pengirim_hold($uid, $hold)
	{

		$data = [
			// 'kode'                          => $kode,
			'status'                          => $hold,
			// 'npwp'                          => $npwp,
			// 'post_date'                     => $post_dates,
			// 'user'                          => $this->session->userdata('nip'),
		];


		$this->M_outgoing->update_pengirim($data, $uid);

		if ($hold == '1') {
			$this->session->set_flashdata('message_name', 'Pengirim berhasil di Hold.');
		} else {
			$this->session->set_flashdata('message_name', 'Pengirim Ready.');
		}
		redirect('outgoinghlp/daftar_pengirim');
	}

	// DAFTAR TUJUAN
	public function daftar_tujuan()
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

		$data['title'] = "Daftar TUJUAN";


		$this->load->view('daftar_tujuan', $data);
	}

	public function getData_tujuan()
	{
		$results = $this->M_outgoing->get_datatables_tujuan();
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
			// 		$button_hold = "<a class='btn btn-sm btn-danger' href='" . base_url() . "outgoinghlp/pengirim_hold/{$r->uid}/0'>
			// <i class='fa fa-remove'></i> Hold</a>";
			// 	} else {
			// 		$hold = "<span class='btn btn-sm' style='color:#d9534f; border:1px solid #d9534f; background:transparent;'>Hold</span> ";
			// 		$button_hold = "<a class='btn btn-sm btn-success' href='" . base_url() . "outgoinghlp/pengirim_hold/{$r->uid}/1'>
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
			'recordsTotal'    => $this->M_outgoing->count_all_tujuan(),
			'recordsFiltered' => $this->M_outgoing->count_filtered_tujuan(),
			'data'            => $data,
		];

		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($output));
	}

	public function edit_tujuan($uid)
	{
		$this->cb->from('out_tujuan');
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

	public function store_tujuan()
	{
		// $kode = $this->input->post('kode_tujuan');
		$kode_kota = $this->input->post('kode_kota_tujuan');
		$nama = $this->input->post('nama_tujuan');

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
			$this->M_outgoing->update_tujuan($data, $uid);
			$this->session->set_flashdata('message_name', 'Tujuan berhasil diupdate.');
		} else {
			$signdate = time();
			$post_date1 = date("Ymd", $signdate);
			$post_date2 = date("His", $signdate);
			$post_dates = "$post_date1" . "$post_date2";

			$out_tujuan = $this->cb->select('MAX(CAST(kode AS UNSIGNED)) as kode')->from('out_tujuan')->get()->row();

			$no_mydisburse1 = $out_tujuan->kode;

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

			$this->M_outgoing->insert_tujuan($data);
			$this->session->set_flashdata('message_name', 'Tujuan berhasil ditambahkan.');
		}

		redirect('outgoinghlp/daftar_tujuan');
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


		$this->load->view('daftar_avsec', $data);
	}

	public function getData_avsec()
	{
		$results = $this->M_outgoing->get_datatables_avsec();
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

				$button_hold = "<a class='btn btn-sm btn-success' href='" . base_url() . "outgoinghlp/avsec_hold/{$r->uid}/0'>
        <i class='fa fa-check'></i> Ready</a>";
			} else {
				$hold = "<span class='btn btn-sm' style='color:#5cb85c; border:1px solid #5cb85c; background:transparent;'>Ready</span> ";
				$button_hold = "<a class='btn btn-sm btn-danger' href='" . base_url() . "outgoinghlp/avsec_hold/{$r->uid}/1'>
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
			'recordsTotal'    => $this->M_outgoing->count_all_avsec(),
			'recordsFiltered' => $this->M_outgoing->count_filtered_avsec(),
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
			$this->M_outgoing->update_avsec($data, $uid);
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

			$this->M_outgoing->insert_avsec($data);
			$this->session->set_flashdata('message_name', 'Avsec berhasil ditambahkan.');
		}

		redirect('outgoinghlp/daftar_avsec');
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


		$this->M_outgoing->update_avsec($data, $uid);

		if ($hold == '1') {
			$this->session->set_flashdata('message_name', 'Avsec berhasil di Hold.');
		} else {
			$this->session->set_flashdata('message_name', 'Avsec Ready.');
		}
		redirect('outgoinghlp/daftar_avsec');
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


		$this->load->view('daftar_driver', $data);
	}

	public function getData_driver()
	{
		$results = $this->M_outgoing->get_datatables_driver();
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

				$button_hold = "<a class='btn btn-sm btn-success' href='" . base_url() . "outgoinghlp/driver_hold/{$r->uid}/0'>
        <i class='fa fa-check'></i> Ready</a>";
			} else {
				$hold = "<span class='btn btn-sm' style='color:#5cb85c; border:1px solid #5cb85c; background:transparent;'>Ready</span> ";
				$button_hold = "<a class='btn btn-sm btn-danger' href='" . base_url() . "outgoinghlp/driver_hold/{$r->uid}/1'>
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
			'recordsTotal'    => $this->M_outgoing->count_all_driver(),
			'recordsFiltered' => $this->M_outgoing->count_filtered_driver(),
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
			$this->M_outgoing->update_driver($data, $uid);
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

			$this->M_outgoing->insert_driver($data);
			$this->session->set_flashdata('message_name', 'Driver berhasil ditambahkan.');
		}

		redirect('outgoinghlp/daftar_driver');
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


		$this->M_outgoing->update_driver($data, $uid);

		if ($hold == '1') {
			$this->session->set_flashdata('message_name', 'Driver berhasil di Hold.');
		} else {
			$this->session->set_flashdata('message_name', 'Driver Ready.');
		}
		redirect('outgoinghlp/daftar_driver');
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


		$this->load->view('daftar_truck', $data);
	}

	public function getData_truck()
	{
		$results = $this->M_outgoing->get_datatables_truck();
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

				$button_hold = "<a class='btn btn-sm btn-success' href='" . base_url() . "outgoinghlp/truck_hold/{$r->uid}/0'>
        <i class='fa fa-check'></i> Ready</a>";
			} else {
				$hold = "<span class='btn btn-sm' style='color:#5cb85c; border:1px solid #5cb85c; background:transparent;'>Ready</span> ";
				$button_hold = "<a class='btn btn-sm btn-danger' href='" . base_url() . "outgoinghlp/truck_hold/{$r->uid}/1'>
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
			'recordsTotal'    => $this->M_outgoing->count_all_truck(),
			'recordsFiltered' => $this->M_outgoing->count_filtered_truck(),
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
			$this->M_outgoing->update_truck($data, $uid);
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

			$this->M_outgoing->insert_truck($data);
			$this->session->set_flashdata('message_name', 'Truck berhasil ditambahkan.');
		}

		redirect('outgoinghlp/daftar_truck');
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


		$this->M_outgoing->update_truck($data, $uid);

		if ($hold == '1') {
			$this->session->set_flashdata('message_name', 'Truck berhasil di Hold.');
		} else {
			$this->session->set_flashdata('message_name', 'Truck Ready.');
		}
		redirect('outgoinghlp/daftar_truck');
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


		$this->load->view('daftar_kategori_harga', $data);
	}

	public function getData_kategori_harga()
	{
		$results = $this->M_outgoing->get_datatables_kategori_harga();
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

				$button_hold = "<a class='btn btn-sm btn-success' href='" . base_url() . "outgoinghlp/kategori_harga_hold/{$r->uid}/0'>
        <i class='fa fa-check'></i> Ready</a>";
			} else {
				$hold = "<span class='btn btn-sm' style='color:#5cb85c; border:1px solid #5cb85c; background:transparent;'>Ready</span> ";
				$button_hold = "<a class='btn btn-sm btn-danger' href='" . base_url() . "outgoinghlp/kategori_harga_hold/{$r->uid}/1'>
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
				$r->jasa_ra,
				$r->user_name ?? '-',
				$tanggal_txt ?? '-',
				$hold ?? '-',
				$button,
			];
		}

		$output = [
			'draw'            => intval($_POST['draw'] ?? 0),
			'recordsTotal'    => $this->M_outgoing->count_all_kategori_harga(),
			'recordsFiltered' => $this->M_outgoing->count_filtered_kategori_harga(),
			'data'            => $data,
		];

		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($output));
	}

	public function edit_kategori_harga($uid)
	{
		$this->cb->from('out_bill_catg');
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
		$jasa_ra = $this->input->post('jasa_ra');






		$data = [
			'jenis_billing'                          => $jenis_billing,
			'nama_billing'                          => $nama_billing,
			'csc'                        => $csc,
			'kade'                       => $kade,
			'sewa_gudang'                        => $sewa_gudang,
			'jasa_ra'                       => $jasa_ra,

		];

		$uid = $this->input->post('uid'); // untuk edit

		if ($uid) {
			$this->M_outgoing->update_kategori_harga($data, $uid);
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

			$this->M_outgoing->insert_kategori_harga($data);
			$this->session->set_flashdata('message_name', 'Kategori Harga berhasil ditambahkan.');
		}

		redirect('outgoinghlp/kategori_harga');
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


		$this->M_outgoing->update_kategori_harga($data, $uid);

		if ($hold == '1') {
			$this->session->set_flashdata('message_name', 'Kategori Harga berhasil di Hold.');
		} else {
			$this->session->set_flashdata('message_name', 'Kategori Harga Ready.');
		}
		redirect('outgoinghlp/kategori_harga');
	}

	// DAFTAR KATEGORI HARGA KHUSUS
	public function kategori_harga_khusus()
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

		$data['title'] = "Daftar Kategori Harga Invoice Khusus";


		$this->load->view('daftar_kategori_harga_khusus', $data);
	}

	public function getData_kategori_harga_khusus()
	{
		$results = $this->M_outgoing->get_datatables_kategori_harga_khusus();
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

				$button_hold = "<a class='btn btn-sm btn-success' href='" . base_url() . "outgoinghlp/kategori_harga_hold_khusus/{$r->uid}/0'>
        <i class='fa fa-check'></i> Ready</a>";
			} else {
				$hold = "<span class='btn btn-sm' style='color:#5cb85c; border:1px solid #5cb85c; background:transparent;'>Ready</span> ";
				$button_hold = "<a class='btn btn-sm btn-danger' href='" . base_url() . "outgoinghlp/kategori_harga_hold_khusus/{$r->uid}/1'>
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
				$r->cdc,
				$r->kade,
				$r->sewa_gudang,
				$r->jasa_ra,
				$r->ppn_gdg * 100 . '%',
				$r->ppn_ra * 100 . '%',
				$r->user_name ?? '-',
				$tanggal_txt ?? '-',
				$hold ?? '-',
				$button,
			];
		}

		$output = [
			'draw'            => intval($_POST['draw'] ?? 0),
			'recordsTotal'    => $this->M_outgoing->count_all_kategori_harga_khusus(),
			'recordsFiltered' => $this->M_outgoing->count_filtered_kategori_harga_khusus(),
			'data'            => $data,
		];

		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($output));
	}

	public function edit_kategori_harga_khusus($uid)
	{
		$this->cb->from('out_bill_catg_inv_khusus');
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

	public function store_kategori_harga_khusus()
	{

		$jenis_billing = $this->input->post('jenis_billing');
		$nama_billing = $this->input->post('nama_billing');
		$csc = $this->input->post('csc');
		$cdc = $this->input->post('cdc');
		$kade = $this->input->post('kade');
		$sewa_gudang = $this->input->post('sewa_gudang');
		$jasa_ra = $this->input->post('jasa_ra');
		$ppn_gdg = (float)$this->input->post('ppn_gdg') / 100;
		$ppn_ra = (float)$this->input->post('ppn_ra') / 100;

		$data = [
			'jenis_billing'                          => $jenis_billing,
			'nama_billing'                          => $nama_billing,
			'csc'                        => $csc,
			'cdc'                        => $cdc,
			'kade'                       => $kade,
			'sewa_gudang'                        => $sewa_gudang,
			'jasa_ra'                       => $jasa_ra,
			'ppn_gdg'                       => $ppn_gdg,
			'ppn_ra'                       => $ppn_ra,

		];

		$uid = $this->input->post('uid'); // untuk edit

		if ($uid) {
			$this->M_outgoing->update_kategori_harga_khusus($data, $uid);
			$this->session->set_flashdata('message_name', 'Kategori Harga berhasil diupdate.');
		} else {
			$signdate = time();
			$post_date1 = date("Ymd", $signdate);
			$post_date2 = date("His", $signdate);
			$post_dates = "$post_date1" . "$post_date2";

			$out_bill_catg = $this->cb->select('MAX(CAST(kode AS UNSIGNED)) as kode')->from('out_bill_catg_inv_khusus')->get()->row();

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

			$this->M_outgoing->insert_kategori_harga_khusus($data);
			$this->session->set_flashdata('message_name', 'Kategori Harga berhasil ditambahkan.');
		}

		redirect('outgoinghlp/kategori_harga_khusus');
	}

	public function kategori_harga_hold_khusus($uid, $hold)
	{

		$data = [
			// 'kode'                          => $kode,
			'hold'                          => $hold,
			// 'npwp'                          => $npwp,
			// 'post_date'                     => $post_dates,
			// 'user'                          => $this->session->userdata('nip'),
		];


		$this->M_outgoing->update_kategori_harga_khusus($data, $uid);

		if ($hold == '1') {
			$this->session->set_flashdata('message_name', 'Kategori Harga berhasil di Hold.');
		} else {
			$this->session->set_flashdata('message_name', 'Kategori Harga Ready.');
		}
		redirect('outgoinghlp/kategori_harga_khusus');
	}
}
