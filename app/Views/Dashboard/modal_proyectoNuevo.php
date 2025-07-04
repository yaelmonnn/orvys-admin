<div class="modal fade" id="modalInsertarProyecto" tabindex="-1" aria-labelledby="modalInsertarProyectoLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content rounded-4 shadow">
                <div class="modal-header bg-primary text-white rounded-top">
                    <h5 class="modal-title" id="modalInsertarProyectoLabel">Nuevo Proyecto</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <form id="formInsertarProyecto">
                        <div class="row g-3">
                            <!-- Título del Proyecto -->
                            <div class="col-md-6">
                                <label for="titulo" class="form-label fw-bold">Título del Proyecto *</label>
                                <input type="text" class="form-control" id="titulo" name="titulo" placeholder="Ingresa el título del proyecto" required>
                            </div>

                            <!-- Tipo de Proyecto -->
                            <div class="col-md-6">
                                <label for="tipo_proyecto" class="form-label fw-bold">Tipo de Proyecto *</label>
                                <select class="form-select" id="tipo_proyecto" name="tipo_proyecto" required>
                                    <option value="">Selecciona el tipo de proyecto</option>
                                    <?php
                                        if (!empty($tipos)) {
                                            foreach($tipos as $t) {
                                                echo '<option value="'.$t['tipo'].'">'.$t['tipo'].'</option>';
                                            }
                                        }
                                    ?>
                                </select>
                            </div>

                            <!-- Periodo -->
                            <div class="col-md-4">
                                <label for="periodo" class="form-label fw-bold">Periodo *</label>
                                <select class="form-select" id="periodo" name="periodo" required>
                                    <option value="">Selecciona un periodo</option>
                                    <?php
                                        echo '<option value="'.$periodoSelectNombre.'">'.$periodoSelectNombre.'</option>';
                                        // if (!empty($periodos)) {
                                        //     foreach($periodos as $p) {
                                        //         echo '<option value="'.$p['periodo'].'">'.$p['periodo'].'</option>';
                                        //     }
                                        // }
                                    ?>
                                </select>
                            </div>
                                                    <!-- Número de Sprints -->
                        <div class="col-md-4">
                            <label for="numero_sprints" class="form-label fw-bold">Número de Sprints *</label>
                            <select class="form-select" id="numero_sprints" name="numero_sprints" required onchange="setFechaFin()">
                                <option value="">Selecciona el número de sprints</option>
                            <?php
                                if (!empty($sprints)) {
                                    foreach($sprints as $s) {
                                        echo '<option value="'.$s['Id'].'">'.$s['sprintMuestra'].'</option>';
                                    }
                                }
                            ?>
                            </select>
                        </div>

                            <!-- Descripción -->
                            <div class="col-md-4">
                                <label for="descripcion" class="form-label fw-bold">Descripción</label>
                                <textarea class="form-control" id="descripcion" name="descripcion" rows="3" placeholder="Describe brevemente el proyecto..."></textarea>
                            </div>

                            <!-- Fecha Inicio -->
                            <?php date_default_timezone_set('America/Merida'); ?>
                            <div class="col-md-4">
                                <label for="fecha_inicio" class="form-label fw-bold">Fecha Inicio *</label>
                                <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" value="<?= date('Y-m-d') ?>" readonly required>
                            </div>



                            <!-- Fecha Fin -->
                            <div class="col-md-4">
                                <label for="fecha_fin" class="form-label fw-bold">Fecha Fin *</label>
                                <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" readonly required>
                            </div>


                            <!-- Estatus -->
                            <div class="col-md-4">
                                <label for="estatus" class="form-label fw-bold">Estatus *</label>
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

                            <!-- Importancia -->
                            <div class="col-md-4">
                                <label for="importancia" class="form-label fw-bold">Importancia *</label>
                                <select class="form-select" id="importancia" name="importancia" required>
                                    <option value="">Selecciona la importancia</option>
                                    <?php
                                        if (!empty($importancias)) {
                                            foreach($importancias as $i) {
                                                echo '<option value="'.$i['importancia'].'">'.$i['importancia'].'</option>';
                                            }
                                        }
                                    ?>
                                </select>
                            </div>

                            <!-- Urgencia -->
                            <div class="col-md-4">
                                <label for="urgencia" class="form-label fw-bold">Urgencia *</label>
                                <select class="form-select" id="urgencia" name="urgencia" required>
                                    <option value="">Selecciona la urgencia</option>
                                    <?php
                                        if (!empty($urgencias)) {
                                            foreach($urgencias as $u) {
                                                echo '<option value="'.$u['urgencia'].'">'.$u['urgencia'].'</option>';
                                            }
                                        }
                                    ?>
                                </select>
                            </div>

                            <!-- Grupos Asignados -->
                            <div class="col-md-4">
                                <label for="grupos_asignados" class="form-label fw-bold">Grupos Asignados</label>
                                <select class="form-select" id="grupos_asignados" name="grupos_asignados" multiple>
                                    <?php
                                        if (!empty($grupos)) {
                                            foreach($grupos as $g) {
                                                echo '<option value="'.$g['grupo'].'">'.$g['grupo'].'</option>';
                                            }
                                        }
                                    ?>
                                </select>
                                <div class="form-text">Mantén presionado Ctrl (Cmd en Mac) para seleccionar múltiples opciones</div>
                            </div>
                        </div>




                        <div class="mt-4 text-end">
                            <button type="submit" class="btn btn-success btn-envNuevo">
                                <i class="fas fa-save me-2"></i>Guardar Proyecto
                            </button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                <i class="fas fa-times me-2"></i>Cancelar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    
<script>
  window.FECHA_FIN_PERIODO = '<?= $fechaFinPeriodo; ?>';
  let sprintAnterior = "";
</script>
