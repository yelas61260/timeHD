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
				<form method="post" id="form_cotizacion" name="form_cotizacion">
					<table class="form_header">
						<tr>
							<td>
								<div class="form-label"><label for="cliente">Cliente:</label></div>
								<div class="form-input"><select name="cliente" id="cliente" required><?= $lista_clientes ?></select></div>
							</td>
							<td>
								<div class="form-label"><label for="fecha_ini">Fecha estimada de inicio:</label></div>
								<div class="form-input"><input type="date" name="fecha_ini" id="fecha_ini" size="45" value="" required/></div>
							</td>
						</tr>
						<tr>
							<td>
								<div class="form-label"><label for="nombre">Nombre del proyecto:</label></div>
								<div class="form-input"><input type="text" name="nombre" id="nombre" size="45" value="" required/></div>
							</td>
							<td>
								<div class="form-label"><label for="fecha_fin_est">Fecha estimada de finalización:</label></div>
								<div class="form-input"><input type="date" name="fecha_fin_est" id="fecha_fin_est" size="45" value="" required/></div>
							</td>
						</tr>
						<tr>
							<td>
								<div class="form-label"><label for="codigo">Código de la cotización:</label></div>
								<div class="form-input"><input type="text" name="codigo" id="codigo" size="45" value="" required/></div>
							</td>
							<td>
								<div class="form-label"><label for="duracion_est">Duración estimada en minutos del curso:</label></div>
								<div class="form-input"><input type="text" name="duracion_est" id="duracion_est" size="15" value="" required/></div>
							</td>
						</tr>
						<tr>
							<td>
								<div class="form-label"><label for="tipo">Tipo de desarrollo:</label></div>
								<div class="form-input"><select name="tipo" id="tipo" required><?= $lista_t_desarrollo ?></select></div>
							</td>
							<td>
								<div class="form-label"><label for="modulos_est">No. de módulos estimados:</label></div>
								<div class="form-input"><input type="text" name="modulos_est" id="modulos_est" size="15" value="" required/></div>
							</td>
						</tr>
						<tr>
							<td>
								<div class="form-label"><label for="tecnologia">Tecnología:</label></div>
								<div class="form-input"><select name="tecnologia" id="tecnologia" required><?= $lista_t_tecnologia ?></select></div>
							</td>
							<td>
								<div class="form-label"><label for="no_escenas">No. de escenas:</label></div>
								<div class="form-input"><input type="text" name="no_escenas" id="no_escenas" size="15" value="" required/></div>
							</td>
						</tr>
						<tr>
							<td>
								<div class="form-label"><label for="responsable">Responsable:</label></div>
								<div class="form-input"><select name="responsable" id="responsable" required><?= $lista_responsables ?></select></div>
							</td>
							<td>
								<div class="form-label"><label for="no_actividades">No. de actividades:</label></div>
								<div class="form-input"><input type="text" name="no_actividades" id="no_actividades" size="15" value="" required/></div>
							</td>
						</tr>
						<tr>
							<td>
								<div class="form-label"><label for="comentarios">Comentarios</label></div>
								<div class="form-input"><textarea name="comentarios" id="comentarios" rows="5" cols="45" pattern="{0,255}" required></textarea></div>
							</td>
							<td>
								<div class="form-label"><label for="no_evaluaciones">No. de evaluaciones:</label></div>
								<div class="form-input"><input type="text" name="no_evaluaciones" id="no_evaluaciones" size="15" value="" required/></div>
							</td>
						</tr>
						<tr>
							<td></td>
							<td>
								<div class"form-label"><label for="estado">Estado</label></div>
								<div class="form-input"><select name="estado" id="estado" required><?= $lista_estados_proy ?></select></div>
							</td>
						</tr>
					</table>
				</form>
			</div>
			<hr>
			<div class="cont_tbl_act">
				<table>
					<tr>
						<td><div class="form-label"><label for="comentarios">Actividad</label></td>
						<td><select name="act" id="act" required><?= $lista_actividades ?></select></td>
					</tr>
					<tr>
						<td><div class="form-label"><label for="comentarios">Cantidad Estimada</label></td>
						<td><div class="form-input"><input type="text" name="cant_est_act" id="cant_est_act" size="15" value="" required/></div></td>
					</tr>
					<tr>
						<td><button onclick="read_actividad_cotizacion('<?= base_url() ?>actividad')">Agregar Actividad</button></td>
					</tr>
				</table>
				<table class="tabla_general" id="extra" border="1">
					<thead>
						<th>Fase No.</th>
						<th>Fase</th>
						<th>Act. No.</th>
						<th>Costo de desarrollo interno</th>
						<th>Actividad</th>
						<th>Cantidad Estimada</th>
						<th>Horas Estimadas</th>
						<th>Costo</th>
					</thead>
					<tbody id="cont_acti">
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
			</div>
			<button id="enviar_btn" onclick="create('<?= base_url() ?>cotizacion','form_cotizacion')"/>Enviar</button>
		</div>
	</div>
</body>
<script type="text/javascript"><?= $update_script ?></script>
</html>