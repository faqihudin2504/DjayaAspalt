<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// ===================================================================
// RUTE HALAMAN PUBLIK & OTENTIKASI
// ===================================================================
$routes->get('/', 'Pages::splashScreen');
$routes->get('login', 'Login::index');
$routes->post('login', 'Login::login');
$routes->get('logout', 'Login::logout');
$routes->get('register', 'Register::index');
$routes->post('register/save', 'Register::save');

// Halaman publik yang bisa diakses siapa saja
$routes->get('dashboard', 'Pages::dashboard');
$routes->get('gallery', 'Pages::gallery');
$routes->get('hubungi-kami', 'Pages::hubungiKami');
$routes->get('artikel', 'Pages::artikel');
$routes->get('bantuan', 'Pages::bantuan');
$routes->get('profile-perusahaan', 'Pages::profilePerusahaan');


// ===================================================================
// RUTE HALAMAN ADMIN (/admin)
// ===================================================================
$routes->group('admin', ['filter' => 'auth:admin'], function($routes) {

    // --- Dashboard ---
    $routes->get('/', 'Admin::index', ['as' => 'admin_dashboard']);

    // --- Cek Paket, Stok, & Pekerja ---
    $routes->get('cek-paket', 'Admin::cek_paket');
    $routes->get('cek-stok/alat-berat', 'Admin::cekStokAlatBerat');
    $routes->get('cek-stok/material', 'Admin::cekStokMaterial');
    $routes->get('cek-pekerja', 'Admin::cek_pekerja');
    $routes->get('cek-pekerja-detail/(:segment)', 'Admin::cek_pekerja_detail/$1');

    // --- Manajemen Pelanggan ---
    $routes->get('pelanggan', 'Admin::manajemenPengguna');
    $routes->get('pelanggan/tambah', 'Admin::tambahPelanggan');
    $routes->post('pelanggan/simpan', 'Admin::simpanPelanggan');
    $routes->get('pelanggan/view/(:any)', 'Admin::viewPelanggan/$1');
    $routes->get('pelanggan/edit/(:any)', 'Admin::editPelanggan/$1');
    $routes->post('pelanggan/update/(:any)', 'Admin::updatePelanggan/$1');
    $routes->get('pelanggan/hapus/(:any)', 'Admin::hapusPelanggan/$1');

    // --- Manajemen Survey ---
    $routes->get('survey', 'Admin::dataSurvey');
    $routes->get('survey/tambah', 'Admin::tambahSurvey');
    $routes->post('survey/simpan', 'Admin::simpanSurvey');
    $routes->get('survey/edit/(:num)', 'Admin::editSurvey/$1');
    $routes->post('survey/update/(:num)', 'Admin::updateSurvey/$1');
    $routes->get('survey/hapus/(:num)', 'Admin::hapusSurvey/$1');

    // --- Manajemen Alat & Material ---
    $routes->get('alat-berat', 'Admin::dataAlatBerat'); // Menampilkan daftar Alat Berat
    $routes->get('material', 'Admin::dataMaterial');   // Menampilkan daftar Material
    $routes->get('alat/tambah', 'Admin::tambahAlat');
    $routes->post('alat/simpan', 'Admin::simpanAlat');
    $routes->get('alat/edit/(:any)', 'Admin::editAlat/$1');
    $routes->post('alat/update/(:any)', 'Admin::updateAlat/$1');
    $routes->get('alat/hapus/(:any)', 'Admin::hapusAlat/$1');
    
    // --- Manajemen Pemesanan ---
    $routes->get('pemesanan', 'Admin::dataPemesanan');
    $routes->get('pemesanan/tambah', 'Admin::tambahPemesanan');
    $routes->post('pemesanan/simpan', 'Admin::simpanPemesanan');
    $routes->get('pemesanan/edit/(:any)', 'Admin::editPemesanan/$1');
    $routes->post('pemesanan/update/(:any)', 'Admin::updatePemesanan/$1');
    $routes->get('pemesanan/hapus/(:any)', 'Admin::hapusPemesanan/$1');
    
    // --- Manajemen Penyewaan ---
    $routes->get('penyewaan', 'Admin::dataPenyewaan');
    $routes->get('penyewaan/tambah', 'Admin::tambahPenyewaan');
    $routes->post('penyewaan/simpan', 'Admin::simpanPenyewaan');
    $routes->get('penyewaan/view/(:any)', 'Admin::viewPenyewaan/$1');
    $routes->get('penyewaan/edit/(:any)', 'Admin::editPenyewaan/$1');
    $routes->post('penyewaan/update/(:any)', 'Admin::updatePenyewaan/$1');
    $routes->get('penyewaan/hapus/(:any)', 'Admin::hapusPenyewaan/$1');
    $routes->get('penyewaan/get-alat-detail/(:any)', 'Admin::getAlatDetail/$1');

    // --- Manajemen Pembayaran ---
    $routes->get('pembayaran/pemesanan', 'Admin::dataPembayaranPemesanan');
    $routes->get('pembayaran/penyewaan', 'Admin::dataPembayaranPenyewaan');
    $routes->get('pembayaran/pemesanan/tambah', 'Admin::tambahPembayaranPemesanan');
    $routes->get('pembayaran/penyewaan/tambah', 'Admin::tambahPembayaranPenyewaan');
    $routes->post('pembayaran/simpan', 'Admin::simpanPembayaran');
    $routes->get('pembayaran/bukti/lihat/(:any)', 'Admin::lihatBukti/$1');
    
    // --- Manajemen Pengembalian ---
    $routes->get('pengembalian', 'Admin::dataPengembalian');
    $routes->get('pengembalian/tambah', 'Admin::tambahPengembalian');
    $routes->post('pengembalian/simpan', 'Admin::simpanPengembalian');
    
    // --- Manajemen Paket ---
    $routes->get('paket/tambah', 'Admin::tambahPaket');
    $routes->post('paket/simpan', 'Admin::simpanPaket');
    $routes->get('paket/edit/(:num)', 'Admin::editPaket/$1');
    $routes->post('paket/update/(:num)', 'Admin::updatePaket/$1');
    $routes->get('paket/hapus/(:num)', 'Admin::hapusPaket/$1');

    // --- Profil Admin ---
    $routes->get('profile', 'Admin::adminProfile');
    $routes->get('profile/edit', 'Admin::editAdminProfile');
    $routes->post('profile/update', 'Admin::updateAdminProfile');
});


