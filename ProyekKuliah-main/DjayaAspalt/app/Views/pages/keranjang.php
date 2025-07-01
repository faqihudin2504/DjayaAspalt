<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="container mt-4">
    <div class="d-flex align-items-center mb-4">
        <a href="javascript:history.back()" class="me-3">
            <img src="<?= base_url('assets/Back-01.png') ?>" width="43" alt="Back">
        </a>
        <h2 class="mb-0">Keranjang</h2>
    </div>

    <h4 class="mb-3">Informasi Detail Harga</h4>

    <?php if (isset($pemesanan)): ?>
    <div class="card p-4 shadow-sm mb-4">
        <div class="row">
            <div class="col-md-4 border-end">
                <h5 class="fw-bold">Paket A <br>Rp <?= number_format($pemesanan['paket_harga'], 0, ',', '.') ?>:</h5>
                <ul class="list-unstyled mt-3">
                    <?php foreach ($pemesanan['detail_layanan'] as $layanan): ?>
                        <li><?= $layanan['nama'] ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="col-md-8 ps-md-4">
                <div class="row mb-2">
                    <?php foreach ($pemesanan['detail_layanan'] as $layanan): ?>
                        <div class="col-6">Pembersihan Lokasi</div>
                        <div class="col-6 text-end">Rp. <?= number_format($layanan['harga'], 0, ',', '.') ?></div>
                    <?php endforeach; ?>
                </div>
                <hr>
                <div class="row mb-2">
                    <div class="col-6">Total Harga Paket</div>
                    <div class="col-6 text-end">Rp. <?= number_format($pemesanan['paket_harga'], 0, ',', '.') ?>/m2</div>
                </div>
                <div class="row mb-2">
                    <div class="col-6">Upah Tenaga</div>
                    <div class="col-6 text-end"><?= $pemesanan['upah_tenaga_jumlah_hari'] ?> hari x Rp. <?= number_format($pemesanan['upah_tenaga_per_hari'], 0, ',', '.') ?></div>
                </div>
                <hr>
                <div class="row mb-2">
                    <div class="col-6">Total Harga</div>
                    <?php
                        $totalHarga = $pemesanan['paket_harga'] + ($pemesanan['upah_tenaga_jumlah_hari'] * $pemesanan['upah_tenaga_per_hari']);
                    ?>
                    <div class="col-6 text-end">Rp. <?= number_format($totalHarga, 0, ',', '.') ?>/m2</div>
                </div>
                <div class="row mb-2 align-items-center">
                    <div class="col-6">Biaya Admin</div>
                    <div class="col-6 text-end d-flex justify-content-end align-items-center">
                        <button class="btn btn-sm btn-outline-secondary me-2">-</button>
                        <span><?= number_format($pemesanan['biaya_admin'], 0, ',', '.') ?></span>
                        <button class="btn btn-sm btn-outline-secondary ms-2">+</button>
                    </div>
                </div>
                <hr>
                <div class="row mb-2">
                    <div class="col-6 fw-bold">Total Semua Harga</div>
                    <?php
                        $totalSemuaHarga = $totalHarga + $pemesanan['biaya_admin'];
                    ?>
                    <div class="col-6 text-end fw-bold">Rp. <?= number_format($totalSemuaHarga, 0, ',', '.') ?></div>
                </div>
            </div>
        </div>
    </div>

    <div class="text-center mt-4">
        <button class="btn btn-danger me-2" onclick="showDeleteConfirmModal()">Hapus</button>
        <button class="btn btn-success" onclick="showPaymentMethodModal()">Pembayaran</button>
    </div>

    <?php else: ?>
        <div class="text-center mt-5">
            <img src="<?= base_url('assets/keranjang_kosong.gif') ?>" alt="Keranjang Kosong" class="img-fluid" style="max-width: 250px;">
            <h4 class="text-danger mt-3 fw-bold">Belum ada pesanan/penyewaan barang</h4>
        </div>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>