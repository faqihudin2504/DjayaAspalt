<?= $this->extend('layout/admin_main') ?>

<?= $this->section('content') ?>

<!-- Bagian untuk Gambar Slider -->
<div id="carouselExampleControls" class="carousel slide mb-4" data-bs-ride="carousel">
    <div class="carousel-inner" style="border-radius: 15px;">
        <div class="carousel-item active">
            <img src="<?= base_url('assets/slider_image_1.jpg') ?>" class="d-block w-100" alt="Slider 1">
        </div>
        <div class="carousel-item">
            <img src="<?= base_url('assets/slider_image_2.jpg') ?>" class="d-block w-100" alt="Slider 2">
        </div>
        <div class="carousel-item">
            <img src="<?= base_url('assets/slider_image_3.jpg') ?>" class="d-block w-100" alt="Slider 3">
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>

<!-- Bagian untuk Catatan Admin -->
<div class="card">
    <div class="card-body">
        <h5 class="card-title fw-bold">Catatan untuk admin:</h5>
        <ol class="list-group list-group-flush">
            <li class="list-group-item">1. Pastikan semua pesanan pelanggan diproses tepat waktu.</li>
            <li class="list-group-item">2. Periksa ketersediaan alat penyewaan sebelum mengkonfirmasi pemesanan.</li>
            <li class="list-group-item">3. Pantau pembayaran yang masuk dan segera konfirmasi kepada pelanggan.</li>
            <li class="list-group-item">4. Pastikan pengembalian alat dilakukan sesuai jadwal dan dalam kondisi baik.</li>
            <li class="list-group-item">5. Update informasi pelanggan secara berkala untuk menjaga data tetap akurat.</li>
        </ol>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<?= $this->endSection() ?>
