<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cliente extends CI_Controller {

	public function index(){
		$this->lib->required_session();
		$this->load->model('cliente/mcliente');
		$data = array(
			'css_js_tables' => $this->lib->css_js_tables(),
			'header' => $this->lib->print_header(),
			'menu' => $this->lib->print_menu(),
			'table_grafic' => $this->mcliente->get_table_grafic(),
			'mod_view' => 'cliente',
			'titulo' => 'Clientes'
			);
		$this->load->view('v_table',$data);
	}

	public function create(){
		$this->lib->required_session();
		$data = array(
			'titulo' => 'Crear Cliente',
			'header' => $this->lib->print_header(),
			'menu' => $this->lib->print_menu(),
			'lista_pais' => $this->renders->get_list_pais(),
			'lista_sector' => $this->renders->get_list_sector(),
			'update_script' => ''
			);
		$this->load->view('cliente/v_cli_form',$data);
	}

	public function jinsert(){
		$tablas = $this->db_struc->getTablas();

		$this->load->model('cliente/mcliente');

		$datos_array[0] = $this->input->post("id");
		$datos_array[1] = $this->input->post("nombre");
		$datos_array[2] = $this->input->post("direccion");
		$datos_array[3] = $this->input->post("nomb_contac");
		$datos_array[4] = $this->input->post("ape_contac");
		$datos_array[5] = $this->input->post("email");
		$datos_array[6] = $this->input->post("tel1");
		$datos_array[7] = $this->input->post("tel2");
		$datos_array[8] = "";
		$datos_array[9] = $this->input->post("sector");
		$datos_array[10] = 1;

		$datos_array2[0] = $this->input->post("ciudad");
		$datos_array2[1] = $this->input->post("pais");
		
		$ciudades = $this->db_con->get_all_records($tablas[1], $this->mcliente->get_campos2(), $datos_array2);

		if(count($ciudades)<=0 || count($ciudades[0])<=1){
			$this->db_con->insert_db_datos($tablas[1], $this->mcliente->get_campos2(), $datos_array2);
			$ciudades = $this->db_con->get_all_records($tablas[1], $this->mcliente->get_campos2(), $datos_array2);
		}

		$datos_array[8] = $ciudades[0]["id"];
		$this->db_con->insert_db_datos($tablas[2], $this->mcliente->get_campos(), $datos_array);
	}

	public function update($id){
		$this->lib->required_session();
		$this->load->model('cliente/mcliente');
		$data = array(
			'titulo' => 'Crear Cliente',
			'header' => $this->lib->print_header(),
			'menu' => $this->lib->print_menu(),
			'lista_pais' => $this->renders->get_list_pais(),
			'lista_sector' => $this->renders->get_list_sector(),
			'update_script' => 'read('.$id.', "'.base_url().'cliente", "form_cliente")'
			);
		$this->load->view('cliente/v_cli_form',$data);
	}

	public function jupdate(){
		$tablas = $this->db_struc->getTablas();

		$this->load->model('cliente/mcliente');

		$datos_array[0] = $this->input->post("id");
		$datos_array[1] = $this->input->post("nombre");
		$datos_array[2] = $this->input->post("direccion");
		$datos_array[3] = $this->input->post("nomb_contac");
		$datos_array[4] = $this->input->post("ape_contac");
		$datos_array[5] = $this->input->post("email");
		$datos_array[6] = $this->input->post("tel1");
		$datos_array[7] = $this->input->post("tel2");
		$datos_array[8] = "";
		$datos_array[9] = $this->input->post("sector");
		$datos_array[10] = 1;

		$datos_array2[0] = $this->input->post("ciudad");
		$datos_array2[1] = $this->input->post("pais");

		$ciudades = $this->db_con->get_all_records($tablas[1], $this->mcliente->get_campos2(), $datos_array2);

		if(count($ciudades)<=0 || count($ciudades[0])<=1){
			$this->db_con->insert_db_datos($tablas[1], $this->mcliente->get_campos2(), $datos_array2);
			$ciudades = $this->db_con->get_all_records($tablas[1], $this->mcliente->get_campos2(), $datos_array2);
		}

		$datos_array[8] = $ciudades[0]["id"];
		$this->db_con->update_db_datos($tablas[2], $this->mcliente->get_campos(), $datos_array, [$this->mcliente->get_id()], [$datos_array[0]]);
	}

	public function jread(){
		$tablas = $this->db_struc->getTablas();

		$this->load->model('cliente/mcliente');

		$id = $this->input->post("id");

		$etiquetas = $this->mcliente->get_campos_read();

		$datos_get = array("t1.nombre as nomb_cliente","t2.nombre as ciudad","fk_pais","direccion","nombre_contacto","apellido_contacto","telefono_uno","telefono2","correo","fk_sector");
		$datos = $this->db_con->get_all_records($tablas[2]." AS t1, ".$tablas[1]." AS t2", [" t1.fk_ciudad = t2.id AND t1.id"], [$id], $datos_get);
		$datosSTR = $id.",";
		$tam = count($etiquetas);

		for($i = 0; $i<$tam-1; $i++) {
			$datosSTR .= utf8_encode($datos[0][$etiquetas[$i]]).",";
		}
		$datosSTR .= utf8_encode($datos[0][$etiquetas[$tam-1]])."";
		echo $datosSTR;
	}

	public function deleted($id){
		$this->lib->required_session();
		echo "<script type='text/javascript' src='".base_url()."recursos/js/jquery-1.7.1.min.js'></script>";
		echo '<script src="'.base_url().'recursos/js/ajax.js"/></script>';
		echo '<script>deleted('.$id.', "'.base_url().'cliente");</script>';
	}

	public function jdeleted(){
		$tablas = $this->db_struc->getTablas();

		$this->load->model('cliente/mcliente');

		$id = $this->input->post("id");

		$this->db_con->update_db_datos($tablas[2], [$this->mcliente->get_campos()[10]], ["2"],[$this->mcliente->get_id()], [$id]);
	}

}