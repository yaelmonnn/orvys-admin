<div class="modal fade" id="modalInfoUsuario" tabindex="-1" aria-labelledby="modalInfoUsuarioLabel" aria-hidden="true">
  <div class="modal-dialog modal-md modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="modalInfoUsuarioLabel">Información del Usuario</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">

        <!-- Select siempre visible arriba -->
        <div class="mb-3">
          <label for="opcionesVista" class="form-label fw-semibold">Ver:</label>
          <select class="form-select" id="opcionesVista">
            <option value="info" selected>Datos del Usuario</option>
            <option value="grupos">Grupos</option>
          </select>
        </div>

        <!-- Sección de datos del usuario -->
        <div id="infoUsuario">
          <p><strong>Nombre:</strong> <span id="usuarioNombre">Juan Pérez</span></p>
          <p><strong>Email:</strong> <span id="usuarioEmail">juan@example.com</span></p>
          <p><strong>Teléfono:</strong> <span id="usuarioTelefono">555-123-4567</span></p>
          <p><strong>Rol:</strong> <span id="usuarioRol">Administrador</span></p>
        </div>

        <!-- Sección de grupos (oculta por defecto) -->
        <div id="seccionGrupos" class="d-none">
          <h6>Grupos a los que pertenece:</h6>
          <ul class="list-group">
            <li class="list-group-item">Grupo Desarrollo</li>
            <li class="list-group-item">Grupo QA</li>
            <li class="list-group-item">Administradores</li>
          </ul>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
