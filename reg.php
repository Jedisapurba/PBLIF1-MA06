<?php

require_once __DIR__ . '/db/auth.php';

if (pengguna_login() !== null) {
    header('Location: user/dashboard.php');
    exit;
}

$pesan = '';
$jenisPesan = 'danger';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim((string) ($_POST['namaLengkap'] ?? ''));
    $username = trim((string) ($_POST['username'] ?? ''));
    $password = (string) ($_POST['password'] ?? '');
    $konfirmasiPassword = (string) ($_POST['konfirmasiPassword'] ?? '');

    if ($nama === '' || $username === '' || $password === '' || $konfirmasiPassword === '') {
        $pesan = 'Semua kolom wajib diisi.';
    } elseif (strlen($nama) > 400 || mb_strlen($nama, 'UTF-8') > 100) {
        $pesan = 'Nama lengkap maksimal 100 karakter.';
    } elseif (strlen($username) > 400 || mb_strlen($username, 'UTF-8') > 100) {
        $pesan = 'Username maksimal 100 karakter.';
    } elseif ($password !== $konfirmasiPassword) {
        $pesan = 'Konfirmasi password tidak sama.';
    } elseif (!isset($_POST['setuju'])) {
        $pesan = 'Persetujuan syarat dan ketentuan wajib diberikan.';
    } else {
        require_once __DIR__ . '/db/koneksi.php';

        try {
            $db = koneksi_database();
            $query = $db->prepare(
                'INSERT INTO pengguna (nama, username, password)
                 VALUES (:nama, :username, :password)'
            );
            $query->execute([
                'nama' => $nama,
                'username' => $username,
                'password' => password_hash($password, PASSWORD_DEFAULT),
            ]);

            header('Location: login.php?registered=1');
            exit;
        } catch (PDOException $exception) {
            if ($exception->getCode() === '23000') {
                $pesan = 'Username tersebut sudah digunakan. Silakan pilih username lain.';
            } else {
                error_log('Registration database error: ' . $exception->getMessage());
                $pesan = 'Registrasi tidak dapat diproses karena database tidak tersedia. Periksa konfigurasi database.';
            }
        }
    }
}
?>
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

      <form id="formRegistrasi" method="post" action="reg.php" novalidate>
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
            aria-describedby="errorNama"
            value="<?= htmlspecialchars((string) ($_POST['namaLengkap'] ?? ''), ENT_QUOTES, 'UTF-8') ?>">
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
            aria-describedby="errorUsername"
            value="<?= htmlspecialchars((string) ($_POST['username'] ?? ''), ENT_QUOTES, 'UTF-8') ?>">
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

        <div id="registerMessage" class="alert <?= $pesan === '' ? 'd-none' : 'alert-' . $jenisPesan ?> mt-3" role="status" aria-live="polite"><?= htmlspecialchars($pesan, ENT_QUOTES, 'UTF-8') ?></div>

        <button class="btn btn-primary w-100 register-submit" type="submit">Daftar</button>
      </form>

      <footer class="register-footer">
        <span>Sudah punya akun?</span>
        <a href="login.php" class="link-primary">Login</a>
      </footer>
    </section>
  </main>

    <script src="assets/js/reg.js?v=<?= filemtime(__DIR__ . '/assets/js/reg.js') ?>"></script>
</body>
</html>