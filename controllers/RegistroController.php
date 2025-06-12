<?php

namespace Controllers;

use Exception;
use Model\ActiveRecord;
use MVC\Router;
use Model\Usuarios;


class RegistroController extends ActiveRecord{
    
public static function renderizarPagina(Router $router){
        $router->render('registro/index', []);
    }


public static function guardarAPI()
    {
        getHeadersApi();
    
        $_POST['usuario_nom1'] = ucwords(strtolower(trim(htmlspecialchars($_POST['usuario_nom1']))));
        
        $cantidad_nombre = strlen($_POST['usuario_nom1']);
        
        if ($cantidad_nombre < 2) {
            
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Nombre debe de tener mas de 1 caracteres'
            ]);
            exit;
        }
        
        $_POST['usuario_nom2'] = ucwords(strtolower(trim(htmlspecialchars($_POST['usuario_nom2']))));
        
        $cantidad_nombre = strlen($_POST['usuario_nom2']);
        
        if ($cantidad_nombre < 2) {
          
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Nombre debe de tener mas de 1 caracteres'
            ]);
            exit;
        }
        
        $_POST['usuario_ape1'] = ucwords(strtolower(trim(htmlspecialchars($_POST['usuario_ape1']))));
        $cantidad_apellido = strlen($_POST['usuario_ape1']);
        
        if ($cantidad_apellido < 2) {
         
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Nombre debe de tener mas de 1 caracteres'
            ]);
            exit;
        }
        
        $_POST['usuario_ape2'] = ucwords(strtolower(trim(htmlspecialchars($_POST['usuario_ape2']))));
        $cantidad_apellido = strlen($_POST['usuario_ape2']);
        
        if ($cantidad_apellido < 2) {
            
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Nombre debe de tener mas de 1 caracteres'
            ]);
            exit;
        }
        
        $_POST['usuario_tel'] = filter_var($_POST['usuario_tel'], FILTER_SANITIZE_NUMBER_INT);
        if (strlen($_POST['usuario_tel']) != 8) {
        
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'El telefono debe de tener 8 numeros'
            ]);
            exit;
        }
        
        $_POST['usuario_direc'] = ucwords(strtolower(trim(htmlspecialchars($_POST['usuario_direc']))));

        $_POST['usuario_dpi'] = filter_var($_POST['usuario_dpi'], FILTER_SANITIZE_NUMBER_INT);
        if (strlen($_POST['usuario_dpi']) != 13) {
           
            
            echo json_encode([
                'codigo' => 0,
                'mennsaje' => 'La cantidad de digitos del DPI debe de ser igual a 13'
            ]);
            exit;
        }
        
        $_POST['usuario_correo'] = filter_var($_POST['usuario_correo'], FILTER_SANITIZE_EMAIL);
        
        if (!filter_var($_POST['usuario_correo'], FILTER_VALIDATE_EMAIL)){
          
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'El correo electronico no es valido'
            ]);
        }
        
        
        // VALIDACIÓN: Contraseña
        if (strlen($_POST['usuario_contra']) < 8) {
      
            
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'La contraseña debe tener al menos 8 caracteres'
            ]);
            exit;
        }

            // Verificar DPI duplicado
            $dpiExistente = "SELECT COUNT(*) as total FROM usuario WHERE usuario_dpi = '{$_POST['usuario_dpi']}' AND usuario_situacion = 1";
            $resultadoDpi = self::fetchArray($dpiExistente);

            if ($resultadoDpi[0]['total'] > 0) {
                http_response_code(400);
                echo json_encode([
                    'codigo' => 2, // Código específico para DPI duplicado
                    'mensaje' => 'El DPI ingresado ya está registrado en el sistema',
                    'campo' => 'usuario_dpi',
                    'tipo' => 'duplicado_dpi'
                ]);
                exit;
            }

            // Verificar correo duplicado
            $correoExistente = "SELECT COUNT(*) as total FROM usuario WHERE usuario_correo = '{$_POST['usuario_correo']}' AND usuario_situacion = 1";
            $resultadoCorreo = self::fetchArray($correoExistente);

            if ($resultadoCorreo[0]['total'] > 0) {
                http_response_code(400);
                echo json_encode([
                    'codigo' => 3, // Código específico para correo duplicado
                    'mensaje' => 'El correo electrónico ingresado ya está registrado en el sistema',
                    'campo' => 'usuario_correo',
                    'tipo' => 'duplicado_correo'
                ]);
                exit;
            }


        // VALIDACIÓN: Confirmar contraseña
        if ($_POST['usuario_contra'] !== $_POST['confirmar_contra']) {
            
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Las contraseñas no coinciden'
            ]);
            exit;
        }
           $_POST['usuario_token'] = uniqid();
            $dpi = $_POST['usuario_dpi'];

            if (!empty($_POST['usuario_fecha_creacion'])) {
                $fecha_ingresada = strtotime($_POST['usuario_fecha_creacion']);
                $fecha_actual = strtotime(date('Y-m-d'));
                
                if ($fecha_ingresada > $fecha_actual) {
                    $_POST['usuario_fecha_creacion'] = date('Y-m-d');
                } else {
                    $_POST['usuario_fecha_creacion'] = date('Y-m-d', $fecha_ingresada);
                }
            } else {
                $_POST['usuario_fecha_creacion'] = date('Y-m-d');
            }
            $_POST['usuario_fecha_contra'] = date('Y-m-d');
        
        $file = $_FILES['usuario_fotografia'];
        $fileName = $file['name'];
        $fileTmpName = $file['tmp_name'];
        $fileSize = $file['size'];
        $fileError = $file['error'];
        
      
        
        
        
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
  
        // Extensiones permitidas
        $allowed = ['jpg', 'jpeg', 'png'];
        
        if (!in_array($fileExtension, $allowed)) {
            
            http_response_code(400);
            echo json_encode([
                'codigo' => 2,
                'mensaje' => 'Solo puede cargar archivos JPG, PNG o JPEG',
            ]);
            exit;
        }
        
        if ($fileSize >= 2000000) {
            
            http_response_code(400);
            echo json_encode([
                'codigo' => 2,
                'mensaje' => 'La imgagen debe pesar menos de 2MB',
            ]);
            exit;
        }
        
        if ($fileError === 0) {
                $ruta = "storage/fotografias/$dpi.$fileExtension";
                $subido = move_uploaded_file($file['tmp_name'], __DIR__ . "../../" . $ruta);
                
                if ($subido) {
                    
                    $_POST['usuario_contra'] = password_hash($_POST['usuario_contra'], PASSWORD_DEFAULT);
                    $foto = base64_encode(file_get_contents(__DIR__ . '/../' . $ruta));
                    $_SESSION['user']->foto = $foto;
                    $usuario = new Usuarios($_POST);
                    $usuario->usuario_fotografia = $ruta;

                    $resultado = $usuario->crear();



                    if($resultado['resultado'] ==1){
                        
                        http_response_code(200);
                        echo json_encode([
                            'codigo' => 1,
                            'mensaje' => 'Usuario registrado correctamente',
                        ]);
                        
                        exit;
                    }else{
                        
                http_response_code(500);
                echo json_encode([
                    'codigo' => 0,
                    'mensaje' => 'Error en registrar al usuario',
                    'datos' => $_POST,
                    'usuario' => $usuario,
                ]);
                exit;


                    }
                } 
            } else {
                
                http_response_code(500);
                echo json_encode([
                    'codigo' => 0,
                    'mensaje' => 'Error en la carga de fotografia',
                ]);
                exit;
            }
        
            

    }
    
