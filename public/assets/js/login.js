document.querySelector("#form-login").addEventListener("submit", async (e) => {
  e.preventDefault();

  const email = e.target.email.value.trim();
  const pass = e.target.password.value;

  const btnLogin = document.querySelector(".btn-login");
  btnLogin.setAttribute("disabled", true);
  btnLogin.innerText = "INGRESANDO...";

  if (!email || !pass) {
    mostrarError("Todos los campos son obligatorios");
    resetearBoton(btnLogin, "INGRESAR");
    return;
  }

  const captchaToken = grecaptcha.getResponse();

  if (!captchaToken) {
    mostrarError("Por favor, completa el captcha");
    resetearBoton(btnLogin, "INGRESAR");
    return;
  }

  const formData = new FormData();
  formData.append("email", email);
  formData.append("password", pass);
  formData.append("g-recaptcha-response", captchaToken);

  try {
    const response = await fetch(`${window.BASE_URL}login/validar`, {
      method: "POST",
      body: formData,
      headers: {
        "X-Requested-With": "XMLHttpRequest",
      },
    });

    const data = await response.json();

    if (data.success) {
      Swal.fire({
        title: "¡Bienvenido!",
        text: data.message || "Inicio de sesión exitoso.",
        icon: "success",
        confirmButtonText: "Continuar",
      }).then(() => {
        window.location.href = `${window.BASE_URL}dashboard`;
      });
    } else {
      Swal.fire({
        title: "Error de autenticación",
        text: data.message || "Credenciales incorrectas",
        icon: "error",
        confirmButtonText: "Intentar de nuevo",
      });
      grecaptcha.reset();
      resetearBoton(btnLogin, "INGRESAR");
    }
  } catch (error) {
    console.error("Error en la petición:", error);
    Swal.fire({
      title: "Error de conexión",
      text: "No se pudo establecer comunicación con el servidor. Intenta nuevamente.",
      icon: "error",
      confirmButtonText: "Aceptar",
    });
    grecaptcha.reset();
    resetearBoton(btnLogin, "INGRESAR");
  } finally {
    resetearBoton(btnLogin, "INGRESAR");
  }
});

function mostrarError(mensaje) {
  Swal.fire({
    title: "Error",
    text: mensaje,
    icon: "error",
    confirmButtonText: "Aceptar",
  });
}

function resetearBoton(btn, text) {
  btn.removeAttribute("disabled");
  btn.innerText = text;
}

function toggleObligatorioLabel(input, span) {
  if (input.value.trim() !== "") {
    span.style.display = "none";
  } else {
    span.style.display = "inline";
  }
}

function initObligatorioLabels() {
  const obligatoriosSpans = document.querySelectorAll(".obligatorio");

  obligatoriosSpans.forEach((span) => {
    const label = span.closest("label");
    if (label) {
      const forAttribute = label.getAttribute("for");
      const input = document.querySelector(`#${forAttribute}`);

      if (input) {
        input.addEventListener("input", function () {
          toggleObligatorioLabel(this, span);
        });

        input.addEventListener("blur", function () {
          toggleObligatorioLabel(this, span);
        });


        toggleObligatorioLabel(input, span);
      }
    }
  });
}

document.addEventListener("DOMContentLoaded", function () {
  initObligatorioLabels();
});
