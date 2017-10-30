<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Login</title>
<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>recursos/css/login.css" />
</head>

<body>
  <?= $header ?>
    <form action="<?= base_url(); ?>login/control_login" method="post" id="login">
          <div class="loginform">
          <div class="contenido" align="center">
            <div class="form-input-login">
              <input type="text" name="username" id="username" size="15" value="" placeholder="Ingrese Usuario"/>
            </div>
            <br />
            <div class="clearer"><!-- --></div>
            <div class="form-input-login">
              <input type="password" name="password" id="password" size="15" value="" placeholder="*************"/>
            </div>
            <br />
          <input type="submit" id="loginbtn" value="" />
          <p id="mensaje_err" style="color:red"></p>
          </div>
          </div>
        </form>
</body>
</html>