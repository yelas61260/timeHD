<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rol extends CI_Controller {

	public function index(){
		$this->lib->required_session();
		$this->load->model('rol/mrol');
		$data = array(
			'css_js_tables' => $this->lib->css_js_tables_responsive(),
			'header' => $this->lib->print_header(),
			'menu' => $this->lib->print_menu(),
			'table_grafic' => $this->mrol->get_table_grafic(),
			'mod_view' => 'rol',
			'titulo' => 'Roles'
			);
		$this->load->view('v_table',$data);
	}

	public function create(){
		$this->lib->required_session();
		$data = array(
			'titulo' => 'Crear Rol',
			'header' => $this->lib->print_header(),
			'menu' => $this->lib->print_menu(),
			'lista_tarea' => $this->renders->get_list_tareas(),
			'update_script' => ''
			);
		$this->load->view('roles/v_rol_form',$data);
	}

	public function jinsert(){
		$tablas = $this->db_struc->getTablas();

		$this->load->model('rol/mrol');

		$datos_array[0] = null;
		$datos_array[1] = $this->input->post("nombre");

		if($this->db_con->existe_registro($tablas[15], ["nombre"], [$datos_array[0]])){
			echo "El rol ya existe.";
		}else{
			$id_new_rol = $this->db_con->insert_db_datos($tablas[15], $this->mrol->get_campos(), $datos_array);

			if(!empty($this->input->post('extra')) && $this->input->post('extra')!=""){
				//roles
				$datos_array = explode(";", $this->input->post('extra'));

				foreach ($datos_array as $dato_tarea) {
					if($dato_tarea != ""){
						$this->db_con->insert_db_datos($tablas[16], $this->mrol->get_campos2(), [$id_new_rol, $dato_tarea]);
					}
				}
			}
			echo "OK";
		}
	}
}