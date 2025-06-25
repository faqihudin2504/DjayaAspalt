<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\RedirectResponse; // Pastikan ini di-include

class AuthFilter implements FilterInterface
{
    /**
     * Do whatever processing this filter needs to do.
     * By default it should not return anything during
     * normal execution. However, when an abnormal state
     * is found, it should return an instance of
     * CodeIgniter\HTTP\RedirectResponse.
     *
     * @param RequestInterface $request
     * @param array|null       $arguments
     *
     * @return RedirectResponse|void
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        // Jika user belum login, arahkan ke halaman login
        if (!session()->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Anda harus login untuk mengakses halaman ini.');
        }

        // Jika ada argumen role yang diberikan (misal 'admin', 'customer', 'cs')
        if ($arguments && is_array($arguments) && !empty($arguments)) {
            $requiredRoles = $arguments;
            $userRole = session()->get('role');

            // Cek apakah role user ada di dalam requiredRoles
            if (!in_array($userRole, $requiredRoles)) {
                // Arahkan ke dashboard atau halaman lain yang diizinkan
                return redirect()->to('/dashboard')->with('error', 'Akses ditolak. Anda tidak memiliki izin untuk halaman ini.');
            }
        }
    }

    /**
     * Allows After filters to inspect and modify the response
     * object as needed. This method does not allow you to override
     * any existing properties but works fine for logging or
     * profiling.
     *
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param array|null        $arguments
     *
     * @return void
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do nothing
    }
}