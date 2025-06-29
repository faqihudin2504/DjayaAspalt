<?= $this->extend('layout/admin_kosong') ?>

<?= $this->section('content') ?>

<h4 class="mb-4 fw-bold">Tambah Pelanggan Baru</h4>

<div class="card shadow-sm">
    <div class="card-body">
        <form action="<?= base_url('admin/pelanggan/simpan') ?>" method="post">
            <?= csrf_field() ?>
            
            <div class="mb-3">
                <label for="tujuan" class="form-label fw-bold">Tujuan Pendaftaran</label>
                <select class="form-select" id="tujuan" name="tujuan" required>
                    <option value="" selected disabled>-- Pilih Tujuan --</option>
                    <option value="survey">Untuk Kebutuhan Survey</option>
                    <option value="sewa">Untuk Kebutuhan Sewa</option>
                </select>
                <small class="form-text text-muted">ID Survey atau ID Sewa akan dibuat otomatis berdasarkan pilihan ini.</small>
            </div>

            <div class="mb-3">
                <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" required placeholder="Masukkan nama lengkap pelanggan">
            </div>
            <div class="mb-3">
                <label for="no_telpon" class="form-label">No. Telepon</label>
                <input type="tel" class="form-control" id="no_telpon" name="no_telpon" required placeholder="Contoh: 081234567890">
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Alamat Email</label>
                <input type="email" class="form-control" id="email" name="email" required placeholder="Contoh: pelanggan@email.com">
            </div>
            <div class="mb-3">
                <label for="lokasi_survey" class="form-label">Alamat Lengkap</label>
                <textarea class="form-control" id="lokasi_survey" name="lokasi_survey" rows="3" required placeholder="Masukkan alamat lengkap pelanggan"></textarea>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="<?= base_url('admin/pelanggan') ?>" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>