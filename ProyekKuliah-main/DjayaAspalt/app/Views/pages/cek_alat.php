<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="container py-4">
    <div class="d-flex align-items-center mb-4">
        <a href="javascript:history.back()" class="me-3">
            <img src="<?= base_url('assets/Back-01.png') ?>" width="43" alt="Back">
        </a>
        <h2 class="mb-0">Cek Alat</h2>
    </div>

    <div class="row">
        <div class="col-md-3 text-center d-none d-md-block">
            <img src="<?= base_url('assets/Penggilas Aspal Besar.png') ?>" class="img-fluid mt-5" style="max-width: 150px; opacity: 0.8;" alt="Rolling Machine Icon">
        </div>
        <div class="col-md-9">
            <div class="card p-4 shadow-sm mb-4">
                <h4 class="mb-3">Nama Alat</h4>
                <div class="d-flex align-items-center mb-4">
                    <img src="<?= base_url('assets/' . $alat_nama . '.png') ?>" class="img-fluid me-4" style="max-width: 150px;" alt="<?= $alat_nama ?>">
                    <div>
                        <h3 class="fw-bold"><?= $alat_nama ?></h3>
                        <h5 class="mt-3">Cek Alat</h5>
                        <?php if ($alat_tersedia): ?>
                            <span class="badge bg-success py-2 px-3 fs-6">Tersedia</span>
                        <?php else: ?>
                            <span class="badge bg-danger py-2 px-3 fs-6">Tidak Tersedia</span>
                        <?php endif; ?>
                        <p class="mt-2 fs-5">Stok Alat <span class="text-success fw-bold"><?= $alat_stok ?></span></p>
                    </div>
                </div>

                <h5 class="mb-3">Informasi Alat</h5>
                <p><?= $alat_info ?></p>

                <a href="<?= base_url('penyewaan-barang/form/' . url_title($alat_nama)) ?>" class="btn btn-success mt-3">Konfirmasi</a>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>