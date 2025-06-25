<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="container mt-4">
    <div class="d-flex align-items-center mb-4">
        <a href="javascript:history.back()" class="me-3">
            <img src="<?= base_url('assets/Back-01.png') ?>" width="43" alt="Back">
        </a>
        <h2 class="mb-0">Informasi Akun</h2>
    </div>

    <div class="row">
        <div class="col-md-3 text-center">
            <img src="<?= base_url('assets/Profil-01.png') ?>" class="img-fluid rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;" alt="User Profile Picture">
            <button class="btn btn-light rounded-circle" style="position: relative; top: -40px; right: -50px; width: 40px; height: 40px;"><i class="fas fa-plus"></i></button>
            <p class="mt-2">Ganti Profil</p>
            <img src="<?= base_url('assets/worker_drilling.png') ?>" class="img-fluid mt-4" style="max-width: 150px;" alt="Worker Drilling">
        </div>
        <div class="col-md-9">
            <div class="card p-4 shadow-sm">
                <form action="<?= base_url('customer-profile/update') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="mb-3 d-flex align-items-center">
                        <img src="<?= base_url('assets/nama_icon.png') ?>" width="24" class="me-2" alt="Name Icon">
                        <label for="nama_lengkap" class="form-label mb-0 me-2">Nama Lengkap</label>
                        <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" value="<?= esc($nama_lengkap ?? '') ?>">
                    </div>
                    <div class="mb-3 d-flex align-items-center">
                        <img src="<?= base_url('assets/hubungi-kami/wa.png') ?>" width="24" class="me-2" alt="Phone Icon">
                        <label for="no_handphone" class="form-label mb-0 me-2">No. Telpon</label>
                        <input type="text" class="form-control" id="no_handphone" name="no_handphone" value="<?= esc($no_handphone ?? '') ?>">
                    </div>
                    <div class="mb-3 d-flex align-items-center">
                        <img src="<?= base_url('assets/hubungi-kami/email.png') ?>" width="24" class="me-2" alt="Email Icon">
                        <label for="email" class="form-label mb-0 me-2">Alamat Gmail</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?= esc($email ?? '') ?>" readonly>
                    </div>
                    <div class="mb-3 d-flex align-items-center">
                        <img src="<?= base_url('assets/home_icon.png') ?>" width="24" class="me-2" alt="Home Icon">
                        <label for="alamat_rumah" class="form-label mb-0 me-2">Alamat Rumah</label>
                        <textarea class="form-control" id="alamat_rumah" name="alamat_rumah" rows="3"><?= esc($alamat_rumah ?? '') ?></textarea>
                    </div>
                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-dark me-2">Konfirmasi</button>
                        <button type="button" class="btn btn-secondary" onclick="window.location.reload();">Ganti Informasi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>