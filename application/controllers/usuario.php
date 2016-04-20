<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usuario extends CI_Controller {

	public function index(){
		$this->lib->required_session();
		$this->load->model('usuario/musuario');
		$data = array(
			'css_js_tables' => $this->lib->css_js_tables(),
			'header' => $this->lib->print_header(),
			'menu' => $this->lib->print_menu(),
			'table_grafic' => $this->musuario->get_table_grafic(),
			'mod_view' => 'usuario',
			'titulo' => 'Usuarios'
			);
		$this->load->view('v_table',$data);
	}

}