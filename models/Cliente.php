<?php

namespace Model;

class Cliente extends ActiveRecord {

    public static $tabla = 'cliente';
    public static $columnasDB = [
        'cli_nombre',
        'cli_apellido',
        'cli_nit',
        'cli_telefono',
        'cli_direccion',
        'cli_situacion'
    ];

    public static $idTabla = 'cli_id';
    public $cli_id;
    public $cli_nombre;
    public $cli_apellido;
    public $cli_nit;
    public $cli_telefono;
    public $cli_direccion;
    public $cli_situacion;

    public function __construct($args = []) {
        $this->cli_id = $args['cli_id'] ?? null;
        $this->cli_nombre = $args['cli_nombre'] ?? '';
        $this->cli_apellido = $args['cli_apellido'] ?? '';
        $this->cli_nit = $args['cli_nit'] ?? '';
        $this->cli_telefono = $args['cli_telefono'] ?? '';
        $this->cli_direccion = $args['cli_direccion'] ?? '';
        $this->cli_situacion = $args['cli_situacion'] ?? 1;
    }

    public static function EliminarCliente($id) {
        $sql = "DELETE FROM cliente WHERE cli_id = $id";
        return self::SQL($sql);
    }
}