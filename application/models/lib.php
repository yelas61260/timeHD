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
		$content .= "<a href='".base_url()."/mod'>Menú</a>";
		$content .= "<a>Usuario: ".$_SESSION["nombre"]."</a>";
		$content .= "</div>";
		$content .= "<div class='botones_salida'>";
		$content .= "<a href='".base_url()."/login/salida.php'>Salir</a>";
		$content .= "</div>";
		$content .= "</div>";
		return $content;
	}
	
	public function print_home(){
		$content = '';
		$content .= "<div class='form_general'>";
		$content .= "<div>";
		$content .= "<p>Bienvenido ".$_SESSION["nombre"]."</p>";
		$content .= "</div>";
		$content .= "</div>";
		return $content;
	}

	public function print_lista($DB, $tabla, $campo){
		$content = '<option value="">Seleccionar</option>';
		$datos = $DB->get_all_records_tabla($tabla, $campo);
		foreach ($datos as $valor) {
			$content .= '<option value="'.$valor[0].'">'.utf8_encode($valor[1]).'</option>';
		}
		return $content;
	}

	public function tabla_generar($tabla,$campos,$nameCampos,$valoresCondicion,$DB,$URL){
		$tamano = count($campos);
		$tamcampos = count($nameCampos);
		echo '<thead><tr>';
		for($i = 0; $i<$tamano; $i++){
		echo'<th id="titul">'.$campos[$i].'</th>';
		}
		echo '</tr></thead>';

		echo '<tbody>';
		if(empty($valoresCondicion)){
			$datos = $DB->get_all_records_tabla($tabla, ['*']);
		}else{
			$sentenciaSQL = "SELECT * FROM ".$tabla." WHERE ";
			$tamCondicion = count($valoresCondicion);
			for($k = 0; $k<$tamCondicion-1; $k++) {
				$sentenciaSQL .= $valoresCondicion[$k]." AND ";
			}
			$sentenciaSQL .= $valoresCondicion[$tamCondicion-1];
			$datos = $DB->get_sql_records($sentenciaSQL);
		}
		//print_r($datos);
		foreach ($datos as $dato) {
			echo '<tr>';
			for($j = 0; $j<$tamcampos - 2; $j++){
				echo '<td id="campo">'.utf8_encode($dato[$nameCampos[$j]]).'</td>';
			}
			echo '<td>';
			?><img src="<?php echo base_url() ?>/pix/modificar.jpg" width="25" height="25" style="cursor: pointer" onclick="abrir_edit('<?php echo base_url()."/mod/".$URL ?>',<?php echo $dato[0] ?>)">
			<?php
  			echo '</td>';
  			echo '<td>';
			echo '<img src="'.base_url().'/pix/eliminar.jpg" width="25" height="25" style="cursor: pointer" onclick="deleted('.$dato[0].')">';
  			echo '</td>';
  			echo '</tr>';
		}
		echo '</tbody>';

		echo'<tfoot><tr>';
		for($j = 0; $j<$tamcampos; $j++){
			echo '<th id="titul"></th>';
		}
		echo '</tr></tfoot>';

	}

	public function required_session(){
		session_start();
		if(empty($_SESSION["id"])){
			header("Location: ".base_url());
		}
	}

	public function css_js_tables(){
		$content = '';
		$content .="<script type='text/javascript' src='".base_url()."/js/jquery.dataTables.min.js'></script>";
		$content .="<link rel='stylesheet' type='text/css' href='".base_url()."/css/jquery.dataTables.css'>";
		$content .="<link rel='stylesheet' type='text/css' href='".base_url()."/css/jquery.dataTables.min.css'>";
		$content .="<link rel='stylesheet' type='text/css' href='".base_url()."/css/estilotabla.css'>";
		return $content;
	}
}