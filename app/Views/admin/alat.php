<?= $this->extend('layout/admin_kosong') ?>
<?= $this->section('content') ?>
<style>
    .card-revisi { border-radius: 15px; background-color: #fff; box-shadow: 0 2px 4px rgba(0,0,0,0.1); border: none; }
    .card-revisi .card-header { background-color: #ff9933; color: black; font-weight: bold; border-top-left-radius: 15px; border-top-right-radius: 15px; padding: 1rem 1.5rem; }
    .table thead th { background-color: #343a40; color: white; text-align: center; font-weight: 600; vertical-align: middle; }
    .table tbody td { text-align: center; vertical-align: middle; }
    .action-buttons .btn { color: white !important; font-weight: bold; padding: 0.25rem 0.5rem; font-size: 0.8rem; border: none; margin: 0 2px; }
    .empty-state { padding: 4rem; text-align: center; } .empty-state img { max-width: 150px; margin-bottom: 1.5rem; }
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold m-0"><?= esc($page_title ?? 'Data Alat') ?></h4>
    <a href="<?= base_url('admin/alat/tambah') ?>" class="btn btn-success">Tambahkan Alat</a>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="card card-revisi">
    <div class="card-header">
        <span>Daftar Semua Alat</span>
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-bordered table-striped table-hover mb-0">
            <thead>
                <tr>
                    <th>ID Alat</th>
                    <th>Status</th>
                    <th>Nama Alat</th>
                    <th>Stok</th>
                    <th>Informasi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($alat_list)): ?>
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                <img src="<?= base_url('assets/table_cat_animated.gif') ?>">
                                <h5 class="text-danger">Tidak Ada Data Alat</h5>
                                <p>Silakan tambahkan data alat baru.</p>
                            </div>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($alat_list as $alat): ?>
                        <tr>
                            <td><?= esc($alat['id_alat']) ?></td>
                            <td><span class="badge bg-primary"><?= esc($alat['cek_alat']) ?></span></td>
                            <td><?= esc($alat['nama_alat']) ?></td>
                            <td><?= esc($alat['stok_alat']) ?></td>
                            <td><?= esc($alat['informasi_alat']) ?></td>
                            <td class="action-buttons">
                                <a href="<?= base_url('admin/alat/edit/' . $alat['id_alat']) ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="<?= base_url('admin/alat/hapus/' . $alat['id_alat']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Anda yakin ingin menghapus alat ini?')">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>