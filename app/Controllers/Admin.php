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
    /**
     * Helper function untuk mengelompokkan data berdasarkan bulan dan tahun.
     */
    private function groupDataByMonth($data, $dateColumn)
    {
        if (empty($data)) {
            return [];
        }
        $grouped = [];
        foreach ($data as $item) {
            $monthYear = Time::parse($item[$dateColumn])->toLocalizedString('MMMM yyyy');
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

    // ===================================================================
    // 1. MANAJEMEN PENGGUNA (PELANGGAN)
    // ===================================================================
    public function manajemenPengguna()
    {
        $model = new PelangganModel();
        $data = [
            'page_title' => 'Manajemen Pelanggan',
            'pelanggan_per_bulan' => $this->groupDataByMonth($model->orderBy('tanggal_survey', 'DESC')->findAll(), 'tanggal_survey')
        ];
        return view('admin/manajemen_pengguna', $data);
    }

    public function tambahPelanggan()
    {
        $data['page_title'] = 'Tambah Pelanggan Baru';
        return view('admin/tambah_pelanggan', $data);
    }

    public function simpanPelanggan()
{
    // Validasi dasar
    $rules = [
        'tipe_transaksi' => 'required|in_list[SURVEY,SEWA]',
        'nama_lengkap' => 'required',
        'no_telpon' => 'required',
    ];

    if (!$this->validate($rules)) {
        return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
    }

    $model = new PelangganModel();
    $data = $this->request->getPost();

    // 1. Ambil tipe transaksi dari dropdown ('SURVEY' atau 'SEWA')
    $tipeTransaksi = $data['tipe_transaksi'];
    
    // 2. Buat ID Pelanggan (logika lama Anda, sudah bagus)
    $prefix = substr(strtoupper($data['nama_lengkap']), 0, 1);
    $data['id_pelanggan'] = $prefix . date('dmyHis');

    // 3. Panggil fungsi di model untuk buat ID otomatis
    $generatedId = $model->generateTransactionalId($tipeTransaksi);

    // 4. Masukkan ID otomatis ke kolom yang sesuai
    if ($tipeTransaksi === 'SEWA') {
        $data['id_namasewa'] = $generatedId;
        $data['id_survey'] = '-'; // Isi kolom survey dengan placeholder
    } else { // SURVEY
        $data['id_survey'] = $generatedId;
        $data['id_namasewa'] = '-'; // Isi kolom sewa dengan placeholder
    }

    // Hapus 'tipe_transaksi' dari array agar tidak ikut disimpan ke DB
    unset($data['tipe_transaksi']);

    // 5. Simpan ke database
    $model->save($data);

    session()->setFlashdata('success', 'Data pelanggan baru untuk ' . $tipeTransaksi . ' berhasil ditambahkan.');
    return redirect()->to('admin/pelanggan');
}

    public function editPelanggan($id)
    {
        $model = new PelangganModel();
        $data = ['page_title' => 'Edit Pelanggan', 'pelanggan'  => $model->find($id)];
        return view('admin/edit_pelanggan', $data);
    }

    public function updatePelanggan($id)
    {
        $model = new PelangganModel();
        $model->update($id, $this->request->getPost());
        session()->setFlashdata('success', 'Data pelanggan berhasil diperbarui.');
        return redirect()->to('admin/pelanggan');
    }

    public function hapusPelanggan($id)
    {
        $model = new PelangganModel();
        $model->delete($id);
        session()->setFlashdata('success', 'Data pelanggan berhasil dihapus.');
        return redirect()->to('admin/pelanggan');
    }

    public function viewPelanggan($id)
    {
        $model = new PelangganModel();
        $data = ['page_title' => 'Detail Pelanggan', 'pelanggan'  => $model->find($id)];
        return view('admin/view_pelanggan', $data);
    }

    // ===================================================================
    // 2. SURVEY LOKASI & 3. PEMESANAN (Struktur dari file lama Anda)
    // ===================================================================
    public function dataPelaksanaan()
    {
        $model = new PelaksanaanModel();
        $data = [
            'page_title' => 'Data Pelaksanaan',
            'pelaksanaan_per_bulan' => $this->groupDataByMonth($model->orderBy('tanggal_pelaksanaan', 'DESC')->findAll(), 'tanggal_pelaksanaan')
        ];
        return view('admin/pelaksanaan', $data);
    }

    public function tambahPelaksanaan()
    {
        $pelangganModel = new PelangganModel();
        $data = ['page_title' => 'Tambah Data Pelaksanaan', 'pelanggan_list' => $pelangganModel->findAll()];
        return view('admin/tambah_pelaksanaan', $data);
    }

    public function simpanPelaksanaan()
    {
        $model = new PelaksanaanModel();
        $data = $this->request->getPost();
        $data['id_pelaksanaan'] = 'PLK' . date('dmyHis');
        $model->save($data);
        session()->setFlashdata('success', 'Data pelaksanaan berhasil ditambahkan.');
        return redirect()->to('admin/pelaksanaan');
    }

    public function editPelaksanaan($id)
    {
        $model = new PelaksanaanModel();
        $pelangganModel = new PelangganModel();
        $data = ['page_title' => 'Edit Data Pelaksanaan', 'pelaksanaan' => $model->find($id), 'pelanggan_list' => $pelangganModel->findAll()];
        return view('admin/edit_pelaksanaan', $data);
    }

    public function updatePelaksanaan($id)
    {
        $model = new PelaksanaanModel();
        $model->update($id, $this->request->getPost());
        session()->setFlashdata('success', 'Data pelaksanaan berhasil diperbarui.');
        return redirect()->to('admin/pelaksanaan');
    }

    public function hapusPelaksanaan($id)
    {
        $model = new PelaksanaanModel();
        $model->delete($id);
        session()->setFlashdata('success', 'Data pelaksanaan berhasil dihapus.');
        return redirect()->to('admin/pelaksanaan');
    }
    
    public function dataPemesanan()
    {
        $model = new PemesananModel();
        $data = [
            'page_title' => 'Data Pemesanan',
            'pemesanan_per_bulan' => $this->groupDataByMonth($model->orderBy('tanggal_pemesanan', 'DESC')->findAll(), 'tanggal_pemesanan')
        ];
        return view('admin/pemesanan', $data);
    }

    public function tambahPemesanan()
    {
        $model = new PelaksanaanModel();
        $data = ['page_title' => 'Tambah Pemesanan', 'pelaksanaan_list' => $model->findAll()];
        return view('admin/tambah_pemesanan', $data);
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

    public function editPemesanan($id)
    {
        $pemesananModel = new PemesananModel();
        $pelaksanaanModel = new PelaksanaanModel();
        $data = ['page_title' => 'Edit Pemesanan', 'pemesanan' => $pemesananModel->find($id), 'pelaksanaan_list' => $pelaksanaanModel->findAll()];
        return view('admin/edit_pemesanan', $data);
    }

    public function updatePemesanan($id)
    {
        $model = new PemesananModel();
        $model->update($id, $this->request->getPost());
        session()->setFlashdata('success', 'Data pemesanan berhasil diperbarui.');
        return redirect()->to('/admin/pemesanan');
    }

    public function hapusPemesanan($id)
    {
        $model = new PemesananModel();
        $model->delete($id);
        session()->setFlashdata('success', 'Data pemesanan berhasil dihapus.');
        return redirect()->to('/admin/pemesanan');
    }

    // ===================================================================
    // 4. MANAJEMEN ALAT (CEK ALAT)
    // ===================================================================
    public function dataAlat()
    {
        $model = new AlatModel();
        $data = ['page_title' => 'Manajemen Data Alat', 'alat_list'  => $model->findAll()];
        return view('admin/alat', $data);
    }

    public function tambahAlat()
    {
        $data = ['page_title' => 'Tambah Alat Baru', 'validation' => \Config\Services::validation()];
        return view('admin/tambah_alat', $data);
    }

    public function simpanAlat()
    {
        $rules = ['id_alat' => 'required|is_unique[alat.id_alat]', 'nama_alat' => 'required', 'stok_alat' => 'required|numeric', 'harga_sewa' => 'required|numeric'];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        $model = new AlatModel();
        $model->save($this->request->getPost());
        session()->setFlashdata('success', 'Data alat berhasil ditambahkan.');
        return redirect()->to('/admin/alat');
    }

    public function editAlat($id)
    {
        $model = new AlatModel();
        $data = ['page_title' => 'Edit Data Alat', 'validation' => \Config\Services::validation(), 'alat' => $model->find($id)];
        if (empty($data['alat'])) { throw new \CodeIgniter\Exceptions\PageNotFoundException('Data alat tidak ditemukan.'); }
        return view('admin/edit_alat', $data);
    }

    public function updateAlat($id)
    {
        $rules = ['id_alat'   => 'required|is_unique[alat.id_alat,id_alat,' . $id . ']', 'nama_alat' => 'required', 'stok_alat' => 'required|numeric', 'harga_sewa' => 'required|numeric'];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        $model = new AlatModel();
        $model->update($id, $this->request->getPost());
        session()->setFlashdata('success', 'Data alat berhasil diperbarui.');
        return redirect()->to('/admin/alat');
    }

    public function hapusAlat($id)
    {
        $model = new AlatModel();
        $model->delete($id);
        session()->setFlashdata('success', 'Data alat berhasil dihapus.');
        return redirect()->to('/admin/alat');
    }
    
    // ===================================================================
    // 5. PENYEWAAN (Revisi dengan Otomatisasi)
    // ===================================================================
    public function dataPenyewaan()
    {
        $model = new PenyewaanModel();
        $data = ['page_title' => 'Data Penyewaan Alat', 'penyewaan_list' => $model->getPenyewaanWithDetails()];
        return view('admin/penyewaan', $data);
    }

    public function tambahPenyewaan()
    {
        $userModel = new UserModel();
        $alatModel = new AlatModel();
        $data = [
            'page_title' => 'Tambah Penyewaan Baru',
            'pelanggan_list' => $userModel->where('role', 'customer')->findAll(),
            'alat_list' => $alatModel->where('cek_alat', 'Tersedia')->findAll()
        ];
        return view('admin/tambah_penyewaan', $data);
    }

    public function simpanPenyewaan()
    {
        $penyewaanModel = new PenyewaanModel();
        $alatModel = new AlatModel();
        $userModel = new UserModel();

        $id_alat = $this->request->getPost('id_alat');
        $id_pelanggan = $this->request->getPost('id_pelanggan');
        
        $alat = $alatModel->find($id_alat);
        $pelanggan = $userModel->find($id_pelanggan);

        $data = [
            'id_sewa' => 'SEWA' . date('ymdHis'),
            'id_pelanggan' => $id_pelanggan,
            'nama_penyewa' => $pelanggan['nama_lengkap'],
            'id_alat' => $id_alat,
            'nama_alat' => $alat['nama_alat'],
            'harga_alatdisewa' => $alat['harga_sewa'],
            'tanggal_penyewaan' => $this->request->getPost('tanggal_penyewaan'),
            'alamat_penyewa' => $this->request->getPost('alamat_penyewa'),
            'status' => 'Disewa'
        ];
        
        $penyewaanModel->save($data);
        $alatModel->update($id_alat, ['cek_alat' => 'Disewa']);
        
        session()->setFlashdata('success', 'Data penyewaan berhasil ditambahkan.');
        return redirect()->to('admin/penyewaan');
    }
    
    public function getAlatDetail($id_alat)
    {
        $alatModel = new AlatModel();
        return $this->response->setJSON($alatModel->find($id_alat));
    }
    
    public function editPenyewaan($id)
    {
        $penyewaanModel = new PenyewaanModel();
        $userModel = new UserModel();
        $alatModel = new AlatModel();
        $data = [
            'page_title' => 'Edit Penyewaan',
            'penyewaan' => $penyewaanModel->find($id),
            'pelanggan_list' => $userModel->where('role', 'customer')->findAll(),
            'alat_list' => $alatModel->findAll()
        ];
        return view('admin/edit_penyewaan', $data);
    }

    public function updatePenyewaan($id)
    {
        $model = new PenyewaanModel();
        $model->update($id, $this->request->getPost());
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

    // ===================================================================
    // 6 & 7. PEMBAYARAN (Revisi dengan pemisahan & tanpa hapus)
    // ===================================================================
    public function dataPembayaranPemesanan()
    {
        $model = new PembayaranModel();
        $data = [
            'page_title' => 'Data Pembayaran Pemesanan',
            'pembayaran_list' => $model->where('id_sewa', null)->findAll(),
            'tipe' => 'pemesanan'
        ];
        return view('admin/pembayaran_data', $data);
    }
    
    public function dataPembayaranPenyewaan()
    {
        $model = new PembayaranModel();
        $data = [
            'page_title' => 'Data Pembayaran Penyewaan',
            'pembayaran_list' => $model->where('id_pesanan', null)->findAll(),
            'tipe' => 'penyewaan'
        ];
        return view('admin/pembayaran_data', $data);
    }
    
    public function tambahPembayaranPemesanan()
    {
        $pemesananModel = new PemesananModel();
        $data = [
            'page_title' => 'Tambah Pembayaran Pemesanan',
            'transaksi_list' => $pemesananModel->findAll(), // Tambahkan join jika butuh nama
            'tipe' => 'pemesanan'
        ];
        return view('admin/pembayaran_tambah', $data);
    }

    public function tambahPembayaranPenyewaan()
    {
        $penyewaanModel = new PenyewaanModel();
        $data = [
            'page_title' => 'Tambah Pembayaran Penyewaan',
            'transaksi_list' => $penyewaanModel->whereIn('status', ['Disewa', 'Selesai'])->findAll(),
            'tipe' => 'penyewaan'
        ];
        return view('admin/pembayaran_tambah', $data);
    }

    public function simpanPembayaran()
    {
        $model = new PembayaranModel();
        $data = $this->request->getPost();
        $data['id_bayar'] = 'PAY' . date('ymdHis');
        $model->save($data);
        session()->setFlashdata('success', 'Data pembayaran berhasil direkam.');
        $redirectUrl = ($this->request->getPost('tipe') === 'penyewaan') ? 'admin/pembayaran/penyewaan' : 'admin/pembayaran/pemesanan';
        return redirect()->to($redirectUrl);
    }

    // ===================================================================
    // 8. PENGEMBALIAN (Tanpa Hapus)
    // ===================================================================
    public function dataPengembalian()
    {
        $model = new PengembalianModel();
        $data = ['page_title' => 'Data Pengembalian', 'pengembalian_list' => $model->getPengembalianWithDetails()];
        return view('admin/pengembalian_data', $data);
    }

    public function tambahPengembalian()
    {
        $penyewaanModel = new PenyewaanModel();
        $data = ['page_title' => 'Tambah Data Pengembalian', 'penyewaan_list' => $penyewaanModel->where('status', 'Disewa')->findAll()];
        return view('admin/tambah_pengembalian', $data);
    }

    public function simpanPengembalian()
    {
        $pengembalianModel = new PengembalianModel();
        $data = $this->request->getPost();
        $data['id_kembali'] = 'KMB' . date('ymdHis');
        $pengembalianModel->save($data);

        $penyewaanModel = new PenyewaanModel();
        $alatModel = new AlatModel();
        $penyewaan = $penyewaanModel->find($data['id_sewa']);
        
        $penyewaanModel->update($data['id_sewa'], ['status' => 'Selesai']);
        $alatModel->update($penyewaan['id_alat'], ['cek_alat' => 'Tersedia']);
        
        session()->setFlashdata('success', 'Data pengembalian berhasil ditambahkan dan status alat telah diperbarui.');
        return redirect()->to('admin/pengembalian');
    }

    // ===================================================================
    // 9. LAPORAN
    // ===================================================================
    public function laporan()
    {
        return view('admin/laporan_form', ['page_title' => 'Cetak Laporan Keuangan']);
    }

    public function cetakLaporan()
    {
        // Disini nanti logika untuk query data dan generate PDF/Excel
    }
    
    // ===================================================================
    // PROFIL ADMIN
    // ===================================================================
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
}