<?php

namespace App\Controllers;

use App\Models\UsuarioModel;
use CodeIgniter\HTTP\ResponseInterface;

class Login extends BaseController
{
    protected $usuarioModel;

    public function __construct()
    {
        $this->usuarioModel = new UsuarioModel();
    }

    public function index()
    {
        
        $session = session();
        if ($session->get('isLoggedIn')) {
            return redirect()->to('/dashboard');
        }

        $titulo = 'Inicio';
        $css = 'inicio.css';
        $cargarJS = false;
        $view = view('layouts/header', [
            'titulo' => $titulo,
            'css' => $css,
            'cargarJS' => $cargarJS
        ]);
        $view .= view('inicio');
        $view .= view('layouts/footer');
        return $view;
    }

    public function dashboard()
    {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $rol = $this->usuarioModel->traerRol($session->get('email'));

        $titulo = 'Dashboard';
        $css = 'dashboard.css';
        $cargarJS = true;
        $js = 'dashboard.js';
        $tituloTopbar = 'Inicio';

        $view = view('layouts/header', [
            'titulo'   => $titulo,
            'css'      => $css,
            'cargarJS' => $cargarJS,
            'js'       => $js,
            'rol'      => $rol,
            'user'     => $session->get('email')
        ]);

        $view .= view('Dashboard/dashboard', [
            'rol'  => $rol,
            'user' => $session->get('email'),
            'vistaExtra' => view('Dashboard/bienvenida'),
            'tituloTop' => $tituloTopbar
        ]);

        $view .= view('layouts/footer');
        return $view;
    }


    public function login() {

        $session = session();
        if ($session->get('isLoggedIn')) {
            return redirect()->to('/dashboard');
        }

        $titulo = 'Login';
        $css = 'login.css';
        $js = 'login.js';
        $cargarJS = true;
        $view = view('layouts/header', [
            'titulo' => $titulo,
            'css' => $css,
            'js' => $js,
            'cargarJS' => $cargarJS
        ]);
        $view .= view('Auth/login');
        $view .= view('layouts/footer');
        return $view;
    }

    public function registro() {

        $session = session();
        if ($session->get('isLoggedIn')) {
            return redirect()->to('/dashboard');
        }

        $titulo = 'Registro';
        $css = 'registro.css';
        $cargarJS = true;
        $js = 'registro.js';
        $view = view('layouts/header', [
            'titulo' => $titulo,
            'css' => $css,
            'cargarJS' => $cargarJS,
            'js' => $js
        ]);
        $view .= view('Auth/registro');
        $view .= view('layouts/footer');
        return $view;
    }

    public function registrar_usuario() {
        
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Petición no válida'
            ]);
        }

        $rules = [
            'nombre' => [
                'rules' => 'required|min_length[2]|max_length[100]',
                'errors' => [
                    'required' => 'El nombre es obligatorio',
                    'min_length' => 'El nombre debe tener al menos 2 caracteres',
                    'max_length' => 'El nombre no puede exceder 100 caracteres'
                ]
            ],
            'telefono' => [
                'rules' => 'required|min_length[10]|max_length[15]|numeric',
                'errors' => [
                    'required' => 'El teléfono es obligatorio',
                    'min_length' => 'El teléfono debe tener al menos 10 dígitos',
                    'max_length' => 'El teléfono no puede exceder 15 dígitos',
                    'numeric' => 'El teléfono solo debe contener números'
                ]
            ],
            'email' => [
                'rules' => 'required|valid_email',
                'errors' => [
                    'required' => 'El email es obligatorio',
                    'valid_email' => 'Debe ser un email válido'
                ]
            ],
            'password' => [
                'rules' => 'required|min_length[8]',
                'errors' => [
                    'required' => 'La contraseña es obligatoria',
                    'min_length' => 'La contraseña debe tener al menos 8 caracteres'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Datos inválidos',
                'errors' => $this->validator->getErrors()
            ]);
        }

        try {
            $nombre = trim($this->request->getPost('nombre'));
            $telefono = trim($this->request->getPost('telefono'));
            $email = strtolower(trim($this->request->getPost('email')));
            $password = $this->request->getPost('password');


            if ($this->usuarioModel->existeEmail($email)) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Este email ya está registrado'
                ]);
            }

            // Hash de la contraseña con Argon2ID
            $passwordHash = password_hash($password, PASSWORD_ARGON2ID, [
                'memory_cost' => 65536,
                'time_cost' => 4,      
                'threads' => 3         
            ]);

            $userData = [
                'nombre' => $nombre,
                'telefono' => $telefono,
                'email' => $email,
                'password' => $passwordHash
            ];

            $usuarioId = null;
            try {
                $usuarioId = $this->usuarioModel->insertarUsuario($userData);
                
            } catch (\Exception $e) {
                if (strpos($e->getMessage(), 'email ya está registrado') !== false ||
                    strpos($e->getMessage(), 'Usuario') !== false) {
                    throw $e;
                }
            }

            if ($usuarioId) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Usuario registrado exitosamente',
                    'user_id' => $usuarioId
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Error al registrar el usuario'
                ]);
            }

        } catch (\Exception $e) {
            
            $message = 'Error interno del servidor';
            $errorMsg = $e->getMessage();
            
            if (strpos($errorMsg, 'email ya está registrado') !== false) {
                $message = 'Este email ya está registrado';
            } elseif (strpos($errorMsg, 'duplicate') !== false || strpos($errorMsg, 'UNIQUE') !== false) {
                $message = 'Este email ya está registrado';
            } elseif (strpos($errorMsg, 'connection') !== false) {
                $message = 'Error de conexión a la base de datos. Intenta nuevamente.';
            } elseif (strpos($errorMsg, 'timeout') !== false) {
                $message = 'La operación tardó demasiado. Intenta nuevamente.';
            } else {
                $message = 'Error al registrar el usuario. Intenta nuevamente.';
            }
            
            return $this->response->setJSON([
                'success' => false,
                'message' => $message
            ]);
        }
    }

    public function validarLogin()
        {
            if (!$this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Petición no válida'
                ]);
            }

            $email = strtolower(trim($this->request->getPost('email')));
            $password = $this->request->getPost('password');
            $captchaResponse = $this->request->getPost('g-recaptcha-response');

            if (!$captchaResponse) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Captcha no completado'
                ]);
            }

            $secretKey = env('RECAPTCHA_SECRET_KEY');
            $verify = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$secretKey}&response={$captchaResponse}");
            $captchaSuccess = json_decode($verify);

            if (!$captchaSuccess->success) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Captcha inválido. Inténtalo de nuevo.'
                ]);
            }

            if (empty($email) || empty($password)) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Email y contraseña son obligatorios'
                ]);
            }

            try {
                $usuario = $this->usuarioModel->validarCredenciales($email);

                if (!$usuario) {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'Usuario no encontrado'
                    ]);
                }

                if (password_verify($password, $usuario['password'])) {
                        $session = session();

                        $session->set([
                            'isLoggedIn' => true,
                            'email'      => $usuario['email'],
                            'periodoSelect' => 0
                        ]);

                    return $this->response->setJSON([
                        'success' => true,
                        'message' => 'Inicio de sesión exitoso',
                        'user' => [
                            'email' => $usuario['email']
                        ]
                    ]);
                } else {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'Contraseña incorrecta'
                    ]);
                }


            } catch (\Exception $e) {
                log_message('error', 'Error en login: ' . $e->getMessage());
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Error interno del servidor'
                ]);
            }
        }

    
        public function logout()
        {
            $session = session();
            $session->destroy();
            return redirect()->to('/');
        }


}