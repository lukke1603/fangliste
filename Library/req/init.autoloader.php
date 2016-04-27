<?php

spl_autoload_register(function($classname){
	if(substr($classname, 0, 4) !== 'MVC\\'){
		return;
	}

	$filename = PATH_ROOT . str_replace('\\', DIRECTORY_SEPARATOR, substr($classname, 4)) . '.php';

	if(file_exists($filename)){
		include $filename;
	}
});