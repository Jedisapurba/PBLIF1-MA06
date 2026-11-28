<?php
require_once __DIR__ . '/../db/auth.php';
wajib_login();
$penggunaAktif = pengguna_login();
if (!isset($_SESSION['csrf_jenis_servis'])) {
    $_SESSION['csrf_jenis_servis'] = bin2hex(random_bytes(32));
}
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="<?= htmlspecialchars($_SESSION['csrf_jenis_servis'], ENT_QUOTES, 'UTF-8') ?>">
  <title>Jenis Servis | Servis Kendaraan Pribadi</title>
  <link href="../assets/css/style.css?v=<?= filemtime(__DIR__ . '/../assets/css/style.css') ?>" rel="stylesheet">
  <link href="../assets/css/jenis_sevis.css?v=<?= filemtime(__DIR__ . '/../assets/css/jenis_sevis.css') ?>" rel="stylesheet">
</head>
<body>
  <a class="skip-link" href="#konten">Lewati ke konten</a>

  <?php require __DIR__ . '/topbar.php'; ?>

  <div class="page-layout d-lg-flex">
    <?php $menuAktif = 'jenis_sevis'; require __DIR__ . '/sidebar.php'; ?>

    <main id="konten" class="flex-grow-1 p-3 p-md-4">
      <div class="page-content">
        <h1 class="h2 fw-bold mb-1">Jenis Servis</h1>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb small mb-4">
            <li class="breadcrumb-item"><a href="dashboard.php">Beranda</a></li>
            <li class="breadcrumb-item">Data Master</li>
            <li class="breadcrumb-item active" aria-current="page">Jenis Servis</li>
          </ol>
        </nav>

        <section aria-label="Daftar jenis servis">
          <div class="d-flex flex-column flex-md-row gap-2 align-items-md-center mb-4">
            <button class="btn btn-primary px-4" type="button" id="btnTambah">
              <span aria-hidden="true">+</span> Tambah Data
            </button>
            <div class="flex-grow-1 filter-search">
              <label for="cariJenis" class="visually-hidden">Cari nama atau keterangan jenis servis</label>
              <input type="search" class="form-control" id="cariJenis" placeholder="Cari jenis servis...">
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
              <input type="text" class="form-control" id="namaJenis" placeholder="Contoh: Ganti Oli" maxlength="100" required>
            </div>
            <fieldset class="mb-3">
              <legend class="form-label">Interval Servis <span class="text-body-secondary small">(isi minimal salah satu)</span></legend>
              <div class="row g-3">
                <div class="col-sm-6">
                  <label for="intervalKm" class="form-label">Kilometer</label>
                  <div class="input-group">
                    <input type="number" class="form-control" id="intervalKm" placeholder="Contoh: 5000" min="1" max="2147483647" step="1" inputmode="numeric">
                    <span class="input-group-text">km</span>
                  </div>
                </div>
                <div class="col-sm-6">
                  <label for="intervalBulan" class="form-label">Waktu</label>
                  <div class="input-group">
                    <input type="number" class="form-control" id="intervalBulan" placeholder="Contoh: 6" min="1" max="2147483647" step="1" inputmode="numeric">
                    <span class="input-group-text">bulan</span>
                  </div>
                </div>
              </div>
              <div class="text-danger small mt-1" id="intervalError" hidden>Isi interval kilometer atau waktu.</div>
            </fieldset>
            <div>
              <label for="keterangan" class="form-label">Keterangan</label>
              <textarea class="form-control" id="keterangan" placeholder="Tambahkan keterangan (opsional)" rows="3" maxlength="150"></textarea>
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
  <script src="../assets/js/jenis_sevis.js?v=<?= filemtime(__DIR__ . '/../assets/js/jenis_sevis.js') ?>"></script>
</body>
</html>