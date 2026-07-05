<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= $title ?? 'Login' ?> - Clean • Fresh • Shine</title>
  <link rel="shortcut icon" type="image/png" href="<?= base_url('assets/images/logos/laundrylogo.png') ?>" />
  <link rel="stylesheet" href="<?= base_url('assets/css/styles.min.css') ?>" />
  <link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Baloo 2', sans-serif !important;
      background: linear-gradient(135deg, rgba(4, 120, 87, 0.15) 0%, rgba(16, 185, 129, 0.15) 100%), url('<?= base_url("assets/images/bglaundry.png") ?>') no-repeat center center;
      background-size: cover;
      min-height: 100vh;
    }
    .card-login {
      border: none;
      border-radius: 24px;
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.25);
      background: #f8fafc;
      max-width: 480px;
      width: 100%;
      margin: 0 auto;
    }
    .card-login .form-label {
      font-size: 14px;
      font-weight: 600;
      color: #1e293b;
    }
    .card-login .input-group {
      background-color: #f1f5f9;
      border: 1px solid #cbd5e1;
      border-radius: 10px;
      transition: all 0.2s ease-in-out;
    }
    .card-login .input-group:focus-within {
      border-color: #059669;
      background-color: #ffffff;
      box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.15);
    }
    .card-login .input-group-text {
      background-color: transparent !important;
      border: none !important;
      padding-right: 8px;
      color: #64748b;
    }
    .card-login .form-control {
      background-color: transparent !important;
      border: none !important;
      padding: 12px 12px 12px 0;
      color: #334155;
      font-size: 14px;
    }
    .card-login .form-control:focus {
      box-shadow: none !important;
    }
    .card-login .btn-primary {
      background-color: #059669;
      border: none;
      border-radius: 12px;
      padding: 12px;
      font-size: 15px;
      font-weight: 600;
      transition: all 0.2s ease-in-out;
    }
    .card-login .btn-primary:hover {
      background-color: #047857;
      transform: translateY(-1px);
      box-shadow: 0 4px 12px rgba(5, 150, 105, 0.2);
    }
  </style>
</head>

<body class="d-flex align-items-center justify-content-center py-5">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-11 col-sm-9 col-md-7 col-lg-6 col-xl-5 d-flex justify-content-center">
        
        <div class="card card-login p-4">
          <div class="card-body">
            
            <div class="text-center mb-4">
              <img src="<?= base_url('assets/images/logos/laundrylogo.png') ?>" alt="Sparkle Laundry Logo" class="img-fluid mb-2" style="max-height: 220px; object-fit: contain;">
              <h3 class="fw-bold text-dark mb-0">Sparkle Laundry</h3>
              <p class="text-muted fs-3">Laundry Management System</p>
            </div>

            
            <?php if (session()->getFlashdata('error')) : ?>
              <div class="alert alert-danger d-flex align-items-center gap-2 py-2 px-3 border-0 rounded-3 mb-4" role="alert">
                <iconify-icon icon="solar:danger-bold-duotone" class="fs-5"></iconify-icon>
                <div class="fs-2 fw-semibold"><?= session()->getFlashdata('error') ?></div>
              </div>
            <?php endif; ?>
            
            <?php if (session()->getFlashdata('success')) : ?>
              <div class="alert alert-success d-flex align-items-center gap-2 py-2 px-3 border-0 rounded-3 mb-4" role="alert">
                <iconify-icon icon="solar:check-circle-bold-duotone" class="fs-5"></iconify-icon>
                <div class="fs-2 fw-semibold"><?= session()->getFlashdata('success') ?></div>
              </div>
            <?php endif; ?>

            <?php $validation = session()->getFlashdata('validation') ?? []; ?>
            <form action="<?= base_url('login') ?>" method="POST" novalidate>
              <div class="mb-3">
                <label for="username" class="form-label">Nama Pengguna (Username)</label>
                <div class="input-group">
                  <span class="input-group-text"><iconify-icon icon="solar:user-rounded-line-duotone"></iconify-icon></span>
                  <input type="text" class="form-control <?= isset($validation['username']) ? 'is-invalid' : '' ?>" id="username" name="username" placeholder="Contoh: admin" value="<?= old('username') ?>">
                </div>
                <?php if (isset($validation['username'])) : ?>
                  <div class="text-danger fs-2 mt-1 px-1"><?= $validation['username'] ?></div>
                <?php endif; ?>
              </div>

              <div class="mb-4">
                <label for="password" class="form-label">Kata Sandi</label>
                <div class="input-group">
                  <span class="input-group-text"><iconify-icon icon="solar:lock-password-line-duotone"></iconify-icon></span>
                  <input type="password" class="form-control <?= isset($validation['password']) ? 'is-invalid' : '' ?>" id="password" name="password" placeholder="••••••••">
                </div>
                <?php if (isset($validation['password'])) : ?>
                  <div class="text-danger fs-2 mt-1 px-1"><?= $validation['password'] ?></div>
                <?php endif; ?>
              </div>

              <button type="submit" class="btn btn-primary w-100 py-2.5 shadow-sm">Masuk Sistem</button>
            </form>

            <div class="text-center mt-4">
              <span class="fs-2 text-muted">Demo: admin / admin101</span>
            </div>

          </div>
        </div>

      </div>
    </div>
  </div>

  
  <script src="<?= base_url('assets/libs/jquery/dist/jquery.min.js') ?>"></script>
  <script src="<?= base_url('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') ?>"></script>
  <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
</body>

</html>
