<?= $this->extend('layout/admin_pemesanan') ?>

<?= $this->section('content') ?>

<h4 class="mb-4 fw-bold">Tambah Data Pemesanan</h4>

<div class="card shadow-sm">
    <div class="card-body">
        <form action="<?= base_url('admin/pemesanan/simpan') ?>" method="post">
            <?= csrf_field() ?>

            <div class="mb-3">
                <label for="id_pesanan" class="form-label">ID Pesanan</label>
                <input type="text" class="form-control" id="id_pesanan" name="id_pesanan" required>
            </div>
            <div class="mb-3">
                <label for="id_pelaksanaan" class="form-label">ID Pelaksanaan</label>
                <input type="text" class="form-control" id="id_pelaksanaan" name="id_pelaksanaan" placeholder="Masukkan ID Pelaksanaan yang ada" required>
            </div>
            <div class="mb-3">
                <label for="nama_paketdipesan" class="form-label">Nama Paket Dipesan</label>
                <input type="text" class="form-control" id="nama_paketdipesan" name="nama_paketdipesan" placeholder="Contoh: Paket A" required>
            </div>
            <div class="mb-3">
                <label for="harga_paketdipesan" class="form-label">Harga Paket Dipesan</label>
                <input type="number" class="form-control" id="harga_paketdipesan" name="harga_paketdipesan" min="0" required>
            </div>
             <div class="mb-3">
                <label for="tanggal_pemesanan" class="form-label">Tanggal Pemesanan</label>
                <input type="date" class="form-control" id="tanggal_pemesanan" name="tanggal_pemesanan" required>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="<?= base_url('admin/pemesanan') ?>" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>