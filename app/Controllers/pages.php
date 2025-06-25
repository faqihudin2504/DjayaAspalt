<?php
// KODE FINAL UNTUK pages.php
namespace App\Controllers;

use App\Controllers\BaseController;

class Pages extends BaseController
{
    // Fungsi mustLogin(), isAdmin(), isCustomer() ini sekarang bersifat opsional atau
    // hanya untuk keperluan internal/debug jika diperlukan di controller ini,
    // karena filter di Routes.php sudah menangani pembatasan akses utama.
    private function mustLogin()
    {
        return session()->get('logged_in');
    }

    private function isAdmin()
    {
        return $this->mustLogin() && session()->get('role') === 'admin';
    }

    private function functionisCustomer()
    {
        return $this->mustLogin() && session()->get('role') === 'customer';
    }

    // Metode baru untuk Splash Screen
    public function splashScreen() {
        return view('splash_screen');
    }

    // Halaman-halaman yang bebas diakses tanpa login (atau diizinkan oleh filter di Routes.php)
    public function dashboard() {
        // Cek dulu apakah ada yang login dan rolenya admin.
        if (session()->get('logged_in') && session()->get('role') === 'admin') {
            // Jika ya, jangan tampilkan dashboard pelanggan, tapi langsung
            // arahkan ke dashboard admin yang seharusnya.
            return redirect()->to('admin');
        }

        $data = [];
        // Cek jika ada flashdata success_register dari Register Controller
        if (session()->getFlashdata('success_register')) {
            $data['show_success_register_modal'] = true;
        }
        return view('dashboard/index', $data);
    }
    public function gallery()          { return view('pages/gallery'); }
    public function hubungiKami()      { return view('pages/hubungi_kami'); }
    public function artikel()          { return view('pages/artikel'); }
    public function bantuan()          { return view('pages/bantuan'); }

    // Metode untuk menampilkan PROFIL PERUSAHAAN (CV. Djaya Aspalt) - untuk SIDEBAR
    public function profilePerusahaan() {
        return view('pages/profile'); // Menggunakan view profile.php yang sudah ada
    }

    // Metode untuk menampilkan BIODATA PELANGGAN - untuk TOPBAR
    public function customerProfile() {
        return view('pages/customer_profile');
    }

    // Metode untuk halaman Edit Profil Pelanggan
    public function editCustomerProfile() {
        $data['nama_lengkap'] = session()->get('nama_lengkap') ?? 'Nama Lengkap Anda';
        $data['no_handphone'] = session()->get('no_handphone') ?? '08xxxxxxxxxx';
        $data['email'] = session()->get('email') ?? 'email@example.com';
        $data['alamat_rumah'] = session()->get('alamat_rumah') ?? 'Alamat Rumah Anda';
        return view('pages/edit_customer_profile', $data);
    }

    // Metode untuk memproses update profil pelanggan (saat ini simulasi)
    public function updateCustomerProfile() {
        session()->setFlashdata('success', 'Profil berhasil diperbarui!');
        // Anda bisa update session dummy data di sini juga kalau mau
        // session()->set('nama_lengkap', $this->request->getPost('nama_lengkap'));
        // session()->set('email', $this->request->getPost('email'));
        return redirect()->to('customer-profile');
    }

    // Metode untuk Histori Pemesanan
    public function historiPemesanan() {
        // Data dummy untuk simulasi jika ada pemesanan
        $data['has_orders'] = true; // Ganti false untuk melihat tampilan "Tidak Ada Pesanan"
        $data['pemesanan'] = [
            'paket' => 'Paket A',
            'nama' => 'Samuel Orief Rosario',
            'waktu' => '7 Hari',
            'tanggal' => '12-12-2024 sampai 19-12-2024',
            'lokasi' => 'Jl. Bhakti No.48 3, RT.3/RW.7, Cilandak Tim., Ps. Minggu, Kota Jakarta Selatan, Daerah Khusus Ibukota Jakarta 12560'
        ];
        return view('pages/histori_pemesanan', $data);
    }

    // Metode untuk Histori Penyewaan
    public function historiPenyewaan() {
        // Data dummy untuk simulasi jika ada penyewaan
        $data['has_rentals'] = true; // Ganti false untuk melihat tampilan "Tidak Ada Penyewaan"
        $data['penyewaan'] = [
            'nama_alat' => 'Penggilas Aspal Besar',
            'waktu_sewa' => '1 Hari',
            'tanggal_sewa' => '12.00 Wib, 13-12-2024',
            'tanggal_kembali' => '12.00 Wib, 14-12-2024',
            'nama_penyewa' => 'Samuel Orief Rosario',
            'lokasi_sewa' => 'Jl. Bhakti No.48 3, RT.3/RW.7, Cilandak Tim., Ps. Minggu, Kota Jakarta Selatan, Daerah Khusus Ibukota Jakarta 12560'
        ];
        return view('pages/histori_penyewaan', $data);
    }

    // Metode untuk tampilan Keranjang (mode belum ada pesanan)
    public function keranjangKosong() {
        return view('pages/keranjang_kosong');
    }
    // Metode untuk tampilan Keranjang (mode ada pesanan)
    public function keranjang() {
        $data['pemesanan'] = [
            'paket_nama' => 'Paket A',
            'paket_harga' => 70000,
            'detail_layanan' => [
                ['nama' => 'Pembersihan Lokasi', 'harga' => 10000],
                ['nama' => 'Pemadatan Baby Roller', 'harga' => 15000],
                ['nama' => 'Cor Emulasi', 'harga' => 15000],
                ['nama' => 'Gelar Aspal Hotmix 2cm', 'harga' => 10000],
            ],
            'upah_tenaga_per_hari' => 20000,
            'upah_tenaga_jumlah_hari' => 7,
            'biaya_admin' => 5000
        ];
        return view('pages/keranjang', $data);
    }

    // Metode untuk Pemesanan (Pilih Jasa/Barang)
    public function pemesanan() {
        return view('pages/pemesanan');
    }

    // Metode untuk Form Pemesanan Jasa & Barang (Data Survey)
    public function pemesananJasaBarangForm1() {
        return view('pages/pemesanan_jasa_barang_form1');
    }
    // Metode untuk Form Pemesanan Jasa & Barang (Data Pelaksanaan)
    public function pemesananJasaBarangForm2() {
        return view('pages/pemesanan_jasa_barang_form2');
    }
    // Metode untuk Paket Pemesanan
    public function pemesananPaket() {
        return view('pages/pemesanan_paket');
    }

    // Metode untuk Penyewaan Barang (Pilih Alat)
    public function penyewaanBarang() {
        return view('pages/penyewaan_barang');
    }
    // Metode untuk Cek Alat Tersedia
    public function cekAlat($alat = 'Penggilas Aspal Besar') {
        $data['alat_nama'] = str_replace('-', ' ', $alat);
        $data['alat_stok'] = 2; // Contoh stok
        $data['alat_tersedia'] = true; // Contoh status
        $data['alat_info'] = "Alat ini digunakan untuk memadatkan lapisan aspal pada jalan yang sedang dibangun atau diperbaiki. Dengan ukurannya yang besar, alat ini mampu menghasilkan tekanan yang kuat untuk memastikan aspal menjadi padat dan rata.";
        return view('pages/cek_alat', $data);
    }
    // Metode untuk Form Penyewaan
    public function penyewaanForm($alat = 'Penggilas Aspal Besar') {
        $data['alat_nama'] = str_replace('-', ' ', $alat);
        $data['harga_per_hari'] = 850000; // Contoh harga
        return view('pages/penyewaan_form', $data);
    }
}