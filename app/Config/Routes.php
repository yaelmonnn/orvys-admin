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
$routes->post('/proyectos/insertar', 'Dashboard::insertarProyecto');
$routes->get('/proyectos/traerPorPeriodo/(:num)', 'Dashboard::traerPorPeriodo/$1');

