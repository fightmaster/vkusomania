<?php

namespace Controller;

use Converter\Converter;
use Mappers\DishMapper;
use Mappers\UserMapper;
use Mail\Mail;

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
        $model = new Converter();
        if ($model->checkPath()) {
            $model->calculate($_POST['filepath']);
            $res = $model->dataMenu();
            $Mapper = new DishMapper();
            $rez = $Mapper->insertToDB($res);
			
            if ($rez == true) {
                include "..\src\\views\\view_admin.php";
            } else {
                include "..\src\\views\\view_afterLoad.php";
            }
        } else {
            $this->error = "<h1>Вы пытаетесь загрузить файл не с официального сайта!</h1>";
            include "..\src\\views\\view_admin.php";
        }
    }

    public function postOrder()
    {
        $DishMapper = new DishMapper();
        $Dishes = $DishMapper->confirmOrder($_POST);
        if (!empty($Dishes)) {
            $_SESSION['order'] = $Dishes;
            include "..\src\\views\\view_order.php";
        } else {
            $this->error = '<p>Выберите минимум одно блюдо! Для этого необходимо указать число порций!</p>';
            $Dishes = $DishMapper->GetMenuFromDB();
            include "..\src\\views\\view.php";
        }
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
        include "..\src\\views\\view.php";
    }

    public function checkUser()
    {
        if ($_SESSION['user_name'] != ADMIN && empty($_POST)) {
            $Mapper = new DishMapper();
            $Dishes = $Mapper->getMenuFromDB();
            include "..\src\\views\\view.php";
        } elseif ($_SESSION['user_name'] == ADMIN && empty($_POST)) {
            include "..\src\\views\\view_admin.php";
        }
    }

    public function postAuto()
    {
        $User = new UserMapper();
        $result = $User->userAuto($_POST);
        if ($_SESSION['user_name'] == ADMIN) {//если авторизовавшийся пользователь - админ
            include "..\src\\views\\view_admin.php";
        } elseif ($result == true) {//если обычный пользователь
            $Mapper = new DishMapper();
            $Dishes = $Mapper->getMenuFromDB();
            include "..\src\\views\\view.php";
        } else {// если такого пользователя не существует
            $this->error = '<h1>Пользователь не найден!</h1>';
            include "..\src\\views\\view_auto.php";
        }
    }

}
