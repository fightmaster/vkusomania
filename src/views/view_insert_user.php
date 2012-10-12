
<h2>Регистрация нового пользователя</h2><br>
<form action="index.php?edit_roles=1" method="POST">
<h3>Имя пользователя:</h3><br>
<input type="text" name="name" value="<?=$user->getName()?>"><br><hr>
<h3>Фамилия пользователя:</h3><br>
<input type="text" name="surname" value=""><br><hr>
<h3>Логин:</h3><br>
<input type="text" name="login" value=""><br><hr>
<h3>Email:</h3><br>
<input type="text" name="login" value=""><br><hr>
<h3>Пароль:</h3><br>
<input type="text" name="pass" value=""><br>
<h3>Повторите пароль:</h3><br>
<input type="text" name="epass" value=""><br><hr><br>

<h3>Доступ к заказам:</h3><br>
<input type="checkbox" name="orders"     value='1' ><br><hr>
<h3>Доступ к администраторской зоне:</h3><br>
<input type="checkbox" name="admin"      value='1' ><br><hr>
<h3>Доступ к редактированию и добавлению ролей:</h3><br>
<input type="checkbox" name="edit_roles" value='1' ><br><hr>
<h3>Доступ к назначению ролей пользователям:</h3><br>
<input type="checkbox" name="user_roles" value='1' ><br><hr>
<h3>Доступ к просмотру отчета:</h3><br>
<input type="checkbox" name="reports"    value='1' ><br><hr><br>

<input type='submit' id="edit_prof" name='save_role' value="Сохранить">
