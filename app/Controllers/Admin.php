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
    // HALAMAN UTAMA & VIEW DASAR
    //======================================================================

    public function index()
    {
        return view('admin/dashboard');
    }

    public function manajemenPengguna()
    {
        $model = new PelangganModel();
        $data = [
            'page_title' => 'Manajemen Pelanggan',
            'pelanggan_per_bulan' => $this->groupDataByMonth($model->orderBy('created_at', 'DESC')->findAll(), 'created_at')
        ];
        return view('admin/manajemen_pengguna', $data);
    }

    public function dataAlatBerat()
    {
        $model = new AlatModel();
        $data = [
            'page_title' => 'Manajemen Alat Berat',
            'alat_list'  => $model->where('kategori', 'Alat Berat')->findAll()
        ];
        return view('admin/alat', $data);
    }

    public function dataMaterial()
    {
        $model = new AlatModel();
        $data = [
            'page_title' => 'Manajemen Material',
            'alat_list'  => $model->where('kategori', 'Material')->findAll()
        ];
        return view('admin/alat', $data);
    }
    
    public function dataPemesanan()
    {
        $model = new PemesananModel();
        $pemesananData = $model->getPemesananWithDetails();
        $data = [
            'page_title' => 'Data Pemesanan',
            'pemesanan_per_bulan' => $this->groupDataByMonth($pemesananData, 'tanggal_pemesanan')
        ];
        return view('admin/pemesanan', $data);
    }

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

    public function dataPengembalian()
    {
        $model = new PengembalianModel();
        $data = ['page_title' => 'Data Pengembalian', 'pengembalian_list' => $model->getPengembalianWithDetails()];
        return view('admin/pengembalian', $data);
    }

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
    
    //======================================================================
    // HALAMAN SUBMENU (CEK PAKET, STOK, PEKERJA)
    //======================================================================
    
    public function cek_paket()
    {
        $paketModel = new PaketModel();
        $data = ['page_title' => 'Manajemen Paket', 'pakets' => $paketModel->findAll()];
        return view('admin/cek_paket', $data);
    }

    public function cek_pekerja()
    {
        $model = new PekerjaModel();
        $data = [
            'page_title' => 'Cek Status Pekerja',
            'pekerja' => [
                'bekerja' => $model->where('status_pekerja', 'bekerja')->countAllResults(),
                'tersedia' => $model->where('status_pekerja', 'tersedia')->countAllResults(),
            ]
        ];
        return view('admin/cek_pekerja_status', $data);
    }

    public function cek_pekerja_detail($status = null)
    {
        if ($status !== 'bekerja' && $status !== 'tersedia') {
            return redirect()->to('admin/cek-pekerja')->with('error', 'Status pekerja tidak valid.');
        }
        $data = [
            'page_title' => 'Detail Pekerja ' . ucfirst($status),
            'status'     => $status,
        ];
        return view('admin/cek_pekerja_detail', $data);
    }

    public function cekStokAlatBerat()
    {
        $model = new AlatModel();
        $data = [
            'page_title' => 'Cek Stok Alat Berat',
            'alat_list'  => $model->where('kategori', 'Alat Berat')->findAll()
        ];
        return view('admin/cek_stok_alat_berat', $data);
    }

    public function cekStokMaterial()
    {
        $model = new AlatModel();
        $data = [
            'page_title'    => 'Cek Stok Material',
            'material_list' => $model->where('kategori', 'Material')->findAll()
        ];
        return view('admin/cek_stok_material', $data);
    }
    
    //======================================================================
    // FUNGSI-FUNGSI CRUD (TAMBAH, SIMPAN, EDIT, UPDATE, HAPUS)
    //======================================================================

    // --- CRUD Pelanggan ---
    public function tambahPelanggan()
    {
        return view('admin/tambah_pelanggan', ['page_title' => 'Tambah Pelanggan Baru']);
    }

    public function simpanPelanggan()
    {
        $model = new PelangganModel();
        $data = $this->request->getPost();
        $data['id_pelanggan'] = substr(strtoupper($data['nama_lengkap']), 0, 1) . date('dmyHis');
        $model->save($data);
        return redirect()->to('admin/pelanggan')->with('success', 'Data pelanggan baru berhasil ditambahkan.');
    }

    public function editPelanggan($id)
    {
        $model = new PelangganModel();
        $data = ['page_title' => 'Edit Pelanggan', 'pelanggan' => $model->find($id)];
        return view('admin/edit_pelanggan', $data);
    }

    public function updatePelanggan($id)
    {
        $model = new PelangganModel();
        $model->update($id, $this->request->getPost());
        return redirect()->to('admin/pelanggan')->with('success', 'Data pelanggan berhasil diperbarui.');
    }

    public function hapusPelanggan($id)
    {
        $model = new PelangganModel();
        $model->delete($id);
        return redirect()->to('admin/pelanggan')->with('success', 'Data pelanggan berhasil dihapus.');
    }
    
    public function viewPelanggan($id)
    {
        $model = new PelangganModel();
        $data = ['page_title' => 'Detail Pelanggan', 'pelanggan'  => $model->find($id)];
        return view('admin/view_pelanggan', $data);
    }

    // --- CRUD Survey ---
    public function tambahSurvey()
    {
        $pelangganModel = new PelangganModel();
        $surveyModel = new SurveyModel();
        $surveyedPelangganIds = $surveyModel->select('id_pelanggan')->distinct()->findAll();
        $excludeIds = array_column($surveyedPelangganIds, 'id_pelanggan');
        
        $availablePelanggan = empty($excludeIds)
            ? $pelangganModel->findAll()
            : $pelangganModel->whereNotIn('id_pelanggan', $excludeIds)->findAll();

        $data = [
            'page_title'     => 'Tambah Survey Baru',
            'pelanggan_list' => $availablePelanggan
        ];
        return view('admin/tambah_survey', $data);
    }

    public function simpanSurvey()
    {
        $surveyModel = new SurveyModel();
        $data = [
            'id_pelanggan'   => $this->request->getPost('id_pelanggan'),
            'alamat_survey'  => $this->request->getPost('alamat_survey'),
            'tanggal_survey' => $this->request->getPost('tanggal_survey'),
            'status'         => 'Dijadwalkan'
        ];
        $surveyModel->insert($data);
        return redirect()->to('/admin/survey')->with('success', 'Data survey berhasil ditambahkan.');
    }

    public function editSurvey($id)
    {
        $surveyModel = new SurveyModel();
        $pelangganModel = new PelangganModel();
        $data = [
            'page_title' => 'Edit Data Survey',
            'survey' => $surveyModel->find($id),
            'pelanggan_list' => $pelangganModel->findAll()
        ];
        return view('admin/edit_survey', $data);
    }

    public function updateSurvey($id)
    {
        $surveyModel = new SurveyModel();
        $data = [
            'id_pelanggan'   => $this->request->getPost('id_pelanggan'),
            'alamat_survey'  => $this->request->getPost('alamat_survey'),
            'tanggal_survey' => $this->request->getPost('tanggal_survey'),
            'status'         => $this->request->getPost('status')
        ];
        $surveyModel->update($id, $data);
        return redirect()->to('/admin/survey')->with('success', 'Data survey berhasil diperbarui.');
    }

    public function hapusSurvey($id)
    {
        $surveyModel = new SurveyModel();
        try {
            if ($surveyModel->delete($id)) {
                return redirect()->to('/admin/survey')->with('success', 'Data survey berhasil dihapus.');
            } else {
                return redirect()->to('/admin/survey')->with('error', 'Gagal menghapus data. ID tidak ditemukan.');
            }
        } catch (\CodeIgniter\Database\Exceptions\DatabaseException $e) {
            log_message('error', '[HAPUS SURVEY] ' . $e->getMessage());
            return redirect()->to('/admin/survey')->with('error', 'Data survey gagal dihapus karena terhubung dengan data lain.');
        }
    }

    // --- CRUD Alat & Material ---
    public function tambahAlat()
    {
        return view('admin/tambah_alat', ['page_title' => 'Tambah Data Alat / Material Baru']);
    }

    public function simpanAlat()
    {
        $alatModel = new AlatModel();
        $data = [
            'id_alat'        => $this->request->getPost('id_alat'),
            'cek_alat'       => $this->request->getPost('cek_alat'),
            'nama_alat'      => $this->request->getPost('nama_alat'),
            'kategori'       => $this->request->getPost('kategori'),
            'stok_alat'      => $this->request->getPost('stok_alat'),
            'informasi_alat' => $this->request->getPost('informasi_alat'),
            'harga_sewa'     => $this->request->getPost('harga_sewa'),
        ];
        $gambar = $this->request->getFile('gambar_alat');
        if ($gambar && $gambar->isValid() && !$gambar->hasMoved()) {
            $newName = $gambar->getRandomName();
            $gambar->move(FCPATH . 'uploads/alat', $newName);
            $data['gambar_alat'] = $newName;
        }
        $alatModel->save($data);
        $redirectUrl = ($data['kategori'] === 'Material') ? 'admin/material' : 'admin/alat-berat';
        return redirect()->to($redirectUrl)->with('success', 'Data baru berhasil ditambahkan.');
    }
    
    public function editAlat($id)
    {
        $model = new AlatModel();
        $data = ['page_title' => 'Edit Data Alat', 'alat' => $model->find($id)];
        return view('admin/edit_alat', $data);
    }
    
    public function updateAlat($id)
    {
        $model = new AlatModel();
        $data = $this->request->getPost();
        $gambar = $this->request->getFile('gambar_alat');
        if ($gambar && $gambar->isValid() && !$gambar->hasMoved()) {
            $alatLama = $model->find($id);
            if ($alatLama && !empty($alatLama['gambar_alat']) && file_exists(FCPATH . 'uploads/alat/' . $alatLama['gambar_alat'])) {
                unlink(FCPATH . 'uploads/alat/' . $alatLama['gambar_alat']);
            }
            $newName = $gambar->getRandomName();
            $gambar->move(FCPATH . 'uploads/alat', $newName);
            $data['gambar_alat'] = $newName;
        }
        $model->update($id, $data);
        $redirectUrl = ($data['kategori'] === 'Material') ? 'admin/material' : 'admin/alat-berat';
        return redirect()->to($redirectUrl)->with('success', 'Data berhasil diperbarui.');
    }

    public function hapusAlat($id)
    {
        $model = new AlatModel();
        $alat = $model->find($id);
        if ($alat && !empty($alat['gambar_alat']) && file_exists(FCPATH . 'uploads/alat/' . $alat['gambar_alat'])) {
            unlink(FCPATH . 'uploads/alat/' . $alat['gambar_alat']);
        }
        $model->delete($id);
        return redirect()->back()->with('success', 'Data berhasil dihapus.');
    }
    
    // --- CRUD Paket ---
    public function tambahPaket() {
        return view('admin/tambah_paket', ['page_title' => 'Tambah Paket Baru']);
    }

    public function simpanPaket() {
        $model = new PaketModel();
        $model->save($this->request->getPost());
        return redirect()->to('admin/cek-paket')->with('success', 'Paket baru berhasil ditambahkan!');
    }

    public function editPaket($id) {
        $model = new PaketModel();
        $data = ['page_title' => 'Edit Paket', 'paket' => $model->find($id)];
        return view('admin/edit_paket', $data);
    }

    public function updatePaket($id) {
        $model = new PaketModel();
        $model->update($id, $this->request->getPost());
        return redirect()->to('admin/cek-paket')->with('success', 'Paket berhasil diperbarui.');
    }

    public function hapusPaket($id) {
        $model = new PaketModel();
        $model->delete($id);
        return redirect()->to('admin/cek-paket')->with('success', 'Paket berhasil dihapus.');
    }
    
    // --- Lanjutan CRUD akan ditambahkan di sini... ---
    // (Pemesanan, Penyewaan, Pembayaran, Pengembalian)
    
    //======================================================================
    // MANAJEMEN PROFIL ADMIN
    //======================================================================
    
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
    // FUNGSI HELPER & API
    //======================================================================
    
    private function groupDataByMonth($data, $dateColumn)
    {
        if (empty($data)) return [];
        $grouped = [];
        foreach ($data as $item) {
            if (empty($item[$dateColumn])) continue;
            $monthYear = Time::parse($item[$dateColumn])->toLocalizedString('MMMM YYYY');
            if (!isset($grouped[$monthYear])) {
                $grouped[$monthYear] = [];
            }
            $grouped[$monthYear][] = $item;
        }
        krsort($grouped);
        return $grouped;
    }

    public function getAlatDetail($id_alat)
    {
        $alatModel = new AlatModel();
        return $this->response->setJSON($alatModel->find($id_alat));
    }
}