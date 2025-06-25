<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="container py-4">
    <div class="d-flex align-items-center mb-4">
        <a href="javascript:history.back()" class="me-3">
            <img src="<?= base_url('assets/Back-01.png') ?>" width="43" alt="Back">
        </a>
        <h2 class="mb-0">Penyewaan Barang</h2>
    </div>

    <div class="text-center mb-5">
        <h3>Halo, Kamu Ingin Melakukan Penyewaan Apa?</h3>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-3 mb-4">
            <a href="<?= base_url('penyewaan-barang/cek-alat/Penggilas-Aspal-Besar') ?>" class="text-decoration-none text-dark">
                <div class="card h-100 shadow-sm text-center p-3">
                    <img src="<?= base_url('assets/Penggilas Aspal Besar.png') ?>" class="card-img-top img-fluid mb-2" alt="Penggilas Aspal Besar">
                    <h5 class="card-title fw-bold">Penggilas Aspal <span class="text-danger">Besar</span></h5>
                </div>
            </a>
        </div>
        <div class="col-md-6 col-lg-3 mb-4">
            <a href="<?= base_url('penyewaan-barang/cek-alat/Penggilas-Aspal-Kecil') ?>" class="text-decoration-none text-dark">
                <div class="card h-100 shadow-sm text-center p-3">
                    <img src="<?= base_url('assets/Penggilas Aspal Kecil.png') ?>" class="card-img-top img-fluid mb-2" alt="Penggilas Aspal Kecil">
                    <h5 class="card-title fw-bold">Penggilas Aspal <span class="text-danger">Kecil</span></h5>
                </div>
            </a>
        </div>
        <div class="col-md-6 col-lg-3 mb-4">
            <a href="<?= base_url('penyewaan-barang/cek-alat/Penyebar-Aspal') ?>" class="text-decoration-none text-dark">
                <div class="card h-100 shadow-sm text-center p-3">
                    <img src="<?= base_url('assets/Penyebar Aspal.png') ?>" class="card-img-top img-fluid mb-2" alt="Penyebar Aspal">
                    <h5 class="card-title fw-bold">Penyebar <span class="text-danger">Aspal</span></h5>
                </div>
            </a>
        </div>
        <div class="col-md-6 col-lg-3 mb-4">
            <a href="<?= base_url('penyewaan-barang/cek-alat/Penghampar-Aspal') ?>" class="text-decoration-none text-dark">
                <div class="card h-100 shadow-sm text-center p-3">
                    <img src="<?= base_url('assets/Penghampar Aspal.png') ?>" class="card-img-top img-fluid mb-2" alt="Penghampar Aspal">
                    <h5 class="card-title fw-bold">Penghampar <span class="text-danger">Aspal</span></h5>
                </div>
            </a>
        </div>
    </div>
</div>

<style>
    .card img {
        max-height: 150px;
        object-fit: contain;
    }
    .card {
        transition: transform 0.3s, box-shadow 0.3s;
        border-radius: 10px;
    }
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
</style>
<?= $this->endSection() ?>