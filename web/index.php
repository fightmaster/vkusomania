<META http-equiv=Content-Type content="text/html; charset=UTF-8">

<?php

require("../src/SplClassLoader.php");

# загрузка классов
$loader = new SplClassLoader();
$loader->loadClass(Controller);



# запуск контроллера
$controller = new Controller();
$controller->processData();

?>


