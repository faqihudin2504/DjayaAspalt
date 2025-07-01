<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Djaya Aspalt Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #F0F2F5; }
        .admin-wrapper { display: flex; }
        .admin-sidebar {
            width: 250px; min-height: 100vh; background-color: #ffffff;
            padding-top: 1.5rem; position: fixed; height: 100%;
            overflow-y: auto; display: flex; flex-direction: column;
            border-right: 1px solid #e0e0e0;
        }
        .sidebar-header { padding: 0 1.5rem; margin-bottom: 2rem; display: flex; align-items: center;}
        .sidebar-header img { width: 40px; margin-right: 10px; }
        .sidebar-header h5 { margin: 0; font-weight: 600; }
        .sidebar-menu { flex-grow: 1; }
        .sidebar-menu a { display: block; padding: 12px 1.5rem; color: #555; text-decoration: none; font-weight: 500; border-left: 3px solid transparent; transition: all 0.2s ease; }
        .sidebar-menu a.active, .sidebar-menu a:hover { background-color: #eef2ff; color: #4361ee; border-left-color: #4361ee; }
        .admin-main-content-wrapper { margin-left: 250px; width: calc(100% - 250px); }
        .admin-topbar { background-color: #ffffff; padding: 1rem 2rem; border-bottom: 1px solid #e0e0e0; display: flex; justify-content: space-between; align-items: center; height: 70px; }
        .search-container { position: relative; width: 50%; }
        .search-container input { width: 100%; padding: 8px 15px 8px 40px; border-radius: 20px; border: 1px solid #ccc; background-color: #f5f5f5; }
        .topbar-profile .dropdown-toggle::after { display: none; }
        .topbar-profile .profile-pic { width: 38px; height: 38px; object-fit: cover; border: 2px solid #ddd; }
        .topbar-profile .dropdown-menu { 
            width: 300px;
            border-radius: .75rem; 
            border: 1px solid #e9ecef;
            padding: 0.5rem;
        }
        .dropdown-profile-header {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
        }
        .dropdown-profile-header .user-info {
            line-height: 1.3;
            margin-left: 1rem;
        }
        .dropdown-profile-header .user-info small {
            color: #6c757d;
        }
        .dropdown-menu .dropdown-item {
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
        }
        .admin-main-content { padding: 2rem; background-color: #FFDAB9; min-height: calc(100vh - 70px); }
    </style>
</head>
<body>
    <div class="admin-wrapper">
        <div class="admin-sidebar">
            <div class="sidebar-header">
                <img src="<?= base_url('assets/logo_djaya_aspalt.png') ?>" alt="Logo">
                <h5>DJAYA ASPALT</h5>
            </div>
            <div class="sidebar-menu">
                <a href="<?= base_url('admin') ?>" class="<?= (uri_string() == 'admin') ? 'active' : '' ?>">Home</a>
                <a href="<?= base_url('admin/pelanggan') ?>" class="<?= (strpos(uri_string(), 'admin/pelanggan') !== false) ? 'active' : '' ?>">Pelanggan</a>
                <a href="<?= base_url('admin/penyewaan') ?>" class="<?= (strpos(uri_string(), 'admin/penyewaan') !== false) ? 'active' : '' ?>">Penyewaan</a>
                <a href="<?= base_url('admin/survey') ?>" class="<?= (strpos(uri_string(), 'admin/survey') !== false) ? 'active' : '' ?>">Survey</a>
                <a href="<?= base_url('admin/pemesanan') ?>" class="<?= (strpos(uri_string(), 'admin/pemesanan') !== false) ? 'active' : '' ?>">Pemesanan</a>
                
                <a href="<?= base_url('admin/alat-berat') ?>" class="<?= (strpos(uri_string(), 'admin/alat-berat') !== false) ? 'active' : '' ?>">Alat Berat</a>
                <a href="<?= base_url('admin/material') ?>" class="<?= (strpos(uri_string(), 'admin/material') !== false) ? 'active' : '' ?>">Material</a>
                
                <a href="<?= base_url('admin/pembayaran/pemesanan') ?>" class="<?= (strpos(uri_string(), 'admin/pembayaran') !== false) ? 'active' : '' ?>">Pembayaran</a>
                <a href="<?= base_url('admin/pengembalian') ?>" class="<?= (strpos(uri_string(), 'admin/pengembalian') !== false) ? 'active' : '' ?>">Pengembalian</a>
            </div>
        </div>
        <div class="admin-main-content-wrapper">
            <div class="admin-topbar">
                <div class="search-container"><input class="form-control" type="search" placeholder="Cari..."></div>
                
                <div class="topbar-profile dropdown">
                    <a href="#" class="d-flex align-items-center link-dark text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="<?= (session()->get('foto_profil')) ? base_url('uploads/avatars/' . session()->get('foto_profil')) : base_url('assets/admin_profile_pic.png') ?>" alt="foto profil" class="rounded-circle profile-pic">
                        <span class="ms-2"><?= esc(session()->get('nama_lengkap') ?? 'Admin') ?></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end text-small shadow" aria-labelledby="dropdownUser1">
                        <li>
                            <div class="dropdown-profile-header">
                                <img src="<?= (session()->get('foto_profil')) ? base_url('uploads/avatars/' . session()->get('foto_profil')) : base_url('assets/admin_profile_pic.png') ?>" alt="foto profil" class="rounded-circle" width="50" height="50">
                                <div class="user-info">
                                    <strong class="d-block text-truncate"><?= esc(session()->get('nama_lengkap') ?? 'Admin') ?></strong>
                                    <small class="text-truncate"><?= esc(session()->get('email')) ?></small>
                                </div>
                            </div>
                        </li>
                        <li><hr class="dropdown-divider my-1"></li>
                        <li><a class="dropdown-item" href="<?= base_url('admin/profile') ?>">Informasi Akun</a></li>
                        <li><a class="dropdown-item text-danger" href="<?= base_url('logout') ?>">Logout</a></li>
                    </ul>
                </div>

            </div>
            <div class="admin-main-content">
                <?= $this->renderSection('content') ?>
            </div>
        </div>
    </div>

    <script>
    // PASTE SEMUA KODE JAVASCRIPT DARI LANGKAH 1 DI SINI
    </script>
</body>
</html>