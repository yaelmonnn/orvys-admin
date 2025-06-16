<div class="d-flex">
    <?= view('Dashboard/sidebar', ['rol' => $rol, 'user' => $user]) ?>

    <div class="flex-grow-1 p-0 main-content" style="background-color: #f8f9fa;">
        <?= view('Dashboard/topbar') ?>
        <?= view('Dashboard/bienvenida') ?>
    </div>
</div>

<?= view('Dashboard/modal_logout') ?>
