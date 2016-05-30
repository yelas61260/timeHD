<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reportes extends CI_Controller {

	public function index(){
		$condiciones_adicionales = array();
		if(!empty($this->input->post('cliente')) && $this->input->post('cliente') != ''){
			$condiciones_adicionales[] = 't3.fk_cliente = '.$this->input->post('cliente');
		}
		if(!empty($this->input->post('proyecto')) && $this->input->post('proyecto') != ''){
			$condiciones_adicionales[] = 't4.fk_proyecto = '.$this->input->post('proyecto');
		}
		if(!empty($this->input->post('recurso')) && $this->input->post('recurso') != ''){
			$condiciones_adicionales[] = 't4.fk_recursos = '.$this->input->post('recurso');
		}
		if(!empty($this->input->post('actividad')) && $this->input->post('actividad') != ''){
			$condiciones_adicionales[] = 't4.fk_actividad = '.$this->input->post('actividad');
		}
		if (count($condiciones_adicionales) == 0) {
			$condiciones_adicionales = null;
		}
		$this->lib->required_session();
		$this->load->model('reporte/mreporte');
		$data = array(
			'titulo' => 'Reportes',
			'header' => $this->lib->print_header(),
			'menu' => $this->lib->print_menu(),
			'css_js_tables' => $this->lib->css_js_tables_responsive(),
			'lista_cliente' => $this->renders->get_list_clientes(),
			'lista_recurso' => $this->renders->get_list_responsable(),
			'table_grafic' => $this->mreporte->get_table_grafic($condiciones_adicionales),
			'id_cli' => $this->input->post('cliente'),
			'id_proy' => $this->input->post('proyecto'),
			'id_rec' => $this->input->post('recurso'),
			'id_act' => $this->input->post('actividad'),
			'update_script' => ''
			);
		$this->load->view('reporte/v_rep_form',$data);
	}

	public function report_excel($id_cli, $id_proy, $id_rec, $id_act){
		$condiciones_adicionales = array();
		if(!empty($id_cli) && $id_cli != ''){
			$condiciones_adicionales[] = 't3.fk_cliente = '.$id_cli;
		}
		if(!empty($id_proy) && $id_proy != ''){
			$condiciones_adicionales[] = 't4.fk_proyecto = '.$id_proy;
		}
		if(!empty($id_rec) && $id_rec != ''){
			$condiciones_adicionales[] = 't4.fk_recursos = '.$id_rec;
		}
		if(!empty($id_act) && $id_act != ''){
			$condiciones_adicionales[] = 't4.fk_actividad = '.$id_act;
		}
		if (count($condiciones_adicionales) == 0) {
			$condiciones_adicionales = null;
		}
		$this->lib->required_session();
		$this->load->model('reporte/mreporte');
		$data = array(
			'titulo' => 'Reporte de tiempos',
			'tabla_grafica' => $this->mreporte->get_table_grafic($condiciones_adicionales)
			);
		$this->load->view('reporte/v_rep_excel',$data);
	}

	public function report_excel_proyectos(){
		$this->lib->required_session();
		$this->load->model('reporte/mreporteproyec');
		$data = array(
			'titulo' => 'Reporte de proyectos',
			'tabla_grafica' => $this->mreporteproyec->get_table_grafic_proyectos()
			);
		$this->load->view('reporte/v_rep_excel',$data);
	}

	public function report_excel_actividad(){
		$this->lib->required_session();
		$this->load->model('reporte/mreporteactividad');
		$data = array(
			'titulo' => 'Reporte de actividades',
			'tabla_grafica' => $this->mreporteactividad->get_table_grafic_act()
			);
		$this->load->view('reporte/v_rep_excel',$data);
	}

	public function report_excel_recursos(){
		$this->lib->required_session();
		$this->load->model('reporte/mreporterecursos');
		$data = array(
			'titulo' => 'Reporte de tiempos',
			'tabla_grafica' => $this->mreporterecursos->get_table_grafic_rec()
			);
		$this->load->view('reporte/v_rep_excel',$data);
	}

	public function get_proy_x_cli(){
		$this->lib->required_session();
		echo ''.$this->renders->get_list_proyecto_x_cli($this->input->post('id_cli'));
	}

	public function get_rec_x_proy(){
		$this->lib->required_session();
		echo ''.$this->renders->get_list_recurso_x_proy($this->input->post('id_proy'));
	}

	public function get_act_x_rec(){
		$this->lib->required_session();
		echo ''.$this->renders->get_list_actividad_x_rec($this->input->post('id_rec'));
	}

}