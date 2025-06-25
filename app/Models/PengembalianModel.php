<?php

namespace App\Models;

use CodeIgniter\Model;

class PengembalianModel extends Model
{
    protected $table            = 'pengembalian';
    protected $primaryKey       = 'id_kembali';
    protected $allowedFields    = [
        'id_kembali', 'id_sewa', 'denda_kembali', 'tanggal_pengembalian'
    ];

    /**
     * Mengambil semua data pengembalian dengan menggabungkan data penyewaan,
     * pelanggan (users), dan alat untuk detail yang lengkap.
     */
    public function getPengembalianWithDetails()
    {
        return $this->select('pengembalian.*, penyewaan.tanggal_penyewaan, users.nama_lengkap, alat.nama_alat') // Ganti 'pelanggan.nama_lengkap' ke 'users.nama_lengkap'
                    ->join('penyewaan', 'penyewaan.id_sewa = pengembalian.id_sewa', 'left')
                    ->join('users', 'users.id = penyewaan.id_namasewa', 'left') // Ganti 'pelanggan' ke 'users'
                    ->join('alat', 'alat.id_alat = penyewaan.id_alat', 'left')
                    ->findAll();
    }
}