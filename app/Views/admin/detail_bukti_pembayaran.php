<?= $this->extend('layout/admin_kosong') ?>

<?= $this->section('content') ?>
<style>
    .bukti-container {
        background-color: #fff;
        padding: 2rem;
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    .bukti-image-wrapper {
        text-align: center;
        margin-bottom: 1.5rem;
    }
    .bukti-image {
        max-width: 100%;
        max-height: 500px;
        border: 1px solid #ddd;
        padding: 5px;
        border-radius: 10px;
    }
    .info-pembayaran h5 {
        font-weight: 600;
    }
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold m-0">Detail Bukti Pembayaran</h4>
    <a href="javascript:history.back()" class="btn btn-secondary">Kembali</a>
</div>

<div class="bukti-container">
    <?php if ($pembayaran && !empty($pembayaran['bukti_pembayaran'])): ?>
        <div class="bukti-image-wrapper">
            <img src="<?= base_url('uploads/bukti/' . esc($pembayaran['bukti_pembayaran'])) ?>" alt="Bukti Transfer" class="bukti-image">
        </div>
        <hr>
        <div class="info-pembayaran mt-4">
            <h5>Informasi Tambahan</h5>
            <p><strong>ID Bayar:</strong> <?= esc($pembayaran['id_bayar']) ?></p>
            <p><strong>Metode:</strong> <?= esc($pembayaran['metode_pembayaran']) ?></p>
            <p><strong>Tanggal Bayar:</strong> <?= date('d F Y', strtotime($pembayaran['tanggal_pembayaran'])) ?></p>
            <p><strong>Status:</strong> <span class="badge bg-success"><?= esc($pembayaran['status_pembayaran']) ?></span></p>
        </div>
    <?php else: ?>
        <div class="text-center p-5">
            <h5 class="text-danger">Bukti pembayaran tidak ditemukan.</h5>
            <p class="text-muted">File mungkin belum diunggah atau telah terhapus.</p>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>