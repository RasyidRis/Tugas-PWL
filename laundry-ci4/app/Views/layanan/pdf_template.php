<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Layanan Laundry</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
            line-height: 1.4;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            color: #059669;
            font-size: 24px;
        }
        .header p {
            margin: 5px 0 0 0;
            color: #666;
            font-size: 12px;
        }
        .meta-info {
            margin-bottom: 20px;
            font-size: 11px;
            color: #555;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .table th, .table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        .table th {
            background-color: #f2f2f2;
            color: #333;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 10px;
        }
        .table tr:nth-child(even) {
            background-color: #fafafa;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .badge {
            background-color: #e2e8f0;
            color: #4a5568;
            padding: 3px 6px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: bold;
        }
        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 10px;
            color: #aaa;
            border-top: 1px solid #eee;
            padding-top: 5px;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1 style="color: #1e293b; margin: 0 0 5px 0;">Sparkle Laundry</h1>
        <div style="color: #059669; font-size: 14px; font-weight: bold; margin-bottom: 5px;">Clean • Fresh • Shine</div>
        <p style="margin: 0; color: #666; font-size: 11px;">Laporan Daftar Jasa & Layanan Laundry Outlet</p>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th style="width: 5%;" class="text-center">No</th>
                <th style="width: 15%;" class="text-center">Gambar</th>
                <th style="width: 25%;">Nama Layanan</th>
                <th style="width: 15%;" class="text-center">Tipe Satuan</th>
                <th style="width: 15%;" class="text-right">Harga</th>
                <th style="width: 10%;" class="text-center">Estimasi Waktu</th>
                <th style="width: 15%;">Deskripsi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($layanan) && count($layanan) > 0) : ?>
                <?php $no = 1; foreach ($layanan as $item) : ?>
                    <tr>
                        <td class="text-center"><?= $no++ ?></td>
                        <td class="text-center">
                            <?php 
                            $imagePath = ROOTPATH . 'public/uploads/layanan/' . $item['gambar'];
                            if (!empty($item['gambar']) && file_exists($imagePath)) : 
                                $imageData = base64_encode(file_get_contents($imagePath));
                                $imageSrc = 'data:image/' . pathinfo($imagePath, PATHINFO_EXTENSION) . ';base64,' . $imageData;
                            ?>
                                <img src="<?= $imageSrc ?>" style="width: 65px; height: 65px; border-radius: 4px; object-fit: cover;">
                            <?php else : ?>
                                <span style="font-size: 9px; color: #999;">No Image</span>
                            <?php endif; ?>
                        </td>
                        <td><strong><?= esc($item['nama_layanan']) ?></strong></td>
                        <td class="text-center"><span class="badge">Per <?= esc($item['tipe_satuan']) ?></span></td>
                        <td class="text-right">Rp<?= number_format($item['harga'], 0, ',', '.') ?></td>
                        <td class="text-center"><?= esc($item['estimasi_waktu']) ?></td>
                        <td><?= !empty($item['deskripsi']) ? esc($item['deskripsi']) : '-' ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="7" class="text-center">Tidak ada data layanan laundry.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>



</body>
</html>
