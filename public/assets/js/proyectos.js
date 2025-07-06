document.addEventListener("DOMContentLoaded", function () {
  const tabla = new DataTable("#example", {
    language: {
      url: "http://localhost/orvys-admin/public/bootstrap/js/es-ES.json",
      search: "Buscar Proyecto:",
      emptyTable:
        "Ningún dato disponible en esta tabla, por favor, seleccione un periodo primero.",
    },
    layout: {
      topStart: {
        buttons: [
          {
            extend: "copyHtml5",
            text: '<i class="fas fa-copy me-1"></i>',
            className: "dt-button btn btn-sm btn-outline-secondary me-2",
            titleAttr: "Copiar datos al portapapeles",
          },
          {
            extend: "excelHtml5",
            text: '<i class="fas fa-file-excel me-1"></i>',
            className: "dt-button btn btn-sm btn-success me-2",
            titleAttr: "Exportar a Excel",
          },
          {
            extend: "csvHtml5",
            text: '<i class="fas fa-file-csv me-1"></i>',
            className: "dt-button btn btn-sm btn-info me-2",
            titleAttr: "Exportar a CSV",
          },
          {
            extend: "pdfHtml5",
            text: '<i class="fas fa-file-pdf me-1"></i>',
            className: "dt-button btn btn-sm btn-danger",
            titleAttr: "Exportar a PDF",
          },
        ],
      },
    },
    initComplete: function () {
      $(".dt-buttons .dt-button").each(function () {
        $(this).addClass("shadow-sm");
        $(this).removeClass("dt-button");
      });

      document
        .querySelectorAll('[data-bs-toggle="tooltip"], [title]')
        .forEach((el) => {
          new bootstrap.Tooltip(el);
        });

      document
        .querySelectorAll('input[name="importancia"]')
        .forEach((radio) => {
          radio.addEventListener("change", function () {
            const valor = this.id.replace("importancia-", "");
            const texto = valor === "todas" ? "" : capitalizar(valor);
            tabla.column(6).search(texto).draw();
          });
        });

      document.querySelectorAll('input[name="urgencia"]').forEach((radio) => {
        radio.addEventListener("change", function () {
          const valor = this.id.replace("urgencia-", "");
          const texto = valor === "todas" ? "" : capitalizar(valor);
          tabla.column(7).search(texto).draw();
        });
      });

      function capitalizar(texto) {
        return texto.charAt(0).toUpperCase() + texto.slice(1);
      }
    },
  });

  const selectSprints = document.getElementById("numero_sprints");
  const inputFechaFin = document.getElementById("fecha_fin");

  selectSprints.addEventListener("focus", function () {
    sprintAnterior = this.value;
  });

  if (window.FECHA_FIN_PERIODO) {
    inputFechaFin.setAttribute("max", window.FECHA_FIN_PERIODO);
  }
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

document
  .querySelector("#formInsertarProyecto")
  .addEventListener("submit", async (e) => {
    e.preventDefault();
    const btnEnviar = document.querySelector(".btn-envNuevo") || e.submitter;
    btnEnviar.setAttribute("disabled", true);
    btnEnviar.innerText = "PROCESANDO...";

    const titulo = e.target.titulo.value;
    const tipo = e.target.tipo_proyecto.value;
    const periodo = e.target.periodo.value;
    const descripcion = e.target.descripcion.value;
    const fechaIni = e.target.fecha_inicio.value;
    const fechaFin = e.target.fecha_fin.value;
    const estatus = e.target.estatus.value;
    const importancia = e.target.importancia.value;
    const urgencia = e.target.urgencia.value;
    const grupos = Array.from(e.target.grupos_asignados.selectedOptions).map(
      (opt) => opt.value
    );
    const sprint_id = e.target.numero_sprints.value;

    const fechaInicioObj = new Date(fechaIni);
    const fechaFinObj = new Date(fechaFin);

    if (fechaFinObj <= fechaInicioObj) {
      mostrarError("La fecha fin debe ser mayor que la fecha inicio.");
      btnEnviar.removeAttribute("disabled");
      btnEnviar.innerText = "Guardar";
      return;
    }

    try {
      const response = await fetch(`${window.BASE_URL}proyectos/insertar`, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "X-Requested-With": "XMLHttpRequest",
        },
        body: JSON.stringify({
          titulo,
          tipo,
          periodo,
          descripcion,
          fecha_inicio: fechaIni,
          fecha_fin: fechaFin,
          estatus,
          importancia,
          urgencia,
          gruposJson: JSON.stringify(grupos),
          sprint_id: sprint_id,
        }),
      });

      const data = await response.json();

      if (response.ok && data.success) {
        Swal.fire({
          icon: "success",
          title: "¡Éxito!",
          text: "Proyecto insertado correctamente",
          timer: 2000,
          showConfirmButton: false,
        });

        const modalInstance = bootstrap.Modal.getInstance(
          document.getElementById("modalInsertarProyecto")
        );
        if (modalInstance) modalInstance.hide();

        setTimeout(() => {
          location.reload();
        }, 2000);
      } else {
        mostrarError(
          data.message || "Ocurrió un error al insertar el proyecto."
        );
      }
    } catch (error) {
      mostrarError(error.message);
    } finally {
      btnEnviar.removeAttribute("disabled");
      btnEnviar.innerText = "Guardar";
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

function setFechaFin() {
  const selectSprints = document.getElementById("numero_sprints");
  const numeroSprints = parseInt(selectSprints.value);
  const fechaInicio = document.getElementById("fecha_inicio").value;
  const fechaLimitePeriodo = new Date(window.FECHA_FIN_PERIODO);
  const inputFechaFin = document.getElementById("fecha_fin");

  if (!isNaN(numeroSprints) && fechaInicio) {
    const fechaIniObj = new Date(fechaInicio);
    const fechaFinObj = new Date(fechaIniObj);
    fechaFinObj.setMonth(fechaFinObj.getMonth() + numeroSprints);

    const fechaFinISO = fechaFinObj.toISOString().split("T")[0];
    const fechaLimiteISO = window.FECHA_FIN_PERIODO;

    if (fechaFinObj > fechaLimitePeriodo) {
      selectSprints.value = sprintAnterior;

      inputFechaFin.value = fechaFinISO;

      mostrarError(
        "La fecha final del proyecto supera la fecha límite del periodo. Selecciona un número de sprints menor."
      );
    } else {
      inputFechaFin.value = fechaFinISO;

      sprintAnterior = selectSprints.value;
    }

    inputFechaFin.setAttribute("max", fechaLimiteISO);
  }
}

document.querySelector(".table").addEventListener("click", (e) => {
  const btn = e.target.closest(".btn-outline-danger");
  if (btn) {
    const idProyecto = btn.dataset.id;
    cancelarProyecto(idProyecto);
  }
});

async function cancelarProyecto(idProyecto) {
  Swal.fire({
    title: "¿Estás seguro?",
    text: "¿Deseas cancelar este proyecto? Esta acción no se puede deshacer.",
    icon: "warning",
    showCancelButton: true,
    confirmButtonText: "Sí, cancelar",
    cancelButtonText: "Cancelar",
  }).then(async (result) => {
    if (result.isConfirmed) {
      try {
        const response = await fetch(
          `${window.BASE_URL}proyectos/eliminar/${idProyecto}`,
          {
            method: "POST",
            headers: {
              "Content-Type": "application/json",
              "X-Requested-With": "XMLHttpRequest",
            },
          }
        );

        const data = await response.json();

        if (response.ok && data.success) {
          Swal.fire({
            icon: "success",
            title: "¡Proyecto cancelado!",
            text: data.message || "El proyecto ha sido cancelado.",
            timer: 1500,
            showConfirmButton: false,
          });

          setTimeout(() => {
            location.reload();
          }, 1500);
        } else {
          Swal.fire({
            icon: "error",
            title: "Error",
            text: data.message || "No se pudo cancelar el proyecto.",
          });
        }
      } catch (error) {
        Swal.fire({
          icon: "error",
          title: "Error",
          text: error.message || "Error de red o del servidor.",
        });
      }
    }
  });
}

// Variables globales
let cargarSprintBacklog;
let avanzarTarea;
let cancelarTarea;

document.addEventListener("DOMContentLoaded", () => {
  const modal = document.getElementById("backlogModal");
  const tipoBacklog = document.getElementById("selectTipoBacklog");
  const selectSprint = document.getElementById("selectSprint");
  const selectStatus = document.getElementById("selectStatus");
  const contenedorTarjetas = document
    .getElementById("contenedorTarjetas")
    .querySelector(".row");
  const contenedorKanban = document.getElementById("contenedorKanban");

  const columnasKanban = {
    ToDo: contenedorKanban.querySelector(".todo"),
    "In Progress": contenedorKanban.querySelector(".inprogress"),
    "Code Review": contenedorKanban.querySelector(".review"),
    Done: contenedorKanban.querySelector(".done"),
  };

  let idProyecto = null;
  let tituloProyecto = "";
  const base = window.BASE_URL.endsWith("/")
    ? window.BASE_URL
    : window.BASE_URL + "/";

  function initTooltips(container) {
    const tooltipTriggerList = [
      ...container.querySelectorAll('[data-bs-toggle="tooltip"]'),
    ];
    tooltipTriggerList.forEach((el) => new bootstrap.Tooltip(el));
  }

  if (modal) {
    modal.addEventListener("show.bs.modal", function (event) {
      const button = event.relatedTarget;
      const mostrar = button?.getAttribute("data-mostrar");
      idProyecto = button?.getAttribute("data-id");
      tituloProyecto = button?.getAttribute("data-titulo");

      document.getElementById(
        "backlogModalLabel"
      ).textContent = `${idProyecto} - ${tituloProyecto}`;
      document.getElementById(
        "descripcionModalBacklog"
      ).textContent = `Historias de usuario asignadas en el proyecto ${tituloProyecto}`;

      if (mostrar === "p-backlog") {
        tipoBacklog.value = "Product Backlog";
        mostrarProductBacklog();
      } else if (mostrar === "s-backlog") {
        tipoBacklog.value = "Sprint Backlog";
        mostrarSprintBacklog();
      }
    });

    tipoBacklog.addEventListener("change", function () {
      if (this.value === "Sprint Backlog") {
        mostrarSprintBacklog();
      } else {
        mostrarProductBacklog();
      }
    });

    selectSprint.addEventListener("change", () => cargarSprintBacklog());
    selectStatus.addEventListener("change", () => cargarSprintBacklog());

    contenedorKanban.addEventListener("click", (e) => {
      const btn = e.target.closest(".btn-avanzar-tarea");
      const cancelarBtn = e.target.closest(".btn-outline-danger");
      if (btn) {
        const id = btn.dataset.id;
        const etapa = btn.dataset.etapa;
        avanzarTarea(id, etapa);
      } else if (cancelarBtn) {
        const idTarea = cancelarBtn.dataset.id;
        cancelarTarea(idTarea);
      }
    });

    contenedorTarjetas.addEventListener("click", (e) => {
      const btn = e.target.closest(".btn-outline-danger");
      if (btn) {
        const id = btn.dataset.id;
        cancelarTarea(id);
      }
    });

    async function mostrarSprintBacklog() {
      selectSprint.classList.remove("d-none");
      selectStatus.classList.remove("d-none");
      contenedorTarjetas.parentElement.classList.add("d-none");
      contenedorKanban.classList.remove("d-none");

      await cargarSprintsProyecto();
      cargarSprintBacklog();
    }

    async function cargarSprintsProyecto() {
      try {
        const response = await fetch(
          `${base}sprintbacklog/sprint/${idProyecto}`
        );
        const sprints = await response.json();

        selectSprint.innerHTML = "<option selected disabled>Sprint</option>";

        if (Array.isArray(sprints) && sprints.length > 0) {
          sprints.forEach((sprint) => {
            const option = document.createElement("option");
            option.value = sprint.Id;
            option.textContent = sprint.sprint;
            selectSprint.appendChild(option);
          });

          selectSprint.selectedIndex = 1;
        } else {
          const option = document.createElement("option");
          option.disabled = true;
          option.textContent = "No hay sprints";
          selectSprint.appendChild(option);
        }
      } catch (error) {
        console.error("Error cargando sprints:", error);
        selectSprint.innerHTML =
          "<option disabled selected>Error al cargar</option>";
      }
    }

    // Asignamos la función a la variable global
    cargarSprintBacklog = async function () {
      const idSprint = selectSprint.value;
      const idEtapa = selectStatus.value;

      if (!idProyecto || !idSprint || !idEtapa) return;

      Object.values(columnasKanban).forEach((col) => {
        col
          .querySelectorAll(".bg-white, .text-muted, .text-danger")
          .forEach((e) => e.remove());
      });

      try {
        const response = await fetch(
          `${base}sprintbacklog/traerPorSprintEtapa/${idProyecto}/${idEtapa}/${idSprint}`
        );
        if (!response.ok) throw new Error(`HTTP ${response.status}`);
        const tareas = await response.json();

        if (Array.isArray(tareas) && tareas.length > 0) {
          tareas.forEach((tarea, index) => {
            const etapa = tarea.etapa?.trim().toLowerCase();
            let columna = null;

            switch (etapa) {
              case "todo":
                columna = columnasKanban["ToDo"];
                break;
              case "en progreso":
              case "in progress":
                columna = columnasKanban["In Progress"];
                break;
              case "review":
              case "code review":
                columna = columnasKanban["Code Review"];
                break;
              case "done":
                columna = columnasKanban["Done"];
                break;
              default:
                columna = columnasKanban["ToDo"];
                break;
            }

            const tarjeta = document.createElement("div");
            tarjeta.className = "bg-white p-2 rounded mb-2 border";
            if (tarea.etapa_id !== 4) {
              tarjeta.innerHTML = `<div class="p-2 rounded shadow-sm mb-3 bg-white border">
              <div class="d-flex justify-content-between align-items-center mb-2">
                <strong>ID: ${tarea.Id}</strong>
                <div>
                  <button class="btn btn-sm btn-outline-danger rounded-pill me-2" data-bs-toggle="tooltip" data-id="${
                    tarea.Id
                  }" title="Eliminar">
                    <i class="fas fa-times"></i>
                  </button>
                  <button class="btn btn-sm btn-outline-primary rounded-pill me-2" data-bs-toggle="collapse" data-bs-target="#detalle${index}" aria-expanded="false" aria-controls="detalle${index}" title="Detalle">
                    <i class="fas fa-chevron-down"></i>
                  </button>
                  <button class="btn btn-sm btn-outline-primary rounded-pill btn-avanzar-tarea" data-id="${
                    tarea.Id
                  }" data-etapa="${
                tarea.etapa_id
              }" data-bs-toggle="tooltip" title="Avanzar">
                    <i class="fas fa-arrow-right"></i>
                  </button>
                </div>
              </div>
              <div>
                <b>Tarea:</b> ${tarea.nombre}<br>
                ${tarea.fecha_inicio} - ${tarea.fecha_fin}
              </div>
              <div class="mt-2 collapse" id="detalle${index}">
                <hr class="my-2">
                <b>Etapa:</b> ${tarea.etapa || "Sin asignar"}<br>
                <b>Creado Por:</b> ${tarea.CreadoPor || "Sin asignar"}<br>
                <b>Duración:</b> ${
                  tarea.duracion || "No especificada"
                } horas<br>
                <b>Cargo del Solicitante:</b> ${
                  tarea.cargo || "No especificado"
                }<br>
                <b>Estatus:</b> ${tarea.estatus || "No especificado"}<br>
                <b>Urgencia:</b> ${tarea.urgencia || "No especificado"}<br>
                <b>Complejidad:</b> ${
                  tarea.complejidad || "No especificado"
                }<br>
                <b>Modulo:</b> ${tarea.modulo || "No especificado"}<br>
                <b>Descripción:</b> ${
                  tarea.descripcion || "No especificado"
                }<br>
                <b>Observaciones:</b> ${
                  tarea.observaciones_tec || "No especificado"
                }<br>
                <b>Adicionales:</b> ${
                  tarea.adicionales || "No especificado"
                }<br>
                <b>Pruebas:</b> ${tarea.pruebas_unitarias || "No especificado"}
              </div>
            </div>`;
            } else {
              tarjeta.innerHTML = `<div class="p-2 rounded shadow-sm mb-3 bg-white border">
              <div class="d-flex justify-content-between align-items-center mb-2">
                <strong>ID: ${tarea.Id}</strong>
                <div>
                  <button class="btn btn-sm btn-outline-danger rounded-pill me-2" data-bs-toggle="tooltip" data-id="${
                    tarea.Id
                  }" title="Eliminar">
                    <i class="fas fa-times"></i>
                  </button>
                  <button class="btn btn-sm btn-outline-primary rounded-pill me-2" data-bs-toggle="collapse" data-bs-target="#detalle${index}" aria-expanded="false" aria-controls="detalle${index}" title="Detalle">
                    <i class="fas fa-chevron-down"></i>
                  </button>
                </div>
              </div>
              <div>
                <b>Tarea:</b> ${tarea.nombre}<br>
                ${tarea.fecha_inicio} - ${tarea.fecha_fin}
              </div>
              <div class="mt-2 collapse" id="detalle${index}">
                <hr class="my-2">
                <b>Etapa:</b> ${tarea.etapa || "Sin asignar"}<br>
                <b>Creado Por:</b> ${tarea.CreadoPor || "Sin asignar"}<br>
                <b>Duración:</b> ${
                  tarea.duracion || "No especificada"
                } horas<br>
                <b>Cargo del Solicitante:</b> ${
                  tarea.cargo || "No especificado"
                }<br>
                <b>Estatus:</b> ${tarea.estatus || "No especificado"}<br>
                <b>Urgencia:</b> ${tarea.urgencia || "No especificado"}<br>
                <b>Complejidad:</b> ${
                  tarea.complejidad || "No especificado"
                }<br>
                <b>Modulo:</b> ${tarea.modulo || "No especificado"}<br>
                <b>Descripción:</b> ${
                  tarea.descripcion || "No especificado"
                }<br>
                <b>Observaciones:</b> ${
                  tarea.observaciones_tec || "No especificado"
                }<br>
                <b>Adicionales:</b> ${
                  tarea.adicionales || "No especificado"
                }<br>
                <b>Pruebas:</b> ${tarea.pruebas_unitarias || "No especificado"}
              </div>
            </div>`;
            }

            columna.appendChild(tarjeta);
            initTooltips(tarjeta);
          });
        } else {
          const aviso = document.createElement("div");
          aviso.className = "text-muted text-center";
          aviso.textContent = "Sin tareas encontradas.";
          let destino;
          if (idEtapa === "1") {
            destino = columnasKanban["ToDo"];
          } else if (idEtapa === "2") {
            destino = columnasKanban["In Progress"];
          } else if (idEtapa === "3") {
            destino = columnasKanban["Code Review"];
          } else {
            destino = columnasKanban["Done"];
          }

          destino.appendChild(aviso);
        }
      } catch (error) {
        console.error("Error cargando Sprint Backlog:", error);
        const errorDiv = document.createElement("div");
        errorDiv.className = "text-danger text-center";
        errorDiv.textContent = "Error al cargar tareas.";
        columnasKanban["ToDo"].appendChild(errorDiv);
      }
    };

    async function mostrarProductBacklog() {
      selectSprint.classList.add("d-none");
      selectStatus.classList.add("d-none");
      contenedorTarjetas.parentElement.classList.remove("d-none");
      contenedorKanban.classList.add("d-none");

      contenedorTarjetas.innerHTML =
        '<div class="text-center">Cargando tareas...</div>';

      try {
        const response = await fetch(
          `${base}backlog/traerPorProyecto/${idProyecto}`
        );
        const tareas = await response.json();

        if (Array.isArray(tareas) && tareas.length > 0) {
          contenedorTarjetas.innerHTML = "";

          tareas.forEach((tarea, index) => {
            const tarjeta = `
              <div class="col-md-4">
                <div class="bg-done p-2 rounded shadow-sm">
                  <div class="bg-white p-2 rounded border">
                    <div class="d-flex justify-content-between align-items-center">
                      <div>
                        <strong>ID: ${tarea.Id}</strong><br>
                        <b>Tarea:</b> ${tarea.nombre}<br>
                        ${tarea.fecha_inicio} - ${tarea.fecha_fin}
                      </div>
                      <div class="btn-group">
                        <button class="btn btn-sm btn-outline-danger rounded-pill me-2" data-bs-toggle="tooltip" data-id="${
                          tarea.Id
                        }" title="Eliminar">
                          <i class="fas fa-times"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-primary rounded-pill" data-bs-toggle="collapse" data-bs-target="#detalle${index}" aria-expanded="false" aria-controls="detalle${index}" title="Detalle">
                          <i class="fas fa-chevron-down"></i>
                        </button>
                      </div>
                    </div>
                    <div class="collapse mt-2" id="detalle${index}">
                      <hr class="my-2">
                      <b>Etapa:</b> ${tarea.etapa || "Sin asignar"}<br>
                      <b>Creado Por:</b> ${tarea.CreadoPor || "Sin asignar"}<br>
                      <b>Duración:</b> ${
                        tarea.duracion || "No especificada"
                      } horas<br>
                      <b>Cargo del Solicitante:</b> ${
                        tarea.cargo || "No especificado"
                      }<br>
                      <b>Estatus:</b> ${tarea.estatus || "No especificado"}<br>
                      <b>Urgencia:</b> ${
                        tarea.urgencia || "No especificado"
                      }<br>
                      <b>Complejidad:</b> ${
                        tarea.complejidad || "No especificado"
                      }<br>
                      <b>Modulo:</b> ${tarea.modulo || "No especificado"}<br>
                      <b>Descripción:</b> ${
                        tarea.descripcion || "No especificado"
                      }<br>
                      <b>Observaciones:</b> ${
                        tarea.observaciones_tec || "No especificado"
                      }<br>
                      <b>Adicionales:</b> ${
                        tarea.adicionales || "No especificado"
                      }<br>
                      <b>Pruebas:</b> ${
                        tarea.pruebas_unitarias || "No especificado"
                      }
                    </div>
                  </div>
                </div>
              </div>`;
            contenedorTarjetas.insertAdjacentHTML("beforeend", tarjeta);
          });

          initTooltips(contenedorTarjetas);
        } else {
          contenedorTarjetas.innerHTML =
            '<div class="text-muted text-center">No se encontraron tareas.</div>';
        }
      } catch (error) {
        console.error("Error cargando tareas:", error);
        contenedorTarjetas.innerHTML =
          '<div class="text-danger text-center">Error al cargar las tareas.</div>';
      }
    }
  }
});

cancelarTarea = async function (idTarea) {
  Swal.fire({
    title: "¿Estás seguro?",
    text: "¿Deseas cancelar esta tarea? Esta acción no se puede deshacer.",
    icon: "warning",
    showCancelButton: true,
    confirmButtonText: "Sí, cancelar",
    cancelButtonText: "Cancelar",
  }).then(async (result) => {
    if (result.isConfirmed) {
      try {
        const response = await fetch(
          `${window.BASE_URL}sprintbacklog/cancelarTarea/${idTarea}`,
          {
            method: "POST",
            headers: {
              "Content-Type": "application/json",
              "X-Requested-With": "XMLHttpRequest",
            },
          }
        );

        const data = await response.json();

        if (response.ok && data.success) {
          Swal.fire({
            icon: "success",
            title: "¡Tarea cancelada!",
            text: data.message || "La tarea ha sido cancelada.",
            timer: 1500,
            showConfirmButton: false,
          });

          if (typeof cargarSprintBacklog === "function") {
            await cargarSprintBacklog();
          }
        } else {
          Swal.fire({
            icon: "error",
            title: "Error",
            text: data.message || "No se pudo cancelar la tarea.",
          });
        }
      } catch (error) {
        Swal.fire({
          icon: "error",
          title: "Error",
          text: error.message || "Error de red o del servidor.",
        });
      }
    }
  });
};

avanzarTarea = async function (idTarea, idEtapaActual) {
  Swal.fire({
    title: "¿Estás seguro?",
    text: "¿Deseas avanzar esta tarea al siguiente estado?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonText: "Sí, avanzar",
    cancelButtonText: "Cancelar",
  }).then(async (result) => {
    if (result.isConfirmed) {
      try {
        const response = await fetch(
          `${window.BASE_URL}sprintbacklog/avanzarTarea/${idTarea}/${idEtapaActual}`,
          {
            method: "POST",
            headers: {
              "Content-Type": "application/json",
              "X-Requested-With": "XMLHttpRequest",
            },
          }
        );

        const data = await response.json();

        if (response.ok && data.success) {
          Swal.fire({
            icon: "success",
            title: "¡Tarea avanzada!",
            text: data.message || "La tarea ha sido movida.",
            timer: 1500,
            showConfirmButton: false,
          });

          if (typeof cargarSprintBacklog === "function") {
            await cargarSprintBacklog();
          }
        } else {
          Swal.fire({
            icon: "error",
            title: "Error",
            text: data.message || "No se pudo avanzar la tarea.",
          });
        }
      } catch (error) {
        Swal.fire({
          icon: "error",
          title: "Error",
          text: error.message || "Error de red o del servidor.",
        });
      }
    }
  });
};
