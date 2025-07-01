<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Loading DJAYA ASPALT</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: url("<?= base_url('assets/bg.jpg') ?>") no-repeat center center fixed;
      background-size: cover;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      color: white; /* Warna teks agar terlihat di background */
      text-shadow: 2px 2px 4px rgba(0,0,0,0.5); /* Efek bayangan teks */
    }
    .splash-content {
        text-align: center;
        background-color: rgba(255, 255, 255, 0.8); /* Background putih sedikit transparan */
        padding: 40px;
        border-radius: 15px;
        box-shadow: 0 0 20px rgba(0,0,0,0.3);
    }
    .splash-content img {
        width: 250px;
        margin-bottom: 20px;
    }
    .spinner-border {
        color: #dc3545; /* Warna spinner */
    }
  </style>
</head>
<body>

<div class="splash-content">
  <img src="<?= base_url('assets/logo.png') ?>" alt="Logo DJAYA ASPALT">
  <h3>Loading...</h3>
  <div class="spinner-border text-primary" role="status">
    <span class="visually-hidden">Loading...</span>
  </div>
</div>

<script>
  // Redirect ke halaman dashboard setelah beberapa detik
  setTimeout(function() {
    window.location.href = '<?= base_url('dashboard') ?>';
  }, 100); // Redirect setelah 0.1 detik
</script>

</body>
</html>