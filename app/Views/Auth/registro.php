<div class="container-fluid main-container">
        <div class="row content-row justify-content-center align-items-center">
            <div class="col-lg-4 col-md-12 img-logo">
                <img src="http://localhost/orvys-admin/public/assets/images/logo.jpeg" alt="Logo futurista" class="shadow">
            </div>

            <div class="col-lg-7 col-md-12 d-flex justify-content-center">
                <div class="registro-box text-white">
                    <h2 class="fw-bold text-center mb-2">Crea tu cuenta</h2>
                    <p class="text-center mb-4">Regístrate para gestionar tus proyectos eficientemente</p>

                    <form action="#" method="post" id="form-registro">
                        <div class="row mb-3-custom">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <label for="nombre" class="form-label small">Nombre completo <i class="fa-solid fa-user ms-1"></i></label>
                                <input type="text" class="form-control form-control-sm" id="nombre" name="nombre" placeholder="Ingrese su nombre completo" required>
                            </div>
                            <div class="col-md-6">
                                <label for="telefono" class="form-label small">Teléfono <i class="fa-solid fa-phone ms-1"></i></label>
                                <input type="tel" class="form-control form-control-sm" id="telefono" name="telefono" placeholder="Ingrese su número de teléfono" required>
                            </div>
                        </div>


                        <div class="mb-3-custom">
                            <label for="email" class="form-label small">Email <i class="fa-solid fa-envelope ms-1"></i></label>
                            <input type="email" class="form-control form-control-sm" id="email" name="email" placeholder="Ingrese su correo electrónico" required>
                        </div>

                        <div class="row mb-3-custom">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <label for="password" class="form-label small">Contraseña <i class="fa-solid fa-lock ms-1"></i></label>
                                <div class="input-group input-group-sm">
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Ingrese su contraseña" required oninput="mostrarEye()">
                                    <button class="input-group-text password-toggle toggle-desaparecer" type="button" onclick="togglePassword()">
                                        <i class="fa-solid fa-eye" id="toggleIcon"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="confirm_password" class="form-label small">Confirmar contraseña <i class="fa-solid fa-lock ms-1"></i></label>
                                <div class="input-group input-group-sm">
                                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirme su contraseña" required oninput="mostrarEye2()">
                                    <button class="input-group-text password-toggle2 toggle-desaparecer" type="button" onclick="togglePassword2()">
                                        <i class="fa-solid fa-eye" id="toggleIcon2"></i>
                                    </button>
                                </div>
                            </div>
                        </div>


                        <div class="form-check text-start mb-4 mt-2">
                            <input class="form-check-input" type="checkbox" id="terminos" name="terminos" required>
                            <label class="form-check-label small" for="terminos">
                                Acepto los <a href="#" class="text-white text-decoration-underline">Términos y Condiciones</a>
                            </label>
                        </div>


                        <button type="submit" class="btn btn-primary btn-sm w-100 w-md-auto btn-enviar">Registrarse</button>
                    </form>


                    <div class="text-center w-100 d-flex flex-column align-items-center justify-content-center mt-3">
                        <a href="<?=base_url('login');?>" class="text-white text-decoration-none small enlace">¿Ya tienes cuenta? Inicia sesión</a>
                    </div>
                </div>
            </div>
        </div>
    </div>