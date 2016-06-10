<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usuario extends CI_Controller {

	public function index(){
		$this->lib->required_session();
		$this->load->model('usuario/musuario');
		$data = array(
			'css_js_tables' => $this->lib->css_js_tables_responsive(),
			'header' => $this->lib->print_header(),
			'menu' => $this->lib->print_menu(),
			'table_grafic' => $this->musuario->get_table_grafic(),
			'mod_view' => 'usuario',
			'titulo' => 'Usuarios'
			);
		$this->load->view('v_table',$data);
	}

	public function create(){
		$this->lib->required_session();
		$data = array(
			'titulo' => 'Crear Usuario',
			'header' => $this->lib->print_header(),
			'menu' => $this->lib->print_menu(),
			'lista_pais' => $this->renders->get_list_pais(),
			'lista_estado' => $this->renders->get_list_estado(),
			'lista_roles' => $this->renders->get_list_roles(),
			'update_script' => ''
			);
		$this->load->view('usuario/v_usu_form',$data);
	}

	public function jinsert(){
		$tablas = $this->db_struc->getTablas();

		$this->load->model('usuario/musuario');

		$datos_array[0] = $this->input->post("cedula");
		$datos_array[1] = $this->input->post("nombres");
		$datos_array[2] = $this->input->post("apellidos");
		$datos_array[3] = $this->input->post("direccion");
		$datos_array[4] = $this->input->post("tel1");
		$datos_array[5] = $this->input->post("tel2");
		$datos_array[6] = $this->input->post("titulo");
		$datos_array[7] = $this->input->post("user");
		$datos_array[8] = $this->input->post("pass");
		$datos_array[9] = $this->input->post("salario");
		$datos_array[10] = $this->input->post("cargo");
		$datos_array[11] = $this->input->post("email");
		$datos_array[12] = $this->input->post("estado");
		$datos_array[13] = "";

		$datos_array2[0] = $this->input->post("ciudad");
		$datos_array2[1] = $this->input->post("pais");

		$ciudades = $this->db_con->get_all_records($tablas[1], $this->musuario->get_campos2(), $datos_array2);

		if(count($ciudades)<=0 || count($ciudades[0])<=1){
			$this->db_con->insert_db_datos($tablas[1], $this->musuario->get_campos2(), $datos_array2);
			$ciudades = $this->db_con->get_all_records($tablas[1], $this->musuario->get_campos2(), $datos_array2);
		}
		$datos_array[13] = $ciudades[0]["id"];
		$this->db_con->insert_db_datos($tablas[12], $this->musuario->get_campos(), $datos_array);

		//roles
		$datos_array = explode(";", $this->input->post('extra'));

		foreach ($datos_array as $dato_rol) {
			if($dato_rol != ""){
				$this->db_con->insert_db_datos($tablas[13], $this->musuario->get_campos3(), [$this->input->post("cedula"), $dato_rol]);
			}
		}
	}

	public function jdeleted(){
		$tablas = $this->db_struc->getTablas();

		$this->load->model('usuario/musuario');

		$id = $this->input->post("id");

		$this->db_con->update_db_datos($tablas[12], [$this->musuario->get_campos()[12]], ["2"],[$this->musuario->get_campos()[0]], [$id]);
	}

	public function jread(){
		$tablas = $this->db_struc->getTablas();

		$this->load->model('usuario/musuario');

		$id = $this->input->post("id");

		$etiquetas = $this->musuario->get_campos_read();

		$datos_get = array("t1.cedula","t1.nombre AS nombre_usu","t1.apellido","t1.direccion","t1.telefono_uno","t1.telefono_dos","t1.correo","t2.nombre AS ciudad_nombre","t2.fk_pais AS id_pais","t1.titulo","t1.cargo","t1.salario","t1.usuario","t1.password","t1.fk_estados");
		$datos = $this->db_con->get_all_records($tablas[12]." AS t1, ".$tablas[1]." AS t2", [" t1.fk_ciudad = t2.id AND t1.cedula"], [$id], $datos_get);
		$datosSTR = "";

		$tam = count($etiquetas);

		for($i = 0; $i<$tam-1; $i++) {
			$datosSTR .= $datos[0][$etiquetas[$i]].",";
		}
		$datosSTR .= $datos[0][$etiquetas[$tam-1]]."";
		echo $datosSTR;
	}

	public function update($id){
		$this->lib->required_session();

		$tablas = $this->db_struc->getTablas();
		$this->load->model('usuario/musuario');

		$script_roles = '';
		$datos = $this->db_con->get_all_records($tablas[13], ["fk_recursos"], [$id]);
		foreach ($datos as $dato) {
			$script_roles .= 'read_roles_usuario_edit('.$dato["fk_roles"].', '.$id.');';
		}

		$data = array(
			'titulo' => 'Crear Usuario',
			'header' => $this->lib->print_header(),
			'menu' => $this->lib->print_menu(),
			'lista_pais' => $this->renders->get_list_pais(),
			'lista_estado' => $this->renders->get_list_estado(),
			'lista_roles' => $this->renders->get_list_roles(),
			'update_script' => 'read('.$id.', "'.base_url().'usuario", "form_usuario");'.$script_roles
			);
		$this->load->view('usuario/v_usu_form',$data);
	}

	public function jupdate(){
		$tablas = $this->db_struc->getTablas();

		$this->load->model('usuario/musuario');

		$datos_array[0] = $this->input->post("cedula");
		$datos_array[1] = $this->input->post("nombres");
		$datos_array[2] = $this->input->post("apellidos");
		$datos_array[3] = $this->input->post("direccion");
		$datos_array[4] = $this->input->post("tel1");
		$datos_array[5] = $this->input->post("tel2");
		$datos_array[6] = $this->input->post("titulo");
		$datos_array[7] = $this->input->post("user");
		$datos_array[8] = $this->input->post("pass");
		$datos_array[9] = $this->input->post("salario");
		$datos_array[10] = $this->input->post("cargo");
		$datos_array[11] = $this->input->post("email");
		$datos_array[12] = $this->input->post("estado");
		$datos_array[13] = "";

		$datos_array2[0] = $this->input->post("ciudad");
		$datos_array2[1] = $this->input->post("pais");

		$ciudades = $this->db_con->get_all_records($tablas[1], $this->musuario->get_campos2(), $datos_array2);

		if(count($ciudades)<=0 || count($ciudades[0])<=1){
			$this->db_con->insert_db_datos($tablas[1], $this->musuario->get_campos2(), $datos_array2);
			$ciudades = $this->db_con->get_all_records($tablas[1], $this->musuario->get_campos2(), $datos_array2);
		}
		$datos_array[13] = $ciudades[0]["id"];
		$this->db_con->update_db_datos($tablas[12], $this->musuario->get_campos(), $datos_array, [$this->musuario->get_campos()[0]], [$this->input->post("cedula")]);

		//roles
		$datos_array = explode(";", $this->input->post('extra'));
		//$this->db_con->delete_db_datos($tablas[13], [$this->musuario->get_campos3()[0]], [$this->input->post("cedula")]);

		foreach ($datos_array as $dato_rol) {
			$rol = $this->db_con->get_all_records($tablas[13], $this->musuario->get_campos3(), [$this->input->post("cedula"), $dato_rol]);
			if(count($rol)<=0 || count($rol[0])<=1){
				$this->db_con->insert_db_datos($tablas[13], $this->musuario->get_campos3(), [$this->input->post("cedula"), $dato_rol]);
			}
		}
	}

	public function jdextra(){
		$tablas = $this->db_struc->getTablas();

		$this->load->model('usuario/musuario');

		$this->db_con->delete_db_datos($tablas[13], $this->musuario->get_campos3(), [$this->input->post("p1_extra"), $this->input->post("p2_extra")]);
	}

}