public static function buscarAPI()
{
    getHeadersApi();

    try {
        $sql = "SELECT * FROM usuario where usuario_situacion = 1";
        $data = self::fetchArray($sql);

        foreach ($data as &$usuario) {
            if (!empty($usuario['usuario_fotografia'])) {
                $rutaCompleta = __DIR__ . '/../' . $usuario['usuario_fotografia'];
                
                if (file_exists($rutaCompleta)) {
                    $contenido = file_get_contents($rutaCompleta);
                    $base64 = base64_encode($contenido);
                    
                    $extension = pathinfo($usuario['usuario_fotografia'], PATHINFO_EXTENSION);
                    
                    $usuario['usuario_fotografia_base64'] = "data:image/{$extension};base64,{$base64}";
                } else {
                    $rutaAlternativa = __DIR__ . '/../../' . $usuario['usuario_fotografia'];
                    if (file_exists($rutaAlternativa)) {
                        $contenido = file_get_contents($rutaAlternativa);
                        $base64 = base64_encode($contenido);
                        $extension = pathinfo($usuario['usuario_fotografia'], PATHINFO_EXTENSION);
                        $usuario['usuario_fotografia_base64'] = "data:image/{$extension};base64,{$base64}";
                    } else {
                        $usuario['usuario_fotografia_base64'] = null;
                    }
                }
            } else {
                $usuario['usuario_fotografia_base64'] = null;
            }
        }

        http_response_code(200);
        echo json_encode([
            'codigo' => 1,
            'mensaje' => 'Usuarios obtenidos correctamente',
            'data' => $data
        ]);
    } catch (Exception $e) {
        http_response_code(400);
        echo json_encode([
            'codigo' => 0,
            'mensaje' => 'Error al obtener los usuarios',
            'detalle' => $e->getMessage(),
        ]);
    }
}

