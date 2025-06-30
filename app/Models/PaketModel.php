<?php
namespace App\Models;
use CodeIgniter\Model;

class PaketModel extends Model
{
    protected $table            = 'paket';
    protected $primaryKey       = 'id_paket';
    protected $allowedFields    = ['nama_paket', 'deskripsi_paket', 'harga_paket'];
}