<?php

namespace MVC\Model;

class User extends ModelDB{
	public $id;
	public $vorname;
	public $nachname;
	public $mail;
	public $created;

	
	public function getSource(){
		return 'users';
	}
}
