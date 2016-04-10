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
		$sql1=$this->db->query(utf8_decode($sentenciaSQL)) or die("No se pudo ejecutar la consulta ".$sentenciaSQL);
		
		if(count($sql1->result_array())>0 && count($sql1->result_array()[0])>0){
			return true;
		}else{
			return false;
		}
	}
	public function get_all_records($tabla, $parametros, $valores){
		$sentenciaSQL = "SELECT * FROM $tabla WHERE";
		$tamParam = count($parametros);
		for($i=0; $i<$tamParam-1; $i++){
			$sentenciaSQL .= " ".$parametros[$i]."='".$valores[$i]."' AND";
		}
		$sentenciaSQL .= " ".$parametros[$tamParam-1]."='".$valores[$tamParam-1]."';";
		$sql1=$this->db->query(utf8_decode($sentenciaSQL)) or die("No se pudo ejecutar la consulta ".$sentenciaSQL);
		
		return $sql1->result_array();
	}
	public function get_all_records_tabla($tabla, $parametros){
		$sentenciaSQL = "SELECT";
		$tamParam = count($parametros);
		for($i=0; $i<$tamParam-1; $i++){
			$sentenciaSQL .= " ".$parametros[$i].", ";
		}
		$sentenciaSQL .= " ".$parametros[$tamParam-1]." ";
		
		$sentenciaSQL .= " FROM $tabla";
		
		$sql1=$this->db->query(utf8_decode($sentenciaSQL)) or die("No se pudo ejecutar la consulta ".$sentenciaSQL);
		
		return $sql1->result_array();
	}
	public function get_sql_records($sentenciaSQL){
		$sql1=$this->db->query(utf8_decode($sentenciaSQL)) or die("No se pudo ejecutar la consulta ".$sentenciaSQL);
		
		return $$sql1->result_array();
	}
	public function insert_db_datos($tabla, $parametros, $valores)
	{
		$tamParam = count($parametros);
		$sentenciaSQL = "INSERT INTO $tabla (`";
		for($i = 0; $i<$tamParam-1; $i++){
			$sentenciaSQL .= $parametros[$i]."`, `";
		}
		$sentenciaSQL .= $parametros[$tamParam-1]."`) VALUES ('";
		for($i = 0; $i<$tamParam-1; $i++){
			$sentenciaSQL .= $valores[$i]."', '";
		}
		$sentenciaSQL .= $valores[$tamParam-1]."');";

		$sql1 = $this->db->query(utf8_decode($sentenciaSQL)) or die("No se pudo agregar el registro ".$sentenciaSQL);
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
			$sentenciaSQL .= "`".$nameID[$i]."` = '".$valueID[$i]."', ";
		}
		$sentenciaSQL .= "`".$nameID[$tamParam-1]."` = '".$valueID[$i]."'";
		
		$sql1 = $this->db->query(utf8_decode($sentenciaSQL)) or die("No se pudo actualizar el registro ".$sentenciaSQL);
	}

	public function delete_db_datos($tabla, $parametros, $valores){
		$tamParam = count($parametros);
		$sentenciaSQL = "DELETE FROM $tabla WHERE ";
		for($i = 0; $i<$tamParam-1; $i++){
			$sentenciaSQL .= "`".$parametros[$i]."` = '".$valores[$i]."' AND ";
		}
		$sentenciaSQL .= "`".$parametros[$tamParam-1]."` = '".$valores[$i]."'";
		$sql1 = $this->db->query(utf8_decode($sentenciaSQL)) or die("No se pudo borrar el registro ".$sentenciaSQL);
	}
}