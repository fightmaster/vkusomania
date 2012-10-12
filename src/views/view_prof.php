
<h2>Редактирование профиля</h2>
<form action="index.php?prof=1" method="POST">
<h3>Имя пользователя:</h3>
<input type="text" name="name"  value="<?=$User->getName()?>"><br><hr>
<h3>Фамилия пользователя:</h3>
<input type="text" name="surname"  value="<?=$User->getSurname()?>"><br><hr>
<h3>Логин:</h3>
<input type="text" name="login" value="<?=$User->getLogin()?>"><br><hr>
<h3>Email:</h3>
<input type="text" name="email" value="<?=$User->getEmail()?>"><br><hr>
<h3>Пароль:</h3>
<input type="password" name="pass" value=""><br>
<h3>Повторите пароль:</h3>
<input type="password" name="r_pass" value=""><br><hr><br>

<input type='submit' id="input_role" name='edit_prof' value="Сохранить"><br><br>

<?php
if ($str != '') {
    echo "<h3>$str</h3>";
}
foreach ($check as $line) {
    echo $line . "<br>";
}
?>
