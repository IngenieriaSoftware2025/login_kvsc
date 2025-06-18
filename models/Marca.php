<?php

namespace Model;

class Marca extends ActiveRecord {

    public static $tabla = 'marca';
    public static $columnasDB = [
        'mar_nombre',
        'mar_descripcion',
        'mar_situacion'
    ];

    public static $idTabla = 'mar_id';
    public $mar_id;
    public $mar_nombre;
    public $mar_descripcion;
    public $mar_situacion;

    public function __construct($args = []) {
        $this->mar_id = $args['mar_id'] ?? null;
        $this->mar_nombre = $args['mar_nombre'] ?? '';
        $this->mar_descripcion = $args['mar_descripcion'] ?? '';
        $this->mar_situacion = $args['mar_situacion'] ?? 1;
    }

    public static function EliminarMarca($id) {
        $sql = "DELETE FROM marca WHERE mar_id = $id";
        return self::SQL($sql);
    }
}