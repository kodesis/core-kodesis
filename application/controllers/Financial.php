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
    }

    public function financial_entry()
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

        $this->load->view('financial_entry', $data);
    }

    public function process_financial_entry($jenis = Null)
    {
        if ($jenis == "multi_kredit") {
            $coa_debit = $this->input->post('neraca_debit');
            $coa_kredit = $this->input->post('accounts');
            $nominal = preg_replace('/[^a-zA-Z0-9\']/', '', $this->input->post('nominals'));
            $jenis_fe = $jenis;
        } else if ($jenis == "multi_debit") {
            $coa_debit = $this->input->post('accounts');
            $coa_kredit = $this->input->post('neraca_kredit');
            $nominal = preg_replace('/[^a-zA-Z0-9\']/', '', $this->input->post('nominals'));
            $jenis_fe = $jenis;
        } else {
            $coa_debit = $this->input->post('neraca_debit');
            $coa_kredit = $this->input->post('neraca_kredit');

            if ($coa_debit == $coa_kredit) {
                $this->session->set_flashdata('message_error', 'CoA Debit dan Kredit tidak boleh sama');
                redirect('financial/financial_entry');
            }
            $nominal = preg_replace('/[^a-zA-Z0-9\']/', '', $this->input->post('input_nominal'));
            $jenis_fe = "single";
        }

        // $coa_debit = $this->input->post('neraca_debit');
        // $coa_kredit = $this->input->post('neraca_kredit');

        // if ($coa_debit == $coa_kredit) {
        //     $this->session->set_flashdata('message_error', 'CoA Debit dan Kredit tidak boleh sama');
        //     redirect('financial/financial_entry');
        // }
        // $nominal = preg_replace('/[^a-zA-Z0-9\']/', '', $this->input->post('input_nominal'));

        $keterangan = trim($this->input->post('input_keterangan'));
        $tanggal = $this->input->post('tanggal');

        if (!$this->input->post()) {
            $this->session->set_flashdata('message_error', 'Gagal Input');
        } else {
            $this->posting($coa_debit, $coa_kredit, $keterangan, $nominal, $tanggal, $jenis_fe);

            $this->session->set_flashdata('message_name', 'Financial entry success.');
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

                $this->posting(
                    $coa_debit,
                    $coa_kredit,
                    $keterangan,
                    $nominal,
                    $tanggal,
                    $jenis_fe = 'single'
                );

                $insertedRows++;
                $progress = round(($insertedRows / $totalRows) * 100);
                echo "data: " . json_encode(['progress' => $progress, 'currentRow' => $insertedRows, 'totalRows' => $totalRows]) . "\n\n";
                ob_flush();
                flush();
            }

            // Commit transaction
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                echo json_encode(['status' => false, 'message' => 'Database error']);
            } else {
                $this->db->trans_commit();
                echo json_encode(['status' => true, 'message' => 'File processed successfully']);
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

        $max_num = $this->m_invoice->select_max();

        if (!$max_num['max']) {
            $bilangan = 1; // Nilai Proses
        } else {
            $bilangan = $max_num['max'] + 1;
        }

        $no_inv = sprintf("%06d", $bilangan);

        $data = [
            'title' => 'Create Invoice',
            'no_invoice' => $no_inv,
            'customers' => $this->M_Customer->list_customer('khusus'),
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

        $max_num = $this->m_invoice->select_max();

        if (!$max_num['max']) {
            $bilangan = 1; // Nilai Proses
        } else {
            $bilangan = $max_num['max'] + 1;
        }

        $no_inv = sprintf("%06d", $bilangan);

        $data = [
            'title' => 'Create Invoice',
            'no_invoice' => $no_inv,
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
            'status_pendapatan' => '1'
        ];

        $this->db->trans_begin();
        $id_invoice = $this->m_invoice->insert($invoice_data);

        if (!$id_invoice) {
            $this->db->trans_rollback();
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
                    'created_by' => $id_user
                ];
            }

            if (!empty($detail_data)) {
                $insert = $this->m_invoice->insert_batch($detail_data);

                if ($insert === FALSE) {
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message_name', 'Failed to insert invoice details.');
                    redirect("financial/invoice");
                }

                // Pastikan fungsi posting tidak mengganggu transaksi
                $this->posting($coa_debit, $coa_kredit, $keterangan, $total_denganpph, $tgl_invoice, $id_invoice);

                $this->db->trans_commit();
                $this->session->set_flashdata('message_name', 'The invoice has been successfully created. ' . $no_inv);
                redirect("financial/invoice");
            } else {
                $this->db->trans_rollback();
                $this->session->set_flashdata('message_name', 'Invoice detail data is empty.');
                redirect("financial/invoice");
            }
        }
    }

    public function edit_invoice($no_inv)
    {
        $inv =  $this->m_invoice->show($no_inv);
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
            'title' => 'Invoice No. ' . $no_inv,
            'inv' => $inv,
            'details' => $this->m_invoice->item_list($inv['Id']),
            'user' => $this->m_invoice->cek_user($inv['user_create']),
            'customers' => $this->M_Customer->list_customer('khusus'),
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

        $this->posting($coa_kredit_lama, $coa_debit_lama, $keterangan_lama, $inv['nominal_pendapatan'], $inv['tanggal_invoice'], $inv['Id']);

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

    private function posting($coa_debit, $coa_kredit, $keterangan, $nominal, $tanggal, $id_invoice = NULL)
    {
        $substr_coa_debit = substr($coa_debit, 0, 1);
        $substr_coa_kredit = substr($coa_kredit, 0, 1);

        $debit = $this->m_coa->cek_coa($coa_debit);
        $kredit = $this->m_coa->cek_coa($coa_kredit);

        $saldo_debit_baru = 0;
        $saldo_kredit_baru = 0;

        if ($debit['posisi'] == "AKTIVA") {
            $saldo_debit_baru = $debit['nominal'] + $nominal;
        } else if ($debit['posisi'] == "PASIVA") {
            $saldo_debit_baru = $debit['nominal'] - $nominal;
        }

        if ($kredit['posisi'] == "AKTIVA") {
            $saldo_kredit_baru = $kredit['nominal'] - $nominal;
        } else if ($kredit['posisi'] == "PASIVA") {
            $saldo_kredit_baru = $kredit['nominal'] + $nominal;
        }

        // cek tabel
        if ($substr_coa_debit == "1" || $substr_coa_debit == "2" || $substr_coa_debit == "3") {
            $tabel_debit = "t_coa_sbb";
            $kolom_debit = "no_sbb";
        } else {
            $tabel_debit = "t_coalr_sbb";
            $kolom_debit = "no_lr_sbb";
        }

        if ($substr_coa_kredit == "1" || $substr_coa_kredit == "2" || $substr_coa_debit == "3") {
            $tabel_kredit = "t_coa_sbb";
            $kolom_kredit = "no_sbb";
        } else {
            $tabel_kredit = "t_coalr_sbb";
            $kolom_kredit = "no_lr_sbb";
        }

        $data_debit = [
            'nominal' => $saldo_debit_baru
        ];
        $data_kredit = [
            'nominal' => $saldo_kredit_baru
        ];

        $this->m_coa->update_nominal_coa($coa_debit, $data_debit, $kolom_debit, $tabel_debit);

        $this->m_coa->update_nominal_coa($coa_kredit, $data_kredit, $kolom_kredit, $tabel_kredit);

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
            'id_invoice' => ($id_invoice) ? $id_invoice : '',
        ];

        $this->m_coa->addJurnal($dt_jurnal);

        $data_transaksi = [
            'user_id' => $this->session->userdata('nip'),
            'tgl_trs' => date('Y-m-d H:i:s'),
            'nominal' => $nominal,
            'debet' => $coa_debit,
            'kredit' => $coa_kredit,
            'keterangan' => trim($keterangan)
        ];

        $this->m_coa->add_transaksi($data_transaksi);
    }

    private function update_posting($coa_debit, $coa_kredit, $keterangan, $nominal, $tanggal, $id_invoice = NULL)
    {
    }

    public function print_invoice($no_inv)
    {
        $inv =  $this->m_invoice->show($no_inv);
        $data = [
            'title_pdf' => 'Invoice No. ' . $no_inv,
            'invoice' => $inv,
            'details' => $this->m_invoice->item_list($inv['Id']),
            'user' => $this->m_invoice->cek_user($inv['user_create'])
        ];

        // filename dari pdf ketika didownload
        $file_pdf = 'Invoice No. ' . $no_inv;

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
                'harga' => $row['harga']
            ];
        }
        echo json_encode($items);
    }

    public function paid()
    {
        // print_r($_POST);
        // exit;
        $no_inv = $this->uri->segment(3);

        $inv =  $this->m_invoice->show($no_inv);
        $coa_debit = $this->input->post('coa_debit');
        $coa_kredit = $this->input->post('coa_kredit');
        $nominal_bayar = $this->convertToNumber(($this->input->post('nominal_bayar')));
        $keterangan = $this->input->post('keterangan');
        $status_bayar = $this->input->post('status_bayar');
        $tanggal_bayar = $this->input->post('tanggal_bayar');

        $nominal_j2 = $inv['subtotal'] - $inv['besaran_pph'];
        // if ($inv['besaran_ppn'] !== '0.00') {
        //     echo 'true';
        // } else {
        //     echo 'false';
        // }
        // exit;
        // kalau tidak 

        // J1: PAD berkurang sebesar nominal pendapatan, Pendapatan bertambah sebesar nominal pendapatan
        $j1_coa_debit = $inv['coa_kredit'];
        $j1_coa_kredit = $coa_kredit;
        $this->posting($j1_coa_debit, $j1_coa_kredit, $keterangan, $inv['nominal_pendapatan'], $tanggal_bayar);

        // J3: Kas/Bank bertambah sebesar nominal bayar, piutang usaha keluaran berkurang sebesar nominal bayar
        $j1_coa_debit = $coa_debit;
        $j1_coa_kredit = $inv['coa_debit'];
        $this->posting($j1_coa_debit, $j1_coa_kredit, $keterangan, $nominal_bayar, $tanggal_bayar);

        // J2: Kas/Bank bertambah sebesar ppn, ppn keluaran bertambah sebesar ppn keluaran
        if ($inv['besaran_ppn'] !== '0.00') {
            $j1_coa_debit = $inv['coa_debit'];
            $j1_coa_kredit = "23011";
            $this->posting($j1_coa_debit, $j1_coa_kredit, $keterangan, $inv['besaran_ppn'], $tanggal_bayar);

            $j2_coa_debit = $inv['coa_kredit'];
            $j2_coa_kredit = $inv['coa_debit'];
            $this->posting($j2_coa_debit, $j2_coa_kredit, $keterangan, $inv['besaran_ppn'], $tanggal_bayar);
        }

        if ($inv['opsi_pph23'] == '1') {
            // J4: Kas/Bank bertambah sebesar pph, utang pph 23 bertambah sebesar pph
            $j1_coa_debit = $coa_debit;
            $j1_coa_kredit = "23014";
            $this->posting($j1_coa_debit, $j1_coa_kredit, $keterangan, $inv['besaran_pph'], $tanggal_bayar);
        }

        $this->log_pembayaran("invoice", $inv['Id'], $nominal_bayar, $keterangan);

        $data_invoice = [
            'status_pendapatan' => ($status_bayar == 1) ? '2' : '1',
            'status_bayar' => ($status_bayar == 1) ? '1' : '0',
            'total_termin' => $inv['total_termin'] + $nominal_bayar,
            'tanggal_bayar' => $this->input->post('tanggal_bayar'),
        ];

        $this->m_invoice->update_invoice($inv['Id'], $data_invoice);

        $this->session->set_flashdata('message_name', 'The invoice has been successfully updated. ' . $no_inv);
        // After that you need to used redirect function instead of load view such as 
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

        // Saldo awal periode sebelumnya
        $last_periode = new DateTime($from);
        $last_periode->modify('-1 month');
        $last_periode = $last_periode->format('Y-m');
        $coaBefore = $this->cb->where('periode', $last_periode)->get('saldo_awal')->row_array()['coa'];
        $coa = json_decode($coaBefore);
        $saldo_awal = null;

        // Iterasi untuk mencari saldo awal
        foreach ($coa as $item) {
            if ($item->no_sbb == $no_coa) {
                $saldo_awal = $item->saldo_awal;
                break;
            }
        }

        // Hitung transaksi dari 1-14 November
        $mid_start = (new DateTime($from))->modify('first day of this month')->format('Y-m-d');
        $mid_end = (new DateTime($from))->modify('-1 day')->format('Y-m-d');

        $transactions_before = $this->m_coa->getCoaReport($no_coa, $mid_start, $mid_end);
        foreach ($transactions_before as $trans) {
            if ($trans->akun_debit == $no_coa) {
                $saldo_awal += $trans->jumlah_debit;
            } else {
                $saldo_awal -= $trans->jumlah_kredit;
            }
        }

        // Set saldo awal untuk 15 November
        $data['saldo_awal'] = ($saldo_awal) ? $saldo_awal : 0;
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
            'keterangan' => 'Saldo awal ' . format_indo($nextMonth)
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
            header('Content-Disposition: attachment;filename="Neraca per tanggal ' . format_indo($tanggal) . '.xls"');
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

    private function prepareLabaRugiReportByDate($data, $tanggal, $button_sbm = null)
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

            $data['biaya'] = $combinedBeban;
            $data['pendapatan'] = $combinedPendapatan;
            $data['sum_biaya'] = $total_beban;
            $data['sum_pendapatan'] = $total_pendapatan;
            $data['total_pendapatan'] = $total_pendapatan - $total_beban;
        } else {
            $this->session->set_flashdata('message_error', 'Closing bulan ' . format_indo($periode) . ' tidak ditemukan');
        }

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
}
