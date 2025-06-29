<?= $this->extend('layout/admin_kosong') ?>

<?= $this->section('content') ?>

<h4 class="mb-4 fw-bold">Tambah Pelanggan Baru</h4>

<?php if (session()->getFlashdata('errors')): ?>
    <div class="alert alert-danger">
        <ul>
        <?php foreach (session()->getFlashdata('errors') as $error): ?>
            <li><?= esc($error) ?></li>
        <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<div class="card shadow-sm">
    <div class="card-body">
        <form action="<?= base_url('admin/pelanggan/simpan') ?>" method="post">
            <?= csrf_field() ?>
            
            <div class="mb-3">
                <label for="tipe_transaksi" class="form-label fw-bold">Tujuan Pendaftaran</label>
                <select class="form-select" name="tipe_transaksi" id="tipe_transaksi" required>
                    <option value="" disabled selected>-- Pilih Tujuan --</option>
                    <option value="SURVEY">Untuk Kebutuhan Survey</option>
                    <option value="SEWA">Untuk Kebutuhan Sewa</option>
                </select>
                <small class="form-text text-muted">ID Survey atau ID Sewa akan dibuat otomatis berdasarkan pilihan ini.</small>
            </div>
            
            <hr>

            <div class="mb-3">
                <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" value="<?= old('nama_lengkap') ?>" required>
            </div>
            
            <div class="mb-3">
                <label for="no_telpon" class="form-label">No. Telepon</label>
                <input type="tel" class="form-control" id="no_telpon" name="no_telpon" value="<?= old('no_telpon') ?>" required>
            </div>
            
            <div class="mb-3">
                <label for="tanggal_survey" class="form-label">Tanggal Survey / Mulai Sewa</label>
                <input type="date" class="form-control" id="tanggal_survey" name="tanggal_survey" value="<?= old('tanggal_survey', date('Y-m-d')) ?>" required>
            </div>
            
            <div class="mb-3">
                <label for="lokasi_survey" class="form-label">Lokasi Survey / Pengiriman</label>
                <textarea class="form-control" id="lokasi_survey" name="lokasi_survey" rows="3" required><?= old('lokasi_survey') ?></textarea>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Simpan Pelanggan</button>
                <a href="<?= base_url('admin/pelanggan') ?>" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>