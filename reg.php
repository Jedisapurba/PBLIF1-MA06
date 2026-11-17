<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="Buat akun Aplikasi Pencatatan Servis Kendaraan Pribadi.">
  <title>Registrasi | Servis Kendaraan Pribadi</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/css/style.css" rel="stylesheet">
  <style>
    .register-page {
      min-height: 100vh;
      display: grid;
      place-items: center;
      padding: 1.5rem 1rem;
      background: var(--sv-bg);
    }
    .register-card {
      width: min(100%, 420px);
      padding: 1.75rem 1.875rem;
      border: 1px solid var(--sv-border);
      border-radius: .375rem;
      background: var(--sv-surface);
      box-shadow: 0 .125rem .5rem rgba(26, 29, 33, .04);
    }
    .register-brand {
      padding-bottom: 1rem;
      border-bottom: 1px solid var(--sv-border);
      text-align: center;
    }
    .register-logo {
      display: grid;
      width: 56px;
      height: 56px;
      margin: 0 auto .75rem;
      place-items: center;
      border-radius: .75rem;
      background: var(--sv-primary);
      color: #fff;
      font-size: 1.5rem;
      font-weight: 700;
    }
    .register-heading { margin-top: 1.15rem; }
    .register-submit { min-height: 40px; }
    .register-footer {
      margin-top: 1.25rem;
      padding-top: 1.15rem;
      border-top: 1px solid var(--sv-border);
      text-align: center;
    }
    @media (max-width: 420px) {
      .register-card { padding: 1.5rem; }
    }
  </style>
</head>
<body>
  <main class="register-page">
    <section class="register-card" aria-labelledby="judulRegistrasi">
      <header class="register-brand">
        <div class="register-logo" aria-hidden="true">S</div>
        <p class="fw-bold mb-0">Aplikasi Pencatatan Servis<br>Kendaraan Pribadi</p>
      </header>

      <div class="register-heading">
        <h1 class="h2 fw-bold mb-1" id="judulRegistrasi">Registrasi</h1>
        <p class="text-body-secondary small mb-4">Buat akun baru untuk mulai mencatat servis kendaraan</p>
      </div>

      <form id="formRegistrasi" novalidate>
        <div class="mb-3">
          <label for="namaLengkap" class="form-label fw-semibold">Nama Lengkap <span aria-hidden="true">*</span></label>
          <input
            type="text"
            class="form-control"
            id="namaLengkap"
            name="namaLengkap"
            placeholder="Masukkan nama lengkap Anda"
            autocomplete="name"
            required
            aria-describedby="errorNama">
          <div class="invalid-feedback" id="errorNama">Nama lengkap wajib diisi.</div>
        </div>

        <div class="mb-3">
          <label for="username" class="form-label fw-semibold">Username <span aria-hidden="true">*</span></label>
          <input
            type="text"
            class="form-control"
            id="username"
            name="username"
            placeholder="Masukkan username"
            autocomplete="username"
            required
            aria-describedby="errorUsername">
          <div class="invalid-feedback" id="errorUsername">Username wajib diisi.</div>
        </div>

        <div class="mb-3">
          <label for="password" class="form-label fw-semibold">Password <span aria-hidden="true">*</span></label>
          <input
            type="password"
            class="form-control"
            id="password"
            name="password"
            placeholder="Masukkan password"
            autocomplete="new-password"
            required
            aria-describedby="errorPassword">
          <div class="invalid-feedback" id="errorPassword">Password wajib diisi.</div>
        </div>

        <div class="mb-3">
          <label for="konfirmasiPassword" class="form-label fw-semibold">Konfirmasi Password <span aria-hidden="true">*</span></label>
          <input
            type="password"
            class="form-control"
            id="konfirmasiPassword"
            name="konfirmasiPassword"
            placeholder="Masukkan kembali password"
            autocomplete="new-password"
            required
            aria-describedby="errorKonfirmasiPassword">
          <div class="invalid-feedback" id="errorKonfirmasiPassword">Konfirmasi password tidak sama.</div>
        </div>

        <div class="mb-3">
          <div class="form-check">
            <input
              class="form-check-input"
              type="checkbox"
              id="setuju"
              name="setuju"
              required
              aria-describedby="errorSetuju">
            <label class="form-check-label small" for="setuju">Saya setuju dengan Syarat dan Ketentuan</label>
            <div class="invalid-feedback" id="errorSetuju">Persetujuan wajib diberikan untuk melanjutkan.</div>
          </div>
        </div>

        <div id="registerMessage" class="alert d-none mt-3" role="status" aria-live="polite"></div>

        <button class="btn btn-primary w-100 register-submit" type="submit">Daftar</button>
      </form>

      <footer class="register-footer">
        <span>Sudah punya akun?</span>
        <a href="login.html" class="link-primary">Login</a>
      </footer>
    </section>
  </main>

  <script>
    const form = document.getElementById('formRegistrasi');
    const nameField = document.getElementById('namaLengkap');
    const usernameField = document.getElementById('username');
    const passwordField = document.getElementById('password');
    const confirmationField = document.getElementById('konfirmasiPassword');
    const termsField = document.getElementById('setuju');
    const message = document.getElementById('registerMessage');

    function setValidity(field, valid) {
      field.classList.toggle('is-invalid', !valid);
      field.setAttribute('aria-invalid', String(!valid));
      return valid;
    }

    function validatePasswordConfirmation() {
      const valid = confirmationField.value !== '' && confirmationField.value === passwordField.value;
      return setValidity(confirmationField, valid);
    }

    [nameField, usernameField, passwordField].forEach(field => {
      field.addEventListener('input', () => {
        if (field.classList.contains('is-invalid')) {
          setValidity(field, field.value.trim() !== '');
        }
        message.classList.add('d-none');
      });
    });

    passwordField.addEventListener('input', () => {
      if (confirmationField.value) validatePasswordConfirmation();
    });
    confirmationField.addEventListener('input', validatePasswordConfirmation);
    termsField.addEventListener('change', () => setValidity(termsField, termsField.checked));

    form.addEventListener('submit', event => {
      event.preventDefault();
      message.classList.add('d-none');

      const validations = [
        [nameField, nameField.value.trim() !== ''],
        [usernameField, usernameField.value.trim() !== ''],
        [passwordField, passwordField.value !== ''],
        [confirmationField, confirmationField.value !== '' && confirmationField.value === passwordField.value],
        [termsField, termsField.checked]
      ];
      validations.forEach(([field, valid]) => setValidity(field, valid));

      const firstInvalid = validations.find(([, valid]) => !valid);
      if (firstInvalid) {
        firstInvalid[0].focus();
        return;
      }

      message.className = 'alert alert-info mt-3';
      message.textContent = 'Registrasi belum terhubung ke layanan akun. Silakan sambungkan formulir ini ke backend.';
    });
  </script>
</body>
</html>