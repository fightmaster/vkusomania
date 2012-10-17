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

        $userRoles = $this->formRoleMenu();


        if ($result == true && $userRoles['orders'] == 1) { //если обычный пользователь
            $mapper = new DishMapper();
            $dishes = $mapper->getMenuFromDB();
        }

        if ($userRoles['orders'] == 0 && $userRoles['admin'] == 0 && $userRoles['edit_roles'] ==
                1 && $userRoles['user_roles'] == 0 && $userRoles['reports'] == 0) {
            header("Location: index.php?edit_roles=1");
        }

        if ($userRoles['orders'] == 0 && $userRoles['admin'] == 0 && $userRoles['edit_roles'] ==
                0 && $userRoles['user_roles'] == 1 && $userRoles['reports'] == 0) {
            header("Location: index.php?user_roles=1");
        }

        if ($userRoles['orders'] == 0 && $userRoles['admin'] == 0 && $userRoles['edit_roles'] ==
                1 && $userRoles['user_roles'] == 0 && $userRoles['reports'] == 0) {
            header("Location: index.php?reports=1");
        }

        if (isset($_SESSION['user'])) {
            $userRoles = $_SESSION['roles'];
        }


        include_once "../src/views/view_main.php";
    }

    public function actionSend()
    {
        $userRoles = $this->formRoleMenu();

        $mapper = new DishMapper();

        $model = new Converter();
        if ($model->checkPath()) {
            $model->formMenu($_POST['filepath']);
            $res = $model->dataMenu();
            $rez = $mapper->insertToDB($res);
        } else {
            self::$error = "<h1>Вы пытаетесь загрузить файл не с официального сайта!</h1>";
        }

        if ($userRoles['orders'] == 1) {

            $dishes = $mapper->getMenuFromDB();
        }

        include_once "../src/views/view_main.php";
    }

    public function actionOrder()
    {
        $userRoles = $this->formRoleMenu();
        $dishMapper = new DishMapper();
        $dishes = $dishMapper->getConfirmOrder($_POST);
        $arr = $dishes->getDishes();
        if (!empty($arr)) {
            $_SESSION['order'] = $dishes;
        } else {
            self::$error = '<p>Выберите минимум одно блюдо!</p>';
            $dishes = $dishMapper->getMenuFromDB();
        }

        include_once "../src/views/view_main.php";
    }

    public function actionConfirm()
    {
        $userRoles = $this->formRoleMenu();
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
        $userRoles = $this->formRoleMenu();

        if ($userRoles['user_roles'] == 1 && isset($_GET['user_roles']) && $_GET['user_roles'] ==
                1) {
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
        } else
        if (isset($_POST['save_role'])) {
            $Roles = new RoleMapper();
            $rez = $Roles->saveRole($_POST);
            $massive = $Roles->getRoles();
        } else
        if ($_GET['id_role'] != "" && $userRoles['edit_roles'] == 1 && isset($_GET['edit_roles']) &&
                $_GET['edit_roles'] == 1) {
            $Roles = new RoleMapper();
            $mass = $Roles->getRole($_GET['id_role']);
        } else
        if ($_GET['del_role'] != "" && isset($_GET['edit_roles']) && $_GET['edit_roles'] ==
                1) {
            $Roles = new RoleMapper();
            $mass = $Roles->delRole($_GET['del_role']);
            $massive = $Roles->getRoles();
        } else
        if ($userRoles['edit_roles'] == 1 && isset($_GET['edit_roles']) && $_GET['edit_roles'] ==
                1) {
            $Roles = new RoleMapper();
            $massive = $Roles->getRoles();
        } else
        if (isset($_GET['prof']) && $_GET['prof'] == 1) {
            $User = new User();
            $User = $_SESSION['user'];
        }
        if ($userRoles['orders'] == 0 and isset($_GET['orders'])) {
            self::$error = "Доступ закрыт!";
        }
        if ($userRoles['admin'] == 0 and isset($_GET['admin'])) {
            self::$error = "Доступ закрыт!";
        }
        if ($userRoles['edit_roles'] == 0 and isset($_GET['edit_roles'])) {
            self::$error = "Доступ закрыт!";
        }
        if ($userRoles['user_roles'] == 0 and isset($_GET['user_roles'])) {
            self::$error = "Доступ закрыт!";
        }
        if ($userRoles['reports'] == 0 and isset($_GET['reports'])) {
            self::$error = "Доступ закрыт!";
        }
        if ($userRoles['orders'] == 0 && $userRoles['admin'] == 0 && empty($_GET)) {
            self::$error = "Доступ закрыт!";
        }

        if ($userRoles['orders'] == 1 && empty($_GET)) {
            $mapper = new DishMapper();
            $dishes = $mapper->getMenuFromDB();
        }

        include_once "../src/views/view_main.php";
    }

    public function insertUser()
    {
        $login = trim(strip_tags($_POST['login']));
        $pass1 = trim(strip_tags($_POST['password1']));
        $pass2 = trim(strip_tags($_POST['password2']));
        $name = trim(strip_tags($_POST['name']));
        $surname = trim(strip_tags($_POST['surname']));
        $email = trim(strip_tags($_POST['email']));

        $user = new UserMapper();
        $result = $user->check($login, $name, $surname, $email, $pass1, $pass2);

        if (empty($result)) {
            $str = $user->insertUser($login, $name, $surname, $pass1, $email);
        }

        include_once "../src/views/view_err.php";
    }

    public function showInsertUserForm()
    {
        $userRoles = $this->formRoleMenu();

        include_once "../src/views/view_main.php";
    }

    public function insertUserWithRoles()
    {
        $userRoles = $this->formRoleMenu();

        $login = trim(strip_tags($_POST['login']));
        $pass1 = trim(strip_tags($_POST['pass']));
        $pass2 = trim(strip_tags($_POST['r_pass']));
        $name = trim(strip_tags($_POST['name']));
        $surname = trim(strip_tags($_POST['surname']));
        $email = trim(strip_tags($_POST['email']));

        $user = new UserMapper();
        $result = $user->check($login, $name, $surname, $email, $pass1, $pass2);

        if (empty($result)) {
            $str = $user->insertUserWithRoles($login, $name, $surname, $pass1, $email, $_POST['orders'], $_POST['admin'], $_POST['edit_roles'], $_POST['user_roles'], $_POST['reports']);
        }
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
        $userRoles = $this->formRoleMenu();

        $Mapper = new UserMapper();
        $user = $Mapper->infoUser($_GET['login']);

        $ACL = new ACL();
        $A = $ACL->getUserPermissions($user->getLogin());
        include_once "../src/views/view_main.php";
    }

    public function editUser()
    {
        $userRoles = $this->formRoleMenu();

        $name = trim(strip_tags($_POST['name']));
        $surname = trim(strip_tags($_POST['surname']));
        $login = trim(strip_tags($_POST['login']));
        $email = trim(strip_tags($_POST['email']));
        $pass1 = trim(strip_tags($_POST['pass']));
        $pass2 = trim(strip_tags($_POST['r_pass']));

        $user = new UserMapper();
        if ($pass1 != '' || $pass2 != '') {
            $check = $user->check($login, $name, $surname, $email, $pass1, $pass2);
            if (empty($check)) {
                $str = $user->updateUser($login, $name, $surname, $email, $pass1);
            }
        } elseif ($pass1 == '' && $pass2 == "") {
            $check = $user->check($login, $name, $surname, $email);
            if (empty($check)) {
                $str = $user->updateUser($login, $name, $surname, $email);
            }
        }

        $User = new User();
        $User = $_SESSION['user'];

        include_once "../src/views/view_main.php";
    }

    private function formRoleMenu()
    {
        if (isset($_SESSION['user'])) {
            $ACL = new ACL();
            $User = new User();
            $User = $_SESSION['user'];
            $userRoles = $ACL->getUserPermissions($User->getLogin());
            return $userRoles;
        }
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
        $userRoles = $this->formRoleMenu();

        $Arr = $ACL->getUserPermissions($User->getLogin());


        $Mapper = new UserMapper();
        $result = $Mapper->editUserRole($_GET['login'], $_POST);

        header("Location: index.php?user_roles=1");
    }

}
