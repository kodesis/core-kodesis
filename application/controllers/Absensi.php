<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Absensi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('Api_Whatsapp');
        $this->load->model('m_app');
        if ($this->session->userdata('isLogin') == FALSE) {
            $this->session->set_flashdata(
                'msg',
                '<div class="alert rounded-s bg-red-dark" role="alert">
                    Your session has been expired! Please login!
                    <button type="button" class="close color-white opacity-60 font-16" data-bs-dismiss="alert" aria-label="Close">&times;</button>
                </div>'

            );
            redirect('auth');
        }
    }
    public function list()
    {
        $a = $this->session->userdata('level');
        if (strpos($a, '401') !== false) {
            //inbox notif
            $nip = $this->session->userdata('nip');
            $sql = "SELECT COUNT(Id) FROM memo WHERE (nip_kpd LIKE '%$nip%' OR nip_cc LIKE '%$nip%') AND (`read` NOT LIKE '%$nip%');";
            $query = $this->db->query($sql);
            $res2 = $query->result_array();
            $result = $res2[0]['COUNT(Id)'];
            $data['count_inbox'] = $result;

            $sql3 = "SELECT COUNT(id) FROM task WHERE (`member` LIKE '%$nip%' or `pic` like '%$nip%') and activity='1'";
            $query3 = $this->db->query($sql3);
            $res3 = $query3->result_array();
            $result3 = $res3[0]['COUNT(id)'];
            $data['count_inbox2'] = $result3;

            $data['user'] = $this->m_app->user_get_detail($this->session->userdata('nip'));

            $this->db->select('*'); // Fetch only these columns
            $this->db->from('tblattendance'); // Table name
            $this->db->where('attendanceStatus', 'Pending');
            $data['notif'] = $this->db->get()->num_rows();

            $this->load->view('absensi_list', $data);
        } else {
            $this->session->set_flashdata('forbidden', 'Not Allowed!');
            redirect('home');
        }
    }

    public function ajax_list()
    {
        $this->load->model('absen_m', 'user');

        $list = $this->user->get_datatables();
        $data = array();
        $crs = "";
        $no = $_POST['start'];
        $months = [
            'Jan',
            'Feb',
            'Mar',
            'Apr',
            'Mei',
            'Jun',
            'Jul',
            'Agu',
            'Sep',
            'Okt',
            'Nov',
            'Des'
        ];

        foreach ($list as $cat) {
            $date = new DateTime($cat->date);

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $cat->nip;
            $row[] = $cat->nama;

            $monthIndex = (int) $date->format('n') - 1; // Get the month index (0-based)
            $row[] = $date->format('d') . ' ' . $months[$monthIndex] . ' ' . $date->format('Y');
            $row[] = $cat->waktu;
            $row[] = $cat->attendanceStatus;
            $row[] = $cat->lokasiAttendance;
            // $row[] = $cat->nama_lokasi;
            // $row[] = $cat->alamat_lokasi;
            $row[] = $cat->tipe;
            // $path = "https://mobileadmin.kodesis.id/upload/attendance/" . $cat->image;
            // $path = "https://mobile" . base_url() . "/upload/attendance/" . $cat->image;
            // $path = base_url("/upload/attendance/" . $cat->image);
            // $path = "https://mobileadmin.kodesis.id/upload/attendance/" . $cat->image;
            // Assume base_url() returns "https://admin.browser.id/"
            // $baseUrl = base_url();

            // // Replace "https://" with "https://mobile"
            // $newUrl = str_replace('https://', 'https://mobile', $baseUrl);

            // // If you want it to work for both HTTP and HTTPS:
            // // $newUrl = str_replace('//', '//mobile', $baseUrl);

            // $path = $newUrl . "upload/attendance/" . $cat->image;

            // Result: https://mobileadmin.browser.id/upload/attendance/image.jpg
            $path = base_url("/upload/attendance/" . $cat->image);
            // $row[] = "<img width='100px' src='" . $path . "'>";
            $row[] = "<img width='100px' src='" . $path . "'>";

            // $row[] = $date->format('d') . ' ' . $months[$monthIndex] . ' ' . $date->format('Y');


            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->user->count_all(),
            "recordsFiltered" => $this->user->count_filtered(),
            "data" => $data,
        );
        echo json_encode($output);
    }
    public function ajax_list2()
    {
        $this->load->model('absen_m', 'user');

        $list = $this->user->get_datatables2();
        $data = array();
        $crs = "";
        $no = $_POST['start'];
        $months = [
            'Jan',
            'Feb',
            'Mar',
            'Apr',
            'Mei',
            'Jun',
            'Jul',
            'Agu',
            'Sep',
            'Okt',
            'Nov',
            'Des'
        ];
        foreach ($list as $cat) {
            $date = new DateTime($cat->date);


            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $cat->nip;
            $row[] = $cat->nama;

            $monthIndex = (int) $date->format('n') - 1; // Get the month index (0-based)
            $row[] = $date->format('d') . ' ' . $months[$monthIndex] . ' ' . $date->format('Y');
            $row[] = $cat->waktu;

            $row[] = $cat->attendanceStatus;

            $row[] = $cat->lokasiAttendance;
            // $row[] = $cat->nama_lokasi;
            // $row[] = $cat->alamat_lokasi;
            $row[] = $cat->tipe;
            // $path = "https://mobileadmin.kodesis.id/upload/attendance/" . $cat->image;
            // $path = "https://mobile" . base_url() . "/upload/attendance/" . $cat->image;
            // $path = base_url("/upload/attendance/" . $cat->image);
            // $path = "https://mobileadmin.kodesis.id/upload/attendance/" . $cat->image;
            // Assume base_url() returns "https://admin.browser.id/"
            // $baseUrl = base_url();

            // // Replace "https://" with "https://mobile"
            // $newUrl = str_replace('https://', 'https://mobile', $baseUrl);

            // // If you want it to work for both HTTP and HTTPS:
            // // $newUrl = str_replace('//', '//mobile', $baseUrl);

            // $path = $newUrl . "upload/attendance/" . $cat->image;

            // Result: https://mobileadmin.browser.id/upload/attendance/image.jpg
            $path = base_url("/upload/attendance/" . $cat->image);
            // $row[] = "<img width='100px' src='" . $path . "'>";
            $row[] = "<img width='100px' src='" . $path . "'>";
            // $row[] = $date->format('d') . ' ' . $months[$monthIndex] . ' ' . $date->format('Y');



            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->user->count_all2(),
            "recordsFiltered" => $this->user->count_filtered2(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function ajax_list3()
    {
        $this->load->model('absen_m', 'user');

        $list = $this->user->get_datatables3();
        $data = array();
        $crs = "";
        $no = $_POST['start'];

        $months = [
            'Jan',
            'Feb',
            'Mar',
            'Apr',
            'Mei',
            'Jun',
            'Jul',
            'Agu',
            'Sep',
            'Okt',
            'Nov',
            'Des'
        ];

        foreach ($list as $cat) {
            $date = new DateTime($cat->date);


            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $cat->nip;
            $row[] = $cat->nama;

            $monthIndex = (int) $date->format('n') - 1; // Get the month index (0-based)
            $row[] = $date->format('d') . ' ' . $months[$monthIndex] . ' ' . $date->format('Y');
            $row[] = $cat->waktu;

            $row[] = $cat->attendanceStatus;
            $row[] = $cat->lokasiAttendance;
            // $row[] = $cat->nama_lokasi;
            // $row[] = $cat->alamat_lokasi;
            $row[] = $cat->tipe;
            // $path = "https://mobileadmin.kodesis.id/upload/attendance/" . $cat->image;
            // Assume base_url() returns "https://admin.browser.id/"
            // $baseUrl = base_url();

            // // Replace "https://" with "https://mobile"
            // $newUrl = str_replace('https://', 'https://mobile', $baseUrl);

            // // If you want it to work for both HTTP and HTTPS:
            // // $newUrl = str_replace('//', '//mobile', $baseUrl);

            // $path = $newUrl . "upload/attendance/" . $cat->image;

            // Result: https://mobileadmin.browser.id/upload/attendance/image.jpg
            $path = base_url("/upload/attendance/" . $cat->image);
            $row[] = "<img width='100px' src='" . $path . "'>";
            // $row[] = $date->format('d') . ' ' . $months[$monthIndex] . ' ' . $date->format('Y');
            if ($cat->attendanceStatus == 'Pending') {
                $row[] = '<center> <div class="list-icons d-inline-flex">
                <button title="Update User" onclick="onApprove(' . $cat->id . ')" class="btn btn-success"><svg xmlns="http://www.w3.org/2000/svg" width="38" height="38" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
  <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425z"/>
</svg></button>
                                                <button title="Delete User" onclick="onNotApprove(' . $cat->id . ')" class="btn btn-danger"><svg xmlns="http://www.w3.org/2000/svg" width="38" height="38" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
  <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
</svg></button>
            </div>
    </center>';
            } else {
                $row[] = 'Approved';
            }


            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->user->count_all3(),
            "recordsFiltered" => $this->user->count_filtered3(),
            "data" => $data,
        );
        echo json_encode($output);
    }
    public function ajax_list4()
    {
        $this->load->model('absen_m', 'user');

        $list = $this->user->get_datatables4();
        $data = array();
        $crs = "";
        $no = $_POST['start'];

        $months = [
            'Jan',
            'Feb',
            'Mar',
            'Apr',
            'Mei',
            'Jun',
            'Jul',
            'Agu',
            'Sep',
            'Okt',
            'Nov',
            'Des'
        ];

        foreach ($list as $cat) {
            $date = new DateTime($cat->date);


            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $cat->nip;
            $row[] = $cat->nama;

            $monthIndex = (int) $date->format('n') - 1; // Get the month index (0-based)
            $row[] = $date->format('d') . ' ' . $months[$monthIndex] . ' ' . $date->format('Y');
            $row[] = $cat->waktu;

            $row[] = $cat->attendanceStatus;
            $row[] = $cat->lokasiAttendance;
            // $row[] = $cat->nama_lokasi;
            // $row[] = $cat->alamat_lokasi;
            $row[] = $cat->tipe;
            // $path = "https://mobileadmin.kodesis.id/upload/attendance/" . $cat->image;
            // Assume base_url() returns "https://admin.browser.id/"
            // $baseUrl = base_url();

            // // Replace "https://" with "https://mobile"
            // $newUrl = str_replace('https://', 'https://mobile', $baseUrl);

            // // If you want it to work for both HTTP and HTTPS:
            // // $newUrl = str_replace('//', '//mobile', $baseUrl);

            // $path = $newUrl . "upload/attendance/" . $cat->image;

            // Result: https://mobileadmin.browser.id/upload/attendance/image.jpg
            $path = base_url("/upload/attendance/" . $cat->image);
            $row[] = "<img width='100px' src='" . $path . "'>";
            // $row[] = $date->format('d') . ' ' . $months[$monthIndex] . ' ' . $date->format('Y');

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->user->count_all4(),
            "recordsFiltered" => $this->user->count_filtered4(),
            "data" => $data,
        );
        echo json_encode($output);
    }
    public function approval($tipe, $id)
    {
        $this->load->model('absen_m', 'user');

        if ($tipe == "Approved") {
            $status = 'Present';
        } else {
            $status = 'Absent';
        }
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $this->user->update(
            array(
                'attendanceStatus'      => $status,
            ),
            array('id' => $id)
        );
        echo json_encode(array("status" => TRUE));
    }
    public function process_export()
    {
        // $tanggal = $this->input->post('tanggal');
        // list($month, $year) = explode('/', $tanggal);
        $tanggal_mulai = $this->input->post('tanggal_mulai');
        $tanggal_akhir = $this->input->post('tanggal_akhir');

        $data_absensi = $this->input->post('data_absensi');
        require APPPATH . 'third_party/autoload.php';

        // Include PhpSpreadsheet from third_party
        require APPPATH . 'third_party/psr/simple-cache/src/CacheInterface.php';

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set header columns
        $sheet->setCellValue('A1', 'Nomor');
        $sheet->setCellValue('B1', 'Username');
        $sheet->setCellValue('C1', 'Nip');
        $sheet->setCellValue('D1', 'FullName');
        $sheet->setCellValue('E1', 'Status');
        $sheet->setCellValue('F1', 'Lokasi');
        $sheet->setCellValue('G1', 'Tipe');
        $sheet->setCellValue('H1', 'Tanggal');
        $sheet->setCellValue('I1', 'Waktu');
        // $sheet->setCellValue('J1', 'Image');

        // Get data from the database
        $this->load->database();
        if ($data_absensi == 'Team') {
            $this->db->select('tblattendance.*,users.bagian');
        } else {
            $this->db->select('tblattendance.*');
        }
        $this->db->from('tblattendance'); // Replace with your table name
        // $this->db->where('YEAR(date)', $year);
        // $this->db->where('MONTH(date)', $month);
        $this->db->where('date >=', $tanggal_mulai);
        $this->db->where('date <=', $tanggal_akhir);
        if ($data_absensi == 'User') {
            $this->db->where('username', $this->session->userdata('username'));
        } else if ($data_absensi == 'Team') {
            $this->db->where('bagian', $this->session->userdata('bagian'));
            $this->db->join('users', 'users.username = tblattendance.username');
        }
        $query = $this->db->get();
        $rows = $query->result_array();

        // Populate rows with data
        $nomor = 1;
        $rowNumber = 2; // Start at row 2 because row 1 is the header
        foreach ($rows as $row) {
            $sheet->setCellValue('A' . $rowNumber, $nomor);
            $sheet->setCellValue('B' . $rowNumber, $row['username']);
            $sheet->setCellValue('C' . $rowNumber, $row['nip']);
            $sheet->setCellValue('D' . $rowNumber, $row['nama']);
            $sheet->setCellValue('E' . $rowNumber, $row['attendanceStatus']);
            $sheet->setCellValue('F' . $rowNumber, $row['lokasiAttendance']);
            $sheet->setCellValue('G' . $rowNumber, $row['tipe']);
            $sheet->setCellValue('H' . $rowNumber, $row['date']);
            $sheet->setCellValue('I' . $rowNumber, $row['waktu']);
            // if (!empty($row['image'])) {
            //     $imagePath = FCPATH . 'upload' . DIRECTORY_SEPARATOR . 'attendance' . DIRECTORY_SEPARATOR . $row['image'];

            //     // Check if the image exists
            //     if (file_exists($imagePath)) {
            //         // If the image exists, insert it into the spreadsheet
            //         $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
            //         $drawing->setName('Attendance Image');
            //         $drawing->setDescription('Attendance Image');
            //         $drawing->setPath($imagePath);  // Set the path to the image
            //         $drawing->setHeight(100); // Optional: Set the image height (you can adjust this)
            //         $drawing->setCoordinates('J' . $rowNumber); // Set the position of the image in the sheet
            //         $drawing->setWorksheet($sheet); // Attach the image to the worksheet
            //     } else {
            //         // If the image is not found, set a message or placeholder
            //         $sheet->setCellValue('J' . $rowNumber, 'Image not found');  // Display a placeholder text in the cell
            //     }
            // } else {
            //     $sheet->setCellValue('J' . $rowNumber, 'Image Null');  // Display a placeholder text in the cell
            // }
            $sheet->getRowDimension($rowNumber)->setRowHeight(80);
            $rowNumber++;
            $nomor++;
        }

        $sheet->getColumnDimension('A')->setWidth(3); // Set width kolom A
        $sheet->getColumnDimension('B')->setWidth(15); // Set width kolom B
        $sheet->getColumnDimension('C')->setWidth(15); // Set width kolom C
        $sheet->getColumnDimension('D')->setWidth(15); // Set width kolom D
        $sheet->getColumnDimension('E')->setWidth(15); // Set width kolom E
        $sheet->getColumnDimension('F')->setWidth(15); // Set width kolom D
        $sheet->getColumnDimension('G')->setWidth(18); // Set width kolom E
        $sheet->getColumnDimension('H')->setWidth(18); // Set width kolom E
        $sheet->getColumnDimension('I')->setWidth(18); // Set width kolom E
        // $sheet->getColumnDimension('J')->setWidth(25); // Set width kolom E

        // Set the filename and save the file
        $fileName = 'Export_' . date('Y-m-d_H-i-s') . '.xlsx';
        require APPPATH . 'third_party/autoload_zip.php';

        // Now PhpSpreadsheet's Xlsx writer can use ZipStream
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $filePath = FCPATH . 'downloads/' . $fileName; // Save to a downloads folder

        // Set headers to force download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        // header('Content-Disposition: attachment; filename="Absensi_' . $month . '_' . $year . '.xlsx"');
        header('Content-Disposition: attachment; filename="Absensi_Export_' . date('d-M-Y')  . '.xlsx"');
        header('Cache-Control: max-age=0');


        // Save the file to the browser for download
        $writer->save('php://output');

        // After the file is downloaded, perform the redirection to a list page or display a message
        exit(); // Terminate script after download is complete
    }

    public function process_export_new()
    {
        $this->load->model('absen_m', 'user');

        // $tanggal = $this->input->post('tanggal');
        // list($month, $year) = explode('/', $tanggal);
        // $tanggal_mulai = $this->input->post('tanggal_mulai');
        // $tanggal_akhir = $this->input->post('tanggal_akhir');
        $start_date_str = $this->input->post('tanggal_mulai');
        $end_date_str = $this->input->post('tanggal_akhir');

        $data_absensi = $this->input->post('data_absensi');
        require APPPATH . 'third_party/autoload.php';
        require APPPATH . 'third_party/autoload_zip.php';

        // Include PhpSpreadsheet from third_party
        require APPPATH . 'third_party/psr/simple-cache/src/CacheInterface.php';

        $users = $this->user->get_user_export($data_absensi, $start_date_str, $end_date_str);

        $raw_attendance = $this->user->get_Absensi_export($start_date_str, $end_date_str);

        // echo $start_date_str;
        // echo $end_date_str;
        // var_dump($raw_attendance);
        // B. Generate Date Range
        $date_range = [];
        $current = new DateTime($start_date_str);
        $end = new DateTime($end_date_str);
        while ($current <= $end) {
            $date_range[] = $current->format('Y-m-d');
            $current->modify('+1 day');
        }

        // C. Organize Data for Lookup
        $organized_attendance = [];
        foreach ($raw_attendance as $record) {
            $userId = $record['nip'];
            $date = $record['date'];
            $type = $record['tipe'];
            $jam_absen = $record['jam_absen'];
            $time = substr($record['waktu'], 0, 5);

            // if (!isset($organized_attendance[$userId][$date])) {
            //     $organized_attendance[$userId][$date] = ['Masuk' => null, 'Pulang' => null];
            // }

            $is_late = false;
            // if ($type === 'Masuk') {
            //     // Find the user's late threshold (better to join this in the model query)
            //     $user_data = array_filter($users, fn($u) => $u['id'] === $userId);
            //     $threshold = reset($user_data)['time'] ?? '09:00:00';
            //     $is_late = ($record['time'] > $threshold);
            // }

            if ($type == 'Telat') {
                $is_late = true;
            }

            $organized_attendance[$userId][$date][$type] = [
                'time' => $time,
                'is_late' => $is_late,
            ];
        }

        // --- 3. PHPSPREADSHEET GENERATION ---

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Define a universal thin border style
        $style_border = ['borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]]];

        // --- DEFINE STYLES ---
        $style_header = [
            'font' => ['bold' => true],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
            // Using fully qualified namespace for Fill
            'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFEFEFEF']], // Light Gray
            'borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]],
        ];

        // Green style: Add border
        $style_green = array_merge($style_border, ['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF84CC16']]]);
        // Yellow style: Add border
        $style_yellow = array_merge($style_border, ['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFFDE047']]]);
        // Red style: Add border
        $style_red = array_merge($style_border, ['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFF87171']]]);

        // --- WRITE HEADER (Rows 1 & 2) ---

        // 1. Main Header Row (No, Nama/Waktu, Tanggal)
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Nama / Waktu');
        $sheet->mergeCells('A1:A2'); // Merge No column
        $sheet->mergeCells('B1:B2'); // Merge Nama/Waktu column

        $date_col_start_index = 3; // C column
        $date_col_end_index = $date_col_start_index + count($date_range) - 1;

        $date_col_start = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($date_col_start_index);
        $date_col_end = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($date_col_end_index);

        $sheet->setCellValue($date_col_start . '1', 'Tanggal');
        if (count($date_range) > 1) {
            $sheet->mergeCells($date_col_start . '1:' . $date_col_end . '1');
        }

        // 2. Date Day Numbers (Row 2)
        $col_index = $date_col_start_index;
        foreach ($date_range as $date) {
            $cell_coord = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col_index) . '2';
            $sheet->setCellValue($cell_coord, date('j', strtotime($date)));
            $col_index++;
        }

        // Apply header style to the entire header block
        $sheet->getStyle('A1:' . $date_col_end . '2')->applyFromArray($style_header);


        // --- WRITE DATA (Rows 3 onwards) ---
        $row_index = 3;
        $user_no = 1;

        foreach ($users as $user) {
            $user_id = $user['nip'];
            $user_name = $user['nama'];

            // MASUK Row (e.g., Row 3 for Dimas)
            $sheet->setCellValue('B' . $row_index, $user_name . "\nMasuk"); // B3 (Nama/Masuk)
            $sheet->getStyle('B' . $row_index)->getAlignment()->setWrapText(true);
            // Apply border to the Name/Time column
            $sheet->getStyle('B' . $row_index)->applyFromArray($style_border);

            $col_index = $date_col_start_index;
            foreach ($date_range as $date) {
                $record = $organized_attendance[$user_id][$date]['Masuk'] ?? null;
                $time = $record['time'] ?? '';

                $cell_name = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col_index) . $row_index;

                if (!empty($time)) {
                    $sheet->setCellValue($cell_name, $time);
                    // Apply Green (On Time) or Yellow (Telat)
                    $style = $record['is_late'] ? $style_yellow : $style_green;
                    $sheet->getStyle($cell_name)->applyFromArray($style);
                } else {
                    $sheet->setCellValue($cell_name, '-');
                    // Apply Red (Absent)
                    $sheet->getStyle($cell_name)->applyFromArray($style_red);
                }
                $col_index++;
            }
            $row_index++; // Move to the Pulang row

            // PULANG Row (e.g., Row 4 for Dimas)
            $sheet->setCellValue('B' . $row_index, 'Pulang'); // B4 (Pulang)
            // Apply border to the Name/Time column
            $sheet->getStyle('B' . $row_index)->applyFromArray($style_border);

            $col_index = $date_col_start_index;
            foreach ($date_range as $date) {
                $record = $organized_attendance[$user_id][$date]['Pulang'] ?? null;
                $time = $record['time'] ?? '';

                $cell_name = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col_index) . $row_index;

                if (!empty($time)) {
                    $sheet->setCellValue($cell_name, $time);
                    // Always Green if recorded
                    $sheet->getStyle($cell_name)->applyFromArray($style_green);
                } else {
                    $sheet->setCellValue($cell_name, '-');
                    // Apply Red (Absent)
                    $sheet->getStyle($cell_name)->applyFromArray($style_red);
                }
                $col_index++;
            }

            // Merge the 'No' column cells
            $start_row = $row_index - 1;
            $end_row = $row_index;
            $sheet->setCellValue('A' . $start_row, $user_no);
            $sheet->mergeCells('A' . $start_row . ':A' . $end_row);
            // Apply border to the merged 'No' column
            $sheet->getStyle('A' . $start_row . ':A' . $end_row)->applyFromArray($style_border);

            $row_index++; // Move to the next user's Masuk row
            $user_no++;
        }

        // Auto size columns for better readability
        foreach (range('A', $date_col_end) as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }
        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(15);
        $spreadsheet->getDefaultStyle()->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('B3:B' . ($row_index - 1))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);


        // --- 4. OUTPUT THE FILE ---

        $filename = 'Laporan_Absensi_' . date('Ymd', strtotime($start_date_str)) . '_to_' . date('Ymd', strtotime($end_date_str)) . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        // Using fully qualified namespace for Xlsx writer
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
}
