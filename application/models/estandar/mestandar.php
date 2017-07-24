<?php
class mestandar extends CI_Model
{
	private static $id;
	private static $campos;
	private static $camposAct;
	private static $camposTer;

	private static $tablas;

	public function __construct()
	{
		parent::__construct();

		self::$id = "id";

		self::$campos[0] = "codigo";
		self::$campos[1] = "nombre";
		self::$campos[2] = "fk_tipo";
		self::$campos[3] = "descripcion";

		self::$camposAct[0] = "fk_plantillas";
		self::$camposAct[1] = "fk_roles";
		self::$camposAct[2] = "fk_actividad";
		self::$camposAct[3] = "tiempo";
		self::$camposAct[4] = "opcional";

		self::$camposTer[0] = "nombre";
		self::$camposTer[1] = "fk_plantilla";
		self::$camposTer[2] = "costo";
		self::$camposTer[3] = "opcional";

		self::$tablas = $this->db_struc->getTablas();
	}

	public function get_table_grafic(){
		return $this->lib->tabla_generar(self::$tablas[8]." AS t1, ".self::$tablas[19]." AS t2",
				array("Nombre","Descripción","Tipo","",""),
				array("nombre","descripcion","tipo","",""),
				["t1.fk_tipo=t2.id"],"estandar",self::get_id(),
				["t1.id as id","t1.nombre","t1.descripcion","t2.nombre as tipo"]);
	}
	public function get_datos($id){
		$objEstandar = new stdClass();
		$objDatos = new stdClass();
		$result = $this->db_con->get_sql_records("SELECT id, codigo, nombre, fk_tipo tipo, descripcion FROM ".self::$tablas[8]." WHERE id = ".$id);
		foreach ($result[0] as $key => $value) {
			$objDatos->$key = $value;
		}
		$objEstandar->datos = $objDatos;
		return $objEstandar;
	}

	public function get_actividades_principales($id){
		$objActPrin = array();
		$result = $this->db_con->get_sql_records("SELECT DISTINCT t5.id idRol, t5.nombre nombreRol, t2.id idObj, t7.id faseN, t7.nombre_fase fase, t3.id actN, t3.nombre actividad, t2.tiempo FROM plantillas t1 JOIN plantilla_actividad t2 on t2.fk_plantillas = t1.id JOIN actividad t3 ON t3.id = t2.fk_actividad JOIN tarea t4 ON t3.id = t4.fk_actividad JOIN roles t5 ON t5.id = t2.fk_roles JOIN fases_proyecto t7 ON t7.id = t3.fk_fases WHERE t2.opcional = 0 AND t1.id = ".$id);
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
		$result = $this->db_con->get_sql_records("SELECT DISTINCT t5.id idRol, t5.nombre nombreRol, t2.id idObj, t7.id faseN, t7.nombre_fase fase, t3.id actN, t3.nombre actividad, t2.tiempo FROM plantillas t1 JOIN plantilla_actividad t2 on t2.fk_plantillas = t1.id JOIN actividad t3 ON t3.id = t2.fk_actividad JOIN tarea t4 ON t3.id = t4.fk_actividad JOIN roles t5 ON t5.id = t2.fk_roles JOIN fases_proyecto t7 ON t7.id = t3.fk_fases WHERE t2.opcional = 1 AND t1.id = ".$id);
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
		$result = $this->db_con->get_sql_records("SELECT * FROM ".self::$tablas[23]." WHERE ".self::$camposTer[1]." = ".$id." AND ".self::$camposTer[3]." = 0");
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
		$result = $this->db_con->get_sql_records("SELECT * FROM ".self::$tablas[23]." WHERE ".self::$camposTer[1]." = ".$id." AND ".self::$camposTer[3]." = 1");
		foreach ($result as $valueAct) {
			$objAct = new stdClass();
			foreach ($valueAct as $key => $value) {
				$objAct->$key = $value;
			}
			$objTerSec[] = $objAct;
		}
		return $objTerSec;
	}

	public function get_id(){
		return self::$id;
	}

	public function get_campos(){
		return self::$campos;
	}

	public function get_campos_act(){
		return self::$camposAct;
	}

	public function get_campos_ter(){
		return self::$camposTer;
	}
}