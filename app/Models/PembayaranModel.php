<?php

namespace App\Models;

use CodeIgniter\Model;

class PengembalianModel extends Model
{
    protected $table            = 'pengembalian';
    protected $primaryKey       = 'id_kembali';
    protected $useAutoIncrement = false; // <-- WAJIB
    protected $returnType       = 'array';
    protected $allowedFields    = [ 'id_kembali', 'id_sewa', 'denda_kembali', 'tanggal_pengembalian' ];

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