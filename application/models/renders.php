<?php
/**
* 
*/
class renders extends CI_Model
{
	private static $tablas;
	
	function __construct()
	{
		parent::__construct();

		self::$tablas = $this->db_struc->getTablas();
	}

	public function get_list_fase(){
		return $this->lib->print_lista(self::$tablas[4], ["id","nombre_fase"]);
	}

	public function get_list_estado(){
		return $this->lib->print_lista(self::$tablas[3], ["id","nombre"]);
	}

	public function get_list_roles(){
		return $this->lib->print_lista(self::$tablas[15], ["id","nombre"]);
	}

	public function get_list_pais(){
		return $this->lib->print_lista(self::$tablas[5], ["id","nombre"]);
	}

	public function get_list_sector(){
		return $this->lib->print_lista(self::$tablas[17], ["id","nombre"]);
	}
}