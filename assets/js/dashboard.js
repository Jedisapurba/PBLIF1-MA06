const dataServis = [
  { tanggal: "2024-05-20", kendaraan: "Honda Beat", jenis: "Ganti Oli", biaya: 65000 },
  { tanggal: "2024-06-10", kendaraan: "Toyota Avanza", jenis: "Servis Berkala", biaya: 1250000 }
];

const BULAN = ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"];
const grafikBiaya = document.getElementById("grafikBiaya");

if (grafikBiaya) {
  const biayaBulanan = Array(12).fill(0);
  dataServis.forEach(servis => {
    const bulan = new Date(`${servis.tanggal}T00:00:00`).getMonth();
    biayaBulanan[bulan] += servis.biaya;
  });
  const biayaMaksimum = Math.max(...biayaBulanan, 1);
  const rupiah = biaya => "Rp " + biaya.toLocaleString("id-ID");

  grafikBiaya.innerHTML = biayaBulanan.map((biaya, index) => `
    <div class="chart-column">
      <div class="chart-bar-area">
        <div class="chart-bar" title="${BULAN[index]}: ${rupiah(biaya)}"></div>
      </div>
      <span class="chart-month">${BULAN[index]}</span>
    </div>`).join("");

  grafikBiaya.querySelectorAll(".chart-bar").forEach((bar, index) => {
    bar.style.height = `${(biayaBulanan[index] / biayaMaksimum) * 100}%`;
  });
  document.getElementById("grafikBiayaDeskripsi").textContent = BULAN
    .map((bulan, index) => `${bulan}: ${rupiah(biayaBulanan[index])}`)
    .join("; ");
}
