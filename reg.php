<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="Buat akun Aplikasi Pencatatan Servis Kendaraan Pribadi.">
  <title>Registrasi | Servis Kendaraan Pribadi</title>
  <link href="assets/css/style.css" rel="stylesheet">
  <link href="assets/css/reg.css" rel="stylesheet">
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

    <script src="assets/js/reg.js"></script>
</body>
</html>