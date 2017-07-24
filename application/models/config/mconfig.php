<?php
class mconfig extends CI_Model
{
	private static $tablas;
	private static $campos;
	private static $opciones;

	public function __construct(){
		parent::__construct();

		self::$campos[0] = "nombre";
		self::$campos[1] = "valor";

		self::$opciones[0] = "hda";
		self::$opciones[0] = "hdi";
		self::$opciones[0] = "hds";
		
		self::$tablas = $this->db_struc->getTablas();
	}

	public function get_campos(){
		return self::$campos;
	}

	public function get_opciones(){
		return self::$opciones;
	}
}