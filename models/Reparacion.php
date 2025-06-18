<?php

namespace Model;

class Reparacion extends ActiveRecord {

    public static $tabla = 'reparacion';
    public static $columnasDB = [
        'rep_cliente_id',
        'rep_equipo', 
        'rep_marca',
        'rep_falla',
        'rep_diagnostico',
        'rep_costo',
        'rep_fecha_entrega',
        'rep_estado',
        'rep_observaciones',
        'rep_situacion'
    ];

    public static $idTabla = 'rep_id';
    public $rep_id;
    public $rep_cliente_id;
    public $rep_equipo;
    public $rep_marca;
    public $rep_falla;
    public $rep_diagnostico;
    public $rep_costo;
    public $rep_fecha_ingreso;
    public $rep_fecha_entrega;
    public $rep_estado;
    public $rep_observaciones;
    public $rep_situacion;

    public function __construct($args = []) {
        $this->rep_id = $args['rep_id'] ?? null;
        $this->rep_cliente_id = $args['rep_cliente_id'] ?? '';
        $this->rep_equipo = $args['rep_equipo'] ?? '';
        $this->rep_marca = $args['rep_marca'] ?? '';
        $this->rep_falla = $args['rep_falla'] ?? '';
        $this->rep_diagnostico = $args['rep_diagnostico'] ?? '';
        $this->rep_costo = $args['rep_costo'] ?? null;
        $this->rep_fecha_ingreso = $args['rep_fecha_ingreso'] ?? null;
        $this->rep_fecha_entrega = $args['rep_fecha_entrega'] ?? null;
        $this->rep_estado = $args['rep_estado'] ?? 'RECIBIDO';
        $this->rep_observaciones = $args['rep_observaciones'] ?? '';
        $this->rep_situacion = $args['rep_situacion'] ?? 1;
    }

    public static function EliminarReparacion($id) {
        $sql = "DELETE FROM reparacion WHERE rep_id = $id";
        return self::SQL($sql);
    }
}