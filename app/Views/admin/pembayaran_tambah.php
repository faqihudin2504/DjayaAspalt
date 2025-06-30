<?= $this->extend('layout/admin_kosong') ?>
<?= $this->section('content') ?>

<h4 class="mb-4 fw-bold"><?= esc($page_title) ?></h4>

<div class="card shadow-sm">
    <div class="card-body">
        <form action="<?= base_url('admin/pembayaran/simpan') ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <input type="hidden" name="tipe" value="<?= $tipe ?>">

            <?php if ($tipe === 'pemesanan'): ?>
            <div class="mb-3">
                <label for="id_pesanan" class="form-label">Pilih Transaksi Pemesanan</label>
                <select name="id_pesanan" id="id_transaksi" class="form-select" required>
                    <option value="">-- Pilih ID Pemesanan --</option>
                    <?php foreach ($transaksi_list as $transaksi): ?>
                        <option value="<?= esc($transaksi['id_pesanan']) ?>" data-harga="<?= esc($transaksi['harga_paketdipesan']) ?>">
                            <?= esc($transaksi['id_pesanan']) ?> - <?= esc($transaksi['nama_lengkap']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <?php else: ?>
            <div class="mb-3">
                <label for="id_sewa" class="form-label">Pilih Transaksi Penyewaan</label>
                <select name="id_sewa" id="id_transaksi" class="form-select" required>
                    <option value="">-- Pilih ID Sewa --</option>
                    <?php foreach ($transaksi_list as $transaksi): ?>
                        <option value="<?= esc($transaksi['id_sewa']) ?>" data-harga="<?= esc($transaksi['harga_alatdisewa']) ?>">
                            <?= esc($transaksi['id_sewa']) ?> - <?= esc($transaksi['nama_penyewa']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <?php endif; ?>
            
            <hr>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="total_harga" class="form-label">Total Harga (Rp)</label>
                    <input type="number" class="form-control" id="total_harga" name="total_harga" min="0" required readonly placeholder="Pilih transaksi untuk melihat harga">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="tanggal_pembayaran" class="form-label">Tanggal Pembayaran</label>
                    <input type="date" class="form-control" id="tanggal_pembayaran" name="tanggal_pembayaran" value="<?= date('Y-m-d') ?>" required>
                </div>
            </div>

            <div class="row">
                 <div class="col-md-6 mb-3">
                    <label for="metode_pembayaran" class="form-label">Metode Pembayaran</label>
                    <select name="metode_pembayaran" id="metode_pembayaran" class="form-select" required>
                        <option value="Tunai">Tunai</option>
                        <option value="Transfer">Transfer</option>
                        <option value="QRIS">QRIS</option>
                    </select>
                </div>
                 <div class="col-md-6 mb-3">
                    <label for="status_pembayaran" class="form-label">Status Pembayaran</label>
                    <select name="status_pembayaran" id="status_pembayaran" class="form-select" required>
                        <option value="Lunas">Lunas</option>
                        <option value="Menunggu">Menunggu</option>
                        <option value="Dibatalkan">Dibatalkan</option>
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label for="bukti_pembayaran" class="form-label">Upload Bukti Pembayaran (Opsional)</label>
                <input type="file" class="form-control" id="bukti_pembayaran" name="bukti_pembayaran">
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Simpan Pembayaran</button>
                <a href="<?= base_url('admin/pembayaran/' . $tipe) ?>" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const transaksiDropdown = document.getElementById('id_transaksi');
    const hargaInput = document.getElementById('total_harga');

    transaksiDropdown.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const harga = selectedOption.getAttribute('data-harga');
        
        if (harga) {
            hargaInput.value = harga;
        } else {
            hargaInput.value = '';
        }
    });
});
</script>

<?= $this->endSection() ?>