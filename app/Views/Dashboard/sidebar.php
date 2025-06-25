<div class="sidebar text-white d-flex flex-column p-3 nav-lateral" id="sidebar">
    <div class="hamburger-container d-flex mb-2">
        <button class="btn btn-sm btn-outline-light" id="toggleSidebar">
            <i class="fas fa-bars"></i>
        </button>
    </div>

    <div class="user-info text-center mb-4 mt-3 px-2">
        <div class="d-flex justify-content-center mb-4">
            <img src="<?= base_url('assets/images/logo.png') ?>" 
                 alt="Perfil" 
                 class="rounded-circle" 
                 style="width: 60px; height: 60px; object-fit: cover;">
        </div>

        <div class="d-flex align-items-center justify-content-center">
            <i class="fa-solid fa-user me-2" title="<?= esc($user) ?>"></i>
            <span class="sidebar-text fw-semibold"><?= esc($user) ?></span>
        </div>
        <div class="d-flex align-items-center justify-content-center mt-2">
            <i class="fa-solid fa-user-gear me-2" title="<?= esc($rol['rol']) ?>"></i>
            <span class="sidebar-text fw-semibold"><?= esc($rol['rol']) ?></span>
        </div>
    </div>

    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item mb-4 mt-3">
            <a href="<?=base_url('dashboard');?>" class="nav-link text-white sidebar-link" data-tooltip="Inicio">
                <i class="fas fa-home me-2"></i> <span class="sidebar-text">Inicio</span>
            </a>
        </li>
        <li class="mb-4 nav-item mt-3">
            <a href="<?=base_url('proyectos');?>" class="nav-link text-white sidebar-link" data-tooltip="Proyectos">
                <i class="fa-solid fa-diagram-project me-2"></i> <span class="sidebar-text">Proyectos</span>
            </a>
        </li>

            <li class="nav-item mt-3">
                <a class="nav-link text-white d-flex justify-content-between align-items-center sidebar-link" 
                   data-bs-toggle="collapse" href="#submenuConfig" role="button" 
                   aria-expanded="false" aria-controls="submenuConfig" data-tooltip="Configuración">
                    <div>
                        <i class="fas fa-cogs me-2"></i> <span class="sidebar-text">Configuración</span>
                    </div>
                    <i class="fas fa-chevron-down sidebar-text"></i>
                </a>
                <div class="collapse sidebar-submenu mt-2" id="submenuConfig">
                    <ul class="nav flex-column ms-4">
                        <li><a href="<?=base_url('periodos');?>" class="nav-link text-white sidebar-link"><i class="fas fa-calendar-alt me-2"></i> Periodos</a></li>
                        <?php
                            if ($rol['rol_id'] == 1) {
                                echo '<li><a href="' . base_url('usuarios') . '" class="nav-link text-white sidebar-link"><i class="fas fa-user me-2"></i> Usuarios</a></li>';
                                echo '<li><a href="' . base_url('grupos') . '" class="nav-link text-white sidebar-link"><i class="fas fa-user-friends me-2"></i> Grupos</a></li>';
                                echo '<li><a href="' . base_url('catalogos') . '" class="nav-link text-white sidebar-link"><i class="fas fa-list me-2"></i> Catálogos</a></li>';
                                echo '<li><a href="' . base_url('configuracion') . '" class="nav-link text-white sidebar-link"><i class="fa-solid fa-gear me-2"></i> Preferencias</a></li>';
                            }
                        ?>
                    </ul>
                </div>
            </li>
    </ul>
</div>
