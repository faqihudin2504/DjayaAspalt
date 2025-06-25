<?php

namespace App\Models;

use CodeIgniter\Model;

class PemesananModel extends Model
{
    protected $table            = 'pemesanan';
    protected $primaryKey       = 'id_pesanan';
    protected $allowedFields    = [
        'id_pesanan', 'id_pelaksanaan', 'nama_paketdipesan',
        'harga_paketdipesan', 'tanggal_pemesanan'
    ];

    /**
     * Mengambil semua data pemesanan dengan menggabungkan data pelanggan (users).
     * pemesanan -> pelaksanaan -> users
     */
    public function getPemesananWithDetails()
    {
        return $this->select('pemesanan.*, users.nama_lengkap, pelaksanaan.alamat_pelaksanaan') // Ganti 'pelanggan.nama_lengkap' ke 'users.nama_lengkap'
                    ->join('pelaksanaan', 'pelaksanaan.id_pelaksanaan = pemesanan.id_pelaksanaan', 'left')
                    ->join('users', 'users.id = pelaksanaan.id_pelanggan', 'left') // Ganti 'pelanggan' ke 'users'
                    ->findAll();
    }
}