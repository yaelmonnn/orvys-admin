<?php

namespace App\Controllers;

use App\Models\UsuarioModel;
use CodeIgniter\HTTP\ResponseInterface;

class Dashboard extends BaseController
{

    protected $usuarioModel;

    public function __construct()
    {
        $this->usuarioModel = new UsuarioModel();
    }


    public function proyectos() {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $rol = $this->usuarioModel->traerRol($session->get('email'));

        $titulo = 'Proyectos';
        $css = 'proyectos.css';
        $cargarJS = true;
        $js = 'proyectos.js';
        $tituloTopbar = 'Proyectos';

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
            'vistaExtra' => view('Dashboard/proyectos'),
            'tituloTop' => $tituloTopbar
        ]);

        $view .= view('layouts/footer');
        return $view;


    }

    public function periodos() {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $rol = $this->usuarioModel->traerRol($session->get('email'));

        $titulo = 'Proyectos';
        $css = 'periodos.css';
        $cargarJS = true;
        $js = 'periodos.js';
        $tituloTopbar = 'Periodos';

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
            'vistaExtra' => view('Dashboard/periodos'),
            'tituloTop' => $tituloTopbar
        ]);

        $view .= view('Dashboard/modal_periodo');
        $view .= view('layouts/footer');
        return $view;
    }

    public function usuarios() {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $rol = $this->usuarioModel->traerRol($session->get('email'));

        $titulo = 'Usuarios';
        $css = 'usuarios.css';
        $cargarJS = true;
        $js = 'usuarios.js';
        $tituloTopbar = 'Usuarios';

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
            'vistaExtra' => view('Dashboard/usuarios'),
            'tituloTop' => $tituloTopbar
        ]);

        $view .= view('layouts/footer');
        return $view;
    }


    public function grupos() {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $rol = $this->usuarioModel->traerRol($session->get('email'));

        $titulo = 'Grupos';
        $css = 'grupos.css';
        $cargarJS = true;
        $js = 'grupos.js';
        $tituloTopbar = 'Grupos';

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
            'vistaExtra' => view('Dashboard/grupos'),
            'tituloTop' => $tituloTopbar
        ]);

        $view .= view('layouts/footer');
        return $view;
    }

    public function catalogos() {
         $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $rol = $this->usuarioModel->traerRol($session->get('email'));

        $titulo = 'Catálogos';
        $css = 'catalogos.css';
        $cargarJS = true;
        $js = 'catalogos.js';
        $tituloTopbar = 'Catalogos';

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
            'vistaExtra' => view('Dashboard/catalogos'),
            'tituloTop' => $tituloTopbar
        ]);

        $view .= view('layouts/footer');
        return $view;
    }

}
