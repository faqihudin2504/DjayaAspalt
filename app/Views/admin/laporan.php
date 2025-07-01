<?= $this->extend('layout/admin_kosong'); ?>

<?= $this->section('content'); ?>
<div class="section">
    <div class="section-header">
        <h1>Laporan Transaksi</h1>
    </div>

    <div class="card">
        <div class="card-header">
            <h4>Filter Laporan</h4>
        </div>
        <div class="card-body">
            <form action="<?= base_url('admin/laporan') ?>" method="post">
                <?= csrf_field() ?>
                <div class="row">
                    <div class="col-md-5">
                        <select name="bulan" class="form-select">
                            <?php for ($i = 1; $i <= 12; $i++) : ?>
                                <option value="<?= $i; ?>" <?= ($i == $bulan) ? 'selected' : ''; ?>>
                                    <?= date('F', mktime(0, 0, 0, $i, 10)); ?>
                                </option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="col-md-5">
                        <select name="tahun" class="form-select">
                            <?php for ($i = date('Y'); $i >= date('Y') - 5; $i--) : ?>
                                <option value="<?= $i; ?>" <?= ($i == $tahun) ? 'selected' : ''; ?>>
                                    <?= $i; ?>
                                </option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">Tampilkan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4>Data Laporan Bulan <?= date('F', mktime(0, 0, 0, $bulan, 10)); ?> Tahun <?= $tahun; ?></h4>
            <?php if (!empty($laporan)) : ?>
                <a href="<?= base_url('admin/laporan/cetak?bulan=' . $bulan . '&tahun=' . $tahun); ?>" class="btn btn-success" target="_blank">
                    Cetak PDF
                </a>
            <?php endif; ?>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>ID Transaksi</th>
                        <th>Nama Pelanggan</th>
                        <th>Tanggal</th>
                        <th>Total Harga</th>
                        <th>Jenis Transaksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($laporan)) : ?>
                        <?php $no = 1;
                        foreach ($laporan as $row) : ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= esc($row['id_transaksi']); ?></td>
                                <td><?= esc($row['nama_pelanggan']); ?></td>
                                <td><?= date('d F Y', strtotime($row['tanggal'])); ?></td>
                                <td>Rp <?= number_format($row['total_harga'], 0, ',', '.'); ?></td>
                                <td>
                                    <span class="badge text-dark <?= ($row['tipe_transaksi'] == 'Penyewaan') ? 'bg-info' : 'bg-warning'; ?>">
                                        <?= esc($row['tipe_transaksi']); ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada data untuk periode ini.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>