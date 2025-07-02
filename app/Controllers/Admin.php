<?php

namespace App\Controllers;

// Import semua model yang dibutuhkan
use App\Models\AlatModel;
use App\Models\PaketModel;
use App\Models\PelangganModel;
use App\Models\PekerjaModel;
use App\Models\PemesananModel;
use App\Models\PenyewaanModel;
use App\Models\SurveyModel;
use App\Models\PembayaranModel;
use App\Models\PengembalianModel;
use App\Models\UserModel;

// Import library pihak ketiga dan helper
use CodeIgniter\I18n\Time;
use Dompdf\Dompdf;

/**
 * Class Admin
 * Controller utama untuk semua fungsionalitas di dashboard admin.
 */
class Admin extends BaseController
{
    //======================================================================
    // HALAMAN UTAMA
    //======================================================================

    /**
     * Menampilkan halaman dashboard utama admin.
     */
    public function index()
    {
        return view('admin/dashboard');
    }

    //======================================================================
    // MANAJEMEN DATA MASTER (Entitas utama aplikasi)
    //======================================================================

    /**
     * Menampilkan halaman manajemen data pelanggan.
     */
    public function manajemenPengguna()
    {
        $model = new PelangganModel();
        $data = [
            'page_title' => 'Manajemen Pelanggan',
            'pelanggan_per_bulan' => $this->groupDataByMonth($model->findAll(), 'created_at')
        ];
        return view('admin/manajemen_pengguna', $data);
    }

    /**
     * Menampilkan halaman manajemen Alat Berat.
     */
    public function dataAlatBerat()
    {
        $model = new AlatModel();
        $data = [
            'page_title' => 'Manajemen Alat Berat',
            'alat_list'  => $model->where('kategori', 'Alat Berat')->findAll()
        ];
        return view('admin/alat', $data);
    }

    /**
     * Menampilkan halaman manajemen Material.
     */
    public function dataMaterial()
    {
        $model = new AlatModel();
        $data = [
            'page_title' => 'Manajemen Material',
            'alat_list'  => $model->where('kategori', 'Material')->findAll()
        ];
        return view('admin/alat', $data);
    }

    /**
     * Menampilkan halaman manajemen daftar paket.
     */
    public function cek_paket()
    {
        $paketModel = new PaketModel();
        $data = [
            'page_title' => 'Manajemen Paket',
            'pakets'     => $paketModel->findAll()
        ];
        return view('admin/cek_paket', $data);
    }

    /**
     * Menampilkan halaman ringkasan status pekerja.
     */
    public function cek_pekerja()
    {
        $model = new PekerjaModel();
        $data = [
            'page_title' => 'Cek Status Pekerja',
            'pekerja' => [
                'bekerja'  => $model->where('status_pekerja', 'bekerja')->countAllResults(),
                'tersedia' => $model->where('status_pekerja', 'tersedia')->countAllResults(),
            ]
        ];
        return view('admin/cek_pekerja_status', $data);
    }

    /**
     * Menampilkan halaman detail pekerja berdasarkan status.
     * @param string $status 'bekerja' atau 'tersedia'
     */
    public function cek_pekerja_detail($status = null)
    {
        if ($status !== 'bekerja' && $status !== 'tersedia') {
            return redirect()->to('admin/cek-pekerja')->with('error', 'Status pekerja tidak valid.');
        }

        $pekerjaModel = new PekerjaModel();
        $data = [
            'page_title'   => 'Detail Pekerja ' . ucfirst($status),
            'status'       => $status,
            'pekerja_list' => $pekerjaModel->where('status_pekerja', $status)->findAll()
        ];
        return view('admin/cek_pekerja_detail', $data);
    }

    //======================================================================
    // MANAJEMEN TRANSAKSI (Proses bisnis utama)
    //======================================================================

    /**
     * Menampilkan halaman manajemen data survey.
     */
    public function dataSurvey()
    {
        $surveyModel = new SurveyModel();
        $surveys = $surveyModel->getSurveysWithDetails();
        $data = [
            'page_title' => 'Manajemen Survey',
            'survey_per_bulan' => $this->groupDataByMonth($surveys, 'tanggal_survey')
        ];
        return view('admin/survey', $data);
    }

