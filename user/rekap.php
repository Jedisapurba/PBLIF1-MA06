<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Laporan Biaya Servis | Servis Kendaraan Pribadi</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/css/style.css" rel="stylesheet">
  <style>
    :root { --sidebar-w: 240px; }
    body { font-size: 1rem; }
    .topbar { background: var(--sv-surface); border-bottom: 1px solid var(--sv-border); }
    /* !important diperlukan: .offcanvas-lg Bootstrap memaksa background transparan di layar lg ke atas */
    .sidebar { width: var(--sidebar-w); background-color: var(--sv-sidebar) !important; }
    .sidebar .nav-link { color: var(--sv-sidebar-text); }
    .sidebar .nav-link.active { color: #fff; }
    .page-layout { min-height: calc(100vh - 64px); }
    .table-report td:first-child { white-space: nowrap; }
    @media (min-width: 992px) {
      .sidebar { position: sticky; top: 64px; height: calc(100vh - 64px); flex: 0 0 var(--sidebar-w); }
    }
    .sidebar .nav-heading { font-size: .75rem; letter-spacing: .06em; text-transform: uppercase; color: #9FB0C8; padding: .75rem 1rem .25rem; }
    .sidebar .nav-link { padding: .6rem 1rem; min-height: 44px; display: flex; align-items: center; }
    .sidebar .nav-link.sub { padding-left: 1.75rem; }
    .page-content { max-width: 1200px; }
    .stat-label { color: var(--sv-muted); font-size: .875rem; }
    .stat-value { font-size: 1.75rem; font-weight: 700; line-height: 1.2; }
    .table-report { font-size: .9375rem; }
    .table-report th, .table-report td { padding: .65rem .75rem; }
    .table-report { table-layout: fixed; min-width: 460px; }
    /* Angka rata kiri sesuai wireframe. Untuk rata kanan (lebih mudah dibandingkan), ganti ke: text-align: right */
    .table-report .num { text-align: left; font-variant-numeric: tabular-nums; white-space: nowrap; }
    .table-report tfoot td { font-weight: 700; background: var(--sv-primary-tint); border-top: 2px solid var(--sv-primary); }
    .brand-logo { width: 36px; height: 36px; border-radius: 8px; background: var(--sv-primary); color: #fff; display: grid; place-items: center; font-weight: 700; }
    .skip-link { position: absolute; left: -999px; }
    .skip-link:focus { left: 8px; top: 8px; z-index: 2000; background: #fff; padding: .5rem 1rem; }
  </style>
</head>
<body>
  <a class="skip-link" href="#konten">Lewati ke konten</a>

  <!-- TOPBAR -->
  <header class="topbar sticky-top" style="height:64px">
    <div class="d-flex align-items-center gap-3 h-100 px-3">
      <button class="btn btn-outline-secondary d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar" aria-controls="sidebar" aria-label="Buka menu">
        <span aria-hidden="true">&#9776;</span>
      </button>
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
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" data-bs-target="#sidebar" aria-label="Tutup"></button>
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
                <table class="table table-report table-hover align-middle mb-0">
                  <colgroup><col style="width:27%"><col style="width:29%"><col style="width:20%"><col style="width:24%"></colgroup>
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
                <table class="table table-report table-hover align-middle mb-0">
                  <colgroup><col style="width:38%"><col style="width:23%"><col style="width:39%"></colgroup>
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

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    /* ===== DATA CONTOH (ganti dengan hasil fetch dari backend/PHP) =====
       Bentuk yang diharapkan dari endpoint, mis. GET /api/servis:
       [{tanggal:'2024-06-12', kendaraan:'Honda Beat', jenis:'Ganti Oli', biaya:65000}, ...] */
    const DATA = [
      { tanggal: '2024-06-12', kendaraan: 'Honda Beat',    jenis: 'Ganti Oli',     biaya: 65000 },
      { tanggal: '2024-05-01', kendaraan: 'Toyota Avanza', jenis: 'Servis Berkala', biaya: 1250000 }
    ];

    const $ = id => document.getElementById(id);
    const rupiah = n => 'Rp ' + new Intl.NumberFormat('id-ID').format(n);
    const bulan = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
    const esc = s => String(s).replace(/[&<>"']/g, c => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]));

    // Label periode laporan, mis. "Mei-Jun 2024" (sama di semua baris, sesuai wireframe).
    // Awal/akhir diambil dari filter tanggal; kalau kosong, dari tanggal data terawal/terakhir.
    function labelPeriode(awalISO, akhirISO) {
      const a = new Date(awalISO + 'T00:00:00'), b = new Date(akhirISO + 'T00:00:00');
      const sameMonth = a.getMonth() === b.getMonth() && a.getFullYear() === b.getFullYear();
      if (sameMonth) return `${bulan[a.getMonth()]} ${a.getFullYear()}`;
      if (a.getFullYear() === b.getFullYear()) return `${bulan[a.getMonth()]}-${bulan[b.getMonth()]} ${a.getFullYear()}`;
      return `${bulan[a.getMonth()]} ${a.getFullYear()} - ${bulan[b.getMonth()]} ${b.getFullYear()}`;
    }

    function groupBy(rows, key) {
      const map = new Map();
      rows.forEach(r => {
        const g = map.get(r[key]) || { nama: r[key], jml: 0, total: 0, tgl: [] };
        g.jml++; g.total += r.biaya; g.tgl.push(r.tanggal);
        map.set(r[key], g);
      });
      return [...map.values()].sort((a, b) => a.nama.localeCompare(b.nama, 'id'));
    }

    function isiDropdown() {
      [['filterKendaraan', 'kendaraan'], ['filterJenis', 'jenis']].forEach(([id, key]) => {
        [...new Set(DATA.map(d => d[key]))].sort().forEach(v => {
          const o = document.createElement('option'); o.value = o.textContent = v; $(id).appendChild(o);
        });
      });
    }

    function render() {
      const mulai = $('periodeMulai').value, selesai = $('periodeSelesai').value;
      const kend = $('filterKendaraan').value, jenis = $('filterJenis').value;

      // Validasi rentang tanggal
      const salah = mulai && selesai && selesai < mulai;
      $('periodeSelesai').classList.toggle('is-invalid', salah);
      if (salah) { $('periodeSelesai').focus(); return; }

      const rows = DATA.filter(d =>
        (!mulai || d.tanggal >= mulai) && (!selesai || d.tanggal <= selesai) &&
        (!kend || d.kendaraan === kend) && (!jenis || d.jenis === jenis));

      const total = rows.reduce((s, r) => s + r.biaya, 0);
      $('statTotal').textContent = rupiah(total);
      $('statJumlah').textContent = rows.length + ' kali';
      $('kosong').classList.toggle('d-none', rows.length > 0);
      $('areaTabel').classList.toggle('d-none', rows.length === 0);
      if (!rows.length) return;

      const tglUrut = rows.map(r => r.tanggal).sort();
      const periode = labelPeriode(mulai || tglUrut[0], selesai || tglUrut[tglUrut.length - 1]);

      $('bodyKendaraan').innerHTML = groupBy(rows, 'kendaraan').map(g =>
        `<tr><td>${periode}</td><td>${esc(g.nama)}</td><td class="num">${g.jml}</td><td class="num">${rupiah(g.total)}</td></tr>`).join('');
      $('footKendaraan').innerHTML = `<tr><td colspan="2">Total</td><td class="num">${rows.length}</td><td class="num">${rupiah(total)}</td></tr>`;

      $('bodyJenis').innerHTML = groupBy(rows, 'jenis').map(g =>
        `<tr><td>${esc(g.nama)}</td><td class="num">${g.jml}</td><td class="num">${rupiah(g.total)}</td></tr>`).join('');
      $('footJenis').innerHTML = `<tr><td>Total</td><td class="num">${rows.length}</td><td class="num">${rupiah(total)}</td></tr>`;
    }

    $('formFilter').addEventListener('submit', e => { e.preventDefault(); render(); });
    $('btnReset').addEventListener('click', () => { $('formFilter').reset(); $('periodeSelesai').classList.remove('is-invalid'); render(); });
    isiDropdown(); render();
  </script>
</body>
</html>