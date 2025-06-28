<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true; // <-- Boleh ada atau dihapus (karena ini default)
    protected $returnType       = 'array';
    protected $allowedFields    = [ 'nama_lengkap', 'username', 'email', 'password', 'role', 'foto_profil', 'no_telpon', 'alamat_rumah' ];
    protected $useTimestamps = false;
}