    /**
     * Menampilkan halaman manajemen data pemesanan.
     */
    public function dataPemesanan()
    {
        $model = new PemesananModel();
        $pemesananData = $model->select('pemesanan.*, pelanggan.nama_lengkap')
            ->join('pelanggan', 'pelanggan.id_pelanggan = pemesanan.id_pelanggan', 'left')
            ->orderBy('pemesanan.tanggal_pemesanan', 'DESC')
            ->findAll();
        $data = [
            'page_title' => 'Data Pemesanan',
            'pemesanan_per_bulan' => $this->groupDataByMonth($pemesananData, 'tanggal_pemesanan')
        ];
        return view('admin/pemesanan', $data);
    }

    /**
     * Menampilkan halaman manajemen data penyewaan.
     */
    public function dataPenyewaan()
    {
        $model = new PenyewaanModel();
        $penyewaanData = $model->getPenyewaanWithDetails();
        $data = [
            'page_title' => 'Data Penyewaan Alat',
            'penyewaan_per_bulan' => $this->groupDataByMonth($penyewaanData, 'tanggal_penyewaan')
        ];
        return view('admin/penyewaan', $data);
    }

    /**
     * Menampilkan halaman data pembayaran untuk pemesanan.
     */
    public function dataPembayaranPemesanan()
    {
        $model = new PembayaranModel();
        $data = [
            'page_title' => 'Data Pembayaran Pemesanan',
            'pembayaran_list' => $model->getPembayaranDetails('pemesanan'),
            'tipe' => 'pemesanan'
        ];
        return view('admin/pembayaran_data', $data);
    }

    /**
     * Menampilkan halaman data pembayaran untuk penyewaan.
     */
    public function dataPembayaranPenyewaan()
    {
        $model = new PembayaranModel();
        $data = [
            'page_title' => 'Data Pembayaran Penyewaan',
            'pembayaran_list' => $model->getPembayaranDetails('penyewaan'),
            'tipe' => 'penyewaan'
        ];
        return view('admin/pembayaran_data', $data);
    }

    /**
     * Menampilkan halaman data pengembalian alat.
     */
    public function dataPengembalian()
    {
        $model = new PengembalianModel();
        $data = [
            'page_title' => 'Data Pengembalian',
            'pengembalian_list' => $model->getPengembalianWithDetails()
        ];
        return view('admin/pengembalian', $data);
    }

    //======================================================================
    // MANAJEMEN LAPORAN
    //======================================================================

    /**
     * Menampilkan halaman laporan dengan filter.
     */
    public function laporan()
    {
        $db = \Config\Database::connect();
        $bulan = $this->request->getVar('bulan') ?? date('m');
        $tahun = $this->request->getVar('tahun') ?? date('Y');

        $builder1 = $db->table('pemesanan');
        $builder1->select("pemesanan.id_pesanan as id_transaksi, pelanggan.nama_lengkap as nama_pelanggan, pemesanan.tanggal_pemesanan as tanggal, pemesanan.harga_paketdipesan as total_harga, 'Pemesanan' as tipe_transaksi");
        $builder1->join('pelanggan', 'pelanggan.id_pelanggan = pemesanan.id_pelanggan');
        $builder1->where('MONTH(pemesanan.tanggal_pemesanan)', $bulan);
        $builder1->where('YEAR(pemesanan.tanggal_pemesanan)', $tahun);
        $query1 = $builder1->getCompiledSelect(false);

        $builder2 = $db->table('penyewaan');
        $builder2->select("penyewaan.id_sewa as id_transaksi, penyewaan.nama_penyewa as nama_pelanggan, penyewaan.tanggal_penyewaan as tanggal, penyewaan.harga_alatdisewa as total_harga, 'Penyewaan' as tipe_transaksi");
        $builder2->where('MONTH(penyewaan.tanggal_penyewaan)', $bulan);
        $builder2->where('YEAR(penyewaan.tanggal_penyewaan)', $tahun);
        $query2 = $builder2->getCompiledSelect();
        
        $laporanQuery = $db->query($query1 . ' UNION ALL ' . $query2 . ' ORDER BY tanggal DESC');

        $data = [
            'page_title' => 'Laporan Transaksi',
            'laporan'    => $laporanQuery->getResultArray(),
            'bulan'      => $bulan,
            'tahun'      => $tahun,
        ];
        return view('admin/laporan', $data);
    }

