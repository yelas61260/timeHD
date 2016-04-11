<?php
class mcotizacion extends CI_Model
{
	private $id;
	private $campos;
	private $campos_actividad;
	private $campos_read;

	public function __construct()
	{
		parent::__construct();

		self::$id = "id";

		self::$campos[0] = "id";
		self::$campos[1] = "nombre";
		self::$campos[2] = "fecha_inicio_estimada";
		self::$campos[3] = "fecha_fin_estimada";
		self::$campos[4] = "duracion_minutos";
		self::$campos[5] = "comentarios";
		self::$campos[6] = "no_modulos";
		self::$campos[7] = "no_escenas";
		self::$campos[8] = "no_actividades";
		self::$campos[9] = "no_evaluaciones";
		self::$campos[10] = "fk_cliente";
		self::$campos[11] = "fk_tipo";
		self::$campos[12] = "fk_tecnologia";
		self::$campos[13] = "fk_recursos";
		self::$campos[14] = "fk_estados";

		self::$campos_read[0] = "fk_cliente";
		self::$campos_read[1] = "fecha_inicio_estimada";
		self::$campos_read[2] = "nombre";
		self::$campos_read[3] = "fecha_fin_estimada";
		self::$campos_read[4] = "id";
		self::$campos_read[5] = "duracion_minutos";
		self::$campos_read[6] = "fk_tipo";
		self::$campos_read[7] = "no_modulos";
		self::$campos_read[8] = "fk_tecnologia";
		self::$campos_read[9] = "no_escenas";
		self::$campos_read[10] = "fk_recursos";
		self::$campos_read[11] = "no_actividades";
		self::$campos_read[12] = "comentarios";
		self::$campos_read[13] = "no_evaluaciones";
		self::$campos_read[14] = "fk_estados";

		self::$campos_actividad[0] = "id";
		self::$campos_actividad[1] = "cantidad_real";
		self::$campos_actividad[2] = "cantidad_estimada";
		self::$campos_actividad[3] = "tiempo_estimado";
		self::$campos_actividad[4] = "costo_estimado";
		self::$campos_actividad[5] = "fk_proyecto";
		self::$campos_actividad[6] = "fk_actividad";
	}

	public function get_id(){
		return self::$id;
	}

	public function get_campos(){
		return self::$campos;
	}

	public function get_campos_read(){
		return self::$campos_read;
	}

	public function get_campos_actividad(){
		return self::$campos_actividad;
	}
}