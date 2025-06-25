<?php

namespace App\Controllers;

use App\Models\AlatModel;
use App\Models\PelaksanaanModel;
use App\Models\PelangganModel;
use App\Models\PembayaranModel;
use App\Models\PemesananModel;
use App\Models\PengembalianModel;
use App\Models\PenyewaanModel;
use App\Models\UserModel;
use CodeIgniter\I18n\Time;

class Admin extends BaseController
{
    private function groupDataByMonth($data, $dateColumn)
    {
        if (empty($data)) { return []; }
        $grouped = [];
        foreach ($data as $item) {
            $monthYear = Time::parse($item[$dateColumn])->toLocalizedString('MMMM YYYY');
            if (!isset($grouped[$monthYear])) {
                $grouped[$monthYear] = [];
            }
            $grouped[$monthYear][] = $item;
        }
        krsort($grouped);
        return $grouped;
    }

    public function index()
    {
        return view('admin/dashboard');
    }

    // HALAMAN UTAMA MODUL
    public function manajemenPengguna()
    {
        $model = new PelangganModel();
        $data = [
            'page_title' => 'Manajemen Pelanggan',
            'pelanggan_per_bulan' => $this->groupDataByMonth($model->orderBy('tanggal_survey', 'DESC')->findAll(), 'tanggal_survey')
        ];
        return view('admin/manajemen_pengguna', $data);
    }

    public function dataPelaksanaan()
    {
        $model = new PelaksanaanModel();
        $data = [
            'page_title' => 'Data Pelaksanaan',
            'pelaksanaan_per_bulan' => $this->groupDataByMonth($model->orderBy('tanggal_pelaksanaan', 'DESC')->findAll(), 'tanggal_pelaksanaan')
        ];
        return view('admin/pelaksanaan', $data);
    }
    
    public function dataPemesanan() { 
        $model = new PemesananModel();
        $data = [
            'page_title' => 'Data Pemesanan',
            'pemesanan_per_bulan' => $this->groupDataByMonth($model->orderBy('tanggal_pemesanan', 'DESC')->findAll(), 'tanggal_pemesanan')
        ];
        return view('admin/pemesanan', $data);
    }

    // ... (fungsi data lainnya tetap sama) ...
    public function dataPenyewaan() { /* ... */ }
    public function dataAlat() { /* ... */ }
    public function dataPembayaran() { /* ... */ }
    public function dataPengembalian() { /* ... */ }


    // FORM TAMBAH DATA
    public function tambahPelanggan() { /* ... */ }
    public function tambahPelaksanaan() { /* ... */ }

    public function tambahPemesanan() 
    { 
        $model = new PelaksanaanModel();
        $data = [
            'page_title' => 'Tambah Pemesanan',
            'pelaksanaan_list' => $model->findAll()
        ];
        return view('admin/tambah_pemesanan', $data);
    }
    // ... (fungsi tambah lainnya tetap sama) ...
    public function tambahPenyewaan() 
    {
        // Mengambil data pelanggan untuk ditampilkan di form
        $pelangganModel = new \App\Models\PelangganModel();
        $data = [
            'page_title' => 'Tambah Data Penyewaan',
            'pelanggan_list' => $pelangganModel->findAll(),
        ];
        return view('admin/tambah_penyewaan', $data);
    }
    public function tambahAlat() { /* ... */ }
    public function tambahPembayaran() { /* ... */ }
    public function tambahPengembalian() { /* ... */ }

    // PROSES SIMPAN DATA (CREATE)
    public function simpanPelanggan() { /* ... */ }
    public function simpanPelaksanaan() { /* ... */ }

    public function simpanPenyewaan()
    {
        $model = new PenyewaanModel();
        $data = $this->request->getPost();

        // Buat ID Sewa unik secara manual
        $data['id_sewa'] = 'SEWA' . date('ymdHis');

        // Karena di form tidak ada input nama_penyewa, kita ambil dari data pelanggan
        $pelangganModel = new PelangganModel();
        $pelanggan = $pelangganModel->find($this->request->getPost('id_pelanggan'));
        if ($pelanggan) {
            $data['nama_penyewa'] = $pelanggan['nama_lengkap'];
        }

        $model->save($data);
        session()->setFlashdata('success', 'Data penyewaan berhasil ditambahkan.');
        return redirect()->to('/admin/penyewaan');
    }

