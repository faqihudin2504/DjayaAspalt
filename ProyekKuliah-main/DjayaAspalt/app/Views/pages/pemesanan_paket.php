<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="container py-4">
    <div class="d-flex align-items-center mb-4">
        <a href="javascript:history.back()" class="me-3">
            <img src="<?= base_url('assets/Back-01.png') ?>" width="43" alt="Back">
        </a>
        <h2 class="mb-0">Pemesanan Jasa & Barang</h2>
    </div>

    <div class="text-center mb-5">
        <h3 class="fw-bold">Halo <?= session()->get('nama_lengkap') ?? 'Pelanggan' ?>, Paket Apa Yang Kamu Inginkan?</h3>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card h-100 shadow-sm border-primary">
                <div class="card-body text-center p-4">
                    <h4 class="card-title fw-bold">Paket A <br>Rp 70.000:</h4>
                    <ul class="list-unstyled text-start mt-3">
                        <li>Pembersihan lokasi</li>
                        <li>Cor emulasi</li>
                        <li>Gelar aspal hotmix 2cm</li>
                        <li>Pemadatan baby roller</li>
                        <li>Upah tenaga</li>
                    </ul>
                    <button class="btn btn-primary px-4 mt-3" onclick="showAddedToCartModal()">Pesan</button>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card h-100 shadow-sm border-success">
                <div class="card-body text-center p-4">
                    <h4 class="card-title fw-bold">Paket B <br>Rp 85.000:</h4>
                    <ul class="list-unstyled text-start mt-3">
                        <li>Pembersihan lokasi</li>
                        <li>Tambal sulam batu split</li>
                        <li>Cor emulasi</li>
                        <li>Gelar aspal hotmix 2cm</li>
                        <li>Pemadatan baby roller</li>
                        <li>Upah tenaga</li>
                    </ul>
                    <button class="btn btn-success px-4 mt-3" onclick="showAddedToCartModal()">Pesan</button>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card h-100 shadow-sm border-warning">
                <div class="card-body text-center p-4">
                    <h4 class="card-title fw-bold">Paket C <br>Rp 100.000:</h4>
                    <ul class="list-unstyled text-start mt-3">
                        <li>Pembersihan lokasi</li>
                        <li>Gelar aspal bakar</li>
                        <li>Gelar abu batu</li>
                        <li>Pemadatan wales 4-6 ton</li>
                        <li>Upah tenaga</li>
                    </ul>
                    <button class="btn btn-warning px-4 mt-3" onclick="showAddedToCartModal()">Pesan</button>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card h-100 shadow-sm border-danger">
                <div class="card-body text-center p-4">
                    <h4 class="card-title fw-bold">Paket D <br>Rp 145.000:</h4>
                    <ul class="list-unstyled text-start mt-3">
                        <li>Pembersihan lokasi</li>
                        <li>Gelar batu makadam</li>
                        <li>Gelar base course/split</li>
                        <li>Cor emulasi</li>
                        <li>Gelar aspal hotmix 3cm</li>
                        <li>Pemadatan wales 4-6 ton</li>
                        <li>Upah tenaga</li>
                    </ul>
                    <button class="btn btn-danger px-4 mt-3" onclick="showAddedToCartModal()">Pesan</button>
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
    .card-title {
        font-size: 1.25rem;
    }
    .list-unstyled li {
        margin-bottom: 5px;
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