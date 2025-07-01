<?= $this->extend('layout/admin_cek_main') ?>
<?= $this->section('content') ?>
<style>
    .detail-pekerja-card { display: flex; align-items: center; background-color: white; padding: 2rem; border-radius: 15px; }
    .pekerja-avatar { margin-right: 2rem; }
    .pekerja-info { text-align: left; }
    .pekerja-info h5 { font-weight: bold; }
    .pekerja-info table { width: 100%; }
    .pekerja-info table td { padding: 5px 0; }
    .pekerja-info table td:first-child { font-weight: 600; width: 100px; }
</style>
<?php if($status === 'bekerja'): ?>
    <div class="detail-pekerja-card">
        <div class="pekerja-avatar text-center"><img src="<?= base_url('assets/pekerja_sedang_bekerja.png') ?>" alt="Pekerja" style="max-width: 150px;" class="mb-2"><h6>Pekerja Sedang Bekerja</h6><p>Pekerja: 10 Orang</p></div>
        <div class="pekerja-info"><h5>Paket A</h5>
            <table>
                <tr><td>Id Pesanan</td><td>: Pesan1212202401</td></tr>
                <tr><td>Id Pelanggan</td><td>: S12122024001</td></tr>
                <tr><td>Nama</td><td>: Samuel Orief Rosario</td></tr>
                <tr><td>Waktu</td><td>: 7 Hari</td></tr>
                <tr><td>Tanggal</td><td>: 12-12-2024 sampai 19-12-2024</td></tr>
                <tr><td class="align-top">Lokasi</td><td class="align-top">: Jl. Bhakti No.48 3, RT.3/RW.7, Cilandak Tim., Ps. Minggu, Kota Jakarta Selatan</td></tr>
            </table>
            <p class="mt-3 text-danger fw-bold">*Sedang Proses Pengerjaan, Tidak Bisa Dipanggil Untuk Melakukan Pekerjaan lain.</p>
            <div class="mt-3"><button class="btn btn-primary btn-sm">Telpon Pekerja</button><button class="btn btn-success btn-sm mx-1">Tambahkan</button><button class="btn btn-dark btn-sm">Edit</button></div>
        </div>
    </div>
<?php else: ?>
     <div class="detail-pekerja-card justify-content-center">
        <div class="pekerja-avatar text-center"><img src="<?= base_url('assets/pekerja_tidak_bekerja.png') ?>" alt="Pekerja" style="max-width: 150px;" class="mb-2"><h6>Pekerja Tersedia</h6><p>Pekerja: 14 Orang</p></div>
        <div class="pekerja-info ms-4">
            <h3 class="fw-bold">Tersedia <span class="text-success">Jasa Pekerja</span></h3><p>Tidak Sedang Melakukan Pekerjaan</p>
            <div class="mt-3"><button class="btn btn-primary btn-sm">Telpon Pekerja</button><button class="btn btn-success btn-sm mx-1">Tambahkan</button><button class="btn btn-dark btn-sm">Edit</button></div>
        </div>
    </div>
<?php endif; ?>
<?= $this->endSection() ?>