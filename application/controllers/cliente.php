<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cliente extends CI_Controller {

	public function index(){
		$this->lib->required_session();
		$this->load->model('cliente/mcliente');
		$data = array(
			'css_js_tables' => $this->lib->css_js_tables(),
			'header' => $this->lib->print_header(),
			'menu' => $this->lib->print_menu(),
			'table_grafic' => $this->mcliente->get_table_grafic(),
			'mod_view' => 'cliente',
			'titulo' => 'Clientes'
			);
		$this->load->view('v_table',$data);
	}

}