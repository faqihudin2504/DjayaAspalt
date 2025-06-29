<?= $this->extend('layout/admin_kosong') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold m-0"><?= esc($page_title ?? 'Data Pembayaran') ?></h4>
    <a href="<?= base_url('admin/pembayaran/' . $tipe . '/tambah') ?>" class="btn btn-success">
        <i class="fas fa-plus"></i> Tambah Pembayaran <?= ucfirst($tipe) ?>
    </a>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="card shadow-sm">
    <div class="card-body table-responsive p-0">
        <table class="table table-bordered table-striped table-hover mb-0">
            <thead class="table-dark">
                <tr>
                    <th>ID Bayar</th>
                    <th>Nama Pelanggan</th>
                    <th>Total Harga</th>
                    <th>Tanggal Bayar</th>
                    <th>Metode</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($pembayaran_list)): ?>
                    <tr>
                        <td colspan="7" class="text-center p-5">
                            <img src="<?= base_url('assets/table_cat_animated.gif') ?>" width="100" class="mb-3">
                            <p class="text-danger">Belum ada data pembayaran.</p>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($pembayaran_list as $item): ?>
                        <tr>
                            <td><?= esc($item['id_bayar']) ?></td>
                            <td><?= esc($item['nama_pelanggan']) ?></td>
                            <td>Rp. <?= number_format($item['total_harga'] ?? 0, 0, ',', '.') ?></td>
                            <td><?= esc(date('d M Y', strtotime($item['tanggal_pembayaran']))) ?></td>
                            <td><span class="badge bg-info"><?= esc($item['metode_pembayaran']) ?></span></td>
                            <td>
                                <?php
                                    $status = esc($item['status_pembayaran']);
                                    $badge_class = 'bg-warning text-dark';
                                    if ($status == 'Lunas') $badge_class = 'bg-success';
                                    if ($status == 'Dibatalkan') $badge_class = 'bg-danger';
                                ?>
                                <span class="badge <?= $badge_class ?>"><?= $status ?></span>
                            </td>
                            <td>
                                <?php if($item['bukti_pembayaran']): ?>
                                    <a href="<?= base_url('uploads/bukti/' . $item['bukti_pembayaran']) ?>" target="_blank" class="btn btn-primary btn-sm">Lihat Bukti</a>
                                <?php endif; ?>
                                </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>