<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Djaya Aspalt Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <style>
    body { font-family: 'Segoe UI', sans-serif; background-color: #f8f9fa; }
    .sidebar {
      width: 200px;
      min-height: 100vh;
      background-color: #ffffff;
      border-right: 1px solid #dee2e6;
      padding-top: 1rem;
      position: fixed; 
      height: 100%;
      overflow-y: auto; 
    }
    .sidebar a {
      display: block;
      padding: 10px 15px;
      color: #000;
      text-decoration: none;
    }
    .sidebar a:hover {
      background-color: #f1f1f1;
      padding-left: 20px;
      transition: 0.2s;
    }
    .main-content-wrapper {
      margin-left: 200px; 
      flex-grow: 1;
    }
    .topbar {
      background-color: #f8f9fa;
      padding: 12px 20px;
      border-bottom: 1px solid #dee2e6;
      display: flex;
      justify-content: space-between; 
      align-items: center;
    }
    .topbar .search-box {
      width: 550px; 
      margin: 0 auto; 
    }
    .topbar input { width: 100%; font-size: 14px; }
    .topbar .icon-group {
        display: flex;
        gap: 15px; 
        align-items: center;
    }
    .topbar .icon-group img {
        cursor: pointer;
        width: 30px; 
        height: auto;
    }
    .topbar .profile-pic {
        width: 45px;
        height: 45px;
        object-fit: cover;
    }
    .main-content { padding: 30px; }

    /* Gaya untuk modal */
    .modal-backdrop.show { opacity: .5; }
    .modal-content {
        border-radius: 15px;
        border: none;
        box-shadow: 0 5px 15px rgba(0,0,0,.3);
    }
    .modal-header { border-bottom: none; }
    .modal-footer { border-top: none; }
    
    /* Gaya khusus untuk dropdown profil */
    .profile-dropdown .dropdown-toggle::after {
        display: none; /* Sembunyikan panah bawaan */
    }
    .profile-dropdown .dropdown-menu {
        width: 280px;
        border-radius: 15px;
        box-shadow: 0 0.5rem 1rem rgba(0,0,0,.15);
        padding: 1rem;
        border: none;
    }
    .profile-dropdown .dropdown-header {
        display: flex;
        align-items: center;
        margin-bottom: 1rem;
    }
    .profile-dropdown .dropdown-header img {
        width: 50px;
        height: 50px;
        object-fit: cover;
        margin-right: 15px;
    }
    .profile-dropdown .dropdown-header .user-info {
        font-size: 0.9rem;
        line-height: 1.2;
    }
     .profile-dropdown .dropdown-header .user-info span {
        color: #6c757d;
    }
    .profile-dropdown .dropdown-item {
        padding: 0.75rem 1rem;
        border-radius: 8px;
    }
  </style>
</head>
<body>

  <div class="d-flex">
    <div class="sidebar">
      <div class="text-center mb-4">
        <img src="<?= base_url('assets/logoSamping1.png') ?>" width="140" alt="Logo">
      </div>
      <a href="<?= base_url('dashboard') ?>">🏠 Home</a>
      <a href="<?= base_url('gallery') ?>">🖼️ Gallery</a>
      <a href="<?= base_url('hubungi-kami') ?>">📞 Hubungi Kami</a>
      <a href="<?= base_url('artikel') ?>">📄 Artikel</a>
      <a href="<?= base_url('bantuan') ?>">❓ Bantuan</a>

      <?php if (session()->get('logged_in')): ?>
        <a href="<?= base_url('profile-perusahaan') ?>">👤 Profile Perusahaan</a>
        <a href="<?= base_url('pemesanan') ?>">📦 Pemesanan</a>
        <a href="<?= base_url('penyewaan-barang') ?>">🏗️ Penyewaan</a>
        <a href="<?= base_url('keranjang') ?>">🛒 Keranjang</a>
        <a href="<?= base_url('logout') ?>" class="text-danger">🚪 Logout</a>
      <?php endif; ?>
    </div>

    <div class="main-content-wrapper">
      <div class="topbar">
        <div class="search-box">
          <input class="form-control" type="search" name="q" placeholder="Cari nama...">
        </div>
        <div class="icon-group">
            <a href="javascript:history.back()">
                <img src="<?= base_url('assets/Back-01.png') ?>" width="43" alt="Back">
            </a>
            <a href="<?= base_url('keranjang') ?>">
                <img src="<?= base_url('assets/Keranjang.png') ?>" width="22" alt="Cart">
            </a>
            
            <?php if (session()->get('logged_in')): ?>
                <div class="dropdown profile-dropdown">
                    <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="<?= (session()->get('foto_profil')) ? base_url('uploads/avatars/' . session()->get('foto_profil')) : base_url('assets/Profil-01.png') ?>" alt="Profile" class="rounded-circle profile-pic">
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <div class="dropdown-header">
                                <img src="<?= (session()->get('foto_profil')) ? base_url('uploads/avatars/' . session()->get('foto_profil')) : base_url('assets/Profil-01.png') ?>" alt="Profile" class="rounded-circle">
                                <div class="user-info">
                                    <strong class="d-block text-truncate"><?= esc(session()->get('nama_lengkap') ?? 'Pelanggan') ?></strong>
                                    <span class="text-truncate"><?= esc(session()->get('email') ?? 'email@anda.com') ?></span>
                                </div>
                            </div>
                        </li>
                        <li><a class="dropdown-item" href="<?= base_url('customer-profile') ?>">Informasi Akun</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="<?= base_url('logout') ?>">Keluar Akun</a></li>
                    </ul>
                </div>
            <?php else: ?>
                <img src="<?= base_url('assets/Profil-01.png') ?>" width="45" alt="Login" id="loginOrProfileIcon" class="rounded-circle profile-pic">
            <?php endif; ?>
            </div>
      </div>
      
      <div class="main-content">
        <?= $this->renderSection('content') ?>
      </div>
    </div>
  </div>

  <?php if (!session()->get('logged_in')): ?>
    <div class="modal fade login-form-modal" id="loginFormModal" tabindex="-1" aria-labelledby="loginFormModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="loginFormModalLabel">Login ke DJAYA ASPALT</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body text-center">
              <img src="<?= base_url('assets/logo.png') ?>" alt="Logo" width="180px" class="mb-3">
              <h5 class="fw-bold mb-3">Login</h5>
              <div id="loginErrorAlert" class="alert alert-danger" style="display:none;"></div>
              <form action="<?= base_url('login') ?>" method="post">
                  <div class="mb-3">
                      <input type="text" class="form-control" name="username" placeholder="Username atau Email" required>
                  </div>
                  <div class="mb-3">
                      <input type="password" class="form-control" name="password" placeholder="Password" required>
                  </div>
                  <button type="submit" class="btn btn-primary w-100">LOGIN</button>
              </form>
              <div class="mt-3 d-flex justify-content-between">
                  <a href="#" id="redirectToRegister" class="text-decoration-none">&lt; REGISTER</a>
                  <a href="#" class="text-decoration-none">Don't remember password?</a>
              </div>
          </div>
        </div>
      </div>
    </div>

    <script>
      document.addEventListener('DOMContentLoaded', function() {
          const loginOrProfileIcon = document.getElementById('loginOrProfileIcon');
          
          if (loginOrProfileIcon) {
              const loginModal = new bootstrap.Modal(document.getElementById('loginFormModal'));
              loginOrProfileIcon.addEventListener('click', function() {
                  loginModal.show();
              });
          }
      });
    </script>
  <?php endif; ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>