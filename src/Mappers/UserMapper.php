<?php

namespace Mappers;

use Mappers\Connect;

class UserMapper
{
     
    public function insertUser($login, $pass, $FIO, $email)
    {
        $link = Connect::getConnection();

        $query = "SELECT * from user where login = '$login'";
        $result = mysql_query($query, $link);
        $num_rows = mysql_num_rows($result);
        if ($num_rows == 0) {
            $query = "INSERT INTO user(login, pass, FIO, email)";
            $query .= "Values ('$login','$pass','$FIO','$email')";
            $result = mysql_query($query, $link);
            return ("Поздравляю! Регистрация прошла успешно!");
        } else {
            return ("Логин -  $login уже занят! Выберите другой!");
        }

    }

    public function check($login, $pass, $FIO, $email)
    {
        $message = '';

        if ($login == '') {
            $message.="Вы не заполнили поле Логин!<br>";
        } elseif (!preg_match("/^[a-zA-Z]{5,}+$/", $login)) {
            $message.="Поле Логин должно быть заполнено латинскими буквами от 5 до 20 символов!<br>";
        }

        if ($pass == '') {
            $message.="Вы не заполнили поле с паролем!<br>";
        } elseif (!preg_match("/^[a-zA-Z0-9]{6,20}+$/", $pass)) {
            $message.="Пароль должен состоять от 6 до 20 символов латинского алфавита и цифр!<br>";
        }

        if ($FIO == '') {
            $message.="Вы не заполнили поле ФИО!<br>";
        } elseif (preg_match("/^[а-яА-я ]{2,60}+$/", $FIO)) {
            $message.="Поле ФИО должно состоять из 2-60 символов русского алфавита!<br>";
        }

        if ($email == '') {
            $message.="Вы не заполнили поле с E-mail!<br>";
        } elseif (!preg_match("/^[a-zA-Z0-9_.]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$/", $email)) {
            $message.="E-mail введен не корректно!<br>";
        }

        return $message;
    }
	
	public static function getUserId()
	{
		$link = Connect::getConnection();
		
		$query_u = "SELECT id FROM user WHERE FIO= '$_SESSION[user_name]'";
        $user = mysql_query($query_u, $link);
        $myrow = mysql_fetch_assoc($user);
		
		return $myrow['id'];
	}
	
    public function userAuto($Arr)
    {
        $link = Connect::getConnection();
        
        $login = trim(strip_tags($Arr['Login']));
		$pass = trim(strip_tags($Arr['Pass']));
        
        if ((!empty($login)) && (!empty($pass) )) {

            $query = "SELECT * FROM user where login='$login' and pass='$pass'";
            $result = mysql_query($query, $link);
            $line = mysql_fetch_array($result);

            if (!empty($line)) {
                $_SESSION['user_name'] = $line['FIO'];
                $_SESSION['id'] = $line['id'];
                
                return true;
            } else {
                
                return false;
            }
        }
    }

}