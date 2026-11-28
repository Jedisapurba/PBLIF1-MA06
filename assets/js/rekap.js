/* ===== DATA CONTOH (ganti dengan hasil fetch dari backend/PHP) =====
       Bentuk yang diharapkan dari endpoint, mis. GET /api/servis:
       [{tanggal:'2024-06-12', kendaraan:'Honda Beat', jenis:'Ganti Oli', biaya:65000}, ...] */
const DATA = [
  { tanggal: '2024-06-12', kendaraan: 'Honda Beat', jenis: 'Ganti Oli', biaya: 65000 },
  { tanggal: '2024-05-01', kendaraan: 'Toyota Avanza', jenis: 'Servis Berkala', biaya: 1250000 }
];

const $ = id => document.getElementById(id);
const rupiah = value => 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
const bulan = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
const esc = value => String(value).replace(/[&<>"']/g, character => ({
  '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;'
}[character]));

function labelPeriode(awalISO, akhirISO) {
  const awal = new Date(awalISO + 'T00:00:00');
  const akhir = new Date(akhirISO + 'T00:00:00');
  const bulanSama = awal.getMonth() === akhir.getMonth() && awal.getFullYear() === akhir.getFullYear();

  if (bulanSama) return `${bulan[awal.getMonth()]} ${awal.getFullYear()}`;
  if (awal.getFullYear() === akhir.getFullYear()) {
    return `${bulan[awal.getMonth()]}-${bulan[akhir.getMonth()]} ${awal.getFullYear()}`;
  }
  return `${bulan[awal.getMonth()]} ${awal.getFullYear()} - ${bulan[akhir.getMonth()]} ${akhir.getFullYear()}`;
}

function groupBy(rows, key) {
  const groups = new Map();
  rows.forEach(row => {
    const group = groups.get(row[key]) || { nama: row[key], jumlah: 0, total: 0 };
    group.jumlah++;
    group.total += row.biaya;
    groups.set(row[key], group);
  });
  return Array.from(groups.values()).sort((left, right) => left.nama.localeCompare(right.nama, 'id'));
}

function isiDropdown() {
  [['filterKendaraan', 'kendaraan'], ['filterJenis', 'jenis']].forEach(([id, key]) => {
    [...new Set(DATA.map(item => item[key]))].sort().forEach(value => {
      const option = document.createElement('option');
      option.value = option.textContent = value;
      $(id).appendChild(option);
    });
  });
}

function render() {
  const mulai = $('periodeMulai').value;
  const selesai = $('periodeSelesai').value;
  const kendaraan = $('filterKendaraan').value;
  const jenis = $('filterJenis').value;
  const periodeSalah = mulai && selesai && selesai < mulai;
  $('periodeSelesai').classList.toggle('is-invalid', Boolean(periodeSalah));
  if (periodeSalah) {
    $('periodeSelesai').focus();
    return;
  }

  const rows = DATA.filter(item =>
    (!mulai || item.tanggal >= mulai)
    && (!selesai || item.tanggal <= selesai)
    && (!kendaraan || item.kendaraan === kendaraan)
    && (!jenis || item.jenis === jenis)
  );
  const total = rows.reduce((sum, item) => sum + item.biaya, 0);
  $('statTotal').textContent = rupiah(total);
  $('statJumlah').textContent = rows.length + ' kali';
  $('kosong').classList.toggle('d-none', rows.length > 0);
  $('areaTabel').classList.toggle('d-none', rows.length === 0);
  if (!rows.length) return;

  const tanggalUrut = rows.map(item => item.tanggal).sort();
  const periode = labelPeriode(mulai || tanggalUrut[0], selesai || tanggalUrut[tanggalUrut.length - 1]);
  $('bodyKendaraan').innerHTML = groupBy(rows, 'kendaraan').map(group =>
    `<tr><td>${periode}</td><td>${esc(group.nama)}</td><td class="num">${group.jumlah}</td><td class="num">${rupiah(group.total)}</td></tr>`
  ).join('');
  $('footKendaraan').innerHTML =
    `<tr><td colspan="2">Total</td><td class="num">${rows.length}</td><td class="num">${rupiah(total)}</td></tr>`;

  $('bodyJenis').innerHTML = groupBy(rows, 'jenis').map(group =>
    `<tr><td>${esc(group.nama)}</td><td class="num">${group.jumlah}</td><td class="num">${rupiah(group.total)}</td></tr>`
  ).join('');
  $('footJenis').innerHTML =
    `<tr><td>Total</td><td class="num">${rows.length}</td><td class="num">${rupiah(total)}</td></tr>`;
}

$('formFilter').addEventListener('submit', event => {
  event.preventDefault();
  render();
});
$('btnReset').addEventListener('click', () => {
  $('formFilter').reset();
  $('periodeSelesai').classList.remove('is-invalid');
  render();
});

isiDropdown();
render();
