<?php

namespace MVC\Model;

abstract class ModelBase extends ModelDB{
	private $user;
	
	public function __construct(){
		$uid = $_SESSION[PROJECT]["user"]["uid"];
		$user = User::findFirst($uid);
		if(!$user instanceOf User){
			throw new NotFoundException();
		}
		
		$this->user = $user;
	}
}