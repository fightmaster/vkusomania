<?php

namespace Mappers;

class Connect {

    private static $link;

    /**
     * 
     * @return type
     */
    public static function getConnection()
    {
        if (empty(self::$link)) {
            $mysql_host = 'localhost';
            $mysql_user = 'root';
            $mysql_password = '123456';
            $my_database = 'vkusomania';
            self::$link = mysql_connect($mysql_host, $mysql_user, $mysql_password);
            mysql_select_db($my_database);
            mysql_query('SET NAMES utf8');
        }

        return self::$link;
    }

}
?>

