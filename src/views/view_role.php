<?php
if ($userRoles['user_roles'] == 1 && $_GET['user_roles'] == 1) {
    echo "<h2>Редактор пользователей</h2>"; 
    
    ?>

    <form action="index.php?insert_user=1" method="POST">
    <table border>
    <tr>
    <td>Логин:</td><td>Имя:</td><td>Фамилия:</td><td>Email:</td><td>Роль:</td>
    </tr>
    <?php
    foreach ($users as $user) {
        ?>
        <form action="index.php?user_roles=1" method="POST">
                <tr>
                    <td><?=$user->getLogin()?></td>
                    <td><a href="index.php?user_edit=1&<?=$user->getId()?>"><?=$user->getName()?></td>
                    <td><?=$user->getSurname()?></td>
                    <td><?=$user->getEmail()?></td> 
                    <td><select size="1" name="role">
                        <?php foreach ($roles as $role) {if ( $role[role_name] == $user->getRole() ) {echo "<option selected value=".$user->getId()."|".$role[id].">$role[role_name]</option>";} 
                                                         else { echo "<option value=".$user->getId()."|".$role[id].">$role[role_name]</option>";} } ?>
                        </select></td>
                    <td><input type='submit' name="input_role" value="Переназначить роль"></td>
               </tr>
        </form> 
        <?php
    }

    ?>
    
    </table>
    <input type='submit' id="input_role" name='new_user' value="Добавить нового пользователя"><br><br>
    </form> 

    <?php
    
}

if ($userRoles['edit_roles'] == 1 && $_GET['edit_roles'] == 1) {  
    
    echo "<h2>Редактор ролей</h2>";  
    
    if ($rez != '' ) {
        echo "<h2>$rez</h2>"; 
        if ( $_POST['save_role'] ) {
            unset($_POST['save_role']);
            $_GET['id_role'] = $_POST['id_role'];
        } else if ( $_POST['insert_role'] ) {
            unset($_POST['insert_role']);
            $_POST['input_role'] = true;
        }
    }
    
    
    if ( $_POST['input_role'] ) {
        
        ?>
        <h3>Новая запись</h3><br>
        <form action='index.php?edit_roles=1' method="POST">
        <h3>Имя роли:</h3><br>
        <input type="text"     name="role_name"  value=""><br><hr>
        <h3>Доступ к заказам:</h3><br>
        <input type="checkbox" name="orders"     value='1' ><br><hr>
        <h3>Доступ к администраторской зоне:</h3><br>
        <input type="checkbox" name="admin"      value='1' ><br><hr>
        <h3>Доступ к редактированию и добавлению ролей:</h3><br>
        <input type="checkbox" name="edit_roles" value='1' ><br><hr>
        <h3>Доступ к назначению ролей пользователям:</h3><br>
        <input type="checkbox" name="user_roles" value='1' ><br><hr>
        <h3>Доступ к просмотру отчета:</h3><br>
        <input type="checkbox" name="reports"    value='1' ><br><hr><br>
        
        <input type='submit' id="input_role" name='insert_role' value="Сохранить">
        </form>
        <?php
        
    } else if ( ( !empty($massive) || ($_POST['save_role']) ) && $rez == "" ) {
        ?>
        <form action='index.php?edit_roles=1' method="POST">
        <table border>
        <tr>
        <td>Роль:</td><td>Доступ к заказам:</td><td>Доступ к админке:</td><td>Редак-ние ролей:</td><td>Редак-ние пользователей:</td><td>Отчетность:</td>
        </tr>
        <?php
        
        foreach ($massive as $line) {
                ?>
                <tr><td><?=$line['role_name']?></td>
                      <td><input type="checkbox" name="option1" <?php if ($line['orders']     == 1) echo "checked"?> disabled></td>
                      <td><input type="checkbox" name="option1" <?php if ($line['admin']      == 1) echo "checked"?> disabled></td>
                      <td><input type="checkbox" name="option1" <?php if ($line['edit_roles'] == 1) echo "checked"?> disabled></td>
                      <td><input type="checkbox" name="option1" <?php if ($line['user_roles'] == 1) echo "checked"?> disabled></td>
                      <td><input type="checkbox" name="option1" <?php if ($line['reports'] == 1) echo "checked"?> disabled></td>
                      <td><a href=<?="index.php?edit_roles=1&id_role=".$line['id']?> >Изменить</a></td>
                      <td><a href=<?="index.php?edit_roles=1&del=1&del_role=".$line['id']?> >Удалить</a></td>
                </tr>
                <?php
        }
        
        ?>
        </table>
        <input type='submit' id="input_role" name='input_role' value="Добавить роль">
        </form>
        <?php
        
    } else if ( isset($_GET['id_role']) && is_numeric($_GET['id_role']) ) {
        ?>
        <h3>Редактирование записи</h3><br>
        <form action="index.php?edit_roles=1" method="POST">
            
        <h3>Имя роли:</h3><br>
        <input type="text" name="role_name" value="<?=$mass['role_name']?>"><br><hr>
        <h3>Доступ к заказам:</h3><br>
        <input type="checkbox" name="orders" <?php if ($mass['orders']     == 1) echo "checked"?>     value='1' ><br><hr>
        <h3>Доступ к администраторской зоне:</h3><br>
        <input type="checkbox" name="admin" <?php if ($mass['admin']      == 1) echo "checked"?>      value='1' ><br><hr>
        <h3>Доступ к редактированию и добавлению ролей:</h3><br>
        <input type="checkbox" name="edit_roles" <?php if ($mass['edit_roles'] == 1) echo "checked"?> value='1' ><br><hr>
        <h3>Доступ к назначению ролей пользователям:</h3><br>
        <input type="checkbox" name="user_roles" <?php if ($mass['user_roles'] == 1) echo "checked"?> value='1' ><br><hr>
        <h3>Доступ к просмотру отчета:</h3><br>
        <input type="checkbox" name="reports" <?php if ($mass['reports'] == 1) echo "checked"?>       value='1' ><br><hr><br>
        <input type="hidden" name="id_role" value='<?=$_GET['id_role']?>' >
        
        <input type='submit' id="input_role" name='save_role' value="Сохранить">
        
        <?php
        
    }
    
    
}

if ($userRoles['reports'] == 1 && $_GET['reports'] == 1) {
    echo "<h2>Отчет</h2>"; 
}