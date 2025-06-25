<?= $this->extend('layout/admin_main') ?>

<?= $this->section('content') ?>

<style>
    .card-revisi { border: 2px solid #ff9933; border-radius: 15px; background-color: #fffaf0; }
    .card-revisi .card-header { background-color: #ff9933; color: black; font-weight: bold; border-bottom: 2px solid #ff8c1a; }
    .empty-data-container { padding: 40px 20px; text-align: center; }
    .empty-data-container img { max-width: 150px; margin-bottom: 15px; }
    .bukti-box {
        background-color: #90ee90; /* light green */
        color: #006400; /* dark green */
        border-radius: 10px;
        padding: 15px;
        margin-bottom: 15px;
        font-weight: bold;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .bukti-box .btn-klik {
        background-color: #006400;
        color: white;
        border: none;
        border-radius: 5px;
        font-size: 0.9rem;
        padding: 5px 15px;
    }
</style>

<h4 class="mb-4 fw-bold">Bukti Pembayaran</h4>

<?php if (empty($bukti_list)): ?>
    <div class="card card-revisi">
        <div class="card-body empty-data-container">
            <img src="<?= base_url('assets/table_cat_animated.gif') ?>" alt="Tidak Ada Data">
            <p class="text-danger fw-bold mt-3">Tidak Ada Bukti Pembayaran</p>
        </div>
    </div>
<?php else: ?>
    <div class="card card-revisi mb-4">
        <div class="card-header">
            Bukti Pembayaran bulan Desember
        </div>
        <div class="card-body">
            <div class="row">
                <?php foreach($bukti_list as $bukti): ?>
                <div class="col-md-6">
                    <div class="bukti-box">
                        <div>
                            Id bayar: <?= esc($bukti['id_bayar']) ?> <br>
                            <?= esc($bukti['nama']) ?>
                        </div>
                        <a href="<?= base_url('admin/pembayaran/bukti/detail/' . $bukti['id_bayar']) ?>" class="btn btn-klik">klik</a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    
    <div class="card card-revisi">
        <div class="card-header">
            Bukti Pembayaran bulan November
        </div>
        <div class="card-body empty-data-container">
            <img src="<?= base_url('assets/table_cat_animated.gif') ?>" alt="Tidak Ada Data">
            <p class="text-danger fw-bold mt-3">Tidak Ada Pembayaran</p>
        </div>
    </div>
<?php endif; ?>

<?= $this->endSection() ?>