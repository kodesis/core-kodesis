<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Model khusus halaman "Deposit Saya" untuk Agent / Tamu.
 * Terpisah dari M_depositwh agar tidak mengganggu fitur admin.
 */
class M_deposit_agent extends CI_Model
{
    /** @var CI_DB_query_builder */
    private $cb;

    public function __construct()
    {
        parent::__construct();
        $this->cb = $this->load->database('corebank', TRUE);
    }

    // =============================================
    // BADGE HEADER (inbox memo & task)
    // =============================================

    public function count_inbox($nip)
    {
        $like = '%' . $nip . '%';
        $sql  = "SELECT COUNT(Id) AS total FROM memo
		         WHERE (nip_kpd LIKE ? OR nip_cc LIKE ?) AND (`read` NOT LIKE ?)";

        return (int) $this->db->query($sql, [$like, $like, $like])->row()->total;
    }

    public function count_task($nip)
    {
        $like = '%' . $nip . '%';
        $sql  = "SELECT COUNT(id) AS total FROM task
		         WHERE (`member` LIKE ? OR `pic` LIKE ?) AND activity = '1'";

        return (int) $this->db->query($sql, [$like, $like])->row()->total;
    }

	// =============================================
	// AKUN DEPOSIT MILIK USER (berdasarkan user_pic)
	// =============================================

    /** Semua akun deposit yang PIC-nya adalah NIP ini, beserta saldo terkini */
    public function get_akun_saya($nip)
    {
        $sql = "SELECT
		            a.uid,
		            a.kode,
		            a.nama,
		            a.telepon,
		            a.hold,
		            (SELECT COALESCE(SUM(t.topup_saldo), 0) - COALESCE(SUM(t.usage_saldo), 0)
		               FROM all_topup t
		              WHERE t.agent_uid = a.uid) AS saldo
		        FROM all_agent_deposit a
		        WHERE a.user_pic = ?
		        ORDER BY a.nama ASC";

        return $this->cb->query($sql, [$nip])->result();
    }

    /** Pastikan akun deposit benar milik NIP ini */
    public function is_owned_by($agent_uid, $nip)
    {
        return $this->cb->from('all_agent_deposit')
            ->where('uid', $agent_uid)
            ->where('user_pic', $nip)
            ->count_all_results() > 0;
    }

    /** Info singkat satu akun (nama & kode) */
    public function get_akun($agent_uid)
    {
        return $this->cb->select('uid, kode, nama')
            ->where('uid', $agent_uid)
            ->get('all_agent_deposit')
            ->row();
    }

    /** Saldo akhir akun saat ini */
    public function get_saldo($agent_uid)
    {
        $row = $this->cb->query(
            "SELECT COALESCE(SUM(topup_saldo), 0) - COALESCE(SUM(usage_saldo), 0) AS saldo
			   FROM all_topup
			  WHERE agent_uid = ?",
            [$agent_uid]
        )->row();

        return (float) ($row->saldo ?? 0);
    }

	// =============================================
	// RIWAYAT TERBARU (topup + penggunaan)
	// =============================================

    /**
     * N transaksi terbaru, urut dari yang paling baru.
     * No invoice & nama kasir diambil langsung dalam satu query (tanpa N+1).
     */
    public function get_riwayat_terbaru($agent_uid, $limit = 20)
    {
        $limit    = max(1, (int) $limit);
        $db_users = $this->db->database; // database default tempat tabel users

        $sql = "SELECT
		            t.uid,
		            t.kode,
		            t.topup_saldo,
		            t.usage_saldo,
		            t.post_date,
		            t.asal_table,
		            CASE t.asal_table
		                WHEN 'out_billing'            THEN (SELECT b.no_invoice FROM out_billing b            WHERE b.uid = t.billing_uid LIMIT 1)
		                WHEN 'in_billing'             THEN (SELECT b.no_invoice FROM in_billing b             WHERE b.uid = t.billing_uid LIMIT 1)
		                WHEN 'out_billing_inv_khusus' THEN (SELECT b.no_invoice FROM out_billing_inv_khusus b WHERE b.uid = t.billing_uid LIMIT 1)
		                ELSE NULL
		            END AS no_invoice,
		            u.nama AS nama_kasir
		        FROM all_topup t
		        LEFT JOIN `{$db_users}`.users u
		               ON u.nip = IF(t.kode IS NOT NULL AND t.kode <> '', t.user_topup, t.user_kasir)
		        WHERE t.agent_uid = ?
		        ORDER BY t.post_date DESC, t.uid DESC
		        LIMIT {$limit}";

        return $this->cb->query($sql, [$agent_uid])->result();
    }
}
