<?php

namespace Controller;

use Converter\Converter;
use Mappers\DishMapper;
use Mappers\UserMapper;

/**
 * @author Maslov Svyatoslav <svyatoslav.maslov@gmail.com>
 */
class OrderController {

    private $error;

    public function getError() {
        return $this->error;
    }

    public function setError($err) {
        $this->error = $err;
    }

    public function actionAuto() {
        $user = new UserMapper();
        $result = $user->userAuto($_POST);
        if ($result == true && $_SESSION['user_name'] != ADMIN) {//если обычный пользователь
            $mapper = new DishMapper();
            $dishes = $mapper->getMenuFromDB();
        } elseif ($result == false && $_SESSION['user_name'] != ADMIN) {// если такого пользователя не существует
            $this->error = '<h1>Пользователь не найден!</h1>';
        }
        include_once '..\\src\\layout\\layout.php';
    }
    
    public function actionSend() {
        $model = new Converter();
        if ($model->checkPath()) {
            $model->calculate($_POST['filepath']);
            $res = $model->dataMenu();
            $mapper = new DishMapper();
            $rez = $mapper->insertToDB($res);
        } else {
            $this->error = "<h1>Вы пытаетесь загрузить файл не с официального сайта!</h1>";
        }
        include_once '..\\src\\layout\\layout.php';
    }

    public function actionOrder() {
        $dishMapper = new DishMapper();
        $dishes = $dishMapper->getConfirmOrder($_POST);
        $arr = $dishes->getDishes();
        if (!empty($arr)) {
            $_SESSION['order'] = $dishes;
        } else {
            $this->error = '<p>Выберите минимум одно блюдо! Для этого необходимо указать число порций!</p>';
            $dishes = $dishMapper->getMenuFromDB();
        }
        include_once '..\\src\\layout\\layout.php';
    }

    public function actionConfirm() {
        $mapper = new DishMapper();
        $dishes = $_SESSION['order'];
        if (!empty($dishes)) {
            $mapper->putOrderIntoDB($dishes);
            $this->message = '<p>Спасибо, ваш заказ обработан и отправлен!</p>';
        } else {
            $this->error = '<p>Выберите блюдо, чтобы отправить заказ!</p>';
        }
        $dishes = $mapper->getMenuFromDB();
        include_once '..\\src\\layout\\layout.php';
    }

    public function checkUser() {
        if ($_SESSION['user_name'] != ADMIN && empty($_POST)) {
            $mapper = new DishMapper();
            $dishes = $mapper->getMenuFromDB();
        }
        include_once '..\\src\\layout\\layout.php';
    }

    public function insertUser() {
        
        $login = trim(strip_tags($_POST['login']));
        $pass = trim(strip_tags($_POST['password']));
        $FIO = trim(strip_tags($_POST['name']));
        $email = trim(strip_tags($_POST['email']));


        $user = new UserMapper;
        $result = $user->check($login, $pass, $FIO, $email);
        if ($result == '') {
            echo $user->insertUser($login, $pass, $FIO, $email);
        } else {
            echo $result;
        }
    }

}
