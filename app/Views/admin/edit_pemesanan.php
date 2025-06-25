<?= $this->extend('layout/admin_kosong') ?>

<?= $this->section('content') ?>

<h4 class="mb-4 fw-bold">Edit Data Pemesanan</h4>

<div class="card shadow-sm">
    <div class="card-body">
        <form action="<?= base_url('admin/pemesanan/update/' . $pemesanan['id_pesanan']) ?>" method="post">
            <?= csrf_field() ?>

            <div class="mb-3">
                <label for="id_pesanan" class="form-label">ID Pesanan</label>
                <input type="text" class="form-control" id="id_pesanan" name="id_pesanan" value="<?= esc($pemesanan['id_pesanan']) ?>" readonly>
                <small class="form-text text-muted">ID Pesanan tidak dapat diubah.</small>
            </div>

            <div class="mb-3">
                <label for="id_pelaksanaan" class="form-label">Pilih ID Pelaksanaan</label>
                <select class="form-control" name="id_pelaksanaan" id="id_pelaksanaan" required>
                    <option value="">-- Pilih Proyek Pelaksanaan --</option>
                    <?php if (!empty($pelaksanaan_list)): ?>
                        <?php foreach($pelaksanaan_list as $pl): ?>
                            <option value="<?= esc($pl['id_pelaksanaan']) ?>" <?= ($pl['id_pelaksanaan'] == $pemesanan['id_pelaksanaan']) ? 'selected' : '' ?>>
                                ID: <?= esc($pl['id_pelaksanaan']) ?> (Alamat: <?= esc($pl['alamat_pelaksanaan']) ?>)
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
                 <small class="form-text text-muted">Pilih proyek yang berkaitan dengan pemesanan ini.</small>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="nama_paketdipesan" class="form-label">Nama Paket</label>
                    <input type="text" class="form-control" name="nama_paketdipesan" id="nama_paketdipesan" value="<?= esc($pemesanan['nama_paketdipesan']) ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="harga_paketdipesan" class="form-label">Harga Paket (Rp)</label>
                    <input type="number" class="form-control" name="harga_paketdipesan" id="harga_paketdipesan" value="<?= esc($pemesanan['harga_paketdipesan']) ?>" required>
                </div>
            </div>

            <div class="mb-3">
                <label for="tanggal_pemesanan" class="form-label">Tanggal Pemesanan</label>
                <input type="date" class="form-control" id="tanggal_pemesanan" name="tanggal_pemesanan" value="<?= esc($pemesanan['tanggal_pemesanan']) ?>" required>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="<?= base_url('admin/pemesanan') ?>" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>