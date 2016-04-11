<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Actividad extends CI_Controller {

	public function index(){
		$this->lib->required_session();
		$this->load->model('actividad/mactividad');
		$data = array(
			'css_js_tables' => $this->lib->css_js_tables(),
			'header' => $this->lib->print_header(),
			'menu' => $this->lib->print_menu(),
			'table_grafic' => $this->mactividad->get_table_grafic()
			);
		$this->load->view('actividad/v_act_table',$data);
	}

}