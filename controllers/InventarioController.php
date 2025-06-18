<?php

namespace Controllers;

use Exception;
use Model\ActiveRecord;
use MVC\Router;
use Model\Inventario;

class InventarioController extends ActiveRecord {
    
    public static function renderizarPagina(Router $router) {
        $router->render('inventario/index', []);
    }

    public static function guardarAPI() {
        getHeadersApi();

        $_POST['inv_modelo'] = ucwords(strtolower(trim(htmlspecialchars($_POST['inv_modelo']))));
        
        $cantidad_modelo = strlen($_POST['inv_modelo']);
        
        if ($cantidad_modelo < 2) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'El modelo debe tener más de 1 caracteres'
            ]);
            exit;
        }

        $_POST['inv_marca_id'] = filter_var($_POST['inv_marca_id'], FILTER_SANITIZE_NUMBER_INT);
        if (empty($_POST['inv_marca_id']) || $_POST['inv_marca_id'] <= 0) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Debe seleccionar una marca válida'
            ]);
            exit;
        }

        $_POST['inv_precio_compra'] = filter_var($_POST['inv_precio_compra'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        if ($_POST['inv_precio_compra'] <= 0) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'El precio de compra debe ser mayor a 0'
            ]);
            exit;
        }

        $_POST['inv_precio_venta'] = filter_var($_POST['inv_precio_venta'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        if ($_POST['inv_precio_venta'] <= 0) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'El precio de venta debe ser mayor a 0'
            ]);
            exit;
        }

        if ($_POST['inv_precio_venta'] <= $_POST['inv_precio_compra']) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'El precio de venta debe ser mayor al precio de compra'
            ]);
            exit;
        }

        $_POST['inv_stock'] = filter_var($_POST['inv_stock'], FILTER_SANITIZE_NUMBER_INT);
        if ($_POST['inv_stock'] < 0) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'El stock no puede ser negativo'
            ]);
            exit;
        }

        $_POST['inv_descripcion'] = ucwords(strtolower(trim(htmlspecialchars($_POST['inv_descripcion']))));

        $modeloExistente = "SELECT COUNT(*) as total FROM inventario WHERE inv_modelo = '{$_POST['inv_modelo']}' AND inv_marca_id = {$_POST['inv_marca_id']} AND inv_situacion = 1";
        $resultadoModelo = self::fetchArray($modeloExistente);

        if ($resultadoModelo[0]['total'] > 0) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 2,
                'mensaje' => 'El modelo ingresado ya está registrado para esta marca',
                'campo' => 'inv_modelo',
                'tipo' => 'duplicado_modelo'
            ]);
            exit;
        }

        try {
            $inventario = new Inventario($_POST);
            $resultado = $inventario->crear();

            if ($resultado['resultado'] == 1) {
                http_response_code(200);
                echo json_encode([
                    'codigo' => 1,
                    'mensaje' => 'Producto registrado correctamente en el inventario',
                ]);
                exit;
            } else {
                http_response_code(500);
                echo json_encode([
                    'codigo' => 0,
                    'mensaje' => 'Error al registrar el producto',
                ]);
                exit;
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al registrar el producto',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

    public static function buscarAPI() {
        getHeadersApi();

        try {
            $sql = "SELECT i.*, m.mar_nombre 
                    FROM inventario i 
                    INNER JOIN marca m ON i.inv_marca_id = m.mar_id 
                    WHERE i.inv_situacion = 1 
                    ORDER BY m.mar_nombre, i.inv_modelo";
            $data = self::fetchArray($sql);

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Inventario obtenido correctamente',
                'data' => $data
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al obtener el inventario',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

    public static function buscarMarcasAPI() {
        getHeadersApi();

        try {
            $sql = "SELECT * FROM marca WHERE mar_situacion = 1 ORDER BY mar_nombre";
            $data = self::fetchArray($sql);

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Marcas obtenidas correctamente',
                'data' => $data
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al obtener las marcas',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

    public static function modificarAPI() {
        getHeadersApi();

        $id = $_POST['inv_id'];

        $inventarioExistente = Inventario::find($id);
        if (!$inventarioExistente) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'El producto no existe'
            ]);
            return;
        }

        $_POST['inv_modelo'] = ucwords(strtolower(trim(htmlspecialchars($_POST['inv_modelo']))));
        $_POST['inv_marca_id'] = filter_var($_POST['inv_marca_id'], FILTER_SANITIZE_NUMBER_INT);
        $_POST['inv_precio_compra'] = filter_var($_POST['inv_precio_compra'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $_POST['inv_precio_venta'] = filter_var($_POST['inv_precio_venta'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $_POST['inv_stock'] = filter_var($_POST['inv_stock'], FILTER_SANITIZE_NUMBER_INT);
        $_POST['inv_descripcion'] = ucwords(strtolower(trim(htmlspecialchars($_POST['inv_descripcion']))));

        if ($_POST['inv_precio_venta'] <= $_POST['inv_precio_compra']) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'El precio de venta debe ser mayor al precio de compra'
            ]);
            return;
        }

        $modeloExistente = "SELECT COUNT(*) as total FROM inventario WHERE inv_modelo = '{$_POST['inv_modelo']}' AND inv_marca_id = {$_POST['inv_marca_id']} AND inv_situacion = 1 AND inv_id != $id";
        $resultadoModelo = self::fetchArray($modeloExistente);

        if ($resultadoModelo[0]['total'] > 0) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 2,
                'mensaje' => 'El modelo ingresado ya está registrado para esta marca',
                'campo' => 'inv_modelo',
                'tipo' => 'duplicado_modelo'
            ]);
            return;
        }

        try {
            $datosActualizar = [
                'inv_modelo' => $_POST['inv_modelo'],
                'inv_marca_id' => $_POST['inv_marca_id'],
                'inv_precio_compra' => $_POST['inv_precio_compra'],
                'inv_precio_venta' => $_POST['inv_precio_venta'],
                'inv_stock' => $_POST['inv_stock'],
                'inv_descripcion' => $_POST['inv_descripcion']
            ];

            $data = Inventario::find($id);
            $data->sincronizar($datosActualizar);
            $data->actualizar();

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'La información del producto ha sido modificada exitosamente'
            ]);

        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al modificar el producto',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

    public static function EliminarAPI() {
        try {
            $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

            $ejecutar = Inventario::EliminarInventario($id);

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'El registro ha sido eliminado correctamente'
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al Eliminar',
                'detalle' => $e->getMessage(),
            ]);
        }
    }
}