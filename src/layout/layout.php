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


        <div class="item">
            <div class="exit" id="exit"> </div>
            <div class="exit" id="query"> </div>
        </div>	

        <div class="main">
         
         <?php
           if ($_POST['send'] && $_SESSION['user_name'] != '') {
                if ($this->error != "") {
                    include_once "..\src\\views\\view_admin.php";
                } else {
                    if ($rez != true) {
                        include_once "..\src\\views\\view_afterLoad.php";  
                    } else {
                        include_once "..\src\\views\\view_admin.php";
                    } 
                }
           }

           if ($_POST['order'] && $_SESSION['user_name'] != '') {
                if (!empty($dishes) && $this->error == "") {
                    include_once "..\src\\views\\view_order.php";
                } elseif ($control->getError() != "") {
                    include_once "..\src\\views\\view.php";
                }
           }

           if ($_POST['confirm'] && $_SESSION['user_name'] != '') {
               include_once "..\src\\views\\view.php";
           }

           if (isset($_SESSION['user_name']) && $_SESSION['user_name'] != '') {
                if ($_SESSION['user_name'] != ADMIN && empty($_POST)) {
                    include_once "..\src\\views\\view.php";

                } elseif ($_SESSION['user_name'] == ADMIN && empty($_POST)) {
                    include_once "..\src\\views\\view_admin.php";
                }
           }

           if ($_POST['auto'] && $_SESSION['user_name'] != '') {
                if ($_SESSION['user_name'] == ADMIN && !empty($_POST)) {
                    include_once "..\src\\views\\view_admin.php";
                } elseif ($result == true) {
                    if ($dishes != false) {
                        include_once "..\src\\views\\view.php";
                    } else {
                        include_once "..\src\\views\\view_no_menu.php";
                    }
                } elseif ($result) {
                    include_once "..\src\\views\\view_auto.php";
                }
           }

           
           if ($_SESSION['user_name'] == '') {
               include_once "..\src\\views\\view_auto.php";
           }
         
         ?>   
            
        </div>

    </body>
</html>