<?= $this->extend('layout/admin_main') ?>

<?= $this->section('content') ?>
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center">
        <h1 class="h3 mb-4 text-gray-800">Pemesanan</h1>
        <div>
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-3">
            <div class="list-group">
                <a href="#" class="list-group-item list-group-item-action">Cek Paket</a>
                <a href="#" class="list-group-item list-group-item-action">Cek Stok</a>
                <a href="#" class="list-group-item list-group-item-action">Cek Pekerja</a>
            </div>
        </div>

        <div class="col-lg-9">
            <?= $this->renderSection('table_content') ?>
        </div>
    </div>
</div>
<?= $this->endSection() ?>