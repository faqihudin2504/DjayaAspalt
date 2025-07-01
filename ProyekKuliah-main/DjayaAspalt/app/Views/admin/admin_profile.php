<?= $this->extend('layout/admin_main') ?>

<?= $this->section('content') ?>

<style>
    .profile-page {
        background-color: #ffb366; /* Warna oranye background */
        padding: 30px;
        border-radius: 15px;
    }
    .profile-pic-container {
        position: relative;
        width: 180px;
        height: 180px;
        margin: 0 auto;
    }
    .profile-pic {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
        border: 5px solid white;
    }
    .profile-pic-btn {
        position: absolute;
        bottom: 10px;
        right: 10px;
        width: 50px;
        height: 50px;
        background-color: #007bff;
        color: white;
        border-radius: 50%;
        border: 3px solid white;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 24px;
        text-decoration: none;
    }
    .info-group {
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
    }
    .info-group .icon {
        width: 40px;
        margin-right: 15px;
    }
    .info-group .info-field {
        background-color: #FFF;
        border-radius: 10px;
        padding: 12px 15px;
        width: 100%;
        min-height: 48px;
        border: 1px solid #ccc;
        color: #495057;
        word-wrap: break-word; /* Agar teks panjang tidak keluar dari kotak */
    }
    .info-group .info-field-disabled {
        background-color: #e48f8f;
        color: white;
        font-weight: bold;
    }
    .info-group .info-field-textarea {
        min-height: 90px;
    }
    .btn-edit-info {
        background-color: #343a40;
        color: white;
        font-weight: bold;
        padding: 10px 30px;
        border-radius: 10px;
        text-decoration: none;
    }
</style>

<div class="profile-page">
    <div class="d-flex align-items-center mb-4">
        <a href="javascript:history.back()" class="text-white me-3">
            <h2 class="mb-0">←</h2>
        </a>
        <h4 class="mb-0 text-white">Informasi Akun</h4>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-md-4 text-center">
            <div class="profile-pic-container mb-2">
                <img src="<?= ($foto_profil ?? null) ? base_url('uploads/avatars/' . $foto_profil) : base_url('assets/admin_profile_pic.png') ?>" class="profile-pic" alt="Foto Profil">
                <a href="<?= base_url('admin/profile/edit') ?>" class="profile-pic-btn">+</a>
            </div>
            <p class="text-white fw-bold">Ganti Profil</p>
            <img src="<?= base_url('assets/admin_worker_illustration.png') ?>" class="img-fluid mt-4" style="max-width: 150px;" alt="Admin Worker">
        </div>

        <div class="col-md-8">
            <div class="info-group">
                <img src="<?= base_url('assets/pelanggan_icon.png') ?>" class="icon" alt="icon">
                <div class="info-field info-field-disabled"><?= esc($username ?? 'admin_user') ?></div>
            </div>
            <div class="info-group">
                <img src="<?= base_url('assets/nama_icon.png') ?>" class="icon" alt="icon">
                <div class="info-field"><?= esc($nama_lengkap ?? 'Nama Belum Diatur') ?></div>
            </div>
            <div class="info-group">
                <img src="<?= base_url('assets/hubungi-kami/wa.png') ?>" class="icon" alt="icon">
                <div class="info-field"><?= esc($no_telpon ?? 'Belum diatur') ?></div>
            </div>
            <div class="info-group">
                <img src="<?= base_url('assets/hubungi-kami/email.png') ?>" class="icon" alt="icon">
                <div class="info-field"><?= esc($email ?? 'email@example.com') ?></div>
            </div>
            <div class="info-group">
                <img src="<?= base_url('assets/home_icon.png') ?>" class="icon" alt="icon">
                <div class="info-field info-field-textarea"><?= esc($alamat_rumah ?? 'Belum diatur') ?></div>
            </div>

            <div class="mt-4">
                <a href="<?= base_url('admin/profile/edit') ?>" class="btn btn-edit-info">Ganti Informasi</a>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>