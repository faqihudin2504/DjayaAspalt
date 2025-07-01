<?php

namespace App\Models;

use CodeIgniter\Model;

class PekerjaModel extends Model
{
    protected $table            = 'pekerja'; // Sesuaikan jika nama tabel Anda berbeda
    protected $primaryKey       = 'id_pekerja'; // Sesuaikan dengan primary key tabel Anda
    protected $allowedFields    = [
        'nama_pekerja',
        'nama_pekerja',
        'posisi',
        'status_pekerja'
    ]; // Sesuaikan dengan kolom di tabel Anda
}