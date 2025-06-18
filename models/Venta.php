<?php

namespace Model;

class Venta extends ActiveRecord {

    public static $tabla = 'venta';
    public static $columnasDB = [
        'ven_cliente_id',
        'ven_inventario_id',
        'ven_cantidad',
        'ven_precio_unitario',
        'ven_total',
        'ven_fecha',
        'ven_observaciones',
        'ven_situacion'
    ];

    public static $idTabla = 'ven_id';
    public $ven_id;
    public $ven_cliente_id;
    public $ven_inventario_id;
    public $ven_cantidad;
    public $ven_precio_unitario;
    public $ven_total;
    public $ven_fecha;
    public $ven_observaciones;
    public $ven_situacion;

    public function __construct($args = []) {
        $this->ven_id = $args['ven_id'] ?? null;
        $this->ven_cliente_id = $args['ven_cliente_id'] ?? '';
        $this->ven_inventario_id = $args['ven_inventario_id'] ?? '';
        $this->ven_cantidad = $args['ven_cantidad'] ?? '';
        $this->ven_precio_unitario = $args['ven_precio_unitario'] ?? 0;
        $this->ven_total = $args['ven_total'] ?? 0;
        $this->ven_fecha = $args['ven_fecha'] ?? null;
        $this->ven_observaciones = $args['ven_observaciones'] ?? '';
        $this->ven_situacion = $args['ven_situacion'] ?? 1;
    }

    public static function EliminarVenta($id) {
        $sql = "DELETE FROM venta WHERE ven_id = $id";
        return self::SQL($sql);
    }
}