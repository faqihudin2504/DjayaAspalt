<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Pilih Jenis Pendaftaran - Djaya Aspalt</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: url("<?= base_url('assets/bg.jpg') ?>") no-repeat center center fixed;
      background-size: cover;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      font-family: 'Poppins', sans-serif;
    }
    .choice-card {
        background-color: rgba(255, 255, 255, 0.95);
        border-radius: 15px;
        border: none;
        box-shadow: 0 5px 15px rgba(0,0,0,.2);
        padding: 30px;
    }
    .option-box {
        border: 2px solid #eee;
        border-radius: 10px;
        padding: 20px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        color: #333;
        display: block;
    }
    .option-box:hover {
        border-color: #4361ee;
        background-color: #f7f9ff;
        transform: translateY(-5px);
    }
    .option-box img {
        width: 90px;
        margin-bottom: 15px;
    }
    .option-box p {
        font-weight: 600;
        margin-bottom: 0;
    }
  </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="choice-card">
                <div class="text-center mb-4">
                    <h4 class="fw-bold">Pilih Jenis Akun</h4>
                    <p class="text-muted">Anda ingin mendaftar sebagai apa?</p>
                </div>
                <div class="row">
                    <div class="col-6">
                        <a href="<?= base_url('register/customer') ?>" class="option-box">
                            <img src="<?= base_url('assets/pelanggan_icon.png') ?>" alt="Pelanggan">
                            <p>Pelanggan</p>
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="<?= base_url('register/admin') ?>" class="option-box">
                            <img src="<?= base_url('assets/admin_icon.png') ?>" alt="Admin">
                            <p>Admin</p>
                        </a>
                    </div>
                </div>
                <div class="text-center mt-4">
                    <a href="<?= base_url('login') ?>">Sudah punya akun? Login di sini</a>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>