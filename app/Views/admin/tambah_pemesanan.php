<?= $this->extend('layout/admin_kosong') ?>
<?= $this->section('content') ?>

<h4 class="mb-4 fw-bold">Tambah Data Pemesanan Baru</h4>
<div class="card shadow-sm">
    <div class="card-body">
        <form action="<?= base_url('admin/pemesanan/simpan') ?>" method="post">
            <?= csrf_field() ?>

            <div class="mb-3">
                <label for="id_pelanggan" class="form-label">Pilih Pelanggan</label>
                <select class="form-control" name="id_pelanggan" id="id_pelanggan" required>
                    <option value="">-- Pilih Pelanggan --</option>
                    <?php if (!empty($pelanggan_list)): ?>
                        <?php foreach($pelanggan_list as $pl): ?>
                            <option value="<?= esc($pl['id_pelanggan']) ?>"><?= esc($pl['nama_lengkap']) ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="nama_paketdipesan" class="form-label">Nama Paket</label>
                    <select class="form-control" name="nama_paketdipesan" id="nama_paketdipesan" required>
                        <option value="" data-harga="">-- Pilih Paket --</option>
                        <option value="Paket A" data-harga="70000">Paket A</option>
                        <option value="Paket B" data-harga="85000">Paket B</option>
                        <option value="Paket C" data-harga="100000">Paket C</option> <option value="Paket D" data-harga="145000">Paket D</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="harga_paketdipesan" class="form-label">Harga Paket (Rp)</label>
                    <input type="number" class="form-control" name="harga_paketdipesan" id="harga_paketdipesan" required placeholder="Pilih paket untuk melihat harga" readonly>
                </div>
            </div>

            <div class="mb-3">
                <label for="tanggal_pemesanan" class="form-label">Tanggal Pemesanan</label>
                <input type="date" class="form-control" id="tanggal_pemesanan" name="tanggal_pemesanan" value="<?= date('Y-m-d') ?>" required>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Simpan Data Pemesanan</button>
                <a href="<?= base_url('admin/pemesanan') ?>" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const paketDropdown = document.getElementById('nama_paketdipesan');
        const hargaInput = document.getElementById('harga_paketdipesan');
        paketDropdown.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const harga = selectedOption.getAttribute('data-harga');
            hargaInput.value = harga || '';
        });
    });
</script>
<?= $this->endSection() ?>