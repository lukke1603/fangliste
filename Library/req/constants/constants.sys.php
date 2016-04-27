<?php

$basedir = implode('/', array_slice(explode('/', $_SERVER['SCRIPT_NAME']), 0, -1));
$basedir = substr($basedir, 1);
define('DIR_NAME_ROOT', $basedir);
define('PROJECT', "MVC");