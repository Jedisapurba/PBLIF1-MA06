<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard | Servis Kendaraan Pribadi</title>
  <link href="../assets/css/style.css" rel="stylesheet">
  <link href="../assets/css/dashboard.css" rel="stylesheet">
  <a href="../kendaraan.html">Kendaraan</a>
</head>
<body>
  <a class="skip-link" href="#konten">Lewati ke konten</a>

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
        <button class="btn btn-light d-flex align-items-center gap-2" type="button" data-ui-toggle="dropdown" aria-expanded="false">
          <span class="avatar-dot rounded-circle bg-secondary-subtle" aria-hidden="true"></span>
          <span class="d-none d-sm-inline">Nama Pengguna</span>
        </button>
        <ul class="dropdown-menu dropdown-menu-end">
          <li><a class="dropdown-item" href="../login.html">Logout</a></li>
        </ul>
      </div>
    </div>
  </header>

  <div class="page-layout d-lg-flex">
    <aside id="sidebar" class="sidebar offcanvas-lg offcanvas-start" tabindex="-1" aria-label="Menu utama">
      <div class="offcanvas-header d-lg-none">
        <span class="fw-semibold">Menu</span>
        <button type="button" class="btn-close btn-close-white" data-ui-dismiss="sidebar" aria-label="Tutup"></button>
      </div>
      <nav class="offcanvas-body d-block p-2">
        <ul class="nav flex-column">
          <li><a class="nav-link active" href="dashboard.html" aria-current="page">Dashboard</a></li>
          <li class="nav-heading">Data Master</li>
          <li><a class="nav-link sub" href="kendaraan.html">Kendaraan</a></li>
          <li><a class="nav-link sub" href="jenis_sevis.html">Jenis Servis</a></li>
          <li class="nav-heading">Transaksi</li>
          <li><a class="nav-link sub" href="servis.html">Riwayat Servis</a></li>
          <li class="nav-heading">Laporan</li>
          <li><a class="nav-link sub" href="rekap.html">Rekap Biaya</a></li>
          <li class="mt-3"><a class="nav-link" href="../login.html">Logout</a></li>
        </ul>
      </nav>
    </aside>

    <main id="konten" class="flex-grow-1 p-3 p-md-4">
      <div class="page-content">
        <h1 class="h2 fw-bold mb-1">Dashboard</h1>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb small mb-4">
            <li class="breadcrumb-item"><a href="dashboard.html">Beranda</a></li>
            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
          </ol>
        </nav>

        <div class="row g-3 mb-4">
          <div class="col-12 col-md-4">
            <div class="stat-card">
              <div class="text-body-secondary small">Total Kendaraan</div>
              <div class="metric-value mt-2">2</div>
              <div class="text-body-secondary small mt-2">Terdaftar</div>
            </div>
          </div>
          <div class="col-12 col-md-4">
            <div class="stat-card">
              <div class="text-body-secondary small">Total Biaya Servis</div>
              <div class="metric-value mt-2">Rp 3.450.000</div>
              <div class="text-body-secondary small mt-2">Semua periode</div>
            </div>
          </div>
          <div class="col-12 col-md-4">
            <div class="stat-card">
              <div class="text-body-secondary small">Servis Terakhir</div>
              <div class="metric-value mt-2">12/06/2024</div>
              <div class="text-body-secondary small mt-2">Ganti Oli - Honda Beat</div>
            </div>
          </div>
        </div>

        <div class="card mb-4">
          <div class="card-body p-0">
            <h2 class="h5 fw-bold px-3 pt-3 pb-2 mb-0">Servis Terakhir per Kendaraan</h2>
            <div class="table-responsive">
              <table class="table table-dashboard table-hover align-middle mb-0">
                <thead>
                  <tr>
                    <th scope="col">Kendaraan</th>
                    <th scope="col">Jenis Servis</th>
                    <th scope="col">Tanggal</th>
                    <th scope="col">Kilometer</th>
                    <th scope="col">Pengingat</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>Honda Beat - BP 1234 AB</td>
                    <td>Ganti Oli</td>
                    <td>12/06/2024</td>
                    <td>15.200</td>
                    <td>Servis berikutnya 17.200 km</td>
                  </tr>
                  <tr>
                    <td>Toyota Avanza - BP 5678 CD</td>
                    <td>Servis Berkala</td>
                    <td>01/05/2024</td>
                    <td>48.000</td>
                    <td>01/11/2024</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <div class="card">
          <div class="card-body">
            <h2 class="h5 fw-bold mb-3">Grafik Biaya Servis per Bulan</h2>
            <div class="chart-scroll">
              <div id="grafikBiaya" class="chart-wrap" role="img" aria-label="Grafik biaya servis per bulan" aria-describedby="grafikBiayaDeskripsi"></div>
            </div>
            <p id="grafikBiayaDeskripsi" class="visually-hidden"></p>
          </div>
        </div>
      </div>
    </main>
  </div>
  <script src="../assets/js/common-ui.js"></script>
  <script src="../assets/js/dashboard.js"></script>
</body>
</html>
