<?php
class mhome extends CI_Model
{
	private static $ItemsMenu;
	private static $LinkMenu;

	public function __construct()
	{
		parent::__construct();

		self::$ItemsMenu[0] = "i7";
		self::$ItemsMenu[1] = "i9";
		self::$ItemsMenu[2] = "i8";
		self::$ItemsMenu[3] = "i2";
		self::$ItemsMenu[4] = "i1";
		self::$ItemsMenu[5] = "i6";
		self::$ItemsMenu[6] = "i5";
		self::$ItemsMenu[7] = "i4";
		self::$ItemsMenu[8] = "i10";
		self::$ItemsMenu[9] = "i11";

		self::$LinkMenu[0] = "usuario";
		self::$LinkMenu[1] = "cliente";
		self::$LinkMenu[2] = "actividad";
		self::$LinkMenu[3] = "cotizacion/create";
		self::$LinkMenu[4] = "reportes";
		self::$LinkMenu[5] = "proyecto";
		self::$LinkMenu[6] = "cotizacion";
		self::$LinkMenu[7] = "estandar";
		self::$LinkMenu[8] = "config";
		self::$LinkMenu[9] = "rol";
	}

	public function getItems(){
		return self::$ItemsMenu;
	}

	public function getLinks(){
		return self::$LinkMenu;
	}
}