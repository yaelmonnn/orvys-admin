<div class="p-3">

<div class="d-flex justify-content-end align-items-center mb-3 flex-wrap">
  <div class="mt-2 mt-sm-0">
    <button class="btn btn-agregar fw-bold rounded-pill shadow-sm text-white" data-bs-toggle="modal" data-bs-target="#modalInsertarPeriodo">
      <i class="fas fa-plus me-2"></i> Agregar
    </button>
  </div>
</div>



<div class="table-container text-center">                    
  <table id="example" class="table table-striped text-center align-middle">
    <thead>
      <tr>
        <th style="width: 5%;">Seleccionar</th>
        <th>Periodo</th>
        <th>Fecha Inicio</th>
        <th>Fecha Fin</th>
        <th>Estatus</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>

      <?php
          if (!empty($periodos)) {
              foreach($periodos as $p) {
                echo '<tr>';
                echo '  <td>';
                echo '<input 
                        type="checkbox" 
                        class="form-check-input" 
                        data-bs-toggle="modal" 
                        data-bs-target="#' . ($p['Id'] == $periodoSelect ? 'confirmarDeseleccionModal' : 'modalPeriodo') . '"  
                        data-id="' . $p['Id'] . '"
                        data-periodo="' . $p['periodo'] . '" 
                        data-fecha-inicio="' . $p['fecha_inicio'] . '" 
                        data-fecha-fin="' . $p['fecha_fin'] . '" ' 
                        . ($p['Id'] == $periodoSelect ? 'checked' : '') . 
                      '/>';
                echo '  </td>';
                echo '  <td>'.$p['periodo'].'</td>';
                echo '<td data-order="'.date('Y-m-d', strtotime($p['fecha_inicio'])).'">'.date('d/m/Y', strtotime($p['fecha_inicio'])).'</td>';
                echo '<td data-order="'.date('Y-m-d', strtotime($p['fecha_fin'])).'">'.date('d/m/Y', strtotime($p['fecha_fin'])).'</td>';


                $estatus = $p['estatus'];
                switch ($estatus) {
                  case 'Activo':
                    echo '<td><span class="badge bg-success">'.$p['estatus'].'</span></td>';
                    break;
                  case 'En Progreso':
                    echo '<td><span class="badge bg-warning text-dark">'.$p['estatus'].'</span></td>';
                    break;
                  case 'Planificado':
                    echo '<td><span class="badge bg-info text-dark">'.$p['estatus'].'</span></td>';
                    break;
                  case 'Completado':
                    echo '<td><span class="badge bg-secondary">'.$p['estatus'].'</span></td>';
                    break;
                  default:
                    echo '<td><span class="badge bg-danger">'.$p['estatus'].'</span></td>';
                    break;
                }
                echo '  <td>';
                echo '    <button class="btn btn-sm btn-outline-primary rounded-pill me-1" title="Ver"><i class="fas fa-eye" data-bs-toggle="modal" data-bs-target="#kanbanModal"></i></button>';
                echo '    <button class="btn btn-sm btn-outline-warning rounded-pill me-1" title="Editar"><i class="fas fa-edit"></i></button>';
                echo '    <button class="btn btn-sm btn-outline-info rounded-pill me-1" title="Ubicación"><i class="fas fa-map-marker-alt"></i></button>';
                echo '    <button class="btn btn-sm btn-outline-secondary rounded-pill me-1" title="Cambiar"><i class="fas fa-exchange-alt"></i></button>';
                echo '    <button class="btn btn-sm btn-outline-dark rounded-pill me-1" title="Calendario"><i class="fas fa-calendar-alt"></i></button>';
                echo '    <button class="btn btn-sm btn-outline-danger rounded-pill me-1" title="Alerta"><i class="fas fa-bell"></i></button>';
                echo '    <button class="btn btn-sm btn-outline-danger rounded-pill" title="Eliminar"><i class="fas fa-times"></i></button>';
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


