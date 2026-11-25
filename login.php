<?php

require_once __DIR__ . '/db/auth.php';

if (pengguna_login() !== null) {
    header('Location: user/dashboard.php');
    exit;
}

$pesan = '';
$jenisPesan = 'danger';

if (isset($_GET['registered'])) {
    $pesan = 'Registrasi berhasil. Silakan login dengan akun baru Anda.';
    $jenisPesan = 'success';
} elseif (isset($_GET['logout'])) {
    $pesan = 'Anda berhasil logout.';
    $jenisPesan = 'success';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim((string) ($_POST['username'] ?? ''));
    $password = (string) ($_POST['password'] ?? '');

    if ($username === '' || $password === '') {
        $pesan = 'Username dan password wajib diisi.';
    } else {
        require_once __DIR__ . '/db/koneksi.php';

        try {
            $db = koneksi_database();
            $query = $db->prepare(
                'SELECT id_pengguna, nama, username, password
                 FROM pengguna
                 WHERE username = :username
                 LIMIT 1'
            );
            $query->execute(['username' => $username]);
            $pengguna = $query->fetch();

            if ($pengguna && password_verify($password, $pengguna['password'])) {
                session_regenerate_id(true);
                $_SESSION['pengguna'] = [
                    'id_pengguna' => (int) $pengguna['id_pengguna'],
                    'nama' => $pengguna['nama'],
                    'username' => $pengguna['username'],
                ];
                header('Location: user/dashboard.php');
                exit;
            }

            $pesan = 'Username atau password salah.';
        } catch (PDOException $exception) {
            error_log('Login database error: ' . $exception->getMessage());
            $pesan = 'Login tidak dapat diproses karena database tidak tersedia. Periksa konfigurasi database.';
        }
    }
}
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="Masuk ke Aplikasi Pencatatan Servis Kendaraan Pribadi.">
  <title>Login | Servis Kendaraan Pribadi</title>
  <link href="assets/css/style.css" rel="stylesheet">
  <link href="assets/css/login.css" rel="stylesheet">
</head>
<body>
  <main class="login-page">
    <section class="login-card" aria-labelledby="judulLogin">
      <header class="login-brand">
        <div class="login-logo" aria-hidden="true">S</div>
        <p class="fw-bold mb-0">Aplikasi Pencatatan Servis<br>Kendaraan Pribadi</p>
      </header>

      <div class="login-heading">
        <h1 class="h2 fw-bold mb-1" id="judulLogin">Login</h1>
        <p class="text-body-secondary mb-4">Masuk untuk mengakses akun Anda</p>
      </div>

      <form id="formLogin" method="post" action="login.php" novalidate>
        <div class="mb-3">
          <label for="username" class="form-label fw-semibold">Username</label>
          <input
            type="text"
            class="form-control"
            id="username"
            name="username"
            placeholder="Masukkan username Anda"
            autocomplete="username"
            required
            aria-describedby="errorUsername"
            value="<?= htmlspecialchars((string) ($_POST['username'] ?? ''), ENT_QUOTES, 'UTF-8') ?>">
          <div class="invalid-feedback" id="errorUsername">Username wajib diisi.</div>
        </div>

        <div class="mb-2">
          <label for="password" class="form-label fw-semibold">Password</label>
          <div class="input-group has-validation">
            <input
              type="password"
              class="form-control"
              id="password"
              name="password"
              placeholder="Masukkan password Anda"
              autocomplete="current-password"
              required
              aria-describedby="errorPassword">
            <button
              class="btn btn-outline-secondary password-toggle"
              type="button"
              id="togglePassword"
              aria-label="Tampilkan password"
              aria-pressed="false">
              Tampilkan
            </button>
            <div class="invalid-feedback" id="errorPassword">Password wajib diisi.</div>
          </div>
        </div>

        <div id="loginMessage" class="alert <?= $pesan === '' ? 'd-none' : 'alert-' . $jenisPesan ?> mt-3" role="status" aria-live="polite"><?= htmlspecialchars($pesan, ENT_QUOTES, 'UTF-8') ?></div>

        <button class="btn btn-primary w-100 login-submit mt-4" type="submit">Masuk</button>
      </form>

      <footer class="login-register">
        <span>Belum punya akun?</span>
        <a href="reg.php" class="link-primary">Registrasi</a>
      </footer>
    </section>
  </main>
    <script src="assets/js/login.js?v=<?= filemtime(__DIR__ . '/assets/js/login.js') ?>"></script>
    <script src="assets/js/common-ui.js"></script>
</body>
</html>