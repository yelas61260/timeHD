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
			'mod_view' => 'cotizacion',
			'titulo' => 'Proyectos'
			);
		$this->load->view('v_table',$data);
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

		$report_proyecto_all_roles = $this->mproyecto->getRecordProyectoAllRoles($id);
		$report_proyectoxrol_all_roles = $this->mproyecto->getRecordProyectoXRolAllRoles($id);

		$report_proyecto_fechas = $this->mproyecto->getFechasProyecto($id);
		$report_proyectoxactividad_all_actividades = $this->mproyecto->getRecordProyectoXActividadAllActividades($id);

		$script_graficas = "$(function () {
			graficReportColumnSubrecord('Tiempo dedicado por roles', '', 'tiempo en minutos', ".$report_proyecto_all_roles.", ".$report_proyectoxrol_all_roles.", 'grafica1');
			graficReportLine('Tiempo dedicado por actividad', '', 'tiempo en minutos', ".$report_proyecto_fechas.", ".$report_proyectoxactividad_all_actividades.", 'grafica2');
		});";

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
			'update_script' => 'read_pcp("'.base_url().'proyecto", '.$id.', "'.base_url().'actividad", 2, "form_proyecto_view");'.$script_graficas
			);
		$this->load->view('proyecto/v_pro_form',$data);
	}

	public function jread(){
		
		$tablas = $this->db_struc->getTablas();

		$this->load->model('proyecto/mproyecto');
		$id = $this->input->post("id");

		$objEstandar = $this->mproyecto->get_datos($id);

		$objEstandar->contr = $this->mproyecto->get_contribucion($id);
		$objEstandar->act_p = $this->mproyecto->get_actividades_principales($id);
		$objEstandar->act_s = $this->mproyecto->get_actividades_secundarias($id);
		$objEstandar->ter_p = $this->mproyecto->get_tercero_principales($id);
		$objEstandar->ter_s = $this->mproyecto->get_tercero_secundarias($id);

		echo json_encode($objEstandar);
	}

	public function jupdate(){
		$tablas = $this->db_struc->getTablas();

		$this->load->model('proyecto/mproyecto');

		$id = $this->input->post("id");

		$datos_array[0] = $this->input->post("nombre");
		$datos_array[1] = $this->input->post("fecha_ini");
		$datos_array[2] = $this->input->post("fecha_fin_est");
		$datos_array[3] = $this->input->post("fecha_ini_real");
		$datos_array[4] = $this->input->post("fecha_fin_real");
		$datos_array[5] = $this->input->post("duracion_est");
		$datos_array[6] = $this->input->post("comentarios");
		$datos_array[7] = $this->input->post("modulos_est");
		$datos_array[8] = $this->input->post("no_escenas");
		$datos_array[9] = $this->input->post("no_actividades");
		$datos_array[10] = $this->input->post("no_evaluaciones");
		$datos_array[11] = $this->input->post("cliente");
		$datos_array[12] = $this->input->post("tipo");
		$datos_array[13] = $this->input->post("tecnologia");
		$datos_array[14] = $this->input->post("responsable");
		$datos_array[15] = $this->input->post("estado");

		$datos_actividades = json_decode($this->input->post("actividades"));
		$datos_terceros = json_decode($this->input->post("terceros"));
		
		$this->db_con->update_db_datos($tablas[10], $this->mproyecto->get_campos(), $datos_array, [$this->mproyecto->get_id()], [$id]);
/*
		if ($datos_actividades != null) {
			foreach ($datos_actividades->act_p as $value) {
				if($value->idObj == 0){
					$this->db_con->insert_db_datos($tablas[11], $this->mproyecto->get_campos_act(), [$id, $value->rolID, $value->actID, $value->horas, $value->costo, 0]);
				}else{
					$this->db_con->update_db_datos($tablas[11], $this->mproyecto->get_campos_act(), [$id, $value->rolID, $value->actID, $value->horas, $value->costo, 0], ["id"], [$value->idObj]);
				}
			}
			foreach ($datos_actividades->act_s as $value) {
				if($value->idObj == 0){
					$this->db_con->insert_db_datos($tablas[11], $this->mproyecto->get_campos_act(), [$id, $value->rolID, $value->actID, $value->horas, $value->costo, 1]);
				}else{
					$this->db_con->update_db_datos($tablas[11], $this->mproyecto->get_campos_act(), [$id, $value->rolID, $value->actID, $value->horas, $value->costo, 1], ["id"], [$value->idObj]);
				}
			}
		}
*/
		if ($datos_terceros != null) {
			foreach ($datos_terceros->ter_p as $value) {
				if ($value->idObj == 0) {
					$this->db_con->insert_db_datos($tablas[24], $this->mproyecto->get_campos_ter(), [$value->nombre, $id, $value->costo, $value->costo_real, 0]);
				}else{
					$this->db_con->update_db_datos($tablas[24], $this->mproyecto->get_campos_ter(), [$value->nombre, $id, $value->costo, $value->costo_real, 0], ["id"], [$value->idObj]);
				}
			}
			foreach ($datos_terceros->ter_s as $value) {
				if ($value->idObj == 0) {
					$this->db_con->insert_db_datos($tablas[24], $this->mproyecto->get_campos_ter(), [$value->nombre, $id, $value->costo, $value->costo_real, 1]);
				}else{
					$this->db_con->update_db_datos($tablas[24], $this->mproyecto->get_campos_ter(), [$value->nombre, $id, $value->costo, $value->costo_real, 1], ["id"], [$value->idObj]);
				}
			}
		}		

		echo "OK";
	}

	public function jdextra(){/*
		$tablas = $this->db_struc->getTablas();

		$this->load->model('proyecto/mproyecto');

		$this->db_con->delete_db_datos($tablas[11], [$this->mproyecto->get_campos_actividad()[5], $this->mproyecto->get_campos_actividad()[6]], [$this->input->post("p1_extra"), $this->input->post("p2_extra")]);
	*/}

	public function getRecordProyectoXRol(){
		//$this->lib->required_session();
		$this->load->model('proyecto/mproyecto');

		$id = $this->input->post("id");

		$datos = new stdclass();

		$datos->fechas = $this->mproyecto->getFechasProyecto($id);

		$roles = $this->db_con->get_sql_records("SELECT * FROM roles");
		foreach ($roles as $rol) {
			$datos->$rol["nombre"] = $this->mproyecto->getRecordProyectoXRol($id, $rol["nombre"]);
		}

		echo json_encode($datos, JSON_UNESCAPED_UNICODE);
	}

}