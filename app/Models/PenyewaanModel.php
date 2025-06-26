<?php

namespace App\Models;

use CodeIgniter\Model;

class PenyewaanModel extends Model
{
    protected $table            = 'penyewaan';
    protected $primaryKey       = 'id_sewa';
    protected $useAutoIncrement = false; // Karena kita buat ID manual
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    // Sesuaikan dengan semua kolom di tabel penyewaan
    protected $allowedFields    = [
        'id_sewa',
        'id_alat',
        'id_namasewa',
        'nama_penyewa',
        'harga_alatdisewa',
        'tanggal_penyewaan',
        'alamat_penyewa',
        'status'
    ];

    // Dates
    protected $useTimestamps = false;
}