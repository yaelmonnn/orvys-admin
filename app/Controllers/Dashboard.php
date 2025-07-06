<?php

namespace App\Controllers;

use App\Models\UsuarioModel;
use App\Models\PeriodoModel;
use App\Models\ProyectoModel;
use App\Models\TareaModel;
use CodeIgniter\HTTP\ResponseInterface;

class Dashboard extends BaseController
{

    protected $usuarioModel;
    protected $periodoModel;
    protected $proyectoModel;
    protected $tareaModel;

    public function __construct()
    {
        $this->usuarioModel = new UsuarioModel();
        $this->periodoModel = new PeriodoModel();
        $this->proyectoModel = new ProyectoModel();
        $this->tareaModel = new TareaModel();
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
        $sprints = $this->proyectoModel->traerSprints();
        $etapas = $this->tareaModel->traerEtapas();

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

        $view .= view('Dashboard/modal_proyectoNuevo', [
            'estados' => $estados,
            'importancias' => $importancias,
            'urgencias' => $urgencias,
            'periodos' => $periodos,
            'grupos' => $grupos,
            'tipos' => $tipos,
            'sprints' => $sprints,
            'fechaFinPeriodo' => $session->get('fechaFinPeriodo')
        ]);
        $view .= view('Dashboard/modal_backlog', [
            'etapas' => $etapas
        ]);
        $view .= view('Dashboard/modal_editProyecto', [
            'estados' => $estados,
            'importancias' => $importancias,
            'urgencias' => $urgencias,
            'tipos' => $tipos
        ]);
        $view .= view('layouts/footer');
        return $view;


    }

    public function traerBacklog($idProyecto)
    {
        try {
            $data = $this->tareaModel->traerProductBacklog($idProyecto);
            return $this->response->setJSON($data);
        } catch (\Exception $e) {
            return $this->response->setStatusCode(500)->setJSON(['error' => $e->getMessage()]);
        }
    }

    
    public function traerSprintBacklog($idProyecto, $idEtapa, $idSprint)
    {
        try {
            $data = $this->tareaModel->traerSprintBacklog($idProyecto, $idEtapa, $idSprint);
            return $this->response->setJSON($data);
        } catch (\Exception $e) {
            return $this->response->setStatusCode(500)->setJSON(['error' => $e->getMessage()]);
        }
    }

    public function traerSprints($idProyecto)
    {
        try {
            $data = $this->tareaModel->traerSprints($idProyecto);
            return $this->response->setJSON($data);
        } catch (\Exception $e) {
            return $this->response->setStatusCode(500)->setJSON(['error' => $e->getMessage()]);
        }
    }

