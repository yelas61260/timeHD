<?php
class mcotizacion extends CI_Model
{
	private static $tablas;

	public function __construct(){
		parent::__construct();
		
		self::$tablas = $this->db_struc->getTablas();
	}
}