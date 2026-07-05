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

<?php if (session()->getFlashdata('error')) : ?>
  <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0" role="alert">
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
        <h5 class="card-title fw-bold text-dark mb-1">Manajemen Antrian Laundry</h5>
        <p class="card-subtitle mb-0">Kelola pesanan masuk, proses pengerjaan, dan riwayat pengambilan</p>
      </div>
      <div class="mt-3 mt-md-0 d-flex gap-2">
        
        <form action="<?= base_url('antrian') ?>" method="GET" class="d-flex gap-2">
          <div class="input-group">
            <input type="text" name="keyword" class="form-control" placeholder="No. Antrian / Pelanggan..." value="<?= esc($keyword) ?>">
            <button type="submit" class="btn btn-outline-primary">
              <iconify-icon icon="solar:magnifer-line-duotone" style="vertical-align: middle;"></iconify-icon>
            </button>
            <?php if (!empty($keyword)) : ?>
              <a href="<?= base_url('antrian') ?>" class="btn btn-outline-secondary d-flex align-items-center">
                <iconify-icon icon="solar:close-circle-line-duotone" class="fs-5"></iconify-icon>
              </a>
            <?php endif; ?>
          </div>
        </form>
        <button type="button" class="btn btn-primary d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#tambahAntrianModal">
          <iconify-icon icon="solar:add-circle-bold-duotone" class="fs-5"></iconify-icon>
          Buat Antrian
        </button>
      </div>
    </div>
    
    <div class="table-responsive">
      <table class="table text-nowrap align-middle mb-0">
        <thead class="text-dark fs-4 bg-light">
          <tr>
            <th class="border-bottom-0"><h6 class="fw-semibold mb-0">No. Antrian</h6></th>
            <th class="border-bottom-0"><h6 class="fw-semibold mb-0">Pelanggan</h6></th>
            <th class="border-bottom-0"><h6 class="fw-semibold mb-0">Detail Pakaian & Layanan</h6></th>
            <th class="border-bottom-0"><h6 class="fw-semibold mb-0">Total Tagihan</h6></th>
            <th class="border-bottom-0 text-center"><h6 class="fw-semibold mb-0">Status Cuci</h6></th>
            <th class="border-bottom-0 text-center"><h6 class="fw-semibold mb-0">Pembayaran</h6></th>
            <th class="border-bottom-0 text-center"><h6 class="fw-semibold mb-0">Aksi</h6></th>
          </tr>
        </thead>
        <tbody>
          <?php if (count($transaksi) > 0) : ?>
            <?php foreach ($transaksi as $item) : ?>
              <tr>
                <td class="border-bottom-0">
                  <span class="text-dark fw-bold fs-3"><?= esc($item['no_antrian']) ?></span>
                  <div class="mt-1 d-flex flex-column text-muted fs-2" style="white-space: nowrap;">
                    <span><iconify-icon icon="solar:calendar-date-line-duotone" class="align-middle me-1"></iconify-icon>Masuk: <?= date('d M Y H:i', strtotime($item['created_at'])) ?></span>
                    <?php if (!empty($item['completed_at'])) : ?>
                      <span class="text-success"><iconify-icon icon="solar:check-circle-line-duotone" class="align-middle me-1"></iconify-icon>Selesai: <?= date('d M Y H:i', strtotime($item['completed_at'])) ?></span>
                    <?php else: ?>
                      <span class="text-warning"><iconify-icon icon="solar:clock-circle-line-duotone" class="align-middle me-1"></iconify-icon>Belum Selesai</span>
                    <?php endif; ?>
                  </div>
                </td>
                <td class="border-bottom-0">
                  <div class="d-flex flex-column">
                    <span class="text-dark fw-semibold fs-4"><?= esc($item['member_nama']) ?></span>
                    <small class="text-muted fs-2"><?= esc($item['member_telepon']) ?></small>
                    <?php if (!empty($item['member_alamat']) && $item['member_alamat'] !== '-') : ?>
                      <span class="text-muted fs-2 text-wrap" style="max-width: 180px;"><iconify-icon icon="solar:map-point-line-duotone" class="align-middle me-0.5"></iconify-icon><?= esc($item['member_alamat']) ?></span>
                    <?php endif; ?>
                  </div>
                </td>
                <td class="border-bottom-0">
                  <p class="mb-0 text-wrap fs-3 text-muted" style="max-width: 250px;">
                    <?= esc($item['detail_text']) ?>
                  </p>
                </td>
                <td class="border-bottom-0">
                  <h6 class="fw-bold mb-0 text-dark">Rp<?= number_format($item['total_harga'], 0, ',', '.') ?></h6>
                </td>
                <td class="border-bottom-0 text-center">
                  <?php 
                    $badgeClass = 'bg-primary-subtle text-primary';
                    if ($item['status'] == 'Hold') {
                        $badgeClass = 'bg-info-subtle text-info';
                    } elseif ($item['status'] == 'Cuci') {
                        $badgeClass = 'bg-warning-subtle text-warning';
                    } elseif ($item['status'] == 'Selesai') {
                        $badgeClass = 'bg-success-subtle text-success';
                    } elseif ($item['status'] == 'Diambil') {
                        $badgeClass = 'bg-secondary-subtle text-secondary';
                    }
                  ?>
                  <span class="badge rounded-pill fw-bold fs-2 px-3 py-1.5 <?= $badgeClass ?>">
                    <?= esc($item['status']) ?>
                  </span>
                </td>
                <td class="border-bottom-0 text-center">
                  <?php if ($item['status_bayar'] === 'Lunas') : ?>
                    <span class="badge bg-success text-white fw-bold fs-2 px-3 py-1.5 rounded-3">Lunas</span>
                  <?php else : ?>
                    <span class="badge bg-danger text-white fw-bold fs-2 px-3 py-1.5 rounded-3">Belum Lunas</span>
                  <?php endif; ?>
                </td>
                <td class="border-bottom-0 text-center">
                  <a href="<?= base_url('antrian/detail/' . $item['id']) ?>" class="btn btn-sm btn-outline-primary d-flex align-items-center justify-content-center gap-1 py-2 px-3" title="Detail & Proses">
                    <iconify-icon icon="solar:eye-bold-duotone" class="fs-4"></iconify-icon> Detail & Aksi
                  </a>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else : ?>
            <tr>
              <td colspan="7" class="text-center py-5">
                <div class="d-flex flex-column align-items-center gap-2">
                  <iconify-icon icon="solar:clipboard-remove-broken" class="fs-8 text-muted"></iconify-icon>
                  <h6 class="fw-semibold text-muted">Data antrian tidak ditemukan</h6>
                  <?php if (!empty($keyword)) : ?>
                    <a href="<?= base_url('antrian') ?>" class="btn btn-sm btn-primary mt-2">Reset Pencarian</a>
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

