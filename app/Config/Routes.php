<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('/receta', 'Receta::detalle');
$routes->get('/crear-receta', 'Receta::crear');
$routes->post('/guardar-receta', 'Receta::guardar');

$routes->get('/login', 'Usuario::login');
$routes->get('/registro', 'Usuario::registro');
$routes->post('/guardar-usuario', 'Usuario::guardar');

$routes->get('/recetas', 'Receta::index');
$routes->get('/categorias', 'Receta::categorias');
$routes->get('/guardados', 'Receta::guardados');