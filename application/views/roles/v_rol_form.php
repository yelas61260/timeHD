<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
<title><?= $titulo ?></title>
</head>

<body>
	<?= $header ?>
	<?= $menu ?>
	<script type='text/javascript' src='<?= base_url(); ?>recursos/js/ajax.js'/></script>
	<div class="form_general">
		<div id="cont" >
			<div id="formulario">
				<form action="" method="post" name="form_rol" id="form_rol">
					<table class="form_header" id="tab_datos">
						<br>
						<tr>
							<td>
								<div class="form-label"><label for="nombre">Nombres<span>*</span></label></div>
								<div class="form-input"><input type="text" name="nombre" id="nombre" size="45" value="" required /></div>
							</td>
						</tr>
					</table>
				</form>

				<hr>
				<div class="cont_tbl_roles">
					<table>
						<tr>
							<td><div class="form-label"><label for="tarea">Tarea</label></td>
							<td><select name="tarea" id="tarea" required>
								<?= $lista_tarea ?>
							</select></td>
						</tr>
						<tr>
							<td>
								<button class="button_form" id="roles_btn" onclick="read_tarea_rol()">Agregar Tarea</button>
							</td>
						</tr>
					</table>
					<table id="extra" class="tabla_general" border="1">
						<thead>
							<th>Tarea</th>
						</thead>
						<tbody id="cont_tarea"></tbody>
					</table>
				</div>
				<button class="button_form" id="enviar_btn" onclick="create('<?= base_url() ?>rol','form_rol')"/>Enviar</button>
				<button class="button_form" id="cancelar_btn" onclick="abrir_ruta('<?= base_url() ?>rol')"/>Cancelar</button>
			</div>
		</div>
	</div>
</body>
<script type="text/javascript"><?= $update_script ?></script>
</html>