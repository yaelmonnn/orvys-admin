new DataTable('#example', {
  language: {
    url: "http://localhost/orvys-admin/public/bootstrap/js/es-ES.json",
    search: "Buscar Usuario:" 
  },
  layout: {
    topStart: {
      buttons: [
        {
          extend: 'copyHtml5',
          text: '<i class="fas fa-copy me-1"></i>',
          className: 'dt-button btn btn-sm btn-outline-secondary me-2',
          titleAttr: 'Copiar datos al portapapeles'
        },
        {
          extend: 'excelHtml5',
          text: '<i class="fas fa-file-excel me-1"></i>',
          className: 'dt-button btn btn-sm btn-success me-2',
          titleAttr: 'Exportar a Excel'
        },
        {
          extend: 'csvHtml5',
          text: '<i class="fas fa-file-csv me-1"></i>',
          className: 'dt-button btn btn-sm btn-info me-2',
          titleAttr: 'Exportar a CSV'
        },
        {
          extend: 'pdfHtml5',
          text: '<i class="fas fa-file-pdf me-1"></i>',
          className: 'dt-button btn btn-sm btn-danger',
          titleAttr: 'Exportar a PDF'
        }
      ]
    }
  },
initComplete: function () {
  $('.dt-buttons .dt-button').each(function () {
    $(this).addClass('shadow-sm');
    $(this).removeClass('dt-button');
  });

  var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"], [title]'))
  tooltipTriggerList.forEach(function (tooltipTriggerEl) {
    new bootstrap.Tooltip(tooltipTriggerEl)
  });


  $('#example thead th').css({
    'text-align': 'center',
    'vertical-align': 'middle'
  });
  $('#example tbody td').css({
    'text-align': 'center',
    'vertical-align': 'middle'
  });


  $('#example tbody input[type="checkbox"]').css({
    'width': '22px',
    'height': '22px',
    'display': 'block',
    'margin': '0 auto',
    'cursor': 'pointer'
  });
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


document.addEventListener("DOMContentLoaded", () => {
  const selectVista = document.getElementById("opcionesVista");
  const infoUsuario = document.getElementById("infoUsuario");
  const seccionGrupos = document.getElementById("seccionGrupos");
  const listaGrupos = seccionGrupos.querySelector("ul");
  let usuarioIdActual = null; 

  const mostrarVista = async (vista) => {
    if (vista === "grupos") {
      infoUsuario.classList.add("d-none");
      seccionGrupos.classList.remove("d-none");
      selectVista.value = "grupos";

      if (usuarioIdActual) {
        try {

          listaGrupos.innerHTML = `<li class="list-group-item text-muted">Cargando...</li>`;

          const response = await fetch(`${window.BASE_URL}usuarios/grupos/${usuarioIdActual}`, {
            method: "POST",
            headers: {
              "Content-Type": "application/json",
              "X-Requested-With": "XMLHttpRequest"
            }
          });

          const data = await response.json();

          if (response.ok && data.success) {
            if (data.grupos.length > 0) {
              listaGrupos.innerHTML = "";
              data.grupos.forEach(grupo => {
                const li = document.createElement("li");
                li.className = "list-group-item";
                li.textContent = grupo.grupo;
                listaGrupos.appendChild(li);
              });
            } else {
              listaGrupos.innerHTML = `<li class="list-group-item text-muted">No pertenece a ningún grupo.</li>`;
            }
          } else {
            listaGrupos.innerHTML = `<li class="list-group-item text-danger">Error al cargar grupos.</li>`;
          }
        } catch (error) {
          listaGrupos.innerHTML = `<li class="list-group-item text-danger">Error de red: ${error.message}</li>`;
        }
      }
    } else {
      seccionGrupos.classList.add("d-none");
      infoUsuario.classList.remove("d-none");
      selectVista.value = "info";
    }
  };


  selectVista.addEventListener("change", () => {
    mostrarVista(selectVista.value);
  });


  const modal = document.getElementById("modalInfoUsuario");
  modal.addEventListener("show.bs.modal", function (event) {
    const button = event.relatedTarget;

    const nombre = button.getAttribute("data-nombre") || "";
    const email = button.getAttribute("data-email") || "";
    const telefono = button.getAttribute("data-tel") || "";
    const rol = button.getAttribute("data-rol") || "";
    usuarioIdActual = button.getAttribute("data-id") || null;

    document.getElementById("usuarioNombre").textContent = nombre;
    document.getElementById("usuarioEmail").textContent = email;
    document.getElementById("usuarioTelefono").textContent = telefono;
    document.getElementById("usuarioRol").textContent = rol;

    const vistaInicial = button.getAttribute("data-mostrar") === "infoGroup" ? "grupos" : "info";
    mostrarVista(vistaInicial);
  });
});

document.querySelector(".table").addEventListener("click", (e) => {
  const btn = e.target.closest(".btn-outline-danger");
  if (btn) {
    const idUsuario = btn.dataset.id;
    eliminarUsuario(idUsuario);
  }
});

async function eliminarUsuario(idUsuario) {
  Swal.fire({
    title: "¿Estás seguro?",
    text: "¿Deseas eliminar este usuario? Esta acción no se puede deshacer.",
    icon: "warning",
    showCancelButton: true,
    confirmButtonText: "Sí, cancelar",
    cancelButtonText: "Cancelar",
  }).then(async (result) => {
    if (result.isConfirmed) {
      try {
        const response = await fetch(
          `${window.BASE_URL}usuarios/eliminar/${idUsuario}`,
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
            title: "¡Usuario cancelado!",
            text: data.message || "El Usuario ha sido cancelado.",
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
            text: data.message || "No se pudo cancelar el usuario.",
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

