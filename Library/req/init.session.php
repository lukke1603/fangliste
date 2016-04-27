<?php

if(!isset($_SESSION)){
	session_start();
}


$_SESSION[PROJECT]['user'] = [
	'uid' => 1
];