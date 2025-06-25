<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <div class="d-flex align-items-center mb-4">
        <a href="javascript:history.back()" class="me-3">
            <img src="<?= base_url('assets/Back-01.png') ?>" width="43" alt="Back">
        </a>
        <h2 class="mb-0">Pemesanan Jasa & Barang</h2>
    </div>

    <div class="row">
        <div class="col-md-3 text-center d-none d-md-block">
            <img src="<?= base_url('assets/engineer_shake_hands.png') ?>" class="img-fluid mt-5" style="max-width: 150px;" alt="Engineer Handshake">
        </div>
        <div class="col-md-9">
            <div class="card p-4 shadow-sm mb-4">
                <h5><strong>Pilih Pelaksanaan</strong></h5>
                <p>Mohon diisi untuk waktu pelaksanaan</p>

                <form action="<?= base_url('pemesanan-paket') ?>" method="get"> <div class="row mb-3">
                        <div class="col-4">
                            <label for="tanggal_pelaksanaan" class="form-label">Tanggal</label>
                            <select type="date" name="tanggal_pelaksanaan" id="tanggal_pelaksanaan" class="form-control" required>
                                <option value="12">12</option>
                                </select>
                        </div>
                        <div class="col-4">
                            <label for="bulan_pelaksanaan" class="form-label">Bulan/Tahun</label>
                            <select name="bulan_pelaksanaan" id="bulan_pelaksanaan" class="form-control" required>
                                <option value="12">12</option>
                                <option value="2024">2024</option>
                                </select>
                        </div>
                        <div class="col-4">
                            <label for="jam_pelaksanaan" class="form-label">Jam</label>
                            <select type="time" name="jam_pelaksanaan" id="jam_pelaksanaan" class="form-control" required>
                                <option value="10:00 WIB">10:00 WIB</option>
                                </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="alamat_pelaksanaan" class="form-label">Alamat</label>
                        <textarea name="alamat_pelaksanaan" id="alamat_pelaksanaan" class="form-control" rows="3" placeholder="Alamat Pelaksanaan" required>Jl. Bhakti No.48 3, RT.3/RW.7, Cilandak Tim., Ps. Minggu, Kota Jakarta Selatan, Daerah Khusus Ibukota Jakarta 12560</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Waktu Pengerjaan</label><br>
                        <?php foreach (['3 Hari', '7 Hari', '14 Hari', '21 Hari', '1 Bulan', 'Sampai Selesai'] as $durasi): ?>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="durasi" id="durasi_<?= str_replace(' ', '', $durasi) ?>" value="<?= $durasi ?>" required>
                                <label class="form-check-label" for="durasi_<?= str_replace(' ', '', $durasi) ?>"><?= $durasi ?></label>
                            </div>
                        <?php endforeach ?>
                    </div>
                    <div class="mb-3">
                        <select class="form-control" name="durasi_pilih" id="durasi_pilih">
                            <option value="">Pilih</option>
                            <option value="Tambahan Durasi">Tambahan Durasi</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-success">Konfirmasi</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>