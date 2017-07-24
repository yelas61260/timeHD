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
				<form action="" method="post" id="form_cliente" name="form_cliente">
					<table class="form_header">
						<br>
						<tr>
							<td>
								<div class="form-label"><label for="id">ID<span>*</span></label></div>
								<div class="form-input"><input type="text" name="id" id="id" size="25" value="" required/></div>
							</td>
						</tr>
						<tr>
							<td>
								<div class="form-label"><label for="nombre">Nombre<span>*</span></label></div>
								<div class="form-input"><input type="text" name="nombre" id="nombres" size="45" value="" required/></div>
							</td>
						</tr>
						<tr>
							<td>
								<div class="form-label"><label for="ciudad">Ciudad<span>*</span></label></div>
								<div class="form-input"><input type="text" name="ciudad" id="ciudad" size="45" value="" required/></div>
							</td>
						</tr>
						<tr>
							<td>
								<div class="form-label"><label for="pais">País<span>*</span></label></div>
								<div class="form-input"><select name="pais" id="pais" required><?= $lista_pais ?></select></div>
							</td>
						</tr>
						<tr>
							<td>
								<div class="form-label"><label for="direccion">Direccion</label></div>
								<div class="form-input"><input type="text" name="direccion" id="direccion" size="45" value=""/></div>
							</td>
						</tr>
						<tr>
							<td>
								<div class="form-label"><label for="nomb_contac">Nombres Contacto</label></div>
								<div class="form-input"><input type="text" name="nomb_contac" id="nomb_contac" size="45" value=""/></div>
							</td>
						</tr>
						<tr>
							<td>
								<div class="form-label"><label for="ape_contac">Apellidos Contacto</label></div>
								<div class="form-input"><input type="text" name="ape_contac" id="ape_contac" size="45" value=""/></div>
							</td>
						</tr>
						<tr>
							<td>
								<div class="form-label"><label for="tel1">Telefono 1</label></div>
								<div class="form-input"><input type="text" name="tel1" id="tel1" size="45" value="" pattern="[0-9]{7}|[0-9]{10}"/></div>
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
								<div class="form-input"><input type="text" name="email" id="email" size="45" value="" pattern="^[_a-z0-9-]+(.[_a-z0-9-]+)*@[a-z0-9-]+(.[a-z0-9-]+)*(.[a-z]{2,4})$"/></div>
							</td>
						</tr>
						<tr>
							<td>
								<div class="form-label"><label for="sector">Sector<span>*</span></label></div>
								<div class="form-input"><select name="sector" id="sector" required><?= $lista_sector ?></select></div>
							</td>
						</tr>
					</table>
				</form>
				<button id="enviar_btn" onclick="create('<?= base_url() ?>cliente','form_cliente')"/>Enviar</button>
			<button id="cancelar_btn" onclick="abrir_ruta('<?= base_url() ?>cliente')"/>Cancelar</button>
			</div>
		</div>
	</div>
</body>
<script type="text/javascript"><?= $update_script ?></script>
</html>