<?= $this->extend('layout/admin_kosong') ?>
<?= $this->section('content') ?>
<style>
    .card-revisi { border-radius: 15px; background-color: #fff; box-shadow: 0 2px 4px rgba(0,0,0,0.1); border: none; }
    .card-revisi .card-header { background-color: #ff9933; color: black; font-weight: bold; border-top-left-radius: 15px; border-top-right-radius: 15px; padding: 1rem 1.5rem; }
    .table thead th { background-color: #343a40; color: white; text-align: center; font-weight: 600; vertical-align: middle; }
    .table tbody td { text-align: center; vertical-align: middle; }
    .action-buttons .btn { color: white; font-weight: bold; padding: 0.25rem 0.5rem; font-size: 0.8rem; }
    .empty-state { padding: 4rem; text-align: center; } .empty-state img { max-width: 150px; margin-bottom: 1.5rem; }
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold m-0"><?= esc($page_title) ?></h4>
    <a href="#" class="btn btn-success">Tambahkan Pengembalian</a>
</div>

<div class="card card-revisi">
    <div class="card-header">Data Pengembalian</div>
    <div class="card-body table-responsive p-0">
        <table class="table table-bordered table-striped mb-0">
            <thead>
                <tr><th>ID Kembali</th><th>ID Sewa</th><th>Denda</th><th>Tanggal Kembali</th><th>Aksi</th></tr>
            </thead>
            <tbody>
                <tr><td colspan="5"><div class="empty-state"><img src="<?= base_url('assets/table_cat_animated.gif') ?>"><h5 class="text-danger">Tidak Ada Data Pengembalian</h5></div></td></tr>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>