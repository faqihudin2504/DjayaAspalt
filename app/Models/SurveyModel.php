<?php

namespace App\Models;

use CodeIgniter\Model;

class SurveyModel extends Model
{
    protected $table            = 'surveys';
    protected $primaryKey       = 'id_survey';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_pelanggan',
        'alamat_survey',
        'tanggal_survey',
        'status',
        'catatan_admin'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Mengambil data survey dengan detail pelanggan
     */
    public function getSurveysWithDetails()
    {
        return $this->select('surveys.*, pelanggan.nama_lengkap, pelanggan.no_telpon')
                    ->join('pelanggan', 'pelanggan.id_pelanggan = surveys.id_pelanggan', 'left')
                    ->orderBy('surveys.tanggal_survey', 'DESC')
                    ->findAll();
    }
}