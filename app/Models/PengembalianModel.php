<?php

namespace App\Models;

use CodeIgniter\Model;

class PengembalianModel extends Model
{
    protected $table            = 'pengembalian';
    protected $primaryKey       = 'id_kembali';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';

    /**
     * Kolom ini disesuaikan 100% dengan struktur tabel database Anda.
     */
    protected $allowedFields    = [
        'id_kembali',
        'id_sewa',
        'denda_kembali',
        'tanggal_pengembalian'
    ];

    /**
     * Mengambil data pengembalian dengan detail dari penyewaan terkait
     * (nama penyewa dan nama alat).
     */
    public function getPengembalianWithDetails()
    {
        return $this->select('pengembalian.*, penyewaan.nama_penyewa, alat.nama_alat')
                    ->join('penyewaan', 'penyewaan.id_sewa = pengembalian.id_sewa', 'left')
                    ->join('alat', 'alat.id_alat = penyewaan.id_alat', 'left')
                    ->orderBy('pengembalian.tanggal_pengembalian', 'DESC')
                    ->findAll();
    }
}