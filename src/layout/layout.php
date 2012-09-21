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
            
            if (isset($_POST['login']) && isset($_POST['password']) && isset($_POST['name']) && isset($_POST['email'])) {
            include_once "..\src\\views\\view_err.php";
            }
            
            if ( ($_POST['send'] && $_SESSION['user_name'] != '' && $_SESSION['user_name'] == ADMIN) || ($_SESSION['user_name'] == ADMIN) ) {
            include_once "..\src\\views\\view_admin.php";
            }

            if ( ($_POST['order'] && $_SESSION['user_name'] != '') || ($_SESSION['user_name'] != ADMIN && empty($_POST)) ) {
            include_once "..\src\\views\\view.php";
            }

            if ($_POST['confirm'] && $_SESSION['user_name'] != '') {
            include_once "..\src\\views\\view.php";
            }

            if ($_POST['auto'] && $_SESSION['user_name'] != '') {
            include_once "..\src\\views\\view.php";
            }

            if ($_SESSION['user_name'] == '' && !isset($_POST['login']) && !isset($_POST['password']) && !isset($_POST['name']) && !isset($_POST['email'])) {
            include_once "..\src\\views\\view_auto.php";
            }
            
         ?>   

    </body>
</html>