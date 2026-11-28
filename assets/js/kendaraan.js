let kendaraan = [];

const $ = id => document.getElementById(id);
const esc = value => String(value).replace(/[&<>"']/g, character => ({
  '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;'
}[character]));
const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
const apiBase = '../db/';
const modalForm = UiModal.getOrCreateInstance($('modalKendaraan'));
const modalDetail = UiModal.getOrCreateInstance($('modalDetail'));
const modalHapus = UiModal.getOrCreateInstance($('modalHapus'));
const toast = new UiToast($('toast'), { delay: 3500 });
let hapusId = null;
let focusTarget = $('btnTambah');
$('tahunKendaraan').max = '2050';

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
          <td>${esc(item.tahun)}</td>
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

async function muatKendaraan() {
  const result = await apiRequest('ambil_kendaraan.php');
  if (!Array.isArray(result.data)) {
    throw new Error('Data kendaraan dari server tidak valid.');
  }

  kendaraan = result.data;
  renderKendaraan();
}

function tampilkanGagalMuat(error) {
  const pesan = 'Gagal memuat data kendaraan: ' + error.message;
  $('bodyKendaraan').innerHTML = `<tr><td class="text-center text-body-secondary py-4" colspan="6">${esc(pesan)}</td></tr>`;
  $('statusKendaraan').textContent = pesan;
  notif(pesan, false);
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
  modalForm.show();
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
    focusTarget = $('btnTambah');
    $('hapusRingkas').textContent = `${item.nama} — ${item.polisi}`;
    modalHapus.show();
  }
});

$('btnKonfirmasiHapus').addEventListener('click', async () => {
  const button = $('btnKonfirmasiHapus');
  button.disabled = true;

  try {
    const result = await apiRequest('hapus_kendaraan.php', 'POST', { id: String(hapusId) });
    kendaraan = kendaraan.filter(item => item.id !== hapusId);
    hapusId = null;
    modalHapus.hide();
    renderKendaraan();
    notif(result.message);
  } catch (error) {
    notif(error.message, false);
  } finally {
    button.disabled = false;
  }
});

$('formKendaraan').addEventListener('submit', async event => {
  event.preventDefault();
  const button = event.currentTarget.querySelector('[type="submit"]');
  const id = $('kendaraanId').value;
  const values = {
    nama: $('namaKendaraan').value.trim(),
    jenis: $('jenisKendaraan').value,
    polisi: $('nomorPolisi').value.trim().toLocaleUpperCase('id'),
    tahun: $('tahunKendaraan').value
  };
  const endpoint = id ? 'ubah_kendaraan.php' : 'tambah_kendaraan.php';
  if (id) values.id = id;
  button.disabled = true;

  try {
    const result = await apiRequest(endpoint, 'POST', values);
    focusTarget = $('btnTambah');
    modalForm.hide();
    notif(result.message);

    try {
      await muatKendaraan();
    } catch (error) {
      notif(result.message + ' Namun daftar kendaraan gagal diperbarui: ' + error.message, false);
    }
  } catch (error) {
    notif(error.message, false);
  } finally {
    button.disabled = false;
  }
});

$('modalKendaraan').addEventListener('ui:hide', () => {
  window.setTimeout(() => focusTarget.focus(), 0);
});
$('modalKendaraan').addEventListener('ui:hidden', () => {
  $('formKendaraan').reset();
  focusTarget.focus();
});
$('statusKendaraan').textContent = 'Memuat data kendaraan.';
$('bodyKendaraan').innerHTML = '<tr><td class="text-center text-body-secondary py-4" colspan="6">Memuat data kendaraan...</td></tr>';
muatKendaraan().catch(tampilkanGagalMuat);
