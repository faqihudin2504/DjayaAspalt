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
$routes->post('login', 'Login::login'); // Rute untuk memproses form login
$routes->get('logout', 'Login::logout');
$routes->get('register', 'Register::index'); // Halaman registrasi
$routes->post('register/save', 'Register::save'); // Proses registrasi

// Halaman publik yang bisa diakses siapa saja
$routes->get('dashboard', 'Pages::dashboard');
$routes->get('gallery', 'Pages::gallery');
$routes->get('hubungi-kami', 'Pages::hubungiKami');
$routes->get('artikel', 'Pages::artikel');
$routes->get('bantuan', 'Pages::bantuan');
$routes->get('profile-perusahaan', 'Pages::profilePerusahaan');

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
    $routes->get('pemesanan-jasa-barang-form2', 'Pages/::pemesananJasaBarangForm2');
    $routes->get('pemesanan-paket', 'Pages::pemesananPaket');
    $routes->get('penyewaan-barang/cek-alat/(:segment)', 'Pages::cekAlat/$1');
    $routes->get('penyewaan-barang/form/(:segment)', 'Pages::penyewaanForm/$1');
});


// ===================================================================
// RUTE HALAMAN ADMIN (DENGAN FILTER AUTH)
// ===================================================================
$routes->group('admin', ['filter' => 'auth:admin'], function($routes) {
    $routes->get('/', 'Admin::index');
    $routes->get('pelanggan', 'Admin::manajemenPengguna');
    // Tambahkan rute admin lainnya di sini...
    $routes->get('profile', 'Admin::adminProfile');
    $routes->get('profile/edit', 'Admin::editAdminProfile');
    $routes->post('profile/update', 'Admin::updateAdminProfile');
});