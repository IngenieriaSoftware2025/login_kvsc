<?php

namespace Model;

use Model\ActiveRecord;

class Permisos extends ActiveRecord {
    
    public static $tabla = 'permiso';
    public static $idTabla = 'permiso_id';
    public static $columnasDB = 
    [
        'permiso_app_id',
        'permiso_nombre',
        'permiso_clave',
        'permiso_fecha',
        'permiso_situacion'
    ];
    
    public $permiso_id;
    public $permiso_app_id;
    public $permiso_nombre;
    public $permiso_clave;
    public $permiso_fecha;
    public $permiso_situacion;
    
    public function __construct($permiso = [])
    {
        $this->permiso_id = $permiso['permiso_id'] ?? null;
        $this->permiso_app_id = $permiso['permiso_app_id'] ?? 0;
        $this->permiso_nombre = $permiso['permiso_nombre'] ?? '';
        $this->permiso_clave = $permiso['permiso_clave'] ?? '';
        $this->permiso_fecha = $permiso['permiso_fecha'] ?? date('Y-m-d H:i:s');
        $this->permiso_situacion = $permiso['permiso_situacion'] ?? 1;
    }

    public static function EliminarPermiso($id){
        $sql = "UPDATE permiso SET permiso_situacion = 0 WHERE permiso_id = $id";
        return self::SQL($sql);
    }
}