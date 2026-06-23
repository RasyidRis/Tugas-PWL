<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<a href="<?= base_url('user-management') ?>" class="btn btn-outline-secondary d-inline-flex align-items-center gap-1 mb-4">
  <iconify-icon icon="solar:arrow-left-line-duotone" class="fs-5"></iconify-icon>
  Kembali ke User Management
</a>

<div class="row justify-content-center">
  <div class="col-lg-8">
    <div class="card shadow-sm border-0">
      <div class="card-body p-4">
        <div class="d-flex align-items-center gap-3 border-bottom pb-3 mb-4">
          <div class="p-3 bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center">
            <iconify-icon icon="solar:user-plus-bold-duotone" class="fs-7"></iconify-icon>
          </div>
          <div>
            <h5 class="card-title fw-semibold mb-1">Tambah User Hak Akses</h5>
            <p class="card-subtitle mb-0">Daftarkan akun pengguna baru untuk akses kasir atau admin</p>
          </div>
        </div>

        <form action="<?= base_url('user-management/simpan') ?>" method="POST">
          <?= csrf_field() ?>

          
          <div class="mb-3">
            <label for="username" class="form-label fw-semibold text-dark">Nama Pengguna (Username) <span class="text-danger">*</span></label>
            <input type="text" 
                   name="username" 
                   class="form-control <?= isset($validation['username']) ? 'is-invalid' : '' ?>" 
                   id="username" 
                   placeholder="Contoh: kasir_laundry"
                   value="<?= old('username') ?>" 
                   required>
            <?php if (isset($validation['username'])) : ?>
              <div class="invalid-feedback"><?= $validation['username'] ?></div>
            <?php endif; ?>
          </div>

          
          <div class="mb-3">
            <label for="email" class="form-label fw-semibold text-dark">Alamat Email <span class="text-danger">*</span></label>
            <input type="email" 
                   name="email" 
                   class="form-control <?= isset($validation['email']) ? 'is-invalid' : '' ?>" 
                   id="email" 
                   placeholder="Contoh: kasir@laundry.com"
                   value="<?= old('email') ?>" 
                   required>
            <?php if (isset($validation['email'])) : ?>
              <div class="invalid-feedback"><?= $validation['email'] ?></div>
            <?php endif; ?>
          </div>

          <div class="row">
            
            <div class="col-md-6 mb-3">
              <label for="password" class="form-label fw-semibold text-dark">Kata Sandi <span class="text-danger">*</span></label>
              <input type="password" 
                     name="password" 
                     class="form-control <?= isset($validation['password']) ? 'is-invalid' : '' ?>" 
                     id="password" 
                     placeholder="Min. 6 Karakter"
                     required>
              <?php if (isset($validation['password'])) : ?>
                <div class="invalid-feedback"><?= $validation['password'] ?></div>
              <?php endif; ?>
            </div>

            
            <div class="col-md-6 mb-4">
              <label for="role" class="form-label fw-semibold text-dark">Hak Akses (Role) <span class="text-danger">*</span></label>
              <select name="role" id="role" class="form-select <?= isset($validation['role']) ? 'is-invalid' : '' ?>" required>
                <option value="" disabled <?= empty(old('role')) ? 'selected' : '' ?>>-- Pilih Hak Akses --</option>
                <option value="kasir" <?= old('role') === 'kasir' ? 'selected' : '' ?>>Kasir / Operator</option>
                <option value="admin" <?= old('role') === 'admin' ? 'selected' : '' ?>>Administrator</option>
              </select>
              <?php if (isset($validation['role'])) : ?>
                <div class="invalid-feedback"><?= $validation['role'] ?></div>
              <?php endif; ?>
            </div>
          </div>

          
          <div class="d-flex gap-2 justify-content-end border-top pt-3">
            <a href="<?= base_url('user-management') ?>" class="btn btn-light">Batal</a>
            <button type="submit" class="btn btn-primary d-flex align-items-center gap-1">
              <iconify-icon icon="solar:diskette-bold-duotone" class="fs-5"></iconify-icon>
              Simpan User
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection() ?>
