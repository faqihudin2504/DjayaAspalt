<?= $this->extend('layout/admin_main') ?>
<?= $this->section('content') ?>
<div class="card shadow-sm">
    <div class="card-header fw-bold">Daftar Semua Pengembalian</div>
    <div class="card-body table-responsive p-0">
        <table class="table table-bordered table-striped table-hover mb-0">
            <thead class="table-dark">
                <tr>
                    <th>ID Kembali</th>
                    <th>ID Sewa</th> <th>Nama Alat Di Sewa</th>
                    <th>Denda Kembali</th>
                    <th>Tanggal Kembali</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($pengembalian_list)): ?>
                    <?php else: ?>
                    <?php foreach ($pengembalian_list as $item): ?>
                        <tr>
                            <td><?= esc($item['id_kembali']) ?></td>
                            <td><?= esc($item['id_sewa']) ?></td>
                            <td><?= esc($item['nama_alat']) ?></td>
                            <td>Rp. <?= number_format($item['denda_kembali'] ?? 0, 0, ',', '.') ?></td>
                            <td><?= esc(date('d-m-Y', strtotime($item['tanggal_pengembalian']))) ?></td>
                            <td>
                                <a href="#" class="btn btn-dark btn-sm">Lihat</a>
                                <a href="#" class="btn btn-warning btn-sm">Ubah</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>