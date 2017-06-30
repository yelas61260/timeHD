<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cotizacion extends CI_Controller {

	public function index(){
		$this->lib->required_session();
		$this->load->model('cotizacion/mcotizacion');
		$data = array(
			'css_js_tables' => $this->lib->css_js_tables_responsive(),
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
			'lista_roles' => $this->renders->get_list_roles(),
			'lista_plantilla' => $this->renders->get_list_plantilla(),
			'update_script' => ''
			);
		$this->load->view('cotizacion/v_cot_form',$data);
	}

	public function jdeleted(){
		$tablas = $this->db_struc->getTablas();

		$this->load->model('cotizacion/mcotizacion');

		$id = $this->input->post("id");

		$this->db_con->update_db_datos($tablas[10], [$this->mcotizacion->get_campos()[14]], ["2"],[$this->mcotizacion->get_id()], [$id]);
	}

	public function jconv_proy(){
		$tablas = $this->db_struc->getTablas();

		$this->load->model('cotizacion/mcotizacion');

		$id = $this->input->post("id");

		$this->db_con->update_db_datos($tablas[10], [$this->mcotizacion->get_campos()[14]], ["1"],[$this->mcotizacion->get_id()], [$id]);
	}

	public function jinsert(){
		$tablas = $this->db_struc->getTablas();

		$this->load->model('cotizacion/mcotizacion');

		$datos_array[0] = $this->input->post("nombre");
		$datos_array[1] = $this->input->post("fecha_ini");
		$datos_array[2] = $this->input->post("fecha_fin_est");
		$datos_array[3] = $this->input->post("duracion_est");
		$datos_array[4] = $this->input->post("comentarios");
		$datos_array[5] = $this->input->post("modulos_est");
		$datos_array[6] = $this->input->post("no_escenas");
		$datos_array[7] = $this->input->post("no_actividades");
		$datos_array[8] = $this->input->post("no_evaluaciones");
		$datos_array[9] = $this->input->post("cliente");
		$datos_array[10] = $this->input->post("tipo");
		$datos_array[11] = $this->input->post("tecnologia");
		$datos_array[12] = $this->input->post("responsable");
		$datos_array[13] = $this->input->post("estado");

		$datos_actividades = json_decode($this->input->post("actividades"));
		$datos_terceros = json_decode($this->input->post("terceros"));

		if($this->db_con->existe_registro($tablas[10], ["nombre","fk_cliente"], [$datos_array[0],$datos_array[9]])){
			echo "El proyecto ya existe.";
		}else{
			$id = $this->db_con->insert_db_datos($tablas[10], $this->mcotizacion->get_campos(), $datos_array);

			if ($datos_actividades != null) {
				foreach ($datos_actividades->act_p as $value) {
					$this->db_con->insert_db_datos($tablas[11], $this->mcotizacion->get_campos_act(), [$id, $value->rolID, $value->actID, $value->horas, $value->costo, 0]);
				}
				foreach ($datos_actividades->act_s as $value) {
					$this->db_con->insert_db_datos($tablas[11], $this->mcotizacion->get_campos_act(), [$id, $value->rolID, $value->actID, $value->horas, $value->costo, 1]);
				}
			}
			if ($datos_terceros != null) {
				foreach ($datos_terceros->ter_p as $value) {
					$this->db_con->insert_db_datos($tablas[24], $this->mcotizacion->get_campos_ter(), [$value->nombre, $id, $value->costo, 0]);
				}
				foreach ($datos_terceros->ter_s as $value) {
					$this->db_con->insert_db_datos($tablas[24], $this->mcotizacion->get_campos_ter(), [$value->nombre, $id, $value->costo, 1]);
				}
			}

			echo "OK";
		}
	}

	public function update($id){
		$this->lib->required_session();
		$this->load->model('cotizacion/mcotizacion');
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
			'lista_roles' => $this->renders->get_list_roles(),
			'lista_plantilla' => $this->renders->get_list_plantilla(),
			'update_script' => 'read_pcp("'.base_url().'cotizacion", '.$id.', "'.base_url().'actividad");'
			);
		$this->load->view('cotizacion/v_cot_form',$data);
	}

	public function jread(){
		$tablas = $this->db_struc->getTablas();

		$this->load->model('cotizacion/mcotizacion');
		$id = $this->input->post("id");

		$objEstandar = $this->mcotizacion->get_datos($id);

		$objEstandar->act_p = $this->mcotizacion->get_actividades_principales($id);
		$objEstandar->act_s = $this->mcotizacion->get_actividades_secundarias($id);
		$objEstandar->ter_p = $this->mcotizacion->get_tercero_principales($id);
		$objEstandar->ter_s = $this->mcotizacion->get_tercero_secundarias($id);

		echo json_encode($objEstandar);
	}

	public function jupdate(){
		$tablas = $this->db_struc->getTablas();

		$this->load->model('cotizacion/mcotizacion');

		$id = $this->input->post("id");

		$datos_array[0] = $this->input->post("nombre");
		$datos_array[1] = $this->input->post("fecha_ini");
		$datos_array[2] = $this->input->post("fecha_fin_est");
		$datos_array[3] = $this->input->post("duracion_est");
		$datos_array[4] = $this->input->post("comentarios");
		$datos_array[5] = $this->input->post("modulos_est");
		$datos_array[6] = $this->input->post("no_escenas");
		$datos_array[7] = $this->input->post("no_actividades");
		$datos_array[8] = $this->input->post("no_evaluaciones");
		$datos_array[9] = $this->input->post("cliente");
		$datos_array[10] = $this->input->post("tipo");
		$datos_array[11] = $this->input->post("tecnologia");
		$datos_array[12] = $this->input->post("responsable");
		$datos_array[13] = $this->input->post("estado");

		$datos_actividades = json_decode($this->input->post("actividades"));
		$datos_terceros = json_decode($this->input->post("terceros"));
		
		$this->db_con->update_db_datos($tablas[10], $this->mcotizacion->get_campos(), $datos_array, [$this->mcotizacion->get_id()], [$id]);

		foreach ($datos_actividades->act_p as $value) {
			if($value->idObj == 0){
				$this->db_con->insert_db_datos($tablas[11], $this->mcotizacion->get_campos_act(), [$id, $value->rolID, $value->actID, $value->horas, $value->costo, 0]);
			}else{
				$this->db_con->update_db_datos($tablas[11], $this->mcotizacion->get_campos_act(), [$id, $value->rolID, $value->actID, $value->horas, $value->costo, 0], ["id"], [$value->idObj]);
			}
		}
		foreach ($datos_actividades->act_s as $value) {
			if($value->idObj == 0){
				$this->db_con->insert_db_datos($tablas[11], $this->mcotizacion->get_campos_act(), [$id, $value->rolID, $value->actID, $value->horas, $value->costo, 1]);
			}else{
				$this->db_con->update_db_datos($tablas[11], $this->mcotizacion->get_campos_act(), [$id, $value->rolID, $value->actID, $value->horas, $value->costo, 1], ["id"], [$value->idObj]);
			}
		}
		foreach ($datos_terceros->ter_p as $value) {
			if ($value->idObj == 0) {
				$this->db_con->insert_db_datos($tablas[24], $this->mcotizacion->get_campos_ter(), [$value->nombre, $id, $value->costo, 0]);
			}else{
				$this->db_con->update_db_datos($tablas[24], $this->mcotizacion->get_campos_ter(), [$value->nombre, $id, $value->costo, 0], ["id"], [$value->idObj]);
			}
		}
		foreach ($datos_terceros->ter_s as $value) {
			if ($value->idObj == 0) {
				$this->db_con->insert_db_datos($tablas[24], $this->mcotizacion->get_campos_ter(), [$value->nombre, $id, $value->costo, 1]);
			}else{
				$this->db_con->update_db_datos($tablas[24], $this->mcotizacion->get_campos_ter(), [$value->nombre, $id, $value->costo, 1], ["id"], [$value->idObj]);
			}
		}
		echo "OK";
	}

	public function jdextra(){
		$tablas = $this->db_struc->getTablas();

		$this->load->model('proyecto/mproyecto');

		$this->db_con->delete_db_datos($tablas[11], [$this->mproyecto->get_campos_actividad()[5], $this->mproyecto->get_campos_actividad()[6]], [$this->input->post("p1_extra"), $this->input->post("p2_extra")]);
	}

}