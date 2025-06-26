
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

  navLinks.forEach((link) => {
    link.addEventListener("click", () => {
      currentStep = parseInt(link.dataset.step);
      showStep(currentStep);
    });
  });

  nextBtn.addEventListener("click", () => {
    if (currentStep < totalSteps) {
      currentStep++;
      showStep(currentStep);
    } else {
      alert("Datos guardados correctamente.");
      // Aquí podrías enviar el formulario
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
