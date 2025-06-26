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

        if ($session->get('periodoSelectNombre') == '') {
            return redirect()->to('/periodos');
        }

        $rol = $this->usuarioModel->traerRol($session->get('email'));

        $titulo = 'Proyectos';
        $css = 'proyectos.css';
        $cargarJS = true;
        $js = 'proyectos.js';
        $tituloTopbar = 'Proyectos';

        $proyectos = $this->proyectoModel->traerProyectos((int) $session->get('periodoSelect'));
        $estados = $this->proyectoModel->traerEstados();
        $importancias = $this->proyectoModel->traerImportancias();
        $urgencias = $this->proyectoModel->traerUrgencias();
        $periodos = $this->proyectoModel->traerPeriodos();
        $grupos = $this->proyectoModel->traerGrupos();
        $tipos = $this->proyectoModel->traerTipos();

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
            'tituloTop' => $tituloTopbar,
            'periodoSelectNombre' => $session->get('periodoSelectNombre')
        ]);

        $view .= view('Dashboard/modal_tareas');
        $view .= view('Dashboard/modal_proyectoNuevo', [
            'estados' => $estados,
            'importancias' => $importancias,
            'urgencias' => $urgencias,
            'periodos' => $periodos,
            'grupos' => $grupos,
            'tipos' => $tipos
        ]);
        $view .= view('Dashboard/modal_backlog');
        $view .= view('layouts/footer');
        return $view;


    }

    public function insertarProyecto()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Petición no válida'
            ]);
        }
         $session = session();
        try {
            $json = $this->request->getJSON();

            $data = [
                'titulo'       => trim($json->titulo),
                'tipo'         => trim($json->tipo),
                'periodo'      => trim($json->periodo),
                'descripcion'  => trim($json->descripcion),
                'fecha_inicio' => $json->fecha_inicio,
                'fecha_fin'    => $json->fecha_fin,
                'estatus'      => trim($json->estatus),
                'importancia'  => trim($json->importancia),
                'urgencia'     => trim($json->urgencia),
                'gruposJson'   => $json->gruposJson,
                'email'        => $session->get('email')
            ];

            
            $resultado = $this->proyectoModel->insertarProyecto($data);

            if ($resultado === true || (is_array($resultado) && $resultado[0]['Result'] === 'CORRECTO')) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Proyecto insertado correctamente',
                    'data'    => $resultado
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'No se pudo insertar el proyecto.',
                    'data'    => $resultado
                ]);
            }

        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error interno del servidor: ' . $e->getMessage()
            ]);
        }
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
            'tituloTop' => $tituloTopbar,
            'periodoSelectNombre' => $session->get('periodoSelectNombre')
        ]);

        $estados = $this->periodoModel->traerEstados();

        $view .= view('Dashboard/modal_periodo');
        $view .= view('Dashboard/modal_resetPeriodo');
        $view .= view('Dashboard/modal_proyectosYperiodos');
        $view .= view('Dashboard/modal_periodoNuevo', [
            'estados' => $estados
        ]);
        $view .= view('layouts/footer');
        return $view;
    }

    public function traerPorPeriodo($idPeriodo)
    {
        try {
            $data = $this->proyectoModel->traerProyectos($idPeriodo);
            return $this->response->setJSON($data);
        } catch (\Exception $e) {
            return $this->response->setStatusCode(500)->setJSON(['error' => $e->getMessage()]);
        }
    }


    public function seleccionarPeriodo()
    {
        $session = session();
        $id = $this->request->getPost('idPeriodo');
        $periodo = $this->request->getPost('periodo');
        if ($id && $periodo) {
            $session->set('periodoSelect', $id);
            $session->set('periodoSelectNombre', $periodo);
            return $this->response->setJSON(['success' => true]);
        }
        return $this->response->setJSON(['success' => false]);
    }

    public function resetearPeriodo() {
        $session = session();
        $session->set('periodoSelect', 0);
        $session->set('periodoSelectNombre', '');
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
        $session = session();
        try {
            $json = $this->request->getJSON();

            $data = [
                'periodo' => trim($json->periodo),
                'fecha_inicio' => $json->fecha_inicio,
                'fecha_fin' => $json->fecha_fin,
                'estatus' => $json->estatus 
            ];

            $resultado = $this->periodoModel->insertarPeriodo($data, $session->get('email'));

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
            'tituloTop' => $tituloTopbar,
            'periodoSelectNombre' => $session->get('periodoSelectNombre')
        ]);

        $view .= view('layouts/footer');
        return $view;
    }

    public function tareas($proyecto, $idProyecto) {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        if ($session->get('periodoSelectNombre') == '') {
            return redirect()->to('/periodos');
        }

        $rol = $this->usuarioModel->traerRol($session->get('email'));

        $titulo = 'Tareas';
        $css = 'tareas.css';
        $cargarJS = true;
        $js = 'tareas.js';
        $tituloTopbar = 'Agregar Tarea';

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
            'vistaExtra' => view('Dashboard/tareas'),
            'tituloTop' => $tituloTopbar,
            'periodoSelectNombre' => $session->get('periodoSelectNombre')
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
            'tituloTop' => $tituloTopbar,
            'periodoSelectNombre' => $session->get('periodoSelectNombre')
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
            'tituloTop' => $tituloTopbar,
            'periodoSelectNombre' => $session->get('periodoSelectNombre')
        ]);

        $view .= view('layouts/footer');
        return $view;
    }

    public function configuracion() {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $rol = $this->usuarioModel->traerRol($session->get('email'));

        $titulo = 'Configuración';
        $css = 'configuracion.css';
        $cargarJS = true;
        $js = 'configuracion.js';
        $tituloTopbar = 'Configuración';

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
            'vistaExtra' => view('Dashboard/configuraciones'),
            'tituloTop' => $tituloTopbar,
            'periodoSelectNombre' => $session->get('periodoSelectNombre')
        ]);

        $view .= view('layouts/footer');
        return $view;
    }

}
