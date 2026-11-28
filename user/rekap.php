<?php
require_once __DIR__ . '/../db/auth.php';
wajib_login();
$penggunaAktif = pengguna_login();
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Laporan Biaya Servis | Servis Kendaraan Pribadi</title>
  <link href="../assets/css/style.css?v=<?= filemtime(__DIR__ . '/../assets/css/style.css') ?>" rel="stylesheet">
  <link href="../assets/css/rekap.css?v=<?= filemtime(__DIR__ . '/../assets/css/rekap.css') ?>" rel="stylesheet">
</head>
<body>
  <a class="skip-link" href="#konten">Lewati ke konten</a>

  <?php require __DIR__ . '/topbar.php'; ?>

  <div class="page-layout d-lg-flex">
    <?php $menuAktif = 'rekap'; require __DIR__ . '/sidebar.php'; ?>

    <!-- KONTEN -->
    <main id="konten" class="flex-grow-1 p-3 p-md-4">
      <div class="page-content">
        <h1 class="h2 fw-bold mb-1">Laporan Biaya Servis</h1>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb small mb-4">
            <li class="breadcrumb-item"><a href="dashboard.php">Beranda</a></li>
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