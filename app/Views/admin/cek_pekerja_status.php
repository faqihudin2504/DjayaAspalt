<?= $this->extend('layout/submenu_layout') ?>

<?= $this->section('content') ?>

<style>
    /* Style baru yang disesuaikan dengan Figma */
    .pekerja-card {
        background-color: white;
        border-radius: 15px;
        padding: 2rem 1.5rem;
        text-align: center;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.07);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        height: 100%; /* Membuat kartu sama tinggi */
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .pekerja-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.1);
    }

    .pekerja-card img {
        max-width: 130px; /* Sedikit lebih kecil agar proporsional */
        margin-bottom: 1.5rem;
    }

    .pekerja-card h5 {
        font-weight: 600; /* Lebih tebal */
        font-size: 1.25rem;
        margin-bottom: 0.25rem;
    }

    .pekerja-card p {
        font-size: 1rem;
        color: #6c757d;
        margin-bottom: 1.5rem;
    }

    .pekerja-actions .btn {
        margin: 0 4px;
        font-weight: 500;
        padding: 6px 14px;
        font-size: 0.8rem;
    }
</style>

<div class="row justify-content-center">
    <div class="col-lg-5 col-md-6 mb-4">
        <div class="pekerja-card">
            <div>
                <img src="<?= base_url('assets/pekerja_sedang_bekerja.png') ?>" alt="Pekerja Sedang Bekerja">
                <h5>Pekerja <span class="text-success">Sedang Bekerja</span></h5>
                <p>Pekerja: <?= esc($pekerja['bekerja']) ?> Orang</p>
            </div>
            <div class="pekerja-actions mt-auto">
                <a href="<?= base_url('admin/cek-pekerja-detail/bekerja') ?>" class="btn btn-warning text-white">Cek</a>
                <a href="#" class="btn btn-success">Tambahkan</a>
                <a href="#" class="btn btn-dark">Edit</a>
            </div>
        </div>
    </div>
    
    <div class="col-lg-5 col-md-6 mb-4">
        <div class="pekerja-card">
            <div>
                <img src="<?= base_url('assets/pekerja_tidak_bekerja.png') ?>" alt="Pekerja Tidak Bekerja">
                <h5>Pekerja <span class="text-danger">Tidak Bekerja</span></h5>
                <p>Pekerja: <?= esc($pekerja['tersedia']) ?> Orang</p>
            </div>
            <div class="pekerja-actions mt-auto">
                <a href="<?= base_url('admin/cek-pekerja-detail/tersedia') ?>" class="btn btn-warning text-white">Cek</a>
                <a href="#" class="btn btn-success">Tambahkan</a>
                <a href="#" class="btn btn-dark">Edit</a>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>