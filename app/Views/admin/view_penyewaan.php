<?= $this->extend('layout/admin_main') ?>

<?= $this->section('content') ?>

<div class="d-flex align-items-center mb-4">
    <a href="<?= base_url('admin/penyewaan') ?>" class="btn btn-light me-3" style="padding: 0.5rem 1rem;">
        &larr; Kembali
    </a>
    <h4 class="mb-0 fw-bold">Detail Data Penyewaan</h4>
</div>

<div class="card shadow-sm">
    <div class="card-header fw-bold">
        ID Sewa: <?= esc($penyewaan['id_sewa']) ?>
    </div>
    <div class="card-body">
        <?php if (!empty($penyewaan)): ?>
            <div class="row">
                <div class="col-md-6">
                    <h5>Informasi Penyewa</h5>
                    <hr>
                    <p><strong>ID Pelanggan (Penyewa):</strong> <?= esc($penyewaan['id_namasewa']) ?></p>
                    <p><strong>Nama Penyewa:</strong> <?= esc($penyewaan['nama_penyewa']) ?></p>
                    <p><strong>Alamat Pengiriman:</strong> <?= esc($penyewaan['alamat_penyewa']) ?></p>
                </div>
                <div class="col-md-6">
                    <h5>Detail Penyewaan</h5>
                    <hr>
                    <p><strong>ID Alat yang Disewa:</strong> <?= esc($penyewaan['id_alat']) ?></p>
                    <p><strong>Tanggal Penyewaan:</strong> <?= esc(date('d F Y', strtotime($penyewaan['tanggal_penyewaan']))) ?></p>
                    <p><strong>Harga Sewa:</strong> Rp. <?= number_format($penyewaan['harga_alatdisewa'] ?? 0, 0, ',', '.') ?></p>
                    <p><strong>Status:</strong> <span class="badge bg-primary"><?= esc($penyewaan['status']) ?></span></p>
                </div>
            </div>
            <div class="text-end mt-4">
                <a href="<?= base_url('admin/penyewaan/edit/' . $penyewaan['id_sewa']) ?>" class="btn btn-warning">Edit Data Ini</a>
            </div>
        <?php else: ?>
            <div class="alert alert-warning" role="alert">
                Data penyewaan tidak ditemukan.
            </div>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>