<?php
class mactividad extends CI_Model
{
	private static $ident;
	private static $idrel;
	private static $campos1;
	private static $campos2;
	private static $campos3;
	private static $campos4;
	private static $campos_time;

	private static $tablas;

	public function __construct()
	{
		parent::__construct();

		self::$ident = "id";
		self::$idrel = "id";

		self::$campos1[0] = "nombre";
		self::$campos1[1] = "fk_fases";
		self::$campos1[2] = "fk_estados";
		self::$campos1[3] = "cam_num";
		self::$campos1[4] = "fk_unidades";

		self::$campos2[0] = "fk_roles";
		self::$campos2[1] = "fk_tarea";

		self::$campos3[0] = "fk_fases";
		self::$campos3[1] = "nombre_fase";
		self::$campos3[2] = "id";
		self::$campos3[3] = "nombre";

		self::$campos4[0] = "nombre";
		self::$campos4[1] = "fk_actividad";

		self::$campos_time[0] = "id";
		self::$campos_time[1] = "fecha_inicio";
		self::$campos_time[2] = "fecha_finalizacion";
		self::$campos_time[3] = "hora_inicio";
		self::$campos_time[4] = "hora_fin";
		self::$campos_time[5] = "registro";
		self::$campos_time[6] = "num_escenas";
		self::$campos_time[7] = "fecha_inicio_date";
		self::$campos_time[8] = "fecha_finalizacion_date";
		self::$campos_time[9] = "fk_proyecto";
		self::$campos_time[10] = "fk_recursos";
		self::$campos_time[11] = "fk_actividad";

		self::$tablas = $this->db_struc->getTablas();
	}

