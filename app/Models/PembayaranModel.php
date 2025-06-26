<?php

namespace App\Models;

use CodeIgniter\Model;

class PembayaranModel extends Model
{
    protected $table            = 'pembayaran';
    protected $primaryKey       = 'id_bayar';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';

    /**
     * Disesuaikan 100% dengan screenshot struktur tabel database Anda.
     */
    protected $allowedFields    = [
        'id_bayar',
        'id_pesanan',
        'id_sewa',
        'tanggal_pembayaran',
        'metode_pembayaran',
        'no_rekening',
        'total_harga'
    ];

    /**
     * Mengambil data pembayaran dengan detail nama pelanggan yang benar.
     */
    public function getPembayaranWithDetails()
    {
        return $this->select('pembayaran.*, users.nama_lengkap, penyewaan.nama_penyewa, pemesanan.nama_paketdipesan')
                    ->join('pemesanan', 'pemesanan.id_pesanan = pembayaran.id_pesanan', 'left')
                    ->join('pelaksanaan', 'pelaksanaan.id_pelaksanaan = pemesanan.id_pelaksanaan', 'left')
                    ->join('users', 'users.id = pelaksanaan.id_pelanggan', 'left')
                    ->join('penyewaan', 'penyewaan.id_sewa = pembayaran.id_sewa', 'left')
                    ->orderBy('pembayaran.tanggal_pembayaran', 'DESC')
                    ->findAll();
    }
}