<?= $this->extend('layout/submenu_layout') ?>

<?= $this->section('content') ?>

<h3 class="mb-4"><?= esc($page_title) ?></h3>

<div class="card shadow-sm">
    <div class="card-body">
        <form action="<?= base_url('admin/paket/update/' . $paket['id_paket']) ?>" method="post">
            <?= csrf_field() ?>
            
            <div class="mb-3">
                <label for="nama_paket" class="form-label">Nama Paket</label>
                <input type="text" class="form-control" id="nama_paket" name="nama_paket" value="<?= esc($paket['nama_paket']) ?>" required>
            </div>
            
            <div class="mb-3">
                <label for="harga_paket" class="form-label">Harga Paket (Rp)</label>
                <input type="number" class="form-control" id="harga_paket" name="harga_paket" value="<?= esc($paket['harga_paket']) ?>" min="0" required>
            </div>

            <div class="mb-3">
                <label for="deskripsi_paket" class="form-label">Deskripsi</label>
                <textarea class="form-control" id="deskripsi_paket" name="deskripsi_paket" rows="4" required><?= esc($paket['deskripsi_paket']) ?></textarea>
            </div>
            
            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Update Paket</button>
                <a href="<?= base_url('admin/cek-paket') ?>" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>