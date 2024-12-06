<?php defined('BASEPATH') or exit('No direct script access allowed');

class Absen_m extends CI_Model
{
    public function get_user()
    {
        $this->db->select('*'); // Fetch only these columns
        $this->db->from('users'); // Table name
        $this->db->where('userImage !=', NULL);
        $this->db->where('userImage !=', '');
        $query = $this->db->get();

        return $query->result_array(); // Return the result as an array
    }
    public function check_registration_exists($username)
    {
        $this->db->where('username', $username);
        return $this->db->count_all_results('users') > 0;
    }
    public function insertAttendance($attendanceData)
    {
        $response = ['status' => 'error', 'message' => 'No data provided'];

        if (!empty($attendanceData)) {
            try {
                foreach ($attendanceData as $data) {
                    $this->db->insert('tblattendance', [
                        'username' => $data['username'],
                        'nama' => $data['nama'],
                        'attendanceStatus' => $data['attendanceStatus'],
                        'date' => date("Y-m-d")
                    ]);
                }

                $response['status'] = 'success';
                $response['message'] = "Attendance recorded successfully for all entries.";
            } catch (Exception $e) {
                $response['status'] = 'error';
                $response['message'] = "Error inserting attendance data: " . $e->getMessage();
            }
        }

        return $response;
    }
}
