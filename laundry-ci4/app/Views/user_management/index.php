<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<?php if (session()->getFlashdata('success')) : ?>
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    <div class="d-flex align-items-center gap-2">
      <iconify-icon icon="solar:check-circle-bold-duotone" class="fs-6"></iconify-icon>
      <div><?= session()->getFlashdata('success') ?></div>
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')) : ?>
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <div class="d-flex align-items-center gap-2">
      <iconify-icon icon="solar:danger-bold-duotone" class="fs-6"></iconify-icon>
      <div><?= session()->getFlashdata('error') ?></div>
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
<?php endif; ?>

<div class="card w-100 shadow-sm border-0 rounded-3">
  <div class="card-body p-4">
    <div class="d-md-flex align-items-center justify-content-between mb-4">
      <div>
        <h5 class="card-title fw-bold text-dark mb-1">User Management</h5>
        <p class="card-subtitle mb-0">Kelola kredensial hak akses pengguna (Admin / Kasir)</p>
      </div>
      <div class="mt-3 mt-md-0">
        <button type="button" class="btn btn-primary d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#tambahUserModal">
          <iconify-icon icon="solar:user-plus-bold-duotone" class="fs-5"></iconify-icon>
          Tambah User Baru
        </button>
      </div>
    </div>
    
    <div class="table-responsive">
      <table class="table text-nowrap align-middle mb-0">
        <thead class="text-dark fs-4 bg-light">
          <tr>
            <th class="border-bottom-0"><h6 class="fw-semibold mb-0">No</h6></th>
            <th class="border-bottom-0"><h6 class="fw-semibold mb-0">Nama Pengguna (Username)</h6></th>
            <th class="border-bottom-0"><h6 class="fw-semibold mb-0">Email Akses</h6></th>
            <th class="border-bottom-0"><h6 class="fw-semibold mb-0">Hak Akses (Role)</h6></th>
            <th class="border-bottom-0"><h6 class="fw-semibold mb-0">Tanggal Dibuat</h6></th>
            <th class="border-bottom-0 text-center"><h6 class="fw-semibold mb-0">Aksi</h6></th>
          </tr>
        </thead>
        <tbody>
          <?php if (count($users) > 0) : ?>
            <?php $no = 1; foreach ($users as $item) : ?>
              <tr>
                <td class="border-bottom-0">
                  <h6 class="fw-semibold mb-0"><?= $no++ ?></h6>
                </td>
                <td class="border-bottom-0">
                  <h6 class="fw-bold mb-1 text-dark"><?= esc($item['username']) ?></h6>
                </td>
                <td class="border-bottom-0">
                  <span class="fs-3 text-dark"><?= esc($item['email']) ?></span>
                </td>
                <td class="border-bottom-0">
                  <?php if ($item['role'] === 'admin') : ?>
                    <span class="badge bg-primary-subtle text-primary fw-bold fs-2 rounded-pill px-3 py-1 text-capitalize">Admin</span>
                  <?php else : ?>
                    <span class="badge bg-info-subtle text-info fw-bold fs-2 rounded-pill px-3 py-1 text-capitalize">Kasir</span>
                  <?php endif; ?>
                </td>
                <td class="border-bottom-0">
                  <span class="fs-3 text-muted"><?= date('d M Y H:i', strtotime($item['created_at'])) ?></span>
                </td>
                <td class="border-bottom-0 text-center">
                  <div class="d-flex align-items-center justify-content-center gap-2">
                    <button type="button" 
                            class="btn btn-sm btn-outline-warning d-flex align-items-center justify-content-center p-2 btn-edit" 
                            data-id="<?= $item['id'] ?>"
                            data-username="<?= esc($item['username']) ?>"
                            data-email="<?= esc($item['email']) ?>"
                            data-role="<?= esc($item['role']) ?>"
                            data-bs-toggle="modal" 
                            data-bs-target="#editUserModal" 
                            title="Edit">
                      <iconify-icon icon="solar:pen-bold-duotone" class="fs-4"></iconify-icon>
                    </button>
                    
                    
                    <?php if ($item['id'] != session()->get('user_id')) : ?>
                      <button type="button" class="btn btn-sm btn-outline-danger d-flex align-items-center justify-content-center p-2 btn-delete" 
                              data-id="<?= $item['id'] ?>" 
                              data-name="<?= esc($item['username']) ?>" 
                              data-bs-toggle="modal" 
                              data-bs-target="#deleteModal" 
                              title="Hapus">
                        <iconify-icon icon="solar:trash-bin-trash-bold-duotone" class="fs-4"></iconify-icon>
                      </button>
                    <?php else : ?>
                      <span class="badge bg-light text-muted fs-1 border">Aktif Saat Ini</span>
                    <?php endif; ?>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else : ?>
            <tr>
              <td colspan="6" class="text-center py-5">
                <div class="d-flex flex-column align-items-center gap-2">
                  <iconify-icon icon="solar:clipboard-remove-broken" class="fs-8 text-muted"></iconify-icon>
                  <h6 class="fw-semibold text-muted">Data user tidak ditemukan</h6>
                </div>
              </td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fw-semibold text-dark" id="deleteModalLabel">Konfirmasi Hapus User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="deleteForm" method="POST" action="">
        <div class="modal-body text-center py-4">
          <iconify-icon icon="solar:shield-warning-bold-duotone" class="fs-9 text-danger mb-3"></iconify-icon>
          <h5 class="fw-semibold mb-2">Apakah Anda yakin?</h5>
          <p class="text-muted mb-0">Anda akan menghapus akun user <span class="fw-bold text-dark" id="deleteUserName"></span>. Hak akses ke sistem akan dicabut sepenuhnya.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-danger">Ya, Hapus Data</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php $validation = session()->getFlashdata('validation') ?? []; ?>
