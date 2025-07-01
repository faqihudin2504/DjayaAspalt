<?= $this->extend('layout/admin_main') ?>

<?= $this->section('content') ?>
<style>
    .bukti-detail-container {
        display: flex;
        gap: 20px;
        background-color: #fff;
        padding: 20px;
        border-radius: 15px;
        justify-content: center;
        align-items: center;
    }
    .bukti-image img {
        max-width: 300px;
        border-radius: 10px;
    }
    .bukti-info {
        background-color: #fff;
        padding: 30px;
        border-radius: 15px;
        max-width: 400px;
    }
    .bukti-info .berhasil {
        background-color: #28a745;
        color: white;
        padding: 5px 15px;
        border-radius: 50px;
        display: inline-block;
        font-weight: bold;
    }
    .action-buttons {
        text-align: right;
        margin-top: 20px;
    }
     .action-buttons .btn {
        margin-left: 10px;
    }
</style>

<div class="container-fluid" style="background-color: #ff9933; padding: 40px; border-radius: 15px;">
    
    <div class="bukti-detail-container">
        <div class="bukti-image">
            <img src="<?= base_url('assets/contoh_bukti.png') ?>" alt="Bukti Transfer">
        </div>
        <div class="bukti-info">
            <p>
                Dari 2100132349 <br>
                Ke 4980175516
            </p>
            <h3><b>Paket A</b></h3>
            <h2><b>Rp. 1.905.000,00</b></h2>
            <p class="mt-3">*Pembayaran atas nama, <br> samuel orief rosario</p>
            <span class="berhasil">Berhasil</span>
        </div>
    </div>
    
    <div class="action-buttons">
        <a href="#" class="btn btn-success">Tambahkan</a>
        <a href="#" class="btn btn-dark">Edit</a>
    </div>

</div>

<?= $this->endSection() ?>