<div class="p-3">

<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
  <div class="d-flex align-items-center flex-wrap gap-4">
    <div class="d-flex align-items-center flex-wrap">
      <label class="fw-bold me-3 mb-0">Filtrar por importancia:</label>
      <div class="d-flex align-items-center flex-wrap gap-2">
        <input type="radio" class="btn-check" name="importancia" id="importancia-alta" autocomplete="off">
        <label class="btn btn-outline-danger btn-sm rounded-pill" for="importancia-alta">Alta</label>

        <input type="radio" class="btn-check" name="importancia" id="importancia-media" autocomplete="off">
        <label class="btn btn-outline-warning btn-sm rounded-pill" for="importancia-media">Media</label>

        <input type="radio" class="btn-check" name="importancia" id="importancia-baja" autocomplete="off">
        <label class="btn btn-outline-success btn-sm rounded-pill" for="importancia-baja">Baja</label>

        <input type="radio" class="btn-check" name="importancia" id="importancia-todas" autocomplete="off" checked>
        <label class="btn btn-outline-secondary btn-sm rounded-pill" for="importancia-todas">Todas</label>
      </div>
    </div>

    <div class="d-flex align-items-center flex-wrap">
      <label class="fw-bold me-3 mb-0">Filtrar por urgencia:</label>
      <div class="d-flex align-items-center flex-wrap gap-2">
        <input type="radio" class="btn-check" name="urgencia" id="urgencia-critico" autocomplete="off">
        <label class="btn btn-outline-danger btn-sm rounded-pill" for="urgencia-critico">Crítico</label>

        <input type="radio" class="btn-check" name="urgencia" id="urgencia-alto" autocomplete="off">
        <label class="btn btn-sm rounded-pill btn-urgencia-alto" for="urgencia-alto">Alto</label>

        <input type="radio" class="btn-check" name="urgencia" id="urgencia-medio" autocomplete="off">
        <label class="btn btn-sm rounded-pill btn-urgencia-medio" for="urgencia-medio">Medio</label>

        <input type="radio" class="btn-check" name="urgencia" id="urgencia-bajo" autocomplete="off">
        <label class="btn btn-outline-success btn-sm rounded-pill" for="urgencia-bajo">Bajo</label>

        <input type="radio" class="btn-check" name="urgencia" id="urgencia-informativo" autocomplete="off">
        <label class="btn btn-sm rounded-pill btn-urgencia-informativo" for="urgencia-informativo">Informativo</label>

        <input type="radio" class="btn-check" name="urgencia" id="urgencia-todas" autocomplete="off" checked>
        <label class="btn btn-outline-secondary btn-sm rounded-pill" for="urgencia-todas">Todas</label>
      </div>
    </div>
  </div>

<div class="mt-2 mt-sm-0">
  <button class="btn btn-agregar fw-bold rounded-pill shadow-sm text-white">
    <i class="fas fa-plus me-2"></i> Agregar
  </button>
</div>
</div>


    <div class="table-container">                    
