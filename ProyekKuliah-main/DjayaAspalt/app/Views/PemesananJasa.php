<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .form-container {
            background-color: white;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            margin-top: 30px;
        }
        .form-title {
            color: #333;
            margin-bottom: 20px;
            font-weight: 600;
        }
        .form-subtitle {
            color: #666;
            margin-bottom: 25px;
            font-size: 0.9rem;
        }
        .form-control {
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 15px;
        }
        .btn-confirm {
            background-color: #0d6efd;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            width: 100%;
            font-weight: 500;
        }
        .date-time-input {
            display: flex;
            gap: 10px;
        }
        .date-time-input select {
            flex: 1;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="form-container">
                    <h4 class="form-title">Halo, Kamu Ingin Melakukan Pemesanan?</h4>
                    <p class="form-subtitle">Mohon diisi dahulu sebelum melakukan pemesanan</p>

                    <?php if(session()->getFlashdata('pesan')): ?>
                        <div class="alert alert-success"><?= session()->getFlashdata('pesan') ?></div>
                    <?php endif; ?>

                    <form action="/pemesanan-jasa/simpan" method="post">
                        <?= csrf_field() ?>
                        
                        <div class="mb-3">
                            <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control <?= (session()->getFlashdata('errors')['nama_lengkap'] ?? false) ? 'is-invalid' : '' ?>" 
                                   id="nama_lengkap" name="nama_lengkap" value="<?= old('nama_lengkap') ?>">
                            <?php if(session()->getFlashdata('errors')['nama_lengkap'] ?? false): ?>
                                <div class="invalid-feedback">
                                    <?= session()->getFlashdata('errors')['nama_lengkap'] ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label for="no_telepon" class="form-label">No. Telepon</label>
                            <input type="text" class="form-control <?= (session()->getFlashdata('errors')['no_telepon'] ?? false) ? 'is-invalid' : '' ?>" 
                                   id="no_telepon" name="no_telepon" value="<?= old('no_telepon') ?>">
                            <?php if(session()->getFlashdata('errors')['no_telepon'] ?? false): ?>
                                <div class="invalid-feedback">
                                    <?= session()->getFlashdata('errors')['no_telepon'] ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <hr>

                        <h5 class="form-title">Pilih Waktu Untuk Survey/Mengecek Tempat Anda</h5>
                        <p class="form-subtitle">Dilakukannya survey, untuk melihat barang apa saja yang anda butuhkan</p>

                        <div class="mb-3">
                            <label class="form-label">Tanggal & Waktu</label>
                            <div class="date-time-input">
                                <select class="form-control" name="tanggal">
                                    <option value="12">12</option>
                                    <!-- Add more days as needed -->
                                </select>
                                <select class="form-control" name="bulan">
                                    <option value="2024">2024</option>
                                    <!-- Add more months/years as needed -->
                                </select>
                                <select class="form-control" name="waktu">
                                    <option value="07:00 WIB">07:00 WIB</option>
                                    <!-- Add more times as needed -->
                                </select>
                            </div>
                            <input type="hidden" id="tanggal_waktu" name="tanggal_waktu">
                        </div>

                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea class="form-control <?= (session()->getFlashdata('errors')['alamat'] ?? false) ? 'is-invalid' : '' ?>" 
                                      id="alamat" name="alamat" rows="3"><?= old('alamat') ?></textarea>
                            <?php if(session()->getFlashdata('errors')['alamat'] ?? false): ?>
                                <div class="invalid-feedback">
                                    <?= session()->getFlashdata('errors')['alamat'] ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <button type="submit" class="btn-confirm">konfirmasi</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Combine date, month and time into a single field before form submission
        document.querySelector('form').addEventListener('submit', function(e) {
            const tanggal = document.querySelector('select[name="tanggal"]').value;
            const bulan = document.querySelector('select[name="bulan"]').value;
            const waktu = document.querySelector('select[name="waktu"]').value;
            
            document.getElementById('tanggal_waktu').value = `${tanggal} ${bulan} ${waktu}`;
        });
    </script>
</body>
</html>