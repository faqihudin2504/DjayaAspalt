<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Login DJAYA ASPALT</title>
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
        padding: 30px;
        text-align: center;
    }
    .btn-google {
        background-color: #4285F4;
        color: white;
        border: none;
        padding: 10px;
        border-radius: 5px;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }
    .btn-google img {
        width: 20px;
        height: 20px;
    }
  </style>
</head>
<body>

<div class="modal fade show" id="loginFormModalStatic" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="display: block;">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Login ke DJAYA ASPALT</h5>
        </div>
      <div class="modal-body">
          <img src="<?= base_url('assets/logo.png') ?>" alt="Logo" width="180px" class="mb-3">
          <h5 class="fw-bold mb-3">Login</h5>
          <button class="btn btn-google mb-3"><img src="https://upload.wikimedia.org/wikipedia/commons/4/4a/Logo_2013_Google.png" alt="Google"> Sign in with Google</button>
          <p>Or</p>
          <form action="<?= base_url('login') ?>" method="post">
              <input type="hidden" name="login_type" value="<?= esc($login_type ?? 'customer') ?>" id="loginTypeHiddenInput">
              <div class="mb-3">
                  <input type="email" class="form-control" name="username" placeholder="Email" required>
              </div>
              <div class="mb-3">
                  <input type="password" class="form-control" name="password" placeholder="Password" required>
              </div>
              <button type="submit" class="btn btn-primary w-100">LOGIN</button>
          </form>
          <div class="mt-3 d-flex justify-content-between">
              <a href="<?= base_url('register') ?>" class="text-decoration-none">< REGISTER</a>
              <a href="#" class="text-decoration-none">Don't remember password?</a>
          </div>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var myModal = new bootstrap.Modal(document.getElementById('loginFormModalStatic'));
        myModal.show();

        // Pesan error dari flashdata
        <?php if (session()->getFlashdata('error')): ?>
            alert('<?= session()->getFlashdata('error') ?>');
        <?php endif; ?>
    });
</script>
</body>
</html>