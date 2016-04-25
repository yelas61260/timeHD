<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//cambio de actividad jj
class Actividad extends CI_Controller {

	public function index(){
		$this->lib->required_session();
		$this->load->model('actividad/mactividad');
		$data = array(
			'css_js_tables' => $this->lib->css_js_tables(),
			'header' => $this->lib->print_header(),
			'menu' => $this->lib->print_menu(),
			'table_grafic' => $this->mactividad->get_table_grafic(),
			'mod_view' => 'actividad',
			'titulo' => 'Actividades'
			);
		$this->load->view('v_table',$data);
	}

	public function create(){
		$this->lib->required_session();
		$data = array(
			'titulo' => 'Crear Actividad',
			'header' => $this->lib->print_header(),
			'menu' => $this->lib->print_menu(),
			'lista_fase' => $this->renders->get_list_fase(),
			'lista_estado' => $this->renders->get_list_estado(),
			'lista_roles' => $this->renders->get_list_roles(),
			'update_script' => ''
			);
		$this->load->view('actividad/v_act_form.php', $data);
	}

	public function jinsert(){
		$tablas = $this->db_struc->getTablas();

		$this->load->model('actividad/mactividad');

		$datos_array1[0] = $this->input->post("nombre");
		$datos_array1[1] = $this->input->post("fase");
		$datos_array1[2] = $this->input->post("Estado");

		//Se inserta la actividad
		$actividad = $this->db_con->insert_db_datos($tablas[0], $this->mactividad->get_campos1(), $datos_array1);

		$datos_array2 = [];
		$temp_datos_array2 = explode(";", $this->input->post('roles_tarea'));
		$rel_tarea_rol = [];

		foreach ($temp_datos_array2 as $value) {
			$datos_array2[] = explode(",", $value);
		}
		foreach ($datos_array2 as $array_temp) {
			if(!$this->db_con->existe_registro($tablas[18], $this->mactividad->get_campos4(), [$array_temp[1],$actividad])){
				$id_tarea = $this->db_con->insert_db_datos($tablas[18], $this->mactividad->get_campos4(), [$array_temp[1],$actividad]);
			}
			$rel_tarea_rol[] = [$array_temp[0],$id_tarea];
		}

		foreach ($rel_tarea_rol as $datos_relacion) {
			if(!$this->db_con->existe_registro($tablas[16], $this->mactividad->get_campos2(), $datos_relacion)){
				$this->db_con->insert_db_datos($tablas[16], $this->mactividad->get_campos2(), $datos_relacion);
			}
		}
	}

	public function jread(){
		$tablas = $this->db_struc->getTablas();

		$this->load->model('actividad/mactividad');

		$id = $this->input->post("id");

		$datos = $this->db_con->get_all_records($tablas[0], [$this->mactividad->get_id()], [$id]);

		$datosSTR = "";

		$etiquetas = $this->mactividad->get_campos1();
		$tam = count($etiquetas);

		for($i = 0; $i<$tam-1; $i++) {
			$datosSTR .= utf8_encode($datos[0][$i]).",";
		}
		$datosSTR .= utf8_encode($datos[0][$tam-1])."";
		echo $datosSTR;
	}

	public function deleted($id){
		$this->lib->required_session();
		echo "<script type='text/javascript' src='".base_url()."recursos/js/jquery-1.7.1.min.js'></script>";
		echo '<script src="'.base_url().'recursos/js/ajax.js"/></script>';
		echo '<script>deleted('.$id.', "'.base_url().'actividad");</script>';
	}

	public function jdeleted(){
		$tablas = $this->db_struc->getTablas();

		$this->load->model('actividad/mactividad');

		$id = $this->input->post("id");

		$this->db_con->update_db_datos($tablas[0], [$this->mactividad->get_campos1()[2]], ["2"],[$this->mactividad->get_id()], [$id]);
	}

	public function update($id){
		$this->lib->required_session();

		$tablas = $this->db_struc->getTablas();
		$this->load->model('actividad/mactividad');

		$script_roles = '';
		$datos = $this->db_con->get_all_records("tarea AS t1, rol_tarea AS t2", ["t1.id = t2.fk_tarea AND t1.fk_actividad"], [$id]);
		foreach ($datos as $dato) {
			$script_roles .= 'read_tarea_act_edit('.$dato["fk_roles"].',"'.$dato["nombre"].'");';
		}

		$data = array(
			'titulo' => 'Crear Actividad',
			'header' => $this->lib->print_header(),
			'menu' => $this->lib->print_menu(),
			'lista_pais' => $this->renders->get_list_pais(),
			'lista_estado' => $this->renders->get_list_estado(),
			'lista_roles' => $this->renders->get_list_roles(),
			'update_script' => 'read('.$id.', "'.base_url().'actividad", "form_actividad");'.$script_roles
			);
		$this->load->view('actividad/v_act_form',$data);
	}

	public function jupdate(){
		$tablas = $this->db_struc->getTablas();

		$this->load->model('actividad/mactividad');

		$id = $this->input->post("id");
		$datos_array1[0] = $this->input->post("nombre");
		$datos_array1[1] = $this->input->post("fase");
		$datos_array1[2] = 1;

		$this->db_con->update_db_datos($tablas[0], $this->mactividad->get_campos1(), $datos_array1, [$this->mactividad->get_id()], [$id]);
	}

}
