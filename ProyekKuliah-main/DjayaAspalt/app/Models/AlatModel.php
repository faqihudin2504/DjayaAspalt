<?php

namespace App\Models;

use CodeIgniter\Model;

class AlatModel extends Model
{
    protected $table            = 'alat';
    protected $primaryKey       = 'id_alat';
    protected $useAutoIncrement = false; // <-- WAJIB
    protected $returnType       = 'array';
    protected $allowedFields = [ 'id_alat', 'cek_alat', 'nama_alat', 'kategori', 'stok_alat', 'informasi_alat', 'harga_sewa', 'gambar_alat' ];
}