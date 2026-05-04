<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// home
$routes->get('/', 'Home::index');

// recetas

$routes->get('/receta', 'Receta::detalle');
$routes->get('/crear-receta', 'Receta::mostrarFormularioReceta', ['filter' => 'auth']);
$routes->post('/guardar-receta', 'Receta::validarReceta', ['filter' => 'auth']);
$routes->get('/obtener-categorias', 'Receta::obtenerCategorias');


$routes->get('/recetas', 'Receta::index');
$routes->get('/categorias', 'Receta::categorias');
$routes->get('/guardados', 'Receta::guardados');
$routes->get('/receta/(:num)', 'Receta::detalle/$1');
$routes->get('/categoria/(:num)', 'Receta::verCategoria/$1');
// login

$routes->get('/login', 'Usuario::login');
$routes->get('/registro', 'Usuario::registro');
$routes->get('/guardados', 'Usuario::guardados');

$routes->post('/guardar-usuario', 'Usuario::guardar'); 
$routes->post('/procesar-login', 'Usuario::procesarLogin'); 
$routes->get('/logout', 'Usuario::salir'); 


// valoracion de recetas 
$routes->post('/valorar-receta-manual', 'Receta::verificarUsuario');

// reseñas
$routes->post('/guardar-resena', 'Receta::guardarResena', ['filter' => 'auth']);

$routes->post('/votar-resena', 'Receta::votarResena', ['filter' => 'auth']);