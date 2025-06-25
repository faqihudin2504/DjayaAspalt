<?= $this->extend('layout/admin_kosong') ?>
<?= $this->section('content') ?>
<h4 class="mb-4 fw-bold">Tambah Data Pembayaran</h4>
<div class="card shadow-sm">
    <div class="card-body">
        <form action="<?= base_url('admin/pembayaran/simpan') ?>" method="post">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label for="id_bayar" class="form-label">ID Bayar</label>
                <input type="text" class="form-control" id="id_bayar" name="id_bayar" required>
            </div>
            <div class="mb-3">
                <label for="id_pesanan" class="form-label">Untuk ID Pesanan (Opsional)</label>
                <input type="text" class="form-control" id="id_pesanan" name="id_pesanan">
            </div>
            <div class="mb-3">
                <label for="id_sewa" class="form-label">Untuk ID Sewa (Opsional)</label>
                <input type="text" class="form-control" id="id_sewa" name="id_sewa">
            </div>
             <div class="mb-3">
                <label for="tanggal_pembayaran" class="form-label">Tanggal Pembayaran</label>
                <input type="date" class="form-control" id="tanggal_pembayaran" name="tanggal_pembayaran" required>
            </div>
            <div class="mb-3">
                <label for="metode_pembayaran" class="form-label">Metode Pembayaran</label>
                <input type="text" class="form-control" id="metode_pembayaran" name="metode_pembayaran" required>
            </div>
            <div class="mb-3">
                <label for="no_rekening" class="form-label">No. Rekening</label>
                <input type="text" class="form-control" id="no_rekening" name="no_rekening" required>
            </div>
             <div class="mb-3">
                <label for="total_harga" class="form-label">Total Harga</label>
                <input type="number" class="form-control" id="total_harga" name="total_harga" min="0" required>
            </div>
            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="<?= base_url('admin/pembayaran') ?>" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>