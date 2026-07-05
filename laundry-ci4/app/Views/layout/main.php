<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= $title ?? 'Aplikasi Laundry' ?> - Laundry Ganjil</title>
  <link rel="shortcut icon" type="image/png" href="<?= base_url('assets/images/logos/laundrylogo.png') ?>" />
  <link rel="stylesheet" href="<?= base_url('assets/css/styles.min.css') ?>" />
  
  <link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <style>
    :root {
      --bs-primary: #059669 !important;
      --bs-primary-rgb: 5, 150, 105 !important;
      --bs-link-color: #059669 !important;
      --bs-link-color-rgb: 5, 150, 105 !important;
      --bs-link-hover-color: #047857 !important;
      --bs-link-hover-color-rgb: 4, 120, 87 !important;
      --bs-focus-ring-color: rgba(5, 150, 105, 0.25) !important;
      
      --bs-light-primary: #ecfdf5 !important;
      --bs-light-primary-rgb: 236, 253, 245 !important;
      --bs-primary-bg-subtle: #d1fae5 !important;
      --bs-primary-border-subtle: #a7f3d0 !important;
      --bs-primary-text-emphasis: #047857 !important;
    }

    body {
      font-family: 'Baloo 2', sans-serif !important;
    }
    /* Fix template layout top space bug (caused by missing promo banner) */
    .left-sidebar {
      top: 0 !important;
      background-color: #ffffff !important; /* Dominant White Sidebar */
      border-right: 1px solid #e5e7eb !important;
      box-shadow: 0 0.125rem 0.375rem 0 rgba(0, 0, 0, 0.05) !important;
    }
    .app-header {
      top: 0 !important;
      background-color: #ffffff !important; /* White Header */
      border-bottom: 1px solid #e5e7eb !important;
      box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.05) !important;
    }
    
    /* Style header text and icons to normal dark slate colors */
    .app-header h5,
    .app-header .text-dark,
    .app-header span.text-dark,
    .app-header .nav-link i,
    .app-header .navbar-nav .nav-link {
      color: #2a3547 !important;
    }
    
    .app-header span.text-muted {
      color: #5a6a85 !important;
    }
    #main-wrapper[data-layout=vertical][data-header-position=fixed] .body-wrapper > .container-fluid {
      padding-top: calc(70px + 30px) !important;
    }
    .brand-logo {
      min-height: 80px !important;
      padding: 0 16px !important;
      background-color: #ffffff !important; /* White Brand Logo Background */
    }
    
    /* Brand logo text */
    .brand-logo a span, 
    .brand-logo span {
      color: #2a3547 !important;
    }

    /* Re-theme elements with primary color to green */
    .text-primary {
      color: #059669 !important;
    }
    .bg-primary {
      background-color: #059669 !important;
    }
    .bg-primary-subtle {
      background-color: #ecfdf5 !important;
      color: #059669 !important;
    }
    .border-primary {
      border-color: #059669 !important;
    }
    
    /* Buttons styling */
    .btn-primary {
      background-color: #059669 !important;
      border-color: #059669 !important;
      color: #ffffff !important;
    }
    .btn-primary:hover, .btn-primary:focus, .btn-primary:active, .btn-primary.active {
      background-color: #047857 !important;
      border-color: #047857 !important;
      color: #ffffff !important;
    }
    .btn-outline-primary {
      color: #059669 !important;
      border-color: #059669 !important;
    }
    .btn-outline-primary:hover, .btn-outline-primary:focus, .btn-outline-primary:active {
      background-color: #059669 !important;
      border-color: #059669 !important;
      color: #ffffff !important;
    }
    .btn-light-primary {
      background-color: #ecfdf5 !important;
      color: #059669 !important;
    }
    
    /* Form controls focus states */
    .form-control:focus, .form-select:focus {
      border-color: #059669 !important;
      box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.05) !important;
      border-color: #059669 !important;
      box-shadow: 0 0 0 0.25rem rgba(5, 150, 105, 0.25) !important;
    }
    
    /* Sidebar Specific Re-theme (White BG with Green accents) */
    .sidebar-nav ul .sidebar-item .sidebar-link {
      color: #5a6a85 !important;
      font-size: 15px !important;
      font-weight: 500 !important;
      padding: 10px 16px !important;
      border-radius: 8px !important;
      margin-bottom: 4px !important;
      display: flex !important;
      align-items: center !important;
      gap: 12px !important;
    }
    .sidebar-nav ul .sidebar-item .sidebar-link iconify-icon,
    .sidebar-nav ul .sidebar-item .sidebar-link i {
      color: #5a6a85 !important;
      font-size: 21px !important;
    }
    
    /* Active Link in Sidebar */
    .sidebar-nav ul .sidebar-item .sidebar-link.active {
      background-color: #ecfdf5 !important;
      color: #059669 !important;
      font-weight: 600 !important;
    }
    .sidebar-nav ul .sidebar-item .sidebar-link.active iconify-icon,
    .sidebar-nav ul .sidebar-item .sidebar-link.active i {
      color: #059669 !important;
    }
    
    /* Hover Link in Sidebar */
    .sidebar-nav ul .sidebar-item .sidebar-link:hover:not(.active) {
      background-color: rgba(5, 150, 105, 0.05) !important;
      color: #059669 !important;
    }
    .sidebar-nav ul .sidebar-item .sidebar-link:hover:not(.active) iconify-icon,
    .sidebar-nav ul .sidebar-item .sidebar-link:hover:not(.active) i {
      color: #059669 !important;
    }
    
    /* Sidebar Small Caps Headers */
    .sidebar-nav .nav-small-cap {
      color: #7c8fac !important;
      font-size: 11.5px !important;
      font-weight: 700 !important;
      letter-spacing: 0.5px !important;
      margin-top: 16px !important;
      margin-bottom: 8px !important;
    }
    .sidebar-nav .nav-small-cap-icon {
      color: #7c8fac !important;
    }
    
    /* Dropdown item active state */
    .dropdown-item.active, .dropdown-item:active {
      background-color: #059669 !important;
      color: #ffffff !important;
    }
    
    /* Pagination focus and active */
    .page-item.active .page-link {
      background-color: #059669 !important;
      border-color: #059669 !important;
    }
    .page-link {
      color: #059669 !important;
    }
    .page-link:hover {
      color: #047857 !important;
    }
    
    /* Widen body wrapper container to avoid excess empty side space */
    .body-wrapper .container-fluid {
      max-width: 100% !important;
      padding-left: 32px !important;
      padding-right: 32px !important;
    }
  </style>
