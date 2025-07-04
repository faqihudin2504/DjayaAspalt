<?php
namespace App\Models;
use CodeIgniter\Model;

class DetailPemesananModel extends Model
{
    protected $table = 'detail_pemesanan';
    protected $primaryKey = 'id_detail';
    protected $allowedFields = ['id_pesanan', 'id_material', 'jumlah_material', 'harga_saat_pesan', 'sub_total'];
}