<?= $this->extend('layout/submenu_layout') ?>

<?= $this->section('content') ?>

<style>
    /* Style untuk menyesuaikan dengan Figma */
    .paket-grid .card {
        border-radius: 12px;
        border: 1px solid #E0E0E0;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        background-color: #ffffff;
    }
    .paket-header {
        background-color: #FFF8F0;
        padding: 1rem;
        border-bottom: 1px solid #E0E0E0;
    }
    .paket-header h5 {
        font-weight: bold;
        margin-bottom: 0;
        font-size: 1.2rem;
    }
    .paket-header strong {
        font-size: 1rem;
        color: #d9534f;
    }
    .paket-body {
        padding: 1.5rem;
        font-size: 0.9rem;
    }
    .paket-deskripsi p {
        margin-bottom: 0.75rem;
        padding-left: 10px;
        border-left: 3px solid #FFDAB9;
    }
    .paket-footer {
        background-color: #FFF8F0;
        border-top: 1px solid #E0E0E0;
    }
    .paket-actions .btn {
        margin: 0 3px;
        font-size: 0.8rem;
        padding: 5px 12px;
        border-radius: 5px;
        font-weight: 500;
    }
    .btn-status {
        width: 100%;
        font-weight: bold;
        border-radius: 8px;
        margin-top: 1rem;
        background-color: #28a745;
        color: white;
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
    <div class="row paket-grid">
        <?php if (!empty($pakets)): ?>
            <?php foreach ($pakets as $paket): ?>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card h-100 d-flex flex-column">
                        <div class="card-body p-0 d-flex flex-column">
                            <div class="paket-header text-center">
                                <h5><?= esc($paket['nama_paket']) ?></h5>
                                <strong>Rp <?= number_format($paket['harga_paket'], 0, ',', '.') ?></strong>
                            </div>
                            
                            <div class="paket-body flex-grow-1">
                                <div class="paket-deskripsi">
                                    <?php 
                                        $items = explode('.', $paket['deskripsi_paket']);
                                        foreach($items as $item) {
                                            if (trim($item) != '') {
                                                echo '<p>' . esc(trim($item)) . '</p>';
                                            }
                                        }
                                    ?>
                                </div>
                            </div>

                            <div class="paket-footer p-3">
                                <div class="paket-actions text-center mb-2">
                                    <a href="<?= base_url('admin/paket/tambah') ?>" class="btn btn-primary">Tambahkan</a>
                                    <a href="<?= base_url('admin/paket/edit/' . $paket['id_paket']) ?>" class="btn btn-dark">Edit</a>
                                    <a href="<?= base_url('admin/paket/hapus/' . $paket['id_paket']) ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus paket ini?')">Hapus</a>
                                </div>
                                <a href="#" class="btn btn-status">Masih Banyak</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-center">Tidak ada data paket yang ditemukan. Silakan tambahkan data paket terlebih dahulu.</p>
        <?php endif; ?>
    </div>

    <?php if (!empty($pakets)): ?>
        <a href="#" class="btn btn-stok-full">Cek Stok Full</a>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>