<?= $this->extend('layout/admin_kosong') ?>

<?= $this->section('content') ?>
<style>
    /* Style ini disalin dari halaman lain agar seragam */
    .card-revisi { border-radius: 15px; background-color: #fff; box-shadow: 0 2px 4px rgba(0,0,0,0.1); border: none; }
    .card-revisi .card-header { background-color: #ff9933; color: black; font-weight: bold; border-top-left-radius: 15px; border-top-right-radius: 15px; padding: 1rem 1.5rem; }
    .table thead.table-dark th { background-color: #343a40; color: white; } /* Memastikan header tabel gelap */
    .table tbody td { vertical-align: middle; }
    .empty-state { padding: 4rem; text-align: center; } 
    .empty-state img { max-width: 150px; margin-bottom: 1.5rem; }
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold m-0">Manajemen Survey</h4>
    <a href="<?= base_url('admin/survey/tambah') ?>" class="btn btn-success">Tambahkan Survey Baru</a>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if (empty($survey_per_bulan)): ?>
    <div class="card card-revisi">
        <div class="card-body empty-state">
            <img src="<?= base_url('assets/table_cat_animated.gif') ?>" alt="Tidak Ada Data">
            <h5 class="text-danger">Tidak Ada Data Survey</h5>
            <p>Silakan klik tombol "Tambahkan Survey Baru" untuk memulai.</p>
        </div>
    </div>
<?php else: ?>
    <?php foreach ($survey_per_bulan as $bulan => $items): ?>
    <div class="card card-revisi mb-4">
        <div class="card-header">
            Data Survey bulan <?= $bulan ?>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-bordered table-striped table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>Pelanggan</th>
                        <th>No. Telepon</th>
                        <th>Alamat Survey</th>
                        <th>Jadwal</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $item): ?>
                        <tr>
                            <td><?= esc($item['nama_lengkap']) ?></td>
                            <td><?= esc($item['no_telpon']) ?></td>
                            <td class="text-start"><?= esc($item['alamat_survey']) ?></td>
                            <td><?= date('d M Y, H:i', strtotime($item['tanggal_survey'])) ?></td>
                            <td><span class="badge bg-info"><?= esc($item['status']) ?></span></td>
                            <td>
                                <a href="<?= base_url('admin/survey/edit/' . $item['id_survey']) ?>" class="btn btn-warning btn-sm">Ubah</a>
                                <a href="<?= base_url('admin/survey/hapus/' . $item['id_survey']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus jadwal survey ini?')">Hapus</a>
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