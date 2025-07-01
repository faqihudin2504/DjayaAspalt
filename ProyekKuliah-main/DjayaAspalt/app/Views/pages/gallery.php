<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="container py-4">
    <div class="d-flex align-items-center mb-4">
        <a href="javascript:history.back()" class="me-3">
            <img src="<?= base_url('assets/Back-01.png') ?>" width="43" alt="Back">
        </a>
        <h2 class="mb-0">Gallery</h2>
    </div>

    <div class="text-center my-4">
        <h1 class="mt-1" style="font-size: 1.5rem;">Gallery Portfolio Projek yang Telah Kami Selesaikan</h1>
        <h2 class="mt-1" style="font-size: 2rem;">Gallery Portfolio Projek CV. Djaya Aspalt</h2>
    </div>

    <div class="row gallery-container">
        <?php for ($i = 1; $i <= 16; $i++): ?>
        <div class="col-md-3 col-sm-6 gallery-item mb-4">
            <div class="card">
                <img src="/assets/gallery/gal<?= $i ?>.png" class="card-img-top" alt="Projek <?= $i ?>">
            </div>
        </div>
        <?php endfor; ?>
    </div>
</div>

<style>
    .gallery-item {
        transition: transform 0.3s;
    }
    .gallery-item:hover {
        transform: scale(1.03);
    }
    .card {
        height: 100%;
    }
    .card-img-top {
        height: 200px;
        object-fit: cover;
    }
</style>

<?= $this->endSection() ?>