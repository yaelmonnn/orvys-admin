<div class="modal fade" id="backlogModal" tabindex="-1" aria-labelledby="backlogModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content rounded-4">
      <div class="modal-header bg-light">
        <h5 class="modal-title fw-bold" id="backlogModalLabel"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>

      <div class="modal-body">
        <!-- Selects -->
        <div class="d-flex flex-wrap align-items-center mb-4">
          <p class="mb-0 me-3" id="descripcionModalBacklog"></p>

          <select class="form-select rounded-pill me-2" id="selectTipoBacklog" style="width: 200px;">
            <option selected>Product Backlog</option>
            <option>Sprint Backlog</option>
          </select>

          <select class="form-select rounded-pill me-2 d-none" id="selectSprint" style="width: 150px;">

          </select>

          <select class="form-select rounded-pill d-none" id="selectStatus" style="width: 150px;">
            <?php
              if(!empty($etapas)) {
                foreach ($etapas as $etapa) {
                  echo '<option value="'.$etapa['Id'].'">'.$etapa['etapa'].'</option>';
                }
              } 
            ?>
          </select>
        </div>

        <!-- Contenedor tarjetas tradicionales -->
        <div class="container-fluid" id="contenedorTarjetas">
          <div class="row g-3">

          </div>
        </div>

        <!-- Contenedor KANBAN -->
        <div id="contenedorKanban" class="kanban-scroll d-flex flex-nowrap gap-3 pb-3 d-none" style="max-height: 340px;">
          <!-- To Do -->
          <div class="flex-shrink-0 p-2 rounded shadow-sm todo" style="min-width: 250px;">
            <h6 class="text-center fw-bold bg-todo p-2">To Do</h6>
          </div>

          <!-- In Progress -->
          <div class="flex-shrink-0 p-2 rounded shadow-sm inprogress" style="min-width: 250px;">
            <h6 class="text-center fw-bold bg-inprogress p-2">In Progress</h6>
          </div>

          <!-- Code Review -->
          <div class="flex-shrink-0 p-2 rounded shadow-sm review" style="min-width: 250px;">
            <h6 class="text-center fw-bold bg-review p-2">Code Review</h6>
          </div>

          <!-- Done -->
          <div class="flex-shrink-0 p-2 rounded shadow-sm done" style="min-width: 250px;">
            <h6 class="text-center fw-bold bg-done p-2">Done</h6>
          </div>
        </div>

      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

