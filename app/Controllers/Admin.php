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
            $monthYear = Time::parse($item[$dateColumn])->toLocalizedString('MMMM yyyy');
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
    
    public function dataPemesanan() { /* ... kode asli ... */ }
    public function dataPenyewaan() { /* ... kode asli ... */ }
    public function dataAlat() { /* ... kode asli ... */ }
    public function dataPembayaran() { /* ... kode asli ... */ }
    public function dataPengembalian() { /* ... kode asli ... */ }

    // FORM TAMBAH DATA
    public function tambahPelanggan() { return view('admin/tambah_pelanggan', ['page_title' => 'Tambah Pelanggan']); }
    public function tambahPelaksanaan() { return view('admin/tambah_pelaksanaan', ['page_title' => 'Tambah Pelaksanaan']); }
    // ... (Fungsi-fungsi tambah lainnya)

    // CRUD UNTUK PELANGGAN
    public function simpanPelanggan()
    {
        $model = new PelangganModel();
        $model->save($this->request->getPost());
        session()->setFlashdata('success', 'Data pelanggan berhasil ditambahkan.');
        return redirect()->to('/admin/pelanggan');
    }

    public function editPelanggan($id)
    {
        $model = new PelangganModel();
        $pelangganData = $model->find($id);
        if (empty($pelangganData)) { throw new \CodeIgniter\Exceptions\PageNotFoundException('Pelanggan tidak ditemukan'); }
        $data = [ 'page_title' => 'Edit Pelanggan', 'pelanggan'  => $pelangganData ];
        return view('admin/edit_pelanggan', $data);
    }

    public function updatePelanggan($id)
    {
        $model = new PelangganModel();
        $model->update($id, $this->request->getPost());
        session()->setFlashdata('success', 'Data pelanggan berhasil diperbarui.');
        return redirect()->to('/admin/pelanggan');
    }

    public function hapusPelanggan($id)
    {
        $model = new PelangganModel();
        $model->delete($id);
        session()->setFlashdata('success', 'Data pelanggan berhasil dihapus.');
        return redirect()->to('/admin/pelanggan');
    }

    public function viewPelanggan($id)
    {
        $model = new PelangganModel();
        $pelangganData = $model->find($id);
        if (empty($pelangganData)) { throw new \CodeIgniter\Exceptions\PageNotFoundException('Pelanggan tidak ditemukan'); }
        $data = [ 'page_title' => 'Detail Pelanggan', 'pelanggan'  => $pelangganData ];
        return view('admin/view_pelanggan', $data);
    }
    
    // CRUD UNTUK PELAKSANAAN
    public function editPelaksanaan($id)
    {
        $model = new PelaksanaanModel();
        $pelaksanaanData = $model->find($id);
        if (empty($pelaksanaanData)) { throw new \CodeIgniter\Exceptions\PageNotFoundException('Data Pelaksanaan tidak ditemukan'); }
        
        $pelangganModel = new PelangganModel();
        $data = [
            'page_title' => 'Edit Pelaksanaan',
            'pelaksanaan' => $pelaksanaanData,
            'pelanggan_list' => $pelangganModel->findAll()
        ];
        return view('admin/edit_pelaksanaan', $data);
    }

    public function updatePelaksanaan($id = null)
    {
        $model = new PelaksanaanModel();
        $model->update($id, $this->request->getPost());
        session()->setFlashdata('success', 'Data pelaksanaan berhasil diperbarui.');
        return redirect()->to('/admin/pelaksanaan');
    }

    public function hapusPelaksanaan($id)
    {
        $model = new PelaksanaanModel();
        $model->delete($id);
        session()->setFlashdata('success', 'Data pelaksanaan berhasil dihapus.');
        return redirect()->to('/admin/pelaksanaan');
    }

    // FUNGSI UNTUK PROFIL ADMIN
    public function adminProfile()
    {
        $userModel = new UserModel();
        $userId = session()->get('user_id');
        $data = $userModel->find($userId);
        if (!$data) { throw new \CodeIgniter\Exceptions\PageNotFoundException('User tidak ditemukan'); }
        return view('admin/admin_profile', $data);
    }

    public function editAdminProfile()
    {
        $userModel = new UserModel();
        $userId = session()->get('user_id');
        $data = $userModel->find($userId);
        return view('admin/edit_admin_profile', $data);
    }

    public function updateAdminProfile()
    {
        $userModel = new UserModel();
        $userId = session()->get('user_id');
        $rules = [
            'nama_lengkap' => 'required|min_length[3]|max_length[100]',
            'email'        => 'required|valid_email',
            'foto_profil'  => 'is_image[foto_profil]|mime_in[foto_profil,image/jpg,image/jpeg,image/png]|max_size[foto_profil,2048]',
        ];
        if (!$this->validate($rules)) { return redirect()->back()->withInput()->with('errors', $this->validator->getErrors()); }
        $data = [
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'email'        => $this->request->getPost('email'),
            'no_telpon'    => $this->request->getPost('no_telpon'),
            'alamat_rumah' => $this->request->getPost('alamat_rumah'),
        ];
        $fotoFile = $this->request->getFile('foto_profil');
        if ($fotoFile->isValid() && !$fotoFile->hasMoved()) {
            $user = $userModel->find($userId);
            if ($user['foto_profil'] && file_exists('uploads/avatars/' . $user['foto_profil'])) { unlink('uploads/avatars/' . $user['foto_profil']);}
            $newName = $fotoFile->getRandomName();
            $fotoFile->move('uploads/avatars', $newName);
            $data['foto_profil'] = $newName;
        }
        $userModel->update($userId, $data);
        session()->set('nama_lengkap', $data['nama_lengkap']);
        if (isset($data['foto_profil'])) { session()->set('foto_profil', $data['foto_profil']);}
        return redirect()->to('admin/profile')->with('success', 'Profil berhasil diperbarui!');
    }
}