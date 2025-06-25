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
    <h4 class="fw-bold m-0"><?= esc($page_title ?? 'Data Penyewaan') ?></h4>
    <a href="#" class="btn btn-success">Tambahkan Penyewaan</a>
</div>

<?php if (empty($penyewaan_per_bulan)): ?>
    <div class="card card-revisi">
        <div class="card-body empty-state">
            <img src="<?= base_url('assets/table_cat_animated.gif') ?>" alt="Tidak Ada Data">
            <h5 class="text-danger">Tidak Ada Data Penyewaan</h5>
            <p>Silakan tambahkan data penyewaan baru.</p>
        </div>
    </div>
<?php else: ?>
    <?php foreach ($penyewaan_per_bulan as $bulan => $items): ?>
    <div class="card card-revisi mb-4">
        <div class="card-header">Data Penyewaan bulan <?= $bulan ?></div>
        <div class="card-body table-responsive p-0">
            <table class="table table-bordered table-striped mb-0">
                <thead>
                    <tr>
                        <th>ID Sewa</th>
                        <th>ID Alat</th>
                        <th>ID Penyewa</th>
                        <th>Harga</th>
                        <th>Tanggal Sewa</th>
                        <th>Alamat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($items)): ?>
                        <tr><td colspan="7" class="p-5">Tidak ada data untuk bulan ini.</td></tr>
                    <?php else: ?>
                        <?php foreach ($items as $item): ?>
                            <tr>
                                <td><?= esc($item['id_sewa']) ?></td>
                                <td><?= esc($item['id_alat']) ?></td>
                                <td><?= esc($item['id_namasewa']) ?></td>
                                <td>Rp. <?= number_format($item['harga_alatdisewa'], 0, ',', '.') ?></td>
                                <td><?= date('d-m-Y', strtotime($item['tanggal_penyewaan'])) ?></td>
                                <td><?= esc($item['alamat_penyewa']) ?></td>
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