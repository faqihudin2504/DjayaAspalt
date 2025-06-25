<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="text-center mt-5">
    <img src="<?= base_url('assets/warning.png') ?>" width="120" alt="Warning">
    <h4 class="text-danger mt-3">Anda tidak bisa melihat layanan ini!</h4>
    <p>Harap login terlebih dahulu untuk mengakses halaman jasa perbaikan jalan.</p>
    <a href="<?= base_url('/') ?>" class="btn btn-primary mt-3">Login Sekarang</a>
</div>

<?= $this->endSection() ?>
