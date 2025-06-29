<?= $this->extend('layout/admin_kosong') ?>

<?= $this->section('content') ?>

<h4 class="mb-4 fw-bold">Edit Pelanggan: <?= esc($pelanggan['nama_lengkap']) ?></h4>

<div class="card shadow-sm">
    <div class="card-body">
        <form action="<?= base_url('admin/pelanggan/update/' . $pelanggan['id_pelanggan']) ?>" method="post">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" value="<?= esc($pelanggan['nama_lengkap']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="no_telpon" class="form-label">No. Telepon</label>
                <input type="text" class="form-control" id="no_telpon" name="no_telpon" value="<?= esc($pelanggan['no_telpon']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Alamat Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= esc($pelanggan['email']) ?>" required>
            </div>
           <div class="mb-3">
                <label for="tanggal_survey" class="form-label">Tanggal Daftar</label>
                <input type="text" class="form-control" id="tanggal_survey" name="tanggal_survey" value="<?= date('d F Y', strtotime($pelanggan['tanggal_survey'])) ?>" readonly>
            </div>
             <div class="mb-3">
                <label for="lokasi_survey" class="form-label">Alamat Lengkap</label>
                <textarea class="form-control" id="lokasi_survey" name="lokasi_survey" rows="3" required><?= esc($pelanggan['lokasi_survey']) ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="<?= base_url('admin/pelanggan') ?>" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>

<?= $this->endSection() ?>