<?php
class musuario extends CI_Model
{
	private $campos;
	private $campos2;
	private $campos3;
	private $campos_read;

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