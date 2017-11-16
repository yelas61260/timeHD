<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?= $titulo ?></title>
	<script type='text/javascript' charset='UTF-8' src='<?= base_url(); ?>recursos/js/highcharts.js'/></script>
	<script type='text/javascript' charset='UTF-8' src='<?= base_url(); ?>recursos/js/data.js'/></script>
	<script type='text/javascript' charset='UTF-8' src='<?= base_url(); ?>recursos/js/drilldown.js'/></script>
</head>

<body>
	<?= $header ?>
	<?= $menu ?>
	<script type='text/javascript' charset='UTF-8' src='<?= base_url(); ?>recursos/js/ajax.js'/></script>
	<div class="form_general">
		<div id="cont" >
			<div id="formulario">
				<form method="post" id="form_proyecto_view" name="form_proyecto_view">
				<input type="hidden" name="id" id="id" value="">
					<table class="form_header">
						<tr>
							<td>
								<div class="form-label"><label for="cliente">Cliente<span>*</span>:</label></div>
								<div class="form-input"><select name="cliente" id="cliente" required><?= $lista_clientes ?></select></div>
							</td>
							<td>
								<div class="form-label"><label for="duracion_est">Duración estimada en minutos del curso:</label></div>
								<div class="form-input"><input type="text" name="duracion_est" id="duracion_est" size="15" value=""/></div>
							</td>
						</tr>
						<tr>
							<td>
								<div class="form-label"><label for="nombre">Nombre del proyecto<span>*</span>:</label></div>
								<div class="form-input"><input type="text" name="nombre" id="nombre" size="45" value="" required/></div>
							</td>
							<td>
								<div class="form-label"><label for="modulos_est">No. de módulos estimados:</label></div>
								<div class="form-input"><input type="text" name="modulos_est" id="modulos_est" size="15" value=""/></div>
							</td>
						</tr>
						<tr>
							<td>
							</td>
							<td>
								<div class="form-label"><label for="no_escenas">No. de escenas:</label></div>
								<div class="form-input"><input type="text" name="no_escenas" id="no_escenas" size="15" value=""/></div>
							</td>
						</tr>
						<tr>
							<td>
								<div class="form-label"><label for="tipo">Tipo de desarrollo<span>*</span>:</label></div>
								<div class="form-input"><select name="tipo" id="tipo" required><?= $lista_t_desarrollo ?></select></div>
							</td>
							<td>
								<div class="form-label"><label for="no_actividades">No. de actividades:</label></div>
								<div class="form-input"><input type="text" name="no_actividades" id="no_actividades" size="15" value=""/></div>
							</td>
						</tr>
						<tr>
							<td>
								<div class="form-label"><label for="tecnologia">Tecnología<span>*</span>:</label></div>
								<div class="form-input"><select name="tecnologia" id="tecnologia" required><?= $lista_t_tecnologia ?></select></div>
							</td>
							<td>
								<div class="form-label"><label for="no_evaluaciones">No. de evaluaciones:</label></div>
								<div class="form-input"><input type="text" name="no_evaluaciones" id="no_evaluaciones" size="15" value="" /></div>
							</td>
						</tr>
						<tr>
							<td>
								<div class="form-label"><label for="responsable">Responsable<span>*</span>:</label></div>
								<div class="form-input"><select name="responsable" id="responsable" required><?= $lista_responsables ?></select></div>
							</td>
							<td>
								<div class"form-label"><label for="estado">Estado<span>*</span></label></div>
								<div class="form-input"><select name="estado" id="estado" required><?= $lista_estados_proy ?></select></div>
							</td>
						</tr>
						<tr>
							<td>
								<div class="form-label"><label for="fecha_ini">Fecha estimada de inicio<span>*</span>:</label></div>
								<div class="form-input"><input type="date" name="fecha_ini" id="fecha_ini" size="45" value="" required/></div>
							</td>
						</tr>
						<tr>
							<td>
								<div class="form-label"><label for="fecha_fin_est">Fecha estimada de finalización<span>*</span>:</label></div>
								<div class="form-input"><input type="date" name="fecha_fin_est" id="fecha_fin_est" size="45" value="" required/></div>
							</td>
						</tr>
						<tr>
							<td>
								<div class="form-label"><label for="fecha_ini_real">Fecha real de inicio:</label></div>
								<div class="form-input"><input type="date" name="fecha_ini_real" id="fecha_ini_real" size="45" value=""/></div>
							</td>
						</tr>
						<tr>
							<td>
								<div class="form-label"><label for="fecha_fin_real">Fecha real de finalización:</label></div>
								<div class="form-input"><input type="date" name="fecha_fin_real" id="fecha_fin_real" size="45" value=""/></div>
							</td>
						</tr>
						<tr>
							<td>
								<div class="form-label"><label for="comentarios">Comentarios</label></div>
								<div class="form-input"><textarea name="comentarios" id="comentarios" rows="5" cols="45" pattern="{0,255}"></textarea></div>
							</td>
						</tr>
					</table>
				</form>
			</div>
			<hr>
			<div class="cont_tbl_act">
				<table class="tabla_general tbl_act" id="act_p" border="1" borrar="">
					<thead><th>Actividades Principales</th></thead>
					<thead>
						<th class="col_id">ID Rol</th>
						<th>Rol</th>
						<th class="col_id">Fase No.</th>
						<th>Fase</th>
						<th class="col_id">Act. No.</th>
						<th>Actividad</th>
						<th>Horas Estimadas</th>
						<th>Horas Reportadas</th>
						<th>Costo Estimado</th>
						<th>Costo Produccion</th>
					</thead>
					<tbody id="cont">
					</tbody>
					<tfoot>
						<tr>
							<th class="col_id"></th>
							<th></th>
							<th class="col_id"></th>
							<th></th>
							<th class="col_id"></th>
							<th>Totales</th>
							<th id="total_tiempo_est">00:00:00</th>
							<th id="total_tiempo">00:00:00</th>
							<th id="total_costo_est">0</th>
							<th id="total_costo">0</th>
						</tr>
						<tr>
							<th class="col_id"></th>
							<th></th>
							<th class="col_id"></th>
							<th></th>
							<th class="col_id"></th>
							<th></th>
							<th></th>
							<th>Contribución</th>
							<th><div id="val_contribucion"></div></th>
							<th></th>
						</tr>
						<tr>
							<th class="col_id"></th>
							<th></th>
							<th class="col_id"></th>
							<th></th>
							<th class="col_id"></th>
							<th></th>
							<th></th>
							<th>Precio</th>
							<th id="val_precio">0</th>
							<th></th>
						</tr>
					</tfoot>
				</table>
				<table class="tabla_general tbl_act" id="act_s" border="1" borrar="">
					<thead><th>Actividades Secundarias</th></thead>
					<thead>
						<th class="col_id">ID Rol</th>
						<th>Rol</th>
						<th class="col_id">Fase No.</th>
						<th>Fase</th>
						<th class="col_id">Act. No.</th>
						<th>Actividad</th>
						<th>Horas Estimadas</th>
						<th>Horas Reportadas</th>
						<th>Costo Estimado</th>
						<th>Costo Produccion</th>
					</thead>
					<tbody id="cont">
					</tbody>
					<tfoot>
						<tr>
							<th class="col_id"></th>
							<th></th>
							<th class="col_id"></th>
							<th></th>
							<th class="col_id"></th>
							<th>Totales</th>
							<th id="total_tiempo_est">00:00:00</th>
							<th id="total_tiempo">00:00:00</th>
							<th id="total_costo_est">0</th>
							<th id="total_costo">0</th>
						</tr>
						<tr>
							<th class="col_id"></th>
							<th></th>
							<th class="col_id"></th>
							<th></th>
							<th class="col_id"></th>
							<th></th>
							<th></th>
							<th>Contribución</th>
							<th><div id="val_contribucion"></div></th>
							<th></th>
						</tr>
						<tr>
							<th class="col_id"></th>
							<th></th>
							<th class="col_id"></th>
							<th></th>
							<th class="col_id"></th>
							<th></th>
							<th></th>
							<th>Precio</th>
							<th id="val_precio">0</th>
							<th></th>
						</tr>
					</tfoot>
				</table>
				<br>
				<table class="tabla_general tbl_ter" id="ter_p" border="1" borrar="">
					<thead><th>Terceros Principales</th></thead>
					<thead>
						<th>Nombre</th>
						<th>Costo</th>
						<th>Costo Real</th>
					</thead>
					<tbody id="cont">
					</tbody>
					<tfoot>
						<tr>
							<th>Total</th>
							<th id="total_costo">0</th>
							<th id="total_costo_real">0</th>
						</tr>
						<tr>
							<th>Contribución</th>
							<th><div id="val_contribucion"></div></th>
							<th></th>
						</tr>
						<tr>
							<th>Precio</th>
							<th id="val_precio">0</th>
							<th></th>
						</tr>
					</tfoot>
				</table>
				<table class="tabla_general tbl_ter" id="ter_s" border="1" borrar="">
					<thead><th>Terceros Secundarios</th></thead>
					<thead>
						<th>Nombre</th>
						<th>Costo</th>
						<th>Costo Real</th>
					</thead>
					<tbody id="cont">
					</tbody>
					<tfoot>
						<tr>
							<th>Total</th>
							<th id="total_costo">0</th>
							<th id="total_costo_real">0</th>
						</tr>
						<tr>
							<th>Contribución</th>
							<th><div id="val_contribucion"></div></th>
							<th></th>
						</tr>
						<tr>
							<th>Precio</th>
							<th id="val_precio">0</th>
							<th></th>
						</tr>
					</tfoot>
				</table>
				<br>
				<br>
				<br>
				<table class="tabla_general" id="totales" border="1">
					<thead><th>Tipo</th><th>Tiempo Estimado</th><th>Tiempo Reportado</th><th>Costo Estimado</th><th>Costo Produccion</th></thead>
					<tbody>
						<tr>
							<td>Costos final sin actividades secundarias</td><td><div id="time1_est">00:00:00</div></td><td><div id="time1">00:00:00</div></td><td><div id="cost1_est">0</div></td><td><div id="cost1">0</div></td>
						</tr>
						<tr>
							<td>Costos final con actividades secundarias</td><td><div id="time2_est">00:00:00</div></td><td><div id="time2">00:00:00</div></td><td><div id="cost2_est">0</div></td><td><div id="cost2">0</div></td>
						</tr>
					</tbody>
				</table>
			</div>
			<button class="button_form" id="enviar_btn" onclick="create('<?= base_url() ?>proyecto','form_proyecto_view')"/>Enviar</button>
			<button class="button_form" id="cancelar_btn" onclick="abrir_ruta('<?= base_url() ?>proyecto')"/>Cancelar</button>
		</div>
	</div>
	<div class="cont_graficos">
		<div id="grafica1"></div>
		<div id="grafica2"></div>
	</div>
</body>
<script type="text/javascript" charset="UTF-8"><?= $update_script ?></script>
</html>