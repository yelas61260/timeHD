<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reportes extends CI_Controller {

	public function index(){
		$this->lib->required_session();
		$this->load->model('reporte/mreporte');
		$data = array(
			'titulo' => 'Editar Cotizacion',
			'header' => $this->lib->print_header(),
			'menu' => $this->lib->print_menu(),
			'css_js_tables' => $this->lib->css_js_tables_responsive(),
			'lista_cliente' => $this->renders->get_list_clientes(),
			'lista_t_proyecto' => $this->renders->get_list_t_desarrollo(),
			'lista_proyecto' => $this->renders->get_list_proyecto(),
			'lista_e_proeycto' => $this->renders->get_list_estado_proy(),
			'lista_fase' => $this->renders->get_list_fase(),
			'lista_actividad' => $this->renders->get_list_actividades(),
			'lista_rol' => $this->renders->get_list_roles(),
			'lista_recurso' => $this->renders->get_list_responsable(),
			'table_grafic' => $this->mreporte->get_table_grafic(),
			'update_script' => ''
			);
		$this->load->view('reporte/v_rep_form',$data);
	}

}