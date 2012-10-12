<div class="item">
    
<div class="menu" id="user_roles"> </div>
<div class="menu" id="edit_roles"> </div>
<div class="menu" id="reports"> </div>
<hr id="menu_hr">
<div class="menu" id="main"> </div> 
<div class="menu" id="prof"> </div>  
<div class="menu" id="exit"> </div>
</div>	

<div class="main">

<?php
echo '<h1> Логин пользователя -' . $_SESSION[user_name] . '</h1>'; 

echo "<h2>".self::$error."</h2>";

if ($user_roles['user_roles'] == 1) {
?>
    <script>document.getElementById("user_roles").innerHTML ="<a class='edit_user' href='index.php?user_roles=1'>Редактирование<br>пользователей</a>";</script>
<?php
}
if ($user_roles['edit_roles'] == 1) {
?>
    <script>document.getElementById("edit_roles").innerHTML ="<a class='edit_user' href='index.php?edit_roles=1'>Редактирование<br>ролей</a>";</script>
<?php
}
if ($user_roles['reports'] == 1) {
?>
    <script>document.getElementById("reports").innerHTML ="<a class='edit_user' href='index.php?reports=1'>Отчетность</a>";</script>
<?php
}
if ($user_roles['orders'] == 1 || $user_roles['admin'] == 1) {
?> 
<script>document.getElementById("main").innerHTML ="<a class='exit' href='index.php'>Главная</a>";</script>
<?php 
}
?>
<script>document.getElementById("prof").innerHTML ="<a class='exit' href='index.php?prof=1'>Мой профиль</a>";</script>
<script>document.getElementById("exit").innerHTML ="<a class='edit_user' href='index.php?exit=1'>Выход</a>";</script>



<?php
if ($_POST['auto']) {
    if ( $user_roles['admin'] == 1  && empty($_GET) ) {
        include_once "../src/views/view_admin.php";
    }
    if ( $user_roles['orders'] == 1  && empty($_GET) ) {
        include_once "../src/views/view_order.php";
    }
    if ($_SESSION['user_name'] != '' && $user_roles['orders'] == 0 && $user_roles['admin'] == 0 && empty($_GET) ) {
        include_once "../src/views/view_menu.php";
    } 
    if ($_POST['Login'] == "" || $_POST['Pass'] == "" || $result == false) {
        if ($result == false) {
            echo "<h2>Такой пользователь не зарегестрирован либо вы ввели неверные данные!</h2>";
        }
        include_once "../src/views/view_auto.php";
    }
}

if ($_POST['send']) {    
    include_once "../src/views/view_admin.php";
    if ( $user_roles['orders'] == 1  && empty($_GET) ) {
        include_once "../src/views/view_order.php";
    }
}

if ($_POST['order']) {
    if ( $user_roles['admin'] == 1  && empty($_GET) ) {
        include_once "../src/views/view_admin.php";
    }
    include_once "../src/views/view_order.php";
}

if ($_POST['confirm'] && $_SESSION['user_name'] != '') {
    if ( $user_roles['admin'] == 1  && empty($_GET) ) {
        include_once "../src/views/view_admin.php";
    }
    include_once "../src/views/view_order.php";
}

if ($_POST['new_user'] && $_SESSION['user_name'] != '' && isset($_GET['insert_user']) && $_GET['insert_user'] == 1 ) {
     include_once "../src/views/view_insert_user.php";
}

if ($_POST['save_user'] && $_SESSION['user_name'] != '' && isset($_GET['insert_user']) && $_GET['insert_user'] == 1 ) {
     include_once "../src/views/view_insert_user.php";
}


if (!empty($_SESSION['user_name']) && ( empty($_POST) || isset($_POST['save_role']) || isset($_POST['input_role']) || isset($_POST['insert_role']) )  ) {
    if ( $user_roles['admin'] == 1  && empty($_GET) ) {
        include_once "../src/views/view_admin.php";
    }
    if ( $user_roles['orders'] == 1  && empty($_GET) ) {
        include_once "../src/views/view_order.php";
    }
    if ($_SESSION['user_name'] != '' && $user_roles['orders'] == 0 && $user_roles['admin'] == 0 && empty($_GET) ) {
        include_once "../src/views/view_menu.php";
    }
    if ( $_SESSION['user_name'] != '' && ( ($user_roles['edit_roles'] == 1 && isset($_GET['edit_roles']) && $_GET['edit_roles'] == 1) ) ||
        ( ($user_roles['user_roles'] == 1 && isset($_GET['user_roles']) && $_GET['user_roles'] == 1 ) )  || ( ($user_roles['reports'] == 1 && isset($_GET['reports']) && $_GET['reports'] == 1) ) ) {
        include_once "../src/views/view_role.php";
    }
}

if (isset($_POST['login']) && isset($_POST['password']) && isset($_POST['name']) && isset($_POST['email'])) {
    if (isset($_POST['login']) && isset($_POST['password']) && isset($_POST['name']) && isset($_POST['email']) && !isset($_SESSION['user_name']) ) {
        echo $str;
    } else if ( empty ($result) ) {
        include_once "../src/views/view_order.php";
    } else {
        include_once "../src/views/view_err.php";
    }
    if ($_SESSION['user_name'] == '' && !isset($_POST['login']) && !isset($_POST['password']) && !isset($_POST['name']) && !isset($_POST['email'])) {
        include_once "../src/views/view_auto.php";
    }
}

if (isset($_GET['prof']) && $_GET['prof'] == 1 ) {
    include_once "../src/views/view_prof.php";
}
?>
</div>