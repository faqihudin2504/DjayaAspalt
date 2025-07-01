<?= $this->extend('layout/admin_kosong') ?>
<?= $this->section('content') ?>

<h4><?= esc($page_title) ?></h4>
<hr>
<form action="<?= base_url('admin/survey/simpan') ?>" method="post">
    <?= csrf_field() ?>

    <div class="mb-3">
        <label for="id_pelanggan" class="form-label">Pilih Pelanggan</label>
        <select name="id_pelanggan" id="id_pelanggan" class="form-select" required>
            <option value="">-- Pilih Pelanggan --</option>
            <?php foreach ($pelanggan_list as $pelanggan): ?>
                <option value="<?= $pelanggan['id_pelanggan'] ?>"><?= esc($pelanggan['nama_lengkap']) ?></option>
            <?php endforeach; ?>
        </select>
        <small>Jika pelanggan belum ada, <a href="<?= base_url('admin/pelanggan/tambah') ?>" target="_blank">tambahkan di sini dulu</a>.</small>
    </div>

    <div class="mb-3">
        <label for="alamat_survey" class="form-label">Alamat Lengkap Survey</label>
        <textarea name="alamat_survey" id="alamat_survey" rows="3" class="form-control" required><?= old('alamat_survey') ?></textarea>
    </div>

    <div class="mb-3">
        <label for="tanggal_survey" class="form-label">Tanggal & Waktu Survey</label>
        <input type="datetime-local" name="tanggal_survey" id="tanggal_survey" class="form-control" value="<?= old('tanggal_survey') ?>" required>
    </div>

    <div class="d-flex justify-content-end">
        <a href="<?= base_url('admin/survey') ?>" class="btn btn-secondary me-2">Batal</a>
        <button type="submit" class="btn btn-primary">Simpan Jadwal Survey</button>
    </div>
</form>

<?= $this->endSection() ?>