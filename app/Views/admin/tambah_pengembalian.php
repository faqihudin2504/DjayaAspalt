<?= $this->extend('layout/admin_main') ?>
<?= $this->section('content') ?>

<h4 class="mb-4 fw-bold"><?= esc($page_title ?? 'Tambah Data Pengembalian') ?></h4>

<?php if (session()->getFlashdata('errors')): ?>
    <div class="alert alert-danger">
        <ul>
        <?php foreach (session()->getFlashdata('errors') as $error): ?>
            <li><?= esc($error) ?></li>
        <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<div class="card shadow-sm">
    <div class="card-body">
        <form action="<?= base_url('admin/pengembalian/simpan') ?>" method="post">
            <?= csrf_field() ?>
            
            <div class="mb-3">
                <label for="id_sewa" class="form-label">Pilih Transaksi Sewa yang Dikembalikan</label>
                <select name="id_sewa" id="id_sewa" class="form-select" required>
                    <option value="">-- Pilih ID Sewa --</option>
                    <?php foreach ($penyewaan_list as $sewa): ?>
                        <option value="<?= esc($sewa['id_sewa']) ?>">
                            ID: <?= esc($sewa['id_sewa']) ?> (Penyewa: <?= esc($sewa['nama_penyewa']) ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
                <small class="form-text text-danger">Pastikan ID Sewa belum pernah dikembalikan sebelumnya.</small>
            </div>
            
            <div class="mb-3">
                <label for="denda_kembali" class="form-label">Denda (Rp)</label>
                <input type="number" class="form-control" id="denda_kembali" name="denda_kembali" value="0" min="0" required>
                <small class="form-text text-muted">Isi 0 jika tidak ada denda.</small>
            </div>
            
            <div class="mb-3">
                <label for="tanggal_pengembalian" class="form-label">Tanggal Pengembalian</label>
                <input type="date" class="form-control" id="tanggal_pengembalian" name="tanggal_pengembalian" value="<?= date('Y-m-d') ?>" required>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Simpan Data Pengembalian</button>
                <a href="<?= base_url('admin/pengembalian') ?>" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>