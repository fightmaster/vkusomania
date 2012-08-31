<?php

namespace Controller;

use Converter\Converter;
use Mappers\DishMapper;
use Mappers\UserMapper;

/**
 * @author John Doe <john.doe@example.com>
 */
class OrderController
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
    
    public function postSend()
    {   
        $rez = '';
        $model = new Converter();
        if ($model->checkPath()) {
            $model->calculate($_POST['filepath']);
            $res = $model->dataMenu();
            $Mapper = new DishMapper();
            $rez = $Mapper->insertToDB($res);
        } else {
            $this->error = "<h1>Вы пытаетесь загрузить файл не с официального сайта!</h1>";
        }
        include_once '..\\src\\layout\\layout.php';
    }

    public function postOrder()
    {
        $DishMapper = new DishMapper();
        $Dishes = $DishMapper->confirmOrder($_POST);
        $Arr = $Dishes->getDishes();
        if (!empty($Arr)) {
            $_SESSION['order'] = $Dishes;
        } else {
            $this->error = '<p>Выберите минимум одно блюдо! Для этого необходимо указать число порций!</p>';
            $Dishes = $DishMapper->getMenuFromDB();
        }
        include_once '..\\src\\layout\\layout.php';
    }

    public function postConfirm()
    {
        $Mapper = new DishMapper();
        $Dishes = $_SESSION['order'];
        if (!empty($Dishes)) {
            $Mapper->putOrderIntoDB($Dishes);
            $this->message = '<p>Спасибо, ваш заказ обработан и отправлен!</p>';
        } else {
            $this->error = '<p>Выберите блюдо, чтобы отправить заказ!</p>';
        }
        $Dishes = $Mapper->getMenuFromDB();
        include_once '..\\src\\layout\\layout.php';
    }

    public function checkUser()
    {
        if ($_SESSION['user_name'] != ADMIN && empty($_POST)) {
            $Mapper = new DishMapper();
            $Dishes = $Mapper->getMenuFromDB();
        }
        include_once '..\\src\\layout\\layout.php';
    }

    public function postAuto()
    {
        $User = new UserMapper();
        $result = $User->userAuto($_POST);
        if ($result == true && $_SESSION['user_name'] != ADMIN) {//если обычный пользователь
            $Mapper = new DishMapper();
            $Dishes = $Mapper->getMenuFromDB();
        } elseif ($result == false && $_SESSION['user_name'] != ADMIN) {// если такого пользователя не существует
            $this->error = '<h1>Пользователь не найден!</h1>';
        }
        include_once '..\\src\\layout\\layout.php';
    }

}
