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
	<?= $css_js_tables ?>
	<script type='text/javascript' src='<?= base_url(); ?>recursos/js/ajax.js'/></script>
	<script type='text/javascript' src='<?= base_url(); ?>recursos/js/tabla.js'/></script>
	<div class="form_general">
		<div id="cont" >
			<div id="principalTabla"><!--DIV PRINCIPAL-->
				<div id="div_tabla">
					<table id="tablaCRUD" class="display" cellspacing="0" width="100%">
						<?= $table_grafic ?>
					</table>
					<br>
					<button id="boton_agregar" onclick="abrir_ruta('<?= base_url().$mod_view; ?>/create')">Agregar</button>
					<br>
				</div>
			</div>
		</div>
	</div>
</body>
</html>