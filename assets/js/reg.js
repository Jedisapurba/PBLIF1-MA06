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
        event.preventDefault();
        firstInvalid[0].focus();
      }
    });
