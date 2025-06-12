<?php

namespace Controllers;

use Model\ActiveRecord;
use MVC\Router;
use Exception;

class LoginController extends ActiveRecord
{
    public static function renderizarPagina(Router $router)
    {
        // Usar tu layout de login existente
        $router->render('login/index', [], 'layout/layout_login');
    }

    public static function login() 
    {
        getHeadersApi();
        
        try {
            $usuario = filter_var($_POST['usu_codigo'], FILTER_SANITIZE_NUMBER_INT);
            $contrasena = htmlspecialchars($_POST['usu_password']);

            $queryExisteUser = "SELECT usuario_id, usuario_nom1, usuario_contra FROM usuario WHERE usuario_dpi = $usuario AND usuario_situacion = 1";

            $existeUsuario = ActiveRecord::fetchArray($queryExisteUser)[0];

            if ($existeUsuario) {
                $passDB = $existeUsuario['usuario_contra'];

                if (password_verify($contrasena, $passDB)) {
                    // Verificar si la sesión ya está iniciada
                    if (session_status() === PHP_SESSION_NONE) {
                        session_start();
                    }

                    $nombreUser = $existeUsuario['usuario_nom1'];
                    $idUsuario = $existeUsuario['usuario_id'];

                    $_SESSION['nombre'] = $nombreUser;
                    $_SESSION['dpi'] = $usuario;
                    $_SESSION['usuario_id'] = $idUsuario;

                    // Cargar permisos dinámicamente
                    $sqlpermisos = "SELECT permiso_clave as permiso FROM asig_permisos 
                                   INNER JOIN permiso ON asignacion_permiso_id = permiso_id 
                                   WHERE asignacion_usuario_id = $idUsuario AND asignacion_situacion = 1";

                    $permisos = ActiveRecord::fetchArray($sqlpermisos);

                    foreach ($permisos as $key => $value) {
                       $_SESSION[$value['permiso']] = 1; 
                    }

                    echo json_encode([
                        'codigo' => 1,
                        'mensaje' => 'Usuario logueado exitosamente',
                    ]);
                } else {
                    echo json_encode([
                        'codigo' => 0,
                        'mensaje' => 'La contraseña que ingreso es incorrecta',
                    ]);
                }
            } else {
                echo json_encode([
                    'codigo' => 0,
                    'mensaje' => 'El usuario que intenta loguearse NO EXISTE',
                ]);
            }
        } catch (Exception $e) {
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al intentar loguearse',
                'detalle' => $e->getMessage()
            ]);
        }
    }

    public static function logout()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION = [];
        session_destroy();
        $login = $_ENV['APP_NAME'];
        header("Location: /$login");
        exit;
    }

    public static function renderInicio(Router $router)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!isset($_SESSION['usuario_id'])) {
            $login = $_ENV['APP_NAME'];
            header("Location: /$login");
            exit;
        }
        
        // Usar tu layout principal existente
        $router->render('pages/index', [], 'layout/layout');
    }    
}