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
		$this->load->model('cotizacion/mcotizacion');
		$data = array(
			'titulo' => 'Crear Cotizacion',
			'header' => $this->lib->print_header(),
			'menu' => $this->lib->print_menu(),
			'lista_clientes' => $this->renders->get_list_clientes(),
			'lista_t_desarrollo' => $this->renders->get_list_t_desarrollo(),
			'lista_t_tecnologia' => $this->renders->get_list_t_tecnologia(),
			'lista_responsables' => $this->renders->get_list_responsable(),
			'lista_estados_proy' => $this->renders->get_list_estado_proy(),
			'lista_actividades' => $this->renders->get_list_actividades(),
			'update_script' => ''
			);
		$this->load->view('cotizacion/v_cot_form',$data);
	}

	public function deleted($id){
		$this->lib->required_session();
		echo "<script type='text/javascript' src='".base_url()."recursos/js/jquery-1.7.1.min.js'></script>";
		echo '<script src="'.base_url().'recursos/js/ajax.js"/></script>';
		echo '<script>deleted('.$id.', "'.base_url().'cotizacion");</script>';
	}

	public function jdeleted(){
		$tablas = $this->db_struc->getTablas();

		$this->load->model('cotizacion/mcotizacion');

		$id = $this->input->post("id");

		$this->db_con->update_db_datos($tablas[10], [$this->mcotizacion->get_campos()[14]], ["2"],[$this->mcotizacion->get_id()], [$id]);
	}

	public function update($id){
		$this->lib->required_session();
		$this->load->model('cotizacion/mco+');
		$data = array(
			'titulo' => 'Crear Cotizacion',
			'header' => $this->lib->print_header(),
			'menu' => $this->lib->print_menu(),
			'lista_pais' => $this->renders->get_list_pais(),
			'lista_sector' => $this->renders->get_list_sector(),
			'update_script' => 'read('.$id.', "'.base_url().'cotizacion", "form_p")'
			);
		$this->load->view('cotizacion/v_cli_form',$data);
	}

	public function read_data_act(){
		$tablas = $this->db_struc->getTablas();
		$this->lib->required_session();
		$this->load->model('actividad/mactividad');

		$id = $this->input->post("id");

		$datos1 = $this->db_con->get_sql_records("SELECT t1.fk_fases, t2.nombre_fase, t1.id, t1.nombre FROM ".$tablas[0]." AS t1 JOIN ".$tablas[4]." AS t2 ON t1.fk_fases = t2.id WHERE t1.id = ".$id);
		$datos2 = $this->db_con->get_sql_records("SELECT DISTINCT AVG(t4.salario) AS dat1 FROM ".$tablas[18]." AS t1 JOIN ".$tablas[16]." AS t2 ON t2.fk_tarea = t1.id JOIN ".$tablas[13]." AS t3 ON t3.fk_roles = t2.fk_roles JOIN ".$tablas[12]." AS t4 ON t4.cedula = t3.fk_recursos WHERE t1.fk_actividad = ".$id);
		$datos3 = $this->db_con->get_sql_records("SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(".$this->mactividad->get_campos_time()[8].", ".$this->mactividad->get_campos_time()[7].")))/SUM(".$this->mactividad->get_campos_time()[6].")) AS dat1 FROM ".$tablas[14]." WHERE ".$this->mactividad->get_campos_time()[11]."=".$id);

		$valor_actividad_unidad = floor((int)$datos2[0]['dat1']);

		$datosSTR = "";

		$etiquetas = $this->mactividad->get_campos3();
		$tam = count($etiquetas);

		for($i = 0; $i<$tam-1; $i++) {
			$datosSTR .= utf8_encode($datos1[0][$etiquetas[$i]]).",";
		}
		$datosSTR .= $this->mactividad->val_x_act($datos3[0]['dat1'], $valor_actividad_unidad).",".utf8_encode($datos1[0][$etiquetas[$tam-1]]).",".$this->input->post("cant_est");
		if(empty($this->input->post("cant_real")) == false){
			$datosSTR .= ",".$this->input->post("cant_real");
		}
		$tiempo_act;
		if (empty($this->input->post("tiempo_act"))) {
			$tiempo_act = $this->mactividad->mult_fecha($datos3[0]['dat1'], (int)($this->input->post("cant_est").""));
			$datosSTR .=",".$tiempo_act;
		}else{
			$tiempo_act = $this->input->post("tiempo_act");
			$datosSTR .=",".$this->input->post("tiempo_act");
		}
		$val_act;
		if (empty($this->input->post("val_act"))) {
			$val_act = floor(($this->mactividad->val_x_act($datos3[0]['dat1'], $valor_actividad_unidad)*(int)($this->input->post("cant_est"))));
			$datosSTR .=",".$val_act;
		}else{
			$val_act = (int)($this->input->post("val_act"));
			$datosSTR .=",".$this->input->post("val_act");
		}
		$datosSTR .=",".$this->mactividad->suma_fecha($this->input->post("total_tiempo"),$tiempo_act).",".((int)($this->input->post("total_costo"))+$val_act);
		echo $datosSTR;
	}

}