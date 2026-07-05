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

<form action="<?= parse_url(site_url('antrian/simpan'), PHP_URL_PATH) ?>" method="POST" id="orderForm">
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
              <h5 class="card-title fw-bold text-dark mb-0">1. Data Pelanggan</h5>
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



    let localCart = [];

    // Render cart from server items
    function renderCart(items, total) {
      cartItems.innerHTML = '';
      localCart = items;

      if (items.length === 0) {
        emptyCartMessage.classList.remove('d-none');
      } else {
        emptyCartMessage.classList.add('d-none');
      }

      items.forEach(item => {
        const row = document.createElement('tr');
        row.id = `row-${item.id}`;

        let options = `<option value="" disabled>-- Pilih Layanan --</option>`;
        services.forEach(s => {
          const selected = (s.id == item.id) ? 'selected' : '';
          options += `<option value="${s.id}" data-price="${s.harga}" data-unit="${s.tipe_satuan}" ${selected}>${s.nama_layanan} (Rp${Number(s.harga).toLocaleString('id-ID')}/${s.tipe_satuan})</option>`;
        });

        row.innerHTML = `
          <td>
            <select class="form-select service-select" disabled>
              ${options}
            </select>
          </td>
          <td>
            <div class="input-group">
              <input type="number" class="form-control qty-input" value="${item.qty}" min="0.01" step="0.01" data-id="${item.id}" required>
              <span class="input-group-text bg-light text-muted unit-label">${item.unit}</span>
            </div>
          </td>
          <td>
            <span class="fw-bold text-dark subtotal-label" data-subtotal="${item.price * item.qty}">Rp${Math.round(item.price * item.qty).toLocaleString('id-ID')}</span>
          </td>
          <td class="text-center">
            <button type="button" class="btn btn-sm btn-outline-danger btn-remove-row" data-id="${item.id}">
              <iconify-icon icon="solar:trash-bin-trash-bold" class="fs-4"></iconify-icon>
            </button>
          </td>
        `;

        cartItems.appendChild(row);

        // Bind events
        const qtyInput = row.querySelector('.qty-input');
        qtyInput.addEventListener('change', function() {
          updateCartItem(item.id, qtyInput.value);
        });

        const removeBtn = row.querySelector('.btn-remove-row');
        removeBtn.addEventListener('click', function() {
          removeCartItem(item.id);
        });
      });

      textTotal.textContent = `Rp${Math.round(total).toLocaleString('id-ID')}`;
      bayarInput.max = total;
    }

    // Add temp row
    function addNewRow() {
      const rowIndex = Date.now();
      const row = document.createElement('tr');
      row.id = `row-temp-${rowIndex}`;
      
      let options = '<option value="" disabled selected>-- Pilih Layanan --</option>';
      services.forEach(s => {
        const inCart = localCart.some(item => item.id == s.id);
        if (!inCart) {
          options += `<option value="${s.id}">${s.nama_layanan} (Rp${Number(s.harga).toLocaleString('id-ID')}/${s.tipe_satuan})</option>`;
        }
      });

      row.innerHTML = `
        <td>
          <select class="form-select temp-service-select" required>
            ${options}
          </select>
        </td>
        <td>
          <div class="input-group">
            <input type="number" class="form-control qty-input" value="1.00" min="0.01" step="0.01" required disabled>
            <span class="input-group-text bg-light text-muted unit-label">-</span>
          </div>
        </td>
        <td>
          <span class="fw-bold text-dark subtotal-label">Rp0</span>
        </td>
        <td class="text-center">
          <button type="button" class="btn btn-sm btn-outline-danger btn-remove-temp-row">
            <iconify-icon icon="solar:trash-bin-trash-bold" class="fs-4"></iconify-icon>
          </button>
        </td>
      `;

      cartItems.appendChild(row);
      emptyCartMessage.classList.add('d-none');

      const select = row.querySelector('.temp-service-select');
      select.addEventListener('change', function() {
        addCartItem(select.value, 1);
      });

      row.querySelector('.btn-remove-temp-row').addEventListener('click', function() {
        row.remove();
        if (cartItems.children.length === 0) {
          emptyCartMessage.classList.remove('d-none');
        }
      });
    }

    addRowBtn.addEventListener('click', addNewRow);

    function addCartItem(layananId, qty) {
      const formData = new FormData();
      formData.append('layanan_id', layananId);
      formData.append('qty', qty);

      fetch(window.location.origin + '<?= parse_url(site_url('antrian/cart/add'), PHP_URL_PATH) ?>', {
        method: 'POST',
        body: formData
      })
      .then(res => res.json())
      .then(data => {
        if (data.status === 'success') {
          renderCart(data.items, data.total);
        } else {
          alert(data.message || 'Gagal menambahkan layanan.');
        }
      });
    }

    function updateCartItem(layananId, qty) {
      const formData = new FormData();
      formData.append('layanan_id', layananId);
      formData.append('qty', qty);

      fetch(window.location.origin + '<?= parse_url(site_url('antrian/cart/update'), PHP_URL_PATH) ?>', {
        method: 'POST',
        body: formData
      })
      .then(res => res.json())
      .then(data => {
        if (data.status === 'success') {
          renderCart(data.items, data.total);
        }
      });
    }

    function removeCartItem(layananId) {
      const formData = new FormData();
      formData.append('layanan_id', layananId);

      fetch(window.location.origin + '<?= parse_url(site_url('antrian/cart/remove'), PHP_URL_PATH) ?>', {
        method: 'POST',
        body: formData
      })
      .then(res => res.json())
      .then(data => {
        if (data.status === 'success') {
          renderCart(data.items, data.total);
        }
      });
    }

    addNewRow();
  });
</script>

<?= $this->endSection() ?>
