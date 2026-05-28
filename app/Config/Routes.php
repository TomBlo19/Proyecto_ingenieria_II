<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// home
$routes->get('/', 'Receta::inicio');

// recetas

$routes->get('/receta', 'Receta::detalle');
$routes->get('/crear-receta', 'Receta::mostrarFormularioReceta', ['filter' => 'auth']);
$routes->post('/guardar-receta', 'Receta::guardarReceta', ['filter' => 'auth']);
$routes->get('/obtener-categorias', 'Categoria::obtenerCategorias');


$routes->get('/recetas', 'Receta::index');
$routes->get('/categorias', 'Categoria::categorias');
$routes->get('/guardados', 'Receta::guardados');
$routes->get('/receta/(:num)', 'Receta::detalle/$1');
$routes->get('/categoria/(:num)', 'Categoria::verRecetas/$1');

// login

$routes->get('/login', 'Usuario::login');
$routes->get('/registro', 'Usuario::registro');
$routes->get('/guardados', 'Usuario::guardados');

$routes->post('/guardar-usuario', 'Usuario::guardar'); 
$routes->post('/procesar-login', 'Usuario::procesarLogin'); 
$routes->get('/logout', 'Usuario::salir'); 


// valoracion de recetas 
$routes->post('/valorar-receta-manual', 'VotoReceta::valorarReceta');

// reseñas
$routes->post('/guardar-resena', 'Resena::guardarResena', ['filter' => 'auth']);

$routes->post('/votar-resena', 'VotoResena::votarResena', ['filter' => 'auth']);