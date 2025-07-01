<?= $this->extend('layout/admin_kosong') ?>

<?= $this->section('content') ?>

<h4 class="mb-4 fw-bold">Edit Data Penyewaan</h4>

<div class="card shadow-sm">
    <div class="card-body">
        <form action="<?= base_url('admin/penyewaan/update/' . $penyewaan['id_sewa']) ?>" method="post">
            <?= csrf_field() ?>

            <div class="mb-3">
                <label for="id_namasewa" class="form-label fw-bold">Pilih Pelanggan Penyewa</label>
                <select class="form-control" name="id_namasewa" id="id_namasewa" required>
                    <?php foreach($pelanggan_list as $pelanggan): ?>
                        <option value="<?= esc($pelanggan['id_pelanggan']) ?>" <?= ($pelanggan['id_pelanggan'] == $penyewaan['id_namasewa']) ? 'selected' : '' ?>>
                            <?= esc($pelanggan['nama_lengkap']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="id_alat" class="form-label fw-bold">Pilih Alat</label>
                <select class="form-control" name="id_alat" id="id_alat" required>
                     <?php foreach($alat_list as $alat): ?>
                        <option value="<?= esc($alat['id_alat']) ?>" <?= ($alat['id_alat'] == $penyewaan['id_alat']) ? 'selected' : '' ?>>
                            <?= esc($alat['nama_alat']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="mb-3">
                <label for="alamat_penyewa" class="form-label fw-bold">Alamat Pengiriman Alat</label>
                <textarea class="form-control" name="alamat_penyewa" id="alamat_penyewa" rows="3" required><?= esc($penyewaan['alamat_penyewa']) ?></textarea>
            </div>

            <div class="mb-3">
                <label for="tanggal_penyewaan" class="form-label fw-bold">Tanggal Penyewaan</label>
                <input type="date" class="form-control" name="tanggal_penyewaan" id="tanggal_penyewaan" value="<?= esc($penyewaan['tanggal_penyewaan']) ?>" required>
            </div>

            <div class="mb-3">
                <label for="harga_alatdisewa" class="form-label fw-bold">Harga Sewa (Rp)</label>
                <input type="number" class="form-control" name="harga_alatdisewa" id="harga_alatdisewa" value="<?= esc($penyewaan['harga_alatdisewa']) ?>" required>
            </div>
            
            <div class="mb-3">
                <label for="status" class="form-label fw-bold">Status</label>
                <select class="form-control" name="status" id="status" required>
                    <option value="Booking" <?= ($penyewaan['status'] == 'Booking') ? 'selected' : '' ?>>Booking</option>
                    <option value="Disewa" <?= ($penyewaan['status'] == 'Disewa') ? 'selected' : '' ?>>Disewa</option>
                    <option value="Selesai" <?= ($penyewaan['status'] == 'Selesai') ? 'selected' : '' ?>>Selesai</option>
                    <option value="Batal" <?= ($penyewaan['status'] == 'Batal') ? 'selected' : '' ?>>Batal</option>
                </select>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Update Data</button>
                <a href="<?= base_url('admin/penyewaan') ?>" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>