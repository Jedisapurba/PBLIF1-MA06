<?php
require_once __DIR__ . '/../db/auth.php';
wajib_login();
$penggunaAktif = pengguna_login();
if (!isset($_SESSION['csrf_kendaraan'])) {
    $_SESSION['csrf_kendaraan'] = bin2hex(random_bytes(32));
}
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="<?= htmlspecialchars($_SESSION['csrf_kendaraan'], ENT_QUOTES, 'UTF-8') ?>">
  <title>Data Kendaraan | Servis Kendaraan Pribadi</title>
  <link href="../assets/css/style.css?v=<?= filemtime(__DIR__ . '/../assets/css/style.css') ?>" rel="stylesheet">
  <link href="../assets/css/kendaraan.css?v=<?= filemtime(__DIR__ . '/../assets/css/kendaraan.css') ?>" rel="stylesheet">
</head>
<body>
  <a class="skip-link" href="#konten">Lewati ke konten</a>

  <?php require __DIR__ . '/topbar.php'; ?>

  <div class="page-layout d-lg-flex">
    <?php $menuAktif = 'kendaraan'; require __DIR__ . '/sidebar.php'; ?>

    <main id="konten" class="flex-grow-1 p-3 p-md-4">
      <div class="page-content">
        <h1 class="h2 fw-bold mb-1">Data Kendaraan</h1>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb small mb-4">
            <li class="breadcrumb-item"><a href="dashboard.php">Beranda</a></li>
            <li class="breadcrumb-item">Data Master</li>
            <li class="breadcrumb-item active" aria-current="page">Kendaraan</li>
          </ol>
        </nav>

        <section aria-label="Daftar kendaraan">
          <div class="d-flex flex-column flex-md-row gap-2 align-items-md-center mb-4">
            <button class="btn btn-primary px-4" type="button" id="btnTambah">
              <span aria-hidden="true">+</span> Tambah Data
            </button>
            <button class="btn btn-outline-secondary px-4" type="button" id="btnFilter" data-ui-toggle="collapse" data-ui-target="#panelFilter" aria-expanded="false" aria-controls="panelFilter">
              Filter
            </button>
            <div class="flex-grow-1 filter-search">
              <label for="cariKendaraan" class="visually-hidden">Cari nama atau nomor polisi</label>
              <input type="search" class="form-control" id="cariKendaraan" placeholder="Cari nama / plat...">
            </div>
          </div>

          <div class="collapse mb-3" id="panelFilter" hidden>
            <div class="card card-body">
              <div class="row g-3 align-items-end">
                <div class="col-12 col-sm-6 col-lg-4">
                  <label for="filterJenis" class="form-label fw-semibold">Jenis Kendaraan</label>
                  <select class="form-select" id="filterJenis">
                    <option value="">Semua jenis</option>
                    <option value="Motor">Motor</option>
                    <option value="Mobil">Mobil</option>
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
              <table class="table table-hover align-middle mb-0 table-vehicles">
                <caption class="visually-hidden">Daftar kendaraan yang terdaftar</caption>
                <thead>
                  <tr>
                    <th scope="col">No</th>
                    <th scope="col">Nama Kendaraan</th>
                    <th scope="col">Jenis</th>
                    <th scope="col">No. Polisi</th>
                    <th scope="col">Tahun</th>
                    <th scope="col">Aksi</th>
                  </tr>
                </thead>
                <tbody id="bodyKendaraan"></tbody>
              </table>
            </div>
          </div>
          <p id="statusKendaraan" class="visually-hidden" role="status" aria-live="polite"></p>
        </section>
      </div>
    </main>
  </div>

  <div class="modal fade" id="modalKendaraan" tabindex="-1" aria-labelledby="judulModalKendaraan" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <form id="formKendaraan">
          <div class="modal-header">
            <h2 class="modal-title fs-5" id="judulModalKendaraan">Tambah Kendaraan</h2>
            <button type="button" class="btn-close" data-ui-dismiss="modal" aria-label="Tutup"></button>
          </div>
          <div class="modal-body">
            <input type="hidden" id="kendaraanId">
            <div class="mb-3">
              <label for="namaKendaraan" class="form-label">Nama Kendaraan</label>
              <input type="text" class="form-control" id="namaKendaraan" placeholder="Contoh: Honda Beat" maxlength="50" required>
            </div>
            <div class="mb-3">
              <label for="jenisKendaraan" class="form-label">Jenis Kendaraan</label>
              <select class="form-select" id="jenisKendaraan" required>
                <option value="">Pilih jenis kendaraan</option>
                <option value="Motor">Motor</option>
                <option value="Mobil">Mobil</option>
              </select>
            </div>
            <div class="mb-3">
              <label for="nomorPolisi" class="form-label">No. Polisi</label>
              <input type="text" class="form-control text-uppercase" id="nomorPolisi" placeholder="Contoh: B 1234 XYZ" maxlength="15" required>
            </div>
            <div>
              <label for="tahunKendaraan" class="form-label">Tahun</label>
              <input type="number" class="form-control" id="tahunKendaraan" placeholder="Contoh: 2022" min="1901" max="2050" required>
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
          <h2 class="modal-title fs-5" id="judulDetail">Detail Kendaraan</h2>
          <button type="button" class="btn-close" data-ui-dismiss="modal" aria-label="Tutup"></button>
        </div>
        <dl class="modal-body row mb-0">
          <dt class="col-5">Nama Kendaraan</dt><dd class="col-7" id="detailNama"></dd>
          <dt class="col-5">Jenis</dt><dd class="col-7" id="detailJenis"></dd>
          <dt class="col-5">No. Polisi</dt><dd class="col-7" id="detailPolisi"></dd>
          <dt class="col-5">Tahun</dt><dd class="col-7 mb-0" id="detailTahun"></dd>
        </dl>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modalHapus" tabindex="-1" aria-labelledby="judulHapus" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h2 class="modal-title h5 fw-bold" id="judulHapus">Hapus Kendaraan</h2>
          <button type="button" class="btn-close" data-ui-dismiss="modal" aria-label="Tutup"></button>
        </div>
        <div class="modal-body">
          <p>Anda yakin ingin menghapus data kendaraan berikut?</p>
          <div class="small text-body-secondary mb-1">Kendaraan yang akan dihapus</div>
          <div class="detail-field mb-3" id="hapusRingkas"></div>
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
  <script src="../assets/js/kendaraan.js?v=<?= filemtime(__DIR__ . '/../assets/js/kendaraan.js') ?>"></script>
</body>
</html>