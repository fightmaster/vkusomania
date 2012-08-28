<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
use Mappers\UserMapper;
require_once("..\AutoLoader\AutoLoader.php");

$login = trim(strip_tags($_GET['login']));
$pass  = trim(strip_tags($_GET['pass']));
$FIO   = trim(strip_tags($_GET['fio']));
$email = trim(strip_tags($_GET['email']));

$user = new UserMapper;
$result = $user->Check($login,$pass,$FIO,$email);
if ($result==''){
	$user->InsertUser($login,$pass,$FIO,$email);
} else {


echo $result;
}

?>