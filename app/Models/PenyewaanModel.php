<?php

namespace App\Models;

use CodeIgniter\Model;

class PenyewaanModel extends Model
{
    // 1. Konfigurasi dasar tabel
    protected $table            = 'penyewaan';
    protected $primaryKey       = 'id_sewa';

    // 2. Kunci penting #1: Memberitahu CodeIgniter
    //    ID-nya kita buat manual (SEWA...), bukan dari database.
    protected $useAutoIncrement = false; 
    
    protected $returnType       = 'array';

    // 3. Kunci penting #2: Ini adalah "daftar izin".
    //    HANYA kolom yang ada di sini yang boleh disimpan ke database.
    //    Ini yang memperbaiki masalah data "ghoib".
    protected $allowedFields    = [
        'id_sewa',
        'id_pelanggan',
        'nama_penyewa',
        'tanggal_penyewaan',
        'total_harga',
        'status'
    ];
}