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
<script>document.getElementById("exit").innerHTML ="<a class='exit' href='index.php?exit=1'>Выход</a>";</script>
<form method='POST' action='index.php' >
<h2>Добро пожаловать в админку!</h2>
<br>
<p>Для обновления меню введите адрес ссылки меню DOC-файла с http://www.vkusomania.com/site/menu.html :</p>
<br>
<br>
<input type='text' size='65' name='filepath' value='' > 
<input type='submit' name='send' value='Загрузить'>
</form>
<?php 
if ($this->error!=''){
	echo '<h2>'.$this->error.'</h2>';
	$this->error = '';
}
if ($res == true) {
?>
	<h2>Данный вариант меню уже содержится в базе!</h2>
<?php
}
?>
        </div>

    </body>
</html>