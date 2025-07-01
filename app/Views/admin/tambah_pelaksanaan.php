<?= $this->extend('layout/admin_kosong') ?>

<?= $this->section('content') ?>

<h4 class="mb-4 fw-bold">Tambah Data Pelaksanaan</h4>

<div class="card shadow-sm">
    <div class="card-body">
        <form action="<?= base_url('admin/pelaksanaan/simpan') ?>" method="post">
            <?= csrf_field() ?>

            <div class="mb-3">
                <label for="id_pelanggan" class="form-label">Pilih Pelanggan</label>
                <select class="form-control" name="id_pelanggan" id="id_pelanggan" required>
                    <option value="">-- Pilih Nama Klien --</option>
                    <?php if (!empty($pelanggan_list)): ?>
                        <?php foreach($pelanggan_list as $pelanggan): ?>
                            <option value="<?= esc($pelanggan['id_pelanggan']) ?>">
                                <?= esc($pelanggan['nama_lengkap']) ?> (ID: <?= esc($pelanggan['id_pelanggan']) ?>)
                            </option>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <option value="" disabled>Tidak ada data pelanggan tersedia</option>
                    <?php endif; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="tanggal_pelaksanaan" class="form-label">Tanggal Pelaksanaan</label>
                <input type="datetime-local" class="form-control" id="tanggal_pelaksanaan" name="tanggal_pelaksanaan" required>
            </div>
            <div class="mb-3">
                <label for="alamat_pelaksanaan" class="form-label">Alamat Pelaksanaan</label>
                <textarea class="form-control" id="alamat_pelaksanaan" name="alamat_pelaksanaan" rows="3" required></textarea>
            </div>
            <div class="mb-3">
                <label for="waktu_pengerjaan" class="form-label">Waktu Pengerjaan</label>
                <input type="text" class="form-control" id="waktu_pengerjaan" name="waktu_pengerjaan" placeholder="Contoh: 7 hari" required>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="<?= base_url('admin/pelaksanaan') ?>" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>