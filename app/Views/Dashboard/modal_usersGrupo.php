<div class="modal fade" id="modalGrupoUsuarios" tabindex="-1" aria-labelledby="modalGrupoUsuariosLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="modalGrupoUsuariosLabel">Información del Grupo</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <!-- Col izquierda: datos del grupo -->
          <div class="col-md-4 border-end">
            <h6 class="fw-bold mb-3">Grupo</h6>
            <p><strong>Nombre:</strong> <span id="grupoNombre">---</span></p>
            <p><strong>Departamento:</strong> <span id="grupoDepartamento">---</span></p>
            <p><strong>Experiencia:</strong> <span id="grupoExperiencia">---</span></p>
          </div>

          <!-- Col derecha: usuarios del grupo -->
          <div class="col-md-8">
            <h6 class="fw-bold mb-3">Usuarios del Grupo</h6>
            <ul class="list-group" id="listaUsuariosGrupo">
              <li class="list-group-item text-muted">Cargando usuarios...</li>
            </ul>
          </div>
        </div>
      </div>
      <div class="modal-footer py-2">
        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
