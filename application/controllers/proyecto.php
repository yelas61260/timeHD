<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Proyecto extends CI_Controller {

	public function index(){
		$this->lib->required_session();
		$this->load->model('proyecto/mproyecto');
		$data = array(
			'css_js_tables' => $this->lib->css_js_tables_responsive(),
			'header' => $this->lib->print_header(),
			'menu' => $this->lib->print_menu(),
			'table_grafic' => $this->mproyecto->get_table_grafic(),
			'mod_view' => 'proyecto',
			'titulo' => 'Proyectos'
			);
		$this->load->view('v_table',$data);
	}

	public function deleted($id){
		$this->lib->required_session();
		echo "<script type='text/javascript' src='".base_url()."recursos/js/jquery-1.7.1.min.js'></script>";
		echo '<script src="'.base_url().'recursos/js/ajax.js"/></script>';
		echo '<script>deleted('.$id.', "'.base_url().'proyecto");</script>';
	}

	public function jdeleted(){
		$tablas = $this->db_struc->getTablas();

		$this->load->model('proyecto/mproyecto');

		$id = $this->input->post("id");

		$this->db_con->update_db_datos($tablas[10], [$this->mproyecto->get_campos()[16]], ["2"],[$this->mproyecto->get_id()], [$id]);
	}

	public function update($id){
		$this->lib->required_session();
		$this->load->model('proyecto/mproyecto');
		$tablas = $this->db_struc->getTablas();

		$campos_act = $this->mproyecto->get_campos_actividad();
		$datos = $this->db_con->get_all_records($tablas[11], ["fk_proyecto"], [$id]);
		$string_actividades_add = "";
		foreach ($datos as $dato) {
			$string_actividades_add .= 'read_actividad_cotizacion_edit("'.$dato[$campos_act[6]].'","'.$dato[$campos_act[2]].'","'.$dato[$campos_act[3]].'","'.$dato[$campos_act[4]].'","'.base_url().'actividad");';
		}

		$data = array(
			'titulo' => 'Editar Cotizacion',
			'header' => $this->lib->print_header(),
			'menu' => $this->lib->print_menu(),
			'lista_clientes' => $this->renders->get_list_clientes(),
			'lista_t_desarrollo' => $this->renders->get_list_t_desarrollo(),
			'lista_t_tecnologia' => $this->renders->get_list_t_tecnologia(),
			'lista_responsables' => $this->renders->get_list_responsable(),
			'lista_estados_proy' => $this->renders->get_list_estado_proy(),
			'lista_actividades' => $this->renders->get_list_actividades(),
			'update_script' => 'read('.$id.', "'.base_url().'proyecto", "form_proyecto");'.$string_actividades_add
			);
		$this->load->view('proyecto/v_pro_form',$data);
	}

	public function jread(){
		$tablas = $this->db_struc->getTablas();

		$this->load->model('proyecto/mproyecto');

		$id = $this->input->post("id");

		$datos = $this->db_con->get_all_records($tablas[10], [$this->mproyecto->get_id()], [$id]);
		$datosSTR = ",";

		$etiquetas = $this->mproyecto->get_campos_read();
		$tam = count($etiquetas);

		for($i = 0; $i<$tam-1; $i++) {
			$datosSTR .= $datos[0][$etiquetas[$i]].",";
		}
		$datosSTR .= $datos[0][$etiquetas[$tam-1]]."";
		echo $datosSTR;
	}

	public function jupdate(){
		$tablas = $this->db_struc->getTablas();

		$this->load->model('proyecto/mproyecto');

		$datos_array[0] = $this->input->post("codigo");
		$datos_array[1] = $this->input->post("nombre");
		$datos_array[2] = $this->input->post("fecha_ini");
		$datos_array[3] = $this->input->post("fecha_fin_est");
		$datos_array[4] = $this->input->post("fecha_ini_real");
		$datos_array[5] = $this->input->post("fecha_fin_real");
		$datos_array[6] = $this->input->post("duracion_est");
		$datos_array[7] = $this->input->post("comentarios");
		$datos_array[8] = $this->input->post("modulos_est");
		$datos_array[9] = $this->input->post("no_escenas");
		$datos_array[10] = $this->input->post("no_actividades");
		$datos_array[11] = $this->input->post("no_evaluaciones");
		$datos_array[12] = $this->input->post("cliente");
		$datos_array[13] = $this->input->post("tipo");
		$datos_array[14] = $this->input->post("tecnologia");
		$datos_array[15] = $this->input->post("responsable");
		$datos_array[16] = $this->input->post("estado");
		
		$this->db_con->update_db_datos($tablas[10], $this->mproyecto->get_campos(), $datos_array, [$this->mproyecto->get_id()], [$datos_array[0]]);

		$datos_array2 = [];
		$temp_datos_array2 = explode(";", $this->input->post('actividades'));
		foreach ($temp_datos_array2 as $value) {
			$datos_array2[] = explode(",", $value);
		}
		foreach ($datos_array2 as $array_temp) {
			$array_temp[5] = $datos_array[0];
			if(!$this->db_con->existe_registro($tablas[11], array_slice($this->mproyecto->get_campos_actividad(),1,7), array_slice($array_temp,1,7))){
				$this->db_con->insert_db_datos($tablas[11], $this->mproyecto->get_campos_actividad(), $array_temp);
			}
		}
	}

}