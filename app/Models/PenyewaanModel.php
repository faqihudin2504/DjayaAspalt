<?php

namespace App\Models;

use CodeIgniter\Model;

class PenyewaanModel extends Model
{
    protected $table            = 'penyewaan';
    protected $primaryKey       = 'id_sewa';
    protected $useAutoIncrement = false; // <-- WAJIB ADA KARENA PK BUKAN ANGKA
    protected $returnType       = 'array';

    /**
     * Kolom yang diizinkan untuk diisi, sudah termasuk kolom otomatis.
     */
    protected $allowedFields    = [
        'id_sewa',
        'id_pelanggan',
        'nama_penyewa',
        'id_alat',
        'nama_alat',
        'harga_alatdisewa',
        'tanggal_penyewaan',
        'alamat_penyewa',
        'status'
    ];

    /**
     * Mengambil data penyewaan lengkap dengan nama pelanggan dari tabel users.
     */
    public function getPenyewaanWithDetails()
    {
        return $this->select('penyewaan.*, users.nama_lengkap')
                    ->join('users', 'users.id = penyewaan.id_pelanggan', 'left')
                    ->orderBy('penyewaan.tanggal_penyewaan', 'DESC')
                    ->findAll();
    }
}