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
        if ($_SESSION['user_name'] == '' && !isset($_POST['login']) && !isset($_POST['auto']) && !isset($_POST['password']) && !isset($_POST['name']) && !isset($_POST['email']) || $_GET['exit'] == 1) {
            include_once "../src/views/view_auto.php";
        }
        ?>   

    </body>
</html>

