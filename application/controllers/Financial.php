<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Financial extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        //$this->load->model('M_cuti');
        $this->load->model(['m_asset', 'm_coa', 'm_invoice', 'M_Customer']);
        $this->load->library(['form_validation', 'session', 'user_agent', 'Api_Whatsapp', 'pagination', 'pdfgenerator']);
        $this->load->database();
        $this->load->helper(['url', 'form', 'download', 'date', 'number']);

        $this->cb = $this->load->database('corebank', TRUE);

        if (!$this->session->userdata('nip')) {
            redirect('login');
        }
    }

    // private function add_log($action, $record_id, $tableName)
    // {
    //     // Dapatkan user ID dari sesi atau sesuai kebutuhan aplikasi Anda
    //     $user_id = $this->session->userdata('id_user');
    //     // Tambahkan log
    //     $this->M_Logging->add_log($user_id, $action, $tableName, $record_id);
    // }

    public function index()
    {
        // $coa_utility = $this->cb->select('nama_coa_ppn_keluaran, nomor_coa_ppn_keluaran, nama_coa_utang_pph23, nomor_coa_utang_pph23')->get('t_utility')->row_array();

        // print_r($coa_utility);
        echo '<h1>Financial</h1>';
    }

    public function financial_entry($jenis = NULL)
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

        $data = [
            'coa' => $this->m_coa->list_coa(),
            'count_inbox' => $result,
            'count_inbox2' => $result2,
        ];



        if ($jenis == "debit") {
            $this->load->view('financial_entry_debit', $data);
        } else if ($jenis == "kredit") {
            $this->load->view('financial_entry_kredit', $data);
        } else {
            $this->load->view('financial_entry', $data);
        }
    }

    public function process_financial_entry($jenis = null)
    {
        $keterangan = trim($this->input->post('input_keterangan'));
        $tanggal_transaksi = $this->input->post('tanggal');

        $this->cb->trans_start(); // Mulai transaksi
        $id_invoice = NULL;

        if ($jenis == "multi_kredit") {
            $coa_debit  = $this->input->post('neraca_debit');
            $coa_kredit = $this->input->post('accounts');
            $nominal    = preg_replace('/[^a-zA-Z0-9\']/', '', $this->input->post('nominals'));

            if (is_array($coa_kredit) && is_array($nominal)) {
                foreach ($coa_kredit as $i => $kredit) {
                    $this->posting($coa_debit, $kredit, $keterangan, $nominal[$i], $tanggal_transaksi, $id_invoice);
                }
            }
        } elseif ($jenis == "multi_debit") {
            $coa_debit  = $this->input->post('accounts');
            $coa_kredit = $this->input->post('neraca_kredit');
            $nominal    = preg_replace('/[^a-zA-Z0-9\']/', '', $this->input->post('nominals'));

            if (is_array($coa_debit) && is_array($nominal)) {
                foreach ($coa_debit as $i => $debit) {
                    $this->posting($debit, $coa_kredit, $keterangan, $nominal[$i], $tanggal_transaksi, $id_invoice);
                }
            }
        } else {
            $coa_debit  = $this->input->post('neraca_debit');
            $coa_kredit = $this->input->post('neraca_kredit');

            if ($coa_debit == $coa_kredit) {
                $this->session->set_flashdata('message_error', 'CoA Debit dan Kredit tidak boleh sama');
                redirect('financial/financial_entry');
            }

            $nominal = preg_replace('/[^a-zA-Z0-9\']/', '', $this->input->post('input_nominal'));
            $this->posting($coa_debit, $coa_kredit, $keterangan, $nominal, $tanggal_transaksi, $id_invoice);
        }

        $this->cb->trans_complete(); // Selesaikan transaksi

        if ($this->cb->trans_status() === FALSE) {
            $this->cb->trans_rollback();
            $this->session->set_flashdata('message_error', 'Transaksi gagal, silakan coba lagi.');
        } else {
            $this->cb->trans_commit();
            $this->session->set_flashdata('message_name', 'Transaksi berhasil.');
        }

        redirect('financial/financial_entry');
    }


    public function upload_financial_entry()
    {
        $this->load->library('upload');
        require APPPATH . 'third_party/autoload.php';

        // Include PhpSpreadsheet from third_party
        require APPPATH . 'third_party/psr/simple-cache/src/CacheInterface.php';


        // Configure upload settings
        $config['upload_path'] = FCPATH . 'upload/financial_entry';
        $config['allowed_types'] = 'xls|xlsx|csv'; // Allowed file types
        $this->upload->initialize($config);

        if (!$this->upload->do_upload('format_data')) {
            // If the upload fails, show the error
            $error = $this->upload->display_errors();
            echo json_encode(['status' => false, 'message' => $error, 'upload_path' => $config['upload_path']]);
            return;
        }

        // File upload success
        $file_data = $this->upload->data();
        $file_path = $file_data['full_path'];

        try {
            // Load the spreadsheet using PhpSpreadsheet
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file_path);
            $worksheet = $spreadsheet->getActiveSheet();

            // Get total rows
            $totalRows = iterator_count($worksheet->getRowIterator());
            $totalRows -= 2; // Adjust for headers
            $insertedRows = 0;

            // --- Initialize counters ---  
            $no_debit_rows = [];
            $no_kredit_rows = [];
            $success_count = 0;

            // Process rows
            foreach ($worksheet->getRowIterator() as $rowIndex => $row) {
                // Skip header rows
                if ($rowIndex < 3) continue;

                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(false);

                $data = [];
                foreach ($cellIterator as $cell) {
                    $data[] = $cell->getValue();
                }

                // Extract and process row data
                $coa_debit = isset($data[0]) ? (string)$data[0] : null;
                $coa_kredit = isset($data[1]) ? (string)$data[1] : null;
                $nominal = isset($data[2]) ? (string)$data[2] : null;
                $tanggal = isset($data[3]) ? $this->processDate($data[3]) : null;
                $keterangan = isset($data[4]) ? $data[4] : null;

                $posting = $this->posting(
                    $coa_debit,
                    $coa_kredit,
                    $keterangan,
                    $nominal,
                    $tanggal,
                    $jenis_fe = 'single'
                );

                // --- Store row index if an error occurs ---
                if ($posting == "No Debit") {
                    $no_debit_rows[] = $rowIndex;
                } else if ($posting == "No Kredit") {
                    $no_kredit_rows[] = $rowIndex;
                } else {
                    $success_count++;
                }

                $insertedRows++;
                $progress = round(($insertedRows / $totalRows) * 100);
                echo "data: " . json_encode(['progress' => $progress, 'currentRow' => $insertedRows, 'totalRows' => $totalRows]) . "\n\n";
                ob_flush();
                flush();
            }

            // Commit transaction
            if ($this->cb->trans_status() === FALSE) {
                $this->cb->trans_rollback();
                echo json_encode(['status' => false, 'message' => 'Database error']);
            } else {
                $this->cb->trans_commit();
                // echo json_encode(['status' => true, 'message' => 'File processed successfully']);
                echo json_encode([
                    'status' => true,
                    'message' => 'File processed successfully',
                    'success_count' => $success_count,
                    'no_debit_rows' => $no_debit_rows,
                    'no_kredit_rows' => $no_kredit_rows
                ]);
            }
        } catch (Exception $e) {
            // Handle exceptions
            echo json_encode(['status' => false, 'message' => $e->getMessage()]);
        } finally {
            // Cleanup uploaded file
            if (file_exists($file_path)) unlink($file_path);
        }
    }

    public function invoice()
    {
        $customer_id = $this->input->post('customer_id') ? $this->input->post('customer_id') : $this->input->get('id_customer');
        $keyword = trim($this->input->post('keyword', true) ?? '');

        $config = [
            'base_url' => site_url('financial/invoice'),
            'total_rows' => $this->m_invoice->invoice_count($keyword, $customer_id),
            'per_page' => 20,
            'uri_segment' => 3,
            'num_links' => 10,
            'full_tag_open' => '<ul class="pagination" style="margin: 0 0">',
            'full_tag_close' => '</ul>',
            'first_link' => false,
            'last_link' => false,
            'first_tag_open' => '<li>',
            'first_tag_close' => '</li>',
            'prev_link' => '«',
            'prev_tag_open' => '<li class="prev">',
            'prev_tag_close' => '</li>',
            'next_link' => '»',
            'next_tag_open' => '<li>',
            'next_tag_close' => '</li>',
            'last_tag_open' => '<li>',
            'last_tag_close' => '</li>',
            'cur_tag_open' => '<li class="active"><a href="#">',
            'cur_tag_close' => '</a></li>',
            'num_tag_open' => '<li>',
            'num_tag_close' => '</li>'
        ];

        $this->pagination->initialize($config);

        $page = $this->uri->segment(3) ? $this->uri->segment(3) : 0;
        $invoices = $this->m_invoice->list_invoice($config["per_page"], $page, $keyword, $customer_id);

        $nip = $this->session->userdata('nip');
        $sql = "SELECT COUNT(Id) FROM memo WHERE (nip_kpd LIKE '%$nip%' OR nip_cc LIKE '%$nip%') AND (`read` NOT LIKE '%$nip%');";
        $query = $this->db->query($sql);
        $result = $query->row_array()['COUNT(Id)'];

        $sql2 = "SELECT COUNT(id) FROM task WHERE (`member` LIKE '%$nip%' or `pic` like '%$nip%') and activity='1'";
        $query2 = $this->db->query($sql2);
        $result2 = $query2->row_array()['COUNT(id)'];

        $data = [
            'page' => $page,
            'invoices' => $invoices,
            'count_inbox' => $result,
            'count_inbox2' => $result2,
            'coa' => $this->m_coa->list_coa(),
            'coa_kas' => $this->m_coa->getCoaByCode('120'),
            // 'coa_pendapatan' => $this->m_coa->getCoaByCode('410'),
            'keyword' => $keyword,
            'title' => "Invoice",
            'customers' => $this->M_Customer->list_customer(''),
        ];

        // Ambil data COA pertama
        $coa_410_arr = $this->m_coa->getCoaByCode('410');

        // Ambil data COA kedua
        $coa_13020_arr = $this->m_coa->getCoaByCode('13020');

        // Gabungkan kedua hasil ke dalam satu array baru
        $merged_coa_arr = array_merge($coa_410_arr, $coa_13020_arr);

        // Jika perlu, konversi kembali menjadi objek
        $data['coa_pendapatan'] = (object)$merged_coa_arr;
        // echo '<pre>';
        // print_r($data['invoices']);
        // echo '</pre>';
        // exit;

        $this->load->view('invoice', $data);
    }

    public function create_invoice()
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

        $data = [
            'title' => 'Create Invoice',
            // 'no_invoice' => $no_inv,
            'customers' => $this->M_Customer->list_customer(),
            'pendapatan' => $this->m_coa->getCoaByCode('1'),
            'persediaan' => $this->m_coa->getCoaByCode('4'),
            'count_inbox' => $result,
            'count_inbox2' => $result2,
        ];

        $this->load->view('invoice_create_khusus', $data);
    }

    public function create_invoice_khusus()
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

        $data = [
            'title' => 'Create Invoice',
            // 'no_invoice' => $no_inv,
            'customers' => $this->M_Customer->list_customer('khusus'),
            'pendapatan' => $this->m_coa->getCoaByCode('1'),
            'persediaan' => $this->m_coa->getCoaByCode('4'),
            'count_inbox' => $result,
            'count_inbox2' => $result2,
        ];

        $this->load->view('invoice_create_khusus', $data);
    }

    public function store_invoice($jenis)
    {
        $id_user = $this->session->userdata('nip');
        $diskon = $this->input->post('diskon');
        $ppn = $this->input->post('ppn');
        $nominal = $this->convertToNumberWithComma($this->input->post('nominal'));
        $besaran_diskon = $this->convertToNumberWithComma(($this->input->post('besaran_diskon')) ? $this->input->post('besaran_diskon') : '0');
        $besaran_ppn = $this->convertToNumberWithComma($this->input->post('besaran_ppn'));
        $besaran_pph = $this->convertToNumberWithComma($this->input->post('besaran_pph'));
        $nominal_bayar = $this->convertToNumberWithComma($this->input->post('nominal_bayar'));
        // $total_chargeable = $this->convertToNumberWithComma($this->input->post('total_chargeable'));
        $total_nonpph = $this->convertToNumberWithComma($this->input->post('total_nonpph'));
        $total_denganpph = $this->convertToNumberWithComma($this->input->post('total_denganpph'));
        $nominal_pendapatan = $this->convertToNumberWithComma($this->input->post('nominal_pendapatan'));

        // print_r($nominal);
        // exit;

        $no_inv = $this->input->post('no_invoice');

        // $status_pendapatan = $this->input->post('status_pendapatan');
        $opsi_termin = $this->input->post('opsi_termin');
        $opsi_pph = $this->input->post('opsi_pph');
        $opsi_ppn = $this->input->post('opsi_ppn');
        $coa_debit = $this->input->post('coa_debit');
        $coa_kredit = $this->input->post('coa_kredit');


        $pph = isset($opsi_pph) ? '0.02' : 0;

        $tgl_invoice = $this->input->post('tgl_invoice');
        $tahun = substr($tgl_invoice, 0, 4);

        $max_num = $this->m_invoice->select_max($tahun);

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

        $keterangan = trim($this->input->post('keterangan'));

        if ($jenis == 'reguler') {
            $jenis_invoice = 'reguler';
        } else {
            $jenis_invoice = 'khusus';
        }

        // Insert ke tabel invoice
        $invoice_data = [
            'no_invoice' => $no_inv,
            'tanggal_invoice' => $tgl_invoice,
            'created_by' => $id_user,
            'keterangan' => $keterangan,
            'id_customer' => $this->input->post('customer'),
            'subtotal' => $nominal,
            'diskon' => isset($diskon) ? $diskon : '0',
            'besaran_diskon' => $besaran_diskon,
            'ppn' => $ppn,
            'besaran_ppn' => $besaran_ppn,
            'opsi_pph23' => isset($opsi_pph) ? $opsi_pph : '0',
            'opsi_ppn' => isset($opsi_ppn) ? $opsi_ppn : '0',
            'pph' => $pph,
            'besaran_pph' => $besaran_pph,
            'total_nonpph' => $total_nonpph,
            'total_denganpph' => $total_denganpph,
            'coa_debit' => $coa_debit,
            'coa_kredit' => $coa_kredit,
            'nominal_bayar' => $nominal_bayar,
            'nominal_pendapatan' => $nominal_pendapatan,
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
            redirect("financial/invoice");
        }

        $items = $this->input->post('item');
        $jumlahs = $this->input->post('jumlah');
        $totals = $this->input->post('total');
        $total_amounts = $this->input->post('total_amount');

        $detail_data = [];

        if (is_array($items)) {

            for ($i = 0; $i < count($items); $i++) {
                $item = trim($items[$i]);
                $total = $this->convertToNumberWithComma($totals[$i]);
                $jumlah = $this->convertToNumberWithComma($jumlahs[$i]);
                $total_amount = $this->convertToNumberWithComma($total_amounts[$i]);

                $detail_data[] = [
                    'id_invoice' => $id_invoice,
                    'item' => strtoupper($item),
                    'total' => $total,
                    'qty' => $jumlah,
                    'total_amount' => $total_amount,
                    'created_by' => $id_user,
                    'id_cabang' => $this->session->userdata('kode_cabang'),
                ];
            }

            if (!empty($detail_data)) {
                $insert = $this->m_invoice->insert_batch($detail_data);

                if ($insert === FALSE) {
                    $this->cb->trans_rollback();
                    $this->session->set_flashdata('message_name', 'Failed to insert invoice details.');
                    redirect("financial/invoice");
                }

                // Pastikan fungsi posting tidak mengganggu transaksi
                $this->posting($coa_debit, $coa_kredit, $keterangan, $total_denganpph, $tgl_invoice, $id_invoice);

                $this->cb->trans_commit();
                $this->session->set_flashdata('message_name', 'The invoice has been successfully created. ' . $no_inv);
                redirect("financial/invoice");
            } else {
                $this->cb->trans_rollback();
                $this->session->set_flashdata('message_name', 'Invoice detail data is empty.');
                redirect("financial/invoice");
            }
        }
    }

    public function edit_invoice($id)
    {
        $inv =  $this->m_invoice->showById($id);
        $nip = $this->session->userdata('nip');
        $sql = "SELECT COUNT(Id) FROM memo WHERE (nip_kpd LIKE '%$nip%' OR nip_cc LIKE '%$nip%') AND (`read` NOT LIKE '%$nip%');";
        $query = $this->db->query($sql);
        $res2 = $query->result_array();
        $result = $res2[0]['COUNT(Id)'];

        $sql2 = "SELECT COUNT(id) FROM task WHERE (`member` LIKE '%$nip%' or `pic` like '%$nip%') and activity='1'";
        $query2 = $this->db->query($sql2);
        $res2 = $query2->result_array();
        $result2 = $res2[0]['COUNT(id)'];

        $data = [
            'title' => 'Invoice No. ' . $inv['no_invoice'],
            'inv' => $inv,
            'details' => $this->m_invoice->item_list($inv['Id']),
            'user' => $this->m_invoice->cek_user($inv['user_create']),
            'customers' => $this->M_Customer->list_customer(),
            'count_inbox' => $result,
            'count_inbox2' => $result2,
            'pendapatan' => $this->m_coa->getCoaByCode('1'),
            'persediaan' => $this->m_coa->getCoaByCode('4'),
        ];

        $pages = "invoice_edit";

        $this->load->view($pages, $data);
    }

    public function update_invoice($id)
    {
        $id_user = $this->session->userdata('nip');
        $diskon = $this->input->post('diskon');
        $ppn = $this->input->post('ppn');
        $nominal = $this->convertToNumber($this->input->post('nominal'));
        $besaran_diskon = $this->convertToNumber(($this->input->post('besaran_diskon')) ? $this->input->post('besaran_diskon') : '0');
        $besaran_ppn = $this->convertToNumber($this->input->post('besaran_ppn'));
        $besaran_pph = $this->convertToNumber($this->input->post('besaran_pph'));
        $nominal_bayar = $this->convertToNumber($this->input->post('nominal_bayar'));
        // $total_chargeable = $this->convertToNumber($this->input->post('total_chargeable'));
        $total_nonpph = $this->convertToNumber($this->input->post('total_nonpph'));
        $total_denganpph = $this->convertToNumber($this->input->post('total_denganpph'));
        $nominal_pendapatan = $this->convertToNumber($this->input->post('nominal_pendapatan'));

        $no_inv = $this->input->post('no_invoice');

        // $status_pendapatan = $this->input->post('status_pendapatan');
        $opsi_termin = $this->input->post('opsi_termin');
        $opsi_pph = $this->input->post('opsi_pph');
        $opsi_ppn = $this->input->post('opsi_ppn');
        $coa_debit = $this->input->post('coa_debit');
        $coa_kredit = $this->input->post('coa_kredit');

        $pph = ($opsi_pph == 1) ? '0.02' : 0;


        $tgl_invoice = $this->input->post('tgl_invoice');

        $keterangan = trim($this->input->post('keterangan'));


        // Insert ke tabel invoice
        $invoice_data = [
            'no_invoice' => $no_inv,
            'tanggal_invoice' => $tgl_invoice,
            'created_by' => $id_user,
            'keterangan' => $keterangan,
            'id_customer' => $this->input->post('customer'),
            'subtotal' => $nominal,
            'diskon' => isset($diskon) ? $diskon : '0',
            'besaran_diskon' => $besaran_diskon,
            'ppn' => $ppn,
            'besaran_ppn' => $besaran_ppn,
            'opsi_pph23' => isset($opsi_pph) ? $opsi_pph : '0',
            'opsi_ppn' => isset($opsi_ppn) ? $opsi_ppn : '0',
            'pph' => $pph,
            'besaran_pph' => $besaran_pph,
            'total_nonpph' => $total_nonpph,
            'total_denganpph' => $total_denganpph,
            'coa_debit' => $coa_debit,
            'coa_kredit' => $coa_kredit,
            'nominal_bayar' => $nominal_bayar,
            'nominal_pendapatan' => $nominal_pendapatan,
            // 'status_pendapatan' => isset($status_pendapatan) ? $status_pendapatan : '0'
            'opsi_termin' => isset($opsi_termin) ? $opsi_termin : '0',
            'status_pendapatan' => '1'
        ];

        $this->cb->trans_begin();

        $inv =  $this->m_invoice->showById($id);

        $keterangan_lama = "Jurnal balik edit invoice " . $inv['no_invoice'];

        // Jurnal balik sebelum update invoice
        $coa_kredit_lama = $inv['coa_kredit'];
        $coa_debit_lama = $inv['coa_debit'];

        $this->posting($coa_kredit_lama, $coa_debit_lama, $keterangan_lama, $inv['total_denganpph'], $inv['tanggal_invoice'], $inv['Id']);

        if (!$this->m_invoice->update_invoice($id, $invoice_data)) {
            $this->cb->trans_rollback();
            $this->session->set_flashdata('message_name', 'Failed to update invoice.');
            redirect('financial/invoice');
        }

        $items = $this->input->post('item');
        $jumlahs = $this->input->post('jumlah');
        $totals = $this->input->post('total');
        $total_amounts = $this->input->post('total_amount');

        // Hapus detail invoice lama
        $this->cb->where('id_invoice', $id)->delete('invoice_details');

        // Handle detail data
        if (!empty($items)) {
            $detail_data = [];

            for ($i = 0; $i < count($items); $i++) {
                $detail_data[] = [
                    'id_invoice' => $id,
                    'item' => strtoupper(trim($items[$i])),
                    'total' => $this->convertToNumber($totals[$i]),
                    'qty' => $this->convertToNumber($jumlahs[$i]),
                    'total_amount' => $this->convertToNumber($total_amounts[$i]),
                    'created_by' => $id_user
                ];
            }

            if (!empty($detail_data)) {
                if (!$this->m_invoice->insert_batch($detail_data)) {
                    $this->cb->trans_rollback();
                    $this->session->set_flashdata('message_name', 'Failed to insert invoice details.');
                    redirect("financial/invoice");
                }
            }
        }

        // Update jurnal
        // $dt_jurnal = [
        //     'tanggal' => $tgl_invoice,
        //     'akun_debit' => $coa_debit,
        //     'jumlah_debit' => $nominal_bayar,
        //     'akun_kredit' => $coa_kredit,
        //     'jumlah_kredit' => $nominal_bayar,
        //     'keterangan' => trim($keterangan),
        //     'created_by' => $id_user,
        // ];

        // if (!$this->cb->where('id_invoice', $id)->update('jurnal_neraca', $dt_jurnal)) {
        //     $this->cb->trans_rollback();
        //     $this->session->set_flashdata('message_name', 'Failed to update journal.');
        //     redirect("financial/invoice");
        // }

        $this->posting(
            $coa_debit,
            $coa_kredit,
            $keterangan,
            $total_denganpph,
            $tgl_invoice,
            $id
        );

        // Commit transaksi
        if ($this->cb->trans_status() === FALSE) {
            $this->cb->trans_rollback();
            $this->session->set_flashdata('message_name', 'Transaction failed.');
        } else {
            $this->cb->trans_commit();
            $this->session->set_flashdata('message_name', 'Invoice updated successfully.');
        }

        redirect('financial/invoice');
    }

    // private function posting($coa_debit, $coa_kredit, $keterangan, $nominal, $tanggal, $id_invoice = NULL)
    // {
    //     $substr_coa_debit = substr($coa_debit, 0, 1);
    //     $substr_coa_kredit = substr($coa_kredit, 0, 1);

    //     $debit = $this->m_coa->cek_coa($coa_debit);
    //     $kredit = $this->m_coa->cek_coa($coa_kredit);

    //     $saldo_debit_baru = 0;
    //     $saldo_kredit_baru = 0;

    //     if ($debit['posisi'] == "AKTIVA") {
    //         $saldo_debit_baru = $debit['nominal'] + $nominal;
    //     } else if ($debit['posisi'] == "PASIVA") {
    //         $saldo_debit_baru = $debit['nominal'] - $nominal;
    //     }

    //     if ($kredit['posisi'] == "AKTIVA") {
    //         $saldo_kredit_baru = $kredit['nominal'] - $nominal;
    //     } else if ($kredit['posisi'] == "PASIVA") {
    //         $saldo_kredit_baru = $kredit['nominal'] + $nominal;
    //     }

    //     // cek tabel
    //     if ($substr_coa_debit == "1" || $substr_coa_debit == "2" || $substr_coa_debit == "3") {
    //         $tabel_debit = "t_coa_sbb";
    //         $kolom_debit = "no_sbb";
    //     } else {
    //         $tabel_debit = "t_coalr_sbb";
    //         $kolom_debit = "no_lr_sbb";
    //     }

    //     if ($substr_coa_kredit == "1" || $substr_coa_kredit == "2" || $substr_coa_debit == "3") {
    //         $tabel_kredit = "t_coa_sbb";
    //         $kolom_kredit = "no_sbb";
    //     } else {
    //         $tabel_kredit = "t_coalr_sbb";
    //         $kolom_kredit = "no_lr_sbb";
    //     }

    //     $data_debit = [
    //         'nominal' => $saldo_debit_baru
    //     ];
    //     $data_kredit = [
    //         'nominal' => $saldo_kredit_baru
    //     ];

    //     $this->m_coa->update_nominal_coa($coa_debit, $data_debit, $kolom_debit, $tabel_debit);

    //     $this->m_coa->update_nominal_coa($coa_kredit, $data_kredit, $kolom_kredit, $tabel_kredit);

    //     $dt_jurnal = [
    //         'tanggal' => $tanggal,
    //         'akun_debit' => $coa_debit,
    //         'jumlah_debit' => $nominal,
    //         'akun_kredit' => $coa_kredit,
    //         'jumlah_kredit' => $nominal,
    //         'saldo_debit' => $saldo_debit_baru,
    //         'saldo_kredit' => $saldo_kredit_baru,
    //         'keterangan' => $keterangan,
    //         'created_by' => $this->session->userdata('nip'),
    //         'id_invoice' => ($id_invoice) ? $id_invoice : '',
    //         'id_cabang' => $this->session->userdata('kode_cabang')
    //     ];

    //     $this->m_coa->addJurnal($dt_jurnal);

    //     $data_transaksi = [
    //         'user_id' => $this->session->userdata('nip'),
    //         'tgl_trs' => date('Y-m-d H:i:s'),
    //         'nominal' => $nominal,
    //         'debet' => $coa_debit,
    //         'kredit' => $coa_kredit,
    //         'keterangan' => trim($keterangan),
    //         'id_cabang' => $this->session->userdata('kode_cabang')
    //     ];

    //     $this->m_coa->add_transaksi($data_transaksi);
    // }

    private function processDate($dateValue)
    {
        if (is_numeric($dateValue)) {
            // Handle Excel date integer
            return DateTime::createFromFormat('U', ($dateValue - 25569) * 86400)->format('Y-m-d');
        } elseif (DateTime::createFromFormat('m/d/Y', $dateValue) !== false) {
            // Handle string date format
            return DateTime::createFromFormat('m/d/Y', $dateValue)->format('Y-m-d');
        }
        // If the date format is not recognized, return null or handle accordingly
        return null;
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

    private function posting_new($coa_debit, $coa_kredit, $keterangan, $nominal, $tanggal, $id_invoice = NULL)
    {
        $substr_coa_debit = substr($coa_debit, 0, 1);
        $substr_coa_kredit = substr($coa_kredit, 0, 1);

        $debit = $this->m_coa->cek_coa($coa_debit);
        $kredit = $this->m_coa->cek_coa($coa_kredit);

        // Tentukan operator berdasarkan posisi akun
        $operator_debit = ($debit['posisi'] == "AKTIVA") ? '+' : '-';
        $operator_kredit = ($kredit['posisi'] == "AKTIVA") ? '-' : '+';

        // Tentukan tabel dan kolom untuk debit
        if (in_array($substr_coa_debit, ['1', '2', '3'])) {
            $tabel_debit = "t_coa_sbb";
            $kolom_debit = "no_sbb";
        } else {
            $tabel_debit = "t_coalr_sbb";
            $kolom_debit = "no_lr_sbb";
        }

        // Tentukan tabel dan kolom untuk kredit
        if (in_array($substr_coa_kredit, ['1', '2', '3'])) {
            $tabel_kredit = "t_coa_sbb";
            $kolom_kredit = "no_sbb";
        } else {
            $tabel_kredit = "t_coalr_sbb";
            $kolom_kredit = "no_lr_sbb";
        }

        // Mulai transaksi database
        $this->db->trans_start();

        // Update saldo debit
        $this->m_coa->update_nominal_coa($coa_debit, $nominal, $kolom_debit, $tabel_debit, $operator_debit);

        // Update saldo kredit
        $this->m_coa->update_nominal_coa($coa_kredit, $nominal, $kolom_kredit, $tabel_kredit, $operator_kredit);

        // Ambil saldo terbaru untuk jurnal (opsional: jika mau lebih presisi)
        $saldo_debit_baru = $this->m_coa->get_nominal($coa_debit, $kolom_debit, $tabel_debit);
        $saldo_kredit_baru = $this->m_coa->get_nominal($coa_kredit, $kolom_kredit, $tabel_kredit);

        // Data untuk jurnal
        $dt_jurnal = [
            'tanggal' => $tanggal,
            'akun_debit' => $coa_debit,
            'jumlah_debit' => $nominal,
            'akun_kredit' => $coa_kredit,
            'jumlah_kredit' => $nominal,
            'saldo_debit' => $saldo_debit_baru,
            'saldo_kredit' => $saldo_kredit_baru,
            'keterangan' => $keterangan,
            'created_by' => $this->session->userdata('nip'),
            'id_invoice' => $id_invoice ?? '',
            'id_cabang' => $this->session->userdata('kode_cabang')
        ];

        $this->m_coa->addJurnal($dt_jurnal);

        // Data untuk transaksi
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

        // Selesai transaksi database
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            // Jika ada gagal, rollback dan beri pesan error
            throw new Exception('Gagal melakukan posting transaksi.');
        }
    }


    public function print_invoice($id)
    {
        $inv =  $this->m_invoice->showById($id);
        $data = [
            'title_pdf' => 'Invoice No. ' . $inv['no_invoice'],
            'invoice' => $inv,
            'details' => $this->m_invoice->item_list($inv['Id']),
            'user' => $this->m_invoice->cek_user($inv['user_create'])
        ];

        // filename dari pdf ketika didownload
        $file_pdf = 'Invoice No. ' . $inv['no_invoice'];

        // setting paper
        $paper = 'A4';

        //orientasi paper potrait / landscape
        $orientation = "portrait";

        $html = $this->load->view('invoice_pdf', $data, true);

        // run dompdf
        $this->pdfgenerator->generate($html, $file_pdf, $paper, $orientation);
        // $this->load->view('invoice_pdf', $data);
    }

    public function autocomplete()
    {
        $term = $this->input->get('term');
        $this->cb->like('nama_item', $term);
        $query = $this->cb->get('item_invoice');
        $result = $query->result_array();
        $items = [];
        foreach ($result as $row) {
            $items[] = [
                'label' => $row['nama_item'],
                'value' => $row['nama_item'],
                'id_item' => $row['id'],
                'harga' => $row['harga'],
                'stok' => $row['stok'],
            ];
        }
        echo json_encode($items);
    }

    public function paid()
    {
        $this->db->trans_begin(); // MULAI TRANSAKSI

        $id = $this->uri->segment(3);

        // print_r($id);
        // exit;
        $inv =  $this->m_invoice->showById($id);
        $coa_debit = $this->input->post('coa_debit');
        $coa_kredit = $this->input->post('coa_kredit');
        $nominal_bayar = $this->convertToNumber($this->input->post('nominal_bayar'));
        $keterangan = $this->input->post('keterangan');
        $status_bayar = $this->input->post('status_bayar');
        $tanggal_bayar = $this->input->post('tanggal_bayar');

        // J1
        $j1_coa_debit = $inv['coa_kredit'];
        $j1_coa_kredit = $coa_kredit;
        $this->posting($j1_coa_debit, $j1_coa_kredit, $keterangan, $inv['nominal_pendapatan'], $tanggal_bayar);

        // J3
        $j1_coa_debit = $coa_debit;
        $j1_coa_kredit = $inv['coa_debit'];
        $this->posting($j1_coa_debit, $j1_coa_kredit, $keterangan, $nominal_bayar, $tanggal_bayar);

        $coa_utility = $this->cb->select('nama_coa_ppn_keluaran, nomor_coa_ppn_keluaran, nama_coa_utang_pph23, nomor_coa_utang_pph23')->get('t_utility')->row_array();
        // print_r($coa_utility);

        // J2
        if ($inv['besaran_ppn'] !== '0.00') {
            $j1_coa_debit = $inv['coa_debit'];
            // $j1_coa_kredit = "23011"; // cek ini
            $j1_coa_kredit = $coa_utility['nomor_coa_ppn_keluaran']; // cek ini
            $this->posting($j1_coa_debit, $j1_coa_kredit, $keterangan, $inv['besaran_ppn'], $tanggal_bayar);

            $j2_coa_debit = $inv['coa_kredit'];
            $j2_coa_kredit = $inv['coa_debit'];
            $this->posting($j2_coa_debit, $j2_coa_kredit, $keterangan, $inv['besaran_ppn'], $tanggal_bayar);
        }

        // J4 (PPH23)
        if ($inv['opsi_pph23'] == '1') {
            $j1_coa_debit = $coa_debit;
            // $j1_coa_kredit = "23014";
            $j1_coa_kredit = $coa_utility['nomor_coa_utang_pph23'];
            $this->posting($j1_coa_debit, $j1_coa_kredit, $keterangan, $inv['besaran_pph'], $tanggal_bayar);
        }

        $this->log_pembayaran("invoice", $inv['Id'], $nominal_bayar, $keterangan);

        $data_invoice = [
            'status_pendapatan' => ($status_bayar == 1) ? '2' : '1',
            'status_bayar' => ($status_bayar == 1) ? '1' : '0',
            'total_termin' => $inv['total_termin'] + $nominal_bayar,
            'tanggal_bayar' => $tanggal_bayar,
        ];

        $this->m_invoice->update_invoice($inv['Id'], $data_invoice);

        // CEK APAKAH SEMUA BERHASIL
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback(); // ROLLBACK TRANSAKSI
            $this->session->set_flashdata('message_name', 'Gagal memperbarui invoice. Silakan coba lagi.');
        } else {
            $this->db->trans_commit(); // KOMIT TRANSAKSI
            $this->session->set_flashdata('message_name', 'The invoice has been successfully updated. ' . $inv['no_invoice']);
        }

        redirect("financial/invoice");
    }


    public function showReport()
    {
        $nip = $this->session->userdata('nip');

        // Fetch counts
        $result = $this->db->query("SELECT COUNT(Id) FROM memo WHERE (nip_kpd LIKE '%$nip%' OR nip_cc LIKE '%$nip%') AND (`read` NOT LIKE '%$nip%');")->row()->{'COUNT(Id)'};
        $result2 = $this->db->query("SELECT COUNT(id) FROM task WHERE (`member` LIKE '%$nip%' or `pic` LIKE '%$nip%') AND activity='1'")->row()->{'COUNT(id)'};

        $data = [
            'count_inbox' => $result,
            'count_inbox2' => $result2,
        ];

        $jenis_laporan = $this->input->post('jenis_laporan');
        $no_coa = $this->input->post('no_coa');

        if ($jenis_laporan) {
            if ($jenis_laporan == "neraca") {
                $this->prepareNeracaReport($data);
            } else if ($jenis_laporan == "laba_rugi") {
                $this->prepareLabaRugiReport($data);
            }
        } else {
            $this->prepareNeracaReport($data);
        }
    }

    public function showNeracaTersimpan($slug)
    {
        $nip = $this->session->userdata('nip');

        // Fetch counts
        $result = $this->db->query("SELECT COUNT(Id) FROM memo WHERE (nip_kpd LIKE '%$nip%' OR nip_cc LIKE '%$nip%') AND (`read` NOT LIKE '%$nip%');")->row()->{'COUNT(Id)'};
        $result2 = $this->db->query("SELECT COUNT(id) FROM task WHERE (`member` LIKE '%$nip%' or `pic` LIKE '%$nip%') AND activity='1'")->row()->{'COUNT(id)'};

        $detail = $this->m_coa->showNeraca($slug);

        $data = [
            'title' => 'Neraca tersimpan',
            'count_inbox' => $result,
            'count_inbox2' => $result2,
            // 'pages' => 'pages/financial/v_neraca',
            'activa' => json_decode($detail['aktiva']),
            'pasiva' => json_decode($detail['pasiva']),
            'neraca' => $detail['nominal_sum_aktiva'] - $detail['nominal_sum_pasiva'],
            'sum_activa' => $detail['nominal_sum_aktiva'],
            'sum_pasiva' => $detail['nominal_sum_pasiva'],
            'laba' => $detail['nominal_laba_th_berjalan']
        ];

        // echo '<pre>';
        // print_r($data);
        // echo '</pre>';
        // exit;

        // $this->load->view('index', $data);

        $this->load->view('neraca', $data);
    }

    public function showLRTersimpan($slug)
    {
        // print_r($slug);
        // exit;
        $nip = $this->session->userdata('nip');

        // Fetch counts
        $result = $this->db->query("SELECT COUNT(Id) FROM memo WHERE (nip_kpd LIKE '%$nip%' OR nip_cc LIKE '%$nip%') AND (`read` NOT LIKE '%$nip%');")->row()->{'COUNT(Id)'};
        $result2 = $this->db->query("SELECT COUNT(id) FROM task WHERE (`member` LIKE '%$nip%' or `pic` LIKE '%$nip%') AND activity='1'")->row()->{'COUNT(id)'};

        $detail = $this->m_coa->showNeraca($slug);

        $data = [
            'title' => 'L/R tersimpan',
            'count_inbox' => $result,
            'count_inbox2' => $result2,
            // 'pages' => 'pages/financial/v_labarugi',
            'pendapatan' => json_decode($detail['pendapatan']),
            'biaya' => json_decode($detail['biaya']),
            'neraca' => $detail['nominal_sum_aktiva'] - $detail['nominal_sum_pasiva'],
            'sum_pendapatan' => $detail['nominal_sum_pendapatan'],
            'sum_biaya' => $detail['nominal_sum_biaya'],
            'selisih' => $detail['nominal_selisih']
        ];

        // echo '<pre>';
        // print_r($data);
        // echo '</pre>';
        // exit;

        // $this->load->view('index', $data);

        $this->load->view('laba_rugi', $data);
    }

    public function coa_report()
    {
        $nip = $this->session->userdata('nip');

        // Fetch counts
        $result = $this->db->query("SELECT COUNT(Id) FROM memo WHERE (nip_kpd LIKE '%$nip%' OR nip_cc LIKE '%$nip%') AND (`read` NOT LIKE '%$nip%');")->row()->{'COUNT(Id)'};
        $result2 = $this->db->query("SELECT COUNT(id) FROM task WHERE (`member` LIKE '%$nip%' or `pic` LIKE '%$nip%') AND activity='1'")->row()->{'COUNT(id)'};

        $data = [
            'count_inbox' => $result,
            'count_inbox2' => $result2,
            'coas' => $this->m_coa->list_coa(),
        ];

        $no_coa = $this->input->post('no_coa');


        if ($no_coa) {
            $this->prepareCoaReport($data, $no_coa);
        } else {
            $data['title'] = "Report CoA";
            // $data['pages'] = "pages/financial/v_report_per_coa";

            $this->load->view('report_per_coa', $data);
        }
    }

    private function prepareNeracaReport(&$data)
    {
        $data['activa'] = $this->m_coa->getNeraca('t_coa_sbb', 'AKTIVA');
        $data['pasiva'] = $this->m_coa->getPasivaWithLaba('t_coa_sbb');

        $total_pasiva = array_sum(array_column($data['pasiva'], 'nominal'));
        $data['pendapatan'] = $this->m_coa->getSumNeraca('t_coalr_sbb', 'PASIVA')['nominal'];
        $data['beban'] = $this->m_coa->getSumNeraca('t_coalr_sbb', 'AKTIVA')['nominal'];

        $data['laba'] = $data['pendapatan'] - $data['beban'];
        $data['sum_activa'] = $this->m_coa->getSumNeraca('t_coa_sbb', 'AKTIVA')['nominal'];
        $data['sum_pasiva'] = $data['laba'] + $total_pasiva;
        $data['neraca'] = $data['sum_pasiva'] - $data['sum_activa'];

        $this->load->view('neraca', $data);
    }

    private function prepareLabaRugiReport(&$data)
    {
        $data['biaya'] = $this->m_coa->getNeraca('t_coalr_sbb', 'AKTIVA');
        $data['pendapatan'] = $this->m_coa->getNeraca('t_coalr_sbb', 'PASIVA');

        $data['sum_biaya'] = $this->m_coa->getSumNeraca('t_coalr_sbb', 'AKTIVA')['nominal'];
        $data['sum_pendapatan'] = $this->m_coa->getSumNeraca('t_coalr_sbb', 'PASIVA')['nominal'];

        $this->load->view('laba_rugi', $data);
    }

    private function prepareCoaReport(&$data, $no_coa)
    {
        $from = $this->input->post('tgl_dari');
        $to = $this->input->post('tgl_sampai');
        $kode_cabang = $this->session->userdata('kode_cabang');
        // return $this->cb->where('id_cabang', $kode_cabang);

        // // Saldo awal periode sebelumnya
        // $last_periode = new DateTime($from);
        // $last_periode->modify('-1 month');
        // $last_periode = $last_periode->format('Y-m');
        // $coaBefore = $this->cb->where('id_cabang', $kode_cabang)
        //     ->where('periode', $last_periode)
        //     ->get('saldo_awal')
        //     ->row_array();

        // $coaBefore = $coaBefore['coa'] ?? null; // Pastikan tidak error jika NULL

        // $coa = json_decode($coaBefore);
        // $saldo_awal = null;

        // echo '<pre>';
        // print_r($coa);
        // echo '</pre>';
        // exit;
        // Iterasi untuk mencari saldo awal
        // if ($coa) {
        //     foreach ($coa as $item) {
        //         if ($item->no_sbb == $no_coa) {
        //             $saldo_awal = $item->saldo_awal;
        //             break;
        //         }
        //     }
        // }

        // // Hitung transaksi dari 1-14 November
        // $mid_start = (new DateTime($from))->modify('first day of this month')->format('Y-m-d');
        // $mid_end = (new DateTime($from))->modify('-1 day')->format('Y-m-d');

        // $transactions_before = $this->m_coa->getCoaReport($no_coa, $mid_start, $mid_end);
        // foreach ($transactions_before as $trans) {
        //     if ($trans->akun_debit == $no_coa) {
        //         $saldo_awal += $trans->jumlah_debit;
        //     } else {
        //         $saldo_awal -= $trans->jumlah_kredit;
        //     }
        // }

        // Set saldo awal untuk 15 November
        // $data['saldo_awal'] = ($saldo_awal) ? $saldo_awal : 0;
        // print_r($saldo_awal);
        // exit;

        // Hitung transaksi dari 15 November - 31 Desember
        $data['coa'] = $this->m_coa->getCoaReport($no_coa, $from, $to);

        $data['sum_debit'] = array_sum(array_map(function ($sum) use ($no_coa) {
            return $sum->akun_debit == $no_coa ? $sum->jumlah_debit : 0;
        }, $data['coa']));

        $data['sum_kredit'] = array_sum(array_map(function ($sum) use ($no_coa) {
            return $sum->akun_kredit == $no_coa ? $sum->jumlah_kredit : 0;
        }, $data['coa']));

        $data['detail_coa'] = $this->m_coa->getCoa($no_coa);

        $this->load->view('report_per_coa', $data);
    }


    public function simpanNeraca()
    {
        // print_r($this->input->post('keterangan'));
        // exit;

        $max_num = $this->m_coa->select_max('neraca');

        if (!$max_num['max']) {
            $bilangan = 1; // Nilai Proses
        } else {
            $bilangan = $max_num['max'] + 1;
        }

        $no_urut = sprintf("%06d", $bilangan);
        $slug = "NR-" . $no_urut;

        $nip = $this->session->userdata('nip');
        // Fetch counts
        $result = $this->db->query("SELECT COUNT(Id) FROM memo WHERE (nip_kpd LIKE '%$nip%' OR nip_cc LIKE '%$nip%') AND (`read` NOT LIKE '%$nip%');")->row()->{'COUNT(Id)'};
        $result2 = $this->db->query("SELECT COUNT(id) FROM task WHERE (`member` LIKE '%$nip%' or `pic` LIKE '%$nip%') AND activity='1'")->row()->{'COUNT(id)'};

        $data = [
            'count_inbox' => $result,
            'count_inbox2' => $result2,
        ];

        $this->prepareNeracaReport($data);

        $json_activa = json_encode($data['activa']);
        $json_pasiva = json_encode($data['pasiva']);

        $insert = [
            'tanggal_simpan' => date('Y-m-d H:i:s'),
            'jenis' => 'neraca',
            'aktiva' => $json_activa,
            'pasiva' => $json_pasiva,
            'nominal_pendapatan' => $data['pendapatan'],
            'nominal_beban' => $data['beban'],
            'nominal_laba_th_berjalan' => $data['laba'],
            'nominal_sum_aktiva' => $data['sum_activa'],
            'nominal_sum_pasiva' => $data['sum_pasiva'],
            'nominal_selisih' => $data['neraca'],
            'created_by' => $this->session->userdata('nip'),
            'keterangan' => trim($this->input->post('keterangan')),
            'no_urut' => $no_urut,
            'slug' => $slug,
        ];

        if ($this->m_coa->simpanLaporan($insert)) {
            $this->session->set_flashdata('message_name', 'Laporan neraca berhasil disimpan.');
        } else {
            $this->session->set_flashdata('message_error', 'Laporan neraca gagal tersimpan.');
        }

        redirect($_SERVER['HTTP_REFERER']);
    }

    public function simpanLR()
    {
        $max_num = $this->m_coa->select_max('labarugi');

        if (!$max_num['max']) {
            $bilangan = 1; // Nilai Proses
        } else {
            $bilangan = $max_num['max'] + 1;
        }

        $no_urut = sprintf("%06d", $bilangan);
        $slug = "LR-" . $no_urut;
        // header('Content-Type: application/json');
        $nip = $this->session->userdata('nip');
        // Fetch counts
        $result = $this->db->query("SELECT COUNT(Id) FROM memo WHERE (nip_kpd LIKE '%$nip%' OR nip_cc LIKE '%$nip%') AND (`read` NOT LIKE '%$nip%');")->row()->{'COUNT(Id)'};
        $result2 = $this->db->query("SELECT COUNT(id) FROM task WHERE (`member` LIKE '%$nip%' or `pic` LIKE '%$nip%') AND activity='1'")->row()->{'COUNT(id)'};

        $data = [
            'count_inbox' => $result,
            'count_inbox2' => $result2,
        ];

        $this->prepareLabaRugiReport($data);

        $json_biaya = json_encode($data['biaya']);
        $json_pendapatan = json_encode($data['pendapatan']);
        $selisih = $data['sum_pendapatan'] - $data['sum_biaya'];

        $insert = [
            'tanggal_simpan' => date('Y-m-d H:i:s'),
            'jenis' => 'labarugi',
            'biaya' => $json_biaya,
            'pendapatan' => $json_pendapatan,
            'nominal_sum_biaya' => $data['sum_biaya'],
            'nominal_sum_pendapatan' => $data['sum_pendapatan'],
            'nominal_selisih' => $selisih,
            'created_by' => $this->session->userdata('nip'),
            'keterangan' => trim($this->input->post('keterangan')),
            'no_urut' => $no_urut,
            'slug' => $slug,
        ];
        // echo '<pre>';
        // print_r($insert);
        // echo '</pre>';
        // exit;

        if ($this->m_coa->simpanLaporan($insert)) {
            $this->session->set_flashdata('message_name', 'Laporan laba rugi berhasil disimpan.');
        } else {
            $this->session->set_flashdata('message_error', 'Laporan laba rugi gagal tersimpan.');
        }

        redirect($_SERVER['HTTP_REFERER']);
    }

    public function neraca_tersimpan()
    {
        $keyword = trim($this->input->post('keyword', true) ?? '');

        $config = [
            'base_url' => site_url('financial/neraca_tersimpan'),
            'total_rows' => $this->m_coa->count_laporan('neraca'),
            'per_page' => 20,
            'uri_segment' => 3,
            'num_links' => 10,
            'full_tag_open' => '<ul class="pagination" style="margin: 0 0">',
            'full_tag_close' => '</ul>',
            'first_link' => false,
            'last_link' => false,
            'first_tag_open' => '<li>',
            'first_tag_close' => '</li>',
            'prev_link' => '«',
            'prev_tag_open' => '<li class="prev">',
            'prev_tag_close' => '</li>',
            'next_link' => '»',
            'next_tag_open' => '<li>',
            'next_tag_close' => '</li>',
            'last_tag_open' => '<li>',
            'last_tag_close' => '</li>',
            'cur_tag_open' => '<li class="active"><a href="#">',
            'cur_tag_close' => '</a></li>',
            'num_tag_open' => '<li>',
            'num_tag_close' => '</li>'
        ];

        $this->pagination->initialize($config);

        $page = $this->uri->segment(3) ? $this->uri->segment(3) : 0;
        $neraca = $this->m_coa->list_laporan('neraca', $config["per_page"], $page);

        $nip = $this->session->userdata('nip');
        $sql = "SELECT COUNT(Id) FROM memo WHERE (nip_kpd LIKE '%$nip%' OR nip_cc LIKE '%$nip%') AND (`read` NOT LIKE '%$nip%');";
        $query = $this->db->query($sql);
        $result = $query->row_array()['COUNT(Id)'];

        $sql2 = "SELECT COUNT(id) FROM task WHERE (`member` LIKE '%$nip%' or `pic` like '%$nip%') and activity='1'";
        $query2 = $this->db->query($sql2);
        $result2 = $query2->row_array()['COUNT(id)'];

        $data = [
            'page' => $page,
            'neraca' => $neraca,
            'count_inbox' => $result,
            'count_inbox2' => $result2,
            'coa' => $this->m_coa->list_coa(),
            'keyword' => $keyword,
            'title' => "Neraca tersimpan",
            'pages' => "pages/financial/v_neraca_tersimpan"
        ];

        $this->load->view('neraca_tersimpan', $data);
    }

    public function lr_tersimpan()
    {
        $keyword = trim($this->input->post('keyword', true) ?? '');

        $config = [
            'base_url' => site_url('financial/laba_tersimpan'),
            'total_rows' => $this->m_coa->count_laporan('labarugi'),
            'per_page' => 20,
            'uri_segment' => 3,
            'num_links' => 10,
            'full_tag_open' => '<ul class="pagination" style="margin: 0 0">',
            'full_tag_close' => '</ul>',
            'first_link' => false,
            'last_link' => false,
            'first_tag_open' => '<li>',
            'first_tag_close' => '</li>',
            'prev_link' => '«',
            'prev_tag_open' => '<li class="prev">',
            'prev_tag_close' => '</li>',
            'next_link' => '»',
            'next_tag_open' => '<li>',
            'next_tag_close' => '</li>',
            'last_tag_open' => '<li>',
            'last_tag_close' => '</li>',
            'cur_tag_open' => '<li class="active"><a href="#">',
            'cur_tag_close' => '</a></li>',
            'num_tag_open' => '<li>',
            'num_tag_close' => '</li>'
        ];

        $this->pagination->initialize($config);

        $page = $this->uri->segment(3) ? $this->uri->segment(3) : 0;
        $neraca = $this->m_coa->list_laporan('labarugi', $config["per_page"], $page);

        $nip = $this->session->userdata('nip');
        $sql = "SELECT COUNT(Id) FROM memo WHERE (nip_kpd LIKE '%$nip%' OR nip_cc LIKE '%$nip%') AND (`read` NOT LIKE '%$nip%');";
        $query = $this->db->query($sql);
        $result = $query->row_array()['COUNT(Id)'];

        $sql2 = "SELECT COUNT(id) FROM task WHERE (`member` LIKE '%$nip%' or `pic` like '%$nip%') and activity='1'";
        $query2 = $this->db->query($sql2);
        $result2 = $query2->row_array()['COUNT(id)'];

        $data = [
            'page' => $page,
            'neraca' => $neraca,
            'count_inbox' => $result,
            'count_inbox2' => $result2,
            'coa' => $this->m_coa->list_coa(),
            'keyword' => $keyword,
            'title' => "L/R tersimpan",
            'pages' => "pages/financial/v_lr_tersimpan"
        ];

        $this->load->view('lr_tersimpan', $data);
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

    private function log_pembayaran($jenis, $id_invoice, $nominal, $keterangan)
    {
        $data = [
            'kategori_pembayaran' => $jenis,
            'id_invoice' => $id_invoice,
            'nominal_bayar' => $nominal,
            'keterangan' => $keterangan,
            'user_input' => $this->session->userdata('nip'),
        ];

        $this->m_invoice->addLogPayment($data);
    }

    public function void_invoice()
    {
        $no_inv = $this->uri->segment(3);

        $inv =  $this->m_invoice->show($no_inv);
        $coa_persediaan = $inv['coa_persediaan'];
        $jenis = $inv['jenis_invoice'];
        $keterangan = $this->input->post('keterangan');
        $total_biaya = $inv['total_biaya'];
        $nominal_pendapatan = $inv['nominal_pendapatan'];
        $tgl_void = date('Y-m-d');

        $data_void = [
            'status_void' => '1',
            'alasan_void' => $keterangan,
            'tanggal_void' => $tgl_void
        ];

        if ($inv) {
            // update 24 Juni 2024 jam 17:07

            $this->posting($inv['coa_kredit'], $inv['coa_debit'], $keterangan, $nominal_pendapatan, $tgl_void);

            $this->m_invoice->update_invoice($inv['Id'], $data_void);

            $this->session->set_flashdata('message_name', 'The invoice has been successfully void. ' . $no_inv);
            // After that you need to used redirect function instead of load view such as 
            redirect("financial/invoice");
        }
    }

    public function list_coa()
    {
        $keyword = ($this->input->post('keyword')) ? trim($this->input->post('keyword')) : (($this->session->userdata('search')) ? $this->session->userdata('search') : '');
        if ($keyword === null) $keyword = $this->session->userdata('search');
        else $this->session->set_userdata('search', $keyword);

        $config = [
            'base_url' => site_url('financial/list_coa'),
            'total_rows' => $this->m_coa->count($keyword, 'v_coa_all'),
            'per_page' => 25,
            'uri_segment' => 3,
            'num_links' => 1,
            'full_tag_open' => '<ul class="pagination" style="margin: 0 0">',
            'full_tag_close' => '</ul>',
            'first_link' => true,
            'last_link' => true,
            'first_tag_open' => '<li>',
            'first_tag_close' => '</li>',
            'first_link' => 'First',
            'prev_link' => '«',
            'prev_tag_open' => '<li class="prev">',
            'prev_tag_close' => '</li>',
            'next_link' => '»',
            'last_link' => 'Last',
            'next_tag_open' => '<li>',
            'next_tag_close' => '</li>',
            'last_tag_open' => '<li>',
            'last_tag_close' => '</li>',
            'cur_tag_open' => '<li class="active"><a href="#">',
            'cur_tag_close' => '</a></li>',
            'num_tag_open' => '<li>',
            'num_tag_close' => '</li>',
            'use_page_numbers' => TRUE,
            // 'enable_query_strings' => TRUE,
            // 'page_query_string' => TRUE,
            // 'query_string_segment' => 'page'
        ];


        $this->pagination->initialize($config);

        $page = $this->uri->segment(3) ? ($this->uri->segment(3) - 1) * $config['per_page'] : 0;
        // $invoices = $this->m_invoice->list_invoice($config["per_page"], $page, $keyword);
        $coa = $this->m_coa->list_coa_paginate($config["per_page"], $page, $keyword);

        $nip = $this->session->userdata('nip');
        $sql = "SELECT COUNT(Id) FROM memo WHERE (nip_kpd LIKE '%$nip%' OR nip_cc LIKE '%$nip%') AND (`read` NOT LIKE '%$nip%');";
        $query = $this->db->query($sql);
        $result = $query->row_array()['COUNT(Id)'];

        $sql2 = "SELECT COUNT(id) FROM task WHERE (`member` LIKE '%$nip%' or `pic` like '%$nip%') and activity='1'";
        $query2 = $this->db->query($sql2);
        $result2 = $query2->row_array()['COUNT(id)'];

        $data = [
            'page' => $page,
            'coa' => $coa,
            'count_inbox' => $result,
            'count_inbox2' => $result2,
            'keyword' => $keyword,
            'title' => "List CoA",
        ];

        $this->load->view('list_coa', $data);
    }

    public function tambahCoa()
    {
        $no_bb = $this->input->post('no_bb');
        $no_sbb = $this->input->post('no_sbb');
        $nama_coa = $this->input->post('nama_coa');

        $cek_no_sbb = $this->m_coa->isAvailable('no_sbb', $no_sbb);
        $cek_nama_coa = $this->m_coa->isAvailable('nama_perkiraan', $nama_coa);

        if ($cek_no_sbb) {
            $this->session->set_flashdata('message_error', 'No. ' . $no_sbb . ' sudah ada');
            redirect($_SERVER['HTTP_REFERER']);
        } else if ($cek_nama_coa) {
            $this->session->set_flashdata('message_error', 'CoA ' . $nama_coa . ' sudah ada');
            redirect($_SERVER['HTTP_REFERER']);
        } else {

            $substr_coa = substr($no_sbb, 0, 1);

            if ($substr_coa == "1" || $substr_coa == "5" || $substr_coa == "6" || $substr_coa == "7" || $substr_coa == "5" || $substr_coa == "6") {
                $posisi = 'AKTIVA';
            } else {
                $posisi = 'PASIVA';
            }

            // cek tabel
            if ($substr_coa == "1" || $substr_coa == "2" || $substr_coa == "3") {
                $tabel = "t_coa_sbb";

                $data = [
                    'no_bb' => $no_bb,
                    'no_sbb' => $no_sbb,
                    'nama_perkiraan' => $nama_coa,
                    'posisi' => $posisi,
                    'id_cabang' => $this->session->userdata('kode_cabang'),
                ];
            } else if ($substr_coa == "4" || $substr_coa == "5" || $substr_coa == "6" || $substr_coa == "7" || $substr_coa == "8" || $substr_coa == "9") {
                $tabel = "t_coalr_sbb";
                $data = [
                    'no_lr_bb' => $no_bb,
                    'no_lr_sbb' => $no_sbb,
                    'nama_perkiraan' => $nama_coa,
                    'posisi' => $posisi,
                    'id_cabang' => $this->session->userdata('kode_cabang'),
                ];
            } else {
                $this->session->set_flashdata('message_error', 'Format nomor CoA ' . $no_sbb . ' tidak sesuai.');
                redirect($_SERVER['HTTP_REFERER']);
            }


            $this->cb->trans_begin();

            $query = $this->cb->insert($tabel, $data);

            if ($query) {
                $this->cb->trans_commit();
                $this->session->set_flashdata('message_name', 'CoA ' . $no_sbb . ' berhasil ditambahkan.');
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $this->cb->trans_rollback();
                $this->session->set_flashdata('message_error', 'CoA ' . $no_sbb . ' gagal disimpan. Ket:' . $this->cb->error());
                redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }

    public function outstanding()
    {
        $nip = $this->session->userdata('nip');

        // Fetch counts
        $result = $this->db->query("SELECT COUNT(Id) FROM memo WHERE (nip_kpd LIKE '%$nip%' OR nip_cc LIKE '%$nip%') AND (`read` NOT LIKE '%$nip%');")->row()->{'COUNT(Id)'};
        $result2 = $this->db->query("SELECT COUNT(id) FROM task WHERE (`member` LIKE '%$nip%' or `pic` LIKE '%$nip%') AND activity='1'")->row()->{'COUNT(id)'};


        $data = [
            'title' => 'Outstanding',
            'count_inbox' => $result,
            'count_inbox2' => $result2,
            'outstanding' => $this->m_invoice->outstanding_agent(),
        ];

        $this->load->view('outstanding', $data);
    }

    public function closing($slug = NULL)
    {
        $nip = $this->session->userdata('nip');

        // Fetch counts using CodeIgniter's query builder to prevent SQL injection
        $this->db->select('COUNT(Id) as count');
        $this->db->from('memo');
        $this->db->where("(nip_kpd LIKE '%$nip%' OR nip_cc LIKE '%$nip%')");
        $this->db->where("`read` NOT LIKE '%$nip%'");
        $result = $this->db->get()->row()->count;

        $this->db->select('COUNT(id) as count');
        $this->db->from('task');
        $this->db->where("(`member` LIKE '%$nip%' OR `pic` LIKE '%$nip%')");
        $this->db->where('activity', '1');
        $result2 = $this->db->get()->row()->count;

        $data = [
            'count_inbox' => $result,
            'count_inbox2' => $result2,
        ];

        if ($slug) {
            $data['title'] = "Detail saldo";

            $data['saldo'] = $this->m_coa->get_saldo_awal($slug);

            $data['coa'] = json_decode($data['saldo']['coa']);

            $this->load->view('saldo_view', $data);
        } else if ($this->input->post('periode')) {
            $data['title'] = "Detail saldo";

            $data['saldo'] = $this->m_coa->get_saldo_awal($this->input->post('periode'));

            $data['coa'] = json_decode($data['saldo']['coa']);

            $this->load->view('saldo_view', $data);
        } else {

            $data['title'] = "Saldo awal";

            $data['saldo'] = $this->m_coa->list_saldo();

            // echo '<pre>';
            // print_r($data['saldo']);
            // echo '</pre>';
            // exit;


            $this->load->view('saldo_awal', $data);
        }
    }

    public function save_saldo_awal()
    {
        $periode = $this->input->post('periode');

        $cek = $this->m_coa->cek_saldo_awal($periode);

        $date = new DateTime($periode);

        $bulan = $date->format('m');
        $tahun = $date->format('Y');

        $last_periode = new DateTime($periode);
        $last_periode = $last_periode->modify('-1 month');
        $last_periode = $last_periode->format('Y-m');

        $getLastPeriod = $this->m_coa->cek_saldo_awal($last_periode);

        if (empty($getLastPeriod)) {
            $updated_saldo_awal = $this->m_coa->calculate_saldo_awal($bulan, $tahun);
        } else {
            $coaLastPeriod = json_decode($getLastPeriod['coa']);
            $saldo_bulan_ini = $this->m_coa->calculate_saldo_awal($bulan, $tahun);

            $saldo_awal_map = [];
            foreach ($coaLastPeriod as $saldo_awal) {
                $saldo_awal_map[$saldo_awal->no_sbb] = $saldo_awal;
            }

            foreach ($saldo_bulan_ini as $saldo_baru) {
                if (isset($saldo_awal_map[$saldo_baru->no_sbb])) {
                    $saldo_awal_map[$saldo_baru->no_sbb]->saldo_awal += (float) $saldo_baru->saldo_awal;
                } else {
                    $saldo_awal_map[$saldo_baru->no_sbb] = (object) [
                        'no_sbb' => $saldo_baru->no_sbb,
                        'saldo_awal' => (float) $saldo_baru->saldo_awal,
                        'posisi' => $saldo_baru->posisi,
                        'table_source' => $saldo_baru->table_source,
                    ];
                }
            }
            $updated_saldo_awal = array_values($saldo_awal_map);
        }

        $nextMonth = ($date->modify('+1 month'));
        $nextMonth = $date->format('Y-m');

        $data = [
            'periode' => $periode,
            'created_by' => $this->session->userdata('nip'),
            'created_at' => date('Y-m-d H:i:s'),
            'slug' => 'saldo-awal-' . $nextMonth,
            'coa' => json_encode($updated_saldo_awal),
            'keterangan' => 'Saldo awal ' . format_indo($nextMonth),
            'id_cabang' => $this->session->userdata('kode_cabang')
        ];

        if (!$cek) {
            $this->m_coa->insert_saldo_awal($data);
            $this->session->set_flashdata('message_name', 'Closing bulan ' . format_indo($periode) . 'Saldo awal periode ' . format_indo($nextMonth) . ' berhasil ditetapkan');
        } else {
            $this->m_coa->update_saldo_awal($periode, $data);
            $this->session->set_flashdata('message_name', 'Closing bulan ' . format_indo($periode) . ' sudah diperbarui');
        }

        redirect($_SERVER['HTTP_REFERER']);
    }

    public function reportByDate()
    {
        $button_sbm = $this->input->post('button_sbm');
        $nip = $this->session->userdata('nip');

        // Fetch counts
        $result = $this->db->query("SELECT COUNT(Id) FROM memo WHERE (nip_kpd LIKE '%$nip%' OR nip_cc LIKE '%$nip%') AND (`read` NOT LIKE '%$nip%');")->row()->{'COUNT(Id)'};
        $result2 = $this->db->query("SELECT COUNT(id) FROM task WHERE (`member` LIKE '%$nip%' or `pic` LIKE '%$nip%') AND activity='1'")->row()->{'COUNT(id)'};

        $per_tanggal = ($this->input->post('per_tanggal') ? $this->input->post('per_tanggal') : date('Y-m-d'));

        $data = [
            'count_inbox' => $result,
            'count_inbox2' => $result2,
            'per_tanggal' => $per_tanggal
        ];

        $jenis_laporan = $this->input->post('jenis_laporan');

        if ($jenis_laporan) {
            if ($jenis_laporan == "neraca") {
                $this->prepareNeracaReportByDate($data, $per_tanggal, $button_sbm);
            } else if ($jenis_laporan == "laba_rugi") {
                $this->prepareLabaRugiReportByDate($data, $per_tanggal, $button_sbm);
            } else if ($jenis_laporan == "neraca_bb") {
                $this->prepareNeracaBbReportByDate($data, $per_tanggal, $button_sbm);
            } else if ($jenis_laporan == "lr_bb") {
                $this->prepareLrBbReportByDate($data, $per_tanggal, $button_sbm);
            } else if ($jenis_laporan == "neraca_monthly") {
                $this->prepareNeracaMonthly($data, $per_tanggal, $button_sbm);
            } else if ($jenis_laporan == "lr_monthly") {
                $this->prepareLabaRugiMonthly($data, $per_tanggal, $button_sbm);
            }
        } else {
            $this->prepareNeracaReportByDate($data, $per_tanggal);
        }
    }

    private function prepareNeracaReportByDate($data, $tanggal, $button_sbm = null)
    {
        $date = new DateTime($tanggal);

        $date->modify('first day of previous month');
        $periode = $date->format('Y-m');

        $cek = $this->m_coa->cek_saldo_awal($periode);

        if ($cek) {
            $coaLastPeriod = json_decode($cek['coa']);
            $filteredCoaAktiva = array_filter($coaLastPeriod, function ($item) {
                return $item->posisi === 'AKTIVA' && $item->table_source === 't_coa_sbb';
            });

            $activa = $this->m_coa->getNeracaByDate('t_coa_sbb', 'AKTIVA', $tanggal, $periode);
            $pasiva = $this->m_coa->getNeracaByDate('t_coa_sbb', 'PASIVA', $tanggal, $periode);
            $pendapatan = $this->m_coa->getNeracaByDate('t_coalr_sbb', 'PASIVA', $tanggal, $periode);
            $beban = $this->m_coa->getNeracaByDate('t_coalr_sbb', 'AKTIVA', $tanggal, $periode);

            // Part Aktiva
            $combinedActiva = [];

            foreach ($activa as $item) {
                if (!isset($combinedActiva[$item->no_sbb])) {
                    $combinedActiva[$item->no_sbb] = (object) [
                        'no_sbb' => $item->no_sbb,
                        'saldo_awal' => $item->saldo_awal,
                    ];
                } else {
                    $combinedActiva[$item->no_sbb]->saldo_awal += $item->saldo_awal;
                }
            }

            foreach ($filteredCoaAktiva as $item) {
                if (!isset($combinedActiva[$item->no_sbb])) {
                    $combinedActiva[$item->no_sbb] = (object) [
                        'no_sbb' => $item->no_sbb,
                        'saldo_awal' => $item->saldo_awal,
                    ];
                } else {
                    $combinedActiva[$item->no_sbb]->saldo_awal += $item->saldo_awal;
                }
            }

            usort($combinedActiva, function ($a, $b) {
                return strcmp($a->no_sbb, $b->no_sbb);
            });
            $total_activa = array_sum(array_column($combinedActiva, 'saldo_awal'));

            // Part Pasiva
            $filteredCoaPasiva = array_filter($coaLastPeriod, function ($item) {
                return $item->posisi === 'PASIVA' && $item->table_source === 't_coa_sbb';
            });

            $combinedPasiva = [];

            foreach ($pasiva as $item) {
                if (!isset($combinedPasiva[$item->no_sbb])) {
                    $combinedPasiva[$item->no_sbb] = (object) [
                        'no_sbb' => $item->no_sbb,
                        'saldo_awal' => $item->saldo_awal,
                    ];
                } else {
                    $combinedPasiva[$item->no_sbb]->saldo_awal += $item->saldo_awal;
                }
            }
            foreach ($filteredCoaPasiva as $item) {
                if (!isset($combinedPasiva[$item->no_sbb])) {
                    $combinedPasiva[$item->no_sbb] = (object) [
                        'no_sbb' => $item->no_sbb,
                        'saldo_awal' => $item->saldo_awal,
                    ];
                } else {
                    $combinedPasiva[$item->no_sbb]->saldo_awal += $item->saldo_awal;
                }
            }

            usort($combinedPasiva, function ($a, $b) {
                return strcmp($a->no_sbb, $b->no_sbb);
            });
            $total_pasiva = array_sum(array_column($combinedPasiva, 'saldo_awal'));

            // Part Pendapatan
            $filteredCoaPendapatan = array_filter($coaLastPeriod, function ($item) {
                return $item->posisi === 'PASIVA' && $item->table_source === 't_coalr_sbb';
            });
            $combinedPendapatan = [];

            foreach ($pendapatan as $item) {
                if (!isset($combinedPendapatan[$item->no_sbb])) {
                    $combinedPendapatan[$item->no_sbb] = (object) [
                        'no_sbb' => $item->no_sbb,
                        'saldo_awal' => $item->saldo_awal,
                    ];
                } else {
                    $combinedPendapatan[$item->no_sbb]->saldo_awal += $item->saldo_awal;
                }
            }
            foreach ($filteredCoaPendapatan as $item) {
                if (!isset($combinedPendapatan[$item->no_sbb])) {
                    $combinedPendapatan[$item->no_sbb] = (object) [
                        'no_sbb' => $item->no_sbb,
                        'saldo_awal' => $item->saldo_awal,
                    ];
                } else {
                    $combinedPendapatan[$item->no_sbb]->saldo_awal += $item->saldo_awal;
                }
            }
            $total_pendapatan = array_sum(array_column($combinedPendapatan, 'saldo_awal'));

            // Part Beban
            $filteredCoaBeban = array_filter($coaLastPeriod, function ($item) {
                return $item->posisi === 'AKTIVA' && $item->table_source === 't_coalr_sbb';
            });

            $combinedBeban = [];

            foreach ($beban as $item) {
                if (!isset($combinedBeban[$item->no_sbb])) {
                    $combinedBeban[$item->no_sbb] = (object) [
                        'no_sbb' => $item->no_sbb,
                        'saldo_awal' => $item->saldo_awal,
                    ];
                } else {
                    $combinedBeban[$item->no_sbb]->saldo_awal += $item->saldo_awal;
                }
            }
            foreach ($filteredCoaBeban as $item) {
                if (!isset($combinedBeban[$item->no_sbb])) {
                    $combinedBeban[$item->no_sbb] = (object) [
                        'no_sbb' => $item->no_sbb,
                        'saldo_awal' => $item->saldo_awal,
                    ];
                } else {
                    $combinedBeban[$item->no_sbb]->saldo_awal += $item->saldo_awal;
                }
            }

            $total_beban = array_sum(array_column($combinedBeban, 'saldo_awal'));

            $laba = $total_pendapatan - $total_beban;
            $sum_pasiva = $total_pasiva + $laba;

            $data['activa'] = $combinedActiva;
            $data['sum_activa'] = $total_activa;
            $data['pasiva'] = $combinedPasiva;
            $data['laba'] = $laba;
            $data['sum_pasiva'] = $sum_pasiva;
            $data['neraca'] = $sum_pasiva - $total_activa;
        } else {
            $this->session->set_flashdata('message_error', 'Closing bulan ' . format_indo($periode) . ' tidak ditemukan');
        }
        $data['title'] = 'Neraca per tanggal ' . format_indo($tanggal);
        $data['pages'] = 'pages/financial/v_neraca_by_date';

        if ($button_sbm == "excel") {
            require_once(APPPATH . 'libraries/PHPExcel/IOFactory.php');

            $excel = new PHPExcel();
            $sheet = $excel->getActiveSheet();

            $excel->getProperties()->setCreator('SLS')
                ->setLastModifiedBy('SLS')
                ->setTitle("Neraca SBB")
                ->setSubject("Neraca SBB")
                ->setDescription("Neraca SBB per tanggal " . format_indo($tanggal))
                ->setKeywords("Neraca SBB");

            // Merge cells untuk header utama
            $sheet->mergeCells('A1:G1');
            $sheet->mergeCells('A2:C2');
            $sheet->mergeCells('E2:G2');

            // Isi data header
            $sheet->setCellValue('A1', 'Neraca SBB per tanggal ' . format_indo($tanggal));
            $sheet->setCellValue('A2', 'AKTIVA');
            $sheet->setCellValue('E2', 'PASIVA');
            $sheet->setCellValue('B3', 'Total: ');
            $sheet->setCellValue('C3', $total_activa);
            $sheet->setCellValue('F3', 'Total: ');
            $sheet->setCellValue('G3', $sum_pasiva);

            // Buat sub-header untuk tabel
            $sheet->setCellValue('A4', 'No. CoA');
            $sheet->setCellValue('B4', 'Nama CoA');
            $sheet->setCellValue('C4', 'Nominal');
            $sheet->setCellValue('E4', 'No. CoA');
            $sheet->setCellValue('F4', 'Nama CoA');
            $sheet->setCellValue('G4', 'Nominal');
            // echo '<pre>';
            // print_r($combinedActiva);
            // echo '</pre>';
            // exit;

            // Tambahkan data Aktiva
            $numrowActiva = 5;
            foreach ($combinedActiva as $t) {
                $coa = $this->m_coa->getCoa($t->no_sbb);
                if ($coa['table_source'] == "t_coa_sbb" && $coa['posisi'] == 'AKTIVA' && $t->saldo_awal != 0) :
                    $sheet->setCellValue('A' . $numrowActiva, $t->no_sbb);
                    $sheet->setCellValue('B' . $numrowActiva, $coa['nama_perkiraan']);
                    $sheet->setCellValue('C' . $numrowActiva, $t->saldo_awal);
                    $numrowActiva++;
                endif;
            }

            // Tambahkan data Pasiva
            $numrowPasiva = 5;
            foreach ($combinedPasiva as $t) {
                $coa = $this->m_coa->getCoa($t->no_sbb);
                if ($coa['table_source'] == "t_coa_sbb" && $coa['posisi'] == 'PASIVA' && $t->saldo_awal != 0) :
                    $sheet->setCellValue('E' . $numrowPasiva, $t->no_sbb);
                    $sheet->setCellValue('F' . $numrowPasiva, $coa['nama_perkiraan']);
                    $sheet->setCellValue('G' . $numrowPasiva, $t->saldo_awal);
                    $numrowPasiva++;
                endif;
            }
            $sheet->setCellValue('E' . $numrowPasiva, '3103001');
            $sheet->setCellValue('F' . $numrowPasiva, 'LABA TAHUN BERJALAN');
            $sheet->setCellValue('G' . $numrowPasiva, $laba);

            // Set auto size untuk semua kolom
            foreach (range('A', 'G') as $columnID) {
                $sheet->getColumnDimension($columnID)->setAutoSize(true);
            }

            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="Neraca per tanggal ' . format_indo($tanggal) . '.xlsx"');
            header('Cache-Control: max-age=0');
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
            header('Cache-Control: cache, must-revalidate');
            header('Pragma: public');

            $objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
            $objWriter->save('php://output');
            exit;
        } else if ($button_sbm === "pdf") {
            $this->load->view('print_pdf_neraca_per_tanggal', $data);
        } else {
            $this->load->view('neraca_by_date', $data);
        }
    }

    private function prepareLabaRugiReportByDate($data, $tanggal, $button_sbm = null)
    {
        $date = new DateTime($tanggal);

        $date->modify('first day of previous month');
        $periode = $date->format('Y-m');

        $cek = $this->m_coa->cek_saldo_awal($periode);

        $data['total_pendapatan'] = 0;
        $data['sum_biaya'] = 0;
        $data['sum_pendapatan'] = 0;
        $data['biaya'] = [];
        $data['pendapatan'] = [];
        if ($cek) {
            $coaLastPeriod = json_decode($cek['coa']);

            $pendapatan = $this->m_coa->getNeracaByDate('t_coalr_sbb', 'PASIVA', $tanggal, $periode);
            $beban = $this->m_coa->getNeracaByDate('t_coalr_sbb', 'AKTIVA', $tanggal, $periode);

            // Part Pendapatan
            $filteredCoaPendapatan = array_filter($coaLastPeriod, function ($item) {
                return $item->posisi === 'PASIVA' && $item->table_source === 't_coalr_sbb';
            });
            $combinedPendapatan = [];

            foreach ($pendapatan as $item) {
                if (!isset($combinedPendapatan[$item->no_sbb])) {
                    $combinedPendapatan[$item->no_sbb] = (object) [
                        'no_sbb' => $item->no_sbb,
                        'saldo_awal' => $item->saldo_awal,
                    ];
                } else {
                    $combinedPendapatan[$item->no_sbb]->saldo_awal += $item->saldo_awal;
                }
            }
            foreach ($filteredCoaPendapatan as $item) {
                if (!isset($combinedPendapatan[$item->no_sbb])) {
                    $combinedPendapatan[$item->no_sbb] = (object) [
                        'no_sbb' => $item->no_sbb,
                        'saldo_awal' => $item->saldo_awal,
                    ];
                } else {
                    $combinedPendapatan[$item->no_sbb]->saldo_awal += $item->saldo_awal;
                }
            }

            usort($combinedPendapatan, function ($a, $b) {
                return strcmp($a->no_sbb, $b->no_sbb);
            });
            $total_pendapatan = array_sum(array_column($combinedPendapatan, 'saldo_awal'));

            // Part Beban
            $filteredCoaBeban = array_filter($coaLastPeriod, function ($item) {
                return $item->posisi === 'AKTIVA' && $item->table_source === 't_coalr_sbb';
            });

            $combinedBeban = [];

            foreach ($beban as $item) {
                if (!isset($combinedBeban[$item->no_sbb])) {
                    $combinedBeban[$item->no_sbb] = (object) [
                        'no_sbb' => $item->no_sbb,
                        'saldo_awal' => $item->saldo_awal,
                    ];
                } else {
                    $combinedBeban[$item->no_sbb]->saldo_awal += $item->saldo_awal;
                }
            }
            foreach ($filteredCoaBeban as $item) {
                if (!isset($combinedBeban[$item->no_sbb])) {
                    $combinedBeban[$item->no_sbb] = (object) [
                        'no_sbb' => $item->no_sbb,
                        'saldo_awal' => $item->saldo_awal,
                    ];
                } else {
                    $combinedBeban[$item->no_sbb]->saldo_awal += $item->saldo_awal;
                }
            }

            usort($combinedBeban, function ($a, $b) {
                return strcmp($a->no_sbb, $b->no_sbb);
            });
            $total_beban = array_sum(array_column($combinedBeban, 'saldo_awal'));

            $data['biaya'] = $combinedBeban;
            $data['pendapatan'] = $combinedPendapatan;
            $data['sum_biaya'] = $total_beban;
            $data['sum_pendapatan'] = $total_pendapatan;
            $data['total_pendapatan'] = $total_pendapatan - $total_beban;
        } else {
            $this->session->set_flashdata('message_error', 'Closing bulan ' . format_indo($periode) . ' tidak ditemukan');
        }

        // print_r($data['total_pendapatan']);
        // exit;
        $data['title'] = 'Laba rugi per tanggal ' . format_indo($tanggal);
        $data['pages'] = 'pages/financial/v_labarugi_by_date';

        if ($button_sbm == "excel") {
            require_once(APPPATH . 'libraries/PHPExcel/IOFactory.php');

            $excel = new PHPExcel();
            $sheet = $excel->getActiveSheet();

            $excel->getProperties()->setCreator('SLS')
                ->setLastModifiedBy('SLS')
                ->setTitle("Laba rugi SBB")
                ->setSubject("Laba rugi SBB")
                ->setDescription("Laba rugi SBB per tanggal " . format_indo($tanggal))
                ->setKeywords("Laba rugi SBB");

            // Merge cells untuk header utama
            $sheet->mergeCells('A1:G1');
            $sheet->mergeCells('A2:C2');
            $sheet->mergeCells('E2:G2');

            // Isi data header
            $sheet->setCellValue('A1', 'Laba rugi SBB per tanggal ' . format_indo($tanggal));
            $sheet->setCellValue('A2', 'BEBAN');
            $sheet->setCellValue('E2', 'PENDAPATAN');
            $sheet->setCellValue('B3', 'Total: ');
            $sheet->setCellValue('C3', $total_beban);
            $sheet->setCellValue('F3', 'Total: ');
            $sheet->setCellValue('G3', $total_pendapatan);

            // Buat sub-header untuk tabel
            $sheet->setCellValue('A4', 'No. CoA');
            $sheet->setCellValue('B4', 'Nama CoA');
            $sheet->setCellValue('C4', 'Nominal');
            $sheet->setCellValue('E4', 'No. CoA');
            $sheet->setCellValue('F4', 'Nama CoA');
            $sheet->setCellValue('G4', 'Nominal');

            // Tambahkan data Aktiva
            $numrowActiva = 5;
            foreach ($combinedBeban as $t) {
                $coa = $this->m_coa->getCoa($t->no_sbb);
                if ($coa['table_source'] == "t_coalr_sbb" && $coa['posisi'] == 'AKTIVA' && $t->saldo_awal != 0) :
                    $sheet->setCellValue('A' . $numrowActiva, $t->no_sbb);
                    $sheet->setCellValue('B' . $numrowActiva, $coa['nama_perkiraan']);
                    $sheet->setCellValue('C' . $numrowActiva, $t->saldo_awal);
                    $numrowActiva++;
                endif;
            }

            // Tambahkan data Pasiva
            $numrowPasiva = 5;
            foreach ($combinedPendapatan as $t) {
                $coa = $this->m_coa->getCoa($t->no_sbb);
                if ($coa['table_source'] == "t_coalr_sbb" && $coa['posisi'] == 'PASIVA' && $t->saldo_awal != 0) :
                    $sheet->setCellValue('E' . $numrowPasiva, $t->no_sbb);
                    $sheet->setCellValue('F' . $numrowPasiva, $coa['nama_perkiraan']);
                    $sheet->setCellValue('G' . $numrowPasiva, $t->saldo_awal);
                    $numrowPasiva++;
                endif;
            }

            // Set auto size untuk semua kolom
            foreach (range('A', 'G') as $columnID) {
                $sheet->getColumnDimension($columnID)->setAutoSize(true);
            }

            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="Laba rugi per tanggal ' . format_indo($tanggal) . '.xls"');
            header('Cache-Control: max-age=0');
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
            header('Cache-Control: cache, must-revalidate');
            header('Pragma: public');

            $objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
            $objWriter->save('php://output');
            exit;
        } else if ($button_sbm === "pdf") {
            $this->load->view('print_pdf_laba_rugi_per_tanggal', $data);
        } else {
            $this->load->view('laba_rugi_by_date', $data);
        }
    }

    private function prepareNeracaBbReportByDate($data, $tanggal, $button_sbm = null)
    {
        $date = new DateTime($tanggal);

        $date->modify('first day of previous month');
        $periode = $date->format('Y-m');

        $cek = $this->m_coa->cek_saldo_awal($periode);

        if ($cek) {
            $coaLastPeriod = json_decode($cek['coa']);
            $filteredCoaAktiva = array_filter($coaLastPeriod, function ($item) {
                return $item->posisi === 'AKTIVA' && $item->table_source === 't_coa_sbb';
            });

            $activa = $this->m_coa->getNeracaByDate('t_coa_sbb', 'AKTIVA', $tanggal, $periode);
            $pasiva = $this->m_coa->getNeracaByDate('t_coa_sbb', 'PASIVA', $tanggal, $periode);
            $pendapatan = $this->m_coa->getNeracaByDate('t_coalr_sbb', 'PASIVA', $tanggal, $periode);
            $beban = $this->m_coa->getNeracaByDate('t_coalr_sbb', 'AKTIVA', $tanggal, $periode);

            // Part Aktiva
            $combinedActiva = [];

            foreach ($activa as $item) {
                if (!isset($combinedActiva[$item->no_sbb])) {
                    $combinedActiva[$item->no_sbb] = (object) [
                        'no_sbb' => $item->no_sbb,
                        'saldo_awal' => $item->saldo_awal,
                    ];
                } else {
                    $combinedActiva[$item->no_sbb]->saldo_awal += $item->saldo_awal;
                }
            }

            foreach ($filteredCoaAktiva as $item) {
                if (!isset($combinedActiva[$item->no_sbb])) {
                    $combinedActiva[$item->no_sbb] = (object) [
                        'no_sbb' => $item->no_sbb,
                        'saldo_awal' => $item->saldo_awal,
                    ];
                } else {
                    $combinedActiva[$item->no_sbb]->saldo_awal += $item->saldo_awal;
                }
            }

            usort($combinedActiva, function ($a, $b) {
                return strcmp($a->no_sbb, $b->no_sbb);
            });
            $total_activa = array_sum(array_column($combinedActiva, 'saldo_awal'));

            // Part Pasiva
            $filteredCoaPasiva = array_filter($coaLastPeriod, function ($item) {
                return $item->posisi === 'PASIVA' && $item->table_source === 't_coa_sbb';
            });

            $combinedPasiva = [];

            foreach ($pasiva as $item) {
                if (!isset($combinedPasiva[$item->no_sbb])) {
                    $combinedPasiva[$item->no_sbb] = (object) [
                        'no_sbb' => $item->no_sbb,
                        'saldo_awal' => $item->saldo_awal,
                    ];
                } else {
                    $combinedPasiva[$item->no_sbb]->saldo_awal += $item->saldo_awal;
                }
            }
            foreach ($filteredCoaPasiva as $item) {
                if (!isset($combinedPasiva[$item->no_sbb])) {
                    $combinedPasiva[$item->no_sbb] = (object) [
                        'no_sbb' => $item->no_sbb,
                        'saldo_awal' => $item->saldo_awal,
                    ];
                } else {
                    $combinedPasiva[$item->no_sbb]->saldo_awal += $item->saldo_awal;
                }
            }

            usort($combinedPasiva, function ($a, $b) {
                return strcmp($a->no_sbb, $b->no_sbb);
            });
            $total_pasiva = array_sum(array_column($combinedPasiva, 'saldo_awal'));

            // Part Pendapatan
            $filteredCoaPendapatan = array_filter($coaLastPeriod, function ($item) {
                return $item->posisi === 'PASIVA' && $item->table_source === 't_coalr_sbb';
            });
            $combinedPendapatan = [];

            foreach ($pendapatan as $item) {
                if (!isset($combinedPendapatan[$item->no_sbb])) {
                    $combinedPendapatan[$item->no_sbb] = (object) [
                        'no_sbb' => $item->no_sbb,
                        'saldo_awal' => $item->saldo_awal,
                    ];
                } else {
                    $combinedPendapatan[$item->no_sbb]->saldo_awal += $item->saldo_awal;
                }
            }
            foreach ($filteredCoaPendapatan as $item) {
                if (!isset($combinedPendapatan[$item->no_sbb])) {
                    $combinedPendapatan[$item->no_sbb] = (object) [
                        'no_sbb' => $item->no_sbb,
                        'saldo_awal' => $item->saldo_awal,
                    ];
                } else {
                    $combinedPendapatan[$item->no_sbb]->saldo_awal += $item->saldo_awal;
                }
            }
            $total_pendapatan = array_sum(array_column($combinedPendapatan, 'saldo_awal'));

            // Part Beban
            $filteredCoaBeban = array_filter($coaLastPeriod, function ($item) {
                return $item->posisi === 'AKTIVA' && $item->table_source === 't_coalr_sbb';
            });

            $combinedBeban = [];

            foreach ($beban as $item) {
                if (!isset($combinedBeban[$item->no_sbb])) {
                    $combinedBeban[$item->no_sbb] = (object) [
                        'no_sbb' => $item->no_sbb,
                        'saldo_awal' => $item->saldo_awal,
                    ];
                } else {
                    $combinedBeban[$item->no_sbb]->saldo_awal += $item->saldo_awal;
                }
            }
            foreach ($filteredCoaBeban as $item) {
                if (!isset($combinedBeban[$item->no_sbb])) {
                    $combinedBeban[$item->no_sbb] = (object) [
                        'no_sbb' => $item->no_sbb,
                        'saldo_awal' => $item->saldo_awal,
                    ];
                } else {
                    $combinedBeban[$item->no_sbb]->saldo_awal += $item->saldo_awal;
                }
            }
            $total_beban = array_sum(array_column($combinedBeban, 'saldo_awal'));


            // Proses pengelompokan, penjumlahan, dan group-ing no_bb Aktiva
            $bbActiva = [];
            foreach ($combinedActiva as $item) {
                $key = substr($item->no_sbb, 0, 3);
                $bbActiva[$key] = ($bbActiva[$key] ?? 0) + $item->saldo_awal;
            }

            // Membentuk groupedActiva dan menghitung total saldo aktiva
            $groupedActiva = [];

            foreach ($bbActiva as $key => $saldo) {
                $groupedActiva[] = (object) ['no_bb' => $key, 'saldo_aktiva' => $saldo];
            }

            // Proses pengelompokan, penjumlahan, dan group-ing no_bb pasiva
            $bbPasiva = [];
            foreach ($combinedPasiva as $item) {
                $key = substr($item->no_sbb, 0, 3);
                $bbPasiva[$key] = ($bbPasiva[$key] ?? 0) + $item->saldo_awal;
            }

            // Membentuk groupedPasiva dan menghitung total saldo pasiva
            $groupedPasiva = [];

            foreach ($bbPasiva as $key => $saldo) {
                $groupedPasiva[] = (object) ['no_bb' => $key, 'saldo_pasiva' => $saldo];
            }



            $laba = $total_pendapatan - $total_beban;
            $sum_pasiva = $total_pasiva + $laba;
            $data['activa'] = $groupedActiva;
            $data['sum_activa'] = $total_activa;
            $data['pasiva'] = $groupedPasiva;
            $data['laba'] = $laba;
            $data['sum_pasiva'] = $sum_pasiva;
            $data['neraca'] = $sum_pasiva - $total_activa;
        } else {
            $this->session->set_flashdata('message_error', 'Closing bulan ' . format_indo($periode) . ' tidak ditemukan');
        }
        $data['title'] = 'Neraca per tanggal ' . format_indo($tanggal);
        $data['pages'] = 'pages/financial/v_neraca_bb_by_date';

        if ($button_sbm == "excel") {
            require_once(APPPATH . 'libraries/PHPExcel/IOFactory.php');

            $excel = new PHPExcel();
            $sheet = $excel->getActiveSheet();

            $excel->getProperties()->setCreator('SLS')
                ->setLastModifiedBy('SLS')
                ->setTitle("Neraca BB")
                ->setSubject("Neraca BB")
                ->setDescription("Neraca BB per tanggal " . format_indo($tanggal))
                ->setKeywords("Neraca BB");

            // Merge cells untuk header utama
            $sheet->mergeCells('A1:G1');
            $sheet->mergeCells('A2:C2');
            $sheet->mergeCells('E2:G2');

            // Isi data header
            $sheet->setCellValue('A1', 'Neraca BB per tanggal ' . format_indo($tanggal));
            $sheet->setCellValue('A2', 'AKTIVA');
            $sheet->setCellValue('E2', 'PASIVA');
            $sheet->setCellValue('B3', 'Total: ');
            $sheet->setCellValue('C3', $total_activa);
            $sheet->setCellValue('F3', 'Total: ');
            $sheet->setCellValue('G3', $sum_pasiva);

            // Buat sub-header untuk tabel
            $sheet->setCellValue('A4', 'No. CoA');
            $sheet->setCellValue('B4', 'Nama CoA');
            $sheet->setCellValue('C4', 'Nominal');
            $sheet->setCellValue('E4', 'No. CoA');
            $sheet->setCellValue('F4', 'Nama CoA');
            $sheet->setCellValue('G4', 'Nominal');

            // Tambahkan data Aktiva
            $numrowActiva = 5;
            foreach ($groupedActiva as $t) {
                $coa = $this->m_coa->getCoaBB($t->no_bb);

                $sheet->setCellValue('A' . $numrowActiva, $t->no_bb);
                $sheet->setCellValue('B' . $numrowActiva, $coa['nama_perkiraan']);
                $sheet->setCellValue('C' . $numrowActiva, $t->saldo_aktiva);

                $numrowActiva++;
            }

            // Tambahkan data Pasiva
            $numrowPasiva = 5;
            foreach ($groupedPasiva as $t) {
                $coa = $this->m_coa->getCoaBB($t->no_bb);

                $sheet->setCellValue('E' . $numrowPasiva, $t->no_bb);
                $sheet->setCellValue('F' . $numrowPasiva, $coa['nama_perkiraan']);
                $sheet->setCellValue('G' . $numrowPasiva, $t->saldo_pasiva);

                $numrowPasiva++;
            }
            $sheet->setCellValue('E' . $numrowPasiva, '3103');
            $sheet->setCellValue('F' . $numrowPasiva, 'LABA TAHUN BERJALAN');
            $sheet->setCellValue('G' . $numrowPasiva, $laba);

            // Set auto size untuk semua kolom
            foreach (range('A', 'G') as $columnID) {
                $sheet->getColumnDimension($columnID)->setAutoSize(true);
            }

            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="Neraca BB per tanggal ' . format_indo($tanggal) . '.xls"');
            header('Cache-Control: max-age=0');
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
            header('Cache-Control: cache, must-revalidate');
            header('Pragma: public');

            $objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
            $objWriter->save('php://output');
            exit;
        } else {
            $this->load->view('neraca_bb_by_date', $data);
        }
    }

    private function prepareLrBbReportByDate($data, $tanggal, $button_sbm = null)
    {
        $date = new DateTime($tanggal);

        $date->modify('first day of previous month');
        $periode = $date->format('Y-m');

        $cek = $this->m_coa->cek_saldo_awal($periode);

        if ($cek) {
            $coaLastPeriod = json_decode($cek['coa']);

            $pendapatan = $this->m_coa->getNeracaByDate('t_coalr_sbb', 'PASIVA', $tanggal, $periode);
            $beban = $this->m_coa->getNeracaByDate('t_coalr_sbb', 'AKTIVA', $tanggal, $periode);

            // Part Pendapatan
            $filteredCoaPendapatan = array_filter($coaLastPeriod, function ($item) {
                return $item->posisi === 'PASIVA' && $item->table_source === 't_coalr_sbb';
            });
            $combinedPendapatan = [];

            foreach ($pendapatan as $item) {
                if (!isset($combinedPendapatan[$item->no_sbb])) {
                    $combinedPendapatan[$item->no_sbb] = (object) [
                        'no_sbb' => $item->no_sbb,
                        'saldo_awal' => $item->saldo_awal,
                    ];
                } else {
                    $combinedPendapatan[$item->no_sbb]->saldo_awal += $item->saldo_awal;
                }
            }
            foreach ($filteredCoaPendapatan as $item) {
                if (!isset($combinedPendapatan[$item->no_sbb])) {
                    $combinedPendapatan[$item->no_sbb] = (object) [
                        'no_sbb' => $item->no_sbb,
                        'saldo_awal' => $item->saldo_awal,
                    ];
                } else {
                    $combinedPendapatan[$item->no_sbb]->saldo_awal += $item->saldo_awal;
                }
            }

            usort($combinedPendapatan, function ($a, $b) {
                return strcmp($a->no_sbb, $b->no_sbb);
            });
            $total_pendapatan = array_sum(array_column($combinedPendapatan, 'saldo_awal'));

            // Part Beban
            $filteredCoaBeban = array_filter($coaLastPeriod, function ($item) {
                return $item->posisi === 'AKTIVA' && $item->table_source === 't_coalr_sbb';
            });

            $combinedBeban = [];

            foreach ($beban as $item) {
                if (!isset($combinedBeban[$item->no_sbb])) {
                    $combinedBeban[$item->no_sbb] = (object) [
                        'no_sbb' => $item->no_sbb,
                        'saldo_awal' => $item->saldo_awal,
                    ];
                } else {
                    $combinedBeban[$item->no_sbb]->saldo_awal += $item->saldo_awal;
                }
            }
            foreach ($filteredCoaBeban as $item) {
                if (!isset($combinedBeban[$item->no_sbb])) {
                    $combinedBeban[$item->no_sbb] = (object) [
                        'no_sbb' => $item->no_sbb,
                        'saldo_awal' => $item->saldo_awal,
                    ];
                } else {
                    $combinedBeban[$item->no_sbb]->saldo_awal += $item->saldo_awal;
                }
            }
            usort($combinedBeban, function ($a, $b) {
                return strcmp($a->no_sbb, $b->no_sbb);
            });
            $total_beban = array_sum(array_column($combinedBeban, 'saldo_awal'));

            // Proses pengelompokan, penjumlahan, dan group-ing no_bb Aktiva
            $bbActiva = [];
            foreach ($combinedBeban as $item) {
                $key = substr($item->no_sbb, 0, 3);
                $bbActiva[$key] = ($bbActiva[$key] ?? 0) + $item->saldo_awal;
            }

            // Membentuk groupedActiva dan menghitung total saldo aktiva
            $groupedActiva = [];

            foreach ($bbActiva as $key => $saldo) {
                $groupedActiva[] = (object) ['no_bb' => $key, 'saldo_aktiva' => $saldo];
            }

            // Proses pengelompokan, penjumlahan, dan group-ing no_bb pasiva
            $bbPasiva = [];
            foreach ($combinedPendapatan as $item) {
                $key = substr($item->no_sbb, 0, 3);
                $bbPasiva[$key] = ($bbPasiva[$key] ?? 0) + $item->saldo_awal;
            }

            // Membentuk groupedPasiva dan menghitung total saldo pasiva
            $groupedPasiva = [];

            foreach ($bbPasiva as $key => $saldo) {
                $groupedPasiva[] = (object) ['no_bb' => $key, 'saldo_pasiva' => $saldo];
            }

            $data['biaya'] = $groupedActiva;
            $data['pendapatan'] = $groupedPasiva;
            $data['sum_biaya'] = $total_beban;
            $data['sum_pendapatan'] = $total_pendapatan;
            $data['total_pendapatan'] = $total_pendapatan - $total_beban;
        } else {
            $this->session->set_flashdata('message_error', 'Closing bulan ' . format_indo($periode) . ' tidak ditemukan');
        }

        $data['title'] = 'Laba rugi BB per tanggal ' . format_indo($tanggal);
        $data['pages'] = 'pages/financial/v_labarugi_bb_by_date';

        if ($button_sbm == "excel") {
            require_once(APPPATH . 'libraries/PHPExcel/IOFactory.php');

            $excel = new PHPExcel();
            $sheet = $excel->getActiveSheet();

            $excel->getProperties()->setCreator('SLS')
                ->setLastModifiedBy('SLS')
                ->setTitle("Neraca SBB")
                ->setSubject("Neraca SBB")
                ->setDescription("Neraca SBB per tanggal " . format_indo($tanggal))
                ->setKeywords("Neraca SBB");

            // Merge cells untuk header utama
            $sheet->mergeCells('A1:G1');
            $sheet->mergeCells('A2:C2');
            $sheet->mergeCells('E2:G2');

            // Isi data header
            $sheet->setCellValue('A1', 'Laba rugi per tanggal ' . format_indo($tanggal));
            $sheet->setCellValue('A2', 'BEBAN');
            $sheet->setCellValue('E2', 'PENDAPATAN');
            $sheet->setCellValue('B3', 'Total: ');
            $sheet->setCellValue('C3', $total_beban);
            $sheet->setCellValue('F2', 'Total: ');
            $sheet->setCellValue('G3', $total_pendapatan);

            // Buat sub-header untuk tabel
            $sheet->setCellValue('A4', 'No. CoA');
            $sheet->setCellValue('B4', 'Nama CoA');
            $sheet->setCellValue('C4', 'Nominal');
            $sheet->setCellValue('E4', 'No. CoA');
            $sheet->setCellValue('F4', 'Nama CoA');
            $sheet->setCellValue('G4', 'Nominal');

            // Tambahkan data Aktiva
            $numrowActiva = 5;
            foreach ($groupedActiva as $t) {
                $coa = $this->m_coa->getCoaBB($t->no_bb);

                $sheet->setCellValue('A' . $numrowActiva, $t->no_bb);
                $sheet->setCellValue('B' . $numrowActiva, $coa['nama_perkiraan']);
                $sheet->setCellValue('C' . $numrowActiva, $t->saldo_aktiva);

                $numrowActiva++;
            }

            // Tambahkan data Pasiva
            $numrowPasiva = 5;
            foreach ($groupedPasiva as $t) {
                $coa = $this->m_coa->getCoaBB($t->no_bb);

                $sheet->setCellValue('E' . $numrowPasiva, $t->no_bb);
                $sheet->setCellValue('F' . $numrowPasiva, $coa['nama_perkiraan']);
                $sheet->setCellValue('G' . $numrowPasiva, $t->saldo_pasiva);

                $numrowPasiva++;
            }

            // Set auto size untuk semua kolom
            foreach (range('A', 'G') as $columnID) {
                $sheet->getColumnDimension($columnID)->setAutoSize(true);
            }

            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="Laba rugi BB per tanggal ' . format_indo($tanggal) . '.xls"');
            header('Cache-Control: max-age=0');
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
            header('Cache-Control: cache, must-revalidate');
            header('Pragma: public');

            $objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
            $objWriter->save('php://output');
            exit;
        } else {
            $this->load->view('labarugi_bb_by_date', $data);
        }
    }

    private function prepareNeracaMonthly($data, $tanggal, $button_sbm = null)
    {
        $date = new DateTime($tanggal);
        $periode_neraca  = $date->format('Y-m');

        $date->modify('first day of previous month');
        $periode = $date->format('Y-m');

        // $cek = $this->m_coa->cek_saldo_awal($periode);

        $activa = $this->m_coa->getNeracaByDate('t_coa_sbb', 'AKTIVA', $tanggal, $periode);
        $pasiva = $this->m_coa->getNeracaByDate('t_coa_sbb', 'PASIVA', $tanggal, $periode);
        $pendapatan = $this->m_coa->getNeracaByDate('t_coalr_sbb', 'PASIVA', $tanggal, $periode);
        $beban = $this->m_coa->getNeracaByDate('t_coalr_sbb', 'AKTIVA', $tanggal, $periode);

        // Part Aktiva
        $combinedActiva = [];

        foreach ($activa as $item) {
            if (!isset($combinedActiva[$item->no_sbb])) {
                $combinedActiva[$item->no_sbb] = (object) [
                    'no_sbb' => $item->no_sbb,
                    'saldo_awal' => $item->saldo_awal,
                ];
            } else {
                $combinedActiva[$item->no_sbb]->saldo_awal += $item->saldo_awal;
            }
        }

        usort($combinedActiva, function ($a, $b) {
            return strcmp($a->no_sbb, $b->no_sbb);
        });
        $total_activa = array_sum(array_column($combinedActiva, 'saldo_awal'));

        // Part Pasiva
        $combinedPasiva = [];

        foreach ($pasiva as $item) {
            if (!isset($combinedPasiva[$item->no_sbb])) {
                $combinedPasiva[$item->no_sbb] = (object) [
                    'no_sbb' => $item->no_sbb,
                    'saldo_awal' => $item->saldo_awal,
                ];
            } else {
                $combinedPasiva[$item->no_sbb]->saldo_awal += $item->saldo_awal;
            }
        }

        usort($combinedPasiva, function ($a, $b) {
            return strcmp($a->no_sbb, $b->no_sbb);
        });
        $total_pasiva = array_sum(array_column($combinedPasiva, 'saldo_awal'));

        // Part Pendapatan
        $combinedPendapatan = [];

        foreach ($pendapatan as $item) {
            if (!isset($combinedPendapatan[$item->no_sbb])) {
                $combinedPendapatan[$item->no_sbb] = (object) [
                    'no_sbb' => $item->no_sbb,
                    'saldo_awal' => $item->saldo_awal,
                ];
            } else {
                $combinedPendapatan[$item->no_sbb]->saldo_awal += $item->saldo_awal;
            }
        }
        $total_pendapatan = array_sum(array_column($combinedPendapatan, 'saldo_awal'));

        // Part Beban
        $combinedBeban = [];

        foreach ($beban as $item) {
            if (!isset($combinedBeban[$item->no_sbb])) {
                $combinedBeban[$item->no_sbb] = (object) [
                    'no_sbb' => $item->no_sbb,
                    'saldo_awal' => $item->saldo_awal,
                ];
            } else {
                $combinedBeban[$item->no_sbb]->saldo_awal += $item->saldo_awal;
            }
        }
        $total_beban = array_sum(array_column($combinedBeban, 'saldo_awal'));

        $laba = $total_pendapatan - $total_beban;
        $sum_pasiva = $total_pasiva + $laba;

        $data['activa'] = $combinedActiva;
        $data['sum_activa'] = $total_activa;
        $data['pasiva'] = $combinedPasiva;
        $data['laba'] = $laba;
        $data['sum_pasiva'] = $sum_pasiva;
        $data['neraca'] = $sum_pasiva - $total_activa;

        $data['title'] = 'Neraca per bulan ' . format_indo($periode_neraca);
        $data['pages'] = 'pages/financial/v_neraca_by_date';

        if ($button_sbm == "excel") {
            require_once(APPPATH . 'libraries/PHPExcel/IOFactory.php');

            $excel = new PHPExcel();
            $sheet = $excel->getActiveSheet();

            $excel->getProperties()->setCreator('Kodesis')
                ->setLastModifiedBy('Kodesis')
                ->setTitle("Neraca")
                ->setSubject("Neraca")
                ->setDescription("Neraca per bulan " . format_indo($periode_neraca))
                ->setKeywords("Neraca");

            // Merge cells untuk header utama
            $sheet->mergeCells('A1:G1');
            $sheet->mergeCells('A2:C2');
            $sheet->mergeCells('E2:G2');

            // Isi data header
            $sheet->setCellValue('A1', 'Neraca SBB per tanggal ' . format_indo($periode_neraca));
            $sheet->setCellValue('A2', 'AKTIVA');
            $sheet->setCellValue('E2', 'PASIVA');
            $sheet->setCellValue('B3', 'Total: ');
            $sheet->setCellValue('C3', $total_activa);
            $sheet->setCellValue('F3', 'Total: ');
            $sheet->setCellValue('G3', $sum_pasiva);

            // Buat sub-header untuk tabel
            $sheet->setCellValue('A4', 'No. CoA');
            $sheet->setCellValue('B4', 'Nama CoA');
            $sheet->setCellValue('C4', 'Nominal');
            $sheet->setCellValue('E4', 'No. CoA');
            $sheet->setCellValue('F4', 'Nama CoA');
            $sheet->setCellValue('G4', 'Nominal');

            // Tambahkan data Aktiva
            $numrowActiva = 5;
            foreach ($combinedActiva as $t) {
                $coa = $this->m_coa->getCoa($t->no_sbb);
                if ($coa['table_source'] == "t_coa_sbb" && $coa['posisi'] == 'AKTIVA' && $t->saldo_awal != 0) :
                    $sheet->setCellValue('A' . $numrowActiva, $t->no_sbb);
                    $sheet->setCellValue('B' . $numrowActiva, $coa['nama_perkiraan']);
                    $sheet->setCellValue('C' . $numrowActiva, $t->saldo_awal);
                    $numrowActiva++;
                endif;
            }

            // Tambahkan data Pasiva
            $numrowPasiva = 5;
            foreach ($combinedPasiva as $t) {
                $coa = $this->m_coa->getCoa($t->no_sbb);
                if ($coa['table_source'] == "t_coa_sbb" && $coa['posisi'] == 'PASIVA' && $t->saldo_awal != 0) :
                    $sheet->setCellValue('E' . $numrowPasiva, $t->no_sbb);
                    $sheet->setCellValue('F' . $numrowPasiva, $coa['nama_perkiraan']);
                    $sheet->setCellValue('G' . $numrowPasiva, $t->saldo_awal);
                    $numrowPasiva++;
                endif;
            }
            $sheet->setCellValue('E' . $numrowPasiva, '3103001');
            $sheet->setCellValue('F' . $numrowPasiva, 'LABA TAHUN BERJALAN');
            $sheet->setCellValue('G' . $numrowPasiva, $laba);

            // Set auto size untuk semua kolom
            foreach (range('A', 'G') as $columnID) {
                $sheet->getColumnDimension($columnID)->setAutoSize(true);
            }

            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="Neraca per bulan ' . format_indo($periode_neraca) . '.xlsx"');
            header('Cache-Control: max-age=0');
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
            header('Cache-Control: cache, must-revalidate');
            header('Pragma: public');

            $objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
            $objWriter->save('php://output');
            exit;
        } else {
            $this->load->view('neraca_by_date', $data);
        }
    }

    private function prepareLabaRugiMonthly($data, $tanggal, $button_sbm = null)
    {
        $date = new DateTime($tanggal);
        $periode_laba_rugi  = $date->format('Y-m');

        $date->modify('first day of previous month');
        $periode = $date->format('Y-m');


        // print_r($periode_laba_rugi);
        // exit;

        // $cek = $this->m_coa->cek_saldo_awal($periode);

        $data['total_pendapatan'] = 0;
        $data['sum_biaya'] = 0;
        $data['sum_pendapatan'] = 0;
        $data['biaya'] = [];
        $data['pendapatan'] = [];


        $pendapatan = $this->m_coa->getNeracaByDate('t_coalr_sbb', 'PASIVA', $tanggal, $periode);
        $beban = $this->m_coa->getNeracaByDate('t_coalr_sbb', 'AKTIVA', $tanggal, $periode);

        // Part Pendapatan
        $combinedPendapatan = [];

        foreach ($pendapatan as $item) {
            if (!isset($combinedPendapatan[$item->no_sbb])) {
                $combinedPendapatan[$item->no_sbb] = (object) [
                    'no_sbb' => $item->no_sbb,
                    'saldo_awal' => $item->saldo_awal,
                ];
            } else {
                $combinedPendapatan[$item->no_sbb]->saldo_awal += $item->saldo_awal;
            }
        }
        $total_pendapatan = array_sum(array_column($combinedPendapatan, 'saldo_awal'));

        // Part Beban

        $combinedBeban = [];

        foreach ($beban as $item) {
            if (!isset($combinedBeban[$item->no_sbb])) {
                $combinedBeban[$item->no_sbb] = (object) [
                    'no_sbb' => $item->no_sbb,
                    'saldo_awal' => $item->saldo_awal,
                ];
            } else {
                $combinedBeban[$item->no_sbb]->saldo_awal += $item->saldo_awal;
            }
        }
        $total_beban = array_sum(array_column($combinedBeban, 'saldo_awal'));

        $data['biaya'] = $combinedBeban;
        $data['pendapatan'] = $combinedPendapatan;
        $data['sum_biaya'] = $total_beban;
        $data['sum_pendapatan'] = $total_pendapatan;
        $data['total_pendapatan'] = $total_pendapatan - $total_beban;


        // print_r($data['total_pendapatan']);
        // exit;
        $data['title'] = 'Laba rugi per bulan ' . format_indo($periode_laba_rugi);
        $data['pages'] = 'pages/financial/v_labarugi_by_date';

        if ($button_sbm == "excel") {
            require_once(APPPATH . 'libraries/PHPExcel/IOFactory.php');

            $excel = new PHPExcel();
            $sheet = $excel->getActiveSheet();

            $excel->getProperties()->setCreator('Kodesis')
                ->setLastModifiedBy('Kodesis')
                ->setTitle("Laba rugi")
                ->setSubject("Laba rugi")
                ->setDescription("Laba rugi per bulan " . format_indo($periode_laba_rugi))
                ->setKeywords("Laba rugi");

            // Merge cells untuk header utama
            $sheet->mergeCells('A1:G1');
            $sheet->mergeCells('A2:C2');
            $sheet->mergeCells('E2:G2');

            // Isi data header
            $sheet->setCellValue('A1', 'Laba rugi SBB per bulan ' . format_indo($periode_laba_rugi));
            $sheet->setCellValue('A2', 'BEBAN');
            $sheet->setCellValue('E2', 'PENDAPATAN');
            $sheet->setCellValue('B3', 'Total: ');
            $sheet->setCellValue('C3', $total_beban);
            $sheet->setCellValue('F3', 'Total: ');
            $sheet->setCellValue('G3', $total_pendapatan);

            // Buat sub-header untuk tabel
            $sheet->setCellValue('A4', 'No. CoA');
            $sheet->setCellValue('B4', 'Nama CoA');
            $sheet->setCellValue('C4', 'Nominal');
            $sheet->setCellValue('E4', 'No. CoA');
            $sheet->setCellValue('F4', 'Nama CoA');
            $sheet->setCellValue('G4', 'Nominal');

            // Tambahkan data Aktiva
            $numrowActiva = 5;
            foreach ($combinedBeban as $t) {
                $coa = $this->m_coa->getCoa($t->no_sbb);
                if ($coa['table_source'] == "t_coalr_sbb" && $coa['posisi'] == 'AKTIVA' && $t->saldo_awal != 0) :
                    $sheet->setCellValue('A' . $numrowActiva, $t->no_sbb);
                    $sheet->setCellValue('B' . $numrowActiva, $coa['nama_perkiraan']);
                    $sheet->setCellValue('C' . $numrowActiva, $t->saldo_awal);
                    $numrowActiva++;
                endif;
            }

            // Tambahkan data Pasiva
            $numrowPasiva = 5;
            foreach ($combinedPendapatan as $t) {
                $coa = $this->m_coa->getCoa($t->no_sbb);
                if ($coa['table_source'] == "t_coalr_sbb" && $coa['posisi'] == 'PASIVA' && $t->saldo_awal != 0) :
                    $sheet->setCellValue('E' . $numrowPasiva, $t->no_sbb);
                    $sheet->setCellValue('F' . $numrowPasiva, $coa['nama_perkiraan']);
                    $sheet->setCellValue('G' . $numrowPasiva, $t->saldo_awal);
                    $numrowPasiva++;
                endif;
            }

            // Set auto size untuk semua kolom
            foreach (range('A', 'G') as $columnID) {
                $sheet->getColumnDimension($columnID)->setAutoSize(true);
            }

            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="Laba rugi per bulan ' . format_indo($periode_laba_rugi) . '.xls"');
            header('Cache-Control: max-age=0');
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
            header('Cache-Control: cache, must-revalidate');
            header('Pragma: public');

            $objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
            $objWriter->save('php://output');
            exit;
        } else {
            $this->load->view('laba_rugi_by_date', $data);
        }
    }

    public function reportBB()
    {
        $nip = $this->session->userdata('nip');

        // Fetch counts
        $result = $this->db->query("SELECT COUNT(Id) FROM memo WHERE (nip_kpd LIKE '%$nip%' OR nip_cc LIKE '%$nip%') AND (`read` NOT LIKE '%$nip%');")->row()->{'COUNT(Id)'};
        $result2 = $this->db->query("SELECT COUNT(id) FROM task WHERE (`member` LIKE '%$nip%' or `pic` LIKE '%$nip%') AND activity='1'")->row()->{'COUNT(id)'};

        $per_tanggal = ($this->input->post('per_tanggal') ? $this->input->post('per_tanggal') : date('Y-m-d'));

        $data = [
            'count_inbox' => $result,
            'count_inbox2' => $result2,
            'per_tanggal' => $per_tanggal
        ];

        $button_sbm = $this->input->post('button_sbm');
        $tahun = $this->input->post('per_tahun') ? $this->input->post('per_tahun') : date('Y');
        $tahun_before = $tahun - 1;
        $bulan_saldo_awal = $tahun_before . '-12';

        $saldo_awal = $this->cb->where('periode', $bulan_saldo_awal)->get('saldo_awal')->row_array();
        $saldo_awal_data = $saldo_awal ? json_decode($saldo_awal['coa']) : [];

        $saldo_awal_indexed = [];
        foreach ($saldo_awal_data as $sa) {
            $saldo_awal_indexed[$sa->no_sbb] = $sa->saldo_awal;
        }
        $data['saldo_awal'] = $saldo_awal_indexed; // Sudah dalam format array dengan key no_sbb
        // $data['saldo_awal_raw'] = $saldo_awal_data;

        $list_coa = $this->cb->get('v_coa_all')->result();

        $data['list_coa'] = $list_coa;
        $data['per_tahun'] = $tahun;

        if ($button_sbm == "excel") {
            // Clear output buffer untuk avoid corrupt
            if (ob_get_length()) {
                ob_end_clean();
            }

            error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT);

            require_once(APPPATH . 'libraries/PHPExcel/IOFactory.php');

            $excel = new PHPExcel();
            $sheet = $excel->getActiveSheet();

            $description = 'Buku besar ' . $this->session->userdata('nama_perusahaan') . ' per tahun ' . $tahun;

            $excel->getProperties()->setCreator('KodeSis')
                ->setLastModifiedBy('KodeSis')
                ->setTitle('Buku besar')
                ->setSubject('Buku besar')
                ->setDescription($description)
                ->setKeywords('Buku besar');

            // Header utama
            $sheet->setCellValue('A1', $description);
            $sheet->mergeCells('A1:D1');

            // Style header utama (opsional)
            $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
            $sheet->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

            $numRow = 3;

            if ($list_coa) {
                foreach ($list_coa as $lc) :
                    $saldo_awal_value = isset($saldo_awal_indexed[$lc->no_sbb]) ? $saldo_awal_indexed[$lc->no_sbb] : 0;

                    $transaction = $this->m_coa->getCoaReportAnnually($lc->no_sbb, $tahun);

                    if ($transaction) {
                        // Header per COA
                        $sheet->setCellValue('A' . $numRow, $lc->no_sbb);
                        $sheet->setCellValue('B' . $numRow, strtoupper($lc->nama_perkiraan));
                        $sheet->setCellValue('D' . $numRow, 'IDR');

                        // Style header COA
                        $sheet->getStyle('A' . $numRow . ':D' . $numRow)->getFont()->setBold(true);
                        $sheet->getStyle('A' . $numRow . ':D' . $numRow)->getFill()
                            ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                            ->getStartColor()->setRGB('E8E8E8');

                        $numRow++;

                        // Sub-header tabel
                        $sheet->setCellValue('A' . $numRow, 'Tanggal');
                        $sheet->setCellValue('B' . $numRow, 'Keterangan');
                        $sheet->setCellValue('C' . $numRow, 'Debit');
                        $sheet->setCellValue('D' . $numRow, 'Kredit');

                        // Style sub-header
                        $sheet->getStyle('A' . $numRow . ':D' . $numRow)->getFont()->setBold(true);
                        $sheet->getStyle('A' . $numRow . ':D' . $numRow)->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                        $numRow++;

                        // Data transaksi
                        $total_debit = 0;
                        $total_kredit = 0;

                        foreach ($transaction as $tr) {
                            if ($lc->no_sbb == $tr->akun_debit) {
                                $sheet->setCellValue('A' . $numRow, date('d/m/Y', strtotime($tr->tanggal)));
                                $sheet->setCellValue('B' . $numRow, $tr->keterangan);
                                $sheet->setCellValue('C' . $numRow, $tr->jumlah_debit);
                                $sheet->setCellValue('D' . $numRow, '-');
                                $total_debit += $tr->jumlah_debit;
                            } else {
                                $sheet->setCellValue('A' . $numRow, date('d/m/Y', strtotime($tr->tanggal)));
                                $sheet->setCellValue('B' . $numRow, $tr->keterangan);
                                $sheet->setCellValue('C' . $numRow, '-');
                                $sheet->setCellValue('D' . $numRow, $tr->jumlah_kredit);
                                $total_kredit += $tr->jumlah_kredit;
                            }

                            // Format angka
                            $sheet->getStyle('C' . $numRow)->getNumberFormat()
                                ->setFormatCode('#,##0');
                            $sheet->getStyle('D' . $numRow)->getNumberFormat()
                                ->setFormatCode('#,##0');

                            $numRow++;
                        }

                        // $mutasi = $total_debit - $total_kredit;
                        if ($lc->posisi === "AKTIVA") {
                            $mutasi = $total_debit - $total_kredit;
                        } else {
                            $mutasi = $total_kredit - $total_debit;
                        }

                        // Total
                        $sheet->setCellValue('A' . $numRow, 'Total');
                        $sheet->setCellValue('C' . $numRow, $total_debit);
                        $sheet->setCellValue('D' . $numRow, $total_kredit);
                        $sheet->getStyle('A' . $numRow . ':D' . $numRow)->getFont()->setBold(true);
                        $sheet->getStyle('C' . $numRow . ':D' . $numRow)->getNumberFormat()
                            ->setFormatCode('#,##0');
                        $numRow++;

                        // Saldo Awal
                        $sheet->setCellValue('A' . $numRow, 'Saldo Awal');
                        $sheet->setCellValue('D' . $numRow, $saldo_awal_value);
                        $sheet->getStyle('A' . $numRow . ':D' . $numRow)->getFont()->setBold(true);
                        $sheet->getStyle('D' . $numRow)->getNumberFormat()
                            ->setFormatCode('#,##0');
                        $numRow++;

                        // Mutasi
                        $sheet->setCellValue('A' . $numRow, 'Mutasi');
                        $sheet->setCellValue('D' . $numRow, $mutasi);
                        $sheet->getStyle('A' . $numRow . ':D' . $numRow)->getFont()->setBold(true);
                        $sheet->getStyle('D' . $numRow)->getNumberFormat()
                            ->setFormatCode('#,##0');
                        $numRow++;

                        // Saldo Akhir
                        // $selisih = $total_debit - $total_kredit;
                        $saldo_akhir = $saldo_awal_value + $mutasi;

                        $sheet->setCellValue('A' . $numRow, 'Saldo Akhir');
                        $sheet->setCellValue('D' . $numRow, $saldo_akhir);
                        $sheet->getStyle('A' . $numRow . ':D' . $numRow)->getFont()->setBold(true);
                        $sheet->getStyle('D' . $numRow)->getNumberFormat()
                            ->setFormatCode('#,##0');

                        $numRow += 2; // Spacing antar COA
                    }
                endforeach;

                // Set auto size untuk semua kolom
                foreach (range('A', 'D') as $columnID) {
                    $sheet->getColumnDimension($columnID)->setAutoSize(true);
                }

                // Clear any remaining output
                if (ob_get_length()) {
                    ob_end_clean();
                }

                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename="' . $description . '.xlsx"');
                header('Cache-Control: max-age=0');
                header('Cache-Control: max-age=1');
                header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
                header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
                header('Cache-Control: cache, must-revalidate');
                header('Pragma: public');

                $objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
                $objWriter->save('php://output');
                exit;
            }
        } else if ($button_sbm == "pdf") {

            $description = 'Buku besar ' . $this->session->userdata('nama_perusahaan') . ' per tahun ' . $tahun;

            $data = [
                'description' => $description,
                'list_coa' => $list_coa,
                'tahun' => $tahun,
                'saldo_awal' => $saldo_awal_indexed
            ];

            $file_pdf = $description;

            $paper = 'A4';

            $orientation = "portrait";

            $this->load->view('print_pdf_buku_besar', $data);
            // Build HTML
            // $html = $this->load->view('print_pdf_buku_besar', $data, true);

            // $this->pdfgenerator->generate($html, $file_pdf, $paper, $orientation);
        } else {
            $this->load->view('report_bb_annually', $data);
        }
    }

    public function reportBBMonthly()
    {
        $nip = $this->session->userdata('nip');

        // Fetch counts
        $result = $this->db->query("SELECT COUNT(Id) FROM memo WHERE (nip_kpd LIKE '%$nip%' OR nip_cc LIKE '%$nip%') AND (`read` NOT LIKE '%$nip%');")->row()->{'COUNT(Id)'};
        $result2 = $this->db->query("SELECT COUNT(id) FROM task WHERE (`member` LIKE '%$nip%' or `pic` LIKE '%$nip%') AND activity='1'")->row()->{'COUNT(id)'};

        $per_tanggal = ($this->input->post('per_tanggal') ? $this->input->post('per_tanggal') : date('Y-m-d'));

        $data = [
            'count_inbox' => $result,
            'count_inbox2' => $result2,
            'per_tanggal' => $per_tanggal
        ];

        $button_sbm = $this->input->post('button_sbm');
        $tahun = $this->input->post('per_tahun') ? $this->input->post('per_tahun') : date('Y');
        $bulan = $this->input->post('per_bulan') ? $this->input->post('per_bulan') : date('m');

        $tahun_before = $tahun - 1;
        $bulan_before = str_pad($bulan - 1, 2, '0', STR_PAD_LEFT);

        $bulan_saldo_awal = $tahun_before . '-' . $bulan_before;

        $saldo_awal = $this->cb->where('periode', $bulan_saldo_awal)->get('saldo_awal')->row_array();
        $saldo_awal_data = $saldo_awal ? json_decode($saldo_awal['coa']) : [];

        $saldo_awal_indexed = [];
        foreach ($saldo_awal_data as $sa) {
            $saldo_awal_indexed[$sa->no_sbb] = $sa->saldo_awal;
        }
        $data['saldo_awal'] = $saldo_awal_indexed; // Sudah dalam format array dengan key no_sbb
        // $data['saldo_awal_raw'] = $saldo_awal_data;

        $list_coa = $this->cb->get('v_coa_all')->result();

        $periode = $tahun . '-' . $bulan;

        $data['list_coa'] = $list_coa;
        $data['per_periode'] = $periode;
        $data['per_tahun'] = $tahun;
        $data['per_bulan'] = $bulan;

        $a = date('F Y', strtotime($periode . '-01'));

        $description = 'Buku besar ' . $this->session->userdata('nama_perusahaan') . ' per bulan ' . $a;
        $data['description'] = $description;


        if ($button_sbm == "pdf") {

            $data['description'] = $description;
            $data = [
                'description' => $description,
                'per_periode' => $periode,
                'list_coa' => $list_coa,
                'tahun' => $tahun,
                'saldo_awal' => $saldo_awal_indexed
            ];

            $this->load->view('print_pdf_buku_besar_monthly', $data);
            // Build HTML
            // $html = $this->load->view('print_pdf_buku_besar', $data, true);

            // $this->pdfgenerator->generate($html, $file_pdf, $paper, $orientation);
        } else {
            $this->load->view('report_bb_monthly', $data);
        }
    }

    public function nota()
    {
        $customer_id = $this->input->post('customer_id');
        $keyword = trim($this->input->post('keyword', true) ?? '');

        $config = [
            'base_url' => site_url('financial/invoice'),
            'total_rows' => $this->m_invoice->invoice_count($keyword, $customer_id),
            'per_page' => 20,
            'uri_segment' => 3,
            'num_links' => 10,
            'full_tag_open' => '<ul class="pagination" style="margin: 0 0">',
            'full_tag_close' => '</ul>',
            'first_link' => false,
            'last_link' => false,
            'first_tag_open' => '<li>',
            'first_tag_close' => '</li>',
            'prev_link' => '«',
            'prev_tag_open' => '<li class="prev">',
            'prev_tag_close' => '</li>',
            'next_link' => '»',
            'next_tag_open' => '<li>',
            'next_tag_close' => '</li>',
            'last_tag_open' => '<li>',
            'last_tag_close' => '</li>',
            'cur_tag_open' => '<li class="active"><a href="#">',
            'cur_tag_close' => '</a></li>',
            'num_tag_open' => '<li>',
            'num_tag_close' => '</li>'
        ];

        $this->pagination->initialize($config);

        $page = $this->uri->segment(3) ? $this->uri->segment(3) : 0;
        $invoices = $this->m_invoice->list_nota($config["per_page"], $page, $keyword, $customer_id);

        $nip = $this->session->userdata('nip');
        $sql = "SELECT COUNT(Id) FROM memo WHERE (nip_kpd LIKE '%$nip%' OR nip_cc LIKE '%$nip%') AND (`read` NOT LIKE '%$nip%');";
        $query = $this->db->query($sql);
        $result = $query->row_array()['COUNT(Id)'];

        $sql2 = "SELECT COUNT(id) FROM task WHERE (`member` LIKE '%$nip%' or `pic` like '%$nip%') and activity='1'";
        $query2 = $this->db->query($sql2);
        $result2 = $query2->row_array()['COUNT(id)'];

        $data = [
            'page' => $page,
            'invoices' => $invoices,
            'count_inbox' => $result,
            'count_inbox2' => $result2,
            'coa' => $this->m_coa->list_coa(),
            'coa_kas' => $this->m_coa->getCoaByCode('1201'),
            'coa_pendapatan' => $this->m_coa->getCoaByCode('410'),
            'keyword' => $keyword,
            'title' => "Invoice",
            'customers' => $this->M_Customer->list_customer(''),
        ];
        // echo '<pre>';
        // print_r($data['invoices']);
        // echo '</pre>';
        // exit;

        $this->load->view('nota', $data);
    }

    public function create_nota()
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

        $data = [
            'title' => 'Create Nota',
            'count_inbox' => $result,
            'count_inbox2' => $result2,
            'jenis' => $this->cb->get('jenis_nota')->result()
        ];

        $this->load->view('nota_create', $data);
    }

    public function store_nota()
    {
        $id_user = $this->session->userdata('nip');
        $ppn = $this->input->post('ppn');
        $nominal = $this->convertToNumberWithComma($this->input->post('nominal'));
        $besaran_ppn = $this->convertToNumberWithComma($this->input->post('besaran_ppn'));
        $nominal_bayar = $this->convertToNumberWithComma($this->input->post('nominal_bayar'));
        $nominal_pendapatan = $this->convertToNumberWithComma($this->input->post('nominal_pendapatan'));

        // print_r($nominal);
        // exit;

        $no_inv = $this->input->post('no_invoice');

        $jenis = $this->input->post('jenis');

        $jenis_nota = $this->cb->where('Id', $jenis)->get('jenis_nota')->row_array();


        $coa_debit = $jenis_nota['coa_debit'];
        $coa_kredit = $jenis_nota['coa_kredit'];

        $kode_cabang = $this->session->userdata('kode_cabang');

        $max_num = $this->cb->select('max(nomor_urut) as max')->where('id_cabang', $this->session->userdata('kode_cabang'))->get('nota')->row_array();


        if (!$max_num['max']) {
            $bilangan = 1; // Nilai Proses
        } else {
            $bilangan = $max_num['max'] + 1;
        }

        $no_nota = sprintf("%03d", $bilangan);

        $slug = "NT.KC-" . sprintf("%02d", $kode_cabang) . '-' . $no_nota;

        $tgl_nota = $this->input->post('tgl_nota');

        // Insert ke tabel invoice
        $nota_data = [
            'nomor_urut' => $bilangan,
            'tanggal_nota' => $tgl_nota,
            'ppn' => $ppn,
            'subtotal' => $nominal,
            'besaran_ppn' => $besaran_ppn,
            'created_by' => $id_user,
            'customer' => $this->input->post('customer'),
            'coa_debit' => $coa_debit,
            'coa_kredit' => $coa_kredit,
            'total_transaksi' => $nominal,
            'nominal_bayar' => $nominal_bayar,
            'nominal_pendapatan' => $nominal_pendapatan,
            'jenis_nota' => $jenis,
            'slug' => $slug,
            'id_cabang' => $this->session->userdata('kode_cabang'),
        ];

        // echo '<pre>';
        // print_r($_POST);
        // echo '</pre>';
        // exit;

        $this->cb->trans_begin();
        $id_nota = $this->m_invoice->insert_nota($nota_data);

        if (!$id_nota) {
            $this->cb->trans_rollback();
            $this->session->set_flashdata('message_name', 'Failed to create nota.');
            redirect("financial/nota");
        }

        $items = $this->input->post('item');
        $id_items = $this->input->post('id_item');
        $jumlahs = $this->input->post('jumlah');
        $stok_awals = $this->input->post('stok_gudang');
        $total_amounts = $this->input->post('total_amount');

        $detail_data = [];

        if (is_array($items)) {

            for ($i = 0; $i < count($items); $i++) {
                $item = trim($items[$i]);
                $id_item = trim($id_items[$i]);
                $stok_awal = $this->convertToNumberWithComma($stok_awals[$i]);
                $jumlah = $this->convertToNumberWithComma($jumlahs[$i]);
                $total_amount = $this->convertToNumberWithComma($total_amounts[$i]);

                if ($id_item) {
                    $detail_data[] = [
                        'id_nota' => $id_nota,
                        'id_item' => ($id_item),
                        'item' => strtoupper($item),
                        'stok_awal' => ($stok_awal),
                        'jumlah' => $jumlah,
                        'total_amount' => $total_amount,
                        'created_by' => $id_user,
                        'id_cabang' => $this->session->userdata('kode_cabang'),
                    ];
                }

                // kurangi stok
                $sisa_stok = $stok_awal - $jumlah;

                // query kurangi stok
                $this->cb->where('id', $id_item)->update('item_invoice', ['stok' => $sisa_stok]);
            }

            if (!empty($detail_data)) {
                $insert = $this->m_invoice->insert_nota_batch($detail_data);

                if ($insert === FALSE) {
                    $this->cb->trans_rollback();
                    $this->session->set_flashdata('message_name', 'Failed to insert nota details.');
                    redirect("financial/nota");
                }

                // Pastikan fungsi posting tidak mengganggu transaksi
                $this->input_general_ledger($coa_debit, $coa_kredit, $nominal_bayar, $tgl_nota, $id_nota);

                $this->cb->trans_commit();
                $this->session->set_flashdata('message_name', 'The nota has been successfully created. ' . $no_inv);
                redirect("financial/nota");
            } else {
                $this->cb->trans_rollback();
                $this->session->set_flashdata('message_name', 'Nota detail data is empty.');
                redirect("financial/nota");
            }
        }
    }

    private function input_general_ledger($coa_debit, $coa_kredit, $nominal, $tanggal, $nota_id = NULL)
    {
        $data = [
            'tanggal' => $tanggal,
            'nota_id' => $nota_id,
            'coa_debit' => $coa_debit,
            'coa_kredit' => $coa_kredit,
            'nominal' => $nominal,
            'id_cabang' => $this->session->userdata('kode_cabang'),
            'nip' => $this->session->userdata('nip'),
        ];

        $this->cb->insert('general_ledger', $data);
    }

    public function closing_harian($tanggal)
    {
        $id_user = $this->session->userdata('nip');
        $kode_cabang = $this->session->userdata('kode_cabang');

        // Ambil semua transaksi GL yang belum diposting jadi jurnal
        $gl_list = $this->cb->where('tanggal', $tanggal)
            ->where('status', 0)
            ->where('id_cabang', $kode_cabang)
            ->where('user', $this->session->userdata('nip'))
            ->get('general_ledger')->result_array();

        if (empty($gl_list)) {
            $this->session->set_flashdata('message_name', 'Tidak ada transaksi untuk closing.');
            redirect('financial/closing');
        }

        $this->cb->trans_begin();

        foreach ($gl_list as $gl) {
            $data_jurnal = [
                'tanggal' => $gl['tanggal'],
                'akun_debit' => $gl['coa_debit'],
                'jumlah_debit' => $gl['nominal'],
                'akun_kredit' => $gl['coa_kredit'],
                'jumlah_kredit' => $gl['nominal'],
                'keterangan' => $gl['keterangan'], // opsional
                'created_by' => $id_user,
                'created_at' => date('Y-m-d H:i:s'),
                'id_cabang' => $gl['id_cabang'],
                'id_invoice' => $gl['nota_id'],
                'saldo_debit' => 0, // opsional update nanti
                'saldo_kredit' => 0,
            ];

            $insert = $this->cb->insert('jurnal_neraca', $data_jurnal);

            if (!$insert) {
                $this->cb->trans_rollback();
                $this->session->set_flashdata('message_name', 'Gagal closing.');
                redirect('financial/closing');
            }

            // Update status di general ledger jadi 1
            $this->cb->where('id', $gl['id'])->update('general_ledger', ['status' => 1]);
        }

        $this->cb->trans_commit();
        $this->session->set_flashdata('message_name', 'Berhasil melakukan closing jurnal harian.');
        redirect('financial/closing');
    }
}
