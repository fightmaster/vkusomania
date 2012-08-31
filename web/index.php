<?php

use Controller\OrderController;

define("ADMIN", "admin");

require_once("..\src\autoLoader.php");
error_reporting(E_ALL ^ E_NOTICE);

$control = new OrderController();

session_start();

if ($_POST['auto']) {
    $control->postAuto();
}

if (isset($_GET['exit']) && $_GET['exit'] == 1) {
    
    session_unset();
    session_destroy();
    session_regenerate_id(); 
    setcookie(session_name(), session_id());
    
}	

if ($_POST['send']) {
    $control->postSend();
}

if ($_POST['order']) {
    $control->postOrder();
}

if ($_POST['confirm']) {
    $control->postConfirm();
}

if (!empty($_SESSION['user_name'])) {
    $control->checkUser();
}
		
if (empty($_POST)) {
	include_once "..\\src\\layout\\layout.php";
}
?>


