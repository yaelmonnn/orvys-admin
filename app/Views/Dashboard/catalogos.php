<div class="p-3">


<div class="table-container text-center">                    
<table id="example" class="table table-striped text-center align-middle">
  <thead>
    <tr>
      <th>#</th>
      <th>Catálogo</th>
      <th>Fecha de creación</th>
      <th>Fecha de modificación</th>
      <th>Acciones</th>
    </tr>
  </thead>
  <tbody>
    <?php 
      if (!empty($catalogos)) {
        foreach($catalogos as $c) {
          echo '<tr>';
          echo '  <td>'.$c['Id'].'</td>';
          echo '  <td>'.$c['catalogo'].'</td>';
          
          
          echo '  <td data-order="'.date('Y-m-d', strtotime($c['fr'])).'">'.date('d/m/Y', strtotime($c['fr'])).'</td>';
          echo '  <td data-order="'.date('Y-m-d', strtotime($c['fm'])).'">'.date('d/m/Y', strtotime($c['fm'])).'</td>';

          echo '  <td>';
          echo '    <button class="btn btn-sm btn-outline-primary rounded-pill me-1" title="Ver"><i class="fas fa-eye"></i></button>';

          if ($rol['rol_id'] == 1) {
            echo '    <button class="btn btn-sm btn-outline-warning rounded-pill me-1" title="Editar"><i class="fas fa-edit"></i></button>';
          }
          if ($rol['rol_id'] == 1) {
            echo '    <button class="btn btn-sm btn-outline-danger rounded-pill" title="Eliminar"><i class="fas fa-times"></i></button>';
          }

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


