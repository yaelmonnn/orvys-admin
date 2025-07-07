new DataTable('#example', {
  language: {
    url: "http://localhost/orvys-admin/public/bootstrap/js/es-ES.json",
    search: "Buscar Proyecto:"
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
  const modal = document.getElementById("modalGrupoUsuarios");

  modal.addEventListener("show.bs.modal", async function (event) {
    const button = event.relatedTarget;

    const grupoId = button.getAttribute("data-id");
    const nombre = button.getAttribute("data-nombre");
    const departamento = button.getAttribute("data-dep");
    const experiencia = button.getAttribute("data-exp");

    // Mostrar datos básicos
    document.getElementById("grupoNombre").textContent = nombre || "—";
    document.getElementById("grupoDepartamento").textContent = departamento || "—";
    document.getElementById("grupoExperiencia").textContent = experiencia || "—";

    // Mostrar loading mientras trae usuarios
    const lista = document.getElementById("listaUsuariosGrupo");
    lista.innerHTML = '<li class="list-group-item text-muted">Cargando usuarios...</li>';

    try {
      const response = await fetch(`${window.BASE_URL}grupos/usuarios/${grupoId}`, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "X-Requested-With": "XMLHttpRequest",
        }
      });

      const data = await response.json();

      if (response.ok && data.success && Array.isArray(data.usuarios)) {
        if (data.usuarios.length === 0) {
          lista.innerHTML = '<li class="list-group-item text-muted">No hay usuarios en este grupo.</li>';
        } else {
          lista.innerHTML = "";
          data.usuarios.forEach(usuario => {
            const li = document.createElement("li");
            li.className = "list-group-item";
            li.textContent = usuario.nombre;
            lista.appendChild(li);
          });
        }
      } else {
        lista.innerHTML = '<li class="list-group-item text-danger">Error al cargar usuarios.</li>';
      }
    } catch (err) {
      lista.innerHTML = `<li class="list-group-item text-danger">Error de red: ${err.message}</li>`;
    }
  });
});

document.querySelector(".table").addEventListener("click", (e) => {
  const btn = e.target.closest(".btn-outline-danger");
  if (btn) {
    const idGrupo = btn.dataset.id;
    eliminarGrupo(idGrupo);
  }
});

async function eliminarGrupo(idGrupo) {
  Swal.fire({
    title: "¿Estás seguro?",
    text: "¿Deseas eliminar este grupo? Esta acción no se puede deshacer.",
    icon: "warning",
    showCancelButton: true,
    confirmButtonText: "Sí, cancelar",
    cancelButtonText: "Cancelar",
  }).then(async (result) => {
    if (result.isConfirmed) {
      try {
        const response = await fetch(
          `${window.BASE_URL}grupos/eliminar/${idGrupo}`,
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
            title: "¡Grupo cancelado!",
            text: data.message || "El Grupo ha sido cancelado.",
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
            text: data.message || "No se pudo cancelar el grupo.",
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
