<?php

use Controllers\Controller;
use Models\Model;
use Views\View;
use Dishes\Dish;

require_once("..\src\AutoLoader\AutoLoader.php");
error_reporting(E_ALL ^ E_NOTICE);

define("ADMIN", "admin");
define("FILEPATH1", "http://vkusomania.com/storage/menu_new.doc");
define("FILEPATH2", "http://vkusomania.com/storage/menu.doc");
define("FILEPATH3", "http://www.vkusomania.com/storage/menu_new.doc");
define("FILEPATH4", "http://www.vkusomania.com/storage/menu.doc");

if ((session_id() == '')) {
    session_start();
}

$control = new Controller();
		
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
		
if (empty($_POST)) {
	include "..\src\Views\ViewAuto.php";
}

?>


