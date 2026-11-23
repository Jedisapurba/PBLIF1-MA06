/* ===== DATA CONTOH (ganti dengan fetch ke backend/PHP) =====
       Master kendaraan & jenis servis seharusnya diambil dari endpoint masing-masing. */
    const KENDARAAN = ['Honda Beat', 'Toyota Avanza'];
    const JENIS = ['Ganti Oli', 'Servis Berkala', 'Ganti Ban', 'Rem'];
    let data = [
      { id: 1, tanggal: '2024-06-12', kendaraan: 'Honda Beat',    jenis: 'Ganti Oli',      bengkel: 'AHASS Batam', km: 15200, biaya: 65000,   catatan: 'Oli MPX2' },
      { id: 2, tanggal: '2024-05-01', kendaraan: 'Toyota Avanza', jenis: 'Servis Berkala', bengkel: 'Auto2000',    km: 48000, biaya: 1250000, catatan: '' }
    ];
    let nextId = 3, editId = null, hapusId = null, detailId = null;

    const $ = id => document.getElementById(id);
    const esc = s => String(s ?? '').replace(/[&<>"']/g, c => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]));
    const fmtRp = n => 'Rp ' + new Intl.NumberFormat('id-ID').format(n);
    const fmtNum = n => new Intl.NumberFormat('id-ID').format(n);
    const fmtTgl = iso => iso.split('-').reverse().join('/');

    const mFormDetail = new UiModal($('modalDetail'));
    const mForm = new UiModal($('modalForm'));
    const mHapus = new UiModal($('modalHapus'));
    const toast = new UiToast($('toast'), { delay: 3500 });

    function notif(pesan, sukses = true) {
      $('toast').className = 'toast align-items-center border-0 text-bg-' + (sukses ? 'success' : 'danger');
      $('toastIsi').textContent = pesan;
      toast.show();
    }

    function isiSelect(selectId, list) {
      list.forEach(v => { const o = document.createElement('option'); o.value = o.textContent = v; $(selectId).appendChild(o); });
    }

    /* ---------- Tabel + filter ---------- */
    function render() {
      const mulai = $('fMulai').value, selesai = $('fSelesai').value;
      const salah = mulai && selesai && selesai < mulai;
      $('fSelesai').classList.toggle('is-invalid', salah);
      if (salah) { $('fSelesai').focus(); return; }

      const k = $('fKendaraan').value, j = $('fJenis').value, b = $('fBengkel').value.trim().toLowerCase();
      const rows = data
        .filter(r => (!k || r.kendaraan === k) && (!j || r.jenis === j) &&
                     (!b || r.bengkel.toLowerCase().includes(b)) &&
                     (!mulai || r.tanggal >= mulai) && (!selesai || r.tanggal <= selesai))
        .sort((a, c) => c.tanggal.localeCompare(a.tanggal) || c.id - a.id);

      $('tbody').innerHTML = rows.map(r => `
        <tr>
          <td class="num">${fmtTgl(r.tanggal)}</td>
          <td>${esc(r.kendaraan)}</td>
          <td>${esc(r.jenis)}</td>
          <td>${esc(r.bengkel) || '-'}</td>
          <td class="num">${fmtNum(r.km)}</td>
          <td class="num">${fmtRp(r.biaya)}</td>
          <td>${esc(r.catatan) || '-'}</td>
          <td class="aksi">
            <div class="btn-group btn-group-sm" role="group" aria-label="Aksi untuk ${esc(r.jenis)} ${esc(r.kendaraan)}">
              <button type="button" class="btn btn-outline-secondary" data-aksi="lihat" data-id="${r.id}">Lihat</button>
              <button type="button" class="btn btn-outline-secondary" data-aksi="edit" data-id="${r.id}">Edit</button>
              <button type="button" class="btn btn-outline-danger" data-aksi="hapus" data-id="${r.id}">Hapus</button>
            </div>
          </td>
        </tr>`).join('');
      $('kosong').classList.toggle('d-none', rows.length > 0);
    }

    $('tbody').addEventListener('click', e => {
      const btn = e.target.closest('button[data-aksi]'); if (!btn) return;
      const id = Number(btn.dataset.id);
      ({ lihat: bukaDetail, edit: bukaForm, hapus: bukaHapus })[btn.dataset.aksi](id);
    });
    $('formFilter').addEventListener('submit', e => { e.preventDefault(); render(); });
    $('btnResetFilter').addEventListener('click', () => { $('formFilter').reset(); $('fSelesai').classList.remove('is-invalid'); render(); });

    /* ---------- Detail ---------- */
    function bukaDetail(id) {
      const r = data.find(x => x.id === id); if (!r) return;
      detailId = id;
      const f = (label, val, full) => `<div class="col-12 ${full ? '' : 'col-md-6'}"><dt class="small fw-normal text-body-secondary">${label}</dt><dd class="detail-field mb-0">${val}</dd></div>`;
      $('detailBody').innerHTML =
        f('Tanggal', fmtTgl(r.tanggal)) + f('Kendaraan', esc(r.kendaraan)) +
        f('Jenis Servis', esc(r.jenis)) + f('Bengkel', esc(r.bengkel) || '-') +
        f('Kilometer', fmtNum(r.km)) + f('Biaya', fmtRp(r.biaya)) +
        f('Catatan', esc(r.catatan) || '-', true);
      mFormDetail.show();
    }
    $('btnDetailEdit').addEventListener('click', () => {
      const id = detailId;
      $('modalDetail').addEventListener('ui:hidden', () => bukaForm(id), { once: true });
      mFormDetail.hide();
    });

    /* ---------- Tambah / Edit ---------- */
    const FIELDS = ['Tanggal', 'Kendaraan', 'Jenis', 'Km', 'Biaya'];
    function bersihkanError() {
      FIELDS.forEach(f => $('i' + f).classList.remove('is-invalid'));
    }
    function bukaForm(id) {
      bersihkanError();
      $('formServis').reset();
      editId = id ?? null;
      const r = editId ? data.find(x => x.id === editId) : null;
      $('judulForm').textContent = r ? 'Edit Riwayat Servis' : 'Tambah Riwayat Servis';
      $('btnSimpan').textContent = r ? 'Simpan Perubahan' : 'Simpan';
      if (r) {
        $('iTanggal').value = r.tanggal; $('iKendaraan').value = r.kendaraan; $('iJenis').value = r.jenis;
        $('iBengkel').value = r.bengkel; $('iKm').value = r.km; $('iBiaya').value = r.biaya; $('iCatatan').value = r.catatan;
      }
      mForm.show();
    }
    $('btnTambah').addEventListener('click', () => bukaForm(null));
    $('modalForm').addEventListener('ui:shown', () => $('iTanggal').focus());

    function validasi() {
      const err = {};
      if (!$('iTanggal').value) err.Tanggal = 'Tanggal wajib diisi';
      if (!$('iKendaraan').value) err.Kendaraan = 'Kendaraan wajib dipilih';
      if (!$('iJenis').value) err.Jenis = 'Jenis servis wajib dipilih';
      const km = $('iKm').value, biaya = $('iBiaya').value;
      if (km === '') err.Km = 'Kilometer wajib diisi';
      else if (Number(km) < 0) err.Km = 'Kilometer tidak boleh negatif';
      else if (!Number.isInteger(Number(km))) err.Km = 'Kilometer harus bilangan bulat';
      if (biaya === '') err.Biaya = 'Biaya wajib diisi';
      else if (Number(biaya) < 0) err.Biaya = 'Biaya harus >= 0';
      FIELDS.forEach(f => {
        $('i' + f).classList.toggle('is-invalid', !!err[f]);
        if (err[f]) $('e' + f).textContent = err[f];
      });
      return err;
    }

    $('formServis').addEventListener('submit', e => {
      e.preventDefault();
      const err = validasi();
      const pertama = FIELDS.find(f => err[f]);
      if (pertama) { $('i' + pertama).focus(); return; }
      const rec = {
        tanggal: $('iTanggal').value, kendaraan: $('iKendaraan').value, jenis: $('iJenis').value,
        bengkel: $('iBengkel').value.trim(), km: Number($('iKm').value), biaya: Number($('iBiaya').value),
        catatan: $('iCatatan').value.trim()
      };
      if (editId) { Object.assign(data.find(x => x.id === editId), rec); notif('Riwayat servis berhasil diubah.'); }
      else { data.push({ id: nextId++, ...rec }); notif('Riwayat servis berhasil ditambahkan.'); }
      mForm.hide(); render();
    });

    /* ---------- Hapus ---------- */
    function bukaHapus(id) {
      const r = data.find(x => x.id === id); if (!r) return;
      hapusId = id;
      $('hapusRingkas').textContent = `${r.jenis} — ${r.kendaraan} — ${fmtTgl(r.tanggal)}`;
      mHapus.show();
    }
    $('btnKonfirmasiHapus').addEventListener('click', () => {
      const n = data.length;
      data = data.filter(x => x.id !== hapusId);
      mHapus.hide(); render();
      notif(data.length < n ? 'Riwayat servis berhasil dihapus.' : 'Gagal menghapus riwayat servis.', data.length < n);
    });

    isiSelect('fKendaraan', KENDARAAN); isiSelect('iKendaraan', KENDARAAN);
    isiSelect('fJenis', JENIS); isiSelect('iJenis', JENIS);
    render();
