<?php

class db_con extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	public function existe_registro($tabla, $parametros, $valores){
		$sentenciaSQL = "SELECT * FROM $tabla WHERE";
		$tamParam = count($parametros);
		for($i=0; $i<$tamParam-1; $i++){
			$sentenciaSQL .= " ".$parametros[$i]."='".$valores[$i]."' AND";
		}
		$sentenciaSQL .= " ".$parametros[$tamParam-1]."='".$valores[$tamParam-1]."';";
		$this->lib->debug_time_print($sentenciaSQL);
		$sql1=$this->db->query($sentenciaSQL) or die("No se pudo ejecutar la consulta ".$sentenciaSQL);
		if(count($sql1->result_array())>0 && count($sql1->result_array()[0])>0){
			return true;
		}else{
			return false;
		}
	}
	public function get_all_records($tabla, $parametros, $valores, $campos_get=null, $order_by=null){
		$sentenciaSQL = "SELECT ";
		if($campos_get == null){
			$sentenciaSQL .= "*";
		}else{
			$tamCondicion = count($campos_get);
			for($k = 0; $k<$tamCondicion-1; $k++) {
				$sentenciaSQL .= $campos_get[$k].", ";
			}
			$sentenciaSQL .= $campos_get[$tamCondicion-1];
		}
		$sentenciaSQL .= " FROM $tabla WHERE";
		$tamParam = count($parametros);
		for($i=0; $i<$tamParam-1; $i++){
			$sentenciaSQL .= " ".$parametros[$i]."='".$valores[$i]."' AND";
		}
		$sentenciaSQL .= " ".$parametros[$tamParam-1]."='".$valores[$tamParam-1]."'";
		if ($order_by == null) {
			$sentenciaSQL .= ";";
		}else{
			$sentenciaSQL .= " ORDER BY ".$order_by." ASC;";
		}
		$this->lib->debug_time_print($sentenciaSQL);
		$sql1=$this->db->query($sentenciaSQL) or die("No se pudo ejecutar la consulta ".$sentenciaSQL);

		return $sql1->result_array();
	}
	public function get_all_records_tabla($tabla, $parametros, $order_by=null){
		$sentenciaSQL = "SELECT ";
		$tamParam = count($parametros);
		for($i=0; $i<$tamParam-1; $i++){
			$sentenciaSQL .= $parametros[$i].", ";
		}
		$sentenciaSQL .= $parametros[$tamParam-1]." ";
		
		$sentenciaSQL .= "FROM $tabla";

		if ($order_by == null) {
			$sentenciaSQL .= ";";
		}else{
			$sentenciaSQL .= " ORDER BY ".$order_by." ASC;";
		}
		$this->lib->debug_time_print($sentenciaSQL);
		$sql1=$this->db->query($sentenciaSQL) or die("No se pudo ejecutar la consulta ".$sentenciaSQL);
		
		return $sql1->result_array();
	}
	public function get_all_records_tabla_where($tabla, $parametros, $condicion, $order_by=null){
		$sentenciaSQL = "SELECT DISTINCT";
		$tamParam = count($parametros);
		for($i=0; $i<$tamParam-1; $i++){
			$sentenciaSQL .= " ".$parametros[$i].", ";
		}
		$sentenciaSQL .= " ".$parametros[$tamParam-1]." ";
		
		$sentenciaSQL .= " FROM $tabla WHERE ".$condicion;

		if ($order_by == null) {
			$sentenciaSQL .= ";";
		}else{
			$sentenciaSQL .= " ORDER BY ".$order_by." ASC;";
		}
		$this->lib->debug_time_print($sentenciaSQL);
		$sql1=$this->db->query($sentenciaSQL) or die("No se pudo ejecutar la consulta ".$sentenciaSQL);
		
		return $sql1->result_array();
	}
	public function get_sql_records($sentenciaSQL){
		$this->lib->debug_time_print($sentenciaSQL);
		$sql1=$this->db->query($sentenciaSQL) or die("No se pudo ejecutar la consulta ".$sentenciaSQL);
		
		return $sql1->result_array();
	}
	public function insert_db_datos($tabla, $parametros, $valores)
	{
		$tamParam = count($parametros);
		$datos_array = [];
		for($i = 0; $i<$tamParam; $i++){
			$datos_array[$parametros[$i]] = $valores[$i];
		}

		$sql1 = $this->db->insert($tabla, $datos_array);

		return $this->db->insert_id();
	}
	
	public function update_db_datos($tabla, $parametros, $valores, $nameID, $valueID){
		$tamParam = count($parametros);
		$sentenciaSQL = "UPDATE $tabla SET ";
		for($i = 0; $i<$tamParam-1; $i++){
			$sentenciaSQL .= "`".$parametros[$i]."` = '".$valores[$i]."', ";
		}
		$sentenciaSQL .= "`".$parametros[$tamParam-1]."`= '".$valores[$i]."' WHERE ";
		$tamParam = count($nameID);
		for($i = 0; $i<$tamParam-1; $i++){
			$sentenciaSQL .= "`".$nameID[$i]."` = '".$valueID[$i]."' AND ";
		}
		$sentenciaSQL .= "`".$nameID[$tamParam-1]."` = '".$valueID[$i]."'";
		$this->lib->debug_time_print($sentenciaSQL);
		$sql1 = $this->db->query($sentenciaSQL) or die("No se pudo actualizar el registro ".$sentenciaSQL);
	}

	public function delete_db_datos($tabla, $parametros, $valores){
		$tamParam = count($parametros);
		$sentenciaSQL = "DELETE FROM $tabla WHERE ";
		for($i = 0; $i<$tamParam-1; $i++){
			$sentenciaSQL .= "`".$parametros[$i]."` = ".$valores[$i]." AND ";
		}
		$sentenciaSQL .= "`".$parametros[$tamParam-1]."` = ".$valores[$i]."";
		$this->lib->debug_time_print($sentenciaSQL);
		$sql1 = $this->db->query($sentenciaSQL) or die("No se pudo borrar el registro ".$sentenciaSQL);
	}
}