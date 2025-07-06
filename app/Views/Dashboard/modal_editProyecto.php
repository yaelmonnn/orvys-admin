<div class="modal fade" id="modalEditarProyecto" tabindex="-1" aria-labelledby="modalEditarProyectoLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="modalEditarProyectoLabel">Editar Proyecto</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <form id="formEditarProyecto">
          <input type="hidden" name="proyecto_id" value="">

          <div class="mb-3">
            <label for="titulo" class="form-label">Título</label>
            <input type="text" class="form-control" id="titulo" name="titulo" value="Proyecto A">
          </div>

          <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea class="form-control" id="descripcion" name="descripcion" rows="3">Descripción del proyecto A</textarea>
          </div>

          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="tipo_id" class="form-label">Tipo</label>
              <select class="form-select" id="tipo_id" name="tipo_id">
                <?php
                    if (!empty($tipos)) {
                        foreach ($tipos as $tipo) {
                            echo '<option value="' . $tipo['Id'] . '">' . $tipo['tipo'] . '</option>';
                        }
                    }
                ?>
              </select>
            </div>
            <div class="col-md-6 mb-3">
              <label for="estatus_id" class="form-label">Estatus</label>
              <select class="form-select" id="estatus_id" name="estatus_id">
                <?php
                    if (!empty($estados)) {
                        foreach ($estados as $estado) {
                            echo '<option value="' . $estado['Id'] . '">' . $estado['estatus'] . '</option>';
                        }
                    }
                ?>
              </select>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="importancia_id" class="form-label">Importancia</label>
              <select class="form-select" id="importancia_id" name="importancia_id">
                <?php
                    if (!empty($importancias)) {
                        foreach ($importancias as $importancia) {
                            echo '<option value="' . $importancia['Id'] . '">' . $importancia['importancia'] . '</option>';
                        }
                    }
                ?>
              </select>
            </div>
            <div class="col-md-6 mb-3">
              <label for="urgencia_id" class="form-label">Urgencia</label>
              <select class="form-select" id="urgencia_id" name="urgencia_id">
                <?php
                    if (!empty($urgencias)) {
                        foreach ($urgencias as $urgencia) {
                            echo '<option value="' . $urgencia['Id'] . '">' . $urgencia['urgencia'] . '</option>';
                        }
                    }
                ?>
              </select>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="guardarEdicionProyecto()">Guardar cambios</button>
      </div>
    </div>
  </div>
</div>
