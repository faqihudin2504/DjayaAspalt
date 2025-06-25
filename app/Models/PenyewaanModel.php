<?php

namespace App\Models;

use CodeIgniter\Model;

class PenyewaanModel extends Model
{
    protected $table            = 'penyewaan';
    protected $primaryKey       = 'id_sewa';
    protected $allowedFields    = [
        'id_sewa', 'id_alat', 'id_namasewa', 'harga_alatdisewa',
        'tanggal_penyewaan', 'alamat_penyewa'
    ];

    /**
     * Mengambil semua data penyewaan dengan menggabungkan data alat dan pelanggan (users).
     */
    public function getPenyewaanWithDetails()
    {
        return $this->select('penyewaan.*, alat.nama_alat, users.nama_lengkap') // Ganti 'pelanggan.nama_lengkap' ke 'users.nama_lengkap'
                    ->join('alat', 'alat.id_alat = penyewaan.id_alat', 'left')
                    ->join('users', 'users.id = penyewaan.id_namasewa', 'left') // Ganti 'pelanggan' ke 'users'
                    ->findAll();
    }
}