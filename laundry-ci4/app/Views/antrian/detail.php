<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="d-flex align-items-center justify-content-between mb-4 d-print-none">
  <a href="<?= base_url('antrian') ?>" class="btn btn-outline-secondary d-inline-flex align-items-center gap-1">
    <iconify-icon icon="solar:arrow-left-line-duotone" class="fs-5"></iconify-icon>
    Kembali ke Antrian
  </a>
  <div class="d-flex gap-2">
    <a href="<?= base_url('antrian/pdf/' . $transaksi['id']) ?>" target="_blank" class="btn btn-danger d-inline-flex align-items-center gap-1">
      <iconify-icon icon="solar:document-text-bold" class="fs-5"></iconify-icon> Unduh PDF Nota
    </a>
  </div>
</div>

<?php if (session()->getFlashdata('success')) : ?>
  <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 d-print-none" role="alert">
    <div class="d-flex align-items-center gap-2">
      <iconify-icon icon="solar:check-circle-bold-duotone" class="fs-6"></iconify-icon>
      <div><?= session()->getFlashdata('success') ?></div>
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')) : ?>
  <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 d-print-none" role="alert">
    <div class="d-flex align-items-center gap-2">
      <iconify-icon icon="solar:danger-bold-duotone" class="fs-6"></iconify-icon>
      <div><?= session()->getFlashdata('error') ?></div>
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
<?php endif; ?>

