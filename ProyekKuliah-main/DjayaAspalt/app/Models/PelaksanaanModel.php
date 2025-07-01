<?php

namespace App\Models;

use CodeIgniter\Model;

class PelaksanaanModel extends Model
{
    protected $table            = 'pelaksanaan';
    protected $primaryKey       = 'id_pelaksanaan';
    protected $useAutoIncrement = false; // <-- WAJIB
    protected $returnType       = 'array';
    protected $allowedFields    = [ 'id_pelaksanaan', 'id_pelanggan', 'tanggal_pelaksanaan', 'alamat_pelaksanaan', 'waktu_pengerjaan' ];

    protected $useTimestamps = false;

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    
    public function getPelaksanaanWithPelanggan()
    {
        return $this->select('
                        pelaksanaan.id_pelaksanaan,
                        pelaksanaan.id_pelanggan, 
                        pelaksanaan.tanggal_pelaksanaan,
                        pelaksanaan.alamat_pelaksanaan,
                        pelaksanaan.waktu_pengerjaan,
                        users.nama_lengkap
                    ')
                    ->join('users', 'users.id = pelaksanaan.id_pelanggan', 'left')
                    ->findAll();
    }
}