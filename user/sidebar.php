<aside id="sidebar" class="sidebar offcanvas-lg offcanvas-start" tabindex="-1" aria-label="Menu utama">
  <div class="offcanvas-header d-lg-none">
    <span class="fw-semibold">Menu</span>
    <button type="button" class="btn-close btn-close-white" data-ui-dismiss="sidebar" aria-label="Tutup"></button>
  </div>
  <nav class="offcanvas-body d-block p-2">
    <ul class="nav flex-column">
      <li><a class="nav-link<?= $menuAktif === 'dashboard' ? ' active' : '' ?>" href="dashboard.php"<?= $menuAktif === 'dashboard' ? ' aria-current="page"' : '' ?>>Dashboard</a></li>
      <li class="nav-heading">Data Master</li>
      <li><a class="nav-link sub<?= $menuAktif === 'kendaraan' ? ' active' : '' ?>" href="kendaraan.php"<?= $menuAktif === 'kendaraan' ? ' aria-current="page"' : '' ?>>Kendaraan</a></li>
      <li><a class="nav-link sub<?= $menuAktif === 'jenis_sevis' ? ' active' : '' ?>" href="jenis_sevis.php"<?= $menuAktif === 'jenis_sevis' ? ' aria-current="page"' : '' ?>>Jenis Servis</a></li>
      <li class="nav-heading">Transaksi</li>
      <li><a class="nav-link sub<?= $menuAktif === 'servis' ? ' active' : '' ?>" href="servis.php"<?= $menuAktif === 'servis' ? ' aria-current="page"' : '' ?>>Servis Kendaraan</a></li>
      <li class="nav-heading">Laporan</li>
      <li><a class="nav-link sub<?= $menuAktif === 'rekap' ? ' active' : '' ?>" href="rekap.php"<?= $menuAktif === 'rekap' ? ' aria-current="page"' : '' ?>>Rekap Biaya</a></li>
      <li class="mt-3"><a class="nav-link" href="../logout.php">Logout</a></li>
    </ul>
  </nav>
</aside>
