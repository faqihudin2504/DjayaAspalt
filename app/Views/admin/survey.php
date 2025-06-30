<?= $this->extend('layout/admin_kosong') ?>

<?= $this->section('content') ?>
<style>
    /* Menggunakan style yang sama dengan halaman lain agar konsisten */
    .card-revisi { border-radius: 15px; background-color: #fff; box-shadow: 0 2px 4px rgba(0,0,0,0.1); border: none; }
    .card-revisi .card-header { background-color: #ff9933; color: black; font-weight: bold; border-top-left-radius: 15px; border-top-right-radius: 15px; padding: 1rem 1.5rem; }
    .table thead th { background-color: #343a40; color: white; text-align: center; font-weight: 600; vertical-align: middle; }
    .table tbody td { text-align: center; vertical-align: middle; }
    .action-buttons .btn { margin: 0 2px; }
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold m-0"><?= esc($page_title ?? 'Manajemen Survey') ?></h4>
    <a href="<?= base_url('admin/pelanggan/tambah') ?>" class="btn btn-success">Tambahkan Survey Baru</a>
</div>

<?php if (session()->getFlashdata('success')) : ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if (empty($survey_per_bulan)): ?>
    <div class="card card-revisi">
        <div class="card-body text-center p-5">
            <h5 class="text-danger">Tidak Ada Data Survey</h5>
            <p>Silakan klik tombol "Tambahkan Survey Baru" untuk memulai.</p>
        </div>
    </div>
<?php else: ?>
    <?php foreach ($survey_per_bulan as $bulan => $items): ?>
    <div class="card card-revisi mb-4">
        <div class="card-header">Data Survey bulan <?= $bulan ?></div>
        <div class="card-body table-responsive p-0">
            <table class="table table-bordered table-striped mb-0">
                <thead>
                    <tr>
                        <th>ID Survey</th>
                        <th>Nama Pelanggan</th>
                        <th>No. Telepon</th>
                        <th>Jadwal Survey</th>
                        <th style="width: 30%;">Alamat Survey</th>
                        <th style="width: 15%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $item): ?>
                        <tr>
                            <td><?= esc($item['id_survey']) ?></td>
                            <td class="text-start"><?= esc($item['nama_lengkap']) ?></td>
                            <td><?= esc($item['no_telpon']) ?></td>
                            <td><?= date('d M Y, H:i', strtotime($item['tanggal_survey'])) ?> WIB</td>
                            <td class="text-start"><?= esc($item['lokasi_survey']) ?></td>
                            <td class="action-buttons">
                                <a href="<?= base_url('admin/pelanggan/view/' . $item['id_pelanggan']) ?>" class="btn btn-dark btn-sm" title="Lihat Detail">View</a>
                                <a href="<?= base_url('admin/pelanggan/edit/' . $item['id_pelanggan']) ?>" class="btn btn-warning btn-sm" title="Edit Data">Edit</a>
                                <a href="<?= base_url('admin/pelanggan/hapus/' . $item['id_pelanggan']) ?>" class="btn btn-danger btn-sm" title="Hapus Data" onclick="return confirm('Menghapus data ini akan menghapus data pelanggan terkait. Yakin?')">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php endforeach; ?>
<?php endif; ?>

<?= $this->endSection() ?>