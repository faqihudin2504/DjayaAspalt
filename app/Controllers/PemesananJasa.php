<?php
namespace App\Controllers;

class PemesananJasa extends BaseController
{
    public function index()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/');
        }
        return view('pages/pemesanan_gabung');
    }

    public function simpan()
    {
        $data = [
            'nama' => $this->request->getPost('nama'),
            'telepon' => $this->request->getPost('telepon'),
            'tanggal_survey' => $this->request->getPost('tanggal_survey'),
            'jam_survey' => $this->request->getPost('jam_survey'),
            'alamat_survey' => $this->request->getPost('alamat_survey'),
            'tanggal_pelaksanaan' => $this->request->getPost('tanggal_pelaksanaan'),
            'jam_pelaksanaan' => $this->request->getPost('jam_pelaksanaan'),
            'alamat_pelaksanaan' => $this->request->getPost('alamat_pelaksanaan'),
            'durasi' => $this->request->getPost('durasi'),
        ];

        // Simpan ke database kalau perlu

        return redirect()->to('/dashboard')->with('success', 'Pemesanan berhasil dikirim!');
    }
}
