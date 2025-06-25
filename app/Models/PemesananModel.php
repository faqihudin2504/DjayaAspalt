<?php

namespace App\Models;

use CodeIgniter\Model;

class PemesananModel extends Model
{
    protected $table            = 'pemesanan';
    protected $primaryKey       = 'id_pesanan';

    // Beritahu model bahwa primary key tidak di-generate otomatis oleh database
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';

    // Daftarkan 'id_pesanan' sebagai kolom yang boleh diisi
    protected $allowedFields    = [
        'id_pesanan', // <-- INI KUNCINYA
        'id_pelaksanaan',
        'nama_paketdipesan',
        'harga_paketdipesan',
        'tanggal_pemesanan'
    ];

    /**
     * Mengambil semua data pemesanan dengan menggabungkan data pelanggan (users).
     * pemesanan -> pelaksanaan -> users
     */
    public function getPemesananWithDetails()
    {
        return $this->select('pemesanan.*, users.nama_lengkap, pelaksanaan.alamat_pelaksanaan')
                    ->join('pelaksanaan', 'pelaksanaan.id_pelaksanaan = pemesanan.id_pelaksanaan', 'left')
                    ->join('users', 'users.id = pelaksanaan.id_pelanggan', 'left')
                    ->findAll();
    }
}