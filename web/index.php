<?php

use Controller\OrderController;
use Models\Model;
use Dishes\Dish;

require_once("..\src\autoLoader.php");
error_reporting(E_ALL ^ E_NOTICE);

define("ADMIN", "admin");

if ((session_id() == '')) {
    session_start();
}

$control = new OrderController();
		
if (isset($_GET['exit']) && $_GET['exit'] == 1) {
    unset($_SESSION['user_name']);
    session_destroy();
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

if (isset($_SESSION['user_name'])) {
    $control->checkUser();
}

if ($_POST['auto']) {
    $control->postAuto();
}
		
if (empty($_POST) && empty($_SESSION['user_name'])) {
	include "..\src\\views\\view_auto.php";
}
?>


