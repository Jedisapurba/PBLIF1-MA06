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
