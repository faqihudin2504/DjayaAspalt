<?= $this->extend('layout/admin_kosong') ?>
<?= $this->section('content') ?>

<h4><?= esc($page_title) ?></h4>
<hr>
<form action="<?= base_url('admin/survey/update/' . $survey['id_survey']) ?>" method="post">
    <?= csrf_field() ?>

    <div class="mb-3">
        <label for="id_pelanggan" class="form-label">Pilih Pelanggan</label>
        <select name="id_pelanggan" id="id_pelanggan" class="form-select" required>
            <option value="">-- Pilih Pelanggan --</option>
            <?php foreach ($pelanggan_list as $pelanggan): ?>
                <option value="<?= $pelanggan['id_pelanggan'] ?>" <?= ($pelanggan['id_pelanggan'] == $survey['id_pelanggan']) ? 'selected' : '' ?>>
                    <?= esc($pelanggan['nama_lengkap']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="mb-3">
        <label for="alamat_survey" class="form-label">Alamat Lengkap Survey</label>
        <textarea name="alamat_survey" id="alamat_survey" rows="3" class="form-control" required><?= esc($survey['alamat_survey']) ?></textarea>
    </div>

    <div class="mb-3">
        <label for="tanggal_survey" class="form-label">Tanggal & Waktu Survey</label>
        <input type="datetime-local" name="tanggal_survey" id="tanggal_survey" class="form-control" value="<?= esc(date('Y-m-d\TH:i', strtotime($survey['tanggal_survey']))) ?>" required>
    </div>

    <div class="mb-3">
        <label for="status" class="form-label">Status</label>
        <select name="status" id="status" class="form-select" required>
            <option value="Dijadwalkan" <?= ($survey['status'] == 'Dijadwalkan') ? 'selected' : '' ?>>Dijadwalkan</option>
            <option value="Selesai" <?= ($survey['status'] == 'Selesai') ? 'selected' : '' ?>>Selesai</option>
            <option value="Dibatalkan" <?= ($survey['status'] == 'Dibatalkan') ? 'selected' : '' ?>>Dibatalkan</option>
        </select>
    </div>

    <div class="d-flex justify-content-end">
        <a href="<?= base_url('admin/survey') ?>" class="btn btn-secondary me-2">Batal</a>
        <button type="submit" class="btn btn-primary">Update Jadwal Survey</button>
    </div>
</form>

<?= $this->endSection() ?>