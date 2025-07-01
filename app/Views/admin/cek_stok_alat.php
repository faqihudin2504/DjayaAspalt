<?= $this->extend('layout/admin_cek_main') ?>
<?= $this->section('content') ?>
<div class="row">
    <?php if (empty($alat_list)): ?>
        <div class="col-12 text-center p-5">
            <h5 class="text-danger">Belum ada data alat.</h5>
        </div>
    <?php else: ?>
        <?php foreach($alat_list as $alat): ?>
            <div class="col-md-3 col-6 mb-4">
                <div class="admin-card h-100">
                    <img src="<?= base_url('uploads/alat/' . ($alat['gambar_alat'] ?: 'default.png')) ?>" class="img-fluid rounded mb-3" style="height: 150px; object-fit: cover;">
                    <h6 class="fw-bold"><?= esc($alat['nama_alat']) ?></h6>
                    <p class="mb-2">Stok: <span class="fw-bold fs-5 <?= $alat['stok_alat'] > 0 ? 'text-success' : 'text-danger' ?>"><?= esc($alat['stok_alat']) ?></span></p>
                    <div>
                        <a href="<?= base_url('admin/alat/edit/' . $alat['id_alat']) ?>" class="btn btn-dark btn-sm">Edit Stok</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>