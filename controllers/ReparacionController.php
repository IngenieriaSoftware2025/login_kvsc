<?php

namespace Controllers;

use Exception;
use Model\ActiveRecord;
use MVC\Router;
use Model\Reparacion;

class ReparacionController extends ActiveRecord {
    
    public static function renderizarPagina(Router $router) {
        $router->render('reparacion/index', []);
    }

   public static function guardarAPI() {
    getHeadersApi();
    
    $cliente_id = (int)$_POST['rep_cliente_id'];
    $equipo = str_replace("'", "''", $_POST['rep_equipo']);
    $marca = str_replace("'", "''", $_POST['rep_marca']);
    $falla = str_replace("'", "''", $_POST['rep_falla']);
    $diagnostico = str_replace("'", "''", $_POST['rep_diagnostico'] ?? '');
    $costo = empty($_POST['rep_costo']) ? 'NULL' : $_POST['rep_costo'];
    $fecha_entrega = empty($_POST['rep_fecha_entrega']) ? 'NULL' : "'{$_POST['rep_fecha_entrega']}'";
    $estado = $_POST['rep_estado'];
    $observaciones = str_replace("'", "''", $_POST['rep_observaciones'] ?? '');

   $sql = "INSERT INTO reparacion (rep_cliente_id, rep_equipo, rep_marca, rep_falla, rep_diagnostico, rep_costo, rep_estado, rep_observaciones, rep_situacion) 
        VALUES ($cliente_id, '$equipo', '$marca', '$falla', '$diagnostico', $costo, '$estado', '$observaciones', 1)";
    
    try {
        self::SQL($sql);
        echo json_encode(['codigo' => 1, 'mensaje' => 'Reparación registrada correctamente']);
    } catch (Exception $e) {
        echo json_encode(['codigo' => 0, 'mensaje' => 'Error al registrar la reparación', 'detalle' => $e->getMessage()]);
    }
}

    public static function buscarAPI() {
        getHeadersApi();

        try {
            $sql = "SELECT r.*, c.cli_nombre, c.cli_apellido, c.cli_telefono
                    FROM reparacion r 
                    INNER JOIN cliente c ON r.rep_cliente_id = c.cli_id
                    WHERE r.rep_situacion = 1 
                    ORDER BY r.rep_fecha_ingreso DESC";
            $data = self::fetchArray($sql);

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Reparaciones obtenidas correctamente',
                'data' => $data
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al obtener las reparaciones',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

    public static function buscarClientesAPI() {
        getHeadersApi();

        try {
            $sql = "SELECT cli_id, cli_nombre, cli_apellido, cli_telefono FROM cliente WHERE cli_situacion = 1 ORDER BY cli_nombre, cli_apellido";
            $data = self::fetchArray($sql);

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Clientes obtenidos correctamente',
                'data' => $data,
                'debug' => 'Método funcionando correctamente'
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al obtener los clientes',
                'detalle' => $e->getMessage(),
                'debug' => 'Error en el método buscarClientesAPI'
            ]);
        }
    }

    public static function modificarAPI() {
        getHeadersApi();

        $id = $_POST['rep_id'];

        $reparacionExistente = Reparacion::find($id);
        if (!$reparacionExistente) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'La reparación no existe'
            ]);
            return;
        }

        $_POST['rep_cliente_id'] = filter_var($_POST['rep_cliente_id'], FILTER_SANITIZE_NUMBER_INT);
        $_POST['rep_equipo'] = ucwords(strtolower(trim(htmlspecialchars($_POST['rep_equipo']))));
        $_POST['rep_marca'] = ucwords(strtolower(trim(htmlspecialchars($_POST['rep_marca']))));
        $_POST['rep_falla'] = ucwords(strtolower(trim(htmlspecialchars($_POST['rep_falla']))));
        $_POST['rep_diagnostico'] = ucwords(strtolower(trim(htmlspecialchars($_POST['rep_diagnostico']))));
        $_POST['rep_observaciones'] = ucwords(strtolower(trim(htmlspecialchars($_POST['rep_observaciones']))));

        if (!empty($_POST['rep_costo'])) {
            $_POST['rep_costo'] = filter_var($_POST['rep_costo'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        } else {
            $_POST['rep_costo'] = null;
        }

        $estadosValidos = ['RECIBIDO', 'EN_PROCESO', 'REPARADO', 'ENTREGADO'];
        if (!in_array($_POST['rep_estado'], $estadosValidos)) {
            $_POST['rep_estado'] = 'RECIBIDO';
        }

        try {
            $datosActualizar = [
                'rep_cliente_id' => $_POST['rep_cliente_id'],
                'rep_equipo' => $_POST['rep_equipo'],
                'rep_marca' => $_POST['rep_marca'],
                'rep_falla' => $_POST['rep_falla'],
                'rep_diagnostico' => $_POST['rep_diagnostico'],
                'rep_costo' => $_POST['rep_costo'],
                'rep_fecha_entrega' => $_POST['rep_fecha_entrega'],
                'rep_estado' => $_POST['rep_estado'],
                'rep_observaciones' => $_POST['rep_observaciones']
            ];

            $data = Reparacion::find($id);
            $data->sincronizar($datosActualizar);
            $data->actualizar();

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'La información de la reparación ha sido modificada exitosamente'
            ]);

        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al modificar la reparación',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

    public static function EliminarAPI() {
        try {
            $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

            $ejecutar = Reparacion::EliminarReparacion($id);

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