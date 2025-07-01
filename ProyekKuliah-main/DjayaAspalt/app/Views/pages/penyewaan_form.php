<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="container py-4">
    <div class="d-flex align-items-center mb-4">
        <a href="javascript:history.back()" class="me-3">
            <img src="<?= base_url('assets/Back-01.png') ?>" width="43" alt="Back">
        </a>
        <h2 class="mb-0">Penyewaan Barang</h2>
    </div>

    <div class="row">
        <div class="col-md-3 text-center d-none d-md-block">
            <img src="<?= base_url('assets/Penggilas Aspal Besar.png') ?>" class="img-fluid mt-5" style="max-width: 150px; opacity: 0.8;" alt="Rolling Machine Icon">
        </div>
        <div class="col-md-9">
            <div class="card p-4 shadow-sm mb-4">
                <h5>Pilih Penyewaan</h5>
                <p>Mohon diisi untuk penyewaan barang</p>

                <div class="d-flex align-items-center mb-4">
                    <img src="<?= base_url('assets/' . $alat_nama . '.png') ?>" class="img-fluid me-4" style="max-width: 100px;" alt="<?= $alat_nama ?>">
                    <div>
                        <h4 class="fw-bold"><?= $alat_nama ?></h4>
                        <p class="mb-0">Penyewaan per <span class="text-danger">Hari</span></p>
                        <h5 class="fw-bold">Rp. <?= number_format($harga_per_hari, 0, ',', '.') ?></h5>
                        <p class="small text-muted mb-0">*Harap mengembalikan alat dalam kondisi baik dan barang sama seperti sebelum di sewa.</p>
                    </div>
                </div>

                <form action="<?= base_url('keranjang') ?>" method="get"> <div class="mb-3">
                        <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" value="<?= session()->get('nama_lengkap') ?? '' ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="no_telepon" class="form-label">No. Telepon</label>
                        <input type="text" class="form-control" id="no_telepon" name="no_telepon" value="<?= session()->get('no_handphone') ?? '' ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="alamat_pengiriman" class="form-label">Alamat Pengiriman</label>
                        <textarea class="form-control" id="alamat_pengiriman" name="alamat_pengiriman" rows="3" required><?= session()->get('alamat_rumah') ?? '' ?></textarea>
                    </div>

                    <button type="submit" class="btn btn-success mt-3">Konfirmasi</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>