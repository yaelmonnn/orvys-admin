<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">
        <div class="navbar-nav me-auto"></div> 

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto me-md-5 mt-3 text-end"> 
                <li class="nav-item me-md-4">
                    <a class="nav-link text-white normal-link" aria-current="page" href="#">Inicio</a>
                </li>
                <li class="nav-item me-md-4">
                    <a class="nav-link text-white normal-link" href="#">Nosotros</a>
                </li>
                <li class="nav-item me-md-4">
                    <a class="nav-link text-white normal-link" href="#">Servicio</a>
                </li>
                <li class="nav-item me-md-4">
                    <a class="nav-link text-white normal-link" href="#">Contacto</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link text-white px-md-3 py-md-1 access-btn" href="<?= base_url('login') ?>">
                    Acceder
                  </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Imagen centrada con borde azul "futurista" -->
<div class="d-flex justify-content-center align-items-center" style="height: calc(100vh - 96px);">
    <img src="<?= base_url('assets/images/logo.jpeg'); ?>" alt="Logo futurista"
        class="rounded-circle shadow"
        style="
            width: 300px;
            height: 300px;
            object-fit: cover;
            border: 3px solid #00cfff;
            box-shadow: 0 0 20px #00cfff, 0 0 40px #00aaff;
        ">
</div>
