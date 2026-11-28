let jenisServis = [];

const $ = id => document.getElementById(id);
const esc = value => String(value ?? '').replace(/[&<>"']/g, character => ({
  '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;'
}[character]));
const formatAngka = value => new Intl.NumberFormat('id-ID').format(value);
const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
const apiBase = '../db/';
const modalForm = new UiModal($('modalJenis'));
const modalDetail = new UiModal($('modalDetail'));
const modalHapus = new UiModal($('modalHapus'));
const toast = new UiToast($('toast'), { delay: 3500 });
let hapusId = null;
let focusTarget = $('btnTambah');

function formatInterval(item) {
  const bagian = [];
  if (item.intervalKm) bagian.push(`${formatAngka(item.intervalKm)} km`);
  if (item.intervalBulan) bagian.push(`${formatAngka(item.intervalBulan)} bulan`);
  return bagian.length ? bagian.join(' / ') : '-';
}

function notif(pesan, sukses = true) {
  $('toast').className = 'toast align-items-center border-0 text-bg-' + (sukses ? 'success' : 'danger');
  $('toastIsi').textContent = pesan;
  toast.show();
}

function pulihkanFokus(modal) {
  modal.addEventListener('ui:hide', () => {
    const focused = modal.querySelector(':focus');
    if (focused) focused.blur();
  });
  modal.addEventListener('ui:hidden', () => focusTarget.focus());
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

function renderJenis() {
  const query = $('cariJenis').value.trim().toLocaleLowerCase('id');
  const rows = jenisServis.filter(item =>
    (!query || item.nama.toLocaleLowerCase('id').includes(query) || item.keterangan.toLocaleLowerCase('id').includes(query))
  );

  $('bodyJenis').innerHTML = rows.length
    ? rows.map((item, index) => `
        <tr>
          <td>${index + 1}</td>
          <td>${esc(item.nama)}</td>
          <td>${esc(formatInterval(item))}</td>
          <td>${esc(item.keterangan) || '-'}</td>
          <td>
            <div class="service-actions">
              <button class="btn btn-sm btn-outline-primary" type="button" data-action="lihat" data-id="${item.id}">Lihat</button>
              <button class="btn btn-sm btn-outline-secondary" type="button" data-action="edit" data-id="${item.id}">Edit</button>
              <button class="btn btn-sm btn-outline-danger" type="button" data-action="hapus" data-id="${item.id}">Hapus</button>
            </div>
          </td>
        </tr>`).join('')
    : '<tr><td class="text-center text-body-secondary py-4" colspan="5">Jenis servis tidak ditemukan.</td></tr>';
  $('statusJenis').textContent = rows.length
    ? `${rows.length} jenis servis ditampilkan.`
    : 'Jenis servis tidak ditemukan.';
}

async function muatJenis() {
  const result = await apiRequest('ambil_jenis_servis.php');
  if (!Array.isArray(result.data)) {
    throw new Error('Data jenis servis dari server tidak valid.');
  }

  jenisServis = result.data;
  renderJenis();
}

function tampilkanGagalMuat(error) {
  const pesan = 'Gagal memuat jenis servis: ' + error.message;
  $('bodyJenis').innerHTML = `<tr><td class="text-center text-body-secondary py-4" colspan="5">${esc(pesan)}</td></tr>`;
  $('statusJenis').textContent = pesan;
  notif(pesan, false);
}

function siapkanForm(item = null) {
  $('formJenis').reset();
  $('jenisId').value = item ? item.id : '';
  $('judulModalJenis').textContent = item ? 'Edit Jenis Servis' : 'Tambah Jenis Servis';
  $('intervalError').hidden = true;
  if (item) {
    $('namaJenis').value = item.nama;
    $('intervalKm').value = item.intervalKm ?? '';
    $('intervalBulan').value = item.intervalBulan ?? '';
    $('keterangan').value = item.keterangan;
  }
}

$('btnTambah').addEventListener('click', () => {
  focusTarget = $('btnTambah');
  siapkanForm();
  modalForm.show();
});
$('cariJenis').addEventListener('input', renderJenis);
['intervalKm', 'intervalBulan'].forEach(id => {
  $(id).addEventListener('input', () => {
    if ($('intervalKm').value || $('intervalBulan').value) $('intervalError').hidden = true;
  });
});

$('bodyJenis').addEventListener('click', event => {
  const button = event.target.closest('button[data-action]');
  if (!button) return;
  const item = jenisServis.find(row => row.id === Number(button.dataset.id));
  if (!item) return;

  if (button.dataset.action === 'lihat') {
    focusTarget = button;
    $('detailNama').textContent = item.nama;
    $('detailInterval').textContent = formatInterval(item);
    $('detailKeterangan').textContent = item.keterangan || '-';
    modalDetail.show();
  } else if (button.dataset.action === 'edit') {
    focusTarget = button;
    siapkanForm(item);
    modalForm.show();
  } else if (button.dataset.action === 'hapus') {
    focusTarget = $('btnTambah');
    hapusId = item.id;
    $('hapusRingkas').textContent = item.nama;
    modalHapus.show();
  }
});

$('formJenis').addEventListener('submit', async event => {
  event.preventDefault();
  const form = $('formJenis');
  const intervalKm = $('intervalKm').value;
  const intervalBulan = $('intervalBulan').value;
  const intervalTidakDiisi = intervalKm === '' && intervalBulan === '';
  $('intervalError').hidden = !intervalTidakDiisi;
  if (!form.reportValidity() || intervalTidakDiisi) return;

  const button = form.querySelector('[type="submit"]');
  const id = $('jenisId').value;
  const values = {
    nama: $('namaJenis').value.trim(),
    intervalKm,
    intervalBulan,
    keterangan: $('keterangan').value.trim()
  };
  const endpoint = id ? 'ubah_jenis_servis.php' : 'tambah_jenis_servis.php';
  if (id) values.id = id;
  button.disabled = true;

  try {
    const result = await apiRequest(endpoint, 'POST', values);
    focusTarget = $('btnTambah');
    modalForm.hide();
    notif(result.message);

    try {
      await muatJenis();
    } catch (error) {
      notif(result.message + ' Namun daftar jenis servis gagal diperbarui: ' + error.message, false);
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
    const result = await apiRequest('hapus_jenis_servis.php', 'POST', { id: String(hapusId) });
    jenisServis = jenisServis.filter(item => item.id !== hapusId);
    hapusId = null;
    modalHapus.hide();
    renderJenis();
    notif(result.message);
  } catch (error) {
    notif(error.message, false);
  } finally {
    button.disabled = false;
  }
});

$('modalJenis').addEventListener('ui:shown', () => $('namaJenis').focus());
$('modalJenis').addEventListener('ui:hidden', () => $('formJenis').reset());
pulihkanFokus($('modalJenis'));
pulihkanFokus($('modalDetail'));
pulihkanFokus($('modalHapus'));

$('statusJenis').textContent = 'Memuat data jenis servis.';
$('bodyJenis').innerHTML = '<tr><td class="text-center text-body-secondary py-4" colspan="5">Memuat data jenis servis...</td></tr>';
muatJenis().catch(tampilkanGagalMuat);
