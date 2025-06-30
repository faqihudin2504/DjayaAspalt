<?= $this->extend('layout/admin_kosong') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold m-0">Manajemen Survey</h4>
    <a href="<?= base_url('admin/survey/tambah') ?>" class="btn btn-success">Tambahkan Survey Baru</a>
</div>

<?php if (empty($survey_per_bulan)): ?>
    <div class="card"><div class="card-body text-center p-5"><h5>Tidak Ada Data Survey Terjadwal</h5></div></div>
<?php else: ?>
    <?php foreach ($survey_per_bulan as $bulan => $items): ?>
    <div class="card card-revisi mb-4">
        <div class="card-header">Data Survey bulan <?= $bulan ?></div>
        <div class="card-body table-responsive p-0">
            <table class="table table-bordered table-striped mb-0">
                <thead>
                    <tr>
                        <th>Pelanggan</th>
                        <th>No. Telpon</th>
                        <th>Alamat Survey</th>
                        <th>Jadwal</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $item): ?>
                        <tr>
                            <td><?= esc($item['nama_lengkap']) ?></td>
                            <td><?= esc($item['no_telpon']) ?></td>
                            <td class="text-start"><?= esc($item['alamat_survey']) ?></td>
                            <td><?= date('d M Y, H:i', strtotime($item['tanggal_survey'])) ?></td>
                            <td><span class="badge bg-info"><?= esc($item['status']) ?></span></td>
                            <td>
                                <a href="<?= base_url('admin/survey/edit/' . $item['id_survey']) ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="<?= base_url('admin/survey/hapus/' . $item['id_survey']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus jadwal survey ini?')">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php endforeach; ?>
<?php endif; ?>

<?= $this->endSection() ?>