    public function simpanPemesanan()
    {
        $model = new PemesananModel();
        $data = $this->request->getPost();
        $data['id_pesanan'] = 'PES' . date('ymdHis');
        $model->save($data);
        session()->setFlashdata('success', 'Data pemesanan berhasil ditambahkan.');
        return redirect()->to('/admin/pemesanan');
    }
    
    // PROSES EDIT & UPDATE
    public function editPelanggan($id) { /* ... */ }
    public function updatePelanggan($id) { /* ... */ }
    public function editPelaksanaan($id) { /* ... */ }
    public function updatePelaksanaan($id = null) { /* ... */ }

    // FUNGSI BARU UNTUK EDIT PEMESANAN
    public function editPemesanan($id)
    {
        $pemesananModel = new PemesananModel();
        $pemesananData = $pemesananModel->find($id);
        if (empty($pemesananData)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data Pemesanan tidak ditemukan');
        }

        $pelaksanaanModel = new PelaksanaanModel();
        $data = [
            'page_title' => 'Edit Pemesanan',
            'pemesanan' => $pemesananData,
            'pelaksanaan_list' => $pelaksanaanModel->findAll()
        ];
        return view('admin/edit_pemesanan', $data);
    }

    // FUNGSI BARU UNTUK UPDATE PEMESANAN
    public function updatePemesanan($id)
    {
        $model = new PemesananModel();
        $model->update($id, $this->request->getPost());
        session()->setFlashdata('success', 'Data pemesanan berhasil diperbarui.');
        return redirect()->to('/admin/pemesanan');
    }


    // PROSES HAPUS (DELETE) & LIHAT (VIEW)
    public function hapusPelanggan($id) { /* ... */ }
    public function viewPelanggan($id) { /* ... */ }
    public function hapusPelaksanaan($id) { /* ... */ }

    // FUNGSI BARU UNTUK HAPUS PEMESANAN
    public function hapusPemesanan($id)
    {
        $model = new PemesananModel();
        $model->delete($id);
        session()->setFlashdata('success', 'Data pemesanan berhasil dihapus.');
        return redirect()->to('/admin/pemesanan');
    }

    // FUNGSI BARU UNTUK CRUD PENYEWAAN

    public function viewPenyewaan($id)
    {
        $penyewaanModel = new PenyewaanModel();
        // Anda bisa membuat join di sini jika perlu menampilkan detail lebih lanjut
        $penyewaanData = $penyewaanModel->find($id); 

        if (empty($penyewaanData)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data Penyewaan tidak ditemukan');
        }

        $data = [
            'page_title' => 'Detail Penyewaan',
            'penyewaan' => $penyewaanData
        ];
        // Anda perlu membuat file view 'admin/view_penyewaan.php' untuk ini
        return view('admin/view_penyewaan', $data);
    }

    public function editPenyewaan($id)
    {
        $penyewaanModel = new PenyewaanModel();
        $penyewaanData = $penyewaanModel->find($id);
        if (empty($penyewaanData)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data Penyewaan tidak ditemukan');
        }

        $pelangganModel = new PelangganModel();
        $data = [
            'page_title' => 'Edit Penyewaan',
            'penyewaan' => $penyewaanData,
            'pelanggan_list' => $pelangganModel->findAll()
        ];
        return view('admin/edit_penyewaan', $data);
    }

    public function updatePenyewaan($id)
    {
        $model = new PenyewaanModel();
        $data = $this->request->getPost();
        
        // Update juga nama penyewa jika id_pelanggan berubah
        $pelangganModel = new PelangganModel();
        $pelanggan = $pelangganModel->find($this->request->getPost('id_pelanggan'));
        if ($pelanggan) {
            $data['nama_penyewa'] = $pelanggan['nama_lengkap'];
        }

        $model->update($id, $data);
        session()->setFlashdata('success', 'Data penyewaan berhasil diperbarui.');
        return redirect()->to('/admin/penyewaan');
    }

    public function hapusPenyewaan($id)
    {
        $model = new PenyewaanModel();
        $model->delete($id);
        session()->setFlashdata('success', 'Data penyewaan berhasil dihapus.');
        return redirect()->to('/admin/penyewaan');
    }



    // FUNGSI UNTUK PROFIL ADMIN
    public function adminProfile() { /* ... */ }
    public function editAdminProfile() { /* ... */ }
    public function updateAdminProfile() { /* ... */ }
}