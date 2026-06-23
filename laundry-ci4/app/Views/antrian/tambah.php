<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<a href="<?= base_url('antrian') ?>" class="btn btn-outline-secondary d-inline-flex align-items-center gap-1 mb-4">
  <iconify-icon icon="solar:arrow-left-line-duotone" class="fs-5"></iconify-icon>
  Kembali ke Antrian
</a>

<?php if (session()->getFlashdata('error')) : ?>
  <div class="alert alert-danger shadow-sm border-0 rounded-3 mb-4" role="alert">
    <div class="d-flex align-items-center gap-2">
      <iconify-icon icon="solar:danger-bold-duotone" class="fs-6"></iconify-icon>
      <div><?= session()->getFlashdata('error') ?></div>
    </div>
  </div>
<?php endif; ?>

<form action="<?= base_url('antrian/simpan') ?>" method="POST" id="orderForm">
  <?= csrf_field() ?>

  <div class="row">
    
    <div class="col-lg-8 mb-4">
      
      <div class="card rounded-3 shadow-sm border-0 mb-4">
        <div class="card-body p-4">
          <div class="d-flex align-items-center gap-3 border-bottom pb-3 mb-4">
            <div class="p-2 bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center">
              <iconify-icon icon="solar:user-rounded-bold-duotone" class="fs-6"></iconify-icon>
            </div>
            <div>
              <h5 class="card-title fw-bold text-dark mb-0">1. Pilih Pelanggan (Member)</h5>
            </div>
          </div>

          <div class="mb-3">
            <label for="member_id" class="form-label fw-semibold text-dark">Nama Pelanggan <span class="text-danger">*</span></label>
            <select name="member_id" id="member_id" class="form-select" required>
              <option value="" disabled selected>-- Pilih Member --</option>
              <option value="new_customer" <?= old('member_id') == 'new_customer' ? 'selected' : '' ?>>+ Pelanggan Baru (Non-Member)</option>
              <?php foreach ($members as $m) : ?>
                <option value="<?= $m['id'] ?>" <?= old('member_id') == $m['id'] ? 'selected' : '' ?>>
                  <?= esc($m['nama']) ?> (<?= esc($m['telepon']) ?>) - Poin: <?= esc($m['poin']) ?>
                </option>
              <?php endforeach; ?>
            </select>
            <div class="form-text text-muted mt-2">
              Pelanggan belum terdaftar? <a href="<?= base_url('member/tambah') ?>" class="text-primary fw-semibold">Daftarkan Member Baru</a>
            </div>
          </div>

          
          <div id="new_customer_fields" class="p-3 bg-light rounded-3 mb-3 d-none border">
            <h6 class="fw-bold text-dark mb-3"><iconify-icon icon="solar:user-plus-bold-duotone" class="text-primary align-middle me-1"></iconify-icon> Data Pelanggan Baru</h6>
            <div class="mb-3">
              <label for="customer_name" class="form-label fw-semibold text-dark">Nama Lengkap <span class="text-danger">*</span></label>
              <input type="text" name="customer_name" id="customer_name" class="form-control" placeholder="Contoh: Budi Santoso" value="<?= old('customer_name') ?>">
            </div>
            <div class="mb-0">
              <label for="customer_phone" class="form-label fw-semibold text-dark">No. Telepon / HP</label>
              <input type="text" name="customer_phone" id="customer_phone" class="form-control" placeholder="Contoh: 081234567890" value="<?= old('customer_phone') ?>">
            </div>
          </div>
        </div>
      </div>

      
      <div class="card rounded-3 shadow-sm border-0">
        <div class="card-body p-4">
          <div class="d-flex align-items-center justify-content-between border-bottom pb-3 mb-4">
            <div class="d-flex align-items-center gap-3">
              <div class="p-2 bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center">
                <iconify-icon icon="solar:tag-price-bold-duotone" class="fs-6"></iconify-icon>
              </div>
              <div>
                <h5 class="card-title fw-bold text-dark mb-0">2. Detail Layanan Cuci</h5>
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
                  <th style="width: 20%;">Jumlah (Kg/Pcs/M)</th>
                  <th style="width: 20%;">Subtotal</th>
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
      <div class="card rounded-3 shadow-sm border-0 sticky-lg-top" style="top: 100px;">
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

          <button type="submit" class="btn btn-primary w-100 py-3 rounded-3 fw-bold fs-4 mb-2 shadow-sm d-flex align-items-center justify-content-center gap-2">
            <iconify-icon icon="solar:diskette-bold" class="fs-5"></iconify-icon> Buat Antrian Laundry
          </button>
          <a href="<?= base_url('antrian') ?>" class="btn btn-light w-100 py-2.5 rounded-3 fw-semibold">Batal</a>
        </div>
      </div>
    </div>
  </div>
</form>

<script>
  const services = <?= json_encode($services) ?>;
  
  document.addEventListener('DOMContentLoaded', function() {
    const cartItems = document.getElementById('cartItems');
    const emptyCartMessage = document.getElementById('emptyCartMessage');
    const addRowBtn = document.getElementById('addRowBtn');
    const textTotal = document.getElementById('textTotal');
    const bayarInput = document.getElementById('bayar');

    // New Customer Handler
    const memberSelect = document.getElementById('member_id');
    const newCustomerFields = document.getElementById('new_customer_fields');
    const customerNameInput = document.getElementById('customer_name');

    function toggleNewCustomerFields() {
      if (memberSelect.value === 'new_customer') {
        newCustomerFields.classList.remove('d-none');
        customerNameInput.required = true;
      } else {
        newCustomerFields.classList.add('d-none');
        customerNameInput.required = false;
      }
    }

    memberSelect.addEventListener('change', toggleNewCustomerFields);
    toggleNewCustomerFields();

    // Add first row by default
    addNewRow();

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
        const price = Number(option.getAttribute('data-price'));
        const unit = option.getAttribute('data-unit');

        qtyInput.disabled = false;
        unitLabel.textContent = unit;
        
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
  });
</script>

<?= $this->endSection() ?>
