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


<?php  
$Dishes = $Dishes->getDishes();
$num = count($Dishes) - 1;
$bool = true;

if(session_id() != '' && isset($_SESSION['user_name']) ) { 
?>
<script>document.getElementById("exit").innerHTML ="<a class='exit' href='index.php?exit=1'>Выход</a>";</script>
<?php 
} 
?>
<h1>ФИО пользователя - <?= $_SESSION['user_name']?></h1>
<?php
if ($this->error!='') {
	echo '<h2>'.$this->error.'</h2>';
	$this->error = '';
}
if ($this->message!='') {
	echo '<h3>'.$this->message.'</h3>';
	$this->message = '';
}

if ( $Dishes == false ) {
	echo '<h2>'.'В базе отсутствует меню, актуальное на сегодня!'.'</h2>';
	echo '<h3>'.'Пожалуйста, обратитесь к администратору!'.'</h3>';
}
?>
<form action='index.php' method='post'>

<?php
for ($i = 0; $i < $num; $i++) {
    
    if ($Dishes[$i]->getDate() != $date){
        $bool = true;
    }

    $date = $Dishes[$i]->getDate();
    $cat  = $Dishes[$i]->getCategory();
    
    if ($bool){
        echo "<h2>".$Dishes[$i]->getDate()."</h2>";
        $bool = false;
    }
    ?>
    <h3><?=$Dishes[$i]->getCategory()?></h3>
    
    <table border>
    
    <tr>
    <td>№</td><td>Наименование:</td><td>Дата:</td><td>Категория:</td><td>Порция</td><td>Цена:</td><td>Кол-во шт:</td>
    </tr>
    
    <?php
            while ( ($Dishes[$i]->getDate() == $date) && ($Dishes[$i]->getCategory() == $cat) ) {
                    ?>
                    <tr>
                    <td><?=$i+1?></td><td><?=$Dishes[$i]->getName()?></td><td><?=$date?></td>
                    <td><?=$cat?></td><td><?=$Dishes[$i]->getPortion()?></td><td><?=$Dishes[$i]->getCost()?></td><td><input name='<?=$Dishes[$i]->getID()?>' size=5></td>
                    </tr>
                    <?php
                    if ($i<$num){
                        $i++;
                    }else{
                        break 2;
                    }
            }
            $i--;
    
    ?>
    
    </table>
    
    <?php
}
?>
</table>
<input type='submit' name='order' value='Заказать' class='add_comment' >
</form>
        </div>

    </body>
</html>