<div class="item">
<div class="exit" id="exit"> </div>
<div class="exit" id="query"> </div>
</div>	

        <div class="main">
<?php
if ( ($_POST['send']) && $rez == false && $model->checkPath() ) {
    ?>
    <h2>Меню успешно загружено в базу данных!</h2>
    <p>Для заказа обеда вам необходимо вернуться на главную страницу, зарегестрироваться или авторизоваться!</p>
    <a href='index.php'>Вернуться...</a>
    <?php
} else {
    ?>
    <script>document.getElementById("exit").innerHTML ="<a class='exit' href='index.php?exit=1'>Выход</a>";</script>
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
    if ($this->error!=''){
        echo '<h2>'.$this->error.'</h2>';
        $this->error = '';
    }
    if ($res == true && $_POST['send']) {
        ?>
        <h2>Данный вариант меню уже содержится в базе!</h2>
        <?php
    }
}
?>
</div>