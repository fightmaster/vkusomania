<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'> 
<html>
    <head>
        <meta http-equiv="Cache-Control" content="private">
        <meta http-equiv="Cache-Control" content="no-cache">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Заказ еды</title>
        <link rel="stylesheet" type="text/css" href="../template/css/style.css">
        <link rel="stylesheet" type="text/css" href="../template/css/jquery.confirm.css" />
    </head>
    <body>

        <script src="../vendor/js/jquery.min.js"></script>
        <script src="../js/jquery.confirm.js"></script>
        <script src="../js/script.js"></script>
               
         <?php
            
            if ($_SESSION['user_name'] != "") {
                echo "<h1>ФИО пользователя - $_SESSION[user_name]</h1>";
            }
            
            if ( $_SESSION['user_name'] != '' && ( ($Arr['edit_roles'] == 1 && isset($_GET['edit_roles']) && $_GET['edit_roles'] == 1) ) ||
                ( ($Arr['user_roles'] == 1 && isset($_GET['user_roles']) && $_GET['user_roles'] == 1 ) )  || ( ($Arr['reports'] == 1 && isset($_GET['reports']) && $_GET['reports'] == 1) ) ) {
                include_once "..\src\\views\\view_role.php";
            }
            
            if (isset($_POST['login']) && isset($_POST['password']) && isset($_POST['name']) && isset($_POST['email'])) {
                include_once "..\src\\views\\view_err.php";
            }
            
            if ( ($_POST['send'] && $_SESSION['user_name'] != '' && $Arr['admin'] == 1 ) || 
               ( $Arr['admin'] == 1 && empty($arr) && empty($_GET) ) ) {
                include_once "..\src\\views\\view_admin.php";
            }

            if ( ($_POST['order'] && $_SESSION['user_name'] != '' && $Arr['orders'] == 1) || ($Arr['orders'] == 1 && $_POST['order'] ) ) {  
                include_once "..\src\\views\\view.php";
            }

            if ($_POST['confirm'] && $_SESSION['user_name'] != '' && $Arr['orders'] == 1) {
                include_once "..\src\\views\\view.php";
            }
            

            if ($_POST['auto'] && $_SESSION['user_name'] != '' && $Arr['orders'] == 1 || ($Arr['orders'] == 1 && empty($_GET) ) ) {
                include_once "..\src\\views\\view.php";
            }

            if ($_SESSION['user_name'] == '' && !isset($_POST['login']) && !isset($_POST['password']) && !isset($_POST['name']) && !isset($_POST['email'])) {
                include_once "..\src\\views\\view_auto.php";
            }
            
            if ($_SESSION['user_name'] != '' && $Arr['orders'] == 0 && $Arr['admin'] == 0 ) {
                include_once "..\src\\views\\view_menu.php";
            }
            
            
         ?>   

    </body>
</html>