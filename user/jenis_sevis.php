<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Jenis Servis | Servis Kendaraan Pribadi</title>
  <link href="../assets/css/style.css" rel="stylesheet">
  <link href="../assets/css/jenis_sevis.css" rel="stylesheet">
</head>
<body>
  <a class="skip-link" href="#konten">Lewati ke konten</a>

  <header class="topbar sticky-top">
    <div class="d-flex align-items-center gap-3 h-100 px-3">
      <button class="btn btn-outline-secondary d-lg-none" type="button" data-ui-toggle="sidebar" data-ui-target="#sidebar" aria-controls="sidebar" aria-expanded="false" aria-label="Buka menu">
        <span aria-hidden="true">&#9776;</span>
      </button>
      <a class="d-flex align-items-center gap-2 text-decoration-none text-body fw-semibold" href="dashboard.html">
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
          <li><a class="nav-link" href="dashboard.html">Dashboard</a></li>
          <li class="nav-heading">Data Master</li>
          <li><a class="nav-link sub" href="kendaraan.html">Kendaraan</a></li>
          <li><a class="nav-link sub active" href="jenis_sevis.html" aria-current="page">Jenis Servis</a></li>
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
        <h1 class="h2 fw-bold mb-1">Jenis Servis</h1>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb small mb-4">
            <li class="breadcrumb-item"><a href="dashboard.html">Beranda</a></li>
            <li class="breadcrumb-item">Data Master</li>
            <li class="breadcrumb-item active" aria-current="page">Jenis Servis</li>
          </ol>
        </nav>

        <section aria-label="Daftar jenis servis">
          <div class="d-flex flex-column flex-md-row gap-2 align-items-md-center mb-4">
            <button class="btn btn-primary px-4" type="button" id="btnTambah">
              <span aria-hidden="true">+</span> Tambah Data
            </button>
            <button class="btn btn-outline-secondary px-4" type="button" id="btnFilter" data-ui-toggle="collapse" data-ui-target="#panelFilter" aria-expanded="false" aria-controls="panelFilter">
              Filter
            </button>
            <div class="flex-grow-1 filter-search">
              <label for="cariJenis" class="visually-hidden">Cari nama atau keterangan jenis servis</label>
              <input type="search" class="form-control" id="cariJenis" placeholder="Cari jenis servis...">
            </div>
          </div>

          <div class="collapse mb-3" id="panelFilter" hidden>
            <div class="card card-body">
              <div class="row g-3 align-items-end">
                <div class="col-12 col-sm-6 col-lg-4">
                  <label for="filterInterval" class="form-label fw-semibold">Interval servis</label>
                  <select class="form-select" id="filterInterval">
                    <option value="">Semua interval</option>
                    <option value="km">Berdasarkan kilometer</option>
                    <option value="waktu">Berdasarkan waktu</option>
                  </select>
                </div>
                <div class="col-auto">
                  <button class="btn btn-outline-secondary" type="button" id="btnResetFilter">Reset filter</button>
                </div>
              </div>
            </div>
          </div>

          <div class="card">
            <div class="table-responsive">
              <table class="table table-hover align-middle mb-0 table-services">
                <caption class="visually-hidden">Daftar jenis servis kendaraan</caption>
                <thead>
                  <tr>
                    <th scope="col">No</th>
                    <th scope="col">Nama Jenis Servis</th>
                    <th scope="col">Interval Km/Waktu</th>
                    <th scope="col">Keterangan</th>
                    <th scope="col">Aksi</th>
                  </tr>
                </thead>
                <tbody id="bodyJenis"></tbody>
              </table>
            </div>
          </div>
          <p id="statusJenis" class="visually-hidden" role="status" aria-live="polite"></p>
        </section>
      </div>
    </main>
  </div>

  <div class="modal fade" id="modalJenis" tabindex="-1" aria-labelledby="judulModalJenis" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <form id="formJenis">
          <div class="modal-header">
            <h2 class="modal-title fs-5" id="judulModalJenis">Tambah Jenis Servis</h2>
            <button type="button" class="btn-close" data-ui-dismiss="modal" aria-label="Tutup"></button>
          </div>
          <div class="modal-body">
            <input type="hidden" id="jenisId">
            <div class="mb-3">
              <label for="namaJenis" class="form-label">Nama Jenis Servis</label>
              <input type="text" class="form-control" id="namaJenis" maxlength="80" required>
            </div>
            <fieldset class="mb-3">
              <legend class="form-label">Interval Servis <span class="text-body-secondary small">(isi minimal salah satu)</span></legend>
              <div class="row g-3">
                <div class="col-sm-6">
                  <label for="intervalKm" class="form-label">Kilometer</label>
                  <div class="input-group">
                    <input type="number" class="form-control" id="intervalKm" min="1" step="1" inputmode="numeric">
                    <span class="input-group-text">km</span>
                  </div>
                </div>
                <div class="col-sm-6">
                  <label for="intervalBulan" class="form-label">Waktu</label>
                  <div class="input-group">
                    <input type="number" class="form-control" id="intervalBulan" min="1" step="1" inputmode="numeric">
                    <span class="input-group-text">bulan</span>
                  </div>
                </div>
              </div>
              <div class="text-danger small mt-1" id="intervalError" hidden>Isi interval kilometer atau waktu.</div>
            </fieldset>
            <div>
              <label for="keterangan" class="form-label">Keterangan</label>
              <textarea class="form-control" id="keterangan" rows="3" maxlength="200"></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-ui-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modalDetail" tabindex="-1" aria-labelledby="judulDetail" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h2 class="modal-title fs-5" id="judulDetail">Detail Jenis Servis</h2>
          <button type="button" class="btn-close" data-ui-dismiss="modal" aria-label="Tutup"></button>
        </div>
        <dl class="modal-body row mb-0">
          <dt class="col-5">Nama Jenis Servis</dt><dd class="col-7" id="detailNama"></dd>
          <dt class="col-5">Interval Km/Waktu</dt><dd class="col-7" id="detailInterval"></dd>
          <dt class="col-5">Keterangan</dt><dd class="col-7 mb-0" id="detailKeterangan"></dd>
        </dl>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modalHapus" tabindex="-1" aria-labelledby="judulHapus" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h2 class="modal-title h5 fw-bold" id="judulHapus">Hapus Jenis Servis</h2>
          <button type="button" class="btn-close" data-ui-dismiss="modal" aria-label="Tutup"></button>
        </div>
        <div class="modal-body">
          <p>Anda yakin ingin menghapus jenis servis berikut?</p>
          <div class="small text-body-secondary mb-1">Jenis servis yang akan dihapus</div>
          <div class="border rounded p-2 mb-3 bg-body-tertiary" id="hapusRingkas"></div>
          <p class="text-danger small mb-0">Tindakan ini tidak dapat dibatalkan.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-ui-dismiss="modal">Batal</button>
          <button type="button" class="btn btn-danger" id="btnKonfirmasiHapus">Hapus</button>
        </div>
      </div>
    </div>
  </div>

  <div class="toast-container position-fixed top-0 end-0 p-3" aria-live="polite" aria-atomic="true">
    <div id="toast" class="toast align-items-center border-0" role="status">
      <div class="d-flex">
        <div class="toast-body fw-semibold" id="toastIsi"></div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-ui-dismiss="toast" aria-label="Tutup"></button>
      </div>
    </div>
  </div>
    <script src="../assets/js/common-ui.js"></script>
  <script src="../assets/js/jenis_sevis.js"></script>
</body>
</html>