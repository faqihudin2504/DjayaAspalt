<?php

namespace App\Controllers;
use App\Models\UserModel;

class Auth extends BaseController
{
    public function login()
    {
        return view('login');
    }

    public function doLogin()
    {
        $session = session();
        $model = new UserModel();

        $user = $model->where('username', $this->request->getPost('username'))
                      ->where('password', md5($this->request->getPost('password')))
                      ->first();

        if ($user) {
            $session->set(['username' => $user['username'], 'role' => $user['role'], 'isLoggedIn' => true]);
            return redirect()->to('/dashboard');
        } else {
            return redirect()->back()->with('error', 'Login gagal!');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }
}
