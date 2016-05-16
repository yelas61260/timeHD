<?php
class mreporterecursos extends CI_Model
{
	private static $encabezados;
	private static $etiquetas_set;
	private static $etiquetas_get;
	private static $condicionales;

	private static $tablas;

	public function __construct()
	{
		parent::__construct();

		self::$encabezados[0] = "Cedula";
		self::$encabezados[1] = "Nombre";
		self::$encabezados[2] = "Correo";
		self::$encabezados[3] = "Salario";
		self::$encabezados[4] = "Roles";

		self::$etiquetas_get[0] = "cedula";
		self::$etiquetas_get[1] = "nombre_completo";
		self::$etiquetas_get[2] = "correo";
		self::$etiquetas_get[3] = "salario";
		self::$etiquetas_get[4] = "rol";
		
		self::$etiquetas_set[0] = "t1.cedula";
		self::$etiquetas_set[1] = "CONCAT(t1.nombre, ' ', t1.apellido) as nombre_completo";
		self::$etiquetas_set[2] = "t1.correo";
		self::$etiquetas_set[3] = "t1.salario";
		self::$etiquetas_set[4] = "t3.nombre as rol";

		self::$condicionales[0] = "t1.cedula = t2.fk_recursos";
		self::$condicionales[1] = "t2.fk_roles = t3.id";

		self::$tablas = $this->db_struc->getTablas();
	}

	public function get_table_grafic_rec(){
		return $this->lib->tabla_generar(self::$tablas[12]." AS t1, ".self::$tablas[13]." AS t2, ".self::$tablas[15]." AS t3",
				self::$encabezados,self::$etiquetas_get,self::$condicionales,"","",self::$etiquetas_set);
	}
}