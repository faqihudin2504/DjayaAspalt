<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Djaya Aspalt</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; background-color: #f8f9fc; }
        .login-container { max-width: 400px; width: 100%; padding: 2rem; background: white; border-radius: 0.5rem; box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15); text-align: center; }
        .login-container h1 { font-size: 1.5rem; margin-bottom: 1.5rem; color: #4e73df; }
        .form-group { margin-bottom: 1rem; }
        .form-control { display: block; width: 100%; padding: 0.75rem 1rem; font-size: 1rem; line-height: 1.5; color: #6e707e; background-color: #fff; background-clip: padding-box; border: 1px solid #d1d3e2; border-radius: 0.35rem; transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out; box-sizing: border-box; }
        .form-control:focus { color: #6e707e; background-color: #fff; border-color: #80bdff; outline: 0; box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25); }
        .btn-primary { width: 100%; padding: 0.75rem; border: none; background-color: #4e73df; color: white; border-radius: 0.35rem; font-size: 1rem; cursor: pointer; transition: background-color .15s ease-in-out; }
        .btn-primary:hover { background-color: #2e59d9; }
        .error-message { color: #e74a3b; font-size: 0.875em; margin-top: -0.5rem; margin-bottom: 1rem; text-align: left; }
        .success-message { color: #1cc88a; margin-bottom: 1rem; }
        .small { font-size: 80%; }
        a { color: #4e73df; text-decoration: none; }
        hr { margin-top: 1rem; margin-bottom: 1rem; border: 0; border-top: 1px solid rgba(0, 0, 0, 0.1); }
    </style>
</head>

<body>

    <div class="login-container">
        <h1>Login ke DJAYA ASPALT</h1>

        <?php if (session()->getFlashdata('error')) : ?>
            <div style="color: #e74a3b; background-color: #fbebe9; border: 1px solid #f5c6cb; padding: .75rem 1.25rem; margin-bottom: 1rem; border-radius: .35rem; text-align: center;">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>
        
        <?php if (session()->getFlashdata('success')) : ?>
            <div style="color: #155724; background-color: #d4edda; border: 1px solid #c3e6cb; padding: .75rem 1.25rem; margin-bottom: 1rem; border-radius: .35rem; text-align: center;">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <form class="user" action="<?= base_url('login') ?>" method="post">
            <?= csrf_field() ?>
            
            <div class="form-group">
                <input type="email" class="form-control" name="username" placeholder="Masukkan Alamat Email..." value="<?= old('username') ?>" required>
            </div>
            
            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Password" required>
            </div>
            
            <button type="submit" class="btn-primary">
                Login
            </button>
        </form>

        <hr>
        
        <div class="text-center">
            <a class="small" href="<?= base_url('register') ?>">Belum punya akun? Buat Akun!</a>
        </div>
    </div>

</body>

</html>