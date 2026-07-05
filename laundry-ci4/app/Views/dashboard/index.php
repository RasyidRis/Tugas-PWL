<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<?php
$days = [
    'Sunday'    => 'Minggu',
    'Monday'    => 'Senin',
    'Tuesday'   => 'Selasa',
    'Wednesday' => 'Rabu',
    'Thursday'  => 'Kamis',
    'Friday'    => 'Jumat',
    'Saturday'  => 'Sabtu'
];
$months = [
    'January'   => 'Januari',
    'February'  => 'Februari',
    'March'     => 'Maret',
    'April'     => 'April',
    'May'       => 'Mei',
    'June'      => 'Juni',
    'July'      => 'Juli',
    'August'    => 'Agustus',
    'September' => 'September',
    'October'   => 'Oktober',
    'November'  => 'November',
    'December'  => 'Desember'
];
$dayNameName = $days[date('l')];
$monthNameName = $months[date('F')];
$formattedDate = $dayNameName . ', ' . date('d') . ' ' . $monthNameName . ' ' . date('Y');
?>

<div class="d-md-flex align-items-center justify-content-between mb-4">
  <div>
    <h3 class="fw-bold text-dark mb-0">Clean • Fresh • Shine</h3>
  </div>
  <div class="text-md-end mt-2 mt-md-0">
    <div class="fw-semibold text-dark fs-3"><?= $formattedDate ?></div>
    <span class="badge bg-success-subtle text-success fw-bold fs-1 rounded-pill px-2.5 py-1">
      <iconify-icon icon="solar:check-circle-bold" class="me-1 fs-2 align-middle"></iconify-icon> Sistem Running OK
    </span>
  </div>
</div>

<?php if (session()->getFlashdata('success')) : ?>
  <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
    <div class="d-flex align-items-center gap-2">
      <iconify-icon icon="solar:check-circle-bold-duotone" class="fs-6"></iconify-icon>
      <div><?= session()->getFlashdata('success') ?></div>
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
<?php endif; ?>

