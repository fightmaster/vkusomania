<?php

namespace ACL;

use Mappers\Connect;

class ACL {

    private $permissions = array();

    public function getPermissions()
    {
        return $this->permissions;
    }

    public function setPermissions($array)
    {
        $this->permissions = $array;
    }

    public function getUserPermissions($login)
    {
        $link = Connect::getConnection();
        $query = "SELECT roles.* from user inner join roles  on user.role = roles.id where user.login = '$login'";
        $result = mysql_query($query, $link);
        $line = mysql_fetch_assoc($result);
        $this->permissions = array();

        foreach ($line as $key => $role) {
            if ($key == 'id' || $key == 'role_name') {
                continue;
            }
            $this->permissions[$key] = $role;
        }

        return $this->getPermissions();
    }

}

?>
