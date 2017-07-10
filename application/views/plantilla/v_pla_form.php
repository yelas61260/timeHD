<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?= $titulo ?></title>
</head>

<body>
	<?= $header ?>
	<?= $menu ?>
	<script type='text/javascript' charset='UTF-8' src='<?= base_url(); ?>recursos/js/ajax.js'/></script>
	<div class="form_general">
		<div id="cont" >
			<div id="formulario">
				<form method="post" id="form_proyecto" name="form_proyecto">
				<input type="hidden" name="id" id="id" value="">
					<table class="form_header">
						<tr>
							<td>
								<div class="form-label"><label for="codigo">Codigo<span>*</span>:</label></div>
								<div class="form-input"><input type="text" name="codigo" id="codigo" size="45" value="" required/></div>
							</td>
						</tr>
						<tr>
							<td>
								<div class="form-label"><label for="nombre">Nombre<span>*</span>:</label></div>
								<div class="form-input"><input type="text" name="nombre" id="nombre" size="45" value="" required/></div>
							</td>
						</tr>
						<tr>
							<td>
								<div class="form-label"><label for="tipo">Tipo<span>*</span>:</label></div>
								<div class="form-input"><select name="tipo" id="tipo" required><?= $lista_tipo ?></select></div>
							</td>
						</tr>
						<tr>
							<td>
								<div class="form-label"><label for="descripcion">Descripción<span>*</span>:</label></div>
								<div class="form-input"><input type="text" name="descripcion" id="descripcion" size="45" value="" required/></div>
							</td>
						</tr>
					</table>
				</form>
			</div>
			<hr>
			<div class="cont_tbl_act">
				<input type="hidden" name="duracion_est" id="duracion_est" value="1">
				<table>
					<tr>
						<td><div class="form-label"><label>Rol</label></td>
						<td><select name="rol" id="rol" onchange="read_list_act_x_rol('<?= base_url() ?>', this.value)"><?= $lista_roles ?></select></td>
					</tr>
					<tr>
						<td><div class="form-label"><label>Actividad</label></td>
						<td><select name="act" id="act"></select></td>
					</tr>
					<tr>
						<td><button onclick="read_actividad_cotizacion('<?= base_url() ?>actividad', 'act_p')">Agregar Actividad Principal</button></td>
						<td><button onclick="read_actividad_cotizacion('<?= base_url() ?>actividad', 'act_s')">Agregar Actividad Secundaria</button></td>
					</tr>
				</table>
				<br>
				<table class="tabla_general tbl_act" id="act_p" border="1" borrar="">
					<thead><th>Actividades Principales</th></thead>
					<thead>
						<th>ID Rol</th>
						<th>Rol</th>
						<th>Fase No.</th>
						<th>Fase</th>
						<th>Act. No.</th>
						<th>Actividad</th>
						<th>Horas</th>
						<th>Costo</th>
					</thead>
					<tbody id="cont">
					</tbody>
					<tfoot>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th>Totales</th>
						<th id="total_tiempo">00:00:00</th>
						<th id="total_costo">0</th>
					</tfoot>
				</table>
				<table class="tabla_general tbl_act" id="act_s" border="1" borrar="">
					<thead><th>Actividades Secundarias</th></thead>
					<thead>
						<th>ID Rol</th>
						<th>Rol</th>
						<th>Fase No.</th>
						<th>Fase</th>
						<th>Act. No.</th>
						<th>Actividad</th>
						<th>Horas</th>
						<th>Costo</th>
					</thead>
					<tbody id="cont">
					</tbody>
					<tfoot>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th>Totales</th>
						<th id="total_tiempo">00:00:00</th>
						<th id="total_costo">0</th>
					</tfoot>
				</table>
				<br>
				<table>
					<tr>
						<td><div class="form-label"><label for="ter">Actividad</label></td>
						<td><input type="text" name="ter" id="ter" size="15" value=""/></td>
					</tr>
					<tr>
						<td><button onclick="read_tercero_cotizacion('<?= base_url() ?>actividad', 'ter_p')">Agregar Actividad Principal</button></td>
						<td><button onclick="read_tercero_cotizacion('<?= base_url() ?>actividad', 'ter_s')">Agregar Actividad Secundaria</button></td>
					</tr>
				</table>
				<table class="tabla_general tbl_ter" id="ter_p" border="1" borrar="">
					<thead><th>Terceros Principales</th></thead>
					<thead>
						<th>Nombre</th>
						<th>Costo</th>
					</thead>
					<tbody id="cont">
					</tbody>
					<tfoot>
						<th>Total</th>
						<th id="total_costo">0</th>
					</tfoot>
				</table>

				<table class="tabla_general tbl_ter" id="ter_s" border="1" borrar="">
					<thead><th>Terceros Secundarios</th></thead>
					<thead>
						<th>Nombre</th>
						<th>Costo</th>
					</thead>
					<tbody id="cont">
					</tbody>
					<tfoot>
						<th>Total</th>
						<th id="total_costo">0</th>
					</tfoot>
				</table>
			</div>
			<button id="enviar_btn" onclick="create('<?= base_url() ?>estandar','form_proyecto')"/>Enviar</button>
			<button id="cancelar_btn" onclick="abrir_ruta('<?= base_url() ?>estandar')"/>Cancelar</button>
		</div>
	</div>
</body>
<script type="text/javascript"><?= $update_script ?></script>
</html>