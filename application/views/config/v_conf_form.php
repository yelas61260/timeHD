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
				<form action="" method="post" id="form_conf" name="form_conf">
					<table class="form_header">
						<br>
						<tr>
							<td>
								<div class="form-label"><label for="hda">Hora de almuerzo</label></div>
								<div class="form-input"><input type="text" name="hda" id="hda" size="25" value="" required/></div>
							</td>
						</tr>
						<tr>
							<td>
								<div class="form-label"><label for="hdi">Hora de ingreso</label></div>
								<div class="form-input"><input type="text" name="hdi" id="hdi" size="25" value="" required/></div>
							</td>
						</tr>
						<tr>
							<td>
								<div class="form-label"><label for="hds">Hora de salida</label></div>
								<div class="form-input"><input type="text" name="hds" id="hds" size="25" value="" required/></div>
							</td>
						</tr>
					</table>
				</form>
				<button id="enviar_btn" onclick="update_conf('<?= base_url() ?>config','form_conf')"/>Enviar</button>
			</div>
		</div>
	</div>
</body>
<script type="text/javascript"><?= $update_script ?></script>
</html>