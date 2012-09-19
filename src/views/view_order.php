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
    $dishes = $dishes->getDishes();
	foreach ($dishes as $dish){
		
	?>
	
    <tr>
    <td><?=$i?></td><td><?=$dish->getName()?></td><td><?=$dish->getCategory()?></td><td><?=$dish->getDate()?></td>
	<td><?=$dish->getPortion()?></td><td><?=$dish->getCost()?></td><td><?=$dish->getNumPortions()?></td>
    </tr>
	
	<?php
	$mail .=$dish->getName()."<br>".$dish->getCategory()."<br>".$dish->getDate()."<br>".
			$dish->getPortion()."<br>".$dish->getCost()."<br>".$dish->getNumPortions()."<br>";
	$i++;
	$itog +=  $dish->getNumPortions() * $dish->getCost();
	}
	$mail .="<br>Заказ на сумму - $itog";
	?>
</table>
<br>
<p>Вы заказали на сумму - <font style="color:red; font-weight:bold "><?=$itog?></font> руб.</p>
<input type='submit' name='confirm' value='Подтвердить заказ'>
</form>