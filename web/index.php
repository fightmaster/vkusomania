<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
 <html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" type="text/css" href="../css/style.css">
<title>Заказ обедов</title>
<meta http-equiv="Content-Type" content="text/html;" />
</head>
<body>
<?php
error_reporting(E_ALL ^ E_NOTICE);
use Controllers\Controller;
require_once("..\src\AutoLoader\AutoLoader.php");

$control = new Controller();
$control->processData();

?>


