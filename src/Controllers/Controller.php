<?php 
namespace Controllers;

use Models\Model;
use Views\View;
use Mappers\DishMapper;
use Mappers\UserMapper;

class Controller{

	private $error=false;
	private $show=false;

	//запуск контроллера
	function processData()
	{
			if ( !$this->situationCheck() ) {
				include "..\src\Views\ViewAuto.php";
			}
	}
	
	function situationCheck()
	{
			if ( isset($_GET['exit']) && $_GET['exit']==1 ){
				unset($_SESSION['user_name']);
				session_destroy();
				include "..\src\Views\ViewAuto.php";
				return true;
			}
			
			if ($_POST['send']) {	 
				$this->PostSend();
				return true;
			}
			
			if ($_POST['order']) {
				$this->PostOrder();
				return true;
			} 
			
			if ($_POST['confirm']) {
				$this->PostConfirm();
				return true;
			} 
			
			if ( isset($_SESSION['user_name']) ) {
				$this->CheckUser();
				return true;
			} 
			
			if ($_POST['auto']) {
				$this->PostAuto();
				return true;
			} 
			
			return false;
	}
	
	function PostSend()
	{
			$model = new Model;
			if ( $model->CheckPath() ) {
				$model->calculate($_POST['filepath']);
				$res = $model->DataMenu();
				$Mapper = new DishMapper();
				$res = $Mapper->insertToDB($res);		
				if ( $res == true ) {
					include "..\src\Views\ViewAdmin.php";
				} else {
					include "..\src\Views\ViewAfterLoad.php";
				}
			} else {
				$this->error = "<h1>Вы пытаетесь загрузить файл не с официального сайта!</h1>";
				include "..\src\Views\ViewAdmin.php";
			}
	}
	
	function PostOrder()
	{
			$DishMapper = new DishMapper;
			$Dishes = $DishMapper->ConfirmOrder($_POST);
			if (!empty($Dishes)){
				$_SESSION['order'] = $Dishes;
				$_SESSION['mail'] = $mail;
				include "..\src\Views\ViewOrder.php";
			} else {
				$this->error = '<p>Выберите минимум одно блюдо! Для этого необходимо указать число порций!</p>';
				$Dishes = $DishMapper->GetMenuFromDB();
				include "..\src\Views\View.php";
			}
	}
	
	function PostConfirm()
	{
			$Mapper = new DishMapper;
			$Dishes = $_SESSION['order'];
			if (!empty($Dishes)){
				$Mapper->PutOrderIntoDB($Dishes);
				//$Model = new Model;
				//$Model->sendmail( $_SESSION['mail'] );
				//echo $_SESSION['mail'];
				$this->message = '<p>Спасибо, ваш заказ обработан и отправлен!</p>';	
			} else {
				$this->error = '<p>Выберите блюдо, чтобы отправить заказ!</p>';
			}
			$Dishes = $Mapper->GetMenuFromDB();
			include "..\src\Views\View.php";
	}
	
	function CheckUser()
	{
			if ( $_SESSION['user_name']!='admin' ) {
				$Mapper = new DishMapper();
				$Dishes = $Mapper->GetMenuFromDB();
				include "..\src\Views\View.php";	
			} else {
				include "..\src\Views\ViewAdmin.php";
			}
	}
	
	function PostAuto()
	{
			$User = new UserMapper;
			$result = $User->UserAuto($_POST);
			if ( $_SESSION['user_name'] == 'admin' ){//если авторизовавшийся пользователь - админ
				include "..\src\Views\ViewAdmin.php";
			} elseif ($result==true ) {//если обычный пользователь
				$Mapper = new DishMapper();
				$Dishes = $Mapper->GetMenuFromDB();
				include "..\src\Views\View.php";
			} else {// если такого пользователя не существует
				$this->error = '<h1>Пользователь не найден!</h1>';
				include "..\src\Views\ViewAuto.php";
			}
	}
	
} // class Controller
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />