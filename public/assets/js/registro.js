document.querySelector('#form-registro').addEventListener('submit', async (e) => {
    e.preventDefault();

    const nombre = e.target.nombre.value.trim();
    const tel = e.target.telefono.value.trim();
    const email = e.target.email.value.trim();
    const pass = e.target.password.value;
    const passVerif = e.target.confirm_password.value;

    const btnEnviar = document.querySelector('.btn-enviar');
    btnEnviar.setAttribute('disabled', true);
    btnEnviar.innerText = 'PROCESANDO...';

    if (!nombre || !tel || !email || !pass || !passVerif) {
        mostrarError('Todos los campos son obligatorios');
        resetearBoton(btnEnviar);
        return;
    }

    if (pass !== passVerif) {
        mostrarError('Las contraseñas no coinciden');
        resetearBoton(btnEnviar);
        return;
    }

    if (pass.length < 8) {
        mostrarError('La contraseña debe tener al menos 8 caracteres');
        resetearBoton(btnEnviar);
        return;
    }

    const formData = new FormData();
    formData.append('nombre', nombre);
    formData.append('telefono', tel);
    formData.append('email', email);
    formData.append('password', pass);

    try {
        const response = await fetch('http://localhost/orvys-admin/public/usuario/registrar', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        const data = await response.json();

        if (data.success) {
            mostrarExito(data.message || 'Usuario registrado exitosamente');
            document.querySelector('#form-registro').reset();
            window.location.href = 'http://localhost/orvys-admin/public/login';
        } else {
            mostrarError(data.message || 'Error al registrar usuario');
        }
    } catch (error) {
        console.error('Error:', error);
        mostrarError('Error de conexión. Intenta nuevamente.');
    } finally {
        resetearBoton(btnEnviar);
    }
});

function mostrarError(mensaje) {
    alert('Error: ' + mensaje);
}

function mostrarExito(mensaje) {
    alert('Éxito: ' + mensaje);
}

function resetearBoton(btn) {
    btn.removeAttribute('disabled');
    btn.innerText = 'REGISTRAR';
}
