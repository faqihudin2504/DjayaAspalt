<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="container py-4">
    <div class="d-flex align-items-center mb-4">
        <a href="javascript:history.back()" class="me-3">
            <img src="<?= base_url('assets/Back-01.png') ?>" width="43" alt="Back">
        </a>
        <h2 class="mb-0">Profile</h2>
    </div>

    <div class="row">
        <div class="col-md-4 text-center">
            <img src="/assets/profile/pro1.png" class="img-fluid rounded mb-3" alt="Pekerjaan Pengaspalan">
            <div class="d-flex justify-content-center align-items-center mb-3">
                <img src="/assets/hubungi-kami/wa.png" style="width: 30px; margin-right: 10px;" alt="Whatsapp Icon">
                <h4 class="mb-0">+62 813 2420 1464</h4>
            </div>
            <img src="<?= base_url('assets/worker_with_shovel.png') ?>" class="img-fluid mt-4" style="max-width: 150px;" alt="Worker">
        </div>

        <div class="col-md-8">
            <div class="card p-4 shadow-sm mb-4">
                <h2 class="text-center mb-3">Tentang CV. Djaya Aspalt</h2>
                <h4 class="text-center mb-4">Kontraktor Aspal Jalan Terpercaya & Berpengalaman</h4>
                <p class="card-text">
                    CV. Djaya Aspalt merupakan perusahaan yang menyediakan jasa di bidang kontraktor jalan. Sebagai perusahaan yang sudah berpengalaman dan terpercaya, kami menyediakan jasa pengaspalan jalan, pemasangan paving block, cor beton dan lain sebagainya.
                </p>
                <p class="card-text">
                    Kami mempunyai tim yang profesional dan siap mengerjakan pesanan Anda dengan cepat menggunakan alat yang canggih dan modern. Oleh karena itu kami adalah pilihan terbaik untuk proyek jalan dan lapangan Anda.
                </p>
            </div>

            <div class="card p-4 shadow-sm mb-4">
                <h2 class="card-title text-center mb-4">Profil Djaya Aspalt</h2>
                <p class="card-text">
                    Anda membutuhkan kontraktor jasa pengaspalan yang bisa diandalkan? Selama bertahun-tahun kami telah banyak menyelesaikan proyek konstruksi jalan, baik itu proses awal cut and fill (galian dan urugan) maupun perbaikan jalan. Jasa aspal jalan kami dilakukan secara profesional oleh SDM yang ahli di bidangnya dan didukung oleh peralatan berat yang sangat memadai.
                </p>
            </div>

            <div class="card p-4 shadow-sm mb-4">
                <h2 class="card-title text-center mb-4">Mengapa Anda Harus Memilih Djaya Aspalt?</h2>
                <p class="text-center">Sebelum menggunakan jasa pengaspalan kami, silakan cek keunggulan layanan kami:</p>
                
                <ol class="pl-3" style="list-style-position: inside; padding-left: 0;">
                    <li class="mb-3">
                        <strong>Berpengalaman</strong><br>
                        Perusahaan kami sudah berpengalaman mengerjakan banyak proyek besar maupun kecil.
                    </li>
                    <li class="mb-3">
                        <strong>Profesional</strong><br>
                        Perusahaan kami memiliki tenaga yang profesional dan ahli dalam mengoperasikan alat berat.
                    </li>
                    <li class="mb-3">
                        <strong>Proses Cepat</strong><br>
                        Proses pengerjaan menggunakan alat canggih dan modern untuk efisiensi waktu.
                    </li>
                    <li class="mb-3">
                        <strong>Bergaransi</strong><br>
                        Garansi pekerjaan sesuai kesepakatan di awal perjanjian.
                    </li>
                    <li class="mb-3">
                        <strong>Terepercaya</strong><br>
                        Telah dipercaya menyelesaikan banyak proyek besar.
                    </li>
                </ol>
            </div>

            <div class="card p-4 shadow-sm mb-4">
                <h2 class="card-title text-center mb-4">Layanan Kami</h2>
                <p class="card-text">
                    Kami akan mengerjakan sesuai dengan keinginan anda, bisa hanya pelapisan atau mulai dari 0 sampai dengan selesai. Adapun layanan kami adalah: jasa pengaspalan jalan, Jasa pengaspalan halaman runah, Jasa pengaspalan halaman parkir, Jasa pemasangan paving block, Jasa cor beton, dan lain sebagainya.
                </p>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>