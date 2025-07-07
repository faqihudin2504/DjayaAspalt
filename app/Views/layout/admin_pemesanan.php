<?php 
// File: app/Views/layout/admin_pemesanan.php (Versi Final)
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemesanan - Djaya Aspalt Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #f8f9fa; }
        .main-wrapper { display: flex; min-height: 100vh; }
        .sub-sidebar {
            width: 250px;
            background-color: #ffffff;
            padding: 1.5rem;
            border-right: 1px solid #dee2e6;
            flex-shrink: 0;
        }
        .sidebar-header a {
            display: flex;
            align-items: center;
            text-decoration: none;
            color: black;
            margin-bottom: 1.5rem;
        }
        .sidebar-header img {
            width: 32px;
            height: 32px;
            margin-right: 10px;
        }
        .sidebar-header h4 {
            margin: 0;
            font-weight: 600;
        }
        .sub-sidebar .nav-link {
            color: #555;
            font-weight: 500;
            padding: 0.75rem;
            border-left: 3px solid transparent;
            border-radius: 0 5px 5px 0;
        }
        .sub-sidebar .nav-link.active, .sub-sidebar .nav-link:hover {
            color: #4361ee;
            background-color: #eef2ff;
            border-left-color: #4361ee;
        }
        .content-wrapper { flex-grow: 1; display: flex; flex-direction: column; }
        .topbar {
            background-color: #ffffff;
            padding: 1rem 2rem;
            border-bottom: 1px solid #dee2e6;
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 70px;
        }
        .main-content { padding: 2rem; background-color: #FFDAB9; flex-grow: 1; }
    </style>
</head>
<body>
    <div class="main-wrapper">
        <div class="sub-sidebar">
            <div class="sidebar-header">
                <a href="<?= base_url('admin') ?>">
                    <img src="<?= base_url('assets/Back-01.png') ?>" alt="Back">
                    <h4>Data Pemesanan</h4>
                </a>
            </div>

            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link <?= (uri_string() == 'admin/cek-paket') ? 'active' : '' ?>" href="<?= base_url('admin/cek-paket') ?>">Cek Paket</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= (strpos(uri_string(), 'admin/alat') !== false) ? 'active' : '' ?>" href="<?= base_url('admin/alat') ?>">Manajemen Alat</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= (strpos(uri_string(), 'admin/cek-pekerja') !== false) ? 'active' : '' ?>" href="<?= base_url('admin/cek-pekerja') ?>">Cek Pekerja</a>
                </li>
            </ul>
        </div>

        <div class="content-wrapper">
            <div class="topbar">
                <div class="search-container w-50"><input class="form-control" type="search" placeholder="Cari..."></div>
                <div class="topbar-profile">
                </div>
            </div>
            <div class="main-content">
                <?= $this->renderSection('content') ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <?= $this->include('layout/partials/modal_script') ?>
</body>
</html>