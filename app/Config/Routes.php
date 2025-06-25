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
$routes->get('dashboard', 'Pages::dashboard');
$routes->get('gallery', 'Pages::gallery');
$routes->get('hubungi-kami', 'Pages::hubungiKami');
$routes->get('artikel', 'Pages::artikel');
$routes->get('bantuan', 'Pages::bantuan');

// ===================================================================
// RUTE HALAMAN ADMIN (DENGAN FILTER AUTH)
// ===================================================================
$routes->group('admin', ['filter' => 'auth:admin'], function($routes) {
    
    // Dashboard Admin
    $routes->get('/', 'Admin::index');

    // Modul Pelanggan
    $routes->get('pelanggan', 'Admin::manajemenPengguna');
    $routes->get('pelanggan/view/(:any)', 'Admin::viewPelanggan/$1');
    $routes->get('pelanggan/tambah', 'Admin::tambahPelanggan');
    $routes->post('pelanggan/simpan', 'Admin::simpanPelanggan');
    $routes->get('pelanggan/edit/(:any)', 'Admin::editPelanggan/$1');
    $routes->post('pelanggan/update/(:any)', 'Admin::updatePelanggan/$1');
    $routes->get('pelanggan/hapus/(:any)', 'Admin::hapusPelanggan/$1');

    // Modul Pelaksanaan
    $routes->get('pelaksanaan', 'Admin::dataPelaksanaan');
    $routes->get('pelaksanaan/tambah', 'Admin::tambahPelaksanaan');
    $routes->post('pelaksanaan/simpan', 'Admin::simpanPelaksanaan');
    $routes->get('pelaksanaan/edit/(:any)', 'Admin::editPelaksanaan/$1');
    $routes->post('pelaksanaan/update/(:any)', 'Admin::updatePelaksanaan/$1');
    $routes->get('pelaksanaan/hapus/(:any)', 'Admin::hapusPelaksanaan/$1');
    
    // Modul Pemesanan
    $routes->get('pemesanan', 'Admin::dataPemesanan');
    $routes->get('pemesanan/tambah', 'Admin::tambahPemesanan');
    $routes->post('pemesanan/simpan', 'Admin::simpanPemesanan');
    $routes->get('pemesanan/edit/(:any)', 'Admin::editPemesanan/$1');
    $routes->post('pemesanan/update/(:any)', 'Admin::updatePemesanan/$1');
    $routes->get('pemesanan/hapus/(:any)', 'Admin::hapusPemesanan/$1');

    // Modul Penyewaan
    $routes->get('penyewaan', 'Admin::dataPenyewaan');
    $routes->get('penyewaan/tambah', 'Admin::tambahPenyewaan');
    $routes->post('penyewaan/simpan', 'Admin::simpanPenyewaan');
    $routes->get('penyewaan/edit/(:any)', 'Admin::editPenyewaan/$1');
    $routes->post('penyewaan/update/(:any)', 'Admin::updatePenyewaan/$1');
    $routes->get('penyewaan/hapus/(:any)', 'Admin::hapusPenyewaan/$1');
    
    // Modul Alat
    $routes->get('alat', 'Admin::dataAlat');
    $routes->get('alat/tambah', 'Admin::tambahAlat');
    $routes->post('alat/simpan', 'Admin::simpanAlat');
    $routes->get('alat/edit/(:any)', 'Admin::editAlat/$1');
    $routes->post('alat/update/(:any)', 'Admin::updateAlat/$1');
    $routes->get('alat/hapus/(:any)', 'Admin::hapusAlat/$1');

    // Modul Pembayaran
    $routes->get('pembayaran', 'Admin::dataPembayaran');
    $routes->get('pembayaran/tambah', 'Admin::tambahPembayaran');
    $routes->post('pembayaran/simpan', 'Admin::simpanPembayaran');
    $routes->get('pembayaran/edit/(:any)', 'Admin::editPembayaran/$1');
    $routes->post('pembayaran/update/(:any)', 'Admin::updatePembayaran/$1');
    $routes->get('pembayaran/hapus/(:any)', 'Admin::hapusPembayaran/$1');
    
    // Modul Pengembalian
    $routes->get('pengembalian', 'Admin::dataPengembalian');
    $routes->get('pengembalian/tambah', 'Admin::tambahPengembalian');
    $routes->post('pengembalian/simpan', 'Admin::simpanPengembalian');
    $routes->get('pengembalian/edit/(:any)', 'Admin::editPengembalian/$1');
    $routes->post('pengembalian/update/(:any)', 'Admin::updatePengembalian/$1');
    $routes->get('pengembalian/hapus/(:any)', 'Admin::hapusPengembalian/$1');
    
    // Rute halaman Cek
    $routes->get('cek-paket', 'Admin::cekPaket');
    $routes->get('cek-stok', 'Admin::cekStok');
    $routes->get('cek-stok-full', 'Admin::cekStokFull');
    $routes->get('cek-pekerja', 'Admin::cekPekerja');
    $routes->get('cek-pekerja-detail/(:segment)', 'Admin::cekPekerjaDetail/$1');
    
    // Rute profil
    $routes->get('profile', 'Admin::adminProfile');

    // Rute untuk Edit Profil Admin
    $routes->get('profile/edit', 'Admin::editAdminProfile');
    $routes->post('profile/update', 'Admin::updateAdminProfile');

});