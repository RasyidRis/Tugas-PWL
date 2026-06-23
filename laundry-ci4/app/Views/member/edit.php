<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<a href="<?= base_url('member') ?>" class="btn btn-outline-secondary d-inline-flex align-items-center gap-1 mb-4">
  <iconify-icon icon="solar:arrow-left-line-duotone" class="fs-5"></iconify-icon>
  Kembali ke Daftar Member
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
            <h5 class="card-title fw-semibold mb-1">Edit Detail Member</h5>
            <p class="card-subtitle mb-0">Ubah informasi rincian pelanggan</p>
          </div>
        </div>

        <form action="<?= base_url('member/update/' . $member['id']) ?>" method="POST">
          <?= csrf_field() ?>

          
          <div class="mb-3">
            <label for="nama" class="form-label fw-semibold text-dark">Nama Pelanggan <span class="text-danger">*</span></label>
            <input type="text" 
                   name="nama" 
                   class="form-control <?= isset($validation['nama']) ? 'is-invalid' : '' ?>" 
                   id="nama" 
                   placeholder="Contoh: Agus Hartono"
                   value="<?= old('nama', $member['nama']) ?>" 
                   required>
            <?php if (isset($validation['nama'])) : ?>
              <div class="invalid-feedback"><?= $validation['nama'] ?></div>
            <?php endif; ?>
          </div>

          <div class="row">
            
            <div class="col-md-6 mb-3">
              <label for="telepon" class="form-label fw-semibold text-dark">Nomor Telepon <span class="text-danger">*</span></label>
              <input type="text" 
                     name="telepon" 
                     class="form-control <?= isset($validation['telepon']) ? 'is-invalid' : '' ?>" 
                     id="telepon" 
                     placeholder="Contoh: 08123456789"
                     value="<?= old('telepon', $member['telepon']) ?>" 
                     required>
              <?php if (isset($validation['telepon'])) : ?>
                <div class="invalid-feedback"><?= $validation['telepon'] ?></div>
              <?php endif; ?>
            </div>

            
            <div class="col-md-6 mb-3">
              <label for="poin" class="form-label fw-semibold text-dark">Poin Loyalty</label>
              <input type="number" 
                     name="poin" 
                     class="form-control <?= isset($validation['poin']) ? 'is-invalid' : '' ?>" 
                     id="poin" 
                     min="0"
                     placeholder="Contoh: 0"
                     value="<?= old('poin', $member['poin']) ?>">
              <?php if (isset($validation['poin'])) : ?>
                <div class="invalid-feedback"><?= $validation['poin'] ?></div>
              <?php endif; ?>
            </div>
          </div>

          
          <div class="mb-4">
            <label for="alamat" class="form-label fw-semibold text-dark">Alamat Lengkap <span class="text-danger">*</span></label>
            <textarea name="alamat" 
                      class="form-control <?= isset($validation['alamat']) ? 'is-invalid' : '' ?>" 
                      id="alamat" 
                      rows="4" 
                      placeholder="Masukkan alamat tinggal lengkap pelanggan..." 
                      required><?= old('alamat', $member['alamat']) ?></textarea>
            <?php if (isset($validation['alamat'])) : ?>
              <div class="invalid-feedback"><?= $validation['alamat'] ?></div>
            <?php endif; ?>
          </div>

          
          <div class="d-flex gap-2 justify-content-end border-top pt-3">
            <a href="<?= base_url('member') ?>" class="btn btn-light">Batal</a>
            <button type="submit" class="btn btn-primary d-flex align-items-center gap-1">
              <iconify-icon icon="solar:diskette-bold-duotone" class="fs-5"></iconify-icon>
              Simpan Perubahan
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection() ?>
