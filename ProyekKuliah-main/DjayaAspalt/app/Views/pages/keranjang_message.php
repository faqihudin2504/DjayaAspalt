<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="text-center mt-5">
    <img src="<?= base_url('assets/warning.png') ?>" width="120" alt="Warning">
    <h4 class="text-danger mt-3">Keranjang tidak bisa diakses!</h4>
    <p>Login terlebih dahulu untuk melihat isi keranjang Anda.</p>
    <a href="<?= base_url('/') ?>" class="btn btn-warning mt-3">Login Sekarang</a>
</div>

<?= $this->endSection() ?>
