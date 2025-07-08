<div class="p-3">
  <div class="row g-4">

    <!-- Tema de la Interfaz - Premiun -->
    <div class="col-md-6">
      <div class="card shadow-sm rounded-4 opacity-50 position-relative">
        <div class="card-body">
          <h5 class="card-title fw-bold">Tema de la Interfaz</h5>
          <select class="form-select rounded-pill mt-2" disabled>
            <option>Claro</option>
            <option>Oscuro</option>
            <option>Automático</option>
          </select>
          <div class="mt-2 text-center text-muted small">
            <i class="fas fa-lock me-1 text-warning"></i>
            Función disponible en la <strong>Licencia Premiun</strong>
          </div>
        </div>
      </div>
    </div>

    <!-- Idioma Preferido - Premiun -->
    <div class="col-md-6">
      <div class="card shadow-sm rounded-4 opacity-50 position-relative">
        <div class="card-body">
          <h5 class="card-title fw-bold">Idioma Preferido</h5>
          <select class="form-select rounded-pill mt-2" disabled>
            <option>Español</option>
            <option>Inglés</option>
            <option>Francés</option>
          </select>
          <div class="mt-2 text-center text-muted small">
            <i class="fas fa-lock me-1 text-warning"></i>
            Función disponible en la <strong>Licencia Premiun</strong>
          </div>
        </div>
      </div>
    </div>

    <!-- Horario de Inicio de Sesión (RANGO) - Activo -->
    <div class="col-md-6">
      <div class="card shadow-sm rounded-4">
        <div class="card-body">
          <h5 class="card-title fw-bold">Rango de Inicio de Sesión</h5>
          <div class="d-flex gap-2 mt-2">
            <?php
              // Valores por defecto
              $horaInicio = '08:00';
              $horaFin = '17:00';

              if (!empty($preferencias)) {
                  foreach ($preferencias as $pref) {
                      if ($pref['configuracion'] === 'horario_sesion') {
                          $rango = explode(' - ', $pref['descripcion']);
                          if (count($rango) === 2) {
                              $horaInicio = $rango[0];
                              $horaFin = $rango[1];
                          }
                      }
                  }
              }

              echo '<input type="time" class="form-control rounded-pill" id="hora_inicio" value="'.$horaInicio.'">';
              echo '<input type="time" class="form-control rounded-pill" id="hora_fin" value="'.$horaFin.'">';
              ?>


            
            
          </div>
          <div class="form-text mt-1">Define un horario permitido para iniciar sesión.</div>
        </div>
      </div>
    </div>

    <!-- Notificaciones - Premiun -->
    <div class="col-md-6">
      <div class="card shadow-sm rounded-4 opacity-50 position-relative">
        <div class="card-body">
          <h5 class="card-title fw-bold">Notificaciones</h5>
          <div class="form-check form-switch mt-2">
            <input class="form-check-input" type="checkbox" id="notificaciones" disabled>
            <label class="form-check-label text-muted" for="notificaciones">Activar notificaciones por correo</label>
          </div>
          <div class="mt-2 text-center text-muted small">
            <i class="fas fa-lock me-1 text-warning"></i>
            Función exclusiva de <strong>Licencia Premiun</strong>
          </div>
        </div>
      </div>
    </div>

    <!-- Zona Horaria - Premiun -->
    <div class="col-md-6">
      <div class="card shadow-sm rounded-4 opacity-50 position-relative">
        <div class="card-body">
          <h5 class="card-title fw-bold">Zona Horaria</h5>
          <select class="form-select rounded-pill mt-2" disabled>
            <option>CST (UTC-6)</option>
            <option>EST (UTC-5)</option>
            <option>PST (UTC-8)</option>
          </select>
          <div class="mt-2 text-center text-muted small">
            <i class="fas fa-lock me-1 text-warning"></i>
            Disponible solo en <strong>Licencia Premiun</strong>
          </div>
        </div>
      </div>
    </div>

    <!-- Botones -->
    <div class="col-12 text-center mt-4">
      <button class="btn btn-primary rounded-pill shadow-sm fw-bold px-4"  onclick="guardarHorarioSesion()">
        <i class="fas fa-save me-2"></i> Guardar Cambios
      </button>
    </div>

    <div class="col-12 text-center">
      <a href="javascript:history.back()" class="btn btn-outline-secondary rounded-pill shadow-sm">
        <i class="fas fa-arrow-left me-2"></i> Regresar
      </a>
    </div>
  </div>
</div>
