document.querySelector('#form-login').addEventListener('submit', async (e) => {
    e.preventDefault();

    const email = e.target.email.value.trim();
    const pass = e.target.password.value;

    const btnLogin = document.querySelector('.btn-login');
    btnLogin.setAttribute('disabled', true);
    btnLogin.innerText = 'INGRESANDO...';

    if (!email || !pass) {
        mostrarError('Todos los campos son obligatorios');
        resetearBoton(btnLogin, 'INGRESAR');
        return;
    }

    const captchaToken = grecaptcha.getResponse();

    if (!captchaToken) {
        mostrarError('Por favor, completa el captcha');
        resetearBoton(btnLogin, 'INGRESAR');
        return;
    }

    const formData = new FormData();
    formData.append('email', email);
    formData.append('password', pass);
    formData.append('g-recaptcha-response', captchaToken);

    try {
        const response = await fetch('http://localhost/orvys-admin/public/login/validar', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        const data = await response.json();

        if (data.success) {
            mostrarExito(data.message || 'Inicio de sesión exitoso');
            window.location.href = 'http://localhost/orvys-admin/public/dashboard';
        } else {
            mostrarError(data.message || 'Credenciales incorrectas');
            grecaptcha.reset();
        }
    } catch (error) {
        console.error('Error:', error);
        mostrarError('Error de conexión. Intenta nuevamente.');
    } finally {
        resetearBoton(btnLogin, 'INGRESAR');
    }
});


function mostrarError(mensaje) {
    alert('Error: ' + mensaje);
}

function mostrarExito(mensaje) {
    alert('Éxito: ' + mensaje);
}

function resetearBoton(btn, texto) {
    btn.removeAttribute('disabled');
    btn.innerText = texto;
}
