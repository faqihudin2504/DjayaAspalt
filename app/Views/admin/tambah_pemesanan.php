<?= $this->extend('layout/admin_kosong') ?>
<?= $this->section('content') ?>

<h4 class="mb-4 fw-bold">Tambah Data Pemesanan Baru</h4>
<div class="card shadow-sm">
    <div class="card-body">
        <form action="<?= base_url('admin/pemesanan/simpan') ?>" method="post">
            <?= csrf_field() ?>

            <div class="mb-3">
                <label for="id_pelanggan" class="form-label">Pilih Pelanggan</label>
                <select class="form-control" name="id_pelanggan" required>
                    <option value="">-- Pilih Pelanggan --</option>
                    <?php foreach($pelanggan_list as $pl): ?>
                        <option value="<?= esc($pl['id_pelanggan']) ?>"><?= esc($pl['nama_lengkap']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="nama_paketdipesan" class="form-label">Nama Paket</label>
                    <select class="form-control" name="nama_paketdipesan" id="nama_paketdipesan" required>
                        <option value="" data-harga="0">-- Pilih Paket --</option>
                        <option value="Paket A" data-harga="70000">Paket A</option>
                        <option value="Paket B" data-harga="85000">Paket B</option>
                        <option value="Paket C" data-harga="100000">Paket C</option>
                        <option value="Paket D" data-harga="145000">Paket D</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="harga_paketdipesan" class="form-label">Harga Paket (Rp)</label>
                    <input type="number" class="form-control" name="harga_paketdipesan" id="harga_paketdipesan" value="0" required readonly>
                </div>
            </div>

            <div class="mb-3">
                <label for="tanggal_pemesanan" class="form-label">Tanggal Pemesanan</label>
                <input type="date" class="form-control" id="tanggal_pemesanan" name="tanggal_pemesanan" value="<?= date('Y-m-d') ?>" required>
            </div>
            
            <hr>

            <h5 class="mb-3">Pilih Material (Opsional)</h5>
            <div id="material-container">
                </div>
            <button type="button" id="add-material-btn" class="btn btn-outline-success btn-sm mt-2">
                + Tambah Material
            </button>
            
            <hr>

            <div class="text-end">
                <h4>Total Biaya: <span id="total-biaya" class="fw-bold">Rp 0</span></h4>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Simpan Data Pemesanan</button>
                <a href="<?= base_url('admin/pemesanan') ?>" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>

<div id="material-template" class="row align-items-center mb-2" style="display: none;">
    <div class="col-md-5">
        <select class="form-control material-select">
            <option value="">-- Pilih Material --</option>
            <?php foreach($material_list as $mat): ?>
            <option value="<?= esc($mat['id_alat']) ?>" data-harga="<?= esc($mat['harga_sewa']) ?>">
                <?= esc($mat['nama_alat']) ?> - Rp <?= number_format($mat['harga_sewa']) ?>
            </option>            <?php endforeach; ?>
        </select>
        <input type="hidden" class="material-harga">
    </div>
    <div class="col-md-3"><input type="number" class="form-control material-jumlah" placeholder="Jumlah (ton)" min="1"></div>
    <div class="col-md-3"><input type="text" class="form-control material-subtotal" placeholder="Subtotal" readonly></div>
    <div class="col-md-1"><button type="button" class="btn btn-danger btn-sm remove-material-btn">X</button></div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const paketDropdown = document.getElementById('nama_paketdipesan');
    const hargaPaketInput = document.getElementById('harga_paketdipesan');
    const materialContainer = document.getElementById('material-container');
    const addMaterialBtn = document.getElementById('add-material-btn');
    const materialTemplate = document.getElementById('material-template');
    const totalBiayaSpan = document.getElementById('total-biaya');
    let materialIndex = 0;

    // Fungsi untuk menghitung total biaya keseluruhan
    function calculateTotal() {
        let total = 0;
        const hargaPaket = parseFloat(hargaPaketInput.value) || 0;
        total += hargaPaket;

        document.querySelectorAll('#material-container .row').forEach(row => {
            const subtotalInput = row.querySelector('.material-subtotal');
            const subtotal = parseFloat(subtotalInput.value.replace(/[^0-9]/g, '')) || 0;
            total += subtotal;
        });
        
        totalBiayaSpan.textContent = 'Rp ' + total.toLocaleString('id-ID');
    }

    // Event listener untuk dropdown paket
    paketDropdown.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        hargaPaketInput.value = selectedOption.getAttribute('data-harga') || 0;
        calculateTotal();
    });

    // Event listener untuk tombol "Tambah Material"
    addMaterialBtn.addEventListener('click', function() {
        const newRow = materialTemplate.cloneNode(true);
        newRow.style.display = 'flex';
        newRow.id = '';
        
        newRow.querySelector('.material-select').name = `material[${materialIndex}][id]`;
        newRow.querySelector('.material-harga').name = `material[${materialIndex}][harga]`;
        newRow.querySelector('.material-jumlah').name = `material[${materialIndex}][jumlah]`;
        
        materialContainer.appendChild(newRow);
        materialIndex++;
    });

    // Event listener untuk container material (menangani perubahan dan hapus)
    materialContainer.addEventListener('change', function(e) {
        const target = e.target;
        if (target.classList.contains('material-select') || target.classList.contains('material-jumlah')) {
            const row = target.closest('.row');
            const select = row.querySelector('.material-select');
            const harga = select.options[select.selectedIndex].getAttribute('data-harga') || 0;
            const jumlah = parseFloat(row.querySelector('.material-jumlah').value) || 0;
            const subtotal = harga * jumlah;

            row.querySelector('.material-harga').value = harga;
            row.querySelector('.material-subtotal').value = 'Rp ' + subtotal.toLocaleString('id-ID');
            calculateTotal();
        }
    });

    materialContainer.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-material-btn')) {
            e.target.closest('.row').remove();
            calculateTotal();
        }
    });
});
</script>
<?= $this->endSection() ?>