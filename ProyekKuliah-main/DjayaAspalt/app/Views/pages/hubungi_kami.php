<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="container py-4">
    <div class="d-flex align-items-center mb-4">
        <a href="javascript:history.back()" class="me-3">
            <img src="<?= base_url('assets/Back-01.png') ?>" width="43" alt="Back">
        </a>
        <h2 class="mb-0">Hubungi Kami</h2>
    </div>

    <div class="row">
        <div class="col-md-4 text-center">
            <img src="/assets/profile/pro1.png" class="img-fluid rounded mb-3" alt="Pekerjaan Pengaspalan">
            <h4 class="mb-3">+62 813 2420 1464</h4>

            <a href="https://wa.me/6281324201464" target="_blank" class="btn btn-success d-block mb-3 py-2">
                <img src="/assets/hubungi-kami/wa.png" style="width: 24px; margin-right: 10px;" alt="Whatsapp Kami"> Whatsapp kami
            </a>
            <a href="mailto:sukatmaesco@gmail.com" class="btn btn-danger d-block mb-3 py-2">
                <img src="/assets/hubungi-kami/email.png" style="width: 24px; margin-right: 10px;" alt="Email Kami"> Email kami
            </a>
            <a href="https://www.google.com/search?q=djaya+asplat+jl.abdul+wahid&oq=djaya+asplat+jl.abdul&gs_lcrp=EgZjaHJvbWUqCQgCECEYChigATIGCAAQRRg5MgkIARAhGAoYoAEyCQgCECEYChigATIHCAMQIRiPAtIBCjEzMDM3ajBqMTWoAgiwAgE&sourceid=chrome&ie=UTF-8&lqi=ChxkamF5YSBhc3BoYWx0IGpsLmFiZHVsIHdhaGlkSJ-kt8bQs4CACFooEAAQARgAGAEYAiIcZGpheWEgYXNwaGFsdCBqbCBhYmR1bCB3YWhpZJIBGXJvYWRfY29uc3RydWN0aW9uX2NvbXBhbnmaASRDaGREU1VoTk1HOW5TMFZKUTBGblNVUkdPRXBoVkhSQlJSQUKqAVgQASoRIg1kamF5YSBhc3BoYWx0KCYyHxABIhsPhG-uB3d57LTddSM_wioWzMaZ9Tbm8qXYPgIyIBACIhxkamF5YSBphYWx0IGpsIGFiZHVsIHdhaGlk-gEECAAQRw#rlimm=1399669793285660123" target="_blank" class="btn btn-info d-block mb-3 py-2">
                <img src="/assets/hubungi-kami/alamat.png" style="width: 24px; margin-right: 10px;" alt="Alamat Kami"> Alamat Kami
            </a>
            <img src="<?= base_url('assets/road_block_icon.png') ?>" class="img-fluid mt-4" style="max-width: 150px;" alt="Road Block">
        </div>

        <div class="col-md-8">
            <div class="card p-4 shadow-sm mb-4">
                <h2 class="fw-bold">Hubungi Kami</h2>
                <h4>CV. Djaya Aspalt</h4>
                <p>Perusahaan jasa pengaspalan jalan dan kontraktor jalan yang berpengalaman dalam melayani jasa pengaspalan dan pemasangan Paving Block/Conblock.</p>
            </div>

            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="card p-3 shadow-sm h-100">
                        <h5>Contact details:</h5>
                        <p>Apakah Anda Punya <br>Pertanyaan?</p>
                        <p><strong>Email:</strong><br><a href="mailto:sukatmaesco@gmail.com">sukatmaesco@gmail.com</a></p>
                        <p><strong>Telepon:</strong><br><a href="tel:+6281324201464">+62 813 2420 1464</a></p>
                        <p><strong>Jam Operasional:</strong><br>Senin - Sabtu: 08.00 - 17.00 WIB</p>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="card p-3 shadow-sm h-100">
                        <h5>Kirim Pesan kepada Kami</h5>
                        <form>
                            <div class="mb-2">
                                <input type="text" class="form-control" placeholder="Your name">
                            </div>
                            <div class="mb-2">
                                <input type="email" class="form-control" placeholder="Your e-mail">
                            </div>
                            <div class="mb-2">
                                <input type="text" class="form-control" placeholder="Subject">
                            </div>
                            <div class="mb-2">
                                <textarea class="form-control" rows="4" placeholder="Message"></textarea>
                            </div>
                            <button type="submit" class="btn btn-info">SEND A MESSAGE</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="card p-4 shadow-sm mb-4">
                <h4>Kontraktor Aspal Jalan Terpercaya & Berpengalaman</h4>
                <p>Kenapa anda harus memilih CV. Djaya Aspalt?</p>
                <p>Di CV. Djaya Aspalt, kami memiliki tim professional dan menggunakan alat-alat canggih serta modern.</p>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>