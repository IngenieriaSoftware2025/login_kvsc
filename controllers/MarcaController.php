<?php

namespace Controllers;

use Exception;
use Model\ActiveRecord;
use MVC\Router;
use Model\Marca;

class MarcaController extends ActiveRecord {
    
    public static function renderizarPagina(Router $router) {
        $router->render('marca/index', []);
    }

    public static function guardarAPI() {
        getHeadersApi();

        $_POST['mar_nombre'] = ucwords(strtolower(trim(htmlspecialchars($_POST['mar_nombre']))));
        
        $cantidad_nombre = strlen($_POST['mar_nombre']);
        
        if ($cantidad_nombre < 2) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'El nombre de la marca debe tener más de 1 caracteres'
            ]);
            exit;
        }

        $_POST['mar_descripcion'] = ucwords(strtolower(trim(htmlspecialchars($_POST['mar_descripcion']))));

        $marcaExistente = "SELECT COUNT(*) as total FROM marca WHERE mar_nombre = '{$_POST['mar_nombre']}' AND mar_situacion = 1";
        $resultadoMarca = self::fetchArray($marcaExistente);

        if ($resultadoMarca[0]['total'] > 0) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 2,
                'mensaje' => 'El nombre de marca ingresado ya está registrado en el sistema',
                'campo' => 'mar_nombre',
                'tipo' => 'duplicado_marca'
            ]);
            exit;
        }

        try {
            $marca = new Marca($_POST);
            $resultado = $marca->crear();

            if ($resultado['resultado'] == 1) {
                http_response_code(200);
                echo json_encode([
                    'codigo' => 1,
                    'mensaje' => 'Marca registrada correctamente',
                ]);
                exit;
            } else {
                http_response_code(500);
                echo json_encode([
                    'codigo' => 0,
                    'mensaje' => 'Error al registrar la marca',
                ]);
                exit;
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al registrar la marca',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

    public static function buscarAPI() {
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

        $id = $_POST['mar_id'];

        $marcaExistente = Marca::find($id);
        if (!$marcaExistente) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'La marca no existe'
            ]);
            return;
        }

        $_POST['mar_nombre'] = ucwords(strtolower(trim(htmlspecialchars($_POST['mar_nombre']))));
        $_POST['mar_descripcion'] = ucwords(strtolower(trim(htmlspecialchars($_POST['mar_descripcion']))));

        $nombreExistente = "SELECT COUNT(*) as total FROM marca WHERE mar_nombre = '{$_POST['mar_nombre']}' AND mar_situacion = 1 AND mar_id != $id";
        $resultadoNombre = self::fetchArray($nombreExistente);

        if ($resultadoNombre[0]['total'] > 0) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 2,
                'mensaje' => 'El nombre de marca ingresado ya está registrado por otra marca',
                'campo' => 'mar_nombre',
                'tipo' => 'duplicado_marca'
            ]);
            return;
        }

        try {
            $datosActualizar = [
                'mar_nombre' => $_POST['mar_nombre'],
                'mar_descripcion' => $_POST['mar_descripcion']
            ];

            $data = Marca::find($id);
            $data->sincronizar($datosActualizar);
            $data->actualizar();

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'La información de la marca ha sido modificada exitosamente'
            ]);

        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al modificar la marca',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

    public static function EliminarAPI() {
        try {
            $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

            $ejecutar = Marca::EliminarMarca($id);

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