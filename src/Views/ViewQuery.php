<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<script>document.getElementById("exit").innerHTML ="<a class='exit' href='index.php?exit=1'>Выход</a>";</script>

<div class="auto">
<form method='get' action='index.php' >
Выберите категорию блюд:
<br>
<select name="category">
<?php
foreach ($category as $cat){
echo "<option value='".$cat."'>".$cat."</option>";
}
?>
</select>
<br>
<br>
Выберите дату:
<select name="date">
<?php
foreach ($date as $d){
echo "<option value='".$d."'>".$d."</option>";
}
?>
</select>

<br>
<br>
Цена (руб.) в диапазоне от:
<INPUT name='from' size="5"> 
до:
<INPUT name='to' size="5"> 
<br>
<br>
<INPUT type='submit' size="10"> 
</form>
</div>