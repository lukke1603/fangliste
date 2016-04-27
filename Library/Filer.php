<?php


namespace MVC\Library;

class Filer{
	
	public static function convertFileArray($array){
		$files = [];
		for($i=0 ; $i<count($array["name"]) ; $i++){
			$files[$i] = array(
				'name' => $array["name"][$i],
				'type' => $array["type"][$i],
				'tmp_name' => $array["tmp_name"][$i],
				'error' => $array["error"][$i],
				'size' => $array["size"][$i]
			);
		}
		
		return $files;
	}
	
}
