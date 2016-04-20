<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Actividad extends CI_Controller {

	public function index(){
		$this->lib->required_session();
		$this->load->model('actividad/mactividad');
		$data = array(
			'css_js_tables' => $this->lib->css_js_tables(),
			'header' => $this->lib->print_header(),
			'menu' => $this->lib->print_menu(),
			'table_grafic' => $this->mactividad->get_table_grafic(),
			'mod_view' => 'actividad',
			'titulo' => 'Actividades'
			);
		$this->load->view('v_table',$data);
	}

	public function create(){
		$this->lib->required_session();
		$data = array(
			'titulo' => 'Crear Actividad',
			'header' => $this->lib->print_header(),
			'menu' => $this->lib->print_menu(),
			'lista_fase' => $this->renders->get_list_fase(),
			'lista_estado' => $this->renders->get_list_estado(),
			'lista_roles' => $this->renders->get_list_roles()
			);
		$this->load->view('actividad/v_act_form.php', $data);
	}

	public function jinsert(){}

	public function jread(){}

	public function jdeleted(){}

	public function jupdate(){}

}