<?= $this->extend('layout/admin_kosong') ?>
<?= $this->section('content') ?>
<h4 class="mb-4 fw-bold"><?= esc($page_title ?? 'Tambah Data Alat') ?></h4>

<?php if (session()->getFlashdata('errors')): ?>
    <div class="alert alert-danger">
        <h5 class="alert-heading">Maaf, Data anda gagal tersimpan!</h5>
        <ul class="mb-0">
        <?php foreach (session()->getFlashdata('errors') as $error): ?>
            <li><?= esc($error) ?></li>
        <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<div class="card shadow-sm">
    <div class="card-body">
        <form action="<?= base_url('admin/alat/simpan') ?>" method="post">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label for="id_alat" class="form-label">ID Alat</label>
                <input type="text" class="form-control" id="id_alat" name="id_alat" value="<?= old('id_alat') ?>" required>
                 <small class="form-text text-muted">Contoh: ALAT001, ALAT002, dll.</small>
            </div>
             <div class="mb-3">
                <label for="cek_alat" class="form-label">Status Awal</label>
                <input type="text" class="form-control" id="cek_alat" name="cek_alat" value="Tersedia" readonly>
            </div>
            <div class="mb-3">
                <label for="nama_alat" class="form-label">Nama Alat</label>
                <input type="text" class="form-control" id="nama_alat" name="nama_alat" value="<?= old('nama_alat') ?>" required>
            </div>
            <div class="mb-3">
                <label for="stok_alat" class="form-label">Stok</label>
                <input type="number" class="form-control" id="stok_alat" name="stok_alat" min="0" value="<?= old('stok_alat') ?>" required>
            </div>
            <div class="mb-3">
                <label for="informasi_alat" class="form-label">Informasi Alat</label>
                <textarea class="form-control" id="informasi_alat" name="informasi_alat" rows="4" required><?= old('informasi_alat') ?></textarea>
            </div>
            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="<?= base_url('admin/alat') ?>" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>