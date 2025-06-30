<?php

namespace App\Models;

use CodeIgniter\Model;

class PelangganModel extends Model
{
    protected $table            = 'pelanggan';
    protected $primaryKey       = 'id_pelanggan';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $allowedFields    = ['id_pelanggan', 'nama_lengkap', 'alamat', 'no_telpon', 'email', 'id_user'];
    protected $useTimestamps = true;

    /**
     * Fungsi untuk membuat ID transaksional (Survey/Sewa) secara otomatis
     * dengan format: [TIPE][ddmmyy][nomor urut 3 digit]
     * Contoh: SEWA290625001
     */
    public function generateTransactionalId($type = 'SURVEY')
    {
        // 1. Tentukan awalan (prefix) dan kolom target di database
        $prefix = ($type === 'SEWA') ? 'Sewa' : 'SURVEY';
        $column = ($type === 'SEWA') ? 'id_namasewa' : 'id_survey';

        // 2. Buat format tanggal hari ini (ddmmyy)
        $datePart = date('dmy');
        $idPattern = $prefix . $datePart; // Contoh: SEWA290625

        // 3. Cari ID terakhir di database yang cocok dengan pola hari ini
        $lastId = $this->selectMax($column)
                       ->like($column, $idPattern, 'after')
                       ->first();
        
        $newSequence = 1;
        if ($lastId && !empty($lastId[$column])) {
            // 4. Jika ada ID hari ini, ambil nomor urutnya dan tambahkan 1
            $lastSequence = (int) substr($lastId[$column], -3);
            $newSequence = $lastSequence + 1;
        }

        // 5. Format nomor urut baru menjadi 3 digit (e.g., 1 -> 001, 12 -> 012)
        $sequencePart = str_pad($newSequence, 3, '0', STR_PAD_LEFT);

        // 6. Gabungkan semua bagian menjadi ID final
        return $idPattern . $sequencePart;
    }
}