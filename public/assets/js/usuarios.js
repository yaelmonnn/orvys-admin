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
