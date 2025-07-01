<?= $this->extend('layout/admin_pelaksanaan') ?>

<?= $this->section('content') ?>

<div class="container py-4">
    <div class="d-flex align-items-center mb-4">
        <a href="<?= base_url('admin/pelaksanaan') ?>" class="me-3">
            <img src="<?= base_url('assets/Back-01.png') ?>" width="43" alt="Back">
        </a>
        <h2 class="mb-0">Edit Data Pelaksanaan</h2>
    </div>

    <div class="card p-4 shadow-sm">
        <form action="<?= base_url('admin/pelaksanaan/update/' . $pelaksanaan['id_pelaksanaan']) ?>" method="post">
            <?= csrf_field() ?>
            <input type="hidden" name="id_pelaksanaan" value="<?= esc($pelaksanaan['id_pelaksanaan']) ?>">

            <div class="mb-3">
                <label for="id_pelanggan" class="form-label">Pilih Pelanggan</label>
                <select class="form-control" id="id_pelanggan" name="id_pelanggan" required>
                    <option value="">-- Pilih Nama Klien --</option>
                    <?php if (!empty($pelanggan_list)): ?>
                        <?php foreach($pelanggan_list as $pelanggan): ?>
                            <option value="<?= esc($pelanggan['id_pelanggan']) ?>" <?= ($pelanggan['id_pelanggan'] == $pelaksanaan['id_pelanggan']) ? 'selected' : '' ?>>
                                <?= esc($pelanggan['nama_lengkap']) ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="tanggal_pelaksanaan" class="form-label">Tanggal Pelaksanaan</label>
                <input type="datetime-local" class="form-control" id="tanggal_pelaksanaan" name="tanggal_pelaksanaan" value="<?= esc(date('Y-m-d\TH:i', strtotime($pelaksanaan['tanggal_pelaksanaan']))) ?>" required>
            </div>
            <div class="mb-3">
                <label for="alamat_pelaksanaan" class="form-label">Alamat Pelaksanaan</label>
                <textarea class="form-control" id="alamat_pelaksanaan" name="alamat_pelaksanaan" rows="3" required><?= esc($pelaksanaan['alamat_pelaksanaan']) ?></textarea>
            </div>
            <div class="mb-3">
                <label for="waktu_pengerjaan" class="form-label">Waktu Pengerjaan</label>
                <input type="text" class="form-control" id="waktu_pengerjaan" name="waktu_pengerjaan" value="<?= esc($pelaksanaan['waktu_pengerjaan']) ?>" required>
            </div>
            
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="<?= base_url('admin/pelaksanaan') ?>" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>

<?= $this->endSection() ?>