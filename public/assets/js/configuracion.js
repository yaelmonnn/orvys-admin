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


function guardarHorarioSesion() {
  const horaInicio = document.getElementById("hora_inicio").value;
  const horaFin = document.getElementById("hora_fin").value;

  if (!horaInicio || !horaFin) {
    Swal.fire("Campos requeridos", "Debes ingresar ambas horas.", "warning");
    return;
  }

  if (horaInicio >= horaFin) {
    Swal.fire("Rango inválido", "La hora de inicio debe ser menor que la hora de fin.", "error");
    return;
  }

  const datos = {
    hora_inicio: horaInicio,
    hora_fin: horaFin
  };

  fetch(`${window.BASE_URL}configuracion/guardarHorario`, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
      "X-Requested-With": "XMLHttpRequest"
    },
    body: JSON.stringify(datos)
  })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        Swal.fire("Horario guardado", "La configuración fue actualizada correctamente.", "success");
      } else {
        Swal.fire("Error", data.message || "No se pudo guardar la configuración.", "error");
      }
    })
    .catch(error => {
      console.error("Error:", error);
      Swal.fire("Error", "Hubo un problema al conectar con el servidor.", "error");
    });
}



