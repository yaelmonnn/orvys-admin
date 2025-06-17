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

    // Validación robusta de contraseña
    if (pass.length < 8) {
        mostrarError('La contraseña debe tener al menos 8 caracteres');
        resetearBoton(btnEnviar);
        return;
    }

    if (!/[a-z]/.test(pass)) {
        mostrarError('La contraseña debe incluir al menos una letra minúscula');
        resetearBoton(btnEnviar);
        return;
    }

    if (!/[A-Z]/.test(pass)) {
        mostrarError('La contraseña debe incluir al menos una letra mayúscula');
        resetearBoton(btnEnviar);
        return;
    }

    if (!/[0-9]/.test(pass)) {
        mostrarError('La contraseña debe incluir al menos un número');
        resetearBoton(btnEnviar);
        return;
    }

    if (!/[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(pass)) {
        mostrarError('La contraseña debe incluir al menos un carácter especial (!@#$%^&*()_+-=[]{}|;:,.<>?)');
        resetearBoton(btnEnviar);
        return;
    }

    const formData = new FormData();
    formData.append('nombre', nombre);
    formData.append('telefono', tel);
    formData.append('email', email);
    formData.append('password', pass);

    try {
        const response = await fetch(`${window.BASE_URL}usuario/registrar`, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        const data = await response.json();

        if (data.success) {
            Swal.fire({
                title: '¡Registro exitoso!',
                text: data.message || 'Usuario registrado exitosamente.',
                icon: 'success',
                confirmButtonText: 'Aceptar'
            }).then(() => {
                document.querySelector('#form-registro').reset();
                window.location.href = `${window.BASE_URL}login`;
            });
        } else {
            Swal.fire({
                title: 'Error',
                text: data.message || 'No se pudo registrar el usuario.',
                icon: 'error',
                confirmButtonText: 'Aceptar'
            });
        }
    } catch (error) {
        console.error('Error:', error);
        Swal.fire({
            title: 'Error de conexión',
            text: 'Ocurrió un problema al conectar con el servidor. Intenta nuevamente.',
            icon: 'error',
            confirmButtonText: 'Aceptar'
        });
    } finally {
        resetearBoton(btnEnviar);
    }
});

function mostrarError(mensaje) {
    Swal.fire({
        title: 'Error',
        text: mensaje,
        icon: 'error',
        confirmButtonText: 'Aceptar'
    });
}

function resetearBoton(btn) {
    btn.removeAttribute('disabled');
    btn.innerText = 'REGISTRAR';
}

function toggleObligatorioLabel(input, span) {
    if (input.value.trim() !== '') {
        span.style.display = 'none';
    } else {
        span.style.display = 'inline';
    }
}

function initObligatorioLabels() {
    const obligatoriosSpans = document.querySelectorAll('.obligatorio');
    
    obligatoriosSpans.forEach(span => {
        const label = span.closest('label');
        if (label) {
            const forAttribute = label.getAttribute('for');
            const input = document.querySelector(`#${forAttribute}`);
            
            if (input) {
                input.addEventListener('input', function() {
                    toggleObligatorioLabel(this, span);
                });
                
                input.addEventListener('blur', function() {
                    toggleObligatorioLabel(this, span);
                });
                
                toggleObligatorioLabel(input, span);
            }
        }
    });
}

document.addEventListener('DOMContentLoaded', function() {
    initObligatorioLabels();
});