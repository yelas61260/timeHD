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
		return $this->lib->print_lista(self::$tablas[4], ["id","nombre_fase"], "nombre_fase");
	}

	public function get_list_estado(){
		return $this->lib->print_lista(self::$tablas[3], ["id","nombre"], "nombre");
	}

	public function get_list_roles(){
		return $this->lib->print_lista(self::$tablas[15], ["id","nombre"], "nombre");
	}

	public function get_list_pais(){
		return $this->lib->print_lista(self::$tablas[5], ["id","nombre"], "nombre");
	}

	public function get_list_sector(){
		return $this->lib->print_lista(self::$tablas[17], ["id","nombre"], "nombre");
	}

	public function get_list_clientes(){
		return $this->lib->print_lista(self::$tablas[2], ["id","nombre"], "nombre");
	}

	public function get_list_t_desarrollo(){
		return $this->lib->print_lista(self::$tablas[19], ["id","nombre"], "nombre");
	}

	public function get_list_t_tecnologia(){
		return $this->lib->print_lista(self::$tablas[19], ["id","nombre"], "nombre");
	}

	public function get_list_responsable(){
		return $this->lib->print_lista(self::$tablas[12], ["cedula","CONCAT(nombre,' ',apellido)"], "CONCAT(nombre,' ',apellido)");
	}

	public function get_list_estado_proy(){
		return $this->lib->print_lista(self::$tablas[20], ["id","nombre"], "nombre");
	}

	public function get_list_actividades(){
		return $this->lib->print_lista(self::$tablas[0], ["id","nombre"], "nombre");
	}

	public function get_list_tareas(){
		return $this->lib->print_lista(self::$tablas[18], ["id","nombre"], "nombre");
	}

	public function get_list_proyecto(){
		return $this->lib->print_lista(self::$tablas[10], ["id","nombre"]);
	}

	public function get_list_unidad(){
		return $this->lib->print_lista(self::$tablas[22], ["id","nombre"]);
	}

	public function get_list_proyecto_x_cli($id_cli){
		return $this->lib->print_lista_filtrada(self::$tablas[10], ["id","nombre"], ["id","nombre"], "fk_cliente=".$id_cli, "nombre");
	}

	public function get_list_recurso_x_proy($id_proy){
		return $this->lib->print_lista_filtrada(self::$tablas[14].' AS t1, '.self::$tablas[12].' AS t2', ["cedula","nombre"], ["t2.cedula","t2.nombre"], "t1.fk_recursos = t2.cedula AND t1.fk_proyecto = ".$id_proy, "nombre");
	}

	public function get_list_actividad_x_rec($id_rec){
		return $this->lib->print_lista_filtrada(self::$tablas[14].' AS t1, '.self::$tablas[0].' AS t2', ["id","nombre"], ["t2.id","t2.nombre"], "t1.fk_actividad = t2.id AND t1.fk_recursos = ".$id_rec, "nombre");
	}
}