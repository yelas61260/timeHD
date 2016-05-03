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

	public function get_list_clientes(){
		return $this->lib->print_lista(self::$tablas[2], ["id","nombre"]);
	}

	public function get_list_t_desarrollo(){
		return $this->lib->print_lista(self::$tablas[19], ["id","nombre"]);
	}

	public function get_list_t_tecnologia(){
		return $this->lib->print_lista(self::$tablas[19], ["id","nombre"]);
	}

	public function get_list_responsable(){
		return $this->lib->print_lista(self::$tablas[12], ["cedula","nombre"]);
	}

	public function get_list_estado_proy(){
		return $this->lib->print_lista(self::$tablas[20], ["id","nombre"]);
	}

	public function get_list_actividades(){
		return $this->lib->print_lista(self::$tablas[0], ["id","nombre"]);
	}
}