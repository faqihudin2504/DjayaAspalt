<?php 
// File: app/Views/layout/admin_pelaksanaan.php 
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pelaksanaan - Djaya Aspalt Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #F0F2F5; }
        .admin-wrapper { display: flex; }
        .admin-sidebar {
            width: 250px; min-height: 100vh; background-color: #ffffff;
            padding-top: 1.5rem; position: fixed; height: 100%;
            border-right: 1px solid #e0e0e0;
        }
        .sidebar-header { padding: 0 1.5rem; margin-bottom: 2rem; }
        .sidebar-header a { text-decoration: none; color: black; display: flex; align-items: center; }
        .sidebar-header img { width: 32px; height: 32px; margin-right: 10px; }
        .sidebar-header h5 { margin: 0; font-weight: 600; }
        .sidebar-menu { flex-grow: 1; } /* Dibiarkan untuk menjaga struktur */
        .admin-main-content-wrapper { margin-left: 250px; width: calc(100% - 250px); }
        .admin-topbar {
            background-color: #ffffff; padding: 1rem 2rem; border-bottom: 1px solid #e0e0e0;
            display: flex; justify-content: space-between; align-items: center; height: 70px;
        }
        .search-container { position: relative; width: 50%; }
        .search-container input { width: 100%; padding: 8px 15px 8px 40px; border-radius: 20px; border: 1px solid #ccc; background-color: #f5f5f5; }
        .topbar-profile a { text-decoration: none; color: #0d6efd; font-weight: 500; }
        .admin-main-content { padding: 2rem; background-color: #FFDAB9; min-height: calc(100vh - 70px); }
    </style>
</head>
<body>
    <div class="admin-wrapper">
        <div class="admin-sidebar">
            <div class="sidebar-header">
                <a href="<?= base_url('admin') ?>">
                    <img src="<?= base_url('assets/Back-01.png') ?>" alt="Back">
                    <h5>Kembali ke Home</h5>
                </a>
            </div>
            <div class="sidebar-menu">
                </div>
        </div>
        <div class="admin-main-content-wrapper">
            <div class="admin-topbar">
                <div class="search-container">
                    <input class="form-control" type="search" placeholder="Cari...">
                </div>
                <div class="topbar-profile"><a href="#">Foto Profil</a></div>
            </div>
            <div class="admin-main-content">
                <?= $this->renderSection('content') ?>
            </div>
        </div>
    </div>
</body>
</html>