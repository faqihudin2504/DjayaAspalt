<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="container mt-4">
    <div class="d-flex align-items-center mb-4">
        <a href="javascript:history.back()" class="me-3">
            <img src="<?= base_url('assets/Back-01.png') ?>" width="43" alt="Back">
        </a>
        <h2 class="mb-0">Profile</h2>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <h2 class="card-title text-center mb-4">Profil Pelanggan Anda</h2>
            <p>Selamat datang di halaman profil Anda. Berikut adalah detail akun Anda:</p>
            <ul class="list-group list-group-flush">
                <?php if (session()->get('username')): ?>
                    <li class="list-group-item"><strong>Username:</strong> <?= session()->get('username') ?></li>
                <?php endif; ?>
                <?php if (session()->get('role')): ?>
                    <li class="list-group-item"><strong>Peran:</strong> <?= session()->get('role') ?></li>
                <?php endif; ?>
                <?php if (session()->get('nama_lengkap')): ?>
                    <li class="list-group-item"><strong>Nama Lengkap:</strong> <?= session()->get('nama_lengkap') ?></li>
                <?php endif; ?>
                <?php if (session()->get('email')): ?>
                    <li class="list-group-item"><strong>Email:</strong> <?= session()->get('email') ?></li>
                <?php endif; ?>
            </ul>

            <div class="mt-4 text-center">
                <a href="<?= base_url('customer-profile/edit') ?>" class="btn btn-primary">Edit Profil</a>
                <a href="<?= base_url('logout') ?>" class="btn btn-danger">Logout</a>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>