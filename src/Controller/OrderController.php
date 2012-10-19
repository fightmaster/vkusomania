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
class OrderController extends Controller 
{
    
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
            $this->error = "<h1>Вы пытаетесь загрузить файл не с официального сайта!</h1>";
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
            $this->error = '<p>Выберите минимум одно блюдо!</p>';
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
            $this->error = '<p>Выберите блюдо, чтобы отправить заказ!</p>';
        }
        $dishes = $mapper->getMenuFromDB();

        include_once "../src/views/view_main.php";
    }

}
