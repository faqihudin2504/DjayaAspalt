<?= $this->extend('layout/admin_cek_main') ?>

<?= $this->section('content') ?>

<style>
    .paket-card {
        background: white;
        border-radius: 15px;
        padding: 20px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        display: flex;
        flex-direction: column;
        height: 100%;
        text-align: center;
    }
    .paket-card h4 {
        font-weight: bold;
    }
    .paket-card ul {
        padding-left: 20px;
        text-align: left;
        flex-grow: 1;
        margin-top: 1rem;
    }
    .paket-card .status-stok {
        background-color: #28a745;
        color: white;
        border-radius: 50px;
        padding: 5px 15px;
        font-weight: bold;
        display: inline-block;
    }
    .paket-card .action-buttons button {
        margin: 0 5px;
    }
</style>

<div class="row">
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="paket-card">
            <h4>Paket A<br>Rp 70.000:</h4>
            <ul class="mt-3">
                <li>Pembersihan lokasi</li>
                <li>Cor emulasi</li>
                <li>Gelar aspal hotmix 2cm</li>
                <li>Pemadatan baby roller</li>
                <li>Upah tenaga</li>
            </ul>
            <div class="mt-auto">
                <div class="action-buttons">
                    <button class="btn btn-success btn-sm">Tambahkan</button>
                    <button class="btn btn-dark btn-sm">Edit</button>
                </div>
                <div class="status-stok mt-3">Masih Banyak</div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="paket-card">
            <h4>Paket B<br>Rp 85.000:</h4>
            <ul class="mt-3">
                <li>Pembersihan lokasi</li>
                <li>Tambal sulam batu split</li>
                <li>Cor emulasi</li>
                <li>Gelar aspal hotmix 2cm</li>
                <li>Pemadatan baby roller</li>
                <li>Upah tenaga</li>
            </ul>
            <div class="mt-auto">
                <div class="action-buttons">
                    <button class="btn btn-success btn-sm">Tambahkan</button>
                    <button class="btn btn-dark btn-sm">Edit</button>
                </div>
                <div class="status-stok mt-3">Masih Banyak</div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="paket-card">
            <h4>Paket C<br>Rp 100.000:</h4>
            <ul class="mt-3">
                <li>Pembersihan lokasi</li>
                <li>Gelar aspal bakar</li>
                <li>Gelar abu batu</li>
                <li>Pemadatan wales 4-6 ton</li>
                <li>Upah tenaga</li>
            </ul>
            <div class="mt-auto">
                <div class="action-buttons">
                    <button class="btn btn-success btn-sm">Tambahkan</button>
                    <button class="btn btn-dark btn-sm">Edit</button>
                </div>
                <div class="status-stok mt-3">Masih Banyak</div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="paket-card">
            <h4>Paket D<br>Rp 145.000:</h4>
            <ul>
                <li>Pembersihan lokasi</li>
                <li>Gelar batu makadam</li>
                <li>Gelar base course/split</li>
                <li>Cor emulasi</li>
                <li>Gelar aspal hotmix 3cm</li>
                <li>Pemadatan wales 4-6 ton</li>
                <li>Upah tenaga</li>
            </ul>
             <div class="mt-auto">
                <div class="action-buttons">
                    <button class="btn btn-success btn-sm">Tambahkan</button>
                    <button class="btn btn-dark btn-sm">Edit</button>
                </div>
                <div class="status-stok mt-3">Masih Banyak</div>
            </div>
        </div>
    </div>
</div>
<div class="text-center mt-3">
    <a href="<?= base_url('admin/cek-stok-full') ?>" class="btn btn-dark">Cek Stok Full</a>
</div>

<?= $this->endSection() ?>