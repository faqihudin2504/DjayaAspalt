<?= $this->extend('layout/admin_kosong') ?>

<?= $this->section('content') ?>
<style>
    .card-revisi { border-radius: 15px; background-color: #fff; box-shadow: 0 2px 4px rgba(0,0,0,0.1); border: none; }
    .card-revisi .card-header { background-color: #ff9933; color: black; font-weight: bold; border-top-left-radius: 15px; border-top-right-radius: 15px; padding: 1rem 1.5rem; }
    .table thead th { background-color: #343a40; color: white; text-align: center; font-weight: 600; vertical-align: middle; }
    .table tbody td { text-align: center; vertical-align: middle; }
    .action-buttons .btn { margin: 0 2px; }
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold m-0"><?= esc($page_title ?? 'Manajemen Pelanggan') ?></h4>
    <a href="<?= base_url('admin/pelanggan/tambah') ?>" class="btn btn-success">Tambahkan Pelanggan</a>
</div>

<?php if (session()->getFlashdata('success')) : ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if (empty($pelanggan_per_bulan)): ?>
    <div class="card card-revisi">
        <div class="card-body text-center p-5">
            <h5 class="text-danger">Tidak Ada Data Pelanggan</h5>
            <p>Silakan klik tombol "Tambahkan Pelanggan" untuk memulai.</p>
        </div>
    </div>
<?php else: ?>
    <?php foreach ($pelanggan_per_bulan as $bulan => $items): ?>
    <div class="card card-revisi mb-4">
        <div class="card-header">Data Pelanggan bulan <?= $bulan ?></div>
        <div class="card-body table-responsive p-0">
            <table class="table table-bordered table-striped mb-0">
                <thead>
                    <tr>
                        <th>ID Pelanggan</th>
                        <th>Nama Lengkap</th>
                        <th>Tujuan</th>
                        <th>Tanggal Daftar</th>
                        <th style="width: 200px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $item): ?>
                        <tr>
                            <td><?= esc($item['id_pelanggan']) ?></td>
                            <td><?= esc($item['nama_lengkap']) ?></td>
                            <td>
                                <?php if (!empty($item['id_survey'])): ?>
                                    <span class="badge bg-info">Survey</span>
                                <?php elseif (!empty($item['id_namasewa'])): ?>
                                    <span class="badge bg-warning">Sewa</span>
                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </td>
                            <td><?= date('d M Y, H:i', strtotime($item['tanggal_survey'])) ?></td>
                            <td class="action-buttons">
                                <a href="<?= base_url('admin/pelanggan/view/' . $item['id_pelanggan']) ?>" class="btn btn-dark btn-sm" title="Lihat Detail">View</a>
                                <a href="<?= base_url('admin/pelanggan/edit/' . $item['id_pelanggan']) ?>" class="btn btn-warning btn-sm" title="Edit Data">Edit</a>
                                <a href="<?= base_url('admin/pelanggan/hapus/' . $item['id_pelanggan']) ?>" class="btn btn-danger btn-sm" title="Hapus Data" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Delete</a>
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