<div class="p-3">




<div class="table-container text-center">                    
  <table id="example" class="table table-striped text-center align-middle">
  <thead>
    <tr>
      <th>Nombre Grupo</th>
      <th>Cargo</th>
      <th>Departamento</th>
      <th>Experiencia</th>
      <th>Acciones</th>
    </tr>
  </thead>
  <tbody>

    <?php

      if (!empty($grupos)) {
        foreach($grupos as $g) {
          echo '<tr>';
          echo '  <td>'.$g['grupo'].'</td>';
          echo '  <td>'.$g['cargo'].'</td>';
          echo '  <td>'.$g['departamento'].'</td>';
          echo '  <td>'.$g['experiencia'].'</td>';
          echo '  <td>';
          echo '    <button class="btn btn-sm btn-outline-primary rounded-pill me-1" data-bs-toggle="modal" data-bs-target="#modalGrupoUsuarios" data-id="'.$g['Id'].'" data-nombre="'.$g['grupo'].'" data-dep="'.$g['departamento'].'" data-exp="'.$g['experiencia'].'" title="Ver"><i class="fas fa-eye"></i></button>';
          echo '    <button class="btn btn-sm btn-outline-danger rounded-pill" data-id="'.$g['Id'].'" title="Eliminar"><i class="fas fa-times"></i></button>';
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


