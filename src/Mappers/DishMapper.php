<?php

namespace Mappers;

use Dishes\Dish;
use Dishes\DishCollection;

class DishMapper 
{

    public function insertToDB($dishes)
    {
        $dishes = $dishes->getDishes();
        $link = Connect::getConnection();

        ///////////////////////////////////////////////// проверка по дате
        $date = $this->formatDate($dishes[0]->getDate());
        $query = "SELECT * FROM menu WHERE date= '$date'";
        $cat = mysql_query($query, $link);
        $myrow = mysql_fetch_array($cat);
        //////////////////////////////////////////////////////////////////

        if (empty($myrow)) { 
            $num = count($dishes);

            for ($i = 0; $i < $num; $i++) {
                
                $q = $dishes[$i]->getCategory();
                $name = $dishes[$i]->getName();
                
                $date = $this->formatDate($dishes[$i]->getDate());
                $portion = $dishes[$i]->getPortion();
                $cost = (integer) $dishes[$i]->getCost();

                $query = "INSERT INTO menu ( cat_id, name, date, portion, cost ) 
                          SELECT `id`, '$name' , '$date' , '$portion' , '$cost' 
                          FROM `category` WHERE category_name= '$q' ";

                $result = mysql_query($query, $link);
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
        while ($myrow = mysql_fetch_assoc($result)) {
            $mass[] = $myrow['category_name'];
        }

        return $mass;
    }

    public function getDateFromDB()
    {
        $link = Connect::getConnection();
        $date = date("Y-m-d");
        $query = "select date from menu where date >='$date' GROUP BY date ";
        $result = mysql_query($query, $link);

        while ($myrow = mysql_fetch_array($result)) {
            $mass[] = $myrow['date'];
        }

        return $mass;
    }
    
    public function getMenuFromDB()
    {
        $link = Connect::getConnection();
        $date = date("Y-m-d");
        $query = "SELECT menu.*, category.category_name from menu 
                  inner join category on menu.cat_id = category.id where menu.date >= '$date' ORDER BY menu.id";
        $result = mysql_query($query);
        $num_rows = mysql_num_rows($result);
        if ($num_rows == 0) {
            return false;
        }

        $dishes = new DishCollection();
        while ($myrow = mysql_fetch_array($result)) {
            $dish = new Dish;
            $dish->setCategory($myrow['category_name']);
            $dish->setDate($myrow['date']);
            $dish->setName($myrow['name']);
            $dish->setPortion($myrow['portion']);
            $dish->setCost($myrow['cost']);
            $dish->setID($myrow['id']);
            $dishes->add($dish);
        }

        return $dishes;
    }

    public function getConfirmOrder($arr)
    {
        $link = Connect::getConnection();
        $dishes = new DishCollection();
        /////////////////////////////////////// формируем строку для вставки в запрос после IN
        $str = "";
        foreach ($arr as $key => $value) {
            if ($value != 0) {
                $key = substr($key, 1);
                $str .= $key . ",";     
            }
        }
        
        $str = substr( $str, 0, strlen($str)-1 );
        $query = "SELECT menu.*, category.category_name from menu 
                  inner join category on menu.cat_id = category.id where menu.id in ($str)";
        $result = mysql_query($query, $link);
        foreach ($arr as $key => $value) {

            if (!empty($value) && is_numeric($value)) {
                $myrow = mysql_fetch_array($result);
                $dish = new Dish;
                $dish->setCategory($myrow['category_name']);
                $dish->setDate($myrow['date']);
                $dish->setName($myrow['name']);
                $dish->setPortion($myrow['portion']);
                $dish->setCost($myrow['cost']);
                $dish->setId($myrow['id']);
                $dish->setNumPortions($value);
                $dishes->add($dish);
            }
        }

        return $dishes;
    }

    public function putOrderIntoDB($dishes)
    {
        $dishes = $dishes->getDishes();
        $link = Connect::getConnection();

        $iduser = UserMapper::getUserId();
        $now = date("Y-m-d");

        $query = "insert into `order` (`id_user`, `date`) values ( $iduser, '$now' )";
        $result = mysql_query($query, $link);

        $id_Order = mysql_insert_id($link);

        $count = count($dishes);

        for ($i = 0; $i < $count; $i++) {

            $name = $dishes[$i]->getName();
            $date = $dishes[$i]->getDate();
            $num = $dishes[$i]->getNumPortions();

            $query = "insert into `order_detail` (`id_dish`, `id_order`, `num`) 
                      SELECT id, $id_Order, $num  from menu where name='$name' and date='$date'";
            $result = mysql_query($query, $link);
        }
    }

    private function formatDate($date)
    {
        $date = strstr($date, ' ');
        $result = strstr($date, ' ');
        $result = trim($result);
        $form = explode('.', $result);
        $result = $form[2] . '-' . $form[1] . '-' . $form[0];
        
        return $result;
    }

}
