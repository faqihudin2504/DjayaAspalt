<?php

namespace App\Models;

use CodeIgniter\Model;

class PekerjaModel extends Model
{
    protected $table            = 'pekerja';
    protected $primaryKey       = 'id_pekerja';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['nama_pekerja', 'posisi', 'status_pekerja'];
}