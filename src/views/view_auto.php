<?php
use Controller\OrderController;
?>

<div class="main">
<?php

$str = OrderController::getError();
if ($str != ''){
	echo '<h2>' . $str . '</h2>';
	$err = '';
	OrderController::setError($err);
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
