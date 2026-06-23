<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<a href="<?= base_url('layanan') ?>" class="btn btn-outline-secondary d-inline-flex align-items-center gap-1 mb-4">
  <iconify-icon icon="solar:arrow-left-line-duotone" class="fs-5"></iconify-icon>
  Kembali ke Dashboard
</a>

<div class="row justify-content-center">
  <div class="col-lg-8">
    <div class="card shadow-sm border-0">
      <div class="card-body p-4">
        <div class="d-flex align-items-center gap-3 border-bottom pb-3 mb-4">
          <div class="p-3 bg-warning-subtle text-warning rounded-circle d-flex align-items-center justify-content-center">
            <iconify-icon icon="solar:pen-bold-duotone" class="fs-7"></iconify-icon>
          </div>
          <div>
            <h5 class="card-title fw-semibold mb-1">Edit Layanan Laundry</h5>
            <p class="card-subtitle mb-0">Ubah informasi jenis layanan laundry Anda</p>
          </div>
        </div>

        <form action="<?= base_url('layanan/update/' . $layanan['id']) ?>" method="POST">
          <?= csrf_field() ?>

          
          <div class="mb-3">
            <label for="nama_layanan" class="form-label fw-semibold text-dark">Nama Layanan <span class="text-danger">*</span></label>
            <input type="text" 
                   name="nama_layanan" 
                   class="form-control <?= isset($validation['nama_layanan']) ? 'is-invalid' : '' ?>" 
                   id="nama_layanan" 
                   placeholder="Contoh: Cuci Kering & Setrika Kemeja"
                   value="<?= old('nama_layanan', $layanan['nama_layanan']) ?>" 
                   required>
            <?php if (isset($validation['nama_layanan'])) : ?>
              <div class="invalid-feedback"><?= $validation['nama_layanan'] ?></div>
            <?php endif; ?>
          </div>

          <div class="row">
            
            <div class="col-md-6 mb-3">
              <label for="tipe_satuan" class="form-label fw-semibold text-dark">Tipe Satuan <span class="text-danger">*</span></label>
              <select name="tipe_satuan" 
                      class="form-select <?= isset($validation['tipe_satuan']) ? 'is-invalid' : '' ?>" 
                      id="tipe_satuan" 
                      required>
                <option value="" disabled>-- Pilih Satuan --</option>
                <option value="Kg" <?= old('tipe_satuan', $layanan['tipe_satuan']) === 'Kg' ? 'selected' : '' ?>>Kg (Kilogram)</option>
                <option value="Pcs" <?= old('tipe_satuan', $layanan['tipe_satuan']) === 'Pcs' ? 'selected' : '' ?>>Pcs (Satuan)</option>
                <option value="Meter" <?= old('tipe_satuan', $layanan['tipe_satuan']) === 'Meter' ? 'selected' : '' ?>>Meter (Karpet/Gordyn)</option>
              </select>
              <?php if (isset($validation['tipe_satuan'])) : ?>
                <div class="invalid-feedback"><?= $validation['tipe_satuan'] ?></div>
              <?php endif; ?>
            </div>

            
            <div class="col-md-6 mb-3">
              <label for="harga" class="form-label fw-semibold text-dark">Harga (Rp) <span class="text-danger">*</span></label>
              <div class="input-group">
                <span class="input-group-text bg-light text-dark fw-semibold">Rp</span>
                <input type="number" 
                       name="harga" 
                       class="form-control <?= isset($validation['harga']) ? 'is-invalid' : '' ?>" 
                       id="harga" 
                       min="0"
                       placeholder="Contoh: 15000"
                       value="<?= old('harga', $layanan['harga']) ?>" 
                       required>
                <?php if (isset($validation['harga'])) : ?>
                  <div class="invalid-feedback d-block"><?= $validation['harga'] ?></div>
                <?php endif; ?>
              </div>
            </div>
          </div>

          
          <div class="mb-3">
            <label for="estimasi_waktu" class="form-label fw-semibold text-dark">Estimasi Waktu Pengerjaan <span class="text-danger">*</span></label>
            <input type="text" 
                   name="estimasi_waktu" 
                   class="form-control <?= isset($validation['estimasi_waktu']) ? 'is-invalid' : '' ?>" 
                   id="estimasi_waktu" 
                   placeholder="Contoh: 2 Hari, 24 Jam, 6 Jam (Express)"
                   value="<?= old('estimasi_waktu', $layanan['estimasi_waktu']) ?>" 
                   required>
            <?php if (isset($validation['estimasi_waktu'])) : ?>
              <div class="invalid-feedback"><?= $validation['estimasi_waktu'] ?></div>
            <?php endif; ?>
          </div>

          
          <div class="mb-4">
            <label for="deskripsi" class="form-label fw-semibold text-dark">Deskripsi Layanan (Opsional)</label>
            <textarea name="deskripsi" 
                      class="form-control <?= isset($validation['deskripsi']) ? 'is-invalid' : '' ?>" 
                      id="deskripsi" 
                      rows="4" 
                      placeholder="Masukkan detail penjelasan mengenai layanan laundry ini..."><?= old('deskripsi', $layanan['deskripsi']) ?></textarea>
            <?php if (isset($validation['deskripsi'])) : ?>
              <div class="invalid-feedback"><?= $validation['deskripsi'] ?></div>
            <?php endif; ?>
          </div>

          
          <div class="d-flex gap-2 justify-content-end border-top pt-3">
            <a href="<?= base_url('layanan') ?>" class="btn btn-light">Batal</a>
            <button type="submit" class="btn btn-warning d-flex align-items-center gap-1 text-white">
              <iconify-icon icon="solar:diskette-bold-duotone" class="fs-5"></iconify-icon>
              Perbarui Layanan
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection() ?>
