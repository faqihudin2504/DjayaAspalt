<?php

namespace App\Models;

use CodeIgniter\Model;

class PemesananModel extends Model
{
    protected $table            = 'pemesanan';
    protected $primaryKey       = 'id_pesanan';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $allowedFields    = ['id_pesanan', 'id_pelanggan', 'nama_paketdipesan', 'harga_paketdipesan', 'tanggal_pemesanan'];

    /**
     * FUNGSI BARU DITAMBAHKAN DI SINI
     * Mengambil data pemesanan dengan detail nama pelanggan.
     */
    public function getPemesananWithDetails()
    {
        return $this->select('pemesanan.*, pelanggan.nama_lengkap')
                    ->join('pelanggan', 'pelanggan.id_pelanggan = pemesanan.id_pelanggan', 'left')
                    ->orderBy('pemesanan.tanggal_pemesanan', 'DESC')
                    ->findAll();
    }
}