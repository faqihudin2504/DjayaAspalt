<?= $this->extend('layout/admin_main') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold m-0"><?= esc($page_title ?? 'Data Pengembalian') ?></h4>
    <a href="<?= base_url('admin/pengembalian/tambah') ?>" class="btn btn-success">Tambahkan Pengembalian</a>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="card shadow-sm">
    <div class="card-header fw-bold">Daftar Semua Pengembalian</div>
    <div class="card-body table-responsive p-0">
        <table class="table table-bordered table-striped table-hover mb-0">
            <thead class="table-dark">
                <tr>
                    <th>ID Kembali</th>
                    <th>ID Sewa</th>
                    <th>Nama Penyewa</th>
                    <th>Alat yang Disewa</th>
                    <th>Denda</th>
                    <th>Tanggal Kembali</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($pengembalian_list)): ?>
                    <tr>
                        <td colspan="7" class="text-center p-5">
                            <img src="<?= base_url('assets/table_cat_animated.gif') ?>" width="100" class="mb-3">
                            <p class="text-danger">Belum ada data pengembalian.</p>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($pengembalian_list as $item): ?>
                        <tr>
                            <td><?= esc($item['id_kembali']) ?></td>
                            <td><?= esc($item['id_sewa']) ?></td>
                            <td><?= esc($item['nama_penyewa']) ?></td>
                            <td><?= esc($item['nama_alat']) ?></td>
                            <td>Rp. <?= number_format($item['denda_kembali'] ?? 0, 0, ',', '.') ?></td>
                            <td><?= esc(date('d M Y', strtotime($item['tanggal_pengembalian']))) ?></td>
                            <td>
                                <a href="<?= base_url('admin/pengembalian/hapus/' . $item['id_kembali']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Anda yakin ingin menghapus data ini?')">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>