<?php

namespace App\Models;

use CodeIgniter\Model;

class PemesananJasaModel extends Model
{
    protected $table = 'pemesanan_jasa';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nama_lengkap', 'no_telepon', 'tanggal_waktu', 'alamat'];
    protected $useTimestamps = true;
}