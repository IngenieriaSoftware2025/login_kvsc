<?php

namespace Controllers;

use Exception;
use Model\ActiveRecord;
use MVC\Router;
use Model\Venta;

class VentaController extends ActiveRecord {
    
    public static function renderizarPagina(Router $router) {
        $router->render('venta/index', []);
    }

    public static function guardarAPI() {
        getHeadersApi();

        $_POST['ven_cliente_id'] = filter_var($_POST['ven_cliente_id'], FILTER_SANITIZE_NUMBER_INT);
        if (empty($_POST['ven_cliente_id']) || $_POST['ven_cliente_id'] <= 0) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Debe seleccionar un cliente válido'
            ]);
            exit;
        }

        $_POST['ven_inventario_id'] = filter_var($_POST['ven_inventario_id'], FILTER_SANITIZE_NUMBER_INT);
        if (empty($_POST['ven_inventario_id']) || $_POST['ven_inventario_id'] <= 0) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Debe seleccionar un producto válido'
            ]);
            exit;
        }

        $_POST['ven_cantidad'] = filter_var($_POST['ven_cantidad'], FILTER_SANITIZE_NUMBER_INT);
        if ($_POST['ven_cantidad'] <= 0) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'La cantidad debe ser mayor a 0'
            ]);
            exit;
        }

        $stockSQL = "SELECT inv_stock, inv_precio_venta FROM inventario WHERE inv_id = {$_POST['ven_inventario_id']} AND inv_situacion = 1";
        $stockData = self::fetchArray($stockSQL);

        if (empty($stockData)) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'El producto seleccionado no existe o está inactivo'
            ]);
            exit;
        }

        $stockDisponible = $stockData[0]['inv_stock'];
        $precioUnitario = $stockData[0]['inv_precio_venta'];

        if ($_POST['ven_cantidad'] > $stockDisponible) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 2,
                'mensaje' => "Stock insuficiente. Disponible: {$stockDisponible} unidades",
                'campo' => 'ven_cantidad',
                'tipo' => 'stock_insuficiente'
            ]);
            exit;
        }


        $_POST['ven_precio_unitario'] = $precioUnitario;
        $_POST['ven_total'] = $_POST['ven_cantidad'] * $precioUnitario;
        $_POST['ven_fecha'] = date('Y-m-d H:i:s');
        $_POST['ven_observaciones'] = trim(htmlspecialchars($_POST['ven_observaciones']));

        try {

            $venta = new Venta($_POST);
            $resultado = $venta->crear();

            if ($resultado['resultado'] == 1) {

                $nuevoStock = $stockDisponible - $_POST['ven_cantidad'];
                $updateStock = "UPDATE inventario SET inv_stock = {$nuevoStock} WHERE inv_id = {$_POST['ven_inventario_id']}";
                self::SQL($updateStock);

                $ventaId = $resultado['id'];
                $clienteSQL = "SELECT cli_nombre, cli_apellido FROM cliente WHERE cli_id = {$_POST['ven_cliente_id']}";
                $clienteData = self::fetchArray($clienteSQL);
                $clienteNombre = $clienteData[0]['cli_nombre'] . ' ' . $clienteData[0]['cli_apellido'];

                $productoSQL = "SELECT i.inv_modelo, m.mar_nombre FROM inventario i INNER JOIN marca m ON i.inv_marca_id = m.mar_id WHERE i.inv_id = {$_POST['ven_inventario_id']}";
                $productoData = self::fetchArray($productoSQL);
                $productoNombre = $productoData[0]['mar_nombre'] . ' ' . $productoData[0]['inv_modelo'];

                $fechaActual = date('Y-m-d H:i:s');
                $historialSQL = "INSERT INTO historial_venta (his_venta_id, his_fecha, his_cliente, his_producto, his_cantidad, his_total) 
                                 VALUES ({$ventaId}, '{$fechaActual}', '{$clienteNombre}', '{$productoNombre}', {$_POST['ven_cantidad']}, {$_POST['ven_total']})";
                self::SQL($historialSQL);

                http_response_code(200);
                echo json_encode([
                    'codigo' => 1,
                    'mensaje' => 'Venta registrada correctamente',
                ]);
                exit;
            } else {
                http_response_code(500);
                echo json_encode([
                    'codigo' => 0,
                    'mensaje' => 'Error al registrar la venta',
                ]);
                exit;
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al registrar la venta',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

    public static function buscarAPI() {
        getHeadersApi();

        try {
            $sql = "SELECT v.*, 
                           c.cli_nombre, c.cli_apellido,
                           i.inv_modelo, m.mar_nombre
                    FROM venta v 
                    INNER JOIN cliente c ON v.ven_cliente_id = c.cli_id
                    INNER JOIN inventario i ON v.ven_inventario_id = i.inv_id
                    INNER JOIN marca m ON i.inv_marca_id = m.mar_id
                    WHERE v.ven_situacion = 1 
                    ORDER BY v.ven_fecha DESC";
            $data = self::fetchArray($sql);

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Ventas obtenidas correctamente',
                'data' => $data
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al obtener las ventas',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

    public static function buscarClientesAPI() {
        getHeadersApi();

        try {
            $sql = "SELECT cli_id, cli_nombre, cli_apellido, cli_nit FROM cliente WHERE cli_situacion = 1 ORDER BY cli_nombre, cli_apellido";
            $data = self::fetchArray($sql);

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Clientes obtenidos correctamente',
                'data' => $data
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al obtener los clientes',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

    public static function buscarProductosAPI() {
        getHeadersApi();

        try {
            $sql = "SELECT i.inv_id, i.inv_modelo, i.inv_precio_venta, i.inv_stock, m.mar_nombre 
                    FROM inventario i 
                    INNER JOIN marca m ON i.inv_marca_id = m.mar_id 
                    WHERE i.inv_situacion = 1 AND i.inv_stock > 0 
                    ORDER BY m.mar_nombre, i.inv_modelo";
            $data = self::fetchArray($sql);

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Productos obtenidos correctamente',
                'data' => $data
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al obtener los productos',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

    public static function modificarAPI() {
        getHeadersApi();

        $id = $_POST['ven_id'];

        $ventaExistente = Venta::find($id);
        if (!$ventaExistente) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'La venta no existe'
            ]);
            return;
        }

        $_POST['ven_observaciones'] = trim(htmlspecialchars($_POST['ven_observaciones']));

        try {
            $datosActualizar = [
                'ven_observaciones' => $_POST['ven_observaciones']
            ];

            $data = Venta::find($id);
            $data->sincronizar($datosActualizar);
            $data->actualizar();

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'La información de la venta ha sido modificada exitosamente'
            ]);

        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al modificar la venta',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

    public static function EliminarAPI() {
        try {
            $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

            $ventaSQL = "SELECT ven_inventario_id, ven_cantidad FROM venta WHERE ven_id = {$id}";
            $ventaData = self::fetchArray($ventaSQL);

            if (!empty($ventaData)) {
                $inventarioId = $ventaData[0]['ven_inventario_id'];
                $cantidad = $ventaData[0]['ven_cantidad'];

                $stockSQL = "SELECT inv_stock FROM inventario WHERE inv_id = {$inventarioId}";
                $stockData = self::fetchArray($stockSQL);
                $stockActual = $stockData[0]['inv_stock'];
                $nuevoStock = $stockActual + $cantidad;

                $updateStock = "UPDATE inventario SET inv_stock = {$nuevoStock} WHERE inv_id = {$inventarioId}";
                self::SQL($updateStock);

                $deleteHistorial = "DELETE FROM historial_venta WHERE his_venta_id = {$id}";
                self::SQL($deleteHistorial);

                $ejecutar = Venta::EliminarVenta($id);
            }

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'El registro ha sido eliminado correctamente y el stock ha sido restaurado'
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