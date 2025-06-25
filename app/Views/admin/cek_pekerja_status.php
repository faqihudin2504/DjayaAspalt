<?= $this->extend('layout/admin_cek_main') ?>
<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-lg-5 col-md-6 mb-4">
        <div class="admin-card h-100">
            <img src="<?= base_url('assets/pekerja_sedang_bekerja.png') ?>" alt="Pekerja Sedang Bekerja" style="max-width: 150px;" class="mb-3">
            <h5 class="fw-bold">Pekerja <span class="text-success">Sedang Bekerja</span></h5>
            <p>Pekerja: 10 Orang</p>
            <div class="mt-3">
                <a href="<?= base_url('admin/cek-pekerja-detail/bekerja') ?>" class="btn btn-info btn-sm">Cek</a>
                <button class="btn btn-success btn-sm mx-1">Tambahkan</button>
                <button class="btn btn-warning btn-sm">Edit</button>
            </div>
        </div>
    </div>
    <div class="col-lg-5 col-md-6 mb-4">
        <div class="admin-card h-100">
            <img src="<?= base_url('assets/pekerja_tidak_bekerja.png') ?>" alt="Pekerja Tidak Bekerja" style="max-width: 150px;" class="mb-3">
            <h5 class="fw-bold">Pekerja <span class="text-danger">Tidak Bekerja</span></h5>
            <p>Pekerja: 14 Orang</p>
            <div class="mt-3">
                <a href="<?= base_url('admin/cek-pekerja-detail/tersedia') ?>" class="btn btn-info btn-sm">Cek</a>
                <button class="btn btn-success btn-sm mx-1">Tambahkan</button>
                <button class="btn btn-warning btn-sm">Edit</button>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>