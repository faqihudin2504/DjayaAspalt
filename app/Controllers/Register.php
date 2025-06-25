<?php

namespace App\Controllers;

use App\Models\UserModel;

class Register extends BaseController
{
    public function index()
    {
        return view('register');
    }

    public function save()
    {
        $userModel = new UserModel();

        // Validasi input
        $rules = [
            'username' => 'required|min_length[3]|max_length[20]|is_unique[users.username]',
            'email'    => 'required|min_length[6]|max_length[50]|valid_email|is_unique[users.email]',
            'no_telpon' => 'required|min_length[10]|max_length[15]', // Validasi untuk no telpon
            'password' => 'required|min_length[8]|max_length[255]',
            'password_confirm' => 'matches[password]'
        ];

        if (!$this->validate($rules)) {
            session()->setFlashdata('error', $this->validator->listErrors());
            return redirect()->back()->withInput();
        }

        // Simpan data ke database
        $userModel->save([
            'username' => $this->request->getVar('username'),
            'email'    => $this->request->getVar('email'),
            'no_telpon' => $this->request->getVar('no_telpon'), // Simpan no telpon
            'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
            'role' => 'customer' // Otomatis set role sebagai customer
        ]);

        return redirect()->to('/login')->with('success', 'Registrasi berhasil! Silakan login.');
    }
}