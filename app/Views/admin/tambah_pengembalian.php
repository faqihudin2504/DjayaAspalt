<?= $this->extend('layout/admin_kosong') ?>
<?= $this->section('content') ?>
<h4 class="mb-4 fw-bold">Tambah Data Pengembalian</h4>
<div class="card shadow-sm">
    <div class="card-body">
        <form action="<?= base_url('admin/pengembalian/simpan') ?>" method="post">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label for="id_kembali" class="form-label">ID Kembali</label>
                <input type="text" class="form-control" id="id_kembali" name="id_kembali" required>
            </div>
             <div class="mb-3">
                <label for="id_sewa" class="form-label">ID Sewa yang Dikembalikan</label>
                <input type="text" class="form-control" id="id_sewa" name="id_sewa" required>
            </div>
            <div class="mb-3">
                <label for="denda_kembali" class="form-label">Denda Kembali (Isi 0 jika tidak ada)</label>
                <input type="number" class="form-control" id="denda_kembali" name="denda_kembali" value="0" min="0" required>
            </div>
            <div class="mb-3">
                <label for="tanggal_pengembalian" class="form-label">Tanggal Pengembalian</label>
                <input type="date" class="form-control" id="tanggal_pengembalian" name="tanggal_pengembalian" required>
            </div>
            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="<?= base_url('admin/pengembalian') ?>" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>