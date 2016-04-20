<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cotizacion extends CI_Controller {

	public function index(){
		$this->lib->required_session();
		$this->load->model('cotizacion/mcotizacion');
		$data = array(
			'css_js_tables' => $this->lib->css_js_tables(),
			'header' => $this->lib->print_header(),
			'menu' => $this->lib->print_menu(),
			'table_grafic' => $this->mcotizacion->get_table_grafic(),
			'mod_view' => 'cotizacion',
			'titulo' => 'Cotizaciones'
			);
		$this->load->view('v_table',$data);
	}

	public function create(){
		$this->lib->required_session();
	}

}