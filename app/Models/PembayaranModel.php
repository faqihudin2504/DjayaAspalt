<?php

namespace App\Models;

use CodeIgniter\Model;

class PembayaranModel extends Model
{
    protected $table            = 'pembayaran';
    protected $primaryKey       = 'id_bayar';
    protected $allowedFields    = [
        'id_bayar', 'id_pesanan', 'id_sewa', 'tanggal_pembayaran',
        'metode_pembayaran', 'no_rekening', 'total_harga'
    ];
}