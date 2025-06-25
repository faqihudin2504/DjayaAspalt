<?php

namespace App\Models;

use CodeIgniter\Model;

class PelaksanaanModel extends Model
{
    protected $table            = 'pelaksanaan';
    protected $primaryKey       = 'id_pelaksanaan';
    protected $allowedFields    = [
        'id_pelanggan', 'tanggal_pelaksanaan',
        'alamat_pelaksanaan', 'waktu_pengerjaan'
    ];

    /**
     * Mengambil semua data pelaksanaan dengan menggabungkan data pengguna (users).
     * PERBAIKAN: Menambahkan 'pelaksanaan.id_pelanggan' ke dalam SELECT
     */
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