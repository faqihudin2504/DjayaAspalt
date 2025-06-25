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
    public function tambahPenyewaan() { /* ... */ }
    public function tambahAlat() { /* ... */ }
    public function tambahPembayaran() { /* ... */ }
    public function tambahPengembalian() { /* ... */ }

    // PROSES SIMPAN DATA (CREATE)
    public function simpanPelanggan() { /* ... */ }
    public function simpanPelaksanaan() { /* ... */ }

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

    // FUNGSI UNTUK PROFIL ADMIN
    public function adminProfile() { /* ... */ }
    public function editAdminProfile() { /* ... */ }
    public function updateAdminProfile() { /* ... */ }
}