<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Transaksi</title>
    <style>
        @page {
            margin: 25px 40px;
        }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 12px;
            color: #333;
        }
        .kop-surat {
            width: 100%;
            border-bottom: 3px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .kop-surat td {
            vertical-align: middle;
        }
        .logo {
            width: 80px;
        }
        .info-perusahaan {
            padding-left: 20px;
        }
        .info-perusahaan h1 {
            font-size: 18px;
            margin: 0;
            font-weight: bold;
        }
        .info-perusahaan p {
            font-size: 11px;
            margin: 2px 0;
        }
        .judul-laporan {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            text-decoration: underline;
            margin-bottom: 5px;
        }
        .periode {
            text-align: center;
            font-size: 12px;
            margin-bottom: 25px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        .table th, .table td {
            border: 1px solid #999;
            padding: 8px;
            text-align: left;
        }
        .table th {
            background-color: #f2f2f2;
            text-align: center;
            font-weight: bold;
        }
        .text-center {
            text-align: center;
        }
        .footer {
            margin-top: 50px;
            width: 100%;
        }
        .tanda-tangan {
            width: 250px;
            float: right;
            text-align: center;
        }
        .tanda-tangan p {
            margin-bottom: 60px;
        }
    </style>
</head>
<body>
    
    <table class="kop-surat">
        <tr>
            <td>
                <img src="<?= FCPATH . 'assets/logo.png' ?>" alt="Logo" class="logo">
            </td>
            <td class="info-perusahaan">
                <h1>CV. DJAYA ASPALT</h1>
                <p>Kontraktor Aspal Jalan Terpercaya & Berpengalaman</p>
                <p>Jl. Abdul Wahab No 18 RT 04 RW 08 Kelurahan Kedaung Kec. Sawangan, Depok. | Telp: +62 813 2420 1464 | Email: sukatmaesco@gmail.com</p>
            </td>
        </tr>
    </table>

    <h3 class="judul-laporan">LAPORAN TRANSAKSI</h3>
    <p class="periode">
        Periode: <?= \CodeIgniter\I18n\Time::createFromDate($tahun, $bulan, 1)->toLocalizedString('MMMM YYYY'); ?>
    </p>

    <table class="table">
        <thead>
            <tr>
                <th style="width:5%;">No</th>
                <th style="width:18%;">ID Transaksi</th>
                <th>Nama Pelanggan</th>
                <th style="width:15%;">Tanggal</th>
                <th style="width:18%;">Total Harga</th>
                <th style="width:15%;">Jenis</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($laporan)) : ?>
                <?php $no = 1; foreach ($laporan as $row) : ?>
                    <tr>
                        <td class="text-center"><?= $no++; ?></td>
                        <td><?= esc($row['id_transaksi']); ?></td>
                        <td><?= esc($row['nama_pelanggan']); ?></td>
                        <td class="text-center"><?= date('d-m-Y', strtotime($row['tanggal'])); ?></td>
                        <td style="text-align: right;">Rp <?= number_format($row['total_harga'], 0, ',', '.'); ?></td>
                        <td class="text-center"><?= esc($row['tipe_transaksi']); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="6" class="text-center">Tidak ada data transaksi untuk periode ini.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="footer">
        <div class="tanda-tangan">
            <p>Depok, <?= \CodeIgniter\I18n\Time::now()->toLocalizedString('d MMMM YYYY'); ?></p>
            <p><strong>(___________________)</strong><br>Pimpinan</p>
        </div>
    </div>

</body>
</html>