<?php

namespace App\Models;

use CodeIgniter\Model;

class PemesananModel extends Model
{
    protected $table            = 'pemesanan';
    protected $primaryKey       = 'id_pesanan';
    protected $useAutoIncrement = false; // <-- WAJIB
    protected $returnType       = 'object';
    protected $allowedFields = [ 'id_pesanan', 'id_pelanggan', 'nama_paketdipesan', 'harga_paketdipesan', 'tanggal_pemesanan' ];

    /**
     * Mengambil semua data pemesanan dengan menggabungkan data pelanggan (users).
     * pemesanan -> pelaksanaan -> users
     */
    public function getPemesananWithDetails()
    {
        return $this->select('pemesanan.*, pelanggan.nama_lengkap')
                    ->join('pelanggan', 'pelanggan.id_pelanggan = pemesanan.id_pelanggan', 'left')
                    ->orderBy('pemesanan.tanggal_pemesanan', 'DESC')
                    ->findAll();
    }
}