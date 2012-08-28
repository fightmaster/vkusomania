<?php
namespace Mappers;
use Dishes\Dish;
class DishMapper{

	function insertToDB($Dishes){

			$mysql_host = 'localhost';
			$mysql_user = 'root';
			$mysql_password = '123456';
			$my_database = 'vkusomania';
			
			$link = mysql_connect($mysql_host, $mysql_user, $mysql_password);
			mysql_select_db($my_database);
			
			$date =strstr($Dishes[0]->getDate(),' ');
			$date = trim($date);
			$form = explode ( '.', $date );
			$date = $form[2].'-'.$form[1].'-'.$form[0];
			
			$query = "SELECT * FROM menu WHERE date= '$date'";
			$cat = mysql_query($query,$link);
			$myrow = mysql_fetch_array($cat);
			
			if ( empty($myrow) ){
				$num = count($Dishes);
				
				for($i=0;$i<$num;$i++){
				
					$q = $Dishes[$i]->getCategory();
					$name = $Dishes[$i]->getName();
					
					//форматирование даты
					$date =strstr($Dishes[$i]->getDate(),' ');
					$date = trim($date);
					$form = explode ( '.', $date );
					$date = $form[2].'-'.$form[1].'-'.$form[0];
					
					$portion = $Dishes[$i]->getPortion();
					$cost =(integer)$Dishes[$i]->getCost();
					$query_c = "SELECT id FROM category WHERE category_name= '$q'";
					$cat = mysql_query($query_c,$link);
					$myrow = mysql_fetch_array($cat);

					$query  = "INSERT INTO menu ( name, cat_id, date, portion, cost ) 
							   Values ( '$name' , '$myrow[id]' , '$date' , '$portion' , '$cost') ";
					
					$result = mysql_query($query,$link);

				}
				mysql_close($link);
				return false;
				
			} else {
				mysql_close($link);
				return true;
			}
	}	
	
	function GetCategoryFromDB(){
		
			$mysql_host = 'localhost';
			$mysql_user = 'root';
			$mysql_password = '123456';
			$my_database = 'vkusomania';
			$link = mysql_connect($mysql_host, $mysql_user, $mysql_password);
			mysql_select_db($my_database);
			$query = "SELECT category_name FROM category";
			$result = mysql_query($query,$link);
			$myrow = mysql_fetch_array($result);
			
			Do
			{
				$mass[] =  $myrow['category_name'];
			}
			while ($myrow=mysql_fetch_array($result));
			
			mysql_close($link);
			return $mass;
	}
	
	function GetDateFromDB(){
		
			$mysql_host = 'localhost';
			$mysql_user = 'root';
			$mysql_password = '123456';
			$my_database = 'vkusomania';
			$link = mysql_connect($mysql_host, $mysql_user, $mysql_password);
			mysql_select_db($my_database);
			$date = date("Y-m-d");
			$query = "select date from menu where date >='$date' GROUP BY date ";
			$result = mysql_query($query,$link);
			$myrow = mysql_fetch_array($result);
			
			Do
			{
				$mass[] =  $myrow['date'];
			}
			while ($myrow=mysql_fetch_array($result));
			
			mysql_close($link);
			return $mass;
	}
	
	function GetMenuFromDB(){
		
			$mysql_host = 'localhost';
			$mysql_user = 'root';
			$mysql_password = '123456';
			$my_database = 'vkusomania';
			$link = mysql_connect($mysql_host, $mysql_user, $mysql_password);
			mysql_select_db($my_database);
			
			$date = date("Y-m-d");
			
			$query = "SELECT menu.*, category.category_name from menu 
			inner join category on menu.cat_id = category.id where menu.date>='$date'  ORDER BY menu.id";
			
			$result = mysql_query($query,$link);
			$myrow = mysql_fetch_array($result);
			
			if ( !empty($myrow) ) {
				Do
				{
					$Dish = new Dish;
					$Dish->setCategory($myrow['category_name']);
					$Dish->setDate($myrow['date']);
					$Dish->setName($myrow['name']);
					$Dish->setPortion($myrow['portion']);
					$Dish->setCost($myrow['cost']);
					$Dish->setID($myrow['id']);
					$Dishes[]=$Dish;
				}
				while ($myrow = mysql_fetch_array($result));
				
				mysql_close($link);
				return $Dishes;
				
			} else {
				return false;
			}
	}
	
