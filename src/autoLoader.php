<?php
spl_autoload_register(function ($className) {

    $fileName = __DIR__ . '/' . $className . '.php'; 
   
    $fileName = str_replace('\\', '/', $fileName); 

    if (is_readable($fileName)) {
        require $fileName;
    } else if (is_readable("../" . $className . '.php')) {
        require "../" . $className . '.php';
    }
	
});
?>
