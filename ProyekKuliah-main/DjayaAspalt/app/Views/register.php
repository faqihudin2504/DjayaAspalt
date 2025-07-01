<?= $this->extend('layout/login_template') ?>

<?= $this->section('content') ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-lg">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Buat Akun Baru!</h1>
                                </div>

                                <?php if(session()->getFlashdata('error')): ?>
                                    <div class="alert alert-danger" role="alert">
                                        <?= session()->getFlashdata('error') ?>
                                    </div>
                                <?php endif; ?>
                                
                                <form class="user" action="<?= base_url('register/save') ?>" method="post">
                                    <?= csrf_field() ?>
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-user" name="username"
                                            placeholder="Username" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="email" class="form-control form-control-user" name="email"
                                            placeholder="Alamat Email" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-user" name="no_telpon"
                                            placeholder="Nomor Telepon" required>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <input type="password" class="form-control form-control-user"
                                                name="password" placeholder="Password" required>
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="password" class="form-control form-control-user"
                                                name="password_confirm" placeholder="Ulangi Password" required>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-user btn-block">
                                        Daftarkan Akun
                                    </button>
                                </form>
                                <hr>
                                <div class="text-center">
                                    <a class="small" href="<?= base_url('login') ?>">Sudah Punya Akun? Login!</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>