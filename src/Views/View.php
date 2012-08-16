<?php
namespace Views;
class View {
 
	static function displayMenu($str) 
	{
            echo $str;
	}
	
	static function buttonsView()
	{
            echo "<script> document.getElementById('comment').style.display = 'none'; </script>";
			echo "<button class='add_comment' onclick=\"refresh()\" >Обновить</button>";
	}
	
	static function displayFormMenu($str) 
	{
			if ($str == false){
				echo "<h2>Данный вариант меню устарел!</h2><br>Попросите администратора обновить меню!";
			} else {
				echo "<form method='POST' action='index.php' >\r\n";
				echo "Введите ФИО:<br>";
				echo "<input type='text' name='FIO' value=''><br>\r\n";
				echo $str;
			}
	}
	
	static function getOrder($doubleMass,$message) 
	{
			echo 'Уважаемый '.$doubleMass[person][0].'!<br><br>';
            echo 'Вы заказали:<br><br>';
			echo '<table border>';
			echo '<tr><td>Дата:</td><td>Категория:</td><td>№</td>'
				.'<td>Наименование:</td><td>Кол-во</td><td>Цена:</td>'
				.'<td>Кол-во шт.:</td></tr>';
				
			for ($i=1;$i<=count($doubleMass)-2;$i++){
				
				echo '<tr>';
				for ($j=0;$j<7;$j++){
				    echo '<td>'.$doubleMass[$i][$j].'</td>';
				}
				echo '</tr>';	
			}
			
			echo '</table>';
			echo "<br>Итого: ".$doubleMass[itog][0].' руб.';
			echo "<form method='POST' action='index.php' ><br>";
			echo "<input type='submit' name='confirm' value='Подтвердить'>";
			echo "<input type='hidden' name='zakaz' value='$message'>";
            echo "</form>";
	}
 

	static function displayError($error) 
	{
            echo "<b>Ошибка:</b> {$error}<br>";
	}
	
	static function Send() 
	{
            echo "<b>Спасибо!</b><br>";
			echo "<b>Ваш заказ отправлен.</b><br><br>";
	}

 
	
 
} // class VIEW
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />