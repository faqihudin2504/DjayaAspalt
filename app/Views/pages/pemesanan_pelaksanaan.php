<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <h5><strong>Pilih Pelaksanaan</strong></h5>
    <p>Mohon isi untuk waktu pelaksanaan</p>

    <form action="<?= base_url('pemesanan-jasa/simpan') ?>" method="post">
        <div class="row mb-3">
            <div class="col-md-4">
                <label>Tanggal</label>
                <input type="date" name="tanggal_pelaksanaan" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label>Jam</label>
                <input type="time" name="jam_pelaksanaan" class="form-control" required>
            </div>
        </div>

        <div class="mb-3">
            <label>Alamat</label>
            <textarea name="alamat_pelaksanaan" class="form-control" rows="3" required></textarea>
        </div>

        <div class="mb-3">
            <label>Waktu Pengerjaan</label><br>
            <?php foreach (['3 Hari', '7 Hari', '14 Hari', '21 Hari', '1 Bulan', 'Sampai Selesai'] as $durasi): ?>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="durasi" value="<?= $durasi ?>" required>
                    <label class="form-check-label"><?= $durasi ?></label>
                </div>
            <?php endforeach ?>
        </div>

        <button type="submit" class="btn btn-success">Konfirmasi</button>
    </form>
</div>

<?= $this->endSection() ?>
