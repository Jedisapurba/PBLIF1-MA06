let data = [];
let kendaraan = [];
let jenisServis = [];
let editId = null;
let hapusId = null;
let detailId = null;

const $ = id => document.getElementById(id);
const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
const apiBase = '../db/';
const esc = value => String(value ?? '').replace(/[&<>"']/g, character => ({
  '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;'
}[character]));
const fmtRp = value => 'Rp ' + new Intl.NumberFormat('id-ID', { maximumFractionDigits: 2 }).format(value);
const fmtNum = value => new Intl.NumberFormat('id-ID', { maximumFractionDigits: 2 }).format(value);
const fmtTgl = value => {
  const [year, month, day] = value.split('-');
  return `${day}/${month}/${year}`;
};

const modalDetail = new UiModal($('modalDetail'));
const modalForm = new UiModal($('modalForm'));
const modalHapus = new UiModal($('modalHapus'));
const toast = new UiToast($('toast'), { delay: 3500 });
const fields = ['Tanggal', 'Kendaraan', 'Jenis', 'Km', 'Biaya'];

function notif(pesan, sukses = true) {
  $('toast').className = 'toast align-items-center border-0 text-bg-' + (sukses ? 'success' : 'danger');
  $('toastIsi').textContent = pesan;
  toast.show();
}

async function apiRequest(file, method = 'GET', values = null) {
  const headers = { Accept: 'application/json' };
  const options = { method, headers, credentials: 'same-origin' };

  if (method === 'POST') {
    headers['X-CSRF-Token'] = csrfToken;
    options.body = new URLSearchParams(values || {});
  }

  const response = await fetch(apiBase + file, options);
  const contentType = response.headers.get('content-type') || '';
  if (!contentType.includes('application/json')) {
    throw new Error('Respons server tidak valid. Muat ulang halaman dan coba lagi.');
  }

  let result;
  try {
    result = await response.json();
  } catch (error) {
    throw new Error('Respons server tidak dapat dibaca. Coba lagi.');
  }

  if (!response.ok) {
    throw new Error(result.message || 'Permintaan tidak dapat diproses.');
  }

  return result;
}

function isiSelect(id, placeholder, items, labelFor) {
  const select = $(id);
  const selected = select.value;
  select.replaceChildren(new Option(placeholder, ''));

  items.forEach(item => {
    select.add(new Option(labelFor(item), String(item.id)));
  });

  if (Array.from(select.options).some(option => option.value === selected)) {
    select.value = selected;
  }
}

function render() {
  const mulai = $('fMulai').value;
  const selesai = $('fSelesai').value;
  const tanggalTidakValid = mulai && selesai && selesai < mulai;
  $('fSelesai').classList.toggle('is-invalid', Boolean(tanggalTidakValid));

  if (tanggalTidakValid) {
    $('fSelesai').focus();
    return;
  }

  const kendaraanId = $('fKendaraan').value;
  const jenisId = $('fJenis').value;
  const bengkelQuery = $('fBengkel').value.trim().toLocaleLowerCase('id');
  const rows = data
    .filter(item =>
      (!kendaraanId || String(item.kendaraanId) === kendaraanId)
      && (!jenisId || String(item.jenisId) === jenisId)
      && (!bengkelQuery || item.bengkel.toLocaleLowerCase('id').includes(bengkelQuery))
      && (!mulai || item.tanggal >= mulai)
      && (!selesai || item.tanggal <= selesai)
    )
    .sort((left, right) => right.tanggal.localeCompare(left.tanggal) || right.id - left.id);

  $('tbody').innerHTML = rows.map(item => `
    <tr>
      <td class="num">${fmtTgl(item.tanggal)}</td>
      <td>${esc(item.kendaraan)} (${esc(item.polisi)})</td>
      <td>${esc(item.jenis)}</td>
      <td>${esc(item.bengkel) || '-'}</td>
      <td class="num">${fmtNum(item.km)}</td>
      <td class="num">${fmtRp(item.biaya)}</td>
      <td>${esc(item.catatan) || '-'}</td>
      <td class="aksi">
        <div class="btn-group btn-group-sm" role="group" aria-label="Aksi untuk ${esc(item.jenis)} ${esc(item.kendaraan)}">
          <button type="button" class="btn btn-outline-secondary" data-aksi="lihat" data-id="${item.id}">Lihat</button>
          <button type="button" class="btn btn-outline-secondary" data-aksi="edit" data-id="${item.id}">Edit</button>
          <button type="button" class="btn btn-outline-danger" data-aksi="hapus" data-id="${item.id}">Hapus</button>
        </div>
      </td>
    </tr>`).join('');
  $('kosong').textContent = 'Data tidak ditemukan.';
  $('kosong').classList.toggle('d-none', rows.length > 0);
}

