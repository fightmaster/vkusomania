<?php

use Controller\OrderController;

require_once("..\src\autoLoader.php");
error_reporting(E_ALL ^ E_NOTICE);

$control = new OrderController();

session_start();

if ($_POST['auto']) {
    session_start();
    $control->actionAuto();
}

if (isset($_GET['exit']) && $_GET['exit'] == 1) {
    $_SESSION['user_name'] = '';
    unset($_SESSION['user_name']);
    unset($_SESSION['user']);
    session_regenerate_id(); 
    setcookie(session_name(), session_id());
}

if ($_POST['send'] && $_SESSION['user_name'] != '') {
    $control->actionSend();
}

if ($_POST['order'] && $_SESSION['user_name'] != '') {
    $control->actionOrder();
}

if ($_POST['confirm'] && $_SESSION['user_name'] != '') {
    $control->actionConfirm();
}

if (!empty($_SESSION['user_name']) && ( empty($_POST) || isset($_POST['save_role']) || isset($_POST['input_role']) || isset($_POST['insert_role']) )  ) {
    $control->checkUser();
}

if (isset($_POST['login']) && isset($_POST['password']) && isset($_POST['name']) && isset($_POST['email'])) {
    $control->insertUser();
}

if ($_SESSION['user_name'] == '' && !isset($_POST['login']) && !isset($_POST['password']) && !isset($_POST['name']) && !isset($_POST['email'])) {
	include_once "..\\src\\layout\\layout.php";
        
}

?>
