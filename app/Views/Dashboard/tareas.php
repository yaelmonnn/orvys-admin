<div class="p-3">
  <div class="card shadow-sm rounded-4">
    <div class="card-body">

      <!-- Título del proyecto -->
      <h4 class="fw-bold text-center text-primary mb-4">Proyecto: Gestión de Tareas de Desarrollo</h4>

      <!-- Navegación de Secciones -->
      <ul class="nav nav-pills nav-justified mb-4" id="wizardNav">
        <li class="nav-item">
          <button class="nav-link active" data-step="1">1. Historia de Usuario</button>
        </li>
        <li class="nav-item">
          <button class="nav-link" data-step="2">2. Detalles Técnicos</button>
        </li>
        <li class="nav-item">
          <button class="nav-link" data-step="3">3. Confirmación</button>
        </li>
      </ul>

      <!-- Contenido del Wizard -->
      <div id="wizardContent">
        <!-- Paso 1 -->
        <div class="wizard-step" data-step="1">
        <h5 class="fw-bold mb-3">Historia de Usuario</h5>

        <div class="row g-3">
            <div class="col-md-6">
            <label class="form-label">1. Nombre de la Historia</label>
            <input type="text" class="form-control rounded-pill">
            </div>

            <div class="col-md-6">
            <label class="form-label">2. Cargo de quien lo solicitó</label>
            <select class="form-select rounded-pill">
                <option selected disabled>Seleccione un cargo</option>
                <option value="Analista">Analista</option>
                <option value="Coordinador">Coordinador</option>
                <option value="Director">Director</option>
                <option value="Gerente">Gerente</option>
                <option value="Otro">Otro</option>
            </select>
            </div>

            <div class="col-md-6">
            <label class="form-label">3. Nivel de Urgencia</label>
            <select class="form-select rounded-pill">
                <option>Alta</option>
                <option>Media</option>
                <option>Baja</option>
            </select>
            </div>

            <div class="col-md-6">
            <label class="form-label">4. Nivel de Complejidad</label>
            <select class="form-select rounded-pill">
                <option>Alta</option>
                <option>Media</option>
                <option>Baja</option>
            </select>
            </div>

            <div class="col-md-6">
            <label class="form-label">5. Fecha de Registro</label>
            <input type="date" class="form-control rounded-pill" value="<?= date('Y-m-d') ?>">
            </div>

            <div class="col-md-6">
            <label class="form-label">6. Descripción</label>
            <textarea class="form-control rounded-4" rows="3"></textarea>
            </div>
        </div>
        </div>



        <!-- Paso 2 -->
        <div class="wizard-step d-none" data-step="2">
        <h5 class="fw-bold mb-3">Detalles Técnicos</h5>

        <div class="row g-3">
            <div class="col-md-6">
            <label class="form-label">1. Módulo Relacionado</label>
            <input type="text" class="form-control rounded-pill" placeholder="Ej. Autenticación, Reportes">
            </div>

            <div class="col-md-6">
            <label class="form-label">2. Duración estimada (horas)</label>
            <input type="number" class="form-control rounded-pill" min="1" placeholder="Ej. 6">
            </div>

            <div class="col-md-6">
            <label class="form-label">3. Fecha límite de entrega</label>
            <input type="date" class="form-control rounded-pill">
            </div>

            <div class="col-md-6">
            <label class="form-label">4. Estatus de la tarea</label>
            <select class="form-select rounded-pill">
                <option selected disabled>Seleccione un estatus</option>
                <option value="backlog">Backlog</option>
                <option value="todo">To Do</option>
                <option value="in_progress">In Progress</option>
                <option value="done">Done</option>
                <option value="blocked">Blocked</option>
            </select>
            </div>

            <div class="col-md-6">
            <label class="form-label">5. Sprint asignado</label>
            <select class="form-select rounded-pill">
                <option selected disabled>Seleccione un Sprint</option>
                <option value="Sprint 1">Sprint 1</option>
                <option value="Sprint 2">Sprint 2</option>
                <option value="Sprint 3">Sprint 3</option>
                <option value="Sprint 4">Sprint 4</option>
                <option value="Sprint 5">Sprint 5</option>
            </select>
            </div>

            <div class="col-md-6">
            <label class="form-label">6. Observaciones Técnicas</label>
            <textarea class="form-control rounded-4" rows="3" placeholder="Tecnologías, dependencias, riesgos..."></textarea>
            </div>

            <div class="col-md-6">
            <label class="form-label">7. Comentarios adicionales</label>
            <textarea class="form-control rounded-4" rows="3" placeholder="Comentarios generales del equipo o PO..."></textarea>
            </div>

            <div class="col-md-6">
            <label class="form-label">8. Pruebas unitarias requeridas</label>
            <textarea class="form-control rounded-4" rows="3" placeholder="Describe qué debe probarse: validaciones, flujo de datos, errores esperados..."></textarea>
            </div>
        </div>
        </div>




        <!-- Paso 3 -->
        <div class="wizard-step d-none" data-step="3">
          <h5 class="fw-bold mb-3">Confirmación</h5>
          <p>Revisa los datos antes de guardar la tarea.</p>
          <ul class="list-group rounded-4 shadow-sm">
            <li class="list-group-item">Nombre de Historia: <strong>...</strong></li>
            <li class="list-group-item">Nivel de Urgencia: <strong>...</strong></li>
            <li class="list-group-item">Fecha de Registro: <strong>...</strong></li>
            <!-- Aquí puedes mostrar un resumen dinámico si lo deseas con JS -->
          </ul>
        </div>
      </div>

      <!-- Navegación de pasos -->
      <div class="d-flex justify-content-between align-items-center mt-4">
        <button class="btn btn-outline-secondary rounded-pill" id="prevStep" disabled>
          <i class="fas fa-arrow-left me-2"></i> Anterior
        </button>
        <button class="btn btn-primary rounded-pill fw-bold px-4" id="nextStep">
          Siguiente <i class="fas fa-arrow-right ms-2"></i>
        </button>
      </div>

      <!-- Barra de progreso -->
      <div class="progress mt-4" style="height: 8px;">
        <div class="progress-bar" role="progressbar" style="width: 33%;" id="wizardProgress"></div>
      </div>
    </div>
  </div>
</div>
