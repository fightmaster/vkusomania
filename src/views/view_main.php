<?php
if ($_POST['auto']) {
    if ( $Arr['admin'] == 1  && empty($_GET) ) {
        include_once "../src/views/view_admin.php";
    }
    if ( $Arr['orders'] == 1  && empty($_GET) ) {
        include_once "../src/views/view_order.php";
    }
    if ($_SESSION['user_name'] != '' && $Arr['orders'] == 0 && $Arr['admin'] == 0 && empty($_GET) ) {
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
    if ( $Arr['orders'] == 1  && empty($_GET) ) {
        include_once "../src/views/view_order.php";
    }
}

if ($_POST['confirm'] && $_SESSION['user_name'] != '') {
    if ( $Arr['admin'] == 1  && empty($_GET) ) {
        include_once "../src/views/view_admin.php";
    }
    include_once "../src/views/view_order.php";
}

if (!empty($_SESSION['user_name']) && ( empty($_POST) || isset($_POST['save_role']) || isset($_POST['input_role']) || isset($_POST['insert_role']) )  ) {
    if ( $Arr['admin'] == 1  && empty($_GET) ) {
        include_once "../src/views/view_admin.php";
    }
    if ( $Arr['orders'] == 1  && empty($_GET) ) {
        include_once "../src/views/view_order.php";
    }
    if ($_SESSION['user_name'] != '' && $Arr['orders'] == 0 && $Arr['admin'] == 0 && empty($_GET) ) {
        include_once "../src/views/view_menu.php";
    }
    if ( $_SESSION['user_name'] != '' && ( ($Arr['edit_roles'] == 1 && isset($_GET['edit_roles']) && $_GET['edit_roles'] == 1) ) ||
        ( ($Arr['user_roles'] == 1 && isset($_GET['user_roles']) && $_GET['user_roles'] == 1 ) )  || ( ($Arr['reports'] == 1 && isset($_GET['reports']) && $_GET['reports'] == 1) ) ) {
        include_once "../src/views/view_role.php";
    }
}

if (isset($_POST['login']) && isset($_POST['password']) && isset($_POST['name']) && isset($_POST['email'])) {
    if ( empty ($result) ) {
        include_once "../src/views/view_order.php";
    } else {
        include_once "../src/views/view_err.php";
    }
    if ($_SESSION['user_name'] == '' && !isset($_POST['login']) && !isset($_POST['password']) && !isset($_POST['name']) && !isset($_POST['email'])) {
        include_once "../src/views/view_auto.php";
    }
}
?>
