<?php 
require_once __DIR__ . '/../includes/app.php';

use MVC\Router;
use Controllers\AppController;
use Controllers\LoginController;
use Controllers\RegistroController;
use Controllers\AplicacionController;
use Controllers\PermisosController;
use Controllers\AsignacionController; // ← FALTABA ESTO

$router = new Router();
$router->setBaseURL('/' . $_ENV['APP_NAME']);

$router->get('/', [LoginController::class,'renderizarPagina']);

// Rutas para Login
$router->get('/login', [LoginController::class,'renderizarPagina']);
$router->post('/login', [LoginController::class,'login']);
$router->get('/logout', [LoginController::class,'logout']);
$router->get('/inicio', [LoginController::class,'renderInicio']);

//Ruta para Registro
$router->get('/registro', [RegistroController::class,'renderizarPagina']);
$router->post('/registro/guardarAPI', [RegistroController::class,'guardarAPI']);
$router->get('/registro/buscarAPI', [RegistroController::class,'buscarAPI']);
$router->get('/registro/eliminarAPI', [RegistroController::class,'eliminarAPI']);
$router->post('/registro/modificarAPI', [RegistroController::class, 'modificarAPI']); // ← CORREGIDO A POST

//Ruta para aplicaciones
$router->get('/aplicacion', [AplicacionController::class, 'renderizarPagina']);
$router->post('/aplicacion/guardarAPI', [AplicacionController::class, 'guardarAPI']);
$router->get('/aplicacion/buscarAPI', [AplicacionController::class, 'buscarAPI']);
$router->post('/aplicacion/modificarAPI', [AplicacionController::class, 'modificarAPI']);
$router->get('/aplicacion/eliminar', [AplicacionController::class, 'EliminarAPI']);

//Ruta para permisos
$router->get('/permisos', [PermisosController::class, 'renderizarPagina']);
$router->post('/permisos/guardarAPI', [PermisosController::class, 'guardarAPI']);
$router->get('/permisos/buscarAPI', [PermisosController::class, 'buscarAPI']);
$router->post('/permisos/modificarAPI', [PermisosController::class, 'modificarAPI']);
$router->get('/permisos/eliminar', [PermisosController::class, 'EliminarAPI']);
$router->get('/permisos/buscarAplicacionesAPI', [PermisosController::class, 'buscarAplicacionesAPI']);
$router->get('/permisos/buscarUsuariosAPI', [PermisosController::class, 'buscarUsuariosAPI']);

//Ruta para asignacion de permisos
$router->get('/asignacion', [AsignacionController::class, 'renderizarPagina']);
$router->post('/asignacion/guardarAPI', [AsignacionController::class, 'guardarAPI']);
$router->get('/asignacion/buscarAPI', [AsignacionController::class, 'buscarAPI']);
$router->post('/asignacion/modificarAPI', [AsignacionController::class, 'modificarAPI']);
$router->get('/asignacion/eliminar', [AsignacionController::class, 'EliminarAPI']);

$router->get('/asignacion/buscarUsuariosAPI', [AsignacionController::class, 'buscarUsuariosAPI']);
$router->get('/asignacion/buscarAplicacionesAPI', [AsignacionController::class, 'buscarAplicacionesAPI']);
$router->get('/asignacion/buscarPermisosAPI', [AsignacionController::class, 'buscarPermisosAPI']);

// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();