    /**
     * Memproses dan menghasilkan laporan dalam format PDF untuk diunduh.
     */
    public function cetakLaporanPdf()
    {
        $db = \Config\Database::connect();
        $bulan = $this->request->getGet('bulan') ?? date('m');
        $tahun = $this->request->getGet('tahun') ?? date('Y');

        $builder1 = $db->table('pemesanan');
        $builder1->select("pemesanan.id_pesanan as id_transaksi, pelanggan.nama_lengkap as nama_pelanggan, pemesanan.tanggal_pemesanan as tanggal, pemesanan.harga_paketdipesan as total_harga, 'Pemesanan' as tipe_transaksi");
        $builder1->join('pelanggan', 'pelanggan.id_pelanggan = pemesanan.id_pelanggan');
        $builder1->where('MONTH(pemesanan.tanggal_pemesanan)', $bulan);
        $builder1->where('YEAR(pemesanan.tanggal_pemesanan)', $tahun);
        $query1 = $builder1->getCompiledSelect(false);

        $builder2 = $db->table('penyewaan');
        $builder2->select("penyewaan.id_sewa as id_transaksi, penyewaan.nama_penyewa as nama_pelanggan, penyewaan.tanggal_penyewaan as tanggal, penyewaan.harga_alatdisewa as total_harga, 'Penyewaan' as tipe_transaksi");
        $builder2->where('MONTH(penyewaan.tanggal_penyewaan)', $bulan);
        $builder2->where('YEAR(penyewaan.tanggal_penyewaan)', $tahun);
        $query2 = $builder2->getCompiledSelect();
        
        $laporanQuery = $db->query($query1 . ' UNION ALL ' . $query2 . ' ORDER BY tanggal DESC');

        $data = [
            'laporan' => $laporanQuery->getResultArray(),
            'bulan'   => $bulan,
            'tahun'   => $tahun,
        ];

        $dompdf = new Dompdf();
        $html = view('admin/laporan_pdf', $data);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $namaBulan = Time::createFromDate($tahun, $bulan, 1)->toLocalizedString('MMMM');
        $nama_file = "Laporan Djaya Aspalt " . $namaBulan . " " . $tahun . ".pdf";
        $dompdf->stream($nama_file, ['Attachment' => 1]);
    }

    //======================================================================
    // MANAJEMEN PROFIL ADMIN
    //======================================================================
    
    /**
     * Menampilkan halaman profil admin yang sedang login.
     */
    public function adminProfile()
    {
        $userModel = new UserModel();
        $adminData = $userModel->find(session()->get('user_id'));
        $data = [
            'page_title' => 'Profil Admin', 'username' => $adminData['username'],
            'nama_lengkap' => $adminData['nama_lengkap'], 'email' => $adminData['email'],
            'no_telpon'  => $adminData['no_telpon'], 'alamat_rumah' => $adminData['alamat_rumah'],
            'foto_profil'  => $adminData['foto_profil']
        ];
        return view('admin/admin_profile', $data);
    }

    /**
     * Menampilkan form untuk mengedit profil admin.
     */
    public function editAdminProfile()
    {
        $userModel = new UserModel();
        $adminData = $userModel->find(session()->get('user_id'));
        $data = [
            'page_title' => 'Edit Profil Admin', 'username' => $adminData['username'],
            'nama_lengkap' => $adminData['nama_lengkap'], 'email' => $adminData['email'],
            'no_telpon'  => $adminData['no_telpon'], 'alamat_rumah' => $adminData['alamat_rumah'],
            'foto_profil'  => $adminData['foto_profil']
        ];
        return view('admin/edit_admin_profile', $data);
    }

