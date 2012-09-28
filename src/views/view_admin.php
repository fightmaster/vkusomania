<div class="item">
<div class="menu" id="main"> </div>      
<div class="menu" id="user_roles"> </div>
<div class="menu" id="edit_roles"> </div>
<div class="menu" id="reports"> </div>
<div class="menu" id="exit"> </div>
<div class="menu" id="query"> </div>
</div>	

<div class="main">
<?php
if ( ($_POST['send']) && $rez == false && $model->checkPath() ) {
    ?>
    <h2>Меню успешно загружено в базу данных!</h2>
    <?php
} else {
    ?>
    <script>document.getElementById("main").innerHTML ="<a class='exit' href='index.php'>Главная</a>";</script>
    <?php
    if ($Arr['user_roles'] == 1) {
    ?>
        <script>document.getElementById("user_roles").innerHTML ="<a class='exit' href='index.php?user_roles=1'>Редактирование<br>пользователей</a>";</script>
    <?php
    }
    if ($Arr['edit_roles'] == 1) {
    ?>
        <script>document.getElementById("edit_roles").innerHTML ="<a class='exit' href='index.php?edit_roles=1'>Редактирование<br>ролей</a>";</script>
    <?php
    }
    if ($Arr['reports'] == 1) {
    ?>
        <script>document.getElementById("reports").innerHTML ="<a class='exit' href='index.php?reports=1'>Отчетность</a>";</script>
    <?php
    }
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
    if (self::$error!=''){
        echo '<h2>'.self::$error.'</h2>';
        self::$error = '';
    }
    if ($res == true && $_POST['send']) {
        ?>
        <h2>Данный вариант меню уже содержится в базе!</h2>
        <?php
    }
}
?>
</div>