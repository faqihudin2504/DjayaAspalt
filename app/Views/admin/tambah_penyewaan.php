<?= $this->extend('layout/admin_kosong') ?>

<?= $this->section('content') ?>

<h4 class="mb-4 fw-bold">Tambah Data Penyewaan</h4>

<div class="card shadow-sm">
    <div class="card-body">
        <form action="<?= base_url('admin/penyewaan/simpan') ?>" method="post">
            <?= csrf_field() ?>

            <div class="mb-3">
                <label for="id_sewa" class="form-label">ID Sewa</label>
                <input type="text" class="form-control" id="id_sewa" name="id_sewa" required>
            </div>
            <div class="mb-3">
                <label for="id_alat" class="form-label">ID Alat</label>
                <input type="text" class="form-control" id="id_alat" name="id_alat" required>
            </div>
            <div class="mb-3">
                <label for="id_namasewa" class="form-label">ID Penyewa (Pelanggan)</label>
                <input type="text" class="form-control" id="id_namasewa" name="id_namasewa" required>
            </div>
            <div class="mb-3">
                <label for="harga_alatdisewa" class="form-label">Harga Alat Disewa</label>
                <input type="number" class="form-control" id="harga_alatdisewa" name="harga_alatdisewa" min="0" required>
            </div>
             <div class="mb-3">
                <label for="tanggal_penyewaan" class="form-label">Tanggal Penyewaan</label>
                <input type="date" class="form-control" id="tanggal_penyewaan" name="tanggal_penyewaan" required>
            </div>
             <div class="mb-3">
                <label for="alamat_penyewa" class="form-label">Alamat Penyewa</label>
                <textarea class="form-control" id="alamat_penyewa" name="alamat_penyewa" rows="3" required></textarea>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="<?= base_url('admin/penyewaan') ?>" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>