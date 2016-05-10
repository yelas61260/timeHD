<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Estandar extends CI_Controller {

	public function index(){
		$this->lib->required_session();
		$this->load->model('estandar/mestandar');
		$data = array(
			'css_js_tables' => $this->lib->css_js_tables_responsive(),
			'header' => $this->lib->print_header(),
			'menu' => $this->lib->print_menu(),
			'table_grafic' => $this->mestandar->get_table_grafic(),
			'mod_view' => 'estandar',
			'titulo' => 'Estandares'
			);
		$this->load->view('v_table',$data);
	}

}