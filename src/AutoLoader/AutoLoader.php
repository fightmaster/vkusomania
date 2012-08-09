<?php 
	
spl_autoload_register(function ($className) {
		$fileName = '../'.$className . '.php'; 
		if ( is_readable( $fileName ) ){
			require $fileName;
		}
});
	
?>
