<?php

namespace Mappers;

use Mappers\Connect;
use Users\User;
use Users\UserList;
use ACL\ACL;

class UserMapper {

    public function insertUser($login, $name, $surname, $pass, $email)
    {
        $link = Connect::getConnection();

        $pass = md5($pass);

        $query = "SELECT * from user where login = '$login'";
        $result = mysql_query($query, $link);
        $num_rows = mysql_num_rows($result);
        if ($num_rows == 0) {
            $query = "INSERT INTO user(login, pass, name, surname, email, role)";

            $query .= " Values ('$login','$pass','$name','$surname','$email', (select id from roles where role_name = 'default'))";
            $result = mysql_query($query, $link) or die(mysql_error());

            return ("Поздравляю! Регистрация прошла успешно!");
        } else {

            return ("Логин -  $login уже занят! Выберите другой!");
        }
    }

    public function insertUserWithRoles($login, $name, $surname, $pass, $email, $orders, $admin, $edit_roles, $user_roles, $reports)
    {
        if (!isset($orders)) {
            $orders = '0';
        }
        if (!isset($admin)) {
            $admin = '0';
        }
        if (!isset($edit_roles)) {
            $edit_roles = "0";
        }
        if (!isset($user_roles)) {
            $user_roles = "0";
        }
        if (!isset($reports)) {
            $reports = "0";
        }

        $link = Connect::getConnection();
        $pass = md5($pass);

        $query = "SELECT * from user where login = '$login'";
        $result = mysql_query($query, $link);
        $num_rows = mysql_num_rows($result);
        if ($num_rows == 0) {

            $query = "INSERT INTO user(login, pass, name, surname, email, role)
                      Values ('$login','$pass','$name','$surname','$email', 
                     (select id from roles where orders = '$orders' and admin = '$admin' and edit_roles = '$edit_roles'
                      and user_roles = '$user_roles' and reports = '$reports'))";
            $result = mysql_query($query, $link);
            if ($result == 1) {

                return ("Поздравляю! Регистрация прошла успешно!");
            } else {

                return ("Роль с такими правами не существует! Обратитесь к администратору!");
            }
        } else {
            return ("Логин -  $login уже занят! Выберите другой!");
        }
    }

    public function check($login, $name, $surname, $email, $pass = "*", $pass2 = "*")
    {
        $message = array();

        if ($name == '') {
            $message[] = "Вы не заполнили поле Имя!";
        } elseif (!preg_match("/^[а-яА-я]{2,20}/", $name)) {
            $message[] = "Поле 'Имя' должно состоять из 2-20 символов русского алфавита!<br>";
        }

        if ($surname == '') {
            $message[] = "Вы не заполнили поле Фамилия!";
        } elseif (!preg_match("/^[А-Яа-я]{2,20}/", $surname)) {
            $message[] = "Поле 'Фамилия' должно состоять из 2-20 символов русского алфавита!<br>";
        }

        if ($login == '') {
            $message[] = "Вы не заполнили поле Логин!";
        } elseif (!preg_match("/^[a-zA-Z]{5,}+$/", $login)) {
            $message[] = "Поле Логин должно быть заполнено латинскими буквами от 5 до 20 символов!<br>";
        }

        if ($pass == '') {
            $message[] = "Вы не заполнили поле с паролем!";
        } elseif (!preg_match("/^[a-zA-Z0-9]{6,20}+$/", $pass) && $pass != "*") {
            $message[] = "Пароль должен состоять от 6 до 20 символов латинского алфавита и цифр!<br>";
        }

        if ($pass != $pass2) {
            $message[] = "Пароли не совпадают!<br>";
        }


        if ($email == '') {
            $message[] = "Вы не заполнили поле с E-mail!";
        } elseif (!preg_match("/^[a-zA-Z0-9_.]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$/", $email)) {
            $message[] = "E-mail введен не корректно!";
        }

        return $message;
    }

    static function getUserId()
    {
        $link = Connect::getConnection();

        $query_u = "SELECT id FROM user WHERE login= '$_SESSION[user_name]'";
        $user = mysql_query($query_u, $link);
        $myrow = mysql_fetch_assoc($user);

        return $myrow['id'];
    }

    public function getUserRole()
    {
        $link = Connect::getConnection();

        $query_u = "SELECT id FROM user WHERE name= '$_SESSION[user_name]'";
        $user = mysql_query($query_u, $link);
        $myrow = mysql_fetch_assoc($user);

        return $myrow['id'];
    }

    public function changeUserRole($role)
    {
        $link = Connect::getConnection();
        $arr = explode("|", $role);
        $query = "UPDATE `user` SET role=$arr[1] WHERE user.id=$arr[0]";
        mysql_query($query, $link) or die(mysql_error());
    }

    public function getUsersFromDB()
    {
        $link = Connect::getConnection();

        $query = "SELECT user.*, roles.role_name from user Inner join roles on user.role=roles.id  ORDER BY user.id";

        $result = mysql_query($query, $link);
        $Users = new UserList();
        while ($myrow = mysql_fetch_assoc($result)) {
            $User = new User;
            $User->setId($myrow['id']);
            $User->setLogin($myrow['login']);
            $User->setName($myrow['name']);
            $User->setSurname($myrow['surname']);
            $User->setEmail($myrow['email']);
            $User->setRole($myrow['role_name']);
            $Users->add($User);
        }

        return $Users;
    }

