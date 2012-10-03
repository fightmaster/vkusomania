<?php

namespace Mappers;

use Mappers\Connect;
use Users\User;
use Users\UserList;
use ACL\ACL;

class UserMapper
{

    public function insertUser($login, $pass, $FIO, $email)
    {
        $link = Connect::getConnection();
        $pass = md5($pass); 
        $query = "SELECT * from user where login = '$login'";
        $result = mysql_query($query, $link);
        $num_rows = mysql_num_rows($result);
        if ($num_rows == 0) {
            $query = "INSERT INTO user(login, pass, FIO, email, role)";
            $query .= " Values ('$login','$pass','$FIO','$email', 1)";
            $result = mysql_query($query, $link);
            return ("Поздравляю! Регистрация прошла успешно!");
        } else {
            return ("Логин -  $login уже занят! Выберите другой!");
        }
    }

    public function check($login, $pass, $FIO, $email)
    {
        $message = array();

        if ($login == '') {
            $message[] = "Вы не заполнили поле Логин!";
        } elseif (!preg_match("/^[a-zA-Z]{5,}+$/", $login)) {
            $message[] = "Поле Логин должно быть заполнено латинскими буквами от 5 до 20 символов!<br>";
        }

        if ($pass == '') {
            $message[] = "Вы не заполнили поле с паролем!";
        } elseif (!preg_match("/^[a-zA-Z0-9]{6,20}+$/", $pass)) {
            $message[] = "Пароль должен состоять от 6 до 20 символов латинского алфавита и цифр!<br>";
        }

        if ($FIO == '') {
            $message[] = "Вы не заполнили поле ФИО!";
        } elseif (preg_match("/^[а-яА-я ]{2,60}+$/", $FIO)) {
            $message[] = "Поле ФИО должно состоять из 2-60 символов русского алфавита!<br>";
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

        $query_u = "SELECT id FROM user WHERE FIO= '$_SESSION[user_name]'";
        $user = mysql_query($query_u, $link);
        $myrow = mysql_fetch_assoc($user);

        return $myrow['id'];
    }
    
    public function getUserRole()
    {
        $link = Connect::getConnection();

        $query_u = "SELECT id FROM user WHERE FIO= '$_SESSION[user_name]'";
        $user = mysql_query($query_u, $link);
        $myrow = mysql_fetch_assoc($user);

        return $myrow['id'];
    }
    
    public function changeUserRole($role)
    {
        $link = Connect::getConnection();
        foreach ($role as $k=>$v)
        {
            if ( substr($k, 0, 4) == "role" ) {
                $arr = explode("|", $v);
                $query = "UPDATE `user` SET role=$arr[1] WHERE user.id=$arr[0]";
                mysql_query($query,$link) or die(mysql_error());
            }
        }
       
    }
    
    public function getUsersFromDB()
    {
        $link = Connect::getConnection();

        $query = "SELECT user.*, roles.role_name from user Inner join roles on user.role=roles.id  ORDER BY user.id";
        $result = mysql_query($query,$link);

        $Users = new UserList();
        while ($myrow = mysql_fetch_assoc($result)) {
            $User = new User;
            
            $User->setId($myrow['id']);
            $User->setLogin($myrow['login']);
            $User->setFIO($myrow['FIO']);
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

        if ((!empty($login)) && (!empty($pass) )) {

            $query = "SELECT * FROM user where login='$login' and pass='$pass'";
            $result = mysql_query($query, $link);
            $line = mysql_fetch_array($result);

            if (!empty($line)) {
                $User = new User();
                $User->setLogin($line['login']);
                $User->setFIO($line['FIO']);
                $User->setEmail($line['email']);
                $User->setRole($line['role']);
                
                $ACL = new ACL();
                $massive = $ACL->getUserPermissions($line['login']);
                
                $_SESSION['user_name'] = $line['FIO'];
                $_SESSION['roles'] = $massive;
                $_SESSION['user'] = $User;

                return true;
            } else {

                return false;
            }
        }
    }
    
    

}