<div class="modal fade" id="tambahUserModal" tabindex="-1" aria-labelledby="tambahUserModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fw-bold text-dark" id="tambahUserModalLabel">Tambah User Hak Akses</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="<?= base_url('user-management/simpan') ?>" method="POST">
        <?= csrf_field() ?>
        <div class="modal-body">
          
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

            
            <div class="col-md-6 mb-0">
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
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary d-flex align-items-center gap-1">
            <iconify-icon icon="solar:diskette-bold-duotone" class="fs-5"></iconify-icon>
            Simpan User
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- Modal Edit User -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg rounded-3">
      <div class="modal-header border-bottom-0 pb-0">
        <h5 class="modal-title fw-bold text-dark" id="editUserModalLabel">Edit User Hak Akses</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="" method="POST" id="editUserForm">
        <?= csrf_field() ?>
        <div class="modal-body">
          
          <div class="mb-3">
            <label for="username_edit" class="form-label fw-semibold text-dark">Nama Pengguna (Username) <span class="text-danger">*</span></label>
            <input type="text" name="username" class="form-control" id="username_edit" required>
          </div>

          
          <div class="mb-3">
            <label for="email_edit" class="form-label fw-semibold text-dark">Alamat Email <span class="text-danger">*</span></label>
            <input type="email" name="email" class="form-control" id="email_edit" required>
          </div>

          <div class="row">
            
            <div class="col-md-6 mb-3">
              <label for="password_edit" class="form-label fw-semibold text-dark">Kata Sandi Baru</label>
              <input type="password" name="password" class="form-control" id="password_edit" placeholder="Isi hanya jika diubah">
            </div>

            
            <div class="col-md-6 mb-0">
              <label for="role_edit" class="form-label fw-semibold text-dark">Hak Akses (Role) <span class="text-danger">*</span></label>
              <select name="role" id="role_edit" class="form-select" required>
                <option value="" disabled>-- Pilih Hak Akses --</option>
                <option value="kasir">Kasir / Operator</option>
                <option value="admin">Administrator</option>
              </select>
            </div>
          </div>
        </div>
        <div class="modal-footer border-top-0 pt-0">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-warning d-flex align-items-center gap-1 text-white">
            <iconify-icon icon="solar:diskette-bold-duotone" class="fs-5"></iconify-icon>
            Perbarui User
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Delete handler
    const deleteButtons = document.querySelectorAll('.btn-delete');
    const deleteForm = document.getElementById('deleteForm');
    const deleteUserName = document.getElementById('deleteUserName');

    deleteButtons.forEach(button => {
      button.addEventListener('click', function() {
        const id = this.getAttribute('data-id');
        const name = this.getAttribute('data-name');
        
        deleteUserName.textContent = name;
        deleteForm.setAttribute('action', '<?= base_url('user-management/hapus') ?>/' + id);
      });
    });

    // Edit handler
    const editButtons = document.querySelectorAll('.btn-edit');
    const editForm = document.getElementById('editUserForm');
    const usernameEdit = document.getElementById('username_edit');
    const emailEdit = document.getElementById('email_edit');
    const passwordEdit = document.getElementById('password_edit');
    const roleEdit = document.getElementById('role_edit');

    editButtons.forEach(button => {
      button.addEventListener('click', function() {
        const id = this.getAttribute('data-id');
        const username = this.getAttribute('data-username');
        const email = this.getAttribute('data-email');
        const role = this.getAttribute('data-role');

        usernameEdit.value = username;
        emailEdit.value = email;
        passwordEdit.value = ''; // Reset password field for security
        roleEdit.value = role;

        editForm.setAttribute('action', '<?= base_url('user-management/update') ?>/' + id);
      });
    });

    // Auto-show add modal on validation error
    <?php if (session()->getFlashdata('modal_open') === 'tambah_user') : ?>
      const myModal = new bootstrap.Modal(document.getElementById('tambahUserModal'));
      myModal.show();
    <?php endif; ?>

    // Auto-show edit modal on validation error
    <?php if (session()->getFlashdata('modal_open') === 'edit_user') : ?>
      const editModal = new bootstrap.Modal(document.getElementById('editUserModal'));
      const failedId = '<?= session()->getFlashdata('edit_id') ?>';
      const button = document.querySelector(`.btn-edit[data-id="${failedId}"]`);
      if (button) {
        button.click();
      }
      editModal.show();
    <?php endif; ?>
  });
</script>

<?= $this->endSection() ?>
