<?= $this->extend('layout/admin_kosong') ?>

<?= $this->section('content') ?>
<style>
    .card-revisi { border-radius: 15px; background-color: #fff; box-shadow: 0 2px 4px rgba(0,0,0,0.1); border: none; }
    .card-revisi .card-header { background-color: #ff9933; color: black; font-weight: bold; border-top-left-radius: 15px; border-top-right-radius: 15px; padding: 1rem 1.5rem; }
    .table thead th { background-color: #343a40; color: white; text-align: center; font-weight: 600; vertical-align: middle; }
    .table tbody td { text-align: center; vertical-align: middle; }
    .action-buttons .btn { color: white !important; font-weight: bold; padding: 0.25rem 0.5rem; font-size: 0.8rem; border: none; }
    .empty-state { padding: 4rem; text-align: center; } 
    .empty-state img { max-width: 150px; margin-bottom: 1.5rem; }
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold m-0">Data Pemesanan</h4>
    <a href="<?= base_url('admin/pemesanan/tambah') ?>" class="btn btn-success">Tambahkan Pemesanan</a>
</div>

<?php if (session()->getFlashdata('success')) : ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if (empty($pemesanan_per_bulan)): ?>
    <div class="card card-revisi">
        <div class="card-body empty-state">
            <img src="<?= base_url('assets/table_cat_animated.gif') ?>" alt="Tidak Ada Data">
            <h5 class="text-danger">Tidak Ada Data Pemesanan</h5>
            <p>Silakan tambahkan data pemesanan baru.</p>
        </div>
    </div>
<?php else: ?>
    <?php foreach ($pemesanan_per_bulan as $bulan => $items): ?>
    <div class="card card-revisi mb-4">
        <div class="card-header">Data Pemesanan bulan <?= $bulan ?></div>
        <div class="card-body table-responsive p-0">
            <table class="table table-bordered table-striped mb-0">
                <thead>
                    <tr>
                        <th>ID Pesanan</th>
                        <th>ID Pelaksanaan</th>
                        <th>Paket</th>
                        <th>Harga</th>
                        <th>Tanggal Pesan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $item): ?>
                        <tr>
                            <td><?= esc($item['id_pesanan']) ?></td>
                            <td><?= esc($item['id_pelaksanaan']) ?></td>
                            <td><?= esc($item['nama_paketdipesan']) ?></td>
                            <td>Rp. <?= number_format($item['harga_paketdipesan'], 0, ',', '.') ?></td>
                            <td><?= date('d-m-Y', strtotime($item['tanggal_pemesanan'])) ?></td>
                            <td class="action-buttons">
                                <a href="<?= base_url('admin/pemesanan/edit/' . $item['id_pesanan']) ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="<?= base_url('admin/pemesanan/hapus/' . $item['id_pesanan']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Anda yakin ingin menghapus data ini?')">Delete</a>
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