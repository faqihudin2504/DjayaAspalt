<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="container mt-4">
    <div class="d-flex align-items-center mb-4">
        <a href="javascript:history.back()" class="me-3">
            <img src="<?= base_url('assets/Back-01.png') ?>" width="43" alt="Back">
        </a>
        <h2 class="mb-0">Jasa Perbaikan Jalan</h2>
    </div>
    <div class="text-center mt-5">
        <p>Konten untuk halaman Jasa Perbaikan Jalan akan ada di sini.</p>
        <p>Halaman ini dilindungi oleh filter, sehingga hanya user yang login sebagai customer yang bisa mengaksesnya.</p>
    </div>
</div>
<?= $this->endSection() ?>