<table id="example" class="table table-striped text-center align-middle">
    <thead>
        <tr>
            <th style="width: 5%;">ID</th>
            <th>Título</th>
            <th>Descripción</th>
            <th style="width: 2%;">Tipo</th>
            <th>Fecha Inicio</th>
            <th>Fecha Fin</th>
            <th>Importancia</th>
            <th>Urgencia</th>
            <th>Estatus</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>1</td>
            <td>Sistema de Gestión</td>
            <td>Automatización de procesos internos</td>
            <td>Interno</td>
            <td>2024-01-15</td>
            <td>2024-06-30</td>
            <td><span class="badge bg-danger rounded-pill">Alta</span></td>
            <td><span class="badge bg-danger rounded-pill">Crítico</span></td>
            <td><span class="badge bg-success">Activo</span></td>
            <td>
                <button class="btn btn-sm btn-outline-primary rounded-pill me-1"><i class="fas fa-eye"></i></button>
                <button class="btn btn-sm btn-outline-warning rounded-pill me-1"><i class="fas fa-edit"></i></button>
                <button class="btn btn-sm btn-outline-info rounded-pill me-1"><i class="fas fa-map-marker-alt"></i></button>
                <button class="btn btn-sm btn-outline-secondary rounded-pill me-1"><i class="fas fa-exchange-alt"></i></button>
                <button class="btn btn-sm btn-outline-dark rounded-pill me-1"><i class="fas fa-calendar-alt"></i></button>
                <button class="btn btn-sm btn-outline-danger rounded-pill me-1"><i class="fas fa-bell"></i></button>
                <button class="btn btn-sm btn-outline-danger rounded-pill"><i class="fas fa-times"></i></button>
            </td>
        </tr>
        <tr>
            <td>2</td>
            <td>Portal Web Corporativo</td>
            <td>Renovación del sitio institucional</td>
            <td>Corporativo</td>
            <td>2024-02-01</td>
            <td>2024-08-15</td>
            <td><span class="badge bg-warning text-dark rounded-pill">Media</span></td>
            <td><span class="badge bg-warning text-dark rounded-pill">Alta</span></td>
            <td><span class="badge bg-warning text-dark">En Progreso</span></td>
            <td>
                <button class="btn btn-sm btn-outline-primary rounded-pill me-1"><i class="fas fa-eye"></i></button>
                <button class="btn btn-sm btn-outline-warning rounded-pill me-1"><i class="fas fa-edit"></i></button>
                <button class="btn btn-sm btn-outline-info rounded-pill me-1"><i class="fas fa-map-marker-alt"></i></button>
                <button class="btn btn-sm btn-outline-secondary rounded-pill me-1"><i class="fas fa-exchange-alt"></i></button>
                <button class="btn btn-sm btn-outline-dark rounded-pill me-1"><i class="fas fa-calendar-alt"></i></button>
                <button class="btn btn-sm btn-outline-danger rounded-pill me-1"><i class="fas fa-bell"></i></button>
                <button class="btn btn-sm btn-outline-danger rounded-pill"><i class="fas fa-times"></i></button>
            </td>
        </tr>
        <tr>
            <td>3</td>
            <td>App Mobile</td>
            <td>Aplicación móvil para clientes</td>
            <td>Cliente</td>
            <td>2024-03-10</td>
            <td>2024-09-30</td>
            <td><span class="badge bg-danger rounded-pill">Alta</span></td>
            <td><span class="badge bg-warning rounded-pill">Media</span></td>
            <td><span class="badge bg-info text-dark">Planificado</span></td>
            <td>
                <button class="btn btn-sm btn-outline-primary rounded-pill me-1"><i class="fas fa-eye"></i></button>
                <button class="btn btn-sm btn-outline-warning rounded-pill me-1"><i class="fas fa-edit"></i></button>
                <button class="btn btn-sm btn-outline-info rounded-pill me-1"><i class="fas fa-map-marker-alt"></i></button>
                <button class="btn btn-sm btn-outline-secondary rounded-pill me-1"><i class="fas fa-exchange-alt"></i></button>
                <button class="btn btn-sm btn-outline-dark rounded-pill me-1"><i class="fas fa-calendar-alt"></i></button>
                <button class="btn btn-sm btn-outline-danger rounded-pill me-1"><i class="fas fa-bell"></i></button>
                <button class="btn btn-sm btn-outline-danger rounded-pill"><i class="fas fa-times"></i></button>
            </td>
        </tr>
        <tr>
            <td>4</td>
            <td>Sistema de Inventario</td>
            <td>Control de stock y almacén</td>
            <td>Interno</td>
            <td>2024-01-20</td>
            <td>2024-07-20</td>
            <td><span class="badge bg-success rounded-pill">Baja</span></td>
            <td><span class="badge bg-info text-dark rounded-pill">Informativo</span></td>
            <td><span class="badge bg-secondary">Pausado</span></td>
            <td>
                <button class="btn btn-sm btn-outline-primary rounded-pill me-1"><i class="fas fa-eye"></i></button>
                <button class="btn btn-sm btn-outline-warning rounded-pill me-1"><i class="fas fa-edit"></i></button>
                <button class="btn btn-sm btn-outline-info rounded-pill me-1"><i class="fas fa-map-marker-alt"></i></button>
                <button class="btn btn-sm btn-outline-secondary rounded-pill me-1"><i class="fas fa-exchange-alt"></i></button>
                <button class="btn btn-sm btn-outline-dark rounded-pill me-1"><i class="fas fa-calendar-alt"></i></button>
                <button class="btn btn-sm btn-outline-danger rounded-pill me-1"><i class="fas fa-bell"></i></button>
                <button class="btn btn-sm btn-outline-danger rounded-pill"><i class="fas fa-times"></i></button>
            </td>
        </tr>
        <tr>
            <td>5</td>
            <td>Plataforma E-learning</td>
            <td>Capacitación en línea</td>
            <td>Educativo</td>
            <td>2023-09-01</td>
            <td>2024-01-31</td>
            <td><span class="badge bg-warning text-dark rounded-pill">Media</span></td>
            <td><span class="badge bg-warning rounded-pill">Media</span></td>
            <td><span class="badge bg-success">Completado</span></td>
            <td>
                <button class="btn btn-sm btn-outline-primary rounded-pill me-1"><i class="fas fa-eye"></i></button>
                <button class="btn btn-sm btn-outline-warning rounded-pill me-1"><i class="fas fa-edit"></i></button>
                <button class="btn btn-sm btn-outline-info rounded-pill me-1"><i class="fas fa-map-marker-alt"></i></button>
                <button class="btn btn-sm btn-outline-secondary rounded-pill me-1"><i class="fas fa-exchange-alt"></i></button>
                <button class="btn btn-sm btn-outline-dark rounded-pill me-1"><i class="fas fa-calendar-alt"></i></button>
                <button class="btn btn-sm btn-outline-danger rounded-pill me-1"><i class="fas fa-bell"></i></button>
                <button class="btn btn-sm btn-outline-danger rounded-pill"><i class="fas fa-times"></i></button>
            </td>
        </tr>
                <tr>
            <td>6</td>
            <td>Rediseño de Marca</td>
            <td>Actualizar identidad visual de la empresa</td>
            <td>Corporativo</td>
            <td>2024-05-01</td>
            <td>2024-10-15</td>
            <td><span class="badge bg-warning text-dark rounded-pill">Media</span></td>
            <td><span class="badge bg-danger rounded-pill">Crítico</span></td>
            <td><span class="badge bg-info text-dark">Planificado</span></td>
            <td>
                <button class="btn btn-sm btn-outline-primary rounded-pill me-1"><i class="fas fa-eye"></i></button>
                <button class="btn btn-sm btn-outline-warning rounded-pill me-1"><i class="fas fa-edit"></i></button>
                <button class="btn btn-sm btn-outline-info rounded-pill me-1"><i class="fas fa-map-marker-alt"></i></button>
                <button class="btn btn-sm btn-outline-secondary rounded-pill me-1"><i class="fas fa-exchange-alt"></i></button>
                <button class="btn btn-sm btn-outline-dark rounded-pill me-1"><i class="fas fa-calendar-alt"></i></button>
                <button class="btn btn-sm btn-outline-danger rounded-pill me-1"><i class="fas fa-bell"></i></button>
                <button class="btn btn-sm btn-outline-danger rounded-pill"><i class="fas fa-times"></i></button>
            </td>
        </tr>
        <tr>
            <td>7</td>
            <td>API de Integración</td>
            <td>Conexión con servicios externos</td>
            <td>Tecnología</td>
            <td>2024-04-10</td>
            <td>2024-09-01</td>
            <td><span class="badge bg-danger rounded-pill">Alta</span></td>
            <td><span class="badge bg-warning text-dark rounded-pill">Alta</span></td>
            <td><span class="badge bg-warning text-dark">En Progreso</span></td>
            <td>
                <button class="btn btn-sm btn-outline-primary rounded-pill me-1"><i class="fas fa-eye"></i></button>
                <button class="btn btn-sm btn-outline-warning rounded-pill me-1"><i class="fas fa-edit"></i></button>
                <button class="btn btn-sm btn-outline-info rounded-pill me-1"><i class="fas fa-map-marker-alt"></i></button>
                <button class="btn btn-sm btn-outline-secondary rounded-pill me-1"><i class="fas fa-exchange-alt"></i></button>
                <button class="btn btn-sm btn-outline-dark rounded-pill me-1"><i class="fas fa-calendar-alt"></i></button>
                <button class="btn btn-sm btn-outline-danger rounded-pill me-1"><i class="fas fa-bell"></i></button>
                <button class="btn btn-sm btn-outline-danger rounded-pill"><i class="fas fa-times"></i></button>
            </td>
        </tr>
        <tr>
            <td>8</td>
            <td>Migración a la Nube</td>
            <td>Transición de infraestructura a servicios cloud</td>
            <td>Tecnología</td>
            <td>2024-03-05</td>
            <td>2024-11-10</td>
            <td><span class="badge bg-danger rounded-pill">Alta</span></td>
            <td><span class="badge bg-info rounded-pill">Media</span></td>
            <td><span class="badge bg-secondary">Pausado</span></td>
            <td>
                <button class="btn btn-sm btn-outline-primary rounded-pill me-1"><i class="fas fa-eye"></i></button>
                <button class="btn btn-sm btn-outline-warning rounded-pill me-1"><i class="fas fa-edit"></i></button>
                <button class="btn btn-sm btn-outline-info rounded-pill me-1"><i class="fas fa-map-marker-alt"></i></button>
                <button class="btn btn-sm btn-outline-secondary rounded-pill me-1"><i class="fas fa-exchange-alt"></i></button>
                <button class="btn btn-sm btn-outline-dark rounded-pill me-1"><i class="fas fa-calendar-alt"></i></button>
                <button class="btn btn-sm btn-outline-danger rounded-pill me-1"><i class="fas fa-bell"></i></button>
                <button class="btn btn-sm btn-outline-danger rounded-pill"><i class="fas fa-times"></i></button>
            </td>
        </tr>
        <tr>
            <td>9</td>
            <td>Gestión de Reclutamiento</td>
            <td>Plataforma de selección de personal</td>
            <td>RH</td>
            <td>2024-06-01</td>
            <td>2024-12-15</td>
            <td><span class="badge bg-warning text-dark rounded-pill">Media</span></td>
            <td><span class="badge bg-success rounded-pill">Baja</span></td>
            <td><span class="badge bg-info text-dark">Planificado</span></td>
            <td>
                <button class="btn btn-sm btn-outline-primary rounded-pill me-1"><i class="fas fa-eye"></i></button>
                <button class="btn btn-sm btn-outline-warning rounded-pill me-1"><i class="fas fa-edit"></i></button>
                <button class="btn btn-sm btn-outline-info rounded-pill me-1"><i class="fas fa-map-marker-alt"></i></button>
                <button class="btn btn-sm btn-outline-secondary rounded-pill me-1"><i class="fas fa-exchange-alt"></i></button>
                <button class="btn btn-sm btn-outline-dark rounded-pill me-1"><i class="fas fa-calendar-alt"></i></button>
                <button class="btn btn-sm btn-outline-danger rounded-pill me-1"><i class="fas fa-bell"></i></button>
                <button class="btn btn-sm btn-outline-danger rounded-pill"><i class="fas fa-times"></i></button>
            </td>
        </tr>
        <tr>
            <td>10</td>
            <td>Sistema de Tickets</td>
            <td>Gestión de incidencias TI</td>
            <td>Soporte</td>
            <td>2024-02-20</td>
            <td>2024-08-05</td>
            <td><span class="badge bg-danger rounded-pill">Alta</span></td>
            <td><span class="badge bg-warning text-dark rounded-pill">Alta</span></td>
            <td><span class="badge bg-warning text-dark">En Progreso</span></td>
            <td>
                <button class="btn btn-sm btn-outline-primary rounded-pill me-1"><i class="fas fa-eye"></i></button>
                <button class="btn btn-sm btn-outline-warning rounded-pill me-1"><i class="fas fa-edit"></i></button>
                <button class="btn btn-sm btn-outline-info rounded-pill me-1"><i class="fas fa-map-marker-alt"></i></button>
                <button class="btn btn-sm btn-outline-secondary rounded-pill me-1"><i class="fas fa-exchange-alt"></i></button>
                <button class="btn btn-sm btn-outline-dark rounded-pill me-1"><i class="fas fa-calendar-alt"></i></button>
                <button class="btn btn-sm btn-outline-danger rounded-pill me-1"><i class="fas fa-bell"></i></button>
                <button class="btn btn-sm btn-outline-danger rounded-pill"><i class="fas fa-times"></i></button>
            </td>
        </tr>
        <tr>
            <td>11</td>
            <td>Automatización de Nómina</td>
            <td>Procesamiento automático de pagos</td>
            <td>Finanzas</td>
            <td>2024-04-15</td>
            <td>2024-10-31</td>
            <td><span class="badge bg-warning text-dark rounded-pill">Media</span></td>
            <td><span class="badge bg-info text-dark rounded-pill">Media</span></td>
            <td><span class="badge bg-secondary">Pausado</span></td>
            <td>
                <button class="btn btn-sm btn-outline-primary rounded-pill me-1"><i class="fas fa-eye"></i></button>
                <button class="btn btn-sm btn-outline-warning rounded-pill me-1"><i class="fas fa-edit"></i></button>
                <button class="btn btn-sm btn-outline-info rounded-pill me-1"><i class="fas fa-map-marker-alt"></i></button>
                <button class="btn btn-sm btn-outline-secondary rounded-pill me-1"><i class="fas fa-exchange-alt"></i></button>
                <button class="btn btn-sm btn-outline-dark rounded-pill me-1"><i class="fas fa-calendar-alt"></i></button>
                <button class="btn btn-sm btn-outline-danger rounded-pill me-1"><i class="fas fa-bell"></i></button>
                <button class="btn btn-sm btn-outline-danger rounded-pill"><i class="fas fa-times"></i></button>
            </td>
        </tr>
        <tr>
            <td>12</td>
            <td>Dashboard Gerencial</td>
            <td>Panel de indicadores clave</td>
            <td>Gerencial</td>
            <td>2024-01-05</td>
            <td>2024-07-31</td>
            <td><span class="badge bg-danger rounded-pill">Alta</span></td>
            <td><span class="badge bg-warning rounded-pill">Media</span></td>
            <td><span class="badge bg-success">Activo</span></td>
            <td>
                <button class="btn btn-sm btn-outline-primary rounded-pill me-1"><i class="fas fa-eye"></i></button>
                <button class="btn btn-sm btn-outline-warning rounded-pill me-1"><i class="fas fa-edit"></i></button>
                <button class="btn btn-sm btn-outline-info rounded-pill me-1"><i class="fas fa-map-marker-alt"></i></button>
                <button class="btn btn-sm btn-outline-secondary rounded-pill me-1"><i class="fas fa-exchange-alt"></i></button>
                <button class="btn btn-sm btn-outline-dark rounded-pill me-1"><i class="fas fa-calendar-alt"></i></button>
                <button class="btn btn-sm btn-outline-danger rounded-pill me-1"><i class="fas fa-bell"></i></button>
                <button class="btn btn-sm btn-outline-danger rounded-pill"><i class="fas fa-times"></i></button>
            </td>
        </tr>

    </tbody>
</table>
</div>

</div>


