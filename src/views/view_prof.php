
<h2>Редактирование профиля</h2><br>
<form action="index.php?edit_roles=1" method="POST">
<h3>Имя пользователя:</h3><br>
<input type="text" name="name" value="<?=$User->getName()?>"><br><hr>
<h3>Фамилия пользователя:</h3><br>
<input type="text" name="surname" value="<?=$User->getSurname()?>"><br><hr>
<h3>Логин:</h3><br>
<input type="text" name="login" value="<?=$User->getLogin()?>"><br><hr>
<h3>Email:</h3><br>
<input type="text" name="Email" value="<?=$User->getEmail()?>"><br><hr>
<h3>Пароль:</h3><br>
<input type="text" name="pass" value=""><br>
<h3>Повторите пароль:</h3><br>
<input type="text" name="epass" value=""><br><hr><br>

<input type='submit' id="edit_prof" name='save_role' value="Сохранить">
