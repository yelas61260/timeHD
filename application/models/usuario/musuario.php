<?php
class musuario extends CI_Model
{
	private static $campos;
	private static $campos2;
	private static $campos3;
	private static $campos_read;

	private static $tablas;

	public function __construct()
	{
		parent::__construct();

		self::$campos[0] = "cedula";
		self::$campos[1] = "nombre";
		self::$campos[2] = "apellido";
		self::$campos[3] = "direccion";
		self::$campos[4] = "telefono_uno";
		self::$campos[5] = "telefono_dos";
		self::$campos[6] = "titulo";
		self::$campos[7] = "usuario";
		self::$campos[8] = "password";
		self::$campos[9] = "salario";
		self::$campos[10] = "cargo";
		self::$campos[11] = "correo";
		self::$campos[12] = "fk_estados";
		self::$campos[13] = "fk_ciudad";

		self::$campos_read[0] = "cedula";
		self::$campos_read[1] = 1;
		self::$campos_read[2] = 2;
		self::$campos_read[3] = "direccion";
		self::$campos_read[4] = "telefono_uno";
		self::$campos_read[5] = "telefono_dos";
		self::$campos_read[6] = "correo";
		self::$campos_read[7] = 15;
		self::$campos_read[8] = 16;
		self::$campos_read[9] = "titulo";
		self::$campos_read[10] = "cargo";
		self::$campos_read[11] = "salario";
		self::$campos_read[12] = "usuario";
		self::$campos_read[13] = "password";
		self::$campos_read[14] = "fk_estados";

		self::$campos2[0] = "nombre";
		self::$campos2[1] = "fk_pais";

		self::$campos3[0] = "fk_recursos";
		self::$campos3[1] = "fk_roles";

		self::$tablas = $this->db_struc->getTablas();
	}

	public function get_table_grafic(){
		return $this->lib->tabla_generar(self::$tablas[12],
				array("Cedula","Nombre","Apellido","Direccion","Telefono 1","Telefono 2","Titulo","Usuario","Salario","Cargo","",""),
				array("cedula","nombre","apellido","direccion","telefono_uno","telefono_dos","titulo","usuario","salario","cargo","",""),
				["fk_estados=1"],"usuario",self::get_id());
	}

	public function get_id(){
		return self::$campos[0];
	}

	public function get_campos(){
		return self::$campos;
	}

	public function get_campos2(){
		return self::$campos2;
	}

	public function get_campos3(){
		return self::$campos3;
	}

	public function get_campos_read(){
		return self::$campos_read;
	}
}