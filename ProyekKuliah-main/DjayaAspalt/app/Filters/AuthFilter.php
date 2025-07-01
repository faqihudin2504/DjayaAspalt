<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\RedirectResponse;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // 1. Cek apakah user sudah login
        if (!session()->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Anda harus login untuk mengakses halaman ini.');
        }

        // 2. Jika filter memerlukan role tertentu (misal: 'auth:admin')
        if ($arguments && is_array($arguments) && !empty($arguments)) {
            $requiredRoles = $arguments;
            $userRole = session()->get('role');

            // Cek apakah role user ada di dalam daftar role yang diizinkan
            if (!in_array($userRole, $requiredRoles)) {
                // Jika tidak sesuai, lempar ke dashboard utama
                return redirect()->to('/dashboard')->with('error', 'Akses ditolak. Anda tidak memiliki izin.');
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak ada aksi setelah request
    }
}