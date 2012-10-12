<form action="index.php?edit=1&login=<?= $user->getLogin() ?>" method="POST">
    <h3>Имя пользователя:</h3><br>
    <input type="text" name="name" value="<?= $user->getName() ?>"><br><hr>
    <h3>Фамилия пользователя:</h3><br>
    <input type="text" name="surname" value="<?= $user->getSurname() ?>"><br><hr>
    <h3>Логин:</h3><br>
    <input type="text" name="login" value="<?= $user->getLogin() ?>"><br><hr>
    <h3>Email:</h3><br>
    <input type="text" name="email" value="<?= $user->getEmail() ?>"><br><hr>
    <h3>Пароль:</h3><br>
    <input type="text" name="pass" value=""><br>
    <h3>Повторите пароль:</h3><br>
    <input type="text" name="r_pass" value=""><br><hr><br>

    <p>Доступ к заказам:<input type="checkbox" name="orders" <?php if ($A['orders'] == 1) echo "checked" ?> value='1' ></p>
    <p>Доступ к администраторской зоне:<input type="checkbox" name="admin"  <?php if ($A['admin'] == 1) echo "checked" ?>  value='1' ></p>
    <p>Доступ к редактированию и добавлению ролей:<input type="checkbox" name="edit_roles" <?php if ($A['edit_roles'] == 1) echo "checked" ?> value='1' ></p><br>
    <p>Доступ к назначению ролей пользователям:<input type="checkbox" name="user_roles" <?php if ($A['user_roles'] == 1) echo "checked" ?> value='1' ></p><br>
    <p>Доступ к просмотру отчета:<input type="checkbox" name="reports"   <?php if ($A['reports'] == 1) echo "checked" ?>  value='1' ><br><hr><br>

    <input type='submit' id="input_role" name='user_edit' value="Сохранить"><br><br>
</form>

<?php
if (is_array($result)) {
    foreach ($result as $line) {
        echo $line . "<br>";
    }
} else {
    echo $result;
}
