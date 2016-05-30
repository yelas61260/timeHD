<?php
class lib extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
	}

	public function print_header(){
		$content = '';
		$content .= "<script type='text/javascript' src='".base_url()."recursos/js/jquery-1.7.1.min.js'></script>";
		$content .= "<script type='text/javascript' src='".base_url()."recursos/js/jquery.js'></script>";
		$content .= "<link rel='stylesheet' type='text/css' href='".base_url()."recursos/css/header.css'/>";
		$content .= "<link rel='stylesheet' type='text/css' href='".base_url()."recursos/css/base.css'/>";
		$content .= "<div class='header'>";
		$content .= "<div id='logo_img'><img src='".base_url()."recursos/pix/logo.png'/></div>";
		$content .= "<div id='logo_texto'>Plataforma de gestión de costos</div>";
		$content .= "</div>";
		return $content;
	}
		
	public function print_menu(){
		$content = '';
		$content .= "<div class='botones'>";
		$content .= "<div class='botones_nav'>";
		$content .= "<a href='".base_url()."home'>Menú</a>";
		$content .= "<a>Usuario: ".$this->session->userdata("nombre")."</a>";
		$content .= "</div>";
		$content .= "<div class='botones_salida'>";
		$content .= "<a href='".base_url()."login/control_logout'>Salir</a>";
		$content .= "</div>";
		$content .= "</div>";
		return $content;
	}
	
	public function print_home(){
		$content = '';
		$content .= "<div class='form_general'>";
		$content .= "<div>";
		$content .= "<p>Bienvenido ".$this->session->userdata("nombre")."</p>";
		$content .= "</div>";
		$content .= "</div>";
		return $content;
	}

	public function print_lista($tabla, $campo){
		$content = '<option value="">Seleccionar</option>';
		$datos = $this->db_con->get_all_records_tabla($tabla, $campo);
		foreach ($datos as $valor) {
			$content .= '<option value="'.$valor[$campo[0]].'">'.$valor[$campo[1]].'</option>';
		}
		return $content;
	}


	public function print_lista_filtrada($tabla, $campo, $get_campo, $condiciones){
		$content = '<option value="">Seleccionar</option>';
		$datos = $this->db_con->get_all_records_tabla_where($tabla, $get_campo, $condiciones);
		foreach ($datos as $valor) {
			$content .= '<option value="'.$valor[$campo[0]].'">'.$valor[$campo[1]].'</option>';
		}
		return $content;
	}

	public function tabla_generar($tabla,$campos,$nameCampos,$valoresCondicion,$URL,$id,$campos_get=null){
		$content = '';

		$tamano = count($campos);
		$tamcampos = count($nameCampos);
		$content .= '<thead><tr>';
		for($i = 0; $i<$tamano; $i++){
		$content .='<th id="titul">'.$campos[$i].'</th>';
		}
		$content .= '</tr></thead>';

		$content .= '<tbody>';
		if(empty($valoresCondicion)){
			$datos = $this->db_con->get_all_records_tabla($tabla, ['*']);
		}else{
			$sentenciaSQL = "SELECT ";
			if($campos_get == null){
				$sentenciaSQL .= "*";
			}else{
				$tamCondicion = count($campos_get);
				for($k = 0; $k<$tamCondicion-1; $k++) {
					$sentenciaSQL .= $campos_get[$k].", ";
				}
				$sentenciaSQL .= $campos_get[$tamCondicion-1];
			}
			$sentenciaSQL .= " FROM ".$tabla." WHERE ";
			$tamCondicion = count($valoresCondicion);
			for($k = 0; $k<$tamCondicion-1; $k++) {
				$sentenciaSQL .= $valoresCondicion[$k]." AND ";
			}
			$sentenciaSQL .= $valoresCondicion[$tamCondicion-1];
			$datos = $this->db_con->get_sql_records($sentenciaSQL);
		}
		//print_r($sentenciaSQL);
		//print_r($datos);
		foreach ($datos as $dato) {
			$content .= '<tr>';
			for($j = 0; $j<$tamcampos - 3; $j++){
				$content .= '<td id="campo">'.$dato[$nameCampos[$j]].'</td>';
			}
			if($nameCampos[$tamcampos - 1] == "" && $nameCampos[$tamcampos - 2] == ""){
				if($nameCampos[$tamcampos - 3] == ""){	
		  			$content .= '<td>';
		  			$content .= '<form action="'.base_url().$URL.'/conv_proy/'.$dato[$id].'" metod="post">';
					$content .= '<button><img src="'.base_url().'recursos/pix/eliminar.jpg" width="25" height="25"></button>';
		  			$content .= '</form>';
		  			$content .= '</td>';
	  			}else{
	  				$content .= '<td id="campo">'.$dato[$nameCampos[$tamcampos - 3]].'</td>';
	  			}

				$content .= '<td>';
				$content .= '<form action="'.base_url().$URL.'/update/'.$dato[$id].'" metod="post">';
				$content .= '<button><img src="'.base_url().'recursos/pix/modificar.jpg" width="25" height="25"></button>';
	  			$content .= '</form>';
	  			$content .= '</td>';
	  			$content .= '<td>';
	  			$content .= '<form action="'.base_url().$URL.'/deleted/'.$dato[$id].'" metod="post">';
				$content .= '<button><img src="'.base_url().'recursos/pix/eliminar.jpg" width="25" height="25"></button>';
	  			$content .= '</form>';
	  			$content .= '</td>';
	  			$content .= '</tr>';
	  		}else{
	  			$content .= '<td id="campo">'.$dato[$nameCampos[$tamcampos - 3]].'</td>';
	  			$content .= '<td id="campo">'.$dato[$nameCampos[$tamcampos - 2]].'</td>';
	  			$content .= '<td id="campo">'.$dato[$nameCampos[$tamcampos - 1]].'</td>';
	  		}
		}
		$content .= '</tbody>';

		$content .='<tfoot><tr>';
		for($j = 0; $j<$tamcampos; $j++){
			$content .= '<th id="titul"></th>';
		}
		$content .= '</tr></tfoot>';
		return $content;
	}

	public function required_session(){
		if(empty($this->session->userdata("id"))){
			header("Location: ".base_url());
		}
	}

	public function css_js_tables(){
		$content = '';
		$content .="<script type='text/javascript' src='".base_url()."recursos/js/jquery.dataTables.min.js'></script>";
		$content .="<link rel='stylesheet' type='text/css' href='".base_url()."recursos/css/jquery.dataTables.css'>";
		$content .="<link rel='stylesheet' type='text/css' href='".base_url()."recursos/css/jquery.dataTables.min.css'>";
		$content .="<link rel='stylesheet' type='text/css' href='".base_url()."recursos/css/estilotabla.css'>";
		return $content;
	}

	public function css_js_tables_responsive(){
		$content = '';
		$content .="<script type='text/javascript' src='".base_url()."recursos/js/responsive/jquery-1.12.0.min.js'></script>";
		$content .="<script type='text/javascript' src='".base_url()."recursos/js/responsive/jquery.dataTables.min.js'></script>";
		$content .="<script type='text/javascript' src='".base_url()."recursos/js/responsive/dataTables.responsive.min.js'></script>";
		$content .="<link rel='stylesheet' type='text/css' href='".base_url()."recursos/css/responsive/responsive.dataTables.min.css'>";
		$content .="<link rel='stylesheet' type='text/css' href='".base_url()."recursos/css/responsive/jquery.dataTables.min.css'>";
		$content .="<link rel='stylesheet' type='text/css' href='".base_url()."recursos/css/estilotabla.css'>";
		return $content;
	}

}