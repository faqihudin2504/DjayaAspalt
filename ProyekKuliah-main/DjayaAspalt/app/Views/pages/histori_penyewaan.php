<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="container mt-4">
    <div class="d-flex align-items-center mb-4">
        <a href="javascript:history.back()" class="me-3">
            <img src="<?= base_url('assets/Back-01.png') ?>" width="43" alt="Back">
        </a>
        <h2 class="mb-0">Histori Penyewaan</h2>
    </div>

    <?php if (isset($has_rentals) && $has_rentals): ?>
    <h4 class="text-dark fw-bold text-center mb-4">SEDANG DIPINJAM</h4>
    <div class="card p-4 shadow-sm mb-4">
        <div class="row align-items-center">
            <div class="col-md-3 text-center">
                <img src="<?= base_url('assets/Penggilas Aspal Besar.png') ?>" class="img-fluid" alt="Alat">
            </div>
            <div class="col-md-9">
                <h5 class="fw-bold mb-1">Halo, <?= session()->get('nama_lengkap') ?? 'Pelanggan' ?></h5>
                <h4 class="fw-bold text-danger mb-2"><?= $penyewaan['nama_alat'] ?? 'Alat Tidak Diketahui' ?></h4>
                <p class="mb-1"><strong>Waktu <?= $penyewaan['waktu_sewa'] ?? '-' ?></strong></p>
                <p class="mb-1">Sewa <?= $penyewaan['tanggal_sewa'] ?? '-' ?></p>
                <p class="mb-1 text-danger">Kembali <?= $penyewaan['tanggal_kembali'] ?? '-' ?></p>
                <p class="small text-muted fst-italic">*Mohon kembalikan tepat waktu, supaya tidak dikenakan denda, terima kasih :)</p>
                <button class="btn btn-dark btn-sm">Catatan</button>
            </div>
        </div>
    </div>
    <div class="text-center mt-5">
        <h4 class="text-success fw-bold mb-4">SUDAH PERNAH DIPESAN & DIKERJAKAN</h4>
        <p class="lead">Belum pernah memesan</p>
        <div class="text-center">
            <img src="<?= base_url('assets/Penggilas Aspal Besar.png') ?>" class="img-fluid" style="max-width: 150px; opacity: 0.5;" alt="Alat sudah disewa">
        </div>
    </div>

    <?php else: ?>
    <div class="text-center mt-5">
        <img src="<?= base_url('assets/histori_kosong.gif') ?>" alt="Tidak Ada Penyewaan" class="img-fluid" style="max-width: 250px;">
        <h4 class="text-danger mt-3 fw-bold">Tidak Ada Penyewaan</h4>
    </div>
    <?php endif; ?>

</div>
<?= $this->endSection() ?>