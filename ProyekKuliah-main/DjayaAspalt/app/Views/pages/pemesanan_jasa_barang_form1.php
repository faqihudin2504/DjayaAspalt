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
                <h5><strong>Halo, Kamu Ingin Melakukan Pemesanan?</strong></h5>
                <p>Mohon diisi dahulu sebelum melakukan pemesanan</p>

                <form action="<?= base_url('pemesanan-jasa-barang-form2') ?>" method="get"> <div class="mb-3">
                        <label for="nama" class="form-label">Nama Lengkap</label>
                        <input name="nama" id="nama" class="form-control" placeholder="Nama Lengkap" required>
                    </div>
                    <div class="mb-3">
                        <label for="telepon" class="form-label">No. Telepon</label>
                        <input name="telepon" id="telepon" class="form-control" placeholder="No. Telepon" required>
                    </div>

                    <hr>
                    <p><strong>Pilih Waktu Untuk Survey/Mengecek Tempat Anda</strong></p>
                    <p class="text-muted">Dilakukannya survey, untuk melihat barang apa saja yang anda butuhkan</p>

                    <div class="row mb-3">
                        <div class="col-4">
                            <label for="tanggal_survey" class="form-label">Tanggal</label>
                            <select name="tanggal_survey" id="tanggal_survey" class="form-control" required>
                                <option value="10">10</option>
                                </select>
                        </div>
                        <div class="col-4">
                            <label for="bulan_survey" class="form-label">Bulan/Tahun</label>
                            <select name="bulan_survey" id="bulan_survey" class="form-control" required>
                                <option value="12">12</option>
                                <option value="2024">2024</option>
                                </select>
                        </div>
                        <div class="col-4">
                            <label for="jam_survey" class="form-label">Jam</label>
                            <select name="jam_survey" id="jam_survey" class="form-control" required>
                                <option value="07:00 WIB">07:00 WIB</option>
                                </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="alamat_survey" class="form-label">Alamat</label>
                        <textarea name="alamat_survey" id="alamat_survey" class="form-control" rows="3" placeholder="Alamat Survey" required></textarea>
                    </div>

                    <button type="submit" class="btn btn-success">Konfirmasi</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>