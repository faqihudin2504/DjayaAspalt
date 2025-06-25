<?php

namespace App\Models;

use CodeIgniter\Model;

class PelangganModel extends Model
{
    protected $table            = 'pelanggan';
    protected $primaryKey       = 'id_pelanggan';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'id_pelanggan',
        'id_survey',
        'id_namasewa',
        'nama_lengkap',
        'no_telpon',
        'tanggal_survey',
        'lokasi_survey'
    ];
}
