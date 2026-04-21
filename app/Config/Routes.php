<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// home
$routes->get('/', 'Home::index');

// recetas

$routes->get('/receta', 'Receta::detalle');
$routes->get('/crear-receta', 'Receta::crear', ['filter' => 'auth']);
$routes->post('/guardar-receta', 'Receta::guardar', ['filter' => 'auth']);

$routes->get('/recetas', 'Receta::index');
$routes->get('/categorias', 'Receta::categorias');
$routes->get('/guardados', 'Receta::guardados');
$routes->get('/receta/(:num)', 'Receta::detalle/$1');
$routes->get('/categoria/(:num)', 'Receta::verCategoria/$1');
// login

$routes->get('/login', 'Usuario::login');
$routes->get('/registro', 'Usuario::registro');
$routes->get('/guardados', 'Usuario::guardados');

$routes->post('/guardar-usuario', 'Usuario::guardar'); // Esta procesa el registro
$routes->post('/procesar-login', 'Usuario::procesarLogin'); // Esta procesa el login
$routes->get('/logout', 'Usuario::salir'); // Esta cierra sesión

