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

	public function create(){
		$this->lib->required_session();
		$this->load->model('estandar/mestandar');
		$data = array(
			'titulo' => 'Crear Cotizacion',
			'header' => $this->lib->print_header(),
			'menu' => $this->lib->print_menu(),
			'lista_tipo' => $this->renders->get_list_t_desarrollo(),
			'lista_roles' => $this->renders->get_list_roles(),
			'update_script' => ''
			);
		$this->load->view('plantilla/v_pla_form',$data);
	}

	public function update($id){
		$this->lib->required_session();
		$this->load->model('estandar/mestandar');
		$data = array(
			'titulo' => 'Editar Cotizacion',
			'header' => $this->lib->print_header(),
			'menu' => $this->lib->print_menu(),
			'lista_tipo' => $this->renders->get_list_t_desarrollo(),
			'lista_roles' => $this->renders->get_list_roles(),
			'update_script' => 'read_pcp("'.base_url().'estandar", '.$id.', "'.base_url().'actividad");'
			);
		$this->load->view('plantilla/v_pla_form',$data);
	}

	public function jinsert(){
		$this->lib->required_session();
		$tablas = $this->db_struc->getTablas();

		$this->load->model('estandar/mestandar');

		$datos_array[0] = $this->input->post("codigo");
		$datos_array[1] = $this->input->post("nombre");
		$datos_array[2] = $this->input->post("tipo");
		$datos_array[3] = $this->input->post("descripcion");

		$datos_actividades = json_decode($this->input->post("actividades"));
		$datos_terceros = json_decode($this->input->post("terceros"));

		if($this->db_con->existe_registro($tablas[8], ["codigo"], [$datos_array[0]])){
			echo "El codigo de proyecto ya existe.";
		}else{
			$id = $this->db_con->insert_db_datos($tablas[8], $this->mestandar->get_campos(), $datos_array);

			if ($datos_actividades != null) {
				foreach ($datos_actividades->act_p as $value) {
					$this->db_con->insert_db_datos($tablas[9], $this->mestandar->get_campos_act(), [$id, $value->rolID, $value->actID, $value->horas, 0]);
				}
				foreach ($datos_actividades->act_s as $value) {
					$this->db_con->insert_db_datos($tablas[9], $this->mestandar->get_campos_act(), [$id, $value->rolID, $value->actID, $value->horas, 1]);
				}
			}
			if ($datos_terceros != null) {
				foreach ($datos_terceros->ter_p as $value) {
					$this->db_con->insert_db_datos($tablas[23], $this->mestandar->get_campos_ter(), [$value->nombre, $id, $value->costo, 0]);
				}
				foreach ($datos_terceros->ter_s as $value) {
					$this->db_con->insert_db_datos($tablas[23], $this->mestandar->get_campos_ter(), [$value->nombre, $id, $value->costo, 1]);
				}
			}
			echo "OK";
		}
	}

	public function jread(){
		$this->lib->required_session();
		$tablas = $this->db_struc->getTablas();

		$this->load->model('estandar/mestandar');
		$idEstandar = $this->input->post("id");

		$objEstandar = $this->mestandar->get_datos($idEstandar);

		$objEstandar->act_p = $this->mestandar->get_actividades_principales($idEstandar);
		$objEstandar->act_s = $this->mestandar->get_actividades_secundarias($idEstandar);
		$objEstandar->ter_p = $this->mestandar->get_tercero_principales($idEstandar);
		$objEstandar->ter_s = $this->mestandar->get_tercero_secundarias($idEstandar);

		echo json_encode($objEstandar);
	}

	public function jupdate(){
		$this->lib->required_session();
		$tablas = $this->db_struc->getTablas();

		$this->load->model('estandar/mestandar');


		$id = $this->input->post("id");

		$datos_array[0] = $this->input->post("codigo");
		$datos_array[1] = $this->input->post("nombre");
		$datos_array[2] = $this->input->post("tipo");
		$datos_array[3] = $this->input->post("descripcion");

		$datos_actividades = json_decode($this->input->post("actividades"));
		$datos_terceros = json_decode($this->input->post("terceros"));

		$this->db_con->update_db_datos($tablas[8], $this->mestandar->get_campos(), $datos_array, ["id"], [$id]);

		$this->db_con->delete_db_datos($tablas[9], ["fk_plantillas"], [$id]);
		if ($datos_actividades != null) {
			foreach ($datos_actividades->act_p as $value) {
				$this->db_con->insert_db_datos($tablas[9], $this->mestandar->get_campos_act(), [$id, $value->rolID, $value->actID, $value->horas, 0]);
			}
			foreach ($datos_actividades->act_s as $value) {
				$this->db_con->insert_db_datos($tablas[9], $this->mestandar->get_campos_act(), [$id, $value->rolID, $value->actID, $value->horas, 1]);
			}
		}
		$this->db_con->delete_db_datos($tablas[23], ["fk_plantilla"], [$id]);
		if ($datos_terceros != null) {
			foreach ($datos_terceros->ter_p as $value) {
				$this->db_con->insert_db_datos($tablas[23], $this->mestandar->get_campos_ter(), [$value->nombre, $id, $value->costo, 0]);
			}
			foreach ($datos_terceros->ter_s as $value) {
				$this->db_con->insert_db_datos($tablas[23], $this->mestandar->get_campos_ter(), [$value->nombre, $id, $value->costo, 1]);
			}
		}
		echo "OK";
	}

	public function jdeleted(){
		//$this->lib->required_session();

		$tablas = $this->db_struc->getTablas();

		$this->load->model('estandar/mestandar');
		$idEstandar = $this->input->post("id");

		$this->db_con->delete_db_datos($tablas[8], ["id"], [$idEstandar]);
		//$this->db_con->delete_db_datos($tablas[9], ["fk_plantillas"], [$idEstandar]);
		//$this->db_con->delete_db_datos($tablas[23], ["fk_plantilla"], [$idEstandar]);

		return "OK";
	}

}