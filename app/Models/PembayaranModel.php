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
        $this->select('pembayaran.*, COALESCE(pelanggan_pesan.nama_lengkap, pelanggan_sewa.nama_lengkap) as nama_pelanggan')
             ->join('pemesanan', 'pemesanan.id_pesanan = pembayaran.id_pesanan', 'left')
             ->join('pelaksanaan', 'pelaksanaan.id_pelaksanaan = pemesanan.id_pelaksanaan', 'left')
             ->join('pelanggan AS pelanggan_pesan', 'pelanggan_pesan.id_pelanggan = pelaksanaan.id_pelanggan', 'left')
             ->join('penyewaan', 'penyewaan.id_sewa = pembayaran.id_sewa', 'left')
             ->join('pelanggan AS pelanggan_sewa', 'pelanggan_sewa.id_pelanggan = penyewaan.id_namasewa', 'left')
             ->orderBy('pembayaran.tanggal_pembayaran', 'DESC');

        if ($type === 'pemesanan') {
            return $this->where('pembayaran.id_sewa IS NULL')->findAll();
        } else {
            return $this->where('pembayaran.id_pesanan IS NULL')->findAll();
        }
    }
}