<?= $this->extend('layout/admin_kosong') ?>

<?= $this->section('content') ?>

<h4 class="mb-4 fw-bold">Tambah Data Pemesanan Baru</h4>

<div class="card shadow-sm">
    <div class="card-body">
        <form action="<?= base_url('admin/pemesanan/simpan') ?>" method="post">
            <?= csrf_field() ?>

            <div class="mb-3">
                <label for="id_pelaksanaan" class="form-label">Pilih ID Pelaksanaan</label>
                <select class="form-control" name="id_pelaksanaan" id="id_pelaksanaan" required>
                    <option value="">-- Pilih Proyek Pelaksanaan --</option>
                    <?php if (!empty($pelaksanaan_list)): ?>
                        <?php foreach($pelaksanaan_list as $pl): ?>
                            <option value="<?= esc($pl['id_pelaksanaan']) ?>">
                                ID: <?= esc($pl['id_pelaksanaan']) ?> (Alamat: <?= esc($pl['alamat_pelaksanaan']) ?>)
                            </option>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <option value="" disabled>Tidak ada data pelaksanaan tersedia</option>
                    <?php endif; ?>
                </select>
                 <small class="form-text text-muted">Pilih proyek yang berkaitan dengan pemesanan ini.</small>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="nama_paketdipesan" class="form-label">Nama Paket</label>
                    <input type="text" class="form-control" name="nama_paketdipesan" id="nama_paketdipesan" required placeholder="Contoh: Paket A">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="harga_paketdipesan" class="form-label">Harga Paket (Rp)</label>
                    <input type="number" class="form-control" name="harga_paketdipesan" id="harga_paketdipesan" required placeholder="Masukkan angka saja, contoh: 500000">
                </div>
            </div>

            <div class="mb-3">
                <label for="tanggal_pemesanan" class="form-label">Tanggal Pemesanan</label>
                <input type="date" class="form-control" id="tanggal_pemesanan" name="tanggal_pemesanan" required>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Simpan Data Pemesanan</button>
                <a href="<?= base_url('admin/pemesanan') ?>" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>