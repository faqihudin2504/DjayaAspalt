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
        $data = ['page_title' => 'Manajemen Paket', 'pakets' => $paketModel->findAll(), 'back_url' => 'admin'];
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
            ],
            'back_url' => 'admin'
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
            'back_url'   => 'admin/cek-pekerja'
        ];
        return view('admin/cek_pekerja_detail', $data);
    }

    public function cekStokAlatBerat()
    {
        $model = new AlatModel();
        $data = [
            'page_title' => 'Cek Stok Alat Berat',
            'alat_list'  => $model->where('kategori', 'Alat Berat')->findAll(),
            'back_url'   => 'admin'
        ];
        return view('admin/cek_stok_alat_berat', $data);
    }

    public function cekStokMaterial()
    {
        $model = new AlatModel();
        $data = [
            'page_title'    => 'Cek Stok Material',
            'material_list' => $model->where('kategori', 'Material')->findAll(),
            'back_url'      => 'admin'
        ];
        return view('admin/cek_stok_material', $data);
    }
    
    //======================================================================
    // FUNGSI-FUNGSI CRUD (TAMBAH, SIMPAN, EDIT, UPDATE, HAPUS)
    //======================================================================

    // --- CRUD Pelanggan ---
    public function tambahPelanggan() { $data = ['page_title' => 'Tambah Pelanggan Baru', 'back_url' => 'admin/pelanggan']; return view('admin/tambah_pelanggan', $data); }
    public function simpanPelanggan() { $model = new PelangganModel(); $data = $this->request->getPost(); $data['id_pelanggan'] = substr(strtoupper($data['nama_lengkap']), 0, 1) . date('dmyHis'); $model->save($data); return redirect()->to('admin/pelanggan')->with('success', 'Data pelanggan baru berhasil ditambahkan.'); }
    public function editPelanggan($id) { $model = new PelangganModel(); $data = ['page_title' => 'Edit Pelanggan', 'pelanggan' => $model->find($id), 'back_url' => 'admin/pelanggan']; return view('admin/edit_pelanggan', $data); }
    public function updatePelanggan($id) { $model = new PelangganModel(); $model->update($id, $this->request->getPost()); return redirect()->to('admin/pelanggan')->with('success', 'Data pelanggan berhasil diperbarui.'); }
    public function viewPelanggan($id) { $model = new PelangganModel(); $data = ['page_title' => 'Detail Pelanggan', 'pelanggan' => $model->find($id), 'back_url' => 'admin/pelanggan']; return view('admin/view_pelanggan', $data); }
    public function hapusPelanggan($id) { $pelangganModel = new PelangganModel(); $penyewaanModel = new PenyewaanModel(); $pemesananModel = new PemesananModel(); $surveyModel = new SurveyModel(); $db = \Config\Database::connect(); $db->transStart(); try { $penyewaanModel->where('id_namasewa', $id)->delete(); $pemesananModel->where('id_pelanggan', $id)->delete(); $surveyModel->where('id_pelanggan', $id)->delete(); $pelangganModel->delete($id); $db->transComplete(); return redirect()->to('admin/pelanggan')->with('success', 'Data pelanggan dan semua transaksinya berhasil dihapus.'); } catch (\Exception $e) { $db->transRollback(); return redirect()->to('admin/pelanggan')->with('show_error_modal', true); } }

    // --- CRUD Survey ---
    public function tambahSurvey() { $pelangganModel = new PelangganModel(); $surveyModel = new SurveyModel(); $surveyedIds = $surveyModel->select('id_pelanggan')->distinct()->findAll(); $excludeIds = array_column($surveyedIds, 'id_pelanggan'); $pelanggan = empty($excludeIds) ? $pelangganModel->findAll() : $pelangganModel->whereNotIn('id_pelanggan', $excludeIds)->findAll(); return view('admin/tambah_survey', ['page_title' => 'Tambah Survey Baru', 'pelanggan_list' => $pelanggan, 'back_url' => 'admin/survey']); }
    public function simpanSurvey() { $model = new SurveyModel(); $model->insert($this->request->getPost()); return redirect()->to('/admin/survey')->with('success', 'Data survey berhasil ditambahkan.'); }
    public function editSurvey($id) { $surveyModel = new SurveyModel(); $pelangganModel = new PelangganModel(); $data = ['page_title' => 'Edit Data Survey', 'survey' => $surveyModel->find($id), 'pelanggan_list' => $pelangganModel->findAll(), 'back_url' => 'admin/survey']; return view('admin/edit_survey', $data); }
    public function updateSurvey($id) { $model = new SurveyModel(); $model->update($id, $this->request->getPost()); return redirect()->to('/admin/survey')->with('success', 'Data survey berhasil diperbarui.'); }
    public function hapusSurvey($id) { $model = new SurveyModel(); try { $model->delete($id); return redirect()->to('/admin/survey')->with('success', 'Data survey berhasil dihapus.'); } catch (\Exception $e) { return redirect()->to('/admin/survey')->with('show_error_modal', true); } }
    
    // --- CRUD Alat & Material ---
    public function tambahAlat() { return view('admin/tambah_alat', ['page_title' => 'Tambah Data Baru', 'back_url' => 'admin/alat-berat']); }
    public function editAlat($id) { $model = new AlatModel(); $alat = $model->find($id); $back_url = ($alat && $alat['kategori'] === 'Material') ? 'admin/material' : 'admin/alat-berat'; return view('admin/edit_alat', ['page_title' => 'Edit Data Alat', 'alat' => $alat, 'back_url' => $back_url]); }
    public function simpanAlat() { $model = new AlatModel(); $data = $this->request->getPost(); if ($gambar = $this->request->getFile('gambar_alat')) { if ($gambar->isValid() && !$gambar->hasMoved()) { $newName = $gambar->getRandomName(); $gambar->move(FCPATH . 'uploads/alat', $newName); $data['gambar_alat'] = $newName; } } $model->save($data); $redirect = ($data['kategori'] === 'Material') ? 'admin/material' : 'admin/alat-berat'; return redirect()->to($redirect)->with('success', 'Data berhasil disimpan.'); }
    public function updateAlat($id) { $model = new AlatModel(); $data = $this->request->getPost(); if ($gambar = $this->request->getFile('gambar_alat')) { if ($gambar->isValid() && !$gambar->hasMoved()) { $alatLama = $model->find($id); if ($alatLama && !empty($alatLama['gambar_alat'])) { @unlink(FCPATH . 'uploads/alat/' . $alatLama['gambar_alat']); } $newName = $gambar->getRandomName(); $gambar->move(FCPATH . 'uploads/alat', $newName); $data['gambar_alat'] = $newName; } } $model->update($id, $data); $redirect = ($data['kategori'] === 'Material') ? 'admin/material' : 'admin/alat-berat'; return redirect()->to($redirect)->with('success', 'Data berhasil diperbarui.'); }
    public function hapusAlat($id) { $model = new AlatModel(); try { $model->delete($id); return redirect()->back()->with('success', 'Data berhasil dihapus.'); } catch (\Exception $e) { return redirect()->back()->with('show_error_modal', true); } }

    // --- CRUD Paket ---
    public function tambahPaket() { return view('admin/tambah_paket', ['page_title' => 'Tambah Paket Baru', 'back_url' => 'admin/cek-paket']); }
    public function simpanPaket() { $model = new PaketModel(); $model->save($this->request->getPost()); return redirect()->to('admin/cek-paket')->with('success', 'Paket berhasil ditambahkan!'); }
    public function editPaket($id) { $model = new PaketModel(); return view('admin/edit_paket', ['page_title' => 'Edit Paket', 'paket' => $model->find($id), 'back_url' => 'admin/cek-paket']); }
    public function updatePaket($id) { $model = new PaketModel(); $model->update($id, $this->request->getPost()); return redirect()->to('admin/cek-paket')->with('success', 'Paket berhasil diperbarui.'); }
    public function hapusPaket($id) { $model = new PaketModel(); try { $model->delete($id); return redirect()->to('admin/cek-paket')->with('success', 'Paket berhasil dihapus.'); } catch (\Exception $e) { return redirect()->to('admin/cek-paket')->with('show_error_modal', true); } }
    
    // --- CRUD Pemesanan ---
    public function tambahPemesanan()
        {
            $pelangganModel = new PelangganModel();
            $alatModel = new AlatModel(); // Panggil model untuk material
            
            $data = [
                'page_title'     => 'Tambah Pemesanan',
                'pelanggan_list' => $pelangganModel->findAll(),
                'material_list'  => $alatModel->where('kategori', 'Material')->findAll() // Ambil data material
            ];
            return view('admin/tambah_pemesanan', $data);
        }
        
        public function viewPemesanan($id)
    {
        $pemesananModel = new \App\Models\PemesananModel();
        $detailModel = new \App\Models\DetailPemesananModel();

        // Ambil data utama pemesanan beserta nama pelanggan
        $pemesanan = $pemesananModel->select('pemesanan.*, pelanggan.nama_lengkap, pelanggan.no_telpon')
                                    ->join('pelanggan', 'pelanggan.id_pelanggan = pemesanan.id_pelanggan', 'left')
                                    ->where('pemesanan.id_pesanan', $id)
                                    ->first();

        if (!$pemesanan) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Ambil data detail material untuk pemesanan ini
        $detail_material = $detailModel->where('id_pesanan', $id)->findAll();

        // =============================================================
        // BAGIAN PERBAIKAN: HITUNG TOTAL HARGA AKHIR SECARA MANUAL
        // =============================================================
        $totalHargaMaterial = 0;
        foreach ($detail_material as $item) {
            $totalHargaMaterial += $item['sub_total'];
        }
        
        // Tambahkan total harga akhir ke dalam array pemesanan
        $pemesanan['total_harga_akhir'] = $pemesanan['harga_paketdipesan'] + $totalHargaMaterial;
        // =============================================================

        $data = [
            'page_title'      => 'Detail Pemesanan',
            'pemesanan'       => $pemesanan,
            'detail_material' => $detail_material,
            'back_url'        => 'admin/pemesanan'
        ];

        return view('admin/view_pemesanan', $data);
    }

    public function simpanPemesanan()
    {
        $db = \Config\Database::connect();
        $pemesananModel = new \App\Models\PemesananModel();
        $detailPemesananModel = new \App\Models\DetailPemesananModel();

        $db->transStart();

        try {
            $idPesananBaru = 'PES' . date('ymdHis');
            $hargaPaket = (int)$this->request->getPost('harga_paketdipesan');

            $totalHargaMaterial = 0;
            $materials = $this->request->getPost('material');

            if (!empty($materials)) {
                foreach ($materials as $material) {
                    if (empty($material['id']) || empty($material['jumlah'])) continue;
                    $subTotal = (int)$material['jumlah'] * (int)$material['harga'];
                    $detailPemesananModel->save([
                        'id_pesanan'        => $idPesananBaru,
                        'id_material'       => $material['id'],
                        'jumlah_material'   => $material['jumlah'],
                        'harga_saat_pesan'  => $material['harga'],
                        'sub_total'         => $subTotal
                    ]);
                    $totalHargaMaterial += $subTotal;
                }
            }

            // Data utama pemesanan dengan total harga akhir yang sudah dihitung
            $pemesananData = [
                'id_pesanan'        => $idPesananBaru,
                'id_pelanggan'      => $this->request->getPost('id_pelanggan'),
                'nama_paketdipesan' => $this->request->getPost('nama_paketdipesan'),
                'harga_paketdipesan'=> $hargaPaket,
                'tanggal_pemesanan' => $this->request->getPost('tanggal_pemesanan'),
                'total_harga_akhir' => $hargaPaket + $totalHargaMaterial // Perhitungan Total
            ];

            $pemesananModel->save($pemesananData);

            $db->transComplete();

            session()->setFlashdata('success', 'Data pemesanan baru berhasil ditambahkan.');
            return redirect()->to('/admin/pemesanan');

        } catch (\Exception $e) {
            $db->transRollback();
            log_message('error', '[SIMPAN PEMESANAN] ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat menyimpan data.');
        }
    }  
    public function editPemesanan($id) { $pemesananModel = new PemesananModel(); $pelangganModel = new PelangganModel(); $data = ['page_title' => 'Edit Data Pemesanan', 'pemesanan' => $pemesananModel->find($id), 'pelanggan_list' => $pelangganModel->findAll(), 'back_url' => 'admin/pemesanan']; return view('admin/edit_pemesanan', $data); }
    public function updatePemesanan($id) { $model = new PemesananModel(); $model->update($id, $this->request->getPost()); return redirect()->to('/admin/pemesanan')->with('success', 'Data pemesanan berhasil diperbarui.'); }
    public function hapusPemesanan($id) { $model = new PemesananModel(); try { $model->delete($id); return redirect()->to('/admin/pemesanan')->with('success', 'Data pemesanan berhasil dihapus.'); } catch (\Exception $e) { return redirect()->to('/admin/pemesanan')->with('show_error_modal', true); } }

    // --- CRUD Penyewaan ---
    public function tambahPenyewaan() { $pelangganModel = new PelangganModel(); $alatModel = new AlatModel(); $penyewaanModel = new PenyewaanModel(); $activeRentals = $penyewaanModel->where('status', 'Disewa')->select('id_namasewa')->distinct()->findAll(); $excludeIds = array_column($activeRentals, 'id_namasewa'); $availablePelanggan = empty($excludeIds) ? $pelangganModel->findAll() : $pelangganModel->whereNotIn('id_pelanggan', $excludeIds)->findAll(); $data = ['page_title' => 'Tambah Data Penyewaan Baru', 'pelanggan_list' => $availablePelanggan, 'alat_list' => $alatModel->where('stok_alat >', 0)->where('cek_alat', 'Tersedia')->findAll(), 'back_url' => 'admin/penyewaan']; return view('admin/tambah_penyewaan', $data); }
    public function simpanPenyewaan() { $penyewaanModel = new PenyewaanModel(); $alatModel = new AlatModel(); $pelangganModel = new PelangganModel(); $id_alat = $this->request->getPost('id_alat'); $id_pelanggan = $this->request->getPost('id_pelanggan'); if (empty($id_alat) || empty($id_pelanggan)) { return redirect()->back()->withInput()->with('error', 'Gagal: Pelanggan dan Alat wajib dipilih.'); } $alat = $alatModel->find($id_alat); $pelanggan = $pelangganModel->find($id_pelanggan); if (!$alat || !$pelanggan) { return redirect()->back()->withInput()->with('error', 'Gagal: Data Alat atau Pelanggan tidak ditemukan.'); } $idSewaBaru = 'SEWA' . date('ymdHis'); $data = ['id_sewa' => $idSewaBaru, 'id_namasewa' => $id_pelanggan, 'nama_penyewa' => $pelanggan['nama_lengkap'], 'id_alat' => $id_alat, 'nama_alatdisewa' => $alat['nama_alat'], 'harga_alatdisewa' => $this->request->getPost('harga_alatdisewa'), 'tanggal_penyewaan' => $this->request->getPost('tanggal_penyewaan'), 'alamat_penyewa' => $this->request->getPost('alamat_penyewa'), 'status' => 'Disewa']; if ($penyewaanModel->save($data)) { $stokBaru = $alat['stok_alat'] - 1; $statusAlatBaru = ($stokBaru > 0) ? 'Tersedia' : 'Disewa'; $alatModel->update($id_alat, ['stok_alat' => $stokBaru, 'cek_alat' => $statusAlatBaru]); session()->setFlashdata('success', 'Data penyewaan ' . $idSewaBaru . ' berhasil ditambahkan.'); } else { return redirect()->back()->withInput()->with('error', 'Gagal menyimpan data ke database.'); } return redirect()->to('admin/penyewaan'); }
    public function editPenyewaan($id) { $penyewaanModel = new PenyewaanModel(); $pelangganModel = new PelangganModel(); $alatModel = new AlatModel(); $data = ['page_title' => 'Edit Penyewaan', 'penyewaan' => $penyewaanModel->find($id), 'pelanggan_list' => $pelangganModel->findAll(), 'alat_list' => $alatModel->findAll(), 'back_url' => 'admin/penyewaan']; return view('admin/edit_penyewaan', $data); }
    public function updatePenyewaan($id) { $model = new PenyewaanModel(); $model->update($id, $this->request->getPost()); return redirect()->to('/admin/penyewaan')->with('success', 'Data penyewaan berhasil diperbarui.'); }
    public function viewPenyewaan($id) { $model = new PenyewaanModel(); $data = ['page_title' => 'Detail Penyewaan', 'penyewaan' => $model->find($id), 'back_url' => 'admin/penyewaan']; return view('admin/view_penyewaan', $data); }
    public function hapusPenyewaan($id) { $model = new PenyewaanModel(); try { $model->delete($id); return redirect()->to('/admin/penyewaan')->with('success', 'Data penyewaan berhasil dihapus.'); } catch (\Exception $e) { return redirect()->to('/admin/penyewaan')->with('show_error_modal', true); } }
    
    // --- CRUD Pembayaran ---
    public function tambahPembayaranPemesanan()
        {
            $pemesananModel = new PemesananModel();
            
            // Ambil data pemesanan, sekarang termasuk total harga akhirnya
            $transaksi_list = $pemesananModel->select('pemesanan.*, pelanggan.nama_lengkap')
                ->join('pelanggan', 'pelanggan.id_pelanggan = pemesanan.id_pelanggan', 'left')
                ->orderBy('pemesanan.tanggal_pemesanan', 'DESC')
                ->findAll();

            $data = [
                'page_title' => 'Tambah Pembayaran Pemesanan',
                'transaksi_list' => $transaksi_list,
                'tipe' => 'pemesanan',
                'back_url' => 'admin/pembayaran/pemesanan'
            ];
            return view('admin/pembayaran_tambah', $data);
        }    
        
    public function tambahPembayaranPenyewaan() { $model = new PenyewaanModel(); $data = ['page_title' => 'Tambah Pembayaran Penyewaan', 'transaksi_list' => $model->getPenyewaanWithDetails(), 'tipe' => 'penyewaan', 'back_url' => 'admin/pembayaran/penyewaan']; return view('admin/pembayaran_tambah', $data); }
    public function simpanPembayaran()
    {
        $model = new \App\Models\PembayaranModel();
        $data = $this->request->getPost();
        $data['id_bayar'] = 'PAY' . date('ymdHis');

        // Dapatkan file yang diupload
        $buktiFile = $this->request->getFile('bukti_pembayaran');

        // Cek apakah ada file yang valid diupload
        if ($buktiFile && $buktiFile->isValid() && !$buktiFile->hasMoved()) {
            // Buat nama file acak untuk keamanan
            $newName = $buktiFile->getRandomName();
            
            // Pindahkan file ke folder public/uploads/bukti
            // Pastikan Anda sudah membuat folder 'uploads' dan 'bukti' di dalam folder 'public'
            $buktiFile->move(FCPATH . 'uploads/bukti', $newName);
            
            // Simpan hanya nama filenya saja ke database
            $data['bukti_pembayaran'] = $newName;
        }

        $model->save($data);
        session()->setFlashdata('success', 'Data pembayaran berhasil direkam.');
        $redirectUrl = ($this->request->getPost('tipe') === 'penyewaan') ? 'admin/pembayaran/penyewaan' : 'admin/pembayaran/pemesanan';
        return redirect()->to($redirectUrl);
    }
    public function lihatBukti($id_bayar) { $model = new PembayaranModel(); $data['pembayaran'] = $model->find($id_bayar); return view('admin/detail_bukti_pembayaran', $data); }
    public function konfirmasiPembayaran($id_bayar = null)
    {
        if ($id_bayar === null) {
            return redirect()->back()->with('error', 'ID Pembayaran tidak valid.');
        }

        $pembayaranModel = new PembayaranModel();
        
        // Update status pembayaran menjadi 'Lunas'
        $pembayaranModel->update($id_bayar, ['status_pembayaran' => 'Lunas']);

        return redirect()->back()->with('success', 'Pembayaran berhasil dikonfirmasi menjadi Lunas.');
    }

    // --- CRUD Pengembalian ---
    public function tambahPengembalian() { $model = new PenyewaanModel(); return view('admin/tambah_pengembalian', ['page_title' => 'Tambah Data Pengembalian', 'penyewaan_list' => $model->where('status', 'Disewa')->findAll(), 'back_url' => 'admin/pengembalian']); }
    public function simpanPengembalian() { $pengembalianModel = new PengembalianModel(); $data = $this->request->getPost(); $data['id_kembali'] = 'KMB' . date('ymdHis'); $pengembalianModel->save($data); $penyewaanModel = new PenyewaanModel(); $alatModel = new AlatModel(); $penyewaan = $penyewaanModel->find($data['id_sewa']); $penyewaanModel->update($data['id_sewa'], ['status' => 'Selesai']); $alatModel->update($penyewaan['id_alat'], ['cek_alat' => 'Tersedia']); return redirect()->to('admin/pengembalian')->with('success', 'Data pengembalian berhasil ditambahkan.'); }
    
    //======================================================================
    // MANAJEMEN LAPORAN
    //======================================================================

    public function laporan() { $db = \Config\Database::connect(); $bulan = $this->request->getVar('bulan') ?? date('m'); $tahun = $this->request->getVar('tahun') ?? date('Y'); $builder1 = $db->table('pemesanan'); $builder1->select("pemesanan.id_pesanan as id_transaksi, pelanggan.nama_lengkap as nama_pelanggan, pemesanan.tanggal_pemesanan as tanggal, pemesanan.harga_paketdipesan as total_harga, 'Pemesanan' as tipe_transaksi"); $builder1->join('pelanggan', 'pelanggan.id_pelanggan = pemesanan.id_pelanggan'); $builder1->where('MONTH(pemesanan.tanggal_pemesanan)', $bulan); $builder1->where('YEAR(pemesanan.tanggal_pemesanan)', $tahun); $query1 = $builder1->getCompiledSelect(false); $builder2 = $db->table('penyewaan'); $builder2->select("penyewaan.id_sewa as id_transaksi, penyewaan.nama_penyewa as nama_pelanggan, penyewaan.tanggal_penyewaan as tanggal, penyewaan.harga_alatdisewa as total_harga, 'Penyewaan' as tipe_transaksi"); $builder2->where('MONTH(penyewaan.tanggal_penyewaan)', $bulan); $builder2->where('YEAR(penyewaan.tanggal_penyewaan)', $tahun); $query2 = $builder2->getCompiledSelect(); $laporanQuery = $db->query($query1 . ' UNION ALL ' . $query2 . ' ORDER BY tanggal DESC'); $data = ['page_title' => 'Laporan Transaksi', 'laporan' => $laporanQuery->getResultArray(), 'bulan' => $bulan, 'tahun' => $tahun,]; return view('admin/laporan', $data); }
    public function cetakLaporanPdf() { $db = \Config\Database::connect(); $bulan = $this->request->getGet('bulan') ?? date('m'); $tahun = $this->request->getGet('tahun') ?? date('Y'); $builder1 = $db->table('pemesanan'); $builder1->select("pemesanan.id_pesanan as id_transaksi, pelanggan.nama_lengkap as nama_pelanggan, pemesanan.tanggal_pemesanan as tanggal, pemesanan.harga_paketdipesan as total_harga, 'Pemesanan' as tipe_transaksi"); $builder1->join('pelanggan', 'pelanggan.id_pelanggan = pemesanan.id_pelanggan'); $builder1->where('MONTH(pemesanan.tanggal_pemesanan)', $bulan); $builder1->where('YEAR(pemesanan.tanggal_pemesanan)', $tahun); $query1 = $builder1->getCompiledSelect(false); $builder2 = $db->table('penyewaan'); $builder2->select("penyewaan.id_sewa as id_transaksi, penyewaan.nama_penyewa as nama_pelanggan, penyewaan.tanggal_penyewaan as tanggal, penyewaan.harga_alatdisewa as total_harga, 'Penyewaan' as tipe_transaksi"); $builder2->where('MONTH(penyewaan.tanggal_penyewaan)', $bulan); $builder2->where('YEAR(penyewaan.tanggal_penyewaan)', $tahun); $query2 = $builder2->getCompiledSelect(); $laporanQuery = $db->query($query1 . ' UNION ALL ' . $query2 . ' ORDER BY tanggal DESC'); $data = ['laporan' => $laporanQuery->getResultArray(), 'bulan' => $bulan, 'tahun' => $tahun,]; $dompdf = new Dompdf(); $html = view('admin/laporan_pdf', $data); $dompdf->loadHtml($html); $dompdf->setPaper('A4', 'portrait'); $dompdf->render(); $namaBulan = Time::createFromDate($tahun, $bulan, 1)->toLocalizedString('MMMM'); $nama_file = "Laporan Djaya Aspalt " . $namaBulan . " " . $tahun . ".pdf"; $dompdf->stream($nama_file, ['Attachment' => 1]); }

    //======================================================================
    // MANAJEMEN PROFIL ADMIN
    //======================================================================
    
    public function adminProfile() { $userModel = new UserModel(); $adminData = $userModel->find(session()->get('user_id')); $data = ['page_title' => 'Profil Admin', 'username' => $adminData['username'], 'nama_lengkap' => $adminData['nama_lengkap'], 'email' => $adminData['email'], 'no_telpon'  => $adminData['no_telpon'], 'alamat_rumah' => $adminData['alamat_rumah'], 'foto_profil'  => $adminData['foto_profil']]; return view('admin/admin_profile', $data); }
    public function editAdminProfile() { $userModel = new UserModel(); $adminData = $userModel->find(session()->get('user_id')); $data = ['page_title' => 'Edit Profil Admin', 'username' => $adminData['username'], 'nama_lengkap' => $adminData['nama_lengkap'], 'email' => $adminData['email'], 'no_telpon'  => $adminData['no_telpon'], 'alamat_rumah' => $adminData['alamat_rumah'], 'foto_profil'  => $adminData['foto_profil']]; return view('admin/edit_admin_profile', $data); }
    public function updateAdminProfile() { $userModel = new UserModel(); $id = session()->get('user_id'); $data = ['nama_lengkap' => $this->request->getPost('nama_lengkap'), 'email' => $this->request->getPost('email'), 'no_telpon' => $this->request->getPost('no_telpon'), 'alamat_rumah' => $this->request->getPost('alamat_rumah'),]; if ($foto = $this->request->getFile('foto_profil')) { if ($foto->isValid() && !$foto->hasMoved()) { $newName = $foto->getRandomName(); $foto->move(WRITEPATH . 'uploads/avatars', $newName); $data['foto_profil'] = $newName; } } $userModel->update($id, $data); session()->set('nama_lengkap', $data['nama_lengkap']); session()->set('email', $data['email']); if (isset($data['foto_profil'])) { session()->set('foto_profil', $data['foto_profil']); } return redirect()->to('admin/profile')->with('success', 'Profil berhasil diperbarui.'); }

    //======================================================================
    // FUNGSI HELPER & API
    //======================================================================
    
    private function groupDataByMonth($data, $dateColumn) { if (empty($data)) return []; $grouped = []; foreach ($data as $item) { if (empty($item[$dateColumn])) continue; $monthYear = Time::parse($item[$dateColumn])->toLocalizedString('MMMM YYYY'); if (!isset($grouped[$monthYear])) { $grouped[$monthYear] = []; } $grouped[$monthYear][] = $item; } krsort($grouped); return $grouped; }
    public function getAlatDetail($id_alat) { $alatModel = new AlatModel(); return $this->response->setJSON($alatModel->find($id_alat)); }
}