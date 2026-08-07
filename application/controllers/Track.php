<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * application/controllers/Track.php
 * Lacak SMU dari tabel out_list. Halaman publik, tanpa login.
 */
class Track extends CI_Controller
{
    /** Kolom nomor SMU di tabel out_list — ganti bila namanya berbeda */
    private $kol_smu = 'smu';

    /** Tahapan: kode => [kolom petugas, kolom tanggal] */
    private $tahap = array(
        'diterima' => array('in_p',  'in_date'),
        'btb'      => array('btb_p', 'btb_date'),
        'invoice'  => array('out_p', 'out_date'),
        'terbang'  => array('fly_p', 'fly_date'),
    );

    public function __construct()
    {
        parent::__construct();
        $this->cb = $this->load->database('corebank', TRUE);
        // $this->load->helper('terbilang');
    }

    public function index()
    {
        $q    = trim((string) $this->input->get('q'));
        $data = array('q' => $q);

        if ($q !== '') {
            $row = $this->cb->get_where('out_list', array($this->kol_smu => $q))->row_array();

            if (!$row) {
                $data['notfound'] = true;
            } else {
                // --- Header SMU: sesuaikan nama kolom di kanan bila berbeda ---
                $data['smu'] = array(
                    'no_smu'      => $this->kol($row, $this->kol_smu),
                    'shipper'     => $this->kol($row, 'nama_agent'),
                    'consignee'   => $this->kol($row, 'nama_penerima'),
                    // 'origin'      => $this->kol($row, 'asal'),
                    'origin'      => 'HLP',
                    'destination' => $this->kol($row, 'tujuan'),
                    'origin_kota' => $this->kol($row, 'origin_kota', ''),
                    'dest_kota'   => $this->kol($row, 'dest_kota', ''),
                    'koli'        => $this->kol($row, 'jumlah'),
                    'berat'       => $this->kol($row, 'gross'),
                    'komoditi'    => $this->kol($row, 'komoditi'),
                    'flight'      => $this->kol($row, 'no_pesawat'),
                    'etd'         => $this->tgl($this->kol($row, 'fly_date', null)),
                );

                // --- Riwayat dari kolom *_date / *_p ---
                $riwayat = array();
                foreach ($this->tahap as $kode => $k) {
                    list($kol_p, $kol_d) = $k;
                    $tgl = isset($row[$kol_d]) ? $row[$kol_d] : null;

                    if ($this->kosong($tgl)) continue;

                    $riwayat[] = array(
                        'kode'    => $kode,
                        'waktu'   => $this->tgl($tgl),
                        'petugas' => isset($row[$kol_p]) ? $row[$kol_p] : '',
                        'lokasi'  => '',
                        'catatan' => '',
                    );
                }
                $data['riwayat'] = $riwayat;
            }
        }

        $this->load->view('track_view', $data);
    }

    /** Ambil kolom bila ada, tanpa notice */
    private function kol($row, $nama, $default = '-')
    {
        return (isset($row[$nama]) && $row[$nama] !== '' && $row[$nama] !== null) ? $row[$nama] : $default;
    }

    /** Tanggal kosong / 0000-00-00 / null dianggap belum terjadi */
    private function kosong($tgl)
    {
        if ($tgl === null || $tgl === '' || $tgl === '0') return true;
        return (strpos((string) $tgl, '0000-00-00') === 0);
    }

    /** Format tanggal Indonesia, jam ditampilkan hanya bila ada */
    private function tgl($tgl)
    {
        if ($this->kosong($tgl)) return '-';
        $ts = strtotime($tgl);
        if (!$ts) return $tgl;
        $punya_jam = (strlen((string) $tgl) > 10 && date('H:i', $ts) !== '00:00');
        return date($punya_jam ? 'd M Y H:i' : 'd M Y', $ts);
    }
}
