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
	<?= $css_js_tables ?>
	<script type='text/javascript' charset='UTF-8' src='<?= base_url(); ?>recursos/js/ajax.js'/></script>
	<script type='text/javascript' src='<?= base_url(); ?>recursos/js/tabla.js'/></script>
	<div class="form_general">
		<div id="cont" >
			<div>
				<h1>Filtros</h1>
				<form method="post" id="form_proyecto" name="form_proyecto">
					<input type="hidden" name="actividades" id="arreglo_env" value="" required>
					<table class="form_header">
						<tr>
							<td>
								<div class="form-label"><label for="cliente">Cliente</label></div>
								<div class="form-input"><select name="cliente" id="cliente" class="list_reporte"><?= $lista_cliente ?></select></div>
							</td>
							<td>
								<div class="form-label"><label for="tipo_proyecto">Tipo de proyecto</label></div>
								<div class="form-input"><select name="tipo_proyecto" id="tipo_proyecto" class="list_reporte"><?= $lista_t_proyecto ?></select></div>
							</td>
							<td>
								<div class="form-label"><label for="proyecto">Proyecto</label></div>
								<div class="form-input"><select name="proyecto" id="proyecto" class="list_reporte"><?= $lista_proyecto ?></select></div>
							</td>
							<td>
								<div class="form-label"><label for="estado_proyecto">Estado del proyecto</label></div>
								<div class="form-input"><select name="estado_proyecto" id="estado_proyecto" class="list_reporte"><?= $lista_e_proeycto ?></select></div>
							</td>
						</tr>
						<tr>
							<td>
								<div class="form-label"><label for="fase">Fase</label></div>
								<div class="form-input"><select name="fase" id="fase" class="list_reporte"><?= $lista_fase ?></select></div>
							</td>
							<td>
								<div class="form-label"><label for="actividad">Actividad</label></div>
								<div class="form-input"><select name="actividad" id="actividad" class="list_reporte"><?= $lista_actividad ?></select></div>
							</td>
							<td>
								<div class="form-label"><label for="rol">Rol</label></div>
								<div class="form-input"><select name="rol" id="rol" class="list_reporte"><?= $lista_rol ?></select></div>
							</td>
							<td>
								<div class="form-label"><label for="recurso">Colaborador</label></div>
								<div class="form-input"><select name="recurso" id="recurso" class="list_reporte"><?= $lista_recurso ?></select></div>
							</td>
						</tr>
					</table>
				</form>
			</div>
			<br>
			<hr>
			<div id="principalTabla"><!--DIV PRINCIPAL-->
				<div id="div_tabla">
					<table id="tablaCRUD" class="display responsive nowrap" cellspacing="0" width="100%">
						<?= $table_grafic ?>
					</table>
				</div>
			</div>
		</div>
	</div>
</body>
<script type="text/javascript"><?= $update_script ?></script>
</html>