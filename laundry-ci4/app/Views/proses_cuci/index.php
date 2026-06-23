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

<div class="card w-100 shadow-sm border-0 rounded-3">
  <div class="card-body p-4">
    <div class="d-md-flex align-items-center justify-content-between mb-4">
      <div>
        <h5 class="card-title fw-bold text-dark mb-1">Daftar Antrian Proses Cuci</h5>
        <p class="card-subtitle mb-0">Halaman khusus pemantauan proses cuci aktif di workshop</p>
      </div>
      <div class="mt-3 mt-md-0">
        <span class="badge bg-primary-subtle text-primary fw-bold px-3 py-2 rounded-3 fs-2">
          <?= count($antrian) ?> Antrian Aktif
        </span>
      </div>
    </div>
    
    <div class="table-responsive">
      <table class="table text-nowrap align-middle mb-0">
        <thead class="text-dark fs-4 bg-light">
          <tr>
            <th class="border-bottom-0" style="width: 15%;"><h6 class="fw-semibold mb-0">No. Antrian</h6></th>
            <th class="border-bottom-0" style="width: 20%;"><h6 class="fw-semibold mb-0">Pelanggan</h6></th>
            <th class="border-bottom-0" style="width: 40%;"><h6 class="fw-semibold mb-0">Layanan & Pakaian</h6></th>
            <th class="border-bottom-0 text-center" style="width: 10%;"><h6 class="fw-semibold mb-0">Status</h6></th>
            <th class="border-bottom-0 text-center" style="width: 15%;"><h6 class="fw-semibold mb-0">Tindakan Workshop</h6></th>
          </tr>
        </thead>
        <tbody>
          <?php if (count($antrian) > 0) : ?>
            <?php foreach ($antrian as $item) : ?>
              <tr>
                <td class="border-bottom-0">
                  <span class="text-dark fw-bold fs-3"><?= esc($item['no_antrian']) ?></span>
                </td>
                <td class="border-bottom-0">
                  <div class="d-flex flex-column">
                    <span class="text-dark fw-semibold fs-4"><?= esc($item['member_nama']) ?></span>
                    <small class="text-muted fs-2"><?= esc($item['member_telepon']) ?></small>
                  </div>
                </td>
                <td class="border-bottom-0">
                  <p class="mb-0 text-wrap fs-3 text-muted" style="max-width: 350px;">
                    <?= esc($item['detail_text']) ?>
                  </p>
                </td>
                <td class="border-bottom-0 text-center">
                  <?php 
                    $badgeClass = ($item['status'] == 'Cuci') ? 'bg-warning-subtle text-warning' : 'bg-primary-subtle text-primary';
                  ?>
                  <span class="badge rounded-pill fw-bold fs-2 px-3 py-1.5 <?= $badgeClass ?>">
                    <?= esc($item['status']) ?>
                  </span>
                </td>
                <td class="border-bottom-0 text-center">
                  <form action="<?= base_url('proses-cuci/selesaikan/' . $item['id']) ?>" method="POST">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn btn-success text-white fw-bold fs-2 btn-sm px-3 py-2 d-inline-flex align-items-center gap-1 shadow-sm">
                      <iconify-icon icon="solar:check-circle-bold" class="fs-4"></iconify-icon> Tandai Selesai
                    </button>
                  </form>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else : ?>
            <tr>
              <td colspan="5" class="text-center py-5">
                <div class="d-flex flex-column align-items-center gap-2">
                  <iconify-icon icon="solar:washing-machine-bold-duotone" class="fs-8 text-muted"></iconify-icon>
                  <h6 class="fw-semibold text-muted mb-0">Tidak ada cucian yang sedang diproses saat ini</h6>
                </div>
              </td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?= $this->endSection() ?>
