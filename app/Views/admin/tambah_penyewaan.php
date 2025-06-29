<?= $this->extend('layout/admin_main') ?>

<?= $this->section('content') ?>

<h4 class="mb-4 fw-bold">Tambah Data Penyewaan</h4>

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
                            <option value="<?= esc($pelanggan['id_pelanggan']) ?>">
                                <?= esc($pelanggan['nama_lengkap']) ?> (ID: <?= esc($pelanggan['id_pelanggan']) ?>)
                            </option>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <option value="" disabled>Tidak ada pelanggan tujuan sewa yang tersedia.</option>
                    <?php endif; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="id_alat" class="form-label fw-bold">Pilih Alat</label>
                <select class="form-control" name="id_alat" id="id_alat" required>
                    <option value="">-- Pilih Alat yang Disewa --</option>
                    <?php if (!empty($alat_list)): ?>
                        <?php foreach($alat_list as $alat): ?>
                            <option value="<?= esc($alat['id_alat']) ?>" <?= set_select('id_alat', $alat['id_alat']) ?>>
                                <?= esc($alat['nama_alat']) ?> (Stok: <?= esc($alat['stok_alat']) ?>)
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>
            
            <hr>
            <h5 class="text-muted">Detail Otomatis</h5>
            <div class="mb-3">
                <label for="harga_alatdisewa" class="form-label fw-bold">Harga Sewa (Rp)</label>
                <input type="number" class="form-control" name="harga_alatdisewa" id="harga_alatdisewa" placeholder="Pilih alat untuk melihat harga" readonly required>
            </div>
            <hr>

            <div class="mb-3">
                <label for="alamat_penyewa" class="form-label fw-bold">Alamat Pengiriman Alat</label>
                <textarea class="form-control" name="alamat_penyewa" id="alamat_penyewa" rows="3" placeholder="Masukkan alamat pengiriman alat" required><?= set_value('alamat_penyewa') ?></textarea>
            </div>

            <div class="mb-3">
                <label for="tanggal_penyewaan" class="form-label fw-bold">Tanggal Penyewaan</label>
                <input type="date" class="form-control" name="tanggal_penyewaan" id="tanggal_penyewaan" value="<?= set_value('tanggal_penyewaan', date('Y-m-d')) ?>" required>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Simpan Data Penyewaan</button>
                <a href="<?= base_url('admin/penyewaan') ?>" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Fungsi untuk mengisi harga sewa secara otomatis saat alat dipilih
        $('#id_alat').change(function() {
            var id_alat = $(this).val();
            if (id_alat) {
                // Panggil rute di controller untuk mengambil detail alat
                $.ajax({
                    url: '<?= base_url('admin/penyewaan/get-alat-detail') ?>/' + id_alat,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        // Isi nilai harga sewa ke dalam input
                        if(data && data.harga_sewa) {
                            $('#harga_alatdisewa').val(data.harga_sewa);
                        } else {
                            $('#harga_alatdisewa').val(''); // Kosongkan jika tidak ada harga
                        }
                    },
                    error: function() {
                         $('#harga_alatdisewa').val('');
                         alert('Gagal mengambil detail harga alat.');
                    }
                });
            } else {
                // Kosongkan harga jika tidak ada alat yang dipilih
                $('#harga_alatdisewa').val('');
                $('#harga_alatdisewa').attr('placeholder', 'Pilih alat untuk melihat harga');
            }
        });
    });
</script>
<?= $this->endSection() ?>