    <div class="container-fluid vh-100 d-flex align-items-center justify-content-center">
        <div class="row w-100 justify-content-center align-items-center">
            
            <div class="col-md-5 col-lg-4 d-flex justify-content-center order-2 order-md-1">
                <div class="login-box text-white">
                    <h2 class="fw-bold text-center mb-3">Bienvenido</h2>
                    <p class="text-center mb-4">Inicia sesión para acceder a tu espacio de trabajo</p>
                    
                    <form action="#" method="post" id="form-login">
                        <div class="mb-4">
                            <label for="email" class="form-label small">Email<span class="ms-2"><i class="fa-solid fa-envelope"></i></span></label>
                            <input type="email" class="form-control form-control-sm" id="email" name="email" placeholder="Ingrese su correo electrónico" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="password" class="form-label small">Contraseña<span class="ms-2"><i class="fa-solid fa-lock"></i></span></label>
                            <div class="input-group input-group-sm">
                                <input type="password" class="form-control" id="password" name="password" placeholder="Ingrese su contraseña" required oninput="mostrarEye()">
                                <button class="input-group-text password-toggle toggle-desaparecer" type="button" onclick="togglePassword()">
                                    <i class="fa-solid fa-eye" id="toggleIcon"></i>
                                </button>
                            </div>
                        </div>

                        <div class="mb-1 text-center">
                        <div class="g-recaptcha d-inline-block" data-sitekey="6LfGNWIrAAAAANM--z_aPGoslnkktbx-uYqJbxUs">
                        </div>
                    </div>
                        
                        <button type="submit" class="btn btn-primary btn-sm w-100 mb-3 mt-3 btn-login">Iniciar sesión</button>
                    </form>
                    
                    <div class="text-center mt-2 w-100 d-flex flex-column align-items-center justify-content-center">
                        <a href="#" class="text-white text-decoration-none d-block mb-3 small enlace">¿Olvidaste tu contraseña?</a>
                        <a href="<?=base_url('registro');?>" class="text-white text-decoration-none small enlace">¿Eres nuevo? Regístrate</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-lg-4 d-flex justify-content-center align-items-center order-1 order-md-2">
                <img src="<?= base_url('assets/images/logo.jpeg'); ?>" alt="Logo futurista"
                    class="rounded-circle shadow logo-img">
            </div>
        </div>
    </div>

    <script src="https://www.google.com/recaptcha/api.js" async defer></script>