    public function userAuto($Arr)
    {
        $link = Connect::getConnection();
        $login = trim(strip_tags($Arr['Login']));
        $pass = trim(strip_tags($Arr['Pass']));
        $pass = md5($pass);

        if ((!empty($login)) && (!empty($pass))) {

            $query = "SELECT * FROM user where login='$login' and pass='$pass'";
            mysql_query('SET NAMES utf8', $link);
            $result = mysql_query($query, $link);
            $line = mysql_fetch_assoc($result);

            if (!empty($line)) {
                $User = new User();
                $User->setLogin($line['login']);
                $User->setName($line['name']);
                $User->setSurname($line['surname']);
                $User->setEmail($line['email']);
                $User->setRole($line['role']);
                $User->setId($line['id']);
                $ACL = new ACL();
                $massive = $ACL->getUserPermissions($line['login']);

                $_SESSION['user_name'] = $line['login'];
                $_SESSION['roles'] = $massive;
                $_SESSION['user'] = $User;

                return true;
            } else {

                return false;
            }
        }
    }

    public function updateUser($login, $name, $surname, $email, $pass = "*")
    {
        $link = Connect::getConnection();
        $pass = md5($pass);

        $user = new User();
        $user = $_SESSION['user'];

        if ($pass != "*") {
            $query = "UPDATE `user` SET login='$login', name='$name', surname='$surname', pass='$pass', email='$email' WHERE user.id=" .
                    $user->getId();
        } else
        if ($pass == "*") {
            $query = "UPDATE `user` SET login='$login', name='$name', surname='$surname',  email='$email' WHERE user.id=" .
                    $user->getId();
        }

        mysql_query($query, $link) or die(mysql_error());

        $user->setName($name);
        $user->setSurname($surname);
        $user->setLogin($login);
        $user->setEmail($email);

        $_SESSION['user_name'] = $name;
        $_SESSION['user'] = $user;
    }

    public function infoUser($login)
    {
        $link = Connect::getConnection();

        $resultat = mysql_query("SELECT * FROM `user`  WHERE login = '$login'");
        $array = mysql_fetch_assoc($resultat);

        $User = new User();
        $User->setLogin($array['login']);
        $User->setName($array['name']);
        $User->setSurname($array['surname']);
        $User->setEmail($array['email']);
        return $User;
    }

    public function delUser($login)
    {
        $link = Connect::getConnection();
        $sql = "DELETE FROM `user` WHERE `login` = '$login' ";
        mysql_query($sql, $link) or die(mysql_error());
        return ('Пользователь удален!');
    }

    public function editUserRole($tek_login, $post)
    {
        $login = trim(strip_tags($post['login']));
        $name = trim(strip_tags($post['name']));
        $surname = trim(strip_tags($post['surname']));
        $email = trim(strip_tags($post['email']));
        $pass1 = trim(strip_tags($post['pass']));
        $pass2 = trim(strip_tags($post['r_pass']));

        $orders = $post['orders'];
        $admin = $post['admin'];
        $edit_roles = $post['edit_roles'];
        $user_roles = $post['user_roles'];
        $reports = $post['reports'];

        if (!isset($orders)) {
            $orders = '0';
        }
        if (!isset($admin)) {
            $admin = '0';
        }
        if (!isset($edit_roles)) {
            $edit_roles = "0";
        }
        if (!isset($user_roles)) {
            $user_roles = "0";
        }
        if (!isset($reports)) {
            $reports = "0";
        }

        if (empty($pass1)) {
            $result = $this->check($login, $name, $surname, $email);
        } else
        if (!empty($pass1) && !empty($pass2)) {
            $result = $this->check($login, $name, $surname, $email, $pass1, $pass2);
        }

        $link = Connect::getConnection();


        if (empty($result)) {

            if ($tek_login == $login) {
                if (empty($pass1)) {
                    $query = "UPDATE `user` SET name = '$name', 
                              surname = '$surname', email = '$email', role = 
                              (select id from roles where orders = '$orders' and admin = '$admin' 
                              and edit_roles = '$edit_roles' and user_roles = '$user_roles'
                              and reports = '$reports') where login = '$login' ";
                } else {
                    $pass1 = md5($pass1);
                    $query = "UPDATE `user` SET pass = '$pass1', name = '$name', 
                              surname = '$surname', email = '$email', role = 
                              (select id from roles where orders = '$orders' and admin = '$admin' 
                              and edit_roles = '$edit_roles' and user_roles = '$user_roles'
                              and reports = '$reports') where login = '$login' ";
                }

                mysql_query($query, $link) or die(mysql_error());
            } else
            if ($tek_login != $login) {
                $query = "SELECT * from user where login = '$login'";
                mysql_query('SET NAMES utf8', $link);
                $result = mysql_query($query, $link);
                $num_rows = mysql_num_rows($result);

                if ($num_rows == 0) {

                    if (empty($pass1)) {
                        $query = "UPDATE `user` SET login = '$login', name = '$name', 
                                  surname = '$surname', email = '$email', role = 
                                  (select id from roles where orders = '$orders' and admin = '$admin' 
                                  and edit_roles = '$edit_roles' and user_roles = '$user_roles'
                                  and reports = '$reports') where login = '$tek_login' ";
                    } else {
                        $pass1 = md5($pass1);
                        $query = "UPDATE `user` SET pass = '$pass1', login = '$login', name = '$name', 
                                  surname = '$surname', email = '$email', role = 
                                  (select id from roles where orders = '$orders' and admin = '$admin' 
                                  and edit_roles = '$edit_roles' and user_roles = '$user_roles'
                                  and reports = '$reports') where login = '$tek_login' ";
                    }

                    $result = mysql_query($query, $link) or die(mysql_error());

                    if ($result == 1) {

                        return ("Поздравляю! Изминеня прошли успешно!");
                    } else {

                        return ("Роль с такими правами не существует! Обратитесь к администратору!");
                    }
                } else {

                    return "Такой пользователь существует!";
                }
            }
        } else {

            return $result;
        }
    }

}
