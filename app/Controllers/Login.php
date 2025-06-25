<?php

namespace App\Controllers;

use App\Models\UserModel;

class Login extends BaseController
{
    public function index()
    {
        // Jika sudah login, jangan tampilkan halaman login lagi
        if (session()->get('logged_in')) {
            return redirect()->to('/dashboard');
        }
        return view('login');
    }

    public function login()
    {
        $session = session();
        $model = new UserModel();
        
        // Menggunakan getPost untuk keamanan
        $emailOrUsername = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        // Cari user berdasarkan email atau username
        $user = $model->where('email', $emailOrUsername)
                      ->orWhere('username', $emailOrUsername)
                      ->first();

        // Verifikasi password
        if ($user && password_verify($password, $user['password'])) {
            // Set data session
            $ses_data = [
                'user_id'       => $user['id'],
                'username'      => $user['username'],
                'nama_lengkap'  => $user['nama_lengkap'],
                'email'         => $user['email'],
                'foto_profil'   => $user['foto_profil'],
                'role'          => $user['role'],
                'logged_in'     => TRUE
            ];
            $session->set($ses_data);

            // Arahkan berdasarkan role
            if ($user['role'] == 'admin') {
                return redirect()->to('/admin');
            } else {
                return redirect()->to('/dashboard');
            }
        } else {
            // Jika login gagal
            $session->setFlashdata('error', 'Username atau Password salah.');
            return redirect()->to('/login');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}