async function muatData() {
  const [riwayatResponse, kendaraanResponse, jenisResponse] = await Promise.all([
    apiRequest('ambil_servis.php'),
    apiRequest('ambil_kendaraan.php'),
    apiRequest('ambil_jenis_servis.php')
  ]);

  if (
    !Array.isArray(riwayatResponse.data)
    || !Array.isArray(kendaraanResponse.data)
    || !Array.isArray(jenisResponse.data)
  ) {
    throw new Error('Data servis kendaraan atau pilihan servis dari server tidak valid.');
  }

  data = riwayatResponse.data;
  kendaraan = kendaraanResponse.data;
  jenisServis = jenisResponse.data;
  isiSelect('fKendaraan', 'Semua kendaraan', kendaraan, item => `${item.nama} (${item.polisi})`);
  isiSelect('iKendaraan', 'Pilih kendaraan', kendaraan, item => `${item.nama} (${item.polisi})`);
  isiSelect('fJenis', 'Semua jenis servis', jenisServis, item => item.nama);
  isiSelect('iJenis', 'Pilih jenis servis', jenisServis, item => item.nama);
  render();
}

function tampilkanGagalMuat(error) {
  $('tbody').innerHTML = '';
  $('kosong').textContent = 'Gagal memuat data servis kendaraan: ' + error.message;
  $('kosong').classList.remove('d-none');
  $('btnTambah').disabled = true;
  notif($('kosong').textContent, false);
}

function bersihkanError() {
  fields.forEach(field => {
    $('i' + field).classList.remove('is-invalid');
    $('e' + field).textContent = '';
  });
}

function validasi() {
  const errors = {};
  const kilometer = $('iKm').value;
  const biaya = $('iBiaya').value;

  if (!$('iTanggal').value) errors.Tanggal = 'Tanggal wajib diisi.';
  if (!$('iKendaraan').value) errors.Kendaraan = 'Kendaraan wajib dipilih.';
  if (!$('iJenis').value) errors.Jenis = 'Jenis servis wajib dipilih.';

  if (kilometer === '') errors.Km = 'Kilometer wajib diisi.';
  else if (!Number.isInteger(Number(kilometer)) || Number(kilometer) < 0 || Number(kilometer) > 2147483647) {
    errors.Km = 'Kilometer harus bilangan bulat antara 0 dan 2147483647.';
  }

  if (biaya === '') errors.Biaya = 'Biaya wajib diisi.';
  else if (!Number.isInteger(Number(biaya)) || Number(biaya) < 0 || Number(biaya) > 9999999999) {
    errors.Biaya = 'Biaya harus bilangan bulat yang valid.';
  }

  fields.forEach(field => {
    $('i' + field).classList.toggle('is-invalid', Boolean(errors[field]));
    $('e' + field).textContent = errors[field] || '';
  });
  return errors;
}

function bukaDetail(id) {
  const item = data.find(row => row.id === id);
  if (!item) return;

  detailId = id;
  const field = (label, value, full = false) => `
    <div class="col-12 ${full ? '' : 'col-md-6'}">
      <dt class="small fw-normal text-body-secondary">${label}</dt>
      <dd class="detail-field mb-0">${value}</dd>
    </div>`;
  $('detailBody').innerHTML =
    field('Tanggal', fmtTgl(item.tanggal))
    + field('Kendaraan', `${esc(item.kendaraan)} (${esc(item.polisi)})`)
    + field('Jenis Servis', esc(item.jenis))
    + field('Bengkel', esc(item.bengkel) || '-')
    + field('Kilometer', fmtNum(item.km))
    + field('Biaya', fmtRp(item.biaya))
    + field('Catatan', esc(item.catatan) || '-', true);
  modalDetail.show();
}

