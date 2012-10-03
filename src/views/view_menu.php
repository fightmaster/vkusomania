<div class="item2">
<div class="menu" id="main"> </div>      
<div class="menu" id="user_roles"> </div>
<div class="menu" id="edit_roles"> </div>
<div class="menu" id="reports"> </div>
<div class="menu" id="exit"> </div>
</div>

<div class="main">
<script>document.getElementById("main").innerHTML ="<a class='exit' href='index.php'>Главная</a>";</script>
<?php
if ($Arr['user_roles'] == 1) {
?>
    <script>document.getElementById("user_roles").innerHTML ="<a class='edit_user' href='index.php?user_roles=1'>Редактирование<br>пользователей</a>";</script>
<?php
}
if ($Arr['edit_roles'] == 1) {
?>
    <script>document.getElementById("edit_roles").innerHTML ="<a class='edit_user' href='index.php?edit_roles=1'>Редактирование<br>ролей</a>";</script>
<?php
}
if ($Arr['reports'] == 1) {
?>
    <script>document.getElementById("reports").innerHTML ="<a class='edit_user' href='index.php?reports=1'>Отчетность</a>";</script>
<?php 
} 
?>
<script>document.getElementById("exit").innerHTML ="<a class='edit_user' href='index.php?exit=1'>Выход</a>";</script>
    
<?php



?>   

</div>