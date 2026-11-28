<header class="topbar sticky-top">
  <div class="d-flex align-items-center gap-3 h-100 px-3">
    <button class="btn btn-outline-secondary d-lg-none" type="button" data-ui-toggle="sidebar" data-ui-target="#sidebar" aria-controls="sidebar" aria-expanded="false" aria-label="Buka menu">
      <span aria-hidden="true">&#9776;</span>
    </button>
    <a class="d-flex align-items-center gap-2 text-decoration-none text-body fw-semibold" href="dashboard.php">
      <img class="brand-logo" src="../assets/logo/ikon-servisku.png" alt="Logo Servisku">
      <span class="d-none d-sm-inline">Servis Kendaraan Pribadi</span>
    </a>
    <div class="dropdown ms-auto">
      <button class="btn btn-light d-flex align-items-center gap-2" type="button" data-ui-toggle="dropdown" aria-expanded="false">
        <span class="avatar-dot rounded-circle bg-secondary-subtle" aria-hidden="true"></span>
        <span class="d-none d-sm-inline"><?= htmlspecialchars($penggunaAktif['nama'], ENT_QUOTES, 'UTF-8') ?></span>
      </button>
      <ul class="dropdown-menu dropdown-menu-end">
        <li><a class="dropdown-item" href="../logout.php">Logout</a></li>
      </ul>
    </div>
  </div>
</header>
