<?php

namespace Controller;

use Converter\Converter;
use Mappers\DishMapper;
use Mappers\UserMapper;
use Mappers\RoleMapper;

use Users\User;

/**
 * @author Maslov Svyatoslav <svyatoslav.maslov@gmail.com>
 */
class OrderController 
{

    private static $error;

    public static function getError() {
        return self::$error;
    }

    public static function setError($err) {
        self::$error = $err;
    }

    public function actionRole() {

        include_once '..\\src\\layout\\layout.php';
    }
    
    public function actionAuto() {
        
        $user = new UserMapper();
        $result = $user->userAuto($_POST);

        if ( isset($_SESSION['user']) ) {
        $Arr = $_SESSION['roles'];
        }
        if ($result == true && $Arr['orders'] == 1) {//если обычный пользователь
            $mapper = new DishMapper();
            $dishes = $mapper->getMenuFromDB();
        } elseif ($result == false && $Arr['orders'] == 1) {// если такого пользователя не существует
            self::$error = '<h1>Пользователь не найден!</h1>';
        }
        include_once '..\\src\\layout\\layout.php';
    }
    
    public function actionSend() {
        
        $User = new User();
        if ( isset($_SESSION['user']) ) {
        $User = $_SESSION['user'];
        $Arr = $User->getPermissions();
        }
        
        $mapper = new DishMapper();
        
        $model = new Converter();
        if ($model->checkPath()) {
            $model->calculate($_POST['filepath']);
            $res = $model->dataMenu();
            $rez = $mapper->insertToDB($res);
        } else {
            self::$error = "<h1>Вы пытаетесь загрузить файл не с официального сайта!</h1>";
        }
        if ($Arr['orders'] == 1) {
            $dishes = $mapper->getMenuFromDB();
        }
        include_once '..\\src\\layout\\layout.php';
    }

    public function actionOrder() {
        $User = new User();
        if ( isset($_SESSION['user']) ) {
        $User = $_SESSION['user'];
        $Arr = $User->getPermissions();
        }
        
        $dishMapper = new DishMapper();
        $dishes = $dishMapper->getConfirmOrder($_POST);
        $arr = $dishes->getDishes();
        if (!empty($arr)) {
            $_SESSION['order'] = $dishes;
        } else {
            self::$error = '<p>Выберите минимум одно блюдо! Для этого необходимо указать число порций!</p>';
            $dishes = $dishMapper->getMenuFromDB();
        }
        include_once '..\\src\\layout\\layout.php';
    }

    public function actionConfirm() {
        $User = new User();
        if ( isset($_SESSION['user']) ) {
        $User = $_SESSION['user'];
        $Arr = $User->getPermissions();
        }
        
        $mapper = new DishMapper();
        $dishes = $_SESSION['order'];
        if (!empty($dishes)) {
            $mapper->putOrderIntoDB($dishes);
            $this->message = '<p>Спасибо, ваш заказ обработан и отправлен!</p>';
        } else {
            self::$error = '<p>Выберите блюдо, чтобы отправить заказ!</p>';
        }
        $dishes = $mapper->getMenuFromDB();
        include_once '..\\src\\layout\\layout.php';
    }

    public function checkUser() {

        if ( isset($_SESSION['user']) ) {
        $Arr = $_SESSION['roles'];
        }
        
        if ($Arr['user_roles'] == 1 && isset($_GET['user_roles']) &&  $_GET['user_roles'] == 1) {
            $Mapper = new UserMapper();
            if (isset($_POST['role']) ) {
                $Mapper->changeUserRole($_POST['role']);
                
            }
            $users = $Mapper->getUsersFromDB();
            $users = $users->getUsers();
            $Role = new RoleMapper();
            $roles = $Role->getRoles();
            
        }
        
        if ( isset($_POST['insert_role']) ) {
            $Roles = new RoleMapper();
            $rez = $Roles->insertRole($_POST);
            $massive = $Roles->getRoles();   
        } else if ( isset($_POST['save_role']) ) {
            $Roles = new RoleMapper();
            $rez = $Roles->saveRole($_POST);
            $massive = $Roles->getRoles();
        } else if ($_GET['id_role'] != "" && $Arr['edit_roles'] == 1 && isset($_GET['edit_roles']) &&  $_GET['edit_roles'] == 1) {
            $Roles = new RoleMapper();
            $mass = $Roles->getRole($_GET['id_role']);
        } else if ($_GET['del_role'] != "" &&  isset($_GET['edit_roles']) &&  $_GET['edit_roles'] == 1) {
            $Roles = new RoleMapper();
            $mass = $Roles->delRole($_GET['del_role']);
            $massive = $Roles->getRoles();
        } else if ($Arr['edit_roles'] == 1 && isset($_GET['edit_roles']) &&  $_GET['edit_roles'] == 1) {
            $Roles = new RoleMapper();
            $massive = $Roles->getRoles();
        } 
        
        if ($Arr['orders'] == 1 && empty($_POST)) {
            $mapper = new DishMapper();
            $dishes = $mapper->getMenuFromDB();
        }
        
        include_once '..\\src\\layout\\layout.php';
    }
    
    public function insertUser() {
        
        $login = trim(strip_tags($_POST['login']));
        $pass = trim(strip_tags($_POST['password']));
        $FIO = trim(strip_tags($_POST['name']));
        $email = trim(strip_tags($_POST['email']));

        $user = new UserMapper;
        $result = $user->check($login, $pass, $FIO, $email);
        
        if ( empty ($result) ) {
            $str = $user->insertUser($login, $pass, $FIO, $email);
        } 
        
        include_once '..\\src\\layout\\layout.php';
        
    }

}