<div class="row">
  
  <div class="col-lg-8 mb-4">
    <div class="card rounded-3 shadow-sm border-0" id="printArea">
      <div class="card-body p-4 p-md-5">
        
        
        <div class="row border-bottom pb-4 mb-4">
          <div class="col-md-6 mb-3 mb-md-0">
            <h4 class="fw-bold text-dark mb-0">Sparkle Laundry</h4>
            <div class="text-primary fw-semibold fs-2 mb-2">Clean • Fresh • Shine</div>
          </div>
          <div class="col-md-6 text-md-end">
            <h4 class="fw-bold text-dark mb-1">NOTA ANTRIAN</h4>
            <span class="fs-3 fw-semibold text-muted">No: <?= esc($transaksi['no_antrian']) ?></span>
            <div class="text-muted fs-2 mt-2">Tanggal Masuk: <?= date('d M Y H:i', strtotime($transaksi['created_at'])) ?></div>
            <div class="text-muted fs-2">Tanggal Selesai: <?= !empty($transaksi['completed_at']) ? date('d M Y H:i', strtotime($transaksi['completed_at'])) : '<span class="badge bg-warning-subtle text-warning fw-bold fs-1 px-2 py-0.5 rounded">Dalam Proses</span>' ?></div>
          </div>
        </div>

        
        <div class="row mb-4 bg-light p-3 rounded-3 mx-0">
          <div class="col-sm-6 mb-2 mb-sm-0">
            <span class="text-uppercase text-muted fs-2 fw-semibold">Pelanggan</span>
            <h6 class="fw-bold text-dark mb-0 mt-1"><?= esc($transaksi['member_nama']) ?></h6>
            <span class="text-muted fs-2"><?= esc($transaksi['member_telepon']) ?></span>
          </div>
          <div class="col-sm-6 text-sm-end">
            <span class="text-uppercase text-muted fs-2 fw-semibold">Alamat Rumah</span>
            <p class="text-dark fs-3 mb-0 mt-1"><?= esc($transaksi['member_alamat']) ?></p>
          </div>
        </div>

        
        <div class="table-responsive mb-4">
          <table class="table table-bordered align-middle">
            <thead>
              <tr class="bg-light text-dark fs-3">
                <th style="width: 5%">No</th>
                <th style="width: 45%">Layanan Laundry</th>
                <th style="width: 15%" class="text-center">Jumlah</th>
                <th style="width: 15%" class="text-center">Estimasi</th>
                <th style="width: 20%" class="text-end">Subtotal</th>
              </tr>
            </thead>
            <tbody>
              <?php $no = 1; foreach ($details as $item) : ?>
                <tr>
                  <td><?= $no++ ?></td>
                  <td>
                    <h6 class="fw-semibold text-dark mb-0 fs-3"><?= esc($item['nama_layanan']) ?></h6>
                    <small class="text-muted">Rp<?= number_format($item['harga_satuan'], 0, ',', '.') ?> / <?= esc($item['tipe_satuan']) ?></small>
                  </td>
                  <td class="text-center fs-3">
                    <?= number_format($item['jumlah'], 2) ?> <?= esc($item['tipe_satuan']) ?>
                  </td>
                  <td class="text-center text-dark fs-3">
                    <?= esc($item['estimasi_waktu']) ?>
                  </td>
                  <td class="text-end fw-bold text-dark fs-3">
                    Rp<?= number_format($item['subtotal'], 0, ',', '.') ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
            <tfoot>
              <tr>
                <td colspan="4" class="text-end fw-semibold text-muted">Total Tagihan</td>
                <td class="text-end fw-bold text-dark fs-4">Rp<?= number_format($transaksi['total_harga'], 0, ',', '.') ?></td>
              </tr>
              <tr>
                <td colspan="4" class="text-end fw-semibold text-muted">Jumlah Bayar</td>
                <td class="text-end fw-bold text-success fs-3">Rp<?= number_format($transaksi['bayar'], 0, ',', '.') ?></td>
              </tr>
              <tr>
                <td colspan="4" class="text-end fw-semibold text-muted">Kekurangan</td>
                <?php $kekurangan = $transaksi['total_harga'] - $transaksi['bayar']; ?>
                <td class="text-end fw-bold <?= $kekurangan > 0 ? 'text-danger' : 'text-success' ?> fs-3">
                  Rp<?= number_format($kekurangan, 0, ',', '.') ?>
                </td>
              </tr>
            </tfoot>
          </table>
        </div>

      </div>
    </div>
  </div>

  
  <div class="col-lg-4 d-print-none">
    
    
    <div class="card rounded-3 shadow-sm border-0 mb-4">
      <div class="card-body p-4">
        <h5 class="card-title fw-bold text-dark mb-4">Status Pengerjaan</h5>
        
        <div class="mb-3">
          <span class="text-muted fs-2 text-uppercase fw-semibold">Status Saat Ini:</span>
          <?php 
            $badgeClass = 'bg-primary-subtle text-primary';
            if ($transaksi['status'] == 'Hold') {
                $badgeClass = 'bg-info-subtle text-info';
            } elseif ($transaksi['status'] == 'Cuci') {
                $badgeClass = 'bg-warning-subtle text-warning';
            } elseif ($transaksi['status'] == 'Selesai') {
                $badgeClass = 'bg-success-subtle text-success';
            } elseif ($transaksi['status'] == 'Diambil') {
                $badgeClass = 'bg-secondary-subtle text-secondary';
            }
          ?>
          <div class="mt-2">
            <span class="badge rounded-pill fw-bold fs-3 px-3 py-2 <?= $badgeClass ?>">
              <?= esc($transaksi['status']) ?>
            </span>
          </div>
        </div>

        <hr class="my-3">

        <form action="<?= base_url('antrian/update-status/' . $transaksi['id']) ?>" method="POST">
          <?= csrf_field() ?>
          <div class="mb-3">
            <label for="status" class="form-label fw-semibold text-dark fs-3">Ubah Status</label>
            <select name="status" id="status" class="form-select">
              <option value="Hold" <?= $transaksi['status'] === 'Hold' ? 'selected' : '' ?>>Hold (Tunda)</option>
              <option value="Cuci" <?= $transaksi['status'] === 'Cuci' ? 'selected' : '' ?>>Cuci (Antrian Cuci)</option>
              <option value="Dalam Proses" <?= $transaksi['status'] === 'Dalam Proses' ? 'selected' : '' ?>>Dalam Proses (Sedang Dicuci)</option>
              <option value="Selesai" <?= $transaksi['status'] === 'Selesai' ? 'selected' : '' ?>>Selesai (Siap Diambil)</option>
              <option value="Diambil" <?= $transaksi['status'] === 'Diambil' ? 'selected' : '' ?> <?= $transaksi['status_bayar'] !== 'Lunas' ? 'disabled' : '' ?>>Diambil (Selesai & Diserahkan)</option>
            </select>
            <?php if ($transaksi['status_bayar'] !== 'Lunas') : ?>
              <small class="text-danger mt-1 d-block"><iconify-icon icon="solar:danger-line-duotone" class="align-middle"></iconify-icon> Pilihan 'Diambil' terkunci hingga pembayaran Lunas.</small>
            <?php endif; ?>
          </div>

          <button type="submit" class="btn btn-primary w-100 py-2.5 rounded-3 fw-bold fs-3 shadow-sm">Perbarui Status</button>
        </form>
      </div>
    </div>

    
    <?php if ($transaksi['status_bayar'] !== 'Lunas') : ?>
      <div class="card rounded-3 shadow-sm border-0 mb-4">
        <div class="card-body p-4">
          <h5 class="card-title fw-bold text-dark mb-4">Pelunasan Pembayaran</h5>
          
          <div class="mb-3">
            <span class="text-muted fs-2 text-uppercase fw-semibold">Kekurangan Tagihan:</span>
            <h4 class="fw-bold text-danger mt-1">Rp<?= number_format($kekurangan, 0, ',', '.') ?></h4>
          </div>

          <hr class="my-3">

          <form action="<?= base_url('antrian/bayar/' . $transaksi['id']) ?>" method="POST">
            <?= csrf_field() ?>
            <div class="mb-3">
              <label for="bayar_input" class="form-label fw-semibold text-dark fs-3">Nominal Bayar (Rp)</label>
              <input type="number" name="bayar" id="bayar_input" class="form-control" min="1" max="<?= $kekurangan ?>" value="<?= $kekurangan ?>" required>
            </div>

            <button type="submit" class="btn btn-success w-100 py-2.5 rounded-3 fw-bold fs-3 text-white shadow-sm d-flex align-items-center justify-content-center gap-1">
              <iconify-icon icon="solar:wad-of-money-bold" class="fs-5"></iconify-icon> Proses Pembayaran
            </button>
          </form>
        </div>
      </div>
    <?php else : ?>
      <div class="card rounded-3 shadow-sm border-0 bg-success-subtle border-success mb-4 text-center">
        <div class="card-body p-4">
          <iconify-icon icon="solar:check-circle-bold-duotone" class="fs-9 text-success mb-2"></iconify-icon>
          <h5 class="fw-bold text-success">Pembayaran Lunas</h5>
          <p class="text-success mb-0 fs-2">Antrian ini telah diselesaikan administrasinya.</p>
        </div>
      </div>
    <?php endif; ?>

  </div>
</div>

<style>
  @media print {
    body {
      background: none !important;
      color: #000 !important;
    }
    .left-sidebar, .app-header, .d-print-none, footer, .py-6 {
      display: none !important;
    }
    .body-wrapper {
      margin-left: 0 !important;
      padding: 0 !important;
    }
    .container-fluid {
      padding: 0 !important;
    }
    .col-lg-8 {
      width: 100% !important;
    }
    .card {
      box-shadow: none !important;
      border: none !important;
    }
    #printArea {
      margin: 0 !important;
      padding: 0 !important;
    }
  }
</style>

<script>
function printPdf(url) {
    // Buat iframe tersembunyi
    const iframe = document.createElement('iframe');
    iframe.style.display = 'none';
    iframe.src = url;
    document.body.appendChild(iframe);
    
    // Tunggu PDF ter-load, lalu cetak
    iframe.onload = function() {
        iframe.contentWindow.focus();
        iframe.contentWindow.print();
        
        // Bersihkan iframe setelah 3 detik
        setTimeout(() => {
            document.body.removeChild(iframe);
        }, 3000);
    };
}
</script>

<?= $this->endSection() ?>
