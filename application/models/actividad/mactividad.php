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
		return join(":",$fecha_sep);
	}

	public function suma_fecha($tiempo1, $tiempo2){
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