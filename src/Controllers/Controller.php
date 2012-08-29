<?php

namespace Controllers;

use Models\Model;
use Views\View;
use Mappers\DishMapper;
use Mappers\UserMapper;

/**
 * @author John Doe <john.doe@example.com>
 */
class Controller
{

    public $error;
    public $show;

    //запуск контроллера
    public function processData()
    {
        if (!$this->situationCheck()) {
            include "..\src\Views\ViewAuto.php";
        }
    }

    public function postSend()
    {
        $model = new Model;
        if ($model->checkPath()) {
            $model->calculate($_POST['filepath']);
            $res = $model->dataMenu();
            $Mapper = new DishMapper();
            $rez = $Mapper->insertToDB($res);
			
            if ($rez == true) {
                include "..\src\Views\ViewAdmin.php";
            } else {
                include "..\src\Views\ViewAfterLoad.php";
            }
        } else {
            $this->error = "<h1>Вы пытаетесь загрузить файл не с официального сайта!</h1>";
            include "..\src\Views\ViewAdmin.php";
        }
    }

    public function postOrder()
    {
        $DishMapper = new DishMapper;
        $Dishes = $DishMapper->confirmOrder($_POST);
        if (!empty($Dishes)) {
            $_SESSION['order'] = $Dishes;
            $_SESSION['mail'] = $mail;
            include "..\src\Views\ViewOrder.php";
        } else {
            $this->error = '<p>Выберите минимум одно блюдо! Для этого необходимо указать число порций!</p>';
            $Dishes = $DishMapper->GetMenuFromDB();
            include "..\src\Views\View.php";
        }
    }

    public function postConfirm()
    {
        $Mapper = new DishMapper;
        $Dishes = $_SESSION['order'];
        if (!empty($Dishes)) {
            $Mapper->putOrderIntoDB($Dishes);
            //$Model = new Model;
            //$Model->sendmail( $_SESSION['mail'] );
            //echo $_SESSION['mail'];
            $this->message = '<p>Спасибо, ваш заказ обработан и отправлен!</p>';
        } else {
            $this->error = '<p>Выберите блюдо, чтобы отправить заказ!</p>';
        }
        $Dishes = $Mapper->getMenuFromDB();
        include "..\src\Views\View.php";
    }

    public function checkUser()
    {
        if ($_SESSION['user_name'] != ADMIN) {
            $Mapper = new DishMapper();
            $Dishes = $Mapper->getMenuFromDB();
            include "..\src\Views\View.php";
        } else {
            include "..\src\Views\ViewAdmin.php";
        }
    }

    public function postAuto()
    {
        $User = new UserMapper;
        $result = $User->userAuto($_POST);
        if ($_SESSION['user_name'] == ADMIN) {//если авторизовавшийся пользователь - админ
            include "..\src\Views\ViewAdmin.php";
        } elseif ($result == true) {//если обычный пользователь
            $Mapper = new DishMapper();
            $Dishes = $Mapper->getMenuFromDB();
            include "..\src\Views\View.php";
        } else {// если такого пользователя не существует
            $this->error = '<h1>Пользователь не найден!</h1>';
            include "..\src\Views\ViewAuto.php";
        }
    }

}