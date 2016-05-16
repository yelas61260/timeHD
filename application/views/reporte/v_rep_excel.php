<?php
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Report_time.xls");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?= $titulo ?></title>
</head>

<body>
	<table width="100%" border="1" cellspacing="0" cellpadding="0">
		<?= $tabla_grafica ?>
	</table>
</body>
</html>