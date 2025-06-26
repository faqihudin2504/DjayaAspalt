<?= $this->extend('layout/admin_kosong') ?>

<?= $this->section('content') ?>

<h4 class="mb-4 fw-bold">Tambah Data Penyewaan</h4>

<div class="card shadow-sm">
    <div class="card-body">
        <form action="<?= base_url('admin/penyewaan/simpan') ?>" method="post">
            <?= csrf_field() ?>

            <div class="mb-3">
                <label for="id_namasewa" class="form-label fw-bold">Pilih Pelanggan Penyewa</label>
                <select class="form-control" name="id_namasewa" id="id_namasewa" required>
                    <option value="">-- Pilih Nama Pelanggan --</option>
                    <?php if (!empty($pelanggan_list)): ?>
                        <?php foreach($pelanggan_list as $pelanggan): ?>
                            <option value="<?= esc($pelanggan['id_pelanggan']) ?>" <?= set_select('id_namasewa', $pelanggan['id_pelanggan']) ?>>
                                <?= esc($pelanggan['nama_lengkap']) ?> (ID: <?= esc($pelanggan['id_pelanggan']) ?>)
                            </option>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <option value="" disabled>Tidak ada data pelanggan tersedia</option>
                    <?php endif; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="id_alat" class="form-label fw-bold">ID Alat</label>
                <input type="text" class="form-control" name="id_alat" id="id_alat" value="<?= set_value('id_alat') ?>" placeholder="Masukkan ID Alat yang disewa" required>
            </div>
            
            <div class="mb-3">
                <label for="alamat_penyewa" class="form-label fw-bold">Alamat Pengiriman Alat</label>
                <textarea class="form-control" name="alamat_penyewa" id="alamat_penyewa" rows="3" placeholder="Masukkan alamat pengiriman alat" required><?= set_value('alamat_penyewa') ?></textarea>
            </div>

            <div class="mb-3">
                <label for="tanggal_penyewaan" class="form-label fw-bold">Tanggal Penyewaan</label>
                <input type="date" class="form-control" name="tanggal_penyewaan" id="tanggal_penyewaan" value="<?= set_value('tanggal_penyewaan', date('Y-m-d')) ?>" required>
            </div>

            <div class="mb-3">
                <label for="harga_alatdisewa" class="form-label fw-bold">Harga Sewa (Rp)</label>
                <input type="number" class="form-control" name="harga_alatdisewa" id="harga_alatdisewa" value="<?= set_value('harga_alatdisewa') ?>" placeholder="Masukkan angka saja, contoh: 500000" required>
            </div>
            
            <div class="mb-3">
                <label for="status" class="form-label fw-bold">Status</label>
                <select class="form-control" name="status" id="status" required>
                    <option value="Booking" <?= set_select('status', 'Booking', true) ?>>Booking</option>
                    <option value="Disewa" <?= set_select('status', 'Disewa') ?>>Disewa</option>
                    <option value="Selesai" <?= set_select('status', 'Selesai') ?>>Selesai</option>
                    <option value="Batal" <?= set_select('status', 'Batal') ?>>Batal</option>
                </select>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Simpan Data Penyewaan</button>
                <a href="<?= base_url('admin/penyewaan') ?>" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>