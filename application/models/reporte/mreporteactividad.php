<?php
class mreporteactividad extends CI_Model
{
	private static $encabezados;
	private static $etiquetas_set;
	private static $etiquetas_get;
	private static $condicionales;

	private static $tablas;

	public function __construct()
	{
		parent::__construct();

		self::$encabezados[0] = "Actividad ID";
		self::$encabezados[1] = "Actividad";
		self::$encabezados[2] = "Tarea ID";
		self::$encabezados[3] = "Tarea";
		self::$encabezados[4] = "Fase";
		self::$encabezados[5] = "Rol";
		self::$encabezados[6] = "Estado";

		self::$etiquetas_get[0] = "id_actividad";
		self::$etiquetas_get[1] = "nombre_actividad";
		self::$etiquetas_get[2] = "id_tarea";
		self::$etiquetas_get[3] = "nombre_tarea";
		self::$etiquetas_get[4] = "nombre_fase";
		self::$etiquetas_get[5] = "rol";
		self::$etiquetas_get[6] = "estado";
		
		self::$etiquetas_set[0] = "t1.id as id_actividad";
		self::$etiquetas_set[1] = "t1.nombre as nombre_actividad";
		self::$etiquetas_set[2] = "t2.id as id_tarea";
		self::$etiquetas_set[3] = "t2.nombre as nombre_tarea";
		self::$etiquetas_set[4] = "t5.nombre_fase";
		self::$etiquetas_set[5] = "t4.nombre as rol";
		self::$etiquetas_set[6] = "t6.nombre as estado";

		self::$condicionales[0] = "t1.id = t2.fk_actividad";
		self::$condicionales[1] = "t3.fk_tarea = t2.id";
		self::$condicionales[2] = "t3.fk_roles = t4.id";
		self::$condicionales[3] = "t1.fk_fases = t5.id";
		self::$condicionales[4] = "t1.fk_estados = t6.id";

		self::$tablas = $this->db_struc->getTablas();
	}

	public function get_table_grafic_act(){
		return $this->lib->tabla_generar(self::$tablas[0]." AS t1, ".self::$tablas[18]." AS t2, ".self::$tablas[16]." AS t3, ".self::$tablas[15]." AS t4, ".self::$tablas[4]." AS t5, ".self::$tablas[3]." AS t6",
				self::$encabezados,self::$etiquetas_get,self::$condicionales,"","",self::$etiquetas_set);
	}
}