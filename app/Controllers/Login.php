<?php

namespace App\Controllers;

use App\Models\UserModel;

class Login extends BaseController
{
    public function index()
    {
        return view('auth/login');
    }

    public function login()
    {
        $session = session();
        $model = new UserModel();
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');

        $user = $model->where('username', $username)->first();

        // **PERBAIKAN KEAMANAN DI SINI**
        // Gunakan password_verify() untuk membandingkan hash password
        if ($user && password_verify($password, $user['password'])) {
            // Cek jika password di DB adalah plain text 'admin123' (untuk transisi)
            if ($user['password'] === 'admin123') {
                // Segera hash dan update password admin
                $newHash = password_hash('admin123', PASSWORD_DEFAULT);
                $model->update($user['id'], ['password' => $newHash]);
            }
            
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

            if ($user['role'] == 'admin') {
                return redirect()->to('/admin');
            } else {
                return redirect()->to('/dashboard');
            }
        } else {
            // Jika password salah atau user tidak ditemukan
            $session->setFlashdata('msg', 'Username atau Password salah.');
            return redirect()->to('/login');
        }
    }

    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/login');
    }
}