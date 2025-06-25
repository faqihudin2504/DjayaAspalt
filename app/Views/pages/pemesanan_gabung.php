<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <h5><strong>Pemesanan Jasa & Barang</strong></h5>

    <form action="<?= base_url('pemesanan-jasa/simpan') ?>" method="post">
        <h6 class="mt-4">🔎 Data Survey / Cek Lokasi</h6>
        <div class="mb-3"><input name="nama" class="form-control" placeholder="Nama Lengkap" required></div>
        <div class="mb-3"><input name="telepon" class="form-control" placeholder="No. Telepon" required></div>
        <div class="row mb-3">
            <div class="col"><input type="date" name="tanggal_survey" class="form-control" required></div>
            <div class="col"><input type="time" name="jam_survey" class="form-control" required></div>
        </div>
        <div class="mb-3"><textarea name="alamat_survey" class="form-control" rows="2" placeholder="Alamat Survey" required></textarea></div>

        <hr>
        <h6 class="mt-4">📆 Data Pelaksanaan</h6>
        <div class="row mb-3">
            <div class="col"><input type="date" name="tanggal_pelaksanaan" class="form-control" required></div>
            <div class="col"><input type="time" name="jam_pelaksanaan" class="form-control" required></div>
        </div>
        <div class="mb-3"><textarea name="alamat_pelaksanaan" class="form-control" rows="2" placeholder="Alamat Pelaksanaan" required></textarea></div>
        <label class="d-block mb-2">Waktu Pengerjaan</label>
        <?php foreach (['3 Hari', '7 Hari', '14 Hari', '21 Hari', '1 Bulan', 'Sampai Selesai'] as $durasi): ?>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="durasi" value="<?= $durasi ?>" required>
                <label class="form-check-label"><?= $durasi ?></label>
            </div>
        <?php endforeach ?>

        <div class="mt-4">
            <button type="submit" class="btn btn-success">Konfirmasi</button>
        </div>
    </form>
</div>

<?= $this->endSection() ?>
