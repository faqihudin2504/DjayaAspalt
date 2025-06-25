<?php

namespace App\Models;

use CodeIgniter\Model;

class AlatModel extends Model
{
    protected $table            = 'alat';
    protected $primaryKey       = 'id_alat';
    protected $allowedFields    = [
        'id_alat', 'cek_alat', 'nama_alat', 'stok_alat', 'informasi_alat'
    ];
}