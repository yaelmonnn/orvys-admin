document.addEventListener("DOMContentLoaded", () => {
  let currentStep = 1;
  const totalSteps = 3;

  const steps = document.querySelectorAll(".wizard-step");
  const navLinks = document.querySelectorAll("#wizardNav .nav-link");
  const nextBtn = document.getElementById("nextStep");
  const prevBtn = document.getElementById("prevStep");
  const progressBar = document.getElementById("wizardProgress");

  
    const selectSprint = document.getElementById("sprintAsignado");
    const inputFechaLimite = document.getElementById("fechaLimite");


    selectSprint.addEventListener("focus", function () {
      sprintAnteriorTarea = this.value;
    });

    if (window.FECHA_FIN_PROYECTO) {
      inputFechaLimite.setAttribute("max", window.FECHA_FIN_PROYECTO);
    }

  function showStep(step) {
    steps.forEach((el) => {
      el.classList.toggle("d-none", el.dataset.step != step);
    });

    navLinks.forEach((el) => {
      el.classList.toggle("active", el.dataset.step == step);
    });

    prevBtn.disabled = step == 1;
    nextBtn.innerHTML =
      step == totalSteps
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
        mostrarError(
          "Por favor, complete todos los campos antes de continuar."
        );
        input.focus();
        return false;
      }

      if (!input.value || input.value.trim() === "") {
        mostrarError(
          "Por favor, complete todos los campos antes de continuar."
        );
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
      if (currentStep === 3) {
        actualizarResumen();
      }
    });
  });

  nextBtn.addEventListener("click", async () => {
    if (currentStep < totalSteps) {
      if (validateStep(currentStep)) {
        currentStep++;
        showStep(currentStep);
        if (currentStep === 3) {
          actualizarResumen();
        }
      }
    } else {
      if (validateStep(currentStep)) {
        const btnEnviar = document.getElementById("nextStep");
        btnEnviar.setAttribute("disabled", "true");
        btnEnviar.textContent = "GUARDANDO...";
        const nombreHistoria = document
          .getElementById("nombreHistoria")
          .value.trim();
        const cargoSolicitante =
          document.getElementById("cargoSolicitante").value;
        const nivelUrgencia = document.getElementById("nivelUrgencia").value;
        const nivelComplejidad =
          document.getElementById("nivelComplejidad").value;
        const descripcion = document.getElementById("descripcion").value.trim();
                const moduloRelacionado = document
          .getElementById("moduloRelacionado")
          .value.trim();
        const duracionEstimada =
          document.getElementById("duracionEstimada").value;
        const estatusTarea = document.getElementById("estatusTarea").value;
        const observacionesTecnicas = document
          .getElementById("observacionesTecnicas")
          .value.trim();
        const comentariosAdicionales = document
          .getElementById("comentariosAdicionales")
          .value.trim();
        const pruebasUnitarias = document
          .getElementById("pruebasUnitarias")
          .value.trim();
        const idProyecto = document.getElementById("idProyecto").value;
        const sprintAsignado = document.getElementById("sprintAsignado").value;
        const fechaRegistro = document.getElementById("fechaRegistro").value;
        const fechaLimite = document.getElementById("fechaLimite").value;




        if (
          !nombreHistoria ||
          !cargoSolicitante ||
          !nivelUrgencia ||
          !nivelComplejidad ||
          !fechaRegistro ||
          !descripcion
        ) {
          mostrarError("Completa todos los campos obligatorios");
          btnEnviar.removeAttribute("disabled");
          btnEnviar.innerHTML =
            'Guardar <i class="fas fa-arrow-right ms-2"></i>';
          return;
        }

        const formData = new FormData();
        formData.append("nombreHistoria", nombreHistoria);
        formData.append("cargoSolicitante", cargoSolicitante);
        formData.append("nivelUrgencia", nivelUrgencia);
        formData.append("nivelComplejidad", nivelComplejidad);
        formData.append("fechaRegistro", fechaRegistro);
        formData.append("descripcion", descripcion);
        formData.append("moduloRelacionado", moduloRelacionado);
        formData.append("duracionEstimada", duracionEstimada);
        formData.append("fechaLimite", fechaLimite);
        formData.append("estatusTarea", estatusTarea);
        formData.append("sprintAsignado", sprintAsignado);
        formData.append("observacionesTecnicas", observacionesTecnicas);
        formData.append("comentariosAdicionales", comentariosAdicionales);
        formData.append("pruebasUnitarias", pruebasUnitarias);
        formData.append("idProyecto", idProyecto);

        try {
          const response = await fetch(`${window.BASE_URL}tareas/guardar`, {
            method: "POST",
            body: formData,
            headers: {
              "X-Requested-With": "XMLHttpRequest"
            },
          });

          const data = await response.json();

          if (data.success) {
            Swal.fire({
              title: "¡Guardado exitoso!",
              text: data.message || "La tarea se guardó correctamente.",
              icon: "success",
              confirmButtonText: "Aceptar",
            }).then(() => {
              window.location.href = `${window.BASE_URL}proyectos`;
            });
          } else {
            Swal.fire({
              title: "Error",
              text: data.message || "No se pudo guardar la tarea.",
              icon: "error",
              confirmButtonText: "Aceptar",
            });
            btnEnviar.removeAttribute("disabled");
            btnEnviar.innerHTML = 'Guardar <i class="fas fa-arrow-right ms-2"></i>';
          }
        } catch (error) {
          console.error("Error:", error);
          Swal.fire({
            title: "Error de conexión",
            text: "Ocurrió un problema al conectar con el servidor. Intenta nuevamente.",
            icon: "error",
            confirmButtonText: "Aceptar",
          });
          btnEnviar.removeAttribute("disabled");
          btnEnviar.innerHTML = 'Guardar <i class="fas fa-arrow-right ms-2"></i>';
        } finally {
          btnEnviar.removeAttribute("disabled");
          btnEnviar.innerHTML =
            'Guardar <i class="fas fa-arrow-right ms-2"></i>';
        }
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
    title: "Error",
    text: mensaje,
    icon: "error",
    confirmButtonText: "Aceptar",
  });
}

function mostrarExitoso(mensaje) {
  Swal.fire({
    title: "¡Guardado Correcto!",
    text: mensaje,
    icon: "success",
    confirmButtonText: "Aceptar",
  });
}

function actualizarResumen() {
  document.getElementById("resumenNombreHistoria").textContent =
    document.getElementById("nombreHistoria").value;
  document.getElementById("resumenCargo").textContent =
    document.getElementById("cargoSolicitante").value;
  document.getElementById("resumenUrgencia").textContent =
    document.getElementById("nivelUrgencia").value;

  const fechaRegistro = document.getElementById("fechaRegistro").value;
  document.getElementById("resumenFecha").textContent =
    formatearFechaDMY(fechaRegistro);

  document.getElementById("resumenModulo").textContent =
    document.getElementById("moduloRelacionado").value;
  document.getElementById("resumenDuracion").textContent =
    document.getElementById("duracionEstimada").value + " horas";

  const fechaLimite = document.getElementById("fechaLimite").value;
  document.getElementById("resumenLimite").textContent =
    formatearFechaDMY(fechaLimite);

  document.getElementById("resumenEstatus").textContent =
    document.getElementById("estatusTarea").value;
  document.getElementById("resumenSprint").textContent =
    document.getElementById("sprintAsignado").value;
}

function formatearFechaDMY(fechaISO) {
  const partes = fechaISO.split("-");
  if (partes.length === 3) {
    return `${partes[2]}/${partes[1]}/${partes[0]}`;
  }
  return fechaISO;
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

document.querySelectorAll(".sidebar-link").forEach((link) => {
  link.addEventListener("click", (e) => {
    if (sidebar.classList.contains("collapsed")) {
      e.preventDefault();
      sidebar.classList.remove("collapsed");
      const tooltipTriggerList = [].slice.call(
        document.querySelectorAll("[title]")
      );
      tooltipTriggerList.forEach(function (el) {
        new bootstrap.Tooltip(el);
      });
    }
  });
});

function setFechaFin() {
  const selectSprint = document.getElementById("sprintAsignado");
  const numeroSprints = parseInt(selectSprint.value);
  const fechaInicio = document.getElementById("fechaRegistro").value;
  const fechaLimiteProyecto = new Date(window.FECHA_FIN_PROYECTO); 
  const inputFechaLimite = document.getElementById("fechaLimite");

  if (!isNaN(numeroSprints) && fechaInicio) {
    const fechaIniObj = new Date(fechaInicio);
    const fechaFinObj = new Date(fechaIniObj);
    fechaFinObj.setMonth(fechaFinObj.getMonth() + numeroSprints);


    const fechaFinISO = fechaFinObj.toISOString().split("T")[0];
    const fechaLimiteISO = window.FECHA_FIN_PROYECTO;

    if (fechaFinObj > fechaLimiteProyecto) {

      selectSprint.value = sprintAnteriorTarea;

      inputFechaLimite.value = fechaLimiteISO;


      mostrarError("La fecha límite calculada para esta tarea supera la fecha final del proyecto. Selecciona un sprint menor.");
    } else {

      inputFechaLimite.value = fechaFinISO;


      sprintAnteriorTarea = selectSprint.value;
    }

    inputFechaLimite.setAttribute("max", fechaLimiteISO);
  }
}
