new DataTable("#example", {
  language: {
    url: "http://localhost/orvys-admin/public/bootstrap/js/es-ES.json",
    search: "Buscar Periodo:",
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
    // Estiliza botones exportación
    $(".dt-buttons .dt-button").each(function () {
      $(this).addClass("shadow-sm");
      $(this).removeClass("dt-button");
    });

    // Tooltips
    const tooltipTriggerList = [].slice.call(
      document.querySelectorAll('[data-bs-toggle="tooltip"], [title]')
    );
    tooltipTriggerList.forEach(function (tooltipTriggerEl) {
      new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Alineación de encabezados y celdas
    $("#example thead th, #example tbody td").css({
      "text-align": "center",
      "vertical-align": "middle",
    });

    // Checkbox personalizado
    $('#example tbody input[type="checkbox"]').css({
      width: "22px",
      height: "22px",
      display: "block",
      margin: "0 auto",
      cursor: "pointer",
    });
  },
});

document.addEventListener("DOMContentLoaded", () => {
  const modal = document.getElementById("modalPeriodo");
  const modalConfirmarDeseleccion = document.getElementById("confirmarDeseleccionModal");
  let checkboxRelacionado = null;
  let guardado = false;
  let esDeseleccion = false;
  let esReemplazo = false;
  let estadoOriginalCheckbox = false;
  let checkboxDeseleccion = null; 

  if (modal) {
    modal.addEventListener("show.bs.modal", function (event) {
      checkboxRelacionado = event.relatedTarget;
      guardado = false;
      esDeseleccion = false;
      esReemplazo = false;

      if (!checkboxRelacionado) return;

      const idPeriodo = checkboxRelacionado.getAttribute("data-id") || "";
      const periodo = checkboxRelacionado.getAttribute("data-periodo") || "";
      const fechaIni = checkboxRelacionado.getAttribute("data-fecha-inicio") || "";
      const fechaFin = checkboxRelacionado.getAttribute("data-fecha-fin") || "";

      esDeseleccion = window.PERIODO_SESION_ID === idPeriodo;
      esReemplazo = window.PERIODO_SESION_ID && window.PERIODO_SESION_ID !== idPeriodo;

      if (esDeseleccion) {
        estadoOriginalCheckbox = true;
      } else if (esReemplazo) {
        estadoOriginalCheckbox = false;
      } else {
        estadoOriginalCheckbox = false;
      }

      document.getElementById("idPeriodo").value = idPeriodo;
      document.getElementById("nombrePeriodo").value = periodo;
      document.getElementById("fechaInicio").value = fechaIni;
      document.getElementById("fechaFin").value = fechaFin;

      const btnGuardar = modal.querySelector(".btn-guardar");
      if (btnGuardar) {
        btnGuardar.textContent = esDeseleccion
          ? "Deseleccionar periodo"
          : (window.PERIODO_SESION_ID ? "Seleccionar periodo" : "Seleccionar periodo");
      }
    });

    modal.addEventListener("hide.bs.modal", function () {
      if (!guardado && checkboxRelacionado) {
        checkboxRelacionado.checked = estadoOriginalCheckbox;
      }
      
      checkboxRelacionado = null;
      esDeseleccion = false;
      esReemplazo = false;
      estadoOriginalCheckbox = false;
    });

    const btnGuardar = modal.querySelector(".btn-guardar");
    if (btnGuardar) {
      btnGuardar.addEventListener("click", () => {
        guardado = true;
        const idPeriodoNuevo = document.getElementById("idPeriodo").value;
        const periodo = document.getElementById("nombrePeriodo").value.trim();
        const fechaFin = document.getElementById("fechaFin").value;
        const modalInstance = bootstrap.Modal.getInstance(modal);
        if (modalInstance) modalInstance.hide();

        if (!idPeriodoNuevo) {
          mostrarError("No hay periodo seleccionado");
          return;
        }

        if (esDeseleccion) {
          fetch(`${window.BASE_URL}periodos/reset`, {
            method: "POST",
            headers: {
              "Content-Type": "application/x-www-form-urlencoded",
              "X-Requested-With": "XMLHttpRequest",
            },
            body: new URLSearchParams({ idPeriodo: idPeriodoNuevo, periodo: periodo, fechaFin: fechaFin}),
          })
            .then((res) => res.json())
            .then((data) => {
              if (data.success) {
                Swal.fire({
                  icon: "success",
                  title: "Periodo deseleccionado con éxito",
                  showConfirmButton: false,
                  timer: 1500,
                }).then(() => window.location.reload());
              } else {
                mostrarError("Error al deseleccionar el periodo");
              }
            })
            .catch((err) => {
              mostrarError("Error en la comunicación con el servidor");
              console.error(err);
            });
        } else if (
          window.PERIODO_SESION_ID &&
          window.PERIODO_SESION_ID !== idPeriodoNuevo
        ) {
          fetch(`${window.BASE_URL}periodos/reset`, {
            method: "POST",
            headers: {
              "Content-Type": "application/x-www-form-urlencoded",
              "X-Requested-With": "XMLHttpRequest",
            },
            body: new URLSearchParams({ idPeriodo: window.PERIODO_SESION_ID, periodo: periodo, fechaFin: fechaFin }),
          })
            .then((res) => res.json())
            .then((data) => {
              if (data.success) {
                seleccionarPeriodo(idPeriodoNuevo, periodo, fechaFin);
              } else {
                mostrarError("Error al deseleccionar el periodo anterior");
              }
            })
            .catch((err) => {
              mostrarError("Error al intentar reemplazar el periodo");
              console.error(err);
            });
        } else {
          seleccionarPeriodo(idPeriodoNuevo, periodo, fechaFin);
        }
      });
    }
  }

  function seleccionarPeriodo(idPeriodo, periodo, fechaFin) {
    fetch(`${window.BASE_URL}periodos/seleccionar`, {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
        "X-Requested-With": "XMLHttpRequest",
      },
      body: new URLSearchParams({ idPeriodo, periodo, fechaFin }),
    })
      .then((res) => res.json())
      .then((data) => {
        if (data.success) {
          Swal.fire({
            icon: "success",
            title: "¡Periodo seleccionado con éxito!",
            showConfirmButton: false,
            timer: 1500,
          }).then(() => window.location.reload());
        } else {
          mostrarError("Error al guardar el periodo seleccionado");
        }
      })
      .catch((err) => {
        mostrarError("Error en la comunicación con el servidor");
        console.error(err);
      });
  }

  if (modalConfirmarDeseleccion) {
    modalConfirmarDeseleccion.addEventListener("show.bs.modal", function (event) {
      checkboxDeseleccion = event.relatedTarget;
    });

    modalConfirmarDeseleccion.addEventListener("hide.bs.modal", function () {
      if (checkboxDeseleccion && !guardado) {
        checkboxDeseleccion.checked = true;
      }
      checkboxDeseleccion = null;
      guardado = false;
    });

    const btnConfirmarDeseleccion = document.getElementById("btnConfirmarDeseleccion");
    if (btnConfirmarDeseleccion) {
      btnConfirmarDeseleccion.addEventListener("click", () => {
        if (!checkboxDeseleccion) return;

        const idPeriodo = checkboxDeseleccion.getAttribute("data-id");
        const periodo = checkboxDeseleccion.getAttribute("data-periodo");
        const fechaFin = checkboxDeseleccion.getAttribute("data-fecha-fin");
        guardado = true;
        
        const modalInstance = bootstrap.Modal.getInstance(modalConfirmarDeseleccion);
        if (modalInstance) modalInstance.hide();

  
        fetch(`${window.BASE_URL}periodos/reset`, {
          method: "POST",
          headers: {
            "Content-Type": "application/x-www-form-urlencoded",
            "X-Requested-With": "XMLHttpRequest",
          },
          body: new URLSearchParams({ idPeriodo, periodo, fechaFin }),
        })
          .then((res) => res.json())
          .then((data) => {
            if (data.success) {
              Swal.fire({
                icon: "success",
                title: "Periodo deseleccionado con éxito",
                showConfirmButton: false,
                timer: 1500,
              }).then(() => window.location.reload());
            } else {
              mostrarError("Error al deseleccionar el periodo");
            }
          })
          .catch((err) => {
            mostrarError("Error en la comunicación con el servidor");
            console.error(err);
          });
      });
    }
  }

  const sidebar = document.getElementById("sidebar");
  const toggleBtn = document.getElementById("toggleSidebar");

  if (sidebar && toggleBtn) {
    toggleBtn.addEventListener("click", () => {
      sidebar.classList.toggle("collapsed");

      if (sidebar.classList.contains("collapsed")) {
        const submenus = document.querySelectorAll(".sidebar-submenu");
        submenus.forEach((sub) => sub.classList.remove("show"));
      }

      const tooltipTriggerList = [].slice.call(
        document.querySelectorAll("[title]")
      );
      tooltipTriggerList.forEach((el) => new bootstrap.Tooltip(el));
    });

    document.querySelectorAll(".sidebar-link").forEach((link) => {
      link.addEventListener("click", (e) => {
        if (sidebar.classList.contains("collapsed")) {
          e.preventDefault();
          sidebar.classList.remove("collapsed");

          const tooltipTriggerList = [].slice.call(
            document.querySelectorAll("[title]")
          );
          tooltipTriggerList.forEach((el) => new bootstrap.Tooltip(el));
        }
      });
    });
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

document.querySelector('#formInsertarPeriodo').addEventListener('submit', async (e) => {
  e.preventDefault();

  const btnEnviar = document.querySelector('.btn-envNuevo') || e.submitter;
  btnEnviar.setAttribute('disabled', true);
  btnEnviar.innerText = 'PROCESANDO...';

  const periodo = e.target.periodo.value;
  const fecha_inicio = e.target.fecha_inicio.value;
  const fecha_fin = e.target.fecha_fin.value;
  const estatus = e.target.estatus.value;

  const fechaInicioObj = new Date(fecha_inicio);
  const fechaFinObj = new Date(fecha_fin);

  if (fechaFinObj <= fechaInicioObj) {
    mostrarError('La fecha fin debe ser mayor que la fecha inicio.');
    btnEnviar.removeAttribute('disabled');
    btnEnviar.innerText = 'Guardar';
    return;
  }

  try {
    const response = await fetch(`${window.BASE_URL}periodos/insertar`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-Requested-With': 'XMLHttpRequest'
      },
      body: JSON.stringify({
        periodo,
        fecha_inicio,
        fecha_fin,
        estatus
      })
    });

    const data = await response.json();

    if (response.ok && data.success) {
      Swal.fire({
        icon: 'success',
        title: '¡Éxito!',
        text: data.message || 'Periodo insertado correctamente',
        timer: 2000,
        showConfirmButton: false
      });

      const modalInstance = bootstrap.Modal.getInstance(document.getElementById('modalInsertarPeriodo'));
      if (modalInstance) modalInstance.hide();

      setTimeout(() => {
        location.reload();
      }, 2000);
    } else {
      mostrarError(data.message || 'Ocurrió un error al insertar el periodo.');
    }
  } catch (error) {
    mostrarError(error.message);
  } finally {
    btnEnviar.removeAttribute('disabled');
    btnEnviar.innerText = 'Guardar';
  }
});

document.addEventListener("DOMContentLoaded", () => {
  const modal = document.getElementById("modalProyectosPorPeriodo");
  const tablaBody = modal.querySelector("tbody");

  document.querySelectorAll(".ver-proyectos").forEach(btn => {
    btn.addEventListener("click", async (e) => {
      const periodoId = btn.getAttribute("data-id");
      tablaBody.innerHTML = '<tr><td colspan="9">Cargando...</td></tr>';

      try {
        const response = await fetch(`${window.BASE_URL}proyectos/traerPorPeriodo/${periodoId}`);
        const data = await response.json();

        if (response.ok && Array.isArray(data) && data.length > 0) {
          tablaBody.innerHTML = "";

          data.forEach(p => {
            const fila = `
              <tr>
                <td>${p.Id}</td>
                <td>${p.titulo}</td>
                <td>${p.descripcion}</td>
                <td>${p.tipo}</td>
                <td>${new Date(p.fecha_inicio).toLocaleDateString()}</td>
                <td>${new Date(p.fecha_fin).toLocaleDateString()}</td>
                <td>${p.importancia}</td>
                <td>${p.urgencia}</td>
                <td>${p.estatus}</td>
              </tr>
            `;
            tablaBody.insertAdjacentHTML("beforeend", fila);
          });
        } else {
          tablaBody.innerHTML = '<tr><td colspan="9">No se encontraron proyectos.</td></tr>';
        }
      } catch (err) {
        tablaBody.innerHTML = '<tr><td colspan="9">Error al cargar los proyectos.</td></tr>';
        console.error(err);
      }
    });
  });
});

document.querySelector(".table").addEventListener("click", (e) => {
  const btn = e.target.closest(".btn-outline-danger");
  if (btn) {
    const idPeriodo = btn.dataset.id;
    cancelarPeriodo(idPeriodo);
  }
});

async function cancelarPeriodo(idPeriodo) {
  Swal.fire({
    title: "¿Estás seguro?",
    text: "¿Deseas cancelar este periodo? Esta acción no se puede deshacer.",
    icon: "warning",
    showCancelButton: true,
    confirmButtonText: "Sí, cancelar",
    cancelButtonText: "Cancelar",
  }).then(async (result) => {
    if (result.isConfirmed) {
      try {
        const response = await fetch(
          `${window.BASE_URL}periodos/eliminar/${idPeriodo}`,
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
            title: "¡Periodo cancelado!",
            text: data.message || "El Periodo ha sido cancelado.",
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
            text: data.message || "No se pudo cancelar el periodo.",
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

