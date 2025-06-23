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


      document
        .querySelectorAll('input[name="urgencia"]')
        .forEach((radio) => {
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
