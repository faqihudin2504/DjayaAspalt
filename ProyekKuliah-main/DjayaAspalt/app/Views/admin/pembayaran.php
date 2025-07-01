<?= $this->extend('layout/admin_main') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold m-0"><?= esc($page_title ?? 'Data Pembayaran') ?></h4>
    <a href="<?= base_url('admin/pembayaran/tambah') ?>" class="btn btn-success">Tambahkan Pembayaran</a>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="card shadow-sm">
    <div class="card-header fw-bold">Daftar Semua Pembayaran</div>
    <div class="card-body table-responsive p-0">
        <table class="table table-bordered table-striped table-hover mb-0">
            <thead class="table-dark">
                <tr>
                    <th>ID Bayar</th>
                    <th>Nama Pelanggan</th>
                    <th>Untuk Transaksi</th>
                    <th>Total Harga</th>
                    <th>Tanggal Bayar</th>
                    <th>Metode</th>
                    <th>No. Rekening</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($pembayaran_list)): ?>
                    <tr>
                        <td colspan="8" class="text-center p-5">
                            <img src="<?= base_url('assets/table_cat_animated.gif') ?>" width="100" class="mb-3">
                            <p class="text-danger">Belum ada data pembayaran.</p>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($pembayaran_list as $item): ?>
                        <tr>
                            <td><?= esc($item['id_bayar']) ?></td>
                            <td>
                                <?php echo esc($item['nama_lengkap'] ?: ($item['nama_penyewa'] ?: 'N/A')); ?>
                            </td>
                            <td>
                                <?php if (!empty($item['id_pesanan'])): ?>
                                    Pesanan: <?= esc($item['id_pesanan']) ?>
                                <?php elseif (!empty($item['id_sewa'])): ?>
                                    Sewa: <?= esc($item['id_sewa']) ?>
                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </td>
                            <td>Rp. <?= number_format($item['total_harga'] ?? 0, 0, ',', '.') ?></td>
                            <td><?= esc(date('d M Y', strtotime($item['tanggal_pembayaran']))) ?></td>
                            <td><span class="badge bg-secondary"><?= esc($item['metode_pembayaran']) ?></span></td>
                            <td><?= esc($item['no_rekening']) ?></td>
                            <td>
                                <a href="<?= base_url('admin/pembayaran/hapus/' . $item['id_bayar']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Anda yakin ingin menghapus data ini?')">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>