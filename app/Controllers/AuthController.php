public function login()
{
    $username = $this->request->getPost('username');
    $password = $this->request->getPost('password');

    // Contoh login manual (ubah sesuai sistemmu)
    if ($username == 'admin' && $password == 'admin123') {
        session()->set('isLoggedIn', true);
        return redirect()->to('/dashboard');
    }

    return redirect()->back()->with('error', 'Login gagal');
}
