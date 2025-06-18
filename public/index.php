<?php 
require_once __DIR__ . '/../includes/app.php';

use MVC\Router;
use Controllers\AppController;
use Controllers\LoginController;
use Controllers\RegistroController;
use Controllers\AplicacionController;
use Controllers\PermisosController;
use Controllers\AsignacionController; 
use Controllers\MarcaController; 
use Controllers\ClienteController;
use Controllers\InventarioController;
use Controllers\VentaController;
use Controllers\ReparacionController;
use Controllers\EstadisticaController;

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

//Ruta para marcas
$router->get('/marca', [MarcaController::class, 'renderizarPagina']);
$router->post('/marca/guardarAPI', [MarcaController::class, 'guardarAPI']);
$router->get('/marca/buscarAPI', [MarcaController::class, 'buscarAPI']);
$router->post('/marca/modificarAPI', [MarcaController::class, 'modificarAPI']);
$router->get('/marca/eliminarAPI', [MarcaController::class, 'EliminarAPI']);

//Rutas para clientes
$router->get('/cliente', [ClienteController::class, 'renderizarPagina']);
$router->post('/cliente/guardarAPI', [ClienteController::class, 'guardarAPI']);
$router->get('/cliente/buscarAPI', [ClienteController::class, 'buscarAPI']);
$router->post('/cliente/modificarAPI', [ClienteController::class, 'modificarAPI']);
$router->get('/cliente/eliminarAPI', [ClienteController::class, 'EliminarAPI']);

// Rutas para inventarios de celulares
$router->get('/inventario', [InventarioController::class, 'renderizarPagina']);
$router->post('/inventario/guardarAPI', [InventarioController::class, 'guardarAPI']);
$router->get('/inventario/buscarAPI', [InventarioController::class, 'buscarAPI']);
$router->get('/inventario/buscarMarcasAPI', [InventarioController::class, 'buscarMarcasAPI']);
$router->post('/inventario/modificarAPI', [InventarioController::class, 'modificarAPI']);
$router->get('/inventario/eliminarAPI', [InventarioController::class, 'EliminarAPI']);

//Rutas para ventas
$router->get('/venta', [VentaController::class, 'renderizarPagina']);
$router->post('/venta/guardarAPI', [VentaController::class, 'guardarAPI']);
$router->get('/venta/buscarAPI', [VentaController::class, 'buscarAPI']);
$router->get('/venta/buscarClientesAPI', [VentaController::class, 'buscarClientesAPI']);
$router->get('/venta/buscarProductosAPI', [VentaController::class, 'buscarProductosAPI']);
$router->post('/venta/modificarAPI', [VentaController::class, 'modificarAPI']);
$router->get('/venta/eliminarAPI', [VentaController::class, 'EliminarAPI']);

//Rutas para reparaciones 
$router->get('/reparacion', [ReparacionController::class, 'renderizarPagina']);
$router->post('/reparacion/guardarAPI', [ReparacionController::class, 'guardarAPI']);
$router->get('/reparacion/buscarAPI', [ReparacionController::class, 'buscarAPI']);
$router->get('/reparacion/buscarClientesAPI', [ReparacionController::class, 'buscarClientesAPI']);
$router->post('/reparacion/modificarAPI', [ReparacionController::class, 'modificarAPI']);
$router->get('/reparacion/eliminarAPI', [ReparacionController::class, 'EliminarAPI']);

//Rutas para estadisticas
$router->get('/estadistica', [EstadisticaController::class, 'renderizarPagina']);
$router->get('/estadistica/buscarAPI', [EstadisticaController::class, 'buscarAPI']);
$router->get('/estadistica/clientesTopAPI', [EstadisticaController::class, 'clientesTopAPI']);
$router->get('/estadistica/ventasPorMesAPI', [EstadisticaController::class, 'ventasPorMesAPI']);
$router->get('/estadistica/reparacionesPorEstadoAPI', [EstadisticaController::class, 'reparacionesPorEstadoAPI']);

// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();