<?= $this->extend('layout/admin_alat') ?>

<?= $this->section('content') ?>
<style>
    /* Common styles */
    .view-toggle-buttons .btn { border: 1px solid #ccc; }
    .view-toggle-buttons .btn.active { background-color: #343a40; color: white; }
    .table thead th { background-color: #343a40; color: white; text-align: center; vertical-align: middle; }
    .table tbody td { text-align: center; vertical-align: middle; }
    .action-buttons .btn { margin: 0 2px; }
    .empty-state { padding: 4rem; text-align: center; } 
    .empty-state img { max-width: 150px; margin-bottom: 1.5rem; }
    .alat-img-thumbnail { width: 80px; height: 80px; object-fit: cover; border-radius: 5px; }
    
    /* Grid view specific styles */
    .grid-card { background: white; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); height: 100%; display: flex; flex-direction: column; }
    .grid-card img { height: 180px; width: 100%; object-fit: cover; border-top-left-radius: 10px; border-top-right-radius: 10px; }
    .grid-card .card-body { display: flex; flex-direction: column; justify-content: space-between; flex-grow: 1; padding: 1rem; }
    .grid-card h6 { font-weight: 600; margin-top: 0.5rem; }
    .grid-card .stok-info { font-size: 0.9rem; margin-bottom: 1rem; }
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold m-0"><?= esc($page_title ?? 'Manajemen Alat & Material') ?></h4>
    <div>
        <div class="btn-group view-toggle-buttons me-2" role="group">
            <button type="button" class="btn btn-light" id="btn-list-view" title="List View"><i class="fas fa-list"></i></button>
            <button type="button" class="btn btn-light" id="btn-grid-view" title="Grid View"><i class="fas fa-th-large"></i></button>
        </div>
        <a href="<?= base_url('admin/alat/tambah') ?>" class="btn btn-success">Tambahkan Data Baru</a>
    </div>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div id="listView">
    <div class="card shadow-sm">
        <div class="card-body table-responsive p-0">
            <table class="table table-bordered table-striped table-hover mb-0">
                <thead>
                    <tr>
                        <th>Gambar</th>
                        <th>ID</th>
                        <th>Nama Alat/Material</th>
                        <th>Kategori</th>
                        <th>Status</th>
                        <th>Stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($alat_list)): ?>
                        <tr>
                            <td colspan="7" class="empty-state">
                                <img src="<?= base_url('assets/table_cat_animated.gif') ?>" alt="Tidak Ada Data">
                                <p class="text-danger mt-3">Tidak ada data untuk ditampilkan.</p>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($alat_list as $alat): ?>
                            <tr>
                                <td><img src="<?= base_url('uploads/alat/' . ($alat['gambar_alat'] ?: 'default.png')) ?>" alt="<?= esc($alat['nama_alat']) ?>" class="alat-img-thumbnail"></td>
                                <td><?= esc($alat['id_alat']) ?></td>
                                <td class="text-start"><?= esc($alat['nama_alat']) ?></td>
                                <td><span class="badge bg-secondary"><?= esc($alat['kategori']) ?></span></td>
                                <td>
                                    <?php $status = esc($alat['cek_alat']); $badge_class = 'bg-secondary';
                                        if ($status == 'Tersedia') $badge_class = 'bg-success';
                                        if ($status == 'Disewa') $badge_class = 'bg-warning text-dark';
                                        if ($status == 'Perbaikan') $badge_class = 'bg-danger';
                                    ?><span class="badge <?= $badge_class ?>"><?= $status ?></span>
                                </td>
                                <td>
                                    <?= esc($alat['stok_alat']) ?> <?= ($alat['kategori'] === 'Material') ? 'ton' : 'unit' ?>
                                </td>
                                <td class="action-buttons">
                                    <a href="<?= base_url('admin/alat/edit/' . $alat['id_alat']) ?>" class="btn btn-warning btn-sm">Ubah</a>
                                    <a href="<?= base_url('admin/alat/hapus/' . $alat['id_alat']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Anda yakin ingin menghapus item ini?')">Hapus</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="gridView" style="display: none;">
    <div class="row">
        <?php if (empty($alat_list)): ?>
            <div class="col-12 empty-state">
                 <img src="<?= base_url('assets/table_cat_animated.gif') ?>" alt="Tidak Ada Data">
                <p class="text-danger mt-3">Tidak ada data untuk ditampilkan.</p>
            </div>
        <?php else: ?>
            <?php foreach($alat_list as $alat): ?>
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="grid-card">
                        <img src="<?= base_url('uploads/alat/' . ($alat['gambar_alat'] ?: 'default.png')) ?>" alt="<?= esc($alat['nama_alat']) ?>">
                        <div class="card-body">
                            <div>
                                <h6 class="fw-bold"><?= esc($alat['nama_alat']) ?></h6>
                                <p class="stok-info">Stok: <span class="fw-bold"><?= esc($alat['stok_alat']) ?> <?= ($alat['kategori'] === 'Material') ? 'ton' : 'unit' ?></span></p>
                            </div>
                            <div class="action-buttons mt-auto">
                                <a href="<?= base_url('admin/alat/edit/' . $alat['id_alat']) ?>" class="btn btn-warning btn-sm w-100 mb-1">Edit</a>
                                <a href="<?= base_url('admin/alat/hapus/' . $alat['id_alat']) ?>" class="btn btn-danger btn-sm w-100" onclick="return confirm('Yakin ingin menghapus item ini?')">Hapus</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const btnListView = document.getElementById('btn-list-view');
    const btnGridView = document.getElementById('btn-grid-view');
    const listView = document.getElementById('listView');
    const gridView = document.getElementById('gridView');

    // Fungsi untuk mengubah view
    function setView(view) {
        if (view === 'grid') {
            gridView.style.display = 'block';
            listView.style.display = 'none';
            btnGridView.classList.add('active');
            btnListView.classList.remove('active');
            localStorage.setItem('alatView', 'grid');
        } else {
            listView.style.display = 'block';
            gridView.style.display = 'none';
            btnListView.classList.add('active');
            btnGridView.classList.remove('active');
            localStorage.setItem('alatView', 'list');
        }
    }

    // Event listeners untuk tombol
    btnListView.addEventListener('click', () => setView('list'));
    btnGridView.addEventListener('click', () => setView('grid'));

    // Cek preferensi view dari localStorage saat halaman dimuat
    const savedView = localStorage.getItem('alatView') || 'list'; // Default ke list view
    setView(savedView);
});
</script>
<?= $this->endSection() ?>