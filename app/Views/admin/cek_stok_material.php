<?= $this->extend('layout/admin_pemesanan') ?>

<?= $this->section('content') ?>
<style>
    .horizontal-scroll-wrapper {
        overflow-x: auto;
        white-space: nowrap;
        padding-bottom: 1rem;
    }
    .horizontal-scroll-wrapper > .card-item {
        display: inline-block;
        width: 300px; /* Lebar setiap kartu */
        margin-right: 1.5rem;
        vertical-align: top;
        white-space: normal;
    }
</style>

<div class="horizontal-scroll-wrapper">
    <?php if (empty($material_list)): ?>
        <div class="col-12 text-center p-5 bg-white rounded">
            <h5 class="text-danger">Belum ada data Material.</h5>
        </div>
    <?php else: ?>
        <?php foreach($material_list as $material): ?>
            <div class="card-item">
                <div class="admin-card h-100">
                    <img src="<?= base_url('uploads/alat/' . ($material['gambar_alat'] ?: 'default.png')) ?>" class="img-fluid rounded mb-3" style="height: 180px; width: 100%; object-fit: cover;" alt="<?= esc($material['nama_alat']) ?>">
                    <h6 class="fw-bold"><?= esc($material['nama_alat']) ?></h6>
                    <p class="mb-2">Stok: <span class="fw-bold fs-5"><?= esc($material['stok_alat']) ?> ton</span></p>
                    <div>
                         <button class="btn btn-success btn-sm">Tambahkan</button>
                         <a href="<?= base_url('admin/alat/edit/' . $material['id_alat']) ?>" class="btn btn-dark btn-sm">Edit</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>