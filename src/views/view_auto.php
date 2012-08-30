<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'> 
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Заказ еды</title>
        <link rel="stylesheet" type="text/css" href="../template/css/style.css">
        <link rel="stylesheet" type="text/css" href="../template/css/jquery.confirm.css" />
    </head>
    <body>

        <script src="../vendor/js/jquery.min.js"></script>
        <script src="../js/jquery.confirm.js"></script>
        <script src="../js/script.js"></script>


        <div class="item">
            <div class="exit" id="exit"> </div>
            <div class="exit" id="query"> </div>
        </div>	

        <div class="main">
<?php
if ($control->getError() != ''){
	echo '<h2>' . $control->getError() . '</h2>';
	$err = ' ';
	$control->setError($err);
}
?>
<div class="item">
    <div class="delete"></div>
</div>
<div class="auto">
<form method='POST' action='index.php' >
<h2>Авторизация</h2>
<br>
<p>Чтобы воспользоваться меню, пройдите авторизацию или зарегистрируйтесь!</p>
<br>
Логин:
<br>
<INPUT  name='Login' size="20">
<br>
Пароль:
<br>
<INPUT type='password' name='Pass' size="20"> 
<br>
<br>
<INPUT type='submit' name='auto' size="20"> 

</form>
</div>
   </div>

    </body>
</html>