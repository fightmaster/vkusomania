<?php

namespace Controller;

use Converter\Converter;
use Mappers\DishMapper;
use Mappers\UserMapper;
use Mappers\RoleMapper;
use ACL\ACL;
use Users\User;

/**
 * @author Maslov Svyatoslav <svyatoslav.maslov@gmail.com>
 */
class OrderController {

    private static $error;

    public static function getError()
    {
        return self::$error;
    }

    public static function setError($err)
    {
        self::$error = $err;
    }

    public function actionAuto()
    {

        $user = new UserMapper();
        if ($_POST['Login'] != '' && $_POST['Pass'] != '') {
            $result = $user->userAuto($_POST);
        }

        if (isset($_SESSION['user'])) {
            $ACL = new ACL();
            $User = new User();
            $User = $_SESSION['user'];
            $Arr = $ACL->getUserPermissions($User->getLogin());
        }

        if ($result == true && $Arr['orders'] == 1) {//если обычный пользователь
            $mapper = new DishMapper();
            $dishes = $mapper->getMenuFromDB();
        }

        if (isset($_SESSION['user'])) {
            $Arr = $_SESSION['roles'];
        }

        include_once "../src/views/view_main.php";
    }

    public function actionSend()
    {

        if (isset($_SESSION['user'])) {
            $ACL = new ACL();
            $User = new User();
            $User = $_SESSION['user'];
            $Arr = $ACL->getUserPermissions($User->getLogin());
        }

        $mapper = new DishMapper();

        $model = new Converter();
        if ($model->checkPath()) {
            $model->formMenu($_POST['filepath']);
            $res = $model->dataMenu();
            $rez = $mapper->insertToDB($res);
        } else {
            self::$error = "<h1>Вы пытаетесь загрузить файл не с официального сайта!</h1>";
        }

        if ($Arr['orders'] == 1) {
            $dishes = $mapper->getMenuFromDB();
        }

        include_once "../src/views/view_main.php";
    }

    public function actionOrder()
    {

        if (isset($_SESSION['user'])) {
            $ACL = new ACL();
            $User = new User();
            $User = $_SESSION['user'];
            $Arr = $ACL->getUserPermissions($User->getLogin());
        }

        $dishMapper = new DishMapper();
        $dishes = $dishMapper->getConfirmOrder($_POST);
        $arr = $dishes->getDishes();
        if (!empty($arr)) {
            $_SESSION['order'] = $dishes;
        } else {
            self::$error = '<p>Выберите минимум одно блюдо! Для этого необходимо указать число порций!</p>';
            if ($Arr['admin'] == 1 && empty($_GET)) {
                include_once "../src/views/view_admin.php";
            }
            $dishes = $dishMapper->getMenuFromDB();
        }

        include_once "../src/views/view_order.php";
    }

    public function actionConfirm()
    {

        if (isset($_SESSION['user'])) {
            $ACL = new ACL();
            $User = new User();
            $User = $_SESSION['user'];
            $Arr = $ACL->getUserPermissions($User->getLogin());
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

        include_once "../src/views/view_main.php";
    }

    public function checkUser()
    {
        if (isset($_SESSION['user'])) {
            $ACL = new ACL();
            $User = new User();
            $User = $_SESSION['user'];
            $Arr = $ACL->getUserPermissions($User->getLogin());
        }
        if ($Arr['user_roles'] == 1 && isset($_GET['user_roles']) && $_GET['user_roles'] == 1) {
            
            $Mapper = new UserMapper();
            if (isset($_POST['input_role'])) {
                $Mapper->changeUserRole($_POST['role']);
            }
            $users = $Mapper->getUsersFromDB();
            $users = $users->getUsers();
            $Role = new RoleMapper();
            $roles = $Role->getRoles();
        }

        if (isset($_POST['insert_role'])) {
            $Roles = new RoleMapper();
            $rez = $Roles->insertRole($_POST);
            $massive = $Roles->getRoles();
        } else if (isset($_POST['save_role'])) {
            $Roles = new RoleMapper();
            $rez = $Roles->saveRole($_POST);
            $massive = $Roles->getRoles();
        } else if ($_GET['id_role'] != "" && $Arr['edit_roles'] == 1 && isset($_GET['edit_roles']) && $_GET['edit_roles'] == 1) {
            $Roles = new RoleMapper();
            $mass = $Roles->getRole($_GET['id_role']);
        } else if ($_GET['del_role'] != "" && isset($_GET['edit_roles']) && $_GET['edit_roles'] == 1) {
            $Roles = new RoleMapper();
            $mass = $Roles->delRole($_GET['del_role']);
            $massive = $Roles->getRoles();
        } else if ($Arr['edit_roles'] == 1 && isset($_GET['edit_roles']) && $_GET['edit_roles'] == 1) {
            $Roles = new RoleMapper();
            $massive = $Roles->getRoles();
        } else if (isset($_GET['prof']) && $_GET['prof'] == 1) {
            $User = new User();
            $User = $_SESSION['user'];
        }

        if ($Arr['orders'] == 1 && empty($_GET)) {
            $mapper = new DishMapper();
            $dishes = $mapper->getMenuFromDB();
        }
        
        include_once "../src/views/view_main.php";
    }

    public function insertUser()
    {
        $login = trim(strip_tags($_POST['login']));
        $pass = trim(strip_tags($_POST['password']));
        $name = trim(strip_tags($_POST['name']));
        $surname = trim(strip_tags($_POST['surname']));
        $email = trim(strip_tags($_POST['email']));

        $user = new UserMapper;
        $result = $user->check($login, $pass, $name, $surname, $email);

        if (empty($result)) {
            $str = $user->insertUser($login, $pass, $name, $surname, $email);
        }
        include_once "../src/views/view_main.php";
    }

    public function delUserWithRoles()
    {
        if (isset($_SESSION['user'])) {
            $ACL = new ACL();
            $User = new User();
            $User = $_SESSION['user'];
            $Arr = $ACL->getUserPermissions($User->getLogin());
        }

        $Mapper = new UserMapper();
        $user = new User();
        $user = $Mapper->infoUser($_GET['login']);
        
        include_once "../src/views/view_main.php";
    }
    
    public function ifUserWithRoles()
    {
        if (isset($_SESSION['user'])) {
            $ACL = new ACL();
            $User = new User();
            $User = $_SESSION['user'];
            $Arr = $ACL->getUserPermissions($User->getLogin());
        }

        $Mapper = new UserMapper();
        $user = $Mapper->infoUser($_GET['login']);

        $ACL = new ACL();
        $A = $ACL->getUserPermissions($user->getLogin());
        
        include_once "../src/views/view_main.php";
    }

    public function delUserForm()
    {
        if ($_POST['delete_user']) {
            $login = $_GET['login'];
            $User = new UserMapper();
            $User->delUser($login);
        }
        
        header("Location: index.php?user_roles=1");
    }

    public function editUserWithRoles()
    {
        if (isset($_SESSION['user'])) {
            $ACL = new ACL();
            $User = new User();
            $User = $_SESSION['user'];
            $Arr = $ACL->getUserPermissions($User->getLogin());
        }
        
        $Mapper = new UserMapper();
        $result = $Mapper->editUserRole($_GET['login'], $_POST);
        
        header("Location: index.php?user_roles=1");
    }

}
