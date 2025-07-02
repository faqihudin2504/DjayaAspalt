<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($page_title ?? 'Admin - Djaya Aspalt') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #F0F2F5; }
        .main-wrapper { display: flex; min-height: 100vh; }
        .sub-sidebar { width: 250px; background-color: #ffffff; padding: 1.5rem; border-right: 1px solid #dee2e6; flex-shrink: 0; }
        .sidebar-back-button { display: flex; align-items: center; text-decoration: none; color: black; margin-bottom: 1.5rem; }
        .sidebar-back-button img { width: 32px; height: 32px; margin-right: 10px; }
        .sidebar-back-button h5 { margin: 0; font-weight: 600; font-size: 1.25rem; }
        .sub-sidebar .nav-link { color: #555; font-weight: 500; padding: 0.75rem; border-left: 3px solid transparent; }
        .sub-sidebar .nav-link:hover, .sub-sidebar .nav-link.active { color: #0d6efd; border-left-color: #0d6efd; }
        .content-wrapper { flex-grow: 1; display: flex; flex-direction: column; }
        .admin-topbar { background-color: #ffffff; padding: 1rem 2rem; border-bottom: 1px solid #e0e0e0; display: flex; justify-content: space-between; align-items: center; height: 70px; }
        .search-container { position: relative; width: 50%; }
        .search-container input { width: 100%; padding: 8px 15px 8px 40px; border-radius: 20px; border: 1px solid #ccc; background-color: #f5f5f5; }
        .topbar-profile .dropdown-toggle::after { display: none; }
        .topbar-profile .profile-pic { width: 38px; height: 38px; object-fit: cover; border: 2px solid #ddd; }
        .topbar-profile .dropdown-menu { width: 300px; border-radius: .75rem; border: 1px solid #e9ecef; padding: 0.5rem; }
        .dropdown-profile-header { display: flex; align-items: center; padding: 0.75rem 1rem; }
        .dropdown-profile-header .user-info { line-height: 1.3; margin-left: 1rem; }
        .dropdown-profile-header .user-info small { color: #6c757d; }
        .dropdown-menu .dropdown-item { padding: 0.75rem 1rem; border-radius: 0.5rem; }
        .main-content { padding: 2rem; background-color: #FFDAB9; flex-grow: 1; }
    </style>
</head>
<body>
    <div class="main-wrapper">
        <div class="sub-sidebar">
            <a href="javascript:history.back()" class="sidebar-back-button">
                <img src="<?= base_url('assets/Back-01.png') ?>" alt="Back">
                <h5><?= esc($page_title ?? 'Kembali') ?></h5>
            </a>
            <ul class="nav flex-column">
                <li class="nav-item"><a class="nav-link" href="<?= base_url('admin/cek-paket') ?>">Cek Paket</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= base_url('admin/cek-stok/alat-berat') ?>">Cek Stok Alat</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= base_url('admin/cek-stok/material') ?>">Cek Stok Material</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= base_url('admin/cek-pekerja') ?>">Cek Pekerja</a></li>
            </ul>
        </div>
        <div class="content-wrapper">
            <div class="admin-topbar">
                <div class="search-container"><input class="form-control" type="search" placeholder="Cari..."></div>
                <div class="topbar-profile dropdown">
                    <a href="#" class="d-flex align-items-center link-dark text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="<?= (session()->get('foto_profil')) ? base_url('uploads/avatars/' . session()->get('foto_profil')) : base_url('assets/admin_profile_pic.png') ?>" alt="foto profil" class="rounded-circle profile-pic">
                        <span class="ms-2"><?= esc(session()->get('nama_lengkap') ?? 'Admin') ?></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end text-small shadow" aria-labelledby="dropdownUser1">
                        <li><div class="dropdown-profile-header"><img src="<?= (session()->get('foto_profil')) ? base_url('uploads/avatars/' . session()->get('foto_profil')) : base_url('assets/admin_profile_pic.png') ?>" alt="foto profil" class="rounded-circle" width="50" height="50"><div class="user-info"><strong class="d-block text-truncate"><?= esc(session()->get('nama_lengkap') ?? 'Admin') ?></strong><small class="text-truncate"><?= esc(session()->get('email')) ?></small></div></div></li>
                        <li><hr class="dropdown-divider my-1"></li>
                        <li><a class="dropdown-item" href="<?= base_url('admin/profile') ?>">Informasi Akun</a></li>
                        <li><a class="dropdown-item text-danger" href="<?= base_url('logout') ?>">Logout</a></li>
                    </ul>
                </div>
            </div>
            <div class="main-content">
                <?= $this->renderSection('content') ?>
            </div>
        </div>
    </div>

    <div class="modal fade" id="confirmDeleteModal" tabindex="-1"><div class="modal-dialog modal-dialog-centered"><div class="modal-content"><div class="modal-header"><h5 class="modal-title">Konfirmasi Penghapusan</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div><div class="modal-body">Apakah Anda yakin ingin menghapus data ini? Proses ini tidak bisa dibatalkan.</div><div class="modal-footer"><button type="button" class="btn btn-primary" data-bs-dismiss="modal">Batal</button><a href="#" id="confirmDeleteButton" class="btn btn-danger">Ya, Hapus</a></div></div></div></div>
    <div class="modal fade" id="errorModal" tabindex="-1"><div class="modal-dialog modal-dialog-centered"><div class="modal-content"><div class="modal-header bg-danger text-white"><h5 class="modal-title">Gagal Menghapus</h5><button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button></div><div class="modal-body">Data ini tidak bisa dihapus karena terhubung dengan data transaksi lain.<br><br><small class="text-muted">Untuk bisa menghapusnya, Anda perlu menghapus data transaksi yang terhubung terlebih dahulu.</small></div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Mengerti</button></div></div></div></div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var cdm = document.getElementById('confirmDeleteModal');
        if(cdm) { cdm.addEventListener('show.bs.modal', function(e) { document.getElementById('confirmDeleteButton').setAttribute('href', e.relatedTarget.getAttribute('data-url')); }); }
        <?php if (session()->getFlashdata('show_error_modal')): ?> new bootstrap.Modal(document.getElementById('errorModal')).show(); <?php endif; ?>
    });
    </script>
</body>
</html>