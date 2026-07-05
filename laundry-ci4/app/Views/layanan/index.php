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

<div class="row">
  
  <div class="col-sm-6 col-xl-3">
    <div class="card overflow-hidden rounded-2 shadow-sm border-0 bg-primary-subtle text-primary">
      <div class="card-body p-4">
        <div class="d-flex align-items-center justify-content-between mb-3">
          <h6 class="fw-semibold mb-0 fs-3 text-uppercase" style="letter-spacing: 0.5px;">Total Layanan</h6>
          <div class="bg-primary rounded-circle text-white d-flex align-items-center justify-content-center" style="width: 56px; height: 56px; flex-shrink: 0;">
            <iconify-icon icon="solar:tag-price-bold-duotone" style="font-size: 32px; display: inline-block; line-height: 1;"></iconify-icon>
          </div>
        </div>
        <div class="d-flex align-items-baseline">
          <h3 class="fw-bold mb-0 text-primary fs-7"><?= $totalLayanan ?></h3>
          <span class="ms-2 fs-2 fw-medium text-primary">jenis layanan</span>
        </div>
      </div>
    </div>
  </div>

  
  <div class="col-sm-6 col-xl-3">
    <div class="card overflow-hidden rounded-2 shadow-sm border-0 bg-success-subtle text-success">
      <div class="card-body p-4">
        <div class="d-flex align-items-center justify-content-between mb-3">
          <h6 class="fw-semibold mb-0 fs-3 text-uppercase" style="letter-spacing: 0.5px;">Rata-Rata Harga</h6>
          <div class="bg-success rounded-circle text-white d-flex align-items-center justify-content-center" style="width: 56px; height: 56px; flex-shrink: 0;">
            <iconify-icon icon="solar:wad-of-money-bold-duotone" style="font-size: 32px; display: inline-block; line-height: 1;"></iconify-icon>
          </div>
        </div>
        <div class="d-flex align-items-baseline">
          <h3 class="fw-bold mb-0 text-success fs-7">Rp<?= number_format($averageHarga, 0, ',', '.') ?></h3>
        </div>
      </div>
    </div>
  </div>

  
  <div class="col-sm-6 col-xl-3">
    <div class="card overflow-hidden rounded-2 shadow-sm border-0 bg-warning-subtle text-warning">
      <div class="card-body p-4">
        <div class="d-flex align-items-center justify-content-between mb-3">
          <h6 class="fw-semibold mb-0 fs-3 text-uppercase" style="letter-spacing: 0.5px;">Layanan Termahal</h6>
          <div class="bg-warning rounded-circle text-white d-flex align-items-center justify-content-center" style="width: 56px; height: 56px; flex-shrink: 0;">
            <iconify-icon icon="solar:round-arrow-up-bold-duotone" style="font-size: 32px; display: inline-block; line-height: 1;"></iconify-icon>
          </div>
        </div>
        <div>
          <h4 class="fw-bold mb-1 text-warning fs-5 text-truncate" title="<?= $maxLayanan ? esc($maxLayanan['nama_layanan']) : '-' ?>">
            <?= $maxLayanan ? esc($maxLayanan['nama_layanan']) : '-' ?>
          </h4>
          <span class="fs-3 fw-medium text-warning">
            <?= $maxLayanan ? 'Rp' . number_format($maxLayanan['harga'], 0, ',', '.') . ' / ' . esc($maxLayanan['tipe_satuan']) : '-' ?>
          </span>
        </div>
      </div>
    </div>
  </div>

  
  <div class="col-sm-6 col-xl-3">
    <div class="card overflow-hidden rounded-2 shadow-sm border-0 bg-info-subtle text-info">
      <div class="card-body p-4">
        <div class="d-flex align-items-center justify-content-between mb-3">
          <h6 class="fw-semibold mb-0 fs-3 text-uppercase" style="letter-spacing: 0.5px;">Layanan Termurah</h6>
          <div class="bg-info rounded-circle text-white d-flex align-items-center justify-content-center" style="width: 56px; height: 56px; flex-shrink: 0;">
            <iconify-icon icon="solar:round-arrow-down-bold-duotone" style="font-size: 32px; display: inline-block; line-height: 1;"></iconify-icon>
          </div>
        </div>
        <div>
          <h4 class="fw-bold mb-1 text-info fs-5 text-truncate" title="<?= $minLayanan ? esc($minLayanan['nama_layanan']) : '-' ?>">
            <?= $minLayanan ? esc($minLayanan['nama_layanan']) : '-' ?>
          </h4>
          <span class="fs-3 fw-medium text-info">
            <?= $minLayanan ? 'Rp' . number_format($minLayanan['harga'], 0, ',', '.') . ' / ' . esc($minLayanan['tipe_satuan']) : '-' ?>
          </span>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="card w-100 shadow-sm">
  <div class="card-body p-4">
    <div class="d-md-flex align-items-center justify-content-between mb-4">
      <div>
        <h5 class="card-title fw-semibold mb-1">Daftar Jasa Layanan</h5>
        <p class="card-subtitle mb-0">Kelola data jenis layanan laundry di outlet Anda</p>
      </div>
      <div class="mt-3 mt-md-0 d-flex gap-2">
        
        <form action="<?= base_url('layanan') ?>" method="GET" class="d-flex gap-2">
          <div class="input-group">
            <input type="text" name="keyword" class="form-control" placeholder="Cari layanan..." value="<?= esc($keyword) ?>">
            <button type="submit" class="btn btn-outline-primary">
              <iconify-icon icon="solar:magnifer-line-duotone" style="vertical-align: middle;"></iconify-icon>
            </button>
            <?php if (!empty($keyword)) : ?>
              <a href="<?= base_url('layanan') ?>" class="btn btn-outline-secondary d-flex align-items-center">
                <iconify-icon icon="solar:close-circle-line-duotone" class="fs-5"></iconify-icon>
              </a>
            <?php endif; ?>
          </div>
        </form>
        <a href="<?= base_url('layanan/pdf') ?>" target="_blank" class="btn btn-danger d-flex align-items-center gap-2">
          <iconify-icon icon="solar:document-text-bold-duotone" class="fs-5"></iconify-icon>
          Cetak PDF
        </a>
        <button type="button" class="btn btn-primary d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#tambahLayananModal">
          <iconify-icon icon="solar:add-circle-bold-duotone" class="fs-5"></iconify-icon>
          Tambah Layanan
        </button>
      </div>
    </div>
    
    <div class="table-responsive">
      <table class="table text-nowrap align-middle mb-0">
        <thead class="text-dark fs-4 bg-light">
          <tr>
            <th class="border-bottom-0">
              <h6 class="fw-semibold mb-0">No</h6>
            </th>
            <th class="border-bottom-0">
              <h6 class="fw-semibold mb-0">Gambar</h6>
            </th>
            <th class="border-bottom-0">
              <h6 class="fw-semibold mb-0">Nama Layanan</h6>
            </th>
            <th class="border-bottom-0">
              <h6 class="fw-semibold mb-0">Tipe Satuan</h6>
            </th>
            <th class="border-bottom-0">
              <h6 class="fw-semibold mb-0">Harga</h6>
            </th>
            <th class="border-bottom-0">
              <h6 class="fw-semibold mb-0">Estimasi Waktu</h6>
            </th>
            <th class="border-bottom-0">
              <h6 class="fw-semibold mb-0">Deskripsi</h6>
            </th>
            <th class="border-bottom-0 text-center">
              <h6 class="fw-semibold mb-0">Aksi</h6>
            </th>
          </tr>
        </thead>
        <tbody>
          <?php if (count($layanan) > 0) : ?>
            <?php $no = 1; foreach ($layanan as $item) : ?>
              <tr>
                <td class="border-bottom-0">
                  <h6 class="fw-semibold mb-0"><?= $no++ ?></h6>
                </td>
                <td class="border-bottom-0">
                  <?php if (!empty($item['gambar']) && file_exists(ROOTPATH . 'public/uploads/layanan/' . $item['gambar'])) : ?>
                    <img src="<?= base_url('uploads/layanan/' . $item['gambar']) ?>" alt="<?= esc($item['nama_layanan']) ?>" class="rounded-3 shadow-sm border" style="width: 72px; height: 72px; object-fit: cover;">
                  <?php else : ?>
                    <div class="bg-light rounded-3 d-flex align-items-center justify-content-center text-muted border" style="width: 72px; height: 72px;">
                      <iconify-icon icon="solar:camera-broken" class="fs-7"></iconify-icon>
                    </div>
                  <?php endif; ?>
                </td>
                <td class="border-bottom-0">
                  <h6 class="fw-semibold mb-1 text-dark"><?= esc($item['nama_layanan']) ?></h6>
                </td>
                <td class="border-bottom-0">
                  <span class="badge rounded-3 bg-secondary-subtle text-secondary fw-semibold fs-2">
                    Per <?= esc($item['tipe_satuan']) ?>
                  </span>
                </td>
                <td class="border-bottom-0">
                  <h6 class="fw-bold mb-0 text-dark">Rp<?= number_format($item['harga'], 0, ',', '.') ?></h6>
                </td>
                <td class="border-bottom-0">
                  <div class="d-flex align-items-center gap-1">
                    <iconify-icon icon="solar:clock-circle-line-duotone" class="text-muted"></iconify-icon>
                    <span class="fs-3 text-dark"><?= esc($item['estimasi_waktu']) ?></span>
                  </div>
                </td>
                <td class="border-bottom-0">
                  <p class="mb-0 text-wrap fs-3 text-muted" style="max-width: 250px;">
                    <?= !empty($item['deskripsi']) ? esc($item['deskripsi']) : '<span class="text-italic text-light-emphasis">Tidak ada deskripsi</span>' ?>
                  </p>
                </td>
                <td class="border-bottom-0 text-center">
                  <div class="d-flex align-items-center justify-content-center gap-2">
                    <button type="button" 
                            class="btn btn-sm btn-outline-warning d-flex align-items-center justify-content-center p-2 btn-edit" 
                            data-id="<?= $item['id'] ?>"
                            data-name="<?= esc($item['nama_layanan']) ?>"
                            data-unit="<?= esc($item['tipe_satuan']) ?>"
                            data-price="<?= esc($item['harga']) ?>"
                            data-estimation="<?= esc($item['estimasi_waktu']) ?>"
                            data-desc="<?= esc($item['deskripsi'] ?? '') ?>"
                            data-image="<?= esc($item['gambar'] ?? '') ?>"
                            data-bs-toggle="modal" 
                            data-bs-target="#editLayananModal" 
                            title="Edit">
                      <iconify-icon icon="solar:pen-bold-duotone" class="fs-4"></iconify-icon>
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-danger d-flex align-items-center justify-content-center p-2 btn-delete" 
                            data-id="<?= $item['id'] ?>" 
                            data-name="<?= esc($item['nama_layanan']) ?>" 
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
              <td colspan="7" class="text-center py-5">
                <div class="d-flex flex-column align-items-center gap-2">
                  <iconify-icon icon="solar:clipboard-remove-broken" class="fs-8 text-muted"></iconify-icon>
                  <h6 class="fw-semibold text-muted">Data layanan laundry tidak ditemukan</h6>
                  <?php if (!empty($keyword)) : ?>
                    <a href="<?= base_url('layanan') ?>" class="btn btn-sm btn-primary mt-2">Reset Pencarian</a>
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
        <h5 class="modal-title fw-semibold text-dark" id="deleteModalLabel">Konfirmasi Hapus Layanan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="deleteForm" method="POST" action="">
        <div class="modal-body text-center py-4">
          <iconify-icon icon="solar:shield-warning-bold-duotone" class="fs-9 text-danger mb-3"></iconify-icon>
          <h5 class="fw-semibold mb-2">Apakah Anda yakin?</h5>
          <p class="text-muted mb-0">Anda akan menghapus layanan <span class="fw-bold text-dark" id="deleteServiceName"></span>. Tindakan ini tidak dapat dibatalkan.</p>
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
<div class="modal fade" id="tambahLayananModal" tabindex="-1" aria-labelledby="tambahLayananModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fw-bold text-dark" id="tambahLayananModalLabel">Tambah Layanan Baru</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="<?= base_url('layanan/simpan') ?>" method="POST" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <div class="modal-body">
          
          <div class="mb-3">
            <label for="nama_layanan" class="form-label fw-semibold text-dark">Nama Layanan <span class="text-danger">*</span></label>
            <input type="text" 
                   name="nama_layanan" 
                   class="form-control <?= isset($validation['nama_layanan']) ? 'is-invalid' : '' ?>" 
                   id="nama_layanan" 
                   placeholder="Contoh: Cuci Kering & Setrika Kemeja"
                   value="<?= old('nama_layanan') ?>" 
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
                <option value="" disabled <?= empty(old('tipe_satuan')) ? 'selected' : '' ?>>-- Pilih Satuan --</option>
                <option value="Kg" <?= old('tipe_satuan') === 'Kg' ? 'selected' : '' ?>>Kg (Kilogram)</option>
                <option value="Pcs" <?= old('tipe_satuan') === 'Pcs' ? 'selected' : '' ?>>Pcs (Satuan)</option>
                <option value="Meter" <?= old('tipe_satuan') === 'Meter' ? 'selected' : '' ?>>Meter (Karpet/Gordyn)</option>
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
                       value="<?= old('harga') ?>" 
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
                   value="<?= old('estimasi_waktu') ?>" 
                   required>
            <?php if (isset($validation['estimasi_waktu'])) : ?>
              <div class="invalid-feedback"><?= $validation['estimasi_waktu'] ?></div>
            <?php endif; ?>
          </div>

          <div class="mb-3">
            <label for="gambar" class="form-label fw-semibold text-dark">Gambar Layanan (Opsional)</label>
            <input type="file" name="gambar" class="form-control" id="gambar" accept="image/*">
            <div class="form-text text-muted">Format file yang diperbolehkan: JPG, JPEG, PNG.</div>
          </div>

          
          <div class="mb-0">
            <label for="deskripsi" class="form-label fw-semibold text-dark">Deskripsi Layanan (Opsional)</label>
            <textarea name="deskripsi" 
                      class="form-control <?= isset($validation['deskripsi']) ? 'is-invalid' : '' ?>" 
                      id="deskripsi" 
                      rows="4" 
                      placeholder="Masukkan detail penjelasan mengenai layanan laundry ini..."><?= old('deskripsi') ?></textarea>
            <?php if (isset($validation['deskripsi'])) : ?>
              <div class="invalid-feedback"><?= $validation['deskripsi'] ?></div>
            <?php endif; ?>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary d-flex align-items-center gap-1">
            <iconify-icon icon="solar:diskette-bold-duotone" class="fs-5"></iconify-icon>
            Simpan Layanan
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- Modal Edit Layanan -->
<div class="modal fade" id="editLayananModal" tabindex="-1" aria-labelledby="editLayananModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg rounded-3">
      <div class="modal-header border-bottom-0 pb-0">
        <h5 class="modal-title fw-bold text-dark" id="editLayananModalLabel">Edit Layanan Laundry</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="" method="POST" id="editLayananForm" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <div class="modal-body">
          
          <div class="mb-3">
            <label for="nama_layanan_edit" class="form-label fw-semibold text-dark">Nama Layanan <span class="text-danger">*</span></label>
            <input type="text" 
                   name="nama_layanan" 
                   class="form-control" 
                   id="nama_layanan_edit" 
                   placeholder="Contoh: Cuci Kering & Setrika Kemeja" 
                   required>
          </div>

          <div class="row">
            
            <div class="col-md-6 mb-3">
              <label for="tipe_satuan_edit" class="form-label fw-semibold text-dark">Tipe Satuan <span class="text-danger">*</span></label>
              <select name="tipe_satuan" class="form-select" id="tipe_satuan_edit" required>
                <option value="" disabled>-- Pilih Satuan --</option>
                <option value="Kg">Kg (Kilogram)</option>
                <option value="Pcs">Pcs (Satuan)</option>
                <option value="Meter">Meter (Karpet/Gordyn)</option>
              </select>
            </div>

            
            <div class="col-md-6 mb-3">
              <label for="harga_edit" class="form-label fw-semibold text-dark">Harga (Rp) <span class="text-danger">*</span></label>
              <div class="input-group">
                <span class="input-group-text bg-light text-dark fw-semibold">Rp</span>
                <input type="number" name="harga" class="form-control" id="harga_edit" min="0" required>
              </div>
            </div>
          </div>

          
          <div class="mb-3">
            <label for="estimasi_waktu_edit" class="form-label fw-semibold text-dark">Estimasi Waktu Pengerjaan <span class="text-danger">*</span></label>
            <input type="text" 
                   name="estimasi_waktu" 
                   class="form-control" 
                   id="estimasi_waktu_edit" 
                   placeholder="Contoh: 2 Hari, 24 Jam, 6 Jam (Express)" 
                   required>
          </div>

          <div class="mb-3">
            <label for="gambar_edit" class="form-label fw-semibold text-dark">Gambar Layanan (Opsional)</label>
            <div id="edit_image_preview"></div>
            <input type="file" name="gambar" class="form-control" id="gambar_edit" accept="image/*">
            <div class="form-text text-muted">Format file yang diperbolehkan: JPG, JPEG, PNG. Biarkan kosong jika tidak ingin mengubah gambar.</div>
          </div>

          
          <div class="mb-0">
            <label for="deskripsi_edit" class="form-label fw-semibold text-dark">Deskripsi Layanan (Opsional)</label>
            <textarea name="deskripsi" 
                      class="form-control" 
                      id="deskripsi_edit" 
                      rows="4" 
                      placeholder="Masukkan detail penjelasan mengenai layanan laundry ini..."></textarea>
          </div>
        </div>
        <div class="modal-footer border-top-0 pt-0">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-warning d-flex align-items-center gap-1 text-white">
            <iconify-icon icon="solar:diskette-bold-duotone" class="fs-5"></iconify-icon>
            Perbarui Layanan
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
    const deleteServiceName = document.getElementById('deleteServiceName');

    deleteButtons.forEach(button => {
      button.addEventListener('click', function() {
        const id = this.getAttribute('data-id');
        const name = this.getAttribute('data-name');
        
        deleteServiceName.textContent = name;
        deleteForm.setAttribute('action', '<?= base_url('layanan/hapus') ?>/' + id);
      });
    });

    // Edit handler
    const editButtons = document.querySelectorAll('.btn-edit');
    const editForm = document.getElementById('editLayananForm');
    const namaLayananEdit = document.getElementById('nama_layanan_edit');
    const tipeSatuanEdit = document.getElementById('tipe_satuan_edit');
    const hargaEdit = document.getElementById('harga_edit');
    const estimasiWaktuEdit = document.getElementById('estimasi_waktu_edit');
    const deskripsiEdit = document.getElementById('deskripsi_edit');

    editButtons.forEach(button => {
      button.addEventListener('click', function() {
        const id = this.getAttribute('data-id');
        const name = this.getAttribute('data-name');
        const unit = this.getAttribute('data-unit');
        const price = this.getAttribute('data-price');
        const estimation = this.getAttribute('data-estimation');
        const desc = this.getAttribute('data-desc');
        const image = this.getAttribute('data-image');

        namaLayananEdit.value = name;
        tipeSatuanEdit.value = unit;
        hargaEdit.value = price;
        estimasiWaktuEdit.value = estimation;
        deskripsiEdit.value = desc;

        const previewContainer = document.getElementById('edit_image_preview');
        if (image && image !== '') {
            previewContainer.innerHTML = `<div class="mb-2"><img src="<?= base_url('uploads/layanan') ?>/${image}" class="img-thumbnail rounded" style="max-height: 80px;"></div>`;
        } else {
            previewContainer.innerHTML = '';
        }

        editForm.setAttribute('action', '<?= base_url('layanan/update') ?>/' + id);
      });
    });

    // Auto-show add modal on validation error
    <?php if (session()->getFlashdata('modal_open') === 'tambah_layanan') : ?>
      const myModal = new bootstrap.Modal(document.getElementById('tambahLayananModal'));
      myModal.show();
    <?php endif; ?>

    // Auto-show edit modal on validation error
    <?php if (session()->getFlashdata('modal_open') === 'edit_layanan') : ?>
      const editModal = new bootstrap.Modal(document.getElementById('editLayananModal'));
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
