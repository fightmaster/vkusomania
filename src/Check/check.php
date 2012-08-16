<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
	function check($value1,$value2) 
	{
		if ( ($value1=='admin') && ($value2=='123456') ){
		return true;
		} else {
		return false;
		}
	}
	
if ( isset($_GET['login']) && isset($_GET['pass']) ){
	if ( check($_GET['login'],$_GET['pass']) == true ){	
		echo "<h2>Добро пожаловать!</h2><br>";
        echo '<form method=POST action=index.php >';
        echo 'Введите адрес ссылки меню DOC-файла с http://www.vkusomania.com/site/menu.html :<br>';
        echo "<input type='text' size='65' name='filepath' value='' > ";
        echo "<input type='submit' name='send' value='Отправить'>";
        echo "</form><br><hr>";
	}else{
		echo "Не правильно введен логин или пароль!<br>";
	}	
} 

	
?>