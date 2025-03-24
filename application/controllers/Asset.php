<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Asset extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();

		//$this->load->model('M_cuti');
		$this->load->model('m_asset');
		$this->load->library(array('form_validation', 'session', 'user_agent', 'Api_Whatsapp'));
		$this->load->library('pagination');
		$this->load->database();
		$this->load->helper('url', 'form', 'download');
		$this->cb = $this->load->database('corebank', TRUE);

		if (!$this->session->userdata('nip')) {
			redirect('login');
		}
	}

	public function item_list()
	{
		if ($this->session->userdata('isLogin') == FALSE) {
			redirect('home');
		} else {
			$a = $this->session->userdata('level');
			if (strpos($a, '501') !== false) {
				//pagination settings
				$config['base_url'] = site_url('asset/item_list');
				$config['total_rows'] = $this->m_asset->asset_count();
				$config['per_page'] = "20";
				$config["uri_segment"] = 3;
				$choice = $config["total_rows"] / $config["per_page"];
				//$config["num_links"] = floor($choice);
				$config["num_links"] = 10;
				// integrate bootstrap pagination
				$config['full_tag_open'] = '<ul class="pagination">';
				$config['full_tag_close'] = '</ul>';
				$config['first_link'] = false;
				$config['last_link'] = false;
				$config['first_tag_open'] = '<li>';
				$config['first_tag_close'] = '</li>';
				$config['prev_link'] = '«';
				$config['prev_tag_open'] = '<li class="prev">';
				$config['prev_tag_close'] = '</li>';
				$config['next_link'] = '»';
				$config['next_tag_open'] = '<li>';
				$config['next_tag_close'] = '</li>';
				$config['last_tag_open'] = '<li>';
				$config['last_tag_close'] = '</li>';
				$config['cur_tag_open'] = '<li class="active"><a href="#">';
				$config['cur_tag_close'] = '</a></li>';
				$config['num_tag_open'] = '<li>';
				$config['num_tag_close'] = '</li>';
				$this->pagination->initialize($config);
				$data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
				$data['users_data'] = $this->m_asset->asset_get($config["per_page"], $data['page']);
				$data['pagination'] = $this->pagination->create_links();

				//inbox notif
				$nip = $this->session->userdata('nip');
				$sql = "SELECT COUNT(Id) FROM memo WHERE (nip_kpd LIKE '%$nip%' OR nip_cc LIKE '%$nip%') AND (`read` NOT LIKE '%$nip%');";
				$sql2 = "SELECT * FROM asset_ruang";
				$sql3 = "SELECT * FROM asset_lokasi";
				$query = $this->db->query($sql);
				$query2 = $this->db->query($sql2);
				$query3 = $this->db->query($sql3);
				$res2 = $query->result_array();
				$asset_ruang = $query2->result();
				$asset_lokasi = $query3->result();
				$result = $res2[0]['COUNT(Id)'];
				$data['count_inbox'] = $result;
				$data['asset_ruang'] = $asset_ruang;
				$data['asset_lokasi'] = $asset_lokasi;

				// Tello
				$sql4 = "SELECT COUNT(Id) FROM task WHERE (`member` LIKE '%$nip%' or `pic` like '%$nip%') and activity='1'";
				$query4 = $this->db->query($sql4);
				$res4 = $query4->result_array();
				$result4 = $res4[0]['COUNT(Id)'];
				$data['count_inbox2'] = $result4;

				$this->load->view('item_list', $data);
			}
		}
	}

	public function list_penyusutan()
	{
		//inbox notif
		$nip = $this->session->userdata('nip');
		$sql = "SELECT COUNT(Id) FROM memo WHERE (nip_kpd LIKE '%$nip%' OR nip_cc LIKE '%$nip%') AND (`read` NOT LIKE '%$nip%');";
		$query = $this->db->query($sql);
		$res1 = $query->result_array();
		$result = $res1[0]['COUNT(Id)'];
		$data['count_inbox'] = $result;

		$sql2 = "SELECT COUNT(id) FROM task WHERE (`member` LIKE '%$nip%' or `pic` like '%$nip%') and activity='1'";
		$query2 = $this->db->query($sql2);
		$res2 = $query2->result_array();
		$result2 = $res2[0]['COUNT(id)'];
		$data['count_inbox2'] = $result2;

		$this->load->view('penyusutan_view', $data);
	}

	public function penyusutan_ajax_list()
	{
		$list = $this->m_asset->get_datatables_penyusutan();
		$data = array();
		$no = $this->input->post('start');
		$i = 1;
		foreach ($list as $penyusutan) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = date("F Y", strtotime($penyusutan->periode));
			$row[] = '<a href="' . base_url("asset/download_penyusutan/") . $penyusutan->periode . '" class="btn btn-success btn-xs">Download</a>';
			$data[] = $row;
		}

		$output = array(
			"draw" => $this->input->post('draw'),
			"recordsTotal" => $this->m_asset->count_all(),
			"recordsFiltered" => $this->m_asset->count_filtered(),
			"data" => $data,
		);
		//output to json format
		$this->output->set_output(json_encode($output));
	}

	public function penyusutan()
	{
		$filterUmur = $this->db->get_where('asset_list', ['sisa_umur > ' => 0]);
		if ($filterUmur->num_rows() > 0) {

			$now = date('Y-m');

			$data_penyusutan = $this->cb->select('periode')->from('t_penyusutan')->where('periode', $now)->get();

			if ($data_penyusutan->num_rows() > 0) {
				$response = [
					'success' => false,
					'msg' => 'Penyusutan pada bulan ini sudah dilakukan!'
				];

				echo json_encode($response);
				return false;
			}

			$this->cb->trans_begin();
			$this->db->trans_begin();
			foreach ($filterUmur->result_array() as $key => $fu) {
				// Coa Akumulasi Penyusutan
				$coaAkmPenyusutan[] = $this->cb->select('nominal,posisi')->from('v_coa_all')->where('no_sbb', $fu['coa_penyusutan'])->get()->row_array();
				if (!$coaAkmPenyusutan[$key]) {
					$this->cb->trans_rollback();
					$this->db->trans_rollback();
					$response = [
						'success' => false,
						'msg' => 'Penyusutan gagal!'
					];

					echo json_encode($response);
					return false;
				}

				$substrCoaPenyusutan[] = substr($fu['coa_penyusutan'], 0, 1);
				$nominalCoaPenyusutanBaru[] = 0;

				// Coa Beban
				$coaBeban[] = $this->cb->select('nominal,posisi')->from('v_coa_all')->where('no_sbb', $fu['coa_beban'])->get()->row_array();

				if (!$coaBeban[$key]) {
					$this->cb->trans_rollback();
					$this->db->trans_rollback();
					$response = [
						'success' => false,
						'msg' => 'Penyusutan gagal!'
					];

					echo json_encode($response);
					return false;
				}
				$substrCoaBeban[] = substr($fu['coa_beban'], 0, 1);
				$nominalCoaBebanBaru[] = 0;

				$nilaiPenyusutan[] = $fu['penyusutan_bulan'];
				$totalPenyusutan[] = $fu['t_penyusutan'] + $nilaiPenyusutan[$key];
				$hargaPerolehan[] = $fu['harga'];
				$nilaiBuku[] = $fu['nilai_buku'] - $nilaiPenyusutan[$key];

				// Arus kas coa akumulasi penyusutan (kredit)
				if ($coaAkmPenyusutan[$key]['posisi'] == 'AKTIVA') {
					$nominalCoaPenyusutanBaru[$key] = $coaAkmPenyusutan[$key]['nominal'] - $nilaiPenyusutan[$key];
				}

				if ($coaAkmPenyusutan[$key]['posisi'] == 'PASIVA') {
					$nominalCoaPenyusutanBaru[$key] = $coaAkmPenyusutan[$key]['nominal'] + $nilaiPenyusutan[$key];
				}

				if ($substrCoaPenyusutan[$key] == '1' || $substrCoaPenyusutan[$key] == '3' || $substrCoaPenyusutan[$key] == '2') {
					$table_kredit[] = 't_coa_sbb';
					$kolom_kredit[] = 'no_sbb';
				}

				if ($substrCoaPenyusutan[$key] == '4' || $substrCoaPenyusutan[$key] == '5' || $substrCoaPenyusutan[$key] == '6' || $substrCoaPenyusutan[$key] == '7' || $substrCoaPenyusutan[$key] == '8' || $substrCoaPenyusutan[$key] == '9') {
					$table_kredit[] = 't_coalr_sbb';
					$kolom_kredit[] = 'no_lr_sbb';
				}

				$this->cb->where([$kolom_kredit[$key] => $fu['coa_penyusutan']]);
				$updateKredit = $this->cb->update($table_kredit[$key], ['nominal' => $nominalCoaPenyusutanBaru[$key]]);


				// Arus kas coa beban (debit)
				if ($coaBeban[$key]['posisi'] == 'AKTIVA') {
					$nominalCoaBebanBaru[$key] = $coaBeban[$key]['nominal'] + $nilaiPenyusutan[$key];
				}

				if ($coaBeban[$key]['posisi'] == 'PASIVA') {
					$nominalCoaBebanBaru[$key] = $coaBeban[$key]['nominal'] - $nilaiPenyusutan[$key];
				}

				if ($substrCoaBeban[$key] == '1' || $substrCoaBeban[$key] == '3' || $substrCoaBeban[$key] == '2') {
					$table_debit[] = 't_coa_sbb';
					$kolom_debit[] = 'no_sbb';
				}

				if ($substrCoaBeban[$key] == '4' || $substrCoaBeban[$key] == '5' || $substrCoaBeban[$key] == '6' || $substrCoaBeban[$key] == '7' || $substrCoaBeban[$key] == '8' || $substrCoaBeban[$key] == '9') {
					$table_debit[] = 't_coalr_sbb';
					$kolom_debit[] = 'no_lr_sbb';
				}

				$this->cb->where([$kolom_debit[$key] => $fu['coa_beban']]);
				$update_debit = $this->cb->update($table_debit[$key], ['nominal' => $nominalCoaBebanBaru[$key]]);

				// create jurnal
				$jurnal = [
					'tanggal' => date('Y-m-d'),
					'akun_debit' => $fu['coa_beban'],
					'jumlah_debit' => $nilaiPenyusutan[$key],
					'akun_kredit' => $fu['coa_penyusutan'],
					'jumlah_kredit' => $nilaiPenyusutan[$key],
					'saldo_debit' => $nominalCoaBebanBaru[$key],
					'saldo_kredit' => $nominalCoaPenyusutanBaru[$key],
					'created_by' => $this->session->userdata('nip'),
					'keterangan' => 'Nilai penyusutan perbulan asset ' . $fu['nama_asset'] . ' (' . $fu['kode'] . ')'
				];

				$insertJurnal = $this->cb->insert('jurnal_neraca', $jurnal);

				// Update total penyusutan, nilai buku, sisa umur
				$this->db->where('Id', $fu['Id']);
				$updateAsset = $this->db->update('asset_list', [
					't_penyusutan' => $totalPenyusutan[$key],
					'nilai_buku' => $nilaiBuku[$key],
					'sisa_umur' => $fu['sisa_umur'] - 1
				]);

				if (!$updateKredit or !$update_debit or !$insertJurnal or !$updateAsset) {
					$this->cb->trans_rollback();
					$this->db->trans_rollback();
					$response = [
						'success' => false,
						'msg' => 'Penyusutan gagal!'
					];

					echo json_encode($response);
					return false;
				}

				$data[] = [
					'Id' => $fu['Id'],
					'harga_perolehan' => $fu['harga'],
					'umur' => $fu['umur'],
					'coa_asset' => $fu['coa_asset'],
					'coa_beban' => $fu['coa_beban'],
					'coa_penyusutan' => $fu['coa_penyusutan'],
					'penyusutan_per_bulan' => $fu['penyusutan_bulan'],
					'total_penyusutan' => $totalPenyusutan[$key],
					'nilai_buku' => $nilaiBuku[$key],
					'sisa_umur' => $fu['sisa_umur'] - 1
				];
			}
			$insertPenyusutan = $this->cb->insert('t_penyusutan', [
				'periode' => date('Y-m'),
				'user' => $this->session->userdata('nip'),
				'detail' => json_encode($data),
			]);

			if (!$insertPenyusutan) {
				$this->cb->trans_rollback();
				$this->db->trans_rollback();
				$response = [
					'success' => false,
					'msg' => 'Penyusutan gagal 3!'
				];

				echo json_encode($response);
				return false;
			}

			$this->db->trans_commit();
			$this->cb->trans_commit();

			$response = [
				'success' => true,
				'msg' => 'Penyusutan bulan ' . date('m') . '-' . date('Y') . ' sukses!'
			];
		} else {
			$response = [
				'success' => false,
				'msg' => 'Data asset tidak ditemukan!'
			];
		}

		echo json_encode($response);
	}

	function filter_jenis_item()
	{
		$jenis = $this->input->post('jenis_item');
		$this->session->set_userdata('filterJenis', $jenis);
		redirect('asset/item_list');
	}
	function export_item()
	{
		$this->load->view('export_item');
	}

	function reset_jenis_item()
	{
		$this->session->unset_userdata('filterJenis');
		redirect('asset/item_list');
	}

	public function item_detail()
	{
		if ($this->session->userdata('isLogin') == FALSE) {
			redirect('home');
		} else {
			$a = $this->session->userdata('level');
			if (strpos($a, '501') !== false) {

				$nip = $this->session->userdata('nip');
				$sql = "SELECT COUNT(Id) FROM memo WHERE (nip_kpd LIKE '%$nip%' OR nip_cc LIKE '%$nip%') AND (`read` NOT LIKE '%$nip%');";
				$query = $this->db->query($sql);
				$res2 = $query->result_array();
				$result = $res2[0]['COUNT(Id)'];
				$data['count_inbox'] = $result;

				$sql2 = "SELECT * FROM asset_ruang";
				$sql3 = "SELECT * FROM asset_lokasi";
				$query2 = $this->db->query($sql2);
				$query3 = $this->db->query($sql3);
				$asset_ruang = $query2->result();
				$asset_lokasi = $query3->result();

				//ambil data asset_list
				$data['asset_list'] = $this->m_app->ambil_asset_list($this->uri->segment(3));
				$data['asset_history'] = $this->m_app->ambil_asset_history($this->uri->segment(3));
				$data['asset_ruang'] = $asset_ruang;
				$data['asset_lokasi'] = $asset_lokasi;

				$this->load->view('asset_detail', $data);
			}
		}
	}

	public function item_cari()
	{
		if ($this->session->userdata('isLogin') == FALSE) {
			redirect('home');
		} else {
			$a = $this->session->userdata('level');
			if (strpos($a, '501') !== false) {
				// get search string
				$search = ($this->input->post("search")) ? $this->input->post("search") : "NIL";
				if ($search <> 'NIL') {
					$this->session->set_userdata('keyword', $search);
				}
				$search = ($this->uri->segment(3)) ? $this->uri->segment(3) : $search;
				$stringLink = str_replace(' ', '_', $search);
				// pagination settings
				$config = array();
				$config['base_url'] = site_url("asset/item_cari/$stringLink");
				$config['total_rows'] = $this->m_asset->item_cari_count($search);
				$config['per_page'] = "20";
				$config["uri_segment"] = 4;
				$choice = $config["total_rows"] / $config["per_page"];
				//$config["num_links"] = floor($choice);
				$config["num_links"] = 10;

				// integrate bootstrap pagination
				$config['full_tag_open'] = '<ul class="pagination">';
				$config['full_tag_close'] = '</ul>';
				$config['first_link'] = false;
				$config['last_link'] = false;
				$config['first_tag_open'] = '<li>';
				$config['first_tag_close'] = '</li>';
				$config['prev_link'] = 'Prev';
				$config['prev_tag_open'] = '<li class="prev">';
				$config['prev_tag_close'] = '</li>';
				$config['next_link'] = 'Next';
				$config['next_tag_open'] = '<li>';
				$config['next_tag_close'] = '</li>';
				$config['last_tag_open'] = '<li>';
				$config['last_tag_close'] = '</li>';
				$config['cur_tag_open'] = '<li class="active"><a href="#">';
				$config['cur_tag_close'] = '</a></li>';
				$config['num_tag_open'] = '<li>';
				$config['num_tag_close'] = '</li>';
				$this->pagination->initialize($config);

				$data['page'] = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;

				// get books list
				$data['users_data'] = $this->m_asset->item_cari_pagination($config["per_page"], $data['page'], $search);
				$data['pagination'] = $this->pagination->create_links();

				//inbox notif
				$nip = $this->session->userdata('nip');
				$sql = "SELECT COUNT(Id) FROM memo WHERE (nip_kpd LIKE '%$nip%' OR nip_cc LIKE '%$nip%') AND (`read` NOT LIKE '%$nip%');";
				$query = $this->db->query($sql);
				$res1 = $query->result_array();
				$result = $res1[0]['COUNT(Id)'];
				$data['count_inbox'] = $result;

				$sql2 = "SELECT COUNT(id) FROM task WHERE (`member` LIKE '%$nip%' or `pic` like '%$nip%') and activity='1'";
				$query2 = $this->db->query($sql2);
				$res2 = $query2->result_array();
				$result2 = $res2[0]['COUNT(id)'];
				$data['count_inbox2'] = $result2;

				$this->load->view('item_list', $data);
			}
		}
	}

	public function download_penyusutan($periode)
	{
		$excel = new PHPExcel();
		// Buat sebuah variabel untuk menampung pengaturan style dari header tabel
		$style_col = array(
			'font' => array('bold' => true), // Set font nya jadi bold
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
			),
			'borders' => array(
				'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
				'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
				'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
				'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
			)
		);

		// Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
		$style_row = array(
			'alignment' => array(
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
			),
			'borders' => array(
				'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
				'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
				'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
				'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
			)
		);

		// Buat header tabel nya pada baris ke 3
		$excel->setActiveSheetIndex(0)->setCellValue('A3', "No.");
		$excel->setActiveSheetIndex(0)->setCellValue('B3', "Kode Barang");
		$excel->setActiveSheetIndex(0)->setCellValue('C3', "Kategori");
		$excel->setActiveSheetIndex(0)->setCellValue('D3', "COA ASSET");
		$excel->setActiveSheetIndex(0)->setCellValue('E3', "COA BEBAN");
		$excel->setActiveSheetIndex(0)->setCellValue('F3', "COA AKM PENYUSUTAN");
		$excel->setActiveSheetIndex(0)->setCellValue('G3', "Nama Barang");
		$excel->setActiveSheetIndex(0)->setCellValue('H3', "Merk Barang");
		$excel->setActiveSheetIndex(0)->setCellValue('I3', "Ruangan");
		$excel->setActiveSheetIndex(0)->setCellValue('J3', "Jumlah");
		$excel->setActiveSheetIndex(0)->setCellValue('K3', "Perolehan");
		$excel->setActiveSheetIndex(0)->setCellValue('L3', "Umur (Bulan)");
		$excel->setActiveSheetIndex(0)->setCellValue('M3', "Hrg Perolehan");
		$excel->setActiveSheetIndex(0)->setCellValue('N3', "Nilai Penyusutan Perbulan");
		$excel->setActiveSheetIndex(0)->setCellValue('O3', "Total Penyusutan");
		$excel->setActiveSheetIndex(0)->setCellValue('P3', "Nilai Buku");
		$excel->setActiveSheetIndex(0)->setCellValue('Q3', "Sisa Umur");

		// Apply style header yang telah kita buat tadi ke masing-masing kolom header
		$excel->getActiveSheet()->getStyle('A3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('B3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('C3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('D3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('E3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('F3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('G3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('H3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('I3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('J3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('K3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('L3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('M3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('N3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('O3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('P3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('Q3')->applyFromArray($style_col);

		// Set width kolom
		$excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true); // Set width kolom A
		$excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true); // Set width kolom B
		$excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true); // Set width kolom C
		$excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true); // Set width kolom D
		$excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('O')->setAutoSize(true); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('P')->setAutoSize(true); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('Q')->setAutoSize(true); // Set width kolom E

		$penyusutan = $this->cb->get_where('t_penyusutan', ['periode' => $periode])->row_array();

		$data = json_decode($penyusutan['detail']);

		$no = 1; // Untuk penomoran tabel, di awal set dengan 1
		$i = 0;
		$numrow = 4; // Set baris pertama untuk isi tabel adalah baris ke 4
		foreach ($data as $val) {
			$asset = $this->db->select('harga,nama_asset, kode, jumlah, kondisi, jenis_asset, spesifikasi, tgl_perolehan, ruangan')->from('asset_list')->where('Id', $val->Id)->get()->row_array();

			$excel->setActiveSheetIndex(0)->setCellValue('A' . $numrow, $no);
			$excel->setActiveSheetIndex(0)->setCellValue('B' . $numrow, $asset['kode']);
			$excel->setActiveSheetIndex(0)->setCellValue('C' . $numrow, $asset['jenis_asset']);
			$excel->setActiveSheetIndex(0)->setCellValue('D' . $numrow, $val->coa_asset);
			$excel->setActiveSheetIndex(0)->setCellValue('E' . $numrow, $val->coa_beban);
			$excel->setActiveSheetIndex(0)->setCellValue('F' . $numrow, $val->coa_penyusutan);
			$excel->setActiveSheetIndex(0)->setCellValue('G' . $numrow, $asset["nama_asset"]);
			$excel->setActiveSheetIndex(0)->setCellValue('H' . $numrow, $asset["spesifikasi"]);
			$excel->setActiveSheetIndex(0)->setCellValue('I' . $numrow, $asset["ruangan"]);
			$excel->setActiveSheetIndex(0)->setCellValue('J' . $numrow, $asset["jumlah"]);
			$excel->setActiveSheetIndex(0)->setCellValue('K' . $numrow, $asset['tgl_perolehan']);
			$excel->setActiveSheetIndex(0)->setCellValue('L' . $numrow, $val->umur);
			$excel->setActiveSheetIndex(0)->setCellValue('M' . $numrow, str_replace('.', ',', $asset['harga']));
			$excel->setActiveSheetIndex(0)->setCellValue('N' . $numrow, str_replace('.', ',', $val->penyusutan_per_bulan));
			$excel->setActiveSheetIndex(0)->setCellValue('O' . $numrow, str_replace('.', ',', $val->total_penyusutan));
			$excel->setActiveSheetIndex(0)->setCellValue('P' . $numrow, str_replace('.', ',', $val->nilai_buku));
			$excel->setActiveSheetIndex(0)->setCellValue('Q' . $numrow, $val->sisa_umur);

			// Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
			$excel->getActiveSheet()->getStyle('A' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('B' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('C' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('D' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('E' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('F' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('G' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('H' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('I' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('J' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('K' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('L' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('M' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('N' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('O' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('P' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('Q' . $numrow)->applyFromArray($style_row);

			// $excel->getActiveSheet()->getStyle('M' . $numrow . ':P' . $numrow)->getNumberFormat()->setFormatCode('#,##0.00');

			$no++; // Tambah 1 setiap kali looping
			$i++;
			$numrow++; // Tambah 1 setiap kali looping
		}

		// Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
		$excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
		// Set orientasi kertas jadi LANDSCAPE
		$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		// Set judul file excel nya
		$excel->getActiveSheet(0)->setTitle("Penyusutan " . date('M-Y', strtotime($penyusutan['periode'])));
		$excel->setActiveSheetIndex(0);
		// Proses file excel
		// ob_end_clean();
		$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
		header("Content-type: application/vnd.ms-excel");
		header('Content-Disposition: attachment; filename="Penyusutan | ' . date('M-Y', strtotime($penyusutan['periode'])) . '.xlsx"');
		header("Pragma: no-cache");
		header("Expires: 0");
		ob_end_clean();
		$write->save('php://output');
	}
}
