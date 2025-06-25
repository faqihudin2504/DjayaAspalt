<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>DJAYA ASPALT</title>
  <link rel="icon" href="<?= base_url('logo.png') ?>">
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background: url('<?= base_url('assets/images/background.png') ?>') no-repeat center center fixed;
      background-size: cover;
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
    }

    .login-card {
      background-color: rgba(255, 255, 255, 0.95);
      border-radius: 16px;
      padding: 40px 30px;
      width: 420px;
      box-shadow: 0 0 30px rgba(0, 0, 0, 0.15);
      text-align: center;
    }

    .login-card img.logo-full {
      width: 100%;
      max-width: 320px;
      margin-bottom: 20px;
    }

    .login-card input[type="text"],
    .login-card input[type="password"] {
      width: 100%;
      padding: 12px;
      margin: 10px 0;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 14px;
    }

    .login-card button {
      width: 100%;
      padding: 12px;
      background-color: #e63946;
      color: white;
      border: none;
      font-size: 16px;
      border-radius: 8px;
      cursor: pointer;
      margin-top: 10px;
    }

    .login-card button:hover {
      background-color: #d62828;
    }

    .copyright {
      margin-top: 20px;
      font-size: 12px;
      color: #888;
    }
  </style>
</head>
<body>
  <div class="login-card">
    <!-- Ganti logo di bawah ini dengan gambar full (logo + teks) -->
    <img src="<?= base_url('logo.png') ?>" alt="DJAYA ASPALT Logo" class="logo-full">

    <form action="<?= base_url('login') ?>" method="post">
      <input type="text" name="username" placeholder="Username" required>
      <input type="password" name="password" placeholder="Password" required>
      <button type="submit">Masuk</button>
    </form>

    <div class="copyright">&copy; <?= date('Y') ?> DJAYA ASPALT</div>
  </div>
</body>
</html>
