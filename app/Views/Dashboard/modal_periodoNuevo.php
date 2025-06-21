<!-- Modal -->
<div class="modal fade" id="modalInsertarPeriodo" tabindex="-1" aria-labelledby="modalInsertarPeriodoLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content rounded-4 shadow">
      <div class="modal-header bg-primary text-white rounded-top">
        <h5 class="modal-title" id="modalInsertarPeriodoLabel">Nuevo Periodo</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <form id="formInsertarPeriodo">
          <div class="row g-3">
            <div class="col-md-4">
              <label for="periodo" class="form-label fw-bold">Periodo</label>
              <input type="text" class="form-control" id="periodo" name="periodo" required>
            </div>
            <div class="col-md-3">
              <label for="fecha_inicio" class="form-label fw-bold">Fecha Inicio</label>
              <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" required>
            </div>
            <div class="col-md-3">
              <label for="fecha_fin" class="form-label fw-bold">Fecha Fin</label>
              <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" required>
            </div>
            <div class="col-md-6">
              <label for="estatus" class="form-label fw-bold">Estatus</label>
              <select class="form-select" id="estatus" name="estatus" required>
                <option value="">Selecciona un estatus</option>
                <?php
                  if (!empty($estados)) {
                      foreach($estados as $e) {
                        echo '<option value="'.$e['estatus'].'">'.$e['estatus'].'</option>';
                      }
                  }
                ?>
              </select>
            </div>
          </div>
          <div class="mt-4 text-end">
            <button type="submit" class="btn btn-success btn-envNuevo">Guardar</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