	function ConfirmOrder($Arr){
		
			$mysql_host = 'localhost';
			$mysql_user = 'root';
			$mysql_password = '123456';
			$my_database = 'vkusomania';
			$link = mysql_connect($mysql_host, $mysql_user, $mysql_password);
			mysql_select_db($my_database);
			
			foreach ($Arr as $key=>$value){
			
				if ( !empty($value) && is_numeric($value) ){
				
					$query = "SELECT menu.*, category.category_name from menu 
					inner join category on menu.cat_id = category.id where menu.id='$key'";
					$result = mysql_query($query,$link);
					$myrow = mysql_fetch_array($result);
					
					$Dish = new Dish;
					$Dish->setCategory($myrow['category_name']);
					$Dish->setDate($myrow['date']);
					$Dish->setName($myrow['name']);
					$Dish->setPortion($myrow['portion']);
					$Dish->setCost($myrow['cost']);
					$Dish->setID($myrow['id']);
					$Dish->setNumPortions($value);
					$Dishes[]=$Dish;
				} 	
			}
			
			mysql_close($link);

			return $Dishes;
	}
	
	function PutOrderIntoDB($Dishes){
			
			$mysql_host = 'localhost';
			$mysql_user = 'root';
			$mysql_password = '123456';
			$my_database = 'vkusomania';
			
			$link = mysql_connect($mysql_host, $mysql_user, $mysql_password);
			mysql_select_db($my_database);

			$query_u = "SELECT id FROM user WHERE FIO= '$_SESSION[user_name]'";
			$user = mysql_query($query_u,$link);
			
			$myrow = mysql_fetch_assoc($user);
			$iduser = (integer)$myrow['id'];
			$now = (string)date("Y-m-d");
			
			$query  = "insert into `order` (`id_user`, `date`) values ( $iduser, '$now' )";
			$result = mysql_query($query,$link);
			
			$id_order = mysql_insert_id($link);
			
			$count = count($Dishes);
			
			for($i=0;$i<$count;$i++){
			
					$name = $Dishes[$i]->getName();
					$query = "SELECT id from menu where name='$name'";
					$result = mysql_query($query,$link);
					$myrow = mysql_fetch_assoc($result);
					
					$id_dish = $myrow['id'];

					
					$num = $Dishes[$i]->getNumPortions();
										
					$query  = "insert into `order_detail` (`id_order`, `id_dish`, `num`) values ( $id_order, $id_dish, $num )";
					$result = mysql_query($query,$link) or die(mysql_error());
			}
			
			mysql_close($link);
	}
	
	function SendQueryToDB($Arr){
			
			$cat  = strip_tags(trim($Arr['category']));
			$date = strip_tags(trim($Arr['date']));
			$from = (integer)strip_tags(trim($Arr['from']));
			$to = (integer)strip_tags(trim($Arr['to']));
			
			$mysql_host = 'localhost';
			$mysql_user = 'root';
			$mysql_password = '123456';
			$my_database = 'vkusomania';
			$link = mysql_connect($mysql_host, $mysql_user, $mysql_password);
			mysql_select_db($my_database);
			
			if ($cat != ''){
				$query  = " SELECT category_name from category where category_name='$cat' ";
				$result = mysql_query($query,$link);
				$myrow  = mysql_fetch_array($result);
				if ( empty($myrow) ){return '”казанной категории не существует!';}
			} elseif($cat==''){
				$cat = '*';
			}
			
			if ($date != ''){
				$query  = " SELECT date from menu where date='$date' ";
				$result = mysql_query($query,$link);
				$myrow  = mysql_fetch_array($result);
				if ( empty($myrow) ){return '”казанной даты не существует!';}
			} elseif ($date==''){
				$date = '*';
			}
			
			if ($from==''){$from='*';}
			if ($to==''){$to='*';}
			
			$query =    "SELECT menu.*, category.category_name from menu 
						inner join category on menu.cat_id = category.id 
						where menu.date = '$date' and 
						category.category_name = '$cat' and
						menu.cost > '$from' and 
						menu.cost < '$to'
						ORDER BY menu.id";
			
			$result = mysql_query($query,$link);
			$myrow  = mysql_fetch_array($result);
			
			if ( !empty($myrow) ) {
				Do
				{
					$Dish = new Dish;
					$Dish->setCategory($myrow['category_name']);
					$Dish->setDate($myrow['date']);
					$Dish->setName($myrow['name']);
					$Dish->setPortion($myrow['portion']);
					$Dish->setCost($myrow['cost']);
					$Dish->setID($myrow['id']);
					$Dishes[]=$Dish;
				}
				while ($myrow = mysql_fetch_array($result));
				
				mysql_close($link);
				return $Dishes;
				
			} else {
				return false;
			}
	}
}
?>
