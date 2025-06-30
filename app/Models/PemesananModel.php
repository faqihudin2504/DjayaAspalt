<?php

namespace App\Models;

use CodeIgniter\Model;

class PemesananModel extends Model
{
    protected $table            = 'pemesanan';
    protected $primaryKey       = 'id_pesanan';
    protected $useAutoIncrement = false; // <-- WAJIB
    protected $returnType       = 'array';
    protected $allowedFields = [ 'id_pesanan', 'id_pelanggan', 'nama_paketdipesan', 'harga_paketdipesan', 'tanggal_pemesanan' ];

    /**
     * Mengambil semua data pemesanan dengan menggabungkan data pelanggan (users).
     * pemesanan -> pelaksanaan -> users
     */
}