    public function avanzarTarea($idTarea, $etapaActualId)
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Petición no válida'
            ]);
        }

        try {
            $resultado = $this->tareaModel->avanzarTarea($etapaActualId, $idTarea);

            return $this->response->setJSON([
                'success' => $resultado['success'],
                'message' => $resultado['message']
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error interno del servidor: ' . $e->getMessage()
            ]);
        }
    }

    public function cancelarTarea($idTarea)
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Petición no válida'
            ]);
        }

        try {
            $resultado = $this->tareaModel->eliminarTarea($idTarea);

            return $this->response->setJSON([
                'success' => $resultado['success'],
                'message' => $resultado['message']
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error interno del servidor: ' . $e->getMessage()
            ]);
        }
    }

    public function eliminarProyecto($idProyecto)
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Petición no válida'
            ]);
        }

        try {
            $resultado = $this->proyectoModel->eliminarProyecto($idProyecto);

            return $this->response->setJSON([
                'success' => $resultado['success'],
                'message' => $resultado['message'] ?? 'Operación completada'
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error interno del servidor: ' . $e->getMessage()
            ]);
        }
    }

    public function editarProyecto()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Petición no válida'
            ]);
        }

        try {
            $data = $this->request->getJSON(true);

            if (
                empty($data['proyecto_id']) ||
                empty($data['titulo']) ||
                empty($data['descripcion']) ||
                empty($data['tipo_id']) ||
                empty($data['estatus_id']) ||
                empty($data['importancia_id']) ||
                empty($data['urgencia_id'])
            ) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Todos los campos son obligatorios.'
                ]);
            }

            $resultado = $this->proyectoModel->editarProyecto($data);

            return $this->response->setJSON([
                'success' => $resultado['success'],
                'message' => $resultado['message']
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error interno del servidor: ' . $e->getMessage()
            ]);
        }
    }

    public function eliminarPeriodo($idPeriodo)
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Petición no válida'
            ]);
        }

        try {
            $resultado = $this->periodoModel->eliminarPeriodo($idPeriodo);

            return $this->response->setJSON([
                'success' => $resultado['success'],
                'message' => $resultado['message'] ?? 'Operación completada'
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error interno del servidor: ' . $e->getMessage()
            ]);
        }
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
                'email'        => $session->get('email'),
                'sprint_id'    => trim($json->sprint_id)
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
                'periodoSelect' => $session->get('periodoSelect'),
                'fechaFinPeriodo' => $session->get('fechaFinPeriodo')
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
        $fechaFin = $this->request->getPost('fechaFin');
        if ($id && $periodo && $fechaFin) {
            $session->set('periodoSelect', $id);
            $session->set('periodoSelectNombre', $periodo);
            $session->set('fechaFinPeriodo', $fechaFin);
            return $this->response->setJSON(['success' => true]);
        }
        return $this->response->setJSON(['success' => false]);
    }

    public function resetearPeriodo() {
        $session = session();
        $session->set('periodoSelect', 0);
        $session->set('periodoSelectNombre', '');
        $session->set('fechaFinPeriodo', '0000-00-00');
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

    public function insertarTarea()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Petición no válida'
            ]);
        }
        $session = session();

        try {
            $data = [
                'nombre'            => trim($this->request->getPost('nombreHistoria')),
                'cargo'             => trim($this->request->getPost('cargoSolicitante')),
                'urgencia'          => trim($this->request->getPost('nivelUrgencia')),
                'complejidad'       => trim($this->request->getPost('nivelComplejidad')),
                'descripcion'       => trim($this->request->getPost('descripcion')),
                'modulo'            => trim($this->request->getPost('moduloRelacionado')),
                'duracion'          => (int)$this->request->getPost('duracionEstimada'),
                'estatus'           => trim($this->request->getPost('estatusTarea')),
                'observaciones_tec' => trim($this->request->getPost('observacionesTecnicas')),
                'adicionales'       => trim($this->request->getPost('comentariosAdicionales')),
                'pruebas_unitarias' => trim($this->request->getPost('pruebasUnitarias')),
                'usuario'           => $session->get('email'),
                'proyecto_id'       => (int)$this->request->getPost('idProyecto'),
                'sprint_id'         => (int)$this->request->getPost('sprintAsignado'),
                'fr_inicio'         => $this->request->getPost('fechaRegistro'),
                'fr_fin'            => $this->request->getPost('fechaLimite')
            ];

            $resultado = $this->tareaModel->insertarTarea($data);

            if ($resultado['success']) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => $resultado['resultado']
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => $resultado['error'] ?? 'Error desconocido al insertar la tarea.'
                ]);
            }

        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error interno del servidor: ' . $e->getMessage()
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
        $view .= view('Dashboard/modal_infoUser');
        $view .= view('layouts/footer');
        return $view;
    }

    public function usuariosGrupos($idUsuario) {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Petición no válida'
            ]);
        }

        try {
            $grupos = $this->usuarioModel->traerGruposPorUsuario($idUsuario);
            return $this->response->setJSON([
                'success' => true,
                'grupos' => $grupos
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error interno del servidor: ' . $e->getMessage()
            ]);
        }
    }

     public function eliminarUsuario($idUsuario)
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Petición no válida'
            ]);
        }

        try {
            $resultado = $this->usuarioModel->eliminarUsuario($idUsuario);

            return $this->response->setJSON([
                'success' => $resultado['success'],
                'message' => $resultado['message'] ?? 'Operación completada'
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error interno del servidor: ' . $e->getMessage()
            ]);
        }
    }

    public function tareas($proyecto, $idProyecto, $fechaFin) {
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
            'vistaExtra' => view('Dashboard/tareas', [
                'proyecto' => $proyecto,
                'idProyecto' => $idProyecto,
                'estados' => $this->tareaModel->traerEstados(),
                'urgencias' => $this->tareaModel->traerUrgencias(),
                'cargos' => $this->tareaModel->traerCargos(),
                'complejidades' => $this->tareaModel->traerComplejidad(),
                'sprints' => $this->tareaModel->traerSprints($idProyecto),
                'fechaFin' => $fechaFin
            ]),
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
