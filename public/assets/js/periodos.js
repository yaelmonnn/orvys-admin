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
  const modalReset = document.getElementById("confirmarDeseleccionModal");
  let checkboxRelacionado = null;
  let guardado = false;

  if (modal) {
    modal.addEventListener("show.bs.modal", function (event) {
      checkboxRelacionado = event.relatedTarget;
      guardado = false;

      if (!checkboxRelacionado) return;

      const idPeriodo = checkboxRelacionado.getAttribute("data-id") || "";

      if (window.PERIODO_SESION_ID && idPeriodo !== window.PERIODO_SESION_ID) {
        mostrarError(
          "Ya existe un periodo seleccionado. Deselecciónalo primero."
        );
        event.preventDefault();
        checkboxRelacionado.checked = false;
        return;
      }

      const periodo = checkboxRelacionado.getAttribute("data-periodo") || "";
      const fechaIni =
        checkboxRelacionado.getAttribute("data-fecha-inicio") || "";
      const fechaFin = checkboxRelacionado.getAttribute("data-fecha-fin") || "";

      document.getElementById("idPeriodo").value = idPeriodo;
      document.getElementById("nombrePeriodo").value = periodo;
      document.getElementById("fechaInicio").value = fechaIni;
      document.getElementById("fechaFin").value = fechaFin;
    });

    modal.addEventListener("hide.bs.modal", function () {
      if (!guardado && checkboxRelacionado) {
        checkboxRelacionado.checked = false;
      }
      checkboxRelacionado = null;
    });

    const btnGuardar = modal.querySelector(".btn-guardar");
    if (btnGuardar) {
      btnGuardar.addEventListener("click", () => {
        guardado = true;
        const modalInstance = bootstrap.Modal.getInstance(modal);
        if (modalInstance) modalInstance.hide();
      });
    }
  }

  if (modalReset) {
    modalReset.addEventListener("show.bs.modal", function (event) {
      checkboxRelacionado = event.relatedTarget;
      guardado = false;
    });

    modalReset.addEventListener("hide.bs.modal", function () {
      if (!guardado && checkboxRelacionado) {
        checkboxRelacionado.checked = true;
      }
      checkboxRelacionado = null;
    });

    const btnConfirmar = modalReset.querySelector(".btn-confirmar-reset");
    if (btnConfirmar) {
      btnConfirmar.addEventListener("click", () => {
        guardado = true;
        const idPeriodo = checkboxRelacionado?.getAttribute("data-id");

        fetch(`${window.BASE_URL}periodos/reset`, {
          method: "POST",
          headers: {
            "Content-Type": "application/x-www-form-urlencoded",
            "X-Requested-With": "XMLHttpRequest",
          },
          body: new URLSearchParams({ idPeriodo }),
        })
          .then((res) => res.json())
          .then((data) => {
            if (data.success) {
              Swal.fire({
                icon: "success",
                title: "Periodo deseleccionado con éxito",
                showConfirmButton: false,
                timer: 1500,
              }).then(() => {
                const modalInstance = bootstrap.Modal.getInstance(modalReset);
                if (modalInstance) modalInstance.hide();
                window.location.reload();
              });
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

document.querySelector("#btn-modal-guardar").addEventListener("click", (e) => {
  e.preventDefault();
  const idPeriodo = document.getElementById("idPeriodo").value;
  if (!idPeriodo) {
    mostrarError("No hay periodo seleccionado");
    return;
  }

  fetch(`${window.BASE_URL}periodos/seleccionar`, {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
      "X-Requested-With": "XMLHttpRequest",
    },
    body: new URLSearchParams({ idPeriodo: idPeriodo }),
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        Swal.fire({
          icon: "success",
          title: "¡Periodo seleccionado con éxito!",
          showConfirmButton: false,
          timer: 1500,
        }).then(() => {
          const modal = document.getElementById("modalPeriodo");
          const modalInstance = bootstrap.Modal.getInstance(modal);
          if (modalInstance) modalInstance.hide();
          window.location.reload();
        });
      } else {
        mostrarError("Error al guardar el periodo seleccionado");
      }
    })
    .catch((err) => {
      mostrarError("Error en la comunicación con el servidor");
      console.error(err);
    });
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

