<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Absen_WFH extends CI_Controller
{

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */
	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('user_logged_in')) {
			redirect('auth'); // Redirect to the 'autentic' page
		}
		$this->load->model('Absen_m', 'user');
	}
	public function index()
	{
		$data['data_user'] = $this->user->get_user();
		$this->load->view('home_view', $data);
	}
	public function fetch_user()
	{
		$users = $this->user->get_user(); // Fetch all users from the database

		if ($users) {
			// Load the user table view and capture its output
			$data['users'] = $users;
			$tableHTML = $this->load->view('userTable', $data, TRUE);

			echo json_encode([
				'status' => 'success',
				'data' => $users,
				'html' => $tableHTML
			]);
		} else {
			echo json_encode([
				'status' => 'error',
				'message' => 'No records found'
			]);
		}
	}
}
