<?php

namespace MVC\Controller;

use MVC\Model\User;

abstract class ControllerBase{
	protected $user;
	
	
	public function setView(View $view){
		$this->view = $view;
	}
	
	public function __construct(){
		$uid = $_SESSION[PROJECT]["user"]["uid"];
		$user = User::findFirst($uid);
		if(!$user instanceOf User){
			throw new NotFoundException();
		}
		
		$this->user = $user;
	}
}