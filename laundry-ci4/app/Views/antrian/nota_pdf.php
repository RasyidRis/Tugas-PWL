<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Nota Laundry - <?= esc($transaksi['no_antrian']) ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
            line-height: 1.4;
        }
        .invoice-card {
            width: 100%;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
        }
        .header {
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .header-title {
            color: #059669;
            font-size: 20px;
            font-weight: bold;
            margin: 0;
        }
        .header-subtitle {
            margin: 3px 0 0 0;
            color: #666;
            font-size: 11px;
        }
        .meta-table {
            width: 100%;
            margin-bottom: 20px;
            font-size: 11px;
        }
        .meta-table td {
            padding: 3px 0;
            vertical-align: top;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .table th, .table td {
            border: 1px solid #e2e8f0;
            padding: 8px;
            text-align: left;
        }
        .table th {
            background-color: #f8fafc;
            color: #475569;
            font-weight: bold;
            font-size: 10px;
            text-transform: uppercase;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .summary-table {
            width: 40%;
            margin-left: auto;
            margin-bottom: 20px;
            font-size: 11px;
        }
        .summary-table td {
            padding: 4px 0;
        }
        .badge {
            background-color: #e2e8f0;
            color: #4a5568;
            padding: 2px 5px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: bold;
        }
        .badge-success {
            background-color: #d1fae5;
            color: #065f46;
        }
        .badge-danger {
            background-color: #fee2e2;
            color: #991b1b;
        }
        .footer {
            text-align: center;
            margin-top: 40px;
            font-size: 10px;
            color: #94a3b8;
            border-top: 1px solid #e2e8f0;
            padding-top: 10px;
        }
    </style>
</head>
<body>

    <div class="invoice-card">
        <div class="header">
            <table style="width: 100%;">
                <tr>
                    <td>
                        <div class="header-title" style="color: #1e293b; font-size: 22px;">Sparkle Laundry</div>
                        <div class="header-slogan" style="color: #059669; font-size: 13px; font-weight: bold; margin-bottom: 5px;">Clean • Fresh • Shine</div>
                    </td>
                    <td style="text-align: right; vertical-align: bottom;">
                        <h2 style="margin: 0; color: #1e293b; font-size: 18px;">NOTA LAUNDRY</h2>
                        <div style="font-weight: bold; color: #475569;">No. Antrian: <?= esc($transaksi['no_antrian']) ?></div>
                    </td>
                </tr>
            </table>
        </div>

        <table class="meta-table">
            <tr>
                <td style="width: 50%;">
                    <strong>Pelanggan:</strong><br>
                    Nama: <?= esc($transaksi['member_nama']) ?><br>
                    Telp: <?= esc($transaksi['member_telepon']) ?><br>
                    Alamat: <?= esc($transaksi['member_alamat']) ?>
                </td>
                <td style="width: 50%; text-align: right;">
                    <strong>Tanggal Masuk:</strong> <?= date('d M Y H:i', strtotime($transaksi['created_at'])) ?><br>
                    <strong>Tanggal Selesai:</strong> <?= !empty($transaksi['completed_at']) ? date('d M Y H:i', strtotime($transaksi['completed_at'])) : 'Dalam Proses' ?><br>
                    <strong>Status Cucian:</strong> <span class="badge"><?= esc($transaksi['status']) ?></span>
                </td>
            </tr>
        </table>

        <table class="table">
            <thead>
                <tr>
                    <th style="width: 5%;" class="text-center">No</th>
                    <th style="width: 45%;">Layanan Laundry</th>
                    <th style="width: 15%;" class="text-right">Harga Satuan</th>
                    <th style="width: 15%;" class="text-center">Jumlah</th>
                    <th style="width: 20%;" class="text-right">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; foreach ($details as $detail) : ?>
                    <tr>
                        <td class="text-center"><?= $no++ ?></td>
                        <td>
                            <strong><?= esc($detail['nama_layanan']) ?></strong><br>
                            <span style="font-size: 9px; color: #64748b;">Estimasi: <?= esc($detail['estimasi_waktu']) ?></span>
                        </td>
                        <td class="text-right">Rp<?= number_format($detail['harga_satuan'], 0, ',', '.') ?></td>
                        <td class="text-center"><?= number_format($detail['jumlah'], 2, '.', ',') ?> <?= esc($detail['tipe_satuan']) ?></td>
                        <td class="text-right">Rp<?= number_format($detail['subtotal'], 0, ',', '.') ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <table class="summary-table">
            <tr>
                <td><strong>Total Tagihan:</strong></td>
                <td class="text-right"><strong>Rp<?= number_format($transaksi['total_harga'], 0, ',', '.') ?></strong></td>
            </tr>
            <tr>
                <td>Jumlah Bayar:</td>
                <td class="text-right">Rp<?= number_format($transaksi['bayar'], 0, ',', '.') ?></td>
            </tr>
            <tr>
                <td>Status Bayar:</td>
                <td class="text-right">
                    <span class="badge <?= ($transaksi['status_bayar'] === 'Lunas') ? 'badge-success' : 'badge-danger' ?>">
                        <?= esc($transaksi['status_bayar']) ?>
                    </span>
                </td>
            </tr>
        </table>

    </div>

</body>
</html>
