<?= $this->extend('layout/admin_kosong') ?>

<?= $this->section('content') ?>

<h4 class="mb-4 fw-bold">Edit Data Penyewaan</h4>

<div class="card shadow-sm">
    <div class="card-body">
        <form action="<?= base_url('admin/penyewaan/update/' . $penyewaan['id_sewa']) ?>" method="post">
            <?= csrf_field() ?>
            
            <div class="mb-3">
                <label for="id_sewa" class="form-label">ID Sewa</label>
                <input type="text" class="form-control" value="<?= esc($penyewaan['id_sewa']) ?>" readonly>
            </div>

            <div class="mb-3">
                <label for="id_pelanggan" class="form-label">Pilih Pelanggan Penyewa</label>
                <select class="form-control" name="id_pelanggan" id="id_pelanggan" required>
                    <option value="">-- Pilih Nama Pelanggan --</option>
                    <?php if (!empty($pelanggan_list)): ?>
                        <?php foreach($pelanggan_list as $pelanggan): ?>
                            <option value="<?= esc($pelanggan['id_pelanggan']) ?>" <?= ($pelanggan['id_pelanggan'] == $penyewaan['id_pelanggan']) ? 'selected' : '' ?>>
                                <?= esc($pelanggan['nama_lengkap']) ?> (ID: <?= esc($pelanggan['id_pelanggan']) ?>)
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="tanggal_penyewaan" class="form-label">Tanggal Penyewaan</label>
                <input type="date" class="form-control" id="tanggal_penyewaan" name="tanggal_penyewaan" value="<?= esc($penyewaan['tanggal_penyewaan']) ?>" required>
            </div>

            <div class="mb-3">
                <label for="total_harga" class="form-label">Total Harga (Rp)</label>
                <input type="number" class="form-control" name="total_harga" id="total_harga" value="<?= esc($penyewaan['total_harga']) ?>" required>
            </div>
            
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-control" name="status" id="status" required>
                    <option value="Disewa" <?= ($penyewaan['status'] == 'Disewa') ? 'selected' : '' ?>>Disewa</option>
                    <option value="Selesai" <?= ($penyewaan['status'] == 'Selesai') ? 'selected' : '' ?>>Selesai</option>
                    <option value="Booking" <?= ($penyewaan['status'] == 'Booking') ? 'selected' : '' ?>>Booking</option>
                </select>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="<?= base_url('admin/penyewaan') ?>" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>