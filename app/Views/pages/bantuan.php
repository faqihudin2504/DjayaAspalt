<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="container py-4">
    <div class="d-flex align-items-center mb-4">
        <a href="javascript:history.back()" class="me-3">
            <img src="<?= base_url('assets/Back-01.png') ?>" width="43" alt="Back">
        </a>
        <h2 class="mb-0">Bantuan</h2>
    </div>

    <div class="mb-5">
        <p class="lead">Halo,</p>
        <p class="lead"><strong>Apakah ada yang bisa kami bantu?</strong></p>
        <p>Pilih Topik sesuai kendala</p>
    </div>

    <div class="row text-center mb-5">
        <div class="col-md-3">
            <h3 style="font-size: 1.2rem;">Pemesanan</h3>
        </div>
        <div class="col-md-3">
            <h3 style="font-size: 1.2rem;">Penyewaan</h3>
        </div>
        <div class="col-md-3">
            <h3 style="font-size: 1.2rem;">Pembayaran</h3>
        </div>
        <div class="col-md-3">
            <h3 style="font-size: 1.2rem;">Paket/promo</h3>
        </div>
    </div>

    <h3 class="mb-4">Yang Sering ditanyakan</h3>
    
    <div class="list-group list-group-flush mb-5">
        <a href="#" class="list-group-item list-group-item-action py-3">Bagaimana cara menggunakan paket projek?</a>
        <hr class="my-2">
        <a href="#" class="list-group-item list-group-item-action py-3">Apa saja metode pembayaran?</a>
        <hr class="my-2">
        <a href="#" class="list-group-item list-group-item-action py-3">Apa saja paket projek yang sedang berlangsung?</a>
        <hr class="my-2">
        <a href="#" class="list-group-item list-group-item-action py-3">Bagaimana mengubah metode pembayaran?</a>
        <hr class="my-2">
        <a href="#" class="list-group-item list-group-item-action py-3">Berapa lama waktu pengiriman?</a>
        <hr class="my-2">
    </div>

    <div class="card p-3 d-flex flex-row align-items-center justify-content-between" style="background-color: #dc3545; color: white;">
        <div class="d-flex align-items-center">
            <img src="<?= base_url('assets/customer_service_icon.png') ?>" width="50" class="me-3" alt="Customer Service">
            <div>
                <p class="mb-0">Masih ada pertanyaan lagi?</p>
                <p class="mb-0 fw-bold">Yuk ngobrol dengan Customer Service kami</p>
            </div>
        </div>
        <button class="btn btn-light rounded-pill px-4">Tanya</button>
    </div>
</div>
<?= $this->endSection() ?>