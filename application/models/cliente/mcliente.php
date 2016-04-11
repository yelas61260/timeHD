<?php
class mcliente extends CI_Model
{
	private $campos;
	private $campos2;
	private $campos_read;

	public function __construct()
	{
		parent::__construct();

		self::$campos[0] = "id";
		self::$campos[1] = "nombre";
		self::$campos[2] = "direccion";
		self::$campos[3] = "nombre_contacto";
		self::$campos[4] = "apellido_contacto";
		self::$campos[5] = "correo";
		self::$campos[6] = "telefono_uno";
		self::$campos[7] = "telefono2";
		self::$campos[8] = "fk_ciudad";
		self::$campos[9] = "fk_sector";
		self::$campos[10] = "fk_estados";

		self::$campos_read[0] = 1;
		self::$campos_read[1] = 12;
		self::$campos_read[2] = "fk_pais";
		self::$campos_read[3] = "direccion";
		self::$campos_read[4] = "nombre_contacto";
		self::$campos_read[5] = "apellido_contacto";
		self::$campos_read[6] = "telefono_uno";
		self::$campos_read[7] = "telefono2";
		self::$campos_read[8] = "correo";
		self::$campos_read[9] = "fk_sector";

		self::$campos2[0] = "nombre";
		self::$campos2[1] = "fk_pais";
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

	public function get_campos_read(){
		return self::$campos_read;
	}
}