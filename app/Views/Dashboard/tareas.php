<div class="p-3">
  <div class="card shadow-sm rounded-4">
    <div class="card-body">

      <!-- Título del proyecto -->
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold text-primary mb-0">Proyecto: <?= $proyecto ?></h4>
        <a href="javascript:history.back()" class="btn btn-outline-secondary rounded-pill shadow-sm">
          <i class="fas fa-arrow-left me-2"></i> Regresar
        </a>
      </div>


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
            <input type="text" class="form-control rounded-pill" id="nombreHistoria">
            </div>

            <div class="col-md-6">
            <label class="form-label">2. Cargo de quien lo solicitó</label>
            <select class="form-select rounded-pill" id="cargoSolicitante">
                <option selected disabled>Seleccione un cargo</option>
                <?php
                 if (!empty($cargos)) {
                     foreach ($cargos as $cargo) {
                         echo "<option value='{$cargo['cargo']}'>{$cargo['cargo']}</option>";
                     }
                 }
                ?>
            </select>
            </div>

            <div class="col-md-6">
            <label class="form-label">3. Nivel de Urgencia</label>
            <select class="form-select rounded-pill" id="nivelUrgencia">
                <option selected disabled>Seleccione una urgencia</option>
                <?php
                 if (!empty($urgencias)) {
                     foreach ($urgencias as $u) {
                         echo "<option value='{$u['urgencia']}'>{$u['urgencia']}</option>";
                     }
                 }
                ?>
            </select>
            </div>

            <div class="col-md-6">
            <label class="form-label">4. Nivel de Complejidad</label>
            <select class="form-select rounded-pill" id="nivelComplejidad">
                 <option selected disabled>Seleccione una complejidad</option>
                <?php
                 if (!empty($complejidades)) {
                     foreach ($complejidades as $c) {
                         echo "<option value='{$c['complejidad']}'>{$c['complejidad']}</option>";
                     }
                 }
                ?>
            </select>
            </div>

            <div class="col-md-6">
              <label class="form-label">5. Estatus de la tarea</label>
              <select class="form-select rounded-pill" id="estatusTarea">
                  <option selected disabled>Seleccione un estatus</option>
                  <?php
                    if (!empty($estados)) {
                        foreach ($estados as $c) {
                            echo "<option value='{$c['estatus']}'>{$c['estatus']}</option>";
                        }
                    }
                  ?>
              </select>
            </div>

            <div class="col-md-6">
            <label class="form-label">6. Descripción</label>
            <textarea class="form-control rounded-4" rows="3" id="descripcion"></textarea>
            </div>
        </div>
        </div>



        <!-- Paso 2 -->
        <div class="wizard-step d-none" data-step="2">
        <h5 class="fw-bold mb-3">Detalles Técnicos</h5>

        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label">7. Sprint asignado</label>
            <select class="form-select rounded-pill" id="sprintAsignado" onchange="setFechaFin()">
                <option selected disabled>Seleccione un Sprint</option>
                <?php
                  if (!empty($sprints)) {
                      foreach ($sprints as $s) {
                          echo "<option value='{$s['Id']}'>{$s['sprint']}</option>";
                      }
                  }
                ?>
            </select>
          </div>

          <div class="col-md-6">
            <label class="form-label">7.1 Grupo asignado</label>
            <select class="form-select rounded-pill" id="grupoAsignado">
                <option selected disabled>Seleccione un grupo</option>
                <?php
                  if (!empty($grupos)) {
                      foreach ($grupos as $g) {
                          echo "<option value='{$g['Id']}'>{$g['grupo']}</option>";
                      }
                  }
                ?>
            </select>
          </div>


            <div class="col-md-6">
            <label class="form-label">8. Duración estimada (horas)</label>
            <input type="number" class="form-control rounded-pill" min="1" placeholder="Ej. 6" id="duracionEstimada">
            </div>

            <div class="col-md-6">
            <label class="form-label">9. Fecha de Registro</label>
            <input type="date" class="form-control rounded-pill" id="fechaRegistro" value="<?= date('Y-m-d') ?>" readonly disabled>
            </div>

            <div class="col-md-6">
            <label class="form-label">10. Fecha límite de entrega</label>
            <input type="date" class="form-control rounded-pill" id="fechaLimite" readonly disabled>
            </div>


            <div class="col-md-6">
              <label class="form-label">11. Módulo Relacionado</label>
              <input type="text" class="form-control rounded-pill" placeholder="Ej. Autenticación, Reportes" id="moduloRelacionado">
            </div>

            <div class="col-md-6">
            <label class="form-label">12. Observaciones Técnicas</label>
            <textarea class="form-control rounded-4" rows="3" placeholder="Tecnologías, dependencias, riesgos..." id="observacionesTecnicas"></textarea>
            </div>

            <div class="col-md-6">
            <label class="form-label">13. Comentarios adicionales</label>
            <textarea class="form-control rounded-4" rows="3" placeholder="Comentarios generales del equipo o PO..." id="comentariosAdicionales"></textarea>
            </div>

            <div class="col-md-6">
            <label class="form-label">14. Pruebas unitarias requeridas</label>
            <textarea class="form-control rounded-4" rows="3" placeholder="Describe qué debe probarse: validaciones, flujo de datos, errores esperados..." id="pruebasUnitarias"></textarea>
            </div>
        </div>
        </div>



        <div class="wizard-step d-none" data-step="3">
          <h5 class="fw-bold mb-3">Confirmación</h5>
          <p>Revisa los datos antes de guardar la tarea.</p>
          <ul class="list-group rounded-4 shadow-sm" id="resumenConfirmacion">
            <li class="list-group-item">Nombre de Historia: <strong id="resumenNombreHistoria">...</strong></li>
            <li class="list-group-item">Cargo solicitante: <strong id="resumenCargo">...</strong></li>
            <li class="list-group-item">Nivel de Urgencia: <strong id="resumenUrgencia">...</strong></li>
            <li class="list-group-item">Fecha de Registro: <strong id="resumenFecha">...</strong></li>
            <li class="list-group-item">Módulo Relacionado: <strong id="resumenModulo">...</strong></li>
            <li class="list-group-item">Duración Estimada: <strong id="resumenDuracion">...</strong></li>
            <li class="list-group-item">Fecha Límite: <strong id="resumenLimite">...</strong></li>
            <li class="list-group-item">Estatus: <strong id="resumenEstatus">...</strong></li>
            <li class="list-group-item">Sprint Asignado: <strong id="resumenSprint">...</strong></li>
            <li class="list-group-item">Grupo Asignado: <strong id="resumenGrupo">...</strong></li>
          </ul>
          <input type="hidden" id="idProyecto" value="<?=$idProyecto?>">

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

<script>
  window.FECHA_FIN_PROYECTO = '<?= $fechaFin; ?>';
   let sprintAnteriorTarea = "";
</script>
