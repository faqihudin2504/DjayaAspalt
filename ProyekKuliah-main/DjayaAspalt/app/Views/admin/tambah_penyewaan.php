<?= $this->extend('layout/admin_kosong') ?>

<?= $this->section('content') ?>

<h4 class="mb-4 fw-bold">Tambah Data Penyewaan</h4>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="card shadow-sm">
    <div class="card-body">
        <form action="<?= base_url('admin/penyewaan/simpan') ?>" method="post">
            <?= csrf_field() ?>

            <div class="mb-3">
                <label for="id_pelanggan" class="form-label fw-bold">Pilih Pelanggan Penyewa</label>
                <select class="form-control" name="id_pelanggan" id="id_pelanggan" required>
                    <option value="">-- Pilih Nama Pelanggan --</option>
                    <?php if (!empty($pelanggan_list)): ?>
                        <?php foreach($pelanggan_list as $pelanggan): ?>
                            <option value="<?= esc($pelanggan['id_pelanggan']) ?>" <?= set_select('id_pelanggan', $pelanggan['id_pelanggan']) ?>>
                                <?= esc($pelanggan['nama_lengkap']) ?>
                            </option>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <option value="" disabled>Tidak ada pelanggan tujuan sewa.</option>
                    <?php endif; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="id_alat" class="form-label fw-bold">Pilih Alat</label>
                <select class="form-control" name="id_alat" id="id_alat" required>
                    <option value="" data-harga="">-- Pilih Alat yang Disewa --</option>
                    <?php if (!empty($alat_list)): ?>
                        <?php foreach($alat_list as $alat): ?>
                            <option value="<?= esc($alat['id_alat']) ?>" data-harga="<?= esc($alat['harga_sewa']) ?>" <?= set_select('id_alat', $alat['id_alat']) ?>>
                                <?= esc($alat['nama_alat']) ?> (Stok: <?= esc($alat['stok_alat']) ?>)
                            </option>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <option value="" disabled>Tidak ada alat yang tersedia.</option>
                    <?php endif; ?>
                </select>
            </div>
            
            <hr>

            <div class="mb-3">
                <label for="harga_alatdisewa" class="form-label fw-bold">Harga Sewa (Rp)</label>
                <input type="number" class="form-control" name="harga_alatdisewa" id="harga_alatdisewa" placeholder="Pilih alat untuk melihat harga" readonly required>
            </div>
            
            <div class="mb-3">
                <label for="alamat_penyewa" class="form-label fw-bold">Alamat Pengiriman</label>
                <textarea class="form-control" name="alamat_penyewa" rows="3" required><?= set_value('alamat_penyewa') ?></textarea>
            </div>

            <div class="mb-3">
                <label for="tanggal_penyewaan" class="form-label fw-bold">Tanggal Penyewaan</label>
                <input type="date" class="form-control" name="tanggal_penyewaan" value="<?= set_value('tanggal_penyewaan', date('Y-m-d')) ?>" required>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Simpan Data Penyewaan</button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const alatDropdown = document.getElementById('id_alat');
    const hargaInput = document.getElementById('harga_alatdisewa');

    function updateHarga() {
        const selectedOption = alatDropdown.options[alatDropdown.selectedIndex];
        if (selectedOption) {
            const harga = selectedOption.getAttribute('data-harga');
            hargaInput.value = harga || '';
        }
    }

    alatDropdown.addEventListener('change', updateHarga);
    updateHarga(); 
});
</script>
<?= $this->endSection() ?>