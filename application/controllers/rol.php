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
			'lista_tarea' => $this->renders->get_list_actividades(),
			'update_script' => ''
			);
		$this->load->view('roles/v_rol_form',$data);
	}

	public function update($id){
		$this->lib->required_session();
		$this->load->model('rol/mrol');

		$script_tareas = '';
		$datos = $this->db_con->get_sql_records("SELECT DISTINCT t3.id, t3.nombre FROM tarea AS t1, rol_tarea AS t2, actividad AS t3 WHERE t1.id = t2.fk_tarea AND t3.id = t1.fk_actividad AND t2.fk_roles=".$id);
		foreach ($datos as $dato) {
			$script_tareas .= 'read_tarea_rol_edit('.$dato["id"].', "'.$dato["nombre"].'", '.$id.');';
		}
		$data = array(
			'titulo' => 'Modificar Rol',
			'header' => $this->lib->print_header(),
			'menu' => $this->lib->print_menu(),
			'lista_tarea' => $this->renders->get_list_actividades(),
			'update_script' => 'read('.$id.', "'.base_url().'rol", "form_rol");'.$script_tareas
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

				foreach ($datos_array as $dato_actividad) {
					$list_tareas = $this->db_con->get_sql_records("SELECT id FROM tarea WHERE fk_actividad = ".$dato_actividad);
					foreach ($list_tareas as $dato_tarea) {
						$this->db_con->insert_db_datos($tablas[16], $this->mrol->get_campos2(), [$id_new_rol, $dato_tarea["id"]]);
					}
				}
			}
			echo "OK";
		}
	}

	public function jupdate(){
		$tablas = $this->db_struc->getTablas();

		$this->load->model('rol/mrol');

		$id = $this->input->post("id");

		$datos_array[0] = $id;
		$datos_array[1] = $this->input->post("nombre");

		$this->db_con->update_db_datos($tablas[15], ["id","nombre"], $datos_array, ['id'], [$id]);

		if(!empty($this->input->post('extra'))){
			$datos_array2 = explode(";", $this->input->post('extra'));

			foreach ($datos_array2 as $id_actividad) {
				$list_tareas = $this->db_con->get_sql_records("SELECT id FROM tarea WHERE fk_actividad = ".$id_actividad);
				foreach ($list_tareas as $id_tarea) {
					if(!$this->db_con->existe_registro($tablas[16], ["fk_roles","fk_tarea"], [$id,$id_tarea["id"]])){
						$this->db_con->insert_db_datos($tablas[16], ["fk_roles","fk_tarea"], [$id,$id_tarea["id"]]);
					}
				}
			}
		}
		echo "OK";
	}

	public function jread(){
		$tablas = $this->db_struc->getTablas();

		$this->load->model('rol/mrol');

		$id = $this->input->post("id");

		$datos = $this->db_con->get_all_records($tablas[15], ["id"], [$id]);

		$datosSTR = $id.",";

		$etiquetas = $this->mrol->get_campos();
		$tam = count($etiquetas);

		for($i = 1; $i<$tam-1; $i++) {
			$datosSTR .= $datos[0][$etiquetas[$i]].",";
		}
		$datosSTR .= $datos[0][$etiquetas[$tam-1]]."";
		echo $datosSTR;
	}

	public function jdextra(){
		$tablas = $this->db_struc->getTablas();
		$this->db_con->delete_db_datos($tablas[16], ["fk_roles"], [$this->input->post("p1_extra")." AND fk_tarea IN (SELECT id FROM tarea WHERE fk_actividad = ".$this->input->post("p2_extra").")"]);
	}
}