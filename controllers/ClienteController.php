<?php

namespace Controllers;

use Exception;
use Model\ActiveRecord;
use MVC\Router;
use Model\Cliente;

class ClienteController extends ActiveRecord {
    
    public static function renderizarPagina(Router $router) {
        $router->render('cliente/index', []);
    }

    public static function guardarAPI() {
        getHeadersApi();

        $_POST['cli_nombre'] = ucwords(strtolower(trim(htmlspecialchars($_POST['cli_nombre']))));
        
        $cantidad_nombre = strlen($_POST['cli_nombre']);
        
        if ($cantidad_nombre < 2) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'El nombre debe tener más de 1 caracteres'
            ]);
            exit;
        }

        $_POST['cli_apellido'] = ucwords(strtolower(trim(htmlspecialchars($_POST['cli_apellido']))));
        
        $cantidad_apellido = strlen($_POST['cli_apellido']);
        
        if ($cantidad_apellido < 2) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'El apellido debe tener más de 1 caracteres'
            ]);
            exit;
        }

        $_POST['cli_nit'] = filter_var($_POST['cli_nit'], FILTER_SANITIZE_NUMBER_INT);
        if (strlen($_POST['cli_nit']) < 7) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'El NIT debe tener al menos 7 dígitos'
            ]);
            exit;
        }

        $_POST['cli_telefono'] = filter_var($_POST['cli_telefono'], FILTER_SANITIZE_NUMBER_INT);
        if (strlen($_POST['cli_telefono']) != 8) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'El teléfono debe tener exactamente 8 dígitos'
            ]);
            exit;
        }

        $_POST['cli_direccion'] = ucwords(strtolower(trim(htmlspecialchars($_POST['cli_direccion']))));

        $nitExistente = "SELECT COUNT(*) as total FROM cliente WHERE cli_nit = '{$_POST['cli_nit']}' AND cli_situacion = 1";
        $resultadoNit = self::fetchArray($nitExistente);

        if ($resultadoNit[0]['total'] > 0) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 2,
                'mensaje' => 'El NIT ingresado ya está registrado en el sistema',
                'campo' => 'cli_nit',
                'tipo' => 'duplicado_nit'
            ]);
            exit;
        }

        $telefonoExistente = "SELECT COUNT(*) as total FROM cliente WHERE cli_telefono = '{$_POST['cli_telefono']}' AND cli_situacion = 1";
        $resultadoTelefono = self::fetchArray($telefonoExistente);

        if ($resultadoTelefono[0]['total'] > 0) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 3,
                'mensaje' => 'El teléfono ingresado ya está registrado en el sistema',
                'campo' => 'cli_telefono',
                'tipo' => 'duplicado_telefono'
            ]);
            exit;
        }

        try {
            $cliente = new Cliente($_POST);
            $resultado = $cliente->crear();

            if ($resultado['resultado'] == 1) {
                http_response_code(200);
                echo json_encode([
                    'codigo' => 1,
                    'mensaje' => 'Cliente registrado correctamente',
                ]);
                exit;
            } else {
                http_response_code(500);
                echo json_encode([
                    'codigo' => 0,
                    'mensaje' => 'Error al registrar el cliente',
                ]);
                exit;
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al registrar el cliente',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

    public static function buscarAPI() {
        getHeadersApi();

        try {
            $sql = "SELECT * FROM cliente WHERE cli_situacion = 1 ORDER BY cli_nombre, cli_apellido";
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

    public static function modificarAPI() {
        getHeadersApi();

        $id = $_POST['cli_id'];

        $clienteExistente = Cliente::find($id);
        if (!$clienteExistente) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'El cliente no existe'
            ]);
            return;
        }

        $_POST['cli_nombre'] = ucwords(strtolower(trim(htmlspecialchars($_POST['cli_nombre']))));
        $_POST['cli_apellido'] = ucwords(strtolower(trim(htmlspecialchars($_POST['cli_apellido']))));
        $_POST['cli_nit'] = filter_var($_POST['cli_nit'], FILTER_SANITIZE_NUMBER_INT);
        $_POST['cli_telefono'] = filter_var($_POST['cli_telefono'], FILTER_SANITIZE_NUMBER_INT);
        $_POST['cli_direccion'] = ucwords(strtolower(trim(htmlspecialchars($_POST['cli_direccion']))));

        $nitExistente = "SELECT COUNT(*) as total FROM cliente WHERE cli_nit = '{$_POST['cli_nit']}' AND cli_situacion = 1 AND cli_id != $id";
        $resultadoNit = self::fetchArray($nitExistente);

        if ($resultadoNit[0]['total'] > 0) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 2,
                'mensaje' => 'El NIT ingresado ya está registrado por otro cliente',
                'campo' => 'cli_nit',
                'tipo' => 'duplicado_nit'
            ]);
            return;
        }

        $telefonoExistente = "SELECT COUNT(*) as total FROM cliente WHERE cli_telefono = '{$_POST['cli_telefono']}' AND cli_situacion = 1 AND cli_id != $id";
        $resultadoTelefono = self::fetchArray($telefonoExistente);

        if ($resultadoTelefono[0]['total'] > 0) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 3,
                'mensaje' => 'El teléfono ingresado ya está registrado por otro cliente',
                'campo' => 'cli_telefono',
                'tipo' => 'duplicado_telefono'
            ]);
            return;
        }

        try {
            $datosActualizar = [
                'cli_nombre' => $_POST['cli_nombre'],
                'cli_apellido' => $_POST['cli_apellido'],
                'cli_nit' => $_POST['cli_nit'],
                'cli_telefono' => $_POST['cli_telefono'],
                'cli_direccion' => $_POST['cli_direccion']
            ];

            $data = Cliente::find($id);
            $data->sincronizar($datosActualizar);
            $data->actualizar();

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'La información del cliente ha sido modificada exitosamente'
            ]);

        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al modificar el cliente',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

    public static function EliminarAPI() {
        try {
            $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

            $ejecutar = Cliente::EliminarCliente($id);

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