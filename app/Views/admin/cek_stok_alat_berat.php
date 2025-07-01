<?= $this->extend('layout/submenu_layout') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="m-0"><?= esc($page_title) ?></h4>
    <a href="<?= base_url('admin/alat/tambah') ?>" class="btn btn-success">Tambahkan Alat Baru</a>
</div>

<div class="row">
    <?php if (empty($alat_list)): ?>
        <div class="col-12">
            <div class="alert alert-warning text-center">
                Belum ada data Alat Berat. Silakan klik tombol "Tambahkan Alat Baru" di atas.
            </div>
        </div>
    <?php else: ?>
        <?php foreach($alat_list as $alat): ?>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card shadow-sm h-100">
                    <img src="<?= base_url('uploads/alat/' . ($alat['gambar_alat'] ?: 'default.png')) ?>" class="card-img-top" style="height: 200px; object-fit: cover;" alt="<?= esc($alat['nama_alat']) ?>">
                    <div class="card-body text-center d-flex flex-column">
                        <h5 class="card-title fw-bold"><?= esc($alat['nama_alat']) ?></h5>
                        <p class="card-text">Stok: <span class="fw-bold fs-5"><?= esc($alat['stok_alat']) ?></span></p>
                        <div class="mt-auto">
                            <a href="<?= base_url('admin/alat/edit/' . $alat['id_alat']) ?>" class="btn btn-dark btn-sm">Edit</a>
                            <a href="<?= base_url('admin/alat/hapus/' . $alat['id_alat']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus item ini?')">Hapus</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>