public static function modificarAPI()
{
    getHeadersApi();

    $id = $_POST['usuario_id'];

    $usuarioExistente = Usuarios::find($id);
    if (!$usuarioExistente) {
        http_response_code(400);
        echo json_encode([
            'codigo' => 0,
            'mensaje' => 'El usuario no existe'
        ]);
        return;
    }

    $dpiExistente = "SELECT COUNT(*) as total FROM usuario WHERE usuario_dpi = '{$_POST['usuario_dpi']}' AND usuario_situacion = 1 AND usuario_id != $id";
    $resultadoDpi = self::fetchArray($dpiExistente);

    if ($resultadoDpi[0]['total'] > 0) {
        http_response_code(400);
        echo json_encode([
            'codigo' => 2,
            'mensaje' => 'El DPI ingresado ya está registrado por otro usuario',
            'campo' => 'usuario_dpi',
            'tipo' => 'duplicado_dpi'
        ]);
        return;
    }

    $correoExistente = "SELECT COUNT(*) as total FROM usuario WHERE usuario_correo = '{$_POST['usuario_correo']}' AND usuario_situacion = 1 AND usuario_id != $id";
    $resultadoCorreo = self::fetchArray($correoExistente);

    if ($resultadoCorreo[0]['total'] > 0) {
        http_response_code(400);
        echo json_encode([
            'codigo' => 3,
            'mensaje' => 'El correo electrónico ingresado ya está registrado por otro usuario',
            'campo' => 'usuario_correo',
            'tipo' => 'duplicado_correo'
        ]);
        return;
    }

    $fotografia = null;
    if (isset($_FILES['usuario_fotografia']) && $_FILES['usuario_fotografia']['error'] == 0) {
        $file = $_FILES['usuario_fotografia'];
        $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png'];
        
        if (!in_array($fileExtension, $allowed)) {
            http_response_code(400);
            echo json_encode(['codigo' => 0, 'mensaje' => 'Solo JPG, PNG o JPEG']);
            return;
        }
        
        if ($file['size'] >= 2000000) {
            http_response_code(400);
            echo json_encode(['codigo' => 0, 'mensaje' => 'Imagen debe pesar menos de 2MB']);
            return;
        }
        
        $dpi = $_POST['usuario_dpi'];
        
        $uploadDir = __DIR__ . "/../../storage/fotografias/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        
        $ruta = "storage/fotografias/$dpi.$fileExtension";
        $subido = move_uploaded_file($file['tmp_name'], __DIR__ . "/../../" . $ruta);
        
        if ($subido) {
            $fotografia = $ruta;
        }
    }

    try {
        $datosActualizar = [
            'usuario_nom1' => ucwords(strtolower(trim(htmlspecialchars($_POST['usuario_nom1'])))),
            'usuario_nom2' => ucwords(strtolower(trim(htmlspecialchars($_POST['usuario_nom2'])))),
            'usuario_ape1' => ucwords(strtolower(trim(htmlspecialchars($_POST['usuario_ape1'])))),
            'usuario_ape2' => ucwords(strtolower(trim(htmlspecialchars($_POST['usuario_ape2'])))),
            'usuario_tel' => filter_var($_POST['usuario_tel'], FILTER_SANITIZE_NUMBER_INT),
            'usuario_direc' => ucwords(strtolower(trim(htmlspecialchars($_POST['usuario_direc'])))),
            'usuario_dpi' => filter_var($_POST['usuario_dpi'], FILTER_SANITIZE_NUMBER_INT),
            'usuario_correo' => filter_var($_POST['usuario_correo'], FILTER_SANITIZE_EMAIL),
            'usuario_fecha_creacion' => $_POST['usuario_fecha_creacion']
        ];

        if (!empty($_POST['usuario_contra'])) {
            $_POST['usuario_contra'] = htmlspecialchars($_POST['usuario_contra']);
            if (strlen($_POST['usuario_contra']) < 8) {
                http_response_code(400);
                echo json_encode([
                    'codigo' => 0,
                    'mensaje' => 'La contraseña debe tener al menos 8 caracteres'
                ]);
                return;
            }
            
            $datosActualizar['usuario_contra'] = password_hash($_POST['usuario_contra'], PASSWORD_DEFAULT);
            $datosActualizar['usuario_fecha_contra'] = date('Y-m-d');
        }

        if ($fotografia) {
            $datosActualizar['usuario_fotografia'] = $fotografia;
        }

        $data = Usuarios::find($id);
        $data->sincronizar($datosActualizar);
        $data->actualizar();

        http_response_code(200);
        echo json_encode([
            'codigo' => 1,
            'mensaje' => 'La información del usuario ha sido modificada exitosamente'
        ]);

    } catch (Exception $e) {
        http_response_code(400);
        echo json_encode([
            'codigo' => 0,
            'mensaje' => 'Error al modificar el usuario',
            'detalle' => $e->getMessage(),
        ]);
    }
}

public static function EliminarAPI()
    {

        try {

            $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

            $ejecutar = Usuarios::EliminarUsuarios($id);

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