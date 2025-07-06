<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Login::index');
$routes->get('/login', 'Login::login');
$routes->get('/registro', 'Login::registro');
$routes->get('/dashboard', 'Login::dashboard');
$routes->get('/logout', 'Login::logout');
$routes->get('/proyectos', 'Dashboard::proyectos');
$routes->get('/periodos', 'Dashboard::periodos');
$routes->get('/usuarios', 'Dashboard::usuarios');
$routes->get('/grupos', 'Dashboard::grupos');
$routes->get('/catalogos', 'Dashboard::catalogos');
$routes->get('/configuracion', 'Dashboard::configuracion');
$routes->post('/usuario/registrar', 'Login::registrar_usuario');
$routes->post('/login/validar', 'Login::validarLogin');
$routes->post('/periodos/seleccionar', 'Dashboard::seleccionarPeriodo');
$routes->post('/periodos/reset', 'Dashboard::resetearPeriodo');
$routes->post('/periodos/insertar', 'Dashboard::insertarPeriodo');
$routes->post('/tareas/guardar', 'Dashboard::insertarTarea');
$routes->post('/proyectos/insertar', 'Dashboard::insertarProyecto');
$routes->get('/proyectos/traerPorPeriodo/(:num)', 'Dashboard::traerPorPeriodo/$1');

$routes->get('/sprintbacklog/sprint/(:num)', 'Dashboard::traerSprints/$1');
$routes->get('/tareas/(:any)/(:num)/(:any)', 'Dashboard::tareas/$1/$2/$3');
$routes->get('/backlog/traerPorProyecto/(:num)', 'Dashboard::traerBacklog/$1');
$routes->get('/sprintbacklog/traerPorSprintEtapa/(:num)/(:num)/(:num)', 'Dashboard::traerSprintBacklog/$1/$2/$3');

$routes->post('/sprintbacklog/avanzarTarea/(:num)/(:num)', 'Dashboard::avanzarTarea/$1/$2');
$routes->post('/sprintbacklog/cancelarTarea/(:num)', 'Dashboard::cancelarTarea/$1');
$routes->post('/proyectos/eliminar/(:num)', 'Dashboard::eliminarProyecto/$1');

$routes->post('/proyectos/editar', 'Dashboard::editarProyecto');

$routes->post('/periodos/eliminar/(:num)', 'Dashboard::eliminarPeriodo/$1');

$routes->post('/usuarios/grupos/(:num)', 'Dashboard::usuariosGrupos/$1');
$routes->post('/usuarios/eliminar/(:num)', 'Dashboard::eliminarUsuario/$1');




