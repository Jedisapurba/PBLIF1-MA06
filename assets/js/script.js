// ===== DATA CONTOH (ganti dengan data dari database/API Anda) =====
const dataServis = [
  { tanggal: "2024-05-20", kendaraan: "Honda Beat",    jenis: "Ganti Oli",      biaya: 65000 },
  { tanggal: "2024-06-10", kendaraan: "Toyota Avanza", jenis: "Servis Berkala", biaya: 1250000 },
];

const BULAN = ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"];

// ===== ELEMEN =====
const el = (id) => document.getElementById(id);
const inputMulai = el("mulai");
const inputSelesai = el("selesai");
const selKendaraan = el("kendaraan");
const selJenis = el("jenis");

// ===== HELPER =====
const rupiah = (n) => "Rp " + n.toLocaleString("id-ID");

// "dd/mm/yyyy" -> Date (null jika kosong/tidak valid)
function parseTanggal(str) {
  const m = /^(\d{2})\/(\d{2})\/(\d{4})$/.exec(str.trim());
  if (!m) return null;
  return new Date(+m[3], +m[2] - 1, +m[1]);
}

function labelPeriode(rows) {
  if (!rows.length) return "-";
  const tgl = rows.map((r) => new Date(r.tanggal)).sort((a, b) => a - b);
  const awal = tgl[0];
  const akhir = tgl[tgl.length - 1];
  const thn = akhir.getFullYear();
  if (awal.getFullYear() !== thn) {
    return `${BULAN[awal.getMonth()]} ${awal.getFullYear()}-${BULAN[akhir.getMonth()]} ${thn}`;
  }
  return awal.getMonth() === akhir.getMonth()
    ? `${BULAN[akhir.getMonth()]} ${thn}`
    : `${BULAN[awal.getMonth()]}-${BULAN[akhir.getMonth()]} ${thn}`;
}

// Kelompokkan data berdasarkan field tertentu
function groupBy(rows, key) {
  const map = new Map();
  rows.forEach((r) => {
    const g = map.get(r[key]) || { nama: r[key], jumlah: 0, total: 0 };
    g.jumlah += 1;
    g.total += r.biaya;
    map.set(r[key], g);
  });
  return [...map.values()];
}

// ===== ISI DROPDOWN =====
function isiDropdown() {
  [...new Set(dataServis.map((d) => d.kendaraan))].forEach((v) =>
    selKendaraan.add(new Option(v, v))
  );
  [...new Set(dataServis.map((d) => d.jenis))].forEach((v) =>
    selJenis.add(new Option(v, v))
  );
}

// ===== FILTER =====
function ambilDataTerfilter() {
  const mulai = parseTanggal(inputMulai.value);
  const selesai = parseTanggal(inputSelesai.value);

  return dataServis.filter((d) => {
    const tgl = new Date(d.tanggal);
    if (mulai && tgl < mulai) return false;
    if (selesai && tgl > selesai) return false;
    if (selKendaraan.value && d.kendaraan !== selKendaraan.value) return false;
    if (selJenis.value && d.jenis !== selJenis.value) return false;
    return true;
  });
}

// ===== RENDER =====
function render() {
  const rows = ambilDataTerfilter();
  const totalBiaya = rows.reduce((s, r) => s + r.biaya, 0);
  const periode = labelPeriode(rows);

  // Kartu ringkasan
  el("totalBiaya").textContent = rupiah(totalBiaya);
  el("jumlahServis").textContent = rows.length + " kali";

  // Tabel per kendaraan
  const perKendaraan = groupBy(rows, "kendaraan");
  el("tbodyKendaraan").innerHTML = perKendaraan.length
    ? perKendaraan.map((g) => `
        <tr>
          <td>${periode}</td>
          <td>${g.nama}</td>
          <td>${g.jumlah}</td>
          <td>${rupiah(g.total)}</td>
        </tr>`).join("")
    : `<tr><td colspan="4">Tidak ada data</td></tr>`;
  el("footJmlKendaraan").textContent = rows.length;
  el("footBiayaKendaraan").textContent = rupiah(totalBiaya);

  // Tabel per jenis servis
  const perJenis = groupBy(rows, "jenis");
  el("tbodyJenis").innerHTML = perJenis.length
    ? perJenis.map((g) => `
        <tr>
          <td>${g.nama}</td>
          <td>${g.jumlah}</td>
          <td>${rupiah(g.total)}</td>
        </tr>`).join("")
    : `<tr><td colspan="3">Tidak ada data</td></tr>`;
  el("footJmlJenis").textContent = rows.length;
  el("footBiayaJenis").textContent = rupiah(totalBiaya);
}

// ===== INISIALISASI =====
isiDropdown();
render();
el("btnTampilkan").addEventListener("click", render);