const kendaraan = [
      { id: 1, nama: 'Honda Beat', jenis: 'Motor', polisi: 'BP 1234 AB', tahun: 2021 },
      { id: 2, nama: 'Toyota Avanza', jenis: 'Mobil', polisi: 'BP 5678 CD', tahun: 2018 }
    ];

    const $ = id => document.getElementById(id);
    const esc = value => String(value).replace(/[&<>"']/g, character => ({
      '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;'
    }[character]));
    const modalForm = UiModal.getOrCreateInstance($('modalKendaraan'));
    const modalDetail = UiModal.getOrCreateInstance($('modalDetail'));
    const modalHapus = UiModal.getOrCreateInstance($('modalHapus'));
    const toast = new UiToast($('toast'), { delay: 3500 });
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

    $('modalKendaraan').addEventListener('ui:hide', () => {
      window.setTimeout(() => focusTarget.focus(), 0);
    });
    $('modalKendaraan').addEventListener('ui:hidden', () => {
      $('formKendaraan').reset();
      focusTarget.focus();
    });
    $('cariGlobal').addEventListener('input', event => {
      $('cariKendaraan').value = event.target.value;
      renderKendaraan();
    });
    renderKendaraan();
