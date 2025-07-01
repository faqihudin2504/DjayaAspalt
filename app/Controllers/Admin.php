<?php

namespace App\Controllers;


use App\Models\SurveyModel;
use App\Models\AlatModel;
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

        // Query untuk menggabungkan data pelanggan dengan survey dan penyewaan
        $pelangganData = $model->select('pelanggan.*, survey.id_survey, sewa.id_sewa')
                            ->join('surveys as survey', 'survey.id_pelanggan = pelanggan.id_pelanggan', 'left')
                            ->join('penyewaan as sewa', 'sewa.id_namasewa = pelanggan.id_pelanggan', 'left')
                            ->groupBy('pelanggan.id_pelanggan') // Menghindari duplikat
                            ->orderBy('pelanggan.created_at', 'DESC')
                            ->findAll();

        $data = [
            'page_title' => 'Manajemen Pelanggan',
            'pelanggan_per_bulan' => $this->groupDataByMonth($pelangganData, 'created_at')
        ];
        
        return view('admin/manajemen_pengguna', $data);
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

    public function tambahSurvey()
    {
        $pelangganModel = new PelangganModel();
        $data = [
            'page_title' => 'Tambah Survey Baru',
            'pelanggan_list' => $pelangganModel->findAll()
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

        if ($surveyModel->insert($data)) {
            return redirect()->to('/admin/survey')->with('success', 'Data survey berhasil ditambahkan.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan data survey.');
        }
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

        if ($surveyModel->update($id, $data)) {
            return redirect()->to('/admin/survey')->with('success', 'Data survey berhasil diperbarui.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui data survey.');
        }
    }

    public function hapusSurvey($id)
    {
        $surveyModel = new SurveyModel();
        if ($surveyModel->delete($id)) {
            return redirect()->to('/admin/survey')->with('success', 'Data survey berhasil dihapus.');
        } else {
            return redirect()->to('/admin/survey')->with('error', 'Gagal menghapus data survey.');
        }
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
    
    public function dataPemesanan()
    {
        $model = new PemesananModel();

        // Query baru dengan JOIN
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

   // di file app/Controllers/Admin.php
    public function tambahPemesanan()
    {
        $pelangganModel = new PelangganModel(); // Tambahkan ini
        $data = [
            'page_title' => 'Tambah Pemesanan',
            'pelanggan_list' => $pelangganModel->findAll() // Tambahkan ini
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
        $pelangganModel = new PelangganModel(); // Tambahkan ini

        $pemesanan = $pemesananModel->find($id);

        if (empty($pemesanan)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data pemesanan tidak ditemukan: ' . $id);
        }

        $data = [
            'page_title'     => 'Edit Data Pemesanan',
            'pemesanan'      => $pemesanan,
            'pelanggan_list' => $pelangganModel->findAll() // Tambahkan ini untuk mengirim daftar pelanggan
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
    // 4. MANAJEMEN ALAT (CEK ALAT)
    // ===================================================================
    // UBAH FUNGSI INI (dari dataAlat menjadi dataAlatBerat)
    public function dataAlatBerat()
    {
        $model = new AlatModel();
        $data = [
            'page_title' => 'Manajemen Alat Berat',
            // Filter hanya untuk 'Alat Berat'
            'alat_list'  => $model->where('kategori', 'Alat Berat')->findAll()
        ];
        return view('admin/alat', $data); // Kita tetap pakai view 'alat.php'
    }

    // TAMBAHKAN FUNGSI BARU INI
    public function dataMaterial()
    {
        $model = new AlatModel();
        $data = [
            'page_title' => 'Manajemen Material',
            // Filter hanya untuk 'Material'
            'alat_list'  => $model->where('kategori', 'Material')->findAll()
        ];
        return view('admin/alat', $data); // Kita juga pakai view 'alat.php' yang sama
    }

    public function tambahAlat()
    {
        $alatModel = new \App\Models\AlatModel();
        $data = [
            'page_title' => 'Tambah Data / Update Stok',
            'alat_list'  => $alatModel->findAll() // Mengirim daftar alat ke view
        ];
        return view('admin/tambah_alat', $data);
    }

    public function simpanAlat()
    {
        $alatModel = new \App\Models\AlatModel();
        
        // Validasi dasar, bisa Anda kembangkan lebih lanjut
        $rules = [
            'id_alat'   => 'required|is_unique[alat.id_alat]',
            'nama_alat' => 'required',
            'kategori'  => 'required',
            'stok_alat' => 'required|numeric'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'id_alat'        => $this->request->getPost('id_alat'),
            'cek_alat'       => $this->request->getPost('cek_alat'),
            'nama_alat'      => $this->request->getPost('nama_alat'),
            'kategori'       => $this->request->getPost('kategori'),
            'stok_alat'      => $this->request->getPost('stok_alat'),
            'informasi_alat' => $this->request->getPost('informasi_alat'),
            'harga_sewa'     => $this->request->getPost('harga_sewa'),
        ];

        // Logika upload gambar
        $gambar = $this->request->getFile('gambar_alat');
        if ($gambar && $gambar->isValid() && !$gambar->hasMoved()) {
            $newName = $gambar->getRandomName();
            $gambar->move(FCPATH . 'uploads/alat', $newName);
            $data['gambar_alat'] = $newName;
        }

        // Simpan ke database
        $alatModel->save($data);
        session()->setFlashdata('success', 'Data baru berhasil ditambahkan.');

        // **REVISI UTAMA DI SINI**
        // Redirect berdasarkan kategori yang dipilih
        if ($this->request->getPost('kategori') === 'Material') {
            return redirect()->to('admin/material');
        } else {
            return redirect()->to('admin/alat-berat');
        }
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
        $model = new AlatModel();
        $data = $this->request->getPost();

        // Logika untuk upload gambar baru jika ada
        $gambar = $this->request->getFile('gambar_alat');
        if ($gambar && $gambar->isValid() && !$gambar->hasMoved()) {
            // Hapus gambar lama jika ada untuk menghemat ruang
            $alatLama = $model->find($id);
            if ($alatLama && !empty($alatLama['gambar_alat']) && file_exists(FCPATH . 'uploads/alat/' . $alatLama['gambar_alat'])) {
                unlink(FCPATH . 'uploads/alat/' . $alatLama['gambar_alat']);
            }

            // Pindahkan gambar baru dan update nama filenya di data
            $newName = $gambar->getRandomName();
            $gambar->move(FCPATH . 'uploads/alat', $newName);
            $data['gambar_alat'] = $newName;
        }

        // Update data di database
        $model->update($id, $data);

        // Set pesan sukses
        session()->setFlashdata('success', 'Data alat berhasil diperbarui.');

        // **REVISI UTAMA ADA DI SINI**
        // Redirect ke halaman yang sesuai berdasarkan kategori
        $kategori = $this->request->getPost('kategori');
        if ($kategori === 'Material') {
            return redirect()->to('/admin/material');
        } else {
            return redirect()->to('/admin/alat-berat');
        }
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
            // SEKARANG MENGAMBIL SEMUA PELANGGAN, KARENA SEMUA BOLEH MENYEWA
            'pelanggan_list' => $pelangganModel->findAll(),
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
        return view('admin/pengembalian', $data);
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
        return view('admin/cek_stok_alat', $data);
    }

    // Fungsi untuk menampilkan stok MATERIAL
    public function cekStokMaterial()
    {
        $model = new \App\Models\AlatModel();
        $data = [
            'page_title' => 'Cek Stok Material',
            // UBAH NAMA VARIABEL DI BARIS INI
            'material_list'  => $model->where('kategori', 'Material')->findAll()
        ];
        // Pastikan nama file view sudah benar
        return view('admin/cek_stok_material', $data);
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

    // ===================================================================
    // FUNGSI UNTUK HALAMAN CEK (TERHUBUNG KE DATABASE)
    // ===================================================================

    public function cek_paket()
    {
        // 1. Panggil PaketModel
        $paketModel = new \App\Models\PaketModel();

        // 2. Siapkan data untuk dikirim ke view
        $data = [
            'page_title' => 'Cek Ketersediaan Paket',
            // 3. Ambil semua data dari tabel paket dan masukkan ke variabel 'pakets'
            'pakets'     => $paketModel->findAll()
        ];

        // 4. Kirim data ke view
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
        $model = new \App\Models\PekerjaModel();
        $data = [
            'page_title' => 'Cek Status Pekerja',
            'pekerja' => [
                'bekerja' => $model->where('status_pekerja', 'bekerja')->countAllResults(),
                'tersedia' => $model->where('status_pekerja', 'tersedia')->countAllResults(),
            ]
        ];
        return view('admin/cek_pekerja_status', $data);
    }

    public function api_getPemesananDetail($id)
    {
        $model = new PemesananModel();
        $data = $model->find($id);
        return $this->response->setJSON($data);
    }

    public function api_getPenyewaanDetail($id)
    {
        $model = new PenyewaanModel();
        $data = $model->find($id);
        return $this->response->setJSON($data);
    }

    public function testlayout()
    {
        return view('admin/test_view');
    }

    public function tambahPaket()
    {
        $data = [
            'page_title' => 'Tambah Paket Baru'
        ];
        return view('admin/tambah_paket', $data);
    }

    // Method untuk menyimpan data paket baru ke database
    public function simpanPaket()
    {
        $paketModel = new \App\Models\PaketModel();

        $data = [
            'nama_paket'      => $this->request->getPost('nama_paket'),
            'deskripsi_paket' => $this->request->getPost('deskripsi_paket'),
            'harga_paket'     => $this->request->getPost('harga_paket'),
        ];

        // Simpan data ke database
        $paketModel->save($data);

        // Arahkan kembali ke halaman cek paket dengan pesan sukses
        return redirect()->to('admin/cek-paket')->with('success', 'Paket baru berhasil ditambahkan!');
    }

    public function hapusPaket($id = null)
    {
        $paketModel = new \App\Models\PaketModel();
        if ($id) {
            $paketModel->delete($id);
        }
        return redirect()->to('admin/cek-paket')->with('success', 'Paket berhasil dihapus.');
    }

    public function editPaket($id = null)
    {
        $paketModel = new \App\Models\PaketModel();
        $data = [
            'page_title' => 'Edit Paket',
            'paket'      => $paketModel->find($id)
        ];

        if (empty($data['paket'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Paket tidak ditemukan.');
        }

        return view('admin/edit_paket', $data);
    }

    // Method untuk menyimpan perubahan dari form edit
    public function updatePaket($id = null)
    {
        $paketModel = new \App\Models\PaketModel();
        $data = [
            'nama_paket'      => $this->request->getPost('nama_paket'),
            'deskripsi_paket' => $this->request->getPost('deskripsi_paket'),
            'harga_paket'     => $this->request->getPost('harga_paket'),
        ];

        $paketModel->update($id, $data);
        return redirect()->to('admin/cek-paket')->with('success', 'Paket berhasil diperbarui.');
    }
}