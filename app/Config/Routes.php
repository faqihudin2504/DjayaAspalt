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
// RUTE HALAMAN ADMIN (DENGAN FILTER AUTH)
// ===================================================================
$routes->group('admin', ['filter' => 'auth:admin'], function($routes) {
    // Dashboard Admin
    $routes->get('/', 'Admin::index', ['as' => 'admin_dashboard']);

    // Manajemen Pelanggan
    $routes->get('pelanggan', 'Admin::manajemenPengguna');
    $routes->get('pelanggan/tambah', 'Admin::tambahPelanggan');
    $routes->post('pelanggan/simpan', 'Admin::simpanPelanggan');
    $routes->get('pelanggan/edit/(:any)', 'Admin::editPelanggan/$1');
    $routes->post('pelanggan/update/(:any)', 'Admin::updatePelanggan/$1');
    $routes->get('pelanggan/hapus/(:any)', 'Admin::hapusPelanggan/$1');
    $routes->get('pelanggan/view/(:any)', 'Admin::viewPelanggan/$1');
    
    // Manajemen Pelaksanaan
    $routes->get('pelaksanaan', 'Admin::dataPelaksanaan');
    $routes->get('pelaksanaan/tambah', 'Admin::tambahPelaksanaan');
    $routes->post('pelaksanaan/simpan', 'Admin::simpanPelaksanaan');
    $routes->get('pelaksanaan/edit/(:any)', 'Admin::editPelaksanaan/$1');
    $routes->post('pelaksanaan/update/(:any)', 'Admin::updatePelaksanaan/$1');
    $routes->get('pelaksanaan/hapus/(:any)', 'Admin::hapusPelaksanaan/$1');

    // Manajemen Pemesanan
    $routes->get('pemesanan', 'Admin::dataPemesanan');
    $routes->get('pemesanan/edit/(:any)', 'Admin::editPemesanan/$1');
    $routes->post('pemesanan/simpan', 'Admin::simpanPemesanan');
    $routes->get('pemesanan/tambah', 'Admin::tambahPemesanan');
    $routes->post('pemesanan/update/(:any)', 'Admin::updatePemesanan/$1');
    $routes->get('pemesanan/hapus/(:any)', 'Admin::hapusPemesanan/$1');

    // Manajemen Penyewaan
    $routes->get('penyewaan', 'Admin::dataPenyewaan');
    $routes->get('penyewaan/tambah', 'Admin::tambahPenyewaan');
    $routes->post('penyewaan/simpan', 'Admin::simpanPenyewaan');
    $routes->get('penyewaan/view/(:any)', 'Admin::viewPenyewaan/$1');  
    $routes->get('penyewaan/edit/(:any)', 'Admin::editPenyewaan/$1');  
    $routes->post('penyewaan/update/(:any)', 'Admin::updatePenyewaan/$1');
    $routes->get('penyewaan/hapus/(:any)', 'Admin::hapusPenyewaan/$1');  
    // ... rute untuk CRUD penyewaan lainnya akan menyusul

    // Manajemen Alat
    $routes->get('alat', 'Admin::dataAlat');
    $routes->get('alat/tambah', 'Admin::tambahAlat');
    $routes->post('alat/simpan', 'Admin::simpanAlat');
    $routes->get('alat/edit/(:any)', 'Admin::editAlat/$1');
    $routes->post('alat/update/(:any)', 'Admin::updateAlat/$1');
    $routes->get('alat/hapus/(:any)', 'Admin::hapusAlat/$1');

    // Manajemen Pembayaran
    $routes->get('pembayaran', 'Admin::dataPembayaran');
    $routes->get('pembayaran/tambah', 'Admin::tambahPembayaran');
    $routes->post('pembayaran/simpan', 'Admin::simpanPembayaran');
    $routes->get('pembayaran/hapus/(:any)', 'Admin::hapusPembayaran/$1');

    // Manajemen Pengembalian
    $routes->get('pengembalian', 'Admin::dataPengembalian');
    $routes->get('pengembalian/tambah', 'Admin::tambahPengembalian');
    $routes->post('pengembalian/simpan', 'Admin::simpanPengembalian');
    $routes->get('pengembalian/hapus/(:any)', 'Admin::hapusPengembalian/$1');

    // Profil Admin
    $routes->get('profile', 'Admin::adminProfile');
    $routes->get('profile/edit', 'Admin::editAdminProfile');
    $routes->post('profile/update', 'Admin::updateAdminProfile');
});

// ===================================================================
// RUTE HALAMAN CUSTOMER (DENGAN FILTER AUTH)
// ===================================================================
$routes->group('', ['filter' => 'auth:customer'], function($routes) {
    // Profil
    $routes->get('customer-profile', 'Pages::customerProfile');
    $routes->get('customer-profile/edit', 'Pages::editCustomerProfile');
    $routes->post('customer-profile/update', 'Pages::updateCustomerProfile');

    // Pemesanan & Penyewaan
    $routes->get('pemesanan', 'Pages::pemesanan');
    $routes->get('penyewaan-barang', 'Pages::penyewaanBarang');
    $routes->get('keranjang', 'Pages::keranjang');
    
    // Alur form
    $routes->get('pemesanan-jasa-barang-form1', 'Pages::pemesananJasaBarangForm1');
    $routes->get('pemesanan-jasa-barang-form2', 'Pages::pemesananJasaBarangForm2');
    $routes->get('pemesanan-paket', 'Pages::pemesananPaket');
    $routes->get('penyewaan-barang/cek-alat/(:segment)', 'Pages::cekAlat/$1');
    $routes->get('penyewaan-barang/form/(:segment)', 'Pages::penyewaanForm/$1');
});