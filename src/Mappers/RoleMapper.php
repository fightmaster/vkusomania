<?php

namespace Mappers;

class RoleMapper
{
    
    public function getRoles()
    {
        $link = Connect::getConnection();

        $query = "SELECT * FROM roles";
        mysql_query('SET NAMES utf8', $link);
        $result = mysql_query($query, $link);
        while ($myrow = mysql_fetch_assoc($result)) {
            $mass[] = $myrow;
        }
        return $mass;
    }
    
    public function getRole($id)
    {
        $link = Connect::getConnection();

        $query = 'SELECT * FROM `roles` WHERE `id`='.$id;
        mysql_query('SET NAMES utf8', $link);
        $result = mysql_query($query, $link); 
        $myrow = mysql_fetch_assoc($result);
        
        return $myrow;
    }
    
    public function delRole($id)
    {
        $link = Connect::getConnection();

        $query = 'DELETE FROM `roles` WHERE id='.$id;
        $result = mysql_query($query, $link); 

    }
    
    public function insertRole($Arr)
    {
        $link = Connect::getConnection();
        
        if ( $Arr[role_name] == '' ) {
            return "Вы не ввели имя, которое является обязательным для заполнения!";
        }
        
        $query = 'SELECT * FROM `roles` WHERE role_name="'.$Arr['role_name'].'"';
        $result = mysql_query($query, $link); 
        $myrow = mysql_num_rows($result);
        
        if ($myrow == 0) {
            $role_name = strip_tags( trim( $this->checkMass($Arr[role_name] ) ) );
            $orders =  $this->checkMass($Arr[orders]);
            $admin = $this->checkMass($Arr[admin]);
            $editRoles = $this->checkMass($Arr[edit_roles]);
            $userRoles = $this->checkMass($Arr[user_roles]);
            $reports = $this->checkMass($Arr[reports]);


            $query = "INSERT INTO `roles` (role_name, `orders`, `admin`, `edit_roles`, `user_roles`, `reports`)
                                   VALUES (\"$role_name\", $orders, $admin, $editRoles, $userRoles, $reports)";

            mysql_query($query, $link) or die(mysql_error()); 
        } else {
            return "Такая роль уже присутствует в базе! Введите другое имя.";
        }

    }
    
    public function saveRole($Arr)
    {
        $link = Connect::getConnection();
        
        if ( $Arr[role_name] == '' ) {
            return "Вы не ввели имя, которое является обязательным для заполнения!";
        }
        
        $query = 'SELECT * FROM `roles` WHERE id="'.$Arr['id_role'].'"';
        mysql_query('SET NAMES utf8', $link);
        $result = mysql_query($query, $link); 
        $myrow1 = mysql_fetch_assoc($result);
        
        $query = 'SELECT * FROM `roles` WHERE role_name="'.$Arr['role_name'].'"';
        $result = mysql_query($query, $link); 
        $myrow2 = mysql_fetch_assoc($result);
        
        if ( empty($myrow2) || ( $myrow1['role_name'] == $myrow2['role_name'] ) ) {
            $role_name = strip_tags( trim( $this->checkMass($Arr[role_name] ) ) );
            $orders = $this->checkMass($Arr[orders]);
            $admin = $this->checkMass($Arr[admin]);
            $editRoles = $this->checkMass($Arr[edit_roles]);
            $userRoles = $this->checkMass($Arr[user_roles]);
            $reports = $this->checkMass($Arr[reports]);


            $query = 'UPDATE `roles` SET role_name="'.$role_name.'", 
                                           orders='.$orders.',  
                                           admin='.$admin.',
                                           edit_roles='.$editRoles.',
                                           user_roles='.$userRoles.',
                                           reports='.$reports.'    
                                           WHERE id='.$Arr['id_role'];

            mysql_query($query, $link) or die(mysql_error()); 
        } else {
            return "Такая роль уже присутствует в базе! Введите другое имя.";
        }

    }
    
    public function checkMass($res)
    {
        if ( isset($res) ) {
            return $res;
        } else {
            return "0";
        }
    }
    
}

?>
