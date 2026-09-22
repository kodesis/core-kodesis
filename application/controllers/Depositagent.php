<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Halaman "Deposit Saya" untuk Agent / Tamu.
 * User hanya bisa melihat akun di all_agent_deposit yang user_pic = NIP login.
 *
 * URL: /depositagent
 */
class Depositagent extends CI_Controller
{
    private $limit_riwayat = 20;

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper(['url']);
        $this->load->model('M_deposit_agent');

        if (!$this->session->userdata('nip')) {
            redirect('login');
        }

        $a = $this->session->userdata('level');
        if (strpos($a, '931') === false) {
            redirect('home');
        }
    }

    // =============================================
    // HALAMAN UTAMA
    // =============================================
    public function index()
    {
        $nip = $this->session->userdata('nip');

        $data['count_inbox']   = $this->M_deposit_agent->count_inbox($nip);
        $data['count_inbox2']  = $this->M_deposit_agent->count_task($nip);
        $data['akun']          = $this->M_deposit_agent->get_akun_saya($nip);
        $data['limit_riwayat'] = $this->limit_riwayat;
        $data['title']         = 'Deposit Saya';

        $this->load->view('agent_deposit_saya', $data);
    }

    // =============================================
    // AJAX: RIWAYAT 20 TRANSAKSI TERBARU
    // =============================================
    public function get_riwayat()
    {
        $nip       = $this->session->userdata('nip');
        $agent_uid = $this->input->post('agent_uid', TRUE);

        // Wajib: cek kepemilikan agar agent tidak bisa intip akun lain
        if (empty($agent_uid) || !$this->M_deposit_agent->is_owned_by($agent_uid, $nip)) {
            return $this->_json([
                'status'  => 'error',
                'message' => 'Akun deposit ini tidak terdaftar atas nama Anda.',
            ], 403);
        }

        $saldo = $this->M_deposit_agent->get_saldo($agent_uid);
        $rows  = $this->M_deposit_agent->get_riwayat_terbaru($agent_uid, $this->limit_riwayat);

        // Sisa saldo dihitung mundur dari saldo akhir,
        // jadi tetap akurat walau hanya 20 data yang diambil.
        $sisa = $saldo;
        $data = [];

        foreach ($rows as $r) {
            $topup    = (float) $r->topup_saldo;
            $usage    = (float) $r->usage_saldo;
            $is_topup = trim((string) $r->kode) !== '';

            $data[] = [
                'tanggal'    => $this->_format_tanggal($r->post_date),
                'jenis'      => $is_topup ? 'topup' : 'usage',
                'keterangan' => $is_topup ? 'Topup #' . $r->kode : 'Penggunaan saldo',
                'no_invoice' => $r->no_invoice ?: '-',
                'topup'      => $topup,
                'usage'      => $usage,
                'sisa'       => $sisa,
                'kasir'      => $r->nama_kasir ?: '-',
            ];

            $sisa -= ($topup - $usage);
        }

        return $this->_json([
            'status' => 'ok',
            'saldo'  => $saldo,
            'data'   => $data,
        ]);
    }

    // =============================================
    // HELPER
    // =============================================
    private function _json($payload, $code = 200)
    {
        return $this->output
            ->set_status_header($code)
            ->set_content_type('application/json')
            ->set_output(json_encode($payload));
    }

    /** post_date disimpan sebagai YmdHis (contoh: 20260922143000) */
    private function _format_tanggal($value)
    {
        if (empty($value)) return '-';

        $dt = DateTime::createFromFormat('YmdHis', $value);
        if ($dt) return $dt->format('d/m/Y H:i');

        $ts = strtotime($value);
        return $ts ? date('d/m/Y H:i', $ts) : $value;
    }
}
