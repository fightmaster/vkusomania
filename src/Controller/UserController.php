<?php

namespace Controller;

use Mappers\DishMapper;
use Mappers\UserMapper;
use ACL\ACL;
use Users\User;
use Controller\Controller;

/**
 * @author Maslov Svyatoslav <svyatoslav.maslov@gmail.com>
 */
class UserController extends Controller
{

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

        $User = new UserMapper();
        $result = $User->check($login, $name, $surname, $email, $pass1, $pass2);

        if (empty($result)) {
            $str = $User->insertUserWithRoles($login, $name, $surname, $pass1, $email, $_POST['orders'], $_POST['admin'], $_POST['edit_roles'], $_POST['user_roles'], $_POST['reports']);
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
        if ($pass1 != "" && $pass2 != "") {
            $check = $user->check($login, $name, $surname, $email, $pass1, $pass2);
            if (empty($check)) {
                $str = $user->updateUser($login, $name, $surname, $email, $pass1);
            }
        } elseif ($pass1 == "" && $pass2 == "") {
            $check = $user->check($login, $name, $surname, $email);
            if (empty($check)) {
                $str = $user->updateUser($login, $name, $surname, $email);
            }
        }

        $User = new User();
        $User = $_SESSION['user'];

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
        $userRoles = $this->formRoleMenu();
        
        $User = new User();
        $User = $_SESSION['user'];
        $ACL = new ACL();
        $Arr = $ACL->getUserPermissions($User->getLogin());

        $Mapper = new UserMapper();
        $result = $Mapper->editUserRole($_GET['login'], $_POST);
        
        if ($User->getLogin() == $_GET['login']) {
            $_SESSION['user_name'] = $_POST['login'];
            $_SESSION['user'] = $Mapper->infoUser($_POST['login']);
        }

        header("Location: index.php?user_roles=1");
    }

}

