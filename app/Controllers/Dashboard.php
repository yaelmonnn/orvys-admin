<?php

namespace App\Controllers;

use App\Models\UsuarioModel;
use App\Models\PeriodoModel;
use App\Models\ProyectoModel;
use CodeIgniter\HTTP\ResponseInterface;

class Dashboard extends BaseController
{

    protected $usuarioModel;
    protected $periodoModel;
    protected $proyectoModel;

    public function __construct()
    {
        $this->usuarioModel = new UsuarioModel();
        $this->periodoModel = new PeriodoModel();
        $this->proyectoModel = new ProyectoModel();
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

        $proyectos = $this->proyectoModel->traerProyectos((int) $session->get('periodoSelect'));

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
            'vistaExtra' => view('Dashboard/proyectos', [
                'proyectos' => $proyectos
            ]),
            'tituloTop' => $tituloTopbar
        ]);

        $view .= view('Dashboard/modal_tareas');
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

        $catPeriodos = $this->periodoModel->traerPeriodos();

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
            'vistaExtra' => view('Dashboard/periodos', [
                'periodos' => $catPeriodos,
                'periodoSelect' => $session->get('periodoSelect')
            ]),
            'tituloTop' => $tituloTopbar
        ]);

        $estados = $this->periodoModel->traerEstados();

        $view .= view('Dashboard/modal_periodo');
        $view .= view('Dashboard/modal_resetPeriodo');
        $view .= view('Dashboard/modal_periodoNuevo', [
            'estados' => $estados
        ]);
        $view .= view('layouts/footer');
        return $view;
    }


    public function seleccionarPeriodo()
    {
        $session = session();
        $id = $this->request->getPost('idPeriodo');
        if ($id) {
            $session->set('periodoSelect', $id);
            return $this->response->setJSON(['success' => true]);
        }
        return $this->response->setJSON(['success' => false]);
    }

    public function resetearPeriodo() {
        $session = session();
        $session->set('periodoSelect', 0);
        return $this->response->setJSON(['success' => true]);
    }

    public function insertarPeriodo()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Petición no válida'
            ]);
        }

        try {
            $json = $this->request->getJSON();

            $data = [
                'periodo' => trim($json->periodo),
                'fecha_inicio' => $json->fecha_inicio,
                'fecha_fin' => $json->fecha_fin,
                'estatus' => $json->estatus 
            ];

            $resultado = $this->periodoModel->insertarPeriodo($data);

            if ($resultado === true) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Periodo insertado correctamente'
                ]);
            } else if (is_array($resultado) && isset($resultado['error'])) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Error del servidor: ' . $resultado['error']
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'No se pudo insertar el periodo. Verifica los datos enviados.'
                ]);
            }

        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error interno del servidor. Intenta nuevamente.'
            ]);
        }
    }





    public function usuarios() {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $rol = $this->usuarioModel->traerRol($session->get('email'));
        $usuarios = $this->usuarioModel->traerUsuarios();

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
            'vistaExtra' => view('Dashboard/usuarios', [
                'usuarios' => $usuarios
            ]),
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
        $grupos = $this->usuarioModel->traerGrupos();

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
            'vistaExtra' => view('Dashboard/grupos', [
                'grupos' => $grupos
            ]),
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
