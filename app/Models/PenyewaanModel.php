<?php

namespace App\Models;

use CodeIgniter\Model;

class PenyewaanModel extends Model
{
    protected $table            = 'penyewaan';
    protected $primaryKey       = 'id_sewa';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $allowedFields = [
        'id_sewa',
        'id_alat', // <--- Nama ini sudah benar dan cocok dengan database
        'id_namasewa', 
        'nama_penyewa',
        'harga_alatdisewa',
        'tanggal_penyewaan',
        'alamat_penyewa',
        'status',
        'nama_alat', 
        'id_pelanggan' 
    ];

    public function getPenyewaanWithDetails()
    {
        // Query ini tidak lagi memerlukan join karena nama penyewa sudah ada
        return $this->orderBy('tanggal_penyewaan', 'DESC')->findAll();
    }
}