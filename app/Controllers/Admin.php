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
use App\Models\PaketModel;
use App\Models\PekerjaModel;
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
    $model = new PelangganModel();
    $data = $this->request->getPost();

    $prefix = substr(strtoupper($data['nama_lengkap']), 0, 1);
    $data['id_pelanggan'] = $prefix . date('dmyHis');

    $tujuan = $this->request->getPost('tujuan');
    $data['id_survey'] = null;
    $data['id_namasewa'] = null;

    if ($tujuan === 'survey') {
        $data['id_survey'] = 'SURVEY' . date('dmyHis');
        session()->setFlashdata('success', 'Data pelanggan baru untuk SURVEY berhasil ditambahkan.');
    } elseif ($tujuan === 'sewa') {
        $data['id_namasewa'] = 'SEWA' . date('dmyHis');
        session()->setFlashdata('success', 'Data pelanggan baru untuk SEWA berhasil ditambahkan.');
    }
    $data['tanggal_survey'] = date('Y-m-d H:i:s'); 

    unset($data['tujuan']);
    $model->save($data);

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
    $data = $this->request->getPost();
    
    // Hapus tanggal dari data yang diupdate agar tidak bisa diubah
    unset($data['tanggal_survey']);

    $model->update($id, $data);
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

        // 1. Ambil tanggal dari form input
        $tanggalInput = $this->request->getPost('tanggal_pelaksanaan');
        
        // 2. Ambil hanya bagian tanggal (YYYY-MM-DD) untuk query
        $tanggalUntukQuery = date('Y-m-d', strtotime($tanggalInput));

        // 3. Hitung berapa banyak pelaksanaan yang sudah ada di tanggal tersebut
        $jumlahHariIni = $model->where('DATE(tanggal_pelaksanaan)', $tanggalUntukQuery)->countAllResults();

        // 4. Buat nomor urut berikutnya (jumlah + 1) dengan format 2 digit (01, 02, dst)
        $nomorUrut = str_pad($jumlahHariIni + 1, 2, '0', STR_PAD_LEFT);
        
        // 5. Format tanggal menjadi ddmmyyyy sesuai Figma
        $formatTanggalFigma = date('dmY', strtotime($tanggalInput));

        // 6. Gabungkan semua menjadi ID baru
        $data['id_pelaksanaan'] = 'Pelaksanaan' . $formatTanggalFigma . $nomorUrut;

        // Simpan data ke database
        $model->save($data);
        session()->setFlashdata('success', 'Data pelaksanaan dengan ID baru berhasil ditambahkan.');

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
    // 1. Siapkan kedua model yang akan digunakan
    $pelaksanaanModel = new PelaksanaanModel();
    $pemesananModel = new PemesananModel();

    // 2. Ambil semua data dari form yang disubmit
    $data = $this->request->getPost();

    // 3. Lakukan update pada tabel 'pelaksanaan' seperti biasa
    if ($pelaksanaanModel->update($id, $data)) {
        
        // --- PROSES SINKRONISASI DIMULAI DI SINI ---
        
        // 4. Ambil tanggal baru yang diinput dari form
        $tanggalBaru = $data['tanggal_pelaksanaan'];

        // 5. Cari semua baris di tabel 'pemesanan' yang memiliki 'id_pelaksanaan' yang sama,
        //    lalu update kolom 'tanggal_pemesanan' mereka dengan tanggal baru.
        $pemesananModel->where('id_pelaksanaan', $id)
                       ->set('tanggal_pemesanan', $tanggalBaru)
                       ->update();

        // 6. Set pesan sukses
        session()->setFlashdata('success', 'Data pelaksanaan dan pemesanan terkait berhasil disinkronkan.');

    } else {
        // Jika update pertama gagal, set pesan error
        session()->setFlashdata('error', 'Gagal memperbarui data pelaksanaan.');
    }

    // 7. Kembali ke halaman daftar pelaksanaan
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
    // ... (kode validasi Anda)

    $model = new AlatModel();
    $data = $this->request->getPost();

    $gambar = $this->request->getFile('gambar_alat');
    if ($gambar && $gambar->isValid() && !$gambar->hasMoved()) {
        $newName = $gambar->getRandomName();
        $gambar->move(FCPATH . 'uploads/alat', $newName); // Pindahkan ke public/uploads/alat
        $data['gambar_alat'] = $newName;
    }

    $model->save($data);
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
    // ... (kode validasi Anda)

    $model = new AlatModel();
    $data = $this->request->getPost();

    $gambar = $this->request->getFile('gambar_alat');
    if ($gambar && $gambar->isValid() && !$gambar->hasMoved()) {
        // Hapus gambar lama jika ada
        $alatLama = $model->find($id);
        if ($alatLama && $alatLama['gambar_alat'] && file_exists(FCPATH . 'uploads/alat/' . $alatLama['gambar_alat'])) {
            unlink(FCPATH . 'uploads/alat/' . $alatLama['gambar_alat']);
        }

        $newName = $gambar->getRandomName();
        $gambar->move(FCPATH . 'uploads/alat', $newName);
        $data['gambar_alat'] = $newName;
    }

    $model->update($id, $data);
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
        $penyewaanData = $model->getPenyewaanWithDetails(); // Ambil data

        // Kelompokkan data berdasarkan bulan
        $groupedData = [];
        foreach ($penyewaanData as $item) {
            $month = date('F Y', strtotime($item['tanggal_penyewaan']));
            $groupedData[$month][] = $item;
        }

        $data = [
            'page_title'        => 'Data Penyewaan Alat',
            'penyewaan_per_bulan' => $groupedData // <-- Kirim data yang sudah dikelompokkan
        ];
        return view('admin/penyewaan', $data);
    }

    public function tambahPenyewaan()
    {
        $pelangganModel = new PelangganModel();
        $alatModel = new AlatModel();

        $data = [
            'page_title' => 'Tambah Data Penyewaan Baru',
            // Ambil pelanggan yang mendaftar untuk 'Sewa'
            'pelanggan_list' => $pelangganModel->where('id_namasewa IS NOT NULL')->where('id_namasewa !=', '')->findAll(),
            // Ambil HANYA alat yang stoknya > 0 DAN statusnya 'Tersedia'
            'alat_list' => $alatModel->where('stok_alat >', 0)->where('cek_alat', 'Tersedia')->findAll()
        ];
        
        return view('admin/tambah_penyewaan', $data);
    }
    
    public function simpanPenyewaan()
    {
        $penyewaanModel = new PenyewaanModel();
        $alatModel = new AlatModel();
        $pelangganModel = new PelangganModel();

        $id_alat = $this->request->getPost('id_alat');
        $id_pelanggan = $this->request->getPost('id_pelanggan');
        
        // --- VALIDASI SEBELUM SIMPAN ---
        if (empty($id_alat) || empty($id_pelanggan)) {
            return redirect()->back()->withInput()->with('error', 'Gagal: Pelanggan dan Alat wajib dipilih.');
        }
        
        $alat = $alatModel->find($id_alat);
        $pelanggan = $pelangganModel->find($id_pelanggan);

        if (!$alat) {
            return redirect()->back()->withInput()->with('error', 'Gagal: Data Alat tidak ditemukan di database.');
        }
        if (!$pelanggan) {
            return redirect()->back()->withInput()->with('error', 'Gagal: Data Pelanggan tidak ditemukan di database.');
        }
        // --- AKHIR VALIDASI ---

        $idSewaBaru = 'SEWA' . date('ymdHis');

        $data = [
            'id_sewa' => $idSewaBaru,
            'id_namasewa' => $id_pelanggan,
            'nama_penyewa' => $pelanggan['nama_lengkap'],
            'id_alat' => $id_alat,
            'nama_alatdisewa' => $alat['nama_alat'],
            'harga_alatdisewa' => $this->request->getPost('harga_alatdisewa'), // Ambil dari form
            'tanggal_penyewaan' => $this->request->getPost('tanggal_penyewaan'),
            'alamat_penyewa' => $this->request->getPost('alamat_penyewa'),
            'status' => 'Disewa'
        ];
        
        if ($penyewaanModel->save($data)) {
            // Jika berhasil, kurangi stok alat & ubah status jika stok jadi 0
            $stokBaru = $alat['stok_alat'] - 1;
            $statusAlatBaru = ($stokBaru > 0) ? 'Tersedia' : 'Disewa'; // Jika stok habis, langsung set jadi Disewa/Tidak Tersedia
            $alatModel->update($id_alat, ['stok_alat' => $stokBaru, 'cek_alat' => $statusAlatBaru]);
            
            session()->setFlashdata('success', 'Data penyewaan ' . $idSewaBaru . ' berhasil ditambahkan.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan data ke database.');
        }
        
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
            'pembayaran_list' => $model->getPembayaranDetails('pemesanan'),
            'tipe' => 'pemesanan'
        ];
        return view('admin/pembayaran_data', $data); // Menggunakan view pembayaran_data
    }
    
    public function dataPembayaranPenyewaan()
    {
        $model = new PembayaranModel();
        $data = [
            'page_title' => 'Data Pembayaran Penyewaan',
            'pembayaran_list' => $model->getPembayaranDetails('penyewaan'),
            'tipe' => 'penyewaan'
        ];
        return view('admin/pembayaran_data', $data); // Menggunakan view pembayaran_data
    }
    
    public function tambahPembayaranPemesanan()
    {
        $pemesananModel = new PemesananModel();
        $data = [
            'page_title' => 'Tambah Pembayaran Pemesanan',
            'transaksi_list' => $pemesananModel->getPemesananWithDetails(),
            'tipe' => 'pemesanan'
        ];
        return view('admin/pembayaran_tambah', $data); // Menggunakan view pembayaran_tambah
    }

    public function tambahPembayaranPenyewaan()
    {
        $penyewaanModel = new PenyewaanModel();
        $data = [
            'page_title' => 'Tambah Pembayaran Penyewaan',
            'transaksi_list' => $penyewaanModel->getPenyewaanWithDetails(),
            'tipe' => 'penyewaan'
        ];
        return view('admin/pembayaran_tambah', $data); // Menggunakan view pembayaran_tambah
    }

    public function simpanPembayaran()
    {
        $model = new PembayaranModel();
        $data = $this->request->getPost();
        
        $data['id_bayar'] = 'PAY' . date('ymdHis');

        // Logika untuk upload bukti pembayaran
        $buktiFile = $this->request->getFile('bukti_pembayaran');
        if ($buktiFile && $buktiFile->isValid() && !$buktiFile->hasMoved()) {
            $newName = $buktiFile->getRandomName();
            $buktiFile->move(FCPATH . 'uploads/bukti', $newName);
            $data['bukti_pembayaran'] = $newName;
        }

        $model->save($data);

        session()->setFlashdata('success', 'Data pembayaran berhasil direkam.');
        $redirectUrl = ($this->request->getPost('tipe') === 'penyewaan') ? 'admin/pembayaran/penyewaan' : 'admin/pembayaran/pemesanan';
        return redirect()->to($redirectUrl);
    }

    public function lihatBukti($id_bayar)
    {
        $model = new PembayaranModel();
        $data['pembayaran'] = $model->find($id_bayar);
        return view('admin/detail_bukti_pembayaran', $data);
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

    public function cekStokAlat()
    {
        $model = new AlatModel();
        $data = [
            'page_title' => 'Cek Stok Alat',
            'alat_list'  => $model->findAll()
        ];
        return view('admin/cek_stok_alat', $data); // Menggunakan view yang sudah ada
    }

    // ===================================================================
    // FUNGSI UNTUK HALAMAN CEK (TERHUBUNG KE DATABASE)
    // ===================================================================

    public function cek_paket()
    {
        $model = new PaketModel(); // Memanggil model Paket
        $data = [
            'page_title' => 'Daftar Paket Pengaspalan',
            'paket_list' => $model->findAll() // Mengambil semua data dari tabel paket
        ];
        return view('admin/cek_paket', $data);
    }

    public function cek_stok()
    {
        $model = new AlatModel(); // Memanggil model Alat
        $data = [
            'page_title' => 'Cek Stok Alat',
            'alat_list'  => $model->findAll() // Mengambil semua data dari tabel alat
        ];
        return view('admin/cek_stok_alat', $data);
    }

    public function cek_pekerja()
    {
        $model = new PekerjaModel(); // Memanggil model Pekerja
        $data = [
            'page_title'   => 'Cek Status Pekerja',
            'pekerja_list' => $model->findAll() // Mengambil semua data dari tabel pekerja
        ];
        return view('admin/cek_pekerja_status', $data);
    }
}