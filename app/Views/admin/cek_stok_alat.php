<?= $this->extend('layout/admin_cek_main') ?>
<?= $this->section('content') ?>
<div class="row">
    <div class="col-md-3 col-6 mb-4">
        <div class="admin-card h-100">
            <img src="<?= base_url('assets/stok_alat_1.png') ?>" class="img-fluid rounded mb-3">
            <h6 class="fw-bold">Penggilas Aspal Besar</h6>
            <p class="mb-2">Stok: 1</p>
            <div>
                <button class="btn btn-success btn-sm">Tambahkan</button>
                <button class="btn btn-dark btn-sm">Edit</button>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-6 mb-4">
        <div class="admin-card h-100">
            <img src="<?= base_url('assets/stok_alat_2.png') ?>" class="img-fluid rounded mb-3">
            <h6 class="fw-bold">Penggilas Aspal Kecil</h6>
            <p class="mb-2">Stok: 1</p>
            <div>
                <button class="btn btn-success btn-sm">Tambahkan</button>
                <button class="btn btn-dark btn-sm">Edit</button>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-6 mb-4">
        <div class="admin-card h-100">
            <img src="<?= base_url('assets/stok_alat_3.png') ?>" class="img-fluid rounded mb-3">
            <h6 class="fw-bold">Alat Penyebar Aspal</h6>
            <p class="mb-2">Stok: 0</p>
            <div>
                <button class="btn btn-success btn-sm">Tambahkan</button>
                <button class="btn btn-dark btn-sm">Edit</button>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-6 mb-4">
        <div class="admin-card h-100">
            <img src="<?= base_url('assets/stok_alat_4.png') ?>" class="img-fluid rounded mb-3">
            <h6 class="fw-bold">Penghampar Aspal</h6>
            <p class="mb-2">Stok: 2</p>
            <div>
                <button class="btn btn-success btn-sm">Tambahkan</button>
                <button class="btn btn-dark btn-sm">Edit</button>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>