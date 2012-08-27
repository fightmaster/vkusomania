<?php 
namespace Controllers;
use Models\Model;
use Views\View;
use Mappers\DishMapper;
use Mappers\UserMapper;

class Controller{

	private $error=false;
	private $message=false;

	//запуск контроллера
	function processData()
	{
			if ($_POST['send']){//если админ загружает в базу меню //считывание меню из txt, парсинг, запись в базу
				if ( $_SESSION['user_name']='admin' ){
					if ( strrpos( $_POST['filepath'] , 'vkusomania.com/storage/menu.doc'     )   || 
						 strrpos( $_POST['filepath'] , 'vkusomania.com/storage/menu_new.doc' ) ) {  //если загружается с сайта
						 
						$model = new Model;
						$model->calculate($_POST['filepath']);
						$array = $model->GetMenuFromTXT();
						$rez = $model->DataMenu($array);
						$Mapper = new DishMapper();
						$res = $Mapper->insertToDB($rez);
						
						if ( $res == true ){
							include "..\src\Views\ViewAdmin.php";
						} else {
							include "..\src\Views\ViewAfterLoad.php";
						}
						
					} else {// иначе если пытаются загрузить чтото другое
						$this->error = "<h1>Вы пытаетесь загрузить файл не с официального сайта!</h1>";
						include "..\src\Views\ViewAdmin.php";
						unset($_POST['send']);
					}
				}
			} elseif ($_POST['order']) {//если сделали заказ...вывод окна подтверждения
				
				$DishMapper = new DishMapper;
				$Dishes = $DishMapper->ConfirmOrder($_POST);
				if (!empty($Dishes)){
					$_SESSION['order'] = $Dishes;
					include "..\src\Views\ViewOrder.php";
					$_SESSION['mail'] = $mail;
				} else {
					$this->error = '<p>Выберите минимум одно блюдо! Для этого необходимо указать число порций!</p>';
					$Dishes = $DishMapper->GetMenuFromDB();
					include "..\src\Views\View.php";
				}
				
			} elseif ($_POST['confirm']) {//если подтвердили заказ...запись в базу, отправка письма на почту
				
				$Mapper = new DishMapper;
				$Dishes = $_SESSION['order'];
				if (!empty($Dishes)){
					$Mapper->PutOrderIntoDB($Dishes);
					$Model = new Model;
					//$Model->sendmail( $_SESSION['mail'] );
					//echo $_SESSION['mail'];
					$this->message = '<p>Спасибо, ваш заказ обработан и отправлен!</p>';
					
				} else {
					$this->error = '<p>Выберите блюдо, чтобы отправить заказ!</p>';
				}
				$Dishes = $Mapper->GetMenuFromDB();
				include "..\src\Views\View.php";
			
			} elseif ( isset($_GET['exit']) && $_GET['exit']==1 ){//если пользователь вышел
			
				session_destroy();
				include "..\src\Views\ViewAuto.php";	
				
			} elseif ( isset($_GET['query']) && $_GET['query']==1 ){//если пользователь выбрал фильтрацию
			
				$Mapper    = new DishMapper();
				$category  = $Mapper->GetCategoryFromDB();
				$date      = $Mapper->GetDateFromDB();
				include "..\src\Views\ViewQuery.php";	
				
			}elseif ( isset($_GET['category']) || isset($_GET['date']) || isset($_GET['from']) || isset($_GET['to']) ){//если пользователь выбрал фильтрацию
			
				$Mapper    = new DishMapper();
				$Dishes  = $Mapper->SendQueryToDB($_GET);
				include "..\src\Views\View.php";	
				
			}elseif ( isset($_SESSION['user_name']) ) {// если сессия все еще открыта, то есть пользователь не вышел
				
				if ( $_SESSION['user_name']!='admin' ){
				
					$Mapper = new DishMapper();
					$Dishes = $Mapper->GetMenuFromDB();
					include "..\src\Views\View.php";
					
				} else {
					include "..\src\Views\ViewAdmin.php";
				}
				
			} elseif ($_POST['auto']) {//если пользователь авторизовывается
				
				$User = new UserMapper;
				$result = $User->UserAuto($_POST);
				$_POST['auto']=false;
				
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
			} else {// в иных случаях.....выводится окно авторизации
			
				include "..\src\Views\ViewAuto.php";
				
			}
	}
} // class Controller

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />