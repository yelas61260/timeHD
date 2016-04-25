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
				<form action="" method="post" name="form_usuario" id="form_usuario">
					<input type="hidden" name="roles" id="roles" value="">
					<table class="form_header" id="tab_datos">
						<br>
						<tr>
							<td>
								<div class="form-label"><label for="cedula">Cedula</label></div>
								<div class="form-input"><input type="text" name="cedula" id="cedula" size="25" value="" pattern="[0-9]{5,15}" required/></div>
							</td>
						</tr>
						<tr>
							<td>
								<div class="form-label"><label for="nombre">Nombres</label></div>
								<div class="form-input"><input type="text" name="nombres" id="nombres" size="45" value="" required /></div>
							</td>
						</tr>
						<tr>
							<td>
								<div class="form-label"><label for="apellido">Apellidos</label></div>
								<div class="form-input"><input type="text" name="apellidos" id="apellidos" size="45" value="" required/></div>
							</td>
						</tr>
						<tr>
							<td>
								<div class="form-label"><label for="direccion">Direccion</label></div>
								<div class="form-input"><input type="text" name="direccion" id="direccion" size="45" value="" required/></div>
							</td>
						</tr>
						<tr>
							<td>
								<div class="form-label"><label for="tel1">Telefono 1</label></div>
								<div class="form-input"><input type="text" name="tel1" id="tel1" size="45" value="" pattern="[0-9]{7}|[0-9]{10}" required/></div>
							</td>
						</tr>
						<tr>
							<td>
								<div class="form-label"><label for="tel2">Telefono 2</label></div>
								<div class="form-input"><input type="text" name="tel2" id="tel2" size="45" value="" pattern="[0-9]{7}|[0-9]{10}"/></div>
							</td>
						</tr>
						<tr>
							<td>
								<div class="form-label"><label for="email">Correo</label></div>
								<div class="form-input"><input type="text" name="email" id="email" size="45" value="" pattern="^[_a-z0-9-]+(.[_a-z0-9-]+)*@[a-z0-9-]+(.[a-z0-9-]+)*(.[a-z]{2,4})$" required/></div>
							</td>
						</tr>
						<tr>
							<td>
								<div class="form-label"><label for="ciudad">Ciudad</label></div>
								<div class="form-input"><input type="text" name="ciudad" id="ciudad" size="45" value="" required/></div>
							</td>
						</tr>
						<tr>
							<td>
								<div class="form-label"><label for="pais">País</label></div>
								<div class="form-input"><select name="pais" required>
									<?= $lista_pais ?>
								</select></div>
							</td>
						</tr>
						<tr>
							<td>
								<div class="form-label"><label for="titulo">Titulo</label></div>
								<div class="form-input"><input type="text" name="titulo" id="titulo" size="45" value="" required/></div>
							</td>
						</tr>
						<tr>
							<td>
								<div class="form-label"><label for="Cargo">Cargo</label></div>
								<div class="form-input"><input type="text" name="cargo" id="cargo" size="45" value="" required/></div>
							</td>
						</tr>
						<tr>
							<td>
								<div class="form-label"><label for="salario">Salario</label></div>
								<div class="form-input"><input type="text" name="salario" id="salario" size="45" value="" required/></div>
							</td>
						</tr>
						<tr>
							<td>
								<div class="form-label"><label for="user">Usuario</label></div>
								<div class="form-input"><input type="text" name="user" id="user" size="45" value="" required/></div>
							</td>
						</tr>
						<tr>
							<td>
								<div class="form-label"><label for="pass">Contraseña</label></div>
								<div class="form-input"><input type="text" name="pass" id="pass" size="45" value="" required/></div>
							</td>
						</tr>
						<tr>
							<td>
								<div class="form-label"><label for="estado">Estado</label></div>
								<div class="form-input"><select name="estado" id="estado" required>
									<?= $lista_estado ?>
								</select></div>
							</td>
						</tr>
					</table>
				</form>

				<hr>
				<div class="cont_tbl_roles">
					<table>
						<tr>
							<td><div class="form-label"><label for="rol">Rol</label></td>
							<td><select name="rol" id="rol" required>
								<?= $lista_roles ?>
							</select></td>
						</tr>
						<tr>
							<td>
								<button id="roles_btn" onclick="read_roles_usuario()"/>Agregar Rol</button>
							</td>
						</tr>
					</table>
					<table style="min-width:300px;" class="tabla_general" border="1">
						<thead>
							<th>Roles</th>
						</thead>
						<tbody id="cont_roles"></tbody>
					</table>
				</div>
				<button id="enviar_btn" onclick="create('<?= base_url() ?>usuario','form_usuario')"/>Enviar</button>
			</div>
		</div>
	</div>
</body>
<script type="text/javascript"><?= $update_script ?></script>
</html>