<?= $this->extend('layout/submenu_layout') ?>

<?= $this->section('content') ?>

<style>
    /* Style baru hanya untuk konten halaman ini */
    .paket-item-wrapper {
        text-align: center;
        margin-bottom: 1.5rem;
    }
    .paket-header {
        font-weight: bold;
        font-size: 1.1rem;
        margin-bottom: 0.5rem;
    }
    .paket-card {
        background: white;
        border-radius: 10px;
        border: 1px solid #ddd;
        padding: 20px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    .paket-card ul {
        padding-left: 20px;
        text-align: left;
        margin-top: 0;
        margin-bottom: 1.5rem;
        font-size: 0.9rem;
        flex-grow: 1; /* Membuat list memanjang memenuhi ruang */
    }
    .paket-buttons .btn {
        margin: 0 2px;
        font-size: 0.8rem;
        padding: 5px 12px;
        border-radius: 5px;
    }
    .btn-stok {
        background-color: #28a745;
        color: white;
        width: 100%;
        font-weight: bold;
        margin-top: 1rem;
        border-radius: 8px;
    }
    .btn-stok-full {
        display: block;
        width: 200px;
        margin: 2.5rem auto 0 auto;
        background-color: #343a40;
        color: white;
        font-weight: bold;
        padding: 10px;
        border-radius: 8px;
    }
</style>

<div class="container-fluid">
    <div class="row">
        <?php if (!empty($pakets)): ?>
            <?php foreach ($pakets as $paket): ?>
                <div class="col-lg-4 col-md-6">
                    <div class="paket-item-wrapper">
                        <div class="paket-header">
                            <?= esc($paket['nama_paket']) ?> Rp <?= number_format($paket['harga_paket'], 0, ',', '.') ?>
                        </div>
                        <div class="paket-card">
                            <ul>
                                <?php 
                                    $items = explode('.', $paket['deskripsi_paket']);
                                    foreach($items as $item) {
                                        if (trim($item) != '') {
                                            echo '<li>' . esc(trim($item)) . '</li>';
                                        }
                                    }
                                ?>
                            </ul>
                            <div class="paket-buttons text-center">
                                <a href="<?= base_url('admin/paket/tambah') ?>" class="btn btn-primary">Tambahkan</a>
                                <a href="<?= base_url('admin/paket/edit/' . $paket['id_paket']) ?>" class="btn btn-dark">Edit</a>
                                <a href="<?= base_url('admin/paket/hapus/' . $paket['id_paket']) ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus paket ini?')">Hapus</a>
                            </div>

                            <a href="#" class="btn btn-stok mt-3">Masih Banyak</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-center">Tidak ada data paket yang ditemukan.</p>
        <?php endif; ?>
    </div>

    <?php if (!empty($pakets)): ?>
        <a href="#" class="btn btn-stok-full">Cek Stok Full</a>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>