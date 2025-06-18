<div class="modal fade" id="modalPeriodo" tabindex="-1" aria-labelledby="modalPeriodoLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered rounded-4 overflow-hidden">
    <div class="modal-content rounded-4 shadow">
      <div class="modal-header border-0">
        <h5 class="modal-title w-100 text-center fw-bold fs-4" id="modalPeriodoLabel">Periodo</h5>
        <button type="button" class="btn-close position-absolute end-0 me-3" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body px-4">
        <!-- Campo Periodo -->
        <div class="mb-3 row align-items-center">
          <label for="nombrePeriodo" class="col-sm-4 col-form-label fw-bold fs-5">Periodo:</label>
          <div class="col-sm-8">
            <input type="text" class="form-control rounded-pill fs-5 fw-semibold" id="nombrePeriodo" value="2025-A">
          </div>
        </div>
        <!-- Campo Fecha de inicio -->
        <div class="mb-3 row align-items-center">
          <label for="fechaInicio" class="col-sm-4 col-form-label fw-bold fs-5">Fecha de inicio:</label>
          <div class="col-sm-8">
            <input type="date" class="form-control rounded-pill fs-5 fw-semibold" id="fechaInicio">
          </div>
        </div>
        <!-- Campo Fecha de término -->
        <div class="mb-3 row align-items-center">
          <label for="fechaFin" class="col-sm-4 col-form-label fw-bold fs-5">Fecha de término:</label>
          <div class="col-sm-8">
            <input type="date" class="form-control rounded-pill fs-5 fw-semibold" id="fechaFin">
          </div>
        </div>
        <!-- Botón Guardar -->
        <div class="text-center mt-4">
          <button type="button" class="btn btn-guardar px-4 py-2 rounded-pill fw-bold fs-5">Guardar</button>
        </div>
      </div>
    </div>
  </div>
</div>