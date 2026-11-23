<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Laporan Biaya Servis | Servis Kendaraan Pribadi</title>
  <link href="../assets/css/style.css" rel="stylesheet">
  <link href="../assets/css/rekap.css" rel="stylesheet">
</head>
<body>
  <a class="skip-link" href="#konten">Lewati ke konten</a>

  <!-- TOPBAR -->
  <header class="topbar sticky-top">
    <div class="d-flex align-items-center gap-3 h-100 px-3">
      <button class="btn btn-outline-secondary d-lg-none" type="button" data-ui-toggle="sidebar" data-ui-target="#sidebar" aria-controls="sidebar" aria-expanded="false" aria-label="Buka menu">
        <span aria-hidden="true">&#9776;</span>
      </button>
      <a class="d-flex align-items-center gap-2 text-decoration-none text-body fw-semibold" href="#">
        <span class="brand-logo" aria-hidden="true">S</span>
        <span class="d-none d-sm-inline">Servis Kendaraan Pribadi</span>
      </a>
      <form class="global-search flex-grow-1 d-none d-md-block mx-lg-4" role="search">
        <label for="cariGlobal" class="visually-hidden">Cari</label>
        <input id="cariGlobal" type="search" class="form-control" placeholder="Cari kendaraan, bengkel, jenis servis...">
      </form>
      <div class="dropdown ms-auto">
        <button class="btn btn-light d-flex align-items-center gap-2" data-ui-toggle="dropdown" aria-expanded="false">
          <span class="avatar-dot rounded-circle bg-secondary-subtle" aria-hidden="true"></span>
          <span class="d-none d-sm-inline">Nama Pengguna</span>
        </button>
        <ul class="dropdown-menu dropdown-menu-end">
          <li><a class="dropdown-item" href="#">Logout</a></li>
        </ul>
      </div>
    </div>
  </header>

  <div class="page-layout d-lg-flex">
    <!-- SIDEBAR (offcanvas di layar kecil) -->
    <aside id="sidebar" class="sidebar offcanvas-lg offcanvas-start" tabindex="-1" aria-label="Menu utama">
      <div class="offcanvas-header d-lg-none">
        <span class="fw-semibold">Menu</span>
        <button type="button" class="btn-close btn-close-white" data-ui-dismiss="sidebar" aria-label="Tutup"></button>
      </div>
      <nav class="offcanvas-body d-block p-2">
        <ul class="nav flex-column">
          <li><a class="nav-link" href="dashboard.html">Dashboard</a></li>
          <li class="nav-heading">Data Master</li>
          <li><a class="nav-link sub" href="kendaraan.html">Kendaraan</a></li>
          <li><a class="nav-link sub" href="jenis_sevis.html">Jenis Servis</a></li>
          <li class="nav-heading">Transaksi</li>
          <li><a class="nav-link sub" href="servis.html">Riwayat Servis</a></li>
          <li class="nav-heading">Laporan</li>
          <li><a class="nav-link sub active" href="rekap.html" aria-current="page">Rekap Biaya</a></li>
          <li class="mt-3"><a class="nav-link" href="../index.html">Logout</a></li>
        </ul>
      </nav>
    </aside>

    <!-- KONTEN -->
    <main id="konten" class="flex-grow-1 p-3 p-md-4">
      <div class="page-content">
        <h1 class="h2 fw-bold mb-1">Laporan Biaya Servis</h1>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb small mb-4">
            <li class="breadcrumb-item"><a href="dashboard.html">Beranda</a></li>
            <li class="breadcrumb-item active" aria-current="page">Laporan</li>
          </ol>
        </nav>

        <!-- FILTER -->
        <section class="card mb-4" aria-labelledby="judulFilter">
          <div class="card-body">
            <h2 id="judulFilter" class="h6 fw-bold mb-3">Filter Laporan</h2>
            <form id="formFilter" novalidate class="row g-3 align-items-end">
              <div class="col-12 col-sm-6 col-xl-3">
                <label for="periodeMulai" class="form-label fw-semibold">Periode Mulai</label>
                <input type="date" id="periodeMulai" class="form-control">
              </div>
              <div class="col-12 col-sm-6 col-xl-3">
                <label for="periodeSelesai" class="form-label fw-semibold">Periode Selesai</label>
                <input type="date" id="periodeSelesai" class="form-control" aria-describedby="errPeriode">
                <div id="errPeriode" class="invalid-feedback">Periode selesai tidak boleh sebelum periode mulai.</div>
              </div>
              <div class="col-12 col-sm-6 col-xl-3">
                <label for="filterKendaraan" class="form-label fw-semibold">Kendaraan</label>
                <select id="filterKendaraan" class="form-select"><option value="">Semua</option></select>
              </div>
              <div class="col-12 col-sm-6 col-xl-3">
                <label for="filterJenis" class="form-label fw-semibold">Jenis Servis</label>
                <select id="filterJenis" class="form-select"><option value="">Semua</option></select>
              </div>
              <div class="col-12 d-flex gap-2">
                <button type="submit" class="btn btn-primary px-4">Tampilkan</button>
                <button type="button" id="btnReset" class="btn btn-outline-secondary">Reset</button>
              </div>
            </form>
          </div>
        </section>

        <!-- RINGKASAN -->
        <section class="row g-3 mb-4" aria-label="Ringkasan" aria-live="polite">
          <div class="col-12 col-sm-6 col-xl-4">
            <div class="card h-100"><div class="card-body">
              <div class="stat-label">Total Biaya</div>
              <div class="stat-value" id="statTotal">Rp 0</div>
            </div></div>
          </div>
          <div class="col-12 col-sm-6 col-xl-4">
            <div class="card h-100"><div class="card-body">
              <div class="stat-label">Jumlah Servis</div>
              <div class="stat-value" id="statJumlah">0 kali</div>
            </div></div>
          </div>
        </section>

        <!-- EMPTY STATE -->
        <div id="kosong" class="alert alert-info d-none" role="status">Data tidak ditemukan untuk filter yang dipilih.</div>

        <!-- TABEL REKAP -->
        <div class="row g-4" id="areaTabel">
          <section class="col-12 col-xl-6" aria-labelledby="jdlKendaraan">
            <div class="card h-100"><div class="card-body">
              <h2 id="jdlKendaraan" class="h6 fw-bold mb-3">Rekap per Kendaraan</h2>
              <div class="table-responsive">
                <table class="table table-report table-report-vehicle table-hover align-middle mb-0">
                  <thead><tr>
                    <th scope="col">Periode</th><th scope="col">Kendaraan</th>
                    <th scope="col" class="num">Jml Servis</th><th scope="col" class="num">Total Biaya</th>
                  </tr></thead>
                  <tbody id="bodyKendaraan"></tbody>
                  <tfoot id="footKendaraan"></tfoot>
                </table>
              </div>
            </div></div>
          </section>

          <section class="col-12 col-xl-6" aria-labelledby="jdlJenis">
            <div class="card h-100"><div class="card-body">
              <h2 id="jdlJenis" class="h6 fw-bold mb-3">Rekap per Jenis Servis</h2>
              <div class="table-responsive">
                <table class="table table-report table-report-type table-hover align-middle mb-0">
                  <thead><tr>
                    <th scope="col">Jenis Servis</th>
                    <th scope="col" class="num">Jumlah</th><th scope="col" class="num">Total Biaya</th>
                  </tr></thead>
                  <tbody id="bodyJenis"></tbody>
                  <tfoot id="footJenis"></tfoot>
                </table>
              </div>
            </div></div>
          </section>
        </div>
      </div>
    </main>
  </div>
    <script src="../assets/js/common-ui.js"></script>
  <script src="../assets/js/rekap.js"></script>
</body>
</html>