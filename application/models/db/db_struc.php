<?php

class db_struc extends CI_Model {

	private static $tablas;

	public function __construct()
	{
		parent::__construct();

		self::$tablas[0] = "actividad";
		self::$tablas[1] = "ciudad";
		self::$tablas[2] = "cliente";
		self::$tablas[3] = "estados";
		self::$tablas[4] = "fases_proyecto";
		self::$tablas[5] = "pais";
		self::$tablas[6] = "permisos";
		self::$tablas[7] = "permisos_rol";
		self::$tablas[8] = "plantillas";
		self::$tablas[9] = "plantilla_actividad";
		self::$tablas[10] = "proyecto";
		self::$tablas[11] = "proyecto_actividad";
		self::$tablas[12] = "recursos";
		self::$tablas[13] = "recurso_rol";
		self::$tablas[14] = "registro_actividad_proyecto_recurso";
		self::$tablas[15] = "roles";
		self::$tablas[16] = "rol_tarea";
		self::$tablas[17] = "sector_econo";
		self::$tablas[18] = "tarea";
		self::$tablas[19] = "tipo_proyecto";
		self::$tablas[20] = "estados_proyecto";
		self::$tablas[21] = "config";
	}

	public function getTablas(){
		return self::$tablas;
	}

}