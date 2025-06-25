<?= $this->extend('layout/admin_main') ?>

<?= $this->section('content') ?>

<div class="d-flex align-items-center mb-4">
    <a href="<?= base_url('admin/pelanggan') ?>" class="btn btn-light me-3">
        &larr; Kembali
    </a>
    <h4 class="mb-0 fw-bold">Detail Data Pelanggan</h4>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <h5>Informasi Utama</h5>
                <hr>
                <p><strong>ID Pelanggan:</strong> <?= esc($pelanggan['id_pelanggan']) ?></p>
                <p><strong>Nama Lengkap:</strong> <?= esc($pelanggan['nama_lengkap']) ?></p>
                <p><strong>Nomor Telepon:</strong> <?= esc($pelanggan['no_telpon']) ?></p>
            </div>
            <div class="col-md-6">
                <h5>Detail Survey & Sewa</h5>
                <hr>
                <p><strong>ID Survey:</strong> <?= esc($pelanggan['id_survey']) ?></p>
                <p><strong>ID Nama Sewa:</strong> <?= esc($pelanggan['id_namasewa']) ?></p>
                <p><strong>Tanggal Survey:</strong> <?= esc(date('d F Y', strtotime($pelanggan['tanggal_survey']))) ?></p>
                <p><strong>Lokasi Survey:</strong> <?= esc($pelanggan['lokasi_survey']) ?></p>
            </div>
        </div>
        <div class="text-end mt-3">
            <a href="<?= base_url('admin/pelanggan/edit/' . $pelanggan['id_pelanggan']) ?>" class="btn btn-warning">Edit Data Ini</a>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
