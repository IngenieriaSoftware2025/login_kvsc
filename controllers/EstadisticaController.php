<?php

namespace Controllers;

use Exception;
use Model\ActiveRecord;
use MVC\Router;

class EstadisticaController extends ActiveRecord {
    
    public static function renderizarPagina(Router $router) {
        $router->render('estadistica/index', []);
    }

    public static function buscarAPI() {
        try {
            $sql = "SELECT 
                m.mar_nombre || ' ' || i.inv_modelo as producto, 
                i.inv_id,
                COALESCE(SUM(v.ven_cantidad), 0) as cantidad 
                FROM inventario i
                INNER JOIN marca m ON i.inv_marca_id = m.mar_id 
                LEFT JOIN venta v ON v.ven_inventario_id = i.inv_id AND v.ven_situacion = 1
                WHERE i.inv_situacion = 1
                GROUP BY i.inv_id, producto
                ORDER BY cantidad ASC";
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
                'detalle' => $e->getMessage()
            ]);
        }
    }

    public static function clientesTopAPI() {
        try {
            $sql = "SELECT 
                c.cli_nombre as nombres,
                c.cli_apellido as apellidos,
                COALESCE(SUM(v.ven_cantidad), 0) as total_productos
                FROM cliente c
                LEFT JOIN venta v ON v.ven_cliente_id = c.cli_id AND v.ven_situacion = 1
                WHERE c.cli_situacion = 1
                GROUP BY c.cli_id, c.cli_nombre, c.cli_apellido
                ORDER BY total_productos DESC
                LIMIT 10";
            $data = self::fetchArray($sql);

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Top clientes obtenidos correctamente',
                'data' => $data
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al obtener top clientes',
                'detalle' => $e->getMessage()
            ]);
        }
    }

    public static function ventasPorMesAPI() {
        try {
            $sql = "SELECT 
                SUM(CASE WHEN MONTH(v.ven_fecha) = 1 THEN 1 ELSE 0 END) AS enero,
                SUM(CASE WHEN MONTH(v.ven_fecha) = 2 THEN 1 ELSE 0 END) AS febrero,
                SUM(CASE WHEN MONTH(v.ven_fecha) = 3 THEN 1 ELSE 0 END) AS marzo,
                SUM(CASE WHEN MONTH(v.ven_fecha) = 4 THEN 1 ELSE 0 END) AS abril,
                SUM(CASE WHEN MONTH(v.ven_fecha) = 5 THEN 1 ELSE 0 END) AS mayo,
                SUM(CASE WHEN MONTH(v.ven_fecha) = 6 THEN 1 ELSE 0 END) AS junio,
                SUM(CASE WHEN MONTH(v.ven_fecha) = 7 THEN 1 ELSE 0 END) AS julio,
                SUM(CASE WHEN MONTH(v.ven_fecha) = 8 THEN 1 ELSE 0 END) AS agosto,
                SUM(CASE WHEN MONTH(v.ven_fecha) = 9 THEN 1 ELSE 0 END) AS septiembre,
                SUM(CASE WHEN MONTH(v.ven_fecha) = 10 THEN 1 ELSE 0 END) AS octubre,
                SUM(CASE WHEN MONTH(v.ven_fecha) = 11 THEN 1 ELSE 0 END) AS noviembre,
                SUM(CASE WHEN MONTH(v.ven_fecha) = 12 THEN 1 ELSE 0 END) AS diciembre
                FROM venta v
                WHERE v.ven_situacion = 1";
            $data = self::fetchFirst($sql);

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Ventas por mes obtenidas correctamente',
                'data' => $data
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    public static function reparacionesPorEstadoAPI() {
        try {
            $sql = "SELECT 
                rep_estado as estado,
                COUNT(*) as cantidad
                FROM reparacion 
                WHERE rep_situacion = 1
                GROUP BY rep_estado
                ORDER BY cantidad DESC";
            $data = self::fetchArray($sql);

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Reparaciones por estado obtenidas correctamente',
                'data' => $data
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al obtener reparaciones por estado',
                'detalle' => $e->getMessage()
            ]);
        }
    }
}