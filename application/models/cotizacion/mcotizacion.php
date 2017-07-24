<?php
class mcotizacion extends CI_Model
{
	private static $id;
	private static $campos;
	private static $campos_read;

	private static $camposAct;
	private static $camposTer;

	private static $tablas;

	public function __construct()
	{
		parent::__construct();

		self::$id = "id";

		self::$campos[0] = "nombre";
		self::$campos[1] = "fecha_inicio_estimada";
		self::$campos[2] = "fecha_fin_estimada";
		self::$campos[3] = "duracion_minutos";
		self::$campos[4] = "comentarios";
		self::$campos[5] = "no_modulos";
		self::$campos[6] = "no_escenas";
		self::$campos[7] = "no_actividades";
		self::$campos[8] = "no_evaluaciones";
		self::$campos[9] = "fk_cliente";
		self::$campos[10] = "fk_tipo";
		self::$campos[11] = "fk_tecnologia";
		self::$campos[12] = "fk_recursos";
		self::$campos[13] = "fk_estados";

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

		self::$camposAct[0] = "fk_proyecto";
		self::$camposAct[1] = "fk_roles";
		self::$camposAct[2] = "fk_actividad";
		self::$camposAct[3] = "tiempo_cotizado";
		self::$camposAct[4] = "costo_cotizado";
		self::$camposAct[5] = "opcional";

		self::$camposTer[0] = "nombre";
		self::$camposTer[1] = "fk_proyecto";
		self::$camposTer[2] = "costo";
		self::$camposTer[3] = "opcional";

		self::$tablas = $this->db_struc->getTablas();
	}

	public function get_table_grafic(){
		return $this->lib->tabla_generar(self::$tablas[10]." AS t1, ".self::$tablas[2]." AS t2, ".self::$tablas[19]." AS t3",
				array("ID","Nombre","Fecha inicio estimada","Fecha fin estimada","Cliente","Tipo","","",""),
				array("id","nombre","fecha_inicio_estimada","fecha_fin_estimada","cliente","tipo","","",""),
				["t1.fk_cliente=t2.id","t1.fk_tipo=t3.id","t1.fk_estados=3"],"cotizacion",self::get_id(),
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

	public function get_campos_act(){
		return self::$camposAct;
	}

	public function get_campos_ter(){
		return self::$camposTer;
	}

	public function get_datos($id){
		$objEstandar = new stdClass();
		$objDatos = new stdClass();
		$result = $this->db_con->get_sql_records("SELECT id, nombre, fecha_inicio_estimada fecha_ini, fecha_fin_estimada fecha_fin_est, duracion_minutos duracion_est, comentarios, no_modulos modulos_est, no_escenas, no_actividades, no_evaluaciones, fk_cliente cliente, fk_tipo tipo, fk_tecnologia tecnologia, fk_recursos responsable, fk_estados estado FROM ".self::$tablas[10]." WHERE id = ".$id);
		foreach ($result[0] as $key => $value) {
			$objDatos->$key = $value;
		}
		$objEstandar->datos = $objDatos;
		return $objEstandar;
	}

	public function get_contribucion($id){
		$objDatos = new stdClass();
		$result = $this->db_con->get_sql_records("SELECT cap, cas, ctp, cts FROM ".self::$tablas[10]." WHERE id = ".$id);
		foreach ($result[0] as $key => $value) {
			$objDatos->$key = $value;
		}
		return $objDatos;
	}

	public function get_actividades_principales($id){
		$objActPrin = array();
		$result = $this->db_con->get_sql_records("SELECT DISTINCT t5.id idRol, t5.nombre nombreRol, t2.id idObj, t7.id faseN, t7.nombre_fase fase, t3.id actN, t3.nombre actividad, t2.tiempo_cotizado tiempo, t2.costo_cotizado costo FROM proyecto t1 JOIN proyecto_actividad t2 on t2.fk_proyecto = t1.id JOIN actividad t3 ON t3.id = t2.fk_actividad JOIN tarea t4 ON t3.id = t4.fk_actividad JOIN roles t5 ON t5.id = t2.fk_roles JOIN fases_proyecto t7 ON t7.id = t3.fk_fases WHERE t2.opcional = 0 AND t1.id =".$id);
		foreach ($result as $valueAct) {
			$objAct = new stdClass();
			foreach ($valueAct as $key => $value) {
				$objAct->$key = $value;
			}
			$objActPrin[] = $objAct;
		}
		return $objActPrin;
	}

	public function get_actividades_secundarias($id){
		$objActSec = array();
		$result = $this->db_con->get_sql_records("SELECT DISTINCT t5.id idRol, t5.nombre nombreRol, t2.id idObj, t7.id faseN, t7.nombre_fase fase, t3.id actN, t3.nombre actividad, t2.tiempo_cotizado tiempo, t2.costo_cotizado costo FROM proyecto t1 JOIN proyecto_actividad t2 on t2.fk_proyecto = t1.id JOIN actividad t3 ON t3.id = t2.fk_actividad JOIN tarea t4 ON t3.id = t4.fk_actividad JOIN roles t5 ON t5.id = t2.fk_roles JOIN fases_proyecto t7 ON t7.id = t3.fk_fases WHERE t2.opcional = 1 AND t1.id =".$id);
		foreach ($result as $valueAct) {
			$objAct = new stdClass();
			foreach ($valueAct as $key => $value) {
				$objAct->$key = $value;
			}
			$objActSec[] = $objAct;
		}
		return $objActSec;
	}

	public function get_tercero_principales($id){
		$objTerPrin = array();
		$result = $this->db_con->get_sql_records("SELECT * FROM ".self::$tablas[24]." WHERE ".self::$camposTer[1]." = ".$id." AND ".self::$camposTer[3]." = 0");
		foreach ($result as $valueAct) {
			$objAct = new stdClass();
			foreach ($valueAct as $key => $value) {
				$objAct->$key = $value;
			}
			$objTerPrin[] = $objAct;
		}
		return $objTerPrin;
	}

	public function get_tercero_secundarias($id){
		$objTerSec = array();
		$result = $this->db_con->get_sql_records("SELECT * FROM ".self::$tablas[24]." WHERE ".self::$camposTer[1]." = ".$id." AND ".self::$camposTer[3]." = 1");
		foreach ($result as $valueAct) {
			$objAct = new stdClass();
			foreach ($valueAct as $key => $value) {
				$objAct->$key = $value;
			}
			$objTerSec[] = $objAct;
		}
		return $objTerSec;
	}
}