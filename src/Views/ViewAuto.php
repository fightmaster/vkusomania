<?php
if ($this->error!=''){
	echo '<h2>'.$this->error.'</h2>';
	$this->error = '';
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