<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="container py-4">
    <div class="d-flex align-items-center mb-4">
        <a href="javascript:history.back()" class="me-3">
            <img src="<?= base_url('assets/Back-01.png') ?>" width="43" alt="Back">
        </a>
        <h2 class="mb-0">Pemesanan</h2>
    </div>

    <div class="text-center mb-5">
        <h2>Pilih yang ingin anda cari!</h2>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-5 col-md-6 mb-4">
            <div class="card h-100 shadow-lg border-primary">
                <div class="card-body text-center p-0">
                    <img src="/assets/pemesanan/pem1.png" class="img-fluid w-100" alt="Jasa & Barang" style="height: 400px; object-fit: cover;">
                    <div class="p-4">
                        <h4 class="card-title">Pemesanan <br>Jasa & Barang</h4>
                        <p class="card-text">Pesan jasa pengaspalan dan material berkualitas untuk proyek Anda</p>
                        <div class="mt-3">
                            <a href="<?= base_url('pemesanan-jasa-barang-form1') ?>" class="btn btn-primary px-4">
                                Pesan Sekarang
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-5 col-md-6 mb-4">
            <div class="card h-100 shadow-lg border-success">
                <div class="card-body text-center p-0">
                    <img src="/assets/pemesanan/pem2.png" class="img-fluid w-100" alt="Penyewaan Barang" style="height: 400px; object-fit: cover;">
                    <div class="p-4">
                        <h4 class="card-title">Penyewaan <br>Barang</h4>
                        <p class="card-text">Sewa peralatan dan mesin untuk kebutuhan proyek pengaspalan Anda</p>
                        <div class="mt-3">
                            <a href="<?= base_url('penyewaan-barang') ?>" class="btn btn-success px-4">
                                Sewa Sekarang
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card {
        transition: transform 0.3s;
        border-radius: 15px;
        overflow: hidden;
    }
    .card:hover {
        transform: translateY(-10px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.15);
    }
    .card-header {
        font-weight: bold;
        font-size: 1.25rem;
    }
    .btn {
        transition: all 0.3s;
    }
    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
</style>

<?= $this->endSection() ?>