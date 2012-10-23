<?php

use Controller\OrderController;
use Dishes\DishCollection;

?>

<script>document.getElementById("exit").innerHTML ="<a class='edit_user' href='index.php?exit=1'>Выход</a>";</script>
<SCRIPT language=JavaScript>
    var num=0;
</SCRIPT>
<?php
if (!empty($dishes) && $this->error == "" && $_POST['order'] && !empty($arr)) {
    ?> 

    <form action='index.php' method='post'>
        <h3>Вы заказали:</h3>

        <table border>

            <tr>
                <td>№</td><td>Наименование:</td><td>Категория:</td><td>Дата:</td><td>Порция</td><td>Цена:</td><td>Кол-во шт:</td>
            </tr>

            <?php
            $i = 1;
            $mail = "Поступил заказ от - $_SESSION[user_name].<br>Состав заказа:<br>";
            $dishes = $dishes->getDishes();
            foreach ($dishes as $dish) {
                ?>

                <tr>
                    <td><?= $i ?></td><td><?= $dish->getName() ?></td><td><?= $dish->getCategory() ?></td><td><?= $dish->getDate() ?></td>
                    <td><?= $dish->getPortion() ?></td><td><?= $dish->getCost() ?></td><td><?= $dish->getNumPortions() ?></td>
                </tr>

                <?php
                $mail .=$dish->getName() . "<br>" . $dish->getCategory() . "<br>" . $dish->getDate() . "<br>" .
                        $dish->getPortion() . "<br>" . $dish->getCost() . "<br>" . $dish->getNumPortions() . "<br>";
                $i++;
                $itog += $dish->getNumPortions() * $dish->getCost();
            }
            $mail .="<br>Заказ на сумму - $itog";
            ?>
        </table>
        <br>
        <p>Вы заказали на сумму - <font style="color:red; font-weight:bold "><?= $itog ?></font> руб.</p>
        <input type='submit' name='confirm' value='Подтвердить заказ'>
    </form>

    <?php
} else {
    if (($dishes != false) || ($_POST['confirm'])) {

        $dishes = $dishes->getDishes();
        $num = count($dishes) - 1;
        $bool = true;

        if ($this->error != '') {
            echo '<h2>' . $this->error . '</h2>';
            $this->error = '';
        }
        if ($this->message != '') {
            echo '<h3>' . $this->message . '</h3>';
            $this->message = '';
        }

        if ($dishes == false) {
            echo '<h2>' . 'В базе отсутствует меню, актуальное на сегодня!' . '</h2>';
            echo '<h3>' . 'Пожалуйста, обратитесь к администратору!' . '</h3>';
        }
        ?>
        <form name="count" action='index.php' method='post'>

        <?php
        for ($i = 0; $i < $num; $i++) {

            if ($dishes[$i]->getDate() != $date) {
                $bool = true;
            }

            $date = $dishes[$i]->getDate();
            $cat = $dishes[$i]->getCategory();

            if ($bool) {
                echo "<h2>" . $dishes[$i]->getDate() . "</h2>";
                $bool = false;
            }
            ?>
                <h3><?= $dishes[$i]->getCategory() ?></h3>

                <table border>

                    <tr>
                        <td>№</td><td>Наименование:</td><td>Дата:</td><td>Категория:</td><td>Порция</td><td>Цена:</td><td>Кол-во шт:</td>
                    </tr>

            <?php
            while (($dishes[$i]->getDate() == $date) && ($dishes[$i]->getCategory() == $cat)) {
                ?>
                        <tr>
                            <td><?= $i + 1 ?></td><td><?= $dishes[$i]->getName() ?></td><td><?= $date ?></td>
                            <td><?= $cat ?></td><td><?= $dishes[$i]->getPortion() ?></td><td><?= $dishes[$i]->getCost() . ' руб.' ?></td>
                            <td id="inp"><input id="val" name='<?= 'a' . $dishes[$i]->getId() ?>' size=2 value='0'><input id="btn" type="button" value="+" onClick = "num=this.form.<?= 'a' . $dishes[$i]->getId() ?>.value;this.form.<?= 'a' . $dishes[$i]->getId() ?>.value=(++num);" ><input id="btn" type="button" value="-" onClick = "num=this.form.<?= 'a' . $dishes[$i]->getId() ?>.value;if(num>0){this.form.<?= 'a' . $dishes[$i]->getId() ?>.value=(--num)};"></td>
                        </tr>
                <?php
                if ($i < $num) {
                    $i++;
                } else {
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
            <?php
        } else {
            ?>    
        <h2>К сожалению меню не может быть сформированно!</h2>
        <p>В базе данных отсутсвуют актуальные данные на сегодня.</p>
        <p>Пожалуйста обратитесь к администратору!</p>
        <?php
    }
} 
