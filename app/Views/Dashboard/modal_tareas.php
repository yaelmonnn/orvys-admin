<div class="modal fade" id="kanbanModal" tabindex="-1" aria-labelledby="kanbanModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content rounded-4">
      <div class="modal-header bg-light">
        <h5 class="modal-title fw-bold" id="kanbanModalLabel">22 - AppSalud</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <p class="mb-4">Desarrollo de una app móvil para seguimiento de citas médicas y control de salud.</p>

        <div class="kanban-scroll d-flex flex-nowrap gap-3 pb-3" 
             style="max-height: 340px;">

          <!-- To Do -->
          <div class="flex-shrink-0 p-2 rounded shadow-sm bg-todo" style="min-width: 250px;">
            <h6 class="text-center fw-bold">To Do</h6>
            <div class="bg-white p-2 rounded mb-2 border">
              <strong>ID: 101</strong><br>
              <b>Título:</b> Crear estructura de base de datos<br>
              <b>Responsable:</b> Juan Dev<br>
              <b>Estimación:</b> 2h
            </div>
            <div class="bg-white p-2 rounded mb-2 border">
              <strong>ID: 102</strong><br>
              <b>Título:</b> Esquematizar wireframes<br>
              <b>Responsable:</b> Dario UX<br>
              <b>Estimación:</b> 3h
            </div>
            <div class="bg-white p-2 rounded mb-2 border">
              <strong>ID: 103</strong><br>
              <b>Título:</b> Registrar endpoints de autenticación<br>
              <b>Responsable:</b> Sofía Dev<br>
              <b>Estimación:</b> 4h
            </div>
            <div class="bg-white p-2 rounded mb-2 border">
              <strong>ID: 104</strong><br>
              <b>Título:</b> Crear documentación inicial<br>
              <b>Responsable:</b> Julio Doc<br>
              <b>Estimación:</b> 1h
            </div>
          </div>

          <!-- In Progress -->
          <div class="flex-shrink-0 p-2 rounded shadow-sm bg-inprogress" style="min-width: 250px;">
            <h6 class="text-center fw-bold">In Progress</h6>
            <div class="bg-white p-2 rounded mb-2 border">
              <strong>ID: 201</strong><br>
              <b>Título:</b> Formularios de registro<br>
              <b>Responsable:</b> Luisa<br>
              <b>Estimación:</b> 3h
            </div>
            <div class="bg-white p-2 rounded mb-2 border">
              <strong>ID: 202</strong><br>
              <b>Título:</b> Validación de usuario<br>
              <b>Responsable:</b> Eduardo<br>
              <b>Estimación:</b> 2h
            </div>
            <div class="bg-white p-2 rounded mb-2 border">
              <strong>ID: 203</strong><br>
              <b>Título:</b> Manejo de tokens<br>
              <b>Responsable:</b> Ana Backend<br>
              <b>Estimación:</b> 2.5h
            </div>
            <div class="bg-white p-2 rounded mb-2 border">
              <strong>ID: 204</strong><br>
              <b>Título:</b> Vista principal de usuario<br>
              <b>Responsable:</b> Mario UI<br>
              <b>Estimación:</b> 4h
            </div>
          </div>

          <!-- Code Review -->
          <div class="flex-shrink-0 p-2 rounded shadow-sm bg-review" style="min-width: 250px;">
            <h6 class="text-center fw-bold">Code Review</h6>
            <div class="bg-white p-2 rounded mb-2 border">
              <strong>ID: 301</strong><br>
              <b>Título:</b> Revisar servicios de login<br>
              <b>Responsable:</b> Laura QA<br>
              <b>Estimación:</b> 2h
            </div>
            <div class="bg-white p-2 rounded mb-2 border">
              <strong>ID: 302</strong><br>
              <b>Título:</b> Validar arquitectura MVC<br>
              <b>Responsable:</b> Carlos<br>
              <b>Estimación:</b> 1.5h
            </div>
            <div class="bg-white p-2 rounded mb-2 border">
              <strong>ID: 303</strong><br>
              <b>Título:</b> Revisión de estilos SCSS<br>
              <b>Responsable:</b> Elena Front<br>
              <b>Estimación:</b> 2h
            </div>
            <div class="bg-white p-2 rounded mb-2 border">
              <strong>ID: 304</strong><br>
              <b>Título:</b> Verificación de rutas protegidas<br>
              <b>Responsable:</b> Javier<br>
              <b>Estimación:</b> 2.5h
            </div>
          </div>

          <!-- Testing -->
          <div class="flex-shrink-0 p-2 rounded shadow-sm bg-testing" style="min-width: 250px;">
            <h6 class="text-center fw-bold">Testing</h6>
            <div class="bg-white p-2 rounded mb-2 border">
              <strong>ID: 401</strong><br>
              <b>Título:</b> Pruebas de login exitoso<br>
              <b>Responsable:</b> Oscar QA<br>
              <b>Estimación:</b> 2h
            </div>
            <div class="bg-white p-2 rounded mb-2 border">
              <strong>ID: 402</strong><br>
              <b>Título:</b> Casos de error en login<br>
              <b>Responsable:</b> Oscar QA<br>
              <b>Estimación:</b> 2h
            </div>
            <div class="bg-white p-2 rounded mb-2 border">
              <strong>ID: 403</strong><br>
              <b>Título:</b> Pruebas de rendimiento<br>
              <b>Responsable:</b> Andrea QA<br>
              <b>Estimación:</b> 3h
            </div>
            <div class="bg-white p-2 rounded mb-2 border">
              <strong>ID: 404</strong><br>
              <b>Título:</b> Test unitarios API<br>
              <b>Responsable:</b> Diego QA<br>
              <b>Estimación:</b> 3h
            </div>
          </div>

          <!-- Done -->
          <div class="flex-shrink-0 p-2 rounded shadow-sm bg-done" style="min-width: 250px;">
            <h6 class="text-center fw-bold">Done</h6>
            <div class="bg-white p-2 rounded mb-2 border">
              <strong>ID: 501</strong><br>
              <b>Título:</b> Integración con base de datos<br>
              <b>Responsable:</b> Mariana Back<br>
              <b>Estimación:</b> 4h
            </div>
            <div class="bg-white p-2 rounded mb-2 border">
              <strong>ID: 502</strong><br>
              <b>Título:</b> Diseño de logo AppSalud<br>
              <b>Responsable:</b> Dario UX<br>
              <b>Estimación:</b> 1h
            </div>
            <div class="bg-white p-2 rounded mb-2 border">
              <strong>ID: 503</strong><br>
              <b>Título:</b> Configuración de entorno local<br>
              <b>Responsable:</b> Ana Backend<br>
              <b>Estimación:</b> 2h
            </div>
            <div class="bg-white p-2 rounded mb-2 border">
              <strong>ID: 504</strong><br>
              <b>Título:</b> Login básico funcional<br>
              <b>Responsable:</b> Luisa<br>
              <b>Estimación:</b> 3h
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
