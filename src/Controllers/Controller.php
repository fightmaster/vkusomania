<?php 
namespace src\Controllers;
use src\Models\Model;
use src\Views\View;

class Controller{

	private $error=false;
	private $result=false;
    private $massD;
	private $email;
	 
	#запуск контроллера
	function processData()
	{
			$this->userRequest();
			if ($this->error!="") {
				View::displayError($this->error); 
			} elseif ($this->result) { 
				View::displayResults($this->result);
			} elseif ( $this->massD && $this->email ) {
				View::getOrder($this->massD,$this->email);
			} elseif (!isset($_POST['send']) && !isset($_POST['order']) && !isset($_POST['confirm']) ) {
				View::displayDefault();
			} 
		
	}

	function userRequest() 
	{
			if (isset($_POST['send'])){
				$this->validate();
				if (!$this->error) {
					$model = new Model();
					$model->calculate($_POST['filepath']);
					$result = $model->getData();
					$this->result = $result;
				} 
			}
				
			if (isset($_POST['order'])){
				$bool = $this->checkout();
				if ( $bool == true ){
						$model = new Model();
						$model->orderDetail($_POST);
						$doubleMass = $model->getDoubleMass();
						$this->massD =$doubleMass;
						$message    = $model->getMail();
						$this->email = $message;
				}				
			}
				
			if (isset ($_POST['confirm'])){
				$model = new Model();
				$model->sendMail($_POST['zakaz']);
				View::Send();
			}
	}
		
	function checkout()
	{
			$it=(count($_POST)-2)/2;
			$check = false;

			for ($i=1; $i<=$it; $i++){
			
				if ( !empty($_POST[$i]) ){
					$check = true;
					if ( !preg_match( "/^[0-9]{1,2}+$/", $_POST[$i] ) ){
						$this->error .=" ".$_POST[$i]."-данное значение не является корректным. Введите число, состоящее из одной или двух цифр!<br>";
					}	
				}	
			}
			
			if ($check == false){
				$this->error = "Вы не выбрали ни одно блюдо из меню!<br>";
			}
					
			if (!preg_match( "/^[А-Яа-я]{3,}+$/", $_POST['FIO'] )){
				$this->error .= "Поле с ФИО заказчика введено не корректно. Повторите попытку!<br>";
			}

			if (empty($_POST['FIO'])){
				$this->error .= "Вы не указали ФИО заказчика!<br>";
			}
				
			if ( ($check == true) && (!empty($_POST['FIO'])) ){
				return true;
			} else {
				return false;
			}
	}
		# проверка
	function validate() 
	{	 
			if (isset($_POST['send']) && empty($_POST['filepath'])) {
				$this->error = 'Не введен путь к файлу!';
			}
	}
	 
} // class Controller

?>
