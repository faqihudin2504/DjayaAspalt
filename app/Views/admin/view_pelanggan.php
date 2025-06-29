<?= $this->extend('layout/admin_kosong') ?>

<?= $this->section('content') ?>

<div class="d-flex align-items-center mb-4">
    <a href="<?= base_url('admin/pelanggan') ?>" class="btn btn-light me-3" style="border: 1px solid #ccc;">
        &larr; Kembali
    </a>
    <h4 class="mb-0 fw-bold">Detail Data Pelanggan</h4>
</div>

<div class="card shadow-sm">
    <div class="card-header fw-bold bg-light">
        Informasi untuk: <?= esc($pelanggan['nama_lengkap']) ?>
    </div>
    <div class="card-body">
        <?php if (!empty($pelanggan)): ?>
            <div class="row">
                <div class="col-md-6">
                    <h5>Informasi Utama</h5>
                    <table class="table table-borderless">
                        <tr>
                            <td style="width: 150px;"><strong>ID Pelanggan</strong></td>
                            <td>: <?= esc($pelanggan['id_pelanggan']) ?></td>
                        </tr>
                        <tr>
                            <td><strong>Nama Lengkap</strong></td>
                            <td>: <?= esc($pelanggan['nama_lengkap']) ?></td>
                        </tr>
                        <tr>
                            <td><strong>Nomor Telepon</strong></td>
                            <td>: <?= esc($pelanggan['no_telpon']) ?></td>
                        </tr>
                        <tr>
                            <td><strong>Email</strong></td>
                            <td>: <?= esc($pelanggan['email']) ?></td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <h5>Detail Pendaftaran</h5>
                     <table class="table table-borderless">
                        <tr>
                            <td style="width: 150px;"><strong>ID Survey</strong></td>
                            <td>: <?= esc($pelanggan['id_survey'] ?: '-') ?></td>
                        </tr>
                        <tr>
                            <td><strong>ID Sewa</strong></td>
                            <td>: <?= esc($pelanggan['id_namasewa'] ?: '-') ?></td>
                        </tr>
                        <tr>
                            <td><strong>Tanggal Survey</strong></td>
                            <td>: <?= esc(date('d F Y', strtotime($pelanggan['tanggal_survey']))) ?></td>
                        </tr>
                        <tr>
                            <td class="align-top"><strong>Alamat Lengkap</strong></td>
                            <td class="align-top">: <?= esc($pelanggan['lokasi_survey']) ?></td>
                        </tr>
                    </table>
                </div>
            </div>
            <hr>
            <div class="text-end mt-3">
                <a href="<?= base_url('admin/pelanggan/edit/' . $pelanggan['id_pelanggan']) ?>" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Edit Data Ini
                </a>
            </div>
        <?php else: ?>
            <div class="alert alert-warning" role="alert">
                Data pelanggan tidak ditemukan atau tidak valid.
            </div>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>