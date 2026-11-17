<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Data Kendaraan | Servis Kendaraan Pribadi</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/css/style.css" rel="stylesheet">
  <style>
    :root { --sidebar-w: 240px; }
    body { font-size: 1rem; }
    .topbar { background: var(--sv-surface); border-bottom: 1px solid var(--sv-border); }
    .sidebar { width: var(--sidebar-w); background-color: var(--sv-sidebar) !important; }
    .sidebar .nav-link { color: var(--sv-sidebar-text); padding: .6rem 1rem; min-height: 44px; display: flex; align-items: center; }
    .sidebar .nav-link.active { color: #fff; }
    .sidebar .nav-link.sub { padding-left: 1.75rem; }
    .sidebar .nav-heading { font-size: .75rem; letter-spacing: .06em; text-transform: uppercase; color: #9FB0C8; padding: .75rem 1rem .25rem; }
    .page-layout { min-height: calc(100vh - 64px); }
    @media (min-width: 992px) {
      .sidebar { position: sticky; top: 64px; height: calc(100vh - 64px); flex: 0 0 var(--sidebar-w); }
    }
    .page-content { max-width: 1400px; }
    .brand-logo { width: 36px; height: 36px; border-radius: 8px; background: var(--sv-primary); color: #fff; display: grid; place-items: center; font-weight: 700; }
    .skip-link { position: absolute; left: -999px; }
    .skip-link:focus { left: 8px; top: 8px; z-index: 2000; background: #fff; padding: .5rem 1rem; }
    .detail-field { background: var(--sv-bg); border: 1px solid var(--sv-border); border-radius: .375rem; padding: .5rem .75rem; min-height: 38px; }
    .toast-container { z-index: 2000; }
    .table-vehicles { min-width: 720px; }
    .table-vehicles th, .table-vehicles td { padding: .7rem .75rem; }
    .table-vehicles th:last-child, .table-vehicles td:last-child { text-align: center; white-space: nowrap; }
    .vehicle-actions { display: inline-flex; gap: .35rem; }
  </style>
</head>
<body>
  <a class="skip-link" href="#konten">Lewati ke konten</a>

  <header class="topbar sticky-top" style="height:64px">
    <div class="d-flex align-items-center gap-3 h-100 px-3">
      <button class="btn btn-outline-secondary d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar" aria-controls="sidebar" aria-label="Buka menu">
        <span aria-hidden="true">&#9776;</span>
      </button>
      <a class="d-flex align-items-center gap-2 text-decoration-none text-body fw-semibold" href="dashboard.html">
        <span class="brand-logo" aria-hidden="true">S</span>
        <span class="d-none d-sm-inline">Servis Kendaraan Pribadi</span>
      </a>
      <form class="flex-grow-1 d-none d-md-block mx-lg-4" role="search" style="max-width:600px" onsubmit="return false">
        <label for="cariGlobal" class="visually-hidden">Cari</label>
        <input id="cariGlobal" type="search" class="form-control" placeholder="Cari kendaraan, bengkel, jenis servis...">
      </form>
      <div class="dropdown ms-auto">
        <button class="btn btn-light d-flex align-items-center gap-2" type="button" data-bs-toggle="dropdown" aria-expanded="false">
          <span class="rounded-circle bg-secondary-subtle d-inline-block" style="width:28px;height:28px" aria-hidden="true"></span>
          <span class="d-none d-sm-inline">Nama Pengguna</span>
        </button>
        <ul class="dropdown-menu dropdown-menu-end">
          <li><a class="dropdown-item" href="login.html">Logout</a></li>
        </ul>
      </div>
    </div>
  </header>

  <div class="page-layout d-lg-flex">
    <aside id="sidebar" class="sidebar offcanvas-lg offcanvas-start" tabindex="-1" aria-label="Menu utama">
      <div class="offcanvas-header d-lg-none">
        <span class="fw-semibold">Menu</span>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" data-bs-target="#sidebar" aria-label="Tutup"></button>
      </div>
      <nav class="offcanvas-body d-block p-2">
        <ul class="nav flex-column">
          <li><a class="nav-link" href="dashboard.html">Dashboard</a></li>
          <li class="nav-heading">Data Master</li>
          <li><a class="nav-link sub active" href="kendaraan.html" aria-current="page">Kendaraan</a></li>
          <li><a class="nav-link sub" href="jenis_sevis.html">Jenis Servis</a></li>
          <li class="nav-heading">Transaksi</li>
          <li><a class="nav-link sub" href="riwayat-servis.html">Riwayat Servis</a></li>
          <li class="nav-heading">Laporan</li>
          <li><a class="nav-link sub" href="rekap.html">Rekap Biaya</a></li>
          <li class="mt-3"><a class="nav-link" href="../index.html">Logout</a></li>
        </ul>
      </nav>
    </aside>

    <main id="konten" class="flex-grow-1 p-3 p-md-4">
      <div class="page-content">
        <h1 class="h2 fw-bold mb-1">Data Kendaraan</h1>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb small mb-4">
            <li class="breadcrumb-item"><a href="dashboard.html">Beranda</a></li>
            <li class="breadcrumb-item">Data Master</li>
            <li class="breadcrumb-item active" aria-current="page">Kendaraan</li>
          </ol>
        </nav>

        <section aria-label="Daftar kendaraan">
          <div class="d-flex flex-column flex-md-row gap-2 align-items-md-center mb-4">
            <button class="btn btn-primary px-4" type="button" id="btnTambah" data-bs-toggle="modal" data-bs-target="#modalKendaraan">
              <span aria-hidden="true">+</span> Tambah Data
            </button>
            <button class="btn btn-outline-secondary px-4" type="button" id="btnFilter" data-bs-toggle="collapse" data-bs-target="#panelFilter" aria-expanded="false" aria-controls="panelFilter">
              Filter
            </button>
            <div class="flex-grow-1" style="max-width: 360px">
              <label for="cariKendaraan" class="visually-hidden">Cari nama atau nomor polisi</label>
              <input type="search" class="form-control" id="cariKendaraan" placeholder="Cari nama / plat...">
            </div>
          </div>

          <div class="collapse mb-3" id="panelFilter">
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
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
          </div>
          <div class="modal-body">
            <input type="hidden" id="kendaraanId">
            <div class="mb-3">
              <label for="namaKendaraan" class="form-label">Nama Kendaraan</label>
              <input type="text" class="form-control" id="namaKendaraan" maxlength="80" required>
            </div>
            <div class="mb-3">
              <label for="jenisKendaraan" class="form-label">Jenis Kendaraan</label>
              <select class="form-select" id="jenisKendaraan" required>
                <option value="">Pilih jenis</option>
                <option value="Motor">Motor</option>
                <option value="Mobil">Mobil</option>
              </select>
            </div>
            <div class="mb-3">
              <label for="nomorPolisi" class="form-label">No. Polisi</label>
              <input type="text" class="form-control text-uppercase" id="nomorPolisi" maxlength="12" required>
            </div>
            <div>
              <label for="tahunKendaraan" class="form-label">Tahun</label>
              <input type="number" class="form-control" id="tahunKendaraan" min="1900" required>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
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
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
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
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>
        <div class="modal-body">
          <p>Anda yakin ingin menghapus data kendaraan berikut?</p>
          <div class="small text-body-secondary mb-1">Kendaraan yang akan dihapus</div>
          <div class="detail-field mb-3" id="hapusRingkas"></div>
          <p class="text-danger small mb-0">Tindakan ini tidak dapat dibatalkan.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="button" class="btn btn-danger" id="btnKonfirmasiHapus">Hapus</button>
        </div>
      </div>
    </div>
  </div>

  <div class="toast-container position-fixed top-0 end-0 p-3" aria-live="polite" aria-atomic="true">
    <div id="toast" class="toast align-items-center border-0" role="status">
      <div class="d-flex">
        <div class="toast-body fw-semibold" id="toastIsi"></div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Tutup"></button>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    const kendaraan = [
      { id: 1, nama: 'Honda Beat', jenis: 'Motor', polisi: 'BP 1234 AB', tahun: 2021 },
      { id: 2, nama: 'Toyota Avanza', jenis: 'Mobil', polisi: 'BP 5678 CD', tahun: 2018 }
    ];

    const $ = id => document.getElementById(id);
    const esc = value => String(value).replace(/[&<>"']/g, character => ({
      '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;'
    }[character]));
    const modalForm = bootstrap.Modal.getOrCreateInstance($('modalKendaraan'));
    const modalDetail = bootstrap.Modal.getOrCreateInstance($('modalDetail'));
    const modalHapus = bootstrap.Modal.getOrCreateInstance($('modalHapus'));
    const toast = new bootstrap.Toast($('toast'), { delay: 3500 });
    let hapusId = null;
    let focusTarget = $('btnTambah');
    $('tahunKendaraan').max = new Date().getFullYear() + 1;

    function notif(pesan, sukses = true) {
      $('toast').className = 'toast align-items-center border-0 text-bg-' + (sukses ? 'success' : 'danger');
      $('toastIsi').textContent = pesan;
      toast.show();
    }

    function renderKendaraan() {
      const query = $('cariKendaraan').value.trim().toLocaleLowerCase('id');
      const jenis = $('filterJenis').value;
      const rows = kendaraan.filter(item =>
        (!jenis || item.jenis === jenis) &&
        (!query || item.nama.toLocaleLowerCase('id').includes(query) || item.polisi.toLocaleLowerCase('id').includes(query))
      );

      $('bodyKendaraan').innerHTML = rows.length
        ? rows.map((item, index) => `
            <tr>
              <td>${index + 1}</td>
              <td>${esc(item.nama)}</td>
              <td>${esc(item.jenis)}</td>
              <td>${esc(item.polisi)}</td>
              <td>${item.tahun}</td>
              <td>
                <div class="vehicle-actions">
                  <button class="btn btn-sm btn-outline-primary" type="button" data-action="lihat" data-id="${item.id}">Lihat</button>
                  <button class="btn btn-sm btn-outline-secondary" type="button" data-action="edit" data-id="${item.id}">Edit</button>
                  <button class="btn btn-sm btn-outline-danger" type="button" data-action="hapus" data-id="${item.id}">Hapus</button>
                </div>
              </td>
            </tr>`).join('')
        : '<tr><td class="text-center text-body-secondary py-4" colspan="6">Data kendaraan tidak ditemukan.</td></tr>';
      $('statusKendaraan').textContent = rows.length
        ? `${rows.length} kendaraan ditampilkan.`
        : 'Data kendaraan tidak ditemukan.';
    }

    function siapkanForm(item = null) {
      $('formKendaraan').reset();
      $('kendaraanId').value = item ? item.id : '';
      $('judulModalKendaraan').textContent = item ? 'Edit Kendaraan' : 'Tambah Kendaraan';
      if (item) {
        $('namaKendaraan').value = item.nama;
        $('jenisKendaraan').value = item.jenis;
        $('nomorPolisi').value = item.polisi;
        $('tahunKendaraan').value = item.tahun;
      }
    }

    $('btnTambah').addEventListener('click', () => {
      focusTarget = $('btnTambah');
      siapkanForm();
    });
    $('cariKendaraan').addEventListener('input', renderKendaraan);
    $('filterJenis').addEventListener('change', renderKendaraan);
    $('btnResetFilter').addEventListener('click', () => {
      $('filterJenis').value = '';
      $('cariKendaraan').value = '';
      renderKendaraan();
    });

    $('bodyKendaraan').addEventListener('click', event => {
      const button = event.target.closest('button[data-action]');
      if (!button) return;
      const item = kendaraan.find(row => row.id === Number(button.dataset.id));
      if (!item) return;

      if (button.dataset.action === 'lihat') {
        $('detailNama').textContent = item.nama;
        $('detailJenis').textContent = item.jenis;
        $('detailPolisi').textContent = item.polisi;
        $('detailTahun').textContent = item.tahun;
        modalDetail.show();
      } else if (button.dataset.action === 'edit') {
        focusTarget = button;
        siapkanForm(item);
        modalForm.show();
      } else if (button.dataset.action === 'hapus') {
        hapusId = item.id;
        $('hapusRingkas').textContent = `${item.nama} — ${item.polisi}`;
        modalHapus.show();
      }
    });

    $('btnKonfirmasiHapus').addEventListener('click', () => {
      const index = kendaraan.findIndex(item => item.id === hapusId);
      if (index === -1) {
        modalHapus.hide();
        notif('Gagal menghapus kendaraan.', false);
        return;
      }
      kendaraan.splice(index, 1);
      hapusId = null;
      modalHapus.hide();
      renderKendaraan();
      notif('Kendaraan berhasil dihapus.');
    });

    $('formKendaraan').addEventListener('submit', event => {
      event.preventDefault();
      const id = Number($('kendaraanId').value);
      const item = {
        id: id || Math.max(0, ...kendaraan.map(row => row.id)) + 1,
        nama: $('namaKendaraan').value.trim(),
        jenis: $('jenisKendaraan').value,
        polisi: $('nomorPolisi').value.trim().toLocaleUpperCase('id'),
        tahun: Number($('tahunKendaraan').value)
      };
      const index = kendaraan.findIndex(row => row.id === id);
      if (index === -1) kendaraan.push(item);
      else kendaraan[index] = item;
      renderKendaraan();
      modalForm.hide();
    });

    $('modalKendaraan').addEventListener('hide.bs.modal', () => {
      window.setTimeout(() => focusTarget.focus(), 0);
    });
    $('modalKendaraan').addEventListener('hidden.bs.modal', () => {
      $('formKendaraan').reset();
      focusTarget.focus();
    });
    $('cariGlobal').addEventListener('input', event => {
      $('cariKendaraan').value = event.target.value;
      renderKendaraan();
    });
    renderKendaraan();
  </script>
</body>
</html>