<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="Masuk ke Aplikasi Pencatatan Servis Kendaraan Pribadi.">
  <title>Login | Servis Kendaraan Pribadi</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/css/style.css" rel="stylesheet">
  <style>
    .login-page {
      min-height: 100vh;
      display: grid;
      place-items: center;
      padding: 1.5rem 1rem;
      background: var(--sv-bg);
    }
    .login-card {
      width: min(100%, 400px);
      min-height: 625px;
      padding: 2rem;
      border: 1px solid var(--sv-border);
      border-radius: .375rem;
      background: var(--sv-surface);
      box-shadow: 0 .125rem .5rem rgba(26, 29, 33, .04);
    }
    .login-brand {
      padding-bottom: 1.25rem;
      border-bottom: 1px solid var(--sv-border);
      text-align: center;
    }
    .login-logo {
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
    .login-heading { margin-top: 1.25rem; }
    .login-submit { min-height: 44px; }
    .password-toggle { min-width: 48px; }
    .login-register {
      margin-top: 1.5rem;
      padding-top: 1.25rem;
      border-top: 1px solid var(--sv-border);
      text-align: center;
    }
    @media (max-width: 420px) {
      .login-card { min-height: auto; padding: 1.5rem; }
    }
  </style>
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

      <form id="formLogin" novalidate>
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
            aria-describedby="errorUsername">
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

        <div id="loginMessage" class="alert d-none mt-3" role="status" aria-live="polite"></div>

        <button class="btn btn-primary w-100 login-submit mt-4" type="submit">Masuk</button>
      </form>

      <footer class="login-register">
        <span>Belum punya akun?</span>
        <a href="reg.html" class="link-primary">Registrasi</a>
      </footer>
    </section>
  </main>

  <script>
    const form = document.getElementById('formLogin');
    const username = document.getElementById('username');
    const password = document.getElementById('password');
    const passwordToggle = document.getElementById('togglePassword');
    const message = document.getElementById('loginMessage');

    function validateField(field) {
      const valid = field.value.trim() !== '';
      field.classList.toggle('is-invalid', !valid);
      field.setAttribute('aria-invalid', String(!valid));
      return valid;
    }

    [username, password].forEach(field => {
      field.addEventListener('input', () => {
        if (field.classList.contains('is-invalid')) validateField(field);
        message.classList.add('d-none');
      });
    });

    passwordToggle.addEventListener('click', () => {
      const isVisible = password.type === 'text';
      password.type = isVisible ? 'password' : 'text';
      passwordToggle.textContent = isVisible ? 'Tampilkan' : 'Sembunyikan';
      passwordToggle.setAttribute('aria-label', isVisible ? 'Tampilkan password' : 'Sembunyikan password');
      passwordToggle.setAttribute('aria-pressed', String(!isVisible));
      password.focus();
    });

    form.addEventListener('submit', event => {
      event.preventDefault();
      message.classList.add('d-none');

      const usernameValid = validateField(username);
      const passwordValid = validateField(password);
      if (!usernameValid || !passwordValid) {
        (usernameValid ? password : username).focus();
        return;
      }

      message.className = 'alert alert-info mt-3';
      message.textContent = 'Autentikasi belum terhubung. Silakan sambungkan formulir ini ke layanan login.';
    });
  </script>
</body>
</html>