<div class="row">
  
  <div class="col-sm-6 col-xl-4 mb-4">
    <div class="card overflow-hidden rounded-3 shadow-sm border-0 bg-white h-100">
      <div class="card-body p-4">
        <div class="d-flex align-items-center gap-3">
          <div class="p-3 bg-primary-subtle rounded-3 text-primary d-inline-flex">
            <iconify-icon icon="solar:clipboard-list-bold-duotone" class="fs-8"></iconify-icon>
          </div>
          <div>
            <span class="text-muted fs-2 text-uppercase fw-semibold" style="letter-spacing: 0.5px;">Total Antrian</span>
            <h3 class="fw-bold mb-0 text-dark fs-7 mt-1"><?= $totalAntrian ?></h3>
          </div>
        </div>
      </div>
    </div>
  </div>

  
  <div class="col-sm-6 col-xl-4 mb-4">
    <div class="card overflow-hidden rounded-3 shadow-sm border-0 bg-white h-100">
      <div class="card-body p-4">
        <div class="d-flex align-items-center gap-3">
          <div class="p-3 bg-warning-subtle rounded-3 text-warning d-inline-flex">
            <iconify-icon icon="solar:clock-circle-bold-duotone" class="fs-8"></iconify-icon>
          </div>
          <div>
            <span class="text-muted fs-2 text-uppercase fw-semibold" style="letter-spacing: 0.5px;">Dalam Proses</span>
            <h3 class="fw-bold mb-0 text-dark fs-7 mt-1"><?= $dalamProses ?></h3>
          </div>
        </div>
      </div>
    </div>
  </div>

  
  <div class="col-sm-6 col-xl-4 mb-4">
    <div class="card overflow-hidden rounded-3 shadow-sm border-0 bg-white h-100">
      <div class="card-body p-4">
        <div class="d-flex align-items-center gap-3">
          <div class="p-3 bg-success-subtle rounded-3 text-success d-inline-flex">
            <iconify-icon icon="solar:wad-of-money-bold-duotone" class="fs-8"></iconify-icon>
          </div>
          <div>
            <span class="text-muted fs-2 text-uppercase fw-semibold" style="letter-spacing: 0.5px;">Omset Hari Ini</span>
            <h3 class="fw-bold mb-0 text-dark fs-6 mt-1">Rp<?= number_format($omsetHariIni, 0, ',', '.') ?></h3>
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
        <div class="d-flex align-items-center justify-content-between mb-4">
          <h5 class="card-title fw-bold text-dark mb-0">Antrian Terbaru</h5>
          <a href="<?= base_url('antrian') ?>" class="text-primary fw-semibold fs-3">Lihat Semua</a>
        </div>

        <div class="table-responsive">
          <table class="table align-middle text-nowrap mb-0">
            <thead class="bg-light text-dark fs-3">
              <tr>
                <th class="border-bottom-0"><h6 class="fw-semibold mb-0 fs-3">NO</h6></th>
                <th class="border-bottom-0"><h6 class="fw-semibold mb-0 fs-3">PELANGGAN</h6></th>
                <th class="border-bottom-0 text-center"><h6 class="fw-semibold mb-0 fs-3">STATUS</h6></th>
                <th class="border-bottom-0 text-center"><h6 class="fw-semibold mb-0 fs-3">AKSI</h6></th>
              </tr>
            </thead>
            <tbody>
              <?php if (count($antrian) > 0) : ?>
                <?php foreach ($antrian as $item) : ?>
                  <tr>
                    <td class="border-bottom-0">
                      <span class="text-dark fw-semibold fs-3"><?= esc($item['no_antrian']) ?></span>
                      <div class="mt-1 d-flex flex-column text-muted fs-2" style="white-space: nowrap;">
                        <span>Masuk: <?= date('d M H:i', strtotime($item['created_at'])) ?></span>
                        <?php if (!empty($item['completed_at'])) : ?>
                          <span class="text-success">Selesai: <?= date('d M H:i', strtotime($item['completed_at'])) ?></span>
                        <?php endif; ?>
                      </div>
                    </td>
                    <td class="border-bottom-0">
                      <div class="d-flex flex-column">
                        <span class="text-dark fw-bold fs-4"><?= esc($item['member_nama']) ?></span>
                        <small class="text-muted text-wrap fs-2" style="max-width: 320px;"><?= esc($item['detail_text']) ?></small>
                      </div>
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
                        }
                      ?>
                      <span class="badge rounded-pill fw-bold fs-2 px-3 py-1.5 <?= $badgeClass ?>">
                        <?= esc($item['status']) ?>
                      </span>
                    </td>
                    <td class="border-bottom-0 text-center">
                      <a href="<?= base_url('antrian/detail/' . $item['id']) ?>" class="btn btn-sm btn-light text-primary fw-semibold fs-2">Detail</a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php else : ?>
                <tr>
                  <td colspan="4" class="text-center py-5">
                    <div class="d-flex flex-column align-items-center gap-2">
                      <iconify-icon icon="solar:clipboard-remove-broken" class="fs-8 text-muted"></iconify-icon>
                      <h6 class="fw-semibold text-muted mb-0">Tidak ada antrian aktif saat ini</h6>
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
    <div class="row">
      
      <div class="col-12 mb-4">
        <div class="card rounded-3 shadow-sm border-0">
          <div class="card-body p-4">
            <h5 class="card-title fw-bold text-dark mb-4">Kas Laundry</h5>
            
            <div class="d-flex align-items-center justify-content-between p-3 bg-light rounded-3">
              <div class="d-flex align-items-center gap-3">
                <div class="p-2 bg-success text-white rounded-circle d-inline-flex">
                  <iconify-icon icon="solar:add-circle-bold" class="fs-5"></iconify-icon>
                </div>
                <div>
                  <h6 class="fw-semibold text-dark mb-0 fs-3">Omset Hari Ini</h6>
                </div>
              </div>
              <div>
                <span class="fw-bold text-success fs-4">Rp<?= number_format($omsetHariIni, 0, ',', '.') ?></span>
              </div>
            </div>

          </div>
        </div>
      </div>

      
      <div class="col-12 mb-4">
        <div class="card text-white border-0 shadow-sm rounded-3 overflow-hidden bg-secondary position-relative" style="background: linear-gradient(135deg, #059669 0%, #10b981 100%) !important;">
          <div class="card-body p-4 position-relative" style="z-index: 2;">
            <h4 class="fw-bold text-white mb-2">Layanan Baru?</h4>
            <p class="text-white-50 fs-3 mb-4">Tambah atau update jenis jasa dan harga layanan laundry.</p>
            <a href="<?= base_url('layanan/tambah') ?>" class="btn btn-white text-primary fw-bold px-4 py-2 fs-3 rounded-pill bg-white border-0">Tambah Layanan</a>
          </div>
          
          <div class="position-absolute" style="right: -20px; bottom: -30px; opacity: 0.15; z-index: 1;">
            <iconify-icon icon="solar:tag-price-bold" class="text-white" style="font-size: 180px;"></iconify-icon>
          </div>
        </div>
      </div>

      

    </div>
  </div>
</div>

<?= $this->endSection() ?>
