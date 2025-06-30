<?= $this->extend('layout/admin_cek_main') ?>
<?= $this->section('content') ?>
<div class="row">
    <?php if (empty($material_list)): ?>
        <div class="col-12 text-center p-5">
            <h5 class="text-danger">Belum ada data Material.</h5>
        </div>
    <?php else: ?>
        <?php foreach($material_list as $material): ?>
            <div class="col-lg-4 col-md-6 col-12 mb-4">
                <div class="admin-card h-100">
                    <img src="<?= base_url('uploads/alat/' . ($material['gambar_alat'] ?: 'default.png')) ?>" class="img-fluid rounded mb-3" style="height: 180px; object-fit: cover;" alt="<?= esc($material['nama_alat']) ?>">
                    <h6 class="fw-bold"><?= esc($material['nama_alat']) ?></h6>
                    <p class="mb-2">Stok: <span class="fw-bold fs-5"><?= esc($material['stok_alat']) ?> ton</span></p>
                    <div>
                         <a href="<?= base_url('admin/alat/edit/' . $material['id_alat']) ?>" class="btn btn-dark btn-sm">Edit</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>