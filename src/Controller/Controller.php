<?php

namespace Controller;

use Mappers\DishMapper;
use Mappers\UserMapper;
use Mappers\RoleMapper;
use ACL\ACL;
use Users\User;

/**
 * @author Maslov Svyatoslav <svyatoslav.maslov@gmail.com>
 */
class Controller
{

    private $error;

    public function getError()
    {
        return $this->error;
    }

    public function setError($err)
    {
        $this->error = $err;
    }

    public function checkUser()
    {
        $userRoles = $this->formRoleMenu();

        if ($userRoles['user_roles'] == 1 && isset($_GET['user_roles']) && $_GET['user_roles'] == 1) {
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
        } else if ($_GET['id_role'] != "" && $userRoles['edit_roles'] == 1 && isset($_GET['edit_roles']) && $_GET['edit_roles'] == 1) {
            $Roles = new RoleMapper();
            $mass = $Roles->getRole($_GET['id_role']);
        } else if ($_GET['del_role'] != "" && isset($_GET['edit_roles']) && $_GET['edit_roles'] == 1) {
            $Roles = new RoleMapper();
            $mass = $Roles->delRole($_GET['del_role']);
            $massive = $Roles->getRoles();
        } else if ($userRoles['edit_roles'] == 1 && isset($_GET['edit_roles']) && $_GET['edit_roles'] == 1) {
            $Roles = new RoleMapper();
            $massive = $Roles->getRoles();
        } else if (isset($_GET['prof']) && $_GET['prof'] == 1) {
            $User = new User();
            $User = $_SESSION['user'];
        }
        if ($userRoles['orders'] == 0 and isset($_GET['orders'])) {
            $this->error = "Доступ закрыт!";
        }
        if ($userRoles['admin'] == 0 and isset($_GET['admin'])) {
            $this->error = "Доступ закрыт!";
        }
        if ($userRoles['edit_roles'] == 0 and isset($_GET['edit_roles'])) {
            $this->error = "Доступ закрыт!";
        }
        if ($userRoles['user_roles'] == 0 and isset($_GET['user_roles'])) {
            $this->error = "Доступ закрыт!";
        }
        if ($userRoles['reports'] == 0 and isset($_GET['reports'])) {
            $this->error = "Доступ закрыт!";
        }
        if ($userRoles['orders'] == 0 && $userRoles['admin'] == 0 && empty($_GET)) {
            $this->error = "Доступ закрыт!";
        }

        if ($userRoles['orders'] == 1 && empty($_GET)) {
            $mapper = new DishMapper();
            $dishes = $mapper->getMenuFromDB();
        }

        include_once "../src/views/view_main.php";
    }

    protected function formRoleMenu()
    {
        if (isset($_SESSION['user'])) {
            $ACL = new ACL();
            $User = new User();
            $User = $_SESSION['user'];
            $login = $User->getLogin();
            $userRoles = $ACL->getUserPermissions($login);
            return $userRoles;
        }
    }

}
