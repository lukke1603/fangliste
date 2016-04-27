<?php

namespace MVC\Model;

class GewaesserTyp extends ModelDB{
	public $id;
	public $bezeichnung;
	
	public function getSource(){
		return "gewaessertypen";
	}
	
}
