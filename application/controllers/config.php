<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Config extends CI_Controller {

	public function index()
	{

		$this->lib->required_session();
		
		$this->load->model('config/mconfig');

		$data = array(
			'titulo' => 'Configuración',
			'header' => $this->lib->print_header(),
			'menu' => $this->lib->print_menu(),
			'update_script' => 'read_conf("'.base_url().'config", "form_conf");'
			);
		$this->load->view('config/v_conf_form', $data);
	}

	public function jread(){
		$tablas = $this->db_struc->getTablas();
		
		$this->load->model('config/mconfig');

		$datos = $this->db_con->get_all_records_tabla($tablas[21], ["*"]);
		$salida = "";
		foreach ($datos as $value) {
			$salida .= ($value[$this->mconfig->get_campos()[1]].",");
		}
		echo $salida;
	}

	public function jupdate(){
		$tablas = $this->db_struc->getTablas();
		
		$this->load->model('config/mconfig');

		$opciones = $this->mconfig->get_opciones();

		$hda = $this->input->post($opciones[0]);
		$hdi = $this->input->post($opciones[1]);
		$hds = $this->input->post($opciones[2]);

		$this->db_con->update_db_datos($tablas[21], [$this->mconfig->get_campos()[1]], [$hda], [$this->mconfig->get_campos()[0]], [$opciones[0]]);
		$this->db_con->update_db_datos($tablas[21], [$this->mconfig->get_campos()[1]], [$hdi], [$this->mconfig->get_campos()[0]], [$opciones[1]]);
		$this->db_con->update_db_datos($tablas[21], [$this->mconfig->get_campos()[1]], [$hds], [$this->mconfig->get_campos()[0]], [$opciones[2]]);

	}

}