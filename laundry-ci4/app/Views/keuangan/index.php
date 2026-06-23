<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<?php if (session()->getFlashdata('success')) : ?>
  <div class="alert alert-success alert-dismissible fade show shadow-sm border-0" role="alert">
    <div class="d-flex align-items-center gap-2">
      <iconify-icon icon="solar:check-circle-bold-duotone" class="fs-6"></iconify-icon>
      <div><?= session()->getFlashdata('success') ?></div>
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
<?php endif; ?>

<div class="row">
  
  <div class="col-sm-6 col-xl-4 mb-4">
    <div class="card overflow-hidden rounded-3 shadow-sm border-0 bg-success-subtle text-success h-100">
      <div class="card-body p-4">
        <div class="d-flex align-items-center gap-3">
          <div class="bg-success rounded-3 text-white d-flex align-items-center justify-content-center" style="width: 56px; height: 56px; flex-shrink: 0;">
            <iconify-icon icon="solar:round-arrow-up-bold-duotone" style="font-size: 32px; display: inline-block; line-height: 1;"></iconify-icon>
          </div>
          <div>
            <span class="text-success fs-2 text-uppercase fw-semibold" style="letter-spacing: 0.5px;">Total Pemasukan</span>
            <h3 class="fw-bold mb-0 text-success fs-6 mt-1">Rp<?= number_format($totalMasuk, 0, ',', '.') ?></h3>
          </div>
        </div>
      </div>
    </div>
  </div>

  
  <div class="col-sm-6 col-xl-4 mb-4">
    <div class="card overflow-hidden rounded-3 shadow-sm border-0 bg-danger-subtle text-danger h-100">
      <div class="card-body p-4">
        <div class="d-flex align-items-center gap-3">
          <div class="bg-danger rounded-3 text-white d-flex align-items-center justify-content-center" style="width: 56px; height: 56px; flex-shrink: 0;">
            <iconify-icon icon="solar:round-arrow-down-bold-duotone" style="font-size: 32px; display: inline-block; line-height: 1;"></iconify-icon>
          </div>
          <div>
            <span class="text-danger fs-2 text-uppercase fw-semibold" style="letter-spacing: 0.5px;">Total Pengeluaran</span>
            <h3 class="fw-bold mb-0 text-danger fs-6 mt-1">Rp<?= number_format($totalKeluar, 0, ',', '.') ?></h3>
          </div>
        </div>
      </div>
    </div>
  </div>

  
  <div class="col-sm-6 col-xl-4 mb-4">
    <div class="card overflow-hidden rounded-3 shadow-sm border-0 bg-primary-subtle text-primary h-100">
      <div class="card-body p-4">
        <div class="d-flex align-items-center gap-3">
          <div class="bg-primary rounded-3 text-white d-flex align-items-center justify-content-center" style="width: 56px; height: 56px; flex-shrink: 0;">
            <iconify-icon icon="solar:wallet-bold-duotone" style="font-size: 32px; display: inline-block; line-height: 1;"></iconify-icon>
          </div>
          <div>
            <span class="text-primary fs-2 text-uppercase fw-semibold" style="letter-spacing: 0.5px;">Saldo Kas Laundry</span>
            <h3 class="fw-bold mb-0 text-primary fs-6 mt-1">Rp<?= number_format($saldo, 0, ',', '.') ?></h3>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row">
  
  <div class="col-lg-8 mb-4">
    <div class="card rounded-3 shadow-sm border-0 h-100">
      <div class="card-body p-4">
        <h5 class="card-title fw-bold text-dark mb-4">Mutasi Kas Buku Ledger</h5>
        
        <div class="table-responsive">
          <table class="table text-nowrap align-middle mb-0">
            <thead class="bg-light text-dark fs-3">
              <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Tipe</th>
                <th>Keterangan</th>
                <th class="text-end">Jumlah</th>
              </tr>
            </thead>
            <tbody>
              <?php if (count($logs) > 0) : ?>
                <?php $no = 1; foreach ($logs as $item) : ?>
                  <tr>
                    <td><?= $no++ ?></td>
                    <td>
                      <span class="text-dark fs-3"><?= date('d/m/Y', strtotime($item['tanggal'])) ?></span>
                    </td>
                    <td>
                      <?php if ($item['tipe'] === 'masuk') : ?>
                        <span class="badge bg-success-subtle text-success fw-bold fs-2 rounded-3 px-2 py-1">Pemasukan</span>
                      <?php else : ?>
                        <span class="badge bg-danger-subtle text-danger fw-bold fs-2 rounded-3 px-2 py-1">Pengeluaran</span>
                      <?php endif; ?>
                    </td>
                    <td>
                      <span class="text-dark text-wrap fs-3" style="max-width: 250px;"><?= esc($item['keterangan']) ?></span>
                    </td>
                    <td class="text-end fw-bold fs-3 <?= $item['tipe'] === 'masuk' ? 'text-success' : 'text-danger' ?>">
                      <?= $item['tipe'] === 'masuk' ? '+' : '-' ?>Rp<?= number_format($item['jumlah'], 0, ',', '.') ?>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php else : ?>
                <tr>
                  <td colspan="5" class="text-center py-5">
                    <div class="d-flex flex-column align-items-center gap-2">
                      <iconify-icon icon="solar:clipboard-remove-broken" class="fs-8 text-muted"></iconify-icon>
                      <h6 class="fw-semibold text-muted mb-0">Belum ada mutasi keuangan tercatat</h6>
                    </div>
                  </td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  
  <div class="col-lg-4">
    <div class="card rounded-3 shadow-sm border-0 sticky-lg-top" style="top: 100px;">
      <div class="card-body p-4">
        <h5 class="card-title fw-bold text-dark mb-4">Catat Transaksi Manual</h5>
        
        <form action="<?= base_url('keuangan/simpan') ?>" method="POST">
          <?= csrf_field() ?>

          
          <div class="mb-3">
            <label for="tipe" class="form-label fw-semibold text-dark fs-3">Tipe Transaksi <span class="text-danger">*</span></label>
            <select name="tipe" id="tipe" class="form-select <?= isset($validation['tipe']) ? 'is-invalid' : '' ?>" required>
              <option value="" disabled selected>-- Pilih Tipe --</option>
              <option value="masuk" <?= old('tipe') === 'masuk' ? 'selected' : '' ?>>Pemasukan Kas</option>
              <option value="keluar" <?= old('tipe') === 'keluar' ? 'selected' : '' ?>>Pengeluaran Kas</option>
            </select>
            <?php if (isset($validation['tipe'])) : ?>
              <div class="invalid-feedback"><?= $validation['tipe'] ?></div>
            <?php endif; ?>
          </div>

          
          <div class="mb-3">
            <label for="jumlah" class="form-label fw-semibold text-dark fs-3">Nominal Uang (Rp) <span class="text-danger">*</span></label>
            <input type="number" name="jumlah" id="jumlah" class="form-control <?= isset($validation['jumlah']) ? 'is-invalid' : '' ?>" min="1" placeholder="Contoh: 10000" value="<?= old('jumlah') ?>" required>
            <?php if (isset($validation['jumlah'])) : ?>
              <div class="invalid-feedback"><?= $validation['jumlah'] ?></div>
            <?php endif; ?>
          </div>

          
          <div class="mb-3">
            <label for="tanggal" class="form-label fw-semibold text-dark fs-3">Tanggal Transaksi <span class="text-danger">*</span></label>
            <input type="date" name="tanggal" id="tanggal" class="form-control <?= isset($validation['tanggal']) ? 'is-invalid' : '' ?>" value="<?= old('tanggal', date('Y-m-d')) ?>" required>
            <?php if (isset($validation['tanggal'])) : ?>
              <div class="invalid-feedback"><?= $validation['tanggal'] ?></div>
            <?php endif; ?>
          </div>

          
          <div class="mb-4">
            <label for="keterangan" class="form-label fw-semibold text-dark fs-3">Keterangan / Deskripsi <span class="text-danger">*</span></label>
            <textarea name="keterangan" id="keterangan" class="form-control <?= isset($validation['keterangan']) ? 'is-invalid' : '' ?>" rows="3" placeholder="Contoh: Pembelian sabun deterjen cair 10 liter" required><?= old('keterangan') ?></textarea>
            <?php if (isset($validation['keterangan'])) : ?>
              <div class="invalid-feedback"><?= $validation['keterangan'] ?></div>
            <?php endif; ?>
          </div>

          <button type="submit" class="btn btn-primary w-100 py-2.5 rounded-3 fw-bold fs-3 shadow-sm d-flex align-items-center justify-content-center gap-1">
            <iconify-icon icon="solar:diskette-bold" class="fs-4"></iconify-icon> Simpan Transaksi
          </button>
        </form>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection() ?>