</head>

<body>
  
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    
    
    <aside class="left-sidebar">
      
      <div>
        <div class="brand-logo d-flex align-items-center justify-content-between">
          <a href="<?= base_url('/') ?>" class="text-nowrap logo-img d-flex align-items-center gap-2 text-decoration-none">
            <img src="<?= base_url('assets/images/logos/laundrylogo.png') ?>" alt="Sparkle Laundry Logo" style="height: 50px; object-fit: contain;">
            <span class="text-dark fw-bold" style="font-size: 20px; letter-spacing: -0.2px;">Sparkle Laundry</span>
          </a>
          <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
            <i class="ti ti-x fs-6"></i>
          </div>
        </div>
        
        
        <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
          <ul id="sidebarnav">
            <li class="sidebar-item">
              <a class="sidebar-link <?= (url_is('/') || url_is('dashboard')) ? 'active' : '' ?>" href="<?= base_url('/') ?>" aria-expanded="false">
                <span>
                  <iconify-icon icon="solar:widget-4-line-duotone" class="fs-6"></iconify-icon>
                </span>
                <span class="hide-menu">Dashboard</span>
              </a>
            </li>
            
            <li class="nav-small-cap">
              <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
              <span class="hide-menu">LAUNDRY MANAGEMENT</span>
            </li>
            
            <li class="sidebar-item">
              <a class="sidebar-link <?= (url_is('antrian') || url_is('antrian/*')) ? 'active' : '' ?>" href="<?= base_url('antrian') ?>" aria-expanded="false">
                <span>
                  <iconify-icon icon="solar:clipboard-list-line-duotone" class="fs-6"></iconify-icon>
                </span>
                <span class="hide-menu">Antrian</span>
              </a>
            </li>
            
            <li class="sidebar-item">
              <a class="sidebar-link <?= (url_is('proses-cuci') || url_is('proses-cuci/*')) ? 'active' : '' ?>" href="<?= base_url('proses-cuci') ?>" aria-expanded="false">
                <span>
                  <iconify-icon icon="solar:washing-machine-line-duotone" class="fs-6"></iconify-icon>
                </span>
                <span class="hide-menu">Proses Cuci</span>
              </a>
            </li>

            <li class="nav-small-cap">
              <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
              <span class="hide-menu">SERVICES & LAYANAN</span>
            </li>

            <li class="sidebar-item">
              <a class="sidebar-link <?= (url_is('layanan') || url_is('layanan/*')) ? 'active' : '' ?>" href="<?= base_url('layanan') ?>" aria-expanded="false">
                <span>
                  <iconify-icon icon="solar:tag-price-line-duotone" class="fs-6"></iconify-icon>
                </span>
                <span class="hide-menu">Layanan</span>
              </a>
            </li>
            
            <?php if (session()->get('role') === 'admin') : ?>
            <li class="nav-small-cap">
              <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
              <span class="hide-menu">FINANCE & USER</span>
            </li>
            
            <li class="sidebar-item">
              <a class="sidebar-link <?= (url_is('keuangan') || url_is('keuangan/*')) ? 'active' : '' ?>" href="<?= base_url('keuangan') ?>" aria-expanded="false">
                <span>
                  <iconify-icon icon="solar:wad-of-money-line-duotone" class="fs-6"></iconify-icon>
                </span>
                <span class="hide-menu">Keuangan</span>
              </a>
            </li>

            <li class="sidebar-item">
              <a class="sidebar-link <?= (url_is('user-management') || url_is('user-management/*')) ? 'active' : '' ?>" href="<?= base_url('user-management') ?>" aria-expanded="false">
                <span>
                  <iconify-icon icon="solar:user-rounded-line-duotone" class="fs-6"></iconify-icon>
                </span>
                <span class="hide-menu">User Management</span>
              </a>
            </li>
            <?php endif; ?>
          </ul>
        </nav>
        
      </div>
      
    </aside>
    
    
    
    <div class="body-wrapper">
      
      <header class="app-header">
        <nav class="navbar navbar-expand-lg navbar-light">
          <ul class="navbar-nav">
            <li class="nav-item d-block d-xl-none">
              <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)">
                <i class="ti ti-menu-2"></i>
              </a>
            </li>
            <li class="nav-item">
              <h5 class="mb-0 fw-semibold text-dark d-none d-md-block">Laundry Management System</h5>
            </li>
          </ul>
          
          <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
            <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
              <li class="nav-item d-none d-sm-flex align-items-center me-2">
                <div class="text-end" style="line-height: 1.2;">
                  <span class="fs-3 fw-bold text-dark d-block"><?= session()->get('username') ?? 'Mahasiswa' ?></span>
                  <span class="fs-2 text-muted text-capitalize d-block"><?= session()->get('role') ?? 'Admin' ?></span>
                </div>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown"
                  aria-expanded="false">
                  <img src="<?= base_url('assets/images/profile/user-1.jpg') ?>" alt="Profile" width="35" height="35" class="rounded-circle">
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                  <div class="message-body">
                    <div class="py-2 px-3 border-bottom mb-2">
                      <p class="mb-0 fs-3 text-dark fw-semibold"><?= session()->get('username') ?? 'Mahasiswa' ?></p>
                      <span class="mb-0 fs-2 text-muted text-capitalize"><?= session()->get('role') ?? 'Admin' ?></span>
                    </div>
                    <a href="<?= base_url('logout') ?>" class="d-flex align-items-center gap-2 dropdown-item">
                      <i class="ti ti-logout fs-5"></i>
                      <p class="mb-0 fs-3">Logout</p>
                    </a>
                  </div>
                </div>
              </li>
            </ul>
          </div>
        </nav>
      </header>
      
      
      <div class="container-fluid">
        
        <?= $this->renderSection('content') ?>
        
        
        <div class="py-6 px-6 text-center mt-5">
          <p class="mb-0 fs-4">© <?= date('Y') ?> Sparkle Laundry. All rights reserved.</p>
        </div>
      </div>
    </div>
  </div>
  
  
  <script src="<?= base_url('assets/libs/jquery/dist/jquery.min.js') ?>"></script>
  <script src="<?= base_url('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') ?>"></script>
  <script src="<?= base_url('assets/js/sidebarmenu.js') ?>"></script>
  <script src="<?= base_url('assets/js/app.min.js') ?>"></script>
  <script src="<?= base_url('assets/libs/simplebar/dist/simplebar.js') ?>"></script>
  
  <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
  
</body>

</html>
