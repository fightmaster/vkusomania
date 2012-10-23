<h2>Удаление пользователя</h2><br>
<form action="index.php?del_user=1&login=<?= $_GET['login'] ?>" method="POST">
    <h3>Имя пользователя:</h3><br>
    <input type="text" name="name" value="<?= $user->getName() ?>"><br><hr>
    <h3>Фамилия пользователя:</h3><br>
    <input type="text" name="surname" value="<?= $user->getSurname() ?>"><br><hr>

    <input type='submit' id="input_role" name='delete_user' value="Уверен">
    <input type='submit' id="input_role" name='cancel' value="Отмена">
</form>
