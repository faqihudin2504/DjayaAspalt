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
            // Menggunakan format 'F Y' untuk mendapatkan nama bulan dan tahun
            $monthYear = Time::parse($item[$dateColumn])->toLocalizedString('MMMM yyyy');
            if (!isset($grouped[$monthYear])) {
                $grouped[$monthYear] = [];
            }
            $grouped[$monthYear][] = $item;
        }
        // Mengurutkan berdasarkan kunci (bulan dan tahun) secara descending
        krsort($grouped);
        return $grouped;
    }

    public function index()
    {
        return view('admin/dashboard');
    }

    // ===================================================================
    // MODUL PELANGGAN
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
        $model = new PelangganModel();
        $data = $this->request->getPost();

        // Membuat ID unik untuk pelanggan
        $prefix = substr(strtoupper($data['nama_lengkap']), 0, 1);
        $data['id_pelanggan'] = $prefix . date('dmyHis');
        
        // Membuat ID survey unik jika tidak ada ID sewa yang diinput
        if (empty($data['id_namasewa'])) {
            $data['id_survey'] = 'SURVEY' . date('dmyHis');
        }

        $model->save($data);
        session()->setFlashdata('success', 'Data pelanggan berhasil ditambahkan.');
        return redirect()->to('admin/pelanggan');
    }

    public function editPelanggan($id)
    {
        $model = new PelangganModel();
        $data = [
            'page_title' => 'Edit Pelanggan',
            'pelanggan'  => $model->find($id)
        ];
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
        $data = [
            'page_title' => 'Detail Pelanggan',
            'pelanggan'  => $model->find($id)
        ];
        return view('admin/view_pelanggan', $data);
    }


    // ===================================================================
    // MODUL PELAKSANAAN
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
        $data = [
            'page_title'       => 'Tambah Data Pelaksanaan',
            'pelanggan_list'   => $pelangganModel->findAll(),
        ];
        return view('admin/tambah_pelaksanaan', $data);
    }

    public function simpanPelaksanaan()
    {
        $model = new PelaksanaanModel();
        $data = $this->request->getPost();
        $data['id_pelaksanaan'] = 'PLK' . date('dmyHis'); // ID Pelaksanaan unik

        $model->save($data);
        session()->setFlashdata('success', 'Data pelaksanaan berhasil ditambahkan.');
        return redirect()->to('admin/pelaksanaan');
    }

    public function editPelaksanaan($id)
    {
        $model = new PelaksanaanModel();
        $pelangganModel = new PelangganModel();
        $data = [
            'page_title'       => 'Edit Data Pelaksanaan',
            'pelaksanaan'      => $model->find($id),
            'pelanggan_list'   => $pelangganModel->findAll()
        ];
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


    // ===================================================================
    // MODUL PEMESANAN
    // ===================================================================

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
        $data = [
            'page_title' => 'Tambah Pemesanan',
            'pelaksanaan_list' => $model->findAll()
        ];
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
        $data = [
            'page_title' => 'Edit Pemesanan',
            'pemesanan' => $pemesananModel->find($id),
            'pelaksanaan_list' => $pelaksanaanModel->findAll()
        ];
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
    // MODUL PENYEWAAN
    // ===================================================================

    public function dataPenyewaan()
    {
        $model = new \App\Models\PenyewaanModel();
        $data = [
            'page_title' => 'Data Penyewaan',
            'penyewaan_per_bulan' => $this->groupDataByMonth($model->orderBy('tanggal_penyewaan', 'DESC')->findAll(), 'tanggal_penyewaan')
        ];
        return view('admin/penyewaan', $data);
    }

   public function tambahPenyewaan()
    {
    // Panggil kedua model yang dibutuhkan
    $pelangganModel = new \App\Models\PelangganModel();
    $alatModel = new \App\Models\AlatModel(); // 1. Panggil Model Alat

    $data = [
        'page_title' => 'Tambah Data Penyewaan',
        'pelanggan_list' => $pelangganModel->findAll(),
        'alat_list' => $alatModel->findAll() // 2. Tambahkan daftar alat ke data
    ];

    // Kirim data yang sudah lengkap ke view
    return view('admin/tambah_penyewaan', $data);
    }
    
   public function simpanPenyewaan()
    {
        $penyewaanModel = new \App\Models\PenyewaanModel();
        $pelangganModel = new \App\Models\PelangganModel();
        
        // Ambil semua data dari form
        $data = $this->request->getPost();

        // Buat ID Sewa unik
        $data['id_sewa'] = 'SEWA' . date('ymdHis');

        // Ambil detail pelanggan berdasarkan id_namasewa dari form
        $pelanggan = $pelangganModel->find($this->request->getPost('id_namasewa'));
        if ($pelanggan) {
            // Isi nama_penyewa secara otomatis
            $data['nama_penyewa'] = $pelanggan['nama_lengkap'];
        }

        $penyewaanModel->save($data);

        session()->setFlashdata('success', 'Data penyewaan berhasil ditambahkan.');
        return redirect()->to('/admin/penyewaan');
    }

    public function viewPenyewaan($id)
    {
        $model = new \App\Models\PenyewaanModel();
        $data = [
            'page_title' => 'Detail Penyewaan',
            'penyewaan' => $model->find($id)
        ];
        return view('admin/view_penyewaan', $data);
    }

    public function editPenyewaan($id)
    {
    // Panggil semua model yang dibutuhkan
    $penyewaanModel = new \App\Models\PenyewaanModel();
    $pelangganModel = new \App\Models\PelangganModel();
    $alatModel = new \App\Models\AlatModel(); // 1. Panggil juga model Alat

    $data = [
        'page_title' => 'Edit Penyewaan',
        'penyewaan' => $penyewaanModel->find($id),
        'pelanggan_list' => $pelangganModel->findAll(),
        'alat_list' => $alatModel->findAll() // 2. Ambil dan kirim daftar alat
    ];
    
    return view('admin/edit_penyewaan', $data);
    }

    public function updatePenyewaan($id)
    {
        $penyewaanModel = new \App\Models\PenyewaanModel();
        $pelangganModel = new \App\Models\PelangganModel();

        // Ambil semua data dari form
        $data = $this->request->getPost();
        
        // Ambil detail pelanggan berdasarkan id_namasewa yang baru dipilih
        $pelanggan = $pelangganModel->find($this->request->getPost('id_namasewa'));
        if ($pelanggan) {
            // Update nama penyewa jika pelanggan berubah
            $data['nama_penyewa'] = $pelanggan['nama_lengkap'];
        }

        $penyewaanModel->update($id, $data);
        session()->setFlashdata('success', 'Data penyewaan berhasil diperbarui.');
        return redirect()->to('/admin/penyewaan');
    }   

    public function hapusPenyewaan($id)
    {
        $model = new \App\Models\PenyewaanModel();
        $model->delete($id);
        session()->setFlashdata('success', 'Data penyewaan berhasil dihapus.');
        return redirect()->to('/admin/penyewaan');
    }
    
   // ===================================================================
    // MODUL
    // ===================================================================

    public function dataAlat()
{
    // 1. Buat instance dari AlatModel
    $model = new \App\Models\AlatModel();
    
    // 2. Siapkan data untuk dikirim ke view
    $data = [
        'page_title' => 'Manajemen Data Alat',
        // 3. Ambil SEMUA data dari tabel alat dan masukkan ke 'alat_list'
        'alat_list'  => $model->findAll()
    ];
    
    // 4. Kirim data tersebut ke view 'admin/alat'
    return view('admin/alat', $data);
}

    public function tambahAlat()
    {
        $data = [
            'page_title' => 'Tambah Alat Baru',
            'validation' => \Config\Services::validation() // Kirim validation service ke view
        ];
        return view('admin/tambah_alat', $data);
    }

    public function simpanAlat()
    {
        // Aturan validasi
        $rules = [
            'id_alat' => 'required|is_unique[alat.id_alat]',
            'nama_alat' => 'required',
            'stok_alat' => 'required|numeric'
        ];

        if (!$this->validate($rules)) {
            // Jika validasi gagal, kembali ke form dengan error
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $model = new \App\Models\AlatModel();
        $model->save([
            'id_alat'        => $this->request->getPost('id_alat'),
            'cek_alat'       => $this->request->getPost('cek_alat'),
            'nama_alat'      => $this->request->getPost('nama_alat'),
            'stok_alat'      => $this->request->getPost('stok_alat'),
            'informasi_alat' => $this->request->getPost('informasi_alat')
        ]);
        
        session()->setFlashdata('success', 'Data alat berhasil ditambahkan.');
        return redirect()->to('/admin/alat');
    }

    public function editAlat($id)
    {
        $model = new \App\Models\AlatModel();
        $data = [
            'page_title' => 'Edit Data Alat',
            'validation' => \Config\Services::validation(),
            'alat'       => $model->find($id)
        ];

        if (empty($data['alat'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data alat tidak ditemukan.');
        }

        return view('admin/edit_alat', $data);
    }

    public function updateAlat($id)
    {
        // Aturan validasi (is_unique diubah untuk mengabaikan data saat ini)
        $rules = [
            'id_alat'   => 'required|is_unique[alat.id_alat,id_alat,' . $id . ']',
            'nama_alat' => 'required',
            'stok_alat' => 'required|numeric'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $model = new \App\Models\AlatModel();
        $model->update($id, [
            'id_alat'        => $this->request->getPost('id_alat'),
            'cek_alat'       => $this->request->getPost('cek_alat'),
            'nama_alat'      => $this->request->getPost('nama_alat'),
            'stok_alat'      => $this->request->getPost('stok_alat'),
            'informasi_alat' => $this->request->getPost('informasi_alat')
        ]);

        session()->setFlashdata('success', 'Data alat berhasil diperbarui.');
        return redirect()->to('/admin/alat');
    }

    public function hapusAlat($id)
    {
        $model = new \App\Models\AlatModel();
        $model->delete($id);
        session()->setFlashdata('success', 'Data alat berhasil dihapus.');
        return redirect()->to('/admin/alat');
    }
    
    // ===================================================================
    // MODUL PEMBAYARAN
    // ===================================================================

    public function dataPembayaran()
{
    $model = new \App\Models\PembayaranModel();
    $data = [
        'page_title' => 'Data Pembayaran',
        'pembayaran_list' => $model->getPembayaranWithDetails()
    ];
    return view('admin/pembayaran', $data);
}

public function tambahPembayaran()
{
    $pemesananModel = new \App\Models\PemesananModel();
    $penyewaanModel = new \App\Models\PenyewaanModel();

    $data = [
        'page_title'      => 'Tambah Data Pembayaran',
        'pemesanan_list'  => $pemesananModel->getPemesananWithDetails(),
        'penyewaan_list'  => $penyewaanModel->findAll(),
        'validation'      => \Config\Services::validation()
    ];
    return view('admin/tambah_pembayaran', $data);
}

public function simpanPembayaran()
{
    // Validasi disesuaikan dengan kolom database
    $rules = [
        'total_harga' => 'required|numeric',
        'no_rekening' => 'required|numeric',
        'tanggal_pembayaran' => 'required|valid_date',
        'metode_pembayaran' => 'required'
    ];
    
    if (empty($this->request->getPost('id_pesanan')) && empty($this->request->getPost('id_sewa'))) {
        return redirect()->back()->withInput()->with('error', 'Anda harus memilih salah satu: ID Pesanan atau ID Sewa.');
    }

    if (!$this->validate($rules)) {
        return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
    }

    $model = new \App\Models\PembayaranModel();
    $data = $this->request->getPost();
    
    $data['id_bayar'] = 'PAY' . date('ymdHis');
    
    $model->save($data);
    
    session()->setFlashdata('success', 'Data pembayaran berhasil ditambahkan.');
    return redirect()->to('admin/pembayaran');
}

public function hapusPembayaran($id)
{
    $model = new \App\Models\PembayaranModel();
    if ($model->find($id)) {
        $model->delete($id);
        session()->setFlashdata('success', 'Data pembayaran berhasil dihapus.');
    } else {
        session()->setFlashdata('error', 'Data pembayaran tidak ditemukan.');
    }
    return redirect()->to('admin/pembayaran');
}
    
    // ===================================================================
    // MODUL PENGEMBALIAN
    // ===================================================================

    public function dataPengembalian()
{
    $model = new \App\Models\PengembalianModel();
    $data = [
        'page_title' => 'Data Pengembalian',
        'pengembalian_list' => $model->getPengembalianWithDetails()
    ];
    return view('admin/pengembalian', $data);
}

public function tambahPengembalian()
{
    // Ambil data penyewaan untuk ditampilkan di dropdown
    $penyewaanModel = new \App\Models\PenyewaanModel();
    $data = [
        'page_title' => 'Tambah Data Pengembalian',
        'penyewaan_list' => $penyewaanModel->findAll(), // Di sini Anda bisa filter hanya yg statusnya 'Disewa'
        'validation' => \Config\Services::validation()
    ];
    return view('admin/tambah_pengembalian', $data);
}

public function simpanPengembalian()
{
    $rules = [
        'id_sewa' => 'required|is_unique[pengembalian.id_sewa,id_kembali,{id_kembali}]',
        'denda_kembali' => 'required|numeric',
        'tanggal_pengembalian' => 'required|valid_date'
    ];

    if (!$this->validate($rules)) {
        return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
    }

    $pengembalianModel = new \App\Models\PengembalianModel();
    $data = $this->request->getPost();
    
    // Buat ID Kembali yang unik
    $data['id_kembali'] = 'KMB' . date('ymdHis');
    
    $pengembalianModel->save($data);

    // Opsional: Update status di tabel penyewaan menjadi 'Selesai'
    $penyewaanModel = new \App\Models\PenyewaanModel();
    $penyewaanModel->update($data['id_sewa'], ['status' => 'Selesai']);
    
    session()->setFlashdata('success', 'Data pengembalian berhasil ditambahkan.');
    return redirect()->to('admin/pengembalian');
}

public function hapusPengembalian($id)
{
    $model = new \App\Models\PengembalianModel();
    if ($model->find($id)) {
        $model->delete($id);
        session()->setFlashdata('success', 'Data pengembalian berhasil dihapus.');
    } else {
        session()->setFlashdata('error', 'Data pengembalian tidak ditemukan.');
    }
    return redirect()->to('admin/pengembalian');
}
    

    // ===================================================================
    // MODUL PROFIL ADMIN
    // ===================================================================

    public function adminProfile()
    {
        $userModel = new UserModel();
        $adminData = $userModel->find(session()->get('user_id'));
        
        $data = [
            'page_title' => 'Profil Admin',
            'username'   => $adminData['username'],
            'nama_lengkap' => $adminData['nama_lengkap'],
            'email'      => $adminData['email'],
            'no_telpon'  => $adminData['no_telpon'],
            'alamat_rumah' => $adminData['alamat_rumah'],
            'foto_profil'  => $adminData['foto_profil']
        ];

        return view('admin/admin_profile', $data);
    }

    public function editAdminProfile()
    {
        $userModel = new UserModel();
        $adminData = $userModel->find(session()->get('user_id'));
        $data = [
            'page_title' => 'Edit Profil Admin',
            'username'   => $adminData['username'],
            'nama_lengkap' => $adminData['nama_lengkap'],
            'email'      => $adminData['email'],
            'no_telpon'  => $adminData['no_telpon'],
            'alamat_rumah' => $adminData['alamat_rumah'],
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

        // Update session
        session()->set('nama_lengkap', $data['nama_lengkap']);
        session()->set('email', $data['email']);
        if (isset($data['foto_profil'])) {
            session()->set('foto_profil', $data['foto_profil']);
        }
        
        session()->setFlashdata('success', 'Profil berhasil diperbarui.');
        return redirect()->to('admin/profile');
    }
}