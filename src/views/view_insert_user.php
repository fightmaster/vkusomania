<h2>Регистрация нового пользователя</h2>
<?php
if ($str != '') {
    echo "<h3>$str</h3>";
}
foreach ($check as $line) {
    echo $line . "<br>";
}
?>
<form action="index.php?insert_user=1" method="POST">
    <h4>Имя пользователя:</h4>
    <input type="text" name="name" value=""><br><hr>
    <h4>Фамилия пользователя:</h4>
    <input type="text" name="surname" value=""><br><hr>
    <h4>Логин:</h4>
    <input type="text" name="login" value=""><br><hr>
    <h4>Email:</h4>
    <input type="text" name="email" value=""><br><hr>
    <h4>Пароль:</h4>
    <input type="password" name="pass" value=""><br>
    <h4>Повторите пароль:</h4>
    <input type="password" name="r_pass" value=""><br><hr><br>

    <p>Доступ к заказам:<input type="checkbox" checked name="orders" value='1' ></p>
    <p>Доступ к администраторской зоне:</h4><input type="checkbox" name="admin" value='1' ></p>
    <p>Доступ к редактированию и добавлению ролей:</h4><input type="checkbox" name="edit_roles" value='1' ></p>
    <p>Доступ к назначению ролей пользователям:</h4><input type="checkbox" name="user_roles" value='1' ></p>
    <p>Доступ к просмотру отчета:</h4><input type="checkbox" name="reports" value='1' ></p>

    <input type='submit' id="input_role" name='save_user' value="Сохранить">
    <input type='reset'  id="input_role" value="Очистить">
</form>


