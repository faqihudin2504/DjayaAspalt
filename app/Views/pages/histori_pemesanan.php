<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="container mt-4">
    <div class="d-flex align-items-center mb-4">
        <a href="javascript:history.back()" class="me-3">
            <img src="<?= base_url('assets/Back-01.png') ?>" width="43" alt="Back">
        </a>
        <h2 class="mb-0">Histori Pemesanan</h2>
    </div>

    <?php if (isset($has_orders) && $has_orders): ?>
    <h4 class="text-success fw-bold text-center mb-4">SUDAH PERNAH DIPESAN & DIKERJAKAN</h4>
    <div class="card p-4 shadow-sm mb-4">
        <h5 class="fw-bold mb-3"><?= $pemesanan['paket'] ?? 'Paket Tidak Diketahui' ?></h5>
        <p class="mb-1"><strong>Nama:</strong> <?= $pemesanan['nama'] ?? '-' ?></p>
        <p class="mb-1"><strong>Waktu:</strong> <?= $pemesanan['waktu'] ?? '-' ?></p>
        <p class="mb-1"><strong>Tanggal:</strong> <?= $pemesanan['tanggal'] ?? '-' ?></p>
        <p class="mb-0"><strong>Lokasi:</strong> <?= $pemesanan['lokasi'] ?? '-' ?></p>
    </div>
    <?php else: ?>
    <div class="text-center mt-5">
        <img src="<?= base_url('assets/histori_kosong.gif') ?>" alt="Tidak Ada Pesanan" class="img-fluid" style="max-width: 250px;">
        <h4 class="text-danger mt-3 fw-bold">Tidak Ada Pesanan</h4>
    </div>
    <?php endif; ?>

</div>
<?= $this->endSection() ?>