function bukaForm(id = null) {
  bersihkanError();
  $('formServis').reset();
  editId = id;
  const item = editId ? data.find(row => row.id === editId) : null;
  $('judulForm').textContent = item ? 'Edit Servis Kendaraan' : 'Tambah Servis Kendaraan';
  $('btnSimpan').textContent = item ? 'Simpan Perubahan' : 'Simpan';

  if (item) {
    $('iTanggal').value = item.tanggal;
    $('iKendaraan').value = String(item.kendaraanId);
    $('iJenis').value = String(item.jenisId);
    $('iBengkel').value = item.bengkel;
    $('iKm').value = item.km;
    $('iBiaya').value = item.biaya;
    $('iCatatan').value = item.catatan;
  }

  modalForm.show();
}

function bukaHapus(id) {
  const item = data.find(row => row.id === id);
  if (!item) return;

  hapusId = id;
  $('hapusRingkas').textContent = `${item.jenis} — ${item.kendaraan} — ${fmtTgl(item.tanggal)}`;
  modalHapus.show();
}

$('tbody').addEventListener('click', event => {
  const button = event.target.closest('button[data-aksi]');
  if (!button) return;

  const id = Number(button.dataset.id);
  const actions = { lihat: bukaDetail, edit: bukaForm, hapus: bukaHapus };
  actions[button.dataset.aksi]?.(id);
});

$('formFilter').addEventListener('submit', event => {
  event.preventDefault();
  render();
});
$('btnResetFilter').addEventListener('click', () => {
  $('formFilter').reset();
  $('fSelesai').classList.remove('is-invalid');
  render();
});
$('btnTambah').addEventListener('click', () => bukaForm());
$('modalForm').addEventListener('ui:shown', () => $('iTanggal').focus());

$('btnDetailEdit').addEventListener('click', () => {
  const id = detailId;
  $('modalDetail').addEventListener('ui:hidden', () => bukaForm(id), { once: true });
  modalDetail.hide();
});

$('formServis').addEventListener('submit', async event => {
  event.preventDefault();
  bersihkanError();
  const errors = validasi();
  const firstInvalidField = fields.find(field => errors[field]);
  if (firstInvalidField) {
    $('i' + firstInvalidField).focus();
    return;
  }

  const button = $('btnSimpan');
  const values = {
    tanggal: $('iTanggal').value,
    kendaraanId: $('iKendaraan').value,
    jenisId: $('iJenis').value,
    bengkel: $('iBengkel').value.trim(),
    km: $('iKm').value,
    biaya: $('iBiaya').value,
    catatan: $('iCatatan').value.trim()
  };
  const endpoint = editId ? 'ubah_servis.php' : 'tambah_servis.php';
  if (editId) values.id = String(editId);
  button.disabled = true;

  try {
    const result = await apiRequest(endpoint, 'POST', values);
    modalForm.hide();
    notif(result.message);

    try {
      await muatData();
    } catch (error) {
      notif(result.message + ' Namun daftar servis kendaraan gagal diperbarui: ' + error.message, false);
    }
  } catch (error) {
    notif(error.message, false);
  } finally {
    button.disabled = false;
  }
});

$('btnKonfirmasiHapus').addEventListener('click', async () => {
  const button = $('btnKonfirmasiHapus');
  button.disabled = true;

  try {
    const result = await apiRequest('hapus_servis.php', 'POST', { id: String(hapusId) });
    hapusId = null;
    modalHapus.hide();
    notif(result.message);

    try {
      await muatData();
    } catch (error) {
      notif(result.message + ' Namun daftar servis kendaraan gagal diperbarui: ' + error.message, false);
    }
  } catch (error) {
    notif(error.message, false);
  } finally {
    button.disabled = false;
  }
});

$('kosong').textContent = 'Memuat data servis kendaraan...';
$('kosong').classList.remove('d-none');
$('btnTambah').disabled = true;
muatData()
  .then(() => { $('btnTambah').disabled = false; })
  .catch(tampilkanGagalMuat);
