<?= $this->extend('layout/admin_main') ?>

<?= $this->section('content') ?>

<style>
    .profile-edit-page {
        background-color: #ffb366;
        padding: 30px;
        border-radius: 15px;
    }
    .profile-pic-container {
        position: relative;
        width: 180px;
        height: 180px;
        margin: 0 auto;
        cursor: pointer;
    }
    .profile-pic {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
        border: 5px solid white;
    }
    .profile-pic-upload-btn {
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
        pointer-events: none; /* Tombol plus hanya sebagai ikon */
    }
    #foto_profil {
        display: none; /* Sembunyikan input file asli */
    }
    .form-group-custom {
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
    }
    .form-group-custom .icon {
        width: 40px;
        margin-right: 15px;
    }
    .form-group-custom .form-control {
        border-radius: 10px;
        border: 1px solid #ccc;
        padding: 10px;
    }
    .form-group-custom .form-control:disabled {
        background-color: #e48f8f;
        color: white;
        font-weight: bold;
    }
    .btn-konfirmasi {
        background-color: #343a40;
        color: white;
        font-weight: bold;
        padding: 10px 30px;
        border-radius: 10px;
    }
    .btn-ganti-info {
        background-color: #ced4da;
        color: #343a40;
        font-weight: bold;
        padding: 10px 30px;
        border-radius: 10px;
    }
</style>

<div class="profile-edit-page">
    <div class="d-flex align-items-center mb-4">
        <a href="javascript:history.back()" class="text-white me-3">
            <h2 class="mb-0">←</h2>
        </a>
        <h4 class="mb-0 text-white">Informasi Akun</h4>
    </div>

    <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger">
            <h4 class="alert-heading">Gagal Menyimpan!</h4>
            <ul>
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('admin/profile/update') ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <div class="row">
            <div class="col-md-4 text-center">
                <label for="foto_profil" class="profile-pic-container mb-2" title="Klik untuk ganti foto profil">
                    <img src="<?= ($foto_profil ?? null) ? base_url('uploads/avatars/' . $foto_profil) : base_url('assets/admin_profile_pic.png') ?>" class="profile-pic" id="profile-pic-preview" alt="Foto Profil">
                    <span class="profile-pic-upload-btn">+</span>
                </label>
                <p class="text-white fw-bold">Ganti Profil</p>
                <input type="file" id="foto_profil" name="foto_profil" class="d-none" onchange="previewImage(event)">
                
                <img src="<?= base_url('assets/admin_worker_illustration.png') ?>" class="img-fluid mt-4" style="max-width: 150px;" alt="Admin Worker">
            </div>

            <div class="col-md-8">
                <div class="form-group-custom">
                    <img src="<?= base_url('assets/pelanggan_icon.png') ?>" class="icon" alt="icon">
                    <input type="text" class="form-control" id="id_admin" value="<?= esc($username ?? 'admin_user') ?>" disabled>
                </div>
                <div class="form-group-custom">
                    <img src="<?= base_url('assets/nama_icon.png') ?>" class="icon" alt="icon">
                    <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" placeholder="Nama Lengkap" value="<?= esc($nama_lengkap ?? '') ?>">
                </div>
                <div class="form-group-custom">
                    <img src="<?= base_url('assets/hubungi-kami/wa.png') ?>" class="icon" alt="icon">
                    <input type="text" class="form-control" id="no_telpon" name="no_telpon" placeholder="No. Telpon" value="081234567890">
                </div>
                <div class="form-group-custom">
                    <img src="<?= base_url('assets/hubungi-kami/email.png') ?>" class="icon" alt="icon">
                    <input type="email" class="form-control" id="email" name="email" placeholder="Alamat Gmail" value="<?= esc($email ?? '') ?>">
                </div>
                <div class="form-group-custom">
                    <img src="<?= base_url('assets/home_icon.png') ?>" class="icon" alt="icon">
                    <textarea class="form-control" id="alamat_rumah" name="alamat_rumah" rows="3" placeholder="Alamat Rumah">Jl. Admin, No. 1, Jakarta</textarea>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-konfirmasi me-2">Konfirmasi</button>
                    <button type="reset" class="btn btn-ganti-info">Ganti Informasi</button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    // Script kecil untuk preview gambar saat dipilih
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function(){
            var output = document.getElementById('profile-pic-preview');
            output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>

<?= $this->endSection() ?>