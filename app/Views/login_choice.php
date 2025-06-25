<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Pilih Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: url("<?= base_url('assets/bg.jpg') ?>") no-repeat center center fixed;
      background-size: cover;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
    }
    .modal-content {
        border-radius: 15px;
        border: none;
        box-shadow: 0 5px 15px rgba(0,0,0,.3);
    }
    .modal-body {
        text-align: center;
        padding: 40px;
    }
    .login-option {
        border: 1px solid #ddd;
        border-radius: 10px;
        padding: 20px;
        margin: 10px;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    .login-option:hover {
        background-color: #f0f0f0;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    .login-option img {
        width: 80px;
        margin-bottom: 10px;
    }
  </style>
</head>
<body>

<div class="modal fade show" id="loginChoiceModalStatic" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="display: block;">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Anda ingin login sebagai apa?</h5>
        </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-6">
            <a href="<?= base_url('login/customer') ?>" class="text-decoration-none text-dark">
              <div class="login-option">
                <img src="<?= base_url('assets/pelanggan_icon.png') ?>" alt="Pelanggan">
                <p class="fw-bold">Pelanggan</p>
              </div>
            </a>
          </div>
          <div class="col-6">
            <a href="<?= base_url('login/admin') ?>" class="text-decoration-none text-dark">
              <div class="login-option">
                <img src="<?= base_url('assets/admin_icon.png') ?>" alt="Admin">
                <p class="fw-bold">Admin</p>
              </div>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var myModal = new bootstrap.Modal(document.getElementById('loginChoiceModalStatic'));
        myModal.show();
    });
</script>
</body>
</html>