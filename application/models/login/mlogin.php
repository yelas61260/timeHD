<?php
class mlogin extends CI_Model
{
	private static $tablas;

	public function __construct()
	{
		parent::__construct();
		self::$tablas = $this->db_struc->getTablas();
	}

	public function action_longin($user, $pass){
		$sql1 = $this->db_con->get_all_records(self::$tablas[12], array("usuario","password"), array($user, $pass));

		if(count($sql1)<=0 || count($sql1[0])<=1){
			header("Location: ".base_url()."login");
		}else{
			$datos_user = array('id' => $sql1[0]["cedula"], 'nombre' => $sql1[0]["nombre"]);
			$this->session->set_userdata($datos_user);
			header("Location: ".base_url()."");
		}
	}

	public function action_longout(){
		$this->session->sess_destroy();
		header("Location: ".base_url()."login");
	}
}