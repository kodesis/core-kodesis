<?php if (!defined('BASEPATH')) exit('Hacking Attempt : Keluar dari sistem..!!');

class M_login extends CI_Model
{

  public function __construct()
  {
    parent::__construct();
  }

  var $client_service = "frontend-client";
  var $auth_key       = "simplerestapi";

  public function ambilPengguna($username, $status) //, $level)
  {
    $this->db->select('*');
    $this->db->from('users');
    $this->db->where('username', $username);
    //$this->db->where('password', $password);
    $this->db->where('status', $status);
    $query = $this->db->get();

    return $query->num_rows();
  }

  public function password()
  {
  }

  public function dataPengguna($username)
  {
    $this->db->select('*');
    $this->db->where('username', $username);
    $query = $this->db->get('users');

    return $query->row();
  }

  public function utility()
  {
    $this->db->select('*');
    $this->db->where('Id', 1);
    $query = $this->db->get('utility');

    return $query->row();
  }

  public function check_auth_client()
  {
    $client_service = $this->input->get_request_header('Client-Service', TRUE);
    $auth_key  = $this->input->get_request_header('Auth-Key', TRUE);

    if ($client_service == $this->client_service && $auth_key == $this->auth_key) {
      return true;
    } else {
      return json_output(401, array('status' => 401, 'message' => 'Unauthorized.'));
    }
  }

  public function auth_api()
  {
    $users_id  = $this->input->get_request_header('User-ID', TRUE);
    $token     = $this->input->get_request_header('Authorization', TRUE);
    $q  = $this->cb->select('expired_at')->from('users_authentication')->where('users_id', $users_id)->where('token', $token)->get()->row();
    if ($q == "") {
      return json_output(401, array('status' => 401, 'message' => 'Unauthorized.'));
    } else {
      if ($q->expired_at < date('Y-m-d H:i:s')) {
        return json_output(401, array('status' => 401, 'message' => 'Your session has been expired.'));
      } else {
        $updated_at = date('Y-m-d H:i:s');
        $expired_at = date("Y-m-d H:i:s", strtotime('+12 hours'));

        $update = $this->cb->where('users_id', $users_id)
          ->where('token', $token)
          ->update('users_authentication', [
            'expired_at' => $expired_at,
            'updated_at' => $updated_at
          ]);

        if (!$update) {
          return json_output(500, ['status' => 500, 'message' => 'Gagal update token.']);
        }

        return array('status' => 200, 'message' => 'Authorized.');
      }
    }
  }
}
