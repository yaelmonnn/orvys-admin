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
$routes->post('/usuario/registrar', 'Login::registrar_usuario');
$routes->post('/login/validar', 'Login::validarLogin');

