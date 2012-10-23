<?php
if (($_POST['send']) && $rez == false && $model->checkPath()) {
    ?>
    <br>
    <h2>Меню успешно загружено в базу данных!</h2>
    <?php
} else {
    ?>

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
    if ($this->error != '') {
        echo '<h2>' . $this->error . '</h2>';
        $this->error = '';
    }
    if ($res == true && $_POST['send']) {
        ?>
        <h2>Данный вариант меню уже содержится в базе!</h2>
        <?php
    }
}
