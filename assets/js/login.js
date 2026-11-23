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
