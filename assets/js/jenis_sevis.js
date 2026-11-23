const jenisServis = [
      { id: 1, nama: 'Ganti Oli', intervalKm: 2000, intervalBulan: 2, keterangan: 'Oli mesin & filter oli' },
      { id: 2, nama: 'Servis Berkala', intervalKm: 10000, intervalBulan: 6, keterangan: 'Pemeriksaan umum' }
    ];

    const $ = id => document.getElementById(id);
    const esc = value => String(value).replace(/[&<>"']/g, character => ({
      '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;'
    }[character]));
    const formatAngka = value => new Intl.NumberFormat('id-ID').format(value);
    const modalForm = UiModal.getOrCreateInstance($('modalJenis'));
    const modalDetail = UiModal.getOrCreateInstance($('modalDetail'));
    const modalHapus = UiModal.getOrCreateInstance($('modalHapus'));
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

    function renderJenis() {
      const query = $('cariJenis').value.trim().toLocaleLowerCase('id');
      const interval = $('filterInterval').value;
      const rows = jenisServis.filter(item =>
        (!interval || (interval === 'km' ? item.intervalKm : item.intervalBulan)) &&
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

    function siapkanForm(item = null) {
      $('formJenis').reset();
      $('jenisId').value = item ? item.id : '';
      $('judulModalJenis').textContent = item ? 'Edit Jenis Servis' : 'Tambah Jenis Servis';
      $('intervalError').hidden = true;
      if (item) {
        $('namaJenis').value = item.nama;
        $('intervalKm').value = item.intervalKm || '';
        $('intervalBulan').value = item.intervalBulan || '';
        $('keterangan').value = item.keterangan;
      }
    }

    $('btnTambah').addEventListener('click', () => {
      focusTarget = $('btnTambah');
      siapkanForm();
      modalForm.show();
    });
    $('cariJenis').addEventListener('input', renderJenis);
    $('filterInterval').addEventListener('change', renderJenis);
    ['intervalKm', 'intervalBulan'].forEach(id => {
      $(id).addEventListener('input', () => {
        if ($('intervalKm').value || $('intervalBulan').value) $('intervalError').hidden = true;
      });
    });
    $('btnResetFilter').addEventListener('click', () => {
      $('filterInterval').value = '';
      $('cariJenis').value = '';
      $('cariGlobal').value = '';
      renderJenis();
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

    $('formJenis').addEventListener('submit', event => {
      event.preventDefault();
      const form = $('formJenis');
      const km = $('intervalKm').value === '' ? null : Number($('intervalKm').value);
      const bulan = $('intervalBulan').value === '' ? null : Number($('intervalBulan').value);
      const intervalTidakDiisi = km === null && bulan === null;
      $('intervalError').hidden = !intervalTidakDiisi;
      if (!form.reportValidity() || intervalTidakDiisi) return;

      const id = Number($('jenisId').value);
      const item = {
        id: id || Math.max(0, ...jenisServis.map(row => row.id)) + 1,
        nama: $('namaJenis').value.trim(),
        intervalKm: km,
        intervalBulan: bulan,
        keterangan: $('keterangan').value.trim()
      };
      const index = jenisServis.findIndex(row => row.id === id);
      if (index === -1) jenisServis.push(item);
      else jenisServis[index] = item;
      renderJenis();
      modalForm.hide();
      notif(id ? 'Jenis servis berhasil diperbarui.' : 'Jenis servis berhasil ditambahkan.');
    });

    $('btnKonfirmasiHapus').addEventListener('click', () => {
      const index = jenisServis.findIndex(item => item.id === hapusId);
      if (index === -1) {
        modalHapus.hide();
        notif('Gagal menghapus jenis servis.', false);
        return;
      }
      jenisServis.splice(index, 1);
      hapusId = null;
      modalHapus.hide();
      renderJenis();
      notif('Jenis servis berhasil dihapus.');
    });

    $('modalJenis').addEventListener('ui:hidden', () => {
      $('formJenis').reset();
    });
    pulihkanFokus($('modalJenis'));
    pulihkanFokus($('modalDetail'));
    pulihkanFokus($('modalHapus'));
    $('cariGlobal').addEventListener('input', event => {
      $('cariJenis').value = event.target.value;
      renderJenis();
    });
    renderJenis();
