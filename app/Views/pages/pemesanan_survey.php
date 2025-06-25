<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <h5><strong>Halo, Kamu Ingin Melakukan Pemesanan?</strong></h5>
    <p>Mohon isi dahulu sebelum melakukan pemesanan</p>

    <form action="<?= base_url('pemesanan-jasa/simpan') ?>" method="post">
        <div class="mb-3">
            <label>Nama Lengkap</label>
            <input type="text" name="nama" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>No. Telepon</label>
            <input type="text" name="telepon" class="form-control" required>
        </div>

        <hr>
        <p><strong>Pilih Waktu Untuk Survey/Mengecek Tempat Anda</strong></p>
        <p class="text-muted">Dilakukannya survey, untuk melihat barang apa saja yang anda butuhkan</p>

        <div class="row mb-3">
            <div class="col-md-4">
                <label>Tanggal</label>
                <input type="date" name="tanggal_survey" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label>Jam</label>
                <input type="time" name="jam_survey" class="form-control" required>
            </div>
        </div>

        <div class="mb-3">
            <label>Alamat</label>
            <textarea name="alamat_survey" class="form-control" rows="3" required></textarea>
        </div>

        <button type="submit" class="btn btn-success">Konfirmasi</button>
    </form>
</div>

<?= $this->endSection() ?>
