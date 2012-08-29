<?php

namespace Mappers;

use Dishes\Dish;
use Mappers\Connect;
use Mappers\UserMapper;

class DishMapper
{
    
    public function insertToDB($Dishes)
    {
        $link = Connect::getConnection();
        
        $date = strstr($Dishes[0]->getDate(), ' ');
        $date = trim($date);
        $form = explode('.', $date);
        $date = $form[2] . '-' . $form[1] . '-' . $form[0];

        $query = "SELECT * FROM menu WHERE date= '$date'";
        $cat = mysql_query($query, $link);
        $myrow = mysql_fetch_array($cat);

        if (empty($myrow)) {
            $num = count($Dishes);

            for ($i = 0; $i < $num; $i++) {

                $q = $Dishes[$i]->getCategory();
                $name = $Dishes[$i]->getName();

                $date = strstr($Dishes[$i]->getDate(), ' ');
                $date = trim($date);
                $form = explode('.', $date);
                $date = $form[2] . '-' . $form[1] . '-' . $form[0];

                $portion = $Dishes[$i]->getPortion();
                $cost    = (integer)$Dishes[$i]->getCost();
				
				$query_c = "SELECT `id` FROM `category` WHERE category_name= '$q'";
				$cat = mysql_query($query_c,$link);
				$myrow = mysql_fetch_array($cat);
				
				$query  = "INSERT INTO menu ( name, cat_id, date, portion, cost ) 
						Values ( '$name' , '$myrow[id]' , '$date' , '$portion' , '$cost') ";

                $result = mysql_query($query, $link);
				echo mysql_error();
            }

            return false;
        } else {

            return true;
        }
    }

    public function getCategoryFromDB()
    {

        $link = Connect::getConnection();
        
        $query = "SELECT category_name FROM category";
        $result = mysql_query($query, $link);
        $myrow = mysql_fetch_array($result);

        do {
            $mass[] = $myrow['category_name'];
        } while ($myrow = mysql_fetch_array($result));

        return $mass;
    }

    public function getDateFromDB()
    {
        $link = Connect::getConnection();
       
        $date = date("Y-m-d");
        $query = "select date from menu where date >='$date' GROUP BY date ";
        $result = mysql_query($query, $link);
        $myrow = mysql_fetch_array($result);

        Do {
            $mass[] = $myrow['date'];
        } while ($myrow = mysql_fetch_array($result));
        
        return $mass;
    }

    public function getMenuFromDB()
    {
        $link = Connect::getConnection();

        $date = date("Y-m-d");

        $query = "SELECT menu.*, category.category_name from menu 
            inner join category on menu.cat_id = category.id where menu.date>='$date'  ORDER BY menu.id";

        $result = mysql_query($query);
        $myrow = mysql_fetch_array($result);

        if (!empty($myrow)) {
            do {
                $Dish = new Dish;
                $Dish->setCategory($myrow['category_name']);
                $Dish->setDate($myrow['date']);
                $Dish->setName($myrow['name']);
                $Dish->setPortion($myrow['portion']);
                $Dish->setCost($myrow['cost']);
                $Dish->setID($myrow['id']);
                $Dishes[] = $Dish;
            } while ($myrow = mysql_fetch_array($result));
			
            return $Dishes;
        } else {
		
            return false;
        }
    }

    public function confirmOrder($Arr)
    {
        $link = Connect::getConnection();

        foreach ($Arr as $key => $value) {

            if (!empty($value) && is_numeric($value)) {

                $query = "SELECT menu.*, category.category_name from menu 
					inner join category on menu.cat_id = category.id where menu.id='$key'";
                $result = mysql_query($query, $link);
                $myrow = mysql_fetch_array($result);

                $Dish = new Dish;
                $Dish->setCategory($myrow['category_name']);
                $Dish->setDate($myrow['date']);
                $Dish->setName($myrow['name']);
                $Dish->setPortion($myrow['portion']);
                $Dish->setCost($myrow['cost']);
                $Dish->setID($myrow['id']);
                $Dish->setNumPortions($value);
                $Dishes[] = $Dish;
            }
        }
		
        return $Dishes;
    }

    public function putOrderIntoDB($Dishes)
    {

        $link = Connect::getConnection();

        $iduser = UserMapper::getUserId();
        $now = date("Y-m-d");

        $query  = "insert into `order` (`id_user`, `date`) values ( $iduser, '$now' )";
        $result = mysql_query($query, $link);

        $id_order = mysql_insert_id($link);

        $count = count($Dishes);

        for ($i = 0; $i < $count; $i++) {

            $name = $Dishes[$i]->getName();
            $query = "SELECT id from menu where name='$name'";
            $result = mysql_query($query, $link);
            $myrow = mysql_fetch_assoc($result);

            $id_dish = $myrow['id'];


            $num = $Dishes[$i]->getNumPortions();

            $query = "insert into `order_detail` (`id_order`, `id_dish`, `num`) values ( $id_order, $id_dish, $num )";
            $result = mysql_query($query, $link) or die(mysql_error());
        }
    }

}