<?= $this->extend('layout/submenu_layout') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="m-0"><?= esc($page_title) ?></h4>
    <a href="<?= base_url('admin/alat/tambah') ?>" class="btn btn-success">Tambahkan Material Baru</a>
</div>

<style>
    .horizontal-scroll-wrapper {
        display: flex;
        overflow-x: auto;
        padding-bottom: 1rem;
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
    .horizontal-scroll-wrapper::-webkit-scrollbar {
        display: none;
    }
    .card-item {
        flex: 0 0 280px;
        margin-right: 1.5rem;
        white-space: normal;
    }
    .admin-card {
        background: white; 
        border-radius: 10px; 
        padding: 15px;
        text-align: center; 
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .admin-card img {
        height: 150px;
        width: 100%;
        object-fit: cover;
    }
    .admin-card h6 {
        font-weight: 600;
        margin-top: 1rem;
    }
    .admin-card .btn {
        font-size: 0.8rem;
        padding: 4px 10px;
        margin: 0 2px;
    }
</style>

<div class="horizontal-scroll-wrapper">
    <?php if (empty($material_list)): ?>
        <div class="col-12">
            <div class="alert alert-warning text-center">
                Belum ada data Material. Silakan klik tombol "Tambahkan Material Baru" di atas.
            </div>
        </div>
    <?php else: ?>
        <?php foreach($material_list as $material): ?>
            <div class="card-item">
                <div class="admin-card">
                    <img src="<?= base_url('uploads/alat/' . ($material['gambar_alat'] ?: 'default.png')) ?>" class="img-fluid rounded mb-3" alt="<?= esc($material['nama_alat']) ?>">
                    <div>
                        <h6 class="fw-bold"><?= esc($material['nama_alat']) ?></h6>
                        <p class="mb-2">Stok: <span class="fw-bold"><?= esc($material['stok_alat']) ?> ton</span></p>
                        <div>
                             <a href="<?= base_url('admin/alat/edit/' . $material['id_alat']) ?>" class="btn btn-dark btn-sm">Edit</a>
                             <a href="<?= base_url('admin/alat/hapus/' . $material['id_alat']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus item ini?')">Hapus</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>