    /**
     * Memproses update data profil admin.
     */
    public function updateAdminProfile()
    {
        $userModel = new UserModel();
        $id = session()->get('user_id');
        $data = [
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'email'        => $this->request->getPost('email'),
            'no_telpon'    => $this->request->getPost('no_telpon'),
            'alamat_rumah' => $this->request->getPost('alamat_rumah'),
        ];
        $foto = $this->request->getFile('foto_profil');
        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            $newName = $foto->getRandomName();
            $foto->move(WRITEPATH . 'uploads/avatars', $newName);
            $data['foto_profil'] = $newName;
        }
        $userModel->update($id, $data);
        session()->set('nama_lengkap', $data['nama_lengkap']);
        session()->set('email', $data['email']);
        if (isset($data['foto_profil'])) {
            session()->set('foto_profil', $data['foto_profil']);
        }
        session()->setFlashdata('success', 'Profil berhasil diperbarui.');
        return redirect()->to('admin/profile');
    }

    //======================================================================
    // FUNGSI-FUNGSI CRUD (Create, Read, Update, Delete)
    // Disatukan di sini agar rapi.
    //======================================================================

    // --- CRUD Pelanggan ---
    public function tambahPelanggan() { /* ... Logika Tambah Pelanggan ... */ }
    public function simpanPelanggan() { /* ... Logika Simpan Pelanggan ... */ }
    public function editPelanggan($id) { /* ... Logika Edit Pelanggan ... */ }
    public function updatePelanggan($id) { /* ... Logika Update Pelanggan ... */ }
    public function hapusPelanggan($id) { /* ... Logika Hapus Pelanggan ... */ }
    public function viewPelanggan($id) { /* ... Logika View Pelanggan ... */ }

    // --- CRUD Alat ---
    public function tambahAlat() { /* ... Logika Tambah Alat ... */ }
    public function simpanAlat() { /* ... Logika Simpan Alat ... */ }
    public function editAlat($id) { /* ... Logika Edit Alat ... */ }
    public function updateAlat($id) { /* ... Logika Update Alat ... */ }
    public function hapusAlat($id) { /* ... Logika Hapus Alat ... */ }

    // --- CRUD Paket ---
    public function tambahPaket() { /* ... Logika Tambah Paket ... */ }
    public function simpanPaket() { /* ... Logika Simpan Paket ... */ }
    public function editPaket($id) { /* ... Logika Edit Paket ... */ }
    public function updatePaket($id) { /* ... Logika Update Paket ... */ }
    public function hapusPaket($id) { /* ... Logika Hapus Paket ... */ }
    
    // --- CRUD Survey ---
    public function tambahSurvey() { /* ... Logika Tambah Survey ... */ }
    public function simpanSurvey() { /* ... Logika Simpan Survey ... */ }
    public function editSurvey($id) { /* ... Logika Edit Survey ... */ }
    public function updateSurvey($id) { /* ... Logika Update Survey ... */ }
    public function hapusSurvey($id) { /* ... Logika Hapus Survey ... */ }

    // --- CRUD Pemesanan ---
    public function tambahPemesanan() { /* ... Logika Tambah Pemesanan ... */ }
    public function simpanPemesanan() { /* ... Logika Simpan Pemesanan ... */ }
    public function editPemesanan($id) { /* ... Logika Edit Pemesanan ... */ }
    public function updatePemesanan($id) { /* ... Logika Update Pemesanan ... */ }
    public function hapusPemesanan($id) { /* ... Logika Hapus Pemesanan ... */ }

    // --- CRUD Penyewaan ---
    public function tambahPenyewaan() { /* ... Logika Tambah Penyewaan ... */ }
    public function simpanPenyewaan() { /* ... Logika Simpan Penyewaan ... */ }
    public function editPenyewaan($id) { /* ... Logika Edit Penyewaan ... */ }
    public function updatePenyewaan($id) { /* ... Logika Update Penyewaan ... */ }
    public function hapusPenyewaan($id) { /* ... Logika Hapus Penyewaan ... */ }

    // --- CRUD Pembayaran ---
    public function tambahPembayaranPemesanan() { /* ... Logika Tambah Bayar Pesan ... */ }
    public function tambahPembayaranPenyewaan() { /* ... Logika Tambah Bayar Sewa ... */ }
    public function simpanPembayaran() { /* ... Logika Simpan Pembayaran ... */ }
    public function lihatBukti($id_bayar) { /* ... Logika Lihat Bukti ... */ }

    // --- CRUD Pengembalian ---
    public function tambahPengembalian() { /* ... Logika Tambah Kembali ... */ }
    public function simpanPengembalian() { /* ... Logika Simpan Kembali ... */ }
    
    //======================================================================
    // FUNGSI HELPER & API
    //======================================================================
    
    /**
     * Helper function untuk mengelompokkan data berdasarkan bulan dan tahun.
     * @param array $data Data yang akan dikelompokkan
     * @param string $dateColumn Nama kolom tanggal sebagai acuan
     * @return array Data yang sudah dikelompokkan
     */
    private function groupDataByMonth($data, $dateColumn)
    {
        if (empty($data)) return [];
        $grouped = [];
        foreach ($data as $item) {
            $monthYear = Time::parse($item[$dateColumn])->toLocalizedString('MMMM YYYY');
            if (!isset($grouped[$monthYear])) {
                $grouped[$monthYear] = [];
            }
            $grouped[$monthYear][] = $item;
        }
        krsort($grouped); // Mengurutkan berdasarkan kunci (bulan-tahun) secara descending
        return $grouped;
    }

    /**
     * API endpoint untuk mengambil detail data alat via AJAX.
     * @param int $id_alat ID alat yang akan dicari
     * @return \CodeIgniter\HTTP\Response
     */
    public function getAlatDetail($id_alat)
    {
        $alatModel = new AlatModel();
        return $this->response->setJSON($alatModel->find($id_alat));
    }
}