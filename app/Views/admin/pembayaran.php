<?= $this->extend('layout/admin_kosong') ?>

<?= $this->section('content') ?>
<style>
    .card-revisi { border-radius: 15px; background-color: #fff; box-shadow: 0 2px 4px rgba(0,0,0,0.1); border: none; }
    .card-revisi .card-header { background-color: #ff9933; color: black; font-weight: bold; border-top-left-radius: 15px; border-top-right-radius: 15px; padding: 1rem 1.5rem; }
    .table thead th { background-color: #343a40; color: white; text-align: center; font-weight: 600; vertical-align: middle; }
    .table tbody td { text-align: center; vertical-align: middle; }
    .action-buttons .btn { color: white !important; font-weight: bold; padding: 0.25rem 0.5rem; font-size: 0.8rem; border: none; }
    .empty-state { padding: 4rem; text-align: center; } .empty-state img { max-width: 150px; margin-bottom: 1.5rem; }
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold m-0"><?= esc($page_title) ?></h4>
    <div>
        <a href="#" class="btn btn-info">Lihat Bukti Pembayaran</a>
        <a href="#" class="btn btn-success ms-2">Tambahkan Pembayaran</a>
    </div>
</div>

<?php if (empty($pembayaran_per_bulan)): ?>
    <div class="card card-revisi">
        <div class="card-body empty-state">
            <img src="<?= base_url('assets/table_cat_animated.gif') ?>" alt="Tidak Ada Data">
            <h5 class="text-danger">Tidak Ada Data Pembayaran</h5>
            <p>Silakan tambahkan data pembayaran baru.</p>
        </div>
    </div>
<?php else: ?>
    <?php foreach ($pembayaran_per_bulan as $bulan => $items): ?>
    <div class="card card-revisi mb-4">
        <div class="card-header">
            Data Pembayaran bulan <?= $bulan ?>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-bordered table-striped mb-0">
                <thead>
                    <tr>
                        <th>ID Bayar</th>
                        <th>ID Pesanan</th>
                        <th>ID Sewa</th>
                        <th>Tanggal</th>
                        <th>Metode</th>
                        <th>No. Rekening</th>
                        <th>Total Harga</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($items)): ?>
                        <tr><td colspan="8" class="p-5">Tidak ada data untuk bulan ini.</td></tr>
                    <?php else: ?>
                        <?php foreach ($items as $item): ?>
                            <tr>
                                <td><?= esc($item['id_bayar']) ?></td>
                                <td><?= esc($item['id_pesanan']) ?: '-' ?></td>
                                <td><?= esc($item['id_sewa']) ?: '-' ?></td>
                                <td><?= date('d-m-Y', strtotime($item['tanggal_pembayaran'])) ?></td>
                                <td><?= esc($item['metode_pembayaran']) ?></td>
                                <td><?= esc($item['no_rekening']) ?></td>
                                <td>Rp. <?= number_format($item['total_harga'], 0, ',', '.') ?></td>
                                <td class="action-buttons">
                                    <a href="#" class="btn btn-dark btn-sm">View</a>
                                    <a href="#" class="btn btn-warning btn-sm">Edit</a>
                                    <a href="#" class="btn btn-danger btn-sm">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php endforeach; ?>
<?php endif; ?>

<?= $this->endSection() ?>