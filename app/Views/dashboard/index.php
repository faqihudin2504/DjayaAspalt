<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div id="carouselExampleIndicators" class="carousel slide mb-4" data-bs-ride="carousel">
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
    </div>
  <div class="carousel-inner rounded">
    <div class="carousel-item active">
      <img src="<?= base_url('assets/banner1.png') ?>" class="d-block w-100" alt="Banner 1">
    </div>
    <div class="carousel-item">
      <img src="<?= base_url('assets/banner2.png') ?>" class="d-block w-100" alt="Banner 2">
    </div>
    <div class="carousel-item">
      <img src="<?= base_url('assets/banner3.png') ?>" class="d-block w-100" alt="Banner 3">
    </div>
    </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>

<h5 class="text-center mb-4"><strong>DJAYA ASPALT</strong>, Bisnis yang melakukan apa sih?</h5>

<div class="row text-center">
  <div class="col-md-6">
    <a href="<?= base_url('jasa-perbaikan') ?>" style="text-decoration: none; color: black;">
      <img src="<?= base_url('assets/Perbaikan Jalan.png') ?>" width="150" alt="Jasa Perbaikan Jalan">
      <p><strong>Jasa Perbaikan Jalan</strong></p>
    </a>
  </div>
  <div class="col-md-6">
    <a href="<?= base_url('penyewaan-barang') ?>" style="text-decoration: none; color: black;">
      <img src="<?= base_url('assets/Penyewaan Barang.png') ?>" width="150" alt="Penyewaan Barang">
      <p><strong>Penyewaan Barang</strong></p>
    </a>
  </div>
</div>

<?= $this->endSection() ?>