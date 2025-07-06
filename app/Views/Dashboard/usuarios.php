<div class="p-3">



<div class="table-container text-center">                    
<table id="example" class="table table-striped text-center align-middle">
  <thead>
    <tr>
      <th>Nombre</th>
      <th>Email</th>
      <th>Teléfono</th>
      <th>Rol</th>
      <th>Acciones</th>
    </tr>
  </thead>
  <tbody>

    <?php
        if (!empty($usuarios)) {
          foreach($usuarios as $u) {
            echo '<tr>';
            echo '  <td>'.$u['nombre'].'</td>';
            echo '  <td>'.$u['email'].'</td>';
            echo '  <td>'.$u['telefono'].'</td>';
            echo '  <td>'.$u['rol'].'</td>';
            echo '  <td>';
            echo '    <button class="btn btn-sm btn-outline-primary rounded-pill me-1" data-bs-toggle="modal" data-bs-target="#modalInfoUsuario" data-id="'.$u['Id'].'" data-nombre="'.$u['nombre'].'" data-email="'.$u['email'].'" data-tel="'.$u['telefono'].'" data-rol="'.$u['rol'].'" data-mostrar="infoUser" title="Ver"><i class="fas fa-eye"></i></button>';
            echo '    <button class="btn btn-sm btn-outline-info rounded-pill me-1" data-bs-toggle="modal" data-bs-target="#modalInfoUsuario" data-id="'.$u['Id'].'" data-nombre="'.$u['nombre'].'" data-email="'.$u['email'].'" data-tel="'.$u['telefono'].'" data-rol="'.$u['rol'].'" data-mostrar="infoGroup" title="Grupo"><i class="fas fa-users"></i></button>';
            echo '    <button class="btn btn-sm btn-outline-danger rounded-pill" data-id="'.$u['Id'].'" title="Eliminar"><i class="fas fa-times"></i></button>';
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


