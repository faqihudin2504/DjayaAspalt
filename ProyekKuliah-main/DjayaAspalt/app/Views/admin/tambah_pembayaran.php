<?= $this->extend('layout/admin_main') ?>
<?= $this->section('content') ?>

<h4 class="mb-4 fw-bold"><?= esc($page_title ?? 'Tambah Data Pembayaran') ?></h4>

<?php if (session()->getFlashdata('errors')): ?>
    <div class="alert alert-danger">
        <ul>
        <?php foreach (session()->getFlashdata('errors') as $error): ?>
            <li><?= esc($error) ?></li>
        <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>
<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
<?php endif; ?>

<div class="card shadow-sm">
    <div class="card-body">
        <form action="<?= base_url('admin/pembayaran/simpan') ?>" method="post">
            <?= csrf_field() ?>

            <div class="mb-3">
                <label for="id_pesanan" class="form-label">Untuk Pemesanan (Opsional)</label>
                <select name="id_pesanan" id="id_pesanan" class="form-select">
                    <option value="">-- Pilih ID Pesanan --</option>
                    <?php foreach ($pemesanan_list as $pesanan): ?>
                        <option value="<?= esc($pesanan['id_pesanan']) ?>"><?= esc($pesanan['id_pesanan']) ?> - <?= esc($pesanan['nama_lengkap']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="id_sewa" class="form-label">Untuk Penyewaan (Opsional)</label>
                <select name="id_sewa" id="id_sewa" class="form-select">
                    <option value="">-- Pilih ID Sewa --</option>
                    <?php foreach ($penyewaan_list as $sewa): ?>
                        <option value="<?= esc($sewa['id_sewa']) ?>"><?= esc($sewa['id_sewa']) ?> - <?= esc($sewa['nama_penyewa']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <hr>

            <div class="mb-3">
                <label for="tanggal_pembayaran" class="form-label">Tanggal Pembayaran</label>
                <input type="date" class="form-control" id="tanggal_pembayaran" name="tanggal_pembayaran" value="<?= date('Y-m-d') ?>" required>
            </div>
            
            <div class="mb-3">
                <label for="metode_pembayaran" class="form-label">Metode Pembayaran</label>
                <select name="metode_pembayaran" id="metode_pembayaran" class="form-select" required>
                    <option value="Tunai">Tunai</option>
                    <option value="Transfer">Transfer</option>
                    <option value="QRIS">QRIS</option>
                </select>
            </div>
            
            <div class="mb-3">
                <label for="no_rekening" class="form-label">No. Rekening (Jika Transfer)</label>
                <input type="text" class="form-control" id="no_rekening" name="no_rekening" value="0" required>
            </div>

            <div class="mb-3">
                <label for="total_harga" class="form-label">Total Harga (Rp)</label>
                <input type="number" class="form-control" id="total_harga" name="total_harga" min="0" required>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Simpan Pembayaran</button>
                <a href="<?= base_url('admin/pembayaran') ?>" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>