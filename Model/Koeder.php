<?php

namespace MVC\Model;


class Koeder extends ModelDB{
	
	public $id;
	public $name;
	public $typ;
	public $kommentar;
	
	public function getSource(){
		return "koeder";
	}
}
