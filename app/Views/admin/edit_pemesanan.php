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
            </div>

            <div class="mb-3">
                <label for="id_pelaksanaan" class="form-label">Pilih ID Pelaksanaan</label>
                <select class="form-control" name="id_pelaksanaan" id="id_pelaksanaan" required>
                    <option value="" data-tanggal="">-- Pilih Proyek Pelaksanaan --</option>
                    <?php if (!empty($pelaksanaan_list)): ?>
                        <?php foreach($pelaksanaan_list as $pl): ?>
                            <option value="<?= esc($pl['id_pelaksanaan']) ?>" 
                                    data-tanggal="<?= esc(date('Y-m-d', strtotime($pl['tanggal_pelaksanaan']))) ?>"
                                    <?= ($pl['id_pelaksanaan'] == $pemesanan['id_pelaksanaan']) ? 'selected' : '' ?>>
                                ID: <?= esc($pl['id_pelaksanaan']) ?> (Alamat: <?= esc(word_limiter($pl['alamat_pelaksanaan'], 5)) ?>)
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="nama_paketdipesan" class="form-label">Nama Paket</label>
                    <select class="form-control" name="nama_paketdipesan" id="nama_paketdipesan" required>
                        <option value="" data-harga="">-- Pilih Paket --</option>
                        <?php 
                            $paket_list = [
                                'Paket A' => '8000000',
                                'Paket B' => '6000000',
                                'Paket C' => '4000000',
                                'Paket D' => '2000000',
                            ];
                        ?>
                        <?php foreach($paket_list as $nama => $harga): ?>
                            <option value="<?= $nama ?>" 
                                    data-harga="<?= $harga ?>" 
                                    <?= ($nama == $pemesanan['nama_paketdipesan']) ? 'selected' : '' ?>>
                                <?= $nama ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="harga_paketdipesan" class="form-label">Harga Paket (Rp)</label>
                    <input type="number" class="form-control" name="harga_paketdipesan" id="harga_paketdipesan" value="<?= esc($pemesanan['harga_paketdipesan']) ?>" required readonly>
                </div>
            </div>

            <div class="mb-3">
                <label for="tanggal_pemesanan" class="form-label">Tanggal Pemesanan</label>
                <input type="date" class="form-control" id="tanggal_pemesanan" name="tanggal_pemesanan" value="<?= esc(date('Y-m-d', strtotime($pemesanan['tanggal_pemesanan']))) ?>" required readonly>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="<?= base_url('admin/pemesanan') ?>" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const paketDropdown = document.getElementById('nama_paketdipesan');
    const hargaInput = document.getElementById('harga_paketdipesan');
    const pelaksanaanDropdown = document.getElementById('id_pelaksanaan');
    const tanggalInput = document.getElementById('tanggal_pemesanan');

    // Event listener untuk Nama Paket -> Harga Paket
    paketDropdown.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const harga = selectedOption.getAttribute('data-harga');
        hargaInput.value = harga || '';
    });

    // Event listener untuk ID Pelaksanaan -> Tanggal Pemesanan
    pelaksanaanDropdown.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const tanggal = selectedOption.getAttribute('data-tanggal');
        tanggalInput.value = tanggal || '';
    });
});
</script>

<?= $this->endSection() ?>