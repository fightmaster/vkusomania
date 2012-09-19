<?php
$dishes = $dishes->getDishes();
$num = count($dishes) - 1;
$bool = true;

if(session_id() != '' && isset($_SESSION['user_name']) ) { 
?>
<script>document.getElementById("exit").innerHTML ="<a class='exit' href='index.php?exit=1'>Выход</a>";</script>
<?php 
} 
?>
<h1>ФИО пользователя - <?= $_SESSION['user_name']?></h1>

<SCRIPT language=JavaScript>
 var num=0;
</SCRIPT>

<?php
if ($this->error!='') {
	echo '<h2>'.$this->error.'</h2>';
	$this->error = '';
}
if ($this->message!='') {
	echo '<h3>'.$this->message.'</h3>';
	$this->message = '';
}

if ( $dishes == false ) {
	echo '<h2>'.'В базе отсутствует меню, актуальное на сегодня!'.'</h2>';
	echo '<h3>'.'Пожалуйста, обратитесь к администратору!'.'</h3>';
}
?>
<form name="count" action='index.php' method='post'>

<?php
for ($i = 0; $i < $num; $i++) {
    
    if ($dishes[$i]->getDate() != $date){
        $bool = true;
    }

    $date = $dishes[$i]->getDate();
    $cat  = $dishes[$i]->getCategory();
    
    if ($bool){
        echo "<h2>".$dishes[$i]->getDate()."</h2>";
        $bool = false;
    }
    ?>
    <h3><?=$dishes[$i]->getCategory()?></h3>
    
    <table border>
    
    <tr>
    <td>№</td><td>Наименование:</td><td>Дата:</td><td>Категория:</td><td>Порция</td><td>Цена:</td><td>Кол-во шт:</td>
    </tr>
    
    <?php
            while ( ($dishes[$i]->getDate() == $date) && ($dishes[$i]->getCategory() == $cat) ) {
                    ?>
                    <tr>
                    <td><?=$i+1?></td><td><?=$dishes[$i]->getName()?></td><td><?=$date?></td>
                    <td><?=$cat?></td><td><?=$dishes[$i]->getPortion()?></td><td><?=$dishes[$i]->getCost().' руб.'?></td>
                    <td id="inp"><input id="val" name='<?='a'.$dishes[$i]->getId()?>' size=5 value='0''><input id="btn" type="button" value="+" onClick = "num=this.form.<?='a'.$dishes[$i]->getId()?>.value;this.form.<?='a'.$dishes[$i]->getId()?>.value=(++num);" ><input id="btn" type="button" value="-" onClick = "num=this.form.<?='a'.$dishes[$i]->getId()?>.value;if(num>0){this.form.<?='a'.$dishes[$i]->getId()?>.value=(--num)};"></td>
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