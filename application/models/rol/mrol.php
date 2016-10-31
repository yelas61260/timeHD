<?php
class mrol extends CI_Model
{
	private static $campos;
	private static $campos2;
	private static $tablas;

	public function __construct()
	{
		parent::__construct();

		self::$campos[0] = "id";
		self::$campos[1] = "nombre";

		self::$campos2[0] = "fk_roles";
		self::$campos2[1] = "fk_tarea";

		self::$tablas = $this->db_struc->getTablas();
	}

	public function get_table_grafic(){
		return $this->lib->tabla_generar(self::$tablas[15],array("id","Nombre","",""),array("id","nombre","",""),[],"roles",self::$campos[0]);
	}

	public function get_campos(){
		return self::$campos;
	}

	public function get_campos2(){
		return self::$campos2;
	}
}