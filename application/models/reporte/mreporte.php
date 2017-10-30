<?php
class mreporte extends CI_Model
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
		self::$encabezados[2] = "Tipo de Proyecto";
		self::$encabezados[3] = "Estado del Proyecto";
		self::$encabezados[4] = "Proyecto ID";
		self::$encabezados[5] = "Proyecto";
		self::$encabezados[6] = "Cedula";
		self::$encabezados[7] = "Colaborador";
		self::$encabezados[8] = "Fase";
		self::$encabezados[9] = "Actividad";
		self::$encabezados[10] = "Cantidad";
		self::$encabezados[11] = "Unidad";
		self::$encabezados[12] = "Inicio";
		self::$encabezados[13] = "Finalización";
		self::$encabezados[14] = "Duración";

		self::$etiquetas_get[0] = "id_cliente";
		self::$etiquetas_get[1] = "nombre_cliente";
		self::$etiquetas_get[2] = "tipo_proyecto";
		self::$etiquetas_get[3] = "estado_proyecto";
		self::$etiquetas_get[4] = "id_proyecto";
		self::$etiquetas_get[5] = "nombre_proyecto";
		self::$etiquetas_get[6] = "cedula";
		self::$etiquetas_get[7] = "nombre_colaborador";
		self::$etiquetas_get[8] = "nombre_fase";
		self::$etiquetas_get[9] = "nombre_actividad";
		self::$etiquetas_get[10] = "cantidad";
		self::$etiquetas_get[11] = "unidad";
		self::$etiquetas_get[12] = "inicio_de_actividad";
		self::$etiquetas_get[13] = "finalizacion_de_actividad";
		self::$etiquetas_get[14] = "duracion";
		
		self::$etiquetas_set[0] = "t1.id AS id_cliente";
		self::$etiquetas_set[1] = "t1.nombre AS nombre_cliente";
		self::$etiquetas_set[2] = "t5.nombre AS tipo_proyecto";
		self::$etiquetas_set[3] = "t2.nombre AS estado_proyecto";
		self::$etiquetas_set[4] = "t3.id AS id_proyecto";
		self::$etiquetas_set[5] = "t3.nombre AS nombre_proyecto";
		self::$etiquetas_set[6] = "t6.cedula AS cedula";
		self::$etiquetas_set[7] = "CONCAT(t6.nombre, ' ', t6.apellido) AS nombre_colaborador";
		self::$etiquetas_set[8] = "t8.nombre_fase AS nombre_fase";
		self::$etiquetas_set[9] = "t7.nombre AS nombre_actividad";
		self::$etiquetas_set[10] = "t4.num_escenas AS cantidad";
		self::$etiquetas_set[11] = "t9.nombre AS unidad";
		self::$etiquetas_set[12] = "t4.fecha_inicio_date AS inicio_de_actividad";
		self::$etiquetas_set[13] = "t4.fecha_finalizacion_date AS finalizacion_de_actividad";
		self::$etiquetas_set[14] = "TIMEDIFF(t4.fecha_finalizacion_date,t4.fecha_inicio_date) AS duracion";

		self::$condicionales[0] = "t4.fk_proyecto = t3.id";
		self::$condicionales[1] = "t4.fk_recursos = t6.cedula";
		self::$condicionales[2] = "t4.fk_actividad = t7.id";
		self::$condicionales[3] = "t3.fk_cliente = t1.id";
		self::$condicionales[4] = "t3.fk_estados = t2.id";
		self::$condicionales[5] = "t3.fk_tipo = t5.id";
		self::$condicionales[6] = "t7.fk_fases = t8.id";
		self::$condicionales[7] = "t7.fk_unidades = t9.id";

		self::$tablas = $this->db_struc->getTablas();
	}

	public function get_table_grafic($condicionales_adicionales=null){
		if ($condicionales_adicionales!=null) {
			$cond_temp = array();
			foreach ($condicionales_adicionales as $value) {
				$cond_temp[] = $value;
			}
			self::$condicionales = array_merge(self::$condicionales, $cond_temp);
			return $this->lib->tabla_generar(self::$tablas[2]." AS t1, ".self::$tablas[20]." AS t2, ".self::$tablas[10]." AS t3, ".self::$tablas[14]." AS t4, ".self::$tablas[19]." AS t5, ".self::$tablas[12]." AS t6, ".self::$tablas[0]." AS t7, ".self::$tablas[4]." AS t8, ".self::$tablas[22]." AS t9",
				self::$encabezados,self::$etiquetas_get,self::$condicionales,"","",self::$etiquetas_set);
		}else{
			return $this->lib->tabla_vacia_generar(self::$encabezados,self::$etiquetas_get);
		}		
	}
	
}