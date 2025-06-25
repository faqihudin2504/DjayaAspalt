<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="text-center mt-5">
    <img src="<?= base_url('assets/warning.png') ?>" width="120" alt="Warning">
    <h4 class="text-danger mt-3">Anda Tidak Bisa Melakukan Pemesanan!</h4>
    <p>Harap Login Akun Dahulu Untuk Melakukan Pemesanan atau Penyewaan Barang. Terima kasih :)</p>
    <a href="<?= base_url('login') ?>" class="btn btn-primary mt-3">Login Sekarang</a>
</div>

<?= $this->endSection() ?>