<?php

namespace Controllers;

use Exception;
use MVC\Router;
use Model\ActiveRecord;
use Model\Permisos;

class PermisosController extends ActiveRecord
{
    public static function renderizarPagina(Router $router)
    {
        $router->render('permisos/index', []);
    }

    public static function guardarAPI()
    {
        getHeadersApi();
    
        try {
            $_POST['permiso_nombre'] = ucwords(strtolower(trim(htmlspecialchars($_POST['permiso_nombre']))));
            
            $cantidad_nombre = strlen($_POST['permiso_nombre']);
            
            if ($cantidad_nombre < 2) {
                http_response_code(400);
                echo json_encode([
                    'codigo' => 0,
                    'mensaje' => 'Nombre del permiso debe de tener mas de 1 caracteres'
                ]);
                exit;
            }
            
            $_POST['permiso_clave'] = strtolower(trim(htmlspecialchars($_POST['permiso_clave'])));
            
            $cantidad_clave = strlen($_POST['permiso_clave']);
            
            if ($cantidad_clave < 2) {
                http_response_code(400);
                echo json_encode([
                    'codigo' => 0,
                    'mensaje' => 'Clave del permiso debe de tener mas de 1 caracteres'
                ]);
                exit;
            }
            
            $_POST['permiso_app_id'] = filter_var($_POST['app_id'], FILTER_SANITIZE_NUMBER_INT);
            
            if ($_POST['permiso_app_id'] <= 0) {
                http_response_code(400);
                echo json_encode([
                    'codigo' => 0,
                    'mensaje' => 'Debe seleccionar una aplicación válida'
                ]);
                exit;
            }

            $_POST['permiso_situacion'] = 1;
            $_POST['permiso_fecha'] = date('Y-m-d H:i:s');
            
            $permiso = new Permisos($_POST);
            $resultado = $permiso->crear();

            if($resultado['resultado'] == 1){
                http_response_code(200);
                echo json_encode([
                    'codigo' => 1,
                    'mensaje' => 'Permiso registrado correctamente',
                ]);
                exit;
            } else {
                http_response_code(500);
                echo json_encode([
                    'codigo' => 0,
                    'mensaje' => 'Error en registrar el permiso',
                ]);
                exit;
            }
            
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error interno del servidor',
                'detalle' => $e->getMessage(),
            ]);
            exit;
        }
    }

    public static function buscarAPI()
    {
        getHeadersApi();
        
        try {
            $app_id = isset($_GET['app_id']) ? $_GET['app_id'] : null;

            $condiciones = ["p.permiso_situacion = 1"];

            if ($app_id) {
                $condiciones[] = "p.permiso_app_id = {$app_id}";
            }

            $where = implode(" AND ", $condiciones);
            $sql = "SELECT 
                        p.*,
                        a.app_nombre_corto
                    FROM permiso p 
                    INNER JOIN aplicacion a ON p.permiso_app_id = a.app_id 
                    WHERE $where 
                    ORDER BY p.permiso_fecha DESC";
            $data = self::fetchArray($sql);

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Permisos obtenidos correctamente',
                'data' => $data
            ]);

        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al obtener los permisos',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

    public static function modificarAPI()
    {
        getHeadersApi();

        $id = $_POST['permiso_id'];
        $_POST['permiso_nombre'] = ucwords(strtolower(trim(htmlspecialchars($_POST['permiso_nombre']))));

        $cantidad_nombre = strlen($_POST['permiso_nombre']);

        if ($cantidad_nombre < 2) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Nombre del permiso debe de tener mas de 1 caracteres'
            ]);
            return;
        }

        $_POST['permiso_clave'] = strtolower(trim(htmlspecialchars($_POST['permiso_clave'])));

        $cantidad_clave = strlen($_POST['permiso_clave']);

        if ($cantidad_clave < 2) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Clave del permiso debe de tener mas de 1 caracteres'
            ]);
            return;
        }

        $_POST['permiso_app_id'] = filter_var($_POST['app_id'], FILTER_SANITIZE_NUMBER_INT);

        if ($_POST['permiso_app_id'] <= 0) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Debe seleccionar una aplicación válida'
            ]);
            return;
        }

        try {
            $data = Permisos::find($id);
            $data->sincronizar([
                'permiso_app_id' => $_POST['permiso_app_id'],
                'permiso_nombre' => $_POST['permiso_nombre'],
                'permiso_clave' => $_POST['permiso_clave'],
                'permiso_situacion' => 1
            ]);
            $data->actualizar();

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'La información del permiso ha sido modificada exitosamente'
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al guardar',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

    public static function EliminarAPI()
    {
        getHeadersApi();
        
        try {
            $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
            $ejecutar = Permisos::EliminarPermiso($id);

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

    public static function buscarAplicacionesAPI()
    {
        getHeadersApi();
        
        try {
            $sql = "SELECT app_id, app_nombre_corto FROM aplicacion WHERE app_situacion = 1 ORDER BY app_nombre_corto";
            $data = self::fetchArray($sql);

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Aplicaciones obtenidas correctamente',
                'data' => $data
            ]);

        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al obtener las aplicaciones',
                'detalle' => $e->getMessage(),
            ]);
        }
    }
}