<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
<title>Actividad</title>
</head>

<body>
	<?= $header ?>
	<?= $menu ?>
	<script type='text/javascript' src='<?= base_url(); ?>recursos/js/ajax.js'/></script>
	<script type='text/javascript' src='<?= base_url(); ?>recursos/js/tabla.js'/></script>
	<div class="form_general">
		<div id="cont" >
			<div id="formulario">
				<form action="" metod="post" name="form_actividad" id="form_actividad">

				<input type="hidden" name="roles_tarea" id="roles_tarea" value="">
				<table class="form_header" id="tab_datos">
				<br>
				<tr>
					<td>
						<div class="form-label"><label for="nombre">Nombre</label></div>
						<div class="form-input"><input type="text" name="nombre" id="nombre" size="25" value="" required/></div>
					</td>
				</tr>

				<tr>
					<td>
						<div class="form-label"><label for="fase">Fase</label></div>
						<div class="form-input"><select name="fase" id="fase" required><?= $lista_fase ?></select></div>
					</td>
				</tr>

				<tr>
					<td>
						<div class="form-label"><label for="Estado">Estado</label></div>
						<div class="form-input"><select name="Estado" id="Estado" required><?= $lista_estado ?></select></div>
					</td>
				</tr>
				</table>
				</form>
				</div>
				<hr>
				<div class="cont_tbl_act">
					<table>
						<tr>
							<td><div class="form-label"><label for="roles">Roles</label></td>
							<td><select name="roles" id="roles" required>
								<?= $lista_roles ?>
							</select></td>
						</tr>
						<tr>
							<td><div class="form-label"><label for="tarea">Tarea</label></div></td>
							<td><div class="form-input"><input type="text" name="tarea" id="tarea" size="25" value="" required/></div></td>
						</tr>
						<tr>
							<td>
							<button onclick="read_tarea_act()">Agregar Tarea</button>
							</td>
						</tr>
					</table>
					<table class="tabla_general" border="1">
						<thead>
						<th>Rol</th>
						<th>Tarea</th>
						</thead>
						<tbody id="cont_roles_tareas">
						</tbody>
					</table>
				</div>
				<button id="enviar_btn" onclick="create('../')"/>Enviar</button>
		</div>
	</div>
</body>
</html>