<div class="p-3">

<!-- Contenedor de filtros -->
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
</div>

<!-- Botón agregar en contenedor aparte alineado a la derecha -->
<div class="mb-3 text-end">
    <?php
      if ($rol['rol_id'] == 1) {
        echo '<button class="btn btn-agregar fw-bold rounded-pill shadow-sm text-white" data-bs-toggle="modal" data-bs-target="#modalInsertarProyecto">
            <i class="fas fa-plus me-2"></i> Agregar
        </button>';
      }
    ?>

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

        <?php
            if (!empty($proyectos)) {
                foreach($proyectos as $p) {
                    echo '<tr>';
                    echo '  <td>'.$p['Id'].'</td>';
                    echo '  <td>'.$p['titulo'].'</td>';
                    echo '  <td>'.$p['descripcion'].'</td>';
                    echo '  <td>'.$p['tipo'].'</td>';
                    echo '<td data-order="'.date('Y-m-d', strtotime($p['fecha_inicio'])).'">'.date('d/m/Y', strtotime($p['fecha_inicio'])).'</td>';
                    echo '<td data-order="'.date('Y-m-d', strtotime($p['fecha_fin'])).'">'.date('d/m/Y', strtotime($p['fecha_fin'])).'</td>';

                    echo '<td><span class="'.$p['htmlImp'].'">'.$p['importancia'].'</span></td>';

                    echo '<td><span class="'.$p['htmlUrg'].'">'.$p['urgencia'].'</span></td>';
 
                    echo '<td><span class="'.$p['htmlEst'].'">'.$p['estatus'].'</span></td>';
            
                    echo '  <td>';
                    echo '    <button class="btn btn-sm btn-outline-warning rounded-pill me-1" data-bs-toggle="tooltip" title="Editar"><i class="fas fa-edit"></i></button>';
                    echo '    <a href="'.base_url('tareas/'.$p['titulo'].'/'.$p['Id'].'').'"><button class="btn btn-sm btn-outline-secondary rounded-pill me-1" data-bs-toggle="tooltip" title="Agregar tareas"><i class="fas fa-bars"></i></button></a>';
                    echo '    <button class="btn btn-sm btn-outline-primary rounded-pill me-1" data-bs-toggle="modal" data-bs-target="#backlogModal" title="Ver Tareas"><i class="fas fa-eye"></i></button>';
                    echo '    <button class="btn btn-sm btn-outline-dark rounded-pill me-1" data-bs-toggle="modal" data-bs-target="#kanbanModal" title="Calendario"><i class="fas fa-calendar-alt"></i></button>';
                    echo '    <button class="btn btn-sm btn-outline-danger rounded-pill" data-bs-toggle="tooltip" title="Eliminar"><i class="fas fa-times"></i></button>';
                    echo '  </td>';



                    echo '</tr>';
                }
            }

        ?>
    </tbody>
</table>

    <div class="mt-4 text-center">
        <a href="javascript:history.back()" class="btn btn-outline-secondary rounded-pill shadow-sm">
            <i class="fas fa-arrow-left me-2"></i> Regresar
        </a>
    </div>

</div>



</div>


