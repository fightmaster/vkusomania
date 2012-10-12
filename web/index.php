<?php

use Controller\OrderController;

require_once("../src/autoLoader.php");
error_reporting(E_ALL ^ E_NOTICE);

session_start();

$control = new OrderController();

include_once "../src/layout/layout.php";

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

if ($_POST['edit_prof'] && $_SESSION['user_name'] != '') {
    $control->editUser();
}

if (isset($_POST['delete_user']) && isset($_GET['id'])) {
    $control->delUserForm();
}

if (isset($_GET['user_edit']) && $_GET['user_edit'] == 1 && isset($_GET['login'])) {
    $control->ifUserWithRoles();
}

if (isset($_GET['user_del']) && $_GET['user_del'] == 1 && isset($_GET['login'])) {
    $control->delUserWithRoles();
}

if (isset($_GET['edit']) && $_GET['edit'] == 1 && isset($_GET['login'])) {
    $control->editUserWithRoles();
}


if (isset($_POST['delete_user']) && isset($_GET['login'])) {
    $control->delUserForm();
}

if (isset($_POST['cancel']) && isset($_GET['login'])) {
    $control->delUserForm();
}

if ($_POST['new_user'] && $_SESSION['user_name'] != '' && isset($_GET['insert_user']) && $_GET['insert_user'] == 1) {
    $control->showInsertUserForm();
}

if ($_POST['save_user'] && $_SESSION['user_name'] != '' && isset($_GET['insert_user']) && $_GET['insert_user'] == 1) {
    $control->insertUserWithRoles();
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

if (!empty($_SESSION['user_name']) && ( empty($_POST) || isset($_POST['save_role']) || isset($_POST['input_role']) || isset($_POST['insert_role']) )) {
    $control->checkUser();
}

if (isset($_POST['login']) && isset($_POST['password1']) && isset($_POST['name']) && isset($_POST['email'])) {
    $control->insertUser();
}
?>
