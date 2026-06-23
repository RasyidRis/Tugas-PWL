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

<div class="card w-100 shadow-sm">
  <div class="card-body p-4">
    <div class="d-md-flex align-items-center justify-content-between mb-4">
      <div>
        <h5 class="card-title fw-semibold mb-1">Daftar Member Laundry</h5>
        <p class="card-subtitle mb-0">Kelola data pelanggan di outlet Anda</p>
      </div>
      <div class="mt-3 mt-md-0 d-flex gap-2">
        
        <form action="<?= base_url('member') ?>" method="GET" class="d-flex gap-2">
          <div class="input-group">
            <input type="text" name="keyword" class="form-control" placeholder="Cari pelanggan..." value="<?= esc($keyword) ?>">
            <button type="submit" class="btn btn-outline-primary">
              <iconify-icon icon="solar:magnifer-line-duotone" style="vertical-align: middle;"></iconify-icon>
            </button>
            <?php if (!empty($keyword)) : ?>
              <a href="<?= base_url('member') ?>" class="btn btn-outline-secondary d-flex align-items-center">
                <iconify-icon icon="solar:close-circle-line-duotone" class="fs-5"></iconify-icon>
              </a>
            <?php endif; ?>
          </div>
        </form>
        <button type="button" class="btn btn-primary d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#tambahMemberModal">
          <iconify-icon icon="solar:add-circle-bold-duotone" class="fs-5"></iconify-icon>
          Tambah Member
        </button>
      </div>
    </div>
    
    <div class="table-responsive">
      <table class="table text-nowrap align-middle mb-0">
        <thead class="text-dark fs-4 bg-light">
          <tr>
            <th class="border-bottom-0"><h6 class="fw-semibold mb-0">No</h6></th>
            <th class="border-bottom-0"><h6 class="fw-semibold mb-0">Nama Pelanggan</h6></th>
            <th class="border-bottom-0"><h6 class="fw-semibold mb-0">Nomor Telepon</h6></th>
            <th class="border-bottom-0"><h6 class="fw-semibold mb-0">Alamat Rumah</h6></th>
            <th class="border-bottom-0"><h6 class="fw-semibold mb-0 text-center">Poin Loyalty</h6></th>
            <th class="border-bottom-0 text-center"><h6 class="fw-semibold mb-0">Aksi</h6></th>
          </tr>
        </thead>
        <tbody>
          <?php if (count($members) > 0) : ?>
            <?php $no = 1; foreach ($members as $item) : ?>
              <tr>
                <td class="border-bottom-0">
                  <h6 class="fw-semibold mb-0"><?= $no++ ?></h6>
                </td>
                <td class="border-bottom-0">
                  <h6 class="fw-semibold mb-1 text-dark"><?= esc($item['nama']) ?></h6>
                </td>
                <td class="border-bottom-0">
                  <span class="fs-3 text-dark"><?= esc($item['telepon']) ?></span>
                </td>
                <td class="border-bottom-0">
                  <p class="mb-0 text-wrap fs-3 text-muted" style="max-width: 300px;">
                    <?= esc($item['alamat']) ?>
                  </p>
                </td>
                <td class="border-bottom-0 text-center">
                  <span class="badge rounded-3 bg-primary-subtle text-primary fw-bold fs-3 px-3 py-1.5">
                    <?= esc($item['poin']) ?> Poin
                  </span>
                </td>
                <td class="border-bottom-0 text-center">
                  <div class="d-flex align-items-center justify-content-center gap-2">
                    <a href="<?= base_url('member/edit/' . $item['id']) ?>" class="btn btn-sm btn-outline-warning d-flex align-items-center justify-content-center p-2" title="Edit">
                      <iconify-icon icon="solar:pen-bold-duotone" class="fs-4"></iconify-icon>
                    </a>
                    <button type="button" class="btn btn-sm btn-outline-danger d-flex align-items-center justify-content-center p-2 btn-delete" 
                            data-id="<?= $item['id'] ?>" 
                            data-name="<?= esc($item['nama']) ?>" 
                            data-bs-toggle="modal" 
                            data-bs-target="#deleteModal" 
                            title="Hapus">
                      <iconify-icon icon="solar:trash-bin-trash-bold-duotone" class="fs-4"></iconify-icon>
                    </button>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else : ?>
            <tr>
              <td colspan="6" class="text-center py-5">
                <div class="d-flex flex-column align-items-center gap-2">
                  <iconify-icon icon="solar:clipboard-remove-broken" class="fs-8 text-muted"></iconify-icon>
                  <h6 class="fw-semibold text-muted">Data member tidak ditemukan</h6>
                  <?php if (!empty($keyword)) : ?>
                    <a href="<?= base_url('member') ?>" class="btn btn-sm btn-primary mt-2">Reset Pencarian</a>
                  <?php endif; ?>
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
        <h5 class="modal-title fw-semibold text-dark" id="deleteModalLabel">Konfirmasi Hapus Member</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="deleteForm" method="POST" action="">
        <div class="modal-body text-center py-4">
          <iconify-icon icon="solar:shield-warning-bold-duotone" class="fs-9 text-danger mb-3"></iconify-icon>
          <h5 class="fw-semibold mb-2">Apakah Anda yakin?</h5>
          <p class="text-muted mb-0">Anda akan menghapus data pelanggan <span class="fw-bold text-dark" id="deleteMemberName"></span>. Tindakan ini tidak dapat dibatalkan.</p>
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
<div class="modal fade" id="tambahMemberModal" tabindex="-1" aria-labelledby="tambahMemberModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fw-bold text-dark" id="tambahMemberModalLabel">Registrasi Member Baru</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="<?= base_url('member/simpan') ?>" method="POST">
        <?= csrf_field() ?>
        <div class="modal-body">
          
          <div class="mb-3">
            <label for="nama" class="form-label fw-semibold text-dark">Nama Pelanggan <span class="text-danger">*</span></label>
            <input type="text" 
                   name="nama" 
                   class="form-control <?= isset($validation['nama']) ? 'is-invalid' : '' ?>" 
                   id="nama" 
                   placeholder="Contoh: Agus Hartono"
                   value="<?= old('nama') ?>" 
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
                     value="<?= old('telepon') ?>" 
                     required>
              <?php if (isset($validation['telepon'])) : ?>
                <div class="invalid-feedback"><?= $validation['telepon'] ?></div>
              <?php endif; ?>
            </div>

            
            <div class="col-md-6 mb-3">
              <label for="poin" class="form-label fw-semibold text-dark">Poin Awal Loyalty (Opsional)</label>
              <input type="number" 
                     name="poin" 
                     class="form-control <?= isset($validation['poin']) ? 'is-invalid' : '' ?>" 
                     id="poin" 
                     min="0"
                     placeholder="Contoh: 0"
                     value="<?= old('poin', 0) ?>">
              <?php if (isset($validation['poin'])) : ?>
                <div class="invalid-feedback"><?= $validation['poin'] ?></div>
              <?php endif; ?>
            </div>
          </div>

          
          <div class="mb-0">
            <label for="alamat" class="form-label fw-semibold text-dark">Alamat Lengkap <span class="text-danger">*</span></label>
            <textarea name="alamat" 
                      class="form-control <?= isset($validation['alamat']) ? 'is-invalid' : '' ?>" 
                      id="alamat" 
                      rows="4" 
                      placeholder="Masukkan alamat tinggal lengkap pelanggan..." 
                      required><?= old('alamat') ?></textarea>
            <?php if (isset($validation['alamat'])) : ?>
              <div class="invalid-feedback"><?= $validation['alamat'] ?></div>
            <?php endif; ?>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary d-flex align-items-center gap-1">
            <iconify-icon icon="solar:diskette-bold-duotone" class="fs-5"></iconify-icon>
            Daftarkan Member
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const deleteButtons = document.querySelectorAll('.btn-delete');
    const deleteForm = document.getElementById('deleteForm');
    const deleteMemberName = document.getElementById('deleteMemberName');

    deleteButtons.forEach(button => {
      button.addEventListener('click', function() {
        const id = this.getAttribute('data-id');
        const name = this.getAttribute('data-name');
        
        deleteMemberName.textContent = name;
        deleteForm.setAttribute('action', '<?= base_url('member/hapus') ?>/' + id);
      });
    });

    // Auto-show add modal on validation error
    <?php if (session()->getFlashdata('modal_open') === 'tambah_member') : ?>
      const myModal = new bootstrap.Modal(document.getElementById('tambahMemberModal'));
      myModal.show();
    <?php endif; ?>
  });
</script>

<?= $this->endSection() ?>
