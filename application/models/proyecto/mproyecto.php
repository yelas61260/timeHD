<?php
class mproyecto extends CI_Model
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
		self::$campos[3] = "fecha_inicio_real";
		self::$campos[4] = "fecha_fin_real";
		self::$campos[5] = "duracion_minutos";
		self::$campos[6] = "comentarios";
		self::$campos[7] = "no_modulos";
		self::$campos[8] = "no_escenas";
		self::$campos[9] = "no_actividades";
		self::$campos[10] = "no_evaluaciones";
		self::$campos[11] = "fk_cliente";
		self::$campos[12] = "fk_tipo";
		self::$campos[13] = "fk_tecnologia";
		self::$campos[14] = "fk_recursos";
		self::$campos[15] = "fk_estados";

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

		self::$camposAct[0] = "fk_proyecto";
		self::$camposAct[1] = "fk_roles";
		self::$camposAct[2] = "fk_actividad";
		self::$camposAct[3] = "costo_facturado";
		self::$camposAct[4] = "opcional";

		self::$camposTer[0] = "nombre";
		self::$camposTer[1] = "fk_proyecto";
		self::$camposTer[2] = "costo";
		self::$camposTer[3] = "costo_real";
		self::$camposTer[4] = "opcional";

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

	public function get_campos_act(){
		return self::$camposAct;
	}

	public function get_campos_ter(){
		return self::$camposTer;
	}

	public function getRecordProyectoAllRoles($id_proyecto){
		$datos1 = $this->db_con->get_sql_records("SELECT t4.id, t4.nombre rol, (hour(SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(t1.fecha_finalizacion_date,t1.fecha_inicio_date)))))*60+(minute(SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(t1.fecha_finalizacion_date,t1.fecha_inicio_date))))))) tiempo
			FROM registro_actividad_proyecto_recurso t1
			JOIN roles t4 ON t4.id = t1.fk_roles
			WHERE t1.fk_proyecto=".$id_proyecto."
			GROUP BY t4.id ORDER BY t4.id ASC");
		$list_roles = [];
		foreach ($datos1 as $rol) {
			$record_rol = new stdClass();
			$record_rol->name = $rol["rol"];
			$record_rol->y = intval($rol["tiempo"]);
			$record_rol->drilldown = $rol["id"];
			$list_roles[] = $record_rol;
		}
		return json_encode($list_roles);
	}

	public function getRecordProyectoXRolAllRoles($id_proyecto){
		$roles = $this->db_con->get_sql_records("SELECT * FROM roles ORDER BY id ASC");
		$list_roles = [];
		foreach ($roles as $rol) {
			$datos1 = $this->db_con->get_sql_records("SELECT CONCAT(YEAR(t1.fecha_inicio_date), '_', IF(MONTH(t1.fecha_inicio_date)<10,CONCAT('0',MONTH(t1.fecha_inicio_date)),MONTH(t1.fecha_inicio_date))) fecha, (hour(SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(t1.fecha_finalizacion_date,t1.fecha_inicio_date)))))*60+(minute(SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(t1.fecha_finalizacion_date,t1.fecha_inicio_date))))))) tiempo
				FROM registro_actividad_proyecto_recurso t1
				JOIN roles t4 ON t4.id = t1.fk_roles
				WHERE t1.fk_proyecto=".$id_proyecto." AND t4.id = '".$rol["id"]."'
				GROUP BY fecha
				ORDER by fecha");
			$record_rol = new stdClass();
			$record_rol->name = $rol["nombre"];
			$record_rol->id = $rol["id"];
			$record_rol->data = [];
			foreach ($datos1 as $datos_rol) {
				$record_rol->data[] = [$datos_rol["fecha"], intval($datos_rol["tiempo"])];
			}
			$list_roles[] = $record_rol;
		}
		return json_encode($list_roles);
	}

	public function getRecordProyectoXActividadAllActividades($id_proyecto){
		$list_categorias = json_decode(self::getFechasProyecto($id_proyecto));
		$sql_query1 = "SELECT DISTINCT t2.id, t2.nombre FROM registro_actividad_proyecto_recurso t1 JOIN actividad t2 ON t1.fk_actividad = t2.id WHERE t1.fk_proyecto=1 ORDER BY t2.nombre ASC";
		$record_sql1 = $this->db_con->get_sql_records($sql_query1);

		$list_actividades = [];
		foreach ($record_sql1 as $actividad_record) {
			$sql_query2 = "SELECT CONCAT(YEAR(t1.fecha_inicio_date), '_', IF(MONTH(t1.fecha_inicio_date)<10,CONCAT('0',MONTH(t1.fecha_inicio_date)),MONTH(t1.fecha_inicio_date))) fecha, 
			(hour(SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(t1.fecha_finalizacion_date,t1.fecha_inicio_date)))))*60+(minute(SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(t1.fecha_finalizacion_date,t1.fecha_inicio_date))))))) tiempo 
			FROM registro_actividad_proyecto_recurso t1 JOIN actividad t2 ON t1.fk_actividad = t2.id 
			WHERE t1.fk_proyecto=".$id_proyecto." AND t1.fk_actividad = ".$actividad_record["id"]." GROUP BY fecha ORDER BY fecha ASC";
			$record_sql2 = $this->db_con->get_sql_records($sql_query2);
			$temp_actividad = new stdClass();
			$temp_actividad->name = $actividad_record["nombre"];
			$temp_actividad->data = [];
			$pos_fecha_act = 0;
			$tam_fecha_act = count($record_sql2);
			foreach ($list_categorias as $fecha) {
				if ($pos_fecha_act < $tam_fecha_act && $fecha == $record_sql2[$pos_fecha_act]["fecha"]) {
					$temp_actividad->data[] = intval($record_sql2[$pos_fecha_act]["tiempo"]);
					$pos_fecha_act++;
				}else{
					$temp_actividad->data[] = 0;
				}
			}
			$list_actividades[] = $temp_actividad;
		}
		return json_encode($list_actividades);		
	}

	public function getFechasProyecto($id_proyecto){
		$datos1 = $this->db_con->get_sql_records("SELECT DISTINCT CONCAT(YEAR(t1.fecha_inicio_date), '_', IF(MONTH(t1.fecha_inicio_date)<10,CONCAT('0',MONTH(t1.fecha_inicio_date)),MONTH(t1.fecha_inicio_date))) fecha
			FROM registro_actividad_proyecto_recurso t1
			WHERE t1.fk_proyecto=".$id_proyecto."
			ORDER by fecha ASC");
		$list_categorias = [];
		foreach ($datos1 as $dato) {
			$list_categorias[] = $dato["fecha"];
		}
		return json_encode($list_categorias);
	}

	public function get_datos($id){
		$objEstandar = new stdClass();
		$objDatos = new stdClass();
		$result = $this->db_con->get_sql_records("SELECT id, nombre, fecha_inicio_estimada fecha_ini, fecha_fin_estimada fecha_fin_est, fecha_inicio_real fecha_ini_real, fecha_fin_real, duracion_minutos duracion_est, comentarios, no_modulos modulos_est, no_escenas, no_actividades, no_evaluaciones, fk_cliente cliente, fk_tipo tipo, fk_tecnologia tecnologia, fk_recursos responsable, fk_estados estado FROM ".self::$tablas[10]." WHERE id = ".$id);
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
		$this->load->model('actividad/mactividad');
		$objActPrin = array();
		$objActSecu = array();
		$isSecunda = false;
		$result = $this->db_con->get_sql_records("SELECT DISTINCT t5.id idRol, t5.nombre nombreRol, t2.id idObj, t7.id faseN, t7.nombre_fase fase, t3.id actN, t3.nombre actividad, SEC_TO_TIME(t2.tiempo_cotizado*3600) tiempo_est, '00:00:00' tiempo_fac, t2.costo_cotizado costo_est, 0 costo_fac, t2.opcional opcional FROM proyecto t1 JOIN proyecto_actividad t2 on t2.fk_proyecto = t1.id JOIN actividad t3 ON t3.id = t2.fk_actividad JOIN tarea t4 ON t3.id = t4.fk_actividad JOIN roles t5 ON t5.id = t2.fk_roles JOIN fases_proyecto t7 ON t7.id = t3.fk_fases WHERE t1.id =".$id);
		foreach ($result as $valueAct) {
			if ($valueAct["opcional"] == 0) {
				$objAct = new stdClass();
				foreach ($valueAct as $key => $value) {
					if($key != "opcional"){
						$objAct->$key = $value;
					}
				}
				$objActPrin[] = $objAct;
			}else{
				$objAct = new stdClass();
				foreach ($valueAct as $key => $value) {
					if($key != "opcional"){
						$objAct->$key = $value;
					}
				}
				$objActSecu[] = $objAct;
			}
		}
		$result_fac = $this->db_con->get_sql_records("SELECT t1.fk_roles idRol, COALESCE((SELECT nombre FROM roles WHERE id = t1.fk_roles), 'No definido') nombreRol, -1 idObj, t3.id faseN, t3.nombre_fase fase, t1.fk_actividad actN, t2.nombre actividad, '00:00:00' tiempo_est, COALESCE(TIMEDIFF(t1.fecha_finalizacion_date,t1.fecha_inicio_date),'00:00:00') tiempo_fac, 0 costo_est, COALESCE(ROUND((TIME_TO_SEC(TIMEDIFF(t1.fecha_finalizacion_date,t1.fecha_inicio_date))/3600)*(SELECT DISTINCT AVG(t40.salario) AS dat1 FROM tarea AS t10 JOIN rol_tarea AS t20 ON t20.fk_tarea = t10.id JOIN recurso_rol AS t30 ON t30.fk_roles = t20.fk_roles JOIN recursos AS t40 ON t40.cedula = t30.fk_recursos WHERE t10.fk_actividad = t1.fk_actividad)),0) costo_fac FROM registro_actividad_proyecto_recurso t1 JOIN actividad t2 ON t1.fk_actividad = t2.id JOIN fases_proyecto t3 ON t2.fk_fases = t3.id WHERE t1.fk_proyecto = ".$id);
		foreach ($result_fac as $valueAct_fac) {
			$objAct = new stdClass();
			$isSecunda = false;
			foreach ($valueAct_fac as $key_fac => $value_fac) {
				$objAct->$key_fac = $value_fac;
			}
			foreach ($objActSecu as $key => $value_s) {
				if ($value_s->idRol == $objAct->idRol && $value_s->actN == $objAct->actN) {
					$isSecunda = true;
					continue 2;
				}
			}
			if (!$isSecunda) {
				foreach ($objActPrin as $key_f => $value_f) {
					if ($value_f->idRol == $objAct->idRol && $value_f->actN == $objAct->actN) {
						$value_f->tiempo_fac = $this->mactividad->suma_fecha($value_f->tiempo_fac, $objAct->tiempo_fac);
						$value_f->costo_fac = $value_f->costo_fac + $objAct->costo_fac;
						continue 2;
					}
				}
				$objActPrin[] = $objAct;
			}
		}
		return $objActPrin;
	}

	public function get_actividades_secundarias($id){
		$objActSec = array();
		$result = $this->db_con->get_sql_records("SELECT DISTINCT t5.id idRol, t5.nombre nombreRol, t2.id idObj, t7.id faseN, t7.nombre_fase fase, t3.id actN, t3.nombre actividad, SEC_TO_TIME(t2.tiempo_cotizado*3600) tiempo_est, '00:00:00' tiempo_fac, t2.costo_cotizado costo_est, 0 costo_fac FROM proyecto t1 JOIN proyecto_actividad t2 on t2.fk_proyecto = t1.id JOIN actividad t3 ON t3.id = t2.fk_actividad JOIN tarea t4 ON t3.id = t4.fk_actividad JOIN roles t5 ON t5.id = t2.fk_roles JOIN fases_proyecto t7 ON t7.id = t3.fk_fases WHERE t2.opcional = 1 AND t1.id =".$id);
		foreach ($result as $valueAct) {
			$objAct = new stdClass();
			foreach ($valueAct as $key => $value) {
				$objAct->$key = $value;
			}
			$objActSec[] = $objAct;
		}
		$result_fac = $this->db_con->get_sql_records("SELECT t1.fk_roles idRol, COALESCE((SELECT nombre FROM roles WHERE id = t1.fk_roles), 'No definido') nombreRol, -1 idObj, t3.id faseN, t3.nombre_fase fase, t1.fk_actividad actN, t2.nombre actividad, '00:00:00' tiempo_est, TIMEDIFF(t1.fecha_finalizacion_date,t1.fecha_inicio_date) tiempo_fac, 0 costo_est, ROUND((TIME_TO_SEC(TIMEDIFF(t1.fecha_finalizacion_date,t1.fecha_inicio_date))/3600)*(SELECT DISTINCT AVG(t40.salario) AS dat1 FROM tarea AS t10 JOIN rol_tarea AS t20 ON t20.fk_tarea = t10.id JOIN recurso_rol AS t30 ON t30.fk_roles = t20.fk_roles JOIN recursos AS t40 ON t40.cedula = t30.fk_recursos WHERE t10.fk_actividad = t1.fk_actividad)) costo_fac FROM registro_actividad_proyecto_recurso t1 JOIN actividad t2 ON t1.fk_actividad = t2.id JOIN fases_proyecto t3 ON t2.fk_fases = t3.id WHERE t1.fk_proyecto = ".$id);
		foreach ($result_fac as $valueAct_fac) {
			$objAct = new stdClass();
			foreach ($valueAct_fac as $key_fac => $value_fac) {
				$objAct->$key_fac = $value_fac;
			}
			foreach ($objActSec as $key_f => $value_f) {
				if ($value_f->idRol == $objAct->idRol && $value_f->actN == $objAct->actN) {
					$value_f->tiempo_fac = $this->mactividad->suma_fecha($value_f->tiempo_fac, $objAct->tiempo_fac);
					$value_f->costo_fac = $value_f->costo_fac + $objAct->costo_fac;
					continue 2;
				}
			}
		}
		return $objActSec;
	}

	public function get_tercero_principales($id){
		$objTerPrin = array();
		$result = $this->db_con->get_sql_records("SELECT * FROM ".self::$tablas[24]." WHERE ".self::$camposTer[1]." = ".$id." AND ".self::$camposTer[4]." = 0");
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
		$result = $this->db_con->get_sql_records("SELECT * FROM ".self::$tablas[24]." WHERE ".self::$camposTer[1]." = ".$id." AND ".self::$camposTer[4]." = 1");
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