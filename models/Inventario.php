<?php

namespace Model;

class Inventario extends ActiveRecord {

    public static $tabla = 'inventario';
    public static $columnasDB = [
        'inv_modelo',
        'inv_marca_id',
        'inv_precio_compra',
        'inv_precio_venta',
        'inv_stock',
        'inv_descripcion',
        'inv_situacion'
    ];

    public static $idTabla = 'inv_id';
    public $inv_id;
    public $inv_modelo;
    public $inv_marca_id;
    public $inv_precio_compra;
    public $inv_precio_venta;
    public $inv_stock;
    public $inv_descripcion;
    public $inv_situacion;

    public function __construct($args = []) {
        $this->inv_id = $args['inv_id'] ?? null;
        $this->inv_modelo = $args['inv_modelo'] ?? '';
        $this->inv_marca_id = $args['inv_marca_id'] ?? '';
        $this->inv_precio_compra = $args['inv_precio_compra'] ?? 0;
        $this->inv_precio_venta = $args['inv_precio_venta'] ?? 0;
        $this->inv_stock = $args['inv_stock'] ?? 0;
        $this->inv_descripcion = $args['inv_descripcion'] ?? '';
        $this->inv_situacion = $args['inv_situacion'] ?? 1;
    }

    public static function EliminarInventario($id) {
        $sql = "DELETE FROM inventario WHERE inv_id = $id";
        return self::SQL($sql);
    }
}