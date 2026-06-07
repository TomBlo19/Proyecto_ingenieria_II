<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// home
$routes->get('/', 'API\RecetaApi::inicio');

// recetas

$routes->get('/receta', 'API\RecetaApi::detalle');
$routes->get('/crear-receta', 'API\RecetaApi::mostrarFormularioReceta', ['filter' => 'auth']);
$routes->post('/guardar-receta', 'API\RecetaApi::guardarReceta', ['filter' => 'auth']);
$routes->get('/obtener-categorias', 'API\NavegacionApi::obtenerCategorias');
$routes->get('/ranking', 'API\RecetaApi::ranking');
$routes->get('/recetas', 'API\RecetaApi::listarRecetas');
$routes->get('/categorias', 'API\NavegacionApi::categorias');
$routes->get('/guardados', 'API\NavegacionApi::guardados');

$routes->get('/receta/(:num)', 'API\RecetaApi::detalle/$1');

$routes->get('/categoria/(:num)', 'API\RecetaApi::verRecetasCategoria/$1');
// login


$routes->get('/login', 'API\NavegacionApi::login');
$routes->get('/registro', 'API\NavegacionApi::registro');
$routes->get('/guardados', 'API\NavegacionApi::guardados');

$routes->post('/guardar-usuario', 'API\NavegacionApi::guardar'); 
$routes->post('/procesar-login', 'API\NavegacionApi::procesarLogin'); 
$routes->get('/logout', 'API\NavegacionApi::salir'); 


// valoracion de recetas 
$routes->post('/valorar-receta-manual', 'API\RecetaApi::valorarReceta');

// reseñas
$routes->post('/guardar-resena', 'API\ResenaApi::guardarResena', ['filter' => 'auth']);

$routes->post('/votar-resena', 'API\ResenaApi::votarResena', ['filter' => 'auth']);