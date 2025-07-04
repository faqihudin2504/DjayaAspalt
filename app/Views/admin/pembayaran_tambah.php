<?= $this->extend('layout/admin_kosong') ?>
<?= $this->section('content') ?>

<h4 class="mb-4 fw-bold"><?= esc($page_title) ?></h4>

<div class="card shadow-sm">
    <div class="card-body">
        <form action="<?= base_url('admin/pembayaran/simpan') ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <input type="hidden" name="tipe" value="<?= esc($tipe) ?>">

            <div class="mb-3">
                <label for="id_transaksi" class="form-label fw-bold">Pilih Transaksi <?= ucfirst($tipe) ?></label>
                <select name="<?= ($tipe === 'pemesanan') ? 'id_pesanan' : 'id_sewa' ?>" id="id_transaksi" class="form-select" required>
                    <option value="" data-harga="">-- Pilih ID Transaksi --</option>
                    <?php foreach ($transaksi_list as $transaksi): ?>
                        <?php
                            // Logika untuk menentukan ID, Nama, dan Harga yang benar
                            $id = '';
                            $nama = '';
                            $harga = 0;
                            if ($tipe === 'pemesanan') {
                                $id = $transaksi['id_pesanan'];
                                $nama = $transaksi['nama_lengkap'];
                                // Gunakan total_harga_akhir jika ada, jika tidak, gunakan harga paket dasar
                                $harga = $transaksi['total_harga_akhir'] ?? $transaksi['harga_paketdipesan'];
                            } else { // tipe adalah 'penyewaan'
                                $id = $transaksi['id_sewa'];
                                $nama = $transaksi['nama_penyewa'];
                                $harga = $transaksi['harga_alatdisewa'];
                            }
                        ?>
                        <option value="<?= esc($id) ?>" data-harga="<?= esc($harga) ?>">
                            <?= esc($id) ?> - <?= esc($nama) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <hr>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="total_harga" class="form-label fw-bold">Total Harga (Rp)</label>
                    <input type="number" class="form-control" id="total_harga" name="total_harga" min="0" required readonly placeholder="Pilih transaksi untuk melihat harga">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="tanggal_pembayaran" class="form-label fw-bold">Tanggal Pembayaran</label>
                    <input type="date" class="form-control" id="tanggal_pembayaran" name="tanggal_pembayaran" value="<?= date('Y-m-d') ?>" required>
                </div>
            </div>

            <div class="row">
                 <div class="col-md-6 mb-3">
                    <label for="metode_pembayaran" class="form-label fw-bold">Metode Pembayaran</label>
                    <select name="metode_pembayaran" id="metode_pembayaran" class="form-select" required>
                        <option value="Tunai">Tunai</option>
                        <option value="Transfer">Transfer Bank</option>
                        <option value="QRIS">QRIS</option>
                    </select>
                </div>
                 <div class="col-md-6 mb-3">
                    <label for="status_pembayaran" class="form-label fw-bold">Status Pembayaran</label>
                    <select name="status_pembayaran" id="status_pembayaran" class="form-select" required>
                        <option value="Menunggu">Menunggu</option>
                        <option value="Lunas">Lunas</option>
                        <option value="Dibatalkan">Dibatalkan</option>
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label for="bukti_pembayaran" class="form-label fw-bold">Upload Bukti Pembayaran (Opsional)</label>
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
        
        hargaInput.value = harga || '';
    });
});
</script>

<?= $this->endSection() ?>