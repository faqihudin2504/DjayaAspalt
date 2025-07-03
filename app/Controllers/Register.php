<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\PelangganModel;

class Register extends BaseController
{
    /**
     * Menampilkan halaman pilihan role.
     */
    public function index()
    {
        return view('register_choice');
    }

    /**
     * Menampilkan form registrasi untuk admin.
     */
    public function admin()
    {
        return view('register_admin');
    }

    /**
     * Menampilkan form registrasi untuk customer.
     */
    public function customer()
    {
        return view('register_customer');
    }

    /**
     * Menyimpan data admin baru.
     */
    public function saveAdmin()
    {
        $rules = [
            'username' => 'required|min_length[3]|max_length[20]|is_unique[users.username]',
            'email'    => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[8]',
            'password_confirm' => 'matches[password]',
            'foto_profil' => 'uploaded[foto_profil]|max_size[foto_profil,1024]|is_image[foto_profil]|mime_in[foto_profil,image/jpg,image/jpeg,image/png]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->listErrors());
        }

        $userModel = new UserModel();
        $foto = $this->request->getFile('foto_profil');
        $namaFoto = $foto->getRandomName();
        $foto->move('uploads/avatars', $namaFoto);

        $userModel->save([
            'username'   => $this->request->getVar('username'),
            'email'      => $this->request->getVar('email'),
            'password'   => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
            'role'       => 'admin',
            'foto_profil'=> $namaFoto
        ]);

        return redirect()->to('/login')->with('success', 'Akun admin berhasil dibuat! Silakan login.');
    }

    /**
     * Menyimpan data customer baru.
     */
    public function saveCustomer()
    {
        $rules = [
            'nama_lengkap' => 'required|min_length[3]',
            'username'     => 'required|min_length[3]|max_length[20]|is_unique[users.username]',
            'email'        => 'required|valid_email|is_unique[users.email]',
            'no_telpon'    => 'required|min_length[10]',
            'password'     => 'required|min_length[8]',
            'password_confirm' => 'matches[password]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->listErrors());
        }

        $userModel = new UserModel();
        $pelangganModel = new PelangganModel();

        // 1. Simpan data ke tabel users untuk login
        $idUser = $userModel->insert([
            'username'     => $this->request->getVar('username'),
            'email'        => $this->request->getVar('email'),
            'password'     => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
            'role'         => 'customer',
            'nama_lengkap' => $this->request->getVar('nama_lengkap'),
            'no_telpon'    => $this->request->getVar('no_telpon'),
            'alamat_rumah' => $this->request->getVar('alamat_rumah'),
        ], true); // true untuk mendapatkan ID yang baru saja dibuat

        // 2. Simpan data ke tabel pelanggan, hubungkan dengan user ID
        $pelangganModel->save([
            'id_pelanggan' => 'CUST' . date('ymdHis'),
            'nama_lengkap' => $this->request->getVar('nama_lengkap'),
            'email'        => $this->request->getVar('email'),
            'no_telpon'    => $this->request->getVar('no_telpon'),
            'alamat'       => $this->request->getVar('alamat_rumah'),
            'id_user'      => $idUser // Foreign key ke tabel users
        ]);

        return redirect()->to('/login')->with('success', 'Akun pelanggan berhasil dibuat! Silakan login.');
    }
}