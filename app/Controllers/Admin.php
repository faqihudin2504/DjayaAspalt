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
        // Panggil semua model yang relevan
        $pelangganModel = new PelangganModel();
        $penyewaanModel = new PenyewaanModel();
        $pemesananModel = new PemesananModel();
        $surveyModel = new SurveyModel();
        
        // Dapatkan koneksi database dan mulai transaksi
        $db = \Config\Database::connect();
        $db->transStart();

        try {
            // 1. Hapus data anak terlebih dahulu
            // Hapus di tabel penyewaan (menggunakan id_namasewa sebagai foreign key)
            $penyewaanModel->where('id_namasewa', $id)->delete();
            
            // Hapus di tabel pemesanan
            $pemesananModel->where('id_pelanggan', $id)->delete();

            // Hapus di tabel survey
            $surveyModel->where('id_pelanggan', $id)->delete();

            // 2. Setelah semua data anak dihapus, baru hapus data induk (pelanggan)
            $pelangganModel->delete($id);

            // Jika semua berhasil, selesaikan transaksi
            $db->transComplete();

            return redirect()->to('admin/pelanggan')->with('success', 'Data pelanggan beserta semua transaksinya berhasil dihapus.');

        } catch (\Exception $e) {
            // Jika ada error di salah satu proses, batalkan semua transaksi
            $db->transRollback();
            return redirect()->to('admin/pelanggan')->with('error', 'Gagal menghapus data pelanggan: ' . $e->getMessage());
        }
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
    public function tambahPaket()
    {
        return view('admin/tambah_paket', ['page_title' => 'Tambah Paket Baru']);
    }

    public function simpanPaket()
    {
        $model = new PaketModel();
        $model->save($this->request->getPost());
        return redirect()->to('admin/cek-paket')->with('success', 'Paket baru berhasil ditambahkan!');
    }

    public function editPaket($id)
    {
        $model = new PaketModel();
        $data = ['page_title' => 'Edit Paket', 'paket' => $model->find($id)];
        return view('admin/edit_paket', $data);
    }

    public function updatePaket($id)
    {
        $model = new PaketModel();
        $model->update($id, $this->request->getPost());
        return redirect()->to('admin/cek-paket')->with('success', 'Paket berhasil diperbarui.');
    }

    public function hapusPaket($id)
    {
        $model = new PaketModel();
        $model->delete($id);
        return redirect()->to('admin/cek-paket')->with('success', 'Paket berhasil dihapus.');
    }
    
    // --- CRUD Pemesanan ---
    public function tambahPemesanan()
    {
        $pelangganModel = new PelangganModel();
        $data = [
            'page_title' => 'Tambah Pemesanan',
            'pelanggan_list' => $pelangganModel->findAll()
        ];
        return view('admin/tambah_pemesanan', $data);
    }

    public function simpanPemesanan()
    {
        $model = new PemesananModel();
        $data = $this->request->getPost();
        $data['id_pesanan'] = 'PES' . date('ymdHis');
        $model->save($data);
        return redirect()->to('/admin/pemesanan')->with('success', 'Data pemesanan berhasil ditambahkan.');
    }

    public function editPemesanan($id)
    {
        $pemesananModel = new PemesananModel();
        $pelangganModel = new PelangganModel();
        $pemesanan = $pemesananModel->find($id);
        if (empty($pemesanan)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data pemesanan tidak ditemukan: ' . $id);
        }
        $data = [
            'page_title'     => 'Edit Data Pemesanan',
            'pemesanan'      => $pemesanan,
            'pelanggan_list' => $pelangganModel->findAll()
        ];
        return view('admin/edit_pemesanan', $data);
    }

    public function updatePemesanan($id)
    {
        $model = new PemesananModel();
        $model->update($id, $this->request->getPost());
        return redirect()->to('/admin/pemesanan')->with('success', 'Data pemesanan berhasil diperbarui.');
    }

    public function hapusPemesanan($id)
    {
        $model = new PemesananModel();
        $model->delete($id);
        return redirect()->to('/admin/pemesanan')->with('success', 'Data pemesanan berhasil dihapus.');
    }
    
    // --- CRUD Penyewaan ---
    public function tambahPenyewaan()
    {
        $pelangganModel = new PelangganModel();
        $alatModel = new AlatModel();
        $penyewaanModel = new PenyewaanModel();
        
        $activeRentals = $penyewaanModel->where('status', 'Disewa')
            ->select('id_namasewa')
            ->distinct()
            ->findAll();
            
        $excludeIds = array_column($activeRentals, 'id_namasewa');

        $availablePelanggan = empty($excludeIds)
            ? $pelangganModel->findAll()
            : $pelangganModel->whereNotIn('id_pelanggan', $excludeIds)->findAll();

        $data = [
            'page_title'     => 'Tambah Data Penyewaan Baru',
            'pelanggan_list' => $availablePelanggan,
            'alat_list'      => $alatModel->where('stok_alat >', 0)->where('cek_alat', 'Tersedia')->findAll()
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
        
        if (empty($id_alat) || empty($id_pelanggan)) {
            return redirect()->back()->withInput()->with('error', 'Gagal: Pelanggan dan Alat wajib dipilih.');
        }
        
        $alat = $alatModel->find($id_alat);
        $pelanggan = $pelangganModel->find($id_pelanggan);

        if (!$alat || !$pelanggan) {
            return redirect()->back()->withInput()->with('error', 'Gagal: Data Alat atau Pelanggan tidak ditemukan.');
        }

        $idSewaBaru = 'SEWA' . date('ymdHis');
        $data = [
            'id_sewa'           => $idSewaBaru,
            'id_namasewa'       => $id_pelanggan,
            'nama_penyewa'      => $pelanggan['nama_lengkap'],
            'id_alat'           => $id_alat,
            'nama_alatdisewa'   => $alat['nama_alat'],
            'harga_alatdisewa'  => $this->request->getPost('harga_alatdisewa'),
            'tanggal_penyewaan' => $this->request->getPost('tanggal_penyewaan'),
            'alamat_penyewa'    => $this->request->getPost('alamat_penyewa'),
            'status'            => 'Disewa'
        ];
        
        if ($penyewaanModel->save($data)) {
            $stokBaru = $alat['stok_alat'] - 1;
            $statusAlatBaru = ($stokBaru > 0) ? 'Tersedia' : 'Disewa';
            $alatModel->update($id_alat, ['stok_alat' => $stokBaru, 'cek_alat' => $statusAlatBaru]);
            session()->setFlashdata('success', 'Data penyewaan ' . $idSewaBaru . ' berhasil ditambahkan.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan data ke database.');
        }
        
        return redirect()->to('admin/penyewaan');
    }

    public function editPenyewaan($id)
    {
        $penyewaanModel = new PenyewaanModel();
        $pelangganModel = new PelangganModel();
        $alatModel = new AlatModel();
        $data = [
            'page_title'     => 'Edit Penyewaan',
            'penyewaan'      => $penyewaanModel->find($id),
            'pelanggan_list' => $pelangganModel->findAll(),
            'alat_list'      => $alatModel->findAll()
        ];
        return view('admin/edit_penyewaan', $data);
    }

    public function updatePenyewaan($id)
    {
        $model = new PenyewaanModel();
        $model->update($id, $this->request->getPost());
        return redirect()->to('/admin/penyewaan')->with('success', 'Data penyewaan berhasil diperbarui.');
    }

    public function hapusPenyewaan($id)
    {
        $model = new PenyewaanModel();
        try {
            $model->delete($id);
            return redirect()->to('/admin/penyewaan')->with('success', 'Data penyewaan berhasil dihapus.');
        } catch (\CodeIgniter\Database\Exceptions\DatabaseException $e) {
            return redirect()->to('/admin/penyewaan')->with('error', 'Data gagal dihapus karena terhubung dengan data lain.');
        }
    }
    
    public function viewPenyewaan($id)
    {
        $model = new PenyewaanModel();
        $data = [
            'page_title' => 'Detail Penyewaan',
            'penyewaan'  => $model->find($id)
        ];
        return view('admin/view_penyewaan', $data);
    }
    
    // --- CRUD Pembayaran ---
    public function tambahPembayaranPemesanan()
    {
        $pemesananModel = new PemesananModel();
        $data = [
            'page_title' => 'Tambah Pembayaran Pemesanan',
            'transaksi_list' => $pemesananModel->getPemesananWithDetails(),
            'tipe' => 'pemesanan'
        ];
        return view('admin/pembayaran_tambah', $data);
    }

    public function tambahPembayaranPenyewaan()
    {
        $penyewaanModel = new PenyewaanModel();
        $data = [
            'page_title' => 'Tambah Pembayaran Penyewaan',
            'transaksi_list' => $penyewaanModel->getPenyewaanWithDetails(),
            'tipe' => 'penyewaan'
        ];
        return view('admin/pembayaran_tambah', $data);
    }

    public function simpanPembayaran()
    {
        $model = new PembayaranModel();
        $data = $this->request->getPost();
        $data['id_bayar'] = 'PAY' . date('ymdHis');
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

    // --- CRUD Pengembalian ---
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
    
    //======================================================================
    // MANAJEMEN LAPORAN
    //======================================================================

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
            $monthYear = Time::parse($item[$dateColumn])->toLocalizedString('MMMM yyyy');
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