<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'> 
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Заказ еды</title>
        <link rel="stylesheet" type="text/css" href="../template/css/style.css">
        <link rel="stylesheet" type="text/css" href="../template/css/jquery.confirm.css" />
    </head>
    <body>

        <script src="../vendor/js/jquery.min.js"></script>
        <script src="../js/jquery.confirm.js"></script>
        <script src="../js/script.js"></script>


        <div class="item">
            <div class="exit" id="exit"> </div>
            <div class="exit" id="query"> </div>
        </div>	

        <div class="main">
<script>document.getElementById("exit").innerHTML ="<a class='exit' href='index.php?exit=1'>Выход</a>";</script>
<h1>ФИО пользователя - <?= $_SESSION['user_name'] ?></h1>
<form action='index.php' method='post'>
<h3>Вы заказали:</h3>

<table border>

    <tr>
    <td>№</td><td>Наименование:</td><td>Категория:</td><td>Дата:</td><td>Порция</td><td>Цена:</td><td>Кол-во шт:</td>
    </tr>
	
	<?php
	$i=1;
	$mail = "Поступил заказ от - $_SESSION[user_name].<br>Состав заказа:<br>";
    $Dishes = $Dishes->getDishes();
	foreach ($Dishes as $Dish){
		
	?>
	
    <tr>
    <td><?=$i?></td><td><?=$Dish->getName()?></td><td><?=$Dish->getCategory()?></td><td><?=$Dish->getDate()?></td>
	<td><?=$Dish->getPortion()?></td><td><?=$Dish->getCost()?></td><td><?=$Dish->getNumPortions()?></td>
    </tr>
	
	<?php
	$mail .=$Dish->getName()."<br>".$Dish->getCategory()."<br>".$Dish->getDate()."<br>".
			$Dish->getPortion()."<br>".$Dish->getCost()."<br>".$Dish->getNumPortions()."<br>";
	$i++;
	$itog +=  $Dish->getNumPortions() * $Dish->getCost();
	}
	$mail .="<br>Заказ на сумму - $itog";
	?>
</table>
<br>
<p>Вы заказали на сумму - <font style="color:red; font-weight:bold "><?=$itog?></font> руб.</p>
<input type='submit' name='confirm' value='Подтвердить заказ'>
</form>
</div>

    </body>
</html>