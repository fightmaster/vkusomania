<?php
spl_autoload_register(function ($className) 
{
        $lastNsPos = strripos(__DIR__, '\\');
        $path = substr(__DIR__, 0, $lastNsPos);

        $fileName = $path . '\\' . $className . '.php';
        if (is_readable($fileName)) {
            require $fileName;
        } else if (is_readable("..\\" . $className . '.php')) {
            require "..\\" . $className . '.php';
        }
});
?>
