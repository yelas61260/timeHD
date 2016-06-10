<?php
class mproyecto extends CI_Model
{
	private static $id;
	private static $campos;
	private static $campos_actividad;
	private static $campos_actividad_update;
	private static $campos_read;

	private static $tablas;

	public function __construct()
	{
		parent::__construct();

		self::$id = "id";

		self::$campos[0] = "id";
		self::$campos[1] = "nombre";
		self::$campos[2] = "fecha_inicio_estimada";
		self::$campos[3] = "fecha_fin_estimada";
		self::$campos[4] = "fecha_inicio_real";
		self::$campos[5] = "fecha_fin_real";
		self::$campos[6] = "duracion_minutos";
		self::$campos[7] = "comentarios";
		self::$campos[8] = "no_modulos";
		self::$campos[9] = "no_escenas";
		self::$campos[10] = "no_actividades";
		self::$campos[11] = "no_evaluaciones";
		self::$campos[12] = "fk_cliente";
		self::$campos[13] = "fk_tipo";
		self::$campos[14] = "fk_tecnologia";
		self::$campos[15] = "fk_recursos";
		self::$campos[16] = "fk_estados";

		self::$campos_read[0] = "fk_cliente";
		self::$campos_read[1] = "duracion_minutos";
		self::$campos_read[2] = "nombre";
		self::$campos_read[3] = "no_modulos";
		self::$campos_read[4] = "id";
		self::$campos_read[5] = "no_escenas";
		self::$campos_read[6] = "fk_tipo";
		self::$campos_read[7] = "no_actividades";
		self::$campos_read[8] = "fk_tecnologia";
		self::$campos_read[9] = "no_evaluaciones";
		self::$campos_read[10] = "fk_recursos";
		self::$campos_read[11] = "fk_estados";
		self::$campos_read[12] = "fecha_inicio_estimada";
		self::$campos_read[13] = "fecha_fin_estimada";
		self::$campos_read[14] = "fecha_inicio_real";
		self::$campos_read[15] = "fecha_fin_real";
		self::$campos_read[16] = "comentarios";

		self::$campos_actividad[0] = "id";
		self::$campos_actividad[1] = "cantidad_real";
		self::$campos_actividad[2] = "cantidad_estimada";
		self::$campos_actividad[3] = "tiempo_estimado";
		self::$campos_actividad[4] = "costo_estimado";
		self::$campos_actividad[5] = "fk_proyecto";
		self::$campos_actividad[6] = "fk_actividad";

		self::$campos_actividad_update[0] = "cantidad_real";
		self::$campos_actividad_update[1] = "cantidad_estimada";
		self::$campos_actividad_update[2] = "tiempo_estimado";
		self::$campos_actividad_update[3] = "costo_estimado";

		self::$tablas = $this->db_struc->getTablas();
	}

	public function get_table_grafic(){
		return $this->lib->tabla_generar(self::$tablas[10]." AS t1, ".self::$tablas[2]." AS t2, ".self::$tablas[19]." AS t3",
				array("ID","Nombre","Fecha inicio estimada","Fecha fin estimada","Cliente","Tipo","",""),
				array("id","nombre","fecha_inicio_estimada","fecha_fin_estimada","cliente","tipo","",""),
				["t1.fk_cliente=t2.id","t1.fk_tipo=t3.id","t1.fk_estados=1"],"proyecto",self::get_id(),
				["t1.id as id","t1.nombre","t1.fecha_inicio_estimada","t1.fecha_fin_estimada","t2.nombre as cliente","t3.nombre as tipo"]);
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

	public function get_campos_actividad_update(){
		return self::$campos_actividad_update;
	}
}