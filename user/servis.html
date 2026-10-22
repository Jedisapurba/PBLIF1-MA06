<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Riwayat Servis | Servis Kendaraan Pribadi</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/css/style.css" rel="stylesheet">
  <style>
    :root { --sidebar-w: 240px; }
    .topbar { background: var(--sv-surface); border-bottom: 1px solid var(--sv-border); }
    /* !important diperlukan: .offcanvas-lg Bootstrap memaksa background transparan di layar lg ke atas */
    .sidebar { width: var(--sidebar-w); background-color: var(--sv-sidebar) !important; }
    .sidebar .nav-link { color: var(--sv-sidebar-text); padding: .6rem 1rem; min-height: 44px; display: flex; align-items: center; }
    .sidebar .nav-link.active { color: #fff; }
    .sidebar .nav-link.sub { padding-left: 1.75rem; }
    .sidebar .nav-heading { font-size: .75rem; letter-spacing: .06em; text-transform: uppercase; color: #9FB0C8; padding: .75rem 1rem .25rem; }
    .page-layout { min-height: calc(100vh - 64px); }
    @media (min-width: 992px) {
      .sidebar { position: sticky; top: 64px; height: calc(100vh - 64px); flex: 0 0 var(--sidebar-w); }
    }
    .page-content { max-width: 1200px; }
    .table-data { font-size: .9375rem; min-width: 900px; }
    .table-data th, .table-data td { padding: .65rem .75rem; vertical-align: middle; }
    .table-data .num { font-variant-numeric: tabular-nums; white-space: nowrap; }
    .table-data .aksi { white-space: nowrap; }
    .brand-logo { width: 36px; height: 36px; border-radius: 8px; background: var(--sv-primary); color: #fff; display: grid; place-items: center; font-weight: 700; }
    .skip-link { position: absolute; left: -999px; }
    .skip-link:focus { left: 8px; top: 8px; z-index: 2000; background: #fff; padding: .5rem 1rem; }
    .detail-field { background: var(--sv-bg); border: 1px solid var(--sv-border); border-radius: .375rem; padding: .5rem .75rem; min-height: 38px; }
    .toast-container { z-index: 2000; }
  </style>
</head>
<body>
  <a class="skip-link" href="#konten">Lewati ke konten</a>

  <!-- TOPBAR -->
  <header class="topbar sticky-top" style="height:64px">
    <div class="d-flex align-items-center gap-3 h-100 px-3">
      <button class="btn btn-outline-secondary d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar" aria-controls="sidebar" aria-label="Buka menu"><span aria-hidden="true">&#9776;</span></button>
      <a class="d-flex align-items-center gap-2 text-decoration-none text-body fw-semibold" href="#">
        <span class="brand-logo" aria-hidden="true">S</span>
        <span class="d-none d-sm-inline">Servis Kendaraan Pribadi</span>
      </a>
      <form class="flex-grow-1 d-none d-md-block mx-lg-4" role="search" style="max-width:600px" onsubmit="return false">
        <label for="cariGlobal" class="visually-hidden">Cari</label>
        <input id="cariGlobal" type="search" class="form-control" placeholder="Cari kendaraan, bengkel, jenis servis...">
      </form>
      <div class="dropdown ms-auto">
        <button class="btn btn-light d-flex align-items-center gap-2" data-bs-toggle="dropdown" aria-expanded="false">
          <span class="rounded-circle bg-secondary-subtle d-inline-block" style="width:28px;height:28px" aria-hidden="true"></span>
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
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" data-bs-target="#sidebar" aria-label="Tutup"></button>
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
    <main id="konten" class="flex-grow-1 p-3 p-md-4" style="min-width:0">
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
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body">
        <dl class="row g-3 mb-0" id="detailBody"></dl>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Tutup</button>
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
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
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
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
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
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body">
        <p>Anda yakin ingin menghapus riwayat servis berikut?</p>
        <div class="small text-body-secondary mb-1">Riwayat servis yang akan dihapus</div>
        <div class="detail-field mb-3" id="hapusRingkas"></div>
        <p class="text-danger small mb-0">Tindakan ini tidak dapat dibatalkan.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-danger" id="btnKonfirmasiHapus">Hapus</button>
      </div>
    </div></div>
  </div>

  <!-- TOAST -->
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
    /* ===== DATA CONTOH (ganti dengan fetch ke backend/PHP) =====
       Master kendaraan & jenis servis seharusnya diambil dari endpoint masing-masing. */
    const KENDARAAN = ['Honda Beat', 'Toyota Avanza'];
    const JENIS = ['Ganti Oli', 'Servis Berkala', 'Ganti Ban', 'Rem'];
    let data = [
      { id: 1, tanggal: '2024-06-12', kendaraan: 'Honda Beat',    jenis: 'Ganti Oli',      bengkel: 'AHASS Batam', km: 15200, biaya: 65000,   catatan: 'Oli MPX2' },
      { id: 2, tanggal: '2024-05-01', kendaraan: 'Toyota Avanza', jenis: 'Servis Berkala', bengkel: 'Auto2000',    km: 48000, biaya: 1250000, catatan: '' }
    ];
    let nextId = 3, editId = null, hapusId = null, detailId = null;

    const $ = id => document.getElementById(id);
    const esc = s => String(s ?? '').replace(/[&<>"']/g, c => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]));
    const fmtRp = n => 'Rp ' + new Intl.NumberFormat('id-ID').format(n);
    const fmtNum = n => new Intl.NumberFormat('id-ID').format(n);
    const fmtTgl = iso => iso.split('-').reverse().join('/');

    const mFormDetail = new bootstrap.Modal($('modalDetail'));
    const mForm = new bootstrap.Modal($('modalForm'));
    const mHapus = new bootstrap.Modal($('modalHapus'));
    const toast = new bootstrap.Toast($('toast'), { delay: 3500 });

    function notif(pesan, sukses = true) {
      $('toast').className = 'toast align-items-center border-0 text-bg-' + (sukses ? 'success' : 'danger');
      $('toastIsi').textContent = pesan;
      toast.show();
    }

    function isiSelect(selectId, list) {
      list.forEach(v => { const o = document.createElement('option'); o.value = o.textContent = v; $(selectId).appendChild(o); });
    }

    /* ---------- Tabel + filter ---------- */
    function render() {
      const mulai = $('fMulai').value, selesai = $('fSelesai').value;
      const salah = mulai && selesai && selesai < mulai;
      $('fSelesai').classList.toggle('is-invalid', salah);
      if (salah) { $('fSelesai').focus(); return; }

      const k = $('fKendaraan').value, j = $('fJenis').value, b = $('fBengkel').value.trim().toLowerCase();
      const rows = data
        .filter(r => (!k || r.kendaraan === k) && (!j || r.jenis === j) &&
                     (!b || r.bengkel.toLowerCase().includes(b)) &&
                     (!mulai || r.tanggal >= mulai) && (!selesai || r.tanggal <= selesai))
        .sort((a, c) => c.tanggal.localeCompare(a.tanggal) || c.id - a.id);

      $('tbody').innerHTML = rows.map(r => `
        <tr>
          <td class="num">${fmtTgl(r.tanggal)}</td>
          <td>${esc(r.kendaraan)}</td>
          <td>${esc(r.jenis)}</td>
          <td>${esc(r.bengkel) || '-'}</td>
          <td class="num">${fmtNum(r.km)}</td>
          <td class="num">${fmtRp(r.biaya)}</td>
          <td>${esc(r.catatan) || '-'}</td>
          <td class="aksi">
            <div class="btn-group btn-group-sm" role="group" aria-label="Aksi untuk ${esc(r.jenis)} ${esc(r.kendaraan)}">
              <button type="button" class="btn btn-outline-secondary" data-aksi="lihat" data-id="${r.id}">Lihat</button>
              <button type="button" class="btn btn-outline-secondary" data-aksi="edit" data-id="${r.id}">Edit</button>
              <button type="button" class="btn btn-outline-danger" data-aksi="hapus" data-id="${r.id}">Hapus</button>
            </div>
          </td>
        </tr>`).join('');
      $('kosong').classList.toggle('d-none', rows.length > 0);
    }

    $('tbody').addEventListener('click', e => {
      const btn = e.target.closest('button[data-aksi]'); if (!btn) return;
      const id = Number(btn.dataset.id);
      ({ lihat: bukaDetail, edit: bukaForm, hapus: bukaHapus })[btn.dataset.aksi](id);
    });
    $('formFilter').addEventListener('submit', e => { e.preventDefault(); render(); });
    $('btnResetFilter').addEventListener('click', () => { $('formFilter').reset(); $('fSelesai').classList.remove('is-invalid'); render(); });

    /* ---------- Detail ---------- */
    function bukaDetail(id) {
      const r = data.find(x => x.id === id); if (!r) return;
      detailId = id;
      const f = (label, val, full) => `<div class="col-12 ${full ? '' : 'col-md-6'}"><dt class="small fw-normal text-body-secondary">${label}</dt><dd class="detail-field mb-0">${val}</dd></div>`;
      $('detailBody').innerHTML =
        f('Tanggal', fmtTgl(r.tanggal)) + f('Kendaraan', esc(r.kendaraan)) +
        f('Jenis Servis', esc(r.jenis)) + f('Bengkel', esc(r.bengkel) || '-') +
        f('Kilometer', fmtNum(r.km)) + f('Biaya', fmtRp(r.biaya)) +
        f('Catatan', esc(r.catatan) || '-', true);
      mFormDetail.show();
    }
    $('btnDetailEdit').addEventListener('click', () => {
      const id = detailId;
      $('modalDetail').addEventListener('hidden.bs.modal', () => bukaForm(id), { once: true });
      mFormDetail.hide();
    });

    /* ---------- Tambah / Edit ---------- */
    const FIELDS = ['Tanggal', 'Kendaraan', 'Jenis', 'Km', 'Biaya'];
    function bersihkanError() {
      FIELDS.forEach(f => $('i' + f).classList.remove('is-invalid'));
    }
    function bukaForm(id) {
      bersihkanError();
      $('formServis').reset();
      editId = id ?? null;
      const r = editId ? data.find(x => x.id === editId) : null;
      $('judulForm').textContent = r ? 'Edit Riwayat Servis' : 'Tambah Riwayat Servis';
      $('btnSimpan').textContent = r ? 'Simpan Perubahan' : 'Simpan';
      if (r) {
        $('iTanggal').value = r.tanggal; $('iKendaraan').value = r.kendaraan; $('iJenis').value = r.jenis;
        $('iBengkel').value = r.bengkel; $('iKm').value = r.km; $('iBiaya').value = r.biaya; $('iCatatan').value = r.catatan;
      }
      mForm.show();
    }
    $('btnTambah').addEventListener('click', () => bukaForm(null));
    $('modalForm').addEventListener('shown.bs.modal', () => $('iTanggal').focus());

    function validasi() {
      const err = {};
      if (!$('iTanggal').value) err.Tanggal = 'Tanggal wajib diisi';
      if (!$('iKendaraan').value) err.Kendaraan = 'Kendaraan wajib dipilih';
      if (!$('iJenis').value) err.Jenis = 'Jenis servis wajib dipilih';
      const km = $('iKm').value, biaya = $('iBiaya').value;
      if (km === '') err.Km = 'Kilometer wajib diisi';
      else if (Number(km) < 0) err.Km = 'Kilometer tidak boleh negatif';
      else if (!Number.isInteger(Number(km))) err.Km = 'Kilometer harus bilangan bulat';
      if (biaya === '') err.Biaya = 'Biaya wajib diisi';
      else if (Number(biaya) < 0) err.Biaya = 'Biaya harus >= 0';
      FIELDS.forEach(f => {
        $('i' + f).classList.toggle('is-invalid', !!err[f]);
        if (err[f]) $('e' + f).textContent = err[f];
      });
      return err;
    }

    $('formServis').addEventListener('submit', e => {
      e.preventDefault();
      const err = validasi();
      const pertama = FIELDS.find(f => err[f]);
      if (pertama) { $('i' + pertama).focus(); return; }
      const rec = {
        tanggal: $('iTanggal').value, kendaraan: $('iKendaraan').value, jenis: $('iJenis').value,
        bengkel: $('iBengkel').value.trim(), km: Number($('iKm').value), biaya: Number($('iBiaya').value),
        catatan: $('iCatatan').value.trim()
      };
      if (editId) { Object.assign(data.find(x => x.id === editId), rec); notif('Riwayat servis berhasil diubah.'); }
      else { data.push({ id: nextId++, ...rec }); notif('Riwayat servis berhasil ditambahkan.'); }
      mForm.hide(); render();
    });

    /* ---------- Hapus ---------- */
    function bukaHapus(id) {
      const r = data.find(x => x.id === id); if (!r) return;
      hapusId = id;
      $('hapusRingkas').textContent = `${r.jenis} — ${r.kendaraan} — ${fmtTgl(r.tanggal)}`;
      mHapus.show();
    }
    $('btnKonfirmasiHapus').addEventListener('click', () => {
      const n = data.length;
      data = data.filter(x => x.id !== hapusId);
      mHapus.hide(); render();
      notif(data.length < n ? 'Riwayat servis berhasil dihapus.' : 'Gagal menghapus riwayat servis.', data.length < n);
    });

    isiSelect('fKendaraan', KENDARAAN); isiSelect('iKendaraan', KENDARAAN);
    isiSelect('fJenis', JENIS); isiSelect('iJenis', JENIS);
    render();
  </script>
</body>
</html>