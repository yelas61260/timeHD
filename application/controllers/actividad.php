<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Actividad extends CI_Controller {

	public function index(){
		$this->lib->required_session();
		$this->load->model('actividad/mactividad');
		$data = array(
			'css_js_tables' => $this->lib->css_js_tables_responsive(),
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
			'lista_unidades' => $this->renders->get_list_unidad(),
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
		if(empty($this->input->post("Cantidad"))){
			$datos_array1[3] = "0";
		}else{
			$datos_array1[3] = $this->input->post("Cantidad");
		}
		if(empty($this->input->post("Unidad")) || $this->input->post("Unidad") == ""){
			$datos_array1[4] = "1";
		}else{
			$datos_array1[4] = $this->input->post("Unidad");
		}

		if($this->db_con->existe_registro($tablas[0], ["nombre"], [$datos_array1[0]])){
			echo "La actividad ya existe.";
		}else{
			//Se inserta la actividad
			$actividad = $this->db_con->insert_db_datos($tablas[0], $this->mactividad->get_campos1(), $datos_array1);

			if(!empty($this->input->post('extra')) && $this->input->post('extra') != ""){
				$datos_array2 = [];
				$temp_datos_array2 = explode(";", $this->input->post('extra'));
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

			echo "OK";
		}
	}

	public function jread(){
		$tablas = $this->db_struc->getTablas();

		$this->load->model('actividad/mactividad');

		$id = $this->input->post("id");

		$datos = $this->db_con->get_all_records($tablas[0], [$this->mactividad->get_id()], [$id]);

		$datosSTR = $id.",";

		$etiquetas = $this->mactividad->get_campos1();
		$tam = count($etiquetas);

		for($i = 0; $i<$tam-1; $i++) {
			$datosSTR .= $datos[0][$etiquetas[$i]].",";
		}
		$datosSTR .= $datos[0][$etiquetas[$tam-1]]."";
		echo $datosSTR;
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
			'titulo' => 'Editar Actividad',
			'header' => $this->lib->print_header(),
			'menu' => $this->lib->print_menu(),
			'lista_fase' => $this->renders->get_list_fase(),
			'lista_estado' => $this->renders->get_list_estado(),
			'lista_roles' => $this->renders->get_list_roles(),
			'lista_unidades' => $this->renders->get_list_unidad(),
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
		$datos_array1[2] = $this->input->post("Estado");
		if(empty($this->input->post("Cantidad"))){
			$datos_array1[3] = "0";
		}else{
			$datos_array1[3] = $this->input->post("Cantidad");
		}
		if(empty($this->input->post("Unidad")) || $this->input->post("Unidad") == ""){
			$datos_array1[4] = "1";
		}else{
			$datos_array1[4] = $this->input->post("Unidad");
		}

		//Se inserta la actividad
		$this->db_con->update_db_datos($tablas[0], $this->mactividad->get_campos1(), $datos_array1, [$this->mactividad->get_id()], [$id]);

		if(!empty($this->input->post('extra'))){
			$datos_array2 = [];
			$temp_datos_array2 = explode(";", $this->input->post('extra'));
			$rel_tarea_rol = [];

			foreach ($temp_datos_array2 as $value) {
				$datos_array2[] = explode(",", $value);
			}
			foreach ($datos_array2 as $array_temp) {
				if(!$this->db_con->existe_registro($tablas[18], $this->mactividad->get_campos4(), [$array_temp[1],$id])){
					$id_tarea = $this->db_con->insert_db_datos($tablas[18], $this->mactividad->get_campos4(), [$array_temp[1],$id]);
				}else{
					$id_tarea = $this->db_con->get_all_records($tablas[18], $this->mactividad->get_campos4(), [$array_temp[1],$id], ["id"])[0]["id"];
				}
				$rel_tarea_rol[] = [$array_temp[0],$id_tarea];
			}

			foreach ($rel_tarea_rol as $datos_relacion) {
				if(!$this->db_con->existe_registro($tablas[16], $this->mactividad->get_campos2(), $datos_relacion)){
					$this->db_con->insert_db_datos($tablas[16], $this->mactividad->get_campos2(), $datos_relacion);
				}
			}
		}
		echo "OK";
		
	}

	public function read_data_act(){
		$tablas = $this->db_struc->getTablas();
		$this->lib->required_session();
		$this->load->model('actividad/mactividad');

		$id = $this->input->post("id");

		$datos1 = $this->db_con->get_sql_records("SELECT DISTINCT t1.fk_fases, t2.nombre_fase, t1.id, t1.nombre FROM actividad AS t1 JOIN fases_proyecto AS t2 ON t1.fk_fases = t2.id JOIN tarea t3 ON t1.id = t3.fk_actividad JOIN rol_tarea t4 ON t4.fk_tarea = t3.id JOIN roles t5 ON t5.id = t4.fk_roles WHERE t1.id =".$id);
		
		$datosSTR = "";

		$etiquetas = $this->mactividad->get_campos3();
		$tam = count($etiquetas);

		for($i = 0; $i<$tam; $i++) {
			if ($i>0) {
				$datosSTR .= "|";
			}
			$datosSTR .= $datos1[0][$etiquetas[$i]]."";
		}
		echo $datosSTR;
	}

	public function read_cost_act(){
		$tablas = $this->db_struc->getTablas();
		$this->lib->required_session();
		$this->load->model('actividad/mactividad');

		$id = $this->input->post("id");

		$datos1 = $this->db_con->get_sql_records("SELECT DISTINCT AVG(t4.salario) AS dat1 FROM tarea AS t1 JOIN rol_tarea AS t2 ON t2.fk_tarea = t1.id JOIN recurso_rol AS t3 ON t3.fk_roles = t2.fk_roles JOIN recursos AS t4 ON t4.cedula = t3.fk_recursos WHERE t1.fk_actividad =".$id);
		echo $datos1[0]["dat1"];
	}

	public function jdextra(){
		$tablas = $this->db_struc->getTablas();

		$this->load->model('actividad/mactividad');

		$datos = $this->db_con->get_all_records($tablas[16]." AS t1, ".$tablas[18]." AS t2", [" t1.fk_tarea=t2.id AND t1.fk_roles", "t2.nombre"], [$this->input->post("p2_extra"), $this->input->post("p1_extra")], ["t1.id"]);		

		//print_r($datos);
		$this->db_con->delete_db_datos($tablas[16], ["id"], [$datos[0]["id"]]);
	}

	public function read_list_act_x_rol($id){
		$tablas = $this->db_struc->getTablas();
		$this->lib->required_session();
		echo $this->renders->get_list_actividad_x_rol($id);
	}

}