<div class="modal fade" id="tambahAntrianModal" tabindex="-1" aria-labelledby="tambahAntrianModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fw-bold text-dark" id="tambahAntrianModalLabel">Buat Antrian Laundry Baru</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="<?= base_url('antrian/simpan') ?>" method="POST" id="orderForm">
        <?= csrf_field() ?>
        <div class="modal-body">
          <div class="row">
            
            <div class="col-lg-8 mb-4">
              
              <div class="card rounded-3 shadow-sm border mb-4">
                <div class="card-body p-4">
                  <div class="d-flex align-items-center gap-3 border-bottom pb-3 mb-4">
                    <div class="p-2 bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center">
                      <iconify-icon icon="solar:user-rounded-bold-duotone" class="fs-6"></iconify-icon>
                    </div>
                    <div>
                      <h6 class="card-title fw-bold text-dark mb-0">1. Data Pelanggan</h6>
                    </div>
                  </div>

                  <input type="hidden" name="member_id" value="new_customer">

                  <div id="new_customer_fields" class="p-3 bg-light rounded-3 mb-3 border">
                    <div class="mb-3">
                      <label for="customer_name" class="form-label fw-semibold text-dark">Nama Lengkap <span class="text-danger">*</span></label>
                      <input type="text" name="customer_name" id="customer_name" class="form-control" placeholder="Contoh: Budi Santoso" value="<?= old('customer_name') ?>" required>
                    </div>
                    <div class="mb-3">
                      <label for="customer_phone" class="form-label fw-semibold text-dark">No. Telepon / HP</label>
                      <input type="text" name="customer_phone" id="customer_phone" class="form-control" placeholder="Contoh: 081234567890" value="<?= old('customer_phone') ?>">
                    </div>
                    <div class="mb-0">
                      <label for="customer_address" class="form-label fw-semibold text-dark">Alamat</label>
                      <textarea name="customer_address" id="customer_address" class="form-control" rows="2" placeholder="Contoh: Jl. Merdeka No. 10"><?= old('customer_address') ?></textarea>
                    </div>
                  </div>
                </div>
              </div>

              
              <div class="card rounded-3 shadow-sm border">
                <div class="card-body p-4">
                  <div class="d-flex align-items-center justify-content-between border-bottom pb-3 mb-4">
                    <div class="d-flex align-items-center gap-3">
                      <div class="p-2 bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center">
                        <iconify-icon icon="solar:tag-price-bold-duotone" class="fs-6"></iconify-icon>
                      </div>
                      <div>
                        <h6 class="card-title fw-bold text-dark mb-0">2. Detail Layanan Cuci</h6>
                      </div>
                    </div>
                    <button type="button" class="btn btn-outline-primary d-flex align-items-center gap-1 btn-sm" id="addRowBtn">
                      <iconify-icon icon="solar:add-circle-bold" class="fs-4"></iconify-icon> Tambah Baris
                    </button>
                  </div>

                  
                  <div class="table-responsive">
                    <table class="table align-middle" id="cartTable">
                      <thead>
                        <tr class="text-dark fs-3 bg-light">
                          <th style="width: 50%;">Layanan Laundry</th>
                          <th style="width: 25%;">Jumlah (Kg/Pcs/M)</th>
                          <th style="width: 25%;">Subtotal</th>
                          <th style="width: 10%;" class="text-center">Aksi</th>
                        </tr>
                      </thead>
                      <tbody id="cartItems">
                        
                      </tbody>
                    </table>
                  </div>

                  <div class="text-center py-4 text-muted d-none" id="emptyCartMessage">
                    <iconify-icon icon="solar:cart-large-broken" class="fs-8 mb-2"></iconify-icon>
                    <p class="mb-0">Belum ada layanan terpilih. Klik 'Tambah Baris' di atas.</p>
                  </div>
                </div>
              </div>
            </div>

            
            <div class="col-lg-4">
              <div class="card rounded-3 shadow-sm border">
                <div class="card-body p-4">
                  <h5 class="card-title fw-bold text-dark mb-4">Rincian Pembayaran</h5>
                  
                  <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Total Tagihan</span>
                    <span class="fw-bold text-dark fs-4" id="textTotal">Rp0</span>
                  </div>

                  <hr class="my-3">

                  
                  <div class="mb-4">
                    <label for="bayar" class="form-label fw-semibold text-dark">Jumlah Bayar Sekarang (Rp)</label>
                    <input type="number" name="bayar" id="bayar" class="form-control" placeholder="Contoh: 50000" min="0" value="0">
                    <div class="form-text text-muted mt-2">
                      Masukkan 0 jika belum membayar sama sekali.
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary d-flex align-items-center gap-2 shadow-sm">
            <iconify-icon icon="solar:diskette-bold" class="fs-5"></iconify-icon> Buat Antrian Laundry
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  const services = <?= json_encode($services) ?>;
  
  document.addEventListener('DOMContentLoaded', function() {
    const cartItems = document.getElementById('cartItems');
    const emptyCartMessage = document.getElementById('emptyCartMessage');
    const addRowBtn = document.getElementById('addRowBtn');
    const textTotal = document.getElementById('textTotal');
    const bayarInput = document.getElementById('bayar');

    // Reset modal when hidden (cancel/close)
    const tambahAntrianModal = document.getElementById('tambahAntrianModal');
    tambahAntrianModal.addEventListener('hidden.bs.modal', function () {
      const orderForm = document.getElementById('orderForm');
      if (orderForm) {
        orderForm.reset();
      }
      cartItems.innerHTML = '';
      textTotal.textContent = 'Rp0';
    });

    // Add first row by default when modal shows
    tambahAntrianModal.addEventListener('shown.bs.modal', function () {
      if (cartItems.children.length === 0) {
        addNewRow();
      }
    });

    addRowBtn.addEventListener('click', function() {
      addNewRow();
    });

    function toggleCartMessage() {
      if (cartItems.children.length === 0) {
        emptyCartMessage.classList.remove('d-none');
      } else {
        emptyCartMessage.classList.add('d-none');
      }
    }

    function addNewRow() {
      const rowIndex = Date.now();
      const row = document.createElement('tr');
      row.id = `row-${rowIndex}`;
      
      let options = '<option value="" disabled selected>-- Pilih Layanan --</option>';
      services.forEach(s => {
        options += `<option value="${s.id}" data-price="${s.harga}" data-unit="${s.tipe_satuan}">${s.nama_layanan} (Rp${Number(s.harga).toLocaleString('id-ID')}/${s.tipe_satuan})</option>`;
      });

      row.innerHTML = `
        <td>
          <select name="layanan_id[]" class="form-select service-select" required>
            ${options}
          </select>
        </td>
        <td>
          <div class="input-group">
            <input type="number" name="jumlah[]" class="form-control qty-input" value="1.00" min="0.01" step="0.01" required disabled>
            <span class="input-group-text bg-light text-muted unit-label">-</span>
          </div>
        </td>
        <td>
          <span class="fw-bold text-dark subtotal-label">Rp0</span>
        </td>
        <td class="text-center">
          <button type="button" class="btn btn-sm btn-outline-danger btn-remove-row">
            <iconify-icon icon="solar:trash-bin-trash-bold" class="fs-4"></iconify-icon>
          </button>
        </td>
      `;

      cartItems.appendChild(row);
      toggleCartMessage();
      initRowEvents(row);
    }

    function initRowEvents(row) {
      const select = row.querySelector('.service-select');
      const qtyInput = row.querySelector('.qty-input');
      const unitLabel = row.querySelector('.unit-label');
      const subtotalLabel = row.querySelector('.subtotal-label');
      const removeBtn = row.querySelector('.btn-remove-row');

      select.addEventListener('change', function() {
        const option = select.options[select.selectedIndex];
        qtyInput.disabled = false;
        unitLabel.textContent = option.getAttribute('data-unit');
        
        calculateRowSubtotal();
      });

      qtyInput.addEventListener('input', function() {
        calculateRowSubtotal();
      });

      removeBtn.addEventListener('click', function() {
        row.remove();
        toggleCartMessage();
        calculateCartTotal();
      });

      function calculateRowSubtotal() {
        const option = select.options[select.selectedIndex];
        if (!option || option.value === '') return;

        const price = Number(option.getAttribute('data-price'));
        const qty = Number(qtyInput.value);
        const subtotal = Math.round(price * qty);

        subtotalLabel.textContent = `Rp${subtotal.toLocaleString('id-ID')}`;
        subtotalLabel.setAttribute('data-subtotal', subtotal);
        calculateCartTotal();
      }
    }

    function calculateCartTotal() {
      let total = 0;
      const subtotalLabels = cartItems.querySelectorAll('.subtotal-label');
      subtotalLabels.forEach(label => {
        const val = Number(label.getAttribute('data-subtotal') ?? 0);
        total += val;
      });

      textTotal.textContent = `Rp${total.toLocaleString('id-ID')}`;
      bayarInput.max = total; // Paid cannot exceed total bill
    }

    // Auto-show modal on error flashdata
    <?php if (session()->getFlashdata('error')) : ?>
      const myModal = new bootstrap.Modal(tambahAntrianModal);
      myModal.show();
    <?php endif; ?>
  });
</script>

<?= $this->endSection() ?>
