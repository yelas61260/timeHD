<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Home</title>
</head>

<body>
	<?= $header ?>
	<?= $menu ?>
	<div class="form_general">
		<div class="menu">
			<?php
				$numBtn = count($LinkMenu);
				for($i = 0; $i<$numBtn; $i++) {
					echo '<div class="menu_item">';
					echo '<a href="'.base_url().''.$LinkMenu[$i].'">';
					echo '<img src="'.base_url().'recursos/pix/menu/'.$ItemsMenu[$i].'.png">';
					echo '</a>';
					echo '</div>';
				}
			?>
		</div>
	</div>
</body>
</html>
