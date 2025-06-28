document.addEventListener("DOMContentLoaded", () => {
  let currentStep = 1;
  const totalSteps = 3;

  const steps = document.querySelectorAll(".wizard-step");
  const navLinks = document.querySelectorAll("#wizardNav .nav-link");
  const nextBtn = document.getElementById("nextStep");
  const prevBtn = document.getElementById("prevStep");
  const progressBar = document.getElementById("wizardProgress");

  function showStep(step) {
    steps.forEach((el) => {
      el.classList.toggle("d-none", el.dataset.step != step);
    });

    navLinks.forEach((el) => {
      el.classList.toggle("active", el.dataset.step == step);
    });

    prevBtn.disabled = step == 1;
    nextBtn.innerHTML = step == totalSteps
      ? '<i class="fas fa-save me-2"></i>Guardar'
      : 'Siguiente <i class="fas fa-arrow-right ms-2"></i>';

    progressBar.style.width = `${(step / totalSteps) * 100}%`;
  }

  function validateStep(step) {
    const stepDiv = document.querySelector(`.wizard-step[data-step="${step}"]`);
    const inputs = stepDiv.querySelectorAll("input, select, textarea");

    for (let input of inputs) {
      if (input.offsetParent === null || input.disabled) continue;

      if (input.tagName === "SELECT" && input.selectedIndex === 0) {
        mostrarError("Por favor, complete todos los campos antes de continuar.");
        input.focus();
        return false;
      }

      if (!input.value || input.value.trim() === "") {
        mostrarError("Por favor, complete todos los campos antes de continuar.");
        input.focus();
        return false;
      }
    }

    return true;
  }

  navLinks.forEach((link) => {
    link.addEventListener("click", () => {
      const targetStep = parseInt(link.dataset.step);
      if (targetStep > currentStep) {
        if (!validateStep(currentStep)) return;
      }
      currentStep = targetStep;
      showStep(currentStep);
    });
  });

  nextBtn.addEventListener("click", () => {
    if (currentStep < totalSteps) {
      if (validateStep(currentStep)) {
        currentStep++;
        showStep(currentStep);
      }
    } else {
      if (validateStep(currentStep)) {
        mostrarExitoso("Datos guardados correctamente.");
      }
    }
  });

  prevBtn.addEventListener("click", () => {
    if (currentStep > 1) {
      currentStep--;
      showStep(currentStep);
    }
  });

  showStep(currentStep);
});

function mostrarError(mensaje) {
    Swal.fire({
        title: 'Error',
        text: mensaje,
        icon: 'error',
        confirmButtonText: 'Aceptar'
    });
}

function mostrarExitoso(mensaje) {
    Swal.fire({
        title: '¡Guardado Correcto!',
        text: mensaje,
        icon: 'success',
        confirmButtonText: 'Aceptar'
    });
}



const sidebar = document.getElementById("sidebar");
const toggleBtn = document.getElementById("toggleSidebar");

toggleBtn.addEventListener("click", () => {
  sidebar.classList.toggle("collapsed");

  if (sidebar.classList.contains("collapsed")) {
    const submenus = document.querySelectorAll(".sidebar-submenu");
    submenus.forEach((sub) => {
      sub.classList.remove("show");
    });
  }

  const tooltipTriggerList = [].slice.call(
    document.querySelectorAll("[title]")
  );
  tooltipTriggerList.forEach(function (el) {
    new bootstrap.Tooltip(el);
  });
});


document.querySelectorAll('.sidebar-link').forEach(link => {
  link.addEventListener('click', (e) => {
    if (sidebar.classList.contains('collapsed')) {
      e.preventDefault();
      sidebar.classList.remove('collapsed');
      const tooltipTriggerList = [].slice.call(
        document.querySelectorAll("[title]")
      );
      tooltipTriggerList.forEach(function (el) {
        new bootstrap.Tooltip(el);
      });
    }
  });
});
