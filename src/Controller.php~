<?php

class Controller {
 
private $error;
 
private $result;

private $loadClass;

 
#конструктор 
function __construct() {
 
$this->error = false;
 
$this->result = false;

$this->loadClass = new SplClassLoader();
 
}

 
#запуск контроллера
function processData() {
 
$this->userRequest();
 
$this->loadClass->loadClass(View);

if ($this->error!="")
 
View::displayError($this->error);
 
else
 
if ($this->result)
 
View::displayResults($this->result);
 
else
 
View::displayDefault();
 
}


#работа с классом MODEL 
function userRequest() {
 
// данные отправлены

if (isset($_POST['send'])) {
$this->validate();

if (!$this->error) {
 
// основные вычислени€
 
$this->loadClass->loadClass(Model);

$model = new Model();
 
$model->calculate("c:/menu.doc");
 
$result = $model->getData();
 
// проверка на ошибки в самой модели
 
 
$this->result = $result;
 
}
 
}
}
 

# проверка
function validate() {
 
if (empty($_POST['filepath']))
 
$this->error = 'Ќе введено им€!';
 
 
}
 
} // class Controller

?>
