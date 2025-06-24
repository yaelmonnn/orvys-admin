<div class="p-3">

  <div class="row g-4">
    <div class="col-md-6">
      <div class="card shadow-sm rounded-4">
        <div class="card-body">
          <h5 class="card-title fw-bold">Tema de la Interfaz</h5>
          <select class="form-select rounded-pill mt-2">
            <option value="light">Claro</option>
            <option value="dark">Oscuro</option>
            <option value="auto">Automático</option>
          </select>
        </div>
      </div>
    </div>

    <div class="col-md-6">
      <div class="card shadow-sm rounded-4">
        <div class="card-body">
          <h5 class="card-title fw-bold">Idioma Preferido</h5>
          <select class="form-select rounded-pill mt-2">
            <option value="es">Español</option>
            <option value="en">Inglés</option>
            <option value="fr">Francés</option>
          </select>
        </div>
      </div>
    </div>

    <div class="col-md-6">
      <div class="card shadow-sm rounded-4">
        <div class="card-body">
          <h5 class="card-title fw-bold">Horario de Inicio de Sesión</h5>
          <input type="time" class="form-control rounded-pill mt-2" value="08:00">
        </div>
      </div>
    </div>

    <div class="col-md-6">
      <div class="card shadow-sm rounded-4">
        <div class="card-body">
          <h5 class="card-title fw-bold">Notificaciones</h5>
          <div class="form-check form-switch mt-2">
            <input class="form-check-input" type="checkbox" id="notificaciones" checked>
            <label class="form-check-label" for="notificaciones">Activar notificaciones por correo</label>
          </div>
        </div>
      </div>
    </div>


    <div class="col-md-6">
      <div class="card shadow-sm rounded-4">
        <div class="card-body">
          <h5 class="card-title fw-bold">Zona Horaria</h5>
          <select class="form-select rounded-pill mt-2">
            <option value="CST">CST (UTC-6)</option>
            <option value="EST">EST (UTC-5)</option>
            <option value="PST">PST (UTC-8)</option>
          </select>
        </div>
      </div>
    </div>


    <div class="col-12 text-center mt-4">
      <button class="btn btn-primary rounded-pill shadow-sm fw-bold px-4">
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