// ===================================================================
// RUTE HALAMAN CUSTOMER (SETELAH LOGIN)
// ===================================================================
$routes->group('', ['filter' => 'auth:customer'], function($routes) {

    // --- Profil & Histori ---
    $routes->get('customer-profile', 'Pages::customerProfile');
    $routes->get('customer-profile/edit', 'Pages::editCustomerProfile');
    $routes->post('customer-profile/update', 'Pages::updateCustomerProfile');
    $routes->get('histori-pemesanan', 'Pages::historiPemesanan');
    $routes->get('histori-penyewaan', 'Pages::historiPenyewaan');

    // --- Alur Pemesanan & Penyewaan ---
    $routes->get('pemesanan', 'Pages::pemesanan');
    $routes->get('penyewaan-barang', 'Pages::penyewaanBarang');
    $routes->get('keranjang', 'Pages::keranjang');
    
    // Alur form yang lebih spesifik
    $routes->get('pemesanan-jasa-barang-form1', 'Pages::pemesananJasaBarangForm1');
    $routes->get('pemesanan-jasa-barang-form2', 'Pages::pemesananJasaBarangForm2');
    $routes->get('pemesanan-paket', 'Pages::pemesananPaket');
    $routes->get('penyewaan-barang/cek-alat/(:segment)', 'Pages::cekAlat/$1');
    $routes->get('penyewaan-barang/form/(:segment)', 'Pages::penyewaanForm/$1');
});