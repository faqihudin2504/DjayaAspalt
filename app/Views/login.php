<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Djaya Aspalt</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
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
        .login-card {
            background-color: rgba(255, 255, 255, 0.97);
            border-radius: 15px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
            width: 100%;
            max-width: 450px;
            overflow: hidden;
        }
        .login-header {
            background-color: #343a40;
            color: white;
            padding: 1rem;
            text-align: center;
        }
        .login-header h5 {
            margin: 0;
            font-weight: 600;
        }
        .login-body {
            padding: 2rem;
            text-align: center;
        }
        .login-body .logo {
            width: 120px;
            height: 120px;
            object-fit: contain;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>

<div class="login-card">
    <div class="login-header">
        <h5 class="modal-title">Login ke DJAYA ASPALT</h5>
    </div>
    <div class="login-body">
        <img src="<?= base_url('assets/logo.png') ?>" alt="Logo" class="logo">
        
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success py-2 small"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger py-2 small"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <form action="<?= base_url('login') ?>" method="post">
            <?= csrf_field() ?>
            <div class="mb-3">
                <input type="text" class="form-control" name="username" placeholder="Username atau Email" required>
            </div>
            <div class="mb-3">
                <input type="password" class="form-control" name="password" placeholder="Password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">LOGIN</button>
        </form>
        <hr>
        <div class="text-center">
            <a href="<?= base_url('register') ?>" class="text-decoration-none">Belum punya akun? Buat Akun</a>
        </div>
    </div>
</div>

</body>
</html>