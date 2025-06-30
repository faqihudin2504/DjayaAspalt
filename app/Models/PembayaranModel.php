<?php

namespace App\Models;

use CodeIgniter\Model;

class PembayaranModel extends Model
{
    protected $table            = 'pembayaran';
    protected $primaryKey       = 'id_bayar';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'id_bayar',
        'id_pesanan',
        'id_sewa',
        'tanggal_pembayaran',
        'metode_pembayaran',
        'no_rekening',
        'total_harga',
        'status_pembayaran', 
        'bukti_pembayaran'  
    ];

    /**
     * Fungsi baru untuk mengambil detail pembayaran dengan nama pelanggan.
     * Ini akan menyederhanakan kode di controller.
     * @param string 
     */
    public function getPembayaranDetails($type = 'pemesanan')
    {
        $builder = $this->select('pembayaran.*, pelanggan.nama_lengkap')
            ->join('pemesanan', 'pemesanan.id_pesanan = pembayaran.id_pesanan', 'left')
            ->join('penyewaan', 'penyewaan.id_sewa = pembayaran.id_sewa', 'left')
            ->join('pelanggan', 'pelanggan.id_pelanggan = pemesanan.id_pelanggan OR pelanggan.id_pelanggan = penyewaan.id_namasewa', 'left')
            ->orderBy('pembayaran.tanggal_pembayaran', 'DESC');

        if ($type === 'pemesanan') {
            return $builder->where('pembayaran.id_sewa IS NULL')->findAll();
        } else {
            return $builder->where('pembayaran.id_pesanan IS NULL')->findAll();
        }
    }
}