<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Riwayat Servis | Servis Kendaraan Pribadi</title>
  <link href="../assets/css/style.css" rel="stylesheet">
  <link href="../assets/css/servis.css" rel="stylesheet">
</head>
<body>
  <a class="skip-link" href="#konten">Lewati ke konten</a>

  <!-- TOPBAR -->
  <header class="topbar sticky-top">
    <div class="d-flex align-items-center gap-3 h-100 px-3">
      <button class="btn btn-outline-secondary d-lg-none" type="button" data-ui-toggle="sidebar" data-ui-target="#sidebar" aria-controls="sidebar" aria-expanded="false" aria-label="Buka menu"><span aria-hidden="true">&#9776;</span></button>
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
        <ul class="dropdown-menu dropdown-menu-end"><li><a class="dropdown-item" href="login.html">Logout</a></li></ul>
      </div>
    </div>
  </header>

  <div class="page-layout d-lg-flex">
    <!-- SIDEBAR -->
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
          <li><a class="nav-link sub active" href="servis.html" aria-current="page">Riwayat Servis</a></li>
          <li class="nav-heading">Laporan</li>
          <li><a class="nav-link sub" href="rekap.html">Rekap Biaya</a></li>
          <li class="mt-3"><a class="nav-link" href="../index.html">Logout</a></li>
        </ul>
      </nav>
    </aside>

    <!-- KONTEN -->
    <main id="konten" class="page-main flex-grow-1 p-3 p-md-4">
      <div class="page-content">
        <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
          <div>
            <h1 class="h2 fw-bold mb-1">Riwayat Servis</h1>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb small mb-0">
                <li class="breadcrumb-item"><a href="dashboard.html">Beranda</a></li>
                <li class="breadcrumb-item">Transaksi</li>
                <li class="breadcrumb-item active" aria-current="page">Riwayat Servis</li>
              </ol>
            </nav>
          </div>
          <button type="button" class="btn btn-primary" id="btnTambah">+ Tambah Data</button>
        </div>

        <!-- FILTER -->
        <section class="card mb-4" aria-labelledby="judulFilter">
          <div class="card-body">
            <h2 id="judulFilter" class="h6 fw-bold mb-3">Filter Riwayat</h2>
            <form id="formFilter" novalidate class="row g-3 align-items-end">
              <div class="col-12 col-sm-6 col-xl">
                <label for="fKendaraan" class="form-label fw-semibold">Kendaraan</label>
                <select id="fKendaraan" class="form-select"><option value="">Semua</option></select>
              </div>
              <div class="col-12 col-sm-6 col-xl">
                <label for="fJenis" class="form-label fw-semibold">Jenis Servis</label>
                <select id="fJenis" class="form-select"><option value="">Semua</option></select>
              </div>
              <div class="col-12 col-sm-6 col-xl">
                <label for="fBengkel" class="form-label fw-semibold">Bengkel</label>
                <input id="fBengkel" type="search" class="form-control" placeholder="Cari bengkel...">
              </div>
              <div class="col-12 col-sm-6 col-xl">
                <label for="fMulai" class="form-label fw-semibold">Tanggal Mulai</label>
                <input id="fMulai" type="date" class="form-control">
              </div>
              <div class="col-12 col-sm-6 col-xl">
                <label for="fSelesai" class="form-label fw-semibold">Tanggal Selesai</label>
                <input id="fSelesai" type="date" class="form-control">
                <div class="invalid-feedback">Tanggal selesai tidak boleh sebelum tanggal mulai.</div>
              </div>
              <div class="col-12 d-flex gap-2">
                <button type="submit" class="btn btn-primary px-4">Cari / Filter</button>
                <button type="button" id="btnResetFilter" class="btn btn-outline-secondary">Reset</button>
              </div>
            </form>
          </div>
        </section>

        <!-- DAFTAR -->
        <section class="card" aria-labelledby="judulDaftar">
          <div class="card-body">
            <h2 id="judulDaftar" class="h6 fw-bold mb-3">Daftar Riwayat Servis</h2>
            <div class="table-responsive">
              <table class="table table-data table-hover mb-0">
                <thead><tr>
                  <th scope="col">Tanggal</th><th scope="col">Kendaraan</th><th scope="col">Jenis Servis</th>
                  <th scope="col">Bengkel</th><th scope="col">Kilometer</th><th scope="col">Biaya</th>
                  <th scope="col">Catatan</th><th scope="col">Aksi</th>
                </tr></thead>
                <tbody id="tbody"></tbody>
              </table>
            </div>
            <div id="kosong" class="alert alert-info mt-3 mb-0 d-none" role="status">Data tidak ditemukan.</div>
          </div>
        </section>
      </div>
    </main>
  </div>

  <!-- MODAL: DETAIL -->
  <div class="modal fade" id="modalDetail" tabindex="-1" aria-labelledby="judulDetail" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg"><div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title h5 fw-bold" id="judulDetail">Detail Riwayat Servis</h2>
        <button type="button" class="btn-close" data-ui-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body">
        <dl class="row g-3 mb-0" id="detailBody"></dl>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-ui-dismiss="modal">Tutup</button>
        <button type="button" class="btn btn-primary" id="btnDetailEdit">Edit</button>
      </div>
    </div></div>
  </div>

  <!-- MODAL: TAMBAH / EDIT -->
  <div class="modal fade" id="modalForm" tabindex="-1" aria-labelledby="judulForm" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg"><div class="modal-content">
      <form id="formServis" novalidate>
        <div class="modal-header">
          <h2 class="modal-title h5 fw-bold" id="judulForm">Tambah Riwayat Servis</h2>
          <button type="button" class="btn-close" data-ui-dismiss="modal" aria-label="Tutup"></button>
        </div>
        <div class="modal-body">
          <p class="text-body-secondary small">Kolom bertanda <span class="text-danger">*</span> wajib diisi.</p>
          <div class="row g-3">
            <div class="col-12 col-md-6">
              <label for="iTanggal" class="form-label fw-semibold">Tanggal <span class="text-danger">*</span></label>
              <input type="date" id="iTanggal" class="form-control" required>
              <div class="invalid-feedback" id="eTanggal"></div>
            </div>
            <div class="col-12 col-md-6">
              <label for="iKendaraan" class="form-label fw-semibold">Kendaraan <span class="text-danger">*</span></label>
              <select id="iKendaraan" class="form-select" required><option value="">Pilih kendaraan</option></select>
              <div class="invalid-feedback" id="eKendaraan"></div>
            </div>
            <div class="col-12 col-md-6">
              <label for="iJenis" class="form-label fw-semibold">Jenis Servis <span class="text-danger">*</span></label>
              <select id="iJenis" class="form-select" required><option value="">Pilih jenis servis</option></select>
              <div class="invalid-feedback" id="eJenis"></div>
            </div>
            <div class="col-12 col-md-6">
              <label for="iBengkel" class="form-label fw-semibold">Bengkel</label>
              <input type="text" id="iBengkel" class="form-control" placeholder="Nama bengkel..." maxlength="100">
            </div>
            <div class="col-12 col-md-6">
              <label for="iKm" class="form-label fw-semibold">Kilometer <span class="text-danger">*</span></label>
              <input type="number" id="iKm" class="form-control" placeholder="Masukkan kilometer" inputmode="numeric" step="1" required>
              <div class="invalid-feedback" id="eKm"></div>
            </div>
            <div class="col-12 col-md-6">
              <label for="iBiaya" class="form-label fw-semibold">Biaya (Rp) <span class="text-danger">*</span></label>
              <input type="number" id="iBiaya" class="form-control" placeholder="Masukkan biaya" inputmode="numeric" step="1" required>
              <div class="invalid-feedback" id="eBiaya"></div>
            </div>
            <div class="col-12">
              <label for="iCatatan" class="form-label fw-semibold">Catatan</label>
              <textarea id="iCatatan" class="form-control" rows="3" placeholder="Catatan servis (opsional)"></textarea>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-ui-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary" id="btnSimpan">Simpan</button>
        </div>
      </form>
    </div></div>
  </div>

  <!-- MODAL: HAPUS -->
  <div class="modal fade" id="modalHapus" tabindex="-1" aria-labelledby="judulHapus" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered"><div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title h5 fw-bold" id="judulHapus">Hapus Riwayat Servis</h2>
        <button type="button" class="btn-close" data-ui-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body">
        <p>Anda yakin ingin menghapus riwayat servis berikut?</p>
        <div class="small text-body-secondary mb-1">Riwayat servis yang akan dihapus</div>
        <div class="detail-field mb-3" id="hapusRingkas"></div>
        <p class="text-danger small mb-0">Tindakan ini tidak dapat dibatalkan.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-ui-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-danger" id="btnKonfirmasiHapus">Hapus</button>
      </div>
    </div></div>
  </div>

  <!-- TOAST -->
  <div class="toast-container position-fixed top-0 end-0 p-3" aria-live="polite" aria-atomic="true">
    <div id="toast" class="toast align-items-center border-0" role="status">
      <div class="d-flex">
        <div class="toast-body fw-semibold" id="toastIsi"></div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-ui-dismiss="toast" aria-label="Tutup"></button>
      </div>
    </div>
  </div>
    <script src="../assets/js/common-ui.js"></script>
  <script src="../assets/js/servis.js"></script>
</body>
</html>