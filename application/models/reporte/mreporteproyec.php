<?php
class mreporteproyec extends CI_Model
{
	private static $encabezados;
	private static $etiquetas_set;
	private static $etiquetas_get;
	private static $condicionales;

	private static $tablas;

	public function __construct()
	{
		parent::__construct();

		self::$encabezados[0] = "Cliente ID";
		self::$encabezados[1] = "Cliente";
		self::$encabezados[2] = "Proyecto ID";
		self::$encabezados[3] = "Proyecto";
		self::$encabezados[4] = "Estado";

		self::$etiquetas_get[0] = "id_cliente";
		self::$etiquetas_get[1] = "nombre_cliente";
		self::$etiquetas_get[2] = "id_proyecto";
		self::$etiquetas_get[3] = "nombre_proyecto";
		self::$etiquetas_get[4] = "estado";
		
		self::$etiquetas_set[0] = "t2.id AS id_cliente";
		self::$etiquetas_set[1] = "t2.nombre AS nombre_cliente";
		self::$etiquetas_set[2] = "t1.id AS id_proyecto";
		self::$etiquetas_set[3] = "t1.nombre AS nombre_proyecto";
		self::$etiquetas_set[4] = "t3.nombre as estado";

		self::$condicionales[0] = "t1.fk_cliente = t2.id";
		self::$condicionales[1] = "t3.id = t1.fk_estados";

		self::$tablas = $this->db_struc->getTablas();
	}

	public function get_table_grafic_proyectos(){
		return $this->lib->tabla_generar(self::$tablas[10]." AS t1, ".self::$tablas[2]." AS t2, ".self::$tablas[20]." AS t3",
				self::$encabezados,self::$etiquetas_get,self::$condicionales,"","",self::$etiquetas_set);
	}
}