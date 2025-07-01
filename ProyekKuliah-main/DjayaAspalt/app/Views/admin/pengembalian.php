<?= $this->extend('layout/admin_kosong') ?>
<?= $this->section('content') ?>

<style>
    /* Menyeragamkan style dengan halaman lain */
    .card-revisi { border-radius: 15px; background-color: #fff; box-shadow: 0 2px 4px rgba(0,0,0,0.1); border: none; }
    .card-revisi .card-header { background-color: #ff9933; color: black; font-weight: bold; border-top-left-radius: 15px; border-top-right-radius: 15px; padding: 1rem 1.5rem; }
    .table thead th { background-color: #343a40; color: white; text-align: center; font-weight: 600; vertical-align: middle; }
    .table tbody td { text-align: center; vertical-align: middle; }
    .action-buttons .btn { margin: 0 2px; }
    .empty-state { padding: 4rem; text-align: center; } 
    .empty-state img { max-width: 150px; margin-bottom: 1.5rem; }
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold m-0">Daftar Semua Pengembalian</h4>
    <a href="<?= base_url('admin/pengembalian/tambah') ?>" class="btn btn-success">Tambah Pengembalian</a>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="card card-revisi">
    <div class="card-body table-responsive p-0">
        <table class="table table-bordered table-striped table-hover mb-0">
            <thead class="table-dark">
                <tr>
                    <th>ID Kembali</th>
                    <th>ID Sewa</th>
                    <th>Nama Alat Disewa</th>
                    <th>Denda Kembali</th>
                    <th>Tanggal Kembali</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($pengembalian_list)): ?>
                    <tr>
                        <td colspan="6" class="p-5 text-center">
                            <img src="<?= base_url('assets/table_cat_animated.gif') ?>" width="100" class="mb-3">
                            <p class="text-danger">Belum ada data pengembalian.</p>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($pengembalian_list as $item): ?>
                        <tr>
                            <td><?= esc($item['id_kembali']) ?></td>
                            <td><?= esc($item['id_sewa']) ?></td>
                            <td class="text-start"><?= esc($item['nama_alat']) ?></td>
                            <td>Rp. <?= number_format($item['denda_kembali'] ?? 0, 0, ',', '.') ?></td>
                            <td><?= esc(date('d-m-Y', strtotime($item['tanggal_pengembalian']))) ?></td>
                            <td class="action-buttons">
                                <a href="#" class="btn btn-warning btn-sm">Ubah</a>
                                <a href="#" class="btn btn-danger btn-sm" onclick="return confirm('Anda yakin ingin menghapus data ini?')">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>