<div class="d-flex justify-content-between align-items-center shadow-sm"
     style="background-color: #F5F5F5; margin: 20px 30px 0; padding: 15px 30px; border-radius: 10px;">
    <div class="fw-bold text-dark"><?=$tituloTop?> - <?php
        if ($periodoSelectNombre == '') {
            echo 'SIN PERIODO SELECCIONADO';
        } else {
            echo 'PERIODO: ' . $periodoSelectNombre;
        }
    ?></div>
    <a href="#" class="logout-btn" data-bs-toggle="modal" data-bs-target="#logoutModal">
        <i class="fas fa-sign-out-alt me-2 text-danger"></i>
    </a>
</div>
