<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="container mt-4">
    <div class="d-flex align-items-center mb-4">
        <a href="javascript:history.back()" class="me-3">
            <img src="<?= base_url('assets/Back-01.png') ?>" width="43" alt="Back">
        </a>
        <h2 class="mb-0">Keranjang</h2>
    </div>

    <div class="text-center mt-5">
        <img src="<?= base_url('assets/keranjang_kosong.gif') ?>" alt="Keranjang Kosong" class="img-fluid" style="max-width: 250px;">
        <h4 class="text-danger mt-3 fw-bold">Belum ada pesanan/penyewaan barang</h4>
    </div>
</div>
<?= $this->endSection() ?>