	public function getRecordMinutosXEscenaAllRecursos($id){
		$datos1 = $this->db_con->get_sql_records("SELECT t3.cedula, concat(t3.nombre, ' ', t3.apellido) nombre_completo, 
			ROUND((hour(SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(t1.fecha_finalizacion_date,t1.fecha_inicio_date)))))*60+(minute(SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(t1.fecha_finalizacion_date,t1.fecha_inicio_date)))))))/IF(t2.cam_num>0,SUM(t1.num_escenas),1)) minXuni 
			FROM registro_actividad_proyecto_recurso t1 
			JOIN actividad t2 ON t2.id = t1.fk_actividad 
			JOIN recursos t3 ON t3.cedula = t1.fk_recursos 
			WHERE t1.fk_actividad=".$id." GROUP BY t1.fk_recursos ORDER BY t3.cedula ASC");
		$list_recursos = [];
		foreach ($datos1 as $recurso) {
			$record_recurso = new stdClass();
			$record_recurso->name = $recurso["nombre_completo"];
			$record_recurso->y = intval($recurso["minXuni"]);
			$record_recurso->drilldown = $recurso["cedula"];
			$list_recursos[] = $record_recurso;
		}
		return json_encode($list_recursos);
	}

	public function getRecordMinutosXEscenaXRecursoAllRecursos($id){
		$recursos = $this->db_con->get_sql_records("SELECT DISTINCT t2.cedula, t2.nombre FROM registro_actividad_proyecto_recurso t1 JOIN recursos t2 ON t2.cedula = t1.fk_recursos WHERE t1.fk_actividad = ".$id." ORDER BY t2.cedula ASC");
		$list_recursos = [];
		foreach ($recursos as $recurso) {
			$datos1 = $this->db_con->get_sql_records("SELECT CONCAT(YEAR(t1.fecha_inicio_date), '_', IF(MONTH(t1.fecha_inicio_date)<10,CONCAT('0',MONTH(t1.fecha_inicio_date)),MONTH(t1.fecha_inicio_date))) fecha, 
				ROUND((hour(SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(t1.fecha_finalizacion_date,t1.fecha_inicio_date)))))*60+(minute(SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(t1.fecha_finalizacion_date,t1.fecha_inicio_date)))))))/IF(t2.cam_num>0,SUM(t1.num_escenas),1)) cantXminuto
				FROM registro_actividad_proyecto_recurso t1 
				JOIN actividad t2 ON t2.id = t1.fk_actividad 
				JOIN recursos t3 ON t3.cedula = t1.fk_recursos 
				WHERE t1.fk_actividad=".$id." AND t1.fk_recursos = ".$recurso["cedula"]." GROUP BY fecha ORDER by fecha");
			$record_recurso = new stdClass();
			$record_recurso->name = $recurso["nombre"];
			$record_recurso->id = $recurso["cedula"];
			$record_recurso->data = [];
			foreach ($datos1 as $datos_recurso) {
				$record_recurso->data[] = [$datos_recurso["fecha"], intval($datos_recurso["cantXminuto"])];
			}
			$list_recursos[] = $record_recurso;
		}
		return json_encode($list_recursos);
	}

	public function mult_fecha($tiempo, $multiplo){
		$fecha_sep = explode(":", $tiempo);
		$tam_array = count($fecha_sep);
		$temp = 0;
		for ($i=$tam_array-1; $i>=0; $i--) {
			$fecha_sep[$i] = ((int)($fecha_sep[$i])*$multiplo)+$temp;
			if($i>0){
				$temp = floor($fecha_sep[$i]/60);
				$fecha_sep[$i] = $fecha_sep[$i]-($temp*60);
			}
		}
		if ($fecha_sep[0]<10) {
			$fecha_sep[0] = "0".$fecha_sep[0];
		}
		if ($fecha_sep[1]<10) {
			$fecha_sep[1] = "0".$fecha_sep[1];
		}
		if ($fecha_sep[2]<10) {
			$fecha_sep[2] = "0".$fecha_sep[2];
		}
		return join(":",$fecha_sep);
	}

	public function suma_fecha($tiempo1, $tiempo2){
		if ($tiempo1 == "") {
			$tiempo1 = "00:00:00";
		}
		if ($tiempo2 == "") {
			$tiempo2 = "00:00:00";
		}
		$fecha_sep1 = explode(":", $tiempo1);
		$fecha_sep2 = explode(":", $tiempo2);
		$fecha_res = [0,0,0];
		$tam_array = count($fecha_sep1);
		$temp = 0;
		for ($i=$tam_array-1; $i>=0; $i--) {
			$fecha_res[$i] = ((int)($fecha_sep1[$i])+(int)($fecha_sep2[$i]))+$temp;
			if($i>0){
				$temp = floor($fecha_res[$i]/60);
				$fecha_res[$i] = $fecha_res[$i]-($temp*60);
			}
		}
		if ($fecha_res[0]<10) {
			$fecha_res[0] = "0".$fecha_res[0];
		}
		if ($fecha_res[1]<10) {
			$fecha_res[1] = "0".$fecha_res[1];
		}
		if ($fecha_res[2]<10) {
			$fecha_res[2] = "0".$fecha_res[2];
		}
		return join(":",$fecha_res);
	}

	public function val_x_act($tiempo, $val_hora_recurso){
		$val_seg_recurso = $val_hora_recurso/3600;
		$fecha_sep = explode(":", $tiempo);
		$tam_array = count($fecha_sep);
		$tam_temp = [3600,60,1];
		$temp_sec = 0;
		for ($i=$tam_array-1; $i>=0; $i--) {
			$temp_sec += ((int)($fecha_sep[$i])*$tam_temp[$i]);
		}
		return floor($val_seg_recurso*$temp_sec);
	}

	public function get_table_grafic(){
		return $this->lib->tabla_generar(self::$tablas[0]." AS t1, ".self::$tablas[4]." AS t2",
				array("Nombre","Fase","",""),
				array("nombre","nombre_fase","",""),
				["t1.fk_fases = t2.id", "t1.fk_estados = 1"],"actividad",self::get_id(),
				["t1.id","t1.nombre","t2.nombre_fase"]);
	}

	public function get_id(){
		return self::$ident;
	}

	public function get_idrel(){
		return self::$idrel;
	}

	public function get_campos1(){
		return self::$campos1;
	}

	public function get_campos2(){
		return self::$campos2;
	}

	public function get_campos3(){
		return self::$campos3;
	}

	public function get_campos4(){
		return self::$campos4;
	}

	public function get_campos_time(){
		return